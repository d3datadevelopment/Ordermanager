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
use PHPUnit\Framework\MockObject\MockObject;

class requirementToOrderNrTest extends d3OrdermanagerRequirementIntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aOrderIdList = [
        'orderTestIdNo1',
        'orderTestIdNo2',
        'orderTestIdNo3',
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
     *
     * @throws DBALException
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
                'oxordernr'     => '5432',
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
                'oxordernr'     => '5433',
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
                'oxordernr'     => '5431',
            ],
            [
                $this->aOrderArticleIdList[2] => [
                    'oxtitle'       => __CLASS__,
                ],
            ]
        );
    }

    /**
     * @throws DBALException
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
    public function getConfiguredManager(): d3ordermanager
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckToOrderNr_status', true);
        $oManager->setValue('sToOrderNrValue', '5432');

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
            $oOrderList->count() >= 2
            && $oOrderList->offsetExists($this->aOrderIdList[0])
            && $oOrderList->offsetExists($this->aOrderIdList[2])
            && false == $oOrderList->offsetExists($this->aOrderIdList[1])
        );
    }

    /**
     * @param $orderNrValue
     *
     * @return d3ordermanager|MockObject
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getConfiguredManagerNoValidConfig($orderNrValue)
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckToOrderNr_status', true);
        $oManager->setValue('sToOrderNrValue', $orderNrValue);

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
            'spaceOrderNr'  => ['   '],
            'emptyOrderNr'  => [''],
            'falseOrderNr'  => [false],
        ];
    }
}
