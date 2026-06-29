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

use D3\ModCfg\Application\Model\Filegenerator\d3filegeneratorcronsh;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Shop;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\ViewConfig;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;

/**
 * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main
 */
class d3_cfg_ordermanagerset_mainTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_cfg_ordermanagerset_main */
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

        $this->_oController = oxNew(d3_cfg_ordermanagerset_main::class);
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
    public function cronPwPass()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getBaseCronPW'])
            ->getMock();
        $oManagerMock->method('getBaseCronPW')->willReturn('testBaseCronPw');

        /** @var d3_cfg_ordermanagerset_main|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanagerset_main::class)
            ->onlyMethods(['getManager'])
            ->getMock();
        $oControllerMock->method('getManager')->willReturn($oManagerMock);

        $this->_oController = $oControllerMock;

        $this->assertEquals(
            'testBaseCronPw',
            $this->callMethod($this->_oController, 'getBaseCronPW')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function cronPathWithCronjobIdPass()
    {
        /** @var ViewConfig|MockObject $oViewConfMock */
        $oViewConfMock = $this->getMockBuilder(ViewConfig::class)
            ->onlyMethods(['getActiveShopId'])
            ->getMock();
        $oViewConfMock->method('getActiveShopId')->willReturn(1);

        /** @var d3_cfg_ordermanagerset_main|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanagerset_main::class)
            ->onlyMethods(['getViewConfig'])
            ->getMock();
        $oControllerMock->method('getViewConfig')->willReturn($oViewConfMock);

        $this->_oController = $oControllerMock;

        $this->assertMatchesRegularExpression(
            '/(?!http).*php.*\/d3_ordermanager_cron\srun\s[0-9]\stestCjId/i',
            $this->callMethod($this->_oController, 'getCronPath', ['testCjId'])
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function cronPathWithNoCronjobIdPass()
    {
        define(VENDOR_PATH, 'TESTPATH');

        /** @var ViewConfig|MockObject $oViewConfMock */
        $oViewConfMock = $this->getMockBuilder(ViewConfig::class)
            ->onlyMethods(['getActiveShopId'])
            ->getMock();
        $oViewConfMock->method('getActiveShopId')->willReturn(1);

        /** @var d3_cfg_ordermanagerset_main|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanagerset_main::class)
            ->onlyMethods(['getViewConfig'])
            ->getMock();
        $oControllerMock->method('getViewConfig')->willReturn($oViewConfMock);

        $this->_oController = $oControllerMock;

        $this->assertMatchesRegularExpression(
            '/(?!http).*php.*\/d3_ordermanager_cron\srun\s[0-9]/i',
            $this->callMethod($this->_oController, 'getCronPath', [])
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetAvailableCronjobIds()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getAvailableCronjobIds'])
            ->getMock();
        $oManagerMock->method('getAvailableCronjobIds')->willReturn([1,5,8,'foobar']);

        /** @var d3_cfg_ordermanagerset_main|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanagerset_main::class)
            ->onlyMethods(['getManager'])
            ->getMock();
        $oControllerMock->method('getManager')->willReturn($oManagerMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            [1,5,8,'foobar'],
            $this->callMethod($this->_oController, 'getAvailableCronjobIds')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetCjIdDescriptionForOne()
    {
        $aCjId = [
            'count' => 1,
            'id'    => 'testid',
        ];

        $sDesc = $this->callMethod($this->_oController, 'getCJIDDesc', [$aCjId]);
        $this->assertStringContainsStringIgnoringCase('testid', $sDesc);
        $this->assertStringContainsStringIgnoringCase('1', $sDesc);
        $this->assertTrue(strlen($sDesc) > 11);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetCjIdDescriptionForMultiple()
    {
        $aCjId = [
            'count' => 5,
            'id'    => 'testid',
        ];

        $sDesc = $this->callMethod($this->_oController, 'getCJIDDesc', [$aCjId]);
        $this->assertStringContainsStringIgnoringCase('testid', $sDesc);
        $this->assertStringContainsStringIgnoringCase('5', $sDesc);
        $this->assertTrue(strlen($sDesc) > 11);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetCronTimestampVarNameWithoutCronId()
    {
        $this->assertTrue(
            strlen($this->callMethod($this->_oController, 'getCronTimestampVarName')) > 5
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetCronTimestampVarNameWithCronId()
    {
        $sVarName = $this->callMethod($this->_oController, 'getCronTimestampVarName', ['testid']);

        $this->assertTrue(strlen($sVarName) > 6);
        $this->assertStringContainsStringIgnoringCase('testid', $sVarName);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetCronProviderList()
    {
        $expected = ['contentList'];

        /** @var d3filegeneratorcronsh|MockObject $oFileGeneratorCronShMock */
        $oFileGeneratorCronShMock = $this->getMockBuilder(d3filegeneratorcronsh::class)
            ->onlyMethods(['getContentList'])
            ->getMock();
        $oFileGeneratorCronShMock->method('getContentList')->willReturn($expected);

        /** @var d3_cfg_ordermanagerset_main|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanagerset_main::class)
            ->onlyMethods(['getFileGeneratorCronSh'])
            ->getMock();
        $oControllerMock->method('getFileGeneratorCronSh')->willReturn($oFileGeneratorCronShMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $expected,
            $this->callMethod($this->_oController, 'getCronProviderList')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGenerateCronShFile()
    {
        $_POST['cronid'] = 'testCronId';

        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->onlyMethods(['getId'])
            ->getMock();
        $oShopMock->method('getId')->willReturn('shopid');

        /** @var d3filegeneratorcronsh|MockObject $oFileGeneratorCronShMock */
        $oFileGeneratorCronShMock = $this->getMockBuilder(d3filegeneratorcronsh::class)
            ->onlyMethods([
                'setContentType',
                'setScriptPath',
                'setSortedParameterList',
                'startDownload', ])
            ->getMock();
        $oFileGeneratorCronShMock->method('setContentType');
        $oFileGeneratorCronShMock->method('setScriptPath');
        $oFileGeneratorCronShMock->method('setSortedParameterList');
        $oFileGeneratorCronShMock->expects($this->once())->method('startDownload')->with(
            $this->stringContains('d3ordermanager_shopid_testCronId.sh')
        );

        /** @var d3_cfg_ordermanagerset_main|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanagerset_main::class)
            ->onlyMethods([
                'd3GetActiveShop',
                'getFileGeneratorCronSh',
            ])
            ->getMock();
        $oControllerMock->method('d3GetActiveShop')->willReturn($oShopMock);
        $oControllerMock->method('getFileGeneratorCronSh')->willReturn($oFileGeneratorCronShMock);

        $this->_oController = $oControllerMock;
        $_POST['crontype'] = 'ctype';

        $this->callMethod($this->_oController, 'generateCronShFile');
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
