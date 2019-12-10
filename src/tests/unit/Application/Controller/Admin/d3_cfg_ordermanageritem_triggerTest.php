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

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_trigger;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use PHPUnit_Framework_MockObject_MockObject;
use ReflectionException;
use stdClass;

class d3_cfg_ordermanageritem_triggerTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_cfg_ordermanageritem_trigger */
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

        $this->_oController = d3GetModCfgDIC()->get(d3_cfg_ordermanageritem_trigger::class);
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
    public function renderPass()
    {
        $this->assertContains(
            '.tpl',
            $this->callMethod($this->_oController, 'render')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function changeDefaultValuesPostPass()
    {
        $_POST = [
            'editval' => ['d3modprofile__d3_cronjobid' => 'foo'],
        ];

        /** @var d3_cfg_ordermanageritem_trigger|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_trigger::class, array(
            'fixCronjobId'
        ));
        $oControllerMock->method('fixCronjobId')->willReturn('newCjId');

        $this->_oController = $oControllerMock;

        $this->assertSame(
            array('foo' => 'bar'),
            $this->callMethod($this->_oController, 'addDefaultValues', array(array('foo' => 'bar')))
        );

        $this->assertEquals('newCjId', $_POST['editval']['d3modprofile__d3_cronjobid']);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function changeDefaultValuesGetPass()
    {
        $_GET = [
            'editval' => ['d3modprofile__d3_cronjobid' => 'foo'],
        ];

        /** @var d3_cfg_ordermanageritem_trigger|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_trigger::class, array(
            'fixCronjobId'
        ));
        $oControllerMock->method('fixCronjobId')->willReturn('newCjId');

        $this->_oController = $oControllerMock;

        $this->assertSame(
            array('foo' => 'bar'),
            $this->callMethod($this->_oController, 'addDefaultValues', array(array('foo' => 'bar')))
        );

        $this->assertEquals('newCjId', $_GET['editval']['d3modprofile__d3_cronjobid']);
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function fixCronJobIdPass()
    {
        $this->assertEquals(
            'test_Id',
            $this->callMethod(
                $this->_oController,
                'fixCronjobId',
                array('test Id')
            )
        );
        $this->assertEquals(
            'test-Id',
            $this->callMethod(
                $this->_oController,
                'fixCronjobId',
                array('test-Id')
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function triggersAreAllowedPass()
    {
        /** @var PHPUnit_Framework_MockObject_MockObject|d3_cfg_mod $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'isDemo'
        ));
        $oModCfgMock->method('isDemo')->willReturn(true);

        /** @var PHPUnit_Framework_MockObject_MockObject|d3ordermanager $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'd3getModCfg',
        ));
        $oManagerMock->expects($this->any())->method('d3getModCfg')->willReturn($oModCfgMock);

        /** @var d3_cfg_ordermanageritem_trigger|PHPUnit_Framework_MockObject_MockObject $oActionMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_trigger::class, array(
            'getManager',
        ), array($oManagerMock));
        $oControllerMock->method('getManager')->willReturn($oManagerMock);

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                'triggersAreAllowed'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function scriptsAreAllowedPass()
    {
        /** @var PHPUnit_Framework_MockObject_MockObject|d3_cfg_mod $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'isDemo'
        ));
        $oModCfgMock->method('isDemo')->willReturn(true);

        /** @var PHPUnit_Framework_MockObject_MockObject|d3ordermanager $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'd3getModCfg',
        ));
        $oManagerMock->expects($this->any())->method('d3getModCfg')->willReturn($oModCfgMock);

        /** @var d3_cfg_ordermanageritem_trigger|PHPUnit_Framework_MockObject_MockObject $oActionMock */
        $oControllerMock = $this->getMock(d3_cfg_ordermanageritem_trigger::class, array(
            'getManager',
        ), array($oManagerMock));
        $oControllerMock->method('getManager')->willReturn($oManagerMock);

        $this->_oController = $oControllerMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oController,
                'scriptsAreAllowed'
            )
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