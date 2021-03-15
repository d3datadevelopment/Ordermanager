<?php

/**
 * This Software is the property of Data Development and is protected
 * by copyright law - it is NOT Freeware.
 * Any unauthorized use of this software without a valid license
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 * https://www.d3data.de
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author        D3 Data Development - Daniel Seifert <support@shopmodule.com>
 * @link          https://www.oxidmodule.com
 */

namespace D3\Ordermanager\tests\integration\Admin;

use D3\Ordermanager\Application\Controller\Admin\d3_ordermanager_jobs;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager;
use D3\Ordermanager\tests\integration\d3IntegrationTestCase;
use Exception;
use OxidEsales\Eshop\Application\Model\Order as Item;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Registry;
use ReflectionException;

class jobExecuteTest extends d3IntegrationTestCase
{
    /** @var d3_ordermanager_jobs */
    public $_oController;
    public $sManagerId = 'managerTestId';
    public $aArticleIdList = array(
        'articleTestIdNo1'
    );
    public $aCountryIdList = [
        'testCountryId1Pass'
    ];
    public $aOrderIdList = array(
        'orderTestIdNo1'
    );
    public $aOrderArticleIdList = array(
        'orderTestIdNo1Article1'
    );

    public $dCurrentValue = 1.23;
    public $dExpectedValue = 2.34;

    public function setUp()
    {
        parent::setUp();

        $this->_oController = oxNew(d3_ordermanager_jobs::class);
    }

    /**
     * @throws Exception
     */
    public function createTestData()
    {
        $this->createManager($this->sManagerId);

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
            $this->deleteBaseModelObject( 'oxcountry', $sId);
        }

        $this->deleteOrder($this->aOrderIdList[0]);
    }

    /**
     * @return Manager
     * @throws Exception
     */
    public function getConfiguredManager()
    {
        $oManager = $this->getManagerMock($this->sManagerId);

        $oManager->assign(
            array(
                'D3_CRONJOBID'    => 'testId'
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
     * @throws ReflectionException
     * @dataProvider execMethodDataProvider
     */
    public function testExecOrdermanagerOk($methodname)
    {
        $_GET['ordermanagerid'] = $this->sManagerId;
        $_GET['oxid'] = $this->aOrderIdList[0];

        // prevent trigger action in test preparation
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, true);
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_FINALIZEORDER, true);

        $this->callMethod(
            $this->_oController,
            $methodname
        );

        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, false);
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_FINALIZEORDER, false);

        /** @var Item $oItem */
        $oItem = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $this->assertSame(
            round((float) $this->dExpectedValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @dataProvider execMethodDataProvider
     */
    public function testExecOrdermanagerInvalidRequirementConfigUnchecked($methodname)
    {
        $_GET['ordermanagerid'] = $this->sManagerId;
        $_GET['oxid'] = $this->aOrderIdList[0];

        $manager = $this->getConfiguredManager();
        $manager->setValue( 'sCustCountryId', [ 'notExistingCountryId' ] );
        $manager->setValue( 'sManuallyExecMeetCondition', false );
        $manager->save();

        // prevent trigger action in test preparation
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, true);
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_FINALIZEORDER, true);

        $this->callMethod(
            $this->_oController,
            $methodname
        );

        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_SAVEORDER, false);
        Registry::getSession()->setVariable(d3_oxorder_ordermanager::PREVENTION_FINALIZEORDER, false);

        $this->getConfiguredManager()->save();

        /** @var Item $oItem */
        $oItem = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $this->assertSame(
            round((float) $this->dExpectedValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @dataProvider execMethodDataProvider
     */
    public function testExecOrdermanagerInvalidRequirementConfigChecked($methodname)
    {
        $_GET['ordermanagerid'] = $this->sManagerId;
        $_GET['oxid'] = $this->aOrderIdList[0];

        $manager = $this->getConfiguredManager();
        $manager->setValue( 'sCustCountryId', [ 'notExistingCountryId' ] );
        $manager->setValue( 'sManuallyExecMeetCondition', true );
        $manager->save();

        $this->callMethod(
            $this->_oController,
            $methodname
        );

        $this->getConfiguredManager()->save();

        /** @var Item $oItem */
        $oItem = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $this->assertSame(
            round((float) $this->dCurrentValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @dataProvider execMethodDataProvider
     */
    public function testExecOrdermanagerInvalidActionConfig($methodname)
    {
        $_GET['ordermanagerid'] = $this->sManagerId;
        $_GET['oxid'] = $this->aOrderIdList[0];

        $manager = $this->getConfiguredManager();
        $manager->setValue('sActionChangeDelCostValue', 'invalid');
        $manager->save();

        $this->callMethod(
            $this->_oController,
            $methodname
        );

        $this->getConfiguredManager()->save();

        /** @var Item $oItem */
        $oItem = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Item::class);
        $oItem->load($this->aOrderIdList[0]);
        $this->assertSame(
            round((float) $this->dCurrentValue * 100),
            round((float) $oItem->getFieldData('oxdelcost') * 100)
        );
    }

    /**
     * @return string[][]
     */
    public function execMethodDataProvider()
    {
        return [
            'instantExecute'        => ['d3execordermanager'],
            'changedContentExecute' => ['d3ExecChangedOrderManager']
        ];
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function testExecChangedContentsOk()
    {
        $_GET['ordermanagerid'] = $this->sManagerId;
        $_GET['oxid'] = $this->aOrderIdList[0];

        $this->callMethod(
            $this->_oController,
            'execChangedContents'
        );

        $this->assertInternalType(
            'array',
            $this->callMethod(
                $this->_oController,
                'getViewDataElement',
                ['aMailContent']
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function testExecChangedContentsInvalidRequirementConfigUnchecked()
    {
        $_GET['ordermanagerid'] = $this->sManagerId;
        $_GET['oxid'] = $this->aOrderIdList[0];

        $manager = $this->getConfiguredManager();
        $manager->setValue( 'sCustCountryId', [ 'notExistingCountryId' ] );
        $manager->setValue( 'sManuallyExecMeetCondition', false );
        $manager->save();

        $this->callMethod(
            $this->_oController,
            'execChangedContents'
        );

        $this->getConfiguredManager()->save();

        $this->assertInternalType(
            'array',
            $this->callMethod(
                $this->_oController,
                'getViewDataElement',
                ['aMailContent']
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function testExecChangedContentsInvalidRequirementConfigChecked()
    {
        $_GET['ordermanagerid'] = $this->sManagerId;
        $_GET['oxid'] = $this->aOrderIdList[0];

        $manager = $this->getConfiguredManager();
        $manager->setValue( 'sCustCountryId', [ 'notExistingCountryId' ] );
        $manager->setValue( 'sManuallyExecMeetCondition', true );
        $manager->save();

        $this->callMethod(
            $this->_oController,
            'execChangedContents'
        );

        $this->getConfiguredManager()->save();

        $this->assertNull(
            $this->callMethod(
                $this->_oController,
                'getViewDataElement',
                ['aMailContent']
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function testExecChangedContentsInvalidActionConfig()
    {
        $_GET['ordermanagerid'] = $this->sManagerId;
        $_GET['oxid'] = $this->aOrderIdList[0];

        $manager = $this->getConfiguredManager();
        $manager->setValue('sActionChangeDelCostValue', 'invalid');
        $manager->save();

        $this->callMethod(
            $this->_oController,
            'execChangedContents'
        );

        $this->getConfiguredManager()->save();

        $this->assertNull(
            $this->callMethod(
                $this->_oController,
                'getViewDataElement',
                ['aMailContent']
            )
        );
    }
}
