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

use D3\ModCfg\Application\Model\d3filesystem;
use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Exception\wrongModIdException;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\Ordermanager\Application\Model\d3ordermanager_vars as VariablesTrait;
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
        public function render(): string
        {
            parent::render();
            return $this->_blThisTemplate;
        }

        public function assignToSubshops()
        {
        }
    }
} else {
    class d3AdminMall extends AdminMall
    {
    }
}
// @codeCoverageIgnoreEnd

/**
 *
 */
class d3_cfg_ordermanageritem_mall extends d3AdminMall
{
    use VariablesTrait;

    private $_sModId = 'd3_ordermanager';
    /**
     * DB table having oxshopincl and oxshopexcl fields we are going to deal with
     */
    protected $_sMallTable = "d3modprofile";
    protected $_blUseOwnOxid = true;
    protected $_sMenuItemTitle = 'd3mxordermanager';
    protected $_sMenuSubItemTitle = 'd3tbclordermanager_items_mall';
    protected $_sHelpLinkMLAdd;
    protected $_aNaviItems = [
        'new' => [
            'sScript' => 'top.oxid.admin.editThis( -1 );return false;',
            'sTranslationId' => 'D3_TOOLTIPS_NEWORDERMANAGER',
        ],
    ];
    /**
     * Class name of object to load
     */
    protected $_sObjectClassName = Manager::class;

    /**
     * constructor.
     */
    public function __construct()
    {
        if (d3GetModCfgDIC()->getParameter($this->_DIC_Instance_Id . 'modcfgid') !== $this->_sModId) {
            throw oxNew(wrongModIdException::class, $this->_sModId);
        }

        parent::__construct();
    }

    /**
     * @return Manager
     */
    public function getProfile(): Manager
    {
        /** @var Manager $oManager */
        $oManager = d3GetModCfgDIC()->get($this->_sObjectClassName);
        return $oManager;
    }

    /**
     * @return string
     */
    public function render(): string
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
    public function getUserMessages(): array
    {
        return [];
    }

    /**
     * @return Language
     */
    public function getLang(): Language
    {
        /** @var Language $lang */
        $lang = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);

        return $lang;
    }

    /**
     * @return string
     */
    public function getHelpURL(): string
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
     * return type can't defined, because of unmockable d3_cfg_mod class, use stdClass in test
     * @return d3_cfg_mod
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
    public function getNaviItems(): array
    {
        return $this->_aNaviItems;
    }

    /**
     * @return string
     */
    public function d3GetMenuItemTitle(): string
    {
        return $this->_sMenuItemTitle;
    }

    /**
     * @return string
     */
    public function d3GetMenuSubItemTitle(): string
    {
        return $this->_sMenuSubItemTitle;
    }

    /**
     * @param $soxId
     *
     * @return bool
     */
    protected function _isSetOxid($soxId): bool
    {
        return isset($soxId) && $soxId && $soxId != "-1";
    }

    /**
     * @param Manager $oProfile
     * @param               $soxId
     *
     * @return Manager
     */
    protected function _d3LoadInOtherLang(Manager $oProfile, $soxId): Manager
    {
        // load object in other languages
        $oOtherLang = $oProfile->getAvailableInLangs();

        if (false == isset($oOtherLang[$this->_iEditLang])) {
            $oProfile->loadInLang(key($oOtherLang), $soxId);
        }

        return $oProfile;
    }
}
