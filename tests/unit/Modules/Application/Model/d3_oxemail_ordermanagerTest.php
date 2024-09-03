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

use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Exception\wrongModIdException;
use D3\ModCfg\Application\Model\Log\d3log;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_action_getpdfdocuments;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanager_conf;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_templaterendererExceptionInterface;
use D3\Ordermanager\Application\Model\Exceptions\emptyMessageException;
use D3\Ordermanager\Application\Model\MessageContentGenerator;
use D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use D3\PdfDocuments\Application\Model\Documents\invoicePdf;
use Doctrine\DBAL\Exception as DBALException;
use Exception;
use Html2Text\Html2Text;
use OxidEsales\Eshop\Application\Model\Content;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\Remark;
use OxidEsales\Eshop\Application\Model\Shop;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Email;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateEngineInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateRendererBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateRendererInterface;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager
 */
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
    public function setUp(): void
    {
        parent::setUp();

        $this->_oModel = d3GetOxidDIC()->get('d3ox.ordermanager.'.Email::class);
    }

    public function tearDown(): void
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
            d3GetOxidDIC()->getParameter('d3.ordermanager.modcfgid')
        );
    }



    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::__construct
     * @test
     */
    public function constructorException()
    {
        /** @var d3_oxemail_ordermanager|MockObject $controller */
        $controller = $this->getMockBuilder(d3_oxemail_ordermanager::class)
            ->disableOriginalConstructor()
            ->getMock();

        d3GetOxidDIC()->setParameter('d3.ordermanager.modcfgid', 'differentModCfgid');

        $this->expectException(wrongModIdException::class);

        $this->callMethod(
            $controller,
            '__construct'
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3GetOrderManagerTemplateEngine
     * @test
     * @throws ReflectionException
     */
    public function templateEngineHasRightInstance()
    {
        $this->assertInstanceOf(
            TemplateEngineInterface::class,
            $this->callMethod(
                $this->_oModel,
                '_d3GetOrderManagerTemplateEngine'
            )
        );
    }

    /**
     * @covers       \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3sendOrderManagerEmail
     * @test
     *
     * @param $sendingSuccess
     *
     * @throws ReflectionException
     * @dataProvider canStartSendingOrderManagerMailDataProvider
     */
    public function canSendOrderManagerEmail($sendingSuccess)
    {
        $viewData = [
            'item1' => 'value1',
            'item2' => 'value2',
        ];

        /** @var Shop|MockObject $oFieldMock */
        $oFieldMock = $this->getMockBuilder(Shop::class)
            ->addMethods(['getRawValue'])
            ->getMock();
        $oFieldMock->method('getRawValue')->willReturn('value');

        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->onlyMethods([
                '__get',
                'getFieldData',
            ])
            ->getMock();
        $oShopMock->method('__get')->willReturn($oFieldMock);
        $oShopMock->method('getFieldData')->willReturn('value');
        $oShopMock->assign([
            'oxsmtp'    => 'SMTPhost',
        ]);

        /** @var d3log|MockObject $oD3LogMock */
        $oD3LogMock = $this->getMockBuilder(d3log::class)
            ->onlyMethods(['log'])
            ->getMock();
        $oD3LogMock->method('log')->willReturnSelf();

        /** @var TemplateRendererInterface $renderer */
        $renderer = ContainerFactory::getInstance()->getContainer()
            ->get(TemplateRendererBridgeInterface::class)
            ->getTemplateRenderer();
        $templateEngine = $renderer->getTemplateEngine();
        $templateEngineClass = get_class($templateEngine);

        /** @var TemplateEngineInterface|MockObject $templateEngineMock */
        $templateEngineMock = $this->getMockBuilder($templateEngineClass)
            ->onlyMethods(['render', 'addGlobal'])
            ->disableOriginalConstructor()
            ->getMock();
        $templateEngineMock->method('render')->willReturn('renderedTemplateContent');
        $templateEngineMock->expects($this->exactly(count($viewData)))->method('addGlobal')->willReturn(true);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'getShop',
                '_d3GetOrderManagerTemplateEngine',
                'setMailParams',
                'setViewData',
                'processViewArray',
                'd3OMsetBody',
                'd3OMsetAltBody',
                'getBody',
                'd3OMsetSubject',
                'setRecipient',
                'setReplyTo',
                'send',
                'getViewData',
            ])
            ->getMock();
        $oModelMock->method('getShop')->willReturn($oShopMock);
        $oModelMock->method('_d3GetOrderManagerTemplateEngine')->willReturn($templateEngineMock);
        $oModelMock->method('setMailParams')->willReturn(true);
        $oModelMock->method('setViewData')->willReturn(true);
        $oModelMock->method('processViewArray')->willReturn(true);
        $oModelMock->expects($this->once())->method('d3OMsetBody')->willReturn(true);
        $oModelMock->method('d3OMsetAltBody')->willReturn(true);
        $oModelMock->method('getBody')->willReturn('mailBody');
        $oModelMock->method('d3OMsetSubject')->willReturn(true);
        $oModelMock->expects($this->once())->method('setRecipient')->willReturn(true);
        $oModelMock->method('setReplyTo')->willReturn(true);
        $oModelMock->method('getViewData')->willReturn($viewData);
        $oModelMock->expects($this->once())->method('send')->willReturn($sendingSuccess);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $sendingSuccess,
            $this->callMethod(
                $this->_oModel,
                'd3sendOrderManagerEmail',
                [[]]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3getOrderManagerOrder
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canLoadOrderUniqueOxid()
    {
        /** @var d3ordermanagerlist|MockObject $oOrderManagerListMock */
        $oOrderManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetOrderSaveTriggeredManagerTasks'])
            ->getMock();
        $oOrderManagerListMock->method('d3GetOrderSaveTriggeredManagerTasks')->willReturn(oxNew(d3ordermanagerlist::class));

        d3GetOxidDIC()->set(d3ordermanagerlist::class, $oOrderManagerListMock);

        $oOrder = new Order();
        $oOrder->setId('testOxId1');
        $oOrder->save();

        $oReturnOrder = $this->callMethod(
            $this->_oModel,
            'd3getOrderManagerOrder',
            ['testOxId1']
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3getOrderManagerOrder
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canLoadOrderOxidPartOfOtherData()
    {
        /** @var d3ordermanagerlist|MockObject $oOrderManagerListMock */
        $oOrderManagerListMock = $this->getMockBuilder(d3ordermanagerlist::class)
            ->onlyMethods(['d3GetOrderSaveTriggeredManagerTasks'])
            ->getMock();
        $oOrderManagerListMock->method('d3GetOrderSaveTriggeredManagerTasks')->willReturn(oxNew(d3ordermanagerlist::class));

        d3GetOxidDIC()->set(d3ordermanagerlist::class, $oOrderManagerListMock);

        $oOrder = new Order();
        $oOrder->setId('testOxId2');
        $oOrder->save();

        $oReturnOrder = $this->callMethod(
            $this->_oModel,
            'd3getOrderManagerOrder',
            ['testOxId2@@otherData']
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
        $oManager = d3GetOxidDIC()->get(d3ordermanager::class);
        $oManager->setId('testOxId3');
        $oManager->save();

        $oReturnManager = $this->callMethod(
            $this->_oModel,
            'd3getOrderManager',
            ['testOxId3']
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
     * @covers       \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::sendOrderManagerMail
     * @test
     *
     * @param $sendingSuccess
     *
     * @throws ReflectionException
     * @dataProvider canStartSendingOrderManagerMailDataProvider
     */
    public function canStartSendingOrderManagerMail($sendingSuccess)
    {
        /** @var Remark|MockObject $oRemarkMock */
        $oRemarkMock = $this->getMockBuilder(Remark::class)
            ->onlyMethods(['save'])
            ->getMock();
        $oRemarkMock->expects($this->exactly((int) $sendingSuccess))->method('save')->willReturn(true);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'getOrderManagerMailContent',
                'getShop',
                'd3OMsetBody',
                'd3OMsetAltBody',
                'd3OMsetSubject',
                '_d3SetOrderManagerReplyAddress',
                '_d3SetOrderManagerMailRecipients',
                '_d3AddOrderManagerPdfAttachment',
                'send',
            ])
            ->getMock();
        $oModelMock->method('getOrderManagerMailContent')->willReturn([
            'html'      => 'foo',
            'plain'     => 'bar',
            'subject'   => 'testSubject',
        ]);
        $oModelMock->method('getShop')->willReturn(d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class));
        $oModelMock->expects($this->once())->method('d3OMsetBody')->willReturn(true);
        $oModelMock->method('d3OMsetAltBody')->willReturn(true);
        $oModelMock->method('d3OMsetSubject')->willReturn(true);
        $oModelMock->method('_d3SetOrderManagerReplyAddress')->willReturn(true);
        $oModelMock->method('_d3SetOrderManagerMailRecipients')->willReturn($oRemarkMock);
        $oModelMock->method('_d3AddOrderManagerPdfAttachment')->willReturn(true);
        $oModelMock->expects($this->once())->method('send')->willReturn($sendingSuccess);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $sendingSuccess,
            $this->callMethod(
                $this->_oModel,
                'sendOrderManagerMail',
                [d3GetOxidDIC()->get(d3ordermanager::class)]
            )
        );
    }

    /**
     * @return array
     */
    public function canStartSendingOrderManagerMailDataProvider(): array
    {
        return [
            'can send'  => [true],
            'can not send'  => [false],
        ];
    }

    /**
     * @covers       \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::sendOrderManagerMail
     * @test
     * @throws ReflectionException
     */
    public function cantSendEmptyOrderManagerMail()
    {
        /** @var Remark|MockObject $oRemarkMock */
        $oRemarkMock = $this->getMockBuilder(Remark::class)
            ->onlyMethods(['save'])
            ->getMock();
        $oRemarkMock->expects($this->never())->method('save')->willReturn(true);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'getOrderManagerMailContent',
                'getShop',
                'd3OMsetBody',
                'd3OMsetAltBody',
                'd3OMsetSubject',
                '_d3SetOrderManagerReplyAddress',
                '_d3SetOrderManagerMailRecipients',
                '_d3AddOrderManagerPdfAttachment',
                'send',
            ])
            ->getMock();
        $oModelMock->method('getOrderManagerMailContent')->willThrowException(oxNew(emptyMessageException::class));
        $oModelMock->method('getShop')->willReturn(d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class));
        $oModelMock->expects($this->never())->method('d3OMsetBody')->willReturn(true);
        $oModelMock->method('d3OMsetAltBody')->willReturn(true);
        $oModelMock->method('d3OMsetSubject')->willReturn(true);
        $oModelMock->method('_d3SetOrderManagerReplyAddress')->willReturn(true);
        $oModelMock->method('_d3SetOrderManagerMailRecipients')->willReturn($oRemarkMock);
        $oModelMock->method('_d3AddOrderManagerPdfAttachment')->willReturn(true);
        $oModelMock->expects($this->never())->method('send')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            false,
            $this->callMethod(
                $this->_oModel,
                'sendOrderManagerMail',
                [d3GetOxidDIC()->get(d3ordermanager::class)]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3OMsetBody
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3OMsetAltBody
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3OMsetSubject
     * @test
     * @param $setMethod
     * @param $getMethod
     * @param $returnValue
     * @param $expectException
     *
     * @throws ReflectionException
     * @dataProvider canSetOrderManagerMailContentDataProvider
     */
    public function canSetOrderManagerMailContent($setMethod, $getMethod, $returnValue, $expectException)
    {
        /** @var Email|MockObject $mailMock */
        $mailMock = $this->getMockBuilder(Email::class)
            ->onlyMethods([$setMethod, $getMethod, 'd3OrderManagerThrowUnequalContentException'])
            ->getMock();
        $mailMock->expects(self::atLeastOnce())->method($setMethod)->willReturn(true);
        $mailMock->method($getMethod)->willReturn($returnValue);
        $mailMock->expects(self::exactly((int) $expectException))->method('d3OrderManagerThrowUnequalContentException');

        $this->_oModel = $mailMock;

        $methodName = 'd3OM'.$setMethod;

        $this->callMethod(
            $this->_oModel,
            $methodName,
            ['content']
        );
    }

    /**
     * @return array[]
     */
    public function canSetOrderManagerMailContentDataProvider(): array
    {
        return [
            'body return passed'    => ['setBody', 'getBody', 'content', false],
            'body return empty'     => ['setBody', 'getBody', '', true],
            'altbody return passed'    => ['setAltBody', 'getAltBody', 'content', false],
            'altbody return empty'     => ['setAltBody', 'getAltBody', '', true],
            'subject return passed'    => ['setSubject', 'getSubject', 'content', false],
            'subject return empty'     => ['setSubject', 'getSubject', '', true],
        ];
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3OMsetBody
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3OMsetAltBody
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3OMsetSubject
     * @test
     *
     * @param $setMethod
     * @param $getMethod
     *
     * @throws ReflectionException
     * @dataProvider canSetOrderManagerMailContentEmptyDataProvider
     */
    public function canSetOrderManagerMailContentEmpty($setMethod, $getMethod)
    {
        /** @var Email|MockObject $mailMock */
        $mailMock = $this->getMockBuilder(Email::class)
            ->onlyMethods([$setMethod, $getMethod, 'd3OrderManagerThrowUnequalContentException'])
            ->getMock();
        $mailMock->expects(self::atLeastOnce())->method($setMethod)->willReturn(true);
        $mailMock->expects($this->never())->method($getMethod);
        $mailMock->expects($this->never())->method('d3OrderManagerThrowUnequalContentException');

        $this->_oModel = $mailMock;

        $methodName = 'd3OM'.$setMethod;

        $this->callMethod(
            $this->_oModel,
            $methodName,
            ['']
        );
    }

    /**
     * @return array[]
     */
    public function canSetOrderManagerMailContentEmptyDataProvider(): array
    {
        return [
            'body'    => ['setBody', 'getBody'],
            'altbody'    => ['setAltBody', 'getAltBody'],
            'subject'    => ['setSubject', 'getSubject'],
        ];
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
            ->onlyMethods([
                '_d3hasOrderManagerCustomerRecipient',
                '_d3sendOrderManagerMailToCustomer',
                '_d3hasOrderManagerOwnerRecipient',
                '_d3sendOrderManagerMailToOwner',
                '_d3hasOrderManagerCustomRecipient',
                '_d3sendOrderManagerMailToCustom',
            ])
            ->getMock();
        $oModelMock->method('_d3hasOrderManagerCustomerRecipient')->willReturn(true);
        $oModelMock->expects($this->once())->method('_d3sendOrderManagerMailToCustomer')->willReturn(d3GetOxidDIC()->get('d3ox.ordermanager.'.Remark::class));
        $oModelMock->method('_d3hasOrderManagerOwnerRecipient')->willReturn(false);
        $oModelMock->expects($this->never())->method('_d3sendOrderManagerMailToOwner')->willReturn(d3GetOxidDIC()->get('d3ox.ordermanager.'.Remark::class));
        $oModelMock->method('_d3hasOrderManagerCustomRecipient')->willReturn(false);
        $oModelMock->expects($this->never())->method('_d3sendOrderManagerMailToCustom')->willReturn(d3GetOxidDIC()->get('d3ox.ordermanager.'.Remark::class));

        $this->_oModel = $oModelMock;

        $this->assertInstanceOf(
            Remark::class,
            $this->callMethod(
                $this->_oModel,
                '_d3SetOrderManagerMailRecipients',
                [d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class)]
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
            ->onlyMethods([
                '_d3hasOrderManagerCustomerRecipient',
                '_d3sendOrderManagerMailToCustomer',
                '_d3hasOrderManagerOwnerRecipient',
                '_d3sendOrderManagerMailToOwner',
                '_d3hasOrderManagerCustomRecipient',
                '_d3sendOrderManagerMailToCustom',
            ])
            ->getMock();
        $oModelMock->method('_d3hasOrderManagerCustomerRecipient')->willReturn(false);
        $oModelMock->expects($this->never())->method('_d3sendOrderManagerMailToCustomer')->willReturn(d3GetOxidDIC()->get('d3ox.ordermanager.'.Remark::class));
        $oModelMock->method('_d3hasOrderManagerOwnerRecipient')->willReturn(true);
        $oModelMock->expects($this->once())->method('_d3sendOrderManagerMailToOwner')->willReturn(d3GetOxidDIC()->get('d3ox.ordermanager.'.Remark::class));
        $oModelMock->method('_d3hasOrderManagerCustomRecipient')->willReturn(false);
        $oModelMock->expects($this->never())->method('_d3sendOrderManagerMailToCustom')->willReturn(d3GetOxidDIC()->get('d3ox.ordermanager.'.Remark::class));

        $this->_oModel = $oModelMock;

        $this->assertInstanceOf(
            Remark::class,
            $this->callMethod(
                $this->_oModel,
                '_d3SetOrderManagerMailRecipients',
                [d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class)]
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
            ->onlyMethods([
                '_d3hasOrderManagerCustomerRecipient',
                '_d3sendOrderManagerMailToCustomer',
                '_d3hasOrderManagerOwnerRecipient',
                '_d3sendOrderManagerMailToOwner',
                '_d3hasOrderManagerCustomRecipient',
                '_d3sendOrderManagerMailToCustom',
            ])
            ->getMock();
        $oModelMock->method('_d3hasOrderManagerCustomerRecipient')->willReturn(false);
        $oModelMock->expects($this->never())->method('_d3sendOrderManagerMailToCustomer')->willReturn(d3GetOxidDIC()->get('d3ox.ordermanager.'.Remark::class));
        $oModelMock->method('_d3hasOrderManagerOwnerRecipient')->willReturn(false);
        $oModelMock->expects($this->never())->method('_d3sendOrderManagerMailToOwner')->willReturn(d3GetOxidDIC()->get('d3ox.ordermanager.'.Remark::class));
        $oModelMock->method('_d3hasOrderManagerCustomRecipient')->willReturn(true);
        $oModelMock->expects($this->once())->method('_d3sendOrderManagerMailToCustom')->willReturn(d3GetOxidDIC()->get('d3ox.ordermanager.'.Remark::class));

        $this->_oModel = $oModelMock;

        $this->assertInstanceOf(
            Remark::class,
            $this->callMethod(
                $this->_oModel,
                '_d3SetOrderManagerMailRecipients',
                [d3GetOxidDIC()->get('d3ox.ordermanager.'.Shop::class)]
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
            ->onlyMethods([
                'getValue',
                'getEditedValues',
            ])
            ->getMock();
        $oManagerMock->expects($this->never())->method('getValue')->willReturn('objectProperty');
        $oManagerMock->expects($this->once())->method('getEditedValues')->willReturn(['editedVar' => 'editedProperty']);

        $this->setValue(
            $this->_oModel,
            'oOrderManager',
            $oManagerMock
        );

        $this->callMethod(
            $this->_oModel,
            '_d3getOrderManagerMailOption',
            ['editedVar']
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
            ->onlyMethods([
                'getValue',
                'getEditedValues',
            ])
            ->getMock();
        $oManagerMock->expects($this->once())->method('getValue')->willReturn('objectProperty');
        $oManagerMock->expects($this->once())->method('getEditedValues')->willReturn(['editedVar' => 'editedProperty']);

        $this->setValue(
            $this->_oModel,
            'oOrderManager',
            $oManagerMock
        );

        $this->callMethod(
            $this->_oModel,
            '_d3getOrderManagerMailOption',
            ['objectVar']
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
            ->onlyMethods(['_d3getOrderManagerMailOption'])
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
            ->onlyMethods(['_d3getOrderManagerMailOption'])
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
            ->onlyMethods(['_d3getOrderManagerMailOption'])
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
            ->onlyMethods(['_d3getOrderManagerMailOption'])
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::getOrderManagerMailContent
     * @test
     * @throws ReflectionException
     * @throws Exception
     * @dataProvider canGetOrderManagerMailContentEmptyExceptionDataProvider
     */
    public function canGetOrderManagerMailContentEmptyException($throwException)
    {
        $expected = [
            'html' => '',
            'subject' => '',
            'plain' => '',
        ];

        if ($throwException) {
            $this->expectException(emptyMessageException::class);
        }

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getEditedValues', 'getFieldData'])
            ->getMock();
        $oManagerMock->method('getEditedValues')->willReturn(
            ['mail'    => [
                'html'  => '',
                'subject'   => '',
                'plain' => '',
                'genplain'   => 1,
            ]]
        );
        $oManagerMock->method('getFieldData')->willReturn('fieldData');

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods(['d3HasOrderManagerEditorMailContent', 'd3generateOrderManagerPlainContent'])
            ->getMock();
        $oModelMock->method('d3HasOrderManagerEditorMailContent')->willReturn(true);
        $oModelMock->expects($this->once())->method('d3generateOrderManagerPlainContent')->with(
            $this->identicalTo('')
        )->willReturn('');

        $this->assertSame(
            $expected,
            $this->callMethod(
                $oModelMock,
                'getOrderManagerMailContent',
                [ $oManagerMock, $throwException ]
            )
        );
    }

    /**
     * @return array
     */
    public function canGetOrderManagerMailContentEmptyExceptionDataProvider(): array
    {
        return [
            'throw exception'   => [true],
            'dont throw exception'  => [false],
        ];
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::getOrderManagerMailContent
     * @test
     * @throws ReflectionException
     * @throws Exception
     * @dataProvider canGetOrderManagerMailContentEditedDataProvider
     */
    public function canGetOrderManagerMailContentEdited($generatePlain)
    {
        $expected = [
            'html' => 'contentHtml',
            'subject' => 'contentSubject',
            'plain' => $generatePlain ? 'contentPlainFromHtml' : 'contentPlain',
        ];

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods([
                'getEditedValues',
            ])
            ->getMock();
        $oManagerMock->method('getEditedValues')->willReturn(
            ['mail'    => [
                'html'  => 'contentHtml',
                'subject'   => 'contentSubject',
                'plain' => 'contentPlain',
                'genplain'   => $generatePlain,
            ]]
        );

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods(['d3HasOrderManagerEditorMailContent', 'd3generateOrderManagerPlainContent'])
            ->getMock();
        $oModelMock->method('d3HasOrderManagerEditorMailContent')->willReturn(true);
        $oModelMock->expects($this->exactly($generatePlain))->method('d3generateOrderManagerPlainContent')->with(
            $this->identicalTo('contentHtml')
        )->willReturn('contentPlainFromHtml');

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oModel,
                'getOrderManagerMailContent',
                [$oManagerMock]
            )
        );
    }

    /**
     * @return int[][]
     */
    public function canGetOrderManagerMailContentEditedDataProvider(): array
    {
        return [
            'no plain generator'    => [0],
            'use plain generator'    => [1],
        ];
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::getOrderManagerMailContent
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canGetOrderManagerMailContentCms()
    {
        $expected = [
            'html' => 'content',
            'subject' => 'contentField',
            'plain' => 'content',
        ];

        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->onlyMethods([
                'getFieldData',
            ])
            ->getMock();
        $oOrderMock->method('getFieldData')->willReturn(1);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods([
                'getValue',
                'getCurrentItem',
            ])
            ->getMock();
        $getValueMap = [['sSendMailFromContentname', 'cmsIdent'], ['sSendMailFromContentnamePlain', 'cmsIdentPlain'], ['sSendMailFromSource', 'cms']];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var Content|MockObject $contentMock */
        $contentMock = $this->getMockBuilder(Content::class)
            ->onlyMethods(['loadInLang', 'getFieldData'])
            ->disableOriginalConstructor()
            ->getMock();
        $contentMock->expects($this->once())->method('loadInLang')->with(
            $this->identicalTo(1),
            $this->identicalTo('cmsIdent')
        )->willReturnSelf();
        $contentMock->expects($this->atLeastOnce())->method('getFieldData')->willReturn('contentField');

        /** @var MessageContentGenerator|MockObject $messageContentGeneratorMock */
        $messageContentGeneratorMock = $this->getMockBuilder(MessageContentGenerator::class)
            ->onlyMethods(['generateFromCms'])
            ->disableOriginalConstructor()
            ->getMock();
        $messageContentGeneratorMock->expects($this->exactly(2))->method('generateFromCms')->willReturn('content');

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods(['getMessageContentGeneratorOrderManager', 'd3GetOrderManagerContentObject'])
            ->getMock();
        $oModelMock->method('getMessageContentGeneratorOrderManager')->willReturn($messageContentGeneratorMock);
        $oModelMock->method('d3GetOrderManagerContentObject')->willReturn($contentMock);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oModel,
                'getOrderManagerMailContent',
                [$oManagerMock]
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
        $expected = [
            'html' => 'content',
            'subject' => 'content',
            'plain' => 'content',
        ];

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods([
                'getValue',
                'getCurrentItem',
            ])
            ->getMock();
        $getValueMap = [
            ['sSendMailFromTheme', 'admin'],
            ['sSendMailFromSource', 'template'],
            ['sSendMailFromTemplatename', 'myTemplate'],
            ['sSendMailFromSubject', 'mySubject'],
            ['sSendMailFromTemplatenamePlain', 'myPlainTemplate'],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var MessageContentGenerator|MockObject $messageContentGeneratorMock */
        $messageContentGeneratorMock = $this->getMockBuilder(MessageContentGenerator::class)
            ->onlyMethods(['setTemplateFrom', 'generateFromTpl'])
            ->disableOriginalConstructor()
            ->getMock();
        $messageContentGeneratorMock->expects($this->atLeastOnce())->method('setTemplateFrom')->with($this->equalTo(MessageContentGenerator::TEMPLATE_FROM_ADMIN));
        $messageContentGeneratorMock->expects($this->exactly(3))->method('generateFromTpl')->willReturn('content');

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods(['getMessageContentGeneratorOrderManager'])
            ->getMock();
        $oModelMock->method('getMessageContentGeneratorOrderManager')->willReturn($messageContentGeneratorMock);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oModel,
                'getOrderManagerMailContent',
                [$oManagerMock]
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
        $expected = [
            'html' => 'content',
            'subject' => 'content',
            'plain' => 'content',
        ];

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods([
                'getValue',
            ])
            ->getMock();
        $getValueMap = [
            ['sSendMailFromTheme', 'frontend'],
            ['sSendMailFromSource', 'template'],
            ['sSendMailFromTemplatename', 'myTemplate'],
            ['sSendMailFromSubject', 'mySubject'],
            ['sSendMailFromTemplatenamePlain', 'myPlainTemplate'],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var MessageContentGenerator|MockObject $messageContentGeneratorMock */
        $messageContentGeneratorMock = $this->getMockBuilder(MessageContentGenerator::class)
            ->onlyMethods(['setTemplateFrom', 'generateFromTpl'])
            ->disableOriginalConstructor()
            ->getMock();
        $messageContentGeneratorMock->expects($this->atLeastOnce())->method('setTemplateFrom')->with($this->equalTo(MessageContentGenerator::TEMPLATE_FROM_FRONTEND));
        $messageContentGeneratorMock->expects($this->exactly(3))->method('generateFromTpl')->willReturn('content');

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods(['getMessageContentGeneratorOrderManager',])
            ->getMock();
        $oModelMock->method('getMessageContentGeneratorOrderManager')->willReturn($messageContentGeneratorMock);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $expected,
            $this->callMethod(
                $this->_oModel,
                'getOrderManagerMailContent',
                [$oManagerMock]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3GetOrderManagerContentObject
     * @test
     * @throws ReflectionException
     */
    public function d3GetOrderManagerContentObjectReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Content::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetOrderManagerContentObject'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::getD3OrderManagerStrObject
     * @test
     * @throws ReflectionException
     */
    public function getD3OrderManagerStrObjectReturnsRightInstance()
    {
        $this->assertInstanceOf(
            d3str::class,
            $this->callMethod(
                $this->_oModel,
                'getD3OrderManagerStrObject'
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
            ->onlyMethods(['d3isOrderManagerArrayEditorMailContent'])
            ->getMock();
        $oModelMock->method('d3isOrderManagerArrayEditorMailContent')->willReturn(true);

        $this->_oModel = $oModelMock;

        $aEditedValues = [
            'mail'  => [
                'subject'   => 'subjectContent',
                'html'      => 'htmlContent',
                'plain'     => 'plainContent',
            ],
        ];

        $this->assertTrue(
            $this->callMethod(
                $this->_oModel,
                'd3HasOrderManagerEditorMailContent',
                [$aEditedValues]
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
            ->onlyMethods(['d3isOrderManagerArrayEditorMailContent'])
            ->getMock();
        $oModelMock->method('d3isOrderManagerArrayEditorMailContent')->willReturn(false);

        $this->_oModel = $oModelMock;

        $aEditedValues = [
            'mail'  => [
                'subject'   => 'subjectContent',
                'html'      => 'htmlContent',
                'plain'     => 'plainContent',
            ],
        ];

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'd3HasOrderManagerEditorMailContent',
                [$aEditedValues]
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
            ->onlyMethods(['d3isOrderManagerArrayEditorMailContent'])
            ->getMock();
        $oModelMock->method('d3isOrderManagerArrayEditorMailContent')->willReturn(true);

        $this->_oModel = $oModelMock;

        $aEditedValues = [
            'mail'  => [
                'subject'   => false,
                'html'      => 'htmlContent',
                'plain'     => 'plainContent',
            ],
        ];

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'd3HasOrderManagerEditorMailContent',
                [$aEditedValues]
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
            ->onlyMethods(['d3isOrderManagerArrayEditorMailContent'])
            ->getMock();
        $oModelMock->method('d3isOrderManagerArrayEditorMailContent')->willReturn(true);

        $this->_oModel = $oModelMock;

        $aEditedValues = [
            'mail'  => [
                'subject'   => 'subjectContent',
                'html'      => false,
                'plain'     => 'plainContent',
            ],
        ];

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'd3HasOrderManagerEditorMailContent',
                [$aEditedValues]
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
            ->onlyMethods(['d3isOrderManagerArrayEditorMailContent'])
            ->getMock();
        $oModelMock->method('d3isOrderManagerArrayEditorMailContent')->willReturn(true);

        $this->_oModel = $oModelMock;

        $aEditedValues = [
            'mail'  => [
                'subject'   => 'subjectContent',
                'html'      => 'htmlContent',
                'plain'     => false,
            ],
        ];

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'd3HasOrderManagerEditorMailContent',
                [$aEditedValues]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3isOrderManagerArrayEditorMailContent
     * @test
     * @throws ReflectionException
     */
    public function d3isOrderManagerArrayEditorMailContentPass()
    {
        $aEditedValues = [
            'mail'  => [],
        ];

        $this->assertTrue(
            $this->callMethod(
                $this->_oModel,
                'd3isOrderManagerArrayEditorMailContent',
                [$aEditedValues]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3isOrderManagerArrayEditorMailContent
     * @test
     * @throws ReflectionException
     */
    public function d3isOrderManagerArrayEditorMailContentNoMailArray()
    {
        $aEditedValues = [];

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'd3isOrderManagerArrayEditorMailContent',
                [$aEditedValues]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3isOrderManagerArrayEditorMailContent
     * @test
     * @throws ReflectionException
     */
    public function d3isOrderManagerArrayEditorMailContentNoValuesArray()
    {
        $aEditedValues = null;

        $this->assertFalse(
            $this->callMethod(
                $this->_oModel,
                'd3isOrderManagerArrayEditorMailContent',
                [$aEditedValues]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3generateOrderManagerPlainContent
     * @test
     * @throws ReflectionException
     */
    public function canGeneratePlainContent()
    {
        /** @var Html2Text|MockObject $oHtml2TextMock */
        $oHtml2TextMock = $this->getMockBuilder(Html2Text::class)
            ->onlyMethods(['getText'])
            ->getMock();
        $oHtml2TextMock->expects($this->once())->method('getText')->willReturn('plainContent');

        d3GetOxidDIC()->set(Html2Text::class, $oHtml2TextMock);

        $this->assertSame(
            'plainContent',
            $this->callMethod(
                $this->_oModel,
                'd3generateOrderManagerPlainContent',
                [
                    'HtmlContent',
                ]
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
            ->addMethods(['getRawValue'])
            ->getMock();
        $oFieldMock->method('getRawValue')->willReturn('shopName');

        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->onlyMethods([
                '__get',
                'getFieldData',
            ])
            ->getMock();
        $oShopMock->method('__get')->willReturn($oFieldMock);
        $oShopMock->method('getFieldData')->willReturn('info@mail.com');

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods([
                'setRecipient',
                '_d3HasOrderManagerCustomMailAddresses',
                '_d3getOrderManagerCustomMailAddressList',
                'AddBcc',
                'd3generateOrderManagerRemark',
            ])
            ->getMock();

        $oModelMock->expects($this->once())->method('setRecipient')->willReturn(true);
        $oModelMock->method('_d3HasOrderManagerCustomMailAddresses')->willReturn(true);
        $oModelMock->expects($this->exactly(2))->method('AddBcc')->willReturn(true);
        $oModelMock->method('_d3getOrderManagerCustomMailAddressList')->willReturn(
            [
                'mail1',
                'mail2',
            ]
        );
        $returnValue = oxNew(Remark::class);
        $oModelMock->method('d3generateOrderManagerRemark')->willReturn($returnValue);

        $this->_oModel = $oModelMock;

        $this->assertSame(
            $returnValue,
            $this->callMethod(
                $this->_oModel,
                '_d3sendOrderManagerMailToOwner',
                [$oShopMock]
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
            ->onlyMethods([
                '_d3hasOrderManagerCustomMailAddresses',
                '_d3getOrderManagerCustomMailAddressList',
                'setRecipient',
                'd3generateOrderManagerRemark',
            ])
            ->getMock();

        $oModelMock->expects($this->once())->method('_d3hasOrderManagerCustomMailAddresses')->willReturn(true);
        $oModelMock->expects($this->exactly(2))->method('setRecipient')->willReturn(true);
        $oModelMock->method('_d3getOrderManagerCustomMailAddressList')->willReturn(
            [
                'mail1',
                'mail2',
            ]
        );
        $returnValue = oxNew(Remark::class);
        $oModelMock->method('d3generateOrderManagerRemark')->willReturn($returnValue);

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
            ->onlyMethods(['_d3getOrderManagerCustomRecipientList'])
            ->getMock();
        $oModelMock->expects($this->once())->method('_d3getOrderManagerCustomRecipientList')->willReturn(
            'mailNo1; mailNo2; '
        );

        $this->_oModel = $oModelMock;

        $this->assertSame(
            [
                'mailNo1',
                'mailNo2',
            ],
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
            ->onlyMethods([
                '_d3hasOrderManagerCustomRecipient',
                '_d3getOrderManagerCustomRecipientList',
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
            ->onlyMethods([
                '_d3hasOrderManagerCustomRecipient',
                '_d3getOrderManagerCustomRecipientList',
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
            ->onlyMethods([
                '_d3hasOrderManagerCustomRecipient',
                '_d3getOrderManagerCustomRecipientList',
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
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3GetOrderManagerRemark
     * @test
     * @throws ReflectionException
     */
    public function d3GetRemarkReturnsRightInstance()
    {
        $this->assertInstanceOf(
            Remark::class,
            $this->callMethod(
                $this->_oModel,
                'd3GetOrderManagerRemark'
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
            ->onlyMethods(['getRawValue'])
            ->getMock();
        $oFieldMock->method('getRawValue')->willReturn('rawValue');

        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->onlyMethods([
                'getFieldData',
                '__get',
            ])
            ->getMock();
        $oShopMock->method('getFieldData')->willReturn('fieldData');
        $oShopMock->method('__get')->willReturn($oFieldMock);

        /** @var User|MockObject $oOrderUserMock */
        $oOrderUserMock = $this->getMockBuilder(User::class)
            ->onlyMethods([
                'getId',
                '__get',
                'getFieldData',
            ])
            ->getMock();
        $oOrderUserMock->method('getId')->willReturn('orderUserId');
        $oOrderUserMock->expects($this->exactly(2))->method('__get')->willReturn($oFieldMock);
        $oOrderUserMock->method('getFieldData')->willReturn('fieldData');

        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->onlyMethods([
                'getOrderUser',
                '__get',
                'getFieldData',
            ])
            ->getMock();
        $oOrderMock->method('getOrderUser')->willReturn($oOrderUserMock);
        $oOrderMock->expects($this->never())->method('__get')->willReturn($oFieldMock);
        $oOrderMock->method('getFieldData')->willReturn('fieldData');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getCurrentItem'])
            ->getMock();
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var Remark|MockObject $oRemarkMock */
        $oRemarkMock = $this->getMockBuilder(Remark::class)
            ->onlyMethods(['assign'])
            ->getMock();
        $oRemarkMock->expects($this->once())->method('assign')->willReturn(true);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods([
                'setRecipient',
                '_d3hasOrderManagerOwnerRecipient',
                'AddBcc',
                '_d3HasOrderManagerCustomMailAddresses',
                '_d3getOrderManagerCustomMailAddressList',
                'd3GetOrderManagerRemark',
            ])
            ->getMock();
        $oModelMock->method('setRecipient')->willReturn(true);
        $oModelMock->method('_d3hasOrderManagerOwnerRecipient')->willReturn(true);
        $oModelMock->expects($this->exactly(3))->method('AddBcc')->willReturn(true);
        $oModelMock->method('_d3HasOrderManagerCustomMailAddresses')->willReturn(true);
        $oModelMock->method('_d3getOrderManagerCustomMailAddressList')->willReturn(['addrNo1', 'addrNo2']);
        $oModelMock->method('d3GetOrderManagerRemark')->willReturn($oRemarkMock);

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
                [$oShopMock]
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
            ->onlyMethods(['getRawValue'])
            ->getMock();
        $oFieldMock->method('getRawValue')->willReturn('rawValue');

        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->onlyMethods([
                'getFieldData',
                '__get',
            ])
            ->getMock();
        $oShopMock->method('getFieldData')->willReturn('fieldData');
        $oShopMock->method('__get')->willReturn($oFieldMock);

        /** @var User|MockObject $oOrderUserMock */
        $oOrderUserMock = $this->getMockBuilder(User::class)
            ->onlyMethods([
                'getId',
                '__get',
                'getFieldData',
            ])
            ->getMock();
        $oOrderUserMock->method('getId')->willReturn(null);
        $oOrderUserMock->expects($this->never())->method('__get')->willReturn($oFieldMock);
        $oOrderUserMock->method('getFieldData')->willReturn('fieldData');

        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->onlyMethods([
                'getOrderUser',
                '__get',
                'getFieldData',
            ])
            ->getMock();
        $oOrderMock->method('getOrderUser')->willReturn($oOrderUserMock);
        $oOrderMock->expects($this->exactly(2))->method('__get')->willReturn($oFieldMock);
        $oOrderMock->method('getFieldData')->willReturn('fieldData');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getCurrentItem'])
            ->getMock();
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var Remark|MockObject $oRemarkMock */
        $oRemarkMock = $this->getMockBuilder(Remark::class)
            ->onlyMethods(['assign'])
            ->getMock();
        $oRemarkMock->expects($this->once())->method('assign')->willReturn(true);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods([
                'setRecipient',
                '_d3hasOrderManagerOwnerRecipient',
                'AddBcc',
                '_d3HasOrderManagerCustomMailAddresses',
                '_d3getOrderManagerCustomMailAddressList',
                'd3GetOrderManagerRemark',
            ])
            ->getMock();
        $oModelMock->method('setRecipient')->willReturn(true);
        $oModelMock->method('_d3hasOrderManagerOwnerRecipient')->willReturn(true);
        $oModelMock->expects($this->exactly(3))->method('AddBcc')->willReturn(true);
        $oModelMock->method('_d3HasOrderManagerCustomMailAddresses')->willReturn(true);
        $oModelMock->method('_d3getOrderManagerCustomMailAddressList')->willReturn(['addrNo1', 'addrNo2']);
        $oModelMock->method('d3GetOrderManagerRemark')->willReturn($oRemarkMock);

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
                [$oShopMock]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3getOrderManagerPdfHandler
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function d3GetOrderManagerPdfHandlerReturnsRightInstance()
    {
        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getCurrentItem'])
            ->getMock();
        $oManagerMock->method('getCurrentItem')->willReturn(d3GetOxidDIC()->get('d3ox.ordermanager.'.Order::class));

        $this->assertInstanceOf(
            d3ordermanager_pdfhandler::class,
            $this->callMethod(
                $this->_oModel,
                'd3getOrderManagerPdfHandler',
                [$oManagerMock]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3AddOrderManagerPdfAttachment
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canAddOrderManagerPdfAttachment()
    {
        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods([
                'd3getOrderManagerPdfHandler',
                'd3addOrderManagerOXIDPdfAttachment',
                'd3addOrderManagerPdfDocumentsAttachment',
            ])
            ->getMock();
        $oModelMock->method('d3getOrderManagerPdfHandler')->willReturn($oPdfHandlerMock);
        $oModelMock->expects($this->once())->method('d3addOrderManagerOXIDPdfAttachment')->willReturn(true);
        $oModelMock->expects($this->once())->method('d3addOrderManagerPdfDocumentsAttachment')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            '_d3AddOrderManagerPdfAttachment',
            [d3GetOxidDIC()->get(d3ordermanager::class)]
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3addOrderManagerOXIDPdfAttachment
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canAddOrderManagerOxidPdfAttachmentInvoice()
    {
        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue', 'getCurrentItem'])
            ->getMock();
        $getValueMap = [
            ['blActionOrderGeneratePdf_status', true],
            ['blActionOrderPdfSendAttach', true],
            ['blActionOrderPdfTypeInvoice', true],
            ['blActionOrderPdfTypeDelnote', false],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->onlyMethods([
                'canGenerateOxidPdf',
                'createOxidPdf',
                'getOxidPdfFileName',
                'getOxidPdfSaveDir', ])
            ->setConstructorArgs([
                $oManagerMock,
                d3GetOxidDIC()->get('d3ox.ordermanager.'.Order::class),
            ])
            ->getMock();
        $oPdfHandlerMock->method('canGenerateOxidPdf')->willReturn(true);
        $oPdfHandlerMock->expects($this->once())->method('createOxidPdf')->with(
            $this->stringContains(d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_INVOICE),
            $this->anything()
        );
        $oPdfHandlerMock->method('getOxidPdfFileName')->willReturn('myFilename.pdf');
        $oPdfHandlerMock->method('getOxidPdfSaveDir')->willReturn('saveFir');

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods([
                'd3getOrderManagerPdfHandler',
                'addAttachment',
            ])
            ->getMock();
        $oModelMock->expects($this->once())->method('addAttachment')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'd3addOrderManagerOXIDPdfAttachment',
            [$oManagerMock, $oPdfHandlerMock]
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3addOrderManagerOXIDPdfAttachment
     * @test
     * @throws ReflectionException
     * @throws Exception
     */
    public function canAddOrderManagerOxidPdfAttachmentDNote()
    {
        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
           ->disableOriginalConstructor()
           ->getMock();

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue', 'getCurrentItem'])
            ->getMock();
        $getValueMap = [
            ['blActionOrderGeneratePdf_status', true],
            ['blActionOrderPdfSendAttach', true],
            ['blActionOrderPdfTypeInvoice', false],
            ['blActionOrderPdfTypeDelnote', true],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->onlyMethods([
                'canGenerateOxidPdf',
                'createOxidPdf',
                'getOxidPdfFileName',
                'getOxidPdfSaveDir',
            ])
            ->setConstructorArgs([
                $oManagerMock,
                d3GetOxidDIC()->get('d3ox.ordermanager.'.Order::class),
            ])
            ->getMock();
        $oPdfHandlerMock->method('canGenerateOxidPdf')->willReturn(true);
        $oPdfHandlerMock->expects($this->once())->method('createOxidPdf')->with(
            $this->stringContains(d3ordermanager_conf::D3_ORDERMANAGER_PDFTYPE_DELIVERYNOTE),
            $this->anything()
        );
        $oPdfHandlerMock->method('getOxidPdfFileName')->willReturn("myFileName.pdf");
        $oPdfHandlerMock->method('getOxidPdfSaveDir')->willReturn('saveDir');

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods([
                'd3getOrderManagerPdfHandler',
                'addAttachment',
            ])
            ->getMock();
        $oModelMock->expects($this->once())->method('addAttachment')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'd3addOrderManagerOXIDPdfAttachment',
            [$oManagerMock, $oPdfHandlerMock]
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::_d3AddOrderManagerPdfAttachment
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3addOrderManagerPdfDocumentsAttachment
     * @test
     * @throws ReflectionException
     */
    public function canAddOrderManagerPdfDocumentAttachment()
    {
        d3GetOxidDIC()->set(
            d3ordermanager_pdfhandler::class.'.args.ordermanager',
            d3GetOxidDIC()->get(d3ordermanager::class)
        );
        d3GetOxidDIC()->set(
            d3ordermanager_pdfhandler::class.'.args.order',
            d3GetOxidDIC()->get('d3ox.ordermanager.'.Order::class)
        );

        /** @var d3ordermanager_pdfhandler $oPdfHandler */
        $oPdfHandler = d3GetOxidDIC()->get(d3ordermanager_pdfhandler::class);

        if (false === $oPdfHandler->canGeneratePdfDocuments()) {
            $this->markTestSkipped('no PDF documents module available');
        }

        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var invoicePdf|MockObject $oDocumentMock */
        $oDocumentMock = $this->getMockBuilder(invoicePdf::class)
            ->onlyMethods(['getFilename'])
            ->getMock();
        $oDocumentMock->method('getFilename')->willReturn('testFileName');

        /** @var d3ordermanager_action_getpdfdocuments|MockObject $oActionMock */
        $oActionMock = $this->getMockBuilder(d3ordermanager_action_getpdfdocuments::class)
            ->onlyMethods(['getDocumentList', 'getItem'])
            ->disableOriginalConstructor()
            ->getMock();
        $oActionMock->method('getDocumentList')->willReturn([$oDocumentMock]);
        $oActionMock->method('getItem')->willReturn(oxNew(Order::class));
        d3GetOxidDIC()->set(d3ordermanager_action_getpdfdocuments::class, $oActionMock);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue', 'getCurrentItem'])
            ->getMock();
        $getValueMap = [
            ['blActionOrderGetPdfDocument_status', true],
            ['blActionOrderPdfDocumentSendAttach', true],
            ['blActionOrderPdfDocumentType_invoice', true],
            ['blActionOrderPdfDocumentType_delnote', false],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);
        $oManagerMock->method('getCurrentItem')->willReturn($oOrderMock);

        /** @var d3ordermanager_pdfhandler|MockObject $oPdfHandlerMock */
        $oPdfHandlerMock = $this->getMockBuilder(d3ordermanager_pdfhandler::class)
            ->onlyMethods(['canGeneratePdfDocuments', 'createPdfDocument', 'getOxidPdfSaveDir'])
            ->setConstructorArgs([$oManagerMock, d3GetOxidDIC()->get('d3ox.ordermanager.'.Order::class)])
            ->getMock();
        $oPdfHandlerMock->method('canGeneratePdfDocuments')->willReturn(true);
        $oPdfHandlerMock->expects($this->once())->method('createPdfDocument')->with(
            $this->isInstanceOf(invoicePdf::class),
            $this->anything()
        )->willReturn(true);
        $oPdfHandlerMock->method('getOxidPdfSaveDir')->willReturn('saveDir');

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods(['d3getOrderManagerPdfHandler', 'addAttachment'])
            ->getMock();
        $oModelMock->expects($this->once())->method('addAttachment')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            'd3addOrderManagerPdfDocumentsAttachment',
            [$oManagerMock, $oPdfHandlerMock]
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
            ->onlyMethods(['getRawValue'])
            ->getMock();
        $oFieldMock->method('getRawValue')->willReturn('rawValue');

        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->onlyMethods([
                '__get',
                'getFieldData',
            ])
            ->getMock();
        $oShopMock->method('__get')->willReturn($oFieldMock);
        $oShopMock->method('getFieldData')->willReturn('fieldData');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue'])
            ->getMock();
        $getValueMap = [
            ['sSendMailReplyAddress', 'reply@test.com'],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods([
                'setFrom',
                'setReplyTo',
            ])
            ->getMock();
        $oModelMock->expects($this->once())->method('setFrom')->willReturn(true);
        $oModelMock->expects($this->once())->method('setReplyTo')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            '_d3SetOrderManagerReplyAddress',
            [$oManagerMock, $oShopMock]
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
            ->onlyMethods(['getRawValue'])
            ->getMock();
        $oFieldMock->method('getRawValue')->willReturn('rawValue');

        /** @var Shop|MockObject $oShopMock */
        $oShopMock = $this->getMockBuilder(Shop::class)
            ->onlyMethods([
                '__get',
                'getFieldData',
            ])
            ->getMock();
        $oShopMock->method('__get')->willReturn($oFieldMock);
        $oShopMock->method('getFieldData')->willReturn('fieldData');

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getValue'])
            ->getMock();
        $getValueMap = [
            ['sSendMailReplyAddress', null],
        ];
        $oManagerMock->method('getValue')->willReturnMap($getValueMap);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods([
                'setFrom',
                'setReplyTo',
            ])
            ->getMock();
        $oModelMock->expects($this->atLeastOnce())->method('setFrom')->willReturn(true);
        $oModelMock->expects($this->atLeastOnce())->method('setReplyTo')->willReturn(true);

        $this->_oModel = $oModelMock;

        $this->callMethod(
            $this->_oModel,
            '_d3SetOrderManagerReplyAddress',
            [$oManagerMock, $oShopMock]
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3generateOrderManagerRemark
     * @test
     * @throws ReflectionException
     */
    public function canGenerateRemark()
    {
        /** @var Remark|MockObject $remarkMock */
        $remarkMock = $this->getMockBuilder(Remark::class)
            ->onlyMethods(['assign'])
            ->getMock();
        $remarkMock->method('assign')->with($this->isType('array'))->willReturn(true);

        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods([
                'd3GetOrderManagerRemark',
                'getAllRecipientAddresses',
                'getBody',
                'getAltBody',
            ])
            ->getMock();
        $oModelMock->expects($this->once())->method('d3GetOrderManagerRemark')->willReturn($remarkMock);
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
            ->onlyMethods(['getId'])
            ->getMock();
        $oUserMock->method('getId')->willReturn('userId');

        /** @var Order|MockObject $oOrderMock */
        $oOrderMock = $this->getMockBuilder(Order::class)
            ->onlyMethods(['getOrderUser'])
            ->getMock();
        $oOrderMock->method('getOrderUser')->willReturn($oUserMock);

        /** @var d3ordermanager|MockObject $oManagerMock */
        $oManagerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getCurrentItem'])
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
                'd3generateOrderManagerRemark'
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3getOrderManagerRemarkText
     * @test
     * @throws ReflectionException
     */
    public function canGetRemarkText()
    {
        /** @var d3_oxemail_ordermanager|MockObject $oModelMock */
        $oModelMock = $this->getMockBuilder(Email::class)
            ->onlyMethods([
                'getAllRecipientAddresses',
                'getBody',
                'getAltBody',
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
                'd3getOrderManagerRemarkText'
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

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3getOrderManagerDIContainer
     * @test
     * @throws ReflectionException
     */
    public function getDIContainerHasRightInstance()
    {
        $this->assertInstanceOf(
            ContainerInterface::class,
            $this->callMethod(
                $this->_oModel,
                'd3getOrderManagerDIContainer'
            )
        );
    }

    /**
     * @test
     * @return void
     * @throws ReflectionException
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::getMessageContentGeneratorOrderManager
     */
    public function getMessageContentGeneratorHasRightInstance()
    {
        $item = oxNew(Order::class);
        $item->assign([
            'oxorderdate'   => '2022-02-02 02:02:22',
            'oxsenddate'   => '2022-02-02 02:02:22',
            'oxisnettomode' => false,
            'oxuserid'      => 'userId',
            'oxcurrency'    => 'EUR',
            'oxcardid'      => 'cardid',
            'oxcardtext'    => 'cardtext',
            'oxdelcost'     => 0,
            'oxdelvat'      => 0,
            'oxpaymenttype' => '',
        ]);

        /** @var d3ordermanager|MockObject $managerMock */
        $managerMock = $this->getMockBuilder(d3ordermanager::class)
            ->onlyMethods(['getCurrentItem'])
            ->disableOriginalConstructor()
            ->getMock();
        $managerMock->method('getCurrentItem')->willReturn($item);

        $this->assertInstanceOf(
            MessageContentGenerator::class,
            $this->callMethod(
                $this->_oModel,
                'getMessageContentGeneratorOrderManager',
                [$managerMock]
            )
        );
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::d3OrderManagerThrowUnequalContentException
     * @test
     * @throws ReflectionException
     */
    public function throwUnequalContentExceptionHasRightInstance()
    {
        $this->expectException(d3ordermanager_templaterendererExceptionInterface::class);

        $this->callMethod(
            $this->_oModel,
            'd3OrderManagerThrowUnequalContentException'
        );
    }
}
