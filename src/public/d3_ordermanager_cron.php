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
use OxidEsales\Eshop\Core\Config;

// @codeCoverageIgnoreStart

$bootstrapFileName = getenv('ESHOP_BOOTSTRAP_PATH');
if (!empty($bootstrapFileName)) {
    $bootstrapFileName = realpath(trim(getenv('ESHOP_BOOTSTRAP_PATH')));
} else {
    $count = 0;
    $bootstrapFileName = '../../../source/bootstrap.php';
    $currentDirectory = __DIR__ . '/';
    while ($count < 5) {
        $count++;
        if (file_exists($currentDirectory . $bootstrapFileName)) {
            $bootstrapFileName = $currentDirectory . $bootstrapFileName;
            break;
        }
        $bootstrapFileName = '../' . $bootstrapFileName;
    }
}

if (!(file_exists($bootstrapFileName) && !is_dir($bootstrapFileName))) {
    $items = [
        "Unable to find eShop bootstrap.php file.",
        "You can override the path by using ESHOP_BOOTSTRAP_PATH environment variable.",
        "\n"
    ];

    $message = implode(" ", $items);

    die($message);
}

require_once($bootstrapFileName);

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

try {
    /** @var $oResponse d3ordermanager_response */
    $oResponse = d3GetModCfgDIC()->get(d3ordermanager_response::class);
    try {
        $oResponse->init();
    } catch (Exception $oEx) {
        ob_end_flush();
    }
    ob_end_flush();

    /** @var Config $config */
    $config = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);
} catch ( Exception $oEx) {}
$config->pageClose();

// @codeCoverageIgnoreEnd