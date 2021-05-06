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
use D3\ModCfg\Application\Model\d3filesystem;
use D3\ModCfg\Application\Model\d3str;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_mall;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Language;
use PHPUnit_Framework_MockObject_MockObject;
use ReflectionException;
use stdClass;

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
    public function setUp()
    {
        parent::setUp();

        $this->_oController = d3GetModCfgDIC()->get(d3_cfg_ordermanageritem_mall::class);
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
    public function profileObjectHasRightInstance()
    {
        $this->assertInstanceOf(
            d3ordermanager::class,
            $this->callMethod($this->_oController, 'getProfile')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function renderWithOxidPass()
    {
        $_POST['oxid'] = 'foobar';

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'loadInLang',
        ));
        $oProfileMock->expects($this->once())->method('loadInLang')->willReturn(true);

        /** @var d3_cfg_ordermanageritem_mall|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_mall::class, array(
            'getProfile',
            '_d3LoadInOtherLang',
            '_isSetOxid'
        ));
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);
        $oControllerMock->method('_d3LoadInOtherLang')->willReturn($oProfileMock);
        $oControllerMock->method('_isSetOxid')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->assertRegExp(
            '@.+\.tpl@i',
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

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'loadInLang',
        ));
        $oProfileMock->expects($this->never())->method('loadInLang')->willReturn(true);

        /** @var d3_cfg_ordermanageritem_mall|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_mall::class, array(
            'getProfile',
            '_d3LoadInOtherLang',
            '_isSetOxid'
        ));
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);
        $oControllerMock->method('_d3LoadInOtherLang')->willReturn($oProfileMock);
        $oControllerMock->method('_isSetOxid')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->assertRegExp(
            '@.+\.tpl@i',
            $this->callMethod($this->_oController, 'render')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetUserMessages()
    {
        $this->assertInternalType(
            'array',
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
        /** @var d3filesystem|PHPUnit_Framework_MockObject_MockObject $oFileSystemMock */
        $oFileSystemMock = $this->getMock(d3filesystem::class, array(
            'unprefixedslashit',
            'splitFilename',
        ));
        $oFileSystemMock->method('unprefixedslashit')->willReturnCallback(array($this, 'firstArgumentReturnCallback'));
        $oFileSystemMock->method('splitFilename')->willReturn(
            array('name' => 'filename', 'ext' => 'html')
        );

        $definitions = d3GetModCfgDIC()->getDefinitions();
        d3GetModCfgDIC()->set(d3filesystem::class, $oFileSystemMock);

        /** @var Language|PHPUnit_Framework_MockObject_MockObject $oLangMock */
        $oLangMock = $this->getMock(Language::class, array(
            'TranslateString',
        ));
        $oLangMock->method('TranslateString')->willReturn('modulepath');

        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getHelpURL'
        ));
        $oModCfgMock->method('getHelpURL')->willReturn('https://faq.d3data.de/module/');

        /** @var d3_cfg_ordermanageritem_mall|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_mall::class, array(
            'd3GetSet',
            'getLang',
        ));
        $oControllerMock->method('d3GetSet')->willReturn($oModCfgMock);
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->setValue($oControllerMock, '_sHelpLinkMLAdd', 'foobar');

        $this->_oController = $oControllerMock;

        $this->assertEquals(
            'https://faq.d3data.de/module/modulepath',
            $this->callMethod($this->_oController, 'getHelpURL')
        );

        d3GetModCfgDIC()->reset();
        d3GetModCfgDIC()->setDefinitions($definitions);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetHelpUrlWithoutExtension()
    {
        /** @var d3filesystem|PHPUnit_Framework_MockObject_MockObject $oFileSystemMock */
        $oFileSystemMock = $this->getMock(d3filesystem::class, array(
            'splitFilename',
        ));
        $oFileSystemMock->method('splitFilename')->willReturn(
            array('name' => 'filename', 'ext' => '')
        );

        $definitions = d3GetModCfgDIC()->getDefinitions();
        d3GetModCfgDIC()->set(d3filesystem::class, $oFileSystemMock);

        /** @var d3str|PHPUnit_Framework_MockObject_MockObject $oD3StrMock */
        $oD3StrMock = $this->getMock(d3str::class, array(
            'unprefixedslashit',
            'trailingslashit',
        ));
        $oD3StrMock->method('unprefixedslashit')->willReturnCallback(array($this, 'firstArgumentReturnCallback'));
        $oD3StrMock->expects($this->once())->method('trailingslashit')->willReturnCallback(array($this, 'firstArgumentReturnCallback'));

        d3GetModCfgDIC()->set(d3str::class, $oD3StrMock);

        /** @var Language|PHPUnit_Framework_MockObject_MockObject $oLangMock */
        $oLangMock = $this->getMock(Language::class, array(
            'TranslateString',
        ));
        $oLangMock->method('TranslateString')->willReturn('modulepath');

        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getHelpURL'
        ));
        $oModCfgMock->method('getHelpURL')->willReturn('https://faq.d3data.de/module/');

        /** @var d3_cfg_ordermanageritem_mall|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_mall::class, array(
            'd3GetSet',
            'getLang',
        ));
        $oControllerMock->method('d3GetSet')->willReturn($oModCfgMock);
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->setValue($oControllerMock, '_sHelpLinkMLAdd', 'foobar');

        $this->_oController = $oControllerMock;

        $this->assertEquals(
            'https://faq.d3data.de/module/modulepath',
            $this->callMethod($this->_oController, 'getHelpURL')
        );

        d3GetModCfgDIC()->reset();
        d3GetModCfgDIC()->setDefinitions($definitions);
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
    public function modcfgObjectIsRightInstance()
    {
        $this->assertInstanceOf(
            d3_cfg_mod::class,
            $this->callMethod($this->_oController, 'd3GetSet')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function naviItemshasRightType()
    {
        $this->assertInternalType(
            'array',
            $this->callMethod($this->_oController, 'getNaviItems')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function menuItemTitleHasRightType()
    {
        $this->assertInternalType(
            'string',
            $this->callMethod($this->_oController, 'd3GetMenuItemTitle')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function menuSubItemTitleHasRightType()
    {
        $this->assertInternalType(
            'string',
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
            $this->callMethod($this->_oController, '_isSetOxid', array('foobar'))
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function checkUnsetOxidPass()
    {
        $this->assertFalse(
            $this->callMethod($this->_oController, '_isSetOxid', array(-1))
        );
        $this->assertFalse(
            $this->callMethod($this->_oController, '_isSetOxid', array(null))
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canLoadInOtherLang()
    {
        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'getAvailableInLangs',
            'loadInLang',
        ));
        $oProfileMock->method('getAvailableInLangs')->willReturn(array('en' => 'english'));
        $oProfileMock->expects($this->once())->method('loadInLang')->willReturn(true);

        $this->setValue($this->_oController, '_iEditLang', 'de');

        $this->assertSame(
            $oProfileMock,
            $this->callMethod($this->_oController, '_d3LoadInOtherLang', array($oProfileMock, 'foobar'))
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
