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
namespace D3\Ordermanager\tests\integration\Actions;

use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Object2Group;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Model\ListModel;

class actionCustAddToGroupTest extends d3OrdermanagerActionIntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aOrderIdList = array(
        'orderTestIdNo1',
    );
    public $aUserIdList = array(
        'orderUserTestIdNo1',
    );
    public $aO2GroupIdList = array(
        'o2groupTestIdNo1',
    );
    public $aGroupsIdList = array(
        'groupTestIdNo1',
        'groupTestIdNo2',
    );

    /**
     * @throws Exception
     */
    public function createTestData()
    {
        $this->createManager($this->sManagerId);

        $this->createGroup($this->aGroupsIdList[0]);
        $this->createGroup($this->aGroupsIdList[1]);

        $this->createOrder(
            $this->aOrderIdList[0],
            array(
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxuserid'     => $this->aUserIdList[0],
                'oxcurrate'     => 1,
                'oxbillcompany' => __CLASS__,
            )
        );

        $this->createUser($this->aUserIdList[0]);
    }

    /**
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws Exception
     */
    public function cleanTestData()
    {
        $this->deleteManager($this->sManagerId);
        $this->deleteOrder($this->aOrderIdList[0]);
        $this->deleteUser($this->aUserIdList[0]);
        $this->deleteObject('d3ox.ordermanager.'.Object2Group::class, $this->aO2GroupIdList[0]);

        $aQueries = [
            "DELETE FROM oxobject2group WHERE oxobjectid = '{$this->aUserIdList[0]}' AND oxgroupsid = '{$this->aGroupsIdList[0]}'",
            "DELETE FROM oxobject2group WHERE oxobjectid = '{$this->aUserIdList[0]}' AND oxgroupsid = '{$this->aGroupsIdList[1]}'",
        ];
        foreach ($aQueries as $sQuery) {
            DatabaseProvider::getDb()->execute($sQuery);
        }
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerSingleGroupsExists()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blActionCust2Group_status', true);
        $oManager->setValue('sCustAddGroup', array($this->aGroupsIdList[0]));
        $oManager->setValue('blItemExecute', true);

        return $oManager;
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerMultiGroupsExists()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blActionCust2Group_status', true);
        $oManager->setValue('sCustAddGroup', array($this->aGroupsIdList[0], $this->aGroupsIdList[1]));
        $oManager->setValue('blItemExecute', true);

        return $oManager;
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerSingleGroupsNotExistsNotAssigned()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blActionCust2Group_status', true);
        $oManager->setValue('sCustAddGroup', array('unknownGroupId'));
        $oManager->setValue('blItemExecute', true);

        return $oManager;
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerNoGroups()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blActionCust2Group_status', true);
        $oManager->setValue('sCustAddGroup', array());
        $oManager->setValue('blItemExecute', true);

        return $oManager;
    }

    /**
     * @return ListModel
     * @throws Exception
     */
    public function getFilledResultList()
    {
        return $this->getResultList(array($this->aOrderIdList[0]));
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
    public function actionChangeConcernedOrderSingleGroupsExistsNotAssigned()
    {
        $oExecute = $this->getExecuteMock($this->getConfiguredManagerSingleGroupsExists());
        $oExecute->startJobItemExecution();

        // check assignment pass
        $sSelect = "SELECT count(*) FROM oxobject2group WHERE oxobjectid = '{$this->aUserIdList[0]}' AND oxgroupsid IN ('{$this->aGroupsIdList[0]}')";
        $this->assertSame(
            1,
            (int) DatabaseProvider::getDb()->getOne($sSelect)
        );

        // check other assignments
        $sSelect = "SELECT count(*) FROM oxobject2group WHERE oxobjectid = '{$this->aUserIdList[0]}' AND oxgroupsid NOT IN ('{$this->aGroupsIdList[0]}')";
        $this->assertSame(
            0,
            (int) DatabaseProvider::getDb()->getOne($sSelect)
        );
        $sSelect = "SELECT count(*) FROM oxobject2group WHERE oxobjectid != '{$this->aUserIdList[0]}' AND oxgroupsid IN ('{$this->aGroupsIdList[0]}')";
        $this->assertSame(
            0,
            (int) DatabaseProvider::getDb()->getOne($sSelect)
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
    public function actionChangeConcernedOrderMultiGroupsExistsNotAssigned()
    {
        $oExecute = $this->getExecuteMock($this->getConfiguredManagerMultiGroupsExists());
        $oExecute->startJobItemExecution();

        // check assignment pass
        $sSelect = "SELECT count(*) FROM oxobject2group WHERE oxobjectid = '{$this->aUserIdList[0]}' AND oxgroupsid IN ('{$this->aGroupsIdList[0]}', '{$this->aGroupsIdList[1]}')";
        $this->assertSame(
            2,
            (int) DatabaseProvider::getDb()->getOne($sSelect)
        );

        // check other assignments
        $sSelect = "SELECT count(*) FROM oxobject2group WHERE oxobjectid = '{$this->aUserIdList[0]}' AND oxgroupsid NOT IN ('{$this->aGroupsIdList[0]}', '{$this->aGroupsIdList[1]}')";
        $this->assertSame(
            0,
            (int) DatabaseProvider::getDb()->getOne($sSelect)
        );
        $sSelect = "SELECT count(*) FROM oxobject2group WHERE oxobjectid != '{$this->aUserIdList[0]}' AND oxgroupsid IN ('{$this->aGroupsIdList[0]}', '{$this->aGroupsIdList[1]}')";
        $this->assertSame(
            0,
            (int) DatabaseProvider::getDb()->getOne($sSelect)
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
    public function actionChangeConcernedOrderSingleGroupsExistsAlreadyAssigned()
    {
        $this->createObject(
            'd3ox.ordermanager.'.Object2Group::class,
            $this->aO2GroupIdList[0],
            array(
                'oxshopid'      => 1,
                'oxobjectid'    => $this->aUserIdList[0],
                'oxgroupsid'    => $this->aGroupsIdList[0],
            )
        );

        $oExecute = $this->getExecuteMock($this->getConfiguredManagerSingleGroupsExists());
        $oExecute->startJobItemExecution();

        // check assignment pass
        $sSelect = "SELECT count(*) FROM oxobject2group WHERE oxobjectid = '{$this->aUserIdList[0]}' AND oxgroupsid IN ('{$this->aGroupsIdList[0]}')";
        $this->assertSame(
            1,
            (int) DatabaseProvider::getDb()->getOne($sSelect)
        );

        // check other assignments
        $sSelect = "SELECT count(*) FROM oxobject2group WHERE oxobjectid = '{$this->aUserIdList[0]}' AND oxgroupsid NOT IN ('{$this->aGroupsIdList[0]}')";
        $this->assertSame(
            0,
            (int) DatabaseProvider::getDb()->getOne($sSelect)
        );
        $sSelect = "SELECT count(*) FROM oxobject2group WHERE oxobjectid != '{$this->aUserIdList[0]}' AND oxgroupsid IN ('{$this->aGroupsIdList[0]}')";
        $this->assertSame(
            0,
            (int) DatabaseProvider::getDb()->getOne($sSelect)
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
    public function actionChangeConcernedOrderSingleGroupsNotExistsNotAssigned()
    {
        $oExecute = $this->getExecuteMock($this->getConfiguredManagerSingleGroupsNotExistsNotAssigned());
        $oExecute->startJobItemExecution();

        // check assignment pass
        $sSelect = "SELECT count(*) FROM oxobject2group WHERE oxobjectid = '{$this->aUserIdList[0]}' AND oxgroupsid IN ('unknownGroupId')";
        $this->assertSame(
            0,
            (int) DatabaseProvider::getDb()->getOne($sSelect)
        );

        // check other assignments
        $sSelect = "SELECT count(*) FROM oxobject2group WHERE oxobjectid = '{$this->aUserIdList[0]}' AND oxgroupsid NOT IN ('unknownGroupId')";
        $this->assertSame(
            0,
            (int) DatabaseProvider::getDb()->getOne($sSelect)
        );
        $sSelect = "SELECT count(*) FROM oxobject2group WHERE oxobjectid != '{$this->aUserIdList[0]}' AND oxgroupsid IN ('unknownGroupId')";
        $this->assertSame(
            0,
            (int) DatabaseProvider::getDb()->getOne($sSelect)
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
    public function actionChangeConcernedOrderNoGroups()
    {
        $oExecute = $this->getExecuteMock($this->getConfiguredManagerNoGroups());
        $oExecute->startJobItemExecution();

        $sSelect = "SELECT count(*) FROM oxobject2group WHERE oxobjectid = '{$this->aUserIdList[0]}'";
        $this->assertSame(
            0,
            (int) DatabaseProvider::getDb()->getOne($sSelect)
        );
    }
}
