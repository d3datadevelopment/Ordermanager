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

namespace D3\Ordermanager\tests\unit\Application\Controller;

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Exception\wrongModIdException;
use D3\ModCfg\Application\Model\Log\d3log;
use D3\ModCfg\Application\Model\Log\d3NullLogger;
use D3\Ordermanager\Application\Controller\d3ordermanager_response;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_execute;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_cronUnavailableException;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_requirementException;
use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirement_orderfield;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Registry;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;
use stdClass;

class d3ordermanager_responseTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3ordermanager_response */
    protected $_oController;

    /**
     * setup basic requirements
     *
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->_oController = d3GetModCfgDIC()->get(d3ordermanager_response::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->_oController);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::__construct
     * @test
     */
    public function constructorPass()
    {
        $this->assertSame(
            'd3_ordermanager',
            d3GetModCfgDIC()->getParameter('d3.ordermanager.modcfgid')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::__construct
     * @test
     */
    public function constructorException()
    {
        /** @var d3ordermanager_response|MockObject $controller */
        $controller = $this->getMockBuilder(d3ordermanager_response::class)
            ->disableOriginalConstructor()
            ->getMock();

        d3GetModCfgDIC()->setParameter('d3.ordermanager.modcfgid', 'differentModCfgid');

        $this->expectException(wrongModIdException::class);

        $this->callMethod(
            $controller,
            '__construct'
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::init
     * @test
     * @throws ReflectionException
     */
    public function initOutputSuccessMessageToBrowser()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                '_startExecution',
                'isBrowserCall',
            ])
            ->getMock();
        $oControllerMock->expects($this->once())->method('_startExecution')->willReturn(false);
        $oControllerMock->expects($this->atLeast(2))->method('isBrowserCall')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->expectOutputRegex('@[a-z0-9]{1,}@i'); // output not empty
        $this->callMethod($this->_oController, 'init');
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::init
     * @test
     * @throws ReflectionException
     */
    public function initOutputErrorMessageToBrowser()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                '_startExecution',
                'isBrowserCall',
            ])
            ->getMock();
        $oControllerMock->expects($this->once())->method('_startExecution')->willReturn(true);
        $oControllerMock->expects($this->atLeast(2))->method('isBrowserCall')->willReturn(false);

        $this->_oController = $oControllerMock;

        Registry::getUtilsView()->addErrorToDisplay(new Exception('excMessage1'));

        $this->expectOutputRegex('@.*ERRORS<br><br>excMessage1.*@i'); // output not empty

        $this->callMethod($this->_oController, 'init');
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::init
     * @test
     * @throws ReflectionException
     */
    public function initcantRunBecauseOfInvalidConfiguration()
    {
        /** @var d3ordermanager_requirement_orderfield|MockObject $requirement */
        $requirement = $this->getMockBuilder(d3ordermanager_requirement_orderfield::class)
            ->setConstructorArgs([$this->_oController->getManager()])
            ->getMock();

        /** @var d3ordermanager_requirementException|MockObject $exception */
        $exception = $this->getMockBuilder(d3ordermanager_requirementException::class)
            ->setConstructorArgs([$requirement])
            ->onlyMethods(['debugOut', 'getMessage'])
            ->getMock();
        $exception->expects($this->once())->method('debugOut')->willReturn(true);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                '_startExecution',
                'isBrowserCall',
            ])
            ->getMock();
        $oControllerMock->expects($this->once())->method('_startExecution')->willThrowException($exception);
        $oControllerMock->expects($this->atLeast(1))->method('isBrowserCall')->willReturn(true);

        $this->_oController = $oControllerMock;
        Registry::set('logger', oxNew(d3NullLogger::class));

        $this->expectOutputRegex('@[a-z0-9]{1,}@i'); // output not empty
        $this->callMethod($this->_oController, 'init');
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::init
     * @test
     * @throws ReflectionException
     */
    public function initThrowExecptionAtServerCall()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                '_startExecution',
                'isBrowserCall',
            ])
            ->getMock();
        $oControllerMock->expects($this->once())->method('_startExecution')->willReturn(true);
        $oControllerMock->expects($this->atLeast(2))->method('isBrowserCall')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->expectOutputRegex('@.*DEPRECATED.*@');
        $this->callMethod($this->_oController, 'init');
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::init
     * @test
     * @throws ReflectionException
     */
    public function initDontOutputSuccessMessageInCaseOfException()
    {
        /** @var d3ordermanager_cronUnavailableException $exc */
        $exc = d3GetModCfgDIC()->get(d3ordermanager_cronUnavailableException::class);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                '_startExecution',
                'isBrowserCall',
            ])
            ->getMock();
        $oControllerMock->expects($this->once())->method('_startExecution')->willThrowException($exc);
        $oControllerMock->expects($this->atLeastOnce())->method('isBrowserCall')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->expectOutputRegex('@^$@'); // output is empty
        $this->callMethod($this->_oController, 'init');
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::initCli
     * @test
     * @throws ReflectionException
     */
    public function canRunInitCli()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods(['_startExecution'])
            ->getMock();
        $oControllerMock->expects($this->once())->method('_startExecution')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'initCli'
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::_startExecution
     * @test
     * @throws ReflectionException
     */
    public function startExecutionPassWithoutException()
    {
        /** @var d3log|MockObject $oLogMock */
        $oLogMock = $this->getMockBuilder(d3log::class)
            ->onlyMethods(['log'])
            ->getMock();
        $oLogMock->method('log')->willReturnSelf();

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['d3getLog'])
            ->addMethods(['setValue'])
            ->addMethods(['saveNoLicenseRefresh'])
            ->getMock();
        $oModCfgMock->method('d3getLog')->willReturn($oLogMock);
        $oModCfgMock->method('setValue')->willReturn(true);
        $oModCfgMock->method('saveNoLicenseRefresh')->willReturn(true);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                '_getSet',
                '_checkUnavailableCronjob',
                '_getCronTimestampVarName',
                '_startJobs', ])
            ->getMock();
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);
        $oControllerMock->method('_checkUnavailableCronjob')->willReturn(null);
        $oControllerMock->method('_getCronTimestampVarName')->willReturn('varName');
        $oControllerMock->expects($this->once())->method('_startJobs')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            '_startExecution'
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::_startExecution
     * @test
     * @throws ReflectionException
     */
    public function startExecutionPassWithCronUnavailableException()
    {
        /** @var d3log|MockObject $oLogMock */
        $oLogMock = $this->getMockBuilder(d3log::class)
            ->onlyMethods(['log'])
            ->getMock();
        $oLogMock->method('log')->willReturnSelf();

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['d3getLog'])
            ->addMethods(['setValue'])
            ->addMethods(['saveNoLicenseRefresh'])
            ->getMock();
        $oModCfgMock->method('d3getLog')->willReturn($oLogMock);
        $oModCfgMock->method('setValue')->willReturn(true);
        $oModCfgMock->method('saveNoLicenseRefresh')->willReturn(true);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                '_getSet',
                '_checkUnavailableCronjob',
                '_getCronTimestampVarName',
                '_startJobs', ])
            ->getMock();
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);
        $oControllerMock->method('_checkUnavailableCronjob')->will($this->returnCallback([$this, 'unavailableCronjobCallback']));
        $oControllerMock->method('_getCronTimestampVarName')->willReturn('varName');
        $oControllerMock->expects($this->never())->method('_startJobs')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->expectException(d3ordermanager_cronUnavailableException::class);

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                '_startExecution'
            )
        );
    }

    /**
     * @throws StandardException
     * @throws Exception
     */
    public function standardExceptionCallback()
    {
        d3GetModCfgDIC()->setParameter(
            'd3ox.ordermanager.'.StandardException::class.'.args.message',
            'cron unavailable'
        );

        /** @var StandardException $oException */
        $oException = d3GetModCfgDIC()->get('d3ox.ordermanager.'.StandardException::class);

        throw $oException;
    }

    /**
     * @throws d3ordermanager_cronUnavailableException
     * @throws Exception
     */
    public function unavailableCronjobCallback()
    {
        d3GetModCfgDIC()->setParameter(
            d3ordermanager_cronUnavailableException::class.'.args.message',
            'cron unavailable'
        );

        /** @var d3ordermanager_cronUnavailableException $oException */
        $oException = d3GetModCfgDIC()->get(d3ordermanager_cronUnavailableException::class);

        throw $oException;
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::getManagerList
     * @test
     * @throws ReflectionException
     */
    public function getListReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3ordermanagerlist::class,
            $this->callMethod(
                $this->_oController,
                'getManagerList'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::getManagerExecute
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function getManagerExecuteReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3ordermanager_execute::class,
            $this->callMethod(
                $this->_oController,
                'getManagerExecute',
                [d3GetModCfgDIC()->get(d3ordermanager::class)]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::_startJobs
     * @test
     * @throws ReflectionException
     */
    public function startedJobsCountPass()
    {
        /** @var d3log|MockObject $oLogMock */
        $oLogMock = $this->getMockBuilder(d3log::class)
            ->onlyMethods(['log'])
            ->getMock();
        $oLogMock->method('log')->willReturnSelf();

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods([
                'd3GetLog',
                'getId',
                'load',
            ])
            ->getMock();
        $oManagerMock->method('getId')->willReturn('sId');
        $oManagerMock->method('d3GetLog')->willReturn($oLogMock);
        $oManagerMock->method('load')->willReturn(true);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->onlyMethods([
                'setManager',
                'startJobExecution',
                'finishJobExecution',
            ])
            ->setConstructorArgs([$oManagerMock])
            ->getMock();
        $oManagerExecuteMock->method('setManager')->willReturn(true);
        $oManagerExecuteMock->expects($this->exactly(3))->method('startJobExecution')->willReturn(true);
        $oManagerExecuteMock->expects($this->once())->method('finishJobExecution')->willReturn(true);

        /** @var d3ordermanagerlist|MockObject $oListMock */
        $oListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods([
                'setCronJobId',
                'setCustomSorting',
                'selectString',
            ])
            ->getMock();
        $oListMock->method('setCronJobId')->willReturn(true);
        $oListMock->method('setCustomSorting')->willReturn(true);
        $oListMock->method('selectString')->willReturn(true);
        $oListMock->offsetSet('item1', $oManagerMock);
        $oListMock->offsetSet('item2', $oManagerMock);
        $oListMock->offsetSet('item3', $oManagerMock);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                'getManagerList',
                'getManager',
                'getManagerExecute',
            ])
            ->getMock();
        $oControllerMock->method('getManagerList')->willReturn($oListMock);
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, '_startJobs');
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::getManager
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
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::_checkAccessKey
     * @test
     * @throws ReflectionException
     */
    public function baseAccessKeyPassedToSetOne()
    {
        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['getValue'])
            ->getMock();
        $map = [
            ['sCronPassword', ''],
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getBaseCronPW'])
            ->getMock();
        $oManagerMock->method('getBaseCronPW')->willReturn('sBaseCronPw');

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                '_getSet',
                'hasValidAccessKey',
                'getManager',
            ])
            ->getMock();
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->expects($this->any())->method('hasValidAccessKey')->with(
            $this->equalTo('sBaseCronPw'),
            $this->equalTo('sSetCronPw')
        )->willReturn(true);

        $this->_oController = $oControllerMock;

        $_GET['key'] = 'sSetCronPw';

        $this->assertTrue(
            $this->callMethod($this->_oController, '_checkAccessKey')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::_checkAccessKey
     * @test
     * @throws ReflectionException
     */
    public function registeredAccessKeyPassedToSetOne()
    {
        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['getValue'])
            ->getMock();
        $map = [
            ['sCronPassword', 'sRegCronPw'],
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getBaseCronPW'])
            ->getMock();
        $oManagerMock->method('getBaseCronPW')->willReturn('sBaseCronPw');

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                '_getSet',
                'hasValidAccessKey',
                'getManager',
            ])
            ->getMock();
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->expects($this->any())->method('hasValidAccessKey')->with(
            $this->equalTo('sRegCronPw'),
            $this->equalTo('sSetCronPw')
        )->willReturn(true);

        $this->_oController = $oControllerMock;

        $_GET['key'] = 'sSetCronPw';

        $this->assertTrue(
            $this->callMethod($this->_oController, '_checkAccessKey')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::_getSet
     * @test
     * @throws ReflectionException
     */
    public function getSetReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3_cfg_mod::class,
            $this->callMethod($this->_oController, '_getSet')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::isBrowserCall
     * @test
     * @throws ReflectionException
     */
    public function isNoBrowserCall()
    {
        $_SERVER['REMOTE_ADDR'] = '';
        $_SERVER['HTTP_USER_AGENT'] = '';

        $this->assertFalse(
            $this->callMethod(
                $this->_oController,
                'isBrowserCall'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::isBrowserCall
     * @test
     * @throws ReflectionException
     */
    public function isBrowserCallBecauseUserAgent()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0';

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                'isBrowserCall'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::isBrowserCall
     * @test
     * @throws ReflectionException
     */
    public function isBrowserCallBecauseRemoteAddr()
    {
        $_SERVER['REMOTE_ADDR'] = '192.168.133.1';

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                'isBrowserCall'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::hasValidAccessKey
     * @test
     * @throws ReflectionException
     */
    public function remoteCallHasValidAccessKey()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods(['isBrowserCall'])
            ->getMock();
        $oControllerMock->method('isBrowserCall')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                'hasValidAccessKey',
                ['requAccessKey', 'requAccessKey']
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::hasValidAccessKey
     * @test
     * @throws ReflectionException
     */
    public function remoteCallHasInvalidAccessKey()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods(['isBrowserCall'])
            ->getMock();
        $oControllerMock->method('isBrowserCall')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->assertFalse(
            $this->callMethod(
                $this->_oController,
                'hasValidAccessKey',
                ['requAccessKey', 'passedAccessKey']
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::hasValidAccessKey
     * @test
     * @throws ReflectionException
     */
    public function serverCallDontRequireAccessKey()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods(['isBrowserCall'])
            ->getMock();
        $oControllerMock->method('isBrowserCall')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                'hasValidAccessKey',
                ['requAccessKey', 'passedAccessKey']
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::_checkUnavailableCronjob
     * @test
     * @throws ReflectionException
     */
    public function unavailableInactiveCronjobPass()
    {
        /** @var d3ordermanager_cronUnavailableException|MockObject $oExceptionMock */
        $oExceptionMock = $this->getMockBuilder(d3ordermanager_cronUnavailableException::class)
            ->onlyMethods(['debugOut'])
            ->getMock();
        $oExceptionMock->method('debugOut')->willReturn(true);

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['isActive'])
            ->getMock();
        $oModCfgMock->method('isActive')->willReturn(false);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                '_checkAccessKey',
                'getCronUnavailableException',
                '_getSet',
            ])
            ->getMock();
        $oControllerMock->method('_checkAccessKey')->willReturn(true);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->expectException(d3ordermanager_cronUnavailableException::class);

        $this->callMethod($this->_oController, '_checkUnavailableCronjob');
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::_checkUnavailableCronjob
     * @test
     * @throws ReflectionException
     */
    public function unavailableCronjobWrongAccessKeyPass()
    {
        /** @var d3ordermanager_cronUnavailableException|MockObject $oExceptionMock */
        $oExceptionMock = $this->getMockBuilder(d3ordermanager_cronUnavailableException::class)
            ->onlyMethods(['debugOut'])
            ->getMock();
        $oExceptionMock->method('debugOut')->willReturn(true);

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['isActive'])
            ->getMock();
        $oModCfgMock->method('isActive')->willReturn(true);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                '_checkAccessKey',
                'getCronUnavailableException',
                '_getSet',
            ])
            ->getMock();
        $oControllerMock->method('_checkAccessKey')->willReturn(false);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->expectException(d3ordermanager_cronUnavailableException::class);

        $this->callMethod($this->_oController, '_checkUnavailableCronjob');
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::_checkUnavailableCronjob
     * @test
     * @throws ReflectionException
     */
    public function unavailableCronjobInactiveCronPass()
    {
        /** @var d3ordermanager_cronUnavailableException|MockObject $oExceptionMock */
        $oExceptionMock = $this->getMockBuilder(d3ordermanager_cronUnavailableException::class)
            ->onlyMethods(['debugOut'])
            ->getMock();
        $oExceptionMock->method('debugOut')->willReturn(true);

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['isActive', 'getValue'])
            ->getMock();
        $oModCfgMock->method('isActive')->willReturn(true);
        $oModCfgMock->method('getValue')->willReturn(false);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                '_checkAccessKey',
                'getCronUnavailableException',
                '_getSet',
            ])
            ->getMock();
        $oControllerMock->method('_checkAccessKey')->willReturn(true);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->expectException(d3ordermanager_cronUnavailableException::class);

        $this->callMethod($this->_oController, '_checkUnavailableCronjob');
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::_checkUnavailableCronjob
     * @test
     * @throws ReflectionException
     * @doesNotPerformAssertions
     */
    public function unavailableEnabledCronjobPass()
    {
        /** @var d3ordermanager_cronUnavailableException|MockObject $oExceptionMock */
        $oExceptionMock = $this->getMockBuilder(d3ordermanager_cronUnavailableException::class)
            ->onlyMethods(['debugOut'])
            ->getMock();
        $oExceptionMock->method('debugOut')->willReturn(true);

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['isActive', 'getValue'])
            ->getMock();
        $oModCfgMock->expects($this->any())->method('isActive')->willReturn(true);
        $oModCfgMock->expects($this->any())->method('getValue')->willReturn(true);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->addMethods(['_checkDisabledCronjob'])
            ->onlyMethods([
                '_checkAccessKey',
                'getCronUnavailableException',
                '_getSet',
            ])
            ->getMock();
        $oControllerMock->expects($this->any())->method('_checkAccessKey')->willReturn(true);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, '_checkUnavailableCronjob');
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::getCronUnavailableException
     * @test
     * @throws ReflectionException
     */
    public function getCronUnavailableExceptionReturnsRightInstance()
    {
        /** @var d3ordermanager_cronUnavailableException $oInstance */
        $oInstance = $this->callMethod(
            $this->_oController,
            'getCronUnavailableException',
            ['testMessage']
        );

        $this->assertInstanceOf(
            d3ordermanager_cronUnavailableException::class,
            $oInstance
        );
        $this->assertEquals('testMessage', $oInstance->getMessage());
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::_getCronJobIdParameter
     * @test
     * @throws ReflectionException
     */
    public function canGetUnsetCjIdParameter()
    {
        $_GET['cjid'] = null;

        $this->assertEquals(0, $this->callMethod($this->_oController, '_getCronJobIdParameter'));
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::_getCronJobIdParameter
     * @test
     * @throws ReflectionException
     */
    public function canGetSetCjIdParameter()
    {
        $_GET['cjid'] = 'foo';

        $this->assertEquals('foo', $this->callMethod($this->_oController, '_getCronJobIdParameter'));
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::_getCronTimestampVarName
     * @test
     * @throws ReflectionException
     */
    public function cronTimestampVarNameWithoutJobParameterPass()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods(['_getCronJobIdParameter'])
            ->getMock();
        $oControllerMock->expects($this->any())->method('_getCronJobIdParameter')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->assertStringContainsStringIgnoringCase('Timestamp', $this->callMethod($this->_oController, '_getCronTimestampVarName'));
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::_getCronTimestampVarName
     * @test
     * @throws ReflectionException
     */
    public function cronTimestampVarNameWithJobParameterPass()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods(['_getCronJobIdParameter'])
            ->getMock();
        $oControllerMock->expects($this->any())->method('_getCronJobIdParameter')->willReturn('testJobId');

        $this->_oController = $oControllerMock;

        $sReturn = $this->callMethod($this->_oController, '_getCronTimestampVarName');
        $this->assertStringContainsStringIgnoringCase('Timestamp', $sReturn);
        $this->assertStringContainsStringIgnoringCase('testJobId', $sReturn);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::getLastExecDate
     * @test
     * @throws ReflectionException
     */
    public function getLastExecDatePassed()
    {
        $testValue = 'testValue';

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['getValue'])
            ->getMock();
        $map = [
            ['tsVarName', $testValue],
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                '_getCronTimestampVarName',
                '_getSet',
            ])
            ->getMock();
        $oControllerMock->expects($this->once())->method('_getCronTimestampVarName')->willReturn('tsVarName');
        $oControllerMock->expects($this->once())->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $testValue,
            $this->callMethod(
                $this->_oController,
                'getLastExecDate'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::getLastExecDateInfo
     * @test
     * @throws ReflectionException
     */
    public function getLastExecDateInfoPassed()
    {
        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->onlyMethods(['translateString'])
            ->getMock();
        $oLangMock->method('translateString')->willReturn('%1$s -- %2$s');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getAvailableCronjobIds'])
            ->getMock();
        $oManagerMock->method('getAvailableCronjobIds')->willReturn(
            [
                [
                    'id'    => 0,
                    'count' => 5,
                ],
                [
                    'id'    => 1,
                    'count' => 9,
                ],
                [
                    'id'    => 4,
                    'count' => 12,
                ],
            ]
        );

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                '_getCronJobIdParameter',
                'getManager',
                'getLastExecDate',
                'getLang',
            ])
            ->getMock();
        $oControllerMock->expects($this->once())->method('_getCronJobIdParameter')->willReturn('1');
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('getLastExecDate')->willReturn('2020-02-02');
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            [
                0 => '1 -- 9',
                1 => '1 -- 2020-02-02',
            ],
            $this->callMethod(
                $this->_oController,
                'getLastExecDateInfo'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response::getLang
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
     * @param $sLicenseKey
     * @param d3ordermanager $oManager
     * @return null
     */
    protected function _setModuleLicenseKey($sLicenseKey, $oManager = null)
    {
        return null;
    }
}
