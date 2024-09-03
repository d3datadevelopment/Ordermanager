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

use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_main;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;

/**
 * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_main
 */
class d3_cfg_ordermanageritem_mainTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_cfg_ordermanageritem_main */
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

        $this->_oController = d3GetOxidDIC()->get(d3_cfg_ordermanageritem_main::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->_oController);
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_main::render
     * @test
     * @throws ReflectionException
     */
    public function renderPass()
    {
        $this->assertSame(
            '@d3ordermanager/admin/d3_cfg_ordermanageritem_main',
            $this->callMethod($this->_oController, 'render')
        );
    }

    /**
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_main::addDefaultValues
     * @test
     * @throws ReflectionException
     */
    public function changeDefaultValuesPostPass()
    {
        $_POST = [
            'editval' => ['d3modprofile__d3_cronjobid' => 'foo'],
        ];

        /** @var d3_cfg_ordermanageritem_main|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_main::class)
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_main::addDefaultValues
     * @test
     * @throws ReflectionException
     */
    public function changeDefaultValuesGetPass()
    {
        $_GET = [
            'editval' => ['d3modprofile__d3_cronjobid' => 'foo'],
        ];

        /** @var d3_cfg_ordermanageritem_main|MockObject $oControllerMock */
        $oControllerMock = $this->getMockBuilder(d3_cfg_ordermanageritem_main::class)
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
     * @covers \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_main::fixCronjobId
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
     * @param $sLicenseKey
     * @param d3ordermanager $oManager
     * @return null
     */
    protected function _setModuleLicenseKey($sLicenseKey, $oManager = null)
    {
        return null;
    }
}
