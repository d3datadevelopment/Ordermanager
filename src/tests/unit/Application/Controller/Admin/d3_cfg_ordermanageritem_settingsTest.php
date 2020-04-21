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

use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_settings;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Model\BaseModel;
use OxidEsales\Eshop\Core\Model\ListModel;
use PHPUnit_Framework_MockObject_MockObject;
use ReflectionException;

class d3_cfg_ordermanageritem_settingsTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_cfg_ordermanageritem_settings */
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

        $this->_oController = d3GetModCfgDIC()->get(d3_cfg_ordermanageritem_settings::class);
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
    public function getItemFoldersReturnArray()
    {
        $this->assertInternalType('array', $this->callMethod($this->_oController, 'getItemFolders'));
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getGroupsListReturnsRightInstance()
    {
        /** @var d3_cfg_ordermanageritem_settings|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_settings::class, array(
            '_getObjectList'
        ));
        $oControllerMock->method('_getObjectList')->will($this->returnCallback(function ($arg1) {
            return $arg1;
        }));

        $this->_oController = $oControllerMock;

        $this->assertInstanceOf(
            ListModel::class,
            $this->callMethod($this->_oController, 'getGroupsList')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getObjectListWillGetAllItemsFromDb()
    {
        /** @var BaseModel|PHPUnit_Framework_MockObject_MockObject $oBaseMock */
        $oBaseMock = $this->getMock(BaseModel::class, array(
            'isMultilang',
            'setLanguage',
            'getSelectFields',
            'getViewName',
        ));
        $oBaseMock->method('isMultilang')->willReturn(true);
        $oBaseMock->method('setLanguage')->willReturn(true);
        $oBaseMock->method('getSelectFields')->willReturn('oxid, oxtitle');
        $oBaseMock->method('getViewName')->willReturn('testViewTableName');

        /** @var ListModel|PHPUnit_Framework_MockObject_MockObject $oListMock */
        $oListMock = $this->getMock(ListModel::class, array(
            'selectString',
            'getBaseObject',
        ));
        $oListMock->expects($this->once())->method('selectString')->with(
            $this->logicalAnd(
                $this->stringContains('oxid, oxtitle'),
                $this->stringContains('testViewTableName'),
                $this->stringContains('testWhere'),
                $this->stringContains('testOrderBy')
            )
        )->willReturn(true);
        $oListMock->method('getBaseObject')->willReturn($oBaseMock);

        $this->assertSame(
            $oListMock,
            $this->callMethod(
                $this->_oController,
                '_getObjectList',
                array($oListMock, 'testwhere', 'testorderby')
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function editModeIsTrue()
    {
        $this->assertTrue(
            $this->callMethod($this->_oController, 'isEditMode')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function restrictionMessageCanGenerated()
    {
        $this->assertNotEmpty(
            $this->callMethod($this->_oController, 'getRestrictionMessage')
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