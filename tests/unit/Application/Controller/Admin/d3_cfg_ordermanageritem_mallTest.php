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

use D3\ModCfg\Application\Model\d3filesystem;
use D3\ModCfg\Application\Model\d3str;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_mall;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Facts\Facts;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;
use stdClass;

/**
 * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_mall
 */
class d3_cfg_ordermanageritem_mallTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_cfg_ordermanageritem_mall */
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

        $this->_oController = oxNew(d3_cfg_ordermanageritem_mall::class);
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
    public function renderWithOxidPass()
    {
        $_POST['oxid'] = 'foobar';

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['loadInLang'])
            ->getMock();
        $oProfileMock->expects($this->once())->method('loadInLang')->willReturn(true);

        /** @var d3_cfg_ordermanageritem_mall|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_mall::class)
            ->onlyMethods([
                'getProfile',
                '_d3LoadInOtherLang',
                '_isSetOxid',
            ])
            ->getMock();
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);
        $oControllerMock->method('_d3LoadInOtherLang')->willReturn($oProfileMock);
        $oControllerMock->method('_isSetOxid')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            strtoupper((oxNew(Facts::class, __DIR__ ?? 'path'))->getEdition()) === 'EE' ?
                'admin_mall' :
                '@d3ordermanager/admin/d3_cfg_ordermanageritem_mall',
            $this->callMethod($this->_oController, 'render')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function renderWithoutOxidPass()
    {
        $_POST['oxid'] = null;

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['loadInLang'])
            ->getMock();
        $oProfileMock->expects($this->never())->method('loadInLang')->willReturn(true);

        /** @var d3_cfg_ordermanageritem_mall|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_mall::class)
            ->onlyMethods([
                'getProfile',
                '_d3LoadInOtherLang',
                '_isSetOxid',
            ])
            ->getMock();
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);
        $oControllerMock->method('_d3LoadInOtherLang')->willReturn($oProfileMock);
        $oControllerMock->method('_isSetOxid')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            strtoupper((oxNew(Facts::class, __DIR__ ?? 'path'))->getEdition()) === 'EE' ?
                'admin_mall' :
                '@d3ordermanager/admin/d3_cfg_ordermanageritem_mall',
            $this->callMethod($this->_oController, 'render')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetUserMessages()
    {
        $this->assertIsArray(
            $this->callMethod($this->_oController, 'getUserMessages')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function languageObjectIsRightInstance()
    {
        $this->assertInstanceOf(
            Language::class,
            $this->callMethod($this->_oController, 'getLang')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetHelpUrlWithExtension()
    {
        /** @var d3filesystem|MockObject $oFileSystemMock */
        $oFileSystemMock = $this->getMockBuilder(d3filesystem::class)
            ->onlyMethods([
                'unprefixedslashit',
                'splitFilename',
            ])
            ->getMock();
        $oFileSystemMock->method('unprefixedslashit')->willReturnCallback([$this, 'firstArgumentReturnCallback']);
        $oFileSystemMock->method('splitFilename')->willReturn(
            ['name' => 'filename', 'ext' => 'html']
        );

        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->onlyMethods(['TranslateString'])
            ->getMock();
        $oLangMock->method('TranslateString')->willReturn('modulepath');

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['getHelpURL'])
            ->getMock();
        $oModCfgMock->method('getHelpURL')->willReturn('https://faq.d3data.de/module/');

        /** @var d3_cfg_ordermanageritem_mall|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_mall::class)
            ->onlyMethods([
                'd3GetOrderManagerConfig',
                'getLang',
                'created3Filesystem',
            ])
            ->getMock();
        $oControllerMock->method('d3GetOrderManagerConfig')->willReturn($oModCfgMock);
        $oControllerMock->method('getLang')->willReturn($oLangMock);
        $oControllerMock->method('created3Filesystem')->willReturn($oFileSystemMock);

        $this->setValue($oControllerMock, '_sHelpLinkMLAdd', 'foobar');

        $this->_oController = $oControllerMock;

        $this->assertEquals(
            'https://faq.d3data.de/module/modulepath',
            $this->callMethod($this->_oController, 'getHelpURL')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetHelpUrlWithoutExtension()
    {
        /** @var d3filesystem|MockObject $oFileSystemMock */
        $oFileSystemMock = $this->getMockBuilder(d3filesystem::class)
            ->onlyMethods(['splitFilename'])
            ->getMock();
        $oFileSystemMock->method('splitFilename')->willReturn(
            ['name' => 'filename', 'ext' => '']
        );

        /** @var d3str|MockObject $oD3StrMock */
        $oD3StrMock = $this->getMockBuilder(d3str::class)
            ->onlyMethods([
                'unprefixedslashit',
                'trailingslashit',
            ])
            ->getMock();
        $oD3StrMock->method('unprefixedslashit')->willReturnCallback([$this, 'firstArgumentReturnCallback']);
        $oD3StrMock->expects(self::once())->method('trailingslashit')
            ->willReturnCallback([$this, 'firstArgumentReturnCallback']);

        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->onlyMethods(['TranslateString'])
            ->getMock();
        $oLangMock->method('TranslateString')->willReturn('modulepath');

        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['getHelpURL'])
            ->getMock();
        $oModCfgMock->method('getHelpURL')->willReturn('https://faq.d3data.de/module/');

        /** @var d3_cfg_ordermanageritem_mall|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_mall::class)
            ->onlyMethods([
                'd3GetOrderManagerConfig',
                'getLang',
                'createD3Str',
                'created3Filesystem',
            ])
            ->getMock();
        $oControllerMock->method('d3GetOrderManagerConfig')->willReturn($oModCfgMock);
        $oControllerMock->method('getLang')->willReturn($oLangMock);
        $oControllerMock->method('createD3Str')->willReturn($oD3StrMock);
        $oControllerMock->method('created3Filesystem')->willReturn($oFileSystemMock);

        $this->setValue($oControllerMock, '_sHelpLinkMLAdd', 'foobar');

        $this->_oController = $oControllerMock;

        $this->assertEquals(
            'https://faq.d3data.de/module/modulepath',
            $this->callMethod($this->_oController, 'getHelpURL')
        );
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
    public function naviItemshasRightType()
    {
        $this->assertIsArray(
            $this->callMethod($this->_oController, 'getNaviItems')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function menuItemTitleHasRightType()
    {
        $this->assertIsString(
            $this->callMethod($this->_oController, 'd3GetMenuItemTitle')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function menuSubItemTitleHasRightType()
    {
        $this->assertIsString(
            $this->callMethod($this->_oController, 'd3GetMenuSubItemTitle')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function checkSetOxidPass()
    {
        $this->assertTrue(
            $this->callMethod($this->_oController, '_isSetOxid', ['foobar'])
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function checkUnsetOxidPass()
    {
        $this->assertFalse(
            $this->callMethod($this->_oController, '_isSetOxid', [-1])
        );
        $this->assertFalse(
            $this->callMethod($this->_oController, '_isSetOxid', [null])
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canLoadInOtherLang()
    {
        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods([
                'getAvailableInLangs',
                'loadInLang',
            ])
            ->getMock();
        $oProfileMock->method('getAvailableInLangs')->willReturn(['en' => 'english']);
        $oProfileMock->expects($this->once())->method('loadInLang')->willReturn(true);

        $this->setValue($this->_oController, '_iEditLang', 'de');

        $this->assertSame(
            $oProfileMock,
            $this->callMethod($this->_oController, '_d3LoadInOtherLang', [$oProfileMock, 'foobar'])
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
