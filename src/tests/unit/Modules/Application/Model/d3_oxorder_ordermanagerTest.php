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
use OxidEsales\Eshop\Core\Module\Module;
use OxidEsales\Eshop\Core\Module\ModuleInstaller;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\UtilsView;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
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
     * @test
     * @throws ReflectionException
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
     * @test
     * @throws ReflectionException
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
     * @test
     * @throws ReflectionException
     */
    public function canGetOrderBasket4OrderManagerWithStornoArticlesNotEmptyList()
    {
        /** @var Voucher|MockObject $oVoucherMock */
        $oVoucherMock = $this->getMock(Voucher::class, array(
            'load',
        ));
        $oVoucherMock->expects($this->exactly(2))->method('load')->willReturn(true);
        
        /** @var ListModel|MockObject $oOrderArticleMock */
        $oOrderArticleMock = $this->getMock(ListModel::class, array(
            'count',
        ));
        $oOrderArticleMock->method('count')->willReturn(5);
        /** @var BaseModel $oBaseModel */
        $oBaseModel = d3GetModCfgDIC()->get('d3ox.ordermanager.'.BaseModel::class);
        $oOrderArticleMock->offsetSet('itemNo1', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo2', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo3', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo4', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo5', $oBaseModel);

        /** @var Basket|MockObject $oBasketMock */
        $oBasketMock = $this->getMock(Basket::class, array(
            'addOrderArticleToBasket4OrderManager',
            'calculateBasket4OrderManager',
            'getVouchers',
        ));
        $oBasketMock->expects($this->exactly(5))->method('addOrderArticleToBasket4OrderManager')->willReturn(true);
        $oBasketMock->expects($this->once())->method('calculateBasket4OrderManager')->willReturn(true);
        $oBasketMock->method('getVouchers')->willReturn(array(
            'voucherNo1' => 'voucherNo1',
            'voucherNo2' => 'voucherNo2'
        ));

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue',
        ));
        $getValueMap = [['blGetStornoArticles', true]];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        
        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMock(Order::class, array(
            'reloadDelivery',
            'reloadDiscount',
            '_getOrderBasket',
            'getOrderArticles',
            'd3GetVoucher',
        ));
        $oModelMock->method('reloadDelivery')->willReturn(true);
        $oModelMock->method('reloadDiscount')->willReturn(true);
        $oModelMock->expects($this->once())->method('_getOrderBasket')->willReturn($oBasketMock);
        $oModelMock->method('d3GetVoucher')->willReturn($oVoucherMock);
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
     * @test
     * @throws ReflectionException
     */
    public function canGetOrderBasket4OrderManagerWithoutStornoArticlesNotEmptyList()
    {
        /** @var Voucher|MockObject $oVoucherMock */
        $oVoucherMock = $this->getMock(Voucher::class, array(
            'load',
        ));
        $oVoucherMock->expects($this->exactly(2))->method('load')->willReturn(true);

        /** @var ListModel|MockObject $oOrderArticleMock */
        $oOrderArticleMock = $this->getMock(ListModel::class, array(
            'count',
        ));
        $oOrderArticleMock->method('count')->willReturn(5);
        /** @var BaseModel $oBaseModel */
        $oBaseModel = d3GetModCfgDIC()->get('d3ox.ordermanager.'.BaseModel::class);
        $oOrderArticleMock->offsetSet('itemNo1', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo2', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo3', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo4', $oBaseModel);
        $oOrderArticleMock->offsetSet('itemNo5', $oBaseModel);

        /** @var Basket|MockObject $oBasketMock */
        $oBasketMock = $this->getMock(Basket::class, array(
            'addOrderArticleToBasket4OrderManager',
            'calculateBasket4OrderManager',
            'getVouchers',
        ));
        $oBasketMock->expects($this->exactly(5))->method('addOrderArticleToBasket4OrderManager')->willReturn(true);
        $oBasketMock->expects($this->once())->method('calculateBasket4OrderManager')->willReturn(true);
        $oBasketMock->method('getVouchers')->willReturn(array(
            'voucherNo1' => 'voucherNo1',
            'voucherNo2' => 'voucherNo2'
        ));

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue',
        ));
        $getValueMap = [['blGetStornoArticles', false]];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMock(Order::class, array(
            'reloadDelivery',
            'reloadDiscount',
            '_getOrderBasket',
            'getOrderArticles',
            'd3GetVoucher',
        ));
        $oModelMock->method('reloadDelivery')->willReturn(true);
        $oModelMock->method('reloadDiscount')->willReturn(true);
        $oModelMock->expects($this->once())->method('_getOrderBasket')->willReturn($oBasketMock);
        $oModelMock->method('d3GetVoucher')->willReturn($oVoucherMock);
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
     * @test
     * @throws ReflectionException
     */
    public function canGetOrderBasket4OrderManagerEmptyList()
    {
        /** @var Voucher|MockObject $oVoucherMock */
        $oVoucherMock = $this->getMock(Voucher::class, array(
            'load',
        ));
        $oVoucherMock->expects($this->exactly(2))->method('load')->willReturn(true);

        /** @var ListModel|MockObject $oOrderArticleMock */
        $oOrderArticleMock = $this->getMock(ListModel::class, array(
            'count',
        ));
        $oOrderArticleMock->method('count')->willReturn(0);

        /** @var Basket|MockObject $oBasketMock */
        $oBasketMock = $this->getMock(Basket::class, array(
            'addOrderArticleToBasket4OrderManager',
            'calculateBasket4OrderManager',
            'getVouchers',
        ));
        $oBasketMock->expects($this->never())->method('addOrderArticleToBasket4OrderManager')->willReturn(true);
        $oBasketMock->expects($this->once())->method('calculateBasket4OrderManager')->willReturn(true);
        $oBasketMock->method('getVouchers')->willReturn(array(
            'voucherNo1' => 'voucherNo1',
            'voucherNo2' => 'voucherNo2'
        ));

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue',
        ));
        $getValueMap = [['blGetStornoArticles', false]];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMock(Order::class, array(
            'reloadDelivery',
            'reloadDiscount',
            '_getOrderBasket',
            'getOrderArticles',
            'd3GetVoucher',
        ));
        $oModelMock->method('reloadDelivery')->willReturn(true);
        $oModelMock->method('reloadDiscount')->willReturn(true);
        $oModelMock->expects($this->once())->method('_getOrderBasket')->willReturn($oBasketMock);
        $oModelMock->method('d3GetVoucher')->willReturn($oVoucherMock);
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
     * @test
     * @throws ReflectionException
     */
    public function d3GetVoucherHasRightInstance()
    {
        $this->assertInstanceOf(
            Voucher::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetVoucher'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3GetPdfHandlerHasRightInstance()
    {
        $this->assertInstanceOf(
            d3ordermanager_pdfhandler::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetPdfHandler'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function d3GetInvoicePdfHasRightInstance()
    {
        $oModule = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Module::class);
        $oModule->load('invoicepdf');
        $oModuleInstaller = d3GetModCfgDIC()->get('d3ox.ordermanager.'.ModuleInstaller::class);
        $oModuleInstaller->activate($oModule);

        $this->assertInstanceOf(
            InvoicepdfPDF::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetInvoicePdf'
            )
        );

        $oModuleInstaller->deactivate($oModule);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canStartGeneratingInvoicePdf()
    {
        $expected = 'returnValue';

        if (false == class_exists('invoicepdfPDF')) {
            $this->markTestSkipped('unavailable invoicePdf class');
        }

        /** @var InvoicepdfPDF|MockObject $oInvoicePdfMock */
        $oInvoicePdfMock = $this->getMockBuilder(InvoicepdfPDF::class)
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
        $oPdfHandlerMock = $this->getMock(d3ordermanager_pdfhandler::class, array(
            'canGenerateOxidPdf',
        ), array(d3GetModCfgDIC()->get(d3ordermanager::class), d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)));
        $oPdfHandlerMock->method('canGenerateOxidPdf')->willReturn(true);
        
        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMock(Order::class, array(
            'getFieldData',
            '_setFieldData',
            'getNextBillNum',
            'save',
            'd3GetPdfHandler',
            'd3GetInvoicePdf',
            'pdfHeader',
            'd3generatePdfBody',
            'pdfFooter',
        ));
        $oModelMock->method('getFieldData')->willReturn(false);
        $oModelMock->expects($this->exactly(2))->method('_setFieldData')->willReturn(true);
        $oModelMock->method('getNextBillNum')->willReturn(true);
        $oModelMock->method('save')->willReturn(true);
        $oModelMock->method('d3GetPdfHandler')->willReturn($oPdfHandlerMock);
        $oModelMock->method('d3GetInvoicePdf')->willReturn($oInvoicePdfMock);
        $oModelMock->method('pdfHeader')->willReturn(true);
        $oModelMock->expects($this->once())->method('d3generatePdfBody')->willReturn(true);
        $oModelMock->method('pdfFooter')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oModel,
                'd3generatePdf',
                array('filename.pdf', 0, d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_INVOICE)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canStartGeneratingDNotePdf()
    {
        $expected = 'returnValue';

        if (false == class_exists('invoicepdfPDF')) {
            $this->markTestSkipped('unavailable invoicePdf class');
        }

        /** @var InvoicepdfPDF|MockObject $oInvoicePdfMock */
        $oInvoicePdfMock = $this->getMockBuilder(InvoicepdfPDF::class)
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
        $oPdfHandlerMock = $this->getMock(d3ordermanager_pdfhandler::class, array(
            'canGenerateOxidPdf',
        ), array(d3GetModCfgDIC()->get(d3ordermanager::class), d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)));
        $oPdfHandlerMock->method('canGenerateOxidPdf')->willReturn(true);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMock(Order::class, array(
            'getFieldData',
            '_setFieldData',
            'getNextBillNum',
            'save',
            'd3GetPdfHandler',
            'd3GetInvoicePdf',
            'pdfHeader',
            'd3generatePdfBody',
            'pdfFooter',
        ));
        $oModelMock->method('getFieldData')->willReturn(false);
        $oModelMock->expects($this->exactly(2))->method('_setFieldData')->willReturn(true);
        $oModelMock->method('getNextBillNum')->willReturn(true);
        $oModelMock->method('save')->willReturn(true);
        $oModelMock->method('d3GetPdfHandler')->willReturn($oPdfHandlerMock);
        $oModelMock->method('d3GetInvoicePdf')->willReturn($oInvoicePdfMock);
        $oModelMock->method('pdfHeader')->willReturn(true);
        $oModelMock->expects($this->once())->method('d3generatePdfBody')->willReturn(true);
        $oModelMock->method('pdfFooter')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oModel,
                'd3generatePdf',
                array('filename.pdf', 0, d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_DELIVERYNOTE)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canStartGeneratingNoPdfGenerator()
    {
        $expected = 'returnValue';

        // use stdClass instead of InvoicepdfPDF, because of possible inactive pdf module
        /** @var stdClass|MockObject $oInvoicePdfMock */
        $oInvoicePdfMock = $this->getMock(stdClass::class, array(
            'setPrintHeader',
            'open',
            'output',
        ));
        $oInvoicePdfMock->method('setPrintHeader')->willReturn(true);
        $oInvoicePdfMock->method('open')->willReturn(true);
        $oInvoicePdfMock->expects($this->never())->method('output')->willReturn($expected);

        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMock(d3ordermanager_pdfhandler::class, array(
            'canGenerateOxidPdf',
        ), array(d3GetModCfgDIC()->get(d3ordermanager::class), d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)));
        $oPdfHandlerMock->method('canGenerateOxidPdf')->willReturn(false);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMock(Order::class, array(
            'getFieldData',
            '_setFieldData',
            'getNextBillNum',
            'save',
            'd3GetPdfHandler',
            'd3GetInvoicePdf',
            'pdfHeader',
            'd3generatePdfBody',
            'pdfFooter',
        ));
        $oModelMock->method('getFieldData')->willReturn(false);
        $oModelMock->expects($this->exactly(2))->method('_setFieldData')->willReturn(true);
        $oModelMock->method('getNextBillNum')->willReturn(true);
        $oModelMock->method('save')->willReturn(true);
        $oModelMock->method('d3GetPdfHandler')->willReturn($oPdfHandlerMock);
        $oModelMock->method('d3GetInvoicePdf')->willReturn($oInvoicePdfMock);
        $oModelMock->method('pdfHeader')->willReturn(true);
        $oModelMock->expects($this->never())->method('d3generatePdfBody')->willReturn(true);
        $oModelMock->method('pdfFooter')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertNull(
            $this->callMethod(
                $this->_oModel,
                'd3generatePdf',
                array('filename.pdf', 0, d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_DELIVERYNOTE)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canFinalizeOrder()
    {
        $oOrderManagerListMock = $this->getMock(d3ordermanagerlist::class, array(
            'd3GetOrderFinishTriggeredManagerTasks'
        ));
        $oOrderManagerListMock->method('d3GetOrderFinishTriggeredManagerTasks')->willReturn(
            [
                oxNew(d3ordermanager::class),
                oxNew(d3ordermanager::class)
            ]
        );

        d3GetModCfgDIC()->set(d3ordermanagerlist::class, $oOrderManagerListMock);

        $oManagerExecuteMock = $this->getMock(d3ordermanager_execute::class, array(
                'orderMeetsConditions',
                'exec4order'
            ),
            array(
                oxNew(d3ordermanager::class)
            )
        );
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::finalizeOrder
     * @test
     * @throws ReflectionException
     * @dataProvider cannotSaveDataProvider
     */
    public function finalizeOrderCantExecuteUnvalidConfiguration($isAdmin)
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

        /** @var d3ordermanager_requirementException|MockObject $exception */
        $exception = $this->getMockBuilder(d3ordermanager_requirementException::class)
            ->disableOriginalConstructor()
            ->setMethods(['debugOut'])
            ->getMock();
        $exception->expects($this->exactly(2))->method('debugOut')->willReturn(true);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->setMethods([
                'orderMeetsConditions',
                'exec4order'
            ])
            ->setConstructorArgs([oxNew(d3ordermanager::class)])
            ->getMock();
        $oManagerExecuteMock->expects($this->exactly(2))->method('orderMeetsConditions')->willThrowException($exception);
        $oManagerExecuteMock->expects($this->never())->method('exec4order')->willReturn(true);

        /** @var UtilsView|MockObject $utilsViewMock */
        $utilsViewMock = $this->getMockBuilder(UtilsView::class)
            ->setMethods(['addErrorToDisplay'])
            ->getMock();
        $utilsViewMock->expects($isAdmin ? $this->exactly(2) : $this->never())
            ->method('addErrorToDisplay')->willReturn(true);

        d3GetModCfgDIC()->set('d3ox.ordermanager.'.UtilsView::class, $utilsViewMock);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->setMethods(['d3OrdermanagerGetManagerExecute', 'isAdmin'])
            ->getMock();
        $oModelMock->method('d3OrdermanagerGetManagerExecute')->willReturn($oManagerExecuteMock);
        $oModelMock->method('isAdmin')->willReturn($isAdmin);

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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::finalizeOrder
     * @test
     * @throws ReflectionException
     * @dataProvider cannotSaveDataProvider
     */
    public function finalizeOrderCantExecuteFetchingError($isAdmin)
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

        /** @var d3ordermanager_smartyException|MockObject $exception */
        $exception = $this->getMockBuilder(d3ordermanager_smartyException::class)
            ->disableOriginalConstructor()
            ->setMethods(['debugOut'])
            ->getMock();
        $exception->expects($this->exactly(2))->method('debugOut')->willReturn(true);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->setMethods([
                'orderMeetsConditions',
                'exec4order'
            ])
            ->setConstructorArgs([oxNew(d3ordermanager::class)])
            ->getMock();
        $oManagerExecuteMock->expects($this->exactly(2))->method('orderMeetsConditions')->willThrowException($exception);
        $oManagerExecuteMock->expects($this->never())->method('exec4order')->willReturn(true);

        /** @var UtilsView|MockObject $utilsViewMock */
        $utilsViewMock = $this->getMockBuilder(UtilsView::class)
            ->setMethods(['addErrorToDisplay'])
            ->getMock();
        $utilsViewMock->expects($isAdmin ? $this->exactly(2) : $this->never())
            ->method('addErrorToDisplay')->willReturn(true);

        d3GetModCfgDIC()->set('d3ox.ordermanager.'.UtilsView::class, $utilsViewMock);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->setMethods(['d3OrdermanagerGetManagerExecute', 'isAdmin'])
            ->getMock();
        $oModelMock->method('d3OrdermanagerGetManagerExecute')->willReturn($oManagerExecuteMock);
        $oModelMock->method('isAdmin')->willReturn($isAdmin);

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
     * @test
     * @throws ReflectionException
     */
    public function canSave()
    {
        $oOrderManagerListMock = $this->getMock(d3ordermanagerlist::class, array(
            'd3GetOrderSaveTriggeredManagerTasks'
        ));
        $oOrderManagerListMock->method('d3GetOrderSaveTriggeredManagerTasks')->willReturn(
            [
                oxNew(d3ordermanager::class),
                oxNew(d3ordermanager::class)
            ]
        );

        d3GetModCfgDIC()->set(d3ordermanagerlist::class, $oOrderManagerListMock);

        $oManagerExecuteMock = $this->getMock(d3ordermanager_execute::class, array(
                'orderMeetsConditions',
                'exec4order'
            ),
            array(
                oxNew(d3ordermanager::class)
            )
        );
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::save
     * @test
     * @param $isAdmin
     * @throws ReflectionException
     * @dataProvider cannotSaveDataProvider
     */
    public function cannotSaveBecauseUnvalidConfiguration($isAdmin)
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

        /** @var d3ordermanager_requirementException|MockObject $exception */
        $exception = $this->getMockBuilder(d3ordermanager_requirementException::class)
            ->disableOriginalConstructor()
            ->setMethods(['debugOut'])
            ->getMock();
        $exception->expects($this->exactly(2))->method('debugOut')->willReturn(true);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->setMethods([
                'orderMeetsConditions',
                'exec4order'
            ])
            ->setConstructorArgs([oxNew(d3ordermanager::class)])
            ->getMock();
        $oManagerExecuteMock->expects($this->exactly(2))->method('orderMeetsConditions')->willThrowException($exception);
        $oManagerExecuteMock->expects($this->never())->method('exec4order')->willReturn(true);

        /** @var UtilsView|MockObject $utilsViewMock */
        $utilsViewMock = $this->getMockBuilder(UtilsView::class)
            ->setMethods(['addErrorToDisplay'])
            ->getMock();
        $utilsViewMock->expects($isAdmin ? $this->exactly(2) : $this->never())
            ->method('addErrorToDisplay')->willReturn(true);

        d3GetModCfgDIC()->set('d3ox.ordermanager.'.UtilsView::class, $utilsViewMock);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->setMethods(['d3OrdermanagerGetManagerExecute', 'isAdmin'])
            ->getMock();
        $oModelMock->method('d3OrdermanagerGetManagerExecute')->willReturn($oManagerExecuteMock);
        $oModelMock->method('isAdmin')->willReturn($isAdmin);
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::save
     * @test
     * @throws ReflectionException
     * @dataProvider cannotSaveDataProvider
     */
    public function cannotSaveBecauseFetchingError($isAdmin)
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

        /** @var d3ordermanager_smartyException|MockObject $exception */
        $exception = $this->getMockBuilder(d3ordermanager_smartyException::class)
            ->disableOriginalConstructor()
            ->setMethods(['debugOut'])
            ->getMock();
        $exception->expects($this->exactly(2))->method('debugOut')->willReturn(true);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->setMethods([
                'orderMeetsConditions',
                'exec4order'
            ])
            ->setConstructorArgs([oxNew(d3ordermanager::class)])
            ->getMock();
        $oManagerExecuteMock->expects($this->exactly(2))->method('orderMeetsConditions')->willReturn(true);
        $oManagerExecuteMock->expects($this->exactly(2))->method('exec4order')->willThrowException($exception);

        /** @var UtilsView|MockObject $utilsViewMock */
        $utilsViewMock = $this->getMockBuilder(UtilsView::class)
            ->setMethods(['addErrorToDisplay'])
            ->getMock();
        $utilsViewMock->expects($isAdmin ? $this->exactly(2) : $this->never())
            ->method('addErrorToDisplay')->willReturn(true);

        d3GetModCfgDIC()->set('d3ox.ordermanager.'.UtilsView::class, $utilsViewMock);

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Order::class)
            ->setMethods(['d3OrdermanagerGetManagerExecute', 'isAdmin'])
            ->getMock();
        $oModelMock->method('d3OrdermanagerGetManagerExecute')->willReturn($oManagerExecuteMock);
        $oModelMock->method('isAdmin')->willReturn($isAdmin);
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
    }

    /**
     * @return array
     */
    public function cannotSaveDataProvider()
    {
        return [
            'is admin'  => [true],
            'is frontend'  => [false],
        ];
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function cand3OrdermanagerGetManagerExecute()
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
     * @test
     * @throws ReflectionException
     */
    public function canGeneratePdfBodyInvoice()
    {
        if (false == class_exists('InvoicepdfPDF')) {
            $this->markTestSkipped('unavailable invoicePdf class');
        }

        $oPDF = oxNew('invoicepdfPDF');

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMock(Order::class, array(
            'exportDeliveryNote',
            'exportStandart',
        ));
        $oModelMock->expects($this->never())->method('exportDeliveryNote')->willReturn(true);
        $oModelMock->expects($this->once())->method('exportStandart')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'd3generatePdfBody',
            array(
                d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_INVOICE,
                $oPDF
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGeneratePdfBodyDNote()
    {
        if (false == class_exists('InvoicepdfPDF')) {
            $this->markTestSkipped('unavailable invoicePdf class');
        }

        $oPDF = oxNew('invoicepdfPDF');

        /** @var d3_oxorder_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMock(Order::class, array(
            'exportDeliveryNote',
            'exportStandart',
        ));
        $oModelMock->expects($this->once())->method('exportDeliveryNote')->willReturn(true);
        $oModelMock->expects($this->never())->method('exportStandart')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'd3generatePdfBody',
            array(
                d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_DELIVERYNOTE,
                $oPDF
            )
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
            ->setMethods(['getValue'])
            ->getMock();
        $getValueMap = [
            ['blGetStornoArticles', false],
            ['sManuallyExecMeetCondition', $manuallyCondition]
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3ordermanager_actionException $expectedExc */
        d3GetModCfgDIC()->set(d3ordermanager_action_moveordertofolder::class.'.args.ordermanager', $oManagerMock);
        d3GetModCfgDIC()->set(d3ordermanager_action_moveordertofolder::class.'.args.order', d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class));
        d3GetModCfgDIC()->set(d3ordermanager_actionException::class.'.args.actionobject', d3GetModCfgDIC()->get(d3ordermanager_action_moveordertofolder::class));
        $expectedExc = d3GetModCfgDIC()->get(d3ordermanager_actionException::class);

        /** @var d3ordermanager_configurationcheck|MockObject $confCheckMock */
        $confCheckMock = $this->getMockBuilder(d3ordermanager_configurationcheck::class)
            ->disableOriginalConstructor()
            ->setMethods(['checkThrowingExceptions'])
            ->getMock();
        $throwExc ?
            $confCheckMock->expects($this->once())->method('checkThrowingExceptions')->willThrowException($expectedExc) :
            $confCheckMock->expects($this->once())->method('checkThrowingExceptions')->willReturn(true);

        d3GetModCfgDIC()->set(d3ordermanager_configurationcheck::class, $confCheckMock);

        if ($throwExc) {
            $this->setExpectedException(get_class($expectedExc));
        }

        $this->callMethod(
            $this->_oModel,
            'd3OrderManagerCheckForConfigurationException',
            [$oManagerMock]
        );

        $this->assertSame(
            $expectedCheck,
            d3GetModCfgDIC()->getParameter(d3ordermanager_configurationcheck::class.'.args.checktypes')
        );
    }

    /**
     * @return array[]
     */
    public function d3OrderManagerCheckForConfigurationExceptionDataProvider()
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
