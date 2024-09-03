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

namespace D3\Ordermanager\tests\integration\Requirements;

use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\integration\d3IntegrationTestCase;
use Doctrine\DBAL\Exception as DBALException;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use PHPUnit\Framework\MockObject\MockObject;

abstract class d3OrdermanagerRequirementIntegrationTestCase extends d3IntegrationTestCase
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
            ->onlyMethods(['d3getLog'])
            ->getMock();
        $oManager->method('d3getLog')->willReturn($this->getD3LogMock());
        $oManager->load($sManagerId);

        $oManager->d3getModCfg()->setValue('iMaxOrderCnt', 10000);

        return $oManager;
    }
}
