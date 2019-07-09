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

use Exception;
use oxarticleinputexception;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\BasketReservation;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\BasketItem;
use OxidEsales\Eshop\Application\Model\DiscountList;
use OxidEsales\Eshop\Application\Model\Discount;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\ArticleException;
use OxidEsales\Eshop\Core\Exception\ArticleInputException;
use OxidEsales\Eshop\Core\Exception\NoArticleException;
use OxidEsales\Eshop\Core\Price;
use OxidEsales\Eshop\Core\PriceList;
use OxidEsales\Eshop\Core\Session;
use oxnoarticleexception;
use stdClass;

/**
 * Class d3_oxbasket_ordermanager
 * @package D3\Ordermanager\Modules\Models
 * @mixin Basket
 */
class d3_oxbasket_ordermanager extends d3_oxbasket_ordermanager_parent
{
    /**
     * @return d3_oxbasketitem_ordermanager
     * @throws Exception
     */
    public function getBasketItemInstance()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.BasketItem::class);
    }

    /**
     * Adds order article to basket (method normally used while recalculating order)
     *
     * @param OrderArticle $oOrderArticle order article to store in basket
     * @throws Exception
     */
    public function addOrderArticleToBasket4OrderManager($oOrderArticle)
    {
        // adding only if amount > 0
        if ($oOrderArticle->getFieldData('oxamount') > 0) {
            $sItemId = $oOrderArticle->getId();
            //inserting new
            $oBasketItem = $this->getBasketItemInstance();
            $oBasketItem->setStockCheckStatus(false);
            $oBasketItem->initFromOrderArticle($oOrderArticle);
            $oBasketItem->setPrice($oOrderArticle->getPrice());
            $oBasketItem->setWrapping($oOrderArticle->getFieldData('oxwrapid'));
            $oBasketItem->setBundle($oOrderArticle->isBundle());
            $oBasketItem->d3ChangeOrderArticle2RealArticle();

            $this->_aBasketContents[$sItemId] = $oBasketItem;

            //calling update method
            $this->onUpdate();
        }
    }

    /**
     * @return Config
     * @throws Exception
     */
    public function d3GetConfig()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);
    }

    /**
     * @return Session
     * @throws Exception
     */
    public function d3GetSession()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.Session::class);
    }

    /**
     * @param bool $blForceUpdate
     * @param      $oOrder
     * @throws ArticleException
     * @throws ArticleInputException
     * @throws NoArticleException
     * @throws oxArticleInputException
     * @throws oxNoArticleException
     * @throws Exception
     */
    public function calculateBasket4OrderManager($blForceUpdate, $oOrder)
    {
        if (!$this->isEnabled()) {
            return;
        }

        if (false == $this->_blUpdateNeeded && false == $blForceUpdate) {
            return;
        }

        $this->_aCosts = array();

        $this->_oPrice = $this->d3GetPrice();
        $this->_oPrice->setBruttoPriceMode();

        //  1. saving basket to the database
        $this->_save();

        //  2. remove all bundles
        $this->_clearBundles();

        //  3. generate bundle items
        $this->_addBundles();

        // reserve active basket
        if ($this->d3GetConfig()->getConfigParam('blPsBasketReservationEnabled')) {
            /** @var BasketReservation $oBasketReservation */
            $oBasketReservation = $this->d3GetSession()->getBasketReservations();
            $oBasketReservation->reserveBasket($this);
        }

        //  4. calculating item prices
        $this->_calcItemsPrice4OrderManager();

        //  5. calculating/applying discounts
        $this->_calcBasketDiscount4OrderManager($oOrder);

        //  6. calculating basket total discount
        $this->_calcBasketTotalDiscount();

        //  7. check for vouchers
        $this->_calcVoucherDiscount();

        //  8. applies all discounts to pricelist
        $this->_applyDiscounts();

        //  9. calculating additional costs:
        //  9.1: delivery
        $this->setCost('oxdelivery', $this->_calcDeliveryCost());

        //  9.2: adding wrapping costs
        $this->setCost('oxwrapping', $this->_calcBasketWrapping());

        //  9.3: adding payment cost
        $this->setCost('oxpayment', $this->_calcPaymentCost4OrderManager($oOrder));

        //  10. calculate total price
        $this->_calcTotalPrice();

        //  11. formating discounts
        $this->formatDiscount();

        //  12.setting to up-to-date status
        $this->afterUpdate();
    }

    /**
     * @return PriceList
     * @throws Exception
     */
    public function d3getPriceList()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.PriceList::class);
    }

    /**
     * @return DiscountList
     * @throws Exception
     */
    public function d3GetDiscountList()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.DiscountList::class);
    }

    /**
     * @throws oxArticleInputException
     * @throws oxNoArticleException
     * @throws Exception
     */
    protected function _calcItemsPrice4OrderManager()
    {
        // resetting
        $this->setSkipDiscounts(false);

        // resetting
        $this->_aItemDiscounts = array();

        $this->_oProductsPriceList = $this->d3getPriceList();
        $this->_oDiscountProductsPriceList = $this->d3getPriceList();
        $this->_oNotDiscountedProductsPriceList = $this->d3getPriceList();

        $oDiscountList = $this->d3GetDiscountList();

        /** @var $oBasketItem BasketItem */
        foreach ($this->_aBasketContents as $oBasketItem) {
            if (!$oBasketItem->isDiscountArticle() && ( $oArticle = $oBasketItem->getArticle())) {
                $oBasketPrice = $oBasketItem->getUnitPrice();
                $oBasketItem->setRegularUnitPrice(clone $oBasketPrice);
                $oBasketItem->setPrice($oBasketPrice);
                //P adding product price
                $this->_oProductsPriceList->addToPriceList($oBasketItem->getPrice());

                $oBasketPrice->setBruttoPriceMode();
                if (!$oArticle->skipDiscounts() && $this->canCalcDiscounts()) {
                    // apply basket type discounts for item
                    $aDiscounts = $oDiscountList->getBasketItemDiscounts($oArticle, $this, $this->getBasketUser());
                    reset($aDiscounts);
                    /** @var Discount $oDiscount */
                    foreach ($aDiscounts as $oDiscount) {
                        $oBasketPrice->setDiscount($oDiscount->getAddSum(), $oDiscount->getAddSumType());
                    }
                    $oBasketPrice->calculateDiscount();
                } else {
                    $oBasketItem->setSkipDiscounts(true);
                    $this->setSkipDiscounts(true);
                }

                $oBasketPrice->multiply($oBasketItem->getAmount());

                //P collect discount values for basket items which are discountable
                if (!$oArticle->skipDiscounts()) {
                    $this->_oDiscountProductsPriceList->addToPriceList($oBasketPrice);
                    $this->_aDiscountedVats[$oBasketPrice->getVat()] += $oBasketPrice->getVatValue();
                } else {
                    $this->_oNotDiscountedProductsPriceList->addToPriceList($oBasketPrice);
                    $oBasketItem->setSkipDiscounts(true);
                    $this->setSkipDiscounts(true);
                }
            } elseif ($oBasketItem->isBundle()) {
                // if bundles price is set to zero
                $oPrice = $this->d3GetPrice();
                $oBasketItem->setPrice($oPrice);
            }
        }
    }

    /**
     * @return Price
     * @throws Exception
     */
    public function d3GetPrice()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.Price::class);
    }

    /**
     * @param Order $oOrder
     * @return Price
     * @throws Exception
     */
    protected function _calcPaymentCost4OrderManager($oOrder)
    {
        $oPaymentPrice = $this->d3GetPrice();
        $oPaymentPrice->setBruttoPriceMode();
        $oPaymentPrice->setPrice($oOrder->getFieldData('oxpaycost'));

        return $oPaymentPrice;
    }

    /**
     * @param Order $oOrder
     */
    protected function _calcBasketDiscount4OrderManager($oOrder)
    {
        $oDiscount = new stdClass();
        $oDiscount->sOXID     = 'stdDiscount';
        $oDiscount->sDiscount = 'RabattText';
        $oDiscount->sType     = 'abs';
        $oDiscount->dDiscount     = $oOrder->getFieldData('oxdiscount');
        $oDiscount->fDiscount     = $oOrder->getFieldData('oxdiscount');

        $this->_aDiscounts = array($oDiscount);

        if (false == is_array($this->_aDiscountedVats)) {
            $this->_aDiscountedVats = array(
                '0' => 0
            );
        }
    }

    /**
     * @return array
     */
    public function d3GetDiscounts()
    {
        return $this->_aDiscounts;
    }

    /**
     * @return array
     */
    public function d3GetDiscountedVats()
    {
        return $this->_aDiscountedVats;
    }
}
