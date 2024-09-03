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
use D3\Ordermanager\Application\Model\Output\d3ordermanager_debugoutput;
use D3\Ordermanager\Application\Model\Output\d3ordermanager_nulloutput;
use D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager;
use D3\Ordermanager\publicDir\d3_ordermanager_cron;
use D3\Ordermanager\tests\integration\d3IntegrationTestCase;
use D3\Ordermanager\tests\tools\Intercept;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Order as Item;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Registry;

class executeCLICronTest extends d3IntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aArticleIdList = [
        'articleTestIdNo1',
        'articleTestIdNo2',
    ];
    public $aCountryIdList = [
        'testCountryId1Pass',
        'testCountryId2Pass',
        'testCountryIdDontPass',
    ];
    public $aOrderIdList = [
        'orderTestIdNo1',
        'orderTestIdNo2',
    ];
    public $aOrderArticleIdList = [
        'orderTestIdNo1Article1',
        'orderTestIdNo2Article1',
    ];

    public $dCurrentValue = 1.23;
    public $dExpectedValue = 2.34;

    public function setUp(): void
    {
        parent::setUp();

        d3GetOxidDIC()->set(
            d3ordermanager_debugoutput::class,
            oxNew(d3ordermanager_nulloutput::class)
        );
    }

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
                'oxvarstock'    => 0,
                'oxvarcount'    => 0,
                'oxshopid'      => Registry::getConfig()->getShopId(),
                'oxstockflag'   => 1,
            ]
        );

        foreach ($this->aCountryIdList as $sId) {
            $this->createBaseModelObject('oxcountry', $sId, [ 'oxtitle' => __METHOD__ ]);
        }

        $this->createOrder(
            $this->aOrderIdList[0],
            [
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxsenddate'    => '2018-01-01 00:00:00',
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

        $this->createArticle(
            $this->aArticleIdList[1],
            [
                'oxtitle'       => __CLASS__,
                'oxparentid'    => null,
                'oxstock'       => 20,
                'oxvarstock'    => 0,
                'oxvarcount'    => 0,
                'oxshopid'      => Registry::getConfig()->getShopId(),
                'oxstockflag'   => 1,
            ]
        );

        $this->createOrder(
            $this->aOrderIdList[1],
            [
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxsenddate'    => '2018-01-01 00:00:00',
                'oxdelcost'     => $this->dCurrentValue,
                'oxcurrate'     => 1,
                'oxbillcountryid'   => $this->aCountryIdList[2],
                'oxdelcountryid'    => $this->aCountryIdList[1],
                'oxbillcompany' => __CLASS__,
            ],
            [
                $this->aOrderArticleIdList[1] => [
                    'oxartnum'      => 'expArtNum2',
                    'oxtitle'       => 'expTitle2',
                    'oxshortdesc'   => 'expShortDesc2',
                    'oxselvariant'  => 'expSelVariant2',
                    'oxpersparam'   => 'expPersParam2',
                    'oxstorno'      => '0',
                    'oxartid'       => $this->aArticleIdList[1],
                ],
            ]
        );

        $this->getConfiguredManager()->save();
    }

    /**
     * @throws DBALException
     */
    public function cleanTestData()
    {
        $this->deleteManager($this->sManagerId);

        foreach ($this->aCountryIdList as $sId) {
            $this->deleteBaseModelObject('oxcountry', $sId);
        }

        $this->deleteOrder($this->aOrderIdList[0]);
        $this->deleteOrder($this->aOrderIdList[1]);
        $this->deleteArticle($this->aArticleIdList[0]);
        $this->deleteArticle($this->aArticleIdList[1]);
    }

    /**
     * @return Manager
     * @throws Exception
     */
    public function getConfiguredManager(): Manager
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->assign(
            [
                'D3_CRONJOBID'    => 'testId',
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
    public function runCronOk()
    {
        $set = d3_cfg_mod::get('d3_ordermanager');
        $blCurrentCronStatus = $set->getValue('blCronActive');
        $set->setValue('blCronActive', true);
        $set->assign([ 'oxactive' => 1 ]);
        $set->saveNoLicenseRefresh();

        $_GET['shp'] = '1';
        $_GET['cjid'] = 'testId';

        $this->setCLIArguments(['script', '-q', 'run', '1', 'testId']);

        // prevent save trigger action in test preparation
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, true);
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_FINALIZEORDER, true);

        /** @var d3_ordermanager_cron $cron */
        $cron = oxNew(d3_ordermanager_cron::class);
        $cron->run();

        // prevent save trigger action in test preparation
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, false);
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_FINALIZEORDER, false);

        $set->setValue('blCronActive', $blCurrentCronStatus);
        $set->assign([ 'oxactive' => 1 ]);
        $set->saveNoLicenseRefresh();

        /** @var Item $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $this->assertSame(
            round((float) $this->dExpectedValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );

        /** @var Item $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[1]);
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
    public function runCronCanceledInvalidRequirementConfig()
    {
        $set = d3_cfg_mod::get('d3_ordermanager');
        $blCurrentCronStatus = $set->getValue('blCronActive');
        $set->setValue('blCronActive', true);
        $set->assign([ 'oxactive' => 1 ]);
        $set->saveNoLicenseRefresh();

        $manager = $this->getConfiguredManager();
        $manager->setValue('sCustCountryId', [ 'notExistingCountryId' ]);
        $manager->save();

        $_GET['shp'] = '1';
        $_GET['cjid'] = 'testId';

        $this->setCLIArguments(['script', 'run', '1', 'testId']);

        stream_filter_register("intercept", Intercept::class);
        stream_filter_append(STDERR, "intercept");  // for warning messages and above
        //stream_filter_append(STDOUT, "intercept");  // for messages below warning level

        /** @var d3_ordermanager_cron $cron */
        $cron = oxNew(d3_ordermanager_cron::class);
        $cron->run();

        $this->getConfiguredManager()->save();

        $this->assertTrue(
            (bool) strlen(trim(Intercept::$cache))
        );
        Intercept::clearCache();

        $set->setValue('blCronActive', $blCurrentCronStatus);
        $set->assign([ 'oxactive' => 1 ]);
        $set->saveNoLicenseRefresh();

        /** @var Item $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $this->assertSame(
            round((float) $this->dCurrentValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );

        /** @var Item $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[1]);
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
    public function runCronCanceledInvalidActionConfig()
    {
        $set = d3_cfg_mod::get('d3_ordermanager');
        $blCurrentCronStatus = $set->getValue('blCronActive');
        $set->setValue('blCronActive', true);
        $set->assign([ 'oxactive' => 1 ]);
        $set->saveNoLicenseRefresh();

        $manager = $this->getConfiguredManager();
        $manager->setValue('sActionChangeDelCostValue', 'invalid');
        $manager->save();

        $_GET['shp'] = '1';
        $_GET['cjid'] = 'testId';

        $this->setCLIArguments(['script', 'run', '1', 'testId']);

        stream_filter_register("intercept", Intercept::class);
        stream_filter_append(STDERR, "intercept");  // for warning messages and above
        //stream_filter_append(STDOUT, "intercept");  // for messages below warning level

        /** @var d3_ordermanager_cron $cron */
        $cron = oxNew(d3_ordermanager_cron::class);
        $cron->run();

        $this->getConfiguredManager()->save();

        $this->assertTrue(
            (bool) strlen(trim(Intercept::$cache))
        );
        Intercept::clearCache();

        $set->setValue('blCronActive', $blCurrentCronStatus);
        $set->assign([ 'oxactive' => 1 ]);
        $set->saveNoLicenseRefresh();

        /** @var Item $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $this->assertSame(
            round((float) $this->dCurrentValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );

        /** @var Item $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[1]);
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
    public function runCronInactiveModule()
    {
        $set = d3_cfg_mod::get('d3_ordermanager');
        $blCurrentCronStatus = $set->getValue('blCronActive');

        $set->setValue('blCronActive', true);
        $set->assign(['oxactive' => 0]);
        $set->saveNoLicenseRefresh();

        $_GET['shp'] = '1';
        $_GET['cjid'] = 'testId';

        $this->setCLIArguments(['script', 'run', '1', 'testId']);

        stream_filter_register("intercept", Intercept::class);
        stream_filter_append(STDERR, "intercept");  // for warning messages and above
        //stream_filter_append(STDOUT, "intercept");  // for messages below warning level

        /** @var d3_ordermanager_cron $cron */
        $cron = oxNew(d3_ordermanager_cron::class);
        $cron->run();

        $this->assertMatchesRegularExpression(
            '@.*(D3_ORDERMANAGER_EXC_CRON_MODULEDISABLED|Auftragsmanagermodul ist deaktiviert).*@',
            Intercept::$cache
        );

        $set->setValue('blCronActive', $blCurrentCronStatus);
        $set->assign(['oxactive' => 1]);
        $set->saveNoLicenseRefresh();

        /** @var Item $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $this->assertSame(
            round((float) $this->dCurrentValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );

        /** @var Item $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[1]);
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
    public function runDisabledCron()
    {
        $set = d3_cfg_mod::get('d3_ordermanager');
        $blCurrentCronStatus = $set->getValue('blCronActive');
        $set->setValue('blCronActive', false);
        $set->assign(['oxactive' => 1]);
        $set->saveNoLicenseRefresh();

        $this->setCLIArguments(['script', 'run', '1', 'testId']);

        stream_filter_register("intercept", Intercept::class);
        stream_filter_append(STDERR, "intercept");  // for warning messages and above
        //stream_filter_append(STDOUT, "intercept");  // for messages below warning level

        /** @var d3_ordermanager_cron $cron */
        $cron = oxNew(d3_ordermanager_cron::class);
        $cron->run();

        $this->assertMatchesRegularExpression(
            '@.*(D3_ORDERMANAGER_EXC_CRON_UNAVAILABLE|Cronjob Aufruf ist deaktiviert).*@',
            Intercept::$cache
        );

        $set->setValue('blCronActive', $blCurrentCronStatus);
        $set->assign(['oxactive' => 1]);
        $set->saveNoLicenseRefresh();

        /** @var Item $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $this->assertSame(
            round((float) $this->dCurrentValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );

        /** @var Item $oItem */
        $oItem = d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[1]);
        $this->assertSame(
            round((float) $this->dCurrentValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );
    }

    /**
     * @param array $arguments
     */
    public function setCLIArguments($arguments)
    {
        global $argv;
        $argv = $_SERVER['argv'] = $GLOBALS['HTTP_SERVER_VARS']['argv'] = $arguments;
    }
}
