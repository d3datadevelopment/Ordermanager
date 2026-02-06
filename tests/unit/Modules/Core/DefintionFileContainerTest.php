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

namespace D3\Ordermanager\tests\unit\Modules\Core;

use D3\DIContainerHandler\definitionFileContainer;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Modules\Core\DefinitionFileContainer_ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use ReflectionException;

/**
 * @coversNothing
 */
class DefintionFileContainerTest extends d3OrdermanagerUnitTestCase
{
    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @covers \D3\Ordermanager\Modules\Core\DefinitionFileContainer_ordermanager::__construct
     */
    public function constructTest(): void
    {
        $parameterAsserted = false;

        $sut = $this->getMockBuilder(DefinitionFileContainer_ordermanager::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['addYamlDefinitions'])
            ->getMock();
        $sut->expects($this->atLeast(2))->method('addYamlDefinitions')
            ->with(self::callback(
                function ($parameter) use (&$parameterAsserted) {
                    if (stristr($parameter, '/ordermanager/')) {
                        $parameterAsserted = true;
                    }
                    return true;
                }
            ));

        $this->callMethod($sut, '__construct');

        $this->assertTrue($parameterAsserted, 'no invocation with ordermanager argument found');
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
