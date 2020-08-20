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
use D3\ModCfg\Application\Model\d3str;
use D3\PdfDocuments\Application\Model\Interfaces\pdfdocumentsOrderInterface;
use Doctrine\DBAL\DBALException;
use Exception;
use Html2Text\Html2Text;
use League\Flysystem\FileExistsException;
use OxidEsales\Eshop\Application\Controller\FrontendController;
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
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\UtilsView;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Path\ModulePathResolverInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateEngineInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateRendererBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

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

        parent::__construct();
    }

    /**
     * @return TemplateEngineInterface
     */
    protected function _getTemplateEngine()
    {
        /** @var TemplateRendererInterface $renderer */
        $renderer = $this->d3GetDIContainer()
            ->get(TemplateRendererBridgeInterface::class)
            ->getTemplateRenderer();
        return $renderer->getTemplateEngine();
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

        $templateEngine = $this->_getTemplateEngine();

        /** @var Config $config */
        $config = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);

        $this->_setMailParams($oShop);
        $this->setViewData("aNotes", $aOrderManagerNotes);
        $this->setViewData("shopTemplateDir", $config->getTemplateDir(false));
        $this->setViewData("oShop", $oShop);

        $this->_processViewArray();

        $this->setBody($templateEngine->render($this->_sOrderManagerInfoTemplate));
        $this->setAltBody($templateEngine->render($this->_sOrderManagerInfoPlainTemplate));

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
        /** @var $oOrderManager d3ordermanager */
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
        return $aEditedValues[$sVarName] === false || $aEditedValues[$sVarName] === null ?
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
        /** @var d3_cfg_mod $modcfg */
        $modcfg = d3GetModCfgDIC()->get('d3.ordermanager.modcfg');
        return $modcfg;
    }

    /**
     * @return Payment
     * @throws Exception
     */
    public function d3GetPayment()
    {
        /** @var Payment $payment */
        $payment = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Payment::class);
        return $payment;
    }

    /**
     * @return Language
     * @throws Exception
     */
    public function d3GetLang()
    {
        /** @var Language $language */
        $language = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);
        return $language;
    }

    /**
     * required for unit tests, can't mock getConfig method
     * @return Config
     * @throws Exception
     */
    public function d3GetConfig()
    {
        /** @var Config $config */
        $config = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);
        return $config;
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

        /** @var TemplateRendererInterface $renderer */
        $renderer = $this->d3GetDIContainer()
            ->get(TemplateRendererBridgeInterface::class)
            ->getTemplateRenderer();
        $templateEngine = $renderer->getTemplateEngine();

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

        // ToDo: check in TWIG and change to a generic solution (e.g. path names in template name)
        // Smarty only
        if (method_exists($templateEngine, '__set')) {
            $templateEngine->__set( 'template_dir', $this->getTemplateDir4OrderManager( $oOrderManager ) );
        }
        $this->_processViewArray();

        if (false == $this->d3GetSet()->getLicenseConfigData('blUseMailSendOnly', 0)) {
            $templateEngine = $this->d3SendMailHook($templateEngine);
        }

        $aContent = $this->_d3GenerateOrderManagerMailContent($aContent, $templateEngine);
        $oConfig->setAdminMode(true);

        return $aContent;
    }

    /**
     * @return d3str
     * @throws Exception
     */
    public function getD3Str()
    {
        /** @var d3str $d3str */
        $d3str = d3GetModCfgDIC()->get(d3str::class);
        return $d3str;
    }

    /**
     * @param d3ordermanager $oOrderManager
     *
     * @return string
     * @throws Exception
     */
    public function getTemplateDir4OrderManager($oOrderManager)
    {
        if ($oOrderManager->getValue('sSendMailFromTheme') == 'module') {
            $sModuleId = $oOrderManager->getValue('sSendMailFromModulePath');
            $pathResolver = $this->d3GetDIContainer()->get(ModulePathResolverInterface::class);
            $sModulePath = $pathResolver->getFullModulePathFromConfiguration(
                $sModuleId,
                Registry::getConfig()->getShopId()
            );
            $sPath = $this->getD3Str()->untrailingslashit($sModulePath);
        } else {
            $blAdmin = $oOrderManager->getValue('sSendMailFromTheme') == 'admin';
            $sPath   = $this->d3GetConfig()->getTemplateDir($blAdmin);
        }
        return $sPath;
    }

    /**
     * @param TemplateEngineInterface $templateEngine
     * @return TemplateEngineInterface
     */
    public function d3SendMailHook(TemplateEngineInterface $templateEngine)
    {
        // available objects:
        // oxEmail:                $this
        // Smarty:                 $oSmarty
        // Ordermanager profile:   $this->oOrderManager
        // Order:                inside smarty
        // oxuser:                 inside smarty

        return $templateEngine;
    }

    /**
     * @codeCoverageIgnore because visual CMS extension issue
     * @return UtilsView
     * @throws Exception
     */
    public function d3GetUtilsView()
    {
        /** @var UtilsView $utilsView */
        $utilsView = d3GetModCfgDIC()->get('d3ox.ordermanager.'.UtilsView::class);
        return $utilsView;
    }

    /**
     * @return Content
     * @throws Exception
     */
    public function d3GetContent()
    {
        /** @var Content $content */
        $content = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Content::class);
        return $content;
    }

    /**
     * @param               $aContent
     * @param TemplateEngineInterface $templateEngine
     *
     * @return mixed
     * @throws d3ParameterNotFoundException
     * @throws Exception
     */
    protected function _d3GenerateOrderManagerMailContent($aContent, TemplateEngineInterface $templateEngine)
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

        if ($this->d3HasOrderManagerEditorMailContent($aEditedValues)) {
            $aContent = $aEditedValues['mail'];

            if ($aContent['genplain']) {
                $aContent['plain'] = $this->d3generatePlainContent($aContent['html']);
            }
        } elseif ($this->oOrderManager->getValue('sSendMailFromSource') == 'cms') {
            $oUtilsView = $this->d3GetUtilsView();
            $oContent = $this->d3GetContent();
            $oContent->loadInLang($iOrderLangId, $this->oOrderManager->getValue('sSendMailFromContentname'));

            $oActView = oxNew(FrontendController::class);
            $oActView->addGlobalParams();

            $aContent['html']    = $oUtilsView->getRenderedContent(
                $oContent->getFieldData('oxcontent'),
                $oActView->getViewData(),
                $oContent->getId() . 'oxcontent'
            );

            $aContent['subject'] = $oContent->getFieldData('oxtitle');
            $oContent->loadInLang($iOrderLangId, $this->oOrderManager->getValue('sSendMailFromContentnamePlain'));
            $aContent['plain'] = $oUtilsView->getRenderedContent(
                $oContent->getFieldData('oxcontent'),
                $oActView->getViewData(),
                $oContent->getId() . 'oxcontent'
            );
        } elseif ($this->oOrderManager->getValue('sSendMailFromSource') == 'template') {
            $aContent['html']    = $templateEngine->render($this->oOrderManager->getValue('sSendMailFromTemplatename'));
            $aContent['plain']   = $templateEngine->render($this->oOrderManager->getValue('sSendMailFromTemplatenamePlain'));
            $aContent['subject'] = $templateEngine->render($this->oOrderManager->getValue('sSendMailFromSubject'));
        }

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
        return is_array($aEditedValues) && is_array($aEditedValues['mail']);
    }

    /**
     * @param $html
     * @return string
     * @throws Exception
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

        /** @var d3ordermanager_pdfhandler $pdfHandler */
        $pdfHandler = d3GetModCfgDIC()->get(d3ordermanager_pdfhandler::class);
        return $pdfHandler;
    }

    /**
     * @param d3ordermanager $oOrderManager
     *
     * @throws FileExistsException
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
     * @throws Exception
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

        if ($oOrderManager->getValue($action->sActionActiveSwitch)
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
     * @throws d3ParameterNotFoundException
     * @throws Exception
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

        if ($oOrderManager->getValue($action->sActionActiveSwitch)
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
            'oxparentid' => $this->oOrderManager->getCurrentItem()->getOrderUser()->getId(),
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
    public function d3GetDIContainer()
    {
        return ContainerFactory::getInstance()->getContainer();
    }
}
