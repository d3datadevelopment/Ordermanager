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

namespace D3\Ordermanager\tests\unit\Application\Controller\Admin;

use Assert\InvalidArgumentException;
use D3\ModCfg\Application\Model\d3filesystem;
use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Log\d3NullLogger;
use D3\Ordermanager\Application\Controller\Admin\d3_ordermanager_jobs;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_configurationcheck;
use D3\Ordermanager\Application\Model\d3ordermanager_execute;
use D3\Ordermanager\Application\Model\d3ordermanager_toorderassignment;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\Events\PartiallyRunEvent;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_requirementException;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_smartyException;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_templaterendererExceptionInterface;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use Generator;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Session;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\UtilsView;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;
use stdClass;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @covers \D3\Ordermanager\Application\Controller\Admin\d3_ordermanager_jobs
 */
class d3_ordermanager_jobsTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_ordermanager_jobs */
    protected $_oController;

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

        $this->_oController = oxNew(d3_ordermanager_jobs::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->_oController);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function renderPass()
    {
        /** @var d3ordermanagerlist|MockObject $oManagerListMock */
        $oManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
                           ->onlyMethods(['load'])
                           ->getMock();
        $oOrderMock->expects($this->once())->method('load')->willReturn(true);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods([
                'getEditObjectId',
                'getItemObject',
                '_d3GetManuallyManagerJobs',
            ])
            ->getMock();
        $oControllerMock->method('getEditObjectId')->willReturn('testOxId');
        $oControllerMock->method('getItemObject')->willReturn($oOrderMock);
        $oControllerMock->method('_d3GetManuallyManagerJobs')->willReturn($oManagerListMock);

        $this->_oController = $oControllerMock;

        $this->assertStringContainsStringIgnoringCase(
            '@d3ordermanager/admin/d3_ordermanager_jobs',
            $this->callMethod($this->_oController, 'render')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canChangeFolder()
    {
        $_POST['jobfolder'] = 'newSelectedFolder';

        /** @var Session|MockObject $oSessionMock */
        $oSessionMock = $this->getMockBuilder(Session::class)
            ->onlyMethods(['setVariable'])
            ->getMock();
        $oSessionMock->expects($this->once())->method('setVariable')->willReturn(true);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods(['d3GetSession'])
            ->getMock();
        $oControllerMock->method('d3GetSession')->willReturn($oSessionMock);

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'changeFolder'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetManagerJobs()
    {
        /** @var d3ordermanagerlist|MockObject $oManagerListMock */
        $oManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['getList'])
            ->getMock();
        $oManagerListMock->expects($this->once())->method('getList')->willReturn(true);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods(['getManagerList'])
            ->getMock();
        $oControllerMock->method('getManagerList')->willReturn($oManagerListMock);

        $this->_oController = $oControllerMock;

        $this->assertInstanceOf(
            d3ordermanagerlist::class,
            $this->callMethod($this->_oController, 'd3GetManagerJobs')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetManuallyExecutableManagerJobsNoConditionCheck()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue'])
            ->getMock();
        $oManagerMock->method('getValue')->willReturn(false);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->onlyMethods(['orderMeetsConditions'])
            ->setConstructorArgs([$oManagerMock])
            ->getMock();
        $oManagerExecuteMock->method('orderMeetsConditions')->willReturn(true);

        /** @var d3ordermanagerlist|MockObject $oManagerListMock */
        $oManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetManuallyManagerJobsByFolder', 'offsetUnset'])
            ->getMock();
        $oManagerListMock->expects($this->once())->method('d3GetManuallyManagerJobsByFolder')->willReturnSelf();
        $oManagerListMock->expects($this->never())->method('offsetUnset');
        $oManagerListMock->offsetSet('No1', $oManagerMock);
        $oManagerListMock->offsetSet('No2', $oManagerMock);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods([
                'getManagerList',
                'getManagerExecute',
            ])
            ->getMock();
        $oControllerMock->method('getManagerList')->willReturn($oManagerListMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);

        $this->_oController = $oControllerMock;

        $generatedList = $this->callMethod(
            $this->_oController,
            '_d3GetManuallyManagerJobs',
            ['sTestFolderId']
        );
        $this->assertInstanceOf(
            ListModel::class,
            $generatedList
        );
        $this->assertCount(2, $generatedList);
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetManuallyExecutableManagerJobsConditionCheckPass()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue'])
            ->getMock();
        $oManagerMock->method('getValue')->willReturn(false);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->onlyMethods(['orderMeetsConditions'])
            ->setConstructorArgs([$oManagerMock])
            ->getMock();
        $oManagerExecuteMock->method('orderMeetsConditions')->will($this->onConsecutiveCalls(false, true));

        /** @var d3ordermanagerlist|MockObject $oManagerListMock */
        $oManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetManuallyManagerJobsByFolder', 'offsetUnset'])
            ->getMock();
        $oManagerListMock->expects($this->once())->method('d3GetManuallyManagerJobsByFolder')->willReturnSelf();
        $oManagerListMock->expects($this->never())->method('offsetUnset');
        $oManagerListMock->offsetSet('No1', $oManagerMock);
        $oManagerListMock->offsetSet('No2', $oManagerMock);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods([
                'getManagerList',
                'getManagerExecute',
            ])
            ->getMock();
        $oControllerMock->method('getManagerList')->willReturn($oManagerListMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);

        $this->_oController = $oControllerMock;

        $generatedList = $this->callMethod(
            $this->_oController,
            '_d3GetManuallyManagerJobs',
            ['sTestFolderId']
        );
        $this->assertInstanceOf(
            ListModel::class,
            $generatedList
        );
        $this->assertCount(2, $generatedList);
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetManuallyExecutableManagerJobsConditionCheckFailed()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue'])
            ->getMock();
        $oManagerMock->method('getValue')->willReturn(true);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->onlyMethods(['orderMeetsConditions'])
            ->setConstructorArgs([$oManagerMock])
            ->getMock();
        $oManagerExecuteMock->method('orderMeetsConditions')->will($this->onConsecutiveCalls(false, true));

        /** @var d3ordermanagerlist|MockObject $oManagerListMock */
        $oManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetManuallyManagerJobsByFolder'])
            ->getMock();
        $oManagerListMock->expects($this->once())->method('d3GetManuallyManagerJobsByFolder')->willReturnSelf();
        $oManagerListMock->offsetSet('No1', $oManagerMock);
        $oManagerListMock->offsetSet('No2', $oManagerMock);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods([
                'getManagerList',
                'getManagerExecute',
            ])
            ->getMock();
        $oControllerMock->method('getManagerList')->willReturn($oManagerListMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);

        $this->_oController = $oControllerMock;

        $generatedList = $this->callMethod(
            $this->_oController,
            '_d3GetManuallyManagerJobs',
            ['sTestFolderId']
        );
        $this->assertInstanceOf(
            ListModel::class,
            $generatedList
        );

         $this->assertCount(1, $generatedList);
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function cannotGetManuallyExecutableManagerJobsBecauseUnvalidConfiguration()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue'])
            ->getMock();
        $oManagerMock->method('getValue')->willReturn(true);

        /** @var d3ordermanager_requirementException|MockObject $exception */
        $exception = $this->getMockBuilder(d3ordermanager_requirementException::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var UtilsView|MockObject $utilsViewMock */
        $utilsViewMock = $this->getMockBuilder(UtilsView::class)
            ->onlyMethods(['addErrorToDisplay'])
            ->getMock();
        $utilsViewMock->expects($this->atLeastOnce())->method('addErrorToDisplay')->willReturn(true);
        $lastUtilsView = Registry::getUtilsView();
        Registry::set(UtilsView::class, $utilsViewMock);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->onlyMethods(['orderMeetsConditions'])
            ->setConstructorArgs([$oManagerMock])
            ->getMock();
        $oManagerExecuteMock->method('orderMeetsConditions')->willThrowException($exception);

        /** @var d3ordermanagerlist|MockObject $oManagerListMock */
        $oManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetManuallyManagerJobsByFolder', 'offsetUnset'])
            ->getMock();
        $oManagerListMock->expects($this->once())->method('d3GetManuallyManagerJobsByFolder')->willReturnSelf();
        $oManagerListMock->expects($this->never())->method('offsetUnset');
        $oManagerListMock->offsetSet('No1', $oManagerMock);
        $oManagerListMock->offsetSet('No2', $oManagerMock);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods([
                'getManagerList',
                'getManagerExecute',
            ])
            ->getMock();
        $oControllerMock->method('getManagerList')->willReturn($oManagerListMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);

        $this->_oController = $oControllerMock;

        try {
            $generatedList = $this->callMethod(
                $this->_oController,
                '_d3GetManuallyManagerJobs',
                ['sTestFolderId']
            );
            $this->assertInstanceOf(
                ListModel::class,
                $generatedList
            );
            $this->assertEmpty($generatedList);
            // offsetUnset doesn't work, because it's mocked
            // $this->assertCount(1, $generatedList);
        } finally {
            Registry::set(UtilsView::class, $lastUtilsView);
        }
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetJobList()
    {
        $aArray = [
            '1' => '2',
        ];

        /** @var ListModel|MockObject $oJobListMock */
        $oJobListMock = $this->getMockBuilder(ListModel::class)
            ->onlyMethods(['getArray'])
            ->getMock();
        $oJobListMock->method('getArray')->willReturn($aArray);

        $this->setValue($this->_oController, '_aJobList', $oJobListMock);

        $this->assertSame(
            $aArray,
            $this->callMethod(
                $this->_oController,
                'd3GetJobList'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function ordermanagerStartExecution()
    {
        $eventDispatcherMock = $this->getMockBuilder(EventDispatcher::class)
            ->onlyMethods(['dispatch'])
            ->getMock();
        $eventDispatcherMock->expects($this->once())->method('dispatch')->with(
            $this->isInstanceOf(PartiallyRunEvent::class),
        );

        $_GET['ordermanagerid'] = 'managerIdFixture';

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods([
                'getEventDispatcher',
                'getEditObjectId',
                'd3GetOrderManagerLog',
                'assertSupported',
            ])
            ->getMock();
        $oControllerMock->method('getEventDispatcher')->willReturn($eventDispatcherMock);
        $oControllerMock->method('getEditObjectId')->willReturn('orderId');
        $oControllerMock->method('d3GetOrderManagerLog')->willReturn(oxNew(d3NullLogger::class));
        $oControllerMock->method('assertSupported');

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'd3execordermanager'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function ordermanagerExecutionNotSupported()
    {
        $_GET['ordermanagerid'] = 'managerIdFixture';

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods([
                'assertSupported',
                'd3GetOrderManagerLog',
            ])
            ->getMock();
        $oControllerMock->method('assertSupported')->willThrowException(
            $this->getMockBuilder(InvalidArgumentException::class)->disableOriginalConstructor()->getMock()
        );
        $oControllerMock->method('d3GetOrderManagerLog')->willReturn(oxNew(d3NullLogger::class));

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'd3execordermanager'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @dataProvider cannotExecChangedContentsBecauseOfExceptionDataProvider
     */
    public function ordermanagerStartExecutionFailed($exceptionClass)
    {
        /** @var d3ordermanager_requirementException|d3ordermanager_templaterendererExceptionInterface|MockObject $exception */
        $exception = $this->getMockBuilder($exceptionClass)
            ->disableOriginalConstructor()
            ->getMock();

        $eventDispatcherMock = $this->getMockBuilder(EventDispatcher::class)
            ->onlyMethods(['dispatch'])
            ->getMock();
        $eventDispatcherMock->expects($this->once())->method('dispatch')->with(
            $this->isInstanceOf(PartiallyRunEvent::class),
        )->willThrowException($exception);

        $_GET['ordermanagerid'] = 'managerIdFixture';

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods([
                'getEventDispatcher',
                'getEditObjectId',
                'd3GetOrderManagerLog',
                'assertSupported',
            ])
            ->getMock();
        $oControllerMock->method('getEventDispatcher')->willReturn($eventDispatcherMock);
        $oControllerMock->method('getEditObjectId')->willReturn('orderId');
        $oControllerMock->method('d3GetOrderManagerLog')->willReturn(oxNew(d3NullLogger::class));
        $oControllerMock->method('assertSupported');

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'd3execordermanager'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function changedOrdermanagerStartExecutionNoConditionCheck()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods([
                'load',
                'setEditedValues',
                'getValue',
            ])
            ->getMock();
        $oManagerMock->expects($this->once())->method('load')->willReturn(true);
        $oManagerMock->expects($this->once())->method('setEditedValues');
        $oManagerMock->method('getValue')->willReturn(false);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->onlyMethods([
                'exec4order',
                'finishJobExecution',
                'orderMeetsConditions',
            ])
            ->setConstructorArgs([$oManagerMock])
            ->getMock();
        $oManagerExecuteMock->expects($this->once())->method('exec4order');
        $oManagerExecuteMock->expects($this->once())->method('finishJobExecution');
        $oManagerExecuteMock->method('orderMeetsConditions')->willReturn(false);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods([
                'getManager',
                'getManagerExecute',
                'd3GetOrderManagerLog',
            ])
            ->getMock();
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);
        $oControllerMock->method('d3GetOrderManagerLog')->willReturn(oxNew(d3NullLogger::class));

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'd3ExecChangedOrderManager'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function changedOrdermanagerStartExecutionConditionCheckPass()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods([
                'load',
                'setEditedValues',
                'getValue',
            ])
            ->getMock();
        $oManagerMock->expects($this->once())->method('load')->willReturn(true);
        $oManagerMock->expects($this->once())->method('setEditedValues');
        $oManagerMock->method('getValue')->willReturn(true);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->onlyMethods([
                'exec4order',
                'finishJobExecution',
                'orderMeetsConditions',
            ])
            ->setConstructorArgs([$oManagerMock])
            ->getMock();
        $oManagerExecuteMock->expects($this->once())->method('exec4order');
        $oManagerExecuteMock->expects($this->once())->method('finishJobExecution');
        $oManagerExecuteMock->method('orderMeetsConditions')->willReturn(true);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods([
                'getManager',
                'getManagerExecute',
                'checkForConfigurationException',
                'd3GetOrderManagerLog',
            ])
            ->getMock();
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);
        $oControllerMock->method('checkForConfigurationException');
        $oControllerMock->method('d3GetOrderManagerLog')->willReturn(oxNew(d3NullLogger::class));

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'd3ExecChangedOrderManager'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @dataProvider cannotExecChangedContentsBecauseOfExceptionDataProvider
     */
    public function changedOrdermanagerStartExecutionConditionCheckFailed($exceptionClass)
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods([
                'load',
                'setEditedValues',
                'getValue',
            ])
            ->getMock();
        $oManagerMock->expects($this->once())->method('load')->willReturn(true);
        $oManagerMock->expects($this->once())->method('setEditedValues');
        $oManagerMock->method('getValue')->willReturn(true);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->onlyMethods([
                'exec4order',
                'finishJobExecution',
                'orderMeetsConditions',
            ])
            ->setConstructorArgs([$oManagerMock])
            ->getMock();
        $oManagerExecuteMock->expects($this->never())->method('exec4order');
        $oManagerExecuteMock->expects($this->never())->method('finishJobExecution');
        $oManagerExecuteMock->method('orderMeetsConditions')->willReturn(false);

        /** @var d3ordermanager_requirementException|d3ordermanager_templaterendererExceptionInterface|MockObject $exception */
        $exception = $this->getMockBuilder($exceptionClass)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods([
                'getManager',
                'getManagerExecute',
                'checkForConfigurationException',
                'd3GetOrderManagerLog',
            ])
            ->getMock();
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);
        $oControllerMock->method('checkForConfigurationException')->willThrowException($exception);
        $oControllerMock->method('d3GetOrderManagerLog')->willReturn(oxNew(d3NullLogger::class));

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'd3ExecChangedOrderManager'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canStartResettingOrderManagerAssignment()
    {
        /** @var d3ordermanager_execute|MockObject $oManagerAssignmentMock */
        $oManagerAssignmentMock = $this->getMockBuilder(d3ordermanager_toorderassignment::class)
            ->onlyMethods(['resetAssignment'])
            ->setConstructorArgs([oxNew(d3ordermanager::class)])
            ->getMock();
        $oManagerAssignmentMock->expects($this->once())->method('resetAssignment');

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods([
                'getManager',
                'getOrderManagerAssignment',
            ])
            ->getMock();
        $oControllerMock->method('getManager')->willReturn(oxNew(d3ordermanager::class));
        $oControllerMock->method('getOrderManagerAssignment')->willReturn($oManagerAssignmentMock);

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'd3resetOrderManagerAssignment'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetManagerFolderList()
    {
        $aFolderList = [
            'Folder#1',
            'Folder#2',
        ];

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['d3getSelectableFolderList'])
            ->getMock();
        $oManagerMock->expects($this->once())->method('d3getSelectableFolderList')->willReturn($aFolderList);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods(['getManager'])
            ->getMock();
        $oControllerMock->method('getManager')->willReturn($oManagerMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $aFolderList,
            $this->callMethod(
                $this->_oController,
                'getFolderList'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canExecChangedContents()
    {
        $_POST['oxid'] = 'testItemId';

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods([
                'load',
                'getEditableContent',
            ])
            ->getMock();
        $oManagerMock->expects($this->once())->method('load')->willReturn(true);
        $oManagerMock->expects($this->once())->method('getEditableContent')->with(
            $this->stringContains('testItemId')
        )->willReturn(['html'   => '<h1>HTML</h1>']);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods(['getManager', 'd3GetOrderManagerLog'])
            ->getMock();
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('d3GetOrderManagerLog')->willReturn(oxNew(d3NullLogger::class));

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'execChangedContents'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @dataProvider cannotExecChangedContentsBecauseOfExceptionDataProvider
     */
    public function cannotExecChangedContentsBecauseOfException($exceptionClass)
    {
        $_POST['oxid'] = 'testItemId';

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods([
                'load',
                'getEditableContent',
            ])
            ->getMock();
        $oManagerMock->expects($this->once())->method('load')->willReturn(true);
        $oManagerMock->expects($this->never())->method('getEditableContent')->with(
            $this->stringContains('testItemId')
        )->willReturn(true);

        /** @var d3ordermanager_requirementException|d3ordermanager_templaterendererExceptionInterface|MockObject $exception */
        $exception = $this->getMockBuilder($exceptionClass)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var UtilsView|MockObject $utilsViewMock */
        $utilsViewMock = $this->getMockBuilder(UtilsView::class)
            ->onlyMethods(['addErrorToDisplay'])
            ->getMock();
        $utilsViewMock->expects($this->atLeastOnce())->method('addErrorToDisplay')->willReturn(true);
        $lastUtilsView = Registry::getUtilsView();
        Registry::set(UtilsView::class, $utilsViewMock);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods(['getManager', 'checkForConfigurationException', 'd3GetOrderManagerLog'])
            ->getMock();
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('checkForConfigurationException')->willThrowException($exception);
        $oControllerMock->method('d3GetOrderManagerLog')->willReturn(oxNew(d3NullLogger::class));

        $this->_oController = $oControllerMock;

        try {
            $this->callMethod(
                $this->_oController,
                'execChangedContents'
            );
        } finally {
            Registry::set(UtilsView::class, $lastUtilsView);
        }
    }

    /**
     * @return string[][]
     */
    public static function cannotExecChangedContentsBecauseOfExceptionDataProvider(): array
    {
        return [
            'unvalid configuration' => [d3ordermanager_requirementException::class],
            'smarty rendering error'    => [d3ordermanager_smartyException::class],
        ];
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetHelpUrlWithExtension()
    {
        /** @var d3filesystem|MockObject $oFileSystemMock */
        $oFileSystemMock = $this->getMockBuilder(d3filesystem::class)
            ->onlyMethods(['splitFilename'])
            ->getMock();
        $oFileSystemMock->method('splitFilename')->willReturn(
            ['name' => 'filename', 'ext' => 'html']
        );

        /** @var d3str|MockObject $oD3StrMock */
        $oD3StrMock = $this->getMockBuilder(d3str::class)
            ->onlyMethods([
                'unprefixedslashit',
                'trailingslashit',
            ])
            ->getMock();
        $oD3StrMock->method('unprefixedslashit')->willReturnCallback([$this, 'firstArgumentReturnCallback']);
        $oD3StrMock->expects($this->never())->method('trailingslashit')->willReturnCallback([$this, 'firstArgumentReturnCallback']);

        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->onlyMethods(['translateString'])
            ->getMock();
        $oLangMock->method('translateString')->willReturn('modulepath');

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['getHelpURL'])
            ->getMock();
        $oModCfgMock->method('getHelpURL')->willReturn('https://faq.d3data.de/module/');

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods([
                'd3GetOrderManagerConfig',
                'getLang',
                'createD3Str',
                'createD3Filesystem',
            ])
            ->getMock();
        $oControllerMock->method('d3GetOrderManagerConfig')->willReturn($oModCfgMock);
        $oControllerMock->method('getLang')->willReturn($oLangMock);
        $oControllerMock->method('createD3Str')->willReturn($oD3StrMock);
        $oControllerMock->method('createD3Filesystem')->willReturn($oFileSystemMock);

        $this->setValue($oControllerMock, '_sHelpLinkMLAdd', 'foobar');

        $this->_oController = $oControllerMock;

        $this->assertEquals(
            'https://faq.d3data.de/module/modulepath',
            $this->callMethod($this->_oController, 'getHelpURL')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetHelpUrlWithoutExtension()
    {
        /** @var d3filesystem|MockObject $oFileSystemMock */
        $oFileSystemMock = $this->getMockBuilder(d3filesystem::class)
            ->onlyMethods(['splitFilename'])
            ->getMock();
        $oFileSystemMock->method('splitFilename')->willReturn(
            ['name' => 'filename', 'ext' => '']
        );

        /** @var d3str|MockObject $oD3StrMock */
        $oD3StrMock = $this->getMockBuilder(d3str::class)
            ->onlyMethods([
                'unprefixedslashit',
                'trailingslashit',
            ])
            ->getMock();
        $oD3StrMock->method('unprefixedslashit')->willReturnCallback([$this, 'firstArgumentReturnCallback']);
        $oD3StrMock->expects($this->once())->method('trailingslashit')->willReturnCallback([$this, 'firstArgumentReturnCallback']);

        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->onlyMethods(['translateString'])
            ->getMock();
        $oLangMock->method('translateString')->willReturn('modulepath');

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['getHelpURL'])
            ->getMock();
        $oModCfgMock->method('getHelpURL')->willReturn('https://faq.d3data.de/module/');

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods([
                'd3GetOrderManagerConfig',
                'getLang',
                'createD3Str',
                'createD3Filesystem',
            ])
            ->getMock();
        $oControllerMock->method('d3GetOrderManagerConfig')->willReturn($oModCfgMock);
        $oControllerMock->method('getLang')->willReturn($oLangMock);
        $oControllerMock->method('createD3Str')->willReturn($oD3StrMock);
        $oControllerMock->method('createD3Filesystem')->willReturn($oFileSystemMock);

        $this->setValue($oControllerMock, '_sHelpLinkMLAdd', 'foobar');

        $this->_oController = $oControllerMock;

        $this->assertEquals(
            'https://faq.d3data.de/module/modulepath',
            $this->callMethod($this->_oController, 'getHelpURL')
        );
    }

    /**
     * @return mixed
     */
    public function firstArgumentReturnCallback()
    {
        $args = func_get_args();
        return $args[0];
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

    /**
     * @test
     * @param $configuration
     * @throws ReflectionException
     * @dataProvider canCheckForConfigurationExceptionDataProvider
     */
    public function canCheckForConfigurationException($configuration)
    {
        /** @var d3ordermanager_configurationcheck|MockObject $confCheckMock */
        $confCheckMock = $this->getMockBuilder(d3ordermanager_configurationcheck::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['checkThrowingExceptions'])
            ->getMock();
        $confCheckMock->expects($this->once())->method('checkThrowingExceptions');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue'])
            ->getMock();
        $oManagerMock->method('getValue')->willReturn($configuration);

        $controller = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods(['createConfigurationCheck'])
            ->getMock();
        $controller->method('createConfigurationCheck')->willReturn($confCheckMock);

        $this->callMethod(
            $controller,
            'checkForConfigurationException',
            [$oManagerMock]
        );
    }

    /**
     * @test
     * @param bool $support
     * @param bool $expectException
     * @return void
     * @throws ReflectionException
     * @dataProvider assertSupportedDataProvider
     */
    public function testAssertSupported(bool $support, bool $expectException): void
    {
        $managerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['load', 'supports'])
            ->getMock();
        $managerMock->method('load')->willReturn(true);
        $managerMock->expects(self::exactly(1))->method('supports')->willReturn($support);

        $controllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->onlyMethods(['getManager'])
            ->getMock();
        $controllerMock->method('getManager')->willReturn($managerMock);

        if ($expectException) {
            $this->expectException(InvalidArgumentException::class);
        }

        $this->callMethod(
            $controllerMock,
            'assertSupported',
            ['foo']
        );
    }

    public static function assertSupportedDataProvider(): Generator
    {
        yield 'supported' => [true, false];
        yield 'unsupported' => [false, true];
    }

    /**
     * @return array[]
     */
    public static function canCheckForConfigurationExceptionDataProvider()
    {
        return [
            [d3ordermanager_configurationcheck::REQUIREMENTS_AND_ACTIONS],
            [d3ordermanager_configurationcheck::ACTIONS_ONLY],
        ];
    }
}
