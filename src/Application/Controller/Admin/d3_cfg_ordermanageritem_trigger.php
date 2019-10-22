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

namespace D3\Ordermanager\Application\Controller\Admin;

use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_main;
use D3\Ordermanager\Application\Model\d3ordermanager_conf;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Request;

class d3_cfg_ordermanageritem_trigger extends d3_cfg_mod_main
{
    protected $_sSavedId = null;
    protected $_sSetModId = 'd3_ordermanager';
    protected $_sModId = 'd3_ordermanager';
    protected $_sMenuItemTitle = 'd3mxordermanager';
    protected $_sMenuSubItemTitle = 'd3mxordermanager_items';
    protected $_sThisTemplate = "d3_cfg_ordermanageritem_trigger.tpl";
    protected $_blUseOwnOxid = true;
    protected $_aNaviItems = array(
        'new' => array(
            'sScript' => 'top.oxid.admin.editThis( -1 );return false;',
            'sTranslationId' => 'D3_TOOLTIPS_NEWORDERMANAGER',
        ),
    );
    protected $_sD3ObjectClass = d3ordermanager::class;

    /**
     * Sets default values for empty article (currently does nothing), returns
     * array with parameters.
     *
     * @param array $aParams Parameters, to set default values
     *
     * @return array
     * @throws Exception
     */
    public function addDefaultValues($aParams)
    {
        $aParams = parent::addDefaultValues($aParams);

        /** @var d3ordermanager $oOrderManager */
        $oOrderManager = d3GetModCfgDIC()->get(d3ordermanager::class);
        $sFieldLongName = $oOrderManager->d3GetFieldLongName('d3_cronjobid');

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
        $aSearch = array(
            ' ',
        );
        $sReplace = '_';

        return str_replace($aSearch, $sReplace, $sId);
    }

    /**
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function triggersAreAllowed()
    {
        return $this->d3GetSet()->isDemo() ||
            in_array(
                true,
                array_map(array($this->d3GetSet(),'getLicenseConfigData'),array(d3ordermanager_conf::SERIAL_BIT_STANDARD_EDITION))
            );
    }

    /**
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function scriptsAreAllowed()
    {
        return $this->d3GetSet()->isDemo() ||
            in_array(
                true,
                array_map(array($this->d3GetSet(),'getLicenseConfigData'),array(d3ordermanager_conf::SERIAL_BIT_PREMIUM_EDITION))
            );
    }
}
