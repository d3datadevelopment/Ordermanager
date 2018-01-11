<?php

/**
 * This Software is the property of Data Development and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * http://www.shopmodule.com
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development - Daniel Seifert <support@shopmodule.com>
 * @link      http://www.oxidmodule.com
 */

namespace D3\Ordermanager\Modules\Application\Model;

use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Log\d3log;
use D3\ModCfg\Application\Model\Shopcompatibility\d3ShopCompatibilityAdapterHandler;
use D3\ModCfg\Application\Model\d3str;
use Doctrine\DBAL\DBALException;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\Shop;
use OxidEsales\Eshop\Application\Model\Remark;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\Payment;
use OxidEsales\Eshop\Application\Model\Content;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\DatabaseException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Module\Module;
use OxidEsales\Eshop\Core\UtilsView;
use OxidEsales\Eshop\Core\Registry;

class d3_oxemail_ordermanager extends d3_oxemail_ordermanager_parent
{
    protected $_sOrderManagerInfoTemplate = 'd3ordermanager_info_html.tpl';
    protected $_sOrderManagerInfoPlainTemplate = 'd3ordermanager_info_plain.tpl';
    private $_sModId = 'd3_ordermanager';
    /** @var  d3ordermanager */
    public $oOrderManager;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->_oConfig = Registry::getConfig();

