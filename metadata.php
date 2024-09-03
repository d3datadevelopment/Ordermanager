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
use D3\Ordermanager\Setup\Events;

use D3\DIContainerHandler\definitionFileContainer;
use D3\Ordermanager\Application\Model\Constants;
use D3\Ordermanager\Modules\Application\Model as ModuleModel;
use D3\Ordermanager\Application\Controller as OMController;
use D3\Ordermanager\Application\Controller\Admin as OMControllerAdmin;
use D3\Ordermanager\Modules\Core\DefinitionFileContainer_ordermanager;
use OxidEsales\Eshop\Application\Model as OxidModel;
use OxidEsales\Eshop\Core as OxidCore;

/**
 * Metadata version
 */
$sMetadataVersion = '2.1';
$sLogo = '<img src="https://logos.oxidmodule.com/d3logo.svg" alt="(D3)" style="height:1em;width:1em"> ';

/**
 * Module information
 */
$aModule = [
    'id'            => 'd3ordermanager',
    'title'         => [
        'de'    => $sLogo . 'Auftragsmanager',
        'en'    => $sLogo . 'Order Manager',
    ],
    'description'  => [
        'de'    => 'Bearbeitet frei definierbare Auftr&auml;ge auf Basis von einstellbaren Bestellungslisten.',
        'en'    => 'Processes freely definable tasks on the basis of adjustable order lists.',
    ],
    'thumbnail'     => 'picture.svg',
    'version'       => '6.0.1.0',
    'author'        => 'D&sup3; Data Development (Inh.: Thomas Dartsch)',
    'email'         => 'support@shopmodule.com',
    'url'           => 'https://www.oxidmodule.com/',
    'extend'        => [
        OxidCore\Email::class                   => ModuleModel\d3_oxemail_ordermanager::class,
        OxidModel\Order::class                  => ModuleModel\d3_oxorder_ordermanager::class,
        OxidModel\User::class                   => ModuleModel\d3_oxuser_ordermanager::class,
        OxidModel\Basket::class                 => ModuleModel\d3_oxbasket_ordermanager::class,
        OxidModel\BasketItem::class             => ModuleModel\d3_oxbasketitem_ordermanager::class,
        definitionFileContainer::class          => DefinitionFileContainer_ordermanager::class,
    ],
    'controllers'   => [
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
        'd3_cfg_ordermanageritem_overview'  => OMControllerAdmin\d3_cfg_ordermanageritem_overview::class,
        'd3_cfg_ordermanageritem_settings'  => OMControllerAdmin\d3_cfg_ordermanageritem_settings::class,
        'd3_cfg_ordermanageritem_requ'      => OMControllerAdmin\d3_cfg_ordermanageritem_requ::class,
        'd3_cfg_ordermanageritem_action'    => OMControllerAdmin\d3_cfg_ordermanageritem_action::class,
        'd3_ordermanager_jobs'              => OMControllerAdmin\d3_ordermanager_jobs::class,
    ],
    'templates'   => [
        '@' . Constants::OXID_MODULE_ID . '/admin/d3_cfg_ordermanagerset_main.tpl' => 'views/smarty/admin/d3_cfg_ordermanagerset_main.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/d3_cfg_ordermanageritem_list.tpl'=> 'views/smarty/admin/d3_cfg_ordermanageritem_list.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/d3_cfg_ordermanageritem_main.tpl'=> 'views/smarty/admin/d3_cfg_ordermanageritem_main.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/d3_cfg_ordermanageritem_mall.tpl'=> 'views/smarty/admin/d3_cfg_ordermanageritem_mall.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/d3_cfg_ordermanageritem_trigger.tpl' => 'views/smarty/admin/d3_cfg_ordermanageritem_trigger.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/d3_cfg_ordermanageritem_overview.tpl'=> 'views/smarty/admin/d3_cfg_ordermanageritem_overview.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/d3_cfg_ordermanageritem_requ.tpl'=> 'views/smarty/admin/d3_cfg_ordermanageritem_requ.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/d3_cfg_ordermanageritem_action.tpl'  => 'views/smarty/admin/d3_cfg_ordermanageritem_action.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/d3_ordermanager_jobs.tpl'        => 'views/smarty/admin/d3_ordermanager_jobs.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/email/html/d3ordermanager_info_html.tpl'    => 'views/smarty/admin/email/html/d3ordermanager_info_html.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/email/plain/d3ordermanager_info_plain.tpl'   => 'views/smarty/admin/email/plain/d3ordermanager_info_plain.tpl',

        '@' . Constants::OXID_MODULE_ID . '/admin/inc/d3ordermanager_activeswitch.tpl'       => 'views/smarty/admin/inc/d3ordermanager_activeswitch.tpl',

        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_fromordernr.tpl' =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_fromordernr.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_toordernr.tpl'             =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_toordernr.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_timespanfilter.tpl'        =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_timespanfilter.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_datenotset.tpl'            =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_datenotset.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_weekdayfilter.tpl'         =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_weekdayfilter.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_paymentfilter.tpl'         =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_paymentfilter.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_deliveryfilter.tpl'        =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_deliveryfilter.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_trackcodefilter.tpl'       =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_trackcodefilter.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_orderstorno.tpl'           =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_orderstorno.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_ordernonstorno.tpl'        =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_ordernonstorno.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_articlestorno.tpl'         =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_articlestorno.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_ordersum.tpl'              =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_ordersum.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_invoiceno.tpl'             =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_invoiceno.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_transactionfilter.tpl'     =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_transactionfilter.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_currencyfilter.tpl'        =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_currencyfilter.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_languagefilter.tpl'        =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_languagefilter.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_folderfilter.tpl'          =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_folderfilter.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_notinfolderfilter.tpl'     =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_notinfolderfilter.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_articlecontent.tpl'        =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_articlecontent.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_noarticlecontent.tpl'      =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_noarticlecontent.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_orderfield.tpl'            =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_orderfield.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_otherjob.tpl'            =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_otherjob.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_mailregexpfilter.tpl'      =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_mailregexpfilter.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_countryfilter.tpl'         =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_countryfilter.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_ingroupfilter.tpl'         =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_ingroupfilter.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_notingroupfilter.tpl'      =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_notingroupfilter.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Requirements/d3ordermanager_requ_executemethodfilter.tpl'      =>
            'views/smarty/admin/Requirements/d3ordermanager_requ_executemethodfilter.tpl',

        'd3_cfg_ordermanageritem_restrictions.tpl'   =>
            'd3/ordermanager/Application/views/admin/tpl/inc/d3_cfg_ordermanageritem_restrictions.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_moveordertofolder.tpl'   =>
            'views/smarty/admin/Actions/d3ordermanager_action_moveordertofolder.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_stornoorder.tpl'         =>
            'views/smarty/admin/Actions/d3ordermanager_action_stornoorder.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_deleteorder.tpl'         =>
            'views/smarty/admin/Actions/d3ordermanager_action_deleteorder.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_setsendednowdate.tpl'    =>
            'views/smarty/admin/Actions/d3ordermanager_action_setsendednowdate.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_setpaiddate.tpl'         =>
            'views/smarty/admin/Actions/d3ordermanager_action_setpaiddate.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_setfieldvalue.tpl'       =>
            'views/smarty/admin/Actions/d3ordermanager_action_setfieldvalue.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_executemethod.tpl'       =>
            'views/smarty/admin/Actions/d3ordermanager_action_executemethod.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_changedelcosts.tpl'      =>
            'views/smarty/admin/Actions/d3ordermanager_action_changedelcosts.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_changediscount.tpl'      =>
            'views/smarty/admin/Actions/d3ordermanager_action_changediscount.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_generatepdf.tpl'         =>
            'views/smarty/admin/Actions/d3ordermanager_action_generatepdf.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_getpdfdocuments.tpl'         =>
            'views/smarty/admin/Actions/d3ordermanager_action_getpdfdocuments.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_custaddtogroup.tpl'      =>
            'views/smarty/admin/Actions/d3ordermanager_action_custaddtogroup.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_custdelfromgroup.tpl'    =>
            'views/smarty/admin/Actions/d3ordermanager_action_custdelfromgroup.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_sendmail.tpl'            =>
            'views/smarty/admin/Actions/d3ordermanager_action_sendmail.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_sendpushnotification.tpl'            =>
            'views/smarty/admin/Actions/d3ordermanager_action_sendpushnotification.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/Actions/d3ordermanager_action_exportlist.tpl'          =>
            'views/smarty/admin/Actions/d3ordermanager_action_exportlist.tpl',

        '@' . Constants::OXID_MODULE_ID . '/email/html/d3ordermanager_delivery_delay.tpl'          =>
            'views/smarty/email/html/d3ordermanager_delivery_delay.tpl',
        '@' . Constants::OXID_MODULE_ID . '/email/html/d3ordermanager_delivery_delay_subject.tpl'          =>
            'views/smarty/email/html/d3ordermanager_delivery_delay_subject.tpl',
        '@' . Constants::OXID_MODULE_ID . '/email/plain/d3ordermanager_delivery_delay.tpl'          =>
            'views/smarty/email/plain/d3ordermanager_delivery_delay.tpl',

        '@' . Constants::OXID_MODULE_ID . '/admin/export-templates/CSV-Vorlage.tpl'          =>
            'views/smarty/admin/export-templates/CSV-Vorlage.tpl',
        '@' . Constants::OXID_MODULE_ID . '/admin/export-templates/XML-Vorlage.tpl'          =>
            'views/smarty/admin/export-templates/XML-Vorlage.tpl',
    ],
    'events'      => [
        'onActivate'    => Events::class . '::onActivate',
    ],
    'blocks'      => [
        [
            'template'  => 'order_remark.tpl',
            'block'     => 'admin_order_remark_type',
            'file'      => 'views/smarty/blocks/admin/d3ordermanager_order_remark_type.tpl',
        ],
    ],
];
