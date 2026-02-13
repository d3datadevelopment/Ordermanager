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

namespace D3\Ordermanager\tests\unit\Modules\Application\Model;

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\Events\FinalizeOrderEvent;
use D3\Ordermanager\Application\Model\Events\OrderSaveEvent;
use D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager;
use D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Application\Model\Payment;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Application\Model\Voucher;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\Registry;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager
 */
class d3_oxorder_ordermanagerTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_oxorder_ordermanager */
    protected $_oModel;

    /**
     * setup basic requirements
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->_oModel = d3GetOxidDIC()->get('d3ox.ordermanager.'.Order::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->_oModel);
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::__get
     * @test
     * @throws ReflectionException
     */
    public function __getPass()
    {
        $expected = 'testValue';

        $this->_oModel->testProperty = $expected;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oModel,
                '__get',
                ['testProperty']
            )
        );

        $this->assertNull(
            $this->callMethod(
                $this->_oModel,
                '__get',
                ['testUnsetProperty']
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3getBasket4OrderManager
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3setBasket4OrderManager
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canSetAndGetBasket()
    {
        $this->callMethod(
            $this->_oModel,
            'd3setBasket4OrderManager',
            [d3GetOxidDIC()->get('d3ox.ordermanager.'.Basket::class)]
        );

        $this->assertInstanceOf(
            Basket::class,
            $this->callMethod(
                $this->_oModel,
                'd3getBasket4OrderManager'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3getPayment4OrderManager
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3setPayment4OrderManager
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canSetAndGetPayment()
    {
        $this->callMethod(
            $this->_oModel,
            'd3setPayment4OrderManager',
            [d3GetOxidDIC()->get('d3ox.ordermanager.'.Payment::class)]
        );

        $this->assertInstanceOf(
            Payment::class,
            $this->callMethod(
                $this->_oModel,
                'd3getPayment4OrderManager'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3getOrderBasket4OrderManager
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetOrderBasket4OrderManagerWithStornoArticlesNotEmptyList()
    {
        /** @var Voucher|MockObject $oVoucherMock */
        $oVoucherMock = $this->getMockBuilder(Voucher::class)
            ->onlyMethods(['load'])
            ->getMock();
        $oVoucherMock->expects($this->exactly(2))->method('load')->willReturn(true);

        /** @var ListModel|MockObject $oOrderArticleMock */
        $oOrderArticleMock = $this->getMockBuilder(ListModel::class)
            ->onlyMethods(['count'])
            ->getMock();
        $oOrderArticleMock->method('count')->willReturn(5);
        /** @var OrderArticle $oOrderArticle */
        $oOrderArticle = d3GetOxidDIC()->get('d3ox.ordermanager.'.OrderArticle::class);
        $oOrderArticleMock->offsetSet('itemNo1', $oOrderArticle);
        $oOrderArticleMock->offsetSet('itemNo2', $oOrderArticle);
        $oOrderArticleMock->offsetSet('itemNo3', $oOrderArticle);
        $oOrderArticleMock->offsetSet('itemNo4', $oOrderArticle);
        $oOrderArticleMock->offsetSet('itemNo5', $oOrderArticle);

        /** @var Basket|MockObject $oBasketMock */
        $oBasketMock = $this->getMockBuilder(d3_oxbasket_ordermanager::class)
            ->onlyMethods([
                'addOrderArticleToBasket4OrderManager',
                'calculateBasket4OrderManager',
                'getVouchers',
            ])
            ->getMock();
        $oBasketMock->expects($this->exactly(5))->method('addOrderArticleToBasket4OrderManager')->willReturn(true);
        $oBasketMock->expects($this->once())->method('calculateBasket4OrderManager')->willReturn(true);
        $oBasketMock->method('getVouchers')->willReturn([
            'voucherNo1' => 'voucherNo1',
            'voucherNo2' => 'voucherNo2',
        ]);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue'])
            ->getMock();
        $getValueMap = [['blGetStornoArticles', true]];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3_oxorder_ordermanager::class)
            ->onlyMethods([
                'reloadDelivery',
                'reloadDiscount',
                'getOrderBasket',
                'getOrderArticles',
                'd3GetOrderManagerVoucher',
            ])
            ->getMock();
        $oModelMock->method('reloadDelivery')->willReturn(true);
        $oModelMock->method('reloadDiscount')->willReturn(true);
        $oModelMock->expects($this->once())->method('getOrderBasket')->willReturn($oBasketMock);
        $oModelMock->method('d3GetOrderManagerVoucher')->willReturn($oVoucherMock);
        $oModelMock->expects($this->once())->method('getOrderArticles')->with(
            $this->isFalse()
        )->willReturn($oOrderArticleMock);

        $this->_oModel = $oModelMock;

        $this->assertInstanceOf(
            Basket::class,
            $this->callMethod(
                $this->_oModel,
                'd3getOrderBasket4OrderManager',
                [$oManagerMock]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3getOrderBasket4OrderManager
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetOrderBasket4OrderManagerWithoutStornoArticlesNotEmptyList()
    {
        /** @var Voucher|MockObject $oVoucherMock */
        $oVoucherMock = $this->getMockBuilder(Voucher::class)
            ->onlyMethods(['load'])
            ->getMock();
        $oVoucherMock->expects($this->exactly(2))->method('load')->willReturn(true);

        /** @var ListModel|MockObject $oOrderArticleMock */
        $oOrderArticleMock = $this->getMockBuilder(ListModel::class)
            ->onlyMethods(['count'])
            ->getMock();
        $oOrderArticleMock->method('count')->willReturn(5);
        /** @var OrderArticle $oOrderArticle */
        $oOrderArticle = d3GetOxidDIC()->get('d3ox.ordermanager.'.OrderArticle::class);
        $oOrderArticleMock->offsetSet('itemNo1', $oOrderArticle);
        $oOrderArticleMock->offsetSet('itemNo2', $oOrderArticle);
        $oOrderArticleMock->offsetSet('itemNo3', $oOrderArticle);
        $oOrderArticleMock->offsetSet('itemNo4', $oOrderArticle);
        $oOrderArticleMock->offsetSet('itemNo5', $oOrderArticle);

        /** @var Basket|MockObject $oBasketMock */
        $oBasketMock = $this->getMockBuilder(d3_oxbasket_ordermanager::class)
            ->onlyMethods([
                'addOrderArticleToBasket4OrderManager',
                'calculateBasket4OrderManager',
                'getVouchers',
            ])
            ->getMock();
        $oBasketMock->expects($this->exactly(5))->method('addOrderArticleToBasket4OrderManager')->willReturn(true);
        $oBasketMock->expects($this->once())->method('calculateBasket4OrderManager')->willReturn(true);
        $oBasketMock->method('getVouchers')->willReturn([
            'voucherNo1' => 'voucherNo1',
            'voucherNo2' => 'voucherNo2',
        ]);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue'])
            ->getMock();
        $getValueMap = [['blGetStornoArticles', false]];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3_oxorder_ordermanager::class)
            ->onlyMethods([
                'reloadDelivery',
                'reloadDiscount',
                'getOrderBasket',
                'getOrderArticles',
                'd3GetOrderManagerVoucher',
            ])
            ->getMock();
        $oModelMock->method('reloadDelivery')->willReturn(true);
        $oModelMock->method('reloadDiscount')->willReturn(true);
        $oModelMock->expects($this->once())->method('getOrderBasket')->willReturn($oBasketMock);
        $oModelMock->method('d3GetOrderManagerVoucher')->willReturn($oVoucherMock);
        $oModelMock->expects($this->once())->method('getOrderArticles')->with(
            $this->isTrue()
        )->willReturn($oOrderArticleMock);

        $this->_oModel = $oModelMock;

        $this->assertInstanceOf(
            Basket::class,
            $this->callMethod(
                $this->_oModel,
                'd3getOrderBasket4OrderManager',
                [$oManagerMock]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3getOrderBasket4OrderManager
     * @test
     * @throws ReflectionException
     */
    public function canGetOrderBasket4OrderManagerEmptyList()
    {
        /** @var Voucher|MockObject $oVoucherMock */
        $oVoucherMock = $this->getMockBuilder(Voucher::class)
            ->onlyMethods(['load'])
            ->getMock();
        $oVoucherMock->expects($this->exactly(2))->method('load')->willReturn(true);

        /** @var ListModel|MockObject $oOrderArticleMock */
        $oOrderArticleMock = $this->getMockBuilder(ListModel::class)
            ->onlyMethods(['count'])
            ->getMock();
        $oOrderArticleMock->method('count')->willReturn(0);

        /** @var Basket|MockObject $oBasketMock */
        $oBasketMock = $this->getMockBuilder(d3_oxbasket_ordermanager::class)
            ->onlyMethods([
                'addOrderArticleToBasket4OrderManager',
                'calculateBasket4OrderManager',
                'getVouchers',
            ])
            ->getMock();
        $oBasketMock->expects($this->never())->method('addOrderArticleToBasket4OrderManager')->willReturn(true);
        $oBasketMock->expects($this->once())->method('calculateBasket4OrderManager')->willReturn(true);
        $oBasketMock->method('getVouchers')->willReturn([
            'voucherNo1' => 'voucherNo1',
            'voucherNo2' => 'voucherNo2',
        ]);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue'])
            ->getMock();
        $getValueMap = [['blGetStornoArticles', false]];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3_oxorder_ordermanager::class)
            ->onlyMethods([
                'reloadDelivery',
                'reloadDiscount',
                'getOrderBasket',
                'getOrderArticles',
                'd3GetOrderManagerVoucher',
            ])
            ->getMock();
        $oModelMock->method('reloadDelivery')->willReturn(true);
        $oModelMock->method('reloadDiscount')->willReturn(true);
        $oModelMock->expects($this->once())->method('getOrderBasket')->willReturn($oBasketMock);
        $oModelMock->method('d3GetOrderManagerVoucher')->willReturn($oVoucherMock);
        $oModelMock->expects($this->once())->method('getOrderArticles')->with(
            $this->isTrue()
        )->willReturn($oOrderArticleMock);

        $this->_oModel = $oModelMock;

        $this->assertInstanceOf(
            Basket::class,
            $this->callMethod(
                $this->_oModel,
                'd3getOrderBasket4OrderManager',
                [$oManagerMock]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3GetOrderManagerVoucher
     * @test
     * @throws ReflectionException
     */
    public function d3GetOrderManagerVoucherHasRightInstance()
    {
        $this->assertInstanceOf(
            Voucher::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetOrderManagerVoucher'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::finalizeOrder
     * @test
     * @throws ReflectionException
     */
    public function canFinalizeOrder()
    {
        /** @var d3_cfg_mod $oSet */
        $oSet = d3GetOxidDIC()->get('d3.ordermanager.modcfg');
        $oSet->setActive(true);

        $eventDispatcherMock = $this->getMockBuilder(EventDispatcher::class)
            ->onlyMethods(['dispatch'])
            ->getMock();
        $eventDispatcherMock->expects($this->once())->method('dispatch')->with(
            $this->isInstanceOf(FinalizeOrderEvent::class),
        );

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3_oxorder_ordermanager::class)
            ->onlyMethods(['d3GetEventDispatcher'])
            ->getMock();
        $oModelMock->method('d3GetEventDispatcher')->willReturn($eventDispatcherMock);
        $orderId = Registry::getUtilsObject()->generateUId();
        $oModelMock->setId($orderId);
        $oModelMock->assign([
            'oxorderdate'   => '2020-02-02 02:02:22',
            'oxsenddate'    => '2020-02-02 02:02:22',
            'oxbillcompany' => __METHOD__,
        ]);

        $this->callMethod(
            $oModelMock,
            'finalizeOrder',
            [
                oxNew(Basket::class),
                oxNew(User::class),
            ]
        );

        $oModelMock->delete($orderId);
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::save
     * @test
     * @throws ReflectionException
     */
    public function canSave()
    {
        /** @var d3_cfg_mod $oSet */
        $oSet = d3GetOxidDIC()->get('d3.ordermanager.modcfg');
        $oSet->setActive(true);

        $eventDispatcherMock = $this->getMockBuilder(EventDispatcher::class)
            ->onlyMethods(['dispatch'])
            ->getMock();
        $eventDispatcherMock->expects($this->once())->method('dispatch')->with(
            $this->isInstanceOf(OrderSaveEvent::class),
        );

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3_oxorder_ordermanager::class)
            ->onlyMethods(['d3GetEventDispatcher'])
            ->getMock();
        $oModelMock->method('d3GetEventDispatcher')->willReturn($eventDispatcherMock);
        $orderId = Registry::getUtilsObject()->generateUId();
        $oModelMock->setId($orderId);
        $oModelMock->assign([
            'oxorderdate'   => '2020-02-02 02:02:22',
            'oxsenddate'    => '2020-02-02 02:02:22',
            'oxbillcompany' => __METHOD__,
        ]);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'save'
        );

        $oModelMock->delete($orderId);
    }

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3GetEventDispatcher
     */
    public function testd3GetEventDispatcher(): void
    {
        $sut = oxNew(Order::class);

        $this->assertInstanceOf(
            EventDispatcher::class,
            $this->callMethod(
                $sut,
                'd3GetEventDispatcher'
            )
        );
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
