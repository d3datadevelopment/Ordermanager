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

use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\Payment;
use OxidEsales\Eshop\Application\Model\Voucher;
use OxidEsales\Eshop\Core\Model\ListModel;

class d3_oxorder_ordermanager extends d3_oxorder_ordermanager_parent
{
    protected $_iSelectedLang;

    /**
     * @param string $sName
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
     * @param Payment $oPayment
     */
    public function d3setPayment4OrderManager(Payment $oPayment)
    {
        $this->_oPayment = $oPayment;
    }

    /**
     * @param d3ordermanager $oOrderManager
     * @return Basket
     */
    public function d3getOrderBasket4OrderManager(d3ordermanager $oOrderManager)
    {
        $this->reloadDelivery(false);
        // reload discount to true, because there is no voucher list in basket
        $this->reloadDiscount(true);
        /** @var $oBasket d3_oxbasket_ordermanager */
        $oBasket = $this->_getOrderBasket(false);

        /** @var $oOrderArticles ListModel */
        if ($oOrderManager->getValue('blGetStornoArticles')) {
            $oOrderArticles = $this->getOrderArticles(false);
        } else {
            $oOrderArticles = $this->getOrderArticles(true);
        }

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
            $oVoucher = oxNew(Voucher::class);
            $oVoucher->load($sKey);
            $this->_aVoucherList[$sKey] = $oVoucher;
        }

        return $oBasket;
    }

    /**
     * @param        $sFilename
     * @param int    $iSelLang
     * @param string $sDocType
     * @param string $sDestination
     * @return string
     */
    public function d3generatePdf($sFilename, $iSelLang = 0, $sDocType = 'invoice', $sDestination = 'S')
    {
        // setting pdf language
        $this->_iSelectedLang = $iSelLang;

        // setting invoice number
        if (!$this->getFieldData('oxbillnr')) {
            $this->_setFieldData('oxbillnr', $this->getNextBillNum());
            $this->_setFieldData('oxbilldate', date('Y-m-d', mktime(0, 0, 0, date('m'), date('d'), date('Y'))));
            $this->save();
        }

        $oPdfHandler = oxNew(d3ordermanager_pdfhandler::class, (oxNew(d3ordermanager::class)), (oxNew(Order::class)));
        if ($oPdfHandler->canGeneratePdf()) {

            /** @var \InvoicepdfPDF $oPdf */
            $oPdf = oxNew(\InvoicepdfPDF::class);
            $oPdf->setPrintHeader(false);
            $oPdf->open();

            // adding header
            $this->pdfHeader($oPdf);

            // adding info data
            switch ($sDocType) {
                case 'dnote':
                    $this->exportDeliveryNote($oPdf);
                    break;
                default:
                    $this->exportStandart($oPdf);
            }

            // adding footer
            $this->pdfFooter($oPdf);

            // outputting file to browser
            return $oPdf->output($sFilename, $sDestination);
        }

        return null;
    }
}
