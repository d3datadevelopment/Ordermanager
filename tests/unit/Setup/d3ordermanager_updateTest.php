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

namespace D3\Ordermanager\tests\unit\Setup;

use D3\DIContainerHandler\d3DicException;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\d3bitmask;
use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Model\Installwizzard\d3installdbrecord;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Setup\d3ordermanager_update;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Query\Expression\ExpressionBuilder;
use Doctrine\DBAL\Query\QueryBuilder;
use Exception;
use OxidEsales\Eshop\Application\Model\Shop;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\EshopCommunity\Internal\Framework\Database\ConnectionProvider;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;

/**
 * @covers \D3\Ordermanager\Setup\d3ordermanager_update
 */
class d3ordermanager_updateTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3ordermanager_update */
    protected $_oModel;

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

        $this->_oModel = d3GetOxidDIC()->get(d3ordermanager_update::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->_oModel);
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::doesOrder2OrderManagerTableNotExist
     * @test
     * @throws ReflectionException
     */
    public function canCheckOrder2OrderManagerTableNotExist()
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods(['_checkTableNotExist'])
            ->getMock();
        $oModelMock->expects($this->once())->method('_checkTableNotExist')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'doesOrder2OrderManagerTableNotExist'
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::addOrder2OrderManagerTable
     * @test
     * @throws ReflectionException
     */
    public function canAddOrder2OrderManagerTable()
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'doesOrder2OrderManagerTableNotExist',
                '_addTable2',
            ])
            ->getMock();
        $oModelMock->method('doesOrder2OrderManagerTableNotExist')->willReturn(true);
        $oModelMock->expects($this->once())->method('_addTable2')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'addOrder2OrderManagerTable'
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::addOrder2OrderManagerTable
     * @test
     * @throws ReflectionException
     */
    public function canNotAddExistingOrder2OrderManagerTable()
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'doesOrder2OrderManagerTableNotExist',
                '_addTable2',
            ])
            ->getMock();
        $oModelMock->method('doesOrder2OrderManagerTableNotExist')->willReturn(false);
        $oModelMock->expects($this->never())->method('_addTable2')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'addOrder2OrderManagerTable'
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::d3GetInstallDbRecord
     * @test
     * @throws ReflectionException
     */
    public function d3GetInstallDbRecordReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3installdbrecord::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetInstallDbRecord'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::d3GetConfig
     * @test
     * @throws ReflectionException
     */
    public function d3GetConfigReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Config::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetConfig'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::doesModCfgItemNotExist
     * @test
     * @throws ReflectionException
     */
    public function canCheckDoesModCfgItemNotExistPositive()
    {
        /** @var d3installdbrecord|MockObject $oInstallDbRecordMock */
        $oInstallDbRecordMock = $this->getMockBuilder(d3installdbrecord::class)
            ->onlyMethods(['checkTableRecordNotExist'])
            ->setConstructorArgs([$this->_oModel])
            ->getMock();
        $oInstallDbRecordMock->expects($this->once())->method('checkTableRecordNotExist')->willReturn(true);

        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->onlyMethods(['getShopIds'])
            ->getMock();
        $oConfigMock->method('getShopIds')->willReturn([1, 2]);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'd3GetConfig',
                'd3GetInstallDbRecord',
            ])
            ->getMock();
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetInstallDbRecord')->willReturn($oInstallDbRecordMock);

        $this->_oModel = $oModelMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oModel,
                'doesModCfgItemNotExist'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::doesModCfgItemNotExist
     * @test
     * @throws ReflectionException
     */
    public function canCheckDoesModCfgItemNotExistNegative()
    {
        /** @var d3installdbrecord|MockObject $oInstallDbRecordMock */
        $oInstallDbRecordMock = $this->getMockBuilder(d3installdbrecord::class)
            ->onlyMethods(['checkTableRecordNotExist'])
            ->setConstructorArgs([$this->_oModel])
            ->getMock();
        $oInstallDbRecordMock->expects($this->exactly(2))->method('checkTableRecordNotExist')->willReturn(false);

        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->onlyMethods(['getShopIds'])
            ->getMock();
        $oConfigMock->method('getShopIds')->willReturn([1, 2]);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'd3GetConfig',
                'd3GetInstallDbRecord',
            ])
            ->getMock();
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetInstallDbRecord')->willReturn($oInstallDbRecordMock);

        $this->_oModel = $oModelMock;

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'doesModCfgItemNotExist'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::addModCfgItem
     * @test
     * @throws ReflectionException
     */
    public function canAddModCfgItemNoStepByStep()
    {
        /** @var d3installdbrecord|MockObject $oInstallDbRecordMock */
        $oInstallDbRecordMock = $this->getMockBuilder(d3installdbrecord::class)
            ->onlyMethods(['checkTableRecordNotExist'])
            ->setConstructorArgs([$this->_oModel])
            ->getMock();
        $oInstallDbRecordMock->expects($this->exactly(2))->method('checkTableRecordNotExist')->willReturn(true);

        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->onlyMethods(['getShopIds'])
            ->getMock();
        $oConfigMock->method('getShopIds')->willReturn([1, 2]);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'doesModCfgItemNotExist',
                'd3GetConfig',
                'd3GetInstallDbRecord',
                'setInitialExecMethod',
            '_updateTableItem2',
            'getStepByStepMode', ])
            ->getMock();
        $oModelMock->method('doesModCfgItemNotExist')->willReturn(true);
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetInstallDbRecord')->willReturn($oInstallDbRecordMock);
        $oModelMock->method('setInitialExecMethod')->willReturn(true);
        $oModelMock->expects($this->exactly(2))->method('_updateTableItem2')->willReturn(true);
        $oModelMock->method('getStepByStepMode')->willReturn(false);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'addModCfgItem'
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::addModCfgItem
     * @test
     * @throws ReflectionException
     */
    public function canAddModCfgItemStepByStep()
    {
        /** @var d3installdbrecord|MockObject $oInstallDbRecordMock */
        $oInstallDbRecordMock = $this->getMockBuilder(d3installdbrecord::class)
            ->onlyMethods(['checkTableRecordNotExist'])
            ->setConstructorArgs([$this->_oModel])
            ->getMock();
        $oInstallDbRecordMock->expects($this->exactly(1))->method('checkTableRecordNotExist')->willReturn(true);

        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->onlyMethods(['getShopIds'])
            ->getMock();
        $oConfigMock->method('getShopIds')->willReturn([1, 2]);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'doesModCfgItemNotExist',
                'd3GetConfig',
                'd3GetInstallDbRecord',
                'setInitialExecMethod',
            '_updateTableItem2',
            'getStepByStepMode', ])
            ->getMock();
        $oModelMock->method('doesModCfgItemNotExist')->willReturn(true);
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetInstallDbRecord')->willReturn($oInstallDbRecordMock);
        $oModelMock->method('setInitialExecMethod')->willReturn(true);
        $oModelMock->expects($this->exactly(1))->method('_updateTableItem2')->willReturn(true);
        $oModelMock->method('getStepByStepMode')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'addModCfgItem'
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::addModCfgItem
     * @test
     * @throws ReflectionException
     */
    public function canNotAddExistingModCfgItem()
    {
        /** @var d3installdbrecord|MockObject $oInstallDbRecordMock */
        $oInstallDbRecordMock = $this->getMockBuilder(d3installdbrecord::class)
            ->onlyMethods(['checkTableRecordNotExist'])
            ->setConstructorArgs([$this->_oModel])
            ->getMock();
        $oInstallDbRecordMock->expects($this->never())->method('checkTableRecordNotExist')->willReturn(true);

        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->onlyMethods(['getShopIds'])
            ->getMock();
        $oConfigMock->method('getShopIds')->willReturn([1, 2]);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'doesModCfgItemNotExist',
                'd3GetConfig',
                'd3GetInstallDbRecord',
                'setInitialExecMethod',
            '_updateTableItem2',
            'getStepByStepMode', ])
            ->getMock();
        $oModelMock->method('doesModCfgItemNotExist')->willReturn(false);
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetInstallDbRecord')->willReturn($oInstallDbRecordMock);
        $oModelMock->method('setInitialExecMethod')->willReturn(true);
        $oModelMock->expects($this->never())->method('_updateTableItem2')->willReturn(true);
        $oModelMock->method('getStepByStepMode')->willReturn(false);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'addModCfgItem'
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::checkCronPasswordSet
     * @test
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws ReflectionException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws StandardException
     * @dataProvider passwordTestDataProvider
     */
    public function canCheckCronPasswordSet($testPW, $expected)
    {
        /** @var d3_cfg_mod $set */
        $set = d3GetOxidDIC()->get('d3.ordermanager.modcfg');
        $currPassword = $set->getValue('sCronPassword');
        $set->setValue('sCronPassword', $testPW);
        $set->saveNoLicenseRefresh();

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oModel,
                'checkCronPasswordSet'
            )
        );

        $set->setValue('sCronPassword', $currPassword);
        $set->saveNoLicenseRefresh();
    }

    /**
     * @return array[]
     */
    public function passwordTestDataProvider()
    {
        return [
            [false, true],
            [null, true],
            ['', true],
            ['abc', false],
            ['123', false],
            ['%_(', false],
        ];
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::createCronPassword
     * @test
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws ReflectionException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function canCreateCronPasswordExecute()
    {
        $expectedPW = 'testRandom';

        /** @var d3_cfg_mod $set */
        $set = d3GetOxidDIC()->get('d3.ordermanager.modcfg');
        $currPassword = $set->getValue('sCronPassword');
        $set->setValue('sCronPassword', 'otherContent');
        $set->saveNoLicenseRefresh();

        $oStrMock = $this->getMockBuilder(d3str::class)
            ->onlyMethods(['random_str'])
            ->getMock();
        $oStrMock->expects($this->atLeastOnce())->method('random_str')->willReturn($expectedPW);
        d3GetOxidDIC()->set(d3str::class, $oStrMock);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'hasExecute',
                'setActionLog',
            ])
            ->getMock();
        $oModelMock->method('hasExecute')->willReturn(true);
        $oModelMock->expects($this->exactly(1))->method('setActionLog')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'createCronPassword'
        );

        /** @var d3_cfg_mod $set */
        $fixtureSet = d3GetOxidDIC()->get('d3.ordermanager.modcfg');
        $fixturePw = $fixtureSet->getValue('sCronPassword');

        $this->assertSame($expectedPW, $fixturePw);

        $set->setValue('sCronPassword', $currPassword);
        $set->saveNoLicenseRefresh();
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::createCronPassword
     * @test
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws ReflectionException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function canCreateCronPasswordNoExecute()
    {
        $expectedPW = 'testRandom';

        /** @var d3_cfg_mod $set */
        $set = d3GetOxidDIC()->get('d3.ordermanager.modcfg');
        $currPassword = $set->getValue('sCronPassword');
        $set->setValue('sCronPassword', 'otherContent');
        $set->saveNoLicenseRefresh();

        $oStrMock = $this->getMockBuilder(d3str::class)
            ->onlyMethods(['random_str'])
            ->getMock();
        $oStrMock->expects($this->never())->method('random_str')->willReturn($expectedPW);
        d3GetOxidDIC()->set(d3str::class, $oStrMock);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'hasExecute',
                'setActionLog',
            ])
            ->getMock();
        $oModelMock->method('hasExecute')->willReturn(false);
        $oModelMock->expects($this->exactly(1))->method('setActionLog')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'createCronPassword'
        );

        /** @var d3_cfg_mod $set */
        $fixtureSet = d3GetOxidDIC()->get('d3.ordermanager.modcfg');
        $fixturePw = $fixtureSet->getValue('sCronPassword');

        $this->assertSame('otherContent', $fixturePw);

        $set->setValue('sCronPassword', $currPassword);
        $set->saveNoLicenseRefresh();
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::needExampleJobList
     * @test
     * @throws ReflectionException
     * @throws d3DicException
     */
    public function needExampleJobListPass()
    {
        /** @var Result|MockObject $resultMock */
        $resultMock = $this->getMockBuilder(Result::class)
            ->onlyMethods(get_class_methods(Result::class))
            ->getMock();
        $resultMock->method('fetchOne')->willReturn(0);

        /** @var QueryBuilder|MockObject $oQBMock */
        $oQBMock = $this->getMockBuilder(QueryBuilder::class)
            ->onlyMethods(['execute'])
            ->setConstructorArgs([(new ConnectionProvider())->get()])
            ->getMock();
        $oQBMock->method('execute')->willReturn($resultMock);

        d3GetOxidDIC()->set('d3ox.modcfg.OxDbQueryBuilder', $oQBMock);

        $this->assertTrue(
            $this->callMethod(
                $this->_oModel,
                'needExampleJobList'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::needExampleJobList
     * @test
     * @throws ReflectionException
     * @throws d3DicException
     */
    public function needExampleJobListDontPass()
    {
        /** @var Result|MockObject $resultMock */
        $resultMock = $this->getMockBuilder(Result::class)
            ->onlyMethods(get_class_methods(Result::class))
            ->getMock();
        $resultMock->method('fetchOne')->willReturn(1);

        /** @var QueryBuilder|MockObject $oQBMock */
        $oQBMock = $this->getMockBuilder(QueryBuilder::class)
            ->onlyMethods(['execute'])
            ->setConstructorArgs([(new ConnectionProvider())->get()])
            ->getMock();
        $oQBMock->method('execute')->willReturn($resultMock);

        d3GetOxidDIC()->set('d3ox.modcfg.OxDbQueryBuilder', $oQBMock);

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'needExampleJobList'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::addExampleJobList
     * @test
     * @throws ReflectionException
     */
    public function canAddExampleJobList()
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'getExampleJobInsertList',
                '_addExampleJobItem',
                'setUpdateBreak',
            ])
            ->getMock();
        $oModelMock->method('getExampleJobInsertList')->willReturn(
            [
                [
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile',
                ],
                [
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile',
                ],
                [
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile',
                ],
            ]
        );
        $oModelMock->expects($this->exactly(2))->method('_addExampleJobItem')->will($this->onConsecutiveCalls(true, false, true));
        $oModelMock->method('setUpdateBreak')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'addExampleJobList'
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::isExampleContentMissingInDatabase
     * @test
     * @throws DBALException
     * @throws ReflectionException
     */
    public function checkIsExampleContentMissingInDatabasePositive()
    {
        /** @var Result|MockObject $resultMock */
        $resultMock = $this->getMockBuilder(Result::class)
           ->onlyMethods(get_class_methods(Result::class))
           ->getMock();
        $resultMock->method('fetchOne')->willReturn(1);

        /** @var ExpressionBuilder|MockObject $expressionBuilderMock */
        $expressionBuilderMock = $this->getMockBuilder(ExpressionBuilder::class)
            ->onlyMethods(['in'])
            ->disableOriginalConstructor()
            ->getMock();
        $expressionBuilderMock->expects($this->atLeastOnce())->method('in');

        /** @var QueryBuilder|MockObject $queryBuilderMock */
        $queryBuilderMock = $this->getMockBuilder(QueryBuilder::class)
            ->onlyMethods(['execute', 'expr'])
            ->disableOriginalConstructor()
            ->getMock();
        $queryBuilderMock->expects($this->atLeastOnce())->method('execute')->willReturn($resultMock);
        $queryBuilderMock->method('expr')->willReturn($expressionBuilderMock);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'getExampleContentInsertList',
                'getExampleJobItem1InsertFields',
            ])
            ->getMock();
        $oModelMock->method('getExampleContentInsertList')->willReturn(
            [
                [
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile',
                ],
            ]
        );
        $oModelMock->method('getExampleJobItem1InsertFields')->willReturn(
            [
                [
                    'fieldname'     => 'OXID',
                    'content'       => "foobar",
                    'force_update'  => false,
                    'use_quote'     => false,
                    'use_multilang' => false,
                ],
                [
                    'fieldname'     => 'OXLOADID',
                    'content'       => "d3unknownContentId",
                    'force_update'  => false,
                    'use_quote'     => true,
                    'use_multilang' => false,
                ],
            ]
        );

        $this->_oModel = $oModelMock;

        d3GetOxidDIC()->set('d3ox.modcfg.OxDbQueryBuilder', $queryBuilderMock);

        $this->assertTrue(
            $this->callMethod(
                $this->_oModel,
                'isExampleContentMissingInDatabase'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::isExampleContentMissingInDatabase
     * @test
     * @throws ReflectionException
     * @throws d3DicException
     */
    public function checkIsExampleContentMissingInDatabaseNegative()
    {
        /** @var Result|MockObject $resultMock */
        $resultMock = $this->getMockBuilder(Result::class)
            ->onlyMethods(get_class_methods(Result::class))
            ->getMock();
        $resultMock->method('fetchOne')->willReturn(0);

        /** @var ExpressionBuilder|MockObject $expressionBuilderMock */
        $expressionBuilderMock = $this->getMockBuilder(ExpressionBuilder::class)
            ->onlyMethods(['in'])
            ->disableOriginalConstructor()
            ->getMock();
        $expressionBuilderMock->expects($this->atLeastOnce())->method('in');

        /** @var QueryBuilder|MockObject $queryBuilderMock */
        $queryBuilderMock = $this->getMockBuilder(QueryBuilder::class)
            ->onlyMethods(['execute', 'expr'])
            ->disableOriginalConstructor()
            ->getMock();
        $queryBuilderMock->expects($this->atLeastOnce())->method('execute')->willReturn($resultMock);
        $queryBuilderMock->method('expr')->willReturn($expressionBuilderMock);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'getExampleContentInsertList',
                'getExampleJobItem1InsertFields',
            ])
            ->getMock();
        $oModelMock->method('getExampleContentInsertList')->willReturn(
            [
                [
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile',
                ],
            ]
        );
        $oModelMock->method('getExampleJobItem1InsertFields')->willReturn(
            [
                [
                    'fieldname'     => 'OXID',
                    'content'       => "foobar",
                    'force_update'  => false,
                    'use_quote'     => false,
                    'use_multilang' => false,
                ],
                [
                    'fieldname'     => 'OXLOADID',
                    'content'       => "d3unknownContentId",
                    'force_update'  => false,
                    'use_quote'     => true,
                    'use_multilang' => false,
                ],
            ]
        );

        $this->_oModel = $oModelMock;

        d3GetOxidDIC()->set('d3ox.modcfg.OxDbQueryBuilder', $queryBuilderMock);

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'isExampleContentMissingInDatabase'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::isExampleContentMissingInDatabase
     * @test
     * @throws ReflectionException
     * @throws d3DicException
     */
    public function checkIsExampleContentMissingInDatabaseNegativeNoLoadId()
    {
        /** @var Result|MockObject $resultMock */
        $resultMock = $this->getMockBuilder(Result::class)
            ->onlyMethods(get_class_methods(Result::class))
            ->getMock();
        $resultMock->method('fetchOne')->willReturn(0);

        /** @var QueryBuilder|MockObject $queryBuilderMock */
        $queryBuilderMock = $this->getMockBuilder(QueryBuilder::class)
            ->onlyMethods(['execute'])
            ->disableOriginalConstructor()
            ->getMock();
        $queryBuilderMock->expects($this->never())->method('execute')->willReturn($resultMock);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'getExampleContentInsertList',
                'getExampleJobItem1InsertFields',
            ])
            ->getMock();
        $oModelMock->method('getExampleContentInsertList')->willReturn(
            [
                [
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile',
                ],
            ]
        );
        $oModelMock->method('getExampleJobItem1InsertFields')->willReturn(
            [
                [
                    'fieldname'     => 'OXID',
                    'content'       => "foobar",
                    'force_update'  => false,
                    'use_quote'     => false,
                    'use_multilang' => false,
                ],
            ]
        );

        $this->_oModel = $oModelMock;

        d3GetOxidDIC()->set('d3ox.modcfg.OxDbQueryBuilder', $queryBuilderMock);

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'isExampleContentMissingInDatabase'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::addExampleContentList
     * @test
     * @throws ReflectionException
     */
    public function canAddExampleContentList()
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'getExampleContentInsertList',
                '_addExampleJobItem',
                'setUpdateBreak',
            ])
            ->getMock();
        $oModelMock->method('getExampleContentInsertList')->willReturn(
            [
                [
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile',
                ],
                [
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile',
                ],
                [
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile',
                ],
            ]
        );
        $oModelMock->expects($this->exactly(2))->method('_addExampleJobItem')->will($this->onConsecutiveCalls(true, false, true));
        $oModelMock->method('setUpdateBreak')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'addExampleContentList'
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::requireExample2ShopRelation
     * @test
     * @throws ReflectionException
     * @throws Exception
     * @dataProvider trueFalseExpected
     */
    public function checkRequireExample2ShopRelationPass($expected)
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'setInitialExecMethod',
                'getExampleJobInsertList',
                'getExampleJobItem1InsertFields',
                '_require2ShopRelation',
                'getShopListByActiveModule',
            ])
            ->getMock();
        $oModelMock->method('setInitialExecMethod')->willReturn(true);
        $oModelMock->method('getExampleJobInsertList')->willReturn(
            [
                [
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile',
                ],
            ]
        );
        $oModelMock->expects($this->exactly($expected ? 1 : 3))->method('getExampleJobItem1InsertFields')->willReturn([]);
        $oModelMock->expects($this->exactly($expected ? 1 : 3))->method('_require2ShopRelation')->willReturn($expected);
        $oModelMock->expects($this->atLeastOnce())->method('getShopListByActiveModule')->willReturn(
            [
                1 => d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class),
                2 => d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class),
                3 => d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class),
            ]
        );

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oModel,
                'requireExample2ShopRelation'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::addExample2ShopRelation
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canAddExample2ShopRelationPass()
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'getExampleJobInsertList',
                '_add2ShopRelation',
                'getShopListByActiveModule',
            ])
            ->addMethods([
                'getExampleJobItem1PassInsertFields',
                'getExampleJobItem2PassInsertFields',
                'getExampleJobItem3PassInsertFields',
            ])
            ->getMock();
        $oModelMock->method('getExampleJobInsertList')->willReturn(
            [
                [
                    'content'   => 'getExampleJobItem1PassInsertFields',
                    'table'     => 'd3modprofile',
                ],
                [
                    'content'   => 'getExampleJobItem2PassInsertFields',
                    'table'     => 'd3modprofile',
                ],
                [
                    'content'   => 'getExampleJobItem3PassInsertFields',
                    'table'     => 'd3modprofile',
                ],
            ]
        );
        $oModelMock->expects($this->exactly(3))->method('getExampleJobItem1PassInsertFields')->willReturn(true);
        $oModelMock->expects($this->exactly(3))->method('getExampleJobItem2PassInsertFields')->willReturn(true);
        $oModelMock->expects($this->exactly(3))->method('getExampleJobItem3PassInsertFields')->willReturn(true);
        $oModelMock->expects($this->exactly(9))->method('_add2ShopRelation')->willReturn(true);
        $oModelMock->expects($this->atLeastOnce())->method('getShopListByActiveModule')->willReturn(
            [
                1 => d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class),
                2 => d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class),
                3 => d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class),
            ]
        );

        $this->_oModel = $oModelMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oModel,
                'addExample2ShopRelation'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::addExample2ShopRelation
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canAddExample2ShopRelationFails()
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'getExampleJobInsertList',
                '_add2ShopRelation',
                'getShopListByActiveModule',
            ])
            ->addMethods([
                'getExampleJobItem1FailedInsertFields',
                'getExampleJobItem2FailedInsertFields',
                'getExampleJobItem3FailedInsertFields',
            ])
            ->getMock();
        $oModelMock->method('getExampleJobInsertList')->willReturn(
            [
                [
                    'content'   => 'getExampleJobItem1FailedInsertFields',
                    'table'     => 'd3modprofile',
                ],
                [
                    'content'   => 'getExampleJobItem2FailedInsertFields',
                    'table'     => 'd3modprofile',
                ],
                [
                    'content'   => 'getExampleJobItem3FailedInsertFields',
                    'table'     => 'd3modprofile',
                ],
            ]
        );
        $oModelMock->expects($this->exactly(3))->method('getExampleJobItem1FailedInsertFields')->willReturn(true);
        $oModelMock->expects($this->exactly(3))->method('getExampleJobItem2FailedInsertFields')->willReturn(true);
        $oModelMock->expects($this->never())->method('getExampleJobItem3FailedInsertFields')->willReturn(true);
        $oModelMock->expects($this->exactly(6))->method('_add2ShopRelation')->will(
            $this->onConsecutiveCalls(
                true,
                true,
                true,
                true,
                false,
                false,
                true,
                true,
                true
            )
        );
        $oModelMock->expects($this->atLeastOnce())->method('getShopListByActiveModule')->willReturn(
            [
                1 => d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class),
                2 => d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class),
                3 => d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class),
            ]
        );

        $this->_oModel = $oModelMock;

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'addExample2ShopRelation'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::getExampleJobInsertList
     * @test
     * @throws ReflectionException
     */
    public function canGetExampleJobInsertList()
    {
        $aList = $this->callMethod(
            $this->_oModel,
            'getExampleJobInsertList'
        );

        $this->assertIsArray($aList);
        $this->assertTrue((bool) count($aList));
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::getExampleContentInsertList
     * @test
     * @throws ReflectionException
     */
    public function canGetExampleContentInsertList()
    {
        $aList = $this->callMethod(
            $this->_oModel,
            'getExampleContentInsertList'
        );

        $this->assertIsArray($aList);
        $this->assertTrue((bool) count($aList));
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::getExampleJobItem1InsertFields
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::getExampleJobItem2InsertFields
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::getExampleJobItem3InsertFields
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::getExampleJobItem4InsertFields
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::getExampleJobItem5InsertFields
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::getExampleJobItem6InsertFields
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::getExampleJobItem7InsertFields
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::getExampleJobItem8InsertFields
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::getExampleJobItem9InsertFields
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::getExampleJobItem10InsertFields
     * @test
     * @throws ReflectionException
     */
    public function canGetExampleJobItemXInsertFields()
    {
        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->onlyMethods(['getId'])
            ->getMock();
        $oShopMock->method('getId')->willReturn('shopId');

        /** @var d3bitmask|MockObject $oD3BitMock */
        $oD3BitMock = $this->getMockBuilder(d3bitmask::class)
            ->onlyMethods(['getIntByBitPosition'])
            ->getMock();
        $oD3BitMock->method('getIntByBitPosition')->willReturn(1);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'getD3BitMask',
                '_getLangAbbrFieldName',
            ])
            ->getMock();
        $oModelMock->method('getD3BitMask')->willReturn($oD3BitMock);
        $oModelMock->method('_getLangAbbrFieldName')->willReturn('fieldName');

        $this->_oModel = $oModelMock;

        foreach ($this->_oModel->getExampleJobInsertList() as $aJobContentInfos) {
            $aFieldList = $this->callMethod(
                $this->_oModel,
                $aJobContentInfos['content'],
                [$oShopMock]
            );

            $this->assertIsArray($aFieldList);
            $this->assertTrue((bool) count($aFieldList));
        }
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::getExampleContent1InsertFields
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::getExampleContent2InsertFields
     * @test
     * @throws ReflectionException
     */
    public function canGetExampleContentXInsertFields()
    {
        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->onlyMethods(['getId'])
            ->getMock();
        $oShopMock->method('getId')->willReturn('shopId');

        /** @var d3bitmask|MockObject $oD3BitMock */
        $oD3BitMock = $this->getMockBuilder(d3bitmask::class)
            ->onlyMethods(['getIntByBitPosition'])
            ->getMock();
        $oD3BitMock->method('getIntByBitPosition')->willReturn(1);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'getD3BitMask',
                '_getLangAbbrFieldName',
            ])
            ->getMock();
        $oModelMock->method('getD3BitMask')->willReturn($oD3BitMock);
        $oModelMock->method('_getLangAbbrFieldName')->willReturn('fieldName');

        $this->_oModel = $oModelMock;

        foreach ($this->_oModel->getExampleContentInsertList() as $aContentInfos) {
            $aFieldList = $this->callMethod(
                $this->_oModel,
                $aContentInfos['content'],
                [$oShopMock]
            );

            $this->assertIsArray($aFieldList);
            $this->assertTrue((bool) count($aFieldList));
        }
    }

    /**
     * @covers       \D3\Ordermanager\Setup\d3ordermanager_update::_addExampleJobItem
     * @test
     *
     * @param $expected
     *
     * @throws ReflectionException
     * @dataProvider trueFalseExpected
     */
    public function canAddExampleJobItemNoStepByStep($expected)
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'getShopListByActiveModule',
                'setInitialExecMethod',
                '_updateTableItem2',
                'getStepByStepMode', ])
            ->addMethods(['jobFieldMethodName'])
            ->getMock();

        $oModelMock->method('getShopListByActiveModule')->willReturn(
            [
                1 => d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class),
                2 => d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class),
            ]
        );

        $oModelMock->method('jobFieldMethodName')->willReturn(true);
        $oModelMock->method('setInitialExecMethod')->willReturn(true);
        $oModelMock->expects($this->exactly(2))->method('_updateTableItem2')->willReturn($expected);
        $oModelMock->method('getStepByStepMode')->willReturn(false);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oModel,
                '_addExampleJobItem',
                ['tableName', 'jobFieldMethodName']
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::getD3BitMask
     * @test
     * @throws ReflectionException
     */
    public function getD3BitReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3bitmask::class,
            $this->callMethod(
                $this->_oModel,
                'getD3BitMask'
            )
        );
    }

    /**
     * @covers       \D3\Ordermanager\Setup\d3ordermanager_update::_addExampleJobItem
     * @test
     *
     * @param $expected
     *
     * @throws ReflectionException
     * @dataProvider trueFalseExpected
     */
    public function canAddExampleJobItemStepByStep($expected)
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'getShopListByActiveModule',
                'setInitialExecMethod',
                '_updateTableItem2',
                'getStepByStepMode', ])
            ->addMethods([
                'jobFieldMethodName',
            ])
            ->getMock();

        $oModelMock->method('getShopListByActiveModule')->willReturn(
            [
                1 => d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class),
                2 => d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class),
            ]
        );

        $oModelMock->method('jobFieldMethodName')->willReturn(true);
        $oModelMock->method('setInitialExecMethod')->willReturn(true);
        $oModelMock->expects($this->once())->method('_updateTableItem2')->willReturn($expected);
        $oModelMock->method('getStepByStepMode')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oModel,
                '_addExampleJobItem',
                [ 'tableName', 'jobFieldMethodName' ]
            )
        );
    }

    /**
     * @return array
     */
    public function trueFalseExpected(): array
    {
        return [
            'true expected' => [true],
            'false expected' => [false],
        ];
    }

    /**
     *
     * @param $blCheckStatus
     * @param $blExpected
     * @param $iArticleCount
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::hasNotOrderArticlesParentId
     * @test
     * @throws DBALException
     * @throws ReflectionException
     * @dataProvider hasNotOrderArticlesParentIdDataProvider
     */
    public function checkHasNotOrderArticlesParentId($blCheckStatus, $blExpected, $iArticleCount)
    {
        /** @var Result|MockObject $resultMock */
        $resultMock = $this->getMockBuilder(Result::class)
            ->onlyMethods(get_class_methods(Result::class))
            ->getMock();
        $resultMock->method('fetchOne')->willReturn($iArticleCount);

        /** @var QueryBuilder|MockObject $oQBMock */
        $oQBMock = $this->getMockBuilder(QueryBuilder::class)
            ->onlyMethods(['execute'])
            ->setConstructorArgs([(new ConnectionProvider())->get()])
            ->getMock();
        $oQBMock->method('execute')->willReturn($resultMock);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                'mustCheckOrderArticlesParentId',
                'setDontCheckOrderArticlesParentId',
            ])
            ->getMock();
        $oModelMock->method('mustCheckOrderArticlesParentId')->willReturn($blCheckStatus);
        $oModelMock->expects($this->exactly(((int)!(bool) $iArticleCount)))->method('setDontCheckOrderArticlesParentId');

        $this->_oModel = $oModelMock;

        d3GetOxidDIC()->set('d3ox.modcfg.OxDbQueryBuilder', $oQBMock);

        $this->assertSame(
            $blExpected,
            $this->callMethod(
                $this->_oModel,
                'hasNotOrderArticlesParentId'
            )
        );
    }

    /**
     * @return array
     */
    public function hasNotOrderArticlesParentIdDataProvider()
    {
        return [
            [true, true, 2], // first execution, must check
            [true, false, 0], // first execution, must check
            [false, false, 2], // later executions, mustn't check again
        ];
    }

    /**
     * @param $blConfig
     * @param $blExpected
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::mustCheckOrderArticlesParentId
     * @test
     * @throws ReflectionException
     * @dataProvider mustCheckOrderArticlesParentIdPassDataProvider
     */
    public function mustCheckOrderArticlesParentIdPass($blConfig, $blExpected)
    {
        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->onlyMethods(['getShopConfVar'])
            ->getMock();
        $oConfigMock->expects($this->once())->method('getShopConfVar')->willReturn($blConfig);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods(['d3GetConfig'])
            ->getMock();
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $blExpected,
            $this->callMethod(
                $this->_oModel,
                'mustCheckOrderArticlesParentId'
            )
        );
    }

    /**
     * @return array
     */
    public function mustCheckOrderArticlesParentIdPassDataProvider()
    {
        return [
            [true, false],
            [false, true],
        ];
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::setDontCheckOrderArticlesParentId()
     * @test
     * @throws ReflectionException
     */
    public function setDontCheckOrderArticlesParentIdPass()
    {
        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->onlyMethods(['saveShopConfVar'])
            ->getMock();
        $oConfigMock->expects($this->once())->method('saveShopConfVar')->willReturn(true);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods(['d3GetConfig'])
            ->getMock();
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'setDontCheckOrderArticlesParentId'
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::addOrderArticlesParentId()
     * @test
     * @throws ReflectionException
     */
    public function canAddOrderArticlesParentId()
    {
        /** @var QueryBuilder|MockObject $oQBMock */
        $oQBMock = $this->getMockBuilder(QueryBuilder::class)
                        ->onlyMethods(['setParameter'])
                        ->setConstructorArgs([(new ConnectionProvider())->get()])
                        ->getMock();

        d3GetOxidDIC()->set('d3ox.modcfg.OxDbQueryBuilder', $oQBMock);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->onlyMethods([
                '_tableSqlExecute',
                'setDontCheckOrderArticlesParentId',
            ])
            ->getMock();
        $oModelMock->expects($this->once())->method('_tableSqlExecute')->willReturn(true);
        $oModelMock->expects($this->once())->method('setDontCheckOrderArticlesParentId');

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'addOrderArticlesParentId'
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
