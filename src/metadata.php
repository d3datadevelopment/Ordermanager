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

use D3\Ordermanager\Modules\Application\Model as ModuleModel;
use D3\Ordermanager\Application\Controller as OMController;
use D3\Ordermanager\Application\Controller\Admin as OMControllerAdmin;
use D3\ModCfg\Application\Model\d3utils;
use OxidEsales\Eshop\Application\Model as OxidModel;
use OxidEsales\Eshop\Core as OxidCore;

/**
 * Metadata version
 */
$sMetadataVersion = '2.1';

/**
 * Module information
 */
$aModule = array(
    'id'            => 'd3ordermanager',
    'title'         =>
        '<img src="https://logos.oxidmodule.com/d3logo.svg" alt="(D3)" style="height:1em;width:1em"> '.
        'Auftragsmanager / Order Manager',
    'description'  => array(
        'de'    => 'Bearbeitet frei definierbare Auftr&auml;ge auf Basis von einstellbaren Bestellungslisten.',
        'en'    => ''),
    'thumbnail'     => 'picture.png',
    'version'       => '4.1.0.0',
    'author'        => 'D&sup3; Data Development (Inh.: Thomas Dartsch)',
    'email'         => 'support@shopmodule.com',
    'url'           => 'http://www.oxidmodule.com/',
    'extend'        => array(
        OxidCore\Email::class                   => ModuleModel\d3_oxemail_ordermanager::class,
        OxidModel\Order::class                  => ModuleModel\d3_oxorder_ordermanager::class,
        OxidModel\User::class                   => ModuleModel\d3_oxuser_ordermanager::class,
        OxidModel\Basket::class                 => ModuleModel\d3_oxbasket_ordermanager::class,
        OxidModel\BasketItem::class             => ModuleModel\d3_oxbasketitem_ordermanager::class
    ),
    'controllers'   => array(
        'd3ordermanager_response'           => OMController\d3ordermanager_response::class,
        
        'd3_cfg_ordermanagerset'            => OMControllerAdmin\d3_cfg_ordermanagerset::class,
        'd3_cfg_ordermanagerset_list'       => OMControllerAdmin\d3_cfg_ordermanagerset_list::class,
        'd3_cfg_ordermanagerset_main'       => OMControllerAdmin\d3_cfg_ordermanagerset_main::class,
        'd3_cfg_ordermanagerlog'            => OMControllerAdmin\d3_cfg_ordermanagerlog::class,
        'd3_cfg_ordermanagerlog_list'       => OMControllerAdmin\d3_cfg_ordermanagerlog_list::class,
        'd3_cfg_ordermanagerset_licence'    => OMControllerAdmin\d3_cfg_ordermanagerset_licence::class,
        'd3_cfg_ordermanageritem'           => OMControllerAdmin\d3_cfg_ordermanageritem::class,
        'd3_cfg_ordermanageritem_list'      => OMControllerAdmin\d3_cfg_ordermanageritem_list::class,
        'd3_cfg_ordermanageritem_main'      => OMControllerAdmin\d3_cfg_ordermanageritem_main::class,
        'd3_cfg_ordermanageritem_mall'      => OMControllerAdmin\d3_cfg_ordermanageritem_mall::class,
        'd3_cfg_ordermanageritem_trigger'   => OMControllerAdmin\d3_cfg_ordermanageritem_trigger::class,
        'd3_cfg_ordermanageritem_overview'  =>
            OMControllerAdmin\d3_cfg_ordermanageritem_overview::class,
        'd3_cfg_ordermanageritem_settings'  =>
            OMControllerAdmin\d3_cfg_ordermanageritem_settings::class,
        'd3_cfg_ordermanageritem_requ'      => OMControllerAdmin\d3_cfg_ordermanageritem_requ::class,
        'd3_cfg_ordermanageritem_action'    => OMControllerAdmin\d3_cfg_ordermanageritem_action::class,
        'd3_ordermanager_jobs'              => OMControllerAdmin\d3_ordermanager_jobs::class,
    ),
    'templates'   => array(
        'd3_cfg_ordermanagerset_main.tpl'       => 'd3/ordermanager/Application/views/admin/tpl/d3_cfg_ordermanagerset_main.tpl',
        'd3_cfg_ordermanageritem_list.tpl'      => 'd3/ordermanager/Application/views/admin/tpl/d3_cfg_ordermanageritem_list.tpl',
        'd3_cfg_ordermanageritem_main.tpl'      => 'd3/ordermanager/Application/views/admin/tpl/d3_cfg_ordermanageritem_main.tpl',
        'd3_cfg_ordermanageritem_mall.tpl'      => 'd3/ordermanager/Application/views/admin/tpl/d3_cfg_ordermanageritem_mall.tpl',
        'd3_cfg_ordermanageritem_trigger.tpl'   => 'd3/ordermanager/Application/views/admin/tpl/d3_cfg_ordermanageritem_trigger.tpl',
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
        'd3ordermanager_action_getpdfdocuments.tpl'         =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_getpdfdocuments.tpl',
        'd3ordermanager_action_custaddtogroup.tpl'      =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_custaddtogroup.tpl',
        'd3ordermanager_action_custdelfromgroup.tpl'    =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_custdelfromgroup.tpl',
        'd3ordermanager_action_sendmail.tpl'            =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_sendmail.tpl',
        'd3ordermanager_action_sendpushnotification.tpl'            =>
            'd3/ordermanager/Application/views/admin/tpl/Actions/d3ordermanager_action_sendpushnotification.tpl',
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
    )
);
