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

namespace D3\Ordermanager\Tests\unit\Application\Controller\Admin;

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\d3filesystem;
use D3\ModCfg\Application\Model\d3str;
use D3\Ordermanager\Application\Controller\Admin\d3_ordermanager_jobs;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_configurationcheck;
use D3\Ordermanager\Application\Model\d3ordermanager_execute;
use D3\Ordermanager\Application\Model\d3ordermanager_toorderassignment;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_requirementException;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_smartyException;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_templaterendererExceptionInterface;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Session;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\UtilsView;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use ReflectionException;
use stdClass;

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
    public function setUp()
    {
        parent::setUp();

        $this->_oController = d3GetModCfgDIC()->get(d3_ordermanager_jobs::class);
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->_oController);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getItemObjectReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Order::class,
            $this->callMethod($this->_oController, 'getItemObject')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getSessionReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Session::class,
            $this->callMethod($this->_oController, 'd3GetSession')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function renderPass()
    {
        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMock(Order::class, array(
            'load',
        ));
        $oOrderMock->expects($this->once())->method('load')->willReturn(true);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_jobs::class, array(
            'getEditObjectId',
            'getItemObject',
            '_d3GetManuallyManagerJobs',
        ));
        $oControllerMock->method('getEditObjectId')->willReturn('testOxId');
        $oControllerMock->method('getItemObject')->willReturn($oOrderMock);
        $oControllerMock->method('_d3GetManuallyManagerJobs')->willReturn($oOrderMock);

        $this->_oController = $oControllerMock;

        $this->assertContains(
            '.tpl',
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
        $oSessionMock = $this->getMock(Session::class, array(
            'setVariable'
        ));
        $oSessionMock->expects($this->once())->method('setVariable')->willReturn(true);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_jobs::class, array(
            'd3GetSession',
        ));
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
    public function getManagerListReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3ordermanagerlist::class,
            $this->callMethod($this->_oController, 'getManagerList')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetManagerJobs()
    {
        /** @var d3ordermanagerlist|MockObject $oManagerListMock */
        $oManagerListMock = $this->getMock(d3ordermanagerlist::class, array(
            'getList',
        ));
        $oManagerListMock->expects($this->once())->method('getList')->willReturn(true);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_jobs::class, array(
            'getManagerList',
        ));
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
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue'
        ));
        $oManagerMock->method('getValue')->willReturn(false);

        $oManagerExecuteMock = $this->getMock(d3ordermanager_execute::class, array(
                'orderMeetsConditions'
            ),
            array(
                $oManagerMock
            )
        );
        $oManagerExecuteMock->method('orderMeetsConditions')->willReturn(true);

        /** @var ListModel|MockObject $oListMock */
        $oListMock = $this->getMock(ListModel::class, array(
            'offsetUnset'
        ));
        $oListMock->expects($this->never())->method('offsetUnset');
        $oListMock->offsetSet('No1', $oManagerMock);
        $oListMock->offsetSet('No2', $oManagerMock);

        /** @var d3ordermanagerlist|MockObject $oManagerListMock */
        $oManagerListMock = $this->getMock(d3ordermanagerlist::class, array(
            'd3GetManuallyManagerJobsByFolder',
        ));
        $oManagerListMock->expects($this->once())->method('d3GetManuallyManagerJobsByFolder')->willReturn($oListMock);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_jobs::class, array(
            'getManagerList',
            'getManagerExecute',
        ));
        $oControllerMock->method('getManagerList')->willReturn($oManagerListMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);

        $this->_oController = $oControllerMock;

        $generatedList = $this->callMethod($this->_oController, '_d3GetManuallyManagerJobs', array('sTestFolderId'));
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
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue'
        ));
        $oManagerMock->method('getValue')->willReturn(false);

        $oManagerExecuteMock = $this->getMock(d3ordermanager_execute::class, array(
                'orderMeetsConditions'
            ),
            array(
                $oManagerMock
            )
        );
        $oManagerExecuteMock->method('orderMeetsConditions')->will($this->onConsecutiveCalls(false, true));

        /** @var ListModel|MockObject $oListMock */
        $oListMock = $this->getMock(ListModel::class, array(
            'offsetUnset'
        ));
        $oListMock->expects($this->never())->method('offsetUnset');
        $oListMock->offsetSet('No1', $oManagerMock);
        $oListMock->offsetSet('No2', $oManagerMock);

        /** @var d3ordermanagerlist|MockObject $oManagerListMock */
        $oManagerListMock = $this->getMock(d3ordermanagerlist::class, array(
            'd3GetManuallyManagerJobsByFolder',
        ));
        $oManagerListMock->expects($this->once())->method('d3GetManuallyManagerJobsByFolder')->willReturn($oListMock);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_jobs::class, array(
            'getManagerList',
            'getManagerExecute',
        ));
        $oControllerMock->method('getManagerList')->willReturn($oManagerListMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);

        $this->_oController = $oControllerMock;

        $generatedList = $this->callMethod($this->_oController, '_d3GetManuallyManagerJobs', array('sTestFolderId'));
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
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue'
        ));
        $oManagerMock->method('getValue')->willReturn(true);

        $oManagerExecuteMock = $this->getMock(d3ordermanager_execute::class, array(
                'orderMeetsConditions'
            ),
            array(
                $oManagerMock
            )
        );
        $oManagerExecuteMock->method('orderMeetsConditions')->will($this->onConsecutiveCalls(false, true));

        /** @var ListModel|MockObject $oListMock */
        $oListMock = $this->getMock(ListModel::class, array(
            'offsetUnset'
        ));
        $oListMock->expects($this->once())->method('offsetUnset');
        $oListMock->offsetSet('No1', $oManagerMock);
        $oListMock->offsetSet('No2', $oManagerMock);

        /** @var d3ordermanagerlist|MockObject $oManagerListMock */
        $oManagerListMock = $this->getMock(d3ordermanagerlist::class, array(
            'd3GetManuallyManagerJobsByFolder',
        ));
        $oManagerListMock->expects($this->once())->method('d3GetManuallyManagerJobsByFolder')->willReturn($oListMock);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_jobs::class, array(
            'getManagerList',
            'getManagerExecute',
        ));
        $oControllerMock->method('getManagerList')->willReturn($oManagerListMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);

        $this->_oController = $oControllerMock;

        $generatedList = $this->callMethod($this->_oController, '_d3GetManuallyManagerJobs', array('sTestFolderId'));
        $this->assertInstanceOf(
            ListModel::class,
            $generatedList
        );
        // offsetUnset doesn't work, because it's mocked
        // $this->assertCount(1, $generatedList);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_ordermanager_jobs::_d3GetManuallyManagerJobs
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function cannotGetManuallyExecutableManagerJobsBecauseUnvalidConfiguration()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getValue'])
            ->getMock();
        $oManagerMock->method('getValue')->willReturn(true);

        /** @var d3ordermanager_requirementException|MockObject $exception */
        $exception = $this->getMockBuilder(d3ordermanager_requirementException::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var UtilsView|MockObject $utilsViewMock */
        $utilsViewMock = $this->getMockBuilder(UtilsView::class)
            ->setMethods(['addErrorToDisplay'])
            ->getMock();
        $utilsViewMock->expects($this->atLeastOnce())->method('addErrorToDisplay')->willReturn(true);
        d3GetModCfgDIC()->set('d3ox.ordermanager.'.UtilsView::class, $utilsViewMock);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->setMethods(['orderMeetsConditions'])
            ->setConstructorArgs([$oManagerMock])
            ->getMock();
        $oManagerExecuteMock->method('orderMeetsConditions')->willThrowException($exception);

        /** @var ListModel|MockObject $oListMock */
        $oListMock = $this->getMockBuilder(ListModel::class)
            ->setMethods(['offsetUnset'])
            ->getMock();
        $oListMock->expects($this->never())->method('offsetUnset');
        $oListMock->offsetSet('No1', $oManagerMock);
        $oListMock->offsetSet('No2', $oManagerMock);

        /** @var d3ordermanagerlist|MockObject $oManagerListMock */
        $oManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->setMethods(['d3GetManuallyManagerJobsByFolder'])
            ->getMock();
        $oManagerListMock->expects($this->once())->method('d3GetManuallyManagerJobsByFolder')->willReturn($oListMock);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->setMethods([
                'getManagerList',
                'getManagerExecute'
            ])
            ->getMock();
        $oControllerMock->method('getManagerList')->willReturn($oManagerListMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);

        $this->_oController = $oControllerMock;

        $generatedList = $this->callMethod(
            $this->_oController,
            '_d3GetManuallyManagerJobs',
            array('sTestFolderId')
        );
        $this->assertInstanceOf(
            ListModel::class,
            $generatedList
        );
        $this->assertTrue(count($generatedList) === 0);
        // offsetUnset doesn't work, because it's mocked
        // $this->assertCount(1, $generatedList);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetJobList()
    {
        $aArray = array(
            '1' => '2',
        );

        /** @var ListModel|MockObject $oJobListMock */
        $oJobListMock = $this->getMock(ListModel::class, array(
            'getArray',
        ));
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
    public function getManagerReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3ordermanager::class,
            $this->callMethod($this->_oController, 'getManager')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function getManagerExecuteReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3ordermanager_execute::class,
            $this->callMethod($this->_oController, 'getManagerExecute', array(d3GetModCfgDIC()->get(d3ordermanager::class)))
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function ordermanagerStartExecutionNoConditionCheck()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'load',
            'setEditedValues',
            'getValue'
        ));
        $oManagerMock->expects($this->once())->method('load')->willReturn(true);
        $oManagerMock->expects($this->never())->method('setEditedValues')->willReturn(true);
        $oManagerMock->method('getValue')->willReturn(false);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMock(d3ordermanager::class, array(
            'exec4order',
            'finishJobExecution',
            'orderMeetsConditions',
        ));
        $oManagerExecuteMock->expects($this->once())->method('exec4order')->willReturn(true);
        $oManagerExecuteMock->expects($this->once())->method('finishJobExecution')->willReturn(true);
        $oManagerExecuteMock->method('orderMeetsConditions')->willReturn(false);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_jobs::class, array(
            'getManager',
            'getManagerExecute',
        ));
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);

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
    public function ordermanagerStartExecutionConditionCheckPass()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'load',
            'setEditedValues',
            'getValue'
        ));
        $oManagerMock->expects($this->once())->method('load')->willReturn(true);
        $oManagerMock->expects($this->never())->method('setEditedValues')->willReturn(true);
        $oManagerMock->method('getValue')->willReturn(true);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMock(d3ordermanager::class, array(
            'exec4order',
            'finishJobExecution',
            'orderMeetsConditions',
        ));
        $oManagerExecuteMock->expects($this->once())->method('exec4order')->willReturn(true);
        $oManagerExecuteMock->expects($this->once())->method('finishJobExecution')->willReturn(true);
        $oManagerExecuteMock->method('orderMeetsConditions')->willReturn(true);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->setMethods([
                'getManager',
                'getManagerExecute',
                'checkForConfigurationException'
            ])
            ->getMock();
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);
        $oControllerMock->method('checkForConfigurationException')->willReturn(true);

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
    public function ordermanagerStartExecutionConditionCheckFailed($exceptionClass)
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'load',
            'setEditedValues',
            'getValue'
        ));
        $oManagerMock->expects($this->once())->method('load')->willReturn(true);
        $oManagerMock->expects($this->never())->method('setEditedValues')->willReturn(true);
        $oManagerMock->method('getValue')->willReturn(true);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMock(d3ordermanager::class, array(
            'exec4order',
            'finishJobExecution',
            'orderMeetsConditions',
        ));
        $oManagerExecuteMock->expects($this->never())->method('exec4order')->willReturn(true);
        $oManagerExecuteMock->expects($this->never())->method('finishJobExecution')->willReturn(true);
        $oManagerExecuteMock->method('orderMeetsConditions')->willReturn(false);

        /** @var d3ordermanager_requirementException|d3ordermanager_templaterendererExceptionInterface|MockObject $exception */
        $exception = $this->getMockBuilder($exceptionClass)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->setMethods([
                'getManager',
                'getManagerExecute',
                'checkForConfigurationException'
            ])
            ->getMock();
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);
        $oControllerMock->method('checkForConfigurationException')->willThrowException($exception);

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
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'load',
            'setEditedValues',
            'getValue'
        ));
        $oManagerMock->expects($this->once())->method('load')->willReturn(true);
        $oManagerMock->expects($this->once())->method('setEditedValues')->willReturn(true);
        $oManagerMock->method('getValue')->willReturn(false);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMock(d3ordermanager::class, array(
            'exec4order',
            'finishJobExecution',
            'orderMeetsConditions',
        ));
        $oManagerExecuteMock->expects($this->once())->method('exec4order')->willReturn(true);
        $oManagerExecuteMock->expects($this->once())->method('finishJobExecution')->willReturn(true);
        $oManagerExecuteMock->method('orderMeetsConditions')->willReturn(false);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_jobs::class, array(
            'getManager',
            'getManagerExecute',
        ));
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);

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
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'load',
            'setEditedValues',
            'getValue'
        ));
        $oManagerMock->expects($this->once())->method('load')->willReturn(true);
        $oManagerMock->expects($this->once())->method('setEditedValues')->willReturn(true);
        $oManagerMock->method('getValue')->willReturn(true);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMock(d3ordermanager::class, array(
            'exec4order',
            'finishJobExecution',
            'orderMeetsConditions',
        ));
        $oManagerExecuteMock->expects($this->once())->method('exec4order')->willReturn(true);
        $oManagerExecuteMock->expects($this->once())->method('finishJobExecution')->willReturn(true);
        $oManagerExecuteMock->method('orderMeetsConditions')->willReturn(true);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->setMethods([
                'getManager',
                'getManagerExecute',
                'checkForConfigurationException'
            ])
            ->getMock();
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);
        $oControllerMock->method('checkForConfigurationException')->willReturn(true);

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
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'load',
            'setEditedValues',
            'getValue'
        ));
        $oManagerMock->expects($this->once())->method('load')->willReturn(true);
        $oManagerMock->expects($this->once())->method('setEditedValues')->willReturn(true);
        $oManagerMock->method('getValue')->willReturn(true);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMock(d3ordermanager::class, array(
            'exec4order',
            'finishJobExecution',
            'orderMeetsConditions',
        ));
        $oManagerExecuteMock->expects($this->never())->method('exec4order')->willReturn(true);
        $oManagerExecuteMock->expects($this->never())->method('finishJobExecution')->willReturn(true);
        $oManagerExecuteMock->method('orderMeetsConditions')->willReturn(false);

        /** @var d3ordermanager_requirementException|d3ordermanager_templaterendererExceptionInterface|MockObject $exception */
        $exception = $this->getMockBuilder($exceptionClass)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->setMethods([
                'getManager',
                'getManagerExecute',
                'checkForConfigurationException'
            ])
            ->getMock();
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);
        $oControllerMock->method('checkForConfigurationException')->willThrowException($exception);

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
    public function orderManagerAssignmentReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3ordermanager_toorderassignment::class,
            $this->callMethod(
                $this->_oController,
                'getOrderManagerAssignment',
                array(d3GetModCfgDIC()->get(d3ordermanager::class))
            )
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
        $oManagerAssignmentMock = $this->getMock(d3ordermanager_toorderassignment::class, array(
            'resetAssignment',
        ), array(d3GetModCfgDIC()->get(d3ordermanager::class)));
        $oManagerAssignmentMock->expects($this->once())->method('resetAssignment')->willReturn(true);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_jobs::class, array(
            'getManager',
            'getOrderManagerAssignment',
        ));
        $oControllerMock->method('getManager')->willReturn(d3GetModCfgDIC()->get(d3ordermanager::class));
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
        $aFolderList = array(
            'Folder#1',
            'Folder#2',
        );

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'd3getSelectableFolderList',
        ));
        $oManagerMock->expects($this->once())->method('d3getSelectableFolderList')->willReturn($aFolderList);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_jobs::class, array(
            'getManager',
        ));
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
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'load',
            'getEditableContent',
        ));
        $oManagerMock->expects($this->once())->method('load')->willReturn(true);
        $oManagerMock->expects($this->once())->method('getEditableContent')->with(
            $this->stringContains('testItemId')
        )->willReturn(true);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_jobs::class, array(
            'getManager',
        ));
        $oControllerMock->method('getManager')->willReturn($oManagerMock);

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'execChangedContents'
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_ordermanager_jobs::execChangedContents
     * @test
     * @throws ReflectionException
     * @dataProvider cannotExecChangedContentsBecauseOfExceptionDataProvider
     */
    public function cannotExecChangedContentsBecauseOfException($exceptionClass)
    {
        $_POST['oxid'] = 'testItemId';

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods([
                'load',
                'getEditableContent'
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
            ->setMethods(['addErrorToDisplay'])
            ->getMock();
        $utilsViewMock->expects($this->atLeastOnce())->method('addErrorToDisplay')->willReturn(true);
        d3GetModCfgDIC()->set('d3ox.ordermanager.'.UtilsView::class, $utilsViewMock);

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_ordermanager_jobs::class)
            ->setMethods(['getManager', 'checkForConfigurationException'])
            ->getMock();
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('checkForConfigurationException')->willThrowException($exception);

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'execChangedContents'
        );
    }

    /**
     * @return string[][]
     */
    public function cannotExecChangedContentsBecauseOfExceptionDataProvider()
    {
        return [
            'unvalid configuration' => [d3ordermanager_requirementException::class],
            'smarty rendering error'    => [d3ordermanager_smartyException::class]
        ];
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getUserMessagesHasRightType()
    {
        $this->assertInternalType(
            'array',
            $this->callMethod(
                $this->_oController,
                'getUserMessages'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getLangReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Language::class,
            $this->callMethod(
                $this->_oController,
                'getLang'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetHelpUrlWithExtension()
    {
        /** @var d3filesystem|MockObject $oFileSystemMock */
        $oFileSystemMock = $this->getMock(d3filesystem::class, array(
            'splitFilename',
        ));
        $oFileSystemMock->method('splitFilename')->willReturn(
            array('name' => 'filename', 'ext' => 'html')
        );

        $definitions = d3GetModCfgDIC()->getDefinitions();
        d3GetModCfgDIC()->set(d3filesystem::class, $oFileSystemMock);

        /** @var d3str|MockObject $oD3StrMock */
        $oD3StrMock = $this->getMock(d3str::class, array(
            'unprefixedslashit',
            'trailingslashit',
        ));
        $oD3StrMock->method('unprefixedslashit')->willReturnCallback(array($this, 'firstArgumentReturnCallback'));
        $oD3StrMock->expects($this->never())->method('trailingslashit')->willReturnCallback(array($this, 'firstArgumentReturnCallback'));

        d3GetModCfgDIC()->set(d3str::class, $oD3StrMock);

        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMock(Language::class, array(
            'translateString',
        ));
        $oLangMock->method('translateString')->willReturn('modulepath');

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getHelpURL'
        ));
        $oModCfgMock->method('getHelpURL')->willReturn('https://faq.d3data.de/module/');

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_jobs::class, array(
            'd3GetSet',
            'getLang',
        ));
        $oControllerMock->method('d3GetSet')->willReturn($oModCfgMock);
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->setValue($oControllerMock, '_sHelpLinkMLAdd', 'foobar');

        $this->_oController = $oControllerMock;

        $this->assertEquals(
            'https://faq.d3data.de/module/modulepath',
            $this->callMethod($this->_oController, 'getHelpURL')
        );

        d3GetModCfgDIC()->reset();
        d3GetModCfgDIC()->setDefinitions($definitions);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetHelpUrlWithoutExtension()
    {
        /** @var d3filesystem|MockObject $oFileSystemMock */
        $oFileSystemMock = $this->getMock(d3filesystem::class, array(
            'splitFilename',
        ));
        $oFileSystemMock->method('splitFilename')->willReturn(
            array('name' => 'filename', 'ext' => '')
        );

        $definitions = d3GetModCfgDIC()->getDefinitions();
        d3GetModCfgDIC()->set(d3filesystem::class, $oFileSystemMock);

        /** @var d3str|MockObject $oD3StrMock */
        $oD3StrMock = $this->getMock(d3str::class, array(
            'unprefixedslashit',
            'trailingslashit',
        ));
        $oD3StrMock->method('unprefixedslashit')->willReturnCallback(array($this, 'firstArgumentReturnCallback'));
        $oD3StrMock->expects($this->once())->method('trailingslashit')->willReturnCallback(array($this, 'firstArgumentReturnCallback'));

        d3GetModCfgDIC()->set(d3str::class, $oD3StrMock);

        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMock(Language::class, array(
            'translateString',
        ));
        $oLangMock->method('translateString')->willReturn('modulepath');

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getHelpURL'
        ));
        $oModCfgMock->method('getHelpURL')->willReturn('https://faq.d3data.de/module/');

        /** @var d3_ordermanager_jobs|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_jobs::class, array(
            'd3GetSet',
            'getLang',
        ));
        $oControllerMock->method('d3GetSet')->willReturn($oModCfgMock);
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->setValue($oControllerMock, '_sHelpLinkMLAdd', 'foobar');

        $this->_oController = $oControllerMock;

        $this->assertEquals(
            'https://faq.d3data.de/module/modulepath',
            $this->callMethod($this->_oController, 'getHelpURL')
        );

        d3GetModCfgDIC()->reset();
        d3GetModCfgDIC()->setDefinitions($definitions);
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
     * @test
     * @throws ReflectionException
     */
    public function getSetReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3_cfg_mod::class,
            $this->callMethod($this->_oController, 'd3GetSet')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getLinkReturnsString()
    {
        $this->assertInternalType(
            'string',
            $this->callMethod(
                $this->_oController,
                'getLink'
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

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_ordermanager_jobs::checkForConfigurationException
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
            ->setMethods(['checkThrowingExceptions'])
            ->getMock();
        $confCheckMock->expects($this->once())->method('checkThrowingExceptions')->willReturn(true);
        d3GetModCfgDIC()->set(d3ordermanager_configurationcheck::class, $confCheckMock);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getValue'])
            ->getMock();
        $oManagerMock->method('getValue')->willReturn($configuration);

        $this->callMethod(
            $this->_oController,
            'checkForConfigurationException',
            [$oManagerMock]
        );
    }

    /**
     * @return array[]
     */
    public function canCheckForConfigurationExceptionDataProvider()
    {
        return [
            [d3ordermanager_configurationcheck::REQUIREMENTS_AND_ACTIONS],
            [d3ordermanager_configurationcheck::ACTIONS_ONLY]
        ];
    }
}
