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

namespace D3\Ordermanager\tests\unit\Modules\Application\Model;

use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager;
use D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\BasketItem;
use OxidEsales\Eshop\Application\Model\Discount;
use OxidEsales\Eshop\Application\Model\DiscountList;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Price;
use OxidEsales\Eshop\Core\PriceList;
use OxidEsales\Eshop\Core\Session;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;

class d3_oxbasket_ordermanagerTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_oxbasket_ordermanager */
    protected $_oModel;

    /**
     * setup basic requirements
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws Exception
     */
    public function setUp()
    {
        parent::setUp();

        $this->_oModel = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Basket::class);
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->_oModel);
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::d3getOrderManagerBasketItemInstance
     * @test
     * @throws ReflectionException
     */
    public function getBasketItemReturnsRightInstance()
    {
        $this->assertInstanceOf(
            BasketItem::class,
            $this->callMethod(
                $this->_oModel,
                'd3getOrderManagerBasketItemInstance'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::addOrderArticleToBasket4OrderManager
     * @test
     * @throws ReflectionException
     */
    public function orderArticleCanAddToBasket()
    {
        /** @var OrderArticle|MockObject $oOrderArticleMock */
        $oOrderArticleMock = $this->getMockBuilder(OrderArticle::class)
            ->setMethods([
                'getFieldData',
                'getId'
            ])
            ->getMock();
        $oOrderArticleMock->method('getFieldData')->willReturn(2);
        $oOrderArticleMock->method('getId')->willReturn(md5('newId'));

        /** @var BasketItem|MockObject $oBasketItemMock */
        $oBasketItemMock = $this->getMockBuilder(BasketItem::class)
            ->setMethods([
                'setStockCheckStatus',
                'initFromOrderArticle',
                'setPrice',
                'setWrapping',
                'setBundle',
                'd3OrderManagerChangeOrderArticle2RealArticle',
                'setAmount'
            ])
            ->getMock();
        $oBasketItemMock->method('setStockCheckStatus')->willReturn(true);
        $oBasketItemMock->expects($this->once())->method('initFromOrderArticle')->willReturn(true);
        $oBasketItemMock->expects($this->once())->method('setPrice')->willReturn(true);
        $oBasketItemMock->method('setWrapping')->willReturn(true);
        $oBasketItemMock->method('setBundle')->willReturn(true);
        $oBasketItemMock->expects($this->any())->method('setAmount')->willReturn(true);
        $oBasketItemMock->expects($this->once())->method('d3OrderManagerChangeOrderArticle2RealArticle')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Basket::class)
            ->setMethods([
                'd3getOrderManagerBasketItemInstance',
                'onUpdate'
            ])
            ->getMock();
        $oModelMock->method('d3getOrderManagerBasketItemInstance')->willReturn($oBasketItemMock);
        $oModelMock->expects($this->once())->method('onUpdate')->willReturn(true);
        $this->_oModel = $oModelMock;

        $this->callMethod($this->_oModel, 'addOrderArticleToBasket4OrderManager', array($oOrderArticleMock));
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::d3GetOrderManagerConfig
     * @test
     * @throws ReflectionException
     */
    public function d3GetOrderManagerConfigIsRightInstance()
    {
        $this->assertInstanceOf(
            Config::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetOrderManagerConfig'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::d3GetOrderManagerSession
     * @test
     * @throws ReflectionException
     */
    public function d3GetOrderManagerSessionIsRightInstance()
    {
        $this->assertInstanceOf(
            Session::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetOrderManagerSession'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::addOrderArticleToBasket4OrderManager
     * @test
     * @throws ReflectionException
     */
    public function emptyOorderArticleCannotAddToBasket()
    {
        /** @var OrderArticle|MockObject $oOrderArticleMock */
        $oOrderArticleMock = $this->getMockBuilder(OrderArticle::class)
            ->setMethods([
                'getFieldData',
                'getId'
            ])
            ->getMock();
        $oOrderArticleMock->method('getFieldData')->willReturn(0);
        $oOrderArticleMock->method('getId')->willReturn(md5('newId'));

        /** @var BasketItem|MockObject $oBasketItemMock */
        $oBasketItemMock = $this->getMockBuilder(BasketItem::class)
            ->setMethods([
                'setStockCheckStatus',
                'initFromOrderArticle',
                'setPrice',
                'setWrapping',
                'setBundle',
                'd3OrderManagerChangeOrderArticle2RealArticle'
            ])
            ->getMock();
        $oBasketItemMock->method('setStockCheckStatus')->willReturn(true);
        $oBasketItemMock->expects($this->never())->method('initFromOrderArticle')->willReturn(true);
        $oBasketItemMock->expects($this->never())->method('setPrice')->willReturn(true);
        $oBasketItemMock->method('setWrapping')->willReturn(true);
        $oBasketItemMock->method('setBundle')->willReturn(true);
        $oBasketItemMock->expects($this->never())->method('d3OrderManagerChangeOrderArticle2RealArticle')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Basket::class)
            ->setMethods([
                'd3getOrderManagerBasketItemInstance',
                'onUpdate'
            ])
            ->getMock();
        $oModelMock->method('d3getOrderManagerBasketItemInstance')->willReturn($oBasketItemMock);
        $oModelMock->expects($this->never())->method('onUpdate')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod($this->_oModel, 'addOrderArticleToBasket4OrderManager', array($oOrderArticleMock));
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::calculateBasket4OrderManager
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function calculateBasket4OrderManagerCanStartedEnabledAndUpdateNeededAndUnforced()
    {
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);

        /** @var Session|MockObject $oBasketReservationMock */
        $oBasketReservationMock = $this->getMockBuilder(Session::class)
            ->setMethods(['reserveBasket'])
            ->getMock();
        $oBasketReservationMock->expects($this->once())->method('reserveBasket')->willReturn(true);

        /** @var Session|MockObject $oSessionMock */
        $oSessionMock = $this->getMockBuilder(Session::class)
            ->setMethods(['getBasketReservations'])
            ->getMock();
        $oSessionMock->method('getBasketReservations')->willReturn($oBasketReservationMock);

        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->setMethods(['getConfigParam'])
            ->getMock();
        $oConfigMock->method('getConfigParam')->willReturn(true);

        /** @var Price|MockObject $oPriceMock */
        $oPriceMock = $this->getMockBuilder(Price::class)
            ->setMethods(['setBruttoPriceMode'])
            ->getMock();
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Basket::class)
            ->setMethods([
                'isEnabled',
                'd3GetOrderManagerPriceObject',
                '_save',
                '_clearBundles',
                '_addBundles',
                'd3GetOrderManagerConfig',
                'd3GetOrderManagerSession',
                '_calcItemsPrice4OrderManager',
                '_calcBasketDiscount4OrderManager',
                '_calcBasketTotalDiscount',
                '_calcVoucherDiscount',
                '_applyDiscounts',
                'setCost',
                '_calcDeliveryCost',
                '_calcBasketWrapping',
                '_calcPaymentCost4OrderManager',
                '_calcTotalPrice',
                'formatDiscount',
                'afterUpdate'
            ])
            ->getMock();
        $oModelMock->method('isEnabled')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerPriceObject')->willReturn($oPriceMock);
        $oModelMock->expects($this->once())->method('_save')->willReturn(true);
        $oModelMock->method('_clearBundles')->willReturn(true);
        $oModelMock->method('_addBundles')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetOrderManagerSession')->willReturn($oSessionMock);
        $oModelMock->method('_calcItemsPrice4OrderManager')->willReturn(true);
        $oModelMock->method('_calcBasketDiscount4OrderManager')->willReturn(true);
        $oModelMock->method('_calcBasketTotalDiscount')->willReturn(true);
        $oModelMock->method('_calcVoucherDiscount')->willReturn(true);
        $oModelMock->method('_applyDiscounts')->willReturn(true);
        $oModelMock->method('setCost')->willReturn(true);
        $oModelMock->method('_calcDeliveryCost')->willReturn(true);
        $oModelMock->method('_calcBasketWrapping')->willReturn(true);
        $oModelMock->method('_calcPaymentCost4OrderManager')->willReturn(oxNew(Price::class));
        $oModelMock->expects($this->once())->method('_calcTotalPrice')->willReturn(true);
        $oModelMock->method('formatDiscount')->willReturn(true);
        $oModelMock->method('afterUpdate')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->setValue(
            $this->_oModel,
            '_blUpdateNeeded',
            true
        );

        $this->callMethod(
            $this->_oModel,
            'calculateBasket4OrderManager',
            array(false, $oOrder)
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::calculateBasket4OrderManager
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function calculateBasket4OrderManagerCanStartedDisabled()
    {
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);

        /** @var Session|MockObject $oBasketReservationMock */
        $oBasketReservationMock = $this->getMockBuilder(Session::class)
            ->setMethods(['reserveBasket'])
            ->getMock();
        $oBasketReservationMock->expects($this->never())->method('reserveBasket')->willReturn(true);

        /** @var Session|MockObject $oSessionMock */
        $oSessionMock = $this->getMockBuilder(Session::class)
            ->setMethods(['getBasketReservations'])
            ->getMock();
        $oSessionMock->method('getBasketReservations')->willReturn($oBasketReservationMock);

        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->setMethods(['getConfigParam'])
            ->getMock();
        $oConfigMock->method('getConfigParam')->willReturn(true);

        /** @var Price|MockObject $oPriceMock */
        $oPriceMock = $this->getMockBuilder(Price::class)
            ->setMethods(['setBruttoPriceMode'])
            ->getMock();
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Basket::class)
            ->setMethods([
                'isEnabled',
                'd3GetOrderManagerPriceObject',
                '_save',
                '_clearBundles',
                '_addBundles',
                'd3GetOrderManagerConfig',
                'd3GetOrderManagerSession',
                '_calcItemsPrice4OrderManager',
                '_calcBasketDiscount4OrderManager',
                '_calcBasketTotalDiscount',
                '_calcVoucherDiscount',
                '_applyDiscounts',
                'setCost',
                '_calcDeliveryCost',
                '_calcBasketWrapping',
                '_calcPaymentCost4OrderManager',
                '_calcTotalPrice',
                'formatDiscount',
                'afterUpdate'
            ])
            ->getMock();
        $oModelMock->method('isEnabled')->willReturn(false);
        $oModelMock->method('d3GetOrderManagerPriceObject')->willReturn($oPriceMock);
        $oModelMock->expects($this->never())->method('_save')->willReturn(true);
        $oModelMock->method('_clearBundles')->willReturn(true);
        $oModelMock->method('_addBundles')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetOrderManagerSession')->willReturn($oSessionMock);
        $oModelMock->method('_calcItemsPrice4OrderManager')->willReturn(true);
        $oModelMock->method('_calcBasketDiscount4OrderManager')->willReturn(true);
        $oModelMock->method('_calcBasketTotalDiscount')->willReturn(true);
        $oModelMock->method('_calcVoucherDiscount')->willReturn(true);
        $oModelMock->method('_applyDiscounts')->willReturn(true);
        $oModelMock->method('setCost')->willReturn(true);
        $oModelMock->method('_calcDeliveryCost')->willReturn(true);
        $oModelMock->method('_calcBasketWrapping')->willReturn(true);
        $oModelMock->method('_calcPaymentCost4OrderManager')->willReturn(true);
        $oModelMock->expects($this->never())->method('_calcTotalPrice')->willReturn(true);
        $oModelMock->method('formatDiscount')->willReturn(true);
        $oModelMock->method('afterUpdate')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->setValue(
            $this->_oModel,
            '_blUpdateNeeded',
            true
        );

        $this->callMethod(
            $this->_oModel,
            'calculateBasket4OrderManager',
            array(false, $oOrder)
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::calculateBasket4OrderManager
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function calculateBasket4OrderManagerCanStartedNoUpdate()
    {
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);

        /** @var Session|MockObject $oBasketReservationMock */
        $oBasketReservationMock = $this->getMockBuilder(Session::class)
            ->setMethods(['reserveBasket'])
            ->getMock();
        $oBasketReservationMock->expects($this->never())->method('reserveBasket')->willReturn(true);

        /** @var Session|MockObject $oSessionMock */
        $oSessionMock = $this->getMockBuilder(Session::class)
            ->setMethods(['getBasketReservations'])
            ->getMock();
        $oSessionMock->method('getBasketReservations')->willReturn($oBasketReservationMock);

        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->setMethods(['getConfigParam'])
            ->getMock();
        $oConfigMock->method('getConfigParam')->willReturn(true);

        /** @var Price|MockObject $oPriceMock */
        $oPriceMock = $this->getMockBuilder(Price::class)
            ->setMethods(['setBruttoPriceMode'])
            ->getMock();
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Basket::class)
            ->setMethods([
                'isEnabled',
                'd3GetOrderManagerPriceObject',
                '_save',
                '_clearBundles',
                '_addBundles',
                'd3GetOrderManagerConfig',
                'd3GetOrderManagerSession',
                '_calcItemsPrice4OrderManager',
                '_calcBasketDiscount4OrderManager',
                '_calcBasketTotalDiscount',
                '_calcVoucherDiscount',
                '_applyDiscounts',
                'setCost',
                '_calcDeliveryCost',
                '_calcBasketWrapping',
                '_calcPaymentCost4OrderManager',
                '_calcTotalPrice',
                'formatDiscount',
                'afterUpdate'
            ])
            ->getMock();
        $oModelMock->method('isEnabled')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerPriceObject')->willReturn($oPriceMock);
        $oModelMock->expects($this->never())->method('_save')->willReturn(true);
        $oModelMock->method('_clearBundles')->willReturn(true);
        $oModelMock->method('_addBundles')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetOrderManagerSession')->willReturn($oSessionMock);
        $oModelMock->method('_calcItemsPrice4OrderManager')->willReturn(true);
        $oModelMock->method('_calcBasketDiscount4OrderManager')->willReturn(true);
        $oModelMock->method('_calcBasketTotalDiscount')->willReturn(true);
        $oModelMock->method('_calcVoucherDiscount')->willReturn(true);
        $oModelMock->method('_applyDiscounts')->willReturn(true);
        $oModelMock->method('setCost')->willReturn(true);
        $oModelMock->method('_calcDeliveryCost')->willReturn(true);
        $oModelMock->method('_calcBasketWrapping')->willReturn(true);
        $oModelMock->method('_calcPaymentCost4OrderManager')->willReturn(true);
        $oModelMock->expects($this->never())->method('_calcTotalPrice')->willReturn(true);
        $oModelMock->method('formatDiscount')->willReturn(true);
        $oModelMock->method('afterUpdate')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->setValue(
            $this->_oModel,
            '_blUpdateNeeded',
            false
        );

        $this->callMethod(
            $this->_oModel,
            'calculateBasket4OrderManager',
            array(false, $oOrder)
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::calculateBasket4OrderManager
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function calculateBasket4OrderManagerCanStartedNoUpdateForced()
    {
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);

        /** @var Session|MockObject $oBasketReservationMock */
        $oBasketReservationMock = $this->getMockBuilder(Session::class)
            ->setMethods(['reserveBasket'])
            ->getMock();
        $oBasketReservationMock->expects($this->never())->method('reserveBasket')->willReturn(true);

        /** @var Session|MockObject $oSessionMock */
        $oSessionMock = $this->getMockBuilder(Session::class)
            ->setMethods(['getBasketReservations'])
            ->getMock();
        $oSessionMock->method('getBasketReservations')->willReturn($oBasketReservationMock);

        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->setMethods(['getConfigParam'])
            ->getMock();
        $oConfigMock->method('getConfigParam')->willReturn(false);

        /** @var Price|MockObject $oPriceMock */
        $oPriceMock = $this->getMockBuilder(Price::class)
            ->setMethods(['setBruttoPriceMode'])
            ->getMock();
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Basket::class)
            ->setMethods([
                'isEnabled',
                'd3GetOrderManagerPriceObject',
                '_save',
                '_clearBundles',
                '_addBundles',
                'd3GetOrderManagerConfig',
                'd3GetOrderManagerSession',
                '_calcItemsPrice4OrderManager',
                '_calcBasketDiscount4OrderManager',
                '_calcBasketTotalDiscount',
                '_calcVoucherDiscount',
                '_applyDiscounts',
                'setCost',
                '_calcDeliveryCost',
                '_calcBasketWrapping',
                '_calcPaymentCost4OrderManager',
                '_calcTotalPrice',
                'formatDiscount',
                'afterUpdate'
            ])
            ->getMock();
        $oModelMock->method('isEnabled')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerPriceObject')->willReturn($oPriceMock);
        $oModelMock->expects($this->once())->method('_save')->willReturn(true);
        $oModelMock->method('_clearBundles')->willReturn(true);
        $oModelMock->method('_addBundles')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetOrderManagerSession')->willReturn($oSessionMock);
        $oModelMock->method('_calcItemsPrice4OrderManager')->willReturn(true);
        $oModelMock->method('_calcBasketDiscount4OrderManager')->willReturn(true);
        $oModelMock->method('_calcBasketTotalDiscount')->willReturn(true);
        $oModelMock->method('_calcVoucherDiscount')->willReturn(true);
        $oModelMock->method('_applyDiscounts')->willReturn(true);
        $oModelMock->method('setCost')->willReturn(true);
        $oModelMock->method('_calcDeliveryCost')->willReturn(true);
        $oModelMock->method('_calcBasketWrapping')->willReturn(true);
        $oModelMock->method('_calcPaymentCost4OrderManager')->willReturn(oxNew(Price::class));
        $oModelMock->expects($this->once())->method('_calcTotalPrice')->willReturn(true);
        $oModelMock->method('formatDiscount')->willReturn(true);
        $oModelMock->method('afterUpdate')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->setValue(
            $this->_oModel,
            '_blUpdateNeeded',
            false
        );

        $this->callMethod(
            $this->_oModel,
            'calculateBasket4OrderManager',
            array(true, $oOrder)
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::d3GetOrderManagerPriceList
     * @test
     * @throws ReflectionException
     */
    public function d3GetOrderManagerPriceListReturnsRightInstance()
    {
        $this->assertInstanceOf(
            PriceList::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetOrderManagerPriceList'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::d3GetOrderManagerDiscountList
     * @test
     * @throws ReflectionException
     */
    public function d3GetOrderManagerDiscountListReturnsRightInstance()
    {
        $this->assertInstanceOf(
            DiscountList::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetOrderManagerDiscountList'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::_calcItemsPrice4OrderManager
     * @test
     * @throws ReflectionException
     */
    public function canCalcItemsPrice4OrderManagerNoDiscountedArticleNoSkipDiscounts()
    {
        /** @var Discount|MockObject $oDiscountMock */
        $oDiscountMock = $this->getMockBuilder(Discount::class)
            ->setMethods([
                'getAddSum',
                'getAddSumType'
            ])
            ->getMock();
        $oDiscountMock->method('getAddSum')->willReturn(true);
        $oDiscountMock->method('getAddSumType')->willReturn(true);

        /** @var DiscountList|MockObject $oDiscountListMock */
        $oDiscountListMock = $this->getMockBuilder(DiscountList::class)
            ->setMethods(['getBasketItemDiscounts'])
            ->getMock();
        $oDiscountListMock->method('getBasketItemDiscounts')->willReturn(array(
            'discNo1' => $oDiscountMock
        ));
        
        /** @var Article|MockObject $oArticleMock */
        $oArticleMock = $this->getMockBuilder(Article::class)
            ->setMethods(['skipDiscounts'])
            ->getMock();
        $oArticleMock->method('skipDiscounts')->willReturn(false);
        
        /** @var Price|MockObject $oPriceMock */
        $oPriceMock = $this->getMockBuilder(Price::class)
            ->setMethods([
                'setBruttoPriceMode',
                'setDiscount',
                'calculateDiscount',
                'multiply',
            'getVat',
            'getVatValue'])
            ->getMock();
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);
        $oPriceMock->expects($this->once())->method('setDiscount')->willReturn(true);
        $oPriceMock->expects($this->once())->method('calculateDiscount')->willReturn(true);
        $oPriceMock->method('multiply')->willReturn(true);
        $oPriceMock->method('getVat')->willReturn(true);
        $oPriceMock->method('getVatValue')->willReturn(true);

        /** @var BasketItem|MockObject $oBasketItemMock */
        $oBasketItemMock = $this->getMockBuilder(BasketItem::class)
            ->setMethods([
                'isDiscountArticle',
                'getArticle',
                'isBundle',
                'getUnitPrice',
                'setRegularUnitPrice',
                'setPrice',
                'getPrice',
                'setSkipDiscounts',
                'getAmount'
            ])
            ->getMock();
        $oBasketItemMock->method('isDiscountArticle')->willReturn(false);
        $oBasketItemMock->method('getArticle')->willReturn($oArticleMock);
        $oBasketItemMock->method('isBundle')->willReturn(false);
        $oBasketItemMock->method('getUnitPrice')->willReturn($oPriceMock);
        $oBasketItemMock->expects($this->once())->method('setRegularUnitPrice')->willReturn(true);
        $oBasketItemMock->method('setPrice')->willReturn(true);
        $oBasketItemMock->method('getPrice')->willReturn(true);
        $oBasketItemMock->method('setSkipDiscounts')->willReturn(true);
        $oBasketItemMock->method('getAmount')->willReturn(true);

        /** @var PriceList|MockObject $oPriceListMock */
        $oPriceListMock = $this->getMockBuilder(PriceList::class)
            ->setMethods(['addToPriceList'])
            ->getMock();
        $oPriceListMock->expects($this->exactly(2))->method('addToPriceList')->willReturn(true);
        
        /** @var d3_oxbasket_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Basket::class)
            ->setMethods([
                'setSkipDiscounts',
                'd3GetOrderManagerPriceList',
                'canCalcDiscounts',
                'd3GetOrderManagerDiscountList',
                'getBasketUser',
                'd3GetOrderManagerPriceObject'
            ])
            ->getMock();
        $oModelMock->method('setSkipDiscounts')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerPriceList')->willReturn($oPriceListMock);
        $oModelMock->method('canCalcDiscounts')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerDiscountList')->willReturn($oDiscountListMock);
        $oModelMock->method('getBasketUser')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerPriceObject')->willReturn($oPriceMock);

        $this->_oModel = $oModelMock;
        
        $this->setValue(
            $this->_oModel,
            '_aBasketContents',
            array(
                'itemNo1'   => $oBasketItemMock
            )
        );

        $this->setValue(
            $this->_oModel,
            '_oProductsPriceList',
            $oPriceListMock
        );

        $this->callMethod(
            $this->_oModel,
            '_calcItemsPrice4OrderManager'
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::_calcItemsPrice4OrderManager
     * @test
     * @throws ReflectionException
     */
    public function canCalcItemsPrice4OrderManagerNoDiscountedArticleSkipDiscounts()
    {
        /** @var Discount|MockObject $oDiscountMock */
        $oDiscountMock = $this->getMockBuilder(Discount::class)
            ->setMethods([
                'getAddSum',
                'getAddSumType'
            ])
            ->getMock();
        $oDiscountMock->method('getAddSum')->willReturn(true);
        $oDiscountMock->method('getAddSumType')->willReturn(true);

        /** @var DiscountList|MockObject $oDiscountListMock */
        $oDiscountListMock = $this->getMockBuilder(DiscountList::class)
            ->setMethods(['getBasketItemDiscounts'])
            ->getMock();
        $oDiscountListMock->method('getBasketItemDiscounts')->willReturn(array(
            'discNo1' => $oDiscountMock
        ));

        /** @var Article|MockObject $oArticleMock */
        $oArticleMock = $this->getMockBuilder(Article::class)
            ->setMethods(['skipDiscounts'])
            ->getMock();
        $oArticleMock->method('skipDiscounts')->willReturn(true);

        /** @var Price|MockObject $oPriceMock */
        $oPriceMock = $this->getMockBuilder(Price::class)
            ->setMethods([
                'setBruttoPriceMode',
                'setDiscount',
                'calculateDiscount',
                'multiply',
                'getVat',
                'getVatValue'
            ])
            ->getMock();
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);
        $oPriceMock->method('setDiscount')->willReturn(true);
        $oPriceMock->expects($this->never())->method('calculateDiscount')->willReturn(true);
        $oPriceMock->method('multiply')->willReturn(true);
        $oPriceMock->method('getVat')->willReturn(true);
        $oPriceMock->method('getVatValue')->willReturn(true);

        /** @var BasketItem|MockObject $oBasketItemMock */
        $oBasketItemMock = $this->getMockBuilder(BasketItem::class)
            ->setMethods([
                'isDiscountArticle',
                'getArticle',
                'isBundle',
                'getUnitPrice',
                'setRegularUnitPrice',
                'setPrice',
                'getPrice',
                'setSkipDiscounts',
                'getAmount'
            ])
            ->getMock();
        $oBasketItemMock->method('isDiscountArticle')->willReturn(false);
        $oBasketItemMock->method('getArticle')->willReturn($oArticleMock);
        $oBasketItemMock->method('isBundle')->willReturn(false);
        $oBasketItemMock->method('getUnitPrice')->willReturn($oPriceMock);
        $oBasketItemMock->expects($this->once())->method('setRegularUnitPrice')->willReturn(true);
        $oBasketItemMock->method('setPrice')->willReturn(true);
        $oBasketItemMock->method('getPrice')->willReturn(true);
        $oBasketItemMock->method('setSkipDiscounts')->willReturn(true);
        $oBasketItemMock->method('getAmount')->willReturn(true);

        /** @var PriceList|MockObject $oPriceListMock */
        $oPriceListMock = $this->getMockBuilder(PriceList::class)
            ->setMethods(['addToPriceList'])
            ->getMock();
        $oPriceListMock->expects($this->exactly(2))->method('addToPriceList')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Basket::class)
            ->setMethods([
                'setSkipDiscounts',
                'd3GetOrderManagerPriceList',
                'canCalcDiscounts',
                'd3GetOrderManagerDiscountList',
                'getBasketUser',
                'd3GetOrderManagerPriceObject'
            ])
            ->getMock();
        $oModelMock->expects($this->exactly(3))->method('setSkipDiscounts')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerPriceList')->willReturn($oPriceListMock);
        $oModelMock->method('canCalcDiscounts')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerDiscountList')->willReturn($oDiscountListMock);
        $oModelMock->method('getBasketUser')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerPriceObject')->willReturn($oPriceMock);

        $this->_oModel = $oModelMock;

        $this->setValue(
            $this->_oModel,
            '_aBasketContents',
            array(
                'itemNo1'   => $oBasketItemMock
            )
        );

        $this->setValue(
            $this->_oModel,
            '_oProductsPriceList',
            $oPriceListMock
        );

        $this->callMethod(
            $this->_oModel,
            '_calcItemsPrice4OrderManager'
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::_calcItemsPrice4OrderManager
     * @test
     * @throws ReflectionException
     */
    public function canCalcItemsPrice4OrderManagerBundle()
    {
        /** @var Discount|MockObject $oDiscountMock */
        $oDiscountMock = $this->getMockBuilder(Discount::class)
            ->setMethods([
                'getAddSum',
                'getAddSumType'
            ])
            ->getMock();
        $oDiscountMock->method('getAddSum')->willReturn(true);
        $oDiscountMock->method('getAddSumType')->willReturn(true);

        /** @var DiscountList|MockObject $oDiscountListMock */
        $oDiscountListMock = $this->getMockBuilder(DiscountList::class)
            ->setMethods(['getBasketItemDiscounts'])
            ->getMock();
        $oDiscountListMock->method('getBasketItemDiscounts')->willReturn(array(
            'discNo1' => $oDiscountMock
        ));

        /** @var Article|MockObject $oArticleMock */
        $oArticleMock = $this->getMockBuilder(Article::class)
            ->setMethods(['skipDiscounts'])
            ->getMock();
        $oArticleMock->method('skipDiscounts')->willReturn(true);

        /** @var Price|MockObject $oPriceMock */
        $oPriceMock = $this->getMockBuilder(Price::class)
            ->setMethods([
                'setBruttoPriceMode',
                'setDiscount',
                'calculateDiscount',
                'multiply',
                'getVat',
                'getVatValue'
            ])
            ->getMock();
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);
        $oPriceMock->expects($this->never())->method('setDiscount')->willReturn(true);
        $oPriceMock->expects($this->never())->method('calculateDiscount')->willReturn(true);
        $oPriceMock->method('multiply')->willReturn(true);
        $oPriceMock->method('getVat')->willReturn(true);
        $oPriceMock->method('getVatValue')->willReturn(true);

        /** @var BasketItem|MockObject $oBasketItemMock */
        $oBasketItemMock = $this->getMockBuilder(BasketItem::class)
            ->setMethods([
                'isDiscountArticle',
                'getArticle',
                'isBundle',
                'getUnitPrice',
                'setRegularUnitPrice',
                'setPrice',
                'getPrice',
                'setSkipDiscounts',
                'getAmount'
            ])
            ->getMock();
        $oBasketItemMock->method('isDiscountArticle')->willReturn(true);
        $oBasketItemMock->method('getArticle')->willReturn($oArticleMock);
        $oBasketItemMock->method('isBundle')->willReturn(true);
        $oBasketItemMock->method('getUnitPrice')->willReturn($oPriceMock);
        $oBasketItemMock->expects($this->never())->method('setRegularUnitPrice')->willReturn(true);
        $oBasketItemMock->expects($this->once())->method('setPrice')->willReturn(true);
        $oBasketItemMock->method('getPrice')->willReturn(true);
        $oBasketItemMock->method('setSkipDiscounts')->willReturn(true);
        $oBasketItemMock->method('getAmount')->willReturn(true);

        /** @var PriceList|MockObject $oPriceListMock */
        $oPriceListMock = $this->getMockBuilder(PriceList::class)
            ->setMethods(['addToPriceList'])
            ->getMock();
        $oPriceListMock->expects($this->never())->method('addToPriceList')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Basket::class)
            ->setMethods([
                'setSkipDiscounts',
                'd3GetOrderManagerPriceList',
                'canCalcDiscounts',
                'd3GetOrderManagerDiscountList',
                'getBasketUser',
                'd3GetOrderManagerPriceObject'
            ])
            ->getMock();
        $oModelMock->method('setSkipDiscounts')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerPriceList')->willReturn($oPriceListMock);
        $oModelMock->method('canCalcDiscounts')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerDiscountList')->willReturn($oDiscountListMock);
        $oModelMock->method('getBasketUser')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerPriceObject')->willReturn($oPriceMock);

        $this->_oModel = $oModelMock;

        $this->setValue(
            $this->_oModel,
            '_aBasketContents',
            array(
                'itemNo1'   => $oBasketItemMock
            )
        );

        $this->setValue(
            $this->_oModel,
            '_oProductsPriceList',
            $oPriceListMock
        );

        $this->callMethod(
            $this->_oModel,
            '_calcItemsPrice4OrderManager'
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::d3GetOrderManagerPriceObject
     * @test
     * @throws ReflectionException
     */
    public function d3GetOrderManagerPriceObjectReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Price::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetOrderManagerPriceObject'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::_calcPaymentCost4OrderManager
     * @test
     * @throws ReflectionException
     */
    public function canCalcPaymentCost4OrderManager()
    {
        /** @var d3_oxorder_ordermanager|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->setMethods(['getFieldData'])
            ->getMock();
        $map = [['oxpaycost', 123.45]];
        $oOrderMock->method('getFieldData')->willReturnMap($map);
        
        /** @var Price|MockObject $oPriceMock */
        $oPriceMock = $this->getMockBuilder(Price::class)
            ->setMethods([
                'setBruttoPriceMode',
                'setPrice'
            ])
            ->getMock();
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);
        $oPriceMock->method('setPrice')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Basket::class)
            ->setMethods(['d3GetOrderManagerPriceObject'])
            ->getMock();
        $oModelMock->method('d3GetOrderManagerPriceObject')->willReturn($oPriceMock);

        $this->_oModel = $oModelMock;

        $this->assertInstanceOf(
            Price::class,
            $this->callMethod(
                $this->_oModel,
                '_calcPaymentCost4OrderManager',
                array($oOrderMock)
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::_calcBasketDiscount4OrderManager
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::d3GetOrderManagerDiscountedVats
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::d3GetOrderManagerDiscounts
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function calcBasketDiscount4OrderManagerPass()
    {
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);
        $oOrder->assign(array(
            'oxdiscount' => 3.75,
        ));

        $this->callMethod(
            $this->_oModel,
            '_calcBasketDiscount4OrderManager',
            array($oOrder)
        );

        $aDiscounts = $this->callMethod($this->_oModel, 'd3GetOrderManagerDiscounts');
        $this->assertInternalType('array', $aDiscounts);
        $this->assertCount(1, $aDiscounts);
        $aDiscountedVats = $this->callMethod($this->_oModel, 'd3GetOrderManagerDiscountedVats');
        $this->assertInternalType('array', $aDiscountedVats);
        $this->assertCount(1, $aDiscountedVats);
    }

    /**
     * @param $sLicenseKey
     * @param d3ordermanager $oManager
     * @return null
     */
    protected function _setModuleLicenseKey($sLicenseKey, $oManager = null)
    {
        return null;
    }
}