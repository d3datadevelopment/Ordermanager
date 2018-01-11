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

use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\d3filesystem;
use Doctrine\DBAL\DBALException;
use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use OxidEsales\Eshop\Application\Controller\Admin\AdminMall;  // required for non fallback case
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;

// fallback for non ee editions
if (false == class_exists("\OxidEsales\Eshop\Application\Controller\Admin\AdminMall")) {
    class d3AdminMall extends AdminDetailsController
    {
        protected $_blThisTemplate = "d3_cfg_ordermanageritem_mall.tpl";

        /**
         * @return string
         */
        public function render()
        {
            parent::render();
            return $this->_blThisTemplate;
        }

        public function assignToSubshops()
        {
        }
    }
} else {
    class d3AdminMall extends AdminMall {}
}

/**
 *
 */
class d3_cfg_ordermanageritem_mall extends d3AdminMall
{
    /**
     * DB table having oxshopincl and oxshopexcl fields we are going to deal with
     */
    protected $_sMallTable = "d3modprofile";
    protected $_blUseOwnOxid = true;
    protected $_sMenuItemTitle = 'd3mxordermanager';
    protected $_sMenuSubItemTitle = 'd3tbclordermanager_items_mall';
    protected $_sUpdateAddSql;
    protected $_sHelpLinkMLAdd;
    protected $_aNaviItems = array(
        'new' => array(
            'sScript' => 'top.oxid.admin.editThis( -1 );return false;',
            'sTranslationId' => 'D3_TOOLTIPS_NEWORDERMANAGER',
        ),
    );
    /**
     * Class name of object to load
     */
    protected $_sObjectClassName = d3ordermanager::class;

    /**
     * @return string
     */
    public function render()
    {
        /** @var d3ordermanager $oProfile */
        $oProfile = oxNew($this->_sObjectClassName);
        $soxId = Registry::get(Request::class)->getRequestEscapedParameter("oxid");

        if ($this->_isSetOxid($soxId)) {
            // load object
            $oProfile->loadInLang($this->_iEditLang, $soxId);
            $oProfile = $this->_d3LoadInOtherLang($oProfile, $soxId);
        }

        $this->addTplParam('edit', $oProfile);

        return parent::render();
    }

    /**
     * Assigns record information in multiple shop field
     */
    public function assignToSubshops()
    {
        $sOXID = $this->getEditObjectId();
        $this->_sUpdateAddSql = " ";

        parent::assignToSubshops();

        //reseting oxfield2shop values
        $oShop = $this->_getEditShop($sOXID);

        // bc for OXID 5.0 + 5.1
        if (method_exists($oShop, 'cleanMultishopFields')) {
            $oShop->cleanMultishopFields($sOXID);
        }
    }

    /**
     * @return array
     */
    public function getUserMessages()
    {
        return array();
    }

    /**
     * @return string
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getHelpURL()
    {
        $sUrl = $this->d3GetSet()->getHelpURL();
        /** @var $oFS d3filesystem */
        $oFS = oxNew(d3filesystem::class);

        if ($this->_sHelpLinkMLAdd) {
            $sUrl .= $oFS->unprefixedslashit(Registry::getLang()->TranslateString($this->_sHelpLinkMLAdd));
        }

        $aFileName = $oFS->splitFilename($sUrl);

        // has no extension
        if (false == $aFileName['ext']) {
            $sUrl = $oFS->trailingslashit($sUrl);
        }

        return $sUrl;
    }

    /**
     * @return d3_cfg_mod
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function d3GetSet()
    {
        return d3_cfg_mod::get('d3_ordermanager');
    }

    /**
     * exampleItem:     array('new' => array(
     *                      'sScript' => 'top.oxid.admin.editThis( -1 );return false;',
     *                      'sTranslationId' => 'foo',
     *                  )
     * @return array
     */
    public function getNaviItems()
    {
        return $this->_aNaviItems;
    }

    /**
     * @return string
     */
    public function d3GetMenuItemTitle()
    {
        return $this->_sMenuItemTitle;
    }

    /**
     * @return string
     */
    public function d3GetMenuSubItemTitle()
    {
        return $this->_sMenuSubItemTitle;
    }

    /**
     * @param $soxId
     *
     * @return bool
     */
    protected function _isSetOxid($soxId)
    {
        return isset($soxId) && $soxId && $soxId != "-1";
    }

    /**
     * @param d3ordermanager $oProfile
     * @param               $soxId
     *
     * @return d3ordermanager
     */
    protected function _d3LoadInOtherLang(d3ordermanager $oProfile, $soxId)
    {
        // load object in other languages
        $oOtherLang = $oProfile->getAvailableInLangs();
        if (false == isset($oOtherLang[$this->_iEditLang])) {
            $oProfile->loadInLang(key($oOtherLang), $soxId);
        }

        return $oProfile;
    }
}
