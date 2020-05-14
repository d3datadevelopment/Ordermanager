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
namespace D3\Ordermanager\tests\integration;

use D3\ModCfg\Application\Model\d3database;
use D3\ModCfg\Application\Model\Log\d3log;
use D3\ModCfg\Tests\unit\d3ModCfgUnitTestCase;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_listgenerator;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\FetchMode;
use Exception;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Application\Model\Groups;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Model\BaseModel;
use PHPUnit\Framework\MockObject\MockObject;

abstract class d3OrdermanagerIntegrationTestCase extends d3ModCfgUnitTestCase
{
    /**
     * Set up fixture.
     */
    public function setUp()
    {
        parent::setUp();

        $this->createTestData();
    }

    /**
     * Tear down fixture.
     */
    public function tearDown()
    {
        $this->cleanTestData();

        parent::tearDown();
    }

    abstract public function createTestData();

    abstract public function cleanTestData();

    /**
     * @param $sClass
     * @param $sId
     * @param array $aFields
     * @throws Exception
     */
    public function createObject($sClass, $sId, $aFields = array())
    {
        /** @var BaseModel $oOrder */
        $oOrder = d3GetModCfgDIC()->get($sClass);

        if ($oOrder->exists($sId)) {
            $oOrder->delete($sId);
        }
        
        $oOrder->setId($sId);
        $oOrder->assign($aFields);
        $oOrder->save();
    }

    /**
     * @param $sTableName
     * @param $sId
     * @param array $aFields
     * @throws Exception
     */
    public function createBaseModelObject($sTableName, $sId, $aFields = array())
    {
        /** @var BaseModel $oOrder */
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.BaseModel::class);
        $oOrder->init($sTableName);
        $oOrder->setId($sId);
        $oOrder->assign($aFields);
        $oOrder->save();
    }

    /**
     * @param $sId
     * @param array $aFields
     * @throws Exception
     */
    public function createArticle($sId, $aFields = array())
    {
        $this->createObject(
            'd3ox.ordermanager.'.Article::class,
            $sId,
            array_merge(
                array('oxprice' => 0),
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
            d3ordermanager::class,
            $sId,
            array(
                'OXSHOPID'          => 1,
                'OXACTIVE'          => true,
                'OXTITLE'           => 'orderManagerTestTitle',
                'OXMODID'           => 'd3_ordermanager',
                'D3_OM_MARKORDER'   => false,
            )
        );
    }

    /**
     * @param $sId
     * @param array $aFields
     * @param array $aOrderArticles
     * @throws Exception
     */
    public function createOrder($sId, $aFields = array(), $aOrderArticles = array())
    {
        $this->createObject('d3ox.ordermanager.'.Order::class, $sId, $aFields);

        if (is_array($aOrderArticles) && count($aOrderArticles)) {
            foreach ($aOrderArticles as $sOArtId => $aOArtFields) {
                $this->createObject('d3ox.ordermanager.'.OrderArticle::class, $sOArtId, array_merge(array('oxorderid' => $sId), $aOArtFields));
            }
        }
    }

    /**
     * @param $sId
     * @param array $aFields
     * @throws Exception
     */
    public function createUser($sId, $aFields = array())
    {
        $this->createObject(
            'd3ox.ordermanager.'.User::class,
            $sId,
            array_merge(array('oxusername'   => $sId, $aFields))
        );
    }

    /**
     * @param $sId
     * @param array $aFields
     * @throws Exception
     */
    public function createGroup($sId, $aFields = array())
    {
        $this->createObject('d3ox.ordermanager.'.Groups::class, $sId, $aFields);
    }

    /**
     * @param $sClass
     * @param $sId
     */
    public function deleteObject($sClass, $sId)
    {
        try {
            /** @var BaseModel $oObject */
            $oObject = d3GetModCfgDIC()->get($sClass);
            if ($oObject->exists($sId)) {
                $oObject->delete($sId);
            }
        } catch (Exception $ex) {}
    }

    /**
     * @param $sTableName
     * @param $sId
     */
    public function deleteBaseModelObject($sTableName, $sId)
    {
        try {
            /** @var BaseModel $oObject */
            $oObject = d3GetModCfgDIC()->get('d3ox.ordermanager.' . BaseModel::class);
            $oObject->init($sTableName);
            if ($oObject->exists($sId)) {
                $oObject->delete($sId);
            }
        } catch (Exception $ex) {}
    }

    /**
     * @param $sId
     * @throws DBALException
     */
    public function deleteManager($sId)
    {
        $this->deleteObject(d3ordermanager::class, $sId);
        $qb = d3database::getInstance()->getQueryBuilder();
        $qb->select('oxid')
            ->from('d3order2ordermanager')
            ->where('oxordermanagerid = '.$qb->createNamedParameter($sId));

        foreach ((array) $qb->execute()->fetchAll(FetchMode::ASSOCIATIVE) as $aId) {
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
            ->setMethods(['log'])
            ->getMock();
        $oD3LogMock->method('log')->willReturn(true);

        return $oD3LogMock;
    }

    /**
     * @param $sManagerId
     * @return d3ordermanager|MockObject
     * @throws Exception
     */
    public function getManagerMock($sManagerId)
    {
        /** @var d3ordermanager|MockObject $oManager */
        $oManager = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods([
                'd3getLog',
                'getListGenerator',
                'getRecalculateFlag'
            ])
            ->getMock();
        $oManager->method('d3getLog')->willReturn($this->getD3LogMock());
        $oManager->method('getListGenerator')->willReturn($this->getListGenerator($oManager));
        $oManager->method('getRecalculateFlag')->willReturn(false);
        $oManager->load($sManagerId);

        return $oManager;
    }

    /**
     * @param d3ordermanager $oManager
     * @return d3ordermanager_listgenerator|MockObject
     * @throws Exception
     */
    public function getListGenerator(d3ordermanager $oManager)
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_listgenerator::class.'.args.ordermanager',
            $oManager
        );

        /** @var d3ordermanager_listgenerator $object */
        $object = d3GetModCfgDIC()->get(d3ordermanager_listgenerator::class);

        return $object;
    }
}