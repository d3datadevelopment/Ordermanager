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
namespace D3\Ordermanager\tests\integration\Requirements;

use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Object2Category;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;

class requirementArticleContentTest extends d3OrdermanagerRequirementIntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aOrderIdList = array(
        'orderTestIdNo1',
        'orderTestIdNo2',
        'orderTestIdNo3',
        'orderTestIdNo4',
        'orderTestIdNo5',
    );
    public $aOrderArticleIdList = array(
        'orderTestIdNo1Article1',
        'orderTestIdNo2Article1',
        'orderTestIdNo3Article1',
        'orderTestIdNo4Article1',
        'orderTestIdNo5Article1',
    );
    public $aArt2CatIdList = array(
        'a2cTestIdNo1',
    );

    /**
     * Set up fixture.
     * @throws Exception
     */
    public function setUp()
    {
        parent::setUp();

        $this->createTestData();
    }

    /**
     * Tear down fixture.
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function tearDown()
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
            array(
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
            ),
            array(
                $this->aOrderArticleIdList[0] => array(
                    'oxartnum'      => 'expArtNum1',
                    'oxtitle'       => 'expTitle1',
                    'oxshortdesc'   => 'expShortDesc1',
                    'oxselvariant'  => 'expSelVariant1',
                    'oxpersparam'   => 'expPersParam1',
                    'oxstorno'      => '0',
                    'oxartid'       => 'artIdTestNo1',
                )
            )
        );

        $this->createObject(
            'd3ox.ordermanager.'.Object2Category::class,
            $this->aArt2CatIdList[0],
            array(
                'oxshopid'      => '1',
                'oxobjectid'    => 'artIdTestNo1',
                'oxcatnid'      => 'catTestId',
            )
        );

        $this->createOrder(
            $this->aOrderIdList[1],
            array(
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
            ),
            array(
                $this->aOrderArticleIdList[1] => array(
                    'oxartnum'      => 'expArtNum2',
                    'oxtitle'       => 'expTitle2',
                    'oxshortdesc'   => 'expShortDesc2',
                    'oxselvariant'  => 'expSelVariant2',
                    'oxpersparam'   => 'expPersParam2',
                    'oxstorno'      => '0',
                    'oxorderid'     => $this->aOrderIdList[1],
                    'oxartid'       => 'artIdTestNo2',
                )
            )
        );

        $this->createOrder(
            $this->aOrderIdList[2],
            array(
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
            ),
            array(
                $this->aOrderArticleIdList[2] => array(
                    'oxartnum'      => 'expArtNum3',
                    'oxtitle'       => 'expTitle3',
                    'oxshortdesc'   => 'expShortDesc3',
                    'oxselvariant'  => 'expSelVariant3',
                    'oxpersparam'   => 'expPersParam3',
                    'oxstorno'      => '0',
                    'oxartid'       => 'artIdTestNo3',
                )
            )
        );

        $this->createOrder(
            $this->aOrderIdList[3],
            array(
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
            ),
            array(
                $this->aOrderArticleIdList[3] => array(
                    'oxartnum'      => 'expArtNum4',
                    'oxtitle'       => 'expTitle4',
                    'oxshortdesc'   => 'expShortDesc4',
                    'oxselvariant'  => 'expSelVariant4',
                    'oxpersparam'   => 'expPersParam4',
                    'oxstorno'      => '0',
                    'oxorderid'     => $this->aOrderIdList[3],
                    'oxartid'       => 'artIdTestNo4',
                )
            )
        );

        $this->createOrder(
            $this->aOrderIdList[4],
            array(
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
            ),
            array(
                $this->aOrderArticleIdList[4] => array(
                    'oxartnum'      => 'expArtNum5',
                    'oxtitle'       => 'expTitle5',
                    'oxshortdesc'   => 'expShortDesc5',
                    'oxselvariant'  => 'expSelVariant5',
                    'oxpersparam'   => 'expPersParam5',
                    'oxstorno'      => '0',
                    'oxartid'       => 'artIdTestNo5',
                )
            )
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
     * @coversNothing
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
        $oOrderList = $oListGenerator->getConcernedOrders();

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
        $oManager = d3GetModCfgDIC()->get(d3ordermanager::class);
        $oManager->load($this->sManagerId);

        $oManager->setValue('blCheckOrderArticle1_status', true);
        $oManager->setValue('sArticleContent1Type', 'oxtitle');
        $oManager->setValue('sArticleContent1RegExp', 'expTitle2');

        return $oManager;
    }

    /**
     * @test
     * @coversNothing
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
        $oOrderList = $oListGenerator->getConcernedOrders();

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
        $oManager = d3GetModCfgDIC()->get(d3ordermanager::class);
        $oManager->load($this->sManagerId);

        $oManager->setValue('blCheckOrderArticle1_status', true);
        $oManager->setValue('sArticleContent1Type', 'oxshortdesc');
        $oManager->setValue('sArticleContent1RegExp', 'expShortDesc3');

        return $oManager;
    }

    /**
     * @test
     * @coversNothing
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
        $oOrderList = $oListGenerator->getConcernedOrders();

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
        $oManager = d3GetModCfgDIC()->get(d3ordermanager::class);
        $oManager->load($this->sManagerId);

        $oManager->setValue('blCheckOrderArticle1_status', true);
        $oManager->setValue('sArticleContent1Type', 'oxselvariant');
        $oManager->setValue('sArticleContent1RegExp', 'expSelVariant4');

        return $oManager;
    }

    /**
     * @test
     * @coversNothing
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
        $oOrderList = $oListGenerator->getConcernedOrders();

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
        $oManager = d3GetModCfgDIC()->get(d3ordermanager::class);
        $oManager->load($this->sManagerId);

        $oManager->setValue('blCheckOrderArticle1_status', true);
        $oManager->setValue('sArticleContent1Type', 'oxpersparam');
        $oManager->setValue('sArticleContent1RegExp', 'expPersParam5');

        return $oManager;
    }

    /**
     * @test
     * @coversNothing
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
        $oOrderList = $oListGenerator->getConcernedOrders();

        $this->assertTrue(
            $oOrderList->count() === 1
            && $oOrderList->offsetExists($this->aOrderIdList[4])
            && false == $oOrderList->offsetExists($this->aOrderIdList[0])
            && false == $oOrderList->offsetExists($this->aOrderIdList[1])
            && false == $oOrderList->offsetExists($this->aOrderIdList[2])
            && false == $oOrderList->offsetExists($this->aOrderIdList[3])
        );
    }
}
