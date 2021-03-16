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

use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_execute;
use D3\Ordermanager\Application\Model\d3ordermanager_listgenerator;
use D3\Ordermanager\Application\Model\d3ordermanager_toorderassignment;
use D3\Ordermanager\tests\integration\d3OrdermanagerIntegrationTestCase;
use Exception;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Model\ListModel;
use PHPUnit_Framework_MockObject_MockObject;

abstract class d3OrdermanagerActionIntegrationTestCase extends d3OrdermanagerIntegrationTestCase
{
    /**
     * @param array $aOrderIdList
     * @return ListModel
     * @throws Exception
     */
    public function getResultList($aOrderIdList = array())
    {
        /** @var ListModel $oList */
        $oList = d3GetModCfgDIC()->get('d3ox.ordermanager.'.ListModel::class);
        $oList->init(Order::class);

        foreach ($aOrderIdList as $sId) {
            /** @var Order $oOrder */
            $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);
            $oOrder->load($sId);
            $oList->offsetSet($oOrder->getId(), $oOrder);
        }

        return $oList;
    }

    /**
     * @param d3ordermanager $oManager
     * @return d3ordermanager_listgenerator|PHPUnit_Framework_MockObject_MockObject
     */
    public function getListGenerator(d3ordermanager $oManager)
    {
        /** @var d3ordermanager_listgenerator|PHPUnit_Framework_MockObject_MockObject $oListGeneratorMock */
        $oListGeneratorMock = $this->getMock(d3ordermanager_listgenerator::class, array(
            'getConcernedOrders',
        ), array($oManager));
        $oListGeneratorMock->method('getConcernedOrders')->willReturn($this->getFilledResultList());

        return $oListGeneratorMock;
    }

    abstract public function getFilledResultList();

    /**
     * @param d3ordermanager $oManager
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function getManagerAssignmentMock(d3ordermanager $oManager)
    {
        $oAssignmentMock = $this->getMock(d3ordermanager_toorderassignment::class, array(
            'setAssignment'
        ), array($oManager));
        $oAssignmentMock->method('setAssignment')->willReturn(true);

        return $oAssignmentMock;
    }

    /**
     * @param d3ordermanager $oConfiguredManager
     * @return d3ordermanager_execute|PHPUnit_Framework_MockObject_MockObject
     */
    public function getExecuteMock(d3ordermanager $oConfiguredManager)
    {
        /** @var d3ordermanager_execute|PHPUnit_Framework_MockObject_MockObject $oExecute */
        $oExecute = $this->getMock(d3ordermanager_execute::class, array(
            'getManagerAssignmentInstance',
        ), array($oConfiguredManager));
        $oExecute->method('getManagerAssignmentInstance')->willReturn($this->getManagerAssignmentMock($oExecute->getManager()));

        return $oExecute;
    }
}
