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

use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_execute;
use D3\Ordermanager\Application\Model\d3ordermanager_listgenerator;
use D3\Ordermanager\Application\Model\d3ordermanager_toorderassignment;
use D3\Ordermanager\tests\integration\d3IntegrationTestCase;
use Exception;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Model\ListModel;
use PHPUnit\Framework\MockObject\MockObject;

abstract class d3OrdermanagerActionIntegrationTestCase extends d3IntegrationTestCase
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
     * @return d3ordermanager_listgenerator|MockObject
     */
    public function getListGenerator(d3ordermanager $oManager)
    {
        /** @var d3ordermanager_listgenerator|MockObject $oListGeneratorMock */
        $oListGeneratorMock = $this->getMockBuilder(d3ordermanager_listgenerator::class)
            ->setMethods(['getConcernedItems'])
            ->setConstructorArgs([$oManager])
            ->getMock();
        $oListGeneratorMock->method('getConcernedItems')->willReturn($this->getFilledResultList());

        return $oListGeneratorMock;
    }

    abstract public function getFilledResultList();

    /**
     * @param d3ordermanager $oManager
     * @return d3ordermanager_toorderassignment|MockObject
     */
    public function getManagerAssignmentMock(d3ordermanager $oManager)
    {
        /** @var d3ordermanager_toorderassignment|MockObject $oExecute */
        $oAssignmentMock = $this->getMockBuilder(d3ordermanager_toorderassignment::class)
            ->setMethods(['setAssignment'])
            ->setConstructorArgs([$oManager])
            ->getMock();
        $oAssignmentMock->method('setAssignment')->willReturn(true);

        return $oAssignmentMock;
    }

    /**
     * @param d3ordermanager $oConfiguredManager
     * @return d3ordermanager_execute|MockObject
     */
    public function getExecuteMock(d3ordermanager $oConfiguredManager)
    {
        /** @var d3ordermanager_execute|MockObject $oExecute */
        $oExecute = $this->getMockBuilder(d3ordermanager_execute::class)
            ->setMethods(['getManagerAssignmentInstance'])
            ->setConstructorArgs([$oConfiguredManager])
            ->getMock();
        $oExecute->method('getManagerAssignmentInstance')->willReturn($this->getManagerAssignmentMock($oExecute->getManager()));

        return $oExecute;
    }
}