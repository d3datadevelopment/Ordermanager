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

namespace D3\Ordermanager\tests\integration\Actions;

use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Model\ListModel;

/**
 * @coversNothing
 */
class actionSetFieldValueTest extends d3OrdermanagerActionIntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aOrderIdList = [
        'orderTestIdNo1',
        'orderTestIdNo2',
    ];

    public $sCurrentValue = 'currentBillFName';
    public $sExpectedValue = 'newBillFName';

    public function tearDown(): void
    {
        restore_error_handler();
        parent::tearDown();
    }

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
                'oxbillfname'     => $this->sCurrentValue,
                'oxbillcompany' => __CLASS__,
            ]
        );

        $this->createOrder(
            $this->aOrderIdList[1],
            [
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbillfname'     => $this->sCurrentValue,
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
    public function getConfiguredManagerExistingSingleLangField()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blActionOrderAddFieldValue_status', true);
        $oManager->setValue('sActionAddField_field', 'oxbillfname');
        $oManager->setValue('sActionAddField_value', $this->sExpectedValue);
        $oManager->setValue('blItemExecute', true);

        return $oManager;
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerNotExistingSingleLangField()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blActionOrderAddFieldValue_status', true);
        $oManager->setValue('sActionAddField_field', 'd3TestField');
        $oManager->setValue('sActionAddField_value', $this->sExpectedValue);
        $oManager->setValue('blItemExecute', true);

        return $oManager;
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManagerNotExistingMultiLangField()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blActionOrderAddFieldValue_status', true);
        $oManager->setValue('sActionAddField_field', 'd3TestField_1');
        $oManager->setValue('sActionAddField_value', $this->sExpectedValue);
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
    public function actionChangeConcernedOrderExistingSingleLangField()
    {
        $oExecute = $this->getExecuteMock($this->getConfiguredManagerExistingSingleLangField());
        $oExecute->startJobItemExecution();

        /** @var Order $oOrder */
        $oOrder = oxNew(Order::class);
        $oOrder->load($this->aOrderIdList[0]);
        $this->assertSame(
            $this->sExpectedValue,
            $oOrder->getFieldData('oxbillfname')
        );

        /** @var Order $oOrder */
        $oOrder = oxNew(Order::class);
        $oOrder->load($this->aOrderIdList[1]);
        $this->assertSame(
            $this->sCurrentValue,
            $oOrder->getFieldData('oxbillfname')
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
    public function actionChangeConcernedOrderNotExistingSingleLangField()
    {
        $oExecute = $this->getExecuteMock($this->getConfiguredManagerNotExistingSingleLangField());
        $oExecute->startJobItemExecution();

        /** @var Order $oOrder */
        $oOrder = oxNew(Order::class);

        $this->expectExceptionMessage('error occured');

        set_error_handler(static function () {
            //            $error = error_get_last();
            //            $errstr = $error['message'];
            throw new Exception('error occured');
        });

        $oOrder->load($this->aOrderIdList[0]);
        $this->assertNull(
            $oOrder->getFieldData('d3TestField')
        );

        $oOrder = oxNew(Order::class);
        $oOrder->load($this->aOrderIdList[1]);
        $this->assertNull(
            $oOrder->getFieldData('d3TestField')
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
    public function actionChangeConcernedOrderNotExistingMultiLangField()
    {
        $oExecute = $this->getExecuteMock($this->getConfiguredManagerNotExistingMultiLangField());
        $oExecute->startJobItemExecution();

        $this->expectExceptionMessage('error occured');

        set_error_handler(static function () {
            //            $error = error_get_last();
            //            $errstr = $error['message'];
            throw new Exception('error occured');
        });

        /** @var Order $oOrder */
        $oOrder = oxNew(Order::class);
        $oOrder->load($this->aOrderIdList[0]);
        $this->assertNull(
            $oOrder->getFieldData('d3TestField_1')
        );

        /** @var Order $oOrder */
        $oOrder = oxNew(Order::class);
        $oOrder->load($this->aOrderIdList[1]);
        $this->assertNull(
            $oOrder->getFieldData('d3TestField_1')
        );
    }
}
