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

namespace D3\Ordermanager\tests\integration\Trigger;

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager;
use D3\Ordermanager\tests\integration\d3IntegrationTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\Order as Item;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Exception\ArticleInputException;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\NoArticleException;
use OxidEsales\Eshop\Core\Exception\OutOfStockException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Registry;
use PHPUnit\Framework\MockObject\MockObject;

class finalizeOrderTest extends d3IntegrationTestCase
{
    public $sManagerId = 'managerTestId';
    public $aArticleIdList = [
        'articleTestIdNo1'
    ];
    public $aCountryIdList = [
        'testCountryId1Pass'
    ];
    public $aOrderIdList = [
        'orderTestIdNo1'
    ];
    public $aOrderArticleIdList = [
        'orderTestIdNo1Article1'
    ];
    public $aPaymentIdList = [
        'paymentTestIdNo1'
    ];
    public $aUserIdList = [
        'userTestIdNo1'
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
            array(
                'oxtitle'       => __CLASS__,
                'oxparentid'    => null,
                'oxstock'       => 20
            )
        );

        foreach ($this->aCountryIdList as $sId) {
            $this->createBaseModelObject( 'oxcountry', $sId, [ 'oxtitle' => __METHOD__ ] );
        }

        $this->createOrder(
            $this->aOrderIdList[0],
            array(
                'oxorderdate'   => '2018-01-01 00:00:00',
                'oxdelcost'     => $this->dCurrentValue,
                'oxcurrate'     => 1,
                'oxbillcountryid'   => $this->aCountryIdList[0],
                'oxdelcountryid'    => '',
                'oxbillcompany' => __CLASS__,
            ),
            array(
                $this->aOrderArticleIdList[0] => array(
                    'oxartnum'      => 'expArtNum1',
                    'oxtitle'       => 'expTitle1',
                    'oxshortdesc'   => 'expShortDesc1',
                    'oxselvariant'  => 'expSelVariant1',
                    'oxpersparam'   => 'expPersParam1',
                    'oxstorno'      => '0',
                    'oxartid'       => $this->aArticleIdList[0],
                ),
            )
        );

        $this->createUser(
            $this->aUserIdList[0],
            [
                'oxcountryid'  => $this->aCountryIdList[0]
            ]
        );

        $this->createBaseModelObject('oxpayments', $this->aPaymentIdList[0]);

