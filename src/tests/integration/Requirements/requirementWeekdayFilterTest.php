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
use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirement_weekdayfilter;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use PHPUnit\Framework\MockObject\MockObject;

class requirementWeekdayFilterTest extends d3OrdermanagerRequirementIntegrationTestCase
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
                'oxsenddate'        => '2018-01-04 00:00:00',
                'oxpaid'            => '2018-01-07 00:00:00',
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
                'oxorderdate'   => '2018-01-02 00:00:00',
                'oxbillcompany' => __CLASS__,
                'oxsenddate'        => '2018-01-05 00:00:00',
                'oxpaid'            => '2018-01-08 00:00:00',
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
                'oxorderdate'   => '2018-01-03 00:00:00',
                'oxbillcompany' => __CLASS__,
                'oxsenddate'        => '2018-01-06 00:00:00',
                'oxpaid'            => '2018-01-09 00:00:00',
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
    public function getConfiguredManagerSingleOrderDate()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckWeekdays_status', true);
        $oManager->setValue('sWeekdaysType', d3ordermanager_requirement_weekdayfilter::TYPE_ORDERDATE);
        $oManager->setValue('sWeekdayDays', [d3ordermanager_requirement_weekdayfilter::WEEKDAY_MON]);

        return $oManager;
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerMultiOrderDate()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckWeekdays_status', true);
        $oManager->setValue('sWeekdaysType', d3ordermanager_requirement_weekdayfilter::TYPE_ORDERDATE);
        $oManager->setValue('sWeekdayDays', [d3ordermanager_requirement_weekdayfilter::WEEKDAY_TUE, d3ordermanager_requirement_weekdayfilter::WEEKDAY_WED]);

        return $oManager;
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerSingleDelDate()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckWeekdays_status', true);
        $oManager->setValue('sWeekdaysType', d3ordermanager_requirement_weekdayfilter::TYPE_DELDATE);
        $oManager->setValue('sWeekdayDays', [d3ordermanager_requirement_weekdayfilter::WEEKDAY_FRI]);

        return $oManager;
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerMultiDelDate()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckWeekdays_status', true);
        $oManager->setValue('sWeekdaysType', d3ordermanager_requirement_weekdayfilter::TYPE_DELDATE);
        $oManager->setValue('sWeekdayDays', [d3ordermanager_requirement_weekdayfilter::WEEKDAY_THU, d3ordermanager_requirement_weekdayfilter::WEEKDAY_SAT]);

        return $oManager;
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerSinglePaidDate()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckWeekdays_status', true);
        $oManager->setValue('sWeekdaysType', d3ordermanager_requirement_weekdayfilter::TYPE_PAIDDATE);
        $oManager->setValue('sWeekdayDays', [d3ordermanager_requirement_weekdayfilter::WEEKDAY_TUE]);

        return $oManager;
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerMultiPaidDate()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckWeekdays_status', true);
        $oManager->setValue('sWeekdaysType', d3ordermanager_requirement_weekdayfilter::TYPE_PAIDDATE);
        $oManager->setValue('sWeekdayDays', [d3ordermanager_requirement_weekdayfilter::WEEKDAY_SUN, d3ordermanager_requirement_weekdayfilter::WEEKDAY_MON]);

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
    public function requirementsSelectsRightOrdersSingleOrderDate()
    {
        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerSingleOrderDate());
        $oOrderList = $oListGenerator->getConcernedItems();

        $this->assertTrue(
            $oOrderList->count() >= 1
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
    public function requirementsSelectsRightOrdersMultiOrderDate()
    {
        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerMultiOrderDate());
        $oOrderList = $oListGenerator->getConcernedItems();

        $this->assertTrue(
            $oOrderList->count() >= 2
            && false == $oOrderList->offsetExists($this->aOrderIdList[0])
            && $oOrderList->offsetExists($this->aOrderIdList[1])
            && $oOrderList->offsetExists($this->aOrderIdList[2])
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
    public function requirementsSelectsRightOrdersSingleDelDate()
    {
        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerSingleDelDate());
        $oOrderList = $oListGenerator->getConcernedItems();

        $this->assertTrue(
            $oOrderList->count() >= 1
            && false == $oOrderList->offsetExists($this->aOrderIdList[0])
            && $oOrderList->offsetExists($this->aOrderIdList[1])
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
    public function requirementsSelectsRightOrdersMultiDelDate()
    {
        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerMultiDelDate());
        $oOrderList = $oListGenerator->getConcernedItems();

        $this->assertTrue(
            $oOrderList->count() >= 2
            && $oOrderList->offsetExists($this->aOrderIdList[0])
            && false == $oOrderList->offsetExists($this->aOrderIdList[1])
            && $oOrderList->offsetExists($this->aOrderIdList[2])
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
    public function requirementsSelectsRightOrdersSinglePaidDate()
    {
        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerSinglePaidDate());
        $oOrderList = $oListGenerator->getConcernedItems();

        $this->assertTrue(
            $oOrderList->count() >= 1
            && false == $oOrderList->offsetExists($this->aOrderIdList[0])
            && false == $oOrderList->offsetExists($this->aOrderIdList[1])
            && $oOrderList->offsetExists($this->aOrderIdList[2])
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
    public function requirementsSelectsRightOrdersMultiPaidDate()
    {
        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerMultiPaidDate());
        $oOrderList = $oListGenerator->getConcernedItems();

        $this->assertTrue(
            $oOrderList->count() >= 2
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

        $oManager->setValue('blCheckWeekdays_status', true);
        $oManager->setValue('sWeekdayDays', $invalidValue);

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
