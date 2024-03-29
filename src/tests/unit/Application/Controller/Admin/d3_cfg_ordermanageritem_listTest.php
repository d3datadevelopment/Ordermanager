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

use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_list;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Model\ListModel;
use PHPUnit\Framework\MockObject\MockObject;
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
    public function setUp(): void
    {
        parent::setUp();

        $this->_oController = d3GetModCfgDIC()->get(d3_cfg_ordermanageritem_list::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->_oController);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_list::buildWhere
     * @test
     * @throws ReflectionException
     */
    public function canBuildWhere()
    {
        /** @var d3_cfg_ordermanageritem_list|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_list::class)
            ->onlyMethods([
                'getListFilter',
                'getItemList',
            ])
            ->getMock();
        $oControllerMock->method('getListFilter')->willReturn(
            [
                'd3modprofile' => [
                    'oxsort' => '5000',
                    'oxtitle'   => 'foo',
                ],
            ]
        );
        $oControllerMock->method('getItemList')->willReturn(oxNew(ListModel::class));

        $this->_oController = $oControllerMock;

        $return = $this->callMethod($this->_oController, 'buildWhere');

        // key check
        $this->assertRegExp(
            '@oxv_d3modprofile_(\d+).oxsort--oxv_d3modprofile_(\d+).oxtitle@is',
            implode('--', array_keys($return))
        );

        // value check
        $this->assertSame(
            [
                0 => '%5000%',
                1 => '%foo%',
            ],
            array_values($return)
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
