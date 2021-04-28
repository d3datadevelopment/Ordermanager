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

declare(strict_types = 1);

namespace D3\Ordermanager\Modules\Application\Model;

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ParameterNotFoundException;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_conf;
use D3\Ordermanager\Application\Model\d3ordermanager_configurationcheck;
use D3\Ordermanager\Application\Model\d3ordermanager_execute;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\Exceptions\d3ActionRequirementAbstract;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_templaterendererExceptionInterface;
use Doctrine\DBAL\DBALException;
use Exception;
use InvoicepdfPDF;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\Payment;
use OxidEsales\Eshop\Application\Model\Voucher;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\ArticleException;
use OxidEsales\Eshop\Core\Exception\ArticleInputException;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\UtilsView;

class d3_oxorder_ordermanager extends d3_oxorder_ordermanager_parent
{
    /** @var Payment */
    protected $_oPayment = null;
    protected $_iSelectedLang;

    CONST PREVENTION_FINALIZEORDER = 'd3PreventOMFinalizeOrderTrigger';
    CONST PREVENTION_SAVEORDER = 'd3PreventOMSaveOrderTrigger';

    /**
     * @param $sName
     *
     * @return mixed
     */
    public function __get($sName)
    {
        $mContent = parent::__get($sName);

        if (false == $mContent && $this->{$sName}) {
            return $this->{$sName};
        }

        return $mContent;
    }

    /**
     * @param Basket $oBasket
     */
    public function d3setBasket4OrderManager(Basket $oBasket)
    {
        $this->_oBasket = $oBasket;
    }

    /**
     * @return Basket
     */
    public function d3getBasket4OrderManager(): Basket
    {
        return $this->_oBasket;
    }

    /**
     * @param Payment $oPayment
     */
    public function d3setPayment4OrderManager(Payment $oPayment)
    {
        $this->_oPayment = $oPayment;
    }

    /**
     * @return Payment
     */
    public function d3getPayment4OrderManager(): ?Payment
    {
        return $this->_oPayment;
    }

