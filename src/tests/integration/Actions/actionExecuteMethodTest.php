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
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\Registry;

class actionExecuteMethodTest extends d3OrdermanagerActionIntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aArticleIdList = [
        'articleTestIdNo1',
        'articleTestIdNo2',
    ];

    public $aOrderIdList = [
        'orderTestIdNo1',
        'orderTestIdNo2',
    ];

    public $aOrderArticleIdList = [
        'orderTestIdNo1Article1',
        'orderTestIdNo2Article1',
    ];

    /**
     * @throws Exception
     */
    public function createTestData()
    {
        $this->createManager($this->sManagerId);

        $this->createArticle(
            $this->aArticleIdList[0],
            [
                'oxtitle'       => __CLASS__,
                'oxparentid'    => null,
                'oxstock'       => 20,
            ]
        );

        $this->createOrder(
            $this->aOrderIdList[0],
            [
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxparentid'    => '',
                'oxbillcompany' => __CLASS__,
            ],
            [
                $this->aOrderArticleIdList[0] => [
                    'oxtitle'       => __CLASS__,
                    'oxartid'       => $this->aArticleIdList[0],
                ],
            ]
        );

        $this->createArticle(
            $this->aArticleIdList[1],
            [
                'oxtitle'       => __CLASS__,
                'oxparentid'    => null,
                'oxstock'       => 20,
            ]
        );

        $this->createOrder(
            $this->aOrderIdList[1],
            [
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxparentid'    => '',
                'oxbillcompany' => __CLASS__,
            ],
            [
                $this->aOrderArticleIdList[1] => [
                    'oxtitle'       => __CLASS__,
                    'oxartid'       => $this->aArticleIdList[1],
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
        $this->deleteOrder($this->aOrderIdList[0]);
        $this->deleteOrder($this->aOrderIdList[1]);
        $this->deleteArticle($this->aArticleIdList[0]);
        $this->deleteArticle($this->aArticleIdList[1]);
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getConfiguredManager()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blActionOrderExecuteMethod_status', true);
        $oManager->setValue('sActionExecuteMethod_name', 'cancelOrder');
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
    public function actionChangeConcernedOrder()
    {
        // prevent save trigger action in test
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, true);

        $oExecute = $this->getExecuteMock($this->getConfiguredManager());
        $oExecute->startJobItemExecution();

        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, false);

        /** @var Order $oOrder */
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);
        $oOrder->load($this->aOrderIdList[0]);
        $this->assertEquals(
            1,
            $oOrder->getFieldData('oxstorno')
        );

        /** @var Order $oOrder */
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);
        $oOrder->load($this->aOrderIdList[1]);
        $this->assertEquals(
            0,
            $oOrder->getFieldData('oxstorno')
        );
    }
}
