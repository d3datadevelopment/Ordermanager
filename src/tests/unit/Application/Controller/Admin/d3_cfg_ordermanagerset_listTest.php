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

use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_list;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;

class d3_cfg_ordermanagerset_listTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_cfg_ordermanagerset_list */
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

        $this->_oController = d3GetModCfgDIC()->get(d3_cfg_ordermanagerset_list::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->_oController);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_list::__construct
     * @test
     * @throws ReflectionException
     */
    public function constructPass()
    {
        $this->_oController = d3GetModCfgDIC()->get(d3_cfg_ordermanagerset_list::class);

        $this->assertFalse(
            $this->getValue(
                $this->_oController,
                '_blD3ShowLangSwitch'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_list::render
     * @test
     * @throws ReflectionException
     */
    public function renderPass()
    {
        /** @var d3_cfg_ordermanagerset_list|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanagerset_list::class)
            ->onlyMethods(['d3FixNamespaceNavigation'])
            ->getMock();
        $oControllerMock->method('d3FixNamespaceNavigation')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->assertStringContainsStringIgnoringCase(
            '.tpl',
            $this->callMethod($this->_oController, 'render')
        );

        $this->assertNotEmpty($this->_oController->getViewDataElement('default_edit'));
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
