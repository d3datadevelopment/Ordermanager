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

use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Registry;
use ReflectionException;

/**
 * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem
 */
class d3_cfg_ordermanageritemTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_cfg_ordermanageritem */
    protected $_oController;

    /**
     * setup basic requirements
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        // required because error if test is executed with intergration tests
        Registry::getConfig()->getActiveShop();
        $this->_oController = d3GetOxidDIC()->get(d3_cfg_ordermanageritem::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->_oController);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem::render
     * @test
     * @throws ReflectionException
     */
    public function renderPass()
    {
        $this->assertSame(
            '@d3modcfg_lib/admin/base_',
            $this->callMethod($this->_oController, 'render')
        );

        $this->assertNotEmpty($this->_oController->getViewDataElement('sListClass'));
        $this->assertNotEmpty($this->_oController->getViewDataElement('sMainClass'));
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
