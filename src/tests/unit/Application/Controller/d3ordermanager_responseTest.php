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

namespace D3\Ordermanager\Tests\unit\Application\Controller;

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Log\d3log;
use D3\ModCfg\Application\Model\Log\d3NullLogger;
use D3\Ordermanager\Application\Controller\d3ordermanager_response;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_execute;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_cronUnavailableException;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_cronUnavailableException as cronUnavailableException;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_requirementException;
use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirement_orderfield;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Registry;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use ReflectionException;
use stdClass;

class d3ordermanager_responseTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3ordermanager_response */
    protected $_oController;

    /**
     * setup basic requirements
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function setUp()
    {
        parent::setUp();

        $this->_oController = d3GetModCfgDIC()->get(d3ordermanager_response::class);
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
    public function initOutputSuccessMessageToBrowser()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_startExecution',
            'isBrowserCall',
        ));
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
            ->setMethods([
                '_startExecution',
                'isBrowserCall'
            ])
            ->getMock();
        $oControllerMock->expects($this->once())->method('_startExecution')->willReturn(true);
        $oControllerMock->expects($this->atLeast(2))->method('isBrowserCall')->willReturn(false);

        $this->_oController = $oControllerMock;

        Registry::getUtilsView()->addErrorToDisplay(new StandardException('excMessage1'));

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
        $requirement = oxNew(d3ordermanager_requirement_orderfield::class, $this->_oController->getManager());

        /** @var d3ordermanager_requirementException|MockObject $exception */
        $exception = $this->getMockBuilder(d3ordermanager_requirementException::class)
            ->setConstructorArgs([$requirement])
            ->setMethods(['debugOut', 'getMessage'])
            ->getMock();
        $exception->expects($this->once())->method('debugOut')->willReturn(true);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->setMethods([
                '_startExecution',
                'isBrowserCall'
            ])
            ->getMock();
        $oControllerMock->expects($this->once())->method('_startExecution')->willThrowException($exception);
        $oControllerMock->expects($this->atLeast(1))->method('isBrowserCall')->willReturn(true);

        $this->_oController = $oControllerMock;
        Registry::set('logger', oxNew(d3NullLogger::class));

        ob_start();
        $this->callMethod($this->_oController, 'init');
        $sOutput = ob_get_contents();
        ob_end_clean();

        $this->assertNotEmpty($sOutput);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function initThrowExecptionAtServerCall()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->setMethods([
                '_startExecution',
                'isBrowserCall'
            ])
            ->getMock();
        $oControllerMock->expects($this->once())->method('_startExecution')->willReturn(true);
        $oControllerMock->expects($this->atLeast(2))->method('isBrowserCall')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->expectOutputRegex('@.*DEPRECATED.*@');
        $this->callMethod($this->_oController, 'init');
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function initDontOutputSuccessMessageInCaseOfException()
    {
        d3GetModCfgDIC()->setParameter(
            cronUnavailableException::class.'.args.message',
            'errorMessage'
        );
        /** @var d3ordermanager_cronUnavailableException $exc */
        $exc = d3GetModCfgDIC()->get(d3ordermanager_cronUnavailableException::class);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->setMethods([
                '_startExecution',
                'isBrowserCall'
            ])
            ->getMock();
        $oControllerMock->expects($this->once())->method('_startExecution')->willThrowException($exc);
        $oControllerMock->expects($this->atLeastOnce())->method('isBrowserCall')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->expectOutputRegex('@.*errorMessage.*@');
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
            ->setMethods(['_startExecution'])
            ->getMock();
        $oControllerMock->expects($this->once())->method('_startExecution')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'initCli'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function startExecutionPassWithoutException()
    {
        /** @var d3log|MockObject $oLogMock */
        $oLogMock = $this->getMock(d3log::class, array(
            'log'
        ));
        $oLogMock->method('log')->willReturn(true);

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'd3getLog',
            'setValue',
            'saveNoLicenseRefresh',
        ));
        $oModCfgMock->method('d3getLog')->willReturn($oLogMock);
        $oModCfgMock->method('setValue')->willReturn(true);
        $oModCfgMock->method('saveNoLicenseRefresh')->willReturn(true);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_getSet',
            '_checkUnavailableCronjob',
            '_getCronTimestampVarName',
            '_startJobs',
        ));
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);
        $oControllerMock->method('_checkUnavailableCronjob')->willReturn(null);
        $oControllerMock->method('_getCronTimestampVarName')->willReturn(true);
        $oControllerMock->expects($this->once())->method('_startJobs')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            '_startExecution'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function startExecutionPassWithCronUnavailableException()
    {
        /** @var d3log|MockObject $oLogMock */
        $oLogMock = $this->getMock(d3log::class, array(
            'log'
        ));
        $oLogMock->method('log')->willReturn(true);

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'd3getLog',
            'setValue',
            'saveNoLicenseRefresh',
        ));
        $oModCfgMock->method('d3getLog')->willReturn($oLogMock);
        $oModCfgMock->method('setValue')->willReturn(true);
        $oModCfgMock->method('saveNoLicenseRefresh')->willReturn(true);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_getSet',
            '_checkUnavailableCronjob',
            '_getCronTimestampVarName',
            '_startJobs',
        ));
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);
        $oControllerMock->method('_checkUnavailableCronjob')->will($this->returnCallback(array($this, 'unavailableCronjobCallback')));
        $oControllerMock->method('_getCronTimestampVarName')->willReturn(true);
        $oControllerMock->expects($this->never())->method('_startJobs')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->setExpectedException(d3ordermanager_cronUnavailableException::class);

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                '_startExecution'
            )
        );
    }

    /**
     * @throws StandardException
     */
    public function standardExceptionCallback()
    {
        $fileName = 'd3ordermanagerExceptionsTest.txt';

        d3GetModCfgDIC()->setParameter(
            'd3ox.ordermanager.'.StandardException::class.'.args.message',
            'cron unavailable'
        );

        /** @var StandardException $oException */
        $oException = d3GetModCfgDIC()->get('d3ox.ordermanager.'.StandardException::class);
        // backward compatibility for OXID < 6.1
        if (method_exists($oException, 'setLogFileName')) {
            $oException->setLogFileName($fileName);
        }

        throw $oException;
    }

    /**
     * @throws d3ordermanager_cronUnavailableException
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
     * @test
     * @throws ReflectionException
     */
    public function getManagerExecuteReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3ordermanager_execute::class,
            $this->callMethod(
                $this->_oController,
                'getManagerExecute',
                array(d3GetModCfgDIC()->get(d3ordermanager::class))
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function startedJobsCountPass()
    {
        /** @var d3log|MockObject $oLogMock */
        $oLogMock = $this->getMock(d3log::class, array(
            'log'
        ));
        $oLogMock->method('log')->willReturn(true);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getId',
            'd3GetLog',
            'load',
        ));
        $oManagerMock->method('getId')->willReturn('sId');
        $oManagerMock->method('d3GetLog')->willReturn($oLogMock);
        $oManagerMock->method('load')->willReturn(true);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMock(d3ordermanager_execute::class, array(
            'setManager',
            'startJobExecution',
            'finishJobExecution',
        ), array($oManagerMock));
        $oManagerExecuteMock->method('setManager')->willReturn(true);
        $oManagerExecuteMock->expects($this->exactly(3))->method('startJobExecution')->willReturn(true);
        $oManagerExecuteMock->expects($this->once())->method('finishJobExecution')->willReturn(true);

        /** @var d3ordermanagerlist|MockObject $oListMock */
        $oListMock = $this->getMock(d3ordermanagerlist::class, array(
            'setCronJobId',
            'setCustomSorting',
            'selectString',
        ));
        $oListMock->method('setCronJobId')->willReturn(true);
        $oListMock->method('setCustomSorting')->willReturn(true);
        $oListMock->method('selectString')->willReturn(true);
        $oListMock->offsetSet('item1', $oManagerMock);
        $oListMock->offsetSet('item2', $oManagerMock);
        $oListMock->offsetSet('item3', $oManagerMock);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            'getManagerList',
            'getManager',
            'getManagerExecute',
        ));
        $oControllerMock->method('getManagerList')->willReturn($oListMock);
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('getManagerExecute')->willReturn($oManagerExecuteMock);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, '_startJobs');
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
     */
    public function baseAccessKeyPassedToSetOne()
    {
        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getValue',
        ));
        $map = [
            ['sCronPassword', ''],
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getBaseCronPW'
        ));
        $oManagerMock->method('getBaseCronPW')->willReturn('sBaseCronPw');

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_getSet',
            'hasValidAccessKey',
            'getManager',
        ));
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('hasValidAccessKey')->with(
            $this->equalTo('sBaseCronPw'),
            $this->equalTo('sSetCronPw')
        )->willReturn(true);

        $this->_oController = $oControllerMock;

        $_GET['key'] = 'sSetCronPw';

        $this->callMethod($this->_oController, '_checkAccessKey');
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function registeredAccessKeyPassedToSetOne()
    {
        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getValue',
        ));
        $map = [
            ['sCronPassword', 'sRegCronPw'],
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getBaseCronPW'
        ));
        $oManagerMock->method('getBaseCronPW')->willReturn('sBaseCronPw');

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_getSet',
            'hasValidAccessKey',
            'getManager',
        ));
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('hasValidAccessKey')->with(
            $this->equalTo('sRegCronPw'),
            $this->equalTo('sSetCronPw')
        )->willReturn(true);

        $this->_oController = $oControllerMock;

        $_GET['key'] = 'sSetCronPw';

        $this->callMethod($this->_oController, '_checkAccessKey');
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getSetReturnsRightInstance()
    {
        $this->assertInstanceOf(d3_cfg_mod::class, $this->callMethod($this->_oController, '_getSet'));
    }

    /**
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
     * @test
     * @throws ReflectionException
     */
    public function remoteCallHasValidAccessKey()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            'isBrowserCall',
        ));
        $oControllerMock->method('isBrowserCall')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                'hasValidAccessKey',
                array('requAccessKey', 'requAccessKey')
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function remoteCallHasInvalidAccessKey()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            'isBrowserCall',
        ));
        $oControllerMock->method('isBrowserCall')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->assertFalse(
            $this->callMethod(
                $this->_oController,
                'hasValidAccessKey',
                array('requAccessKey', 'passedAccessKey')
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function serverCallDontRequireAccessKey()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            'isBrowserCall',
        ));
        $oControllerMock->method('isBrowserCall')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                'hasValidAccessKey',
                array('requAccessKey', 'passedAccessKey')
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function unavailableInactiveCronjobPass()
    {
        /** @var d3ordermanager_cronUnavailableException|MockObject $oExceptionMock */
        $oExceptionMock = $this->getMock(d3ordermanager_cronUnavailableException::class, array(
            'debugOut'
        ));
        $oExceptionMock->method('debugOut')->willReturn(true);

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'isActive',
        ));
        $oModCfgMock->method('isActive')->willReturn(false);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_checkAccessKey',
            'getCronUnavailableException',
            '_getSet',
        ));
        $oControllerMock->method('_checkAccessKey')->willReturn(true);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->setExpectedException(d3ordermanager_cronUnavailableException::class);

        $this->callMethod($this->_oController, '_checkUnavailableCronjob');
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function unavailableCronjobWrongAccessKeyPass()
    {
        /** @var d3ordermanager_cronUnavailableException|MockObject $oExceptionMock */
        $oExceptionMock = $this->getMock(d3ordermanager_cronUnavailableException::class, array(
            'debugOut'
        ));
        $oExceptionMock->method('debugOut')->willReturn(true);

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'isActive',
        ));
        $oModCfgMock->method('isActive')->willReturn(true);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_checkAccessKey',
            'getCronUnavailableException',
            '_getSet',
        ));
        $oControllerMock->method('_checkAccessKey')->willReturn(false);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->setExpectedException(d3ordermanager_cronUnavailableException::class);

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
            ->setMethods(['debugOut'])
            ->getMock();
        $oExceptionMock->method('debugOut')->willReturn(true);

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['isActive', 'getValue'])
            ->getMock();
        $oModCfgMock->method('isActive')->willReturn(true);
        $oModCfgMock->method('getValue')->willReturn(false);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->setMethods([
                '_checkAccessKey',
                'getCronUnavailableException',
                '_getSet'
            ])
            ->getMock();
        $oControllerMock->method('_checkAccessKey')->willReturn(true);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->setExpectedException(d3ordermanager_cronUnavailableException::class);

        $this->callMethod($this->_oController, '_checkUnavailableCronjob');
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function unavailableEnabledCronjobPass()
    {
        /** @var d3ordermanager_cronUnavailableException|MockObject $oExceptionMock */
        $oExceptionMock = $this->getMock(d3ordermanager_cronUnavailableException::class, array(
            'debugOut'
        ));
        $oExceptionMock->method('debugOut')->willReturn(true);

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['isActive', 'getValue'])
            ->getMock();
        $oModCfgMock->expects($this->any())->method('isActive')->willReturn(true);
        $oModCfgMock->expects($this->any())->method('getValue')->willReturn(true);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_checkAccessKey',
            'getCronUnavailableException',
            '_getSet',
            '_checkDisabledCronjob',
        ));
        $oControllerMock->method('_checkAccessKey')->willReturn(true);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, '_checkUnavailableCronjob');
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getCronUnavailableExceptionReturnsRightInstance()
    {
        /** @var d3ordermanager_cronUnavailableException $oInstance */
        $oInstance = $this->callMethod(
            $this->_oController,
            'getCronUnavailableException',
            array('testMessage')
        );

        $this->assertInstanceOf(
            d3ordermanager_cronUnavailableException::class,
            $oInstance
        );
        $this->assertEquals('testMessage', $oInstance->getMessage());
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetUnsetCjIdParameter()
    {
        $_GET['cjid'] = null;

        $this->assertEquals(0, $this->callMethod($this->_oController, '_getCronJobIdParameter'));
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetSetCjIdParameter()
    {
        $_GET['cjid'] = 'foo';

        $this->assertEquals('foo', $this->callMethod($this->_oController, '_getCronJobIdParameter'));
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function cronTimestampVarNameWithoutJobParameterPass()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_getCronJobIdParameter',
        ));
        $oControllerMock->expects($this->any())->method('_getCronJobIdParameter')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->assertContains('Timestamp', $this->callMethod($this->_oController, '_getCronTimestampVarName'));
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function cronTimestampVarNameWithJobParameterPass()
    {
        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_getCronJobIdParameter',
        ));
        $oControllerMock->expects($this->any())->method('_getCronJobIdParameter')->willReturn('testJobId');

        $this->_oController = $oControllerMock;

        $sReturn = $this->callMethod($this->_oController, '_getCronTimestampVarName');
        $this->assertContains('Timestamp', $sReturn);
        $this->assertContains('testJobId', $sReturn);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getLastExecDatePassed()
    {
        $testValue = 'testValue';

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getValue',
        ));
        $map = [
            ['tsVarName', $testValue]
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_getCronTimestampVarName',
            '_getSet',
        ));
        $oControllerMock->expects($this->once())->method('_getCronTimestampVarName')->willReturn('tsVarName');
        $oControllerMock->expects($this->once())->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $testValue,
            $this->callMethod(
                $this->_oController, 'getLastExecDate'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getLastExecDateInfoPassed()
    {
        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMock(Language::class, array(
            'translateString',
        ));
        $oLangMock->method('translateString')->willReturn('%1$s -- %2$s');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getAvailableCronjobIds',
        ));
        $oManagerMock->method('getAvailableCronjobIds')->willReturn(
            [
                [
                    'id'    => 0,
                    'count' => 5
                ],
                [
                    'id'    => 1,
                    'count' => 9
                ],
                [
                    'id'    => 4,
                    'count' => 12
                ]
            ]
        );

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_getCronJobIdParameter',
            'getManager',
            'getLastExecDate',
            'getLang',
        ));
        $oControllerMock->expects($this->once())->method('_getCronJobIdParameter')->willReturn('1');
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('getLastExecDate')->willReturn('2020-02-02');
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            [
                0 => '1 -- 9',
                1 => '1 -- 2020-02-02'
            ],
            $this->callMethod(
                $this->_oController,
                'getLastExecDateInfo'
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
     * @param $sLicenseKey
     * @param d3ordermanager $oManager
     * @return null
     */
    protected function _setModuleLicenseKey($sLicenseKey, $oManager = null)
    {
        return null;
    }
}
