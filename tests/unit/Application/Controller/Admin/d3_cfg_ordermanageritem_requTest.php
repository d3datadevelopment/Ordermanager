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

declare(strict_types=1);

namespace D3\Ordermanager\tests\unit\Application\Controller\Admin;

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
use OxidEsales\Eshop\Application\Model\DeliverySetList;
use OxidEsales\Eshop\Application\Model\PaymentList;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;

/**
 * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ
 */
class d3_cfg_ordermanageritem_requTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_cfg_ordermanageritem_requ */
    protected $_oController;

    /**
     * setup basic requirements
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->_oController = d3GetOxidDIC()->get(d3_cfg_ordermanageritem_requ::class);

        $oSampleManager = d3GetOxidDIC()->get(d3ordermanager::class);
        $oSampleManager->setId('testId');
        $oSampleManager->save();

        $oTestDelivery = d3GetOxidDIC()->get('d3ox.ordermanager.'.Delivery::class);
        $oTestDelivery->setId('testId');
        $oTestDelivery->save();

        $aViewData = array_merge(
            $this->_oController->getViewData(),
            ['edit' => $oSampleManager]
        );

        $this->_oController->setViewData($aViewData);
    }

    /**
     * @throws Exception
     */
    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->_oController);

        $oSampleManager = d3GetOxidDIC()->get(d3ordermanager::class);
        $oSampleManager->delete('testId');

        $oTestDelivery = d3GetOxidDIC()->get('d3ox.ordermanager.'.Delivery::class);
        $oTestDelivery->delete('testId');
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ::save
     * @test
     * @throws ReflectionException
     */
    public function canSaveNoMissingValues()
    {
        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue'])
            ->getMock();
        $getValueMap = [['blCheckTrackcode_status', true]];
        $oProfileMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_cfg_ordermanageritem_requ|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_requ::class)
            ->onlyMethods(['getProfile'])
            ->getMock();
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, 'save');
        $this->assertNull($this->_oController->getViewDataElement('missingRequValuesActions'));
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ::save
     * @test
     * @throws ReflectionException
     */
    public function canSaveMissingValues()
    {
        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue'])
            ->getMock();
        $getValueMap = [['blCheckDelivery_status', true]];
        $oProfileMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_cfg_ordermanageritem_requ|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_requ::class)
            ->onlyMethods(['getProfile', 'addDefaultValues'])
            ->getMock();
        $oControllerMock->method('getProfile')->willReturn($oProfileMock);
        $oControllerMock->method('addDefaultValues')->willReturn([]);

        $this->_oController = $oControllerMock;

        $this->callMethod($this->_oController, 'save');
        $aMissing = $this->_oController->getViewDataElement('missingRequValuesActions');
        $this->assertIsArray($aMissing);
        $this->assertCount(1, $aMissing);
        $this->assertContains('deliveryFilter', $aMissing);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ::getPaymentList
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
        $this->assertNotEmpty($oList);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ::getDeliverySetList
     * @test
     * @throws ReflectionException
     */
    public function getDeliverySetListPass()
    {
        /** @var DeliverySetList $oList */
        $oList = $this->callMethod(
            $this->_oController,
            'getDeliverySetList'
        );

        $this->assertInstanceOf(
            DeliverySetList::class,
            $oList
        );
        $this->assertNotEmpty($oList);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ::getCountryList
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
        $this->assertNotEmpty($oList);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ::getJobList
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
        $this->assertNotEmpty($oList, 'ordermanager job list shouldn\t empty');
        $this->assertFalse($oList->offsetExists('testId'), 'current object shouldn\'t contain in job list');
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ::getLanguageList
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

        $this->assertIsArray($aList);
        $this->assertNotEmpty($aList);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ::addDefaultValues
     * @test
     * @throws ReflectionException
     */
    public function addDefaultValuesReturnValues()
    {
        $aValues = [
            'key1'  => 'value1',
            'key2'  => 'value2',
        ];

        $this->assertSame(
            $aValues,
            $this->callMethod(
                $this->_oController,
                'addDefaultValues',
                [$aValues]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ::getRequirementGroupList
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function getRequirementGroupListReturnsRightInstance()
    {
        $oManager = d3GetOxidDIC()->get(d3ordermanager::class);

        $this->assertInstanceOf(
            d3ordermanager_requirementgrouplist::class,
            $this->callMethod(
                $this->_oController,
                'getRequirementGroupList',
                [$oManager]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ::getRequirementListObject
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetRequirementListObject()
    {
        $this->assertInstanceOf(
            d3ordermanager_requirementlist::class,
            $this->callMethod(
                $this->_oController,
                'getRequirementListObject',
                [d3GetOxidDIC()->get(d3ordermanager::class)]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ::getRequirementList
     * @test
     * @throws ReflectionException
     */
    public function canGetRequirementList()
    {
        $aRequList = $this->callMethod($this->_oController, 'getRequirementList');
        $this->assertIsArray(
            $aRequList
        );
        $this->assertNotEmpty($aRequList);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ::getGroupedRequirementList
     * @test
     * @throws ReflectionException
     */
    public function getGroupedRequirementListPass()
    {
        $mExpected = ['item1', 'item2'];

        /** @var d3ordermanager_conf|MockObject $oManagerConfMock */
        $oManagerConfMock = $this->getMockBuilder(d3ordermanager_conf::class)
            ->onlyMethods(['getGroupedRequirementIdList'])
            ->getMock();
        $oManagerConfMock->method('getGroupedRequirementIdList')->willReturn([]);

        /** @var d3ordermanager|MockObject $oProfileMock */
        $oProfileMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getConfiguration'])
            ->getMock();
        $oProfileMock->method('getConfiguration')->willReturn($oManagerConfMock);

        /** @var d3ordermanager_requirementgrouplist|MockObject $oRequGroupListMock */
        $oRequGroupListMock = $this->getMockBuilder(d3ordermanager_requirementgrouplist::class)
            ->onlyMethods([
                'setGroups',
                'getGroupList',
            ])
            ->setConstructorArgs([$oProfileMock])
            ->getMock();
        $oRequGroupListMock->method('setGroups');
        $oRequGroupListMock->method('getGroupList')->willReturn($mExpected);

        /** @var d3_cfg_ordermanageritem_requ|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_requ::class)
            ->onlyMethods([
                'getProfile',
                'getRequirementGroupList',
            ])
            ->getMock();
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
