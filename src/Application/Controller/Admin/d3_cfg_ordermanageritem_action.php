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
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actiongrouplist;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\ModCfg\Application\Model\Shopcompatibility\d3ShopCompatibilityAdapterHandler;
use Doctrine\DBAL\DBALException;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\ContentList;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Module\Module;
use OxidEsales\Eshop\Core\Module\ModuleList;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;

class d3_cfg_ordermanageritem_action extends d3_cfg_ordermanageritem_settings
{
    protected $_sThisTemplate = "d3_cfg_ordermanageritem_action.tpl";
    protected $_sMenuSubItemTitle = 'd3mxordermanager_items';
    protected $_sSavedId;
    protected $_sExportFieldDescMLIdent = 'D3_ORDERMANAGER_FIELDDESC';
    protected $_sExportFieldTitleBaseMLIdent = 'D3_ORDERMANAGER_FIELDTITLE_';
    protected $_sExportFieldLangMLIdent = 'D3_ORDERMANAGER_FIELDADD_LANG';

    /**
     * @return ListModel
     */
    public function getContentList()
    {
        /** @var $oContentList ContentList */
        $oContentList = oxNew(ContentList::class);
        return $this->_getObjectList($oContentList);
    }

    /**
     * @param $blAdmin
     * @return string
     */
    public function getManagerTemplateDirs($blAdmin)
    {
        return Registry::getConfig()->getTemplateDir($blAdmin);
    }

    /**
     * @return array
     */
    public function getItemFieldNames()
    {
        /** @var Order $oOrder */
        $oOrder = oxNew(Order::class);
        return $oOrder->getFieldNames();
    }


    /**
     * @return string
     */
    public function getExportExamplePath()
    {
        /** @var d3ordermanager $oProfile */
        $oProfile = oxNew($this->_sD3ObjectClass);
        $soxId    = Registry::get(Request::class)->getRequestEscapedParameter("oxid");

        if (isset( $soxId) && $soxId && $soxId != "-1") {
            // load object
            $oProfile->loadInLang($this->_iEditLang, $soxId);
            $oProfile = $this->_d3LoadInOtherLang($oProfile, $soxId);
        }

        $aSearch = array(date('Y-m-d_H-i-s', $oProfile->getStartTime()));
        $aReplace = array(Registry::getLang()->translateString('D3_ORDERMANAGER_ACTION_DATEPLACEHOLDER'));

        return str_replace($aSearch, $aReplace, $oProfile->getListExportFilePath());
    }

    /**
     * @param $sFieldName
     *
     * @return string
     */
    public function getFieldNameDescription($sFieldName)
    {
        if (($sFieldNameTitle = $this->getFieldNameTitle($sFieldName))) {
            return sprintf(
                Registry::getLang()->translateString($this->_sExportFieldDescMLIdent),
                $sFieldNameTitle,
                $sFieldName
            );
        } else {
            return $sFieldName;
        }
    }

    /**
     * @param $sFieldName
     *
     * @return null|string
     */
    public function getFieldNameTitle($sFieldName)
    {
        $sLangAdd = '';
        $sPattern = "@(.*)([_]{1}([0-9]{1,3}))$@";
        if (preg_match($sPattern, $sFieldName, $aMatches)) {
            $sFieldMLIdent = $this->_sExportFieldTitleBaseMLIdent.strtoupper($aMatches[1]);
            $aLangNames = Registry::getLang()->getLanguageNames();
            $sLangAdd  = sprintf(
                Registry::getLang()->translateString($this->_sExportFieldLangMLIdent),
                $aLangNames[$aMatches[3]]
            );
        } else {
            $sFieldMLIdent = $this->_sExportFieldTitleBaseMLIdent.strtoupper($sFieldName);
        }

        $sFieldName = Registry::getLang()->translateString($sFieldMLIdent);

        if ($sFieldName != $sFieldMLIdent) {
            return $sFieldName.$sLangAdd;
        } else {
            return null;
        }
    }

    /**
     * @return bool
     */
    public function canGeneratePdf()
    {
        /** @var d3ordermanager $oProfile */
        $oProfile = $this->getProfile();

        /** @var Order $oOrder */
        $oOrder = oxNew(Order::class);

        /** @var d3ordermanager_pdfhandler $oPDFHandler */
        $oPDFHandler = oxNew(d3ordermanager_pdfhandler::class, $oProfile, $oOrder);
        return $oPDFHandler->canGeneratePdf();
    }

    /**
     * @return array
     */
    public function getGroupedActionList()
    {
        /** @var d3ordermanager $oManager */
        $oManager = $this->getProfile();
        $oItem = oxNew(Order::class);

        /** @var d3ordermanager_actiongrouplist $oActionList */
        $oActionList = oxNew(d3ordermanager_actiongrouplist::class, $oManager, $oItem);
        $oActionList->setGroups($oManager->getConfiguration()->getGroupedActionIdList());

        return $oActionList->getGroupList();
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

    /**
     * @return array
     * @throws d3ShopCompatibilityAdapterException
     * @throws StandardException
     */
    public function getModulePathList()
    {
        $sModulesDir = Registry::getConfig()->getModulesDir();
        $aModulePathList = array();

        /** @var Module $oModule */
        $oModule = oxNew(Module::class);
        /** @var ModuleList $oModuleList */
        $oModuleList = oxNew(ModuleList::class);
        foreach (array_keys($oModuleList->getModulesFromDir($sModulesDir)) as $sId) {
            /** @var d3ShopCompatibilityAdapterHandler $oD3CompatibilityAdapterHandler */
            $oD3CompatibilityAdapterHandler = oxNew(d3ShopCompatibilityAdapterHandler::class);
            $sModulePath = $oD3CompatibilityAdapterHandler->call(
                'oxmodule__getModuleFullPath',
                array($oModule, $sId)
            );

            $aModulePathList[$sId] = $sModulePath;
        };

        return $aModulePathList;
    }

    /**
     * @throws StandardException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3ShopCompatibilityAdapterException
     */
    public function markAsFinished()
    {
        /** @var d3ordermanager $oProfile */
        $oProfile = $this->getProfile();
        $iCount = $oProfile->markConcernedItemsAsFinished();
        $this->_aMessages[] = sprintf(
            Registry::getLang()->translateString('D3_ORDERMANAGER_ACTION_MARKASFINISHED_MESSAGE'),
            $iCount
        );
    }
}
