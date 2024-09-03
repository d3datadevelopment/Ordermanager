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
use D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager;
use Doctrine\DBAL\Exception as DBALException;
use donatj\MockWebServer\MockWebServer;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\Registry;

class actionSendPushNotificationTest extends d3OrdermanagerActionIntegrationTestCase
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
    public function getConfiguredManager($url)
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blActionOrderSendPushNotification_status', true);
        $oManager->setValue('sActionSendPushNotification_url', $url);
        $oManager->setValue('sActionSendPushNotification_method', 'POST');
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
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     */
    public function actionRequestSuccess()
    {
        // prevent save trigger action in test
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, true);

        $testServer = new MockWebServer(3456);
        $oExecute = $this->getExecuteMock($this->getConfiguredManager($testServer->getServerRoot()));
        try {
            $testServer->start();
            $oExecute->startJobItemExecution();
            $this->assertMatchesRegularExpression( '@.*orderNr.*@', $testServer->getLastRequest()->getInput() );
        } catch (Exception $e) {
            throw $e;
        } finally {
            $testServer->stop();
            Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, false);
        }
    }

    /**
     * @test
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     */
    public function actionRequestFailed()
    {
        // prevent save trigger action in test
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, true);

        $testServer = new MockWebServer(3456);
        $oExecute = $this->getExecuteMock($this->getConfiguredManager(str_replace('3456', '4567', $testServer->getServerRoot())));

        try {
            $testServer->start();
            $this->expectException( GuzzleException::class );

            $oExecute->startJobItemExecution();
        } catch (Exception $e) {
            throw $e;
        } finally {
            $testServer->stop();
            Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, false);
        }
    }
}
