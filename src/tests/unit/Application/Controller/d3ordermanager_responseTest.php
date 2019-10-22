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
use D3\Ordermanager\Application\Controller\d3ordermanager_response;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_execute;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_cronUnavailableException;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use PHPUnit_Framework_MockObject_MockObject;
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
        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_startExecution',
            'isBrowserCall',
        ));
        $oControllerMock->expects($this->once())->method('_startExecution')->willReturn(false);
        $oControllerMock->expects($this->once())->method('isBrowserCall')->willReturn(true);

        $this->_oController = $oControllerMock;

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
    public function initDontOutputSuccessMessageToServer()
    {
        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_startExecution',
            'isBrowserCall'
        ));
        $oControllerMock->expects($this->once())->method('_startExecution')->willReturn(false);
        $oControllerMock->expects($this->once())->method('isBrowserCall')->willReturn(false);

        $this->_oController = $oControllerMock;

        ob_start();
        $this->callMethod($this->_oController, 'init');
        $sOutput = ob_get_contents();
        ob_end_clean();

        $this->assertEmpty($sOutput);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function initDontOutputSuccessMessageInCaseOfException()
    {
        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_startExecution',
            'isBrowserCall'
        ));
        $oControllerMock->expects($this->once())->method('_startExecution')->willReturn(true);
        $oControllerMock->expects($this->once())->method('isBrowserCall')->willReturn(true);

        $this->_oController = $oControllerMock;

        ob_start();
        $this->callMethod($this->_oController, 'init');
        $sOutput = ob_get_contents();
        ob_end_clean();

        $this->assertEmpty($sOutput);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function startExecutionPassWithoutException()
    {
        /** @var d3log|PHPUnit_Framework_MockObject_MockObject $oLogMock */
        $oLogMock = $this->getMock(d3log::class, array(
            'log'
        ));
        $oLogMock->method('log')->willReturn(true);

        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'd3getLog',
            'setValue',
            'saveNoLicenseRefresh',
        ));
        $oModCfgMock->method('d3getLog')->willReturn($oLogMock);
        $oModCfgMock->method('setValue')->willReturn(true);
        $oModCfgMock->method('saveNoLicenseRefresh')->willReturn(true);

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_getSet',
            '_checkUnavailableCronjob',
            '_getCronTimestampVarName',
            '_startJobs',
        ));
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);
        $oControllerMock->method('_checkUnavailableCronjob')->willReturn(true);
        $oControllerMock->method('_getCronTimestampVarName')->willReturn(true);
        $oControllerMock->expects($this->once())->method('_startJobs')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->assertFalse(
            $this->callMethod(
                $this->_oController,
                '_startExecution'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function startExecutionPassWithCronUnavailableException()
    {
        /** @var d3log|PHPUnit_Framework_MockObject_MockObject $oLogMock */
        $oLogMock = $this->getMock(d3log::class, array(
            'log'
        ));
        $oLogMock->method('log')->willReturn(true);

        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'd3getLog',
            'setValue',
            'saveNoLicenseRefresh',
        ));
        $oModCfgMock->method('d3getLog')->willReturn($oLogMock);
        $oModCfgMock->method('setValue')->willReturn(true);
        $oModCfgMock->method('saveNoLicenseRefresh')->willReturn(true);

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
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

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                '_startExecution'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function startExecutionPassWithStandardException()
    {
        /** @var d3log|PHPUnit_Framework_MockObject_MockObject $oLogMock */
        $oLogMock = $this->getMock(d3log::class, array(
            'log'
        ));
        $oLogMock->method('log')->willReturn(true);

        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'd3getLog',
            'setValue',
            'saveNoLicenseRefresh',
        ));
        $oModCfgMock->method('d3getLog')->willReturn($oLogMock);
        $oModCfgMock->method('setValue')->willReturn(true);
        $oModCfgMock->method('saveNoLicenseRefresh')->willReturn(true);

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_getSet',
            '_checkUnavailableCronjob',
            '_getCronTimestampVarName',
            '_startJobs',
        ));
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);
        $oControllerMock->method('_checkUnavailableCronjob')->will($this->returnCallback(array($this, 'standardExceptionCallback')));
        $oControllerMock->method('_getCronTimestampVarName')->willReturn(true);
        $oControllerMock->expects($this->never())->method('_startJobs')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                '_startExecution'
            )
        );

        $fileName = 'd3ordermanagerExceptionsTest.txt';
        $sLogFolder = str_replace(basename(OX_LOG_FILE), '', OX_LOG_FILE);
        $sLogFile = $sLogFolder.$fileName;

        // backward compatibility for OXID < 6.1
        if (method_exists(StandardException::class, 'setLogFileName')
            && file_exists($sLogFile)
        ) {
            $file = file_get_contents($sLogFile);
            unlink($sLogFile);
            $this->assertContains('cron unavailable', $file);
        } elseif (file_exists(OX_LOG_FILE)) {
            $file = file_get_contents(OX_LOG_FILE);
            file_put_contents(OX_LOG_FILE, '');
            $this->assertContains('cron unavailable', $file);
        }
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
        $oException->d3disableScreenMessage();

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
        /** @var d3log|PHPUnit_Framework_MockObject_MockObject $oLogMock */
        $oLogMock = $this->getMock(d3log::class, array(
            'log'
        ));
        $oLogMock->method('log')->willReturn(true);

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getId',
            'd3GetLog',
            'load',
        ));
        $oManagerMock->method('getId')->willReturn('sId');
        $oManagerMock->method('d3GetLog')->willReturn($oLogMock);
        $oManagerMock->method('load')->willReturn(true);

        /** @var d3ordermanager_execute|PHPUnit_Framework_MockObject_MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMock(d3ordermanager_execute::class, array(
            'setManager',
            'startJobExecution',
            'finishJobExecution',
        ), array($oManagerMock));
        $oManagerExecuteMock->method('setManager')->willReturn(true);
        $oManagerExecuteMock->expects($this->exactly(3))->method('startJobExecution')->willReturn(true);
        $oManagerExecuteMock->expects($this->once())->method('finishJobExecution')->willReturn(true);

        /** @var d3ordermanagerlist|PHPUnit_Framework_MockObject_MockObject $oListMock */
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

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
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
        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getValue',
        ));
        $map = [
            ['sCronPassword', ''],
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getBaseCronPW'
        ));
        $oManagerMock->method('getBaseCronPW')->willReturn('sBaseCronPw');

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
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
        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getValue',
        ));
        $map = [
            ['sCronPassword', 'sRegCronPw'],
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getBaseCronPW'
        ));
        $oManagerMock->method('getBaseCronPW')->willReturn('sBaseCronPw');

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
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
    public function disabledMessageWillNotShow()
    {
        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getValue',
            'hasDebugMode',
        ));
        $map = [
            ['blCronActive', false],
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);
        $oModCfgMock->method('hasDebugMode')->willReturn(false);

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            'isBrowserCall',
            '_getSet',
        ));
        $oControllerMock->method('isBrowserCall')->willReturn(false);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->assertFalse($this->callMethod($this->_oController, 'showDisabledMessage'));
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function disabledMessageWillShowBecauseDebug()
    {
        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getValue',
            'hasDebugMode',
        ));
        $map = [
            ['blCronActive', false],
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);
        $oModCfgMock->method('hasDebugMode')->willReturn(true);

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            'isBrowserCall',
            '_getSet',
        ));
        $oControllerMock->method('isBrowserCall')->willReturn(false);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->assertTrue($this->callMethod($this->_oController, 'showDisabledMessage'));
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function disabledMessageWillShowBecauseBrowserCall()
    {
        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getValue',
            'hasDebugMode',
        ));
        $map = [
            ['blCronActive', false],
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);
        $oModCfgMock->method('hasDebugMode')->willReturn(false);

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            'isBrowserCall',
            '_getSet',
        ));
        $oControllerMock->method('isBrowserCall')->willReturn(true);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->assertTrue($this->callMethod($this->_oController, 'showDisabledMessage'));
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
        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
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
        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
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
        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
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
        /** @var d3ordermanager_cronUnavailableException|PHPUnit_Framework_MockObject_MockObject $oExceptionMock */
        $oExceptionMock = $this->getMock(d3ordermanager_cronUnavailableException::class, array(
            'debugOut'
        ));
        $oExceptionMock->method('debugOut')->willReturn(true);

        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'isActive',
        ));
        $oModCfgMock->method('isActive')->willReturn(false);

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_checkAccessKey',
            'getCronUnavailableException',
            '_getSet',
        ));
        $oControllerMock->method('_checkAccessKey')->willReturn(true);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->setExpectedException(d3ordermanager_cronunavailableexception::class);

        $this->callMethod($this->_oController, '_checkUnavailableCronjob');
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function unavailableCronjobWrongAccessKeyPass()
    {
        /** @var d3ordermanager_cronUnavailableException|PHPUnit_Framework_MockObject_MockObject $oExceptionMock */
        $oExceptionMock = $this->getMock(d3ordermanager_cronUnavailableException::class, array(
            'debugOut'
        ));
        $oExceptionMock->method('debugOut')->willReturn(true);

        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'isActive',
        ));
        $oModCfgMock->method('isActive')->willReturn(true);

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_checkAccessKey',
            'getCronUnavailableException',
            '_getSet',
        ));
        $oControllerMock->method('_checkAccessKey')->willReturn(false);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->setExpectedException(d3ordermanager_cronunavailableexception::class);

        $this->callMethod($this->_oController, '_checkUnavailableCronjob');
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function unavailableEnabledCronjobPass()
    {
        /** @var d3ordermanager_cronUnavailableException|PHPUnit_Framework_MockObject_MockObject $oExceptionMock */
        $oExceptionMock = $this->getMock(d3ordermanager_cronUnavailableException::class, array(
            'debugOut'
        ));
        $oExceptionMock->method('debugOut')->willReturn(true);

        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'isActive',
        ));
        $oModCfgMock->method('isActive')->willReturn(true);

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            '_checkAccessKey',
            'getCronUnavailableException',
            '_getSet',
            '_checkDisabledCronjob',
        ));
        $oControllerMock->method('_checkAccessKey')->willReturn(true);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);
        $oControllerMock->method('_checkDisabledCronjob')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, '_checkUnavailableCronjob');
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function disabledCronjobWithDisabledMessagePass()
    {
        /** @var d3ordermanager_cronUnavailableException|PHPUnit_Framework_MockObject_MockObject $oExceptionMock */
        $oExceptionMock = $this->getMock(d3ordermanager_cronUnavailableException::class, array(
            'debugOut'
        ));
        $oExceptionMock->method('debugOut')->willReturn(true);

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            'showDisabledMessage',
            'getCronUnavailableException',
        ));
        $oControllerMock->method('showDisabledMessage')->willReturn(true);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);

        $this->_oController = $oControllerMock;

        $this->setExpectedException(d3ordermanager_cronunavailableexception::class);

        $this->callMethod($this->_oController, '_checkDisabledCronjob');
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function disabledCronjobWithInactiveCronPass()
    {
        /** @var d3ordermanager_cronUnavailableException|PHPUnit_Framework_MockObject_MockObject $oExceptionMock */
        $oExceptionMock = $this->getMock(d3ordermanager_cronUnavailableException::class, array(
            'debugOut'
        ));
        $oExceptionMock->method('debugOut')->willReturn(true);

        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getValue',
        ));
        $map = [
            ['blCronActive', false]
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            'showDisabledMessage',
            'getCronUnavailableException',
            '_getSet',
        ));
        $oControllerMock->method('showDisabledMessage')->willReturn(false);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->setExpectedException(d3ordermanager_cronunavailableexception::class);

        $this->callMethod($this->_oController, '_checkDisabledCronjob');
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function disabledCronjobCheckDontPassWithEnabledCronjob()
    {
        /** @var d3ordermanager_cronUnavailableException|PHPUnit_Framework_MockObject_MockObject $oExceptionMock */
        $oExceptionMock = $this->getMock(d3ordermanager_cronUnavailableException::class, array(
            'debugOut'
        ));
        $oExceptionMock->method('debugOut')->willReturn(true);

        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getValue',
        ));
        $map = [
            ['blCronActive', true]
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3ordermanager_response::class, array(
            'showDisabledMessage',
            'getCronUnavailableException',
            '_getSet',
        ));
        $oControllerMock->method('showDisabledMessage')->willReturn(false);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('_getSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, '_checkDisabledCronjob');
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
        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
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
        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
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
     * @param $sLicenseKey
     * @param d3ordermanager $oManager
     * @return null
     */
    protected function _setModuleLicenseKey($sLicenseKey, $oManager = null)
    {
        return null;
    }
}