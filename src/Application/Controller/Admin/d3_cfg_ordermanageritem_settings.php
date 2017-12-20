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
 * @copyright © D³ Data Development, Thomas Dartsch
 * @author    D³ Data Development - Daniel Seifert <support@shopmodule.com>
 * @link      http://www.oxidmodule.com
 */

namespace D3\Ordermanager\Application\Controller\Admin;

use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_main;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\Model\MultiLanguageModel;
use OxidEsales\Eshop\Core\Registry;

class d3_cfg_ordermanageritem_settings extends d3_cfg_mod_main
{
    protected $_sSetModId = 'd3_ordermanager';
    protected $_sMenuItemTitle = 'd3mxordermanager';
    protected $_blUseOwnOxid = true;
    protected $_aNaviItems = array(
        'new' => array(
            'sScript' => 'top.oxid.admin.editThis( -1 );return false;',
            'sTranslationId' => 'D3_TOOLTIPS_NEWORDERMANAGER',
        ),
    );
    protected $_sD3ObjectClass = d3ordermanager::class;

    /**
     * @return array
     */
    public function getItemFolders()
    {
        return Registry::getConfig()->getConfigParam('aOrderfolder');
    }

    /**
     * @return ListModel
     */
    public function getGroupsList()
    {
        /** @var $oGroupsList ListModel */
        $oGroupsList = oxNew(ListModel::class);
        $oGroupsList->init('oxgroups');
        return $this->_getObjectList($oGroupsList);
    }

    /**
     * @param ListModel $oObjectList
     *
     * @return ListModel
     */
    protected function _getObjectList($oObjectList)
    {
        startProfile(__METHOD__);

        /** @var $oObject MultiLanguageModel */
        $oObject = $oObjectList->getBaseObject();
        if ($oObject->isMultilang()) {
            $oObject->setLanguage(Registry::getLang()->getTplLanguage());
        }
        $sFieldList = $oObject->getSelectFields();
        $sQ = "select {$sFieldList} from {$oObject->getViewName()}";
        $oObjectList->selectString($sQ);

        stopProfile(__METHOD__);

        return $oObjectList;
    }

    /**
     * @return bool
     */
    public function isEditMode()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getRestrictionMessage()
    {
        return sprintf(
            Registry::getLang()->translateString('D3_ORDERMANAGER_ERROR_RESTRICTIONS'),
            d3_cfg_mod::get($this->_sSetModId)->getLicenseConfigData('sEditionId', 'unknown')
        );
    }
}
