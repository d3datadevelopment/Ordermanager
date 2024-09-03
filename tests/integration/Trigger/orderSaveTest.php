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

namespace D3\Ordermanager\tests\integration\Trigger;

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager;
use D3\Ordermanager\tests\integration\d3IntegrationTestCase;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Order as Item;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @coversNothing
 */
class orderSaveTest extends d3IntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aArticleIdList = [
        'articleTestIdNo1',
    ];
    public $aCountryIdList = [
        'testCountryId1Pass',
    ];
    public $aOrderIdList = [
        'orderTestIdNo1',
    ];
    public $aOrderArticleIdList = [
        'orderTestIdNo1Article1',
    ];

    public $dCurrentValue = 1.23;
    public $dExpectedValue = 2.34;

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

        foreach ($this->aCountryIdList as $sId) {
            $this->createBaseModelObject('oxcountry', $sId, [ 'oxtitle' => __METHOD__ ]);
        }

        $this->createOrder(
            $this->aOrderIdList[0],
            [
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxdelcost'     => $this->dCurrentValue,
                'oxcurrate'     => 1,
                'oxbillcountryid'   => $this->aCountryIdList[0],
                'oxdelcountryid'    => '',
                'oxbillcompany' => __CLASS__,
            ],
            [
                $this->aOrderArticleIdList[0] => [
                    'oxartnum'      => 'expArtNum1',
                    'oxtitle'       => 'expTitle1',
                    'oxshortdesc'   => 'expShortDesc1',
                    'oxselvariant'  => 'expSelVariant1',
                    'oxpersparam'   => 'expPersParam1',
                    'oxstorno'      => '0',
                    'oxartid'       => $this->aArticleIdList[0],
                ],
            ]
        );

        $this->getConfiguredManager()->save();
    }

    /**
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws Exception
     */
    public function cleanTestData()
    {
        $this->deleteManager($this->sManagerId);

        foreach ($this->aCountryIdList as $sId) {
            $this->deleteBaseModelObject('oxcountry', $sId);
        }

        $this->deleteOrder($this->aOrderIdList[0]);
        $this->deleteArticle($this->aArticleIdList[0]);
    }

    /**
     * @return Manager
     * @throws Exception
     */
    public function getConfiguredManager()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->assign(
            [
                'D3_CRONJOBID'              => 'testId',
                'd3_om_ordersavetriggered'  => '1',
            ]
        );

        $oManager->setValue('blActionOrderChangeDeliveryCost_status', true);
        $oManager->setValue('sActionChangeDelCostValue', $this->dExpectedValue);

        $oManager->setValue('blCheckCountry_status', true);
        $oManager->setValue('sCustCountryId', [ $this->aCountryIdList[0] ]);

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
    public function runTriggerOk()
    {
        $set = d3_cfg_mod::get('d3_ordermanager');
        $set->assign([ 'oxactive' => 1 ]);
        $set->saveNoLicenseRefresh();

        $manager = $this->getConfiguredManager();
        /** @var d3ordermanagerlist|MockObject $managerListMock */
        $managerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetOrderSaveTriggeredManagerTasks'])
            ->getMock();
        $managerListMock->offsetSet($manager->getId(), $manager);
        $managerListMock->method('d3GetOrderSaveTriggeredManagerTasks')->willReturnSelf();

        $definitions = d3GetOxidDIC()->getDefinitions();

        d3GetOxidDIC()->set(d3ordermanagerlist::class, $managerListMock);

        /** @var Item $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $oItem->save();

        d3GetOxidDIC()->reset();
        d3GetOxidDIC()->setDefinitions($definitions);

        // require reload
        /** @var d3_oxorder_ordermanager $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $this->assertSame(
            round((float) $this->dExpectedValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
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
    public function runTriggerCanceledInvalidRequirementConfig()
    {
        $set = d3_cfg_mod::get('d3_ordermanager');
        $set->assign([ 'oxactive' => 1 ]);
        $set->saveNoLicenseRefresh();

        $manager = $this->getConfiguredManager();
        $manager->setValue('sCustCountryId', [ 'notExistingCountryId' ]);
        $manager->save();

        /** @var d3ordermanagerlist|MockObject $managerListMock */
        $managerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetOrderSaveTriggeredManagerTasks'])
            ->getMock();
        $managerListMock->offsetSet($manager->getId(), $manager);
        $managerListMock->method('d3GetOrderSaveTriggeredManagerTasks')->willReturnSelf();

        $definitions = d3GetOxidDIC()->getDefinitions();

        d3GetOxidDIC()->set(d3ordermanagerlist::class, $managerListMock);

        /** @var Item $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $oItem->save();

        d3GetOxidDIC()->reset();
        d3GetOxidDIC()->setDefinitions($definitions);

        // require reload
        /** @var d3_oxorder_ordermanager $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $this->assertSame(
            round((float) $this->dCurrentValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
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
    public function runTriggerCanceledInvalidActionConfig()
    {
        $set = d3_cfg_mod::get('d3_ordermanager');
        $set->assign([ 'oxactive' => 1 ]);
        $set->saveNoLicenseRefresh();

        $manager = $this->getConfiguredManager();
        $manager->setValue('sActionChangeDelCostValue', 'invalid');
        $manager->save();

        /** @var d3ordermanagerlist|MockObject $managerListMock */
        $managerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetOrderSaveTriggeredManagerTasks'])
            ->getMock();
        $managerListMock->method('d3GetOrderSaveTriggeredManagerTasks')->willReturnSelf();

        $definitions = d3GetOxidDIC()->getDefinitions();

        d3GetOxidDIC()->set(d3ordermanagerlist::class, $managerListMock);

        /** @var Item $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $oItem->save();

        d3GetOxidDIC()->reset();
        d3GetOxidDIC()->setDefinitions($definitions);

        // require reload
        /** @var d3_oxorder_ordermanager $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $this->assertSame(
            round((float) $this->dCurrentValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );
    }

    /**
     * @test
     * @throws Exception
     */
    public function runDisabledTrigger()
    {
        $manager = $this->getConfiguredManager();
        $manager->assign(['D3_OM_ORDERSAVETRIGGERED'  => '0']);
        $manager->save();

        /** @var d3ordermanagerlist|MockObject $managerListMock */
        $managerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetOrderSaveTriggeredManagerTasks'])
            ->getMock();
        $managerListMock->method('d3GetOrderSaveTriggeredManagerTasks')->willReturnSelf();

        $definitions = d3GetOxidDIC()->getDefinitions();

        d3GetOxidDIC()->set(d3ordermanagerlist::class, $managerListMock);

        /** @var Item $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $oItem->save();

        d3GetOxidDIC()->reset();
        d3GetOxidDIC()->setDefinitions($definitions);

        // require reload
        /** @var d3_oxorder_ordermanager $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $this->assertSame(
            round((float) $this->dCurrentValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );
    }
}
