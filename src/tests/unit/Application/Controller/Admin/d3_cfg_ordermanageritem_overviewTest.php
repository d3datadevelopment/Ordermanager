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
use D3\Ordermanager\Application\Model\d3ordermanager_listgenerator;
use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirementlist;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\SystemComponentException;
use OxidEsales\Eshop\Core\Language;
use PHPUnit\Framework\MockObject\MockObject;
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getActionAdminController
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getRequirementAdminController
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::__call
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
        $oActionAdminControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->setMethods([$sMethodName])
            ->getMock();
        $oActionAdminControllerMock
            ->expects($this->once())
            ->method($sMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedAction);

        /** @var d3_cfg_ordermanageritem_requ|MockObject $oRequirementAdminControllerMock */
        $oRequirementAdminControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->setMethods([$sOtherMethodName])
            ->getMock();
        $oRequirementAdminControllerMock
            ->expects($this->never())
            ->method($sOtherMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedRequ);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'getActionAdminController',
                'getRequirementAdminController',
                $sOtherMethodName
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::__call
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
        $oActionAdminControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->setMethods([$sOtherMethodName])
            ->getMock();
        $oActionAdminControllerMock
            ->expects($this->never())
            ->method($sOtherMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedAction);

        /** @var d3_cfg_ordermanageritem_requ|MockObject $oRequirementAdminControllerMock */
        $oRequirementAdminControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->setMethods([$sMethodName])
            ->getMock();
        $oRequirementAdminControllerMock
            ->expects($this->once())
            ->method($sMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedRequ);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'getActionAdminController',
                'getRequirementAdminController',
                $sOtherMethodName
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::__call
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
        $oActionAdminControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->setMethods([$sOtherMethodName])
            ->getMock();
        $oActionAdminControllerMock
            ->expects($this->never())
            ->method($sOtherMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedAction);

        /** @var d3_cfg_ordermanageritem_requ|MockObject $oRequirementAdminControllerMock */
        $oRequirementAdminControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->setMethods([$sOtherMethodName])
            ->getMock();
        $oRequirementAdminControllerMock
            ->expects($this->never())
            ->method($sOtherMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedRequ);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'getActionAdminController',
                'getRequirementAdminController',
                $sMethodName
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::__call
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
        $oActionAdminControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->setMethods([$sOtherMethodName])
            ->getMock();
        $oActionAdminControllerMock
            ->expects($this->never())
            ->method($sOtherMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedAction);

        /** @var d3_cfg_ordermanageritem_requ|MockObject $oRequirementAdminControllerMock */
        $oRequirementAdminControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->setMethods([$sOtherMethodName])
            ->getMock();
        $oRequirementAdminControllerMock
            ->expects($this->never())
            ->method($sOtherMethodName)
            ->with(
                $this->stringContains('sArg1')
            )
            ->willReturn($mExpectedRequ);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'getActionAdminController',
                'getRequirementAdminController',
                $sOtherMethodName
            ])
            ->getMock();
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

        $this->expectException(SystemComponentException::class);

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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getRequirementListObject
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getRequirementList
     * @test
     * @throws ReflectionException
     */
    public function canGetRequirementList()
    {
        /** @var d3ordermanager_conf|MockObject $oManagerConfMock */
        $oManagerConfMock = $this->getMockBuilder(d3ordermanager_conf::class)
            ->setMethods(['getRequirementIdList'])
            ->getMock();
        $oManagerConfMock->method('getRequirementIdList')->willReturn(true);

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getConfiguration'])
            ->getMock();
        $oProfileMock->method('getConfiguration')->willReturn($oManagerConfMock);

        /** @var d3ordermanager_requirementlist|MockObject $oRequListMock */
        $oRequListMock = $this->getMockBuilder(d3ordermanager_requirementlist::class)
            ->setMethods([
                'setRequirements',
                'getRequirementList'
            ])
            ->setConstructorArgs([$oProfileMock])
            ->getMock();
        $oRequListMock->method('setRequirements')->willReturn(true);
        $oRequListMock->expects($this->once())->method('getRequirementList')->willReturn('testReturn');

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'getProfile',
                'getRequirementListObject'
            ])
            ->getMock();
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);
        $oControllerMock->method('getRequirementListObject')->willReturn($oRequListMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            'testReturn',
            $this->callMethod(
                $this->_oController,
                "getRequirementList"
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getActionListObject
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getActionList
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetActionList()
    {
        /** @var d3ordermanager_conf|MockObject $oManagerConfMock */
        $oManagerConfMock = $this->getMockBuilder(d3ordermanager_conf::class)
            ->setMethods(['getActionIdList'])
            ->getMock();
        $oManagerConfMock->method('getActionIdList')->willReturn(true);

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getConfiguration'])
            ->getMock();
        $oProfileMock->method('getConfiguration')->willReturn($oManagerConfMock);

        /** @var d3ordermanager_actionlist|MockObject $oActionListMock */
        $oActionListMock = $this->getMockBuilder(d3ordermanager_actionlist::class)
            ->setMethods([
                'setActions',
                'getActionList'
            ])
            ->setConstructorArgs([$oProfileMock, d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)])
            ->getMock();
        $oActionListMock->method('setActions')->willReturn(true);
        $oActionListMock->expects($this->once())->method('getActionList')->willReturn('testReturn');

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'getProfile',
                'getActionListObject'
            ])
            ->getMock();
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);
        $oControllerMock->method('getActionListObject')->willReturn($oActionListMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            'testReturn',
            $this->callMethod(
                $this->_oController,
                "getActionList"
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::isEditMode
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::setRequestData
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::_getRequestData
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getToFinishedCount
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetToFinishedCountCanRequestData()
    {
        $mExpected = 255;

        /** @var d3ordermanager_listgenerator|MockObject $oListGeneratorMock */
        $oListGeneratorMock = $this->getMockBuilder(d3ordermanager_listgenerator::class)
            ->setMethods(['getConcernedItemCount'])
            ->setConstructorArgs([d3GetModCfgDIC()->get(d3ordermanager::class)])
            ->getMock();
        $oListGeneratorMock->method('getConcernedItemCount')->willReturn($mExpected);

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getListGenerator'])
            ->getMock();
        $oProfileMock->method('getListGenerator')->willReturn($oListGeneratorMock);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'canRequestData',
                'getProfile'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getToFinishedCount
     * @test
     * @throws ReflectionException
     */
    public function canGetToFinishedCountHasRequestData()
    {
        $mExpected = 256;
        $_POST['toFinishedCount'] = $mExpected;

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'canRequestData',
                'canUseRequestData'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getToFinishedCount
     * @test
     * @throws ReflectionException
     */
    public function canNotGetToFinishedCount()
    {
        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'canRequestData',
                'canUseRequestData'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getFinishedCount
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetFinishedCountCanRequestData()
    {
        $mExpected = 257;

        /** @var d3ordermanager_listgenerator|MockObject $oListGeneratorMock */
        $oListGeneratorMock = $this->getMockBuilder(d3ordermanager_listgenerator::class)
            ->setMethods(['getFinishedItemCount'])
            ->setConstructorArgs([d3GetModCfgDIC()->get(d3ordermanager::class)])
            ->getMock();
        $oListGeneratorMock->method('getFinishedItemCount')->willReturn($mExpected);

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getListGenerator'])
            ->getMock();
        $oProfileMock->method('getListGenerator')->willReturn($oListGeneratorMock);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'canRequestData',
                'getProfile'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getFinishedCount
     * @test
     * @throws ReflectionException
     */
    public function canGetFinishedCountHasRequestData()
    {
        $mExpected = 258;
        $_POST['finishedCount'] = $mExpected;

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'canRequestData',
                'canUseRequestData'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getFinishedCount
     * @test
     * @throws ReflectionException
     */
    public function canNotGetFinishedCount()
    {
        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'canRequestData',
                'canUseRequestData'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getFinishedMonthCount
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetFinishedMonthCountCanRequestData()
    {
        $mExpected = 259;

        /** @var d3ordermanager_listgenerator|MockObject $oListGeneratorMock */
        $oListGeneratorMock = $this->getMockBuilder(d3ordermanager_listgenerator::class)
            ->setMethods(['getFinishedMonthItemCount'])
            ->setConstructorArgs([d3GetModCfgDIC()->get(d3ordermanager::class)])
            ->getMock();
        $oListGeneratorMock->method('getFinishedMonthItemCount')->willReturn($mExpected);

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getListGenerator'])
            ->getMock();
        $oProfileMock->method('getListGenerator')->willReturn($oListGeneratorMock);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'canRequestData',
                'getProfile'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getFinishedMonthCount
     * @test
     * @throws ReflectionException
     */
    public function canGetFinishedMonthCountHasRequestData()
    {
        $mExpected = 260;
        $_POST['finishedMonthCount'] = $mExpected;

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'canRequestData',
                'canUseRequestData'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getFinishedMonthCount
     * @test
     * @throws ReflectionException
     */
    public function canNotGetFinishedMonthCount()
    {
        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'canRequestData',
                'canUseRequestData'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getNotFinishedCount
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetNotFinishedCountCanRequestData()
    {
        $mExpected = 261;

        /** @var d3ordermanager_listgenerator|MockObject $oListGeneratorMock */
        $oListGeneratorMock = $this->getMockBuilder(d3ordermanager_listgenerator::class)
            ->setMethods(['getNotFinishedItemCount'])
            ->setConstructorArgs([d3GetModCfgDIC()->get(d3ordermanager::class)])
            ->getMock();
        $oListGeneratorMock->method('getNotFinishedItemCount')->willReturn($mExpected);

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getListGenerator'])
            ->getMock();
        $oProfileMock->method('getListGenerator')->willReturn($oListGeneratorMock);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'canRequestData',
                'getProfile'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getNotFinishedCount
     * @test
     * @throws ReflectionException
     */
    public function canGetNotFinishedCountHasRequestData()
    {
        $mExpected = 262;
        $_POST['notFinishedCount'] = $mExpected;

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'canRequestData',
                'canUseRequestData'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getNotFinishedCount
     * @test
     * @throws ReflectionException
     */
    public function canNotGetNotFinishedMonthCount()
    {
        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'canRequestData',
                'canUseRequestData'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::canRequestData
     * @test
     * @throws ReflectionException
     */
    public function canRequestDataNoDemand()
    {
        $sFncName = 'fncName';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods(['getDataOnDemand'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::canRequestData
     * @test
     * @throws ReflectionException
     */
    public function canRequestDataOnDemandHasRequestData()
    {
        $sFncName = 'fncName';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'getDataOnDemand',
                '_getRequestData'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::canRequestData
     * @test
     * @throws ReflectionException
     */
    public function canRequestDataOnDemandHasNoRequestData()
    {
        $sFncName = 'fncName';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'getDataOnDemand',
                '_getRequestData'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::canUseRequestData
     * @test
     * @throws ReflectionException
     */
    public function checkUsableRequestDataNoDemand()
    {
        $iRequestCount = '300';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods(['getDataOnDemand'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::canUseRequestData
     * @test
     * @throws ReflectionException
     */
    public function checkUsableRequestDataOnDemandHasRequestData()
    {
        $iRequestCount = '301';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods(['getDataOnDemand'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::canUseRequestData
     * @test
     * @throws ReflectionException
     */
    public function checkUsableRequestDataOnDemandHasNoRequestData()
    {
        $iRequestCount = null;

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods(['getDataOnDemand'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getDataOnDemand
     * @test
     * @throws ReflectionException
     */
    public function dataOnDemandOptionPass()
    {
        $mExpected = 'testValue';

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['getValue'])
            ->getMock();
        $oModCfgMock->method('getValue')->willReturn($mExpected);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods(['d3GetSet'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::hasRequestedData
     * @test
     * @throws ReflectionException
     */
    public function hasRequestedDataHasData()
    {
        $_POST['sRequestName'] = 400;
        $sFncName = 'fncName';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods(['_getRequestData'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::hasRequestedData
     * @test
     * @throws ReflectionException
     */
    public function hasRequestedDataHasNoData()
    {
        $_POST['sRequestName'] = null;
        $sFncName = 'fncName';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods(['_getRequestData'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::hasRequestedData
     * @test
     * @throws ReflectionException
     */
    public function hasRequestedDataHasOtherFunctionName()
    {
        $_POST['sRequestName'] = 401;
        $sFncName = 'fncName';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods(['_getRequestData'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::hasRequestedData
     * @test
     * @throws ReflectionException
     */
    public function hasRequestedDataHasNoDataAndOtherFunctionName()
    {
        $_POST['sRequestName'] = null;
        $sFncName = 'fncName';

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods(['_getRequestData'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getManager
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getLang
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getManagerTitle
     * @test
     * @throws ReflectionException
     */
    public function getManagerTitleFromObjectPass()
    {
        $mExpected = 'managerTitleFromObject';

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods([
                'load',
                'getFieldData'
            ])
            ->getMock();
        $oManagerMock->method('load')->willReturn(true);
        $oManagerMock->method('getFieldData')->willReturn($mExpected);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods(['getManager'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::getManagerTitle
     * @test
     * @throws ReflectionException
     */
    public function getManagerTitleFromTranslationPass()
    {
        $mExpected = 'managerTitleFromTranslation';

        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['translateString'])
            ->getMock();
        $oLangMock->method('translateString')->willReturn($mExpected);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods([
                'load',
                'getFieldData'
            ])
            ->getMock();
        $oManagerMock->method('load')->willReturn(false);
        $oManagerMock->method('getFieldData')->willReturn($mExpected);

        /** @var d3_cfg_ordermanageritem_overview|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_overview::class)
            ->setMethods([
                'getManager',
                'getLang'
            ])
            ->getMock();
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