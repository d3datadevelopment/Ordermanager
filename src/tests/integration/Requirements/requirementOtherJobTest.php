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

class requirementOtherJobTest extends d3OrdermanagerRequirementIntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aOrderIdList = array(
        'orderTestIdNo1',
        'orderTestIdNo2',
        'orderTestIdNo3',
    );
    public $aOrderArticleIdList = array(
        'orderTestIdNo1Article1',
        'orderTestIdNo2Article1',
        'orderTestIdNo3Article1',
    );
    public $aAssignIdList = array(
        'toOrderManagerAssignIdNo1',
        'toOrderManagerAssignIdNo2',
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
                    'oxtitle'           => __CLASS__,
                )
            )
        );

        $this->createBaseModelObject(
            'd3order2ordermanager',
            $this->aAssignIdList[0],
            array(
                'oxorderid'    => $this->aOrderIdList[0],
                'oxordermanagerid'    => 'TestJobIdPass',
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
                    'oxtitle'       => __CLASS__,
                )
            )
        );

        $this->createBaseModelObject(
            'd3order2ordermanager',
            $this->aAssignIdList[1],
            array(
                'oxorderid'    => $this->aOrderIdList[1],
                'oxordermanagerid'    => 'TestJobIdNotPass',
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
                    'oxtitle'       => __CLASS__,
                )
            )
        );
    }

    /**
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function cleanTestData()
    {
        $this->deleteManager($this->sManagerId);

        foreach ($this->aOrderIdList as $sOrderId) {
            $this->deleteOrder($sOrderId);
        }

        foreach ($this->aAssignIdList as $sAssignId) {
            $this->deleteBaseModelObject('d3order2ordermanager', $sAssignId);
        }
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerNotExec()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckOtherJob_status', true);
        $oManager->setValue('sOtherJob_Type', 'notexec');
        $oManager->setValue('sOtherJob_ID', 'TestJobIdPass');

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
    public function requirementsSelectsRightOrdersNotExec()
    {
        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerNotExec());
        $oOrderList = $oListGenerator->getConcernedOrders();

        $this->assertTrue(
            $oOrderList->count() >= 2
            && $oOrderList->offsetExists($this->aOrderIdList[1])
            && $oOrderList->offsetExists($this->aOrderIdList[2])
            && false == $oOrderList->offsetExists($this->aOrderIdList[0])
        );
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerExec()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckOtherJob_status', true);
        $oManager->setValue('sOtherJob_Type', 'exec');
        $oManager->setValue('sOtherJob_ID', 'TestJobIdPass');

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
    public function requirementsSelectsRightOrdersExec()
    {
        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerExec());
        $oOrderList = $oListGenerator->getConcernedOrders();

        $this->assertTrue($oOrderList->count() >= 1);
        $this->assertTrue($oOrderList->offsetExists($this->aOrderIdList[0]));
        $this->assertFalse($oOrderList->offsetExists($this->aOrderIdList[1]));
        $this->assertFalse($oOrderList->offsetExists($this->aOrderIdList[2]));
    }
}
