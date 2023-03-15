<?php

/**
 * This Software is the property of Data Development and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * https://www.d3data.de
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development - Daniel Seifert <support@shopmodule.com>
 * @link      https://www.oxidmodule.com
 */

declare(strict_types=1);

namespace D3\Ordermanager\Modules\Application\Model;

use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ParameterNotFoundException;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Model\Exception\wrongModIdException;
use D3\ModCfg\Application\Model\Log\d3LogInterface;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_action_generatepdf;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_action_getpdfdocuments;
use D3\Ordermanager\Application\Model\Context\Html2TextContext;
use D3\Ordermanager\Application\Model\Context\Html2TextContextInterface;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_conf;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler;
use D3\ModCfg\Application\Model\d3str;
use D3\Ordermanager\Application\Model\d3ordermanager_renderererrorhandler;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_smartyException;
use D3\Ordermanager\Application\Model\Exceptions\emptyMessageException;
use D3\Ordermanager\Application\Model\MessageContentGenerator;
use D3\PdfDocuments\Application\Model\Interfaces\pdfdocumentsOrderInterface;
use Doctrine\DBAL\DBALException;
use Exception;
use Html2Text\Html2Text;
use League\Flysystem\FileExistsException;
use OxidEsales\Eshop\Application\Model\Order as Item;
use OxidEsales\Eshop\Application\Model\Shop;
use OxidEsales\Eshop\Application\Model\Remark;
use OxidEsales\Eshop\Application\Model\Content;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\DatabaseException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Smarty\Legacy\LegacySmartyEngine;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateEngineInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateRendererBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class d3_oxemail_ordermanager extends d3_oxemail_ordermanager_parent
{
    private $_sModId = 'd3_ordermanager';
    protected $_sOrderManagerInfoTemplate = 'd3ordermanager_info_html.tpl';
    protected $_sOrderManagerInfoPlainTemplate = 'd3ordermanager_info_plain.tpl';
    /** @var  Manager */
    public $oOrderManager;

    /**
     * d3_oxemail_ordermanager constructor.
     * @throws Exception
     */
    public function __construct()
    {
        if (d3GetModCfgDIC()->getParameter('d3.ordermanager.modcfgid') !== $this->_sModId) {
            throw oxNew(wrongModIdException::class, $this->_sModId);
        }

        parent::__construct();
    }

    /**
     * @return TemplateEngineInterface
     */
    protected function _d3GetOrderManagerTemplateEngine(): TemplateEngineInterface
    {
        /** @var TemplateRendererInterface $renderer */
        $renderer = $this->d3getOrderManagerDIContainer()
            ->get(TemplateRendererBridgeInterface::class)
            ->getTemplateRenderer();
        return $renderer->getTemplateEngine();
    }

    /**
     * @param $aManagerNotes
     *
     * @return bool
     * @throws d3ordermanager_smartyException
     * @throws Exception
     */
    public function d3sendOrderManagerEmail($aManagerNotes): bool
    {
        startProfile(__METHOD__);

        $oShop = $this->_getShop();

        /** @var Config $config */
        $config = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);

        $this->_setMailParams($oShop);
        $this->setViewData("aNotes", $aManagerNotes);
        $this->setViewData("shopTemplateDir", $config->getTemplateDir(false));
        $this->setViewData("oShop", $oShop);

        $this->_processViewArray();

        set_error_handler(
            [d3GetModCfgDIC()->get(d3ordermanager_renderererrorhandler::class), 'd3HandleTemplateEngineErrors']
        );
        /** @var LegacySmartyEngine $templateEngine */
        $templateEngine = $this->_d3GetOrderManagerTemplateEngine();
        foreach ($this->getViewData() as $key => $value) {
            $templateEngine->addGlobal($key, $value);
        }
        $this->d3OMsetBody($templateEngine->render($this->_sOrderManagerInfoTemplate));
        $this->d3OMsetAltBody($templateEngine->render($this->_sOrderManagerInfoPlainTemplate));

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
     * @return Item
     * @throws Exception
     */
    public function d3getOrderManagerOrder($sOxId): Item
    {
        if (strstr($sOxId, '@@')) {
            $aOxId = explode('@@', $sOxId);
            $sOxId = $aOxId[0];
        }

        /** @var $oItem Item */
        $oItem = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Item::class);

        $oItem->load($sOxId);
        return $oItem;
    }

    /**
     * @param $sOxId
     * @return Manager
     * @throws Exception
     */
    public function d3getOrderManager($sOxId): Manager
    {
        /** @var $oManager Manager */
        $oManager = d3GetModCfgDIC()->get(Manager::class);
        $oManager->load($sOxId);
        return $oManager;
    }

    /**
     * @param Manager $oManager
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
    public function sendOrderManagerMail(Manager $oManager): bool
    {
        $blSuccess = false;

        try {
            $this->oOrderManager = $oManager;
            $aContent            = $this->getOrderManagerMailContent($oManager);

            $oShop = $this->_getShop();
            $this->d3OMsetBody($aContent['html']);
            $this->d3OMsetAltBody($aContent['plain']);
            $this->d3OMsetSubject($aContent['subject']);

            $this->_d3SetOrderManagerReplyAddress($oManager, $oShop);

            $oRemark = $this->_d3SetOrderManagerMailRecipients($oShop);

            $this->_d3AddOrderManagerPdfAttachment($oManager);

            $blSuccess = $this->send();

            if ($blSuccess && $oRemark) {
                $oRemark->save();
            }
        } catch (emptyMessageException $e) {
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

        if (strlen($content) && false === (bool) strlen($this->getBody())) {
            $this->d3OrderManagerThrowUnequalContentException();
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

        if (strlen($content) && false === (bool) strlen($this->getAltBody())) {
            $this->d3OrderManagerThrowUnequalContentException();
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

        if (strlen($content) && false === (bool) strlen($this->getSubject())) {
            $this->d3OrderManagerThrowUnequalContentException();
        }
    }

    /**
     * @param Shop $oShop
     *
     * @return null|Remark
     * @throws d3ParameterNotFoundException
     */
    protected function _d3SetOrderManagerMailRecipients(Shop $oShop): ?Remark
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
     * @param Manager $oManager
     *
     * @return array
     * @throws emptyMessageException
     * @throws d3ParameterNotFoundException
     */
    public function getOrderManagerMailContent(Manager $oManager, bool $checkForEmptyContents = true): array
    {
        $aContent = [];

        $aEditedValues = $oManager->getEditedValues();

        if ($this->d3HasOrderManagerEditorMailContent($aEditedValues)) {
            $aContent = $aEditedValues['mail'];

            if ($aContent['genplain']) {
                $aContent['plain'] = $this->d3generateOrderManagerPlainContent($aContent['html']);
            }
            unset($aContent['genplain']);
        } elseif ($oManager->getValue('sSendMailFromSource') == 'cms') {
            $generator = $this->getMessageContentGeneratorOrderManager($oManager);
            $generator->setAllowEmptyMessageContent(true);
            $iOrderLangId = $oManager->getCurrentItem()->getFieldData('oxlang');
            $oContent = $this->d3GetOrderManagerContentObject();
            $oContent->loadInLang($iOrderLangId, $oManager->getValue('sSendMailFromContentname'));
            $aContent['html'] = $generator->generateFromCms($oManager->getValue('sSendMailFromContentname'));
            $aContent['subject'] = $oContent->getFieldData('oxtitle');
            $aContent['plain'] = $generator->generateFromCms($oManager->getValue('sSendMailFromContentnamePlain'));
        } elseif ($oManager->getValue('sSendMailFromSource') == 'template') {
            $generator = $this->getMessageContentGeneratorOrderManager($oManager);
            $generator->setAllowEmptyMessageContent(true);
            $fromTheme = $oManager->getValue('sSendMailFromTheme');
            $generator->setTemplateFrom(
                $fromTheme === 'admin' ? MessageContentGenerator::TEMPLATE_FROM_ADMIN :
                    ($fromTheme === 'module' ? MessageContentGenerator::TEMPLATE_FROM_MODULE :
                        MessageContentGenerator::TEMPLATE_FROM_FRONTEND),
                $oManager->getValue('sSendMailFromModulePath')
            );
            $aContent['html']  = $generator->generateFromTpl($oManager->getValue('sSendMailFromTemplatename'));
            $aContent['subject']  = $generator->generateFromTpl($oManager->getValue('sSendMailFromSubject'));
            $aContent['plain']  = $generator->generateFromTpl($oManager->getValue('sSendMailFromTemplatenamePlain'));
        }

        if ($checkForEmptyContents && (
            (false === is_string($aContent['html']) || false === (bool) strlen($aContent['html'])) &&
            (false === is_string($aContent['html']) || false === (bool) strlen($aContent['plain'])) &&
            (false === is_string($aContent['html']) || false === (bool) strlen($aContent['subject']))
        )
        ) {
            /** @var emptyMessageException $exc */
            $exc = oxNew(emptyMessageException::class, 'message content is empty, '.$oManager->getFieldData('oxtitle'));
            throw $exc;
        }

        return $aContent;
    }

    /**
     * @return d3str
     * @throws Exception
     */
    public function getD3OrderManagerStrObject(): d3str
    {
        /** @var d3str $d3str */
        $d3str = d3GetModCfgDIC()->get(d3str::class);
        return $d3str;
    }

    /**
     * @return Content
     * @throws Exception
     */
    public function d3GetOrderManagerContentObject(): Content
    {
        /** @var Content $content */
        $content = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Content::class);
        return $content;
    }

    /**
     * @param $aEditedValues
     *
     * @return bool
     */
    public function d3HasOrderManagerEditorMailContent($aEditedValues): bool
    {
        return $this->d3isOrderManagerArrayEditorMailContent($aEditedValues) &&
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
    public function d3isOrderManagerArrayEditorMailContent($aEditedValues): bool
    {
        return is_array($aEditedValues) && isset($aEditedValues['mail']) && is_array($aEditedValues['mail']);
    }

    /**
     * @param $html
     * @return string
     * @throws Exception
     */
    public function d3generateOrderManagerPlainContent($html): string
    {
        /** @var Html2TextContext $context */
        $context = d3GetModCfgDIC()->get(Html2TextContextInterface::class);
        $context->setMessage($html);

        /** @var Html2Text $html */
        $html = d3GetModCfgDIC()->get(Html2Text::class);
        return $html->getText();
    }

    /**
     * @return Remark
     * @throws Exception
     */
    public function d3GetOrderManagerRemark(): Remark
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
    protected function _d3sendOrderManagerMailToCustomer(Shop $oShop): Remark
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

        return $this->d3generateOrderManagerRemark();
    }

    /**
     * @param Shop $oShop
     *
     * @return Remark
     * @throws d3ParameterNotFoundException
     * @throws Exception
     */
    protected function _d3sendOrderManagerMailToOwner(Shop $oShop): Remark
    {
        $sFullName = $oShop->__get('oxshops__oxname')->getRawValue();
        $this->setRecipient($oShop->getFieldData('oxinfoemail'), $sFullName);

        if ($this->_d3HasOrderManagerCustomMailAddresses()) {
            foreach ($this->_d3getOrderManagerCustomMailAddressList() as $sMailAdr) {
                $this->addBCC(trim($sMailAdr), trim($sMailAdr));
            }
        }

        return $this->d3generateOrderManagerRemark();
    }

    /**
     * @throws d3ParameterNotFoundException
     */
    protected function _d3sendOrderManagerMailToCustom(): Remark
    {
        if ($this->_d3HasOrderManagerCustomMailAddresses()) {
            foreach ($this->_d3getOrderManagerCustomMailAddressList() as $sMailAdr) {
                $this->setRecipient(trim($sMailAdr), trim($sMailAdr));
            }
        }

        return $this->d3generateOrderManagerRemark();
    }

    /**
     * @return array
     * @throws d3ParameterNotFoundException
     */
    protected function _d3getOrderManagerCustomMailAddressList(): array
    {
        $aMailAddressList = [];

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
    public function _d3HasOrderManagerCustomMailAddresses(): bool
    {
        return $this->_d3hasOrderManagerCustomRecipient() && $this->_d3getOrderManagerCustomRecipientList();
    }

    /**
     * @param Manager $oOrderManager
     *
     * @return d3ordermanager_pdfhandler
     * @throws d3ParameterNotFoundException
     * @throws Exception
     */
    public function d3getOrderManagerPdfHandler(Manager $oOrderManager): d3ordermanager_pdfhandler
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
     * @param Manager $oOrderManager
     *
     * @throws FileExistsException
     * @throws Exception
     */
    protected function _d3AddOrderManagerPdfAttachment(Manager $oOrderManager)
    {
        $oPDFHandler = $this->d3getOrderManagerPdfHandler($oOrderManager);

        $this->d3addOrderManagerOXIDPdfAttachment($oOrderManager, $oPDFHandler);
        $this->d3addOrderManagerPdfDocumentsAttachment($oOrderManager, $oPDFHandler);
    }

    /**
     * @param Manager            $oOrderManager
     * @param d3ordermanager_pdfhandler $oPDFHandler
     *
     * @throws FileExistsException
     * @throws Exception
     */
    public function d3addOrderManagerOXIDPdfAttachment(Manager $oOrderManager, d3ordermanager_pdfhandler $oPDFHandler)
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_action_generatepdf::class.'.args.ordermanager',
            d3GetModCfgDIC()->get(Manager::class)
        );
        d3GetModCfgDIC()->set(
            d3ordermanager_action_generatepdf::class.'.args.order',
            d3GetModCfgDIC()->get('d3ox.ordermanager.'.Item::class)
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
     * @param Manager                   $oManager
     * @param d3ordermanager_pdfhandler $oPDFHandler
     *
     * @throws FileExistsException
     * @throws d3ParameterNotFoundException
     * @throws Exception
     */
    public function d3addOrderManagerPdfDocumentsAttachment(Manager $oManager, d3ordermanager_pdfhandler $oPDFHandler)
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_action_getpdfdocuments::class.'.args.ordermanager',
            $oManager
        );

        d3GetModCfgDIC()->set(
            d3ordermanager_action_getpdfdocuments::class.'.args.order',
            $oManager->getCurrentItem()
        );

        /** @var d3ordermanager_action_getpdfdocuments $action */
        $action = d3GetModCfgDIC()->get(d3ordermanager_action_getpdfdocuments::class);

        if ($oManager->getValue($action->getActiveSwitchParameter())
            && $oManager->getValue('blActionOrderPdfDocumentSendAttach')
            && $oPDFHandler->canGeneratePdfDocuments()
        ) {
            /** @var pdfdocumentsOrderInterface $document */
            foreach ($action->getDocumentList() as $document) {
                if ($oManager->getValue($action->getDocumentRequestId($document))) {
                    $document->setOrder($action->getItem());
                    $oPDFHandler->createPdfDocument($document, d3ordermanager_conf::D3_ORDERMANAGER_PDFSENDTYPE_ATTACH);
                    $sFilePath = $oPDFHandler->getOxidPdfSaveDir(d3ordermanager_conf::D3_ORDERMANAGER_PDFSENDTYPE_ATTACH).$document->getFilename();
                    $this->addAttachment($sFilePath, $document->getFilename(), 'base64', 'application/pdf');
                }
            }
        }
    }

    /**
     * @param Manager $oManager
     * @param Shop $oShop
     */
    protected function _d3SetOrderManagerReplyAddress(Manager $oManager, Shop $oShop)
    {
        if (strlen(trim((string) $oManager->getValue('sSendMailReplyAddress')))) {
            $this->setFrom(trim($oManager->getValue('sSendMailReplyAddress')));
            $this->setReplyTo(
                trim((string) $oManager->getValue('sSendMailReplyAddress')),
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
    public function d3generateOrderManagerRemark(): Remark
    {
        $oRemark        = $this->d3GetOrderManagerRemark();
        $aRemarkContent = [
            'oxtext'     => $this->d3getOrderManagerRemarkText(),
            'oxparentid' => $this->oOrderManager->getCurrentItem()->getOrderUser()->getId() ?:
                $this->oOrderManager->getCurrentItem()->getId(),
            'oxtype'     => 'd3om',
        ];
        $oRemark->assign($aRemarkContent);

        return $oRemark;
    }

    /**
     * @return string
     */
    public function d3getOrderManagerRemarkText(): string
    {
        return implode(
            PHP_EOL.'---'.PHP_EOL,
            [
               'Recipients:',
               implode(', ', array_keys($this->getAllRecipientAddresses())),
               'HTML:',
               $this->getBody(),
               'Plain',
               $this->getAltBody(),
           ]
        );
    }

    /**
     * @return ContainerInterface
     */
    public function d3getOrderManagerDIContainer(): ContainerInterface
    {
        return ContainerFactory::getInstance()->getContainer();
    }

    /**
     * @throws d3ordermanager_smartyException
     * @throws Exception
     */
    protected function d3OrderManagerThrowUnequalContentException(): void
    {
        throw oxNew(d3ordermanager_smartyException::class, 'empty mail content, possible file encoding error');
    }

    /**
     * @param Manager $oManager
     *
     * @return MessageContentGenerator|mixed
     * @throws d3ParameterNotFoundException
     */
    protected function getMessageContentGeneratorOrderManager(Manager $oManager)
    {
        return oxNew(MessageContentGenerator::class, $oManager, $oManager->getCurrentItem());
    }
}
