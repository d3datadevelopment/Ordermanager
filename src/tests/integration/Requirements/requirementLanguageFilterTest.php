<?php

/**
 * This Software is the property of Data Development and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * https://www.d3data.de
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development - Daniel Seifert <support@shopmodule.com>
 * @link      https://www.oxidmodule.com
 */

namespace D3\Ordermanager\tests\integration\Requirements;

use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_requirementException;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Registry;
use PHPUnit\Framework\MockObject\MockObject;
use stdClass;

class requirementLanguageFilterTest extends d3OrdermanagerRequirementIntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aOrderIdList = [
        'orderTestIdNo1',
        'orderTestIdNo2',
        'orderTestIdNo3',
    ];
    public $aLanguageId = [
        '52',
        '53',
        '54',
    ];
    public $aOrderArticleIdList = [
        'orderTestIdNo1Article1',
        'orderTestIdNo2Article1',
        'orderTestIdNo3Article1',
    ];

    /**
     * Set up fixture.
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->createTestData();
    }

    /**
     * Tear down fixture.
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function tearDown(): void
    {
        $this->cleanTestData();

        parent::tearDown();
    }

    /**
     * @throws Exception
     */
    public function createTestData()
    {
        $this->createManager(
            $this->sManagerId
        );

        $this->createOrder(
            $this->aOrderIdList[0],
            [
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
                'oxlang'        => $this->aLanguageId[0],
            ],
            [
                $this->aOrderArticleIdList[0] => [
                    'oxtitle'           => __CLASS__,
                ],
            ]
        );

        $this->createOrder(
            $this->aOrderIdList[1],
            [
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
                'oxlang'        => $this->aLanguageId[1],
            ],
            [
                $this->aOrderArticleIdList[1] => [
                    'oxtitle'       => __CLASS__,
                ],
            ]
        );

        $this->createOrder(
            $this->aOrderIdList[2],
            [
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
                'oxlang'        => $this->aLanguageId[2],
            ],
            [
                $this->aOrderArticleIdList[2] => [
                    'oxtitle'       => __CLASS__,
                ],
            ]
        );
    }

    /**
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws Exception
     */
    public function cleanTestData()
    {
        $this->deleteManager($this->sManagerId);

        foreach ($this->aOrderIdList as $sOrderId) {
            $this->deleteOrder($sOrderId);
        }
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerSingle()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckLanguage_status', true);
        $oManager->setValue('sInLanguageId', [$this->aLanguageId[0]]);

        return $oManager;
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerMulti()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckLanguage_status', true);
        $oManager->setValue('sInLanguageId', [$this->aLanguageId[0], $this->aLanguageId[1]]);

        return $oManager;
    }

    /**
     * @test
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     */
    public function requirementsSelectsRightOrdersSingle()
    {
        /** @var Language $oLang */
        $oLang = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);
        $langBackup = $oLang;
        $aLangs = $oLang->getLanguageArray();

        foreach ($this->aLanguageId as $sId) {
            $oLang = oxNew(stdClass::class);
            $oLang->id = $sId;
            $oLang->oxid = $sId.'_oxid';
            $oLang->abbr = $sId.'_abbr';
            $oLang->name = $sId.'_name';
            $oLang->active = '1';
            $oLang->sort = $sId;
            $oLang->selected = 0;
            $aLangs[$sId] = $oLang;
        }

        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->onlyMethods(['getLanguageArray'])
            ->getMock();
        $oLangMock->method('getLanguageArray')->willReturn($aLangs);

        $definitions = d3GetModCfgDIC()->getDefinitions();

        d3GetModCfgDIC()->set('d3ox.ordermanager.'.Language::class, $oLangMock);

        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerSingle());
        $oOrderList = $oListGenerator->getConcernedItems();

        d3GetModCfgDIC()->reset();
        d3GetModCfgDIC()->setDefinitions($definitions);
        Registry::set(Language::class, $langBackup);

        $this->assertTrue(
            $oOrderList->count() === 1
            && $oOrderList->offsetExists($this->aOrderIdList[0])
            && false == $oOrderList->offsetExists($this->aOrderIdList[1])
            && false == $oOrderList->offsetExists($this->aOrderIdList[2])
        );
    }

    /**
     * @test
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     */
    public function requirementsSelectsRightOrdersMulti()
    {
        /** @var Language $oLang */
        $oLang = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);
        $langBackup = $oLang;
        $aLangs = $oLang->getLanguageArray();

        foreach ($this->aLanguageId as $sId) {
            $oLang = oxNew(stdClass::class);
            $oLang->id = $sId;
            $oLang->oxid = $sId.'_oxid';
            $oLang->abbr = $sId.'_abbr';
            $oLang->name = $sId.'_name';
            $oLang->active = '1';
            $oLang->sort = $sId;
            $oLang->selected = 0;
            $aLangs[$sId] = $oLang;
        }

        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->onlyMethods(['getLanguageArray'])
            ->getMock();
        $oLangMock->method('getLanguageArray')->willReturn($aLangs);

        $definitions = d3GetModCfgDIC()->getDefinitions();

        d3GetModCfgDIC()->set('d3ox.ordermanager.'.Language::class, $oLangMock);

        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerMulti());
        $oOrderList = $oListGenerator->getConcernedItems();

        d3GetModCfgDIC()->reset();
        d3GetModCfgDIC()->setDefinitions($definitions);
        Registry::set(Language::class, $langBackup);

        $this->assertTrue(
            $oOrderList->count() === 2
            && $oOrderList->offsetExists($this->aOrderIdList[0])
            && $oOrderList->offsetExists($this->aOrderIdList[1])
            && false == $oOrderList->offsetExists($this->aOrderIdList[2])
        );
    }

    /**
     * @param $invalidValue
     *
     * @return d3ordermanager|MockObject
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getConfiguredManagerNoValidConfig($invalidValue)
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckLanguage_status', true);
        $oManager->setValue('sInLanguageId', $invalidValue);

        return $oManager;
    }

    /**
     * @test
     * @param $testValue
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     * @dataProvider requirementsSelectsRightOrdersNoValidConfigDataProvider
     */
    public function requirementsSelectsRightOrdersNoValidConfig($testValue)
    {
        $this->expectException(d3ordermanager_requirementException::class);

        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerNoValidConfig($testValue));
        $oListGenerator->getConcernedItems();
    }

    /**
     * @return array
     */
    public function requirementsSelectsRightOrdersNoValidConfigDataProvider(): array
    {
        return [
            'unknown'=> ['unknownValue'],
            'space'  => [' '],
            'empty'  => [''],
            'false'  => [false],
        ];
    }
}
