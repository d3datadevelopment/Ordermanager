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

use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Exception\wrongModIdException;
use D3\ModCfg\Application\Model\Filegenerator\d3filegeneratorcronsh;
use D3\ModCfg\Application\Model\Shopcompatibility\d3ShopCompatibilityAdapterHandler;
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

        $this->_oController = d3GetOxidDIC()->get(d3_cfg_ordermanagerset_main::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->_oController);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::__construct
     * @test
     */
    public function constructorPass()
    {
        $this->assertSame(
            'd3_ordermanager',
            d3GetOxidDIC()->getParameter('d3.ordermanager.modcfgid')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::__construct
     * @test
     */
    public function constructorException()
    {
        /** @var d3_cfg_ordermanagerset_main|MockObject $controller */
        $controller = $this->getMockBuilder(d3_cfg_ordermanagerset_main::class)
            ->disableOriginalConstructor()
            ->getMock();

        d3GetOxidDIC()->setParameter('d3.ordermanager.modcfgid', 'differentModCfgid');

        $this->expectException(wrongModIdException::class);

        $this->callMethod(
            $controller,
            '__construct'
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::getManager
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::getBaseCronPW
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::getViewConfig
     * @test
     * @throws ReflectionException
     */
    public function getViewConfigReturnsRightInstance()
    {
        $this->assertInstanceOf(
            ViewConfig::class,
            $this->callMethod($this->_oController, 'getViewConfig')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::getD3Str
     * @test
     * @throws ReflectionException
     */
    public function getD3StrReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3str::class,
            $this->callMethod($this->_oController, 'getD3Str')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::getCronPath
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::getCronPath
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::getAvailableCronjobIds
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::getCJIDDesc
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::getCJIDDesc
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::getCronTimestampVarName
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::getCronTimestampVarName
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::getFileGeneratorCronSh
     * @test
     * @throws ReflectionException
     */
    public function getFileGeneratorCronShReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3filegeneratorcronsh::class,
            $this->callMethod($this->_oController, 'getFileGeneratorCronSh')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::getCronProviderList
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::getCompatibilityAdapterHandler
     * @test
     * @throws ReflectionException
     */
    public function getCompatibilityAdapterHandlerReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3ShopCompatibilityAdapterHandler::class,
            $this->callMethod($this->_oController, 'getCompatibilityAdapterHandler')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::d3GetActiveShop
     * @test
     * @throws ReflectionException
     */
    public function getActiveShopReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Shop::class,
            $this->callMethod($this->_oController, 'd3GetActiveShop')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::generateCronShFile
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
