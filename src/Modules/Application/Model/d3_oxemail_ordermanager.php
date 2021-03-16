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
use D3\ModCfg\Application\Model\Exception\d3ParameterNotFoundException;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Model\Log\d3LogInterface;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_action_generatepdf;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_action_getpdfdocuments;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_conf;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Shopcompatibility\d3ShopCompatibilityAdapterHandler;
use D3\ModCfg\Application\Model\d3str;
use D3\Ordermanager\Application\Model\d3ordermanager_renderererrorhandler;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_smartyException;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_templaterendererExceptionInterface;
use D3\PdfDocuments\Application\Model\Interfaces\pdfdocumentsOrderInterface;
use Doctrine\DBAL\DBALException;
use Exception;
use Html2Text\Html2Text;
use League\Flysystem\FileExistsException;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\Shop;
use OxidEsales\Eshop\Application\Model\Remark;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\Payment;
use OxidEsales\Eshop\Application\Model\Content;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\ArticleException;
use OxidEsales\Eshop\Core\Exception\ArticleInputException;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\DatabaseException;
use OxidEsales\Eshop\Core\Exception\NoArticleException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Module\Module;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\UtilsView;
use OxidEsales\EshopCommunity\Internal\Application\ContainerFactory;
use Psr\Container\ContainerInterface;
use Smarty;

class d3_oxemail_ordermanager extends d3_oxemail_ordermanager_parent
{
    private $_sModId = 'd3_ordermanager';
    protected $_sOrderManagerInfoTemplate = 'd3ordermanager_info_html.tpl';
    protected $_sOrderManagerInfoPlainTemplate = 'd3ordermanager_info_plain.tpl';
    /** @var  d3ordermanager */
    public $oOrderManager;

    /**
     * d3_oxemail_ordermanager constructor.
     * @throws Exception
     */
    public function __construct()
    {
        d3GetModCfgDIC()->setParameter('d3.ordermanager.modcfgid', $this->_sModId);

        /** @var Config _oConfig */
        $this->_oConfig = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);

