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

namespace D3\Ordermanager\tests\unit\Application\Controller\Admin;

use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Registry;
use ReflectionException;

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
    public function setUp() : void
    {
        parent::setUp();

        // required because error if test is executed with intergration tests
        Registry::getConfig()->getActiveShop();
        $this->_oController = d3GetModCfgDIC()->get(d3_cfg_ordermanageritem::class);
    }

    public function tearDown() : void
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
        $this->assertStringContainsStringIgnoringCase(
            '.tpl',
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
