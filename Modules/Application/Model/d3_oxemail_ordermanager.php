<?php

/**
 * Copyright (c) D3 Data Development (Inh. Thomas Dartsch)
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * https://www.d3data.de
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development - Daniel Seifert <info@shopmodule.com>
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
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_action_sendmail;
use D3\Ordermanager\Application\Model\Constants;
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
use Doctrine\DBAL\Exception as DBALException;
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
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateEngineInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateRendererBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class d3_oxemail_ordermanager extends d3_oxemail_ordermanager_parent
{
    private string $_sModId = 'd3_ordermanager';

    protected $_sOrderManagerInfoTemplate = '@'.Constants::OXID_MODULE_ID.'/admin/email/html/d3ordermanager_info_html';

    protected $_sOrderManagerInfoPlainTemplate = '@'.Constants::OXID_MODULE_ID.'/admin/email/plain/d3ordermanager_info_plain';

    /** @var  Manager */
    public $oOrderManager;

    /**
     * d3_oxemail_ordermanager constructor.
     * @throws Exception
     */
    public function __construct()
    {
        d3GetOxidDIC()->getParameter('d3.ordermanager.modcfgid') === $this->_sModId or
            throw oxNew(wrongModIdException::class, $this->_sModId);

        parent::__construct();
    }

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
     * @throws d3ordermanager_smartyException
     * @throws Exception
     */
    public function d3sendOrderManagerEmail($aManagerNotes): bool
    {
        startProfile(__METHOD__);

        $oShop = $this->getShop();

        /** @var Config $config */
        $config = d3GetOxidDIC()->get('d3ox.ordermanager.'.Config::class);

        $this->setMailParams($oShop);
        $this->setViewData("aNotes", $aManagerNotes);
        $this->setViewData("shopTemplateDir", $config->getTemplateDir(false));
        $this->setViewData("oShop", $oShop);

        $this->processViewArray();

        set_error_handler(
            [d3GetOxidDIC()->get(d3ordermanager_renderererrorhandler::class), 'd3HandleTemplateEngineErrors']
        );

        $templateEngine = $this->_d3GetOrderManagerTemplateEngine();
        foreach ($this->getViewData() as $key => $value) {
            $templateEngine->addGlobal($key, $value);
        }

        $this->d3OMsetBody($templateEngine->render($this->_sOrderManagerInfoTemplate));
        $this->d3OMsetAltBody($templateEngine->render($this->_sOrderManagerInfoPlainTemplate));

        restore_error_handler();

        /** @var d3LogInterface $oLog */
        $oLog = d3GetOxidDIC()->get('d3.ordermanager.log');
        $oLog->notice(
            self::class,
            __FUNCTION__,
            __LINE__,
            'send job execution info mail',
            $this->getBody()
        );

        /** @var Language $oLang */
        $oLang = d3GetOxidDIC()->get('d3ox.ordermanager.'.Language::class);
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
     * @throws Exception
     */
    public function d3getOrderManagerOrder($sOxId): Item
    {
        if (strstr($sOxId, '@@')) {
            $aOxId = explode('@@', $sOxId);
            $sOxId = $aOxId[0];
        }

        /** @var Item $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);

        $oItem->load($sOxId);
        return $oItem;
    }

    /**
     * @param $sOxId
     * @throws Exception
     */
    public function d3getOrderManager($sOxId): Manager
    {
        /** @var Manager $oManager */
        $oManager = d3GetOxidDIC()->get(Manager::class);
        $oManager->load($sOxId);
        return $oManager;
    }

    /**
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

            $oShop = $this->getShop();
            $this->d3OMsetBody($aContent['html']);
            $this->d3OMsetAltBody($aContent['plain']);
            $this->d3OMsetSubject($aContent['subject']);

            $this->_d3SetOrderManagerReplyAddress($oManager, $oShop);

            $oRemark = $this->_d3SetOrderManagerMailRecipients($oShop);

            $this->_d3AddOrderManagerPdfAttachment($oManager);

            $blSuccess = $this->send();

            if ($blSuccess && $oRemark instanceof Remark) {
                $oRemark->save();
            }
        } catch (emptyMessageException) {
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
        if ((string) $content === '') {
            return;
        }

        if ((bool) strlen($this->getBody())) {
            return;
        }

        $this->d3OrderManagerThrowUnequalContentException();
    }

    /**
     * @param $content
     *
     * @throws d3ordermanager_smartyException
     */
    protected function d3OMsetAltBody($content)
    {
        $this->setAltBody($content);
        if ((string) $content === '') {
            return;
        }

        if ((bool) strlen($this->getAltBody())) {
            return;
        }

        $this->d3OrderManagerThrowUnequalContentException();
    }

    /**
     * @param $content
     *
     * @throws d3ordermanager_smartyException
     */
    protected function d3OMsetSubject($content)
    {
        $this->setSubject($content);
        if ((string) $content === '') {
            return;
        }

        if ((bool) strlen($this->getSubject())) {
            return;
        }

        $this->d3OrderManagerThrowUnequalContentException();
    }

    /**
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
     *
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
                $fromTheme === d3ordermanager_action_sendmail::ADMIN_CONTEXT ?
                    MessageContentGenerator::TEMPLATE_FROM_ADMIN :
                    MessageContentGenerator::TEMPLATE_FROM_FRONTEND
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
     * @throws Exception
     */
    public function getD3OrderManagerStrObject(): d3str
    {
        /** @var d3str $d3str */
        $d3str = d3GetOxidDIC()->get(d3str::class);
        return $d3str;
    }

    /**
     * @throws Exception
     */
    public function d3GetOrderManagerContentObject(): Content
    {
        /** @var Content $content */
        $content = d3GetOxidDIC()->get('d3ox.ordermanager.'.Content::class);
        return $content;
    }

    /**
     * @param $aEditedValues
     */
    public function d3HasOrderManagerEditorMailContent($aEditedValues): bool
    {
        return $this->d3isOrderManagerArrayEditorMailContent($aEditedValues) &&
               $aEditedValues['mail']['subject'] &&
               $aEditedValues['mail']['html'] &&
                (
                    (isset($aEditedValues['mail']['genplain']) && $aEditedValues['mail']['genplain']) ||
                        $aEditedValues['mail']['plain']
                );
    }

    /**
     * @param $aEditedValues
     */
    public function d3isOrderManagerArrayEditorMailContent($aEditedValues): bool
    {
        return is_array($aEditedValues) && isset($aEditedValues['mail']) && is_array($aEditedValues['mail']);
    }

    /**
     * @param $html
     * @throws Exception
     */
    public function d3generateOrderManagerPlainContent($html): string
    {
        /** @var Html2TextContext $context */
        $context = d3GetOxidDIC()->get(Html2TextContextInterface::class);
        $context->setMessage($html);

        /** @var Html2Text $html */
        $html = d3GetOxidDIC()->get(Html2Text::class);
        return $html->getText();
    }

    /**
     * @throws Exception
     */
    public function d3GetOrderManagerRemark(): Remark
    {
        /** @var Remark $remark */
        $remark = d3GetOxidDIC()->get('d3ox.ordermanager.'.Remark::class);
        return $remark;
    }

    /**
     *
     * @throws d3ParameterNotFoundException
     * @throws Exception
     */
    protected function _d3sendOrderManagerMailToCustomer(Shop $oShop): Remark
    {
        $oOrderUser = $this->oOrderManager->getCurrentItem()->getOrderUser();

        /** @var null|string $userId */
        $userId = $oOrderUser->getId();
        if ($userId !== null && $userId !== '') {
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
     *
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
     * @throws d3ParameterNotFoundException
     */
    protected function _d3getOrderManagerCustomMailAddressList(): array
    {
        $aMailAddressList = [];

        foreach (explode(';', $this->_d3getOrderManagerCustomRecipientList()) as $sAddress) {
            if (strlen(trim($sAddress)) !== 0) {
                $aMailAddressList[] = trim($sAddress);
            }
        }

        return $aMailAddressList;
    }

    /**
     * @throws d3ParameterNotFoundException
     */
    public function _d3HasOrderManagerCustomMailAddresses(): bool
    {
        return $this->_d3hasOrderManagerCustomRecipient() && $this->_d3getOrderManagerCustomRecipientList();
    }

    /**
     *
     * @throws d3ParameterNotFoundException
     * @throws Exception
     */
    public function d3getOrderManagerPdfHandler(Manager $oOrderManager): d3ordermanager_pdfhandler
    {
        d3GetOxidDIC()->set(
            d3ordermanager_pdfhandler::class.'.args.ordermanager',
            $oOrderManager
        );
        d3GetOxidDIC()->set(
            d3ordermanager_pdfhandler::class.'.args.order',
            $oOrderManager->getCurrentItem()
        );

        /** @var d3ordermanager_pdfhandler $pdfHandler */
        $pdfHandler = d3GetOxidDIC()->get(d3ordermanager_pdfhandler::class);
        return $pdfHandler;
    }

    /**
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
     * @throws FileExistsException
     * @throws Exception
     */
    public function d3addOrderManagerOXIDPdfAttachment(Manager $oOrderManager, d3ordermanager_pdfhandler $oPDFHandler)
    {
        d3GetOxidDIC()->set(
            d3ordermanager_action_generatepdf::class.'.args.ordermanager',
            d3GetOxidDIC()->get(Manager::class)
        );
        d3GetOxidDIC()->set(
            d3ordermanager_action_generatepdf::class.'.args.order',
            d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class)
        );

        /** @var d3ordermanager_action_generatepdf $action */
        $action = d3GetOxidDIC()->get(d3ordermanager_action_generatepdf::class);

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
     *
     * @throws FileExistsException
     * @throws d3ParameterNotFoundException
     * @throws Exception
     */
    public function d3addOrderManagerPdfDocumentsAttachment(Manager $oManager, d3ordermanager_pdfhandler $oPDFHandler)
    {
        d3GetOxidDIC()->set(
            d3ordermanager_action_getpdfdocuments::class.'.args.ordermanager',
            $oManager
        );

        d3GetOxidDIC()->set(
            d3ordermanager_action_getpdfdocuments::class.'.args.order',
            $oManager->getCurrentItem()
        );

        /** @var d3ordermanager_action_getpdfdocuments $action */
        $action = d3GetOxidDIC()->get(d3ordermanager_action_getpdfdocuments::class);
        if (!$oManager->getValue($action->getActiveSwitchParameter())) {
            return;
        }

        if (!$oManager->getValue('blActionOrderPdfDocumentSendAttach')) {
            return;
        }

        if (!$oPDFHandler->canGeneratePdfDocuments()) {
            return;
        }

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

    protected function _d3SetOrderManagerReplyAddress(Manager $oManager, Shop $oShop)
    {
        if (strlen(trim((string) $oManager->getValue('sSendMailReplyAddress'))) !== 0) {
            $this->setFrom(trim($oManager->getValue('sSendMailReplyAddress')));
            $this->setReplyTo(
                trim((string) $oManager->getValue('sSendMailReplyAddress')),
                $oShop->__get('oxshops__oxname')->getRawValue()
            );
        } else {
            $this->setFrom($oShop->getFieldData('oxinfoemail'), $oShop->__get('oxshops__oxname')->getRawValue());
            $this->setReplyTo($oShop->getFieldData('oxinfoemail'), $oShop->__get('oxshops__oxname')->getRawValue());
        }
    }

    /**
     * add user history
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
     *
     * @return MessageContentGenerator|mixed
     * @throws d3ParameterNotFoundException
     */
    protected function getMessageContentGeneratorOrderManager(Manager $oManager)
    {
        return oxNew(MessageContentGenerator::class, $oManager, $oManager->getCurrentItem());
    }
}
