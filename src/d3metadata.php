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

use D3\Ordermanager\Setup as ModuleSetup;

/**
 * Module information
 */
$aModule = array(
    'd3FileRegister'    => array(
        'd3/ordermanager/IntelliSenseHelper.php',
        'd3/ordermanager/metadata.php',
        'd3/ordermanager/d3metadata.php',
        'd3/ordermanager/models/Requirements/d3ordermanager_requirement_orderarticlefilter_abstract.php',
        'd3/ordermanager/Application/views/admin/blocks/d3ordermanager_order_remark_type.tpl',
        'd3/ordermanager/Application/views/admin/de/d3_ordermanager_lang.php',
        'd3/ordermanager/Application/views/admin/en/d3_ordermanager_lang.php',
        'd3/ordermanager/Application/views/admin/tpl/d3_ordermanager_bottomnaviitem.tpl',
        'd3/ordermanager/Application/views/admin/tpl/email/html/d3ordermanager_delivery_delay.tpl',
        'd3/ordermanager/Application/views/admin/tpl/email/plain/d3ordermanager_delivery_delay.tpl',
        'd3/ordermanager/Application/views/tpl/email/html/d3ordermanager_delivery_delay.tpl',
        'd3/ordermanager/Application/views/tpl/email/html/d3ordermanager_delivery_delay_subject.tpl',
        'd3/ordermanager/Application/views/tpl/email/plain/d3ordermanager_delivery_delay.tpl',

        'd3/ordermanager/Application/Controller/d3ordermanager_response.php',
        'd3/ordermanager/Application/Controller/Admin/d3_cfg_ordermanageritem_action.php',
        'd3/ordermanager/Application/Controller/Admin/d3_cfg_ordermanageritem.php',
        'd3/ordermanager/Application/Controller/Admin/d3_ordermanager_jobs.php',
        'd3/ordermanager/Application/Controller/Admin/d3_cfg_ordermanagerlog.php',
        'd3/ordermanager/Application/Controller/Admin/d3_cfg_ordermanagerset_main.php',
        'd3/ordermanager/Application/Controller/Admin/d3_cfg_ordermanageritem_mall.php',
        'd3/ordermanager/Application/Controller/Admin/d3_cfg_ordermanageritem_list.php',
        'd3/ordermanager/Application/Controller/Admin/d3_cfg_ordermanageritem_requ.php',
        'd3/ordermanager/Application/Controller/Admin/d3_cfg_ordermanagerlog_list.php',
        'd3/ordermanager/Application/Controller/Admin/d3_cfg_ordermanageritem_settings.php',
        'd3/ordermanager/Application/Controller/Admin/d3_cfg_ordermanageritem_main.php',
        'd3/ordermanager/Application/Controller/Admin/d3_cfg_ordermanagerset.php',
        'd3/ordermanager/Application/Controller/Admin/d3_cfg_ordermanagerset_list.php',
        'd3/ordermanager/Application/Controller/Admin/d3_cfg_ordermanageritem_overview.php',
        'd3/ordermanager/Application/Controller/Admin/d3_cfg_ordermanagerset_licence.php',
        'd3/ordermanager/Application/Model/d3ordermanager_pdfhandler.php',
        'd3/ordermanager/Application/Model/d3ordermanagerlist.php',
        'd3/ordermanager/Application/Model/d3ordermanager_listgenerator.php',
        'd3/ordermanager/Application/Model/d3ordermanager_export.php',
        'd3/ordermanager/Application/Model/d3ordermanager.php',
        'd3/ordermanager/Application/Model/Exceptions/d3ordermanager_cronUnavailableException.php',
        'd3/ordermanager/Application/Model/Exceptions/d3ordermanager_requirementException.php',
        'd3/ordermanager/Application/Model/d3ordermanager_toorderassignment.php',
        'd3/ordermanager/Application/Model/d3ordermanager_execute.php',
        'd3/ordermanager/Application/Model/d3ordermanager_conf.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_custaddtogroup.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_setsendednowdate.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_exportlist.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_actionlist.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_deleteorder.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_stornoorder.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_moveordertofolder.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_setpaiddate.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_changediscount.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_executemethod.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_custdelfromgroup.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_generatepdf.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_actiongrouplist.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_changedelcosts.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_abstract.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_sendmail.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_setfieldvalue.php',
        'd3/ordermanager/Application/Model/Actions/d3ordermanager_action_interface.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_notinfolderfilter.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_folderfilter.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirementgrouplist.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_toordernr.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_articlestorno.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_mailregexpfilter.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_trackcodefilter.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirementlist.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_abstract.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_executemethodfilter.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_articlecontent_abstract.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_languagefilter.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_invoiceno.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_ordersum.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_otherjob.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_orderstorno.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_deliveryfilter.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_noarticlecontent_abstract.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_articlecontent1.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_transactionfilter.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_orderarticlefilter_abstract.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_noarticlecontent1.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_ingroupfilter.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_articlecontent2.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_timespanfilter1.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_ordernonstorno.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_paymentfilter.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_timespanfilter2.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_noarticlecontent2.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_interface.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_orderfield.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_fromordernr.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_datenotset.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_notingroupfilter.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_weekdayfilter.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_currencyfilter.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_timespanfilter_abstract.php',
        'd3/ordermanager/Application/Model/Requirements/d3ordermanager_requirement_countryfilter.php',
        'd3/ordermanager/Application/Model/d3ordermanager_partgrouplist_abstract.php',
        'd3/ordermanager/Application/Model/d3ordermanager_partgrouplist_interface.php',
        'd3/ordermanager/Application/Model/d3ordermanager_remark.php',
        'd3/ordermanager/Config/services.php',
        'd3/ordermanager/Setup/d3ordermanager_update.php',
        'd3/ordermanager/public/d3_ordermanager_cron.php',
        
        'd3/ordermanager/Application/views/admin/tpl/export-templates/XML-Vorlage.tpl',
        'd3/ordermanager/Application/views/admin/tpl/export-templates/CSV-Vorlage.tpl',

        'd3/ordermanager/Modules/Application/Controller/Admin/d3_order_remark_ordermanager.php',
        'd3/ordermanager/Modules/Application/Model/d3_oxorder_ordermanager.php',
        'd3/ordermanager/Modules/Application/Model/d3_oxbasket_ordermanager.php',
        'd3/ordermanager/Modules/Application/Model/d3_oxbasketitem_ordermanager.php',
        'd3/ordermanager/Modules/Application/Model/d3_oxuser_ordermanager.php',
        'd3/ordermanager/Modules/Application/Model/d3_oxemail_ordermanager.php',

        'd3/ordermanager/Setup/Events.php',

        'd3/ordermanager/tests/additional.inc.php',
        'd3/ordermanager/tests/d3ordermanager_config.php',
        'd3/ordermanager/tests/unit/d3OrdermanagerUnitTestCase.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractiongeneratepdfTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractionchangediscountTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractionchangedelcostsTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractionmoveordertofolderTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractionstornoorderTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractioncustdelfromgroupTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractiondeleteorderTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractionsetpaiddateTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractionsetfieldvalueTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractioncustaddtogroupTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractionsetsendednowdateTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3OrdermanagerActionUnitTestCase.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractionexportlistTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractiongrouplistTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractionlistTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractionsendmailTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Actions/d3ordermanageractionexecutemethodTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequweekdayfilterTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequinvoicenoTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequnoarticlecontent2Test.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequirementgrouplistTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequirementlistTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequtimespanfilter2Test.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequordernonstornoTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequdatenotsetTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequfolderfilterTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequcountryfilterTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequmailregexpfilterTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequnoarticlecontent1Test.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequorderstornoTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequtoordernrTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequtimespanfilter1Test.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequarticlecontent1Test.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequtrackcodefilterTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequpaymentfilterTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequdeliveryfilterTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequfromordernrTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequordersumTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequexecutemethodfilterTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequlanguagefilterTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequarticlestornoTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequorderfieldTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequarticlecontent2Test.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequingroupfilterTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequtransactionfilterTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequnotinfolderfilterTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequcurrencyfilterTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequnotingroupfilterTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3ordermanagerrequotherjobTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Requirements/d3OrdermanagerRequirementUnitTestCase.php',
        'd3/ordermanager/tests/unit/Application/Model/d3ordermanagerTest.php',
        'd3/ordermanager/tests/unit/Application/Model/d3ordermanager_executeTest.php',
        'd3/ordermanager/tests/unit/Modules/Application/Model/d3_oxbasket_ordermanagerTest.php',
        'd3/ordermanager/tests/unit/Modules/Application/Model/d3_oxbasketitem_ordermanagerTest.php',
        'd3/ordermanager/tests/unit/Application/Model/d3ordermanager_listgeneratorTest.php',
        'd3/ordermanager/tests/unit/Application/Model/d3ordermanager_pdfhandlerTest.php',
        'd3/ordermanager/tests/unit/Application/Model/d3ordermanager_remarkTest.php',
        'd3/ordermanager/tests/unit/Application/Model/d3ordermanager_exportTest.php',
        'd3/ordermanager/tests/unit/Application/Model/d3ordermanagerlistTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Exceptions/d3ordermanager_cronUnavailableExceptionTest.php',
        'd3/ordermanager/tests/unit/Application/Model/Exceptions/d3ordermanager_requirementExceptionTest.php',
        'd3/ordermanager/tests/unit/Application/Model/d3ordermanager_confTest.php',
        'd3/ordermanager/tests/unit/Application/Model/d3ordermanager_toorderassignmentTest.php',
        'd3/ordermanager/tests/unit/Application/Controller/d3ordermanager_responseTest.php',
        'd3/ordermanager/tests/unit/Application/Controller/Admin/d3_cfg_ordermanagerlogTest.php',
        'd3/ordermanager/tests/unit/Application/Controller/Admin/d3_cfg_ordermanagerset_mainTest.php',
        'd3/ordermanager/tests/unit/Application/Controller/Admin/d3_cfg_ordermanageritemTest.php',
        'd3/ordermanager/tests/unit/Application/Controller/Admin/d3_cfg_ordermanagersetTest.php',
        'd3/ordermanager/tests/unit/Application/Controller/Admin/d3_cfg_ordermanageritem_mallTest.php',
        'd3/ordermanager/tests/unit/Application/Controller/Admin/d3_cfg_ordermanageritem_actionTest.php',
        'd3/ordermanager/tests/unit/Application/Controller/Admin/d3_cfg_ordermanageritem_triggerTest.php',
        'd3/ordermanager/tests/unit/Application/Controller/Admin/d3_cfg_ordermanageritem_settingsTest.php',
        'd3/ordermanager/tests/unit/Application/Controller/Admin/d3_cfg_ordermanagerset_listTest.php',
        'd3/ordermanager/tests/unit/Application/Controller/Admin/d3_cfg_ordermanageritem_listTest.php',
        'd3/ordermanager/tests/unit/Application/Controller/Admin/d3_cfg_ordermanageritem_mainTest.php',
        'd3/ordermanager/tests/unit/Application/Controller/Admin/d3_ordermanager_jobsTest.php',
        'd3/ordermanager/tests/unit/Application/Controller/Admin/d3_cfg_ordermanageritem_requTest.php',
        'd3/ordermanager/tests/unit/Application/Controller/Admin/d3_cfg_ordermanageritem_overviewTest.php',
        'd3/ordermanager/tests/unit/Modules/Application/Controller/Admin/d3_order_remark_ordermanagerTest.php',
        'd3/ordermanager/tests/unit/Modules/Application/Model/d3_oxuser_ordermanagerTest.php',
        'd3/ordermanager/tests/unit/Modules/Application/Model/d3_oxorder_ordermanagerTest.php',
        'd3/ordermanager/tests/unit/Modules/Application/Model/d3_oxemail_ordermanagerTest.php',
        'd3/ordermanager/tests/unit/public/d3_ordermanager_cronTest.php',
        'd3/ordermanager/tests/unit/Setup/d3ordermanager_updateTest.php',
        'd3/ordermanager/tests/integration/Requirements/d3OrdermanagerRequirementIntegrationTestCase.php'.
        'd3/ordermanager/tests/integration/Requirements/requirementOrderSumTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementInvoiceNoTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementInGroupFilterTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementArticleContentTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementCountryFilterTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementOrderStornoTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementOtherJobTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementMailRegexpFilterTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementOrderNoStornoTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementTrackCodeFilterTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementLanguageFilterTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementExecuteMethodFilterTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementDateNotSetTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementPaymentFilterTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementNotInGroupFilterTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementToOrderNrTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementArticleStornoTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementNoArticleContentTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementFromOrderNrTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementOrderFieldTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementCurrencyFilterTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementWeekdayFilterTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementTimespanFilterTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementDeliveryFilterTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementTransactionFilterTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementFolderFilterTest.php',
        'd3/ordermanager/tests/integration/Requirements/requirementNotInFolderFilterTest.php',
        'd3/ordermanager/tests/integration/d3OrdermanagerIntegrationTestCase.php',
        'd3/ordermanager/tests/integration/Actions/actionSetPaidDateTest.php',
        'd3/ordermanager/tests/integration/Actions/d3OrdermanagerActionIntegrationTestCase.php',
        'd3/ordermanager/tests/integration/Actions/actionDeleteOrderTest.php',
        'd3/ordermanager/tests/integration/Actions/actionSetFieldValueTest.php',
        'd3/ordermanager/tests/integration/Actions/actionCustDelFromGroupTest.php',
        'd3/ordermanager/tests/integration/Actions/actionChangeDelCostsTest.php',
        'd3/ordermanager/tests/integration/Actions/actionExecuteMethodTest.php',
        'd3/ordermanager/tests/integration/Actions/actionSetSendedNowDateTest.php',
        'd3/ordermanager/tests/integration/Actions/actionStornoOrderTest.php',
        'd3/ordermanager/tests/integration/Actions/actionMoveOrderToFolderTest.php',
        'd3/ordermanager/tests/integration/Actions/actionChangeDiscountTest.php',
        'd3/ordermanager/tests/integration/Actions/actionCustAddToGroupTest.php',
        'd3/ordermanager/tests/integration/Requirements/d3OrdermanagerRequirementIntegrationTestCase.php',
        'd3/ordermanager/tests/integration/Requirements/requirementOrderSumTest.php',
        'd3/ordermanager/tests/integration/executeCronTest.php',
        'd3/ordermanager/tests/integration/Admin/jobListTest.php',
    ),
    'd3SetupClasses'    => array(
        ModuleSetup\d3ordermanager_update::class,
    ),
    'd3DICDefinitionFiles'  => [
        'd3/ordermanager/Config/services.yaml',
    ]
);