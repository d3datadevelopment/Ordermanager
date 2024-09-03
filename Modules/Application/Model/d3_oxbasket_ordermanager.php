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

use Exception;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\BasketReservation;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\BasketItem;
use OxidEsales\Eshop\Application\Model\DiscountList;
use OxidEsales\Eshop\Application\Model\Discount;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Price;
use OxidEsales\Eshop\Core\PriceList;
use OxidEsales\Eshop\Core\Session;
use stdClass;

/**
 * Class d3_oxbasket_ordermanager
 * @package D3\Ordermanager\Modules\Models
 * @mixin Basket
 */
class d3_oxbasket_ordermanager extends d3_oxbasket_ordermanager_parent
{
    public function d3getOrderManagerBasketItemInstance(): d3_oxbasketitem_ordermanager
    {
        /** @var d3_oxbasketitem_ordermanager $basketItem */
        $basketItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.BasketItem::class);
        return $basketItem;
    }

    /**
     * Adds order article to basket (method normally used while recalculating order)
     *
     * @param OrderArticle $oOrderArticle order article to store in basket
     */
    public function addOrderArticleToBasket4OrderManager(OrderArticle $oOrderArticle)
    {
        // adding only if amount > 0
        if ($oOrderArticle->getFieldData('oxamount') > 0) {
            $sItemId = $oOrderArticle->getId();
            //inserting new
            $oBasketItem = $this->d3getOrderManagerBasketItemInstance();
            $oBasketItem->setStockCheckStatus(false);
            $oBasketItem->initFromOrderArticle($oOrderArticle);
            $oBasketItem->setPrice($oOrderArticle->getPrice());
            $oBasketItem->setWrapping($oOrderArticle->getFieldData('oxwrapid'));
            $oBasketItem->setBundle($oOrderArticle->isBundle());
            $oBasketItem->d3OrderManagerChangeOrderArticle2RealArticle();

            $this->_aBasketContents[$sItemId] = $oBasketItem;

            //calling update method
            $this->onUpdate();
        }
    }

    public function d3GetOrderManagerConfig(): Config
    {
        /** @var Config $config */
        $config = d3GetOxidDIC()->get('d3ox.ordermanager.'.Config::class);
        return $config;
    }

    public function d3GetOrderManagerSession(): Session
    {
        /** @var Session $session */
        $session = d3GetOxidDIC()->get('d3ox.ordermanager.'.Session::class);
        return $session;
    }

    /**
     * @param      $oOrder
     * @throws Exception
     */
    public function calculateBasket4OrderManager(bool $blForceUpdate, $oOrder)
    {
        if (!$this->isEnabled()) {
            return;
        }

        if (false == $this->_blUpdateNeeded && false == $blForceUpdate) {
            return;
        }

        $this->_aCosts = [];

        $this->_oPrice = $this->d3GetOrderManagerPriceObject();
        $this->_oPrice->setBruttoPriceMode();

        //  1. saving basket to the database
        $this->save();

        //  2. remove all bundles
        $this->clearBundles();

        //  3. generate bundle items
        $this->addBundles();

        // reserve active basket
        if ($this->d3GetOrderManagerConfig()->getConfigParam('blPsBasketReservationEnabled')) {
            /** @var BasketReservation $oBasketReservation */
            $oBasketReservation = $this->d3GetOrderManagerSession()->getBasketReservations();
            $oBasketReservation->reserveBasket($this);
        }

        //  4. calculating item prices
        $this->_calcItemsPrice4OrderManager();

        //  5. calculating/applying discounts
        $this->_calcBasketDiscount4OrderManager($oOrder);

        //  6. calculating basket total discount
        $this->calcBasketTotalDiscount();

        //  7. check for vouchers
        $this->calcVoucherDiscount();

        //  8. applies all discounts to pricelist
        $this->applyDiscounts();

        //  9. calculating additional costs:
        //  9.1: delivery
        $this->setCost('oxdelivery', $this->calcDeliveryCost());

        //  9.2: adding wrapping costs
        $this->setCost('oxwrapping', $this->calcBasketWrapping());

        //  9.3: adding payment cost
        $this->setCost('oxpayment', $this->_calcPaymentCost4OrderManager($oOrder));

        //  10. calculate total price
        $this->calcTotalPrice();

        //  11. formating discounts
        $this->formatDiscount();

        //  12.setting to up-to-date status
        $this->afterUpdate();
    }

    /**
     * @throws Exception
     */
    public function d3GetOrderManagerPriceList(): PriceList
    {
        /** @var PriceList $priceList */
        $priceList = d3GetOxidDIC()->get('d3ox.ordermanager.'.PriceList::class);
        return $priceList;
    }

    /**
     * @throws Exception
     */
    public function d3GetOrderManagerDiscountList(): DiscountList
    {
        /** @var DiscountList $discountList */
        $discountList = d3GetOxidDIC()->get('d3ox.ordermanager.'.DiscountList::class);
        return $discountList;
    }

    /**
     * @throws Exception
     */
    protected function _calcItemsPrice4OrderManager()
    {
        // resetting
        $this->setSkipDiscounts(false);

        // resetting
        $this->_aItemDiscounts = [];

        $this->_oProductsPriceList = $this->d3GetOrderManagerPriceList();
        $this->_oDiscountProductsPriceList = $this->d3GetOrderManagerPriceList();
        $this->_oNotDiscountedProductsPriceList = $this->d3GetOrderManagerPriceList();

        $oDiscountList = $this->d3GetOrderManagerDiscountList();

        /** @var BasketItem $oBasketItem */
        foreach ($this->_aBasketContents as $oBasketItem) {
            if (!$oBasketItem->isDiscountArticle() && ($oArticle = $oBasketItem->getArticle())) {
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
                    if (false === isset($this->_aDiscountedVats[$oBasketPrice->getVat()])) {
                        $this->_aDiscountedVats[$oBasketPrice->getVat()] = 0;
                    }

                    $this->_aDiscountedVats[$oBasketPrice->getVat()] += $oBasketPrice->getVatValue();
                } else {
                    $this->_oNotDiscountedProductsPriceList->addToPriceList($oBasketPrice);
                    $oBasketItem->setSkipDiscounts(true);
                    $this->setSkipDiscounts(true);
                }
            } elseif ($oBasketItem->isBundle()) {
                // if bundles price is set to zero
                $oPrice = $this->d3GetOrderManagerPriceObject();
                $oBasketItem->setPrice($oPrice);
            }
        }
    }

    /**
     * @throws Exception
     */
    public function d3GetOrderManagerPriceObject(): Price
    {
        /** @var Price $price */
        $price = d3GetOxidDIC()->get('d3ox.ordermanager.'.Price::class);
        return $price;
    }

    /**
     * @throws Exception
     */
    protected function _calcPaymentCost4OrderManager(Order $oOrder): Price
    {
        $oPaymentPrice = $this->d3GetOrderManagerPriceObject();
        $oPaymentPrice->setBruttoPriceMode();
        $oPaymentPrice->setPrice($oOrder->getFieldData('oxpaycost'));

        return $oPaymentPrice;
    }

    protected function _calcBasketDiscount4OrderManager(Order $oOrder)
    {
        $oDiscount = new stdClass();
        $oDiscount->sOXID     = 'stdDiscount';
        $oDiscount->sDiscount = 'RabattText';
        $oDiscount->sType     = 'abs';
        $oDiscount->dDiscount     = $oOrder->getFieldData('oxdiscount');
        $oDiscount->fDiscount     = $oOrder->getFieldData('oxdiscount');

        $this->_aDiscounts = [$oDiscount];

        if (false == is_array($this->_aDiscountedVats)) {
            $this->_aDiscountedVats = [
                '0' => 0,
            ];
        }
    }

    public function d3GetOrderManagerDiscounts(): array
    {
        return $this->_aDiscounts;
    }

    public function d3GetOrderManagerDiscountedVats(): array
    {
        return $this->_aDiscountedVats;
    }
}
