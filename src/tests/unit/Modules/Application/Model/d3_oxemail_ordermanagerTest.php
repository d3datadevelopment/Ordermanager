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

namespace D3\Ordermanager\Tests\unit\Modules\Application\Model;

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Log\d3log;
use D3\ModCfg\Application\Model\Shopcompatibility\d3ShopCompatibilityAdapterHandler;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_action_getpdfdocuments;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_conf;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use D3\PdfDocuments\Application\Model\Documents\invoicePdf;
use Doctrine\DBAL\DBALException;
use Exception;
use Html2Text\Html2Text;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\Content;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\Payment;
use OxidEsales\Eshop\Application\Model\Remark;
use OxidEsales\Eshop\Application\Model\Shop;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Email;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Module\Module;
use PHPUnit_Framework_MockObject_MockObject;
use ReflectionException;
use Smarty;
use stdClass;

class d3_oxemail_ordermanagerTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_oxemail_ordermanager */
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

        $this->_oModel = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Email::class);
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
    public function canSendOrderManagerEmail()
    {
        /** @var Shop|PHPUnit_Framework_MockObject_MockObject $oFieldMock */
        $oFieldMock = $this->getMock(Shop::class, array(
            'getRawValue',
        ));
        $oFieldMock->method('getRawValue')->willReturn('value');
        
        /** @var Shop|PHPUnit_Framework_MockObject_MockObject $oShopMock */
        $oShopMock = $this->getMock(Shop::class, array(
            '__get',
            'getFieldData',
        ));
        $oShopMock->method('__get')->willReturn($oFieldMock);
        $oShopMock->method('getFieldData')->willReturn('value');

        /** @var d3log|PHPUnit_Framework_MockObject_MockObject $oD3LogMock */
        $oD3LogMock = $this->getMock(d3log::class, array(
            'log',
        ));
        $oD3LogMock->method('log')->willReturn(true);
        
        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'd3getLog',
        ));
        $oModCfgMock->method('d3getLog')->willReturn($oD3LogMock);
        
        /** @var Smarty|PHPUnit_Framework_MockObject_MockObject $oSmartyMock */
        $oSmartyMock = $this->getMock(Smarty::class, array(
            'fetch',
        ));
        $oSmartyMock->method('fetch')->willReturn('smartyContent');
        
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            '_getShop',
            '_getSmarty',
            '_setMailParams',
            'setViewData',
            '_processViewArray',
            'setBody',
            'setAltBody',
            'getBody',
            'd3GetSet',
            'setSubject',
            'setRecipient',
            'setReplyTo',
            'send',
        ));
        $oModelMock->method('_getShop')->willReturn($oShopMock);
        $oModelMock->method('_getSmarty')->willReturn($oSmartyMock);
        $oModelMock->method('_setMailParams')->willReturn(true);
        $oModelMock->method('setViewData')->willReturn(true);
        $oModelMock->method('_processViewArray')->willReturn(true);
        $oModelMock->expects($this->once())->method('setBody')->willReturn(true);
        $oModelMock->method('setAltBody')->willReturn(true);
        $oModelMock->method('getBody')->willReturn('mailBody');
        $oModelMock->method('d3GetSet')->willReturn($oModCfgMock);
        $oModelMock->method('setSubject')->willReturn(true);
        $oModelMock->expects($this->once())->method('setRecipient')->willReturn(true);
        $oModelMock->method('setReplyTo')->willReturn(true);
        $oModelMock->expects($this->once())->method('send')->willReturn('sendSuccessStatus');

        $this->_oModel = $oModelMock;

        $this->assertSame(
            'sendSuccessStatus',
            $this->callMethod(
                $this->_oModel,
                'd3sendOrderManagerEmail',
                array(array())
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canLoadOrderUniqueOxid()
    {
        $oOrderManagerListMock = $this->getMock(d3ordermanagerlist::class,
            ['d3GetOrderSaveTriggeredManagerTasks']
        );
        $oOrderManagerListMock->method('d3GetOrderSaveTriggeredManagerTasks')->willReturn(array());

        d3GetModCfgDIC()->set(d3ordermanagerlist::class, $oOrderManagerListMock);

        $oOrder = new Order();
        $oOrder->setId('testOxId1');
        $oOrder->save();

        $oReturnOrder = $this->callMethod(
            $this->_oModel,
            'd3getOrder',
            array('testOxId1')
        );

        $this->assertInstanceOf(
            Order::class,
            $oReturnOrder
        );
        $this->assertSame(
            'testOxId1',
            $oReturnOrder->getId()
        );

        $oOrder->delete('testOxId1');
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canLoadOrderOxidPartOfOtherData()
    {
        $oOrderManagerListMock = $this->getMock(d3ordermanagerlist::class,
            ['d3GetOrderSaveTriggeredManagerTasks']
        );
        $oOrderManagerListMock->method('d3GetOrderSaveTriggeredManagerTasks')->willReturn(array());

        d3GetModCfgDIC()->set(d3ordermanagerlist::class, $oOrderManagerListMock);

        $oOrder = new Order();
        $oOrder->setId('testOxId2');
        $oOrder->save();

        $oReturnOrder = $this->callMethod(
            $this->_oModel,
            'd3getOrder',
            array('testOxId2@@otherData')
        );

        $this->assertInstanceOf(
            Order::class,
            $oReturnOrder
        );
        $this->assertSame(
            'testOxId2',
            $oReturnOrder->getId()
        );

        $oOrder->delete('testOxId2');
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canLoadOrdermanager()
    {
        /** @var d3ordermanager $oManager */
        $oManager = d3GetModCfgDIC()->get(d3ordermanager::class);
        $oManager->setId('testOxId3');
        $oManager->save();

        $oReturnManager = $this->callMethod(
            $this->_oModel,
            'd3getOrderManager',
            array('testOxId3')
        );

        $this->assertInstanceOf(
            d3ordermanager::class,
            $oReturnManager
        );
        $this->assertSame(
            'testOxId3',
            $oReturnManager->getId()
        );

        $oManager->delete('testOxId3');
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canStartSendingOrderManagerMail()
    {
        /** @var Remark|PHPUnit_Framework_MockObject_MockObject $oRemarkMock */
        $oRemarkMock = $this->getMock(Remark::class, array(
            'save',
        ));
        $oRemarkMock->expects($this->once())->method('save')->willReturn(true);
        
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'getOrderManagerMailContent',
            '_getShop',
            'setBody',
            'setAltBody',
            'setSubject',
            '_d3SetOrderManagerReplyAddress',
            '_d3SetOrderManagerMailRecipients',
            '_d3AddOrderManagerPdfAttachment',
            'send',
        ));
        $oModelMock->method('getOrderManagerMailContent')->willReturn(array(
            'html'      => 'foo',
            'plain'     => 'bar',
            'subject'   => 'testSubject'
        ));
        $oModelMock->method('_getShop')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class));
        $oModelMock->expects($this->once())->method('setBody')->willReturn(true);
        $oModelMock->method('setAltBody')->willReturn(true);
        $oModelMock->method('setSubject')->willReturn(true);
        $oModelMock->method('_d3SetOrderManagerReplyAddress')->willReturn(true);
        $oModelMock->method('_d3SetOrderManagerMailRecipients')->willReturn($oRemarkMock);
        $oModelMock->method('_d3AddOrderManagerPdfAttachment')->willReturn(true);
        $oModelMock->expects($this->once())->method('send')->willReturn('successSendStatus');

        $this->_oModel = $oModelMock;

        $this->assertSame(
            'successSendStatus',
            $this->callMethod(
                $this->_oModel,
                'sendOrderManagerMail',
                array(d3GetModCfgDIC()->get(d3ordermanager::class))
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canSetOrderManagerMailRecipientsCustomer()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            '_d3hasOrderManagerCustomerRecipient',
            '_d3sendOrderManagerMailToCustomer',
            '_d3hasOrderManagerOwnerRecipient',
            '_d3sendOrderManagerMailToOwner',
            '_d3hasOrderManagerCustomRecipient',
            '_d3sendOrderManagerMailToCustom',
        ));
        $oModelMock->method('_d3hasOrderManagerCustomerRecipient')->willReturn(true);
        $oModelMock->expects($this->once())->method('_d3sendOrderManagerMailToCustomer')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Remark::class));
        $oModelMock->method('_d3hasOrderManagerOwnerRecipient')->willReturn(false);
        $oModelMock->expects($this->never())->method('_d3sendOrderManagerMailToOwner')->willReturn(true);
        $oModelMock->method('_d3hasOrderManagerCustomRecipient')->willReturn(false);
        $oModelMock->expects($this->never())->method('_d3sendOrderManagerMailToCustom')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertInstanceOf(
            Remark::class,
            $this->callMethod(
                $this->_oModel,
                '_d3SetOrderManagerMailRecipients',
                array(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class))
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canSetOrderManagerMailRecipientsOwner()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            '_d3hasOrderManagerCustomerRecipient',
            '_d3sendOrderManagerMailToCustomer',
            '_d3hasOrderManagerOwnerRecipient',
            '_d3sendOrderManagerMailToOwner',
            '_d3hasOrderManagerCustomRecipient',
            '_d3sendOrderManagerMailToCustom',
        ));
        $oModelMock->method('_d3hasOrderManagerCustomerRecipient')->willReturn(false);
        $oModelMock->expects($this->never())->method('_d3sendOrderManagerMailToCustomer')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Remark::class));
        $oModelMock->method('_d3hasOrderManagerOwnerRecipient')->willReturn(true);
        $oModelMock->expects($this->once())->method('_d3sendOrderManagerMailToOwner')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Remark::class));
        $oModelMock->method('_d3hasOrderManagerCustomRecipient')->willReturn(false);
        $oModelMock->expects($this->never())->method('_d3sendOrderManagerMailToCustom')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Remark::class));

        $this->_oModel = $oModelMock;

        $this->assertInstanceOf(
            Remark::class,
            $this->callMethod(
                $this->_oModel,
                '_d3SetOrderManagerMailRecipients',
                array(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class))
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canSetOrderManagerMailRecipientsCustom()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            '_d3hasOrderManagerCustomerRecipient',
            '_d3sendOrderManagerMailToCustomer',
            '_d3hasOrderManagerOwnerRecipient',
            '_d3sendOrderManagerMailToOwner',
            '_d3hasOrderManagerCustomRecipient',
            '_d3sendOrderManagerMailToCustom',
        ));
        $oModelMock->method('_d3hasOrderManagerCustomerRecipient')->willReturn(false);
        $oModelMock->expects($this->never())->method('_d3sendOrderManagerMailToCustomer')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Remark::class));
        $oModelMock->method('_d3hasOrderManagerOwnerRecipient')->willReturn(false);
        $oModelMock->expects($this->never())->method('_d3sendOrderManagerMailToOwner')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Remark::class));
        $oModelMock->method('_d3hasOrderManagerCustomRecipient')->willReturn(true);
        $oModelMock->expects($this->once())->method('_d3sendOrderManagerMailToCustom')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Remark::class));

        $this->_oModel = $oModelMock;

        $this->assertInstanceOf(
            Remark::class,
            $this->callMethod(
                $this->_oModel,
                '_d3SetOrderManagerMailRecipients',
                array(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Shop::class))
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGgetOrderManagerMailOptionEdited()
    {
        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue',
            'getEditedValues',
        ));
        $oManagerMock->expects($this->never())->method('getValue')->willReturn('objectProperty');
        $oManagerMock->expects($this->once())->method('getEditedValues')->willReturn(array('editedVar' => 'editedProperty'));

        $this->setValue(
            $this->_oModel,
            'oOrderManager',
            $oManagerMock
        );
        
        $this->callMethod(
            $this->_oModel,
            '_d3getOrderManagerMailOption',
            array('editedVar')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGgetOrderManagerMailOptionObject()
    {
        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue',
            'getEditedValues',
        ));
        $oManagerMock->expects($this->once())->method('getValue')->willReturn('objectProperty');
        $oManagerMock->expects($this->once())->method('getEditedValues')->willReturn(array('editedVar' => 'editedProperty'));

        $this->setValue(
            $this->_oModel,
            'oOrderManager',
            $oManagerMock
        );

        $this->callMethod(
            $this->_oModel,
            '_d3getOrderManagerMailOption',
            array('objectVar')
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canHasOrderManagerCustomerRecipient()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            '_d3getOrderManagerMailOption',
        ));
        $oModelMock->expects($this->once())->method('_d3getOrderManagerMailOption')->with(
            $this->stringContains('Customer')
        )->willReturn('returnValue');

        $this->_oModel = $oModelMock;
        
        $this->assertSame(
            'returnValue',
            $this->callMethod(
                $this->_oModel,
                '_d3hasOrderManagerCustomerRecipient'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canHasOrderManagerOwnerRecipient()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            '_d3getOrderManagerMailOption',
        ));
        $oModelMock->expects($this->once())->method('_d3getOrderManagerMailOption')->with(
            $this->stringContains('Owner')
        )->willReturn('returnValue');

        $this->_oModel = $oModelMock;

        $this->assertSame(
            'returnValue',
            $this->callMethod(
                $this->_oModel,
                '_d3hasOrderManagerOwnerRecipient'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canHasOrderManagerCustomRecipient()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            '_d3getOrderManagerMailOption',
        ));
        $oModelMock->expects($this->once())->method('_d3getOrderManagerMailOption')->with(
            $this->stringContains('Custom')
        )->willReturn('returnValue');

        $this->_oModel = $oModelMock;

        $this->assertSame(
            'returnValue',
            $this->callMethod(
                $this->_oModel,
                '_d3hasOrderManagerCustomRecipient'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetOrderManagerCustomRecipientList()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            '_d3getOrderManagerMailOption',
        ));
        $oModelMock->expects($this->once())->method('_d3getOrderManagerMailOption')->with(
            $this->stringContains('CustomAddress')
        )->willReturn('returnValue');

        $this->_oModel = $oModelMock;

        $this->assertSame(
            'returnValue',
            $this->callMethod(
                $this->_oModel,
                '_d3getOrderManagerCustomRecipientList'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3GetSetReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3_cfg_mod::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetSet'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3GetPaymentReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Payment::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetPayment'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3GetLangReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Language::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetLang'
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
    public function canGetOrderManagerMailContentAdminTpl()
    {
        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getLicenseConfigData',
        ));
        $oModCfgMock->method('getLicenseConfigData')->willReturn(false);
        
        /** @var Language|PHPUnit_Framework_MockObject_MockObject $oLanguageMock */
        $oLanguageMock = $this->getMock(Language::class, array(
            'translateString',
        ));
        $oLanguageMock->method('translateString')->willReturn(true);
        
        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getTemplateDir',
            'setAdminMode',
        ));
        $oConfigMock->method('getTemplateDir')->willReturn(true);
        $oConfigMock->expects($this->exactly(2))->method('setAdminMode')->with(
            $this->isTrue()
        )->willReturn(true);

        /** @var Payment|PHPUnit_Framework_MockObject_MockObject $oPaymentMock */
        $oPaymentMock = $this->getMock(Payment::class, array(
            'load',
        ));
        $oPaymentMock->method('load')->willReturn(true);
        
        /** @var Basket|PHPUnit_Framework_MockObject_MockObject $oBasketMock */
        $oBasketMock = $this->getMock(Basket::class, array(
            'getPaymentId',
        ));
        $oBasketMock->method('getPaymentId')->willReturn(true);
        
        /** @var Order|PHPUnit_Framework_MockObject_MockObject $oOrderMock */
        $oOrderMock = $this->getMock(Order::class, array(
            'd3getOrderBasket4OrderManager',
            'd3setBasket4OrderManager',
            'd3setPayment4OrderManager',
            'getOrderUser',
            'getDelSet',
            'getOrderCurrency',
        ));
        $oOrderMock->method('d3getOrderBasket4OrderManager')->willReturn($oBasketMock);
        $oOrderMock->method('d3setBasket4OrderManager')->willReturn(true);
        $oOrderMock->method('d3setPayment4OrderManager')->willReturn(true);
        $oOrderMock->method('getOrderUser')->willReturn(true);
        $oOrderMock->method('getDelSet')->willReturn(true);
        $oOrderMock->method('getOrderCurrency')->willReturn(true);

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue',
            'getCurrentItem',
        ));
        $getValueMap = [['sSendMailFromTheme', 'admin']];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);
        
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            '_getShop',
            '_setMailParams',
            '_getSmarty',
            'd3GetPayment',
            'setViewData',
            'getViewConfig',
            'd3GetConfig',
            'd3GetLang',
            'getTemplateDir4OrderManager',
            '_processViewArray',
            'd3GetSet',
            'd3SendMailHook',
            '_d3GenerateOrderManagerMailContent',
        ));
        $oModelMock->method('_getShop')->willReturn(true);
        $oModelMock->method('_setMailParams')->willReturn(true);
        $oModelMock->method('_getSmarty')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Smarty::class));
        $oModelMock->method('d3GetPayment')->willReturn($oPaymentMock);
        $oModelMock->method('setViewData')->willReturn(true);
        $oModelMock->method('getViewConfig')->willReturn(true);
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetLang')->willReturn($oLanguageMock);
        $oModelMock->method('getTemplateDir4OrderManager')->willReturn(true);
        $oModelMock->method('_processViewArray')->willReturn(true);
        $oModelMock->method('d3GetSet')->willReturn($oModCfgMock);
        $oModelMock->method('d3SendMailHook')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Smarty::class));
        $oModelMock->method('_d3GenerateOrderManagerMailContent')->willReturn('returnValue');

        $this->_oModel = $oModelMock;

        $this->assertSame(
            'returnValue',
            $this->callMethod(
                $this->_oModel,
                'getOrderManagerMailContent',
                array($oManagerMock)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetOrderManagerMailContentFrontendTpl()
    {
        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oModCfgMock */
        $oModCfgMock = $this->getMock(stdClass::class, array(
            'getLicenseConfigData',
        ));
        $oModCfgMock->method('getLicenseConfigData')->willReturn(false);

        /** @var Language|PHPUnit_Framework_MockObject_MockObject $oLanguageMock */
        $oLanguageMock = $this->getMock(Language::class, array(
            'translateString',
        ));
        $oLanguageMock->method('translateString')->willReturn(true);

        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getTemplateDir',
            'setAdminMode',
        ));
        $oConfigMock->method('getTemplateDir')->willReturn(true);
        $oConfigMock->expects($this->exactly(2))->method('setAdminMode')->withConsecutive(
            [$this->isFalse()],
            [$this->isTrue()]
        )->willReturn(true);

        /** @var Payment|PHPUnit_Framework_MockObject_MockObject $oPaymentMock */
        $oPaymentMock = $this->getMock(Payment::class, array(
            'load',
        ));
        $oPaymentMock->method('load')->willReturn(true);

        /** @var Basket|PHPUnit_Framework_MockObject_MockObject $oBasketMock */
        $oBasketMock = $this->getMock(Basket::class, array(
            'getPaymentId',
        ));
        $oBasketMock->method('getPaymentId')->willReturn(true);

        /** @var Order|PHPUnit_Framework_MockObject_MockObject $oOrderMock */
        $oOrderMock = $this->getMock(Order::class, array(
            'd3getOrderBasket4OrderManager',
            'd3setBasket4OrderManager',
            'd3setPayment4OrderManager',
            'getOrderUser',
            'getDelSet',
            'getOrderCurrency',
        ));
        $oOrderMock->method('d3getOrderBasket4OrderManager')->willReturn($oBasketMock);
        $oOrderMock->method('d3setBasket4OrderManager')->willReturn(true);
        $oOrderMock->method('d3setPayment4OrderManager')->willReturn(true);
        $oOrderMock->method('getOrderUser')->willReturn(true);
        $oOrderMock->method('getDelSet')->willReturn(true);
        $oOrderMock->method('getOrderCurrency')->willReturn(true);

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue',
            'getCurrentItem',
        ));
        $getValueMap = [['sSendMailFromTheme', 'frontend']];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            '_getShop',
            '_setMailParams',
            '_getSmarty',
            'd3GetPayment',
            'setViewData',
            'getViewConfig',
            'd3GetConfig',
            'd3GetLang',
            'getTemplateDir4OrderManager',
            '_processViewArray',
            'd3GetSet',
            'd3SendMailHook',
            '_d3GenerateOrderManagerMailContent',
        ));
        $oModelMock->method('_getShop')->willReturn(true);
        $oModelMock->method('_setMailParams')->willReturn(true);
        $oModelMock->method('_getSmarty')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Smarty::class));
        $oModelMock->method('d3GetPayment')->willReturn($oPaymentMock);
        $oModelMock->method('setViewData')->willReturn(true);
        $oModelMock->method('getViewConfig')->willReturn(true);
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetLang')->willReturn($oLanguageMock);
        $oModelMock->method('getTemplateDir4OrderManager')->willReturn(true);
        $oModelMock->method('_processViewArray')->willReturn(true);
        $oModelMock->method('d3GetSet')->willReturn($oModCfgMock);
        $oModelMock->method('d3SendMailHook')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Smarty::class));
        $oModelMock->method('_d3GenerateOrderManagerMailContent')->willReturn('returnValue');

        $this->_oModel = $oModelMock;

        $this->assertSame(
            'returnValue',
            $this->callMethod(
                $this->_oModel,
                'getOrderManagerMailContent',
                array($oManagerMock)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetTemplateDir4OrderManagerModule()
    {
        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getTemplateDir',
        ));
        $oConfigMock->expects($this->never())->method('getTemplateDir')->willReturn('returnValue');
        
        /** @var d3str|PHPUnit_Framework_MockObject_MockObject $oD3StrMock */
        $oD3StrMock = $this->getMock(d3str::class, array(
            'untrailingslashit',
        ));
        $oD3StrMock->method('untrailingslashit')->willReturn('returnValue');
        
        /** @var d3ShopCompatibilityAdapterHandler|PHPUnit_Framework_MockObject_MockObject $oShopCompatHandlerMock */
        $oShopCompatHandlerMock = $this->getMock(d3ShopCompatibilityAdapterHandler::class, array(
            'call',
        ));
        $oShopCompatHandlerMock->expects($this->once())->method('call')->willReturn('fullPath');
        
        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue',
        ));
        $getValueMap = [
            ['sSendMailFromTheme', 'module'],
            ['sSendMailFromModulePath', 'module'],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'd3GetShopCompatibilityAdapterHandler',
            'd3GetModule',
            'getD3Str',
            'd3GetConfig',
        ));
        $oModelMock->method('d3GetShopCompatibilityAdapterHandler')->willReturn($oShopCompatHandlerMock);
        $oModelMock->method('d3GetModule')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Module::class));
        $oModelMock->method('getD3Str')->willReturn($oD3StrMock);
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            'returnValue',
            $this->callMethod(
                $this->_oModel,
                'getTemplateDir4OrderManager',
                array($oManagerMock)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetTemplateDir4OrderManagerAdmin()
    {
        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getTemplateDir',
        ));
        $oConfigMock->expects($this->once())->method('getTemplateDir')->with(
            $this->isTrue()
        )->willReturn('returnValue');

        /** @var d3str|PHPUnit_Framework_MockObject_MockObject $oD3StrMock */
        $oD3StrMock = $this->getMock(d3str::class, array(
            'untrailingslashit',
        ));
        $oD3StrMock->method('untrailingslashit')->willReturn('returnValue');

        /** @var d3ShopCompatibilityAdapterHandler|PHPUnit_Framework_MockObject_MockObject $oShopCompatHandlerMock */
        $oShopCompatHandlerMock = $this->getMock(d3ShopCompatibilityAdapterHandler::class, array(
            'call',
        ));
        $oShopCompatHandlerMock->expects($this->never())->method('call')->willReturn('fullPath');

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue',
        ));
        $getValueMap = [
            ['sSendMailFromTheme', 'admin'],
            ['sSendMailFromModulePath', 'module'],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'd3GetShopCompatibilityAdapterHandler',
            'd3GetModule',
            'getD3Str',
            'd3GetConfig',
        ));
        $oModelMock->method('d3GetShopCompatibilityAdapterHandler')->willReturn($oShopCompatHandlerMock);
        $oModelMock->method('d3GetModule')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Module::class));
        $oModelMock->method('getD3Str')->willReturn($oD3StrMock);
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            'returnValue',
            $this->callMethod(
                $this->_oModel,
                'getTemplateDir4OrderManager',
                array($oManagerMock)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGetTemplateDir4OrderManagerFrontend()
    {
        /** @var Config|PHPUnit_Framework_MockObject_MockObject $oConfigMock */
        $oConfigMock = $this->getMock(Config::class, array(
            'getTemplateDir',
        ));
        $oConfigMock->expects($this->once())->method('getTemplateDir')->with(
            $this->isFalse()
        )->willReturn('returnValue');

        /** @var d3str|PHPUnit_Framework_MockObject_MockObject $oD3StrMock */
        $oD3StrMock = $this->getMock(d3str::class, array(
            'untrailingslashit',
        ));
        $oD3StrMock->method('untrailingslashit')->willReturn('returnValue');

        /** @var d3ShopCompatibilityAdapterHandler|PHPUnit_Framework_MockObject_MockObject $oShopCompatHandlerMock */
        $oShopCompatHandlerMock = $this->getMock(d3ShopCompatibilityAdapterHandler::class, array(
            'call',
        ));
        $oShopCompatHandlerMock->expects($this->never())->method('call')->willReturn('fullPath');

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue',
        ));
        $getValueMap = [
            ['sSendMailFromTheme', 'frontend'],
            ['sSendMailFromModulePath', 'module'],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'd3GetShopCompatibilityAdapterHandler',
            'd3GetModule',
            'getD3Str',
            'd3GetConfig',
        ));
        $oModelMock->method('d3GetShopCompatibilityAdapterHandler')->willReturn($oShopCompatHandlerMock);
        $oModelMock->method('d3GetModule')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Module::class));
        $oModelMock->method('getD3Str')->willReturn($oD3StrMock);
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            'returnValue',
            $this->callMethod(
                $this->_oModel,
                'getTemplateDir4OrderManager',
                array($oManagerMock)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3SendMailHookReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Smarty::class,
            $this->callMethod(
                $this->_oModel,
                'd3SendMailHook',
                array(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Smarty::class))
            )
        );
    }

    /**
     * @test
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3GetUtilsView
     */
    public function d3GetUtilsViewReturnsRightInstance()
    {
        $this->markTestSkipped('skipped because visual CMS extension issue');

        /*
        $this->assertInstanceOf(
            UtilsView::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetUtilsView'
            )
        );
        */
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3GetContentReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Content::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetContent'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3GetModuleReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Module::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetModule'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function getD3StrReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3str::class,
            $this->callMethod(
                $this->_oModel,
                'getD3Str'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3GetShopCompatibilityAdapterHandlerReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3ShopCompatibilityAdapterHandler::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetShopCompatibilityAdapterHandler'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function _d3GenerateOrderManagerMailContentFromEditor()
    {
        $currLangId = 2;
        $orderLangId = 3;

        /** @var Order|PHPUnit_Framework_MockObject_MockObject $oOrderMock */
        $oOrderMock = $this->getMock(Order::class, array(
            'getFieldData',
        ));
        $getFieldDataMap = [
            ['oxlang', $orderLangId],
        ];
        $oOrderMock->method('getFieldData')->willReturnMap($getFieldDataMap);
        
        /** @var Language|PHPUnit_Framework_MockObject_MockObject $oLangMock */
        $oLangMock = $this->getMock(Language::class, array(
            'getTplLanguage',
            'setTplLanguage',
        ));
        $oLangMock->method('getTplLanguage')->willReturn($currLangId);
        $oLangMock->expects($this->exactly(2))->method('setTplLanguage')
            ->withConsecutive([$orderLangId], [$currLangId])->willReturn(true);

        // can't use a mock of UtilsView, because extension issue
        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oUtilsViewMock */
        $oUtilsViewMock = $this->getMock(stdClass::class, array(
            'parseThroughSmarty',
        ));
        $oUtilsViewMock->expects($this->never())->method('parseThroughSmarty')->willReturn(true);
        
        /** @var Content|PHPUnit_Framework_MockObject_MockObject $oContentMock */
        $oContentMock = $this->getMock(Content::class, array(
            'setLanguage',
            'load',
            'getFieldData',
            'getId',
        ));
        $oContentMock->method('setLanguage')->willReturn(true);
        $oContentMock->expects($this->never())->method('load')->willReturn(true);
        $oContentMock->method('getFieldData')->willReturn(true);
        $oContentMock->method('getId')->willReturn(true);
        
        /** @var Smarty|PHPUnit_Framework_MockObject_MockObject $oSmartyMock */
        $oSmartyMock = $this->getMock(Smarty::class, array(
            'fetch',
        ));
        $oSmartyMock->expects($this->never())->method('fetch')->willReturn('smartyContent');

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getEditedValues',
            'getValue',
            'getCurrentItem',
        ));
        $getValueMap = [
            ['sSendMailFromSource', 'cms'],
        ];
        $aEditedValues = array(
            'mail' => array(
                'subject' => 'subjectMailContent',
                'plain' => 'plainMailContent',
                'html' => 'htmlMailContent',
            )
        );
        $oManagerMock->method('getEditedValues')->willReturn($aEditedValues);
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'd3HasOrderManagerEditorMailContent',
            'd3GetLang',
            'd3GetUtilsView',
            'd3GetContent',
        ));
        $oModelMock->method('d3HasOrderManagerEditorMailContent')->willReturn(true);
        $oModelMock->method('d3GetLang')->willReturn($oLangMock);
        $oModelMock->method('d3GetUtilsView')->willReturn($oUtilsViewMock);
        $oModelMock->method('d3GetContent')->willReturn($oContentMock);

        $this->_oModel = $oModelMock;

        $this->setValue(
            $this->_oModel,
            'oOrderManager',
            $oManagerMock
        );

        $this->assertSame(
            $aEditedValues['mail'],
            $this->callMethod(
                $this->_oModel,
                '_d3GenerateOrderManagerMailContent',
                array(
                    array(
                        'mail' => array(
                            'subject' => 'subjectMailContent',
                            'plain' => 'plainMailContent',
                            'html' => 'htmlMailContent',
                        )
                    ),
                    $oSmartyMock
                )
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function _d3GenerateOrderManagerMailContentFromEditorGeneratedPlain()
    {
        $currLangId = 2;
        $orderLangId = 3;

        /** @var Order|PHPUnit_Framework_MockObject_MockObject $oOrderMock */
        $oOrderMock = $this->getMock(Order::class, array(
            'getFieldData',
        ));
        $getFieldDataMap = [
            ['oxlang', $orderLangId],
        ];
        $oOrderMock->method('getFieldData')->willReturnMap($getFieldDataMap);

        /** @var Language|PHPUnit_Framework_MockObject_MockObject $oLangMock */
        $oLangMock = $this->getMock(Language::class, array(
            'getTplLanguage',
            'setTplLanguage',
        ));
        $oLangMock->method('getTplLanguage')->willReturn($currLangId);
        $oLangMock->expects($this->exactly(2))->method('setTplLanguage')
            ->withConsecutive([$orderLangId], [$currLangId])->willReturn(true);

        // can't use a mock of UtilsView, because extension issue
        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oUtilsViewMock */
        $oUtilsViewMock = $this->getMock(stdClass::class, array(
            'parseThroughSmarty',
        ));
        $oUtilsViewMock->expects($this->never())->method('parseThroughSmarty')->willReturn(true);

        /** @var Content|PHPUnit_Framework_MockObject_MockObject $oContentMock */
        $oContentMock = $this->getMock(Content::class, array(
            'setLanguage',
            'load',
            'getFieldData',
            'getId',
        ));
        $oContentMock->method('setLanguage')->willReturn(true);
        $oContentMock->expects($this->never())->method('load')->willReturn(true);
        $oContentMock->method('getFieldData')->willReturn(true);
        $oContentMock->method('getId')->willReturn(true);

        /** @var Smarty|PHPUnit_Framework_MockObject_MockObject $oSmartyMock */
        $oSmartyMock = $this->getMock(Smarty::class, array(
            'fetch',
        ));
        $oSmartyMock->expects($this->never())->method('fetch')->willReturn('smartyContent');

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getEditedValues',
            'getValue',
            'getCurrentItem',
        ));
        $getValueMap = [
            ['sSendMailFromSource', 'cms'],
        ];
        $aEditedValues = array(
            'mail' => array(
                'subject' => 'subjectMailContent',
                'genplain' => '1',
                'plain' => 'html'.PHP_EOL.'MailCont'.PHP_EOL.'ent',
                'html' => 'html<div>Mail</div>Cont<br>ent',
            )
        );
        $oManagerMock->method('getEditedValues')->willReturn($aEditedValues);
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'd3HasOrderManagerEditorMailContent',
            'd3GetLang',
            'd3GetUtilsView',
            'd3GetContent',
        ));
        $oModelMock->method('d3HasOrderManagerEditorMailContent')->willReturn(true);
        $oModelMock->method('d3GetLang')->willReturn($oLangMock);
        $oModelMock->method('d3GetUtilsView')->willReturn($oUtilsViewMock);
        $oModelMock->method('d3GetContent')->willReturn($oContentMock);

        $this->_oModel = $oModelMock;

        $this->setValue(
            $this->_oModel,
            'oOrderManager',
            $oManagerMock
        );

        $this->assertSame(
            $aEditedValues['mail'],
            $this->callMethod(
                $this->_oModel,
                '_d3GenerateOrderManagerMailContent',
                array(
                    array(
                        'mail' => array(
                            'subject' => 'subjectMailContent',
                            'genplain' => '1',
                            'html' => 'html<div>Mail</div>Cont<br>ent',
                        )
                    ),
                    $oSmartyMock
                )
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function _d3GenerateOrderManagerMailContentFromCms()
    {
        $currLangId = 2;
        $orderLangId = 3;

        /** @var Order|PHPUnit_Framework_MockObject_MockObject $oOrderMock */
        $oOrderMock = $this->getMock(Order::class, array(
            'getFieldData',
        ));
        $getFieldDataMap = [
            ['oxlang', $orderLangId],
        ];
        $oOrderMock->method('getFieldData')->willReturnMap($getFieldDataMap);

        /** @var Language|PHPUnit_Framework_MockObject_MockObject $oLangMock */
        $oLangMock = $this->getMock(Language::class, array(
            'getTplLanguage',
            'setTplLanguage',
        ));
        $oLangMock->method('getTplLanguage')->willReturn($currLangId);
        $oLangMock->expects($this->exactly(2))->method('setTplLanguage')
            ->withConsecutive([$orderLangId], [$currLangId])->willReturn(true);

        // can't use a mock of UtilsView, because extension issue
        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oUtilsViewMock */
        $oUtilsViewMock = $this->getMock(stdClass::class, array(
            'parseThroughSmarty',
        ));
        $oUtilsViewMock->expects($this->exactly(2))->method('parseThroughSmarty')->willReturn('smartyContent');

        /** @var Content|PHPUnit_Framework_MockObject_MockObject $oContentMock */
        $oContentMock = $this->getMock(Content::class, array(
            'setLanguage',
            'load',
            'getFieldData',
            'getId',
        ));
        $oContentMock->method('setLanguage')->willReturn(true);
        $oContentMock->expects($this->exactly(2))->method('load')->willReturn(true);
        $oContentMock->method('getFieldData')->willReturn('fieldData');
        $oContentMock->method('getId')->willReturn(true);

        /** @var Smarty|PHPUnit_Framework_MockObject_MockObject $oSmartyMock */
        $oSmartyMock = $this->getMock(Smarty::class, array(
            'fetch',
        ));
        $oSmartyMock->expects($this->never())->method('fetch')->willReturn('smartyContent');

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getEditedValues',
            'getValue',
            'getCurrentItem',
        ));
        $getValueMap = [
            ['sSendMailFromSource', 'cms'],
        ];
        $aEditedValues = array(
            'mail' => array(
                'subject' => 'subjectMailContent',
                'plain' => 'plainMailContent',
                'html' => 'htmlMailContent',
            )
        );
        $oManagerMock->method('getEditedValues')->willReturn($aEditedValues);
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'd3HasOrderManagerEditorMailContent',
            'd3GetLang',
            'd3GetUtilsView',
            'd3GetContent',
        ));
        $oModelMock->method('d3HasOrderManagerEditorMailContent')->willReturn(false);
        $oModelMock->method('d3GetLang')->willReturn($oLangMock);
        $oModelMock->method('d3GetUtilsView')->willReturn($oUtilsViewMock);
        $oModelMock->method('d3GetContent')->willReturn($oContentMock);

        $this->_oModel = $oModelMock;

        $this->setValue(
            $this->_oModel,
            'oOrderManager',
            $oManagerMock
        );

        $this->assertEquals(
            array(
                'subject'   => 'fieldData',
                'plain'     => 'smartyContent',
                'html'      => 'smartyContent',
            ),
            $this->callMethod(
                $this->_oModel,
                '_d3GenerateOrderManagerMailContent',
                array(
                    array(),
                    $oSmartyMock
                )
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function _d3GenerateOrderManagerMailContentFromTpl()
    {
        $currLangId = 2;
        $orderLangId = 3;

        /** @var Order|PHPUnit_Framework_MockObject_MockObject $oOrderMock */
        $oOrderMock = $this->getMock(Order::class, array(
            'getFieldData',
        ));
        $getFieldDataMap = [
            ['oxlang', $orderLangId],
        ];
        $oOrderMock->method('getFieldData')->willReturnMap($getFieldDataMap);

        /** @var Language|PHPUnit_Framework_MockObject_MockObject $oLangMock */
        $oLangMock = $this->getMock(Language::class, array(
            'getTplLanguage',
            'setTplLanguage',
        ));
        $oLangMock->method('getTplLanguage')->willReturn($currLangId);
        $oLangMock->expects($this->exactly(2))->method('setTplLanguage')
            ->withConsecutive([$orderLangId], [$currLangId])->willReturn(true);

        // can't use a mock of UtilsView, because extension issue
        /** @var stdClass|PHPUnit_Framework_MockObject_MockObject $oUtilsViewMock */
        $oUtilsViewMock = $this->getMock(stdClass::class, array(
            'parseThroughSmarty',
        ));
        $oUtilsViewMock->expects($this->never())->method('parseThroughSmarty')->willReturn('smartyContent');

        /** @var Content|PHPUnit_Framework_MockObject_MockObject $oContentMock */
        $oContentMock = $this->getMock(Content::class, array(
            'setLanguage',
            'load',
            'getFieldData',
            'getId',
        ));
        $oContentMock->method('setLanguage')->willReturn(true);
        $oContentMock->expects($this->never())->method('load')->willReturn(true);
        $oContentMock->method('getFieldData')->willReturn('fieldData');
        $oContentMock->method('getId')->willReturn(true);

        /** @var Smarty|PHPUnit_Framework_MockObject_MockObject $oSmartyMock */
        $oSmartyMock = $this->getMock(Smarty::class, array(
            'fetch',
        ));
        $oSmartyMock->expects($this->exactly(3))->method('fetch')->willReturn('smartyFetchContent');

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getEditedValues',
            'getValue',
            'getCurrentItem',
        ));
        $getValueMap = [
            ['sSendMailFromSource', 'template'],
        ];
        $aEditedValues = array(
            'mail' => array(
                'subject' => 'subjectMailContent',
                'plain' => 'plainMailContent',
                'html' => 'htmlMailContent',
            )
        );
        $oManagerMock->method('getEditedValues')->willReturn($aEditedValues);
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'd3HasOrderManagerEditorMailContent',
            'd3GetLang',
            'd3GetUtilsView',
            'd3GetContent',
        ));
        $oModelMock->method('d3HasOrderManagerEditorMailContent')->willReturn(false);
        $oModelMock->method('d3GetLang')->willReturn($oLangMock);
        $oModelMock->method('d3GetUtilsView')->willReturn($oUtilsViewMock);
        $oModelMock->method('d3GetContent')->willReturn($oContentMock);

        $this->_oModel = $oModelMock;

        $this->setValue(
            $this->_oModel,
            'oOrderManager',
            $oManagerMock
        );

        $this->assertEquals(
            array(
                'subject'   => 'smartyFetchContent',
                'plain'     => 'smartyFetchContent',
                'html'      => 'smartyFetchContent',
            ),
            $this->callMethod(
                $this->_oModel,
                '_d3GenerateOrderManagerMailContent',
                array(
                    array(),
                    $oSmartyMock
                )
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3HasOrderManagerEditorMailContentPass()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'isArrayEditorMailContent',
        ));
        $oModelMock->method('isArrayEditorMailContent')->willReturn(true);

        $this->_oModel = $oModelMock;

        $aEditedValues = array(
            'mail'  => array(
                'subject'   => 'subjectContent',
                'html'      => 'htmlContent',
                'plain'     => 'plainContent'
            )
        );

        $this->assertTrue(
            $this->callMethod(
                $this->_oModel,
                'd3HasOrderManagerEditorMailContent',
                array($aEditedValues)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3HasOrderManagerEditorMailContentIsNoArray()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'isArrayEditorMailContent',
        ));
        $oModelMock->method('isArrayEditorMailContent')->willReturn(false);

        $this->_oModel = $oModelMock;

        $aEditedValues = array(
            'mail'  => array(
                'subject'   => 'subjectContent',
                'html'      => 'htmlContent',
                'plain'     => 'plainContent'
            )
        );

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'd3HasOrderManagerEditorMailContent',
                array($aEditedValues)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3HasOrderManagerEditorMailContentIsNoSubject()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'isArrayEditorMailContent',
        ));
        $oModelMock->method('isArrayEditorMailContent')->willReturn(true);

        $this->_oModel = $oModelMock;

        $aEditedValues = array(
            'mail'  => array(
                'subject'   => false,
                'html'      => 'htmlContent',
                'plain'     => 'plainContent'
            )
        );

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'd3HasOrderManagerEditorMailContent',
                array($aEditedValues)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3HasOrderManagerEditorMailContentIsNoHtml()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'isArrayEditorMailContent',
        ));
        $oModelMock->method('isArrayEditorMailContent')->willReturn(true);

        $this->_oModel = $oModelMock;

        $aEditedValues = array(
            'mail'  => array(
                'subject'   => 'subjectContent',
                'html'      => false,
                'plain'     => 'plainContent'
            )
        );

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'd3HasOrderManagerEditorMailContent',
                array($aEditedValues)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3HasOrderManagerEditorMailContentIsNoPlain()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'isArrayEditorMailContent',
        ));
        $oModelMock->method('isArrayEditorMailContent')->willReturn(true);

        $this->_oModel = $oModelMock;

        $aEditedValues = array(
            'mail'  => array(
                'subject'   => 'subjectContent',
                'html'      => 'htmlContent',
                'plain'     => false
            )
        );

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'd3HasOrderManagerEditorMailContent',
                array($aEditedValues)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function isArrayEditorMailContentPass()
    {
        $aEditedValues = array(
            'mail'  => array()
        );

        $this->assertTrue(
            $this->callMethod(
                $this->_oModel,
                'isArrayEditorMailContent',
                array($aEditedValues)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function isArrayEditorMailContentNoMailArray()
    {
        $aEditedValues = array();

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'isArrayEditorMailContent',
                array($aEditedValues)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function isArrayEditorMailContentNoValuesArray()
    {
        $aEditedValues = null;

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'isArrayEditorMailContent',
                array($aEditedValues)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canGeneratePlainContent()
    {
        /** @var Html2Text|PHPUnit_Framework_MockObject_MockObject $oHtml2TextMock */
        $oHtml2TextMock = $this->getMock(Html2Text::class, array(
            'getText',
        ));
        $oHtml2TextMock->expects($this->once())->method('getText')->willReturn('plainContent');

        d3GetModCfgDIC()->set(Html2Text::class, $oHtml2TextMock);

        $this->assertSame(
            'plainContent',
            $this->callMethod(
                $this->_oModel,
                'd3generatePlainContent',
                array(
                    'HtmlContent'
                )
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canSendOrderManagerMailToOwner()
    {
        /** @var Shop|PHPUnit_Framework_MockObject_MockObject $oFieldMock */
        $oFieldMock = $this->getMock(Shop::class, array(
            'getRawValue',
        ));
        $oFieldMock->method('getRawValue')->willReturn('shopName');
        
        /** @var Shop|PHPUnit_Framework_MockObject_MockObject $oShopMock */
        $oShopMock = $this->getMock(Shop::class, array(
            '__get',
            'getFieldData',
        ));
        $oShopMock->method('__get')->willReturn($oFieldMock);
        $oShopMock->method('getFieldData')->willReturn('info@mail.com');

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'setRecipient',
            '_d3HasOrderManagerCustomMailAddresses',
            '_d3getOrderManagerCustomMailAddressList',
            'AddBcc',
            'd3generateRemark'
        ));
        $oModelMock->expects($this->once())->method('setRecipient')->willReturn(true);
        $oModelMock->method('_d3HasOrderManagerCustomMailAddresses')->willReturn(true);
        $oModelMock->expects($this->exactly(2))->method('AddBcc')->willReturn(true);
        $oModelMock->method('_d3getOrderManagerCustomMailAddressList')->willReturn(
            array(
                'mail1',
                'mail2'
            )
        );
        $returnValue = 'testValue';
        $oModelMock->method('d3generateRemark')->willReturn($returnValue);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $returnValue,
            $this->callMethod(
                $this->_oModel,
                '_d3sendOrderManagerMailToOwner',
                array($oShopMock)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canSendOrderManagerMailToCustom()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            '_d3hasOrderManagerCustomMailAddresses',
            '_d3getOrderManagerCustomMailAddressList',
            'setRecipient',
            'd3generateRemark'
        ));
        $oModelMock->expects($this->once())->method('_d3hasOrderManagerCustomMailAddresses')->willReturn(true);
        $oModelMock->expects($this->exactly(2))->method('setRecipient')->willReturn(true);
        $oModelMock->method('_d3getOrderManagerCustomMailAddressList')->willReturn(
            array(
                'mail1',
                'mail2'
            )
        );
        $returnValue = 'testValue';
        $oModelMock->method('d3generateRemark')->willReturn($returnValue);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $returnValue,
            $this->callMethod(
                $this->_oModel,
                '_d3sendOrderManagerMailToCustom'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canExtractCustomMailAddressList()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            '_d3getOrderManagerCustomRecipientList',
        ));
        $oModelMock->expects($this->once())->method('_d3getOrderManagerCustomRecipientList')->willReturn(
            'mailNo1; mailNo2; '
        );

        $this->_oModel = $oModelMock;

        $this->assertSame(
            array(
                'mailNo1',
                'mailNo2'
            ),
            $this->callMethod(
                $this->_oModel,
                '_d3getOrderManagerCustomMailAddressList'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function hasOrderManagerCustomMailAddressesPass()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            '_d3hasOrderManagerCustomRecipient',
            '_d3getOrderManagerCustomRecipientList',
        ));
        $oModelMock->method('_d3hasOrderManagerCustomRecipient')->willReturn(true);
        $oModelMock->method('_d3getOrderManagerCustomRecipientList')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertTrue(
            $this->callMethod(
                $this->_oModel,
                '_d3HasOrderManagerCustomMailAddresses'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function hasOrderManagerCustomMailAddressesNoCustRecipient()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            '_d3hasOrderManagerCustomRecipient',
            '_d3getOrderManagerCustomRecipientList',
        ));
        $oModelMock->method('_d3hasOrderManagerCustomRecipient')->willReturn(false);
        $oModelMock->method('_d3getOrderManagerCustomRecipientList')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                '_d3HasOrderManagerCustomMailAddresses'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function hasOrderManagerCustomMailAddressesNoCustRecipientList()
    {
        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            '_d3hasOrderManagerCustomRecipient',
            '_d3getOrderManagerCustomRecipientList',
        ));
        $oModelMock->method('_d3hasOrderManagerCustomRecipient')->willReturn(true);
        $oModelMock->method('_d3getOrderManagerCustomRecipientList')->willReturn(false);

        $this->_oModel = $oModelMock;

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                '_d3HasOrderManagerCustomMailAddresses'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3GetRemarkReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Remark::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetRemark'
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canD3sendOrderManagerMailToCustomerOrderUserHasId()
    {
        /** @var Field|PHPUnit_Framework_MockObject_MockObject $oFieldMock */
        $oFieldMock = $this->getMock(Field::class, array(
            'getRawValue',
        ));
        $oFieldMock->method('getRawValue')->willReturn('rawValue');

        /** @var Shop|PHPUnit_Framework_MockObject_MockObject $oShopMock */
        $oShopMock = $this->getMock(Shop::class, array(
            'getFieldData',
            '__get',
        ));
        $oShopMock->method('getFieldData')->willReturn('fieldData');
        $oShopMock->method('__get')->willReturn($oFieldMock);
        
        /** @var User|PHPUnit_Framework_MockObject_MockObject $oOrderUserMock */
        $oOrderUserMock = $this->getMock(User::class, array(
            'getId',
            '__get',
            'getFieldData',
        ));
        $oOrderUserMock->method('getId')->willReturn('orderUserId');
        $oOrderUserMock->expects($this->exactly(2))->method('__get')->willReturn($oFieldMock);
        $oOrderUserMock->method('getFieldData')->willReturn('fieldData');

        /** @var Order|PHPUnit_Framework_MockObject_MockObject $oOrderMock */
        $oOrderMock = $this->getMock(Order::class, array(
            'getOrderUser',
            '__get',
            'getFieldData',
        ));
        $oOrderMock->method('getOrderUser')->willReturn($oOrderUserMock);
        $oOrderMock->expects($this->never())->method('__get')->willReturn($oFieldMock);
        $oOrderMock->method('getFieldData')->willReturn('fieldData');

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getCurrentItem',
        ));
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var Remark|PHPUnit_Framework_MockObject_MockObject $oRemarkMock */
        $oRemarkMock = $this->getMock(Remark::class, array(
            'assign',
        ));
        $oRemarkMock->expects($this->once())->method('assign')->willReturn(true);

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'setRecipient',
            '_d3hasOrderManagerOwnerRecipient',
            'AddBcc',
            '_d3HasOrderManagerCustomMailAddresses',
            '_d3getOrderManagerCustomMailAddressList',
            'd3GetRemark',
        ));
        $oModelMock->method('setRecipient')->willReturn(true);
        $oModelMock->method('_d3hasOrderManagerOwnerRecipient')->willReturn(true);
        $oModelMock->expects($this->exactly(3))->method('AddBcc')->willReturn(true);
        $oModelMock->method('_d3HasOrderManagerCustomMailAddresses')->willReturn(true);
        $oModelMock->method('_d3getOrderManagerCustomMailAddressList')->willReturn(array('addrNo1', 'addrNo2'));
        $oModelMock->method('d3GetRemark')->willReturn($oRemarkMock);

        $this->_oModel = $oModelMock;

        $this->setValue(
            $this->_oModel,
            'oOrderManager',
            $oManagerMock
        );

        $this->assertInstanceOf(
            Remark::class,
            $this->callMethod(
                $this->_oModel,
                '_d3sendOrderManagerMailToCustomer',
                array($oShopMock)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canD3sendOrderManagerMailToCustomerNoOrderUser()
    {
        /** @var Field|PHPUnit_Framework_MockObject_MockObject $oFieldMock */
        $oFieldMock = $this->getMock(Field::class, array(
            'getRawValue',
        ));
        $oFieldMock->method('getRawValue')->willReturn('rawValue');

        /** @var Shop|PHPUnit_Framework_MockObject_MockObject $oShopMock */
        $oShopMock = $this->getMock(Shop::class, array(
            'getFieldData',
            '__get',
        ));
        $oShopMock->method('getFieldData')->willReturn('fieldData');
        $oShopMock->method('__get')->willReturn($oFieldMock);

        /** @var User|PHPUnit_Framework_MockObject_MockObject $oOrderUserMock */
        $oOrderUserMock = $this->getMock(User::class, array(
            'getId',
            '__get',
            'getFieldData',
        ));
        $oOrderUserMock->method('getId')->willReturn(false);
        $oOrderUserMock->expects($this->never())->method('__get')->willReturn($oFieldMock);
        $oOrderUserMock->method('getFieldData')->willReturn('fieldData');

        /** @var Order|PHPUnit_Framework_MockObject_MockObject $oOrderMock */
        $oOrderMock = $this->getMock(Order::class, array(
            'getOrderUser',
            '__get',
            'getFieldData',
        ));
        $oOrderMock->method('getOrderUser')->willReturn($oOrderUserMock);
        $oOrderMock->expects($this->exactly(2))->method('__get')->willReturn($oFieldMock);
        $oOrderMock->method('getFieldData')->willReturn('fieldData');

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getCurrentItem',
        ));
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var Remark|PHPUnit_Framework_MockObject_MockObject $oRemarkMock */
        $oRemarkMock = $this->getMock(Remark::class, array(
            'assign',
        ));
        $oRemarkMock->expects($this->once())->method('assign')->willReturn(true);

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'setRecipient',
            '_d3hasOrderManagerOwnerRecipient',
            'AddBcc',
            '_d3HasOrderManagerCustomMailAddresses',
            '_d3getOrderManagerCustomMailAddressList',
            'd3GetRemark',
        ));
        $oModelMock->method('setRecipient')->willReturn(true);
        $oModelMock->method('_d3hasOrderManagerOwnerRecipient')->willReturn(true);
        $oModelMock->expects($this->exactly(3))->method('AddBcc')->willReturn(true);
        $oModelMock->method('_d3HasOrderManagerCustomMailAddresses')->willReturn(true);
        $oModelMock->method('_d3getOrderManagerCustomMailAddressList')->willReturn(array('addrNo1', 'addrNo2'));
        $oModelMock->method('d3GetRemark')->willReturn($oRemarkMock);

        $this->_oModel = $oModelMock;

        $this->setValue(
            $this->_oModel,
            'oOrderManager',
            $oManagerMock
        );

        $this->assertInstanceOf(
            Remark::class,
            $this->callMethod(
                $this->_oModel,
                '_d3sendOrderManagerMailToCustomer',
                array($oShopMock)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function d3GetPdfHandlerReturnsRightInstance()
    {
        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getCurrentItem',
        ));
        $oManagerMock->method('getCurrentItem')->willReturn(d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class));

        $this->assertInstanceOf(
            d3ordermanager_pdfhandler::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetPdfHandler',
                array($oManagerMock)
            )
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function _d3AddOrderManagerPdfAttachmentPass()
    {
        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, [], [], '', false);

        /** @var d3ordermanager_pdfhandler|PHPUnit_Framework_MockObject_MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMock(d3ordermanager_pdfhandler::class, [],
            array($oManagerMock, d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)));

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'd3GetPdfHandler',
            'addOXIDPdfAttachment',
            'addPdfDocumentsAttachment',
        ));
        $oModelMock->expects($this->once())->method('d3GetPdfHandler')->willReturn($oPdfHandlerMock);
        $oModelMock->expects($this->once())->method('addOXIDPdfAttachment')->willReturn(true);
        $oModelMock->expects($this->once())->method('addPdfDocumentsAttachment')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            '_d3AddOrderManagerPdfAttachment',
            [$oManagerMock]
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canAddOrderManagerOxidPdfAttachmentInvoice()
    {
        /** @var Order|PHPUnit_Framework_MockObject_MockObject $oOrderMock */
        $oOrderMock = $this->getMock(Order::class, [], [], '', false);

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue',
            'getCurrentItem',
        ));
        $getValueMap = [
            ['blActionOrderGeneratePdf_status', true],
            ['blActionOrderPdfSendAttach', true],
            ['blActionOrderPdfTypeInvoice', true],
            ['blActionOrderPdfTypeDelnote', false],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var d3ordermanager_pdfhandler|PHPUnit_Framework_MockObject_MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMock(d3ordermanager_pdfhandler::class, array(
            'canGenerateOxidPdf',
            'createOxidPdf',
            'getOxidPdfFileName',
            'getOxidPdfSaveDir',
        ), array($oManagerMock, d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)));
        $oPdfHandlerMock->method('canGenerateOxidPdf')->willReturn(true);
        $oPdfHandlerMock->expects($this->once())->method('createOxidPdf')->with(
            $this->stringContains(d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_INVOICE),
            $this->anything()
        )->willReturn(true);
        $oPdfHandlerMock->method('getOxidPdfFileName')->willReturn(true);
        $oPdfHandlerMock->method('getOxidPdfSaveDir')->willReturn(true);

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'addAttachment',
        ));
        $oModelMock->expects($this->once())->method('addAttachment')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'addOXIDPdfAttachment',
            array($oManagerMock, $oPdfHandlerMock)
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canAddOrderManagerOxidPdfAttachmentDNote()
    {
        /** @var Order|PHPUnit_Framework_MockObject_MockObject $oOrderMock */
        $oOrderMock = $this->getMock(Order::class, [], [], '', false);

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue',
            'getCurrentItem',
        ));
        $getValueMap = [
            ['blActionOrderGeneratePdf_status', true],
            ['blActionOrderPdfSendAttach', true],
            ['blActionOrderPdfTypeInvoice', false],
            ['blActionOrderPdfTypeDelnote', true],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var d3ordermanager_pdfhandler|PHPUnit_Framework_MockObject_MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMock(d3ordermanager_pdfhandler::class, array(
            'canGenerateOxidPdf',
            'createOxidPdf',
            'getOxidPdfFileName',
            'getOxidPdfSaveDir',
        ), array($oManagerMock, d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)));
        $oPdfHandlerMock->method('canGenerateOxidPdf')->willReturn(true);
        $oPdfHandlerMock->expects($this->once())->method('createOxidPdf')->with(
            $this->stringContains(d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_DELIVERYNOTE),
            $this->anything()
        )->willReturn(true);
        $oPdfHandlerMock->method('getOxidPdfFileName')->willReturn(true);
        $oPdfHandlerMock->method('getOxidPdfSaveDir')->willReturn(true);

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'addAttachment',
        ));
        $oModelMock->expects($this->once())->method('addAttachment')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'addOXIDPdfAttachment',
            array($oManagerMock, $oPdfHandlerMock)
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3AddOrderManagerPdfAttachment
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::addPdfDocumentsAttachment
     * @test
     * @throws ReflectionException
     */
    public function canAddOrderManagerPdfDocumentAttachment()
    {
        /** @var Order|PHPUnit_Framework_MockObject_MockObject $oOrderMock */
        $oOrderMock = $this->getMock(Order::class, [], [], '', false);

        /** @var invoicePdf|PHPUnit_Framework_MockObject_MockObject $oDocumentMock */
        $oDocumentMock = $this->getMock(invoicePdf::class,
            ['getFilename']
        );
        $oDocumentMock->method('getFilename')->willReturn('testFileName');
        
        /** @var d3ordermanager_action_getpdfdocuments|PHPUnit_Framework_MockObject_MockObject $oActionMock */
        $oActionMock = $this->getMock(d3ordermanager_action_getpdfdocuments::class,
            ['getDocumentList', 'getOrder'],
            [], '', false
        );
        $oActionMock->method('getDocumentList')->willReturn([$oDocumentMock]);
        $oActionMock->method('getOrder')->willReturn(oxNew(Order::class));
        d3GetModCfgDIC()->set(d3ordermanager_action_getpdfdocuments::class, $oActionMock);

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue',
            'getCurrentItem',
        ));
        $getValueMap = [
            ['blActionOrderGetPdfDocument_status', true],
            ['blActionOrderPdfDocumentSendAttach', true],
            ['blActionOrderPdfDocumentType_invoice', true],
            ['blActionOrderPdfDocumentType_delnote', false],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var d3ordermanager_pdfhandler|PHPUnit_Framework_MockObject_MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMock(d3ordermanager_pdfhandler::class, array(
            'canGeneratePdfDocuments',
            'createPdfDocument',
            'getOxidPdfSaveDir',
        ), array($oManagerMock, d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)));
        $oPdfHandlerMock->method('canGeneratePdfDocuments')->willReturn(true);
        $oPdfHandlerMock->expects($this->once())->method('createPdfDocument')->with(
            $this->isInstanceOf(invoicePdf::class),
            $this->anything()
        )->willReturn(true);
        $oPdfHandlerMock->method('getOxidPdfSaveDir')->willReturn(true);

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'addAttachment',
        ));
        $oModelMock->expects($this->once())->method('addAttachment')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'addPdfDocumentsAttachment',
            array($oManagerMock, $oPdfHandlerMock)
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canSetOrderManagerReplyAddressWithReply()
    {
        /** @var Field|PHPUnit_Framework_MockObject_MockObject $oFieldMock */
        $oFieldMock = $this->getMock(Field::class, array(
            'getRawValue',
        ));
        $oFieldMock->method('getRawValue')->willReturn('rawValue');
        
        /** @var Shop|PHPUnit_Framework_MockObject_MockObject $oShopMock */
        $oShopMock = $this->getMock(Shop::class, array(
            '__get',
            'getFieldData',
        ));
        $oShopMock->method('__get')->willReturn($oFieldMock);
        $oShopMock->method('getFieldData')->willReturn('fieldData');

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue',
        ));
        $getValueMap = [
            ['sSendMailReplyAddress', 'reply@test.com'],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'setFrom',
            'setReplyTo',
        ));
        $oModelMock->expects($this->once())->method('setFrom')->willReturn(true);
        $oModelMock->expects($this->once())->method('setReplyTo')->willReturn(true);

        $this->_oModel = $oModelMock;
        
        $this->callMethod(
            $this->_oModel,
            '_d3SetOrderManagerReplyAddress',
            array($oManagerMock, $oShopMock)
        );
    }

    /**
     * @test
     * @throws ReflectionException
     */
    public function canSetOrderManagerReplyAddressWithoutReply()
    {
        /** @var Field|PHPUnit_Framework_MockObject_MockObject $oFieldMock */
        $oFieldMock = $this->getMock(Field::class, array(
            'getRawValue',
        ));
        $oFieldMock->method('getRawValue')->willReturn('rawValue');

        /** @var Shop|PHPUnit_Framework_MockObject_MockObject $oShopMock */
        $oShopMock = $this->getMock(Shop::class, array(
            '__get',
            'getFieldData',
        ));
        $oShopMock->method('__get')->willReturn($oFieldMock);
        $oShopMock->method('getFieldData')->willReturn('fieldData');

        /** @var d3ordermanager|PHPUnit_Framework_MockObject_MockObject $oManagerMock */
        $oManagerMock = $this->getMock(d3ordermanager::class, array(
            'getValue',
        ));
        $getValueMap = [
            ['sSendMailReplyAddress', null],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxemail_ordermanager|PHPUnit_Framework_MockObject_MockObject $oModelMock */
        $oModelMock = $this->getMock(Email::class, array(
            'setFrom',
            'setReplyTo',
        ));
        $oModelMock->expects($this->never())->method('setFrom')->willReturn(true);
        $oModelMock->expects($this->once())->method('setReplyTo')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            '_d3SetOrderManagerReplyAddress',
            array($oManagerMock, $oShopMock)
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