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

namespace D3\Ordermanager\tests\integration;

use D3\DIContainerHandler\d3DicHandler;
use D3\ModCfg\Application\Model\d3database;
use D3\ModCfg\Application\Model\Log\d3log;
use D3\ModCfg\Application\Model\Log\d3NullLogger;
use D3\ModCfg\Tests\unit\d3ModCfgUnitTestCase;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_listgenerator as Manager_Listgenerator;
use D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Driver\Exception as DriverException;
use Exception;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Application\Model\Groups;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Model\BaseModel;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\ConnectionProviderInterface;
use PHPUnit\Framework\MockObject\MockObject;

abstract class d3IntegrationTestCase extends d3ModCfgUnitTestCase
{
    /**
     * Set up fixture.
     */
    public function setUp(): void
    {
        /** @var Connection $connection */
        $connection = ContainerFactory::getInstance()->getContainer()->get(ConnectionProviderInterface::class)->get();
        $connection->prepare('SET time_zone = ?')->executeStatement([date_default_timezone_get()]);

        d3DicHandler::getUncompiledInstance();

        parent::setUp();

        d3GetOxidDIC()->set('d3.ordermanager.log', d3GetOxidDIC()->get(d3NullLogger::class));

        $this->createTestData();
    }

    /**
     * Tear down fixture.
     */
    public function tearDown(): void
    {
        $this->cleanTestData();

        parent::tearDown();

        d3DicHandler::removeInstance();
    }

    abstract public function createTestData();

    abstract public function cleanTestData();

    /**
     * @param $sClass
     * @param $sId
     * @param array $aFields
     * @throws Exception
     */
    public function createObject($sClass, $sId, $aFields = [])
    {
        /** @var BaseModel $oObject */
        $oObject = d3GetOxidDIC()->get($sClass);

        if ($oObject->exists($sId)) {
            $oObject->delete($sId);
        }

        $oObject->setId($sId);
        $oObject->assign($aFields);
        $oObject->save();
    }

    /**
     * @param $sTableName
     * @param $sId
     * @param array $aFields
     * @throws Exception
     */
    public function createBaseModelObject($sTableName, $sId, $aFields = [])
    {
        /** @var BaseModel $oObject */
        $oObject = d3GetOxidDIC()->get('d3ox.ordermanager.'.BaseModel::class);
        $oObject->init($sTableName);
        $oObject->setId($sId);
        $oObject->assign($aFields);
        $oObject->save();
    }

    /**
     * @param $sId
     * @param array $aFields
     * @throws Exception
     */
    public function createArticle($sId, $aFields = [])
    {
        $this->createObject(
            'd3ox.ordermanager.'.Article::class,
            $sId,
            array_merge(
                [
                    'oxprice'   => 0,
                    'oxvarstock'=> 0,
                    'oxvarcount'=> 0,
                    'oxshopid'  => 1,
                    'oxstockflag'   => 1,
                ],
                $aFields
            )
        );
    }

    /**
     * @param $sId
     * @throws Exception
     */
    public function createManager($sId)
    {
        $this->createObject(
            Manager::class,
            $sId,
            [
                'OXSHOPID'          => 1,
                'OXACTIVE'          => true,
                'OXTITLE'           => 'orderManagerTestTitle',
                'OXMODID'           => 'd3_ordermanager',
                'D3_OM_MARKORDER'   => false,
            ]
        );
    }

    /**
     * @param $sId
     * @param array $aFields
     * @param array $aOrderArticles
     * @throws Exception
     */
    public function createOrder($sId, $aFields = [], $aOrderArticles = [])
    {
        // prevent trigger action in test preparation
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, true);

        $this->createObject(
            'd3ox.ordermanager.'.Order::class,
            $sId,
            array_merge(
                [
                    'oxsenddate'    => '1970-01-01 00:00:00',
                ],
                $aFields
            )
        );

        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, false);

        if (is_array($aOrderArticles) && count($aOrderArticles)) {
            foreach ($aOrderArticles as $sOArtId => $aOArtFields) {
                $this->createObject('d3ox.ordermanager.'.OrderArticle::class, $sOArtId, array_merge(['oxorderid' => $sId], $aOArtFields));
            }
        }
    }

    /**
     * @param $sId
     * @param $aFields
     *
     * @return void
     * @throws Exception
     */
    public function createGroup($sId, $aFields = [])
    {
        $this->createObject(
            'd3ox.ordermanager.'.Groups::class,
            $sId,
            array_merge(
                //['oxusername'   => (string) $sId],
                $aFields
            )
        );
    }

    /**
     * @param $sId
     * @param array $aFields
     * @throws Exception
     */
    public function createUser($sId, $aFields = [])
    {
        $sClass = 'd3ox.ordermanager.'.User::class;

        /** @var BaseModel $oObject */
        $oObject = d3GetOxidDIC()->get($sClass);

        $oObject->assign(['oxusername'  => $sId]);

        if ($oObject->exists($sId)) {
            $oObject->delete($sId);
        }

        $oObject->setId($sId);
        $oObject->assign(
            array_merge(
                [
                    'oxpassword'    => '',
                    'oxusername'    => $sId,
                ],
                $aFields
            )
        );
        $oObject->save();

        // can't use getObject because exists check don't work without an assigned username
//        $this->createObject(
//            'd3ox.ordermanager.'.User::class,
//            $sId,
//            array_merge(
//                [
//                    'oxpassword'    => '',
//                  'oxusername'   => (string) $sId
//                ],
//                $aFields
//            )
//        );
    }

    /**
     * @param $sClass
     * @param $sId
     */
    public function deleteObject($sClass, $sId)
    {
        try {
            /** @var BaseModel $oObject */
            $oObject = d3GetOxidDIC()->get($sClass);
            if (method_exists($oObject, 'setRights')) {
                $oObject->setRights(null);
            }
            if ($oObject->exists($sId)) {
                $oObject->delete($sId);
            }
        } catch (Exception $ex) {
        }
    }

    /**
     * @param $sTableName
     * @param $sId
     */
    public function deleteBaseModelObject($sTableName, $sId)
    {
        try {
            /** @var BaseModel $oObject */
            $oObject = d3GetOxidDIC()->get('d3ox.ordermanager.' . BaseModel::class);
            $oObject->init($sTableName);
            if (method_exists($oObject, 'setRights')) {
                $oObject->setRights(null);
            }
            if ($oObject->exists($sId)) {
                $oObject->delete($sId);
            }
        } catch (Exception $ex) {
        }
    }

    /**
     * @param $sId
     * @throws DBALException
     * @throws DriverException
     */
    public function deleteManager($sId)
    {
        $this->deleteObject(Manager::class, $sId);
        $qb = d3database::getInstance()->getQueryBuilder();
        $qb->select('oxid')
            ->from('d3order2ordermanager')
            ->where('oxordermanagerid = '.$qb->createNamedParameter($sId));

        foreach ($qb->execute()->fetchAllAssociative() as $aId) {
            $aId = array_change_key_case($aId, CASE_UPPER);
            $this->deleteBaseModelObject('d3order2ordermanager', $aId['OXID']);
        }
    }

    /**
     * @param $sId
     */
    public function deleteArticle($sId)
    {
        $this->deleteObject('d3ox.ordermanager.'.Article::class, $sId);
    }

    /**
     * @param $sId
     */
    public function deleteOrder($sId)
    {
        $this->deleteObject('d3ox.ordermanager.'.Order::class, $sId);
    }

    /**
     * @param $sId
     */
    public function deleteUser($sId)
    {
        $this->deleteObject('d3ox.ordermanager.'.User::class, $sId);
    }

    /**
     * @return d3log|MockObject
     */
    public function getD3LogMock()
    {
        /** @var d3log|MockObject $oD3LogMock */
        $oD3LogMock = $this->getMockBuilder(d3log::class)
            ->onlyMethods(['log'])
            ->getMock();
        $oD3LogMock->method('log')->willReturnSelf();

        return $oD3LogMock;
    }

    /**
     * @param $sManagerId
     * @return Manager|MockObject
     * @throws Exception
     */
    public function getManagerMock($sManagerId)
    {
        /** @var Manager|MockObject $oManager */
        $oManager = $this->getMockBuilder(Manager::class)
            ->onlyMethods([
                'd3getLog',
                'getListGenerator',
                'getRecalculateFlag',
            ])
            ->getMock();
        $oManager->method('d3getLog')->willReturn($this->getD3LogMock());
        $oManager->method('getListGenerator')->willReturn($this->getListGenerator($oManager));
        $oManager->method('getRecalculateFlag')->willReturn(false);
        $oManager->load($sManagerId);

        return $oManager;
    }

    /**
     * @param Manager $oManager
     * @return Manager_Listgenerator|MockObject
     * @throws Exception
     */
    public function getListGenerator(Manager $oManager)
    {
        d3GetOxidDIC()->set(
            Manager_Listgenerator::class.'.args.ordermanager',
            $oManager
        );

        /** @var Manager_Listgenerator $object */
        $object = d3GetOxidDIC()->get(Manager_Listgenerator::class);

        return $object;
    }
}
