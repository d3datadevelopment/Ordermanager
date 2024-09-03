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

use D3\ModCfg\Application\Model\Exception\wrongModIdException;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_settings;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Model\BaseModel;
use OxidEsales\Eshop\Core\Model\ListModel;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_settings
 */
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
    public function setUp(): void
    {
        parent::setUp();

        $this->_oController = d3GetOxidDIC()->get(d3_cfg_ordermanageritem_settings::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->_oController);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_settings::__construct
     * @test
     */
    public function constructorPass()
    {
        $this->assertSame(
            'd3_ordermanager',
            d3GetOxidDIC()->getParameter('d3.ordermanager.modcfgid')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_settings::__construct
     * @test
     */
    public function constructorException()
    {
        /** @var d3_cfg_ordermanageritem_settings|MockObject $controller */
        $controller = $this->getMockBuilder(d3_cfg_ordermanageritem_settings::class)
            ->disableOriginalConstructor()
            ->getMock();

        d3GetOxidDIC()->setParameter('d3.ordermanager.modcfgid', 'differentModCfgid');

        $this->expectException(wrongModIdException::class);

        $this->callMethod(
            $controller,
            '__construct'
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_settings::getItemFolders
     * @test
     * @throws ReflectionException
     */
    public function getItemFoldersReturnArray()
    {
        $this->assertIsArray(
            $this->callMethod($this->_oController, 'getItemFolders')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_settings::getGroupsList
     * @test
     * @throws ReflectionException
     */
    public function getGroupsListReturnsRightInstance()
    {
        /** @var d3_cfg_ordermanageritem_settings|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_settings::class)
            ->onlyMethods(['_getObjectList'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_settings::_getObjectList
     * @test
     * @throws ReflectionException
     */
    public function getObjectListWillGetAllItemsFromDb()
    {
        /** @var BaseModel|MockObject $oBaseMock */
        $oBaseMock = $this->getMockBuilder(BaseModel::class)
            ->addMethods(['setLanguage'])
            ->onlyMethods([
                'isMultilang',
                'getSelectFields',
                'getViewName', ])
            ->getMock();
        $oBaseMock->method('isMultilang')->willReturn(true);
        $oBaseMock->method('setLanguage')->willReturn(true);
        $oBaseMock->method('getSelectFields')->willReturn('oxid, oxtitle');
        $oBaseMock->method('getViewName')->willReturn('testViewTableName');

        /** @var ListModel|MockObject $oListMock */
        $oListMock = $this->getMockBuilder(ListModel::class)
            ->onlyMethods([
                'selectString',
                'getBaseObject',
            ])
            ->getMock();
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
                [$oListMock, 'testwhere', 'testorderby']
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_settings::isEditMode
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_settings::getRestrictionMessage
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

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_settings::getDIContainer
     * @test
     * @throws ReflectionException
     */
    public function getDIContainerHasRightInstance()
    {
        $this->assertInstanceOf(
            ContainerInterface::class,
            $this->callMethod(
                $this->_oController,
                'getDIContainer'
            )
        );
    }
}