    /**
     * @return Voucher
     * @throws Exception
     */
    public function d3GetOrderManagerVoucher(): Voucher
    {
        /** @var Voucher $voucher */
        $voucher = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Voucher::class);
        return $voucher;
    }

    /**
     * @param Manager $oOrderManager
     *
     * @return Basket
     * @throws ArticleException
     * @throws ArticleInputException
     */
    public function d3getOrderBasket4OrderManager(Manager $oOrderManager)
    {
        $this->reloadDelivery(false);
        // reload discount to true, because there is no voucher list in basket
        $this->reloadDiscount(true);
        /** @var $oBasket d3_oxbasket_ordermanager */
        $oBasket = $this->_getOrderBasket(false);

        /** @var $oOrderArticles ListModel */
        $oOrderArticles = $this->getOrderArticles(
            false === (bool) $oOrderManager->getValue('blGetStornoArticles')
        );

        // if no order articles, return empty basket
        if ($oOrderArticles->count() > 0) {
            //adding order articles to basket
            /** @var OrderArticle $oOrderArticle */
            foreach ($oOrderArticles as $oOrderArticle) {
                $oBasket->addOrderArticleToBasket4OrderManager($oOrderArticle);
            }
        }

        $oBasket->calculateBasket4OrderManager(true, $this);

        $this->_aVoucherList = $oBasket->getVouchers();
        foreach (array_keys($this->_aVoucherList) as $sKey) {
            $oVoucher = $this->d3GetOrderManagerVoucher();
            $oVoucher->load($sKey);
            $this->_aVoucherList[$sKey] = $oVoucher;
        }

        return $oBasket;
    }

    /**
     * @return d3ordermanager_pdfhandler
     * @throws Exception
     */
    public function d3GetOrderManagerPdfHandler(): d3ordermanager_pdfhandler
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_pdfhandler::class.'.args.ordermanager',
            d3GetModCfgDIC()->get(Manager::class)
        );
        d3GetModCfgDIC()->set(
            d3ordermanager_pdfhandler::class.'.args.order',
            d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)
        );

        /** @var d3ordermanager_pdfhandler $pdfHandler */
        $pdfHandler = d3GetModCfgDIC()->get(d3ordermanager_pdfhandler::class);
        return $pdfHandler;
    }

    /**
     * @return InvoicepdfPDF
     * @throws Exception
     */
    public function d3GetOrderManagerInvoicePdf(): InvoicepdfPDF
    {
        /** @var InvoicepdfPDF $invoicePdf */
        $invoicePdf = d3GetModCfgDIC()->get('d3ox.ordermanager.'.InvoicepdfPDF::class);
        return $invoicePdf;
    }

    /**
     * @param $sFilename
     * @param int $iSelLang
     * @param string $sDocType
     * @param string $sDestination
     * @return null|string
     * @throws Exception
     */
    public function d3OrderManagerGeneratePdf(
        $sFilename,
        $iSelLang = 0,
        $sDocType = d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_INVOICE,
        $sDestination = 'S'
    ): ?string
    {
        // setting pdf language
        $this->_iSelectedLang = $iSelLang;

        // setting invoice number
        if (!$this->getFieldData('oxbillnr')) {
            $this->assign(
                [
                    'oxbillnr'      => $this->getNextBillNum(),
                    'oxbilldate'    => date(
                        'Y-m-d',
                        mktime(0, 0, 0, (int) date('m'), (int) date('d'), (int) date('Y'))
                    )
                ]
            );
            $this->save();
        }

        $oPdfHandler = $this->d3GetOrderManagerPdfHandler();
        if ($oPdfHandler->canGenerateOxidPdf()) {

            $oPdf = $this->d3GetOrderManagerInvoicePdf();
            $oPdf->setPrintHeader(false);
            $oPdf->Open();

            // adding header
            $this->pdfHeader($oPdf);
            $this->d3OrderManagerGeneratePdfBody( $sDocType, $oPdf );
            // adding footer
            $this->pdfFooter($oPdf);

            // outputting file to browser
            return $oPdf->Output($sFilename, $sDestination);
        }

        return null;
    }

    /**
     * @param Basket $oBasket
     * @param object $oUser
     * @param bool $blRecalculatingOrder
     * @return int
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ParameterNotFoundException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     */
    public function finalizeOrder(Basket $oBasket, $oUser, $blRecalculatingOrder = false)//: int // function declaration must be compatible with parent function
    {
        $iRet = parent::finalizeOrder($oBasket, $oUser, $blRecalculatingOrder);

        /** @var d3_cfg_mod $oSet */
        $oSet = d3GetModCfgDIC()->get('d3.ordermanager.modcfg');
        $currentAdminMode = $this->isAdmin();

        if ($oSet->isActive() && in_array(Registry::getSession()->getVariable(self::PREVENTION_FINALIZEORDER), [null, false], true)) {
            /** @var d3ordermanagerlist $oOrderManagerList */
            $oOrderManagerList = d3GetModCfgDIC()->get(d3ordermanagerlist::class);
            /** @var Manager $oManager */
            foreach ($oOrderManagerList->d3GetOrderFinishTriggeredManagerTasks() as $oManager) {
                try {
                    $this->d3OrderManagerCheckForConfigurationException($oManager);

                    $oManagerExecute = $this->d3OrdermanagerGetManagerExecute($oManager);
                    if ($oManagerExecute->orderMeetsConditions($this->getId())) {
                        // prevent infinit loop because of circular reference in recalculate::method
                        Registry::getSession()->setVariable(self::PREVENTION_FINALIZEORDER, true);
                        $oManagerExecute->exec4order($this->getId(), d3ordermanager_conf::EXECTYPE_ORDERFINISHTRIGGERED);
                    }
                } catch (d3ActionRequirementAbstract $e) {
                    $e->debugOut();
                    if (true === $currentAdminMode) {
                        /** @var UtilsView $utilsView */
                        $utilsView = d3GetModCfgDIC()->get('d3ox.ordermanager.' . UtilsView::class);
                        $utilsView->addErrorToDisplay($e);
                    }
                } catch (d3ordermanager_templaterendererExceptionInterface $e) {
                    $e->debugOut();
                    if (true === $currentAdminMode) {
                        /** @var UtilsView $utilsView */
                        $utilsView = d3GetModCfgDIC()->get('d3ox.ordermanager.' . UtilsView::class);
                        $utilsView->addErrorToDisplay($e);
                    }
                } finally {
                    Registry::getSession()->setVariable(self::PREVENTION_FINALIZEORDER, false);
                    $oConfig = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);
                    $oConfig->setAdminMode($currentAdminMode);
                }
            }
        }

        return $iRet;
    }

    /**
     * @return false|string
     * @throws d3ParameterNotFoundException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws Exception
     */
    public function save()
    {
        /** @var false|string $mReturn */
        $mReturn = parent::save();

        /** @var d3_cfg_mod $oSet */
        $oSet = d3GetModCfgDIC()->get('d3.ordermanager.modcfg');
        $currentAdminMode = $this->isAdmin();

        if ($oSet->isActive() && in_array(Registry::getSession()->getVariable(self::PREVENTION_SAVEORDER), [null, false], true)) {
            /** @var d3ordermanagerlist $oOrderManagerList */
            $oOrderManagerList = d3GetModCfgDIC()->get(d3ordermanagerlist::class);
            /** @var Manager $oManager */
            foreach ($oOrderManagerList->d3GetOrderSaveTriggeredManagerTasks() as $oManager) {
                try {
                    $this->d3OrderManagerCheckForConfigurationException($oManager);

                    $oManagerExecute = $this->d3OrdermanagerGetManagerExecute($oManager);
                    if ($oManagerExecute->orderMeetsConditions($this->getId())) {
                        // prevent infinit loop because of circular reference in save::method
                        Registry::getSession()->setVariable(self::PREVENTION_SAVEORDER, true);
                        $oManagerExecute->exec4order($this->getId(), d3ordermanager_conf::EXECTYPE_ORDERSAVETRIGGERED);
                    }
                } catch (d3ActionRequirementAbstract $e) {
                    $e->debugOut();
                    if (true === $currentAdminMode) {
                        /** @var UtilsView $utilsView */
                        $utilsView = d3GetModCfgDIC()->get('d3ox.ordermanager.' . UtilsView::class);
                        $utilsView->addErrorToDisplay($e);
                    }
                } catch (d3ordermanager_templaterendererExceptionInterface $e) {
                    $e->debugOut();
                    if (true === $currentAdminMode) {
                        /** @var UtilsView $utilsView */
                        $utilsView = d3GetModCfgDIC()->get('d3ox.ordermanager.' . UtilsView::class);
                        $utilsView->addErrorToDisplay($e);
                    }
                } finally {
                    Registry::getSession()->setVariable(self::PREVENTION_SAVEORDER, false);
                    $oConfig = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);
                    $oConfig->setAdminMode($currentAdminMode);
                }
            }
        }

        return $mReturn;
    }

    /**
     * @param Manager $oManager
     * @return d3ordermanager_execute
     * @throws Exception
     */
    public function d3OrdermanagerGetManagerExecute(Manager $oManager): d3ordermanager_execute
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_execute::class.'.args.ordermanager',
            $oManager
        );

        /** @var d3ordermanager_execute $execute */
        $execute = d3GetModCfgDIC()->get(d3ordermanager_execute::class);
        return $execute;
    }

    /**
     * @param               $sDocType
     * @param InvoicepdfPDF $oPdf
     */
    public function d3OrderManagerGeneratePdfBody( $sDocType, InvoicepdfPDF $oPdf )
    {
        switch ( $sDocType ) {
            case d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_DELIVERYNOTE:
                $this->exportDeliveryNote( $oPdf );
                break;
            case d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_INVOICE:
                $this->exportStandart( $oPdf );
        }
    }

    /**
     * @param Manager $oManager
     */
    protected function d3OrderManagerCheckForConfigurationException(Manager $oManager): void
    {
        d3GetModCfgDIC()->set(d3ordermanager_configurationcheck::class.'.args.ordermanager', $oManager);
        d3GetModCfgDIC()->setParameter(
            d3ordermanager_configurationcheck::class.'.args.checktypes',
            $oManager->getValue('sManuallyExecMeetCondition') ?
                d3ordermanager_configurationcheck::REQUIREMENTS_AND_ACTIONS :
                d3ordermanager_configurationcheck::ACTIONS_ONLY
        );
        /** @var d3ordermanager_configurationcheck $confCheck */
        $confCheck = d3GetModCfgDIC()->get(d3ordermanager_configurationcheck::class);
        $confCheck->checkThrowingExceptions();
    }
}
