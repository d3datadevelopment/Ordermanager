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

use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actionlist;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_conf;
use D3\Ordermanager\Application\Model\d3ordermanager_configurationcheck;
use D3\Ordermanager\Application\Model\d3ordermanager_listgenerator;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_requirementException;
use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirementlist;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\SystemComponentException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\UtilsView;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use ReflectionException;
use stdClass;

class d3_cfg_ordermanageritem_overviewTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_cfg_ordermanageritem_overview */
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

        $this->_oController = d3GetModCfgDIC()->get(d3_cfg_ordermanageritem_overview::class);
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->_oController);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::render
     * @test
     * @throws ReflectionException
     */
    public function renderThrowsException()
    {
        /** @var d3ordermanager_requirementException|MockObject $excMock */
        $excMock = $this->getMockBuilder(d3ordermanager_requirementException::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var d3ordermanager_configurationcheck|MockObject $confCheckMock */
        $confCheckMock = $this->getMockBuilder(d3ordermanager_configurationcheck::class)
            ->setMethods(['checkThrowingExceptions'])
            ->disableOriginalConstructor()
            ->getMock();
        $confCheckMock->method('checkThrowingExceptions')->willThrowException($excMock);

        d3GetModCfgDIC()->set(d3ordermanager_configurationcheck::class, $confCheckMock);

        /** @var UtilsView|MockObject $utilsViewMock */
        $utilsViewMock = $this->getMockBuilder(UtilsView::class)
            ->setMethods(['addErrorToDisplay'])
            ->getMock();
        $utilsViewMock->expects($this->atLeastOnce())->method('addErrorToDisplay')->willReturn(true);

        d3GetModCfgDIC()->set('d3ox.ordermanager.'.UtilsView::class, $utilsViewMock);

        $this->callMethod(
            $this->_oController,
            'render'
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::render
     * @test
     * @throws ReflectionException
     */
    public function renderDontThrowsException()
    {
        /** @var d3ordermanager_configurationcheck|MockObject $confCheckMock */
        $confCheckMock = $this->getMockBuilder(d3ordermanager_configurationcheck::class)
            ->setMethods(['checkThrowingExceptions'])
            ->disableOriginalConstructor()
            ->getMock();
        $confCheckMock->method('checkThrowingExceptions')->willReturn(true);

        d3GetModCfgDIC()->set(d3ordermanager_configurationcheck::class, $confCheckMock);

        /** @var UtilsView|MockObject $utilsViewMock */
        $utilsViewMock = $this->getMockBuilder(UtilsView::class)
            ->setMethods(['addErrorToDisplay'])
            ->getMock();
        $utilsViewMock->expects($this->never())->method('addErrorToDisplay')->willReturn(true);

        d3GetModCfgDIC()->set('d3ox.ordermanager.'.UtilsView::class, $utilsViewMock);

        $this->callMethod(
            $this->_oController,
            'render'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function actionAdminControllerIsRightInstance()
    {
        $this->assertInstanceOf(
            d3_cfg_ordermanageritem_action::class,
            $this->callMethod(
                $this->_oController,
                'getActionAdminController'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function requirementAdminControllerIsRightInstance()
    {
        $this->assertInstanceOf(
            d3_cfg_ordermanageritem_requ::class,
            $this->callMethod(
                $this->_oController,
                'getRequirementAdminController'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function callFromActionItemClassPass()
    {
        $sMethodName = 'methodeName';
        $sOtherMethodName = 'otherMethodName';
        $mExpectedAction = 'returnValueAction';
        $mExpectedRequ = 'returnValueRequ';
        $mExpectedController = 'returnValueController';

        /** @var d3_cfg_ordermanageritem_action|MockObject $oActionAdminControllerMock */
        $oActionAdminControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            $sMethodName
        ));
        $oActionAdminControllerMock
            ->expects($this->once())
            ->method($sMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedAction);

        /** @var d3_cfg_ordermanageritem_requ|MockObject $oRequirementAdminControllerMock */
        $oRequirementAdminControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            $sOtherMethodName
        ));
        $oRequirementAdminControllerMock
            ->expects($this->never())
            ->method($sOtherMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedRequ);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'getActionAdminController',
            'getRequirementAdminController',
            $sOtherMethodName
        ));
        $oControllerMock->method('getActionAdminController')->willReturn($oActionAdminControllerMock);
        $oControllerMock->method('getRequirementAdminController')->willReturn($oRequirementAdminControllerMock);
        $oControllerMock
            ->expects($this->never())
            ->method($sOtherMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedController);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $mExpectedAction,
            $this->callMethod(
                $this->_oController,
                '__call',
                array($sMethodName, array('sArg1'))
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function callFromRequItemClassPass()
    {
        $sMethodName = 'methodeName';
        $sOtherMethodName = 'otherMethodName';
        $mExpectedAction = 'returnValueAction';
        $mExpectedRequ = 'returnValueRequ';
        $mExpectedController = 'returnValueController';

        /** @var d3_cfg_ordermanageritem_action|MockObject $oActionAdminControllerMock */
        $oActionAdminControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            $sOtherMethodName
        ));
        $oActionAdminControllerMock
            ->expects($this->never())
            ->method($sOtherMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedAction);

        /** @var d3_cfg_ordermanageritem_requ|MockObject $oRequirementAdminControllerMock */
        $oRequirementAdminControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            $sMethodName
        ));
        $oRequirementAdminControllerMock
            ->expects($this->once())
            ->method($sMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedRequ);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'getActionAdminController',
            'getRequirementAdminController',
            $sOtherMethodName
        ));
        $oControllerMock->method('getActionAdminController')->willReturn($oActionAdminControllerMock);
        $oControllerMock->method('getRequirementAdminController')->willReturn($oRequirementAdminControllerMock);
        $oControllerMock
            ->expects($this->never())
            ->method($sOtherMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedController);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $mExpectedRequ,
            $this->callMethod(
                $this->_oController,
                '__call',
                array($sMethodName, array('sArg1'))
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function callFromControllerClassPass()
    {
        $sMethodName = 'methodeName';
        $sOtherMethodName = 'otherMethodName';
        $mExpectedAction = 'returnValueAction';
        $mExpectedRequ = 'returnValueRequ';
        $mExpectedController = 'returnValueController';

        /** @var d3_cfg_ordermanageritem_action|MockObject $oActionAdminControllerMock */
        $oActionAdminControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            $sOtherMethodName
        ));
        $oActionAdminControllerMock
            ->expects($this->never())
            ->method($sOtherMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedAction);

        /** @var d3_cfg_ordermanageritem_requ|MockObject $oRequirementAdminControllerMock */
        $oRequirementAdminControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            $sOtherMethodName
        ));
        $oRequirementAdminControllerMock
            ->expects($this->never())
            ->method($sOtherMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedRequ);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'getActionAdminController',
            'getRequirementAdminController',
            $sMethodName
        ));
        $oControllerMock->method('getActionAdminController')->willReturn($oActionAdminControllerMock);
        $oControllerMock->method('getRequirementAdminController')->willReturn($oRequirementAdminControllerMock);
        $oControllerMock
            ->expects($this->once())
            ->method($sMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedController);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $mExpectedController,
            $this->callMethod(
                $this->_oController,
                '__call',
                array($sMethodName, array('sArg1'))
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function callDontPass()
    {
        $sMethodName = 'methodeName';
        $sOtherMethodName = 'otherMethodName';
        $mExpectedAction = 'returnValueAction';
        $mExpectedRequ = 'returnValueRequ';
        $mExpectedController = 'returnValueController';

        /** @var d3_cfg_ordermanageritem_action|MockObject $oActionAdminControllerMock */
        $oActionAdminControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            $sOtherMethodName
        ));
        $oActionAdminControllerMock
            ->expects($this->never())
            ->method($sOtherMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedAction);

        /** @var d3_cfg_ordermanageritem_requ|MockObject $oRequirementAdminControllerMock */
        $oRequirementAdminControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            $sOtherMethodName
        ));
        $oRequirementAdminControllerMock
            ->expects($this->never())
            ->method($sOtherMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedRequ);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'getActionAdminController',
            'getRequirementAdminController',
            $sOtherMethodName
        ));
        $oControllerMock->method('getActionAdminController')->willReturn($oActionAdminControllerMock);
        $oControllerMock->method('getRequirementAdminController')->willReturn($oRequirementAdminControllerMock);
        $oControllerMock
            ->expects($this->never())
            ->method($sOtherMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedController);

        $this->_oController = $oControllerMock;

        $this->setExpectedException(SystemComponentException::class);

        $this->assertSame(
            $mExpectedController,
            $this->callMethod(
                $this->_oController,
                '__call',
                array($sMethodName, array('sArg1'))
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function requirementListObjectIsRightInstance()
    {
        $this->assertInstanceOf(
            d3ordermanager_requirementlist::class,
            $this->callMethod(
                $this->_oController,
                "getRequirementListObject",
                array(d3GetModCfgDIC()->get(d3ordermanager::class))
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetRequirementList()
    {
        $expected = [
            'test'  => 'item'
        ];

        /** @var d3ordermanager_conf|MockObject $oManagerConfMock */
        $oManagerConfMock = $this->getMock(d3ordermanager_conf::class, array(
            'getRequirementIdList'
        ));
        $oManagerConfMock->method('getRequirementIdList')->willReturn([]);

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'getConfiguration'
        ));
        $oProfileMock->method('getConfiguration')->willReturn($oManagerConfMock);

        /** @var d3ordermanager_requirementlist|MockObject $oRequListMock */
        $oRequListMock = $this->getMock(d3ordermanager_requirementlist::class, array(
            'setRequirements',
            'getRequirementList'
        ), array($oProfileMock));
        $oRequListMock->method('setRequirements')->willReturn(true);
        $oRequListMock->expects($this->once())->method('getRequirementList')->willReturn($expected);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'getProfile',
            'getRequirementListObject',
        ));
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);
        $oControllerMock->method('getRequirementListObject')->willReturn($oRequListMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oController,
                "getRequirementList"
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function actionListObjectIsRightInstance()
    {
        $this->assertInstanceOf(
            d3ordermanager_actionlist::class,
            $this->callMethod(
                $this->_oController,
                "getActionListObject",
                array(d3GetModCfgDIC()->get(d3ordermanager::class))
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetActionList()
    {
        $expected = [
            'test'  => 'item'
        ];

        /** @var d3ordermanager_conf|MockObject $oManagerConfMock */
        $oManagerConfMock = $this->getMock(d3ordermanager_conf::class, array(
            'getActionIdList'
        ));
        $oManagerConfMock->method('getActionIdList')->willReturn([]);

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'getConfiguration'
        ));
        $oProfileMock->method('getConfiguration')->willReturn($oManagerConfMock);

        /** @var d3ordermanager_actionlist|MockObject $oActionListMock */
        $oActionListMock = $this->getMock(d3ordermanager_actionlist::class, array(
            'setActions',
            'getActionList'
        ), array($oProfileMock, d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)));
        $oActionListMock->method('setActions')->willReturn(true);
        $oActionListMock->expects($this->once())->method('getActionList')->willReturn($expected);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'getProfile',
            'getActionListObject',
        ));
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);
        $oControllerMock->method('getActionListObject')->willReturn($oActionListMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oController,
                "getActionList"
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function editModeIsBoolean()
    {
        $this->assertInternalType(
            'bool',
            $this->callMethod(
                $this->_oController,
                'isEditMode'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canSetAndGetRequestData()
    {
        $sExpected = 'testData';
        $_POST['sRequestData'] = $sExpected;

        $this->callMethod($this->_oController, 'setRequestData');
        $this->assertSame($sExpected, $this->callMethod($this->_oController, '_getRequestData'));
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetToFinishedCountCanRequestData()
    {
        $mExpected = 255;

        /** @var d3ordermanager_listgenerator|MockObject $oListGeneratorMock */
        $oListGeneratorMock = $this->getMock(d3ordermanager_listgenerator::class, array(
            'getConcernedItemCount'
        ), array(d3GetModCfgDIC()->get(d3ordermanager::class)));
        $oListGeneratorMock->method('getConcernedItemCount')->willReturn($mExpected);

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'getListGenerator'
        ));
        $oProfileMock->method('getListGenerator')->willReturn($oListGeneratorMock);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'canRequestData',
            'getProfile',
        ));
        $oControllerMock->method('canRequestData')->willReturn(true);
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $mExpected,
            $this->callMethod(
                $this->_oController,
                'getToFinishedCount'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetToFinishedCountHasRequestData()
    {
        $mExpected = 256;
        $_POST['toFinishedCount'] = $mExpected;

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'canRequestData',
            'canUseRequestData',
        ));
        $oControllerMock->method('canRequestData')->willReturn(false);
        $oControllerMock->method('canUseRequestData')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $mExpected,
            $this->callMethod(
                $this->_oController,
                'getToFinishedCount'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canNotGetToFinishedCount()
    {
        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'canRequestData',
            'canUseRequestData',
        ));
        $oControllerMock->method('canRequestData')->willReturn(false);
        $oControllerMock->method('canUseRequestData')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->assertEmpty(
            $this->callMethod(
                $this->_oController,
                'getToFinishedCount'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetFinishedCountCanRequestData()
    {
        $mExpected = 257;

        /** @var d3ordermanager_listgenerator|MockObject $oListGeneratorMock */
        $oListGeneratorMock = $this->getMock(d3ordermanager_listgenerator::class, array(
            'getFinishedItemCount'
        ), array(d3GetModCfgDIC()->get(d3ordermanager::class)));
        $oListGeneratorMock->method('getFinishedItemCount')->willReturn($mExpected);

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'getListGenerator'
        ));
        $oProfileMock->method('getListGenerator')->willReturn($oListGeneratorMock);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'canRequestData',
            'getProfile',
        ));
        $oControllerMock->method('canRequestData')->willReturn(true);
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $mExpected,
            $this->callMethod(
                $this->_oController,
                'getFinishedCount'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetFinishedCountHasRequestData()
    {
        $mExpected = 258;
        $_POST['finishedCount'] = $mExpected;

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'canRequestData',
            'canUseRequestData',
        ));
        $oControllerMock->method('canRequestData')->willReturn(false);
        $oControllerMock->method('canUseRequestData')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $mExpected,
            $this->callMethod(
                $this->_oController,
                'getFinishedCount'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canNotGetFinishedCount()
    {
        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'canRequestData',
            'canUseRequestData',
        ));
        $oControllerMock->method('canRequestData')->willReturn(false);
        $oControllerMock->method('canUseRequestData')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->assertEmpty(
            $this->callMethod(
                $this->_oController,
                'getFinishedCount'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetFinishedMonthCountCanRequestData()
    {
        $mExpected = 259;

        /** @var d3ordermanager_listgenerator|MockObject $oListGeneratorMock */
        $oListGeneratorMock = $this->getMock(d3ordermanager_listgenerator::class, array(
            'getFinishedMonthItemCount'
        ), array(d3GetModCfgDIC()->get(d3ordermanager::class)));
        $oListGeneratorMock->method('getFinishedMonthItemCount')->willReturn($mExpected);

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'getListGenerator'
        ));
        $oProfileMock->method('getListGenerator')->willReturn($oListGeneratorMock);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'canRequestData',
            'getProfile',
        ));
        $oControllerMock->method('canRequestData')->willReturn(true);
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $mExpected,
            $this->callMethod(
                $this->_oController,
                'getFinishedMonthCount'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetFinishedMonthCountHasRequestData()
    {
        $mExpected = 260;
        $_POST['finishedMonthCount'] = $mExpected;

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'canRequestData',
            'canUseRequestData',
        ));
        $oControllerMock->method('canRequestData')->willReturn(false);
        $oControllerMock->method('canUseRequestData')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $mExpected,
            $this->callMethod(
                $this->_oController,
                'getFinishedMonthCount'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canNotGetFinishedMonthCount()
    {
        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'canRequestData',
            'canUseRequestData',
        ));
        $oControllerMock->method('canRequestData')->willReturn(false);
        $oControllerMock->method('canUseRequestData')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->assertEmpty(
            $this->callMethod(
                $this->_oController,
                'getFinishedMonthCount'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetNotFinishedCountCanRequestData()
    {
        $mExpected = 261;

        /** @var d3ordermanager_listgenerator|MockObject $oListGeneratorMock */
        $oListGeneratorMock = $this->getMock(d3ordermanager_listgenerator::class, array(
            'getNotFinishedItemCount'
        ), array(d3GetModCfgDIC()->get(d3ordermanager::class)));
        $oListGeneratorMock->method('getNotFinishedItemCount')->willReturn($mExpected);

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'getListGenerator'
        ));
        $oProfileMock->method('getListGenerator')->willReturn($oListGeneratorMock);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'canRequestData',
            'getProfile',
        ));
        $oControllerMock->method('canRequestData')->willReturn(true);
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $mExpected,
            $this->callMethod(
                $this->_oController,
                'getNotFinishedCount'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetNotFinishedCountHasRequestData()
    {
        $mExpected = 262;
        $_POST['notFinishedCount'] = $mExpected;

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'canRequestData',
            'canUseRequestData',
        ));
        $oControllerMock->method('canRequestData')->willReturn(false);
        $oControllerMock->method('canUseRequestData')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $mExpected,
            $this->callMethod(
                $this->_oController,
                'getNotFinishedCount'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canNotGetNotFinishedMonthCount()
    {
        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'canRequestData',
            'canUseRequestData',
        ));
        $oControllerMock->method('canRequestData')->willReturn(false);
        $oControllerMock->method('canUseRequestData')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->assertEmpty(
            $this->callMethod(
                $this->_oController,
                'getNotFinishedCount'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canRequestDataNoDemand()
    {
        $sFncName = 'fncName';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'getDataOnDemand',
        ));
        $oControllerMock->method('getDataOnDemand')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                'canRequestData',
                array($sFncName)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canRequestDataOnDemandHasRequestData()
    {
        $sFncName = 'fncName';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'getDataOnDemand',
            '_getRequestData'
        ));
        $oControllerMock->method('getDataOnDemand')->willReturn(true);
        $oControllerMock->method('_getRequestData')->willReturn($sFncName);

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                'canRequestData',
                array($sFncName)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canRequestDataOnDemandHasNoRequestData()
    {
        $sFncName = 'fncName';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'getDataOnDemand',
            '_getRequestData'
        ));
        $oControllerMock->method('getDataOnDemand')->willReturn(true);
        $oControllerMock->method('_getRequestData')->willReturn('otherFncName');

        $this->_oController = $oControllerMock;

        $this->assertFalse(
            $this->callMethod(
                $this->_oController,
                'canRequestData',
                array($sFncName)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function checkUsableRequestDataNoDemand()
    {
        $iRequestCount = '300';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'getDataOnDemand'
        ));
        $oControllerMock->method('getDataOnDemand')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->assertFalse(
            $this->callMethod(
                $this->_oController,
                'canUseRequestData',
                array($iRequestCount)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function checkUsableRequestDataOnDemandHasRequestData()
    {
        $iRequestCount = '301';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'getDataOnDemand',
        ));
        $oControllerMock->method('getDataOnDemand')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                'canUseRequestData',
                array($iRequestCount)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function checkUsableRequestDataOnDemandHasNoRequestData()
    {
        $iRequestCount = null;

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'getDataOnDemand',
        ));
        $oControllerMock->method('getDataOnDemand')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->assertFalse(
            $this->callMethod(
                $this->_oController,
                'canUseRequestData',
                array($iRequestCount)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function dataOnDemandOptionPass()
    {
        $mExpected = 'testValue';

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getValue',
        ));
        $oModCfgMock->method('getValue')->willReturn($mExpected);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'd3GetSet',
        ));
        $oControllerMock->method('d3GetSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $mExpected,
            $this->callMethod(
                $this->_oController,
                'getDataOnDemand'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function hasRequestedDataHasData()
    {
        $_POST['sRequestName'] = 400;
        $sFncName = 'fncName';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            '_getRequestData'
        ));
        $oControllerMock->method('_getRequestData')->willReturn($sFncName);

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                'hasRequestedData',
                array('sRequestName', $sFncName)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function hasRequestedDataHasNoData()
    {
        $_POST['sRequestName'] = null;
        $sFncName = 'fncName';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            '_getRequestData'
        ));
        $oControllerMock->method('_getRequestData')->willReturn($sFncName);

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                'hasRequestedData',
                array('sRequestName', $sFncName)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function hasRequestedDataHasOtherFunctionName()
    {
        $_POST['sRequestName'] = 401;
        $sFncName = 'fncName';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            '_getRequestData'
        ));
        $oControllerMock->method('_getRequestData')->willReturn('otherFncName');

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                'hasRequestedData',
                array('sRequestName', $sFncName)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function hasRequestedDataHasNoDataAndOtherFunctionName()
    {
        $_POST['sRequestName'] = null;
        $sFncName = 'fncName';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            '_getRequestData'
        ));
        $oControllerMock->method('_getRequestData')->willReturn('otherFncName');

        $this->_oController = $oControllerMock;

        $this->assertFalse(
            $this->callMethod(
                $this->_oController,
                'hasRequestedData',
                array('sRequestName', $sFncName)
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
            $this->callMethod(
                $this->_oController,
                'getManager'
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
    public function getManagerTitleFromObjectPass()
    {
        $mExpected = 'managerTitleFromObject';

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'load',
            'getFieldData'
        ));
        $oManagerMock->method('load')->willReturn(true);
        $oManagerMock->method('getFieldData')->willReturn($mExpected);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'getManager'
        ));
        $oControllerMock->method('getManager')->willReturn($oManagerMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $mExpected,
            $this->callMethod(
                $this->_oController,
                'getManagerTitle',
                array('sManagerId')
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getManagerTitleFromTranslationPass()
    {
        $mExpected = 'managerTitleFromTranslation';

        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMock(d3ordermanager::class, array(
            'translateString',
        ));
        $oLangMock->method('translateString')->willReturn($mExpected);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'load',
            'getFieldData'
        ));
        $oManagerMock->method('load')->willReturn(false);
        $oManagerMock->method('getFieldData')->willReturn($mExpected);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_overview::class, array(
            'getManager',
            'getLang'
        ));
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->_oController = $oControllerMock;

        $sTitle = $this->callMethod(
            $this->_oController,
            'getManagerTitle',
            array('sManagerId')
        );

        $this->assertRegExp('@'.$mExpected.'@i', $sTitle);
        $this->assertRegExp('@sManagerId@i', $sTitle);
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
