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

namespace D3\Ordermanager\Tests\unit\Modules\Application\Model;

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
use PHPUnit_Framework_MockObject_MockObject;
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
     * @test
     * @throws ReflectionException
     */
    public function getBasketItemReturnsRightInstance()
    {
        $this->assertInstanceOf(
            BasketItem::class,
            $this->callMethod(
                $this->_oModel,
                'getBasketItemInstance'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function orderArticleCanAddToBasket()
    {
        /** @var OrderArticle|PHPUnit_Framework_MockObject_MockObject $oOrderArticleMock */
        $oOrderArticleMock = $this->getMock(OrderArticle::class, array(
            'getFieldData',
            'getId'
        ));
        $oOrderArticleMock->method('getFieldData')->willReturn(2);
        $oOrderArticleMock->method('getId')->willReturn(md5('newId'));

        /** @var BasketItem|PHPUnit_Framework_MockObject_MockObject $oBasketItemMock */
        $oBasketItemMock = $this->getMock(BasketItem::class, array(
            'setStockCheckStatus',
            'initFromOrderArticle',
            'setPrice',
            'setWrapping',
            'setBundle',
            'd3ChangeOrderArticle2RealArticle',
            'setAmount'
        ));
        $oBasketItemMock->method('setStockCheckStatus')->willReturn(true);
        $oBasketItemMock->expects($this->once())->method('initFromOrderArticle')->willReturn(true);
        $oBasketItemMock->expects($this->once())->method('setPrice')->willReturn(true);
        $oBasketItemMock->method('setWrapping')->willReturn(true);
        $oBasketItemMock->method('setBundle')->willReturn(true);
        $oBasketItemMock->expects($this->any())->method('setAmount')->willReturn(true);
        $oBasketItemMock->expects($this->once())->method('d3ChangeOrderArticle2RealArticle')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Basket::class, array(
            'getBasketItemInstance',
            'onUpdate',
        ));
        $oModelMock->method('getBasketItemInstance')->willReturn($oBasketItemMock);
        $oModelMock->expects($this->once())->method('onUpdate')->willReturn(true);
        $this->_oModel = $oModelMock;

        $this->callMethod($this->_oModel, 'addOrderArticleToBasket4OrderManager', array($oOrderArticleMock));
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3GetConfigIsRightInstance()
    {
        $this->assertInstanceOf(
            Config::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetConfig'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3GetSessionIsRightInstance()
    {
        $this->assertInstanceOf(
            Session::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetSession'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function emptyOorderArticleCannotAddToBasket()
    {
        /** @var OrderArticle|PHPUnit_Framework_MockObject_MockObject $oOrderArticleMock */
        $oOrderArticleMock = $this->getMock(OrderArticle::class, array(
            'getFieldData',
            'getId'
        ));
        $oOrderArticleMock->method('getFieldData')->willReturn(0);
        $oOrderArticleMock->method('getId')->willReturn(md5('newId'));

        /** @var BasketItem|PHPUnit_Framework_MockObject_MockObject $oBasketItemMock */
        $oBasketItemMock = $this->getMock(BasketItem::class, array(
            'setStockCheckStatus',
            'initFromOrderArticle',
            'setPrice',
            'setWrapping',
            'setBundle',
            'd3ChangeOrderArticle2RealArticle'
        ));
        $oBasketItemMock->method('setStockCheckStatus')->willReturn(true);
        $oBasketItemMock->expects($this->never())->method('initFromOrderArticle')->willReturn(true);
        $oBasketItemMock->expects($this->never())->method('setPrice')->willReturn(true);
        $oBasketItemMock->method('setWrapping')->willReturn(true);
        $oBasketItemMock->method('setBundle')->willReturn(true);
        $oBasketItemMock->expects($this->never())->method('d3ChangeOrderArticle2RealArticle')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Basket::class, array(
            'getBasketItemInstance',
            'onUpdate',
        ));
        $oModelMock->method('getBasketItemInstance')->willReturn($oBasketItemMock);
        $oModelMock->expects($this->never())->method('onUpdate')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod($this->_oModel, 'addOrderArticleToBasket4OrderManager', array($oOrderArticleMock));
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function calculateBasket4OrderManagerCanStartedEnabledAndUpdateNeededAndUnforced()
    {
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);

        /** @var Session|PHPUnit_Framework_MockObject_MockObject $oBasketReservationMock */
        $oBasketReservationMock = $this->getMock(Session::class, array(
            'reserveBasket',
        ));
        $oBasketReservationMock->expects($this->once())->method('reserveBasket')->willReturn(true);

        /** @var Session|PHPUnit_Framework_MockObject_MockObject $oSessionMock */
        $oSessionMock = $this->getMock(Session::class, array(
            'getBasketReservations',
        ));
        $oSessionMock->method('getBasketReservations')->willReturn($oBasketReservationMock);

        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getConfigParam',
        ));
        $oConfigMock->method('getConfigParam')->willReturn(true);

        /** @var Price|PHPUnit_Framework_MockObject_MockObject $oPriceMock */
        $oPriceMock = $this->getMock(Price::class, array(
            'setBruttoPriceMode',
        ));
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Basket::class, array(
            'isEnabled',
            'd3GetPrice',
            '_save',
            '_clearBundles',
            '_addBundles',
            'd3GetConfig',
            'd3GetSession',
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
            'afterUpdate',
        ));
        $oModelMock->method('isEnabled')->willReturn(true);
        $oModelMock->method('d3GetPrice')->willReturn($oPriceMock);
        $oModelMock->expects($this->once())->method('_save')->willReturn(true);
        $oModelMock->method('_clearBundles')->willReturn(true);
        $oModelMock->method('_addBundles')->willReturn(true);
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetSession')->willReturn($oSessionMock);
        $oModelMock->method('_calcItemsPrice4OrderManager')->willReturn(true);
        $oModelMock->method('_calcBasketDiscount4OrderManager')->willReturn(true);
        $oModelMock->method('_calcBasketTotalDiscount')->willReturn(true);
        $oModelMock->method('_calcVoucherDiscount')->willReturn(true);
        $oModelMock->method('_applyDiscounts')->willReturn(true);
        $oModelMock->method('setCost')->willReturn(true);
        $oModelMock->method('_calcDeliveryCost')->willReturn(true);
        $oModelMock->method('_calcBasketWrapping')->willReturn(true);
        $oModelMock->method('_calcPaymentCost4OrderManager')->willReturn(true);
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
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function calculateBasket4OrderManagerCanStartedDisabled()
    {
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);

        /** @var Session|PHPUnit_Framework_MockObject_MockObject $oBasketReservationMock */
        $oBasketReservationMock = $this->getMock(Session::class, array(
            'reserveBasket',
        ));
        $oBasketReservationMock->expects($this->never())->method('reserveBasket')->willReturn(true);

        /** @var Session|PHPUnit_Framework_MockObject_MockObject $oSessionMock */
        $oSessionMock = $this->getMock(Session::class, array(
            'getBasketReservations',
        ));
        $oSessionMock->method('getBasketReservations')->willReturn($oBasketReservationMock);

        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getConfigParam',
        ));
        $oConfigMock->method('getConfigParam')->willReturn(true);

        /** @var Price|PHPUnit_Framework_MockObject_MockObject $oPriceMock */
        $oPriceMock = $this->getMock(Price::class, array(
            'setBruttoPriceMode',
        ));
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Basket::class, array(
            'isEnabled',
            'd3GetPrice',
            '_save',
            '_clearBundles',
            '_addBundles',
            'd3GetConfig',
            'd3GetSession',
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
            'afterUpdate',
        ));
        $oModelMock->method('isEnabled')->willReturn(false);
        $oModelMock->method('d3GetPrice')->willReturn($oPriceMock);
        $oModelMock->expects($this->never())->method('_save')->willReturn(true);
        $oModelMock->method('_clearBundles')->willReturn(true);
        $oModelMock->method('_addBundles')->willReturn(true);
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetSession')->willReturn($oSessionMock);
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
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function calculateBasket4OrderManagerCanStartedNoUpdate()
    {
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);

        /** @var Session|PHPUnit_Framework_MockObject_MockObject $oBasketReservationMock */
        $oBasketReservationMock = $this->getMock(Session::class, array(
            'reserveBasket',
        ));
        $oBasketReservationMock->expects($this->never())->method('reserveBasket')->willReturn(true);

        /** @var Session|PHPUnit_Framework_MockObject_MockObject $oSessionMock */
        $oSessionMock = $this->getMock(Session::class, array(
            'getBasketReservations',
        ));
        $oSessionMock->method('getBasketReservations')->willReturn($oBasketReservationMock);

        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getConfigParam',
        ));
        $oConfigMock->method('getConfigParam')->willReturn(true);

        /** @var Price|PHPUnit_Framework_MockObject_MockObject $oPriceMock */
        $oPriceMock = $this->getMock(Price::class, array(
            'setBruttoPriceMode',
        ));
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Basket::class, array(
            'isEnabled',
            'd3GetPrice',
            '_save',
            '_clearBundles',
            '_addBundles',
            'd3GetConfig',
            'd3GetSession',
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
            'afterUpdate',
        ));
        $oModelMock->method('isEnabled')->willReturn(true);
        $oModelMock->method('d3GetPrice')->willReturn($oPriceMock);
        $oModelMock->expects($this->never())->method('_save')->willReturn(true);
        $oModelMock->method('_clearBundles')->willReturn(true);
        $oModelMock->method('_addBundles')->willReturn(true);
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetSession')->willReturn($oSessionMock);
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
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function calculateBasket4OrderManagerCanStartedNoUpdateForced()
    {
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);

        /** @var Session|PHPUnit_Framework_MockObject_MockObject $oBasketReservationMock */
        $oBasketReservationMock = $this->getMock(Session::class, array(
            'reserveBasket',
        ));
        $oBasketReservationMock->expects($this->never())->method('reserveBasket')->willReturn(true);

        /** @var Session|PHPUnit_Framework_MockObject_MockObject $oSessionMock */
        $oSessionMock = $this->getMock(Session::class, array(
            'getBasketReservations',
        ));
        $oSessionMock->method('getBasketReservations')->willReturn($oBasketReservationMock);

        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getConfigParam',
        ));
        $oConfigMock->method('getConfigParam')->willReturn(false);

        /** @var Price|PHPUnit_Framework_MockObject_MockObject $oPriceMock */
        $oPriceMock = $this->getMock(Price::class, array(
            'setBruttoPriceMode',
        ));
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Basket::class, array(
            'isEnabled',
            'd3GetPrice',
            '_save',
            '_clearBundles',
            '_addBundles',
            'd3GetConfig',
            'd3GetSession',
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
            'afterUpdate',
        ));
        $oModelMock->method('isEnabled')->willReturn(true);
        $oModelMock->method('d3GetPrice')->willReturn($oPriceMock);
        $oModelMock->expects($this->once())->method('_save')->willReturn(true);
        $oModelMock->method('_clearBundles')->willReturn(true);
        $oModelMock->method('_addBundles')->willReturn(true);
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetSession')->willReturn($oSessionMock);
        $oModelMock->method('_calcItemsPrice4OrderManager')->willReturn(true);
        $oModelMock->method('_calcBasketDiscount4OrderManager')->willReturn(true);
        $oModelMock->method('_calcBasketTotalDiscount')->willReturn(true);
        $oModelMock->method('_calcVoucherDiscount')->willReturn(true);
        $oModelMock->method('_applyDiscounts')->willReturn(true);
        $oModelMock->method('setCost')->willReturn(true);
        $oModelMock->method('_calcDeliveryCost')->willReturn(true);
        $oModelMock->method('_calcBasketWrapping')->willReturn(true);
        $oModelMock->method('_calcPaymentCost4OrderManager')->willReturn(true);
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
     * @test
     * @throws ReflectionException
     */
    public function d3getPriceListReturnsRightInstance()
    {
        $this->assertInstanceOf(
            PriceList::class,
            $this->callMethod(
                $this->_oModel,
                'd3getPriceList'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3GetDiscountListReturnsRightInstance()
    {
        $this->assertInstanceOf(
            DiscountList::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetDiscountList'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canCalcItemsPrice4OrderManagerNoDiscountedArticleNoSkipDiscounts()
    {
        /** @var Discount|PHPUnit_Framework_MockObject_MockObject $oDiscountMock */
        $oDiscountMock = $this->getMock(Discount::class, array(
            'getAddSum',
            'getAddSumType',
        ));
        $oDiscountMock->method('getAddSum')->willReturn(true);
        $oDiscountMock->method('getAddSumType')->willReturn(true);

        /** @var DiscountList|PHPUnit_Framework_MockObject_MockObject $oDiscountListMock */
        $oDiscountListMock = $this->getMock(DiscountList::class, array(
            'getBasketItemDiscounts',
        ));
        $oDiscountListMock->method('getBasketItemDiscounts')->willReturn(array(
            'discNo1' => $oDiscountMock
        ));
        
        /** @var Article|PHPUnit_Framework_MockObject_MockObject $oArticleMock */
        $oArticleMock = $this->getMock(Article::class, array(
            'skipDiscounts',
        ));
        $oArticleMock->method('skipDiscounts')->willReturn(false);
        
        /** @var Price|PHPUnit_Framework_MockObject_MockObject $oPriceMock */
        $oPriceMock = $this->getMock(Price::class, array(
            'setBruttoPriceMode',
            'setDiscount',
            'calculateDiscount',
            'multiply',
            'getVat',
            'getVatValue',
        ));
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);
        $oPriceMock->expects($this->once())->method('setDiscount')->willReturn(true);
        $oPriceMock->expects($this->once())->method('calculateDiscount')->willReturn(true);
        $oPriceMock->method('multiply')->willReturn(true);
        $oPriceMock->method('getVat')->willReturn(true);
        $oPriceMock->method('getVatValue')->willReturn(true);

        /** @var BasketItem|PHPUnit_Framework_MockObject_MockObject $oBasketItemMock */
        $oBasketItemMock = $this->getMock(BasketItem::class, array(
            'isDiscountArticle',
            'getArticle',
            'isBundle',
            'getUnitPrice',
            'setRegularUnitPrice',
            'setPrice',
            'getPrice',
            'setSkipDiscounts',
            'getAmount',
        ));
        $oBasketItemMock->method('isDiscountArticle')->willReturn(false);
        $oBasketItemMock->method('getArticle')->willReturn($oArticleMock);
        $oBasketItemMock->method('isBundle')->willReturn(false);
        $oBasketItemMock->method('getUnitPrice')->willReturn($oPriceMock);
        $oBasketItemMock->expects($this->once())->method('setRegularUnitPrice')->willReturn(true);
        $oBasketItemMock->method('setPrice')->willReturn(true);
        $oBasketItemMock->method('getPrice')->willReturn(true);
        $oBasketItemMock->method('setSkipDiscounts')->willReturn(true);
        $oBasketItemMock->method('getAmount')->willReturn(true);

        /** @var PriceList|PHPUnit_Framework_MockObject_MockObject $oPriceListMock */
        $oPriceListMock = $this->getMock(PriceList::class, array(
            'addToPriceList',
        ));
        $oPriceListMock->expects($this->exactly(2))->method('addToPriceList')->willReturn(true);
        
        /** @var d3_oxbasket_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Basket::class, array(
            'setSkipDiscounts',
            'd3getPriceList',
            'canCalcDiscounts',
            'd3GetDiscountList',
            'getBasketUser',
            'd3GetPrice',
        ));
        $oModelMock->method('setSkipDiscounts')->willReturn(true);
        $oModelMock->method('d3getPriceList')->willReturn($oPriceListMock);
        $oModelMock->method('canCalcDiscounts')->willReturn(true);
        $oModelMock->method('d3GetDiscountList')->willReturn($oDiscountListMock);
        $oModelMock->method('getBasketUser')->willReturn(true);
        $oModelMock->method('d3GetPrice')->willReturn($oPriceMock);

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
     * @test
     * @throws ReflectionException
     */
    public function canCalcItemsPrice4OrderManagerNoDiscountedArticleSkipDiscounts()
    {
        /** @var Discount|PHPUnit_Framework_MockObject_MockObject $oDiscountMock */
        $oDiscountMock = $this->getMock(Discount::class, array(
            'getAddSum',
            'getAddSumType',
        ));
        $oDiscountMock->method('getAddSum')->willReturn(true);
        $oDiscountMock->method('getAddSumType')->willReturn(true);

        /** @var DiscountList|PHPUnit_Framework_MockObject_MockObject $oDiscountListMock */
        $oDiscountListMock = $this->getMock(DiscountList::class, array(
            'getBasketItemDiscounts',
        ));
        $oDiscountListMock->method('getBasketItemDiscounts')->willReturn(array(
            'discNo1' => $oDiscountMock
        ));

        /** @var Article|PHPUnit_Framework_MockObject_MockObject $oArticleMock */
        $oArticleMock = $this->getMock(Article::class, array(
            'skipDiscounts',
        ));
        $oArticleMock->method('skipDiscounts')->willReturn(true);

        /** @var Price|PHPUnit_Framework_MockObject_MockObject $oPriceMock */
        $oPriceMock = $this->getMock(Price::class, array(
            'setBruttoPriceMode',
            'setDiscount',
            'calculateDiscount',
            'multiply',
            'getVat',
            'getVatValue',
        ));
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);
        $oPriceMock->method('setDiscount')->willReturn(true);
        $oPriceMock->expects($this->never())->method('calculateDiscount')->willReturn(true);
        $oPriceMock->method('multiply')->willReturn(true);
        $oPriceMock->method('getVat')->willReturn(true);
        $oPriceMock->method('getVatValue')->willReturn(true);

        /** @var BasketItem|PHPUnit_Framework_MockObject_MockObject $oBasketItemMock */
        $oBasketItemMock = $this->getMock(BasketItem::class, array(
            'isDiscountArticle',
            'getArticle',
            'isBundle',
            'getUnitPrice',
            'setRegularUnitPrice',
            'setPrice',
            'getPrice',
            'setSkipDiscounts',
            'getAmount',
        ));
        $oBasketItemMock->method('isDiscountArticle')->willReturn(false);
        $oBasketItemMock->method('getArticle')->willReturn($oArticleMock);
        $oBasketItemMock->method('isBundle')->willReturn(false);
        $oBasketItemMock->method('getUnitPrice')->willReturn($oPriceMock);
        $oBasketItemMock->expects($this->once())->method('setRegularUnitPrice')->willReturn(true);
        $oBasketItemMock->method('setPrice')->willReturn(true);
        $oBasketItemMock->method('getPrice')->willReturn(true);
        $oBasketItemMock->method('setSkipDiscounts')->willReturn(true);
        $oBasketItemMock->method('getAmount')->willReturn(true);

        /** @var PriceList|PHPUnit_Framework_MockObject_MockObject $oPriceListMock */
        $oPriceListMock = $this->getMock(PriceList::class, array(
            'addToPriceList',
        ));
        $oPriceListMock->expects($this->exactly(2))->method('addToPriceList')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Basket::class, array(
            'setSkipDiscounts',
            'd3getPriceList',
            'canCalcDiscounts',
            'd3GetDiscountList',
            'getBasketUser',
            'd3GetPrice',
        ));
        $oModelMock->expects($this->exactly(3))->method('setSkipDiscounts')->willReturn(true);
        $oModelMock->method('d3getPriceList')->willReturn($oPriceListMock);
        $oModelMock->method('canCalcDiscounts')->willReturn(true);
        $oModelMock->method('d3GetDiscountList')->willReturn($oDiscountListMock);
        $oModelMock->method('getBasketUser')->willReturn(true);
        $oModelMock->method('d3GetPrice')->willReturn($oPriceMock);

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
     * @test
     * @throws ReflectionException
     */
    public function canCalcItemsPrice4OrderManagerBundle()
    {
        /** @var Discount|PHPUnit_Framework_MockObject_MockObject $oDiscountMock */
        $oDiscountMock = $this->getMock(Discount::class, array(
            'getAddSum',
            'getAddSumType',
        ));
        $oDiscountMock->method('getAddSum')->willReturn(true);
        $oDiscountMock->method('getAddSumType')->willReturn(true);

        /** @var DiscountList|PHPUnit_Framework_MockObject_MockObject $oDiscountListMock */
        $oDiscountListMock = $this->getMock(DiscountList::class, array(
            'getBasketItemDiscounts',
        ));
        $oDiscountListMock->method('getBasketItemDiscounts')->willReturn(array(
            'discNo1' => $oDiscountMock
        ));

        /** @var Article|PHPUnit_Framework_MockObject_MockObject $oArticleMock */
        $oArticleMock = $this->getMock(Article::class, array(
            'skipDiscounts',
        ));
        $oArticleMock->method('skipDiscounts')->willReturn(true);

        /** @var Price|PHPUnit_Framework_MockObject_MockObject $oPriceMock */
        $oPriceMock = $this->getMock(Price::class, array(
            'setBruttoPriceMode',
            'setDiscount',
            'calculateDiscount',
            'multiply',
            'getVat',
            'getVatValue',
        ));
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);
        $oPriceMock->expects($this->never())->method('setDiscount')->willReturn(true);
        $oPriceMock->expects($this->never())->method('calculateDiscount')->willReturn(true);
        $oPriceMock->method('multiply')->willReturn(true);
        $oPriceMock->method('getVat')->willReturn(true);
        $oPriceMock->method('getVatValue')->willReturn(true);

        /** @var BasketItem|PHPUnit_Framework_MockObject_MockObject $oBasketItemMock */
        $oBasketItemMock = $this->getMock(BasketItem::class, array(
            'isDiscountArticle',
            'getArticle',
            'isBundle',
            'getUnitPrice',
            'setRegularUnitPrice',
            'setPrice',
            'getPrice',
            'setSkipDiscounts',
            'getAmount',
        ));
        $oBasketItemMock->method('isDiscountArticle')->willReturn(true);
        $oBasketItemMock->method('getArticle')->willReturn($oArticleMock);
        $oBasketItemMock->method('isBundle')->willReturn(true);
        $oBasketItemMock->method('getUnitPrice')->willReturn($oPriceMock);
        $oBasketItemMock->expects($this->never())->method('setRegularUnitPrice')->willReturn(true);
        $oBasketItemMock->expects($this->once())->method('setPrice')->willReturn(true);
        $oBasketItemMock->method('getPrice')->willReturn(true);
        $oBasketItemMock->method('setSkipDiscounts')->willReturn(true);
        $oBasketItemMock->method('getAmount')->willReturn(true);

        /** @var PriceList|PHPUnit_Framework_MockObject_MockObject $oPriceListMock */
        $oPriceListMock = $this->getMock(PriceList::class, array(
            'addToPriceList',
        ));
        $oPriceListMock->expects($this->never())->method('addToPriceList')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Basket::class, array(
            'setSkipDiscounts',
            'd3getPriceList',
            'canCalcDiscounts',
            'd3GetDiscountList',
            'getBasketUser',
            'd3GetPrice',
        ));
        $oModelMock->method('setSkipDiscounts')->willReturn(true);
        $oModelMock->method('d3getPriceList')->willReturn($oPriceListMock);
        $oModelMock->method('canCalcDiscounts')->willReturn(true);
        $oModelMock->method('d3GetDiscountList')->willReturn($oDiscountListMock);
        $oModelMock->method('getBasketUser')->willReturn(true);
        $oModelMock->method('d3GetPrice')->willReturn($oPriceMock);

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
     * @test
     * @throws ReflectionException
     */
    public function d3GetPriceReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Price::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetPrice'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canCalcPaymentCost4OrderManager()
    {
        /** @var d3_oxorder_ordermanager|PHPUnit_Framework_MockObject_MockObject $oOrderMock */
        $oOrderMock = $this->getMock(Order::class, array(
            'getFieldData',
        ));
        $map = [['oxpaycost', 123.45]];
        $oOrderMock->method('getFieldData')->willReturnMap($map);
        
        /** @var Price|PHPUnit_Framework_MockObject_MockObject $oPriceMock */
        $oPriceMock = $this->getMock(Price::class, array(
            'setBruttoPriceMode',
            'setPrice',
        ));
        $oPriceMock->method('setBruttoPriceMode')->willReturn(true);
        $oPriceMock->method('setPrice')->willReturn(true);

        /** @var d3_oxbasket_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Basket::class, array(
            'd3GetPrice',
        ));
        $oModelMock->method('d3GetPrice')->willReturn($oPriceMock);

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

        $aDiscounts = $this->callMethod($this->_oModel, 'd3GetDiscounts');
        $this->assertInternalType('array', $aDiscounts);
        $this->assertCount(1, $aDiscounts);
        $aDiscountedVats = $this->callMethod($this->_oModel, 'd3GetDiscountedVats');
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