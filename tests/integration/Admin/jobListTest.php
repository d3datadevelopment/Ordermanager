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

namespace D3\Ordermanager\tests\integration\Admin;

use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_list;
use D3\Ordermanager\tests\integration\d3IntegrationTestCase;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;

/**
 * @coversNothing
 */
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
     * @test
     */
    public function getUnfilteredJobList()
    {
        $controller = oxNew(d3_cfg_ordermanageritem_list::class);
        $_GET['viewListSize'] = $_POST['viewListSize'] = 300;
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
     * @test
     */
    public function getFilteredJobList()
    {
        $_POST['where'] = [
            'd3modprofile'  => [
                'oxtitle'   => 'orderManagerTestTitle',
            ],
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
