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

use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_list;
use D3\Ordermanager\tests\integration\d3IntegrationTestCase;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;

class jobListTest extends d3IntegrationTestCase
{
    public $sManagerId = 'managerTestId';

    /**
     * @throws Exception
     */
    public function createTestData()
    {
        $this->createManager($this->sManagerId);
    }

    /**
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws Exception
     */
    public function cleanTestData()
    {
        $this->deleteManager($this->sManagerId);
    }

    /**
     * @coversNothing
     * @test
     */
    public function getUnfilteredJobList()
    {
        $controller = oxNew(d3_cfg_ordermanageritem_list::class);
        $list = $controller->getItemList();
// ToDo: check if it use page navigation and doesn't contain all items
        $this->assertGreaterThan(
            0,
            $list->count()
        );

        $this->assertArrayHasKey(
            $this->sManagerId,
            $list
        );
    }

    /**
     * @coversNothing
     * @test
     */
    public function getFilteredJobList()
    {
        $_POST['where'] = [
            'd3modprofile'  => [
                'oxtitle'   => 'orderManagerTestTitle'
            ]
        ];

        $controller = oxNew(d3_cfg_ordermanageritem_list::class);
        $list = $controller->getItemList();

        $this->assertGreaterThan(
            0,
            $list->count()
        );

        $this->assertArrayHasKey(
            $this->sManagerId,
            $list
        );
    }
}