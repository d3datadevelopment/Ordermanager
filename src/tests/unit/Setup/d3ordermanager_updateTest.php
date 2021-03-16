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

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\d3bitmask;
use D3\ModCfg\Application\Model\d3database;
use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Model\Installwizzard\d3installdbrecord;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Setup\d3ordermanager_update;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\PDOException;
use OxidEsales\Eshop\Application\Model\Shop;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use PHPUnit_Framework_MockObject_MockObject;
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
     * @test
     * @throws ReflectionException
     */
    public function canCheckOrderManagerTableExist()
    {
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            '_checkTableNotExist',
        ));
        $oModelMock->expects($this->once())->method('_checkTableNotExist')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'checkOrderManagerTableExist'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canStartConvertOrderManagerItemsExecuteNoException()
    {
        /** @var DatabaseInterface|PHPUnit_Framework_MockObject_MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMock(stdClass::class, array(
            'Execute',
        ));
        $oDBInterfaceMock->expects($this->once())->method('Execute')->willReturn(true);
        
        /** @var d3database|PHPUnit_Framework_MockObject_MockObject $oDatabaseMock */
        $oDatabaseMock = $this->getMock(d3database::class, array(
            'getDataConvertQuery',
        ));
        $oDatabaseMock->method('getDataConvertQuery')->willReturn(array('SELECT 1;', 'SELECT 2;'));

        
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
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
            'setErrorMessage',
        ));
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
     * @test
     * @throws ReflectionException
     */
    public function canStartConvertOrderManagerItemsNoExecute()
    {
        /** @var DatabaseInterface|PHPUnit_Framework_MockObject_MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMock(stdClass::class, array(
            'Execute',
        ));
        $oDBInterfaceMock->expects($this->never())->method('Execute')->willReturn(true);

        /** @var d3database|PHPUnit_Framework_MockObject_MockObject $oDatabaseMock */
        $oDatabaseMock = $this->getMock(d3database::class, array(
            'getDataConvertQuery',
        ));
        $oDatabaseMock->method('getDataConvertQuery')->willReturn(array('SELECT 1;', 'SELECT 2;'));


        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
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
            'setErrorMessage',
        ));
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
     * @test
     * @throws ReflectionException
     */
    public function canNotStartConvertOrderManagerItems()
    {
        /** @var DatabaseInterface|PHPUnit_Framework_MockObject_MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMock(stdClass::class, array(
            'Execute',
        ));
        $oDBInterfaceMock->expects($this->never())->method('Execute')->willReturn(true);

        /** @var d3database|PHPUnit_Framework_MockObject_MockObject $oDatabaseMock */
        $oDatabaseMock = $this->getMock(d3database::class, array(
            'getDataConvertQuery',
        ));
        $oDatabaseMock->method('getDataConvertQuery')->willReturn(array('SELECT 1;', 'SELECT 2;'));


        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
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
            'setErrorMessage',
        ));
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
     * @test
     * @throws ReflectionException
     */
    public function canStartConvertOrderManagerItemsExecuteException()
    {
        /** @var DatabaseInterface|PHPUnit_Framework_MockObject_MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMock(stdClass::class, array(
            'Execute',
        ));
        $oDBInterfaceMock->expects($this->once())->method('Execute')->willReturnCallback(array($this, 'dbInterfaceExecuteThrowException'));

        /** @var d3database|PHPUnit_Framework_MockObject_MockObject $oDatabaseMock */
        $oDatabaseMock = $this->getMock(d3database::class, array(
            'getDataConvertQuery',
        ));
        $oDatabaseMock->method('getDataConvertQuery')->willReturn(array('SELECT 1;', 'SELECT 2;'));

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
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
            'setErrorMessage',
        ));
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
        $pdoExceptionMock = $this->getMockBuilder(PDOException::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pdoExceptionMock->errorInfo = array(
            1   => 'errorInfoNo1',
            2   => 'errorInfoNo1',
        );

        /** @var PDOException $pdoExc */
        $pdoExc = oxNew(PDOException::class, $pdoExceptionMock);

        throw $pdoExc;
    }

    /**
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
     * @test
     * @throws ReflectionException
     */
    public function canChangeItemContentExecuteNoException()
    {
        $iLangCount = 2;

        /** @var DatabaseInterface|PHPUnit_Framework_MockObject_MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMock(stdClass::class, array(
            'getAll',
            'Execute',
        ));
        $oDBInterfaceMock->expects($this->exactly($iLangCount))->method('getAll')->willReturn(
            array('field1' => array(
                'value' => 'YSUzQTIlM0ElN0JzJTNBNCUzQSUyMmtleTElMjIlM0JzJTNBNiUzQSUyMnZhbHVlMSUyMiUzQnMlM0E0JTNBJTIya2V5MiUyMiUzQnMlM0E2JTNBJTIydmFsdWUyJTIyJTNCJTdE')
                // array(
                //    'key1'    => 'value1',
                //    'key2'    => 'value2',
                //)
            )
        );
        $oDBInterfaceMock->expects($this->exactly($iLangCount))->method('Execute')->willReturn(true);

        /** @var d3database|PHPUnit_Framework_MockObject_MockObject $oDatabaseMock */
        $oDatabaseMock = $this->getMock(d3database::class, array(
            'checkFieldExist',
        ));
        $oDatabaseMock->method('checkFieldExist')->willReturn(true);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getMaxLanguages',
            '_addMultiLangAddOn',
            '_getDatabaseHandler',
            'getDb',
            'hasExecute',
            'setUpdateBreak',
            'setActionLog',
            'setErrorMessage',
        ));
        $oModelMock->method('getMaxLanguages')->willReturn($iLangCount);
        $oModelMock->method('_addMultiLangAddOn')->willReturn(true);
        $oModelMock->method('_getDatabaseHandler')->willReturn($oDatabaseMock);
        $oModelMock->method('getDb')->willReturn($oDBInterfaceMock);
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
     * @test
     * @throws ReflectionException
     */
    public function canChangeItemContentExecuteException()
    {
        $iLangCount = 2;

        /** @var DatabaseInterface|PHPUnit_Framework_MockObject_MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMock(stdClass::class, array(
            'getAll',
            'Execute',
        ));
        $oDBInterfaceMock->expects($this->exactly($iLangCount))->method('getAll')->willReturn(
            array('field1' => array(
                'value' => 'YSUzQTIlM0ElN0JzJTNBNCUzQSUyMmtleTElMjIlM0JzJTNBNiUzQSUyMnZhbHVlMSUyMiUzQnMlM0E0JTNBJTIya2V5MiUyMiUzQnMlM0E2JTNBJTIydmFsdWUyJTIyJTNCJTdE')
                // array(
                //    'key1'    => 'value1',
                //    'key2'    => 'value2',
                //)
            )
        );
        $oDBInterfaceMock->expects($this->exactly($iLangCount))->method('Execute')->willReturnCallback(array($this, 'dbInterfaceExecuteThrowException'));

        /** @var d3database|PHPUnit_Framework_MockObject_MockObject $oDatabaseMock */
        $oDatabaseMock = $this->getMock(d3database::class, array(
            'checkFieldExist',
        ));
        $oDatabaseMock->method('checkFieldExist')->willReturn(true);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getMaxLanguages',
            '_addMultiLangAddOn',
            '_getDatabaseHandler',
            'getDb',
            'hasExecute',
            'setUpdateBreak',
            'setActionLog',
            'setErrorMessage',
        ));
        $oModelMock->method('getMaxLanguages')->willReturn($iLangCount);
        $oModelMock->method('_addMultiLangAddOn')->willReturn(true);
        $oModelMock->method('_getDatabaseHandler')->willReturn($oDatabaseMock);
        $oModelMock->method('getDb')->willReturn($oDBInterfaceMock);
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
     * @test
     * @throws ReflectionException
     */
    public function canChangeItemContentNoExecute()
    {
        $iLangCount = 2;

        /** @var DatabaseInterface|PHPUnit_Framework_MockObject_MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMock(stdClass::class, array(
            'getAll',
            'Execute',
        ));
        $oDBInterfaceMock->expects($this->exactly($iLangCount))->method('getAll')->willReturn(
            array('field1' => array(
                'value' => 'YSUzQTIlM0ElN0JzJTNBNCUzQSUyMmtleTElMjIlM0JzJTNBNiUzQSUyMnZhbHVlMSUyMiUzQnMlM0E0JTNBJTIya2V5MiUyMiUzQnMlM0E2JTNBJTIydmFsdWUyJTIyJTNCJTdE')
                // array(
                //    'key1'    => 'value1',
                //    'key2'    => 'value2',
                //)
            )
        );
        $oDBInterfaceMock->expects($this->never())->method('Execute')->willReturn(true);

        /** @var d3database|PHPUnit_Framework_MockObject_MockObject $oDatabaseMock */
        $oDatabaseMock = $this->getMock(d3database::class, array(
            'checkFieldExist',
        ));
        $oDatabaseMock->method('checkFieldExist')->willReturn(true);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getMaxLanguages',
            '_addMultiLangAddOn',
            '_getDatabaseHandler',
            'getDb',
            'hasExecute',
            'setUpdateBreak',
            'setActionLog',
            'setErrorMessage',
        ));
        $oModelMock->method('getMaxLanguages')->willReturn($iLangCount);
        $oModelMock->method('_addMultiLangAddOn')->willReturn(true);
        $oModelMock->method('_getDatabaseHandler')->willReturn($oDatabaseMock);
        $oModelMock->method('getDb')->willReturn($oDBInterfaceMock);
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
     * @test
     * @throws ReflectionException
     */
    public function canChangeItemContentFieldNotExist()
    {
        $iLangCount = 2;

        /** @var DatabaseInterface|PHPUnit_Framework_MockObject_MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMock(stdClass::class, array(
            'getAll',
            'Execute',
        ));
        $oDBInterfaceMock->expects($this->never())->method('getAll')->willReturn(
            array('field1' => array(
                'value' => 'YSUzQTIlM0ElN0JzJTNBNCUzQSUyMmtleTElMjIlM0JzJTNBNiUzQSUyMnZhbHVlMSUyMiUzQnMlM0E0JTNBJTIya2V5MiUyMiUzQnMlM0E2JTNBJTIydmFsdWUyJTIyJTNCJTdE')
                // array(
                //    'key1'    => 'value1',
                //    'key2'    => 'value2',
                //)
            )
        );
        $oDBInterfaceMock->expects($this->never())->method('Execute')->willReturn(true);

        /** @var d3database|PHPUnit_Framework_MockObject_MockObject $oDatabaseMock */
        $oDatabaseMock = $this->getMock(d3database::class, array(
            'checkFieldExist',
        ));
        $oDatabaseMock->method('checkFieldExist')->willReturn(false);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getMaxLanguages',
            '_addMultiLangAddOn',
            '_getDatabaseHandler',
            'getDb',
            'hasExecute',
            'setUpdateBreak',
            'setActionLog',
            'setErrorMessage',
        ));
        $oModelMock->method('getMaxLanguages')->willReturn($iLangCount);
        $oModelMock->method('_addMultiLangAddOn')->willReturn(true);
        $oModelMock->method('_getDatabaseHandler')->willReturn($oDatabaseMock);
        $oModelMock->method('getDb')->willReturn($oDBInterfaceMock);
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
     * @test
     * @throws ReflectionException
     */
    public function canCheckOrder2OrderManagerTableNotExist()
    {
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            '_checkTableNotExist',
        ));
        $oModelMock->expects($this->once())->method('_checkTableNotExist')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'doesOrder2OrderManagerTableNotExist'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canAddOrder2OrderManagerTable()
    {
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'doesOrder2OrderManagerTableNotExist',
            '_addTable2',
        ));
        $oModelMock->method('doesOrder2OrderManagerTableNotExist')->willReturn(true);
        $oModelMock->expects($this->once())->method('_addTable2')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'addOrder2OrderManagerTable'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canNotAddExistingOrder2OrderManagerTable()
    {
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'doesOrder2OrderManagerTableNotExist',
            '_addTable2',
        ));
        $oModelMock->method('doesOrder2OrderManagerTableNotExist')->willReturn(false);
        $oModelMock->expects($this->never())->method('_addTable2')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'addOrder2OrderManagerTable'
        );
    }

    /**
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
     * @test
     * @throws ReflectionException
     */
    public function canCheckDoesModCfgItemNotExistPositive()
    {
        /** @var d3installdbrecord|PHPUnit_Framework_MockObject_MockObject $oInstallDbRecordMock */
        $oInstallDbRecordMock = $this->getMock(d3installdbrecord::class, array(
            'checkTableRecordNotExist',
        ), array($this->_oModel));
        $oInstallDbRecordMock->expects($this->once())->method('checkTableRecordNotExist')->willReturn(true);
        
        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getShopIds',
        ));
        $oConfigMock->method('getShopIds')->willReturn(array(1, 2));
        
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'd3GetConfig',
            'd3GetInstallDbRecord',
        ));
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
     * @test
     * @throws ReflectionException
     */
    public function canCheckDoesModCfgItemNotExistNegative()
    {
        /** @var d3installdbrecord|PHPUnit_Framework_MockObject_MockObject $oInstallDbRecordMock */
        $oInstallDbRecordMock = $this->getMock(d3installdbrecord::class, array(
            'checkTableRecordNotExist',
        ), array($this->_oModel));
        $oInstallDbRecordMock->expects($this->exactly(2))->method('checkTableRecordNotExist')->willReturn(false);

        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getShopIds',
        ));
        $oConfigMock->method('getShopIds')->willReturn(array(1, 2));

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'd3GetConfig',
            'd3GetInstallDbRecord',
        ));
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
     * @test
     * @throws ReflectionException
     */
    public function canAddModCfgItemNoStepByStep()
    {
        /** @var d3installdbrecord|PHPUnit_Framework_MockObject_MockObject $oInstallDbRecordMock */
        $oInstallDbRecordMock = $this->getMock(d3installdbrecord::class, array(
            'checkTableRecordNotExist',
        ), array($this->_oModel));
        $oInstallDbRecordMock->expects($this->exactly(2))->method('checkTableRecordNotExist')->willReturn(true);

        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getShopIds',
        ));
        $oConfigMock->method('getShopIds')->willReturn(array(1, 2));

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'doesModCfgItemNotExist',
            'd3GetConfig',
            'd3GetInstallDbRecord',
            'setInitialExecMethod',
            '_updateTableItem2',
            'getStepByStepMode',
        ));
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
     * @test
     * @throws ReflectionException
     */
    public function canAddModCfgItemStepByStep()
    {
        /** @var d3installdbrecord|PHPUnit_Framework_MockObject_MockObject $oInstallDbRecordMock */
        $oInstallDbRecordMock = $this->getMock(d3installdbrecord::class, array(
            'checkTableRecordNotExist',
        ), array($this->_oModel));
        $oInstallDbRecordMock->expects($this->exactly(1))->method('checkTableRecordNotExist')->willReturn(true);

        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getShopIds',
        ));
        $oConfigMock->method('getShopIds')->willReturn(array(1, 2));

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'doesModCfgItemNotExist',
            'd3GetConfig',
            'd3GetInstallDbRecord',
            'setInitialExecMethod',
            '_updateTableItem2',
            'getStepByStepMode',
        ));
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
     * @test
     * @throws ReflectionException
     */
    public function canNotAddExistingModCfgItem()
    {
        /** @var d3installdbrecord|PHPUnit_Framework_MockObject_MockObject $oInstallDbRecordMock */
        $oInstallDbRecordMock = $this->getMock(d3installdbrecord::class, array(
            'checkTableRecordNotExist',
        ), array($this->_oModel));
        $oInstallDbRecordMock->expects($this->never())->method('checkTableRecordNotExist')->willReturn(true);

        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getShopIds',
        ));
        $oConfigMock->method('getShopIds')->willReturn(array(1, 2));

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'doesModCfgItemNotExist',
            'd3GetConfig',
            'd3GetInstallDbRecord',
            'setInitialExecMethod',
            '_updateTableItem2',
            'getStepByStepMode',
        ));
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
     * @param $testPW
     * @param $expected
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
        $set = d3GetModCfgDIC()->get('d3.ordermanager.modcfg');
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
        $set = d3GetModCfgDIC()->get('d3.ordermanager.modcfg');
        $currPassword = $set->getValue('sCronPassword');
        $set->setValue('sCronPassword', 'otherContent');
        $set->saveNoLicenseRefresh();

        $oStrMock = $this->getMockBuilder(d3str::class)
            ->setMethods(['random_str'])
            ->getMock();
        $oStrMock->expects($this->atLeastOnce())->method('random_str')->willReturn($expectedPW);
        d3GetModCfgDIC()->set(d3str::class, $oStrMock);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'hasExecute',
                'setActionLog'
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
        $fixtureSet = d3GetModCfgDIC()->get('d3.ordermanager.modcfg');
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
        $set = d3GetModCfgDIC()->get('d3.ordermanager.modcfg');
        $currPassword = $set->getValue('sCronPassword');
        $set->setValue('sCronPassword', 'otherContent');
        $set->saveNoLicenseRefresh();

        $oStrMock = $this->getMockBuilder(d3str::class)
            ->setMethods(['random_str'])
            ->getMock();
        $oStrMock->expects($this->never())->method('random_str')->willReturn($expectedPW);
        d3GetModCfgDIC()->set(d3str::class, $oStrMock);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(d3ordermanager_update::class)
            ->setMethods([
                'hasExecute',
                'setActionLog'
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
        $fixtureSet = d3GetModCfgDIC()->get('d3.ordermanager.modcfg');
        $fixturePw = $fixtureSet->getValue('sCronPassword');

        $this->assertSame('otherContent', $fixturePw);

        $set->setValue('sCronPassword', $currPassword);
        $set->saveNoLicenseRefresh();
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function needExampleJobListPass()
    {
        /** @var DatabaseInterface|PHPUnit_Framework_MockObject_MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMock(stdClass::class, array(
            'getOne',
        ));
        $oDBInterfaceMock->expects($this->once())->method('getOne')->willReturn(0);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getDb',
        ));
        $oModelMock->method('getDb')->willReturn($oDBInterfaceMock);

        $this->_oModel = $oModelMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oModel,
                'needExampleJobList'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function needExampleJobListDontPass()
    {
        /** @var DatabaseInterface|PHPUnit_Framework_MockObject_MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMock(stdClass::class, array(
            'getOne',
        ));
        $oDBInterfaceMock->expects($this->once())->method('getOne')->willReturn(1);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getDb',
        ));
        $oModelMock->method('getDb')->willReturn($oDBInterfaceMock);

        $this->_oModel = $oModelMock;

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'needExampleJobList'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canAddExampleJobList()
    {
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getExampleJobInsertList',
            '_addExampleJobItem',
            'setUpdateBreak',
        ));
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
     * @test
     * @throws ReflectionException
     */
    public function checkIsExampleContentMissingInDatabasePositive()
    {
        /** @var DatabaseInterface|PHPUnit_Framework_MockObject_MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMock(stdClass::class, array(
            'getOne',
        ));
        $oDBInterfaceMock->expects($this->once())->method('getOne')->willReturn(1);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getExampleContentInsertList',
            'getDb',
            'getExampleJobItem1InsertFields',
        ));
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
     * @test
     * @throws ReflectionException
     */
    public function checkIsExampleContentMissingInDatabaseNegative()
    {
        /** @var DatabaseInterface|PHPUnit_Framework_MockObject_MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMock(stdClass::class, array(
            'getOne',
        ));
        $oDBInterfaceMock->expects($this->once())->method('getOne')->willReturn(0);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getExampleContentInsertList',
            'getDb',
            'getExampleJobItem1InsertFields'
        ));
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
     * @test
     * @throws ReflectionException
     */
    public function checkIsExampleContentMissingInDatabaseNegativeNoLoadId()
    {
        /** @var DatabaseInterface|PHPUnit_Framework_MockObject_MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMock(stdClass::class, array(
            'getOne',
        ));
        $oDBInterfaceMock->expects($this->never())->method('getOne')->willReturn(0);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getExampleContentInsertList',
            'getDb',
            'getExampleJobItem1InsertFields'
        ));
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
     * @test
     * @throws ReflectionException
     */
    public function canAddExampleContentList()
    {
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getExampleContentInsertList',
            '_addExampleJobItem',
            'setUpdateBreak',
        ));
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
     * @test
     * @throws ReflectionException
     */
    public function checkRequireExample2ShopRelationTrue()
    {
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'setInitialExecMethod',
            'getExampleJobInsertList',
            'getExampleJobItem1InsertFields',
            '_require2ShopRelation',
        ));
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
     * @test
     * @throws ReflectionException
     */
    public function checkRequireExample2ShopRelationFalse()
    {
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'setInitialExecMethod',
            'getExampleJobInsertList',
            'getExampleJobItem1InsertFields',
            '_require2ShopRelation',
            'getShopList',
        ));
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
        $oModelMock->method('getShopList')->willReturn(
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
     * @test
     * @throws ReflectionException
     */
    public function canAddExample2ShopRelationPass()
    {
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getExampleJobInsertList',
            'getExampleJobItem1PassInsertFields',
            'getExampleJobItem2PassInsertFields',
            'getExampleJobItem3PassInsertFields',
            '_add2ShopRelation',
            'getShopList'
        ));
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
        $oModelMock->method('getShopList')->willReturn(
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
     * @test
     * @throws ReflectionException
     */
    public function canAddExample2ShopRelationFails()
    {
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getExampleJobInsertList',
            'getExampleJobItem1FailedInsertFields',
            'getExampleJobItem2FailedInsertFields',
            'getExampleJobItem3FailedInsertFields',
            '_add2ShopRelation',
            'getShopList',
        ));
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
        $oModelMock->expects($this->never())->method('getExampleJobItem3InsertFailedFields')->willReturn(true);
        $oModelMock->expects($this->exactly(6))->method('_add2ShopRelation')->will(
            $this->onConsecutiveCalls(
                true, true, true,
                true, false, false,
                true, true, true)
        );
        $oModelMock->method('getShopList')->willReturn(
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
     * @test
     * @throws ReflectionException
     */
    public function canGetExampleJobItemXInsertFields()
    {
        /** @var Shop|PHPUnit_Framework_MockObject_MockObject $oShopMock */
        $oShopMock = $this->getMock(Shop::class, array(
            'getId',
        ));
        $oShopMock->method('getId')->willReturn('shopId');
        
        /** @var d3bitmask|PHPUnit_Framework_MockObject_MockObject $oD3BitMock */
        $oD3BitMock = $this->getMock(d3bitmask::class, array(
            'getIntByBitPosition',
        ));
        $oD3BitMock->method('getIntByBitPosition')->willReturn(1);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getD3BitMask',
            '_getLangAbbrFieldName',
        ));
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
     * @test
     * @throws ReflectionException
     */
    public function canGetExampleContentXInsertFields()
    {
        /** @var Shop|PHPUnit_Framework_MockObject_MockObject $oShopMock */
        $oShopMock = $this->getMock(Shop::class, array(
            'getId',
        ));
        $oShopMock->method('getId')->willReturn('shopId');

        /** @var d3bitmask|PHPUnit_Framework_MockObject_MockObject $oD3BitMock */
        $oD3BitMock = $this->getMock(d3bitmask::class, array(
            'getIntByBitPosition',
        ));
        $oD3BitMock->method('getIntByBitPosition')->willReturn(1);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getD3BitMask',
            '_getLangAbbrFieldName',
        ));
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
     * @test
     * @throws ReflectionException
     */
    public function canAddExampleJobItemNoStepByStep()
    {
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getShopList',
            'jobFieldMethodName',
            '_convertExampleJobItems',
            'setInitialExecMethod',
            '_updateTableItem2',
            'getStepByStepMode',
        ));
        $oModelMock->method('getShopList')->willReturn(
            array(
                1 => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class),
                2 => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class),
            ));
        $oModelMock->method('jobFieldMethodName')->willReturn(true);
        $oModelMock->method('_convertExampleJobItems')->willReturn(true);
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
     * @test
     * @throws ReflectionException
     */
    public function canAddExampleJobItemStepByStep()
    {
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getShopList',
            'jobFieldMethodName',
            '_convertExampleJobItems',
            'setInitialExecMethod',
            '_updateTableItem2',
            'getStepByStepMode',
        ));
        $oModelMock->method('getShopList')->willReturn(
            array(
                1 => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class),
                2 => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class),
            ));
        $oModelMock->method('jobFieldMethodName')->willReturn(true);
        $oModelMock->method('_convertExampleJobItems')->willReturn(true);
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
     * @test
     * @throws ReflectionException
     * @dataProvider hasNotOrderArticlesParentIdDataProvider
     */
    public function checkHasNotOrderArticlesParentId($blCheckStatus, $blExpected, $iArticleCount)
    {
        /** @var DatabaseInterface|PHPUnit_Framework_MockObject_MockObject $oDBInterfaceMock */
        $oDBInterfaceMock = $this->getMock(stdClass::class, array(
            'getOne',
        ));
        $oDBInterfaceMock->expects($this->exactly((int) $blCheckStatus))->method('getOne')->willReturn($iArticleCount);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'getDb',
            'mustCheckOrderArticlesParentId',
            'setDontCheckOrderArticlesParentId'
        ));
        $oModelMock->method('getDb')->willReturn($oDBInterfaceMock);
        $oModelMock->method('mustCheckOrderArticlesParentId')->willReturn($blCheckStatus);
        $oModelMock->expects($this->exactly(((int)!(bool) $iArticleCount)))->method('setDontCheckOrderArticlesParentId');

        $this->_oModel = $oModelMock;

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
            [false, false, 2] // later executions, mustn't check again
        ];
    }

    /**
     * @test
     * @throws ReflectionException
     * @dataProvider mustCheckOrderArticlesParentIdPassDataProvider
     */
    public function mustCheckOrderArticlesParentIdPass($blConfig, $blExpected)
    {
        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getShopConfVar',
        ));
        $oConfigMock->expects($this->once())->method('getShopConfVar')->willReturn($blConfig);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'd3GetConfig'
        ));
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
            [false, true]
        ];
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function setDontCheckOrderArticlesParentIdPass()
    {
        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'saveShopConfVar',
        ));
        $oConfigMock->expects($this->once())->method('saveShopConfVar')->willReturn(true);

        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            'd3GetConfig'
        ));
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'setDontCheckOrderArticlesParentId'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canAddOrderArticlesParentId()
    {
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            '_tableSqlExecute',
            'setDontCheckOrderArticlesParentId'
        ));
        $oModelMock->expects($this->once())->method('_tableSqlExecute')->willReturn(true);
        $oModelMock->expects($this->once())->method('setDontCheckOrderArticlesParentId')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'addOrderArticlesParentId'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canCheckHasUnregisteredFiles()
    {
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            '_hasUnregisteredFiles',
        ));
        $oModelMock->expects($this->once())->method('_hasUnregisteredFiles')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'hasUnregisteredFiles'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canShowUnregisteredFiles()
    {
        /** @var d3ordermanager_update|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(d3ordermanager_update::class, array(
            '_showUnregisteredFiles',
        ));
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
