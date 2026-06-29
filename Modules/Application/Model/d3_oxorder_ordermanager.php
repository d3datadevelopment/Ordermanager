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
use D3\Ordermanager\Application\Context\ExecutionMode;
use D3\Ordermanager\Application\Context\ProcessExecutionContext;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\Events\FinalizeOrderEvent;
use D3\Ordermanager\Application\Model\Events\OrderSaveEvent;
use D3\Ordermanager\Application\Model\Events\States\FinalizeOrderEventExecutionState;
use D3\Ordermanager\Application\Model\Events\States\OrderSaveEventExecutionState;
use D3\Ordermanager\Core\ModCfgTrait;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\Payment;
use OxidEsales\Eshop\Application\Model\Voucher;
use OxidEsales\Eshop\Core\Exception\ArticleException;
use OxidEsales\Eshop\Core\Exception\ArticleInputException;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class d3_oxorder_ordermanager extends d3_oxorder_ordermanager_parent
{
    use ModCfgTrait;

    /** @var Payment */
    protected $_oPayment;

    protected $_iSelectedLang;

    public $isFirst = false;

    public $isLast  = false;

    protected ?OrderSaveEventExecutionState $orderSaveEventState = null;

    protected ?FinalizeOrderEventExecutionState $finalizeOrderEventState = null;

    /**
     * @param $sName
     *
     * @return mixed
     */
    public function __get($sName)
    {
        $mContent = parent::__get($sName);

        if (false == $mContent && isset($this->{$sName})) {
            return $this->{$sName};
        }

        return $mContent;
    }

    public function d3setBasket4OrderManager(Basket $oBasket)
    {
        $this->_oBasket = $oBasket;
    }

    public function d3getBasket4OrderManager(): Basket
    {
        return $this->_oBasket;
    }

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
     * @codeCoverageIgnore
     */
    public function d3GetOrderManagerVoucher(): Voucher
    {
        return oxNew(Voucher::class);
    }

    /**
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
        /** @var d3_oxbasket_ordermanager $oBasket */
        $oBasket = $this->getOrderBasket(false);

        /** @var ListModel $oOrderArticles */
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

        $oSet = $this->d3GetOrderManagerConfig();

        if ($oSet->isActive()) {
            /** @var ProcessExecutionContext $context */
            $context = ContainerFactory::getInstance()->getContainer()->get(ProcessExecutionContext::class);
            if ($context->is(ExecutionMode::default())) {
                $context->setMode(ExecutionMode::finalizeOrder());
            }

            $event = oxNew(FinalizeOrderEvent::class, $this);
            $this->d3GetEventDispatcher()->dispatch($event);

            if ($context->is(ExecutionMode::finalizeOrder())) {
                $context->resetMode();
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

        $oSet = $this->d3GetOrderManagerConfig();

        if ($oSet->isActive()) {
            /** @var ProcessExecutionContext $context */
            $context = ContainerFactory::getInstance()->getContainer()->get(ProcessExecutionContext::class);
            if ($context->is(ExecutionMode::default())) {
                $context->setMode(ExecutionMode::orderSave());
            }

            $event = oxNew(OrderSaveEvent::class, $this);
            $this->d3GetEventDispatcher()->dispatch($event);

            if ($context->is(ExecutionMode::orderSave())) {
                $context->resetMode();
            }
        }

        return $mReturn;
    }

    protected function d3GetEventDispatcher(): EventDispatcherInterface
    {
        return ContainerFactory::getInstance()->getContainer()->get(EventDispatcherInterface::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function d3GetOrderSaveEventState(): OrderSaveEventExecutionState
    {
        if ($this->orderSaveEventState === null) {
            $this->orderSaveEventState = new OrderSaveEventExecutionState();
        }

        return $this->orderSaveEventState;
    }

    /**
     * @codeCoverageIgnore
     */
    public function d3GetFinalizeOrderEventState(): FinalizeOrderEventExecutionState
    {
        if ($this->finalizeOrderEventState === null) {
            $this->finalizeOrderEventState = new FinalizeOrderEventExecutionState();
        }

        return $this->finalizeOrderEventState;
    }
}
