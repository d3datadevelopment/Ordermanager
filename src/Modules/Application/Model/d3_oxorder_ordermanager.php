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
use Exception;
use InvoicepdfPDF;
use oxArticleInputException;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\Payment;
use OxidEsales\Eshop\Application\Model\Voucher;
use OxidEsales\Eshop\Core\Exception\ArticleException;
use OxidEsales\Eshop\Core\Exception\ArticleInputException;
use OxidEsales\Eshop\Core\Exception\NoArticleException;
use OxidEsales\Eshop\Core\Model\ListModel;
use oxNoArticleException;

class d3_oxorder_ordermanager extends d3_oxorder_ordermanager_parent
{
    /** @var Payment */
    protected $_oPayment = null;
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
     * @return Basket
     */
    public function d3getBasket4OrderManager()
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
    public function d3getPayment4OrderManager()
    {
        return $this->_oPayment;
    }

    /**
     * @return Voucher
     * @throws Exception
     */
    public function d3GetVoucher()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.Voucher::class);
    }

    /**
     * @param d3ordermanager $oOrderManager
     * @return Basket
     * @throws ArticleException
     * @throws ArticleInputException
     * @throws NoArticleException
     * @throws oxArticleInputException
     * @throws oxNoArticleException
     * @throws Exception
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
            $oVoucher = $this->d3GetVoucher();
            $oVoucher->load($sKey);
            $this->_aVoucherList[$sKey] = $oVoucher;
        }

        return $oBasket;
    }

    /**
     * @return d3ordermanager_pdfhandler
     * @throws Exception
     */
    public function d3GetPdfHandler()
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_pdfhandler::class.'.args.ordermanager',
            d3GetModCfgDIC()->get(d3ordermanager::class)
        );
        d3GetModCfgDIC()->set(
            d3ordermanager_pdfhandler::class.'.args.order',
            d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)
        );

        return d3GetModCfgDIC()->get(d3ordermanager_pdfhandler::class);
    }

    /**
     * @return InvoicepdfPDF
     * @throws Exception
     */
    public function d3GetInvoicePdf()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.InvoicepdfPDF::class);
    }

    /**
     * @param $sFilename
     * @param int $iSelLang
     * @param string $sDocType
     * @param string $sDestination
     * @return null|string
     * @throws Exception
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

        $oPdfHandler = $this->d3GetPdfHandler();
        if ($oPdfHandler->canGeneratePdf()) {

            $oPdf = $this->d3GetInvoicePdf();
            $oPdf->setPrintHeader(false);
            $oPdf->Open();

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
            return $oPdf->Output($sFilename, $sDestination);
        }

        return null;
    }
}
