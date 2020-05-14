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
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_conf;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
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
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ShopConfigurationDaoBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ModuleConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateEngineInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateRendererBridgeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::__construct
     * @test
     */
    public function constructorPass()
    {
        $this->assertEquals(
            'd3_ordermanager',
            d3GetModCfgDIC()->getParameter('d3.ordermanager.modcfgid')
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_getTemplateEngine
     * @test
     * @throws ReflectionException
     */
    public function templateEngineHasRightInstance()
    {
        $this->assertInstanceOf(
            TemplateEngineInterface::class,
            $this->callMethod(
                $this->_oModel,
                '_getTemplateEngine'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3sendOrderManagerEmail
     * @test
     * @throws ReflectionException
     */
    public function canSendOrderManagerEmail()
    {
        /** @var Shop|MockObject $oFieldMock */
        $oFieldMock = $this->getMockBuilder(Shop::class)
            ->setMethods(['getRawValue'])
            ->getMock();
        $oFieldMock->method('getRawValue')->willReturn('value');
        
        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->setMethods([
                '__get',
                'getFieldData'
            ])
            ->getMock();
        $oShopMock->method('__get')->willReturn($oFieldMock);
        $oShopMock->method('getFieldData')->willReturn('value');

        /** @var d3log|MockObject $oD3LogMock */
        $oD3LogMock = $this->getMockBuilder(d3log::class)
            ->setMethods(['log'])
            ->getMock();
        $oD3LogMock->method('log')->willReturn(true);
        
        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['d3getLog'])
            ->getMock();
        $oModCfgMock->method('d3getLog')->willReturn($oD3LogMock);

        $templateEngineClass = get_class(ContainerFactory::getInstance()->getContainer()->get(TemplateEngineInterface::class));

        /** @var TemplateEngineInterface|MockObject $templateEngineMock */
        $templateEngineMock = $this->getMockBuilder($templateEngineClass)
            ->setMethods(['render'])
            ->disableOriginalConstructor()
            ->getMock();
        $templateEngineMock->method('render')->willReturn('renderedTemplateContent');

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                '_getShop',
                '_getTemplateEngine',
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
                'send'
            ])
            ->getMock();
        $oModelMock->method('_getShop')->willReturn($oShopMock);
        $oModelMock->method('_getTemplateEngine')->willReturn($templateEngineMock);
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
                [[]]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3getOrder
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canLoadOrderUniqueOxid()
    {
        /** @var d3ordermanagerlist|MockObject $oOrderManagerListMock */
        $oOrderManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->setMethods(['d3GetOrderSaveTriggeredManagerTasks'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3getOrder
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canLoadOrderOxidPartOfOtherData()
    {
        /** @var d3ordermanagerlist|MockObject $oOrderManagerListMock */
        $oOrderManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->setMethods(['d3GetOrderSaveTriggeredManagerTasks'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3getOrderManager
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::sendOrderManagerMail
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canStartSendingOrderManagerMail()
    {
        /** @var Remark|MockObject $oRemarkMock */
        $oRemarkMock = $this->getMockBuilder(Remark::class)
            ->setMethods(['save'])
            ->getMock();
        $oRemarkMock->expects($this->once())->method('save')->willReturn(true);
        
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'getOrderManagerMailContent',
                '_getShop',
                'setBody',
                'setAltBody',
                'setSubject',
                '_d3SetOrderManagerReplyAddress',
                '_d3SetOrderManagerMailRecipients',
                '_d3AddOrderManagerPdfAttachment',
                'send'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3SetOrderManagerMailRecipients
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canSetOrderManagerMailRecipientsCustomer()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                '_d3hasOrderManagerCustomerRecipient',
                '_d3sendOrderManagerMailToCustomer',
                '_d3hasOrderManagerOwnerRecipient',
                '_d3sendOrderManagerMailToOwner',
                '_d3hasOrderManagerCustomRecipient',
                '_d3sendOrderManagerMailToCustom'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3SetOrderManagerMailRecipients
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canSetOrderManagerMailRecipientsOwner()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                '_d3hasOrderManagerCustomerRecipient',
                '_d3sendOrderManagerMailToCustomer',
                '_d3hasOrderManagerOwnerRecipient',
                '_d3sendOrderManagerMailToOwner',
                '_d3hasOrderManagerCustomRecipient',
                '_d3sendOrderManagerMailToCustom'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3SetOrderManagerMailRecipients
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canSetOrderManagerMailRecipientsCustom()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                '_d3hasOrderManagerCustomerRecipient',
                '_d3sendOrderManagerMailToCustomer',
                '_d3hasOrderManagerOwnerRecipient',
                '_d3sendOrderManagerMailToOwner',
                '_d3hasOrderManagerCustomRecipient',
                '_d3sendOrderManagerMailToCustom'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3getOrderManagerMailOption
     * @test
     * @throws ReflectionException
     */
    public function canGgetOrderManagerMailOptionEdited()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods([
                'getValue',
                'getEditedValues'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3getOrderManagerMailOption
     * @test
     * @throws ReflectionException
     */
    public function canGgetOrderManagerMailOptionObject()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods([
                'getValue',
                'getEditedValues'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3hasOrderManagerCustomerRecipient
     * @test
     * @throws ReflectionException
     */
    public function canHasOrderManagerCustomerRecipient()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods(['_d3getOrderManagerMailOption'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3hasOrderManagerOwnerRecipient
     * @test
     * @throws ReflectionException
     */
    public function canHasOrderManagerOwnerRecipient()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods(['_d3getOrderManagerMailOption'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3hasOrderManagerCustomRecipient
     * @test
     * @throws ReflectionException
     */
    public function canHasOrderManagerCustomRecipient()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods(['_d3getOrderManagerMailOption'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3getOrderManagerCustomRecipientList
     * @test
     * @throws ReflectionException
     */
    public function canGetOrderManagerCustomRecipientList()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods(['_d3getOrderManagerMailOption'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3GetSet
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3GetPayment
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3GetLang
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3GetConfig
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::getOrderManagerMailContent
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetOrderManagerMailContentAdminTpl()
    {
        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['getLicenseConfigData'])
            ->getMock();
        $oModCfgMock->method('getLicenseConfigData')->willReturn(false);
        
        /** @var Language|MockObject $oLanguageMock */
        $oLanguageMock = $this->getMockBuilder(Language::class)
            ->setMethods(['translateString'])
            ->getMock();
        $oLanguageMock->method('translateString')->willReturn(true);
        
        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->setMethods([
                'getTemplateDir',
                'setAdminMode'
            ])
            ->getMock();
        $oConfigMock->method('getTemplateDir')->willReturn(true);
        $oConfigMock->expects($this->exactly(2))->method('setAdminMode')->with(
            $this->isTrue()
        )->willReturn(true);

        /** @var Payment|MockObject $oPaymentMock */
        $oPaymentMock = $this->getMockBuilder(Payment::class)
            ->setMethods(['load'])
            ->getMock();
        $oPaymentMock->method('load')->willReturn(true);
        
        /** @var Basket|MockObject $oBasketMock */
        $oBasketMock = $this->getMockBuilder(Basket::class)
            ->setMethods(['getPaymentId'])
            ->getMock();
        $oBasketMock->method('getPaymentId')->willReturn(true);
        
        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->setMethods([
                'd3getOrderBasket4OrderManager',
                'd3setBasket4OrderManager',
                'd3setPayment4OrderManager',
                'getOrderUser',
                'getDelSet',
                'getOrderCurrency'
            ])
            ->getMock();
        $oOrderMock->method('d3getOrderBasket4OrderManager')->willReturn($oBasketMock);
        $oOrderMock->method('d3setBasket4OrderManager')->willReturn(true);
        $oOrderMock->method('d3setPayment4OrderManager')->willReturn(true);
        $oOrderMock->method('getOrderUser')->willReturn(true);
        $oOrderMock->method('getDelSet')->willReturn(true);
        $oOrderMock->method('getOrderCurrency')->willReturn(true);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods([
                'getValue',
                'getCurrentItem'
            ])
            ->getMock();
        $getValueMap = [['sSendMailFromTheme', 'admin']];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        $templateEngine = ContainerFactory::getInstance()->getContainer()
            ->get(TemplateRendererBridgeInterface::class)
            ->getTemplateRenderer()->getTemplateEngine();

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                '_getShop',
                '_setMailParams',
                '_getTemplateRenderer',
                'd3GetPayment',
                'setViewData',
                'getViewConfig',
                'd3GetConfig',
                'd3GetLang',
                'getTemplateDir4OrderManager',
                '_processViewArray',
                'd3GetSet',
                'd3SendMailHook',
                '_d3GenerateOrderManagerMailContent'
            ])
            ->getMock();
        $oModelMock->method('_getShop')->willReturn(true);
        $oModelMock->method('_setMailParams')->willReturn(true);
        $oModelMock->method('_getTemplateRenderer')->willReturn($templateEngine);
        $oModelMock->method('d3GetPayment')->willReturn($oPaymentMock);
        $oModelMock->method('setViewData')->willReturn(true);
        $oModelMock->method('getViewConfig')->willReturn(true);
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetLang')->willReturn($oLanguageMock);
        $oModelMock->method('getTemplateDir4OrderManager')->willReturn(true);
        $oModelMock->method('_processViewArray')->willReturn(true);
        $oModelMock->method('d3GetSet')->willReturn($oModCfgMock);
        $oModelMock->method('d3SendMailHook')->willReturn($templateEngine);
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::getOrderManagerMailContent
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetOrderManagerMailContentFrontendTpl()
    {
        /** @var stdClass|MockObject $oModCfgMock */
        $oModCfgMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['getLicenseConfigData'])
            ->getMock();
        $oModCfgMock->method('getLicenseConfigData')->willReturn(false);

        /** @var Language|MockObject $oLanguageMock */
        $oLanguageMock = $this->getMockBuilder(Language::class)
            ->setMethods(['translateString'])
            ->getMock();
        $oLanguageMock->method('translateString')->willReturn(true);

        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->setMethods([
                'getTemplateDir',
                'setAdminMode'
            ])
            ->getMock();
        $oConfigMock->method('getTemplateDir')->willReturn(true);
        $oConfigMock->expects($this->exactly(2))->method('setAdminMode')->withConsecutive(
            [$this->isFalse()],
            [$this->isTrue()]
        )->willReturn(true);

        /** @var Payment|MockObject $oPaymentMock */
        $oPaymentMock = $this->getMockBuilder(Payment::class)
            ->setMethods(['load'])
            ->getMock();
        $oPaymentMock->method('load')->willReturn(true);

        /** @var Basket|MockObject $oBasketMock */
        $oBasketMock = $this->getMockBuilder(Basket::class)
            ->setMethods(['getPaymentId'])
            ->getMock();
        $oBasketMock->method('getPaymentId')->willReturn(true);

        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->setMethods([
                'd3getOrderBasket4OrderManager',
                'd3setBasket4OrderManager',
                'd3setPayment4OrderManager',
                'getOrderUser',
                'getDelSet',
                'getOrderCurrency'
            ])
            ->getMock();
        $oOrderMock->method('d3getOrderBasket4OrderManager')->willReturn($oBasketMock);
        $oOrderMock->method('d3setBasket4OrderManager')->willReturn(true);
        $oOrderMock->method('d3setPayment4OrderManager')->willReturn(true);
        $oOrderMock->method('getOrderUser')->willReturn(true);
        $oOrderMock->method('getDelSet')->willReturn(true);
        $oOrderMock->method('getOrderCurrency')->willReturn(true);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods([
                'getValue',
                'getCurrentItem'
            ])
            ->getMock();
        $getValueMap = [['sSendMailFromTheme', 'frontend']];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        $templateEngine = ContainerFactory::getInstance()->getContainer()
            ->get(TemplateRendererBridgeInterface::class)
            ->getTemplateRenderer()->getTemplateEngine();

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                '_getShop',
                '_setMailParams',
                '_getTemplateRenderer',
                'd3GetPayment',
                'setViewData',
                'getViewConfig',
                'd3GetConfig',
                'd3GetLang',
                'getTemplateDir4OrderManager',
                '_processViewArray',
                'd3GetSet',
                'd3SendMailHook',
                '_d3GenerateOrderManagerMailContent'
            ])
            ->getMock();
        $oModelMock->method('_getShop')->willReturn(true);
        $oModelMock->method('_setMailParams')->willReturn(true);
        $oModelMock->method('_getTemplateRenderer')->willReturn($templateEngine);
        $oModelMock->method('d3GetPayment')->willReturn($oPaymentMock);
        $oModelMock->method('setViewData')->willReturn(true);
        $oModelMock->method('getViewConfig')->willReturn(true);
        $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);
        $oModelMock->method('d3GetLang')->willReturn($oLanguageMock);
        $oModelMock->method('getTemplateDir4OrderManager')->willReturn(true);
        $oModelMock->method('_processViewArray')->willReturn(true);
        $oModelMock->method('d3GetSet')->willReturn($oModCfgMock);
        $oModelMock->method('d3SendMailHook')->willReturn($templateEngine);
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::getTemplateDir4OrderManager
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetTemplateDir4OrderManagerModule()
    {
        $container = ContainerFactory::getInstance()->getContainer();
        $shopConfiguration = $container->get(ShopConfigurationDaoBridgeInterface::class)->get();

        $moduleA = new ModuleConfiguration();
        $moduleA
            ->setId('d3module1')
            ->setPath('d3module1Path')
            ->setTitle([
                'de' => 'TestModule A '.__METHOD__,
                'en' => 'TestModule A '.__METHOD__
            ]);
        $shopConfiguration->addModuleConfiguration($moduleA);

        $container->get(ShopConfigurationDaoBridgeInterface::class)->save($shopConfiguration);

        try {
            /** @var Config|MockObject $oConfigMock */
            $oConfigMock = $this->getMockBuilder(Config::class)
                ->setMethods(['getTemplateDir'])
                ->getMock();
            $oConfigMock->expects($this->never())->method('getTemplateDir')->willReturn('returnValue');

            /** @var d3str|MockObject $oD3StrMock */
            $oD3StrMock = $this->getMockBuilder(d3str::class)
                ->setMethods(['untrailingslashit'])
                ->getMock();
            $oD3StrMock->method('untrailingslashit')->willReturnArgument(0);

            /** @var d3ordermanager|MockObject $oManagerMock */
            $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
                ->setMethods(['getValue'])
                ->getMock();
            $getValueMap = [
                ['sSendMailFromTheme', 'module'],
                ['sSendMailFromModulePath', 'd3module1'],
            ];
            $oManagerMock->method('getValue')->willReturnMap($getValueMap);

            /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
            $oModelMock = $this->getMockBuilder(Email::class)
                ->setMethods([
                    'getD3Str',
                    'd3GetConfig'
                ])
                ->getMock();
            $oModelMock->method('getD3Str')->willReturn($oD3StrMock);
            $oModelMock->method('d3GetConfig')->willReturn($oConfigMock);

            $this->_oModel = $oModelMock;

            $this->assertContains(
                'source/modules/d3module1Path',
                $this->callMethod(
                    $this->_oModel,
                    'getTemplateDir4OrderManager',
                    array($oManagerMock)
                )
            );
        } finally {
            $shopConfiguration->deleteModuleConfiguration($moduleA->getId());

            $container->get(ShopConfigurationDaoBridgeInterface::class)->save($shopConfiguration);
        }
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::getTemplateDir4OrderManager
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetTemplateDir4OrderManagerAdmin()
    {
        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->setMethods(['getTemplateDir'])
            ->getMock();
        $oConfigMock->expects($this->once())->method('getTemplateDir')->with(
            $this->isTrue()
        )->willReturn('returnValue');

        /** @var d3str|MockObject $oD3StrMock */
        $oD3StrMock = $this->getMockBuilder(d3str::class)
            ->setMethods(['untrailingslashit'])
            ->getMock();
        $oD3StrMock->method('untrailingslashit')->willReturn('returnValue');

        /** @var d3ShopCompatibilityAdapterHandler|MockObject $oShopCompatHandlerMock */
        $oShopCompatHandlerMock = $this->getMockBuilder(d3ShopCompatibilityAdapterHandler::class)
            ->setMethods(['call'])
            ->getMock();
        $oShopCompatHandlerMock->expects($this->never())->method('call')->willReturn('fullPath');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getValue'])
            ->getMock();
        $getValueMap = [
            ['sSendMailFromTheme', 'admin'],
            ['sSendMailFromModulePath', 'module'],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'd3GetShopCompatibilityAdapterHandler',
                'getD3Str',
                'd3GetConfig'
            ])
            ->getMock();
        $oModelMock->method('d3GetShopCompatibilityAdapterHandler')->willReturn($oShopCompatHandlerMock);
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::getTemplateDir4OrderManager
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetTemplateDir4OrderManagerFrontend()
    {
        /** @var Config|MockObject $oConfigMock */
        $oConfigMock = $this->getMockBuilder(Config::class)
            ->setMethods(['getTemplateDir'])
            ->getMock();
        $oConfigMock->expects($this->once())->method('getTemplateDir')->with(
            $this->isFalse()
        )->willReturn('returnValue');

        /** @var d3str|MockObject $oD3StrMock */
        $oD3StrMock = $this->getMockBuilder(d3str::class)
            ->setMethods(['untrailingslashit'])
            ->getMock();
        $oD3StrMock->method('untrailingslashit')->willReturn('returnValue');

        /** @var d3ShopCompatibilityAdapterHandler|MockObject $oShopCompatHandlerMock */
        $oShopCompatHandlerMock = $this->getMockBuilder(d3ShopCompatibilityAdapterHandler::class)
            ->setMethods(['call'])
            ->getMock();
        $oShopCompatHandlerMock->expects($this->never())->method('call')->willReturn('fullPath');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getValue'])
            ->getMock();
        $getValueMap = [
            ['sSendMailFromTheme', 'frontend'],
            ['sSendMailFromModulePath', 'module'],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'd3GetShopCompatibilityAdapterHandler',
                'getD3Str',
                'd3GetConfig'
            ])
            ->getMock();
        $oModelMock->method('d3GetShopCompatibilityAdapterHandler')->willReturn($oShopCompatHandlerMock);
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3SendMailHook
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function d3SendMailHookReturnsRightInstance()
    {
        $this->assertInstanceOf(
            TemplateEngineInterface::class,
            $this->callMethod(
                $this->_oModel,
                'd3SendMailHook',
                array(
                    ContainerFactory::getInstance()->getContainer()
                        ->get(TemplateRendererBridgeInterface::class)
                        ->getTemplateRenderer()->getTemplateEngine()
                )
            )
        );
    }

    /**
     * @coversNothing
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3GetContent
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::getD3Str
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3GenerateOrderManagerMailContent
     * @test
     * @throws ReflectionException
     */
    public function _d3GenerateOrderManagerMailContentFromEditor()
    {
        $currLangId = 2;
        $orderLangId = 3;

        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->setMethods(['getFieldData'])
            ->getMock();
        $getFieldDataMap = [
            ['oxlang', $orderLangId],
        ];
        $oOrderMock->method('getFieldData')->willReturnMap($getFieldDataMap);
        
        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->setMethods([
                'getTplLanguage',
                'setTplLanguage'
            ])
            ->getMock();

        $oLangMock->method('getTplLanguage')->willReturn($currLangId);
        $oLangMock->expects($this->exactly(2))->method('setTplLanguage')
            ->withConsecutive([$orderLangId], [$currLangId])->willReturn(true);

        // can't use a mock of UtilsView, because extension issue
        /** @var stdClass|MockObject $oUtilsViewMock */
        $oUtilsViewMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['getRenderedContent'])
            ->getMock();
        $oUtilsViewMock->expects($this->never())->method('getRenderedContent')->willReturn(true);
        
        /** @var Content|MockObject $oContentMock */
        $oContentMock = $this->getMockBuilder(Content::class)
            ->setMethods([
                'setLanguage',
                'load',
                'getFieldData',
                'getId'
            ])
            ->getMock();
        $oContentMock->method('setLanguage')->willReturn(true);
        $oContentMock->expects($this->never())->method('load')->willReturn(true);
        $oContentMock->method('getFieldData')->willReturn(true);
        $oContentMock->method('getId')->willReturn(true);

        $templateEngineClass = get_class(ContainerFactory::getInstance()->getContainer()->get(TemplateEngineInterface::class));

        /** @var TemplateEngineInterface|MockObject $templateEngineMock */
        $templateEngineMock = $this->getMockBuilder($templateEngineClass)
            ->setMethods(['render'])
            ->disableOriginalConstructor()
            ->getMock();
        $templateEngineMock->expects($this->never())->method('render')->willReturn('renderedTemplateContent');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods([
                'getEditedValues',
                'getValue',
                'getCurrentItem'
            ])
            ->getMock();
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

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'd3HasOrderManagerEditorMailContent',
                'd3GetLang',
                'd3GetUtilsView',
                'd3GetContent'
            ])
            ->getMock();
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
                    $templateEngineMock
                )
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3GenerateOrderManagerMailContent
     * @test
     * @throws ReflectionException
     */
    public function _d3GenerateOrderManagerMailContentFromEditorGeneratedPlain()
    {
        $currLangId = 2;
        $orderLangId = 3;

        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->setMethods(['getFieldData'])
            ->getMock();

        $getFieldDataMap = [
            ['oxlang', $orderLangId],
        ];
        $oOrderMock->method('getFieldData')->willReturnMap($getFieldDataMap);

        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->setMethods([
                'getTplLanguage',
                'setTplLanguage'
            ])
            ->getMock();

        $oLangMock->method('getTplLanguage')->willReturn($currLangId);
        $oLangMock->expects($this->exactly(2))->method('setTplLanguage')
            ->withConsecutive([$orderLangId], [$currLangId])->willReturn(true);

        // can't use a mock of UtilsView, because extension issue
        /** @var stdClass|MockObject $oUtilsViewMock */
        $oUtilsViewMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['getRenderedContent'])
            ->getMock();
        $oUtilsViewMock->expects($this->never())->method('getRenderedContent')->willReturn(true);

        /** @var Content|MockObject $oContentMock */
        $oContentMock = $this->getMockBuilder(Content::class)
            ->setMethods([
                'setLanguage',
                'load',
                'getFieldData',
                'getId'
            ])
            ->getMock();
        $oContentMock->method('setLanguage')->willReturn(true);
        $oContentMock->expects($this->never())->method('load')->willReturn(true);
        $oContentMock->method('getFieldData')->willReturn(true);
        $oContentMock->method('getId')->willReturn(true);

        $templateEngineClass = get_class(ContainerFactory::getInstance()->getContainer()->get(TemplateEngineInterface::class));

        /** @var TemplateEngineInterface|MockObject $templateEngineMock */
        $templateEngineMock = $this->getMockBuilder($templateEngineClass)
            ->setMethods(['render'])
            ->disableOriginalConstructor()
            ->getMock();
        $templateEngineMock->expects($this->never())->method('render')->willReturn('renderedTemplateContent');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods([
                'getEditedValues',
                'getValue',
                'getCurrentItem'
            ])
            ->getMock();
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

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'd3HasOrderManagerEditorMailContent',
                'd3GetLang',
                'd3GetUtilsView',
                'd3GetContent'
            ])
            ->getMock();
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
                    $templateEngineMock
                )
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3GenerateOrderManagerMailContent
     * @test
     * @throws ReflectionException
     */
    public function _d3GenerateOrderManagerMailContentFromCms()
    {
        $currLangId = 2;
        $orderLangId = 3;

        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->setMethods(['getFieldData'])
            ->getMock();

        $getFieldDataMap = [
            ['oxlang', $orderLangId],
        ];
        $oOrderMock->method('getFieldData')->willReturnMap($getFieldDataMap);

        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->setMethods([
                'getTplLanguage',
                'setTplLanguage'
            ])
            ->getMock();

        $oLangMock->method('getTplLanguage')->willReturn($currLangId);
        $oLangMock->expects($this->exactly(2))->method('setTplLanguage')
            ->withConsecutive([$orderLangId], [$currLangId])->willReturn(true);

        // can't use a mock of UtilsView, because extension issue
        /** @var stdClass|MockObject $oUtilsViewMock */
        $oUtilsViewMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['getRenderedContent'])
            ->getMock();
        $oUtilsViewMock->expects($this->exactly(2))->method('getRenderedContent')->willReturn('renderedTemplateContent');

        /** @var Content|MockObject $oContentMock */
        $oContentMock = $this->getMockBuilder(Content::class)
            ->setMethods([
                'setLanguage',
                'load',
                'getFieldData',
                'getId'
            ])
            ->getMock();
        $oContentMock->method('setLanguage')->willReturn(true);
        $oContentMock->expects($this->exactly(2))->method('load')->willReturn(true);
        $oContentMock->method('getFieldData')->willReturn('fieldData');
        $oContentMock->method('getId')->willReturn(true);

        $templateEngineClass = get_class(ContainerFactory::getInstance()->getContainer()->get(TemplateEngineInterface::class));

        /** @var TemplateEngineInterface|MockObject $templateEngineMock */
        $templateEngineMock = $this->getMockBuilder($templateEngineClass)
            ->setMethods(['render'])
            ->disableOriginalConstructor()
            ->getMock();
        $templateEngineMock->expects($this->never())->method('render')->willReturn('renderedTemplateContent');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods([
                'getEditedValues',
                'getValue',
                'getCurrentItem'
            ])
            ->getMock();
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

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'd3HasOrderManagerEditorMailContent',
                'd3GetLang',
                'd3GetUtilsView',
                'd3GetContent'
            ])
            ->getMock();
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
                'plain'     => 'renderedTemplateContent',
                'html'      => 'renderedTemplateContent',
            ),
            $this->callMethod(
                $this->_oModel,
                '_d3GenerateOrderManagerMailContent',
                array(
                    array(),
                    $templateEngineMock
                )
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3GenerateOrderManagerMailContent
     * @test
     * @throws ReflectionException
     */
    public function _d3GenerateOrderManagerMailContentFromTpl()
    {
        $currLangId = 2;
        $orderLangId = 3;

        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->setMethods(['getFieldData'])
            ->getMock();

        $getFieldDataMap = [
            ['oxlang', $orderLangId],
        ];
        $oOrderMock->method('getFieldData')->willReturnMap($getFieldDataMap);

        /** @var Language|MockObject $oLangMock */
        $oLangMock = $this->getMockBuilder(Language::class)
            ->setMethods([
                'getTplLanguage',
                'setTplLanguage'
            ])
            ->getMock();

        $oLangMock->method('getTplLanguage')->willReturn($currLangId);
        $oLangMock->expects($this->exactly(2))->method('setTplLanguage')
            ->withConsecutive([$orderLangId], [$currLangId])->willReturn(true);

        // can't use a mock of UtilsView, because extension issue
        /** @var stdClass|MockObject $oUtilsViewMock */
        $oUtilsViewMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['getRenderedContent'])
            ->getMock();
        $oUtilsViewMock->expects($this->never())->method('getRenderedContent')->willReturn('renderedTemplateContent');

        /** @var Content|MockObject $oContentMock */
        $oContentMock = $this->getMockBuilder(Content::class)
            ->setMethods([
                'setLanguage',
                'load',
                'getFieldData',
                'getId'
            ])
            ->getMock();
        $oContentMock->method('setLanguage')->willReturn(true);
        $oContentMock->expects($this->never())->method('load')->willReturn(true);
        $oContentMock->method('getFieldData')->willReturn('fieldData');
        $oContentMock->method('getId')->willReturn(true);

        $templateEngineClass = get_class(ContainerFactory::getInstance()->getContainer()->get(TemplateEngineInterface::class));

        /** @var TemplateEngineInterface|MockObject $templateEngineMock */
        $templateEngineMock = $this->getMockBuilder($templateEngineClass)
            ->setMethods(['render'])
            ->disableOriginalConstructor()
            ->getMock();
        $templateEngineMock->expects($this->exactly(3))->method('render')->willReturn('renderedTemplateContent');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods([
                'getEditedValues',
                'getValue',
                'getCurrentItem'
            ])
            ->getMock();
        $getValueMap = [
            ['sSendMailFromSource', 'template'],
            ['sSendMailFromTemplatename', 'HtmlTpl'],
            ['sSendMailFromTemplatenamePlain', 'PlainTpl'],
            ['sSendMailFromSubject', 'SubjectTpl']
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

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'd3HasOrderManagerEditorMailContent',
                'd3GetLang',
                'd3GetUtilsView',
                'd3GetContent'
            ])
            ->getMock();
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
                'subject'   => 'renderedTemplateContent',
                'plain'     => 'renderedTemplateContent',
                'html'      => 'renderedTemplateContent',
            ),
            $this->callMethod(
                $this->_oModel,
                '_d3GenerateOrderManagerMailContent',
                array(
                    array(),
                    $templateEngineMock
                )
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3HasOrderManagerEditorMailContent
     * @test
     * @throws ReflectionException
     */
    public function d3HasOrderManagerEditorMailContentPass()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods(['isArrayEditorMailContent'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3HasOrderManagerEditorMailContent
     * @test
     * @throws ReflectionException
     */
    public function d3HasOrderManagerEditorMailContentIsNoArray()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods(['isArrayEditorMailContent'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3HasOrderManagerEditorMailContent
     * @test
     * @throws ReflectionException
     */
    public function d3HasOrderManagerEditorMailContentIsNoSubject()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods(['isArrayEditorMailContent'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3HasOrderManagerEditorMailContent
     * @test
     * @throws ReflectionException
     */
    public function d3HasOrderManagerEditorMailContentIsNoHtml()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods(['isArrayEditorMailContent'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3HasOrderManagerEditorMailContent
     * @test
     * @throws ReflectionException
     */
    public function d3HasOrderManagerEditorMailContentIsNoPlain()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods(['isArrayEditorMailContent'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::isArrayEditorMailContent
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::isArrayEditorMailContent
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::isArrayEditorMailContent
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3generatePlainContent
     * @test
     * @throws ReflectionException
     */
    public function canGeneratePlainContent()
    {
        /** @var Html2Text|MockObject $oHtml2TextMock */
        $oHtml2TextMock = $this->getMockBuilder(Html2Text::class)
            ->setMethods(['getText'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3sendOrderManagerMailToOwner
     * @test
     * @throws ReflectionException
     */
    public function canSendOrderManagerMailToOwner()
    {
        /** @var Shop|MockObject $oFieldMock */
        $oFieldMock = $this->getMockBuilder(Shop::class)
            ->setMethods(['getRawValue'])
            ->getMock();
        $oFieldMock->method('getRawValue')->willReturn('shopName');
        
        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->setMethods([
                '__get',
                'getFieldData'
            ])
            ->getMock();
        $oShopMock->method('__get')->willReturn($oFieldMock);
        $oShopMock->method('getFieldData')->willReturn('info@mail.com');

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'setRecipient',
                '_d3HasOrderManagerCustomMailAddresses',
                '_d3getOrderManagerCustomMailAddressList',
                'AddBcc',
                'd3generateRemark'
            ])
            ->getMock();

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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3sendOrderManagerMailToCustom
     * @test
     * @throws ReflectionException
     */
    public function canSendOrderManagerMailToCustom()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                '_d3hasOrderManagerCustomMailAddresses',
                '_d3getOrderManagerCustomMailAddressList',
                'setRecipient',
                'd3generateRemark'
            ])
            ->getMock();

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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3getOrderManagerCustomMailAddressList
     * @test
     * @throws ReflectionException
     */
    public function canExtractCustomMailAddressList()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods(['_d3getOrderManagerCustomRecipientList'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3HasOrderManagerCustomMailAddresses
     * @test
     * @throws ReflectionException
     */
    public function hasOrderManagerCustomMailAddressesPass()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                '_d3hasOrderManagerCustomRecipient',
                '_d3getOrderManagerCustomRecipientList'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3HasOrderManagerCustomMailAddresses
     * @test
     * @throws ReflectionException
     */
    public function hasOrderManagerCustomMailAddressesNoCustRecipient()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                '_d3hasOrderManagerCustomRecipient',
                '_d3getOrderManagerCustomRecipientList'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3HasOrderManagerCustomMailAddresses
     * @test
     * @throws ReflectionException
     */
    public function hasOrderManagerCustomMailAddressesNoCustRecipientList()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                '_d3hasOrderManagerCustomRecipient',
                '_d3getOrderManagerCustomRecipientList'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3GetRemark
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3sendOrderManagerMailToCustomer
     * @test
     * @throws ReflectionException
     */
    public function canD3sendOrderManagerMailToCustomerOrderUserHasId()
    {
        /** @var Field|MockObject $oFieldMock */
        $oFieldMock = $this->getMockBuilder(Field::class)
            ->setMethods(['getRawValue'])
            ->getMock();
        $oFieldMock->method('getRawValue')->willReturn('rawValue');

        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->setMethods([
                'getFieldData',
                '__get'
            ])
            ->getMock();
        $oShopMock->method('getFieldData')->willReturn('fieldData');
        $oShopMock->method('__get')->willReturn($oFieldMock);
        
        /** @var User|MockObject $oOrderUserMock */
        $oOrderUserMock = $this->getMockBuilder(User::class)
            ->setMethods([
                'getId',
                '__get',
                'getFieldData'
            ])
            ->getMock();
        $oOrderUserMock->method('getId')->willReturn('orderUserId');
        $oOrderUserMock->expects($this->exactly(2))->method('__get')->willReturn($oFieldMock);
        $oOrderUserMock->method('getFieldData')->willReturn('fieldData');

        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->setMethods([
                'getOrderUser',
                '__get',
                'getFieldData'
            ])
            ->getMock();
        $oOrderMock->method('getOrderUser')->willReturn($oOrderUserMock);
        $oOrderMock->expects($this->never())->method('__get')->willReturn($oFieldMock);
        $oOrderMock->method('getFieldData')->willReturn('fieldData');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getCurrentItem'])
            ->getMock();
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var Remark|MockObject $oRemarkMock */
        $oRemarkMock = $this->getMockBuilder(Remark::class)
            ->setMethods(['assign'])
            ->getMock();
        $oRemarkMock->expects($this->once())->method('assign')->willReturn(true);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'setRecipient',
                '_d3hasOrderManagerOwnerRecipient',
                'AddBcc',
                '_d3HasOrderManagerCustomMailAddresses',
                '_d3getOrderManagerCustomMailAddressList',
                'd3GetRemark'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3sendOrderManagerMailToCustomer
     * @test
     * @throws ReflectionException
     */
    public function canD3sendOrderManagerMailToCustomerNoOrderUser()
    {
        /** @var Field|MockObject $oFieldMock */
        $oFieldMock = $this->getMockBuilder(Field::class)
            ->setMethods(['getRawValue'])
            ->getMock();
        $oFieldMock->method('getRawValue')->willReturn('rawValue');

        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->setMethods([
                'getFieldData',
                '__get'
            ])
            ->getMock();
        $oShopMock->method('getFieldData')->willReturn('fieldData');
        $oShopMock->method('__get')->willReturn($oFieldMock);

        /** @var User|MockObject $oOrderUserMock */
        $oOrderUserMock = $this->getMockBuilder(User::class)
            ->setMethods([
                'getId',
                '__get',
                'getFieldData'
            ])
            ->getMock();
        $oOrderUserMock->method('getId')->willReturn(false);
        $oOrderUserMock->expects($this->never())->method('__get')->willReturn($oFieldMock);
        $oOrderUserMock->method('getFieldData')->willReturn('fieldData');

        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->setMethods([
                'getOrderUser',
                '__get',
                'getFieldData'
            ])
            ->getMock();
        $oOrderMock->method('getOrderUser')->willReturn($oOrderUserMock);
        $oOrderMock->expects($this->exactly(2))->method('__get')->willReturn($oFieldMock);
        $oOrderMock->method('getFieldData')->willReturn('fieldData');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getCurrentItem'])
            ->getMock();
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var Remark|MockObject $oRemarkMock */
        $oRemarkMock = $this->getMockBuilder(Remark::class)
            ->setMethods(['assign'])
            ->getMock();
        $oRemarkMock->expects($this->once())->method('assign')->willReturn(true);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'setRecipient',
                '_d3hasOrderManagerOwnerRecipient',
                'AddBcc',
                '_d3HasOrderManagerCustomMailAddresses',
                '_d3getOrderManagerCustomMailAddressList',
                'd3GetRemark'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3GetPdfHandler
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function d3GetPdfHandlerReturnsRightInstance()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getCurrentItem'])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3AddOrderManagerPdfAttachment
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canAddOrderManagerPdfAttachmentInvoice()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getValue'])
            ->getMock();
        $getValueMap = [
            ['blActionOrderGeneratePdf_status', true],
            ['blActionOrderPdfSendAttach', true],
            ['blActionOrderPdfTypeInvoice', true],
            ['blActionOrderPdfTypeDelnote', false],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->setMethods([
                'canGeneratePdf',
                'createPdf',
                'getPdfFileName',
                'getPdfSaveDir'])
            ->setConstructorArgs([
                $oManagerMock, 
                d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)
            ])
            ->getMock();
        $oPdfHandlerMock->method('canGeneratePdf')->willReturn(true);
        $oPdfHandlerMock->expects($this->once())->method('createPdf')->with(
            $this->stringContains(d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_INVOICE),
            $this->anything()
        )->willReturn(true);
        $oPdfHandlerMock->method('getPdfFileName')->willReturn(true);
        $oPdfHandlerMock->method('getPdfSaveDir')->willReturn(true);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'd3GetPdfHandler',
                'addAttachment'
            ])
            ->getMock();
        $oModelMock->method('d3GetPdfHandler')->willReturn($oPdfHandlerMock);
        $oModelMock->expects($this->once())->method('addAttachment')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            '_d3AddOrderManagerPdfAttachment',
            array($oManagerMock)
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3AddOrderManagerPdfAttachment
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canAddOrderManagerPdfAttachmentDNote()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getValue'])
            ->getMock();
        $getValueMap = [
            ['blActionOrderGeneratePdf_status', true],
            ['blActionOrderPdfSendAttach', true],
            ['blActionOrderPdfTypeInvoice', false],
            ['blActionOrderPdfTypeDelnote', true],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->setMethods([
                'canGeneratePdf',
                'createPdf',
                'getPdfFileName',
                'getPdfSaveDir'
            ])
            ->setConstructorArgs([
                $oManagerMock, 
                d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)
            ])
            ->getMock();
        $oPdfHandlerMock->method('canGeneratePdf')->willReturn(true);
        $oPdfHandlerMock->expects($this->once())->method('createPdf')->with(
            $this->stringContains(d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_DELIVERYNOTE),
            $this->anything()
        )->willReturn(true);
        $oPdfHandlerMock->method('getPdfFileName')->willReturn(true);
        $oPdfHandlerMock->method('getPdfSaveDir')->willReturn(true);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'd3GetPdfHandler',
                'addAttachment'
            ])
            ->getMock();
        $oModelMock->method('d3GetPdfHandler')->willReturn($oPdfHandlerMock);
        $oModelMock->expects($this->once())->method('addAttachment')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            '_d3AddOrderManagerPdfAttachment',
            array($oManagerMock)
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3SetOrderManagerReplyAddress
     * @test
     * @throws ReflectionException
     */
    public function canSetOrderManagerReplyAddressWithReply()
    {
        /** @var Field|MockObject $oFieldMock */
        $oFieldMock = $this->getMockBuilder(Field::class)
            ->setMethods(['getRawValue'])
            ->getMock();
        $oFieldMock->method('getRawValue')->willReturn('rawValue');
        
        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->setMethods([
                '__get',
                'getFieldData'
            ])
            ->getMock();
        $oShopMock->method('__get')->willReturn($oFieldMock);
        $oShopMock->method('getFieldData')->willReturn('fieldData');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getValue'])
            ->getMock();
        $getValueMap = [
            ['sSendMailReplyAddress', 'reply@test.com'],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'setFrom',
                'setReplyTo'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3SetOrderManagerReplyAddress
     * @test
     * @throws ReflectionException
     */
    public function canSetOrderManagerReplyAddressWithoutReply()
    {
        /** @var Field|MockObject $oFieldMock */
        $oFieldMock = $this->getMockBuilder(Field::class)
            ->setMethods(['getRawValue'])
            ->getMock();
        $oFieldMock->method('getRawValue')->willReturn('rawValue');

        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->setMethods([
                '__get',
                'getFieldData'
            ])
            ->getMock();
        $oShopMock->method('__get')->willReturn($oFieldMock);
        $oShopMock->method('getFieldData')->willReturn('fieldData');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getValue'])
            ->getMock();
        $getValueMap = [
            ['sSendMailReplyAddress', null],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'setFrom',
                'setReplyTo'
            ])
            ->getMock();
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3generateRemark
     * @test
     * @throws ReflectionException
     */
    public function canGenerateRemark()
    {
        /** @var Remark|MockObject $remarkMock */
        $remarkMock = $this->getMockBuilder(Remark::class)
            ->setMethods(['assign'])
            ->getMock();
        $remarkMock->method('assign')->with($this->isType('array'))->willReturn(true);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'd3GetRemark',
                'getAllRecipientAddresses',
                'getBody',
                'getAltBody'
            ])
            ->getMock();
        $oModelMock->expects($this->once())->method('d3GetRemark')->willReturn($remarkMock);
        $oModelMock->expects($this->any())->method('getAllRecipientAddresses')->willReturn(
            [
                'key1'  => 'value1',
                'key2'  => 'value2',
            ]
        );
        $oModelMock->expects($this->any())->method('getBody')->willReturn('testBody');
        $oModelMock->expects($this->any())->method('getAltBody')->willReturn('testAltBody');

        $this->_oModel = $oModelMock;

        /** @var User|MockObject $oUserMock */
        $oUserMock = $this->getMockBuilder(User::class)
            ->setMethods(['getId'])
            ->getMock();
        $oUserMock->method('getId')->willReturn('userId');

        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->setMethods(['getOrderUser'])
            ->getMock();
        $oOrderMock->method('getOrderUser')->willReturn($oUserMock);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->setMethods(['getCurrentItem'])
            ->getMock();
        $oManagerMock->expects($this->any())->method('getCurrentItem')->willReturn($oOrderMock);

        $this->setValue(
            $this->_oModel,
            'oOrderManager',
            $oManagerMock
        );

        $this->assertSame(
            $remarkMock,
            $this->callMethod(
                $this->_oModel,
                'd3generateRemark'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3getRemarkText
     * @test
     * @throws ReflectionException
     */
    public function canGetRemarkText()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->setMethods([
                'getAllRecipientAddresses',
                'getBody',
                'getAltBody'
            ])
            ->getMock();
        $oModelMock->expects($this->any())->method('getAllRecipientAddresses')->willReturn(
            [
                'key1'  => 'value1',
                'key2'  => 'value2',
            ]
        );
        $oModelMock->expects($this->any())->method('getBody')->willReturn('testBody');
        $oModelMock->expects($this->any())->method('getAltBody')->willReturn('testAltBody');

        $this->_oModel = $oModelMock;

        $this->assertEquals(
            'Recipients:'.
            PHP_EOL.'---'.PHP_EOL.
            'key1, key2'.
            PHP_EOL.'---'.PHP_EOL.
            'HTML:'.
            PHP_EOL.'---'.PHP_EOL.
            'testBody'.
            PHP_EOL.'---'.PHP_EOL.
            'Plain'.
            PHP_EOL.'---'.PHP_EOL.
            'testAltBody',
            $this->callMethod(
                $this->_oModel,
                'd3getRemarkText'
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
