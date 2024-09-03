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

use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actiongrouplist;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_conf;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\Exception as DBALException;
use Exception as ExceptionAlias;
use Exception;
use OxidEsales\Eshop\Application\Model\ContentList;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Language;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;
use D3\Ordermanager\Application\Model\Actions as Actions;

/**
 * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action
 */
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
    public function setUp(): void
    {
        parent::setUp();

        $this->_oController = d3GetOxidDIC()->get(d3_cfg_ordermanageritem_action::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->_oController);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::save
     * @test
     * @throws ReflectionException
     */
    public function canSaveNoMissingValues()
    {
        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue'])
            ->getMock();
        $getValueMap = [['blActionOrderStorno_status', true]];
        $oProfileMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods(['getProfile'])
            ->getMock();
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, 'save');
        $this->assertNull($this->_oController->getViewDataElement('missingRequValuesActions'));
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::save
     * @test
     * @throws ReflectionException
     */
    public function canSaveMissingValues()
    {
        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue'])
            ->getMock();
        $getValueMap = [['blActionOrder2Folder_status', true]];
        $oProfileMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods(['getProfile'])
            ->getMock();
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, 'save');
        $aMissing = $this->_oController->getViewDataElement('missingRequValuesActions');
        $this->assertIsArray($aMissing);
        $this->assertCount(1, $aMissing);
        $this->assertContains('moveOrderToFolder', $aMissing);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getContentList
     * @test
     * @throws ReflectionException
     */
    public function getContentListReturnsItems()
    {
        $oContentList = $this->callMethod($this->_oController, 'getContentList', []);

        $this->assertInstanceOf(ContentList::class, $oContentList);
        $this->assertTrue($oContentList->count() > 0);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::d3GetConfig
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getItemFieldNames
     * @test
     * @throws ReflectionException
     */
    public function orderFieldNamesPass()
    {
        $aFieldNames = $this->callMethod($this->_oController, 'getItemFieldNames');
        $this->assertIsArray($aFieldNames);
        $this->assertGreaterThan(0, count($aFieldNames));
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getProfile
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function getProfileReturnsRightInstance()
    {
        $oProfile = d3GetOxidDIC()->get(d3ordermanager::class);
        $oProfile->setId('newProfileId');
        $oProfile->save();

        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods(['getEditObjectId'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getProfile
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function getProfileOtherLangReturnsRightInstance()
    {
        $oProfile = d3GetOxidDIC()->get(d3ordermanager::class);
        $oProfile->setId('newProfileId');
        $oProfile->save();

        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods(['getEditObjectId'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getExportExamplePath
     * @test
     * @throws ReflectionException
     */
    public function exportExamplePathWillGenerated()
    {
        $_POST['oxid'] = 'foobar';

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods([
                'loadInLang',
                'getStartTime',
                'getListExportFilePath',
            ])
            ->getMock();
        $oProfileMock->expects($this->once())->method('loadInLang')->willReturn(true);
        $oProfileMock->method('getStartTime')->willReturn(1420716228);
        $oProfileMock->method('getListExportFilePath')->willReturn('/var/www/html/shop/source/export/d3ordermananger_profileName_2015-01-08_12-23-48.csv');

        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods([
                'getProfile',
                '_d3LoadInOtherLang',
            ])
            ->getMock();
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);
        $oControllerMock->method('_d3LoadInOtherLang')->willReturn($oProfileMock);

        $this->_oController = $oControllerMock;

        $sPath = $this->callMethod($this->_oController, 'getExportExamplePath');
        $this->assertMatchesRegularExpression('@/var/www/html/shop/source/export/d3ordermananger_profileName_.*.csv@i', $sPath);
        $this->assertStringNotContainsStringIgnoringCase('2015-01-08_12-23-48', $sPath);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getLang
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getFieldNameDescription
     * @test
     * @throws ReflectionException
     */
    public function fieldNameDescriptionCanTranslated()
    {
        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->onlyMethods(['translateString'])
            ->getMock();
        $oLangMock->expects($this->once())->method('translateString')->willReturn('%1$s (%2$s)');

        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods([
                'getFieldNameTitle',
                'getLang',
            ])
            ->getMock();
        $oControllerMock->method('getFieldNameTitle')->willReturn('barfoo');
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            'barfoo (foobar_5)',
            $this->callMethod($this->_oController, 'getFieldNameDescription', ['foobar_5'])
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getFieldNameDescription
     * @test
     * @throws ReflectionException
     */
    public function fieldNameDescriptionCantTranslated()
    {
        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods(['getFieldNameTitle'])
            ->getMock();
        $oControllerMock->method('getFieldNameTitle')->willReturn(null);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            'foobar_5',
            $this->callMethod($this->_oController, 'getFieldNameDescription', ['foobar_5'])
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getFieldNameTitle
     * @test
     * @throws ReflectionException
     */
    public function canGetFieldNameTitleWithLangIdent()
    {
        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->onlyMethods(['translateString'])
            ->getMock();
        $oLangMock->expects($this->exactly(2))->method('translateString')->with(
            $this->logicalOr(
                $this->stringContains('D3_ORDERMANAGER'),
                $this->logicalAnd(
                    $this->stringContains('foobar'),
                    $this->logicalNot(
                        $this->identicalTo(5)
                    )
                )
            )
        )->willReturn('Sprache %u ');

        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods(['getLang'])
            ->getMock();
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            'Sprache %u Sprache 0 ',
            $this->callMethod($this->_oController, 'getFieldNameTitle', ['foobar_1'])
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getFieldNameTitle
     * @test
     * @throws ReflectionException
     */
    public function canGetFieldNameTitleWithoutLangIdent()
    {
        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->onlyMethods(['translateString'])
            ->getMock();
        $oLangMock->expects($this->once())->method('translateString')->with(
            $this->stringContains('foobar')
        )->willReturn('Sprache %u ');

        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods(['getLang'])
            ->getMock();
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            'Sprache %u ',
            $this->callMethod($this->_oController, 'getFieldNameTitle', ['foobar'])
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getFieldNameTitle
     * @test
     * @throws ReflectionException
     */
    public function canGetFieldNameTitleWithNotExistingTranslation()
    {
        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->onlyMethods(['translateString'])
            ->getMock();
        $oLangMock->expects($this->once())->method('translateString')->willReturn('FOOBAR');

        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods(['getLang'])
            ->getMock();
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->setValue($oControllerMock, '_sExportFieldTitleBaseMLIdent', '');

        $this->_oController = $oControllerMock;

        $this->assertNull(
            $this->callMethod($this->_oController, 'getFieldNameTitle', ['FOOBAR'])
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getPdfHandler
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::canGenerateOxidPdf
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGenerateOxidPdfStatusPass()
    {
        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->onlyMethods(['canGenerateOxidPdf'])
            ->setConstructorArgs([d3GetOxidDIC()->get(d3ordermanager::class), d3GetOxidDIC()->get('d3ox.ordermanager.'.Order::class)])
            ->getMock();
        $oPdfHandlerMock->method('canGenerateOxidPdf')->willReturn(true);

        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods(['getPdfHandler'])
            ->getMock();
        $oControllerMock->method('getPdfHandler')->willReturn($oPdfHandlerMock);

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod($this->_oController, 'canGenerateOxidPdf')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::canGenerateOxidPdf
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGenerateOxidPdfStatusDontPass()
    {
        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->onlyMethods(['canGenerateOxidPdf'])
            ->setConstructorArgs([d3GetOxidDIC()->get(d3ordermanager::class), d3GetOxidDIC()->get('d3ox.ordermanager.'.Order::class)])
            ->getMock();
        $oPdfHandlerMock->method('canGenerateOxidPdf')->willReturn(false);

        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods(['getPdfHandler'])
            ->getMock();
        $oControllerMock->method('getPdfHandler')->willReturn($oPdfHandlerMock);

        $this->_oController = $oControllerMock;

        $this->assertFalse(
            $this->callMethod($this->_oController, 'canGenerateOxidPdf')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::canGeneratePdfDocuments
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGeneratePdfDocumentsStatusPass()
    {
        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->onlyMethods(['canGeneratePdfDocuments'])
            ->setConstructorArgs([d3GetOxidDIC()->get(d3ordermanager::class), d3GetOxidDIC()->get('d3ox.ordermanager.'.Order::class)])
            ->getMock();
        $oPdfHandlerMock->method('canGeneratePdfDocuments')->willReturn(true);

        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods(['getPdfHandler'])
            ->getMock();
        $oControllerMock->method('getPdfHandler')->willReturn($oPdfHandlerMock);

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod($this->_oController, 'canGeneratePdfDocuments')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::canGeneratePdfDocuments
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGeneratePdfDocumentsStatusDontPass()
    {
        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->onlyMethods(['canGeneratePdfDocuments'])
            ->setConstructorArgs([d3GetOxidDIC()->get(d3ordermanager::class), d3GetOxidDIC()->get('d3ox.ordermanager.'.Order::class)])
            ->getMock();
        $oPdfHandlerMock->method('canGeneratePdfDocuments')->willReturn(false);

        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods(['getPdfHandler'])
            ->getMock();
        $oControllerMock->method('getPdfHandler')->willReturn($oPdfHandlerMock);

        $this->_oController = $oControllerMock;

        $this->assertFalse(
            $this->callMethod($this->_oController, 'canGeneratePdfDocuments')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getActionGroupList
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getActionListObject
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getActionList
     * @test
     * @throws ReflectionException
     */
    public function canGetActionList()
    {
        $aActionList = $this->callMethod($this->_oController, 'getActionList');
        $this->assertIsArray(
            $aActionList
        );
        $this->assertNotEmpty($aActionList);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::getGroupedActionList
     * @test
     * @throws ReflectionException
     * @throws ExceptionAlias
     */
    public function canGetGroupList()
    {
        $groupedList = [
            'D3_ORDERMANAGER_ACTION_ORDER'   => [
                'moveOrderToFolder'     => Actions\d3ordermanager_action_moveordertofolder::class,
                'stornoOrder'           => Actions\d3ordermanager_action_stornoorder::class,
            ],
            'D3_ORDERMANAGER_ACTION_CUSTOMER'       => [
                'custAddToGroup'        => Actions\d3ordermanager_action_custaddtogroup::class,
            ],
        ];

        /** @var d3ordermanager_conf|MockObject $oConfigurationMock */
        $oConfigurationMock = $this->getMockBuilder(d3ordermanager_conf::class)
            ->onlyMethods(['getGroupedActionIdList'])
            ->getMock();
        $oConfigurationMock->method('getGroupedActionIdList')->willReturn($groupedList);

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getConfiguration'])
            ->getMock();
        $oProfileMock->method('getConfiguration')->willReturn($oConfigurationMock);

        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods([
                'getProfile',
                'getActionList',
            ])
            ->getMock();
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);
        $oControllerMock->method('getActionList')->willReturn(['test'  => 'item']);

        $this->_oController = $oControllerMock;

        $aList = $this->callMethod($this->_oController, 'getGroupedActionList');

        $this->assertIsArray($aList);
        $this->assertCount(2, $aList);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::_d3LoadInOtherLang
     * @test
     * @throws ReflectionException
     */
    public function canLoadInOtherLanguages()
    {
        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods([
                'getAvailableInLangs',
                'loadInLang',
            ])
            ->getMock();
        $oProfileMock->method('getAvailableInLangs')->willReturn(['de' => 'deutsch']);
        $oProfileMock->expects($this->once())->method('loadInLang')->willReturn(true);

        $this->setValue($this->_oController, '_iEditLang', 'en');

        $this->assertSame(
            $oProfileMock,
            $this->callMethod(
                $this->_oController,
                '_d3LoadInOtherLang',
                [$oProfileMock, 'oxid']
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::_d3LoadInOtherLang
     * @test
     * @throws ReflectionException
     */
    public function dontNeedLoadInOtherLanguages()
    {
        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods([
                'getAvailableInLangs',
                'loadInLang',
            ])
            ->getMock();
        $oProfileMock->method('getAvailableInLangs')->willReturn(['de' => 'deutsch']);
        $oProfileMock->expects($this->never())->method('loadInLang')->willReturn(true);

        $this->setValue($this->_oController, '_iEditLang', 'de');

        $this->assertSame(
            $oProfileMock,
            $this->callMethod(
                $this->_oController,
                '_d3LoadInOtherLang',
                [$oProfileMock, 'oxid']
            )
        );
    }

    /**
     * @return string
     */
    public function shopCompatHandlerCallback()
    {
        $args = func_get_args();
        return '/module/path/'.$args[1][1];
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::markAsFinished
     * @test
     * @throws ReflectionException
     */
    public function canMarkedAsFinished()
    {
        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['markConcernedItemsAsFinished'])
            ->getMock();
        $oProfileMock->expects($this->once())->method('markConcernedItemsAsFinished')->willReturn(25);

        /** @var d3_cfg_ordermanageritem_action|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_action::class)
            ->onlyMethods(['getProfile'])
            ->getMock();
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
