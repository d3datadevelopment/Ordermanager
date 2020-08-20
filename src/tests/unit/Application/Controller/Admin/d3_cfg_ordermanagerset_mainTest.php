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
use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Filegenerator\d3filegeneratorcronsh;
use D3\ModCfg\Application\Model\Shopcompatibility\d3ShopCompatibilityAdapterHandler;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Shop;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\ViewConfig;
use PHPUnit_Framework_MockObject_MockObject;
use ReflectionException;
use stdClass;

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
    public function setUp()
    {
        parent::setUp();

        $this->_oController = d3GetModCfgDIC()->get(d3_cfg_ordermanagerset_main::class);
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
    public function cronPwPass()
    {
        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getBaseCronPW'
        ));
        $oManagerMock->method('getBaseCronPW')->willReturn('testBaseCronPw');

        /** @var d3_cfg_ordermanagerset_main|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanagerset_main::class, array(
            'getManager'
        ));
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
    public function getViewConfigReturnsRightInstance()
    {
        $this->assertInstanceOf(
            ViewConfig::class,
            $this->callMethod($this->_oController, 'getViewConfig')
        );
    }

    /**
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
     * @test
     * @throws ReflectionException
     */
    public function cronLinkWithCustPasswordAndCronjobIdPass()
    {
        /** @var d3_cfg_mod|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getValue',
        ));
        $map = [
            ['sCronPassword', 'testCronPassword']
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);

        /** @var d3str|PHPUnit_Framework_MockObject_MockObject $oD3StrMock */
        $oD3StrMock = $this->getMock(d3str::class, array(
            'generateParameterUrl',
        ));
        $oD3StrMock->method('generateParameterUrl')->with(
            $this->stringContains('http://www.example.net/modules/public/d3_ordermanager_cron.php'),
            $this->logicalAnd(
                $this->contains('testCjId'),
                $this->contains('testCronPassword')
            )
        )->willReturn('testUrl');

        /** @var ViewConfig|PHPUnit_Framework_MockObject_MockObject $oViewConfMock */
        $oViewConfMock = $this->getMock(ViewConfig::class, array(
            'getModuleUrl',
            'getActiveShopId',
        ));
        $oViewConfMock->method('getModuleUrl')->willReturn('http://www.example.net/modules/public/d3_ordermanager_cron.php');
        $oViewConfMock->method('getActiveShopId')->willReturn(1);

        /** @var d3_cfg_ordermanagerset_main|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanagerset_main::class, array(
            'getViewConfig',
            'd3GetSet',
            'getBaseCronPW',
            'getD3Str',
        ));
        $oControllerMock->method('getViewConfig')->willReturn($oViewConfMock);
        $oControllerMock->method('d3GetSet')->willReturn($oModCfgMock);
        $oControllerMock->method('getBaseCronPW')->willReturn('testBaseCronPassword');
        $oControllerMock->method('getD3Str')->willReturn($oD3StrMock);

        $this->_oController = $oControllerMock;

        $this->assertEquals(
            'testUrl',
            $this->callMethod($this->_oController, 'getCronLink', array(true, 'testCjId'))
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function cronLinkWithBasePasswordAndNoCronjobIdPass()
    {
        /** @var d3_cfg_mod|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getValue',
        ));
        $map = [
            ['sCronPassword', '']
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);

        /** @var d3str|PHPUnit_Framework_MockObject_MockObject $oD3StrMock */
        $oD3StrMock = $this->getMock(d3str::class, array(
            'generateParameterUrl',
        ));
        $oD3StrMock->method('generateParameterUrl')->with(
            $this->stringContains('http://www.example.net/modules/public/d3_ordermanager_cron.php'),
            $this->logicalAnd(
                $this->logicalNot(
                    $this->contains('testCjId')
                ),
                $this->contains('testBaseCronPassword')
            )
        )->willReturn('testUrl');

        /** @var ViewConfig|PHPUnit_Framework_MockObject_MockObject $oViewConfMock */
        $oViewConfMock = $this->getMock(ViewConfig::class, array(
            'getModuleUrl',
            'getActiveShopId',
        ));
        $oViewConfMock->method('getModuleUrl')->willReturn('http://www.example.net/modules/public/d3_ordermanager_cron.php');
        $oViewConfMock->method('getActiveShopId')->willReturn(1);

        /** @var d3_cfg_ordermanagerset_main|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanagerset_main::class, array(
            'getViewConfig',
            'd3GetSet',
            'getBaseCronPW',
            'getD3Str',
        ));
        $oControllerMock->method('getViewConfig')->willReturn($oViewConfMock);
        $oControllerMock->method('d3GetSet')->willReturn($oModCfgMock);
        $oControllerMock->method('getBaseCronPW')->willReturn('testBaseCronPassword');
        $oControllerMock->method('getD3Str')->willReturn($oD3StrMock);

        $this->_oController = $oControllerMock;

        $this->assertEquals(
            'testUrl',
            $this->callMethod($this->_oController, 'getCronLink', array(true))
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function cronLinkWithoutPasswordAndNoCronjobIdPass()
    {
        /** @var d3_cfg_mod|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getValue',
        ));
        $map = [
            ['sCronPassword', '']
        ];
        $oModCfgMock->method('getValue')->willReturnMap($map);

        /** @var d3str|PHPUnit_Framework_MockObject_MockObject $oD3StrMock */
        $oD3StrMock = $this->getMock(d3str::class, array(
            'generateParameterUrl',
        ));
        $oD3StrMock->method('generateParameterUrl')->with(
            $this->stringContains('http://www.example.net/modules/public/d3_ordermanager_cron.php'),
            $this->logicalAnd(
                $this->logicalNot(
                    $this->contains('testCjId')
                ),
                $this->logicalNot(
                    $this->contains('testBaseCronPassword')
                )
            )
        )->willReturn('testUrl');

        /** @var ViewConfig|PHPUnit_Framework_MockObject_MockObject $oViewConfMock */
        $oViewConfMock = $this->getMock(ViewConfig::class, array(
            'getModuleUrl',
            'getActiveShopId',
        ));
        $oViewConfMock->method('getModuleUrl')->willReturn('http://www.example.net/modules/public/d3_ordermanager_cron.php');
        $oViewConfMock->method('getActiveShopId')->willReturn(1);

        /** @var d3_cfg_ordermanagerset_main|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanagerset_main::class, array(
            'getViewConfig',
            'd3GetSet',
            'getBaseCronPW',
            'getD3Str',
        ));
        $oControllerMock->method('getViewConfig')->willReturn($oViewConfMock);
        $oControllerMock->method('d3GetSet')->willReturn($oModCfgMock);
        $oControllerMock->method('getBaseCronPW')->willReturn('testBaseCronPassword');
        $oControllerMock->method('getD3Str')->willReturn($oD3StrMock);

        $this->_oController = $oControllerMock;

        $this->assertEquals(
            'testUrl',
            $this->callMethod($this->_oController, 'getCronLink', array(false))
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function cronPathWithCronjobIdPass()
    {
        /** @var ViewConfig|PHPUnit_Framework_MockObject_MockObject $oViewConfMock */
        $oViewConfMock = $this->getMock(ViewConfig::class, array(
            'getActiveShopId',
        ));
        $oViewConfMock->method('getActiveShopId')->willReturn(1);

        /** @var d3_cfg_ordermanagerset_main|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanagerset_main::class, array(
            'getViewConfig',
        ));
        $oControllerMock->method('getViewConfig')->willReturn($oViewConfMock);

        $this->_oController = $oControllerMock;

        $this->assertRegExp(
            '/(?!http).*php.*\/d3_ordermanager_cron\srun\s[0-9]\stestCjId/i',
            $this->callMethod($this->_oController, 'getCronPath', array('testCjId'))
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function cronPathWithNoCronjobIdPass()
    {
        define(VENDOR_PATH, 'TESTPATH');

        /** @var ViewConfig|PHPUnit_Framework_MockObject_MockObject $oViewConfMock */
        $oViewConfMock = $this->getMock(ViewConfig::class, array(
            'getActiveShopId',
        ));
        $oViewConfMock->method('getActiveShopId')->willReturn(1);

        /** @var d3_cfg_ordermanagerset_main|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanagerset_main::class, array(
            'getViewConfig',
        ));
        $oControllerMock->method('getViewConfig')->willReturn($oViewConfMock);

        $this->_oController = $oControllerMock;

        $this->assertRegExp(
            '/(?!http).*php.*\/d3_ordermanager_cron\srun\s[0-9]/i',
            $this->callMethod($this->_oController, 'getCronPath', array())
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetAvailableCronjobIds()
    {
        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getAvailableCronjobIds',
        ));
        $oManagerMock->method('getAvailableCronjobIds')->willReturn(array(1,5,8,'foobar'));

        /** @var d3_cfg_ordermanagerset_main|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanagerset_main::class, array(
            'getManager',
        ));
        $oControllerMock->method('getManager')->willReturn($oManagerMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            array(1,5,8,'foobar'),
            $this->callMethod($this->_oController, 'getAvailableCronjobIds')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetCjIdDescriptionForOne()
    {
        $aCjId = array(
            'count' => 1,
            'id'    => 'testid'
        );

        $sDesc = $this->callMethod($this->_oController, 'getCJIDDesc', array($aCjId));
        $this->assertContains('testid', $sDesc);
        $this->assertContains('1', $sDesc);
        $this->assertTrue(strlen($sDesc) > 11);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetCjIdDescriptionForMultiple()
    {
        $aCjId = array(
            'count' => 5,
            'id'    => 'testid'
        );

        $sDesc = $this->callMethod($this->_oController, 'getCJIDDesc', array($aCjId));
        $this->assertContains('testid', $sDesc);
        $this->assertContains('5', $sDesc);
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
        $sVarName = $this->callMethod($this->_oController, 'getCronTimestampVarName', array('testid'));

        $this->assertTrue(strlen($sVarName) > 6);
        $this->assertContains('testid', $sVarName);
    }

    /**
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
     * @test
     * @throws ReflectionException
     */
    public function canGetCronProviderList()
    {
        /** @var d3filegeneratorcronsh|PHPUnit_Framework_MockObject_MockObject $oFileGeneratorCronShMock */
        $oFileGeneratorCronShMock = $this->getMock(d3filegeneratorcronsh::class, array(
            'getContentList'
        ));
        $oFileGeneratorCronShMock->method('getContentList')->willReturn('contentList');

        /** @var d3_cfg_ordermanagerset_main|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanagerset_main::class, array(
            'getFileGeneratorCronSh'
        ));
        $oControllerMock->method('getFileGeneratorCronSh')->willReturn($oFileGeneratorCronShMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            'contentList',
            $this->callMethod($this->_oController, 'getCronProviderList')
        );
    }

    /**
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
     * @test
     * @throws ReflectionException
     */
    public function canGenerateCronShFile()
    {
        $_POST['cronid'] = 'testCronId';

        /** @var d3ShopCompatibilityAdapterHandler|PHPUnit_Framework_MockObject_MockObject $oShopCompatibilityAdapterHandlerMock */
        $oShopCompatibilityAdapterHandlerMock = $this->getMock(d3ShopCompatibilityAdapterHandler::class, array(
            'call'
        ));
        $oShopCompatibilityAdapterHandlerMock->method('call')->willReturnCallback(array($this, 'shopCompatHandlerCallback'));

        /** @var Shop|PHPUnit_Framework_MockObject_MockObject $oShopMock */
        $oShopMock = $this->getMock(Shop::class, array(
            'getId'
        ));
        $oShopMock->method('getId')->willReturn('shopid');

        /** @var d3filegeneratorcronsh|PHPUnit_Framework_MockObject_MockObject $oFileGeneratorCronShMock */
        $oFileGeneratorCronShMock = $this->getMock(d3filegeneratorcronsh::class, array(
            'setContentType',
            'setScriptPath',
            'setSortedParameterList',
            'startDownload',
        ));
        $oFileGeneratorCronShMock->method('setContentType')->willReturn(true);
        $oFileGeneratorCronShMock->method('setScriptPath')->willReturn(true);
        $oFileGeneratorCronShMock->method('setSortedParameterList')->willReturn(true);
        $oFileGeneratorCronShMock->expects($this->once())->method('startDownload')->with(
            $this->stringContains('d3ordermanager_shopid_testCronId.sh')
        )->willReturn(true);

        /** @var d3_cfg_ordermanagerset_main|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanagerset_main::class, array(
            'getCompatibilityAdapterHandler',
            'd3GetActiveShop',
            'getFileGeneratorCronSh',
        ));
        $oControllerMock->method('getCompatibilityAdapterHandler')->willReturn($oShopCompatibilityAdapterHandlerMock);
        $oControllerMock->method('d3GetActiveShop')->willReturn($oShopMock);
        $oControllerMock->method('getFileGeneratorCronSh')->willReturn($oFileGeneratorCronShMock);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, 'generateCronShFile');
    }

    public function shopCompatHandlerCallback()
    {
        $args = func_get_args();
        return '/module/path/'.$args[1][1];
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