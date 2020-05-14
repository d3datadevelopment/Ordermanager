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
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Model\ListModel;
use PHPUnit\Framework\MockObject\MockObject;

class requirementExecuteMethodFilterTest extends d3OrdermanagerRequirementIntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aOrderIdList = array(
        'orderTestIdNo1',
        'orderTestIdNo2',
    );
    public $aOrderArticleIdList = array(
        'orderTestIdNo1Article1',
        'orderTestIdNo2Article1',
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
                'oxbillnr'      => 'TestBillNo1',
            ),
            array(
                $this->aOrderArticleIdList[0] => array(
                    'oxtitle'           => __CLASS__,
                )
            )
        );

        $this->createOrder(
            $this->aOrderIdList[1],
            array(
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
                'oxbillnr'      => '0',
            ),
            array(
                $this->aOrderArticleIdList[1] => array(
                    'oxtitle'       => __CLASS__,
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
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManager()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blItemExecute', true);
        $oManager->setValue('blCheckExecuteMethod_status', true);
        $oManager->setValue('sRequirementExecuteMethod_name', 'testChangeOrderList');

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
    public function requirementsSelectsRightOrders()
    {
        $oListGenerator = $this->getListGenerator($this->getConfiguredManager());

        /** @var ListModel|MockObject $oListMock */
        $oListMock = $this->getMockBuilder(ListModel::class)
            ->setMethods(['testChangeOrderList'])
            ->getMock();
        $oListMock->expects($this->once())->method('testChangeOrderList')->willReturn(null);
        d3GetModCfgDIC()->set('d3ox.ordermanager.'.ListModel::class, $oListMock);

        $oOrderList = $oListGenerator->getConcernedOrders();

        $this->assertTrue(
            $oOrderList->count() >= 2
            && $oOrderList->offsetExists($this->aOrderIdList[0])
            && $oOrderList->offsetExists($this->aOrderIdList[1])
        );
    }
}
