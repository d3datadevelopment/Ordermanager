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

namespace D3\Ordermanager\tests\unit\Application\Controller;

use D3\ModCfg\Application\Model\Log\d3log;
use D3\Ordermanager\Application\Controller\d3ordermanager_response;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_execute;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_cronUnavailableException;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use Generator;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Registry;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;
use stdClass;

/**
 * @covers \D3\Ordermanager\Application\Controller\d3ordermanager_response
 */
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

        $this->_oController = oxNew(d3ordermanager_response::class);
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
    public function isCLIPass()
    {
        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                'isClI'
            )
        );
    }

    /**
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
            ->addMethods(['setValue'])
            ->addMethods(['saveNoLicenseRefresh'])
            ->getMock();
        $oModCfgMock->method('setValue')->willReturn(true);
        $oModCfgMock->method('saveNoLicenseRefresh')->willReturn(true);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods(['_checkUnavailableCronjob', '_getCronTimestampVarName', '_startJobs', 'd3GetOrderManagerLog', 'd3GetOrderManagerConfig'])
            ->getMock();
        $oControllerMock->method('_checkUnavailableCronjob')->willReturn(null);
        $oControllerMock->method('_getCronTimestampVarName')->willReturn('varName');
        $oControllerMock->expects($this->once())->method('_startJobs')->willReturn(true);
        $oControllerMock->method('d3GetOrderManagerLog')->willReturn($oLogMock);
        $oControllerMock->method('d3GetOrderManagerConfig')->willReturn($oModCfgMock);

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
        $oLogMock = $this->getMockBuilder(d3log::class)
            ->onlyMethods(['log'])
            ->getMock();
        $oLogMock->method('log')->willReturnSelf();

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['setValue', 'saveNoLicenseRefresh', 'd3getLog'])
            ->getMock();
        $oModCfgMock->method('setValue')->willReturn(true);
        $oModCfgMock->method('saveNoLicenseRefresh')->willReturn(true);
        $oModCfgMock->method('d3getLog')->willReturn($oLogMock);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                'd3GetOrderManagerConfig',
                '_checkUnavailableCronjob',
                '_getCronTimestampVarName',
                '_startJobs', ])
            ->getMock();
        $oControllerMock->method('d3GetOrderManagerConfig')->willReturn($oModCfgMock);
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
        throw oxNew(StandardException::class, 'cron unavailable');
    }

    /**
     * @throws d3ordermanager_cronUnavailableException
     * @throws Exception
     */
    public function unavailableCronjobCallback()
    {
        throw oxNew(d3ordermanager_cronUnavailableException::class, 'cron unavailable');
    }

    /**
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
                'getId',
                'load',
            ])
            ->getMock();
        $oManagerMock->method('getId')->willReturn('sId');
        $oManagerMock->method('load')->willReturn(true);

        /** @var d3ordermanager_execute|MockObject $oManagerExecuteMock */
        $oManagerExecuteMock = $this->getMockBuilder(d3ordermanager_execute::class)
            ->onlyMethods([
                'setManager',
                'startJobExecution',
                'finishJobExecution',
                'd3GetOrderManagerLog',
            ])
            ->setConstructorArgs([$oManagerMock])
            ->getMock();
        $oManagerExecuteMock->method('setManager');
        $oManagerExecuteMock->expects($this->exactly(3))->method('startJobExecution');
        $oManagerExecuteMock->expects($this->once())->method('finishJobExecution');
        $oManagerExecuteMock->method('d3GetOrderManagerLog')->willReturn($oLogMock);

        /** @var d3ordermanagerlist|MockObject $oListMock */
        $oListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods([
                'setCronJobId',
                'setCustomSorting',
                'selectString',
            ])
            ->getMock();
        $oListMock->method('setCronJobId');
        $oListMock->method('setCustomSorting');
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
     * @test
     * @throws ReflectionException
     */
    public function getManagerReturnsRightInstance()
    {
        $lastLanguage = Registry::getLang();

        $languageMock = $this->getMockBuilder(Language::class)
            ->onlyMethods(['getTplLanguage'])
            ->getMock();
        $languageMock->method('getTplLanguage')->willReturn(5);

        Registry::set(Language::class, $languageMock);

        $manager = $this->callMethod($this->_oController, 'getManager');

        try {
            $this->assertInstanceOf(d3ordermanager::class, $manager);
            $this->assertSame(5, $manager->getLanguage());
        } finally {
            Registry::set(Language::class, $lastLanguage);
        }
    }

    /**
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
                'd3GetOrderManagerConfig',
                'hasValidAccessKey',
                'getManager',
            ])
            ->getMock();
        $oControllerMock->method('d3GetOrderManagerConfig')->willReturn($oModCfgMock);
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
                'd3GetOrderManagerConfig',
                'hasValidAccessKey',
                'getManager',
            ])
            ->getMock();
        $oControllerMock->method('d3GetOrderManagerConfig')->willReturn($oModCfgMock);
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
     * @test
     * @throws ReflectionException
     */
    public function unavailableInactiveCronjobPass()
    {
        /** @var d3ordermanager_cronUnavailableException|MockObject $oExceptionMock */
        $oExceptionMock = $this->getMockBuilder(d3ordermanager_cronUnavailableException::class)
            ->getMock();

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
                'd3GetOrderManagerConfig',
            ])
            ->getMock();
        $oControllerMock->method('_checkAccessKey')->willReturn(true);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('d3GetOrderManagerConfig')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->expectException(d3ordermanager_cronUnavailableException::class);

        $this->callMethod($this->_oController, '_checkUnavailableCronjob');
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function unavailableCronjobWrongAccessKeyPass()
    {
        /** @var d3ordermanager_cronUnavailableException|MockObject $oExceptionMock */
        $oExceptionMock = $this->getMockBuilder(d3ordermanager_cronUnavailableException::class)
            ->getMock();

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
                'd3GetOrderManagerConfig',
            ])
            ->getMock();
        $oControllerMock->method('_checkAccessKey')->willReturn(false);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('d3GetOrderManagerConfig')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->expectException(d3ordermanager_cronUnavailableException::class);

        $this->callMethod($this->_oController, '_checkUnavailableCronjob');
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function unavailableCronjobInactiveCronPass()
    {
        /** @var d3ordermanager_cronUnavailableException|MockObject $oExceptionMock */
        $oExceptionMock = $this->getMockBuilder(d3ordermanager_cronUnavailableException::class)
            ->getMock();

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
                'd3GetOrderManagerConfig',
            ])
            ->getMock();
        $oControllerMock->method('_checkAccessKey')->willReturn(true);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('d3GetOrderManagerConfig')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->expectException(d3ordermanager_cronUnavailableException::class);

        $this->callMethod($this->_oController, '_checkUnavailableCronjob');
    }

    /**
     * @test
     * @throws ReflectionException
     * @doesNotPerformAssertions
     */
    public function unavailableEnabledCronjobPass()
    {
        /** @var d3ordermanager_cronUnavailableException|MockObject $oExceptionMock */
        $oExceptionMock = $this->getMockBuilder(d3ordermanager_cronUnavailableException::class)
            ->getMock();

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
                'd3GetOrderManagerConfig',
            ])
            ->getMock();
        $oControllerMock->expects($this->any())->method('_checkAccessKey')->willReturn(true);
        $oControllerMock->method('getCronUnavailableException')->willReturn($oExceptionMock);
        $oControllerMock->method('d3GetOrderManagerConfig')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, '_checkUnavailableCronjob');
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
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods(['_getCronJobIdParameter'])
            ->getMock();
        $oControllerMock->expects($this->any())->method('_getCronJobIdParameter')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->assertStringContainsStringIgnoringCase('Timestamp', $this->callMethod($this->_oController, '_getCronTimestampVarName'));
    }

    /**
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
     * @test
     * @throws ReflectionException
     * @dataProvider getLastExecDatePassedDataProvider
     */
    public function getLastExecDatePassed(?string $timestampValue, array $expected)
    {
        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['getValue'])
            ->getMock();
        $map = [
            ['tsVarName', $timestampValue],
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);

        /** @var d3ordermanager_response|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods([
                '_getCronTimestampVarName',
                'd3GetOrderManagerConfig',
            ])
            ->getMock();
        $oControllerMock->expects($this->once())->method('_getCronTimestampVarName')->willReturn('tsVarName');
        $oControllerMock->expects($this->once())->method('d3GetOrderManagerConfig')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->assertContains(
            $this->callMethod(
                $this->_oController,
                'getLastExecDate'
            ),
            $expected
        );
    }

    public static function getLastExecDatePassedDataProvider(): Generator
    {
        yield 'null value' => [null, ['']];
        yield 'timestamp value' => ['2021-12-24 18:00:00', ['2021-12-24 18:00:00', '24.12.2021 18:00:00']];
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getLastExecDateInfoPassed()
    {
        $lastLanguage = Registry::getLang();

        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->onlyMethods(['translateString'])
            ->getMock();
        $oLangMock->method('translateString')->willReturn('%1$s -- %2$s');
        Registry::set(Language::class, $oLangMock);

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
            ])
            ->getMock();
        $oControllerMock->expects($this->once())->method('_getCronJobIdParameter')->willReturn('1');
        $oControllerMock->method('getManager')->willReturn($oManagerMock);
        $oControllerMock->method('getLastExecDate')->willReturn('2020-02-02');

        $this->_oController = $oControllerMock;

        try {
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
        } finally {
            Registry::set(Language::class, $lastLanguage);
        }
    }

    /**
     * @test
     * @return void
     * @throws ReflectionException
     */
    public function getStatisticTest()
    {
        $managerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['getAffectedItemsCount'])
            ->getMock();
        $managerListMock->expects($this->once())->method('getAffectedItemsCount');

        $sut = $this->getMockBuilder(d3ordermanager_response::class)
            ->onlyMethods(['getManagerList'])
            ->getMock();
        $sut->method('getManagerList')->willReturn($managerListMock);

        $this->callMethod(
            $sut,
            'getStatistic'
        );
    }

    /**
     * @param bool $admin
     * @param int $invocationCount
     * @return void
     * @throws ReflectionException
     * @dataProvider setAdminContextDataProvider
     */
    public function testSetAdminContext(bool $admin, int $invocationCount)
    {
        $lastConfig = Registry::getConfig();

        $configMock = $this->getMockBuilder(Config::class)
            ->onlyMethods(['isAdmin', 'setAdminMode'])
            ->getMock();
        $configMock->method('isAdmin')->willReturn(true);
        $configMock->expects(self::exactly($invocationCount))->method('setAdminMode');
        Registry::set(Config::class, $configMock);

        try {
            $this->callMethod(
                $this->_oController,
                'setAdminContext',
                [$admin]
            );
        } finally {
            Registry::set(Config::class, $lastConfig);
        }
    }

    public static function setAdminContextDataProvider(): Generator
    {
        yield 'change required' => [false, 1];
        yield 'unchanged' => [true, 0];
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