        $this->getConfiguredManager()->save();
    }

    /**
     * @throws DBALException
     */
    public function cleanTestData()
    {
        $this->deleteManager($this->sManagerId);

        foreach ($this->aCountryIdList as $sId) {
            $this->deleteBaseModelObject( 'oxcountry', $sId);
        }

        $this->deleteOrder($this->aOrderIdList[0]);
        $this->deleteArticle($this->aArticleIdList[0]);
        $this->deleteBaseModelObject('oxpayments', $this->aPaymentIdList[0]);
        $this->deleteUser($this->aUserIdList[0]);
    }

    /**
     * @return mixed|Basket
     * @throws ArticleInputException
     * @throws NoArticleException
     * @throws OutOfStockException
     */
    public function getBasket(): Basket
    {
        $basket = oxNew(Basket::class);
        $basket->addToBasket($this->aArticleIdList[0], 1);
        $basket->setPayment($this->aPaymentIdList[0]);

        return $basket;
    }

    /**
     * @return Manager
     * @throws Exception
     */
    public function getConfiguredManager(): Manager
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->assign(
            array(
                'D3_CRONJOBID'               => 'testId',
                'D3_OM_ORDERFINISHTRIGGERED' => '1'
            )
        );

        $oManager->setValue('blActionOrderChangeDeliveryCost_status', true);
        $oManager->setValue('sActionChangeDelCostValue', $this->dExpectedValue);

        $oManager->setValue('blCheckCountry_status', true);
        $oManager->setValue( 'sCustCountryId', [ $this->aCountryIdList[0] ] );

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
        $set->assign( [ 'oxactive' => 1 ] );
        $set->saveNoLicenseRefresh();

        $user = oxNew(User::class);
        $user->load($this->aUserIdList[0]);

        /** @var Item|MockObject $oItem */
        $oItem = $this->getMockBuilder(Item::class)
            ->setMethods(
                ['validateOrder', '_loadFromBasket', '_executePayment', '_sendOrderByEmail']
            )
            ->getMock();
        $oItem->method('validateOrder')->willReturn(null);
        $oItem->method('_loadFromBasket')->willReturn(null);
        $oItem->method('_executePayment')->willReturn(true);
        $oItem->method('_sendOrderByEmail')->willReturn(Item::ORDER_STATE_OK);

        $manager = $this->getConfiguredManager();

        /** @var d3ordermanagerlist|MockObject $managerListMock */
        $managerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->setMethods(['d3GetOrderFinishTriggeredManagerTasks'])
            ->getMock();
        $managerListMock->offsetSet($manager->getId(), $manager);
        $managerListMock->method('d3GetOrderFinishTriggeredManagerTasks')->willReturnSelf();

        $definitions = d3GetModCfgDIC()->getDefinitions();

        d3GetModCfgDIC()->set(d3ordermanagerlist::class, $managerListMock);

        // prevent save trigger action in test preparation
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, true);

        $oItem->load($this->aOrderIdList[0]);
        $oItem->finalizeOrder(
            $this->getBasket(),
            $user
        );

        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, false);

        $sId = $oItem->getId();

        d3GetModCfgDIC()->reset();
        d3GetModCfgDIC()->setDefinitions($definitions);

        // require reload
        $oItem = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($sId);
        $this->assertSame(
            round((float) $this->dExpectedValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );
        $oItem->delete();
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
        $set->assign( [ 'oxactive' => 1 ] );
        $set->saveNoLicenseRefresh();

        $user = oxNew(User::class);
        $user->load($this->aUserIdList[0]);

        /** @var Item|MockObject $oItem */
        $oItem = $this->getMockBuilder(Item::class)
            ->setMethods(
                ['validateOrder', '_loadFromBasket', '_executePayment', '_sendOrderByEmail']
            )
            ->getMock();
        $oItem->method('validateOrder')->willReturn(null);
        $oItem->method('_loadFromBasket')->willReturn(null);
        $oItem->method('_executePayment')->willReturn(true);
        $oItem->method('_sendOrderByEmail')->willReturn(Item::ORDER_STATE_OK);

        $manager = $this->getConfiguredManager();
        $manager->setValue( 'sCustCountryId', [ 'notExistingCountryId' ] );
        $manager->save();

        /** @var d3ordermanagerlist|MockObject $managerListMock */
        $managerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->setMethods(['d3GetOrderFinishTriggeredManagerTasks'])
            ->getMock();
        $managerListMock->method('d3GetOrderFinishTriggeredManagerTasks')->willReturnSelf();

        $definitions = d3GetModCfgDIC()->getDefinitions();

        d3GetModCfgDIC()->set(d3ordermanagerlist::class, $managerListMock);

        // prevent save trigger action in test preparation
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, true);

        $oItem->load($this->aOrderIdList[0]);
        $oItem->finalizeOrder(
            oxNew(Basket::class),
            $user
        );

        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, false);

        $sId = $oItem->getId();

        d3GetModCfgDIC()->reset();
        d3GetModCfgDIC()->setDefinitions($definitions);

        $this->getConfiguredManager()->save();

        // require reload
        $oItem = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($sId);
        $this->assertSame(
            round((float) $this->dCurrentValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );
        $oItem->delete();
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
        $set->assign( [ 'oxactive' => 1 ] );
        $set->saveNoLicenseRefresh();

        $user = oxNew(User::class);
        $user->load($this->aUserIdList[0]);

        /** @var Item|MockObject $oItem */
        $oItem = $this->getMockBuilder(Item::class)
            ->setMethods(
                ['validateOrder', '_loadFromBasket', '_executePayment', '_sendOrderByEmail']
            )
            ->getMock();
        $oItem->method('validateOrder')->willReturn(null);
        $oItem->method('_loadFromBasket')->willReturn(null);
        $oItem->method('_executePayment')->willReturn(true);
        $oItem->method('_sendOrderByEmail')->willReturn(Item::ORDER_STATE_OK);

        $manager = $this->getConfiguredManager();
        $manager->setValue('sActionChangeDelCostValue', 'invalid');
        $manager->save();

        /** @var d3ordermanagerlist|MockObject $managerListMock */
        $managerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->setMethods(['d3GetOrderFinishTriggeredManagerTasks'])
            ->getMock();
        $managerListMock->method('d3GetOrderFinishTriggeredManagerTasks')->willReturnSelf();

        $definitions = d3GetModCfgDIC()->getDefinitions();

        d3GetModCfgDIC()->set(d3ordermanagerlist::class, $managerListMock);

        // prevent save trigger action in test preparation
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, true);

        $oItem->load($this->aOrderIdList[0]);
        $oItem->finalizeOrder(
            oxNew(Basket::class),
            $user
        );

        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, false);

        $sId = $oItem->getId();

        d3GetModCfgDIC()->reset();
        d3GetModCfgDIC()->setDefinitions($definitions);

        $this->getConfiguredManager()->save();

        // require reload
        $oItem = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($sId);
        $this->assertSame(
            round((float) $this->dCurrentValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );
        $oItem->delete();
    }

    /**
     * @test
     * @throws Exception
     */
    public function runDisabledTrigger()
    {
        $manager = $this->getConfiguredManager();
        $manager->assign(['D3_OM_ORDERFINISHTRIGGERED'  => '0']);
        $manager->save();

        /** @var d3ordermanagerlist|MockObject $managerListMock */
        $managerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->setMethods(['d3GetOrderFinishTriggeredManagerTasks'])
            ->getMock();
        $managerListMock->method('d3GetOrderFinishTriggeredManagerTasks')->willReturnSelf();

        $definitions = d3GetModCfgDIC()->getDefinitions();

        d3GetModCfgDIC()->set(d3ordermanagerlist::class, $managerListMock);

        $user = oxNew(User::class);
        $user->load($this->aUserIdList[0]);

        /** @var Item|MockObject $oItem */
        $oItem = $this->getMockBuilder(Item::class)
            ->setMethods(
                ['validateOrder', '_loadFromBasket', '_executePayment', '_sendOrderByEmail']
            )
            ->getMock();
        $oItem->method('validateOrder')->willReturn(null);
        $oItem->method('_loadFromBasket')->willReturn(null);
        $oItem->method('_executePayment')->willReturn(true);
        $oItem->method('_sendOrderByEmail')->willReturn(Item::ORDER_STATE_OK);

        // prevent save trigger action in test preparation
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, true);

        $oItem->load($this->aOrderIdList[0]);
        $oItem->finalizeOrder(
            oxNew(Basket::class),
            $user
        );
        $sId = $oItem->getId();

        d3GetModCfgDIC()->reset();
        d3GetModCfgDIC()->setDefinitions($definitions);

        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, false);

        // require reload
        $oItem = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($sId);
        $this->assertSame(
            round((float) $this->dCurrentValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );
        $oItem->delete();
    }
}
