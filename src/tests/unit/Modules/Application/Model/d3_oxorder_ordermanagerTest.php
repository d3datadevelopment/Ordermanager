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

namespace D3\Ordermanager\tests\unit\Modules\Application\Model;

use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_conf;
use D3\Ordermanager\Application\Model\d3ordermanager_execute;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use InvoicepdfPDF;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\Payment;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Application\Model\Voucher;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Model\BaseModel;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ShopConfigurationDaoBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Bridge\ModuleActivationBridge;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Bridge\ModuleActivationBridgeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;
use stdClass;

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
    public function setUp()
    {
        parent::setUp();

        $this->_oModel = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);
    }

    public function tearDown()
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
                array('testProperty')
            )
        );

        $this->assertNull(
            $this->callMethod(
                $this->_oModel,
                '__get',
                array('testUnsetProperty')
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
            array(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Basket::class))
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
            array(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Payment::class))
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
            ->setMethods(['load'])
            ->getMock();
        $oVoucherMock->expects($this->exactly(2))->method('load')->willReturn(true);
        
        /** @var ListModel|MockObject $oOrderArticleMock */
        $oOrderArticleMock = $this->getMockBuilder(ListModel::class)
            ->setMethods(['count'])
            ->getMock();
        $oOrderArticleMock->method('count')->willReturn(5);
        /** @var BaseModel $oBaseModel */
        $oBaseModel = d3GetModCfgDIC()->get('d3ox.ordermanager.'.BaseModel::class);
        $oOrderArticleMock->offsetSet('itemNo1', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo2', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo3', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo4', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo5', $oBaseModel);

        /** @var Basket|MockObject $oBasketMock */
        $oBasketMock = $this->getMockBuilder(Basket::class)
            ->setMethods([
                'addOrderArticleToBasket4OrderManager',
                'calculateBasket4OrderManager',
                'getVouchers'
            ])
            ->getMock();
        $oBasketMock->expects($this->exactly(5))->method('addOrderArticleToBasket4OrderManager')->willReturn(true);
        $oBasketMock->expects($this->once())->method('calculateBasket4OrderManager')->willReturn(true);
        $oBasketMock->method('getVouchers')->willReturn(array(
            'voucherNo1' => 'voucherNo1',
            'voucherNo2' => 'voucherNo2'
        ));

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getValue'])
            ->getMock();
        $getValueMap = [['blGetStornoArticles', true]];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        
        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->setMethods([
                'reloadDelivery',
                'reloadDiscount',
                '_getOrderBasket',
                'getOrderArticles',
                'd3GetOrderManagerVoucher'
            ])
            ->getMock();
        $oModelMock->method('reloadDelivery')->willReturn(true);
        $oModelMock->method('reloadDiscount')->willReturn(true);
        $oModelMock->expects($this->once())->method('_getOrderBasket')->willReturn($oBasketMock);
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
                array($oManagerMock)
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
            ->setMethods(['load'])
            ->getMock();
        $oVoucherMock->expects($this->exactly(2))->method('load')->willReturn(true);

        /** @var ListModel|MockObject $oOrderArticleMock */
        $oOrderArticleMock = $this->getMockBuilder(ListModel::class)
            ->setMethods(['count'])
            ->getMock();
        $oOrderArticleMock->method('count')->willReturn(5);
        /** @var BaseModel $oBaseModel */
        $oBaseModel = d3GetModCfgDIC()->get('d3ox.ordermanager.'.BaseModel::class);
        $oOrderArticleMock->offsetSet('itemNo1', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo2', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo3', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo4', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo5', $oBaseModel);

        /** @var Basket|MockObject $oBasketMock */
        $oBasketMock = $this->getMockBuilder(Basket::class)
            ->setMethods([
                'addOrderArticleToBasket4OrderManager',
                'calculateBasket4OrderManager',
                'getVouchers'
            ])
            ->getMock();
        $oBasketMock->expects($this->exactly(5))->method('addOrderArticleToBasket4OrderManager')->willReturn(true);
        $oBasketMock->expects($this->once())->method('calculateBasket4OrderManager')->willReturn(true);
        $oBasketMock->method('getVouchers')->willReturn(array(
            'voucherNo1' => 'voucherNo1',
            'voucherNo2' => 'voucherNo2'
        ));

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getValue'])
            ->getMock();
        $getValueMap = [['blGetStornoArticles', false]];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->setMethods([
                'reloadDelivery',
                'reloadDiscount',
                '_getOrderBasket',
                'getOrderArticles',
                'd3GetOrderManagerVoucher'
            ])
            ->getMock();
        $oModelMock->method('reloadDelivery')->willReturn(true);
        $oModelMock->method('reloadDiscount')->willReturn(true);
        $oModelMock->expects($this->once())->method('_getOrderBasket')->willReturn($oBasketMock);
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
                array($oManagerMock)
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
            ->setMethods(['load'])
            ->getMock();
        $oVoucherMock->expects($this->exactly(2))->method('load')->willReturn(true);

        /** @var ListModel|MockObject $oOrderArticleMock */
        $oOrderArticleMock = $this->getMockBuilder(ListModel::class)
            ->setMethods(['count'])
            ->getMock();
        $oOrderArticleMock->method('count')->willReturn(0);

        /** @var Basket|MockObject $oBasketMock */
        $oBasketMock = $this->getMockBuilder(Basket::class)
            ->setMethods([
                'addOrderArticleToBasket4OrderManager',
                'calculateBasket4OrderManager',
                'getVouchers'
            ])
            ->getMock();
        $oBasketMock->expects($this->never())->method('addOrderArticleToBasket4OrderManager')->willReturn(true);
        $oBasketMock->expects($this->once())->method('calculateBasket4OrderManager')->willReturn(true);
        $oBasketMock->method('getVouchers')->willReturn(array(
            'voucherNo1' => 'voucherNo1',
            'voucherNo2' => 'voucherNo2'
        ));

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getValue'])
            ->getMock();
        $getValueMap = [['blGetStornoArticles', false]];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->setMethods([
                'reloadDelivery',
                'reloadDiscount',
                '_getOrderBasket',
                'getOrderArticles',
                'd3GetOrderManagerVoucher'
            ])
            ->getMock();
        $oModelMock->method('reloadDelivery')->willReturn(true);
        $oModelMock->method('reloadDiscount')->willReturn(true);
        $oModelMock->expects($this->once())->method('_getOrderBasket')->willReturn($oBasketMock);
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
                array($oManagerMock)
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
     * @throws ReflectionException
     * @throws Exception
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
                $moduleActivationBridge->activate( $moduleId, $shopId);
            }

            // can't test directly due a PHP 7.4 bug in TCPDF
            /** @var invoicepdfPDF|MockObject $oInvoicePdfMock */
            $oInvoicePdfMock = $this->getMockBuilder(invoicepdfPDF::class)
                ->setMethods([
                    'setPrintHeader',
                    'open',
                    'output'
                ])
                ->disableOriginalConstructor()
                ->getMock();
            d3GetModCfgDIC()->set('d3ox.ordermanager.'.InvoicepdfPDF::class, $oInvoicePdfMock);
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
                $moduleActivationBridge->deactivate( $moduleId, $shopId);
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

        /** @var invoicepdfPDF|MockObject $oInvoicePdfMock */
        $oInvoicePdfMock = $this->getMockBuilder(invoicepdfPDF::class)
            ->setMethods([
                'setPrintHeader',
                'open',
                'output'
            ])
            ->disableOriginalConstructor()
            ->getMock();
        $oInvoicePdfMock->method('setPrintHeader')->willReturn(true);
        $oInvoicePdfMock->method('open')->willReturn(true);
        $oInvoicePdfMock->expects($this->once())->method('output')->willReturn($expected);

        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->setMethods(['canGenerateOxidPdf'])
            ->setConstructorArgs([d3GetModCfgDIC()->get(d3ordermanager::class), d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)])
            ->getMock();
        $oPdfHandlerMock->method('canGenerateOxidPdf')->willReturn(true);
        
        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->setMethods([
                'getFieldData',
                '_setFieldData',
                'getNextBillNum',
                'save',
                'd3GetOrderManagerPdfHandler',
                'd3GetOrderManagerInvoicePdf',
                'pdfHeader',
                'd3OrderManagerGeneratePdfBody',
                'pdfFooter'
            ])
            ->getMock();
        $oModelMock->method('getFieldData')->willReturn(false);
        $oModelMock->expects($this->exactly(2))->method('_setFieldData')->willReturn(true);
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
                array('filename.pdf', 0, d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_INVOICE)
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

        /** @var invoicepdfPDF|MockObject $oInvoicePdfMock */
        $oInvoicePdfMock = $this->getMockBuilder(invoicepdfPDF::class)
            ->setMethods([
                'setPrintHeader',
                'open',
                'output'
            ])
            ->disableOriginalConstructor()
            ->getMock();
        $oInvoicePdfMock->method('setPrintHeader')->willReturn(true);
        $oInvoicePdfMock->method('open')->willReturn(true);
        $oInvoicePdfMock->expects($this->once())->method('output')->willReturn($expected);

        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->setMethods(['canGenerateOxidPdf'])
            ->setConstructorArgs([d3GetModCfgDIC()->get(d3ordermanager::class), d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)])
            ->getMock();

        $oPdfHandlerMock->method('canGenerateOxidPdf')->willReturn(true);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->setMethods([
                'getFieldData',
                '_setFieldData',
                'getNextBillNum',
                'save',
                'd3GetOrderManagerPdfHandler',
                'd3GetOrderManagerInvoicePdf',
                'pdfHeader',
                'd3OrderManagerGeneratePdfBody',
                'pdfFooter'
            ])
            ->getMock();
        $oModelMock->method('getFieldData')->willReturn(false);
        $oModelMock->expects($this->exactly(2))->method('_setFieldData')->willReturn(true);
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
                array('filename.pdf', 0, d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_DELIVERYNOTE)
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
        $expected = 'returnValue';

        // use stdClass instead of InvoicepdfPDF, because of possible inactive pdf module
        /** @var stdClass|MockObject $oInvoicePdfMock */
        $oInvoicePdfMock = $this->getMockBuilder(stdClass::class)
            ->setMethods([
                'setPrintHeader',
                'open',
                'output'
            ])
            ->getMock();
        $oInvoicePdfMock->method('setPrintHeader')->willReturn(true);
        $oInvoicePdfMock->method('open')->willReturn(true);
        $oInvoicePdfMock->expects($this->never())->method('output')->willReturn($expected);

        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->setMethods(['canGenerateOxidPdf'])
            ->setConstructorArgs([d3GetModCfgDIC()->get(d3ordermanager::class), d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)])
            ->getMock();

        $oPdfHandlerMock->method('canGenerateOxidPdf')->willReturn(false);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->setMethods([
                'getFieldData',
                '_setFieldData',
                'getNextBillNum',
                'save',
                'd3GetOrderManagerPdfHandler',
                'd3GetOrderManagerInvoicePdf',
                'pdfHeader',
                'd3OrderManagerGeneratePdfBody',
                'pdfFooter'
            ])
            ->getMock();
        $oModelMock->method('getFieldData')->willReturn(false);
        $oModelMock->expects($this->exactly(2))->method('_setFieldData')->willReturn(true);
        $oModelMock->method('getNextBillNum')->willReturn(true);
        $oModelMock->method('save')->willReturn(true);
        $oModelMock->method('d3GetOrderManagerPdfHandler')->willReturn($oPdfHandlerMock);
        $oModelMock->method('d3GetOrderManagerInvoicePdf')->willReturn($oInvoicePdfMock);
        $oModelMock->method('pdfHeader')->willReturn(true);
        $oModelMock->expects($this->never())->method('d3OrderManagerGeneratePdfBody')->willReturn(true);
        $oModelMock->method('pdfFooter')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertNull(
            $this->callMethod(
                $this->_oModel,
                'd3OrderManagerGeneratePdf',
                array('filename.pdf', 0, d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_DELIVERYNOTE)
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
        /** @var d3ordermanagerlist|MockObject $oOrderManagerListMock */
        $oOrderManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->setMethods(['d3GetOrderFinishTriggeredManagerTasks'])
            ->getMock();
        $oOrderManagerListMock->method('d3GetOrderFinishTriggeredManagerTasks')->willReturn(
            [
                oxNew(d3ordermanager::class),
                oxNew(d3ordermanager::class)
            ]
        );

        d3GetModCfgDIC()->set(d3ordermanagerlist::class, $oOrderManagerListMock);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->setMethods([
                'orderMeetsConditions',
                'exec4order'
            ])
            ->setConstructorArgs([oxNew(d3ordermanager::class)])
            ->getMock();
        $oManagerExecuteMock->expects($this->exactly(2))->method('orderMeetsConditions')->willReturn(true);
        $oManagerExecuteMock->expects($this->exactly(2))->method('exec4order')->willReturn(true);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->setMethods(['d3OrdermanagerGetManagerExecute'])
            ->getMock();
        $oModelMock->method('d3OrdermanagerGetManagerExecute')->willReturn($oManagerExecuteMock);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'finalizeOrder',
            array(
                oxNew(Basket::class),
                oxNew(User::class)
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::save
     * @test
     * @throws ReflectionException
     */
    public function canSave()
    {
        /** @var d3ordermanagerlist|MockObject $oOrderManagerListMock */
        $oOrderManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->setMethods(['d3GetOrderSaveTriggeredManagerTasks'])
            ->getMock();
        $oOrderManagerListMock->method('d3GetOrderSaveTriggeredManagerTasks')->willReturn(
            [
                oxNew(d3ordermanager::class),
                oxNew(d3ordermanager::class)
            ]
        );

        d3GetModCfgDIC()->set(d3ordermanagerlist::class, $oOrderManagerListMock);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->setMethods([
                'orderMeetsConditions',
                'exec4order'
            ])
            ->setConstructorArgs([oxNew(d3ordermanager::class)])
            ->getMock();
        $oManagerExecuteMock->expects($this->exactly(2))->method('orderMeetsConditions')->willReturn(true);
        $oManagerExecuteMock->expects($this->exactly(2))->method('exec4order')->willReturn(true);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->setMethods(['d3OrdermanagerGetManagerExecute'])
            ->getMock();
        $oModelMock->method('d3OrdermanagerGetManagerExecute')->willReturn($oManagerExecuteMock);
        $orderId = Registry::getUtilsObject()->generateUId();
        $oModelMock->setId($orderId);
        $oModelMock->assign([
            'oxbillcompany' => __METHOD__
        ]);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'save'
        );

        $oModelMock->delete($orderId);
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3OrdermanagerGetManagerExecute
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetManagerExecute()
    {
        $oManager = d3GetModCfgDIC()->get(d3ordermanager::class);

        $this->assertInstanceOf(
            d3ordermanager_execute::class,
            $this->callMethod(
                $this->_oModel,
                'd3OrdermanagerGetManagerExecute',
                array(
                    $oManager
                )
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
        if (false == class_exists('invoicepdfPDF')) {
            $this->markTestSkipped('unavailable invoicePdf class');
        }

        // can't test directly due a PHP 7.4 bug in TCPDF
        /** @var invoicepdfPDF|MockObject $oInvoicePdfMock */
        $oInvoicePdfMock = $this->getMockBuilder(invoicepdfPDF::class)
            ->setMethods([
                'setPrintHeader',
                'open',
                'output'
            ])
            ->disableOriginalConstructor()
            ->getMock();

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->setMethods([
                'exportDeliveryNote',
                'exportStandart'
            ])
            ->getMock();
        $oModelMock->expects($this->never())->method('exportDeliveryNote')->willReturn(true);
        $oModelMock->expects($this->once())->method('exportStandart')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'd3OrderManagerGeneratePdfBody',
            array(
                d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_INVOICE,
                $oInvoicePdfMock
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::d3OrderManagerGeneratePdfBody
     * @test
     * @throws ReflectionException
     */
    public function canGeneratePdfBodyDNote()
    {
        if (false == class_exists('invoicepdfPDF')) {
            $this->markTestSkipped('unavailable invoicePdf class');
        }

        // can't test directly due a PHP 7.4 bug in TCPDF
        /** @var invoicepdfPDF|MockObject $oInvoicePdfMock */
        $oInvoicePdfMock = $this->getMockBuilder(invoicepdfPDF::class)
            ->setMethods([
                'setPrintHeader',
                'open',
                'output'
            ])
            ->disableOriginalConstructor()
            ->getMock();

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->setMethods([
                'exportDeliveryNote',
                'exportStandart'
            ])
            ->getMock();
        $oModelMock->expects($this->once())->method('exportDeliveryNote')->willReturn(true);
        $oModelMock->expects($this->never())->method('exportStandart')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'd3OrderManagerGeneratePdfBody',
            array(
                d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_DELIVERYNOTE,
                $oInvoicePdfMock
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
