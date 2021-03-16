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

use D3\ModCfg\Application\Model\d3filesystem;
use D3\ModCfg\Application\Model\d3str;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use Exception;
use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use OxidEsales\Eshop\Application\Controller\Admin\AdminMall;  // required for non fallback case
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Request;

// @codeCoverageIgnoreStart
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
// @codeCoverageIgnoreEnd

/**
 *
 */
class d3_cfg_ordermanageritem_mall extends d3AdminMall
{
    private $_sModId = 'd3_ordermanager';
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
     * d3_cfg_ordermanageritem_mall constructor.
     */
    public function __construct()
    {
        d3GetModCfgDIC()->setParameter('d3.ordermanager.modcfgid', $this->_sModId);

        parent::__construct();
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getProfile()
    {
        /** @var d3ordermanager $oManager */
        $oManager = d3GetModCfgDIC()->get($this->_sObjectClassName);
        return $oManager;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function render()
    {
        $oProfile = $this->getProfile();
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $soxId = $request->getRequestEscapedParameter("oxid");

        if ($this->_isSetOxid($soxId)) {
            // load object
            $oProfile->loadInLang($this->_iEditLang, $soxId);
            $oProfile = $this->_d3LoadInOtherLang($oProfile, $soxId);
        }

        $this->addTplParam('edit', $oProfile);

        return parent::render();
    }

    /**
     * @return array
     */
    public function getUserMessages()
    {
        return array();
    }

    /**
     * @return Language
     * @throws Exception
     */
    public function getLang()
    {
        /** @var Language $lang */
        $lang = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);

        return $lang;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getHelpURL()
    {
        $sUrl = $this->d3GetSet()->getHelpURL();
        /** @var d3str $oD3Str */
        $oD3Str = d3GetModCfgDIC()->get(d3str::class);

        if ($this->_sHelpLinkMLAdd) {
            $sUrl .= $oD3Str->unprefixedslashit($this->getLang()->translateString($this->_sHelpLinkMLAdd));
        }

        $oFS = d3GetModCfgDIC()->get(d3filesystem::class);
        $aFileName = $oFS->splitFilename($sUrl);

        // has no extension
        if (false == $aFileName['ext']) {
            $sUrl = $oD3Str->trailingslashit($sUrl);
        }

        return $sUrl;
    }

    /**
     * @return d3_cfg_mod
     * @throws Exception
     */
    public function d3GetSet()
    {
        /** @var d3_cfg_mod $modcfg */
        $modcfg = d3GetModCfgDIC()->get('d3.ordermanager.modcfg');

        return $modcfg;
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
