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
namespace D3\Ordermanager\tests\integration\Requirements;

use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\integration\d3OrdermanagerIntegrationTestCase;
use Doctrine\DBAL\DBALException;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use PHPUnit\Framework\MockObject\MockObject;

abstract class d3OrdermanagerRequirementIntegrationTestCase extends d3OrdermanagerIntegrationTestCase
{
    /**
     * @param $sManagerId
     * @return d3ordermanager|MockObject
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getManagerMock($sManagerId)
    {
        /** @var d3ordermanager|MockObject $oManager */
        $oManager = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['d3getLog'])
            ->getMock();
        $oManager->method('d3getLog')->willReturn($this->getD3LogMock());
        $oManager->load($sManagerId);

        $oManager->d3getModCfg()->setValue('iMaxOrderCnt', 2000);

        return $oManager;
    }
}