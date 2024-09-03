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

use D3\Ordermanager\Application\Model\Actions\d3ordermanager_action_moveordertofolder;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_conf;
use D3\Ordermanager\Application\Model\d3ordermanager_configurationcheck;
use D3\Ordermanager\Application\Model\d3ordermanager_execute;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_actionException;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_requirementException;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_smartyException;
use D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use InvoicepdfPDF;
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
use OxidEsales\Eshop\Core\UtilsView;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ShopConfigurationDaoBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Bridge\ModuleActivationBridge;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Bridge\ModuleActivationBridgeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

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
        $oBasketMock = $this->getMockBuilder(Basket::class)
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
        $oModelMock = $this->getMockBuilder(Order::class)
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
        $oBasketMock = $this->getMockBuilder(Basket::class)
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
        $oModelMock = $this->getMockBuilder(Order::class)
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
        $oBasketMock = $this->getMockBuilder(Basket::class)
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
        $oModelMock = $this->getMockBuilder(Order::class)
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3GetOrderManagerPdfHandler
     * @test
     * @throws ReflectionException
     */
    public function d3GetOrderManagerPdfHandlerHasRightInstance()
    {
        $this->assertInstanceOf(
            d3ordermanager_pdfhandler::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetOrderManagerPdfHandler'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3GetOrderManagerInvoicePdf
     * @test
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function d3GetOrderManagerInvoicePdfHasRightInstance()
    {
        $moduleId = 'invoicepdf';

        $container = ContainerFactory::getInstance()->getContainer();
        $shopConfiguration = $container->get(ShopConfigurationDaoBridgeInterface::class)->get();

        // Module isn't installed
        if (false === $shopConfiguration->hasModuleConfiguration($moduleId)) {
            $this->markTestSkipped('no InvoicePdf module installed');
        }

        $shopId = Registry::getConfig()->getShopId();

        /** @var ModuleActivationBridge $moduleActivationBridge */
        $moduleActivationBridge = ContainerFactory::getInstance()->getContainer()->get(ModuleActivationBridgeInterface::class);
        $blIsActive = $moduleActivationBridge->isActive($moduleId, $shopId);

        try {
            if (false == $blIsActive) {
                $moduleActivationBridge->activate($moduleId, $shopId);
            }

            // can't test directly due a PHP 7.4 bug in TCPDF
            /** @var InvoicepdfPDF|MockObject $oInvoicePdfMock */
            $oInvoicePdfMock = $this->getMockBuilder(InvoicepdfPDF::class)
                ->onlyMethods([
                    'setPrintHeader',
                    'open',
                    'output',
                ])
                ->disableOriginalConstructor()
                ->getMock();
            d3GetOxidDIC()->set('d3ox.ordermanager.'.InvoicepdfPDF::class, $oInvoicePdfMock);
            $this->assertSame(
                $oInvoicePdfMock,
                $this->callMethod(
                    $this->_oModel,
                    'd3GetOrderManagerInvoicePdf'
                )
            );
        } catch (Exception $exception) {
            Registry::getLogger()->error($exception->getMessage(), [$exception]);
        } finally {
            if (!$blIsActive) {
                $moduleActivationBridge->deactivate($moduleId, $shopId);
            }
        }
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3OrderManagerGeneratePdf
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canStartGeneratingInvoicePdf()
    {
        $expected = 'returnValue';
        $moduleId = 'invoicepdf';

        $container = ContainerFactory::getInstance()->getContainer();
        $shopConfiguration = $container->get(ShopConfigurationDaoBridgeInterface::class)->get();

        // Module isn't installed
        if (false === $shopConfiguration->hasModuleConfiguration($moduleId)) {
            $this->markTestSkipped('unavailable invoicePdf class');
        }

        /** @var InvoicepdfPDF|MockObject $oInvoicePdfMock */
        $oInvoicePdfMock = $this->getMockBuilder(InvoicepdfPDF::class)
            ->onlyMethods([
                'setPrintHeader',
                'open',
                'output',
            ])
            ->disableOriginalConstructor()
            ->getMock();
        $oInvoicePdfMock->method('setPrintHeader')->willReturn(true);
        $oInvoicePdfMock->method('open')->willReturn(true);
        $oInvoicePdfMock->expects($this->once())->method('output')->willReturn($expected);

        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->onlyMethods(['canGenerateOxidPdf'])
            ->setConstructorArgs([d3GetOxidDIC()->get(d3ordermanager::class), d3GetOxidDIC()->get('d3ox.ordermanager.'.Order::class)])
            ->getMock();
        $oPdfHandlerMock->method('canGenerateOxidPdf')->willReturn(true);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->onlyMethods([
                'getFieldData',
                'setFieldData',
                'getNextBillNum',
                'save',
                'd3GetOrderManagerPdfHandler',
                'd3GetOrderManagerInvoicePdf',
                'pdfHeader',
                'd3OrderManagerGeneratePdfBody',
                'pdfFooter',
            ])
            ->getMock();
        $oModelMock->method('getFieldData')->willReturn(false);
        $oModelMock->expects($this->exactly(2))->method('setFieldData')->willReturn(true);
        $oModelMock->method('getNextBillNum')->willReturn(true);
        $oModelMock->method('save')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerPdfHandler')->willReturn($oPdfHandlerMock);
        $oModelMock->method('d3GetOrderManagerInvoicePdf')->willReturn($oInvoicePdfMock);
        $oModelMock->method('pdfHeader')->willReturn(true);
        $oModelMock->expects($this->once())->method('d3OrderManagerGeneratePdfBody')->willReturn(true);
        $oModelMock->method('pdfFooter')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oModel,
                'd3OrderManagerGeneratePdf',
                ['filename.pdf', 0, d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_INVOICE]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3OrderManagerGeneratePdf
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canStartGeneratingDNotePdf()
    {
        $expected = 'returnValue';
        $moduleId = 'invoicepdf';

        $container = ContainerFactory::getInstance()->getContainer();
        $shopConfiguration = $container->get(ShopConfigurationDaoBridgeInterface::class)->get();

        // Module isn't installed
        if (false === $shopConfiguration->hasModuleConfiguration($moduleId)) {
            $this->markTestSkipped('unavailable invoicePdf class');
        }

        /** @var InvoicepdfPDF|MockObject $oInvoicePdfMock */
        $oInvoicePdfMock = $this->getMockBuilder(InvoicepdfPDF::class)
            ->onlyMethods([
                'setPrintHeader',
                'open',
                'output',
            ])
            ->disableOriginalConstructor()
            ->getMock();
        $oInvoicePdfMock->method('setPrintHeader')->willReturn(true);
        $oInvoicePdfMock->method('open')->willReturn(true);
        $oInvoicePdfMock->expects($this->once())->method('output')->willReturn($expected);

        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->onlyMethods(['canGenerateOxidPdf'])
            ->setConstructorArgs([d3GetOxidDIC()->get(d3ordermanager::class), d3GetOxidDIC()->get('d3ox.ordermanager.'.Order::class)])
            ->getMock();

        $oPdfHandlerMock->method('canGenerateOxidPdf')->willReturn(true);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->onlyMethods([
                'getFieldData',
                'setFieldData',
                'getNextBillNum',
                'save',
                'd3GetOrderManagerPdfHandler',
                'd3GetOrderManagerInvoicePdf',
                'pdfHeader',
                'd3OrderManagerGeneratePdfBody',
                'pdfFooter',
            ])
            ->getMock();
        $oModelMock->method('getFieldData')->willReturn(false);
        $oModelMock->expects($this->exactly(2))->method('setFieldData')->willReturn(true);
        $oModelMock->method('getNextBillNum')->willReturn(true);
        $oModelMock->method('save')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerPdfHandler')->willReturn($oPdfHandlerMock);
        $oModelMock->method('d3GetOrderManagerInvoicePdf')->willReturn($oInvoicePdfMock);
        $oModelMock->method('pdfHeader')->willReturn(true);
        $oModelMock->expects($this->once())->method('d3OrderManagerGeneratePdfBody')->willReturn(true);
        $oModelMock->method('pdfFooter')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oModel,
                'd3OrderManagerGeneratePdf',
                ['filename.pdf', 0, d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_DELIVERYNOTE]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3OrderManagerGeneratePdf
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canStartGeneratingNoPdfGenerator()
    {
        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->onlyMethods(['canGenerateOxidPdf'])
            ->setConstructorArgs([d3GetOxidDIC()->get(d3ordermanager::class), d3GetOxidDIC()->get('d3ox.ordermanager.'.Order::class)])
            ->getMock();

        $oPdfHandlerMock->method('canGenerateOxidPdf')->willReturn(false);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->onlyMethods([
                'getFieldData',
                'getNextBillNum',
                'save',
                'd3GetOrderManagerPdfHandler',
                'd3GetOrderManagerInvoicePdf',
                'pdfHeader',
                'd3OrderManagerGeneratePdfBody',
                'pdfFooter',
            ])
            ->getMock();
        $oModelMock->method('getFieldData')->willReturn(false);
        $oModelMock->method('getNextBillNum')->willReturn(true);
        $oModelMock->method('save')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerPdfHandler')->willReturn($oPdfHandlerMock);
        $oModelMock->method('d3GetOrderManagerInvoicePdf')->willThrowException(oxNew(Exception::class, 'no invoice PDF class available'));
        $oModelMock->method('pdfHeader')->willReturn(true);
        $oModelMock->expects($this->never())->method('d3OrderManagerGeneratePdfBody')->willReturn(true);
        $oModelMock->method('pdfFooter')->willReturn(true);
        $oModelMock->assign([
            'oxorderdate'   => '2020-02-02 02:02:22',
            'oxsenddate'    => '2020-02-02 02:02:22',
        ]);

        $this->_oModel = $oModelMock;

        $this->assertNull(
            $this->callMethod(
                $this->_oModel,
                'd3OrderManagerGeneratePdf',
                ['filename.pdf', 0, d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_DELIVERYNOTE]
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
        /** @var d3ordermanagerlist $managerList */
        $managerList = d3GetOxidDIC()->get(d3ordermanagerlist::class);
        $managerList->offsetSet('no1', oxNew(d3ordermanager::class));
        $managerList->offsetSet('no2', oxNew(d3ordermanager::class));

        /** @var d3ordermanagerlist|MockObject $oOrderManagerListMock */
        $oOrderManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetOrderFinishTriggeredManagerTasks'])
            ->getMock();
        $oOrderManagerListMock->method('d3GetOrderFinishTriggeredManagerTasks')->willReturn($managerList);

        d3GetOxidDIC()->set(d3ordermanagerlist::class, $oOrderManagerListMock);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->onlyMethods([
                'orderMeetsConditions',
                'exec4order',
            ])
            ->setConstructorArgs([oxNew(d3ordermanager::class)])
            ->getMock();
        $oManagerExecuteMock->expects($this->exactly(2))->method('orderMeetsConditions')->willReturn(true);
        $oManagerExecuteMock->expects($this->exactly(2))->method('exec4order');

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->onlyMethods(['d3OrdermanagerGetManagerExecute'])
            ->getMock();
        $oModelMock->method('d3OrdermanagerGetManagerExecute')->willReturn($oManagerExecuteMock);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'finalizeOrder',
            [
                oxNew(Basket::class),
                oxNew(User::class),
            ]
        );
    }

    /**
     * @covers       \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::finalizeOrder
     * @test
     *
     * @param $isAdmin
     *
     * @throws ReflectionException
     * @dataProvider cannotSaveDataProvider
     */
    public function finalizeOrderCantExecuteUnvalidConfiguration($isAdmin)
    {
        /** @var d3ordermanagerlist $managerList */
        $managerList = d3GetOxidDIC()->get(d3ordermanagerlist::class);
        $managerList->offsetSet('no1', oxNew(d3ordermanager::class));
        $managerList->offsetSet('no2', oxNew(d3ordermanager::class));

        /** @var d3ordermanagerlist|MockObject $oOrderManagerListMock */
        $oOrderManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetOrderFinishTriggeredManagerTasks'])
            ->getMock();
        $oOrderManagerListMock->method('d3GetOrderFinishTriggeredManagerTasks')->willReturn($managerList);

        d3GetOxidDIC()->set(d3ordermanagerlist::class, $oOrderManagerListMock);

        /** @var d3ordermanager_requirementException|MockObject $exception */
        $exception = $this->getMockBuilder(d3ordermanager_requirementException::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->onlyMethods([
                'orderMeetsConditions',
                'exec4order',
            ])
            ->setConstructorArgs([oxNew(d3ordermanager::class)])
            ->getMock();
        $oManagerExecuteMock->expects($this->exactly(2))->method('orderMeetsConditions')->willThrowException($exception);
        $oManagerExecuteMock->expects($this->never())->method('exec4order');

        /** @var UtilsView|MockObject $utilsViewMock */
        $utilsViewMock = $this->getMockBuilder(UtilsView::class)
            ->onlyMethods(['addErrorToDisplay'])
            ->getMock();
        $utilsViewMock->expects($isAdmin ? $this->exactly(2) : $this->never())
            ->method('addErrorToDisplay')->willReturn(true);

        d3GetOxidDIC()->set('d3ox.ordermanager.'.UtilsView::class, $utilsViewMock);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->onlyMethods(['d3OrdermanagerGetManagerExecute', 'isAdmin'])
            ->getMock();
        $oModelMock->method('d3OrdermanagerGetManagerExecute')->willReturn($oManagerExecuteMock);
        $oModelMock->method('isAdmin')->willReturn($isAdmin);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'finalizeOrder',
            [
                oxNew(Basket::class),
                oxNew(User::class),
            ]
        );
    }

    /**
     * @covers       \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::finalizeOrder
     * @test
     *
     * @param $isAdmin
     *
     * @throws ReflectionException
     * @dataProvider cannotSaveDataProvider
     */
    public function finalizeOrderCantExecuteFetchingError($isAdmin)
    {
        /** @var d3ordermanagerlist $managerList */
        $managerList = d3GetOxidDIC()->get(d3ordermanagerlist::class);
        $managerList->offsetSet('no1', oxNew(d3ordermanager::class));
        $managerList->offsetSet('no2', oxNew(d3ordermanager::class));

        /** @var d3ordermanagerlist|MockObject $oOrderManagerListMock */
        $oOrderManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetOrderFinishTriggeredManagerTasks'])
            ->getMock();
        $oOrderManagerListMock->method('d3GetOrderFinishTriggeredManagerTasks')->willReturn($managerList);

        d3GetOxidDIC()->set(d3ordermanagerlist::class, $oOrderManagerListMock);

        /** @var d3ordermanager_smartyException|MockObject $exception */
        $exception = $this->getMockBuilder(d3ordermanager_smartyException::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->onlyMethods([
                'orderMeetsConditions',
                'exec4order',
            ])
            ->setConstructorArgs([oxNew(d3ordermanager::class)])
            ->getMock();
        $oManagerExecuteMock->expects($this->exactly(2))->method('orderMeetsConditions')->willThrowException($exception);
        $oManagerExecuteMock->expects($this->never())->method('exec4order');

        /** @var UtilsView|MockObject $utilsViewMock */
        $utilsViewMock = $this->getMockBuilder(UtilsView::class)
            ->onlyMethods(['addErrorToDisplay'])
            ->getMock();
        $utilsViewMock->expects($isAdmin ? $this->exactly(2) : $this->never())
            ->method('addErrorToDisplay')->willReturn(true);

        d3GetOxidDIC()->set('d3ox.ordermanager.'.UtilsView::class, $utilsViewMock);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->onlyMethods(['d3OrdermanagerGetManagerExecute', 'isAdmin'])
            ->getMock();
        $oModelMock->method('d3OrdermanagerGetManagerExecute')->willReturn($oManagerExecuteMock);
        $oModelMock->method('isAdmin')->willReturn($isAdmin);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'finalizeOrder',
            [
                oxNew(Basket::class),
                oxNew(User::class),
            ]
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::save
     * @test
     * @throws ReflectionException
     */
    public function canSave()
    {
        /** @var d3ordermanagerlist $managerList */
        $managerList = d3GetOxidDIC()->get(d3ordermanagerlist::class);
        $managerList->offsetSet('no1', oxNew(d3ordermanager::class));
        $managerList->offsetSet('no2', oxNew(d3ordermanager::class));

        /** @var d3ordermanagerlist|MockObject $oOrderManagerListMock */
        $oOrderManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetOrderSaveTriggeredManagerTasks'])
            ->getMock();
        $oOrderManagerListMock->method('d3GetOrderSaveTriggeredManagerTasks')->willReturn($managerList);

        d3GetOxidDIC()->set(d3ordermanagerlist::class, $oOrderManagerListMock);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->onlyMethods([
                'orderMeetsConditions',
                'exec4order',
            ])
            ->setConstructorArgs([oxNew(d3ordermanager::class)])
            ->getMock();
        $oManagerExecuteMock->expects($this->exactly(2))->method('orderMeetsConditions')->willReturn(true);
        $oManagerExecuteMock->expects($this->exactly(2))->method('exec4order');

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->onlyMethods(['d3OrdermanagerGetManagerExecute'])
            ->getMock();
        $oModelMock->method('d3OrdermanagerGetManagerExecute')->willReturn($oManagerExecuteMock);
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::save
     * @test
     * @param $isAdmin
     * @throws ReflectionException
     * @dataProvider cannotSaveDataProvider
     */
    public function cannotSaveBecauseUnvalidConfiguration($isAdmin)
    {
        /** @var d3ordermanagerlist $managerList */
        $managerList = d3GetOxidDIC()->get(d3ordermanagerlist::class);
        $managerList->offsetSet('no1', oxNew(d3ordermanager::class));
        $managerList->offsetSet('no2', oxNew(d3ordermanager::class));

        /** @var d3ordermanagerlist|MockObject $oOrderManagerListMock */
        $oOrderManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetOrderSaveTriggeredManagerTasks'])
            ->getMock();
        $oOrderManagerListMock->method('d3GetOrderSaveTriggeredManagerTasks')->willReturn($managerList);

        d3GetOxidDIC()->set(d3ordermanagerlist::class, $oOrderManagerListMock);

        /** @var d3ordermanager_requirementException|MockObject $exception */
        $exception = $this->getMockBuilder(d3ordermanager_requirementException::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->onlyMethods([
                'orderMeetsConditions',
                'exec4order',
            ])
            ->setConstructorArgs([oxNew(d3ordermanager::class)])
            ->getMock();
        $oManagerExecuteMock->expects($this->exactly(2))->method('orderMeetsConditions')->willThrowException($exception);
        $oManagerExecuteMock->expects($this->never())->method('exec4order');

        /** @var UtilsView|MockObject $utilsViewMock */
        $utilsViewMock = $this->getMockBuilder(UtilsView::class)
            ->onlyMethods(['addErrorToDisplay'])
            ->getMock();
        $utilsViewMock->expects($isAdmin ? $this->exactly(2) : $this->never())
            ->method('addErrorToDisplay')->willReturn(true);

        d3GetOxidDIC()->set('d3ox.ordermanager.'.UtilsView::class, $utilsViewMock);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->onlyMethods(['d3OrdermanagerGetManagerExecute', 'isAdmin'])
            ->getMock();
        $oModelMock->method('d3OrdermanagerGetManagerExecute')->willReturn($oManagerExecuteMock);
        $oModelMock->method('isAdmin')->willReturn($isAdmin);
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
     * @covers       \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::save
     * @test
     *
     * @param $isAdmin
     *
     * @throws ReflectionException
     * @dataProvider cannotSaveDataProvider
     */
    public function cannotSaveBecauseFetchingError($isAdmin)
    {
        /** @var d3ordermanagerlist $managerList */
        $managerList = d3GetOxidDIC()->get(d3ordermanagerlist::class);
        $managerList->offsetSet('no1', oxNew(d3ordermanager::class));
        $managerList->offsetSet('no2', oxNew(d3ordermanager::class));

        /** @var d3ordermanagerlist|MockObject $oOrderManagerListMock */
        $oOrderManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetOrderSaveTriggeredManagerTasks'])
            ->getMock();
        $oOrderManagerListMock->method('d3GetOrderSaveTriggeredManagerTasks')->willReturn($managerList);

        d3GetOxidDIC()->set(d3ordermanagerlist::class, $oOrderManagerListMock);

        /** @var d3ordermanager_smartyException|MockObject $exception */
        $exception = $this->getMockBuilder(d3ordermanager_smartyException::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->onlyMethods([
                'orderMeetsConditions',
                'exec4order',
            ])
            ->setConstructorArgs([oxNew(d3ordermanager::class)])
            ->getMock();
        $oManagerExecuteMock->expects($this->exactly(2))->method('orderMeetsConditions')->willReturn(true);
        $oManagerExecuteMock->expects($this->exactly(2))->method('exec4order')->willThrowException($exception);

        /** @var UtilsView|MockObject $utilsViewMock */
        $utilsViewMock = $this->getMockBuilder(UtilsView::class)
            ->onlyMethods(['addErrorToDisplay'])
            ->getMock();
        $utilsViewMock->expects($isAdmin ? $this->exactly(2) : $this->never())
            ->method('addErrorToDisplay')->willReturn(true);

        d3GetOxidDIC()->set('d3ox.ordermanager.'.UtilsView::class, $utilsViewMock);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->onlyMethods(['d3OrdermanagerGetManagerExecute', 'isAdmin'])
            ->getMock();
        $oModelMock->method('d3OrdermanagerGetManagerExecute')->willReturn($oManagerExecuteMock);
        $oModelMock->method('isAdmin')->willReturn($isAdmin);
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
     * @return array
     */
    public function cannotSaveDataProvider(): array
    {
        return [
            'is admin'  => [true],
            'is frontend'  => [false],
        ];
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3OrdermanagerGetManagerExecute
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetManagerExecute()
    {
        $oManager = d3GetOxidDIC()->get(d3ordermanager::class);

        $this->assertInstanceOf(
            d3ordermanager_execute::class,
            $this->callMethod(
                $this->_oModel,
                'd3OrdermanagerGetManagerExecute',
                [
                    $oManager,
                ]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3OrderManagerGeneratePdfBody
     * @test
     * @throws ReflectionException
     */
    public function canGeneratePdfBodyInvoice()
    {
        if (false == class_exists('InvoicepdfPDF')) {
            $this->markTestSkipped('unavailable invoicePdf class');
        }

        // can't test directly due a PHP 7.4 bug in TCPDF
        /** @var InvoicepdfPDF|MockObject $oInvoicePdfMock */
        $oInvoicePdfMock = $this->getMockBuilder(InvoicepdfPDF::class)
            ->onlyMethods([
                'setPrintHeader',
                'open',
                'output',
            ])
            ->disableOriginalConstructor()
            ->getMock();

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMockBuilder = $this->getMockBuilder(Order::class);
        foreach (['exportDeliveryNote', 'exportStandart'] as $methodName) {
            method_exists(oxNew(Order::class), $methodName) ?
                $oModelMockBuilder->onlyMethods([$methodName]) :
                $oModelMockBuilder->addMethods([$methodName]);
        }
        $oModelMock = $oModelMockBuilder->getMock();
        $oModelMock->expects($this->never())->method('exportDeliveryNote')->willReturn(true);
        $oModelMock->expects($this->once())->method('exportStandart')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'd3OrderManagerGeneratePdfBody',
            [
                d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_INVOICE,
                $oInvoicePdfMock,
            ]
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3OrderManagerGeneratePdfBody
     * @test
     * @throws ReflectionException
     */
    public function canGeneratePdfBodyDNote()
    {
        if (false == class_exists('InvoicepdfPDF')) {
            $this->markTestSkipped('unavailable invoicePdf class');
        }

        // can't test directly due a PHP 7.4 bug in TCPDF
        /** @var InvoicepdfPDF|MockObject $oInvoicePdfMock */
        $oInvoicePdfMock = $this->getMockBuilder(InvoicepdfPDF::class)
            ->onlyMethods([
                'setPrintHeader',
                'open',
                'output',
            ])
            ->disableOriginalConstructor()
            ->getMock();

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMockBuilder = $this->getMockBuilder(Order::class);
        foreach (['exportDeliveryNote', 'exportStandart'] as $methodName) {
            method_exists(oxNew(Order::class), $methodName) ?
                $oModelMockBuilder->onlyMethods([$methodName]) :
                $oModelMockBuilder->addMethods([$methodName]);
        }
        $oModelMock = $oModelMockBuilder->getMock();
        $oModelMock->expects($this->once())->method('exportDeliveryNote')->willReturn(true);
        $oModelMock->expects($this->never())->method('exportStandart')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'd3OrderManagerGeneratePdfBody',
            [
                d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_DELIVERYNOTE,
                $oInvoicePdfMock,
            ]
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3OrderManagerCheckForConfigurationException
     * @test
     * @param $manuallyCondition
     * @param $expectedCheck
     * @param $throwExc
     * @throws ReflectionException
     * @dataProvider d3OrderManagerCheckForConfigurationExceptionDataProvider
     */
    public function d3OrderManagerCheckForConfigurationExceptionPass($manuallyCondition, $expectedCheck, $throwExc)
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue'])
            ->getMock();
        $getValueMap = [
            ['blGetStornoArticles', false],
            ['sManuallyExecMeetCondition', $manuallyCondition],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3ordermanager_actionException $expectedExc */
        d3GetOxidDIC()->set(d3ordermanager_action_moveordertofolder::class.'.args.ordermanager', $oManagerMock);
        d3GetOxidDIC()->set(d3ordermanager_action_moveordertofolder::class.'.args.order', d3GetOxidDIC()->get('d3ox.ordermanager.'.Order::class));
        d3GetOxidDIC()->set(d3ordermanager_actionException::class.'.args.actionobject', d3GetOxidDIC()->get(d3ordermanager_action_moveordertofolder::class));
        $expectedExc = d3GetOxidDIC()->get(d3ordermanager_actionException::class);

        /** @var d3ordermanager_configurationcheck|MockObject $confCheckMock */
        $confCheckMock = $this->getMockBuilder(d3ordermanager_configurationcheck::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['checkThrowingExceptions'])
            ->getMock();
        $throwExc ?
            $confCheckMock->expects($this->once())->method('checkThrowingExceptions')->with($this->identicalTo($expectedCheck))->willThrowException($expectedExc) :
            $confCheckMock->expects($this->once())->method('checkThrowingExceptions')->with($this->identicalTo($expectedCheck));

        d3GetOxidDIC()->set(d3ordermanager_configurationcheck::class, $confCheckMock);

        if ($throwExc) {
            $this->expectException(get_class($expectedExc));
        }

        $this->callMethod(
            $this->_oModel,
            'd3OrderManagerCheckForConfigurationException',
            [$oManagerMock]
        );
    }

    /**
     * @return array[]
     */
    public function d3OrderManagerCheckForConfigurationExceptionDataProvider(): array
    {
        return [
            'requirements and actions throw exception' => [true, d3ordermanager_configurationcheck::REQUIREMENTS_AND_ACTIONS, true],
            'requirements and actions don\'t throw exception' => [true, d3ordermanager_configurationcheck::REQUIREMENTS_AND_ACTIONS, false],
            'actions only throw exception' => [false, d3ordermanager_configurationcheck::ACTIONS_ONLY, true],
            'actions only don\'t throw exception' => [false, d3ordermanager_configurationcheck::ACTIONS_ONLY, false],
        ];
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
