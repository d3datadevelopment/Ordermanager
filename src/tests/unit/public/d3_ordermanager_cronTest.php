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

use D3\Ordermanager\Application\Controller\d3ordermanager_response;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Session;
use splitbrain\phpcli\Exception as Exception;
use splitbrain\phpcli\Options;

class d3_ordermanager_cronTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_ordermanager_cron */
    protected $_oController;

    /**
     * setup basic requirements
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function setUp()
    {
        parent::setUp();

        $count = 0;
        $filePath = '../../../source/modules/d3/ordermanager/public/d3_ordermanager_cron.php';
        $currentDirectory = __DIR__ . '/';
        while ($count < 5) {
            $count++;
            if (file_exists($currentDirectory . $filePath)) {
                $filePath = $currentDirectory . $filePath;
                break;
            }
            $filePath = '../' . $filePath;
        }

        require_once($filePath);

        $this->_oController = oxNew(d3_ordermanager_cron::class);
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
    public function canSetup()
    {
        /** @var Options|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oOptionsMock = $this->getMock(Options::class, array(
            'registerOption',
            'registerCommand',
            'registerArgument',
        ));
        $oOptionsMock->expects($this->exactly(3))->method('registerOption')->willReturn(true);
        $oOptionsMock->expects($this->exactly(2))->method('registerCommand')->willReturn(true);
        $oOptionsMock->expects($this->exactly(3))->method('registerArgument')->willReturn(true);

        $this->callMethod(
            $this->_oController,
            'setup',
            array(
                $oOptionsMock
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canParseOptions()
    {
        /** @var Options|PHPUnit_Framework_MockObject_MockObject $oOptionsMock */
        $oOptionsMock = $this->getMock(Options::class, array(
            'registerOption'
        ),
            array($this->getValue($this->_oController, 'colors'))
        );
        $oOptionsMock->expects($this->atLeast(3))->method('registerOption');

        $this->setValue(
            $oOptionsMock,
            'args',
            array()
        );
        $oOptionsMock->parseOptions();

        $this->setValue($this->_oController, 'options', $oOptionsMock);

        $this->callMethod(
            $this->_oController,
            'parseOptions'
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function mainShowVersion()
    {
        /** @var Options|PHPUnit_Framework_MockObject_MockObject $oOptionsMock */
        $oOptionsMock = $this->getMock(Options::class, array(
            'getOpt',
            'getCmd'
        ),
            array($this->getValue($this->_oController, 'colors'))
        );
        $oOptionsMock->method('getOpt')->will($this->returnCallback(
            function($param) {
                return $param == 'version';
            }
        ));
        $oOptionsMock->expects($this->never())->method('getCmd')->willReturn(false);

        $this->setValue(
            $oOptionsMock,
            'args',
            array()
        );
        $oOptionsMock->parseOptions();

        /** @var d3_ordermanager_cron|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_cron::class, array(
            'info',
        ));
        $oControllerMock->expects($this->once())->method('info')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'main',
            array($oOptionsMock)
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function mainUseQuietCmdDefaultNoCJID()
    {
        /** @var Options|PHPUnit_Framework_MockObject_MockObject $oOptionsMock */
        $oOptionsMock = $this->getMock(Options::class, array(
            'getOpt',
            'getCmd'
        ),
            array($this->getValue($this->_oController, 'colors'))
        );
        $oOptionsMock->method('getOpt')->will($this->returnCallback(
            function($param) {
                return $param == 'quiet';
            }
        ));
        $oOptionsMock->method('getCmd')->willReturn(false);

        $this->setValue(
            $oOptionsMock,
            'args',
            array()
        );
        $oOptionsMock->parseOptions();

        /** @var Session|PHPUnit_Framework_MockObject_MockObject $oSessionMock */
        $oSessionMock = $this->getMock(Session::class, array(
            'setVariable'
        ));
        $oSessionMock->expects($this->once())->method('setVariable')
            ->with($this->equalTo('d3ordermanager_quiet'))->willReturn(true);
        d3GetModCfgDIC()->set('d3ox.ordermanager.'.Session::class, $oSessionMock);

        /** @var d3_ordermanager_cron|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_cron::class, array(
            'translateFixedStrings',
        ));
        $oControllerMock->expects($this->once())->method('translateFixedStrings')->willReturn(false);

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'main',
            array($oOptionsMock)
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function mainUseQuietCmdDefaultCJID()
    {
        /** @var Options|PHPUnit_Framework_MockObject_MockObject $oOptionsMock */
        $oOptionsMock = $this->getMock(Options::class, array(
            'getOpt',
            'getCmd',
            'getArgs'
        ),
            array($this->getValue($this->_oController, 'colors'))
        );
        $oOptionsMock->method('getOpt')->willReturn(false);
        $oOptionsMock->method('getCmd')->willReturn(false);
        $oOptionsMock->method('getArgs')->willReturn(['1', '10', 'key']);

        $this->setValue(
            $oOptionsMock,
            'args',
            ['1', '10', 'key']
        );
        $oOptionsMock->parseOptions();

        /** @var Session|PHPUnit_Framework_MockObject_MockObject $oSessionMock */
        $oSessionMock = $this->getMock(Session::class, array(
            'setVariable'
        ));
        $oSessionMock->expects($this->never())->method('setVariable')
            ->with($this->equalTo('d3ordermanager_quiet'))->willReturn(false);
        d3GetModCfgDIC()->set('d3ox.ordermanager.'.Session::class, $oSessionMock);

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oResponseMock */
        $oResponseMock = $this->getMock(d3ordermanager_response::class, array(
            'init'
        ));
        $oResponseMock->expects($this->once())->method('init')->willReturn(true);
        d3GetModCfgDIC()->set( d3ordermanager_response::class, $oResponseMock);

        /** @var d3_ordermanager_cron|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_cron::class, array(
            'translateFixedStrings',
            'success'
        ));
        $oControllerMock->expects($this->never())->method('translateFixedStrings')->willReturn(false);
        $oControllerMock->expects($this->once())->method('success')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'main',
            array($oOptionsMock)
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function mainCmdRun()
    {
        /** @var Options|PHPUnit_Framework_MockObject_MockObject $oOptionsMock */
        $oOptionsMock = $this->getMock(Options::class, array(
            'getOpt',
            'getCmd'
        ),
            array($this->getValue($this->_oController, 'colors'))
        );
        $oOptionsMock->method('getCmd')->willReturn('run');
        $oOptionsMock->method('getOpt')->willReturn(false);

        $this->setValue(
            $oOptionsMock,
            'args',
            array()
        );
        $oOptionsMock->parseOptions();

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oResponseMock */
        $oResponseMock = $this->getMock(d3ordermanager_response::class, array(
            'init'
        ));
        $oResponseMock->expects($this->once())->method('init')->willReturn(true);
        d3GetModCfgDIC()->set( d3ordermanager_response::class, $oResponseMock);

        /** @var d3_ordermanager_cron|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_cron::class, array(
            'success',
        ));
        $oControllerMock->expects($this->once())->method('success')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'main',
            array($oOptionsMock)
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function mainCmdStatus()
    {
        /** @var Options|PHPUnit_Framework_MockObject_MockObject $oOptionsMock */
        $oOptionsMock = $this->getMock(Options::class, array(
            'getOpt',
            'getCmd'
        ),
            array($this->getValue($this->_oController, 'colors'))
        );
        $oOptionsMock->method('getCmd')->willReturn('status');
        $oOptionsMock->method('getOpt')->willReturn(false);

        $this->setValue(
            $oOptionsMock,
            'args',
            array()
        );
        $oOptionsMock->parseOptions();

        /** @var d3_ordermanager_cron|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_cron::class, array(
            'info',
        ));
        $oControllerMock->expects($this->once())->method('info')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'main',
            array($oOptionsMock)
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function mainHandleException()
    {
        /** @var Options|PHPUnit_Framework_MockObject_MockObject $oOptionsMock */
        $oOptionsMock = $this->getMock(Options::class, array(
            'getOpt',
            'getCmd'
        ),
            array($this->getValue($this->_oController, 'colors'))
        );
        $oOptionsMock->method('getCmd')->willReturn('run');
        $oOptionsMock->method('getOpt')->willReturn(false);

        $this->setValue(
            $oOptionsMock,
            'args',
            array()
        );
        $oOptionsMock->parseOptions();

        /** @var d3ordermanager_response|PHPUnit_Framework_MockObject_MockObject $oResponseMock */
        $oResponseMock = $this->getMock(d3ordermanager_response::class, array(
            'init'
        ));
        $oResponseMock->expects($this->once())->method('init')->willThrowException(new Exception('excMsg'));
        d3GetModCfgDIC()->set( d3ordermanager_response::class, $oResponseMock);

        /** @var d3_ordermanager_cron|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_ordermanager_cron::class, array(
            'error',
        ));
        $oControllerMock->expects($this->once())->method('error')->willReturn(true);

        $this->_oController = $oControllerMock;

        $this->callMethod(
            $this->_oController,
            'main',
            array($oOptionsMock)
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function translateFixedStringsPassed()
    {
        $this->assertSame(
            'abc D3_ORDERMANAGER_CLI_COMMAND def',
            $this->callMethod(
                $this->_oController,
                'translateFixedStrings',
                array(
                    'abc This tool accepts a command as first parameter as outlined below: def'
                )
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function translateFixedStringsFailed()
    {
        $this->assertSame(
            'abc This tool accepts a foo command as first parameter as outlined below: def',
            $this->callMethod(
                $this->_oController,
                'translateFixedStrings',
                array(
                    'abc This tool accepts a foo command as first parameter as outlined below: def'
                )
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