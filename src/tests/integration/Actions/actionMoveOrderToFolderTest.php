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

namespace D3\Ordermanager\tests\integration\Actions;

use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\Registry;

class actionMoveOrderToFolderTest extends d3OrdermanagerActionIntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aOrderIdList = [
        'orderTestIdNo1',
        'orderTestIdNo2',
    ];

    public $sCurrentValue = 'currentFolder';
    public $sExpectedValue = 'newFolder';

    /**
     * @throws Exception
     */
    public function createTestData()
    {
        $this->createManager($this->sManagerId);

        $this->createOrder(
            $this->aOrderIdList[0],
            [
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxfolder'     => $this->sCurrentValue,
                'oxbillcompany' => __CLASS__,
            ]
        );

        $this->createOrder(
            $this->aOrderIdList[1],
            [
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxfolder'     => $this->sCurrentValue,
                'oxbillcompany' => __CLASS__,
            ]
        );
    }

    /**
     * @throws DBALException
     */
    public function cleanTestData()
    {
        $this->deleteManager($this->sManagerId);
        $this->deleteOrder($this->aOrderIdList[0]);
        $this->deleteOrder($this->aOrderIdList[1]);
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerExistingFolder()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blActionOrder2Folder_status', true);
        $oManager->setValue('sOrderFolder', $this->sExpectedValue);
        $oManager->setValue('blItemExecute', true);

        return $oManager;
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerNotExistingFolder()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blActionOrder2Folder_status', true);
        $oManager->setValue('sOrderFolder', 'notExistingFolder');
        $oManager->setValue('blItemExecute', true);

        return $oManager;
    }

    /**
     * @return ListModel
     * @throws Exception
     */
    public function getFilledResultList()
    {
        return $this->getResultList([$this->aOrderIdList[0]]);
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
    public function actionChangeConcernedOrderExistingFolder()
    {
        /** @var Config $config */
        $config = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);
        $config->setConfigParam(
            'aOrderfolder',
            [
                $this->sCurrentValue => '#FF0000',
                $this->sExpectedValue => '#FF0000',
            ]
        );

        // prevent save trigger action in test
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, true);

        $oExecute = $this->getExecuteMock($this->getConfiguredManagerExistingFolder());
        $oExecute->startJobItemExecution();

        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, false);

        /** @var Order $oOrder */
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);
        $oOrder->load($this->aOrderIdList[0]);
        $this->assertSame(
            $this->sExpectedValue,
            $oOrder->getFieldData('oxfolder')
        );

        /** @var Order $oOrder */
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);
        $oOrder->load($this->aOrderIdList[1]);
        $this->assertSame(
            $this->sCurrentValue,
            $oOrder->getFieldData('oxfolder')
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
    public function actionChangeConcernedOrderNotExistingFolder()
    {
        /** @var Config $config */
        $config = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);
        $config->setConfigParam(
            'aOrderfolder',
            [
                $this->sCurrentValue => '#FF0000',
            ]
        );

        // prevent save trigger action in test
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, true);

        $oExecute = $this->getExecuteMock($this->getConfiguredManagerNotExistingFolder());
        $oExecute->startJobItemExecution();

        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, false);

        /** @var Order $oOrder */
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);
        $oOrder->load($this->aOrderIdList[0]);
        $this->assertSame(
            $this->sCurrentValue,
            $oOrder->getFieldData('oxfolder')
        );

        /** @var Order $oOrder */
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);
        $oOrder->load($this->aOrderIdList[1]);
        $this->assertSame(
            $this->sCurrentValue,
            $oOrder->getFieldData('oxfolder')
        );
    }
}