        parent::__construct();
    }

    /**
     * @param array $aOrderManagerNotes
     *
     * @return bool
     * @throws Exception
     */
    public function d3sendOrderManagerEmail($aOrderManagerNotes)
    {
        startProfile(__METHOD__);

        $oShop = $this->_getShop();
        /** @var Smarty $oSmarty */
        $oSmarty = $this->_getSmarty();

        /** @var Config $config */
        $config = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);

        $this->_setMailParams($oShop);
        $this->setViewData("aNotes", $aOrderManagerNotes);
        $this->setViewData("shopTemplateDir", $config->getTemplateDir(false));
        $this->setViewData("oShop", $oShop);
        $oSmarty->template_dir = $config->getTemplateDir(false);

        $this->_processViewArray();

        set_error_handler(
            [d3GetModCfgDIC()->get(d3ordermanager_renderererrorhandler::class), 'd3HandleTemplateEngineErrors']
        );

        $this->d3OMsetBody($oSmarty->fetch($this->_sOrderManagerInfoTemplate));
        $this->d3OMsetAltBody($oSmarty->fetch($this->_sOrderManagerInfoPlainTemplate));

        restore_error_handler();

        /** @var d3LogInterface $oLog */
        $oLog = d3GetModCfgDIC()->get('d3.ordermanager.log');
        $oLog->notice(
            __CLASS__,
            __FUNCTION__,
            __LINE__,
            'send job execution info mail',
            $this->getBody()
        );

        /** @var Language $oLang */
        $oLang = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);
        $sSubject = $oLang->translateString('D3_ORDERMANAGER_MAIL_ORDERSUBJECT', 0);
        $this->d3OMsetSubject($sSubject);

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
     * @throws Exception
     */
    public function d3getOrder($sOxId)
    {
        if (strstr($sOxId, '@@')) {
            $aOxId = explode('@@', $sOxId);
            $sOxId = $aOxId[0];
        }

        /** @var $oOrder Order */
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);

        $oOrder->load($sOxId);
        return $oOrder;
    }

    /**
     * @param $sOxId
     * @return d3ordermanager
     * @throws Exception
     */
    public function d3getOrderManager($sOxId)
    {
        /** @var $oOrder d3ordermanager */
        $oOrderManager = d3GetModCfgDIC()->get(d3ordermanager::class);
        $oOrderManager->load($sOxId);
        return $oOrderManager;
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
     * @throws Exception
     */
    public function sendOrderManagerMail(d3ordermanager $oOrderManager)
    {
        $this->oOrderManager = $oOrderManager;
        $aContent = $this->getOrderManagerMailContent($oOrderManager);

        $oShop = $this->_getShop();
        $this->d3OMsetBody($aContent['html']);
        $this->d3OMsetAltBody($aContent['plain']);
        $this->d3OMsetSubject($aContent['subject']);

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
     * @param $content
     *
     * @throws d3ordermanager_smartyException
     */
    protected function d3OMsetBody($content)
    {
        $this->setBody($content);

        if ((bool) strlen($content) && false === (bool) strlen($this->getBody())) {
            $this->throwUnequalContentException();
        }
    }

    /**
     * @param $content
     *
     * @throws d3ordermanager_smartyException
     */
    protected function d3OMsetAltBody($content)
    {
        $this->setAltBody($content);

        if ((bool) strlen($content) && false === (bool) strlen($this->getAltBody())) {
            $this->throwUnequalContentException();
        }
    }

    /**
     * @param $content
     *
     * @throws d3ordermanager_smartyException
     */
    protected function d3OMsetSubject($content)
    {
        $this->setSubject($content);

        if ((bool) strlen($content) && false === (bool) strlen($this->getSubject())) {
            $this->throwUnequalContentException();
        }
    }

    /**
     * @param Shop $oShop
     *
     * @return null|Remark
     * @throws d3ParameterNotFoundException
     */
    protected function _d3SetOrderManagerMailRecipients(Shop $oShop)
    {
        $oRemark = null;
        if ($this->_d3hasOrderManagerCustomerRecipient()) {
            $oRemark = $this->_d3sendOrderManagerMailToCustomer($oShop);
        } elseif ($this->_d3hasOrderManagerOwnerRecipient()) {
            $oRemark = $this->_d3sendOrderManagerMailToOwner($oShop);
        } elseif ($this->_d3hasOrderManagerCustomRecipient()) {
            $oRemark = $this->_d3sendOrderManagerMailToCustom();
        }

        return $oRemark;
    }

    /**
     * @param               $sVarName
     *
     * @return mixed
     * @throws d3ParameterNotFoundException
     */
    protected function _d3getOrderManagerMailOption($sVarName)
    {
        $aEditedValues = $this->oOrderManager->getEditedValues();
        return false === isset($aEditedValues[$sVarName]) || $aEditedValues[$sVarName] === false || $aEditedValues[$sVarName] === null ?
            $this->oOrderManager->getValue($sVarName) :
            $aEditedValues[$sVarName];
    }

    /**
     * @return mixed
     * @throws d3ParameterNotFoundException
     */
    protected function _d3hasOrderManagerCustomerRecipient()
    {
        return $this->_d3getOrderManagerMailOption('blSendMailToCustomer');
    }

    /**
     * @return mixed
     * @throws d3ParameterNotFoundException
     */
    protected function _d3hasOrderManagerOwnerRecipient()
    {
        return $this->_d3getOrderManagerMailOption('blSendMailToOwner');
    }

    /**
     * @return mixed
     * @throws d3ParameterNotFoundException
     */
    protected function _d3hasOrderManagerCustomRecipient()
    {
        return $this->_d3getOrderManagerMailOption('blSendMailToCustom');
    }

    /**
     * @return mixed
     * @throws d3ParameterNotFoundException
     */
    protected function _d3getOrderManagerCustomRecipientList()
    {
        return $this->_d3getOrderManagerMailOption('sSendMailToCustomAddress');
    }

    /**
     * @return d3_cfg_mod
     * @throws Exception
     */
    public function d3GetSet()
    {
        return d3GetModCfgDIC()->get('d3.ordermanager.modcfg');
    }

    /**
     * @return Payment
     * @throws Exception
     */
    public function d3GetPayment()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.Payment::class);
    }

    /**
     * @return Language
     * @throws Exception
     */
    public function d3GetLang()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);
    }

    /**
     * required for unit tests, can't mock getConfig method
     * @return Config
     * @throws Exception
     */
    public function d3GetConfig()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);
    }

    /**
     * @param d3ordermanager $oOrderManager
     *
     * @return array
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws ArticleException
     * @throws ArticleInputException
     * @throws NoArticleException
     * @throws d3ParameterNotFoundException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     * @throws d3ordermanager_templaterendererExceptionInterface
     */
    public function getOrderManagerMailContent(d3ordermanager $oOrderManager)
    {
        $this->oOrderManager = $oOrderManager;
        $aContent = array();

        $blTplFromAdmin = $oOrderManager->getValue('sSendMailFromTheme') == 'admin';

        $oConfig = $this->d3GetConfig();
        $oConfig->setAdminMode($blTplFromAdmin);

        $oShop = $this->_getShop();
        $this->_setMailParams($oShop);

        /** @var Smarty $oSmarty */
        $oSmarty = $this->_getSmarty();

        /** @var $oBasket Basket */
        $oBasket = $oOrderManager->getCurrentItem()->d3getOrderBasket4OrderManager($oOrderManager);

        $oPayment = $this->d3GetPayment();
        $oPayment->loadInLang($this->oOrderManager->getCurrentItem()->getFieldData('oxlang'), $oBasket->getPaymentId());

        $oOrderManager->getCurrentItem()->d3setBasket4OrderManager($oBasket);
        $oOrderManager->getCurrentItem()->d3setPayment4OrderManager($oPayment);

        $this->setViewData("oShop", $oShop);
        $this->setViewData("oViewConf", $this->getViewConfig());
        $this->setViewData("oOrder", $oOrderManager->getCurrentItem());
        $this->setViewData("oUser", $oOrderManager->getCurrentItem()->getOrderUser());
        $this->setViewData("shopTemplateDir", $this->d3GetConfig()->getTemplateDir(false));
        $this->setViewData("charset", $this->d3GetLang()->translateString("charset"));

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
        $oConfig->setAdminMode(true);

        return $aContent;
    }

    /**
     * @return Module
     * @throws Exception
     */
    public function d3GetModule()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.Module::class);
    }

    /**
     * @return d3str
     * @throws Exception
     */
    public function getD3Str()
    {
        return d3GetModCfgDIC()->get(d3str::class);
    }

    /**
     * @return d3ShopCompatibilityAdapterHandler
     * @throws Exception
     */
    public function d3GetShopCompatibilityAdapterHandler()
    {
        return d3GetModCfgDIC()->get(d3ShopCompatibilityAdapterHandler::class);
    }

    /**
     * @param d3ordermanager $oOrderManager
     *
     * @return string
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws Exception
     */
    public function getTemplateDir4OrderManager($oOrderManager)
    {
        if ($oOrderManager->getValue('sSendMailFromTheme') == 'module') {
            $sModuleId = $oOrderManager->getValue('sSendMailFromModulePath');
            $sModulePath = $this->d3GetShopCompatibilityAdapterHandler()->call(
                'oxmodule__getModuleFullPath',
                array($this->d3GetModule(), $sModuleId)
            );

            $sPath = $this->getD3Str()->untrailingslashit($sModulePath);
        } else {
            $blAdmin = $oOrderManager->getValue('sSendMailFromTheme') == 'admin';
            $sPath   = $this->d3GetConfig()->getTemplateDir($blAdmin);
        }
        return $sPath;
    }

    /**
     * @param Smarty $oSmarty
     * @return Smarty
     */
    public function d3SendMailHook( Smarty $oSmarty)
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
     * @codeCoverageIgnore because visual CMS extension issue
     * @return UtilsView
     * @throws Exception
     */
    public function d3GetUtilsView()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.UtilsView::class);
    }

    /**
     * @return Content
     * @throws Exception
     */
    public function d3GetContent()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.Content::class);
    }

    /**
     * @param               $aContent
     * @param Smarty $oSmarty
     *
     * @return mixed
     * @throws d3ParameterNotFoundException
     * @throws Exception
     * @throws d3ordermanager_templaterendererExceptionInterface
     */
    protected function _d3GenerateOrderManagerMailContent($aContent, Smarty $oSmarty)
    {
        $aEditedValues = $this->oOrderManager->getEditedValues();

        $iOrderLangId = $this->oOrderManager->getCurrentItem()->getFieldData('oxlang');
        $oLang        = $this->d3GetLang();
        $iCurrentTplLang = $oLang->getTplLanguage();
        $iCurrentBaseLang = $oLang->getBaseLanguage();
        $oLang->setTplLanguage($iOrderLangId);
        $oLang->setBaseLanguage($iOrderLangId);

        $iCurrentCurrency = Registry::getConfig()->getShopCurrency();
        $iOrderCurr = $this->oOrderManager->getCurrentItem()->getOrderCurrency()->id;
        Registry::getConfig()->setActShopCurrency($iOrderCurr);

        set_error_handler(
            [d3GetModCfgDIC()->get(d3ordermanager_renderererrorhandler::class), 'd3HandleTemplateEngineErrors']
        );

        if ($this->d3HasOrderManagerEditorMailContent($aEditedValues)) {
            $aContent = $aEditedValues['mail'];

            if ($aContent['genplain']) {
                $aContent['plain'] = $this->d3generatePlainContent($aContent['html']);
            }
        } elseif ($this->oOrderManager->getValue('sSendMailFromSource') == 'cms') {
            $oUtilsView = $this->d3GetUtilsView();
            $oContent = $this->d3GetContent();
            $oContent->loadInLang($iOrderLangId, $this->oOrderManager->getValue('sSendMailFromContentname'));

            $aContent['html']    = $oUtilsView->parseThroughSmarty(
                $oContent->getFieldData('oxcontent'),
                $oContent->getId() . 'oxcontent'
            );

            $aContent['subject'] = $oContent->getFieldData('oxtitle');
            $oContent->loadInLang($iOrderLangId, $this->oOrderManager->getValue('sSendMailFromContentnamePlain'));
            $aContent['plain'] = $oUtilsView->parseThroughSmarty(
                $oContent->getFieldData('oxcontent'),
                $oContent->getId() . 'oxcontent'
            );
        } elseif ($this->oOrderManager->getValue('sSendMailFromSource') == 'template') {
            $aContent['html']    = $oSmarty->fetch($this->oOrderManager->getValue('sSendMailFromTemplatename'));
            $aContent['plain']   = $oSmarty->fetch($this->oOrderManager->getValue('sSendMailFromTemplatenamePlain'));
            $aContent['subject'] = $oSmarty->fetch($this->oOrderManager->getValue('sSendMailFromSubject'));
        }

        restore_error_handler();

        $oLang->setTplLanguage($iCurrentTplLang);
        $oLang->setBaseLanguage($iCurrentBaseLang);
        Registry::getConfig()->setActShopCurrency($iCurrentCurrency);

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
                (
                    $aEditedValues['mail']['genplain'] ||
                    $aEditedValues['mail']['plain']
                );
    }

    /**
     * @param $aEditedValues
     *
     * @return bool
     */
    public function isArrayEditorMailContent($aEditedValues)
    {
        return is_array($aEditedValues) && isset($aEditedValues['mail']) && is_array($aEditedValues['mail']);
    }

    /**
     * @param $html
     * @return string
     */
    public function d3generatePlainContent($html)
    {
        d3GetModCfgDIC()->setParameter(Html2Text::class.'.args.html', $html);

        /** @var Html2Text $html */
        $html = d3GetModCfgDIC()->get(Html2Text::class);
        return $html->getText();
    }

    /**
     * @return Remark
     * @throws Exception
     */
    public function d3GetRemark()
    {
        /** @var Remark $remark */
        $remark = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Remark::class);

        return $remark;
    }

    /**
     * @param Shop $oShop
     *
     * @return Remark
     * @throws d3ParameterNotFoundException
     * @throws Exception
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
            $this->addBCC($oShop->getFieldData('oxinfoemail'), $oShop->__get('oxshops__oxname')->getRawValue());
        }

        if ($this->_d3HasOrderManagerCustomMailAddresses()) {
            foreach ($this->_d3getOrderManagerCustomMailAddressList() as $sMailAdr) {
                $this->addBCC(trim($sMailAdr), trim($sMailAdr));
            }
        }

        return $this->d3generateRemark();
    }

    /**
     * @param Shop $oShop
     *
     * @return Remark
     * @throws d3ParameterNotFoundException
     * @throws Exception
     */
    protected function _d3sendOrderManagerMailToOwner(Shop $oShop)
    {
        $sFullName = $oShop->__get('oxshops__oxname')->getRawValue();
        $this->setRecipient($oShop->getFieldData('oxinfoemail'), $sFullName);

        if ($this->_d3HasOrderManagerCustomMailAddresses()) {
            foreach ($this->_d3getOrderManagerCustomMailAddressList() as $sMailAdr) {
                $this->addBCC(trim($sMailAdr), trim($sMailAdr));
            }
        }

        return $this->d3generateRemark();
    }

    /**
     * @throws d3ParameterNotFoundException
     */
    protected function _d3sendOrderManagerMailToCustom()
    {
        if ($this->_d3HasOrderManagerCustomMailAddresses()) {
            foreach ($this->_d3getOrderManagerCustomMailAddressList() as $sMailAdr) {
                $this->setRecipient(trim($sMailAdr), trim($sMailAdr));
            }
        }

        return $this->d3generateRemark();
    }

    /**
     * @return array
     * @throws d3ParameterNotFoundException
     */
    protected function _d3getOrderManagerCustomMailAddressList()
    {
        $aMailAddressList = array();

        foreach (explode(';', $this->_d3getOrderManagerCustomRecipientList()) as $sAddress) {
            if (strlen(trim($sAddress))) {
                $aMailAddressList[] = trim($sAddress);
            }
        }

        return $aMailAddressList;
    }

    /**
     * @return bool
     * @throws d3ParameterNotFoundException
     */
    public function _d3HasOrderManagerCustomMailAddresses()
    {
        return $this->_d3hasOrderManagerCustomRecipient() && $this->_d3getOrderManagerCustomRecipientList();
    }

    /**
     * @param d3ordermanager $oOrderManager
     * @return d3ordermanager_pdfhandler
     * @throws Exception
     */
    public function d3GetPdfHandler(d3ordermanager $oOrderManager)
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_pdfhandler::class.'.args.ordermanager',
            $oOrderManager
        );
        d3GetModCfgDIC()->set(
            d3ordermanager_pdfhandler::class.'.args.order',
            $oOrderManager->getCurrentItem()
        );

        return d3GetModCfgDIC()->get(d3ordermanager_pdfhandler::class);
    }

    /**
     * @param d3ordermanager $oOrderManager
     *
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     */
    protected function _d3AddOrderManagerPdfAttachment(d3ordermanager $oOrderManager)
    {
        $oPDFHandler = $this->d3GetPdfHandler($oOrderManager);

        $this->addOXIDPdfAttachment($oOrderManager, $oPDFHandler);
        $this->addPdfDocumentsAttachment($oOrderManager, $oPDFHandler);
    }

    /**
     * @param d3ordermanager            $oOrderManager
     * @param d3ordermanager_pdfhandler $oPDFHandler
     *
     * @throws FileExistsException
     */
    public function addOXIDPdfAttachment(d3ordermanager $oOrderManager, d3ordermanager_pdfhandler $oPDFHandler)
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_action_generatepdf::class.'.args.ordermanager',
            d3GetModCfgDIC()->get(d3ordermanager::class)
        );
        d3GetModCfgDIC()->set(
            d3ordermanager_action_generatepdf::class.'.args.order',
            d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)
        );

        /** @var d3ordermanager_action_generatepdf $action */
        $action = d3GetModCfgDIC()->get(d3ordermanager_action_generatepdf::class);

        if ($oOrderManager->getValue($action->getActiveSwitchParameter())
            && $oOrderManager->getValue('blActionOrderPdfSendAttach')
            && $oPDFHandler->canGenerateOxidPdf()
        ) {
            if ($oOrderManager->getValue('blActionOrderPdfTypeInvoice')) {
                $oPDFHandler->createOxidPdf(d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_INVOICE, d3ordermanager_conf::D3_ORDERMANAGER_PDFSENDTYPE_ATTACH);
                $sFileName = $oPDFHandler->getOxidPdfFileName(d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_INVOICE);
                $sFilePath = $oPDFHandler->getOxidPdfSaveDir(d3ordermanager_conf::D3_ORDERMANAGER_PDFSENDTYPE_ATTACH) . $sFileName;
                $this->addAttachment($sFilePath, $sFileName, 'base64', 'application/pdf');
            }

            if ($oOrderManager->getValue('blActionOrderPdfTypeDelnote')) {
                $oPDFHandler->createOxidPdf(d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_DELIVERYNOTE, d3ordermanager_conf::D3_ORDERMANAGER_PDFSENDTYPE_ATTACH);
                $sFileName = $oPDFHandler->getOxidPdfFileName(d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_DELIVERYNOTE);
                $sFilePath = $oPDFHandler->getOxidPdfSaveDir(d3ordermanager_conf::D3_ORDERMANAGER_PDFSENDTYPE_ATTACH) . $sFileName;
                $this->addAttachment($sFilePath, $sFileName, 'base64', 'application/pdf');
            }
        }
    }

    /**
     * @param d3ordermanager            $oOrderManager
     * @param d3ordermanager_pdfhandler $oPDFHandler
     *
     * @throws FileExistsException
     */
    public function addPdfDocumentsAttachment(d3ordermanager $oOrderManager, d3ordermanager_pdfhandler $oPDFHandler)
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_action_getpdfdocuments::class.'.args.ordermanager',
            $oOrderManager
        );

        d3GetModCfgDIC()->set(
            d3ordermanager_action_getpdfdocuments::class.'.args.order',
            $oOrderManager->getCurrentItem()
        );

        /** @var d3ordermanager_action_getpdfdocuments $action */
        $action = d3GetModCfgDIC()->get(d3ordermanager_action_getpdfdocuments::class);

        if ($oOrderManager->getValue($action->getActiveSwitchParameter())
            && $oOrderManager->getValue('blActionOrderPdfDocumentSendAttach')
            && $oPDFHandler->canGeneratePdfDocuments()
        ) {
            /** @var pdfdocumentsOrderInterface $document */
            foreach ($action->getDocumentList() as $document) {
                if ($oOrderManager->getValue($action->getDocumentRequestId($document))) {
                    $document->setOrder($action->getOrder());
                    $oPDFHandler->createPdfDocument($document, d3ordermanager_conf::D3_ORDERMANAGER_PDFSENDTYPE_ATTACH);
                    $sFilePath = $oPDFHandler->getOxidPdfSaveDir(d3ordermanager_conf::D3_ORDERMANAGER_PDFSENDTYPE_ATTACH).$document->getFilename();
                    $this->addAttachment($sFilePath, $document->getFilename(), 'base64', 'application/pdf');
                }
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

    /**
     * add user history
     * @return Remark
     * @throws d3ParameterNotFoundException
     * @throws Exception
     */
    public function d3generateRemark() {
        $oRemark        = $this->d3GetRemark();
        $aRemarkContent = array(
            'oxtext'     => $this->d3getRemarkText(),
            'oxparentid' => $this->oOrderManager->getCurrentItem()->getOrderUser()->getId() ? :
                $this->oOrderManager->getCurrentItem()->getId(),
            'oxtype'     => 'd3om',
        );
        $oRemark->assign( $aRemarkContent );

        return $oRemark;
    }

    /**
     * @return string
     */
    public function d3getRemarkText()
    {
        return implode(
            PHP_EOL.'---'.PHP_EOL,
           [
               'Recipients:',
               implode(', ', array_keys($this->getAllRecipientAddresses())),
               'HTML:',
               $this->getBody(),
               'Plain',
               $this->getAltBody()
           ]
        );
    }

    /**
     * @return ContainerInterface
     */
    public function d3getOrderManagerDIContainer()
    {
        return ContainerFactory::getInstance()->getContainer();
    }

    /**
     * @throws d3ordermanager_smartyException
     */
    protected function throwUnequalContentException()
    {
        d3GetModCfgDIC()->setParameter(
            d3ordermanager_smartyException::class . '.args.message',
            'empty mail content, possible file encoding error'
        );
        /** @var d3ordermanager_smartyException $e */
        $e = d3GetModCfgDIC()->get( d3ordermanager_smartyException::class );
        throw $e;
    }
}
