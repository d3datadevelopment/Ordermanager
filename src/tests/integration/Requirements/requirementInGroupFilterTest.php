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
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_requirementException;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class requirementInGroupFilterTest extends d3OrdermanagerRequirementIntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aOrderIdList = [
        'orderTestIdNo1',
        'orderTestIdNo2',
        'orderTestIdNo3',
    ];
    public $aGroupsIdList = [
        'sGroupId1Pass',
        'sGroupId2Pass',
        'sGroupId3Pass',
    ];
    public $aOrderArticleIdList = [
        'orderTestIdNo1Article1',
        'orderTestIdNo2Article1',
        'orderTestIdNo3Article1',
    ];
    public $aGroupAssignIdList = [
        'groupAssignIdNo1',
        'groupAssignIdNo2',
        'groupAssignIdNo3',
    ];

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

        foreach ($this->aGroupsIdList as $sId) {
            $this->createBaseModelObject(
                'oxgroups',
                $sId,
                ['oxtitle' => __METHOD__]
            );
        }

        $this->createOrder(
            $this->aOrderIdList[0],
            array(
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
                'oxuserid'      => 'sUserIdNo1',
            ),
            array(
                $this->aOrderArticleIdList[0] => array(
                    'oxtitle'           => __CLASS__,
                )
            )
        );

        $this->createBaseModelObject(
            'oxobject2group',
            $this->aGroupAssignIdList[0],
            array(
                'oxobjectid'    => 'sUserIdNo1',
                'oxgroupsid'    => $this->aGroupsIdList[0],
            )
        );

        $this->createOrder(
            $this->aOrderIdList[1],
            array(
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
                'oxuserid'      => 'sUserIdNo2',
            ),
            array(
                $this->aOrderArticleIdList[1] => array(
                    'oxtitle'       => __CLASS__,
                )
            )
        );

        $this->createBaseModelObject(
            'oxobject2group',
            $this->aGroupAssignIdList[1],
            array(
                'oxobjectid'    => 'sUserIdNo2',
                'oxgroupsid'    => $this->aGroupsIdList[1],
            )
        );

        $this->createOrder(
            $this->aOrderIdList[2],
            array(
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillcompany' => __CLASS__,
                'oxuserid'      => 'sUserIdNo3',
            ),
            array(
                $this->aOrderArticleIdList[2] => array(
                    'oxtitle'       => __CLASS__,
                )
            )
        );

        $this->createBaseModelObject(
            'oxobject2group',
            $this->aGroupAssignIdList[2],
            array(
                'oxobjectid'    => 'sUserIdNo3',
                'oxgroupsid'    => $this->aGroupsIdList[2],
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

        foreach ($this->aGroupsIdList as $sId) {
            $this->deleteBaseModelObject(
                'oxgroups',
                $sId
            );
        }

        foreach ($this->aOrderIdList as $sOrderId) {
            $this->deleteOrder($sOrderId);
        }

        foreach ($this->aGroupAssignIdList as $sGroupAssignId) {
            $this->deleteBaseModelObject('oxobject2group', $sGroupAssignId);
        }
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerSingle()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckInGroup_status', true);
        $oManager->setValue('sCustInGroupId', [$this->aGroupsIdList[0]]);

        return $oManager;
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerMulti()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blCheckInGroup_status', true);
        $oManager->setValue('sCustInGroupId', [$this->aGroupsIdList[0], $this->aGroupsIdList[1]]);

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
        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerSingle());
        $oOrderList = $oListGenerator->getConcernedOrders();

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
        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerMulti());
        $oOrderList = $oListGenerator->getConcernedOrders();

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

        $oManager->setValue('blCheckInGroup_status', true);
        $oManager->setValue('sCustInGroupId', $invalidValue);

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
        $this->setExpectedException(d3ordermanager_requirementException::class);

        $oListGenerator = $this->getListGenerator($this->getConfiguredManagerNoValidConfig($testValue));
        $oListGenerator->getConcernedOrders();
    }

    /**
     * @return array
     */
    public function requirementsSelectsRightOrdersNoValidConfigDataProvider()
    {
        return [
            'unknown'=> ['unknownValue'],
            'space'  => [' '],
            'empty'  => [''],
            'false'  => [false]
        ];
    }
}
