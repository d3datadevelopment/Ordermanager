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

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_trigger;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_conf;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use Generator;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;
use stdClass;

/**
 * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_trigger
 */
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
    public function setUp(): void
    {
        parent::setUp();

        $this->_oController = d3GetOxidDIC()->get(d3_cfg_ordermanageritem_trigger::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->_oController);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_trigger::render
     * @test
     * @throws ReflectionException
     */
    public function renderPass()
    {
        $this->assertStringContainsStringIgnoringCase(
            '@d3ordermanager/admin/d3_cfg_ordermanageritem_trigger',
            $this->callMethod($this->_oController, 'render')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_trigger::addDefaultValues
     * @test
     * @throws ReflectionException
     */
    public function changeDefaultValuesPostPass()
    {
        $_POST = [
            'editval' => ['d3modprofile__d3_cronjobid' => 'foo'],
        ];

        /** @var d3_cfg_ordermanageritem_trigger|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_trigger::class)
            ->onlyMethods(['fixCronjobId'])
            ->getMock();
        $oControllerMock->method('fixCronjobId')->willReturn('newCjId');

        $this->_oController = $oControllerMock;

        $this->assertSame(
            ['foo' => 'bar'],
            $this->callMethod($this->_oController, 'addDefaultValues', [['foo' => 'bar']])
        );

        $this->assertEquals('newCjId', $_POST['editval']['d3modprofile__d3_cronjobid']);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_trigger::addDefaultValues
     * @test
     * @throws ReflectionException
     */
    public function changeDefaultValuesGetPass()
    {
        $_GET = [
            'editval' => ['d3modprofile__d3_cronjobid' => 'foo'],
        ];

        /** @var d3_cfg_ordermanageritem_trigger|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_trigger::class)
            ->onlyMethods(['fixCronjobId'])
            ->getMock();
        $oControllerMock->method('fixCronjobId')->willReturn('newCjId');

        $this->_oController = $oControllerMock;

        $this->assertSame(
            ['foo' => 'bar'],
            $this->callMethod($this->_oController, 'addDefaultValues', [['foo' => 'bar']])
        );

        $this->assertEquals('newCjId', $_GET['editval']['d3modprofile__d3_cronjobid']);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_trigger::fixCronjobId
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
                ['test Id']
            )
        );
        $this->assertEquals(
            'test-Id',
            $this->callMethod(
                $this->_oController,
                'fixCronjobId',
                ['test-Id']
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_trigger::triggersAreAllowed
     * @test
     * @throws ReflectionException
     * @dataProvider triggersAreAllowedPassDataProvider
     */
    public function triggersAreAllowedPass($isDemo, $expected)
    {
        /** @var MockObject|d3_cfg_mod $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['isDemo', 'getLicenseConfigData'])
            ->getMock();
        $oModCfgMock->method('isDemo')->willReturn($isDemo);
        $oModCfgMock->method('getLicenseConfigData')->willReturn((int) $expected);

        /** @var MockObject|d3ordermanager $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->getMock();

        /** @var d3_cfg_ordermanageritem_trigger|MockObject $oActionMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_trigger::class)
            ->onlyMethods(['d3GetSet'])
            ->setConstructorArgs([$oManagerMock])
            ->getMock();
        $oControllerMock->method('d3GetSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oController,
                'triggersAreAllowed'
            )
        );
    }

    public function triggersAreAllowedPassDataProvider(): Generator
    {
        yield 'is demo' => [true, true];
        yield 'no demo, no standard' => [false, false];
        yield 'no demo, standard' => [false, true];
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_trigger::scriptsAreAllowed
     * @test
     * @throws ReflectionException
     * @dataProvider scriptsAreAllowedPassDataProvider
     */
    public function scriptsAreAllowedPass($isDemo, $expected)
    {
        /** @var MockObject|d3_cfg_mod $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->addMethods(['isDemo', 'getLicenseConfigData'])
            ->getMock();
        $oModCfgMock->method('isDemo')->willReturn($isDemo);
        $oModCfgMock->method('getLicenseConfigData')->willReturn((int) $expected);

        /** @var MockObject|d3ordermanager $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->getMock();

        /** @var d3_cfg_ordermanageritem_trigger|MockObject $oActionMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_trigger::class)
            ->onlyMethods(['d3GetSet'])
            ->setConstructorArgs([$oManagerMock])
            ->getMock();
        $oControllerMock->method('d3GetSet')->willReturn($oModCfgMock);

        $this->_oController = $oControllerMock;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oController,
                'scriptsAreAllowed'
            )
        );
    }

    public function scriptsAreAllowedPassDataProvider(): Generator
    {
        yield 'is demo' => [true, true];
        yield 'no demo, no premium' => [false, false];
        yield 'no demo, premium' => [false, true];
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
