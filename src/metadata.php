<?php

use D3\Ordermanager\Setup as ModuleSetup;
use D3\ModCfg\Application\Model\d3utils;
use OxidEsales\Eshop\Application\Controller as OxidController;
use OxidEsales\Eshop\Application\Model as OxidModel;
use OxidEsales\Eshop\Core as OxidCore;

/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = array(
    'id'            => 'd3ordermanager',
    'title'         =>
        (class_exists(d3utils::class) ? d3utils::getInstance()->getD3Logo() : 'D&sup3;') .
        ' Auftragsmanager / Order Manager',
    'description'  => array(
        'de'    => 'Bearbeitet frei definierbare Auftr&auml;ge auf Basis von einstellbaren Bestellungslisten.',
        'en'    => ''),
    'thumbnail'     => 'picture.png',
    'version'       => '3.0.0.0',
    'author'        => 'D&sup3; Data Development (Inh.: Thomas Dartsch)',
    'email'         => 'support@shopmodule.com',
    'url'           => 'http://www.oxidmodule.com/',
    'extend'        => array(
        OxidCore\Email::class                   => \D3\Ordermanager\Modules\Application\Model\d3_oxemail_ordermanager::class,
        OxidModel\Order::class                  => \D3\Ordermanager\Modules\Application\Model\d3_oxorder_ordermanager::class,
        OxidModel\User::class                   => \D3\Ordermanager\Modules\Application\Model\d3_oxuser_ordermanager::class,
        OxidModel\Basket::class                 => \D3\Ordermanager\Modules\Application\Model\d3_oxbasket_ordermanager::class,
        OxidModel\BasketItem::class             => \D3\Ordermanager\Modules\Application\Model\d3_oxbasketitem_ordermanager::class,
        OxidController\Admin\OrderRemark::class => \D3\Ordermanager\Modules\Application\Controller\Admin\d3_order_remark_ordermanager::class,
    ),
    'controllers'   => array(
        'd3ordermanager_response'           => \D3\Ordermanager\Application\Controller\d3ordermanager_response::class,
        
        'd3_cfg_ordermanagerset'            => \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset::class,
        'd3_cfg_ordermanagerset_list'       => \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_list::class,
        'd3_cfg_ordermanagerset_main'       => \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main::class,
        'd3_cfg_ordermanagerlog'            => \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerlog::class,
        'd3_cfg_ordermanagerlog_list'       => \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerlog_list::class,
        'd3_cfg_ordermanagerset_licence'    => \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_licence::class,
        'd3_cfg_ordermanageritem'           => \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem::class,
        'd3_cfg_ordermanageritem_list'      => \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_list::class,
        'd3_cfg_ordermanageritem_main'      => \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_main::class,
        'd3_cfg_ordermanageritem_mall'      => \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_mall::class,
        'd3_cfg_ordermanageritem_overview'  =>
            \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_overview::class,
        'd3_cfg_ordermanageritem_settings'  =>
            \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_settings::class,
        'd3_cfg_ordermanageritem_requ'      => \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ::class,
        'd3_cfg_ordermanageritem_action'    => \D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action::class,
        'd3_ordermanager_jobs'              => \D3\Ordermanager\Application\Controller\Admin\d3_ordermanager_jobs::class,
    ),
    'templates'   => array(
        'd3_cfg_ordermanagerset_main.tpl'       => 'd3/ordermanager/Application/views/admin/tpl/d3_cfg_ordermanagerset_main.tpl',
        'd3_cfg_ordermanageritem_list.tpl'      => 'd3/ordermanager/Application/views/admin/tpl/d3_cfg_ordermanageritem_list.tpl',
        'd3_cfg_ordermanageritem_main.tpl'      => 'd3/ordermanager/Application/views/admin/tpl/d3_cfg_ordermanageritem_main.tpl',
        'd3_cfg_ordermanageritem_mall.tpl'      => 'd3/ordermanager/Application/views/admin/tpl/d3_cfg_ordermanageritem_mall.tpl',
        'd3_cfg_ordermanageritem_overview.tpl'  =>
            'd3/ordermanager/Application/views/admin/tpl/d3_cfg_ordermanageritem_overview.tpl',
        'd3_cfg_ordermanageritem_requ.tpl'      => 'd3/ordermanager/Application/views/admin/tpl/d3_cfg_ordermanageritem_requ.tpl',
        'd3_cfg_ordermanageritem_action.tpl'    =>
            'd3/ordermanager/Application/views/admin/tpl/d3_cfg_ordermanageritem_action.tpl',
        'd3_ordermanager_jobs.tpl'              => 'd3/ordermanager/Application/views/admin/tpl/d3_ordermanager_jobs.tpl',
        'd3ordermanager_info_html.tpl'          =>
            'd3/ordermanager/Application/views/admin/tpl/email/html/d3ordermanager_info_html.tpl',
        'd3ordermanager_info_plain.tpl'         =>
            'd3/ordermanager/Application/views/admin/tpl/email/plain/d3ordermanager_info_plain.tpl',
        'd3_ordermanager_order_remark.tpl'         =>
            'd3/ordermanager/Application/views/admin/tpl/d3_ordermanager_order_remark.tpl',

        'd3ordermanager_requ_fromordernr.tpl'           =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_fromordernr.tpl',
        'd3ordermanager_requ_toordernr.tpl'             =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_toordernr.tpl',
        'd3ordermanager_requ_timespanfilter.tpl'        =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_timespanfilter.tpl',
        'd3ordermanager_requ_datenotset.tpl'            =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_datenotset.tpl',
        'd3ordermanager_requ_weekdayfilter.tpl'         =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_weekdayfilter.tpl',
        'd3ordermanager_requ_paymentfilter.tpl'         =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_paymentfilter.tpl',
        'd3ordermanager_requ_deliveryfilter.tpl'        =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_deliveryfilter.tpl',
        'd3ordermanager_requ_trackcodefilter.tpl'       =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_trackcodefilter.tpl',
        'd3ordermanager_requ_orderstorno.tpl'           =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_orderstorno.tpl',
        'd3ordermanager_requ_ordernonstorno.tpl'        =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_ordernonstorno.tpl',
        'd3ordermanager_requ_articlestorno.tpl'         =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_articlestorno.tpl',
        'd3ordermanager_requ_ordersum.tpl'              =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_ordersum.tpl',
        'd3ordermanager_requ_invoiceno.tpl'             =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_invoiceno.tpl',
        'd3ordermanager_requ_transactionfilter.tpl'     =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_transactionfilter.tpl',
        'd3ordermanager_requ_currencyfilter.tpl'        =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_currencyfilter.tpl',
        'd3ordermanager_requ_languagefilter.tpl'        =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_languagefilter.tpl',
        'd3ordermanager_requ_folderfilter.tpl'          =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_folderfilter.tpl',
        'd3ordermanager_requ_notinfolderfilter.tpl'     =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_notinfolderfilter.tpl',
        'd3ordermanager_requ_articlecontent.tpl'        =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_articlecontent.tpl',
        'd3ordermanager_requ_noarticlecontent.tpl'      =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_noarticlecontent.tpl',
        'd3ordermanager_requ_orderfield.tpl'            =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_orderfield.tpl',
        'd3ordermanager_requ_otherjob.tpl'            =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_otherjob.tpl',
        'd3ordermanager_requ_mailregexpfilter.tpl'      =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_mailregexpfilter.tpl',
        'd3ordermanager_requ_countryfilter.tpl'         =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_countryfilter.tpl',
        'd3ordermanager_requ_ingroupfilter.tpl'         =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_ingroupfilter.tpl',
        'd3ordermanager_requ_notingroupfilter.tpl'      =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_notingroupfilter.tpl',
        'd3ordermanager_requ_executemethodfilter.tpl'      =>
            'd3/ordermanager/Application/views/admin/tpl/Requirements/d3ordermanager_requ_executemethodfilter.tpl',

        'd3_cfg_ordermanageritem_restrictions.tpl'   =>
            'd3/ordermanager/Application/views/admin/tpl/inc/d3_cfg_ordermanageritem_restrictions.tpl',
        'd3ordermanager_action_moveordertofolder.tpl'   =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_moveordertofolder.tpl',
        'd3ordermanager_action_stornoorder.tpl'         =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_stornoorder.tpl',
        'd3ordermanager_action_deleteorder.tpl'         =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_deleteorder.tpl',
        'd3ordermanager_action_setsendednowdate.tpl'    =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_setsendednowdate.tpl',
        'd3ordermanager_action_setpaiddate.tpl'         =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_setpaiddate.tpl',
        'd3ordermanager_action_setfieldvalue.tpl'       =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_setfieldvalue.tpl',
        'd3ordermanager_action_executemethod.tpl'       =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_executemethod.tpl',
        'd3ordermanager_action_changedelcosts.tpl'      =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_changedelcosts.tpl',
        'd3ordermanager_action_changediscount.tpl'      =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_changediscount.tpl',
        'd3ordermanager_action_generatepdf.tpl'         =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_generatepdf.tpl',
        'd3ordermanager_action_custaddtogroup.tpl'      =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_custaddtogroup.tpl',
        'd3ordermanager_action_custdelfromgroup.tpl'    =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_custdelfromgroup.tpl',
        'd3ordermanager_action_sendmail.tpl'            =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_sendmail.tpl',
        'd3ordermanager_action_exportlist.tpl'          =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_exportlist.tpl',
    ),
    'events'      => [
        'onActivate'    => '\D3\Ordermanager\Setup\Events::onActivate',
    ],
    'blocks'      => array(
        array(
            'template'  => 'order_remark.tpl',
            'block'     => 'admin_order_remark_type',
            'file'      => 'Application/views/admin/blocks/d3ordermanager_order_remark_type.tpl',
        )
    ),
    'd3FileRegister'    => array(
        'd3/ordermanager/IntelliSenseHelper.php',
        'd3/ordermanager/metadata.php',
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
        'd3/ordermanager/Application/Model/Exceptions/d3ordermanager_cronunavailableexception.php',
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
    ),
    'd3SetupClasses'    => array(
        ModuleSetup\d3ordermanager_update::class,
    ),
);