        parent::__construct();
    }

    /**
     * @param array $aOrderManagerNotes
     * @return bool
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     */
    public function d3sendOrderManagerEmail($aOrderManagerNotes)
    {
        startProfile(__METHOD__);

        $oShop = $this->_getShop();
        $oSmarty = $this->_getSmarty();

        $this->_setMailParams($oShop);
        $this->setViewData("aNotes", $aOrderManagerNotes);
        $this->setViewData("shopTemplateDir", Registry::getConfig()->getTemplateDir(false));
        $this->setViewData("oShop", $oShop);
        $oSmarty->template_dir = Registry::getConfig()->getTemplateDir(false);

        $this->_processViewArray();

        $this->setBody($oSmarty->fetch($this->_sOrderManagerInfoTemplate));
        $this->setAltBody($oSmarty->fetch($this->_sOrderManagerInfoPlainTemplate));

        d3_cfg_mod::get($this->_sModId)->d3getLog()->log(
            d3log::NOTICE,
            __CLASS__,
            __FUNCTION__,
            __LINE__,
            'send job execution info mail',
            $this->getBody()
        );

        $sSubject = Registry::getLang()->translateString('D3_ORDERMANAGER_MAIL_ORDERSUBJECT', 0);
        $this->setSubject($sSubject);

        $sFullName = $oShop->__get('oxshops__oxname')->getRawValue();
        $this->setRecipient($oShop->getFieldData('oxinfoemail'), $sFullName);
        $this->setReplyTo($oShop->getFieldData('oxinfoemail'), $oShop->__get('oxshops__oxname')->getRawValue());

        $blSuccess = $this->send();

        stopProfile(__METHOD__);

        return $blSuccess;
    }

    /**
     * @param $sOxId
     * @return Order
     */
    public function d3getOrder($sOxId)
    {
        if (strstr($sOxId, '@@')) {
            $aOxId = explode('@@', $sOxId);
            $sOxId = $aOxId[0];
        }

        /** @var $oOrder Order */
        $oOrder = oxNew(Order::class);
        $oOrder->Load($sOxId);
        return $oOrder;
    }

    /**
     * @param $sOxId
     * @return d3ordermanager
     */
    public function d3getOrderManager($sOxId)
    {
        /** @var $oOrder d3ordermanager */
        $oOrder = oxNew(d3ordermanager::class);
        $oOrder->Load($sOxId);
        return $oOrder;
    }

    /**
     * @param d3ordermanager $oOrderManager
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws DatabaseException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function sendOrderManagerMail(d3ordermanager $oOrderManager)
    {
        $this->oOrderManager = $oOrderManager;
        $aContent = $this->getOrderManagerMailContent($oOrderManager);

        $oShop = $this->_getShop();
        $this->setBody($aContent['html']);
        $this->setAltBody($aContent['plain']);
        $this->setSubject($aContent['subject']);

        $this->_d3SetOrderManagerReplyAddress($oOrderManager, $oShop);

        $oRemark = $this->_d3SetOrderManagerMailRecipients($oShop);

        $this->_d3AddOrderManagerPdfAttachment($oOrderManager);

        $blSuccess = $this->send();

        if ($blSuccess && $oRemark) {
            $oRemark->save();
        }

        return $blSuccess;
    }

    /**
     * @param Shop         $oShop
     *
     * @return null|Remark
     */
    protected function _d3SetOrderManagerMailRecipients(Shop $oShop)
    {
        $oRemark = null;
        if ($this->_d3hasOrderManagerCustomerRecipient()) {
            $oRemark = $this->_d3sendOrderManagerMailToCustomer($oShop);
        } elseif ($this->_d3hasOrderManagerOwnerRecipient()) {
            $this->_d3sendOrderManagerMailToOwner($oShop);
        } elseif ($this->_d3hasOrderManagerCustomRecipient()) {
            $this->_d3sendOrderManagerMailToCustom();
        }

        return $oRemark;
    }

    /**
     * @param               $sVarName
     *
     * @return mixed
     */
    protected function _d3getOrderManagerMailOption($sVarName)
    {
        $aEditedValues = $this->oOrderManager->getEditedValues();
        return $aEditedValues[$sVarName] === false || $aEditedValues[$sVarName] === null ?
            $this->oOrderManager->getValue($sVarName) :
            $aEditedValues[$sVarName];
    }

    /**
     * @return mixed
     */
    protected function _d3hasOrderManagerCustomerRecipient()
    {
        return $this->_d3getOrderManagerMailOption('blSendMailToCustomer');
    }

    /**
     * @return mixed
     */
    protected function _d3hasOrderManagerOwnerRecipient()
    {
        return $this->_d3getOrderManagerMailOption('blSendMailToOwner');
    }

    /**
     * @return mixed
     */
    protected function _d3hasOrderManagerCustomRecipient()
    {
        return $this->_d3getOrderManagerMailOption('blSendMailToCustom');
    }

    /**
     * @return mixed
     */
    protected function _d3getOrderManagerCustomRecipientList()
    {
        return $this->_d3getOrderManagerMailOption('sSendMailToCustomAddress');
    }

    /**
     * @return d3_cfg_mod
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function d3GetSet()
    {
        return d3_cfg_mod::get($this->_sModId);
    }

    /**
     * @param d3ordermanager $oOrderManager
     * @return array
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function getOrderManagerMailContent(d3ordermanager $oOrderManager)
    {
        $this->oOrderManager = $oOrderManager;
        $aContent = array();

        $blTplFromAdmin = $oOrderManager->getValue('sSendMailFromTheme') == 'admin' ? true : false;
        Registry::getConfig()->setAdminMode($blTplFromAdmin);

        $oShop = $this->_getShop();
        $this->_setMailParams($oShop);

        $oSmarty = $this->_getSmarty();

        /** @var $oBasket Basket */
        $oBasket = $oOrderManager->getCurrentItem()->d3getOrderBasket4OrderManager($oOrderManager);

        /** @var $oPayment Payment */
        $oPayment = oxNew(Payment::class);
        $oPayment->load($oBasket->getPaymentId());

        $oOrderManager->getCurrentItem()->d3setBasket4OrderManager($oBasket);
        $oOrderManager->getCurrentItem()->d3setPayment4OrderManager($oPayment);

        $this->setViewData("oShop", $oShop);
        $this->setViewData("oViewConf", $this->getViewConfig());
        $this->setViewData("oOrder", $oOrderManager->getCurrentItem());
        $this->setViewData("oUser", $oOrderManager->getCurrentItem()->getOrderUser());
        $this->setViewData("shopTemplateDir", Registry::getConfig()->getTemplateDir(false));
        $this->setViewData("charset", Registry::getLang()->translateString("charset"));

        $this->setViewData("shop", $oShop);
        $this->setViewData("order", $oOrderManager->getCurrentItem());
        $this->setViewData("user", $oOrderManager->getCurrentItem()->getOrderUser());
        $this->setViewData("payment", $oPayment);
        $this->setViewData("oDelSet", $oOrderManager->getCurrentItem()->getDelSet());
        $this->setViewData("currency", $oOrderManager->getCurrentItem()->getOrderCurrency());
        $this->setViewData("basket", $oBasket);

        $oSmarty->template_dir = $this->getTemplateDir4OrderManager($oOrderManager);
        $this->_processViewArray();

        if (false == $this->d3GetSet()->getLicenseConfigData('blUseMailSendOnly', 0)) {
            $oSmarty = $this->d3SendMailHook($oSmarty);
        }

        $aContent = $this->_d3GenerateOrderManagerMailContent($aContent, $oSmarty);

        Registry::getConfig()->setAdminMode(true);

        return $aContent;
    }

    /**
     * @param d3ordermanager $oOrderManager
     * @return string
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     */
    public function getTemplateDir4OrderManager($oOrderManager)
    {
        if ($oOrderManager->getValue('sSendMailFromTheme') == 'module') {
            /** @var Module $oModule */
            $oModule = oxNew(Module::class);
            /** @var d3str $oD3Str */
            $oD3Str = oxNew(d3str::class);
            $sModuleId = $oOrderManager->getValue('sSendMailFromModulePath');

            /** @var d3ShopCompatibilityAdapterHandler $oD3CompatibilityAdapterHandler */
            $oD3CompatibilityAdapterHandler = oxNew(d3ShopCompatibilityAdapterHandler::class);
            $sModulePath = $oD3CompatibilityAdapterHandler->call(
                'oxmodule__getModuleFullPath',
                array($oModule, $sModuleId)
            );

            $sPath = $oD3Str->untrailingslashit($sModulePath);
        } else {
            $blAdmin = $oOrderManager->getValue('sSendMailFromTheme') == 'admin' ? true : false;
            $sPath   = Registry::getConfig()->getTemplateDir($blAdmin);
        }
        return $sPath;
    }

    /**
     * @param \Smarty $oSmarty
     * @return \Smarty
     */
    public function d3SendMailHook(\Smarty $oSmarty)
    {
        // available objects:
        // oxEmail:                $this
        // Smarty:                 $oSmarty
        // Ordermanager profile:   $this->oOrderManager
        // Order:                inside smarty
        // oxuser:                 inside smarty

        return $oSmarty;
    }

    /**
     * @param               $aContent
     * @param \Smarty        $oSmarty
     *
     * @return mixed
     */
    protected function _d3GenerateOrderManagerMailContent($aContent, \Smarty $oSmarty)
    {
        $aEditedValues = $this->oOrderManager->getEditedValues();

        if ($this->d3HasOrderManagerEditorMailContent($aEditedValues)) {
            $aContent = $aEditedValues['mail'];
        } elseif ($this->oOrderManager->getValue('sSendMailFromSource') == 'cms') {
            $iOrderLangId = $this->oOrderManager->getCurrentItem()->getFieldData('oxlang');
            $oLang        = Registry::getLang();
            $iCurrentLang = $oLang->getTplLanguage();
            $oLang->setTplLanguage($iOrderLangId);

            /** @var UtilsView $oUtilsView */
            $oUtilsView = Registry::get(UtilsView::class);
            /** @var $oContent Content */
            $oContent = oxNew(Content::class);
            $oContent->setLanguage($iOrderLangId);
            $oContent->load($this->oOrderManager->getValue('sSendMailFromContentname'));

            $aContent['html']    = $oUtilsView->parseThroughSmarty(
                $oContent->getFieldData('oxcontent'),
                $oContent->getId() . 'oxcontent'
            );

            $aContent['subject'] = $oContent->getFieldData('oxtitle');
            $oContent->load($this->oOrderManager->getValue('sSendMailFromContentnamePlain'));
            $aContent['plain'] = $oUtilsView->parseThroughSmarty(
                $oContent->getFieldData('oxcontent'),
                $oContent->getId() . 'oxcontent'
            );
            $oLang->setTplLanguage($iCurrentLang);
        } elseif ($this->oOrderManager->getValue('sSendMailFromSource') == 'template') {
            $aContent['html']    = $oSmarty->fetch($this->oOrderManager->getValue('sSendMailFromTemplatename'));
            $aContent['plain']   = $oSmarty->fetch($this->oOrderManager->getValue('sSendMailFromTemplatenamePlain'));
            $aContent['subject'] = $oSmarty->fetch($this->oOrderManager->getValue('sSendMailFromSubject'));
        }

        return $aContent;
    }

    /**
     * @param $aEditedValues
     *
     * @return bool
     */
    public function d3HasOrderManagerEditorMailContent($aEditedValues)
    {
        return $this->isArrayEditorMailContent($aEditedValues) &&
               $aEditedValues['mail']['subject'] &&
               $aEditedValues['mail']['html'] &&
               $aEditedValues['mail']['plain'];
    }

    /**
     * @param $aEditedValues
     *
     * @return bool
     */
    public function isArrayEditorMailContent($aEditedValues)
    {
        return is_array($aEditedValues) && is_array($aEditedValues['mail']);
    }

    /**
     * @param Shop        $oShop
     *
     * @return Remark
     */
    protected function _d3sendOrderManagerMailToCustomer(Shop $oShop)
    {
        $oOrderUser = $this->oOrderManager->getCurrentItem()->getOrderUser();

        if ($oOrderUser->getId()) {
            $sFullName = $oOrderUser->__get('oxuser__oxfname')->getRawValue() . " " .
                $oOrderUser->__get('oxuser__oxlname')->getRawValue();
            $this->setRecipient($oOrderUser->getFieldData('oxusername'), $sFullName);
        } else {
            $sFullName = $this->oOrderManager->getCurrentItem()->__get('oxorder__oxbillfname')->getRawValue() . " " .
                $this->oOrderManager->getCurrentItem()->__get('oxorder__oxbilllname')->getRawValue();
            $this->setRecipient($this->oOrderManager->getCurrentItem()->getFieldData('oxbillemail'), $sFullName);
        }

        if ($this->_d3hasOrderManagerOwnerRecipient()) {
            $this->AddBcc($oShop->getFieldData('oxinfoemail'), $oShop->__get('oxshops__oxname')->getRawValue());
        }

        if ($this->_d3HasOrderManagerCustomMailAddresses()) {
            foreach ($this->_d3getOrderManagerCustomMailAddressList() as $sMailAdr) {
                $this->AddBcc(trim($sMailAdr), trim($sMailAdr));
            }
        }

        // add user history
        /** @var Remark $oRemark */
        $oRemark                       = oxNew(Remark::class);
        $aRemarkContent = array(
            'oxtext'        => $this->getAltBody(),
            'oxparentid'    => $this->oOrderManager->getCurrentItem()->getId(),
            'oxtype'        => 'o',
        );
        $oRemark->assign($aRemarkContent);
        return $oRemark;
    }

    /**
     * @param Shop        $oShop
     */
    protected function _d3sendOrderManagerMailToOwner(Shop $oShop)
    {
        $sFullName = $oShop->__get('oxshops__oxname')->getRawValue();
        $this->setRecipient($oShop->getFieldData('oxinfoemail'), $sFullName);

        if ($this->_d3HasOrderManagerCustomMailAddresses()) {
            foreach ($this->_d3getOrderManagerCustomMailAddressList() as $sMailAdr) {
                $this->AddBcc(trim($sMailAdr), trim($sMailAdr));
            }
        }
    }

    protected function _d3sendOrderManagerMailToCustom()
    {
        if ($this->_d3hasOrderManagerCustomMailAddresses()) {
            foreach ($this->_d3getOrderManagerCustomMailAddressList() as $sMailAdr) {
                $this->setRecipient(trim($sMailAdr), trim($sMailAdr));
            }
        }
    }

    /**
     * @return array
     */
    protected function _d3getOrderManagerCustomMailAddressList()
    {
        $aMailAddressList = array();

        foreach (explode(';', $this->_d3getOrderManagerCustomRecipientList()) as $sAddress) {
            if (strlen(trim($sAddress))) {
                $aMailAddressList[] = $sAddress;
            }
        }

        return $aMailAddressList;
    }

    /**
     * @return bool
     */
    public function _d3HasOrderManagerCustomMailAddresses()
    {
        return $this->_d3hasOrderManagerCustomRecipient() && $this->_d3getOrderManagerCustomRecipientList();
    }

    /**
     * @param d3ordermanager $oOrderManager
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    protected function _d3AddOrderManagerPdfAttachment(d3ordermanager $oOrderManager)
    {
        /** @var d3ordermanager_pdfhandler $oPDFHandler */
        $oPDFHandler = oxNew(d3ordermanager_pdfhandler::class, $oOrderManager, $oOrderManager->getCurrentItem());

        if ($oOrderManager->getValue('blActionOrderGeneratePdf_status')
            && $oOrderManager->getValue('blActionOrderPdfSendAttach')
            && $oPDFHandler->canGeneratePdf()
        ) {
            if ($oOrderManager->getValue('blActionOrderPdfTypeInvoice')) {
                $oPDFHandler->createPdf('invoice', 'attach');
                $sFileName = $oPDFHandler->getPdfFileName('invoice');
                $sFilePath = $oPDFHandler->getPdfSaveDir('attach') . $sFileName;
                $this->addAttachment($sFilePath, $sFileName, 'base64', 'application/pdf');
            }

            if ($oOrderManager->getValue('blActionOrderPdfTypeDelnote')) {
                $oPDFHandler->createPdf('dnote', 'attach');
                $sFileName = $oPDFHandler->getPdfFileName('dnote');
                $sFilePath = $oPDFHandler->getPdfSaveDir('attach') . $sFileName;
                $this->addAttachment($sFilePath, $sFileName, 'base64', 'application/pdf');
            }
        }
    }

    /**
     * @param d3ordermanager $oOrderManager
     * @param Shop $oShop
     */
    protected function _d3SetOrderManagerReplyAddress(d3ordermanager $oOrderManager, Shop $oShop)
    {
        if (strlen(trim($oOrderManager->getValue('sSendMailReplyAddress')))) {
            $this->setFrom(trim($oOrderManager->getValue('sSendMailReplyAddress')));
            $this->setReplyTo(
                trim($oOrderManager->getValue('sSendMailReplyAddress')),
                $oShop->__get('oxshops__oxname')->getRawValue()
            );
        } else {
            $this->setReplyTo($oShop->getFieldData('oxinfoemail'), $oShop->__get('oxshops__oxname')->getRawValue());
        }
    }
}
