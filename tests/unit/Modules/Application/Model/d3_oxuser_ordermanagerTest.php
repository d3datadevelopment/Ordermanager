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

namespace D3\Ordermanager\tests\unit\Modules\Application\Model;

use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Modules\Application\Model\d3_oxuser_ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use Generator;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Model\ListModel;
use ReflectionException;

/**
 * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxuser_ordermanager
 */
class d3_oxuser_ordermanagerTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_oxuser_ordermanager */
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

        $this->_oModel = d3GetOxidDIC()->get('d3ox.ordermanager.'.User::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->_oModel);
    }

    /**
     * @param $propertyName
     * @param $expected
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxuser_ordermanager::__get
     * @test
     * @throws ReflectionException
     * @dataProvider __getPassDataProvider
     */
    public function __getPass($propertyName, $expected)
    {
        $this->_oModel->testProperty = $expected;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oModel,
                '__get',
                [$propertyName]
            )
        );
    }

    /**
     * @return Generator
     */
    public function __getPassDataProvider(): Generator
    {
        yield 'set property'  => ['testProperty', 'testValue'];
        yield 'unset property'  => ['testUnsetProperty', null];
    }

    /**
     * @param $propertyName
     * @param $expected
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxuser_ordermanager::__get
     * @test
     * @throws ReflectionException
     */
    public function __getPassParent()
    {
        $this->assertInstanceOf(
            ListModel::class,
            $this->callMethod(
                $this->_oModel,
                '__get',
                ['oGroups']
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
