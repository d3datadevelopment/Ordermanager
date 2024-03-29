<?php

/**
 * This Software is the property of Data Development and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * https://www.d3data.de
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development - Daniel Seifert <support@shopmodule.com>
 * @link      https://www.oxidmodule.com
 */

declare(strict_types=1);

namespace D3\Ordermanager\Application\Controller\Admin;

use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_main;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_vars as VariablesTrait;
use Doctrine\DBAL\DBALException;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Request;

class d3_cfg_ordermanageritem_main extends d3_cfg_mod_main
{
    use VariablesTrait;

    protected $_sSavedId = null;
    protected $_sSetModId = 'd3_ordermanager';
    protected $_sModId = 'd3_ordermanager';
    protected $_sMenuItemTitle = 'd3mxordermanager';
    protected $_sMenuSubItemTitle = 'd3mxordermanager_items';
    protected $_sThisTemplate = "d3_cfg_ordermanageritem_main.tpl";
    protected $_blUseOwnOxid = true;
    protected $_aNaviItems = [
        'new' => [
            'sScript' => 'top.oxid.admin.editThis( -1 );return false;',
            'sTranslationId' => 'D3_TOOLTIPS_NEWORDERMANAGER',
        ],
    ];
    protected $_sD3ObjectClass = Manager::class;

    /**
     * Loads article parameters and passes them to template engine, returns
     * name of template file "article_main.tpl".
     *
     * @return string
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function render(): string
    {
        $sRet = parent::render();

        /** @var Config $config */
        $config = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);

        $this->addTplParam("blUseTimeCheck", $config->getConfigParam('blUseTimeCheck'));

        return $sRet;
    }

    /**
     * Sets default values for empty article (currently does nothing), returns
     * array with parameters.
     *
     * @param array $aParams Parameters, to set default values
     *
     * @return array
     */
    public function addDefaultValues($aParams): array
    {
        $aParams = parent::addDefaultValues($aParams);

        /** @var Manager $oManager */
        $oManager = d3GetModCfgDIC()->get(Manager::class);
        $sFieldLongName = $oManager->d3GetFieldLongName('d3_cronjobid');

        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $aRequestParameter = $request->getRequestEscapedParameter("editval");

        if (is_array($aRequestParameter) && isset($aRequestParameter[$sFieldLongName])) {
            $aRequestParameter[$sFieldLongName] = $this->fixCronjobId($aRequestParameter[$sFieldLongName]);
            if (isset($_POST['editval'])) {
                $_POST['editval'] = $aRequestParameter;
            } elseif (isset($_GET['editval'])) {
                $_GET['editval'] = $aRequestParameter;
            }
        }

        return $aParams;
    }

    /**
     * @param $sId
     * @return mixed
     */
    public function fixCronjobId($sId)
    {
        $aSearch = [
            ' ',
        ];
        $sReplace = '_';

        return str_replace($aSearch, $sReplace, $sId);
    }
}
