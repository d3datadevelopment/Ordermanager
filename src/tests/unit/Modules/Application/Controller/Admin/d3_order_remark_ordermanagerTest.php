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

namespace D3\Ordermanager\Tests\unit\Modules\Application\Controller\Admin;

use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Modules\Application\Controller\Admin\d3_order_remark_ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Remark;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Language;
use PHPUnit_Framework_MockObject_MockObject;
use ReflectionException;

class d3_order_remark_ordermanagerTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_order_remark_ordermanager */
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

        $this->_oController = d3GetModCfgDIC()->get(d3_order_remark_ordermanager::class);
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
        $sRet = $this->callMethod(
            $this->_oController,
            "render"
        );

        $this->assertRegExp('@.*\.tpl@i', $sRet);
        $this->assertRegExp('@.*\.tpl@i', $this->_oController->getViewDataElement('sOriginalTplName'));
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canFixRemarkItems()
    {
        /** @var d3_order_remark_ordermanager|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_order_remark_ordermanager::class, array(
            'getViewDataElement',
            'd3ReplaceType',
        ));
        $oControllerMock->method('getViewDataElement')->willReturn($this->getRemarkList());
        $oControllerMock->expects($this->once())->method('d3ReplaceType')->willReturn('newContent');

        $this->_oController = $oControllerMock;

        $this->assertSame(
            'newContent',
            $this->callMethod($this->_oController, 'd3FixRemarkItems', array('oldContent'))
        );
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getRemarkList()
    {
        $oRemark1 = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Remark::class);
        $oRemark1->setId('testId');
        $oRemark1->assign(array('oxtype' => 'd3om'));

        $oRemark2 = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Remark::class);
        $oRemark2->setId('testId');
        $oRemark2->assign(array('oxtype' => 'order'));

        return array(
            '#1'    => $oRemark1,
            '#2'    => $oRemark2,
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getLangReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Language::class,
            $this->callMethod(
                $this->_oController,
                'getLang'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canReplaceType()
    {
        $sOldContent = '<option value="itemNo1">[Order] No. 1</option>'.PHP_EOL.
                       '<option value="itemNo2">[Order] No. 2</option>';

        /** @var Language|PHPUnit_Framework_MockObject_MockObject $oLangMock */
        $oLangMock = $this->getMock(Language::class, array(
            'translateString',
        ));
        $oLangMock->method('translateString')->willReturn('[OM_Ident]');

        /** @var d3_order_remark_ordermanager|PHPUnit_Framework_MockObject_MockObject $oControllerMock */
        $oControllerMock = $this->getMock(d3_order_remark_ordermanager::class, array(
            'getLang',
        ));
        $oControllerMock->method('getLang')->willReturn($oLangMock);

        $this->_oController = $oControllerMock;
        
        $this->assertSame(
            '<option value="itemNo1">[Order] No. 1</option>'.PHP_EOL.
                     '<option value="itemNo2">[OM_Ident] No. 2</option>',
            $this->callMethod(
                $this->_oController,
                'd3ReplaceType',
                array(
                    $sOldContent,
                    'itemNo2'
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