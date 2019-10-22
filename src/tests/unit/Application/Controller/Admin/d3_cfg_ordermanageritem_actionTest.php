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

use D3\ModCfg\Application\Model\Shopcompatibility\d3ShopCompatibilityAdapterHandler;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actiongrouplist;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_conf;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception as ExceptionAlias;
use Exception;
use OxidEsales\Eshop\Application\Model\ContentList;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Module\Module;
use OxidEsales\Eshop\Core\Module\ModuleList;
use PHPUnit_Framework_MockObject_MockObject;
use ReflectionException;
use D3\Ordermanager\Application\Model\Actions as Actions;

class d3_cfg_ordermanageritem_actionTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_cfg_ordermanageritem_action */
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

        $this->_oController = d3GetModCfgDIC()->get(d3_cfg_ordermanageritem_action::class);
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
    public function canSaveNoMissingValues()
    {
        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'getValue'
        ));
        $getValueMap = [['blActionOrderStorno_status', true]];
        $oProfileMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'getProfile'
        ));
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, 'save');
        $this->assertNull($this->_oController->getViewDataElement('missingRequValuesActions'));
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canSaveMissingValues()
    {
        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'getValue'
        ));
        $getValueMap = [['blActionOrder2Folder_status', true]];
        $oProfileMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'getProfile'
        ));
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, 'save');
        $aMissing = $this->_oController->getViewDataElement('missingRequValuesActions');
        $this->assertInternalType('array', $aMissing);
        $this->assertCount(1, $aMissing);
        $this->assertContains('moveOrderToFolder', $aMissing);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getContentListReturnsItems()
    {
        $oContentList = $this->callMethod($this->_oController, 'getContentList', array());

        $this->assertInstanceOf(ContentList::class, $oContentList);
        $this->assertTrue($oContentList->count() > 0);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3GetConfigReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Config::class,
            $this->callMethod(
                $this->_oController,
                'd3GetConfig'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function managerContentDirsFromAdminPass()
    {
        $sExpected = '/var/www/html/source/Application/views/admin/tpl/';

        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getTemplateDir',
        ));
        $oConfigMock->expects($this->any())->method('getTemplateDir')->with(
            $this->isTrue()
        )->willReturn($sExpected);

        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'd3GetConfig',
        ));
        $oControllerMock->method('d3GetConfig')->willReturn($oConfigMock);

        $this->_oController = $oControllerMock;

        $sDir = $this->callMethod($this->_oController, 'getManagerTemplateDirs', array(true));
        $this->assertSame(
            $sExpected,
            $sDir
        );
    }

    /**
     * in case of error, check if a active theme is defined
     * @test
     * @throws ReflectionException
     */
    public function managerContentDirsFromFrontentPass()
    {
        $sExpected = '/var/www/html/source/Application/views/flow/tpl/';

        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getTemplateDir',
        ));
        $oConfigMock->expects($this->any())->method('getTemplateDir')->with(
            $this->isFalse()
        )->willReturn($sExpected);
        
        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'd3GetConfig',
        ));
        $oControllerMock->method('d3GetConfig')->willReturn($oConfigMock);

        $this->_oController = $oControllerMock;
        
        $sDir = $this->callMethod($this->_oController, 'getManagerTemplateDirs', array(false));
        $this->assertSame(
            $sExpected,
            $sDir
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function orderFieldNamesPass()
    {
        $aFieldNames = $this->callMethod($this->_oController, 'getItemFieldNames');
        $this->assertInternalType('array', $aFieldNames);
        $this->assertGreaterThan(0, count($aFieldNames));
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function getProfileReturnsRightInstance()
    {
        $oProfile = d3GetModCfgDIC()->get(d3ordermanager::class);
        $oProfile->setId('newProfileId');
        $oProfile->save();

        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'getEditObjectId',
        ));
        $oControllerMock->method('getEditObjectId')->willReturn('newProfileId');

        $this->_oController = $oControllerMock;

        $oAssertProfile = $this->callMethod($this->_oController, 'getProfile');

        $this->assertInstanceOf(
            d3ordermanager::class,
            $oAssertProfile
        );
        $this->assertSame('newProfileId', $oAssertProfile->getId());

        $oProfile->delete();
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function getProfileOtherLangReturnsRightInstance()
    {
        $oProfile = d3GetModCfgDIC()->get(d3ordermanager::class);
        $oProfile->setId('newProfileId');
        $oProfile->save();

        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'getEditObjectId',
        ));
        $oControllerMock->method('getEditObjectId')->willReturn('newProfileId');

        $this->_oController = $oControllerMock;

        $this->setValue($this->_oController, '_iEditLang', 'en');
        $oAssertProfile = $this->callMethod($this->_oController, 'getProfile');

        $this->assertInstanceOf(
            d3ordermanager::class,
            $oAssertProfile
        );
        $this->assertSame('newProfileId', $oAssertProfile->getId());

        $oProfile->delete();
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function exportExamplePathWillGenerated()
    {
        $_POST['oxid'] = 'foobar';

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'loadInLang',
            'getStartTime',
            'getListExportFilePath',
        ));
        $oProfileMock->expects($this->once())->method('loadInLang')->willReturn(true);
        $oProfileMock->method('getStartTime')->willReturn(1420716228);
        $oProfileMock->method('getListExportFilePath')->willReturn('/var/www/html/shop/source/export/d3ordermananger_profileName_2015-01-08_12-23-48.csv');

        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'getProfile',
            '_d3LoadInOtherLang',
        ));
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);
        $oControllerMock->method('_d3LoadInOtherLang')->willReturn($oProfileMock);

        $this->_oController = $oControllerMock;

        $sPath = $this->callMethod($this->_oController, 'getExportExamplePath');
        $this->assertRegExp('@/var/www/html/shop/source/export/d3ordermananger_profileName_.*.csv@i', $sPath);
        $this->assertNotContains('2015-01-08_12-23-48', $sPath);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function langWillReturnRightInstance()
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
    public function fieldNameDescriptionCanTranslated()
    {
        /** @var Language|PHPUnit_Framework_MockObject_MockObject $oLangMock */
        $oLangMock = $this->getMock(Language::class, array(
            'translateString',
        ));
        $oLangMock->expects($this->once())->method('translateString')->willReturn('%1$s (%2$s)');

        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'getFieldNameTitle',
            'getLang',
        ));
        $oControllerMock->method('getFieldNameTitle')->willReturn('barfoo');
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            'barfoo (foobar_5)',
            $this->callMethod($this->_oController, 'getFieldNameDescription', array('foobar_5'))
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function fieldNameDescriptionCantTranslated()
    {
        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'getFieldNameTitle',
        ));
        $oControllerMock->method('getFieldNameTitle')->willReturn(null);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            'foobar_5',
            $this->callMethod($this->_oController, 'getFieldNameDescription', array('foobar_5'))
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetFieldNameTitleWithLangIdent()
    {
        /** @var Language|PHPUnit_Framework_MockObject_MockObject $oLangMock */
        $oLangMock = $this->getMock(Language::class, array(
            'translateString',
        ));
        $oLangMock->expects($this->exactly(2))->method('translateString')->with(
            $this->logicalOr(
                $this->stringContains('D3_ORDERMANAGER'),
                $this->logicalAnd(
                    $this->stringContains('foobar'),
                    $this->logicalNot(
                        $this->stringContains('5')
                    )
                )
            )
        )->willReturn('Sprache %u ');

        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'getLang',
        ));
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            'Sprache %u Sprache 0 ',
            $this->callMethod($this->_oController, 'getFieldNameTitle', array('foobar_1'))
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetFieldNameTitleWithoutLangIdent()
    {
        /** @var Language|PHPUnit_Framework_MockObject_MockObject $oLangMock */
        $oLangMock = $this->getMock(Language::class, array(
            'translateString',
        ));
        $oLangMock->expects($this->once())->method('translateString')->with(
            $this->stringContains('foobar')
        )->willReturn('Sprache %u ');

        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'getLang',
        ));
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            'Sprache %u ',
            $this->callMethod($this->_oController, 'getFieldNameTitle', array('foobar'))
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetFieldNameTitleWithNotExistingTranslation()
    {
        /** @var Language|PHPUnit_Framework_MockObject_MockObject $oLangMock */
        $oLangMock = $this->getMock(Language::class, array(
            'translateString',
        ));
        $oLangMock->expects($this->once())->method('translateString')->willReturn('FOOBAR');

        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'getLang',
        ));
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->setValue($oControllerMock, '_sExportFieldTitleBaseMLIdent', '');

        $this->_oController = $oControllerMock;

        $this->assertNull(
            $this->callMethod($this->_oController, 'getFieldNameTitle', array('FOOBAR'))
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function pdfHandlerReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3ordermanager_pdfhandler::class,
            $this->callMethod($this->_oController, 'getPdfHandler')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGeneratePdfStatusPass()
    {
        /** @var d3ordermanager_pdfhandler|PHPUnit_Framework_MockObject_MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMock(d3ordermanager_pdfhandler::class, array(
            'canGeneratePdf',
        ), array(d3GetModCfgDIC()->get(d3ordermanager::class), d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)));
        $oPdfHandlerMock->method('canGeneratePdf')->willReturn(true);

        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'getPdfHandler',
        ));
        $oControllerMock->method('getPdfHandler')->willReturn($oPdfHandlerMock);

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod($this->_oController, 'canGeneratePdf')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGeneratePdfStatusDontPass()
    {
        /** @var d3ordermanager_pdfhandler|PHPUnit_Framework_MockObject_MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMock(d3ordermanager_pdfhandler::class, array(
            'canGeneratePdf',
        ), array(d3GetModCfgDIC()->get(d3ordermanager::class), d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)));
        $oPdfHandlerMock->method('canGeneratePdf')->willReturn(false);

        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'getPdfHandler',
        ));
        $oControllerMock->method('getPdfHandler')->willReturn($oPdfHandlerMock);

        $this->_oController = $oControllerMock;

        $this->assertFalse(
            $this->callMethod($this->_oController, 'canGeneratePdf')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws ExceptionAlias
     */
    public function getActionListReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3ordermanager_actiongrouplist::class,
            $this->callMethod(
                $this->_oController,
                'getActionGroupList'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetActionListObject()
    {
        $this->assertInstanceOf(
            Actions\d3ordermanager_actionlist::class,
            $this->callMethod($this->_oController, 'getActionListObject')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetActionList()
    {
        $aActionList = $this->callMethod($this->_oController, 'getActionList');
        $this->assertInternalType(
            'array',
            $aActionList
        );
        $this->assertTrue(count($aActionList) > 0);
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws ExceptionAlias
     */
    public function canGetGroupList()
    {
        $groupedList = array(
            'D3_ORDERMANAGER_ACTION_ORDER'   => array(
                'moveOrderToFolder'     => Actions\d3ordermanager_action_moveordertofolder::class,
                'stornoOrder'           => Actions\d3ordermanager_action_stornoorder::class
            ),
            'D3_ORDERMANAGER_ACTION_CUSTOMER'       => array(
                'custAddToGroup'        => Actions\d3ordermanager_action_custaddtogroup::class,
            )
        );

        /** @var d3ordermanager_actiongrouplist|PHPUnit_Framework_MockObject_MockObject $oActionGroupListMock */
        $oActionGroupListMock = $this->getMock(d3ordermanager_actiongrouplist::class, array(
            'setGroups',
            'getGroupList'
        ), array($this->_oController->getProfile(), d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)));
        $oActionGroupListMock->method('setGroups')->willReturn(true);
        $oActionGroupListMock->method('getGroupList')->willReturn($groupedList);

        /** @var d3ordermanager_conf|PHPUnit_Framework_MockObject_MockObject $oConfigurationMock */
        $oConfigurationMock = $this->getMock(d3ordermanager_conf::class, array(
            'getGroupedActionIdList'
        ));
        $oConfigurationMock->method('getGroupedActionIdList')->willReturn($groupedList);

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'getConfiguration'
        ));
        $oProfileMock->method('getConfiguration')->willReturn($oConfigurationMock);

        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'getProfile',
            'getActionList',
        ));
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);
        $oControllerMock->method('getActionList')->willReturn($oActionGroupListMock);

        $this->_oController = $oControllerMock;

        $aList = $this->callMethod($this->_oController, 'getGroupedActionList');

        $this->assertInternalType('array', $aList);
        $this->assertCount(2, $aList);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canLoadInOtherLanguages()
    {
        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'getAvailableInLangs',
            'loadInLang',
        ));
        $oProfileMock->method('getAvailableInLangs')->willReturn(array('de' => 'deutsch'));
        $oProfileMock->expects($this->once())->method('loadInLang')->willReturn(true);

        $this->setValue($this->_oController, '_iEditLang', 'en');

        $this->assertSame(
            $oProfileMock,
            $this->callMethod(
                $this->_oController,
                '_d3LoadInOtherLang',
                array($oProfileMock, 'oxid')
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function dontNeedLoadInOtherLanguages()
    {
        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'getAvailableInLangs',
            'loadInLang',
        ));
        $oProfileMock->method('getAvailableInLangs')->willReturn(array('de' => 'deutsch'));
        $oProfileMock->expects($this->never())->method('loadInLang')->willReturn(true);

        $this->setValue($this->_oController, '_iEditLang', 'de');

        $this->assertSame(
            $oProfileMock,
            $this->callMethod(
                $this->_oController,
                '_d3LoadInOtherLang',
                array($oProfileMock, 'oxid')
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public  function moduleListHasRightInstance()
    {
        $this->assertInstanceOf(
            ModuleList::class,
            $this->callMethod($this->_oController, 'getModuleList')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function shopCompatibilityAdapterHandlerHasRightInstance()
    {
        $this->assertInstanceOf(
            d3ShopCompatibilityAdapterHandler::class,
            $this->callMethod($this->_oController, 'getShopCompatibilityAdapterHandler')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetModulePathList()
    {
        /** @var d3ShopCompatibilityAdapterHandler|PHPUnit_Framework_MockObject_MockObject $oShopCompatibilityAdapterHandlerMock */
        $oShopCompatibilityAdapterHandlerMock = $this->getMock(d3ShopCompatibilityAdapterHandler::class, array(
            'call'
        ));
        $oShopCompatibilityAdapterHandlerMock->method('call')->willReturnCallback(array($this, 'shopCompatHandlerCallback'));

        $aModulesList = array(
            'd3module1' => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Module::class),
            'd3module2' => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Module::class)
        );

        /** @var ModuleList|PHPUnit_Framework_MockObject_MockObject $oModuleListMock */
        $oModuleListMock = $this->getMock(ModuleList::class, array(
            'getModulesFromDir'
        ));
        $oModuleListMock->method('getModulesFromDir')->willReturn($aModulesList);

        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'getModuleList',
            'getShopCompatibilityAdapterHandler',
        ));
        $oControllerMock->method('getModuleList')->willReturn($oModuleListMock);
        $oControllerMock->method('getShopCompatibilityAdapterHandler')->willReturn($oShopCompatibilityAdapterHandlerMock);

        $this->_oController = $oControllerMock;

        $aList = $this->callMethod($this->_oController, 'getModulePathList');

        $this->assertSame(
            array(
                'd3module1' => '/module/path/d3module1',
                'd3module2' => '/module/path/d3module2',
            ),
            $aList
        );
    }

    public function shopCompatHandlerCallback()
    {
        $args = func_get_args();
        return '/module/path/'.$args[1][1];
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canMarkedAsFinished()
    {
        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'markConcernedItemsAsFinished'
        ));
        $oProfileMock->expects($this->once())->method('markConcernedItemsAsFinished')->willReturn(25);

        /** @var d3_cfg_ordermanageritem_action|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_action::class, array(
            'getProfile',
        ));
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, 'markAsFinished');
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