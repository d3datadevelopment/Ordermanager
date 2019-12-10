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

namespace D3\Ordermanager\Tests\unit\Application\Controller\Admin;

use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_list;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use PHPUnit_Framework_MockObject_MockObject;
use ReflectionException;

class d3_cfg_ordermanageritem_listTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_cfg_ordermanageritem_list */
    protected $_oController;

    /**
     * setup basic requirements
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws Exception
     */
    public function setUp()
    {
        parent::setUp();

        $this->_oController = d3GetModCfgDIC()->get(d3_cfg_ordermanageritem_list::class);
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->_oController);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canBuildWhere()
    {
        /** @var d3_cfg_ordermanageritem_list|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_list::class, array(
            'getListFilter',
        ));
        $oControllerMock->method('getListFilter')->willReturn(
            array(
                'd3modprofile' => array(
                    'oxsort' => '5000',
                    'oxtitle'   => 'foo'
                )
            )
        );

        $this->_oController = $oControllerMock;

        $this->assertSame(
            array(
                'd3modprofile.oxsort' => '%5000%',
                'd3modprofile.oxtitle' => '%foo%'
            ),
            $this->callMethod($this->_oController, 'buildWhere')
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