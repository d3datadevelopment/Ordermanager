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
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Model\ListModel;

class actionDeleteOrderTest extends d3OrdermanagerActionIntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aArticleIdList = array(
        'articleTestIdNo1',
        'articleTestIdNo2',
    );

    public $aOrderIdList = array(
        'orderTestIdNo1',
        'orderTestIdNo2',
    );

    public $aOrderArticleIdList = array(
        'orderTestIdNo1Article1',
        'orderTestIdNo2Article1',
    );

    /**
     * @throws Exception
     */
    public function createTestData()
    {
        $this->createManager($this->sManagerId);

        $this->createArticle(
            $this->aArticleIdList[0],
            array(
                'oxtitle'       => __CLASS__,
                'oxparentid'    => null,
                'oxstock'       => 20
            )
        );

        $this->createOrder(
            $this->aOrderIdList[0],
            array(
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxparentid'    => '',
                'oxbillcompany' => __CLASS__,
            ),
            array(
                $this->aOrderArticleIdList[0] => array(
                    'oxtitle'       => __CLASS__,
                    'oxartid'       => $this->aArticleIdList[0],
                ),
            )
        );

        $this->createArticle(
            $this->aArticleIdList[1],
            array(
                'oxtitle'       => __CLASS__,
                'oxparentid'    => null,
                'oxstock'       => 20
            )
        );

        $this->createOrder(
            $this->aOrderIdList[1],
            array(
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxparentid'    => '',
                'oxbillcompany' => __CLASS__,
            ),
            array(
                $this->aOrderArticleIdList[1] => array(
                    'oxtitle'       => __CLASS__,
                    'oxartid'       => $this->aArticleIdList[1],
                ),
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

        $oManager->setValue('blActionOrderDelete_status', true);
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
    public function actionChangeConcernedOrder()
    {
        $oExecute = $this->getExecuteMock($this->getConfiguredManager());
        $oExecute->startJobItemExecution();

        $sSelect = "SELECT count(*) FROM oxorder WHERE oxid IN ('{$this->aOrderIdList[0]}')";
        $this->assertSame(
            0,
            (int) DatabaseProvider::getDb()->getOne($sSelect)
        );

        $sSelect = "SELECT count(*) FROM oxorder WHERE oxid IN ('{$this->aOrderIdList[1]}')";
        $this->assertSame(
            1,
            (int) DatabaseProvider::getDb()->getOne($sSelect)
        );

    }
}
