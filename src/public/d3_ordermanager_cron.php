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
use OxidEsales\Eshop\Core\Registry;

/**
 * Returns shop base path.
 *
 * @return string
 */
if (!function_exists('getShopBasePath')) {
    function getShopBasePath()
    {
        return dirname(__FILE__) . '/../../../../';
    }
}

require_once getShopBasePath() . "/bootstrap.php";

// required for recalculating order and generating pdf
define('OX_IS_ADMIN', true);

if (false == function_exists('isAdmin')) {
    /**
     * @return bool
     */
    function isAdmin()
    {
        if (defined('OX_IS_ADMIN')) {
            return OX_IS_ADMIN;
        }

        return true;
    }
}

ob_start();

$aTranslation['shp'] = '';
$aTranslation['cjid'] = '';
$aTranslation['key'] = '';

if (isset($argv) && is_array($argv) && count($argv)) {
    $aParams = array();
    $aTranslation['shp'] = $argv[1];
    $aTranslation['cjid'] = $argv[2];
    $aTranslation['key'] = $argv[3];
    foreach ($aTranslation as $sKey => $mValue) {
        $aParams[$sKey] = $mValue;
    }
    $_GET = $aParams;
}

/** @var $oResponse d3ordermanager_response */
$oResponse = oxNew(d3ordermanager_response::class);
$oResponse->init();
ob_end_flush();

Registry::getConfig()->pageClose();
