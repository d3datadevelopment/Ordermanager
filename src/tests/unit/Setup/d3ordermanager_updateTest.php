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

namespace D3\Ordermanager\Tests\unit\Setup;

use D3\ModCfg\Application\Model\d3bitmask;
use D3\ModCfg\Application\Model\d3database;
use D3\ModCfg\Application\Model\Installwizzard\d3installdbrecord;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Setup\d3ordermanager_update;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\DBAL\Driver\PDOStatement;
use Doctrine\DBAL\Query\QueryBuilder;
use Exception;
use OxidEsales\Eshop\Application\Model\Shop;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;
use stdClass;

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
    public function setUp()
    {
        parent::setUp();

        $this->_oModel = d3GetModCfgDIC()->get(d3ordermanager_update::class);
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->_oModel);
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::checkOrderManagerTableExist
     * @test
     * @throws ReflectionException
     */
    public function canCheckOrderManagerTableExist()
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods(['_checkTableNotExist'])
            ->getMock();
        $oModelMock->expects($this->once())->method('_checkTableNotExist')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'checkOrderManagerTableExist'
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::convertOrderManagerItems
     * @test
     * @throws ReflectionException
     */
    public function canStartConvertOrderManagerItemsExecuteNoException()
    {
        /** @var DatabaseInterface|MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['Execute'])
            ->getMock();
        $oDBInterfaceMock->expects($this->once())->method('Execute')->willReturn(true);
        
        /** @var d3database|MockObject $oDatabaseMock */
        $oDatabaseMock = $this->getMockBuilder(d3database::class)
            ->setMethods(['getDataConvertQuery'])
            ->getMock();
        $oDatabaseMock->method('getDataConvertQuery')->willReturn(array('SELECT 1;', 'SELECT 2;'));

        
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'checkOrderManagerTableExist',
                '_changeItemContent',
                '_prepareConvertAssignments',
                '_getConvertAssignments',
                '_getDatabaseHandler',
                'hasExecute',
                'getDb',
                'setUpdateBreak',
                'setActionLog',
                '_dropTable',
                'fixUnRegisterMultiLangTables',
                'setErrorMessage'
            ])
            ->getMock();
        $oModelMock->method('checkOrderManagerTableExist')->willReturn(true);
        $oModelMock->expects($this->once())->method('_changeItemContent')->willReturn(true);
        $oModelMock->method('_prepareConvertAssignments')->willReturn(true);
        $oModelMock->method('_getConvertAssignments')->willReturn(true);
        $oModelMock->method('_getDatabaseHandler')->willReturn($oDatabaseMock);
        $oModelMock->method('hasExecute')->willReturn(true);
        $oModelMock->method('getDb')->willReturn($oDBInterfaceMock);
        $oModelMock->method('setUpdateBreak')->willReturn(true);
        $oModelMock->expects($this->once())->method('setActionLog')->willReturn(true);
        $oModelMock->expects($this->once())->method('_dropTable')->willReturn(true);
        $oModelMock->expects($this->once())->method('fixUnRegisterMultiLangTables')->willReturn(true);
        $oModelMock->expects($this->never())->method('setErrorMessage')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oModel,
                'convertOrderManagerItems'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::convertOrderManagerItems
     * @test
     * @throws ReflectionException
     */
    public function canStartConvertOrderManagerItemsNoExecute()
    {
        /** @var DatabaseInterface|MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['Execute'])
            ->getMock();
        $oDBInterfaceMock->expects($this->never())->method('Execute')->willReturn(true);

        /** @var d3database|MockObject $oDatabaseMock */
        $oDatabaseMock = $this->getMockBuilder(d3database::class)
            ->setMethods(['getDataConvertQuery'])
            ->getMock();
        $oDatabaseMock->method('getDataConvertQuery')->willReturn(array('SELECT 1;', 'SELECT 2;'));


        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'checkOrderManagerTableExist',
                '_changeItemContent',
                '_prepareConvertAssignments',
                '_getConvertAssignments',
            '_getDatabaseHandler',
            'hasExecute',
            'getDb',
            'setUpdateBreak',
            'setActionLog',
            '_dropTable',
            'fixUnRegisterMultiLangTables',
            'setErrorMessage'])
            ->getMock();
        $oModelMock->method('checkOrderManagerTableExist')->willReturn(true);
        $oModelMock->expects($this->once())->method('_changeItemContent')->willReturn(true);
        $oModelMock->method('_prepareConvertAssignments')->willReturn(true);
        $oModelMock->method('_getConvertAssignments')->willReturn(true);
        $oModelMock->method('_getDatabaseHandler')->willReturn($oDatabaseMock);
        $oModelMock->method('hasExecute')->willReturn(false);
        $oModelMock->method('getDb')->willReturn($oDBInterfaceMock);
        $oModelMock->method('setUpdateBreak')->willReturn(true);
        $oModelMock->expects($this->once())->method('setActionLog')->willReturn(true);
        $oModelMock->expects($this->once())->method('_dropTable')->willReturn(true);
        $oModelMock->expects($this->once())->method('fixUnRegisterMultiLangTables')->willReturn(true);
        $oModelMock->expects($this->never())->method('setErrorMessage')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oModel,
                'convertOrderManagerItems'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::convertOrderManagerItems
     * @test
     * @throws ReflectionException
     */
    public function canNotStartConvertOrderManagerItems()
    {
        /** @var DatabaseInterface|MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['Execute'])
            ->getMock();
        $oDBInterfaceMock->expects($this->never())->method('Execute')->willReturn(true);

        /** @var d3database|MockObject $oDatabaseMock */
        $oDatabaseMock = $this->getMockBuilder(d3database::class)
            ->setMethods(['getDataConvertQuery'])
            ->getMock();
        $oDatabaseMock->method('getDataConvertQuery')->willReturn(array('SELECT 1;', 'SELECT 2;'));


        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'checkOrderManagerTableExist',
                '_changeItemContent',
                '_prepareConvertAssignments',
                '_getConvertAssignments',
            '_getDatabaseHandler',
            'hasExecute',
            'getDb',
            'setUpdateBreak',
            'setActionLog',
            '_dropTable',
            'fixUnRegisterMultiLangTables',
            'setErrorMessage'])
            ->getMock();
        $oModelMock->method('checkOrderManagerTableExist')->willReturn(false);
        $oModelMock->expects($this->never())->method('_changeItemContent')->willReturn(true);
        $oModelMock->method('_prepareConvertAssignments')->willReturn(true);
        $oModelMock->method('_getConvertAssignments')->willReturn(true);
        $oModelMock->method('_getDatabaseHandler')->willReturn($oDatabaseMock);
        $oModelMock->method('hasExecute')->willReturn(false);
        $oModelMock->method('getDb')->willReturn($oDBInterfaceMock);
        $oModelMock->method('setUpdateBreak')->willReturn(true);
        $oModelMock->expects($this->never())->method('setActionLog')->willReturn(true);
        $oModelMock->expects($this->never())->method('_dropTable')->willReturn(true);
        $oModelMock->expects($this->never())->method('fixUnRegisterMultiLangTables')->willReturn(true);
        $oModelMock->expects($this->never())->method('setErrorMessage')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'convertOrderManagerItems'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::convertOrderManagerItems
     * @test
     * @throws ReflectionException
     */
    public function canStartConvertOrderManagerItemsExecuteException()
    {
        /** @var DatabaseInterface|MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['Execute'])
            ->getMock();
        $oDBInterfaceMock->expects($this->once())->method('Execute')->willReturnCallback(array($this, 'dbInterfaceExecuteThrowException'));

        /** @var d3database|MockObject $oDatabaseMock */
        $oDatabaseMock = $this->getMockBuilder(d3database::class)
            ->setMethods(['getDataConvertQuery'])
            ->getMock();
        $oDatabaseMock->method('getDataConvertQuery')->willReturn(array('SELECT 1;', 'SELECT 2;'));

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'checkOrderManagerTableExist',
                '_changeItemContent',
                '_prepareConvertAssignments',
                '_getConvertAssignments',
            '_getDatabaseHandler',
            'hasExecute',
            'getDb',
            'setUpdateBreak',
            'setActionLog',
            '_dropTable',
            'fixUnRegisterMultiLangTables',
            'setErrorMessage'])
            ->getMock();
        $oModelMock->method('checkOrderManagerTableExist')->willReturn(true);
        $oModelMock->expects($this->once())->method('_changeItemContent')->willReturn(true);
        $oModelMock->method('_prepareConvertAssignments')->willReturn(true);
        $oModelMock->method('_getConvertAssignments')->willReturn(true);
        $oModelMock->method('_getDatabaseHandler')->willReturn($oDatabaseMock);
        $oModelMock->method('hasExecute')->willReturn(true);
        $oModelMock->method('getDb')->willReturn($oDBInterfaceMock);
        $oModelMock->method('setUpdateBreak')->willReturn(true);
        $oModelMock->expects($this->once())->method('setActionLog')->willReturn(true);
        $oModelMock->expects($this->never())->method('_dropTable')->willReturn(true);
        $oModelMock->expects($this->never())->method('fixUnRegisterMultiLangTables')->willReturn(true);
        $oModelMock->expects($this->once())->method('setErrorMessage')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'convertOrderManagerItems'
            )
        );
    }

    public function dbInterfaceExecuteThrowException()
    {
        $oPDOException = oxNew(\PDOException::class);
        $oPDOException->errorInfo = array(
            1   => 'errorInfoNo1',
            2   => 'errorInfoNo1',
        );

        throw oxNew(PDOException::class, $oPDOException);
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::_getConvertAssignments
     * @test
     * @throws ReflectionException
     */
    public function canGetConvertAssignments()
    {
        $aAssignments = $this->callMethod(
            $this->_oModel,
            '_getConvertAssignments'
        );

        $this->assertInternalType(
            'array',
            $aAssignments
        );
        $this->assertTrue((bool) count($aAssignments), 'Assignments dont have got items');
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::_changeItemContent
     * @test
     * @throws DBALException
     * @throws ReflectionException
     */
    public function canChangeItemContentExecuteNoException()
    {
        $iLangCount = 2;
        $iValueCount = 2;

        /** @var PDOStatement|MockObject $oStmtMock */
        $oStmtMock = $this->getMockBuilder(PDOStatement::class)
            ->setMethods(['fetchAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $oStmtMock->expects($this->exactly($iLangCount))->method('fetchAll')->willReturn(
            array('field1' => array(
                'value' => 'YSUzQTIlM0ElN0JzJTNBNCUzQSUyMmtleTElMjIlM0JzJTNBNiUzQSUyMnZhbHVlMSUyMiUzQnMlM0E0JTNBJTIya2V5MiUyMiUzQnMlM0E2JTNBJTIydmFsdWUyJTIyJTNCJTdE')
                // array(
                //    'key1'    => 'value1',
                //    'key2'    => 'value2',
                //)
            )
        );

        /** @var QueryBuilder|MockObject $oQBMock */
        $oQBMock = $this->getMockBuilder(QueryBuilder::class)
            ->setMethods(['execute'])
            ->setConstructorArgs([d3database::getInstance()->getConnection()])
            ->getMock();
        $oQBMock->expects($this->exactly($iLangCount * $iValueCount))->method('Execute')->willReturn($oStmtMock);

        /** @var d3database|MockObject $od3databaseMock */
        $od3databaseMock = $this->getMockBuilder(d3database::class)
            ->setMethods([
                'getQueryBuilder',
                'checkTableExist',
                'checkFieldExist'
            ])
            ->getMock();
        $od3databaseMock->expects($this->exactly($iLangCount * $iValueCount))->method('getQueryBuilder')->willReturn($oQBMock);
        $od3databaseMock->method('checkTableExist')->willReturn(true);
        $od3databaseMock->method('checkFieldExist')->willReturn(true);

        d3GetModCfgDIC()->set('d3.ordermanager.database', $od3databaseMock);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'getMaxLanguages',
                '_addMultiLangAddOn',
                'hasExecute',
                'setUpdateBreak',
                'setActionLog',
                'setErrorMessage'])
            ->getMock();
        $oModelMock->method('getMaxLanguages')->willReturn($iLangCount);
        $oModelMock->method('_addMultiLangAddOn')->willReturn(true);
        $oModelMock->method('hasExecute')->willReturn(true);
        $oModelMock->expects($this->exactly($iLangCount))->method('setUpdateBreak')->willReturn(true);
        $oModelMock->expects($this->exactly($iLangCount))->method('setActionLog')->willReturn(true);
        $oModelMock->expects($this->never())->method('setErrorMessage')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            '_changeItemContent',
            array('oldKey', 'newKey')
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::_changeItemContent
     * @test
     * @throws DBALException
     * @throws ReflectionException
     */
    public function canChangeItemContentExecuteException()
    {
        $iLangCount = 2;
        $iValueCount = 2;

        /** @var PDOStatement|MockObject $oStmtMock */
        $oStmtMock = $this->getMockBuilder(PDOStatement::class)
            ->setMethods(['fetchAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $oStmtMock->expects($this->exactly($iLangCount))->method('fetchAll')->willReturn(
            array('field1' => array(
                'value' => 'YSUzQTIlM0ElN0JzJTNBNCUzQSUyMmtleTElMjIlM0JzJTNBNiUzQSUyMnZhbHVlMSUyMiUzQnMlM0E0JTNBJTIya2V5MiUyMiUzQnMlM0E2JTNBJTIydmFsdWUyJTIyJTNCJTdE')
                // array(
                //    'key1'    => 'value1',
                //    'key2'    => 'value2',
                //)
            )
        );

        /** @var QueryBuilder|MockObject $oQBSuccessMock */
        $oQBSuccessMock = $this->getMockBuilder(QueryBuilder::class)
            ->setMethods(['execute'])
            ->setConstructorArgs([d3database::getInstance()->getConnection()])
            ->getMock();
        $oQBSuccessMock->expects($this->exactly($iLangCount))->method('execute')->willReturn($oStmtMock);

        /** @var QueryBuilder|MockObject $oQBExceptionMock */
        $oQBExceptionMock = $this->getMockBuilder(QueryBuilder::class)
            ->setMethods(['execute'])
            ->setConstructorArgs([d3database::getInstance()->getConnection()])
            ->getMock();
        $oQBExceptionMock->expects($this->exactly($iValueCount))->method('execute')->willReturnCallback(array($this, 'dbInterfaceExecuteThrowException'));

        /** @var d3database|MockObject $od3databaseMock */
        $od3databaseMock = $this->getMockBuilder(d3database::class)
            ->setMethods([
                'getQueryBuilder',
                'checkTableExist',
                'checkFieldExist'
            ])
            ->getMock();
        $od3databaseMock->expects($this->exactly($iLangCount * $iValueCount))->method('getQueryBuilder')->willReturnOnConsecutiveCalls(
            $oQBSuccessMock,
            $oQBExceptionMock,
            $oQBSuccessMock,
            $oQBExceptionMock
        );
        $od3databaseMock->method('checkTableExist')->willReturn(true);
        $od3databaseMock->method('checkFieldExist')->willReturn(true);

        d3GetModCfgDIC()->set('d3.ordermanager.database', $od3databaseMock);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'getMaxLanguages',
                '_addMultiLangAddOn',
                'hasExecute',
                'setUpdateBreak',
                'setActionLog',
                'setErrorMessage'])
            ->getMock();
        $oModelMock->method('getMaxLanguages')->willReturn($iLangCount);
        $oModelMock->method('_addMultiLangAddOn')->willReturn(true);
        $oModelMock->method('hasExecute')->willReturn(true);
        $oModelMock->expects($this->exactly($iLangCount))->method('setUpdateBreak')->willReturn(true);
        $oModelMock->expects($this->exactly($iLangCount))->method('setActionLog')->willReturn(true);
        $oModelMock->expects($this->exactly($iLangCount))->method('setErrorMessage')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            '_changeItemContent',
            array('oldKey', 'newKey')
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::_changeItemContent
     * @test
     * @throws DBALException
     * @throws ReflectionException
     */
    public function canChangeItemContentNoExecute()
    {
        $iLangCount = 2;
        $iValueCount = 2;

        /** @var PDOStatement|MockObject $oStmtMock */
        $oStmtMock = $this->getMockBuilder(PDOStatement::class)
            ->setMethods(['fetchAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $oStmtMock->expects($this->exactly($iLangCount))->method('fetchAll')->willReturn(
            array('field1' => array(
                'value' => 'YSUzQTIlM0ElN0JzJTNBNCUzQSUyMmtleTElMjIlM0JzJTNBNiUzQSUyMnZhbHVlMSUyMiUzQnMlM0E0JTNBJTIya2V5MiUyMiUzQnMlM0E2JTNBJTIydmFsdWUyJTIyJTNCJTdE')
                // array(
                //    'key1'    => 'value1',
                //    'key2'    => 'value2',
                //)
            )
        );

        /** @var QueryBuilder|MockObject $oQBMock */
        $oQBMock = $this->getMockBuilder(QueryBuilder::class)
            ->setMethods(['execute'])
            ->setConstructorArgs([d3database::getInstance()->getConnection()])
            ->getMock();
        $oQBMock->expects($this->exactly($iLangCount))->method('execute')->willReturn($oStmtMock);

        /** @var d3database|MockObject $od3databaseMock */
        $od3databaseMock = $this->getMockBuilder(d3database::class)
            ->setMethods([
                'getQueryBuilder',
                'checkTableExist',
                'checkFieldExist'
            ])
            ->getMock();
        $od3databaseMock->expects($this->exactly($iLangCount * $iValueCount))->method('getQueryBuilder')->willReturn($oQBMock);
        $od3databaseMock->method('checkTableExist')->willReturn(true);
        $od3databaseMock->method('checkFieldExist')->willReturn(true);

        d3GetModCfgDIC()->set('d3.ordermanager.database', $od3databaseMock);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'getMaxLanguages',
                '_addMultiLangAddOn',
                'hasExecute',
                'setUpdateBreak',
                'setActionLog',
                'setErrorMessage'])
            ->getMock();
        $oModelMock->method('getMaxLanguages')->willReturn($iLangCount);
        $oModelMock->method('_addMultiLangAddOn')->willReturn(true);
        $oModelMock->method('hasExecute')->willReturn(false);
        $oModelMock->expects($this->exactly($iLangCount))->method('setUpdateBreak')->willReturn(true);
        $oModelMock->expects($this->exactly($iLangCount))->method('setActionLog')->willReturn(true);
        $oModelMock->expects($this->never())->method('setErrorMessage')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            '_changeItemContent',
            array('oldKey', 'newKey')
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::_changeItemContent
     * @test
     * @throws ReflectionException
     */
    public function canChangeItemContentFieldNotExist()
    {
        $iLangCount = 2;

        /** @var d3database|MockObject $od3databaseMock */
        $od3databaseMock = $this->getMockBuilder(d3database::class)
            ->setMethods([
                'getQueryBuilder',
                'checkTableExist',
                'checkFieldExist'
            ])
            ->getMock();
        $od3databaseMock->expects($this->never())->method('getQueryBuilder')->willReturn(true);
        $od3databaseMock->method('checkTableExist')->willReturn(false);
        $od3databaseMock->method('checkFieldExist')->willReturn(false);

        d3GetModCfgDIC()->set('d3.ordermanager.database', $od3databaseMock);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'getMaxLanguages',
                '_addMultiLangAddOn',
                'hasExecute',
                'setUpdateBreak',
                'setActionLog',
                'setErrorMessage'])
            ->getMock();
        $oModelMock->method('getMaxLanguages')->willReturn($iLangCount);
        $oModelMock->method('_addMultiLangAddOn')->willReturn(true);
        $oModelMock->method('hasExecute')->willReturn(false);
        $oModelMock->expects($this->never())->method('setUpdateBreak')->willReturn(true);
        $oModelMock->expects($this->never())->method('setActionLog')->willReturn(true);
        $oModelMock->expects($this->never())->method('setErrorMessage')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            '_changeItemContent',
            array('oldKey', 'newKey')
        );
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
            ->setMethods(['_checkTableNotExist'])
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
            ->setMethods([
                'doesOrder2OrderManagerTableNotExist',
                '_addTable2'
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
            ->setMethods([
                'doesOrder2OrderManagerTableNotExist',
                '_addTable2'
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
            ->setMethods(['checkTableRecordNotExist'])
            ->setConstructorArgs([$this->_oModel])
            ->getMock();
        $oInstallDbRecordMock->expects($this->once())->method('checkTableRecordNotExist')->willReturn(true);
        
        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->setMethods(['getShopIds'])
            ->getMock();
        $oConfigMock->method('getShopIds')->willReturn(array(1, 2));
        
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'd3GetConfig',
                'd3GetInstallDbRecord'
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
            ->setMethods(['checkTableRecordNotExist'])
            ->setConstructorArgs([$this->_oModel])
            ->getMock();
        $oInstallDbRecordMock->expects($this->exactly(2))->method('checkTableRecordNotExist')->willReturn(false);

        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->setMethods(['getShopIds'])
            ->getMock();
        $oConfigMock->method('getShopIds')->willReturn(array(1, 2));

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'd3GetConfig',
                'd3GetInstallDbRecord'
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
            ->setMethods(['checkTableRecordNotExist'])
            ->setConstructorArgs([$this->_oModel])
            ->getMock();
        $oInstallDbRecordMock->expects($this->exactly(2))->method('checkTableRecordNotExist')->willReturn(true);

        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->setMethods(['getShopIds'])
            ->getMock();
        $oConfigMock->method('getShopIds')->willReturn(array(1, 2));

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'doesModCfgItemNotExist',
                'd3GetConfig',
                'd3GetInstallDbRecord',
                'setInitialExecMethod',
            '_updateTableItem2',
            'getStepByStepMode'])
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
            ->setMethods(['checkTableRecordNotExist'])
            ->setConstructorArgs([$this->_oModel])
            ->getMock();
        $oInstallDbRecordMock->expects($this->exactly(1))->method('checkTableRecordNotExist')->willReturn(true);

        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->setMethods(['getShopIds'])
            ->getMock();
        $oConfigMock->method('getShopIds')->willReturn(array(1, 2));

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'doesModCfgItemNotExist',
                'd3GetConfig',
                'd3GetInstallDbRecord',
                'setInitialExecMethod',
            '_updateTableItem2',
            'getStepByStepMode'])
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
            ->setMethods(['checkTableRecordNotExist'])
            ->setConstructorArgs([$this->_oModel])
            ->getMock();
        $oInstallDbRecordMock->expects($this->never())->method('checkTableRecordNotExist')->willReturn(true);

        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->setMethods(['getShopIds'])
            ->getMock();
        $oConfigMock->method('getShopIds')->willReturn(array(1, 2));

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'doesModCfgItemNotExist',
                'd3GetConfig',
                'd3GetInstallDbRecord',
                'setInitialExecMethod',
            '_updateTableItem2',
            'getStepByStepMode'])
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
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::needExampleJobList
     * @test
     * @throws DBALException
     * @throws ReflectionException
     */
    public function needExampleJobListPass()
    {
        /** @var PDOStatement|MockObject $oStmtMock */
        $oStmtMock = $this->getMockBuilder(PDOStatement::class)
            ->setMethods(['fetchColumn'])
            ->disableOriginalConstructor()
            ->getMock();
        $oStmtMock->expects($this->once())->method('fetchColumn')->willReturn(0);

        /** @var QueryBuilder|MockObject $oQBMock */
        $oQBMock = $this->getMockBuilder(QueryBuilder::class)
            ->setMethods(['execute'])
            ->setConstructorArgs([d3database::getInstance()->getConnection()])
            ->getMock();
        $oQBMock->method('execute')->willReturn($oStmtMock);

        /** @var d3database|MockObject $od3databaseMock */
        $od3databaseMock = $this->getMockBuilder(d3database::class)
            ->setMethods(['getQueryBuilder'])
            ->getMock();
        $od3databaseMock->expects($this->once())->method('getQueryBuilder')->willReturn($oQBMock);

        d3GetModCfgDIC()->set('d3.ordermanager.database', $od3databaseMock);

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
     * @throws DBALException
     * @throws ReflectionException
     */
    public function needExampleJobListDontPass()
    {
        /** @var PDOStatement|MockObject $oStmtMock */
        $oStmtMock = $this->getMockBuilder(PDOStatement::class)
            ->setMethods(['fetchColumn'])
            ->disableOriginalConstructor()
            ->getMock();
        $oStmtMock->expects($this->once())->method('fetchColumn')->willReturn(true);

        /** @var QueryBuilder|MockObject $oQBMock */
        $oQBMock = $this->getMockBuilder(QueryBuilder::class)
            ->setMethods(['execute'])
            ->setConstructorArgs([d3database::getInstance()->getConnection()])
            ->getMock();
        $oQBMock->method('execute')->willReturn($oStmtMock);

        /** @var d3database|MockObject $od3databaseMock */
        $od3databaseMock = $this->getMockBuilder(d3database::class)
            ->setMethods(['getQueryBuilder'])
            ->getMock();
        $od3databaseMock->expects($this->once())->method('getQueryBuilder')->willReturn($oQBMock);

        d3GetModCfgDIC()->set('d3.ordermanager.database', $od3databaseMock);

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
            ->setMethods([
                'getExampleJobInsertList',
                '_addExampleJobItem',
                'setUpdateBreak'
            ])
            ->getMock();
        $oModelMock->method('getExampleJobInsertList')->willReturn(
            array(
                array(
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile'
                ),
                array(
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile'
                ),
                array(
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile'
                )
            )
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
        /** @var PDOStatement|MockObject $oStmtMock */
        $oStmtMock = $this->getMockBuilder(PDOStatement::class)
            ->setMethods(['fetchColumn'])
            ->disableOriginalConstructor()
            ->getMock();
        $oStmtMock->expects($this->once())->method('fetchColumn')->willReturn(1);

        /** @var QueryBuilder|MockObject $oQBMock */
        $oQBMock = $this->getMockBuilder(QueryBuilder::class)
            ->setMethods(['execute'])
            ->setConstructorArgs([d3database::getInstance()->getConnection()])
            ->getMock();
        $oQBMock->method('execute')->willReturn($oStmtMock);

        /** @var d3database|MockObject $od3databaseMock */
        $od3databaseMock = $this->getMockBuilder(d3database::class)
            ->setMethods(['getQueryBuilder'])
            ->getMock();
        $od3databaseMock->expects($this->once())->method('getQueryBuilder')->willReturn($oQBMock);

        d3GetModCfgDIC()->set('d3.ordermanager.database', $od3databaseMock);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'getExampleContentInsertList',
                'getExampleJobItem1InsertFields'
            ])
            ->getMock();
        $oModelMock->method('getExampleContentInsertList')->willReturn(
            array(
                array(
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile'
                )
            )
        );
        $oModelMock->method('getExampleJobItem1InsertFields')->willReturn(
            array(
                array (
                    'fieldname'     => 'OXID',
                    'content'       => "foobar",
                    'force_update'  => false,
                    'use_quote'     => false,
                    'use_multilang' => false,
                ),
                array (
                    'fieldname'     => 'OXLOADID',
                    'content'       => "d3unknownContentId",
                    'force_update'  => false,
                    'use_quote'     => true,
                    'use_multilang' => false,
                )
            )
        );

        $this->_oModel = $oModelMock;

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
     * @throws DBALException
     * @throws ReflectionException
     */
    public function checkIsExampleContentMissingInDatabaseNegative()
    {
        /** @var PDOStatement|MockObject $oStmtMock */
        $oStmtMock = $this->getMockBuilder(PDOStatement::class)
            ->setMethods(['fetchColumn'])
            ->disableOriginalConstructor()
            ->getMock();
        $oStmtMock->expects($this->once())->method('fetchColumn')->willReturn(0);

        /** @var QueryBuilder|MockObject $oQBMock */
        $oQBMock = $this->getMockBuilder(QueryBuilder::class)
            ->setMethods(['execute'])
            ->setConstructorArgs([d3database::getInstance()->getConnection()])
            ->getMock();
        $oQBMock->method('execute')->willReturn($oStmtMock);

        /** @var d3database|MockObject $od3databaseMock */
        $od3databaseMock = $this->getMockBuilder(d3database::class)
            ->setMethods(['getQueryBuilder'])
            ->getMock();
        $od3databaseMock->expects($this->once())->method('getQueryBuilder')->willReturn($oQBMock);

        d3GetModCfgDIC()->set('d3.ordermanager.database', $od3databaseMock);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'getExampleContentInsertList',
                'getExampleJobItem1InsertFields'
            ])
            ->getMock();
        $oModelMock->method('getExampleContentInsertList')->willReturn(
            array(
                array(
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile'
                )
            )
        );
        $oModelMock->method('getExampleJobItem1InsertFields')->willReturn(
            array(
                array (
                    'fieldname'     => 'OXID',
                    'content'       => "foobar",
                    'force_update'  => false,
                    'use_quote'     => false,
                    'use_multilang' => false,
                ),
                array (
                    'fieldname'     => 'OXLOADID',
                    'content'       => "d3unknownContentId",
                    'force_update'  => false,
                    'use_quote'     => true,
                    'use_multilang' => false,
                )
            )
        );

        $this->_oModel = $oModelMock;

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
     */
    public function checkIsExampleContentMissingInDatabaseNegativeNoLoadId()
    {
        /** @var DatabaseInterface|MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['getOne'])
            ->getMock();
        $oDBInterfaceMock->expects($this->never())->method('getOne')->willReturn(0);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'getExampleContentInsertList',
                'getDb',
                'getExampleJobItem1InsertFields'
            ])
            ->getMock();
        $oModelMock->method('getExampleContentInsertList')->willReturn(
            array(
                array(
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile'
                )
            )
        );
        $oModelMock->method('getDb')->willReturn($oDBInterfaceMock);
        $oModelMock->method('getExampleJobItem1InsertFields')->willReturn(
            array(
                array (
                    'fieldname'     => 'OXID',
                    'content'       => "foobar",
                    'force_update'  => false,
                    'use_quote'     => false,
                    'use_multilang' => false,
                ),
            )
        );

        $this->_oModel = $oModelMock;

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
            ->setMethods([
                'getExampleContentInsertList',
                '_addExampleJobItem',
                'setUpdateBreak'
            ])
            ->getMock();
        $oModelMock->method('getExampleContentInsertList')->willReturn(
            array(
                array(
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile'
                ),
                array(
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile'
                ),
                array(
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile'
                )
            )
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
     */
    public function checkRequireExample2ShopRelationTrue()
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'setInitialExecMethod',
                'getExampleJobInsertList',
                'getExampleJobItem1InsertFields',
                '_require2ShopRelation'])
            ->getMock();
        $oModelMock->method('setInitialExecMethod')->willReturn(true);
        $oModelMock->method('getExampleJobInsertList')->willReturn(
            array(
                array(
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile'
                )
            )
        );
        $oModelMock->expects($this->once())->method('getExampleJobItem1InsertFields')->willReturn(true);
        $oModelMock->expects($this->once())->method('_require2ShopRelation')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oModel,
                'requireExample2ShopRelation'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::requireExample2ShopRelation
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function checkRequireExample2ShopRelationFalse()
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'setInitialExecMethod',
                'getExampleJobInsertList',
                'getExampleJobItem1InsertFields',
                '_require2ShopRelation',
                'getShopListByActiveModule'
            ])
            ->getMock();
        $oModelMock->method('setInitialExecMethod')->willReturn(true);
        $oModelMock->method('getExampleJobInsertList')->willReturn(
            array(
                array(
                    'content'   => 'getExampleJobItem1InsertFields',
                    'table'     => 'd3modprofile'
                )
            )
        );
        $oModelMock->expects($this->exactly(3))->method('getExampleJobItem1InsertFields')->willReturn(true);
        $oModelMock->expects($this->exactly(3))->method('_require2ShopRelation')->willReturn(false);
        $oModelMock->expects($this->atLeastOnce())->method('getShopListByActiveModule')->willReturn(
            array(
                1 => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class),
                2 => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class),
                3 => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class),
            ));

        $this->_oModel = $oModelMock;

        $this->assertFalse(
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
            ->setMethods([
                'getExampleJobInsertList',
                'getExampleJobItem1PassInsertFields',
                'getExampleJobItem2PassInsertFields',
                'getExampleJobItem3PassInsertFields',
                '_add2ShopRelation',
                'getShopListByActiveModule'
            ])
            ->getMock();
        $oModelMock->method('getExampleJobInsertList')->willReturn(
            array(
                array(
                    'content'   => 'getExampleJobItem1PassInsertFields',
                    'table'     => 'd3modprofile'
                ),
                array(
                    'content'   => 'getExampleJobItem2PassInsertFields',
                    'table'     => 'd3modprofile'
                ),
                array(
                    'content'   => 'getExampleJobItem3PassInsertFields',
                    'table'     => 'd3modprofile'
                )
            )
        );
        $oModelMock->expects($this->exactly(3))->method('getExampleJobItem1PassInsertFields')->willReturn(true);
        $oModelMock->expects($this->exactly(3))->method('getExampleJobItem2PassInsertFields')->willReturn(true);
        $oModelMock->expects($this->exactly(3))->method('getExampleJobItem3PassInsertFields')->willReturn(true);
        $oModelMock->expects($this->exactly(9))->method('_add2ShopRelation')->willReturn(true);
        $oModelMock->expects($this->atLeastOnce())->method('getShopListByActiveModule')->willReturn(
            array(
                1 => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class),
                2 => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class),
                3 => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class),
            ));

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
            ->setMethods([
                'getExampleJobInsertList',
                'getExampleJobItem1FailedInsertFields',
                'getExampleJobItem2FailedInsertFields',
                'getExampleJobItem3FailedInsertFields',
                '_add2ShopRelation',
                'getShopListByActiveModule'
            ])
            ->getMock();
        $oModelMock->method('getExampleJobInsertList')->willReturn(
            array(
                array(
                    'content'   => 'getExampleJobItem1FailedInsertFields',
                    'table'     => 'd3modprofile'
                ),
                array(
                    'content'   => 'getExampleJobItem2FailedInsertFields',
                    'table'     => 'd3modprofile'
                ),
                array(
                    'content'   => 'getExampleJobItem3FailedInsertFields',
                    'table'     => 'd3modprofile'
                )
            )
        );
        $oModelMock->expects($this->exactly(3))->method('getExampleJobItem1FailedInsertFields')->willReturn(true);
        $oModelMock->expects($this->exactly(3))->method('getExampleJobItem2FailedInsertFields')->willReturn(true);
        $oModelMock->expects($this->never())->method('getExampleJobItem3FailedInsertFields')->willReturn(true);
        $oModelMock->expects($this->exactly(6))->method('_add2ShopRelation')->will(
            $this->onConsecutiveCalls(
                true, true, true,
                true, false, false,
                true, true, true)
        );
        $oModelMock->expects($this->atLeastOnce())->method('getShopListByActiveModule')->willReturn(
            array(
                1 => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class),
                2 => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class),
                3 => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class),
            ));

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

        $this->assertInternalType('array', $aList);
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

        $this->assertInternalType('array', $aList);
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
     * @test
     * @throws ReflectionException
     */
    public function canGetExampleJobItemXInsertFields()
    {
        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->setMethods(['getId'])
            ->getMock();
        $oShopMock->method('getId')->willReturn('shopId');
        
        /** @var d3bitmask|MockObject $oD3BitMock */
        $oD3BitMock = $this->getMockBuilder(d3bitmask::class)
            ->setMethods(['getIntByBitPosition'])
            ->getMock();
        $oD3BitMock->method('getIntByBitPosition')->willReturn(1);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'getD3BitMask',
                '_getLangAbbrFieldName'
            ])
            ->getMock();
        $oModelMock->method('getD3BitMask')->willReturn($oD3BitMock);
        $oModelMock->method('_getLangAbbrFieldName')->willReturn('fieldName');

        $this->_oModel = $oModelMock;
        
        foreach ($this->_oModel->getExampleJobInsertList() as $aJobContentInfos) {
            $aFieldList = $this->callMethod(
                $this->_oModel,
                $aJobContentInfos['content'],
                array($oShopMock)
            );

            $this->assertInternalType('array', $aFieldList);
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
            ->setMethods(['getId'])
            ->getMock();
        $oShopMock->method('getId')->willReturn('shopId');

        /** @var d3bitmask|MockObject $oD3BitMock */
        $oD3BitMock = $this->getMockBuilder(d3bitmask::class)
            ->setMethods(['getIntByBitPosition'])
            ->getMock();
        $oD3BitMock->method('getIntByBitPosition')->willReturn(1);

        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'getD3BitMask',
                '_getLangAbbrFieldName'
            ])
            ->getMock();
        $oModelMock->method('getD3BitMask')->willReturn($oD3BitMock);
        $oModelMock->method('_getLangAbbrFieldName')->willReturn('fieldName');

        $this->_oModel = $oModelMock;

        foreach ($this->_oModel->getExampleContentInsertList() as $aContentInfos) {
            $aFieldList = $this->callMethod(
                $this->_oModel,
                $aContentInfos['content'],
                array($oShopMock)
            );

            $this->assertInternalType('array', $aFieldList);
            $this->assertTrue((bool) count($aFieldList));
        }
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::_addExampleJobItem
     * @test
     * @throws ReflectionException
     */
    public function canAddExampleJobItemNoStepByStep()
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'getShopListByActiveModule',
                'jobFieldMethodName',
                'setInitialExecMethod',
            '_updateTableItem2',
            'getStepByStepMode'])
            ->getMock();
        $oModelMock->method('getShopListByActiveModule')->willReturn(array(1, 2));
        $oModelMock->method('jobFieldMethodName')->willReturn(true);
        $oModelMock->method('setInitialExecMethod')->willReturn(true);
        $oModelMock->expects($this->exactly(2))->method('_updateTableItem2')->willReturn('returnValue');
        $oModelMock->method('getStepByStepMode')->willReturn(false);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            'returnValue',
            $this->callMethod(
                $this->_oModel,
                '_addExampleJobItem',
                array('tableName', 'jobFieldMethodName')
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
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::_addExampleJobItem
     * @test
     * @throws ReflectionException
     */
    public function canAddExampleJobItemStepByStep()
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'getShopListByActiveModule',
                'jobFieldMethodName',
                'setInitialExecMethod',
            '_updateTableItem2',
            'getStepByStepMode'])
            ->getMock();
        $oModelMock->method('getShopListByActiveModule')->willReturn(array(1, 2));
        $oModelMock->method('jobFieldMethodName')->willReturn(true);
        $oModelMock->method('setInitialExecMethod')->willReturn(true);
        $oModelMock->expects($this->once())->method('_updateTableItem2')->willReturn('returnValue');
        $oModelMock->method('getStepByStepMode')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            'returnValue',
            $this->callMethod(
                $this->_oModel,
                '_addExampleJobItem',
                array('tableName', 'jobFieldMethodName')
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::hasNotOrderArticlesParentId
     * @test
     * @throws DBALException
     * @throws ReflectionException
     */
    public function checkHasNotOrderArticlesParentId()
    {
        /** @var PDOStatement|MockObject $oStmtMock */
        $oStmtMock = $this->getMockBuilder(PDOStatement::class)
            ->setMethods(['fetchColumn'])
            ->disableOriginalConstructor()
            ->getMock();
        $oStmtMock->expects($this->once())->method('fetchColumn')->willReturn(1);

        /** @var QueryBuilder|MockObject $oQBMock */
        $oQBMock = $this->getMockBuilder(QueryBuilder::class)
            ->setMethods(['execute'])
            ->setConstructorArgs([d3database::getInstance()->getConnection()])
            ->getMock();
        $oQBMock->method('execute')->willReturn($oStmtMock);

        /** @var d3database|MockObject $od3databaseMock */
        $od3databaseMock = $this->getMockBuilder(d3database::class)
            ->setMethods(['getQueryBuilder'])
            ->getMock();
        $od3databaseMock->expects($this->once())->method('getQueryBuilder')->willReturn($oQBMock);

        d3GetModCfgDIC()->set('d3.ordermanager.database', $od3databaseMock);

        $this->assertTrue(
            $this->callMethod(
                $this->_oModel,
                'hasNotOrderArticlesParentId'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::addOrderArticlesParentId
     * @test
     * @throws ReflectionException
     */
    public function canAddOrderArticlesParentId()
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods(['_tableSqlExecute'])
            ->getMock();
        $oModelMock->expects($this->once())->method('_tableSqlExecute')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'addOrderArticlesParentId'
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::hasUnregisteredFiles
     * @test
     * @throws ReflectionException
     */
    public function canCheckHasUnregisteredFiles()
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods(['_hasUnregisteredFiles'])
            ->getMock();
        $oModelMock->expects($this->once())->method('_hasUnregisteredFiles')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'hasUnregisteredFiles'
        );
    }

    /**
     * @covers \D3\Ordermanager\Setup\d3ordermanager_update::showUnregisteredFiles
     * @test
     * @throws ReflectionException
     */
    public function canShowUnregisteredFiles()
    {
        /** @var d3ordermanager_update|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods(['_showUnregisteredFiles'])
            ->getMock();
        $oModelMock->expects($this->once())->method('_showUnregisteredFiles')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'showUnregisteredFiles'
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