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
use DateTime;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\Registry;

class actionExportListTest extends d3OrdermanagerActionIntegrationTestCase
{
    public $sManagerId = 'managerTestId';

    public $aOrderIdList = array(
        'orderTestIdNo1',
        'orderTestIdNo2',
    );

    public $given    = 'CurrentCity';
    public $expected = 'TestCity';

    /**
     * @throws Exception
     */
    public function createTestData()
    {
        $this->createManager($this->sManagerId);

        $this->createOrder(
            $this->aOrderIdList[0],
            array(
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbilllname'       => 'order1',
                'oxbillcompany' => __CLASS__,
            )
        );

        $this->createOrder(
            $this->aOrderIdList[1],
            array(
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxbilllname'   => 'order2',
                'oxbillcompany' => __CLASS__,
            )
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
    public function getConfiguredManager()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->setValue('blActionExport_status', true);
        $oManager->setValue('aExportFieldList', ['oxid', 'oxbilllname']);
        $oManager->setValue('sExportListFromTheme', 'module');
        $oManager->setValue('sExportListFromModulePath', 'd3ordermanager');
        $oManager->setValue('sExportTemplatename', 'Application/views/admin/tpl/export-templates/CSV-Vorlage.tpl');
        $oManager->setValue('sExportExtension', '.txt');
        $oManager->setValue('blItemExecute', true);

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
    public function actionChangeConcernedOrder()
    {
        $oExecute = $this->getExecuteMock($this->getConfiguredManager());
        $oExecute->startJobItemExecution();

        $time = new DateTime();
        foreach ([
            $time->format('Y-m-d_H-i-s'),
            $time->modify("-1 second")->format('Y-m-d_H-i-s'),
            $time->modify("-2 second")->format('Y-m-d_H-i-s')
        ] as $date) {
            $fileName = "d3ordermananger_orderManagerTestTitle_".$date.".txt";
            $filePath = Registry::getConfig()->getConfigParam('sShopDir').'/export/'.$fileName;
            if (file_exists($filePath)) {
                $this->assertSame(
                    '"oxid","oxbilllname"'.PHP_EOL.'"orderTestIdNo1","order1"'.PHP_EOL,
                    file_get_contents($filePath)
                );
                unlink($filePath);
                break;
            }
        }

    }

    /**
     * @return ListModel
     * @throws Exception
     */
    public function getFilledResultList()
    {
        return $this->getResultList(array($this->aOrderIdList[0]));
    }
}
