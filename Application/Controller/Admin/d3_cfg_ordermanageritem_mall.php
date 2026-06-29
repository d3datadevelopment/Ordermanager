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

namespace D3\Ordermanager\Application\Controller\Admin;

use D3\ModCfg\Application\Model\d3filesystem;
use D3\ModCfg\Application\Model\d3str;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Core\ModCfgTrait;
use OxidEsales\Eshop\Application\Controller\Admin\AdminMall;  // required for non fallback case
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Registry;

class d3_cfg_ordermanageritem_mall extends d3AdminMall
{
    use ModCfgTrait;

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
     * @codeCoverageIgnore
     */
    public function getProfile(): Manager
    {
        return oxNew($this->_sObjectClassName);
    }

    public function render(): string
    {
        $oProfile = $this->getProfile();
        $soxId = Registry::getRequest()->getRequestEscapedParameter("oxid");

        if ($this->_isSetOxid($soxId)) {
            // load object
            $oProfile->loadInLang($this->_iEditLang, $soxId);
            $oProfile = $this->_d3LoadInOtherLang($oProfile, $soxId);
        }

        $this->addTplParam('edit', $oProfile);

        return parent::render();
    }

    public function getUserMessages(): array
    {
        return [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getLang(): Language
    {
        return Registry::getLang();
    }

    public function getHelpURL(): string
    {
        $sUrl = $this->d3GetOrderManagerConfig()->getHelpURL();
        $oD3Str = $this->createD3Str();

        if ($this->_sHelpLinkMLAdd) {
            $sUrl .= $oD3Str->unprefixedslashit($this->getLang()->translateString($this->_sHelpLinkMLAdd));
        }

        $oFS = $this->created3Filesystem();
        $aFileName = $oFS->splitFilename($sUrl);

        // has no extension
        if (!$aFileName['ext']) {
            return $oD3Str->trailingslashit($sUrl);
        }

        return $sUrl;
    }

    /**
     * exampleItem:     array('new' => array(
     *                      'sScript' => 'top.oxid.admin.editThis( -1 );return false;',
     *                      'sTranslationId' => 'foo',
     *                  )
     */
    public function getNaviItems(): array
    {
        return $this->_aNaviItems;
    }

    public function d3GetMenuItemTitle(): string
    {
        return $this->_sMenuItemTitle;
    }

    public function d3GetMenuSubItemTitle(): string
    {
        return $this->_sMenuSubItemTitle;
    }

    /**
     * @param $soxId
     */
    protected function _isSetOxid($soxId): bool
    {
        return isset($soxId) && $soxId && $soxId != "-1";
    }

    /**
     * @param               $soxId
     *
     */
    protected function _d3LoadInOtherLang(Manager $oProfile, $soxId): Manager
    {
        // load object in other languages
        $oOtherLang = $oProfile->getAvailableInLangs();

        if (!isset($oOtherLang[$this->_iEditLang])) {
            $oProfile->loadInLang(key($oOtherLang), $soxId);
        }

        return $oProfile;
    }

    /**
     * @codeCoverageIgnore
     */
    public function createD3Str(): d3str
    {
        return oxNew(d3str::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function created3Filesystem(): d3filesystem
    {
        return oxNew(d3filesystem::class);
    }
}
