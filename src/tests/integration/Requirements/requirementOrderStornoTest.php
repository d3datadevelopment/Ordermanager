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
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;

class requirementOrderStornoTest extends d3OrdermanagerRequirementIntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aOrderIdList = [
        'orderTestIdNo1',
        'orderTestIdNo2',
    ];
    public $aOrderArticleIdList = [
        'orderTestIdNo1Article1',
        'orderTestIdNo2Article1',
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
                'oxstorno'      => '1',
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
                'oxstorno'      => '0',
            ],
            [
                $this->aOrderArticleIdList[1] => [
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
    public function getConfiguredManager()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckOrderstorno_status', true);

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
    public function requirementsSelectsRightOrders()
    {
        $oListGenerator = $this->getListGenerator($this->getConfiguredManager());
        $oOrderList = $oListGenerator->getConcernedItems();

        $this->assertTrue(
            $oOrderList->count() >= 1
            && $oOrderList->offsetExists($this->aOrderIdList[0])
            && false == $oOrderList->offsetExists($this->aOrderIdList[1])
        );
    }
}
