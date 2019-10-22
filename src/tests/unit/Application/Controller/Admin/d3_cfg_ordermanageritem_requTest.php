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

namespace D3\Ordermanager\Tests\unit\Application\Controller\Admin;

use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_conf;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirementgrouplist;
use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirementlist;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Exception;
use OxidEsales\Eshop\Application\Model\CountryList;
use OxidEsales\Eshop\Application\Model\Delivery;
use OxidEsales\Eshop\Application\Model\DeliveryList;
use OxidEsales\Eshop\Application\Model\PaymentList;
use PHPUnit_Framework_MockObject_MockObject;
use ReflectionException;

class d3_cfg_ordermanageritem_requTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_cfg_ordermanageritem_requ */
    protected $_oController;

    /**
     * setup basic requirements
     * @throws Exception
     */
    public function setUp()
    {
        parent::setUp();

        $this->_oController = d3GetModCfgDIC()->get(d3_cfg_ordermanageritem_requ::class);

        $oSampleManager = d3GetModCfgDIC()->get(d3ordermanager::class);
        $oSampleManager->setId('testId');
        $oSampleManager->save();

        $oTestDelivery = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Delivery::class);
        $oTestDelivery->setId('testId');
        $oTestDelivery->save();

        $aViewData = array_merge(
            $this->_oController->getViewData(),
            array('edit' => $oSampleManager)
        );

        $this->_oController->setViewData($aViewData);
    }

    /**
     * @throws Exception
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->_oController);

        $oSampleManager = d3GetModCfgDIC()->get(d3ordermanager::class);
        $oSampleManager->delete('testId');

        $oTestDelivery = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Delivery::class);
        $oTestDelivery->delete('testId');
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canSaveNoMissingValues()
    {
        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'getValue'
        ));
        $getValueMap = [['blCheckTrackcode_status', true]];
        $oProfileMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_cfg_ordermanageritem_requ|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_requ::class, array(
            'getProfile'
        ));
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, 'save');
        $this->assertNull($this->_oController->getViewDataElement('missingRequValuesActions'));
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canSaveMissingValues()
    {
        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'getValue'
        ));
        $getValueMap = [['blCheckDelivery_status', true]];
        $oProfileMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_cfg_ordermanageritem_requ|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_requ::class, array(
            'getProfile'
        ));
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, 'save');
        $aMissing = $this->_oController->getViewDataElement('missingRequValuesActions');
        $this->assertInternalType('array', $aMissing);
        $this->assertCount(1, $aMissing);
        $this->assertContains('deliveryFilter', $aMissing);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getPaymentListPass()
    {
        /** @var PaymentList $oList */
        $oList = $this->callMethod(
            $this->_oController,
            'getPaymentList'
        );

        $this->assertInstanceOf(
            PaymentList::class,
            $oList
        );
        $this->assertTrue(count($oList) > 0);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getDeliveryListPass()
    {
        /** @var DeliveryList $oList */
        $oList = $this->callMethod(
            $this->_oController,
            'getDeliveryList'
        );

        $this->assertInstanceOf(
            DeliveryList::class,
            $oList
        );
        $this->assertTrue(count($oList) > 0);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getCountryListPass()
    {
        /** @var CountryList $oList */
        $oList = $this->callMethod(
            $this->_oController,
            'getCountryList'
        );

        $this->assertInstanceOf(
            CountryList::class,
            $oList
        );
        $this->assertTrue(count($oList) > 0);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getOrdermanagerJobListPass()
    {
        /** @var d3ordermanagerlist $oList */
        $oList = $this->callMethod(
            $this->_oController,
            'getJobList'
        );

        $this->assertInstanceOf(
            d3ordermanagerlist::class,
            $oList
        );
        $this->assertTrue(count($oList) > 0, 'ordermanager job list shouldn\t empty');
        $this->assertFalse($oList->offsetExists('testId'), 'current object shouldn\'t contain in job list');
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getLanguageListPass()
    {
        /** @var array $aList */
        $aList = $this->callMethod(
            $this->_oController,
            'getLanguageList'
        );

        $this->assertInternalType(
            "array",
            $aList
        );
        $this->assertTrue(count($aList) > 0);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getTransStatusListPass()
    {
        /** @var array $aTransStatusList */
        $aTransStatusList = $this->callMethod(
            $this->_oController,
            'getTransStatusList'
        );

        $this->assertInternalType(
            "array",
            $aTransStatusList
        );
        $this->assertTrue(count($aTransStatusList) > 0);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function addDefaultValuesReturnValues()
    {
        $aValues = array(
            'key1'  => 'value1',
            'key2'  => 'value2',
        );

        $this->assertSame(
            $aValues,
            $this->callMethod(
                $this->_oController,
                'addDefaultValues',
                array($aValues)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function getRequirementGroupListReturnsRightInstance()
    {
        $oManager = d3GetModCfgDIC()->get(d3ordermanager::class);

        $this->assertInstanceOf(
            d3ordermanager_requirementgrouplist::class,
            $this->callMethod(
                $this->_oController,
                'getRequirementGroupList',
                array($oManager)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetRequirementListObject()
    {
        $this->assertInstanceOf(
            d3ordermanager_requirementlist::class,
            $this->callMethod($this->_oController, 'getRequirementListObject', array(d3GetModCfgDIC()->get(d3ordermanager::class)))
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetRequirementList()
    {
        $aRequList = $this->callMethod($this->_oController, 'getRequirementList');
        $this->assertInternalType(
            'array',
            $aRequList
        );
        $this->assertTrue(count($aRequList) > 0);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getGroupedRequirementListPass()
    {
        $mExpected = array('item1', 'item2');

        /** @var d3ordermanager_conf|PHPUnit_Framework_MockObject_MockObject $oManagerConfMock */
        $oManagerConfMock = $this->getMock(d3ordermanager_conf::class, array(
            'getGroupedRequirementIdList'
        ));
        $oManagerConfMock->method('getGroupedRequirementIdList')->willReturn(true);

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oProfileMock */
        $oProfileMock = $this->getMock(d3ordermanager::class, array(
            'getConfiguration'
        ));
        $oProfileMock->method('getConfiguration')->willReturn($oManagerConfMock);

        /** @var d3ordermanager_requirementgrouplist|PHPUnit_Framework_MockObject_MockObject $oRequGroupListMock */
        $oRequGroupListMock = $this->getMock(d3ordermanager_requirementgrouplist::class, array(
            'setGroups',
            'getGroupList'
        ), array($oProfileMock));
        $oRequGroupListMock->method('setGroups')->willReturn(true);
        $oRequGroupListMock->method('getGroupList')->willReturn($mExpected);

        /** @var d3_cfg_ordermanageritem_requ|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_requ::class, array(
            'getProfile',
            'getRequirementGroupList',
        ));
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);
        $oControllerMock->method('getRequirementGroupList')->willReturn($oRequGroupListMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $mExpected,
            $this->callMethod(
                $this->_oController,
                'getGroupedRequirementList'
            )
        );
    }

    /**
     * @param $sLicenseKey
     * @param d3ordermanager $oManager
     * @return null
     */
    protected function _setModuleLicenseKey($sLicenseKey, $oManager = null)
    {
        return null;
    }
}