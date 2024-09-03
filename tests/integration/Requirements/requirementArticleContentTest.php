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

namespace D3\Ordermanager\tests\integration\Requirements;

use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_requirementException;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Object2Category;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @coversNothing
 */
class requirementArticleContentTest extends d3OrdermanagerRequirementIntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aOrderIdList = [
        'orderTestIdNo1',
        'orderTestIdNo2',
        'orderTestIdNo3',
        'orderTestIdNo4',
        'orderTestIdNo5',
    ];
    public $aOrderArticleIdList = [
        'orderTestIdNo1Article1',
        'orderTestIdNo2Article1',
        'orderTestIdNo3Article1',
        'orderTestIdNo4Article1',
        'orderTestIdNo5Article1',
    ];
    public $aArt2CatIdList = [
        'a2cTestIdNo1',
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
            ],
            [
                $this->aOrderArticleIdList[0] => [
                    'oxartnum'      => 'expArtNum1',
                    'oxtitle'       => 'expTitle1',
                    'oxshortdesc'   => 'expShortDesc1',
                    'oxselvariant'  => 'expSelVariant1',
                    'oxpersparam'   => 'expPersParam1',
                    'oxstorno'      => '0',
                    'oxartid'       => 'artIdTestNo1',
                ],
            ]
        );

        $this->createObject(
            'd3ox.ordermanager.'.Object2Category::class,
            $this->aArt2CatIdList[0],
            [
                'oxshopid'      => '1',
                'oxobjectid'    => 'artIdTestNo1',
                'oxcatnid'      => 'catTestId',
            ]
        );

        $this->createOrder(
            $this->aOrderIdList[1],
            [
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
            ],
            [
                $this->aOrderArticleIdList[1] => [
                    'oxartnum'      => 'expArtNum2',
                    'oxtitle'       => 'expTitle2',
                    'oxshortdesc'   => 'expShortDesc2',
                    'oxselvariant'  => 'expSelVariant2',
                    'oxpersparam'   => 'expPersParam2',
                    'oxstorno'      => '0',
                    'oxorderid'     => $this->aOrderIdList[1],
                    'oxartid'       => 'artIdTestNo2',
                ],
            ]
        );

        $this->createOrder(
            $this->aOrderIdList[2],
            [
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
            ],
            [
                $this->aOrderArticleIdList[2] => [
                    'oxartnum'      => 'expArtNum3',
                    'oxtitle'       => 'expTitle3',
                    'oxshortdesc'   => 'expShortDesc3',
                    'oxselvariant'  => 'expSelVariant3',
                    'oxpersparam'   => 'expPersParam3',
                    'oxstorno'      => '0',
                    'oxartid'       => 'artIdTestNo3',
                ],
            ]
        );

        $this->createOrder(
            $this->aOrderIdList[3],
            [
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
            ],
            [
                $this->aOrderArticleIdList[3] => [
                    'oxartnum'      => 'expArtNum4',
                    'oxtitle'       => 'expTitle4',
                    'oxshortdesc'   => 'expShortDesc4',
                    'oxselvariant'  => 'expSelVariant4',
                    'oxpersparam'   => 'expPersParam4',
                    'oxstorno'      => '0',
                    'oxorderid'     => $this->aOrderIdList[3],
                    'oxartid'       => 'artIdTestNo4',
                ],
            ]
        );

        $this->createOrder(
            $this->aOrderIdList[4],
            [
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
            ],
            [
                $this->aOrderArticleIdList[4] => [
                    'oxartnum'      => 'expArtNum5',
                    'oxtitle'       => 'expTitle5',
                    'oxshortdesc'   => 'expShortDesc5',
                    'oxselvariant'  => 'expSelVariant5',
                    'oxpersparam'   => 'expPersParam5',
                    'oxstorno'      => '0',
                    'oxartid'       => 'artIdTestNo5',
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

        $this->deleteObject('d3ox.ordermanager.'.Object2Category::class, $this->aArt2CatIdList[0]);
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerArtnumAndCatId()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckOrderArticle1_status', true);
        $oManager->setValue('sArticleContent1Type', 'oxartnum');
        $oManager->setValue('sArticleContent1RegExp', 'expArtNum1');

        $oManager->setValue('blCheckOrderArticle2_status', true);
        $oManager->setValue('sArticleContent2Type', 'oxcatid');
        $oManager->setValue('sArticleContent2RegExp', 'catTestId');

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
    public function requirementsSelectsRightOrdersArtnumAndCatId()
    {
        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerArtnumAndCatId());
        $oOrderList = $oListGenerator->getConcernedItems();

        $this->assertTrue(
            $oOrderList->count() === 1
            && $oOrderList->offsetExists($this->aOrderIdList[0])
            && false == $oOrderList->offsetExists($this->aOrderIdList[1])
            && false == $oOrderList->offsetExists($this->aOrderIdList[2])
            && false == $oOrderList->offsetExists($this->aOrderIdList[3])
            && false == $oOrderList->offsetExists($this->aOrderIdList[4])
        );
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerTitle()
    {
        /** @var d3ordermanager $oManager */
        $oManager = d3GetOxidDIC()->get(d3ordermanager::class);
        $oManager->load($this->sManagerId);

        $oManager->setValue('blCheckOrderArticle1_status', true);
        $oManager->setValue('sArticleContent1Type', 'oxtitle');
        $oManager->setValue('sArticleContent1RegExp', 'expTitle2');

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
    public function requirementsSelectsRightOrdersTitle()
    {
        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerTitle());
        $oOrderList = $oListGenerator->getConcernedItems();

        $this->assertTrue(
            $oOrderList->count() === 1
            && $oOrderList->offsetExists($this->aOrderIdList[1])
            && false == $oOrderList->offsetExists($this->aOrderIdList[0])
            && false == $oOrderList->offsetExists($this->aOrderIdList[2])
            && false == $oOrderList->offsetExists($this->aOrderIdList[3])
            && false == $oOrderList->offsetExists($this->aOrderIdList[4])
        );
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerShortDesc()
    {
        /** @var d3ordermanager $oManager */
        $oManager = d3GetOxidDIC()->get(d3ordermanager::class);
        $oManager->load($this->sManagerId);

        $oManager->setValue('blCheckOrderArticle1_status', true);
        $oManager->setValue('sArticleContent1Type', 'oxshortdesc');
        $oManager->setValue('sArticleContent1RegExp', 'expShortDesc3');

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
    public function requirementsSelectsRightOrdersShortDesc()
    {
        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerShortDesc());
        $oOrderList = $oListGenerator->getConcernedItems();

        $this->assertTrue(
            $oOrderList->count() === 1
            && $oOrderList->offsetExists($this->aOrderIdList[2])
            && false == $oOrderList->offsetExists($this->aOrderIdList[0])
            && false == $oOrderList->offsetExists($this->aOrderIdList[1])
            && false == $oOrderList->offsetExists($this->aOrderIdList[3])
            && false == $oOrderList->offsetExists($this->aOrderIdList[4])
        );
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerSelVariant()
    {
        /** @var d3ordermanager $oManager */
        $oManager = d3GetOxidDIC()->get(d3ordermanager::class);
        $oManager->load($this->sManagerId);

        $oManager->setValue('blCheckOrderArticle1_status', true);
        $oManager->setValue('sArticleContent1Type', 'oxselvariant');
        $oManager->setValue('sArticleContent1RegExp', 'expSelVariant4');

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
    public function requirementsSelectsRightOrdersSelVariant()
    {
        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerSelVariant());
        $oOrderList = $oListGenerator->getConcernedItems();

        $this->assertTrue(
            $oOrderList->count() === 1
            && $oOrderList->offsetExists($this->aOrderIdList[3])
            && false == $oOrderList->offsetExists($this->aOrderIdList[0])
            && false == $oOrderList->offsetExists($this->aOrderIdList[1])
            && false == $oOrderList->offsetExists($this->aOrderIdList[2])
            && false == $oOrderList->offsetExists($this->aOrderIdList[4])
        );
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerPersParams()
    {
        /** @var d3ordermanager $oManager */
        $oManager = d3GetOxidDIC()->get(d3ordermanager::class);
        $oManager->load($this->sManagerId);

        $oManager->setValue('blCheckOrderArticle1_status', true);
        $oManager->setValue('sArticleContent1Type', 'oxpersparam');
        $oManager->setValue('sArticleContent1RegExp', 'expPersParam5');

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
    public function requirementsSelectsRightOrdersPersParams()
    {
        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerPersParams());
        $oOrderList = $oListGenerator->getConcernedItems();

        $this->assertTrue(
            $oOrderList->count() === 1
            && $oOrderList->offsetExists($this->aOrderIdList[4])
            && false == $oOrderList->offsetExists($this->aOrderIdList[0])
            && false == $oOrderList->offsetExists($this->aOrderIdList[1])
            && false == $oOrderList->offsetExists($this->aOrderIdList[2])
            && false == $oOrderList->offsetExists($this->aOrderIdList[3])
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

        $oManager->setValue('blCheckOrderArticle1_status', true);
        $oManager->setValue('sArticleContent1Type', $invalidValue);

        return $oManager;
    }

    /**
     * @test
     * @param $orderNrValue
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     * @dataProvider requirementsSelectsRightOrdersNoValidConfigDataProvider
     */
    public function requirementsSelectsRightOrdersNoValidConfig($orderNrValue)
    {
        $this->expectException(d3ordermanager_requirementException::class);

        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerNoValidConfig($orderNrValue));
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
