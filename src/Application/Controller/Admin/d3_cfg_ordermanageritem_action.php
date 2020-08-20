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
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_action_abstract;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actiongrouplist;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actionlist;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\ModCfg\Application\Model\Shopcompatibility\d3ShopCompatibilityAdapterHandler;
use Doctrine\DBAL\DBALException;
use Exception as ExceptionAlias;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\ContentList;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Module\Module;
use OxidEsales\Eshop\Core\Module\ModuleList;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\Request;

class d3_cfg_ordermanageritem_action extends d3_cfg_ordermanageritem_settings
{
    protected $_sThisTemplate = "d3_cfg_ordermanageritem_action.tpl";
    protected $_sMenuSubItemTitle = 'd3mxordermanager_items';
    protected $_sSavedId;
    protected $_sExportFieldDescMLIdent = 'D3_ORDERMANAGER_FIELDDESC';
    protected $_sExportFieldTitleBaseMLIdent = 'D3_ORDERMANAGER_FIELDTITLE_';
    protected $_sExportFieldLangMLIdent = 'D3_ORDERMANAGER_FIELDADD_LANG';

    public function save()
    {
        // @codeCoverageIgnoreStart
        if (!defined('OXID_PHP_UNIT')) {
            parent::save();
        }
        // @codeCoverageIgnoreEnd

        $aMissingRequiredValues = array();
        /** @var d3ordermanager_action_abstract $oAction */
        foreach ($this->getActionList() as $sId => $oAction) {
            if ($this->getProfile()->getValue($oAction->sActionActiveSwitch) && false == $oAction->hasRequiredValues()) {
                $aMissingRequiredValues[] = $sId;
            }
        };

        if (count($aMissingRequiredValues)) {
            $this->addTplParam('missingRequValuesActions', $aMissingRequiredValues);
        }
    }

    /**
     * @return ListModel
     * @throws ExceptionAlias
     */
    public function getContentList()
    {
        /** @var $oContentList ContentList */
        $oContentList = d3GetModCfgDIC()->get('d3ox.ordermanager.'.ContentList::class);
        return $this->_getObjectList($oContentList);
    }

    /**
     * @return Config
     * @throws ExceptionAlias
     */
    public function d3GetConfig()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);
    }

    /**
     * @param $blAdmin
     *
     * @return string
     * @throws ExceptionAlias
     */
    public function getManagerTemplateDirs($blAdmin)
    {
        return $this->d3GetConfig()->getTemplateDir($blAdmin);
    }

    /**
     * @return array
     * @throws ExceptionAlias
     */
    public function getItemFieldNames()
    {
        /** @var Order $oOrder */
        $oOrder = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);
        return $oOrder->getFieldNames();
    }

    /**
     * @return d3ordermanager
     * @throws ExceptionAlias
     */
    public function getProfile()
    {
        $oProfile = d3GetModCfgDIC()->get(d3ordermanager::class);

        $soxId = $this->getEditObjectId();

        if (isset($soxId) && $soxId && $soxId != "-1") {
            // load object
            $oProfile->loadInLang($this->_iEditLang, $soxId);

            // load object in other languages
            $oOtherLang = $oProfile->getAvailableInLangs();
            if (false == isset($oOtherLang[$this->_iEditLang])) {
                $oProfile->loadInLang(key($oOtherLang), $soxId);
            }
        }

        return $oProfile;
    }

    /**
     * @return string
     * @throws ExceptionAlias
     */
    public function getExportExamplePath()
    {
        $oProfile = $this->getProfile();
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $soxId    = $request->getRequestEscapedParameter("oxid");

        if (isset( $soxId) && $soxId && $soxId != "-1") {
            // load object
            $oProfile->loadInLang($this->_iEditLang, $soxId);
            $oProfile = $this->_d3LoadInOtherLang($oProfile, $soxId);
        }

        $aSearch = array(date('Y-m-d_H-i-s', $oProfile->getStartTime()));
        /** @var Language $oLang */
        $oLang = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);
        $aReplace = array($oLang->translateString('D3_ORDERMANAGER_ACTION_DATEPLACEHOLDER'));

        return str_replace($aSearch, $aReplace, $oProfile->getListExportFilePath());
    }

    /**
     * @param $sFieldName
     *
     * @return string
     * @throws ExceptionAlias
     */
    public function getFieldNameDescription($sFieldName)
    {
        if (($sFieldNameTitle = $this->getFieldNameTitle($sFieldName))) {
            return sprintf(
                $this->getLang()->translateString($this->_sExportFieldDescMLIdent),
                $sFieldNameTitle,
                $sFieldName
            );
        } else {
            return $sFieldName;
        }
    }

    /**
     * @return Language
     * @throws ExceptionAlias
     */
    public function getLang()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);
    }

    /**
     * @param $sFieldName
     *
     * @return null|string
     * @throws ExceptionAlias
     */
    public function getFieldNameTitle($sFieldName)
    {
        $sLangAdd = '';
        $sPattern = "@(.*)([_]{1}([0-9]{1,3}))$@";
        if (preg_match($sPattern, $sFieldName, $aMatches)) {
            $sFieldMLIdent = $this->_sExportFieldTitleBaseMLIdent.strtoupper($aMatches[1]);
            $aLangNames = $this->getLang()->getLanguageNames();
            $sLangAdd  = sprintf(
                $this->getLang()->translateString($this->_sExportFieldLangMLIdent),
                $aLangNames[$aMatches[3]]
            );
        } else {
            $sFieldMLIdent = $this->_sExportFieldTitleBaseMLIdent.strtoupper($sFieldName);
        }

        $sFieldName = $this->getLang()->translateString($sFieldMLIdent);

        if ($sFieldName != $sFieldMLIdent) {
            return $sFieldName.$sLangAdd;
        } else {
            return null;
        }
    }

    /**
     * @return d3ordermanager_pdfhandler
     * @throws ExceptionAlias
     */
    public function getPdfHandler()
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_pdfhandler::class.'.args.ordermanager',
            $this->getProfile()
        );
        d3GetModCfgDIC()->set(
            d3ordermanager_pdfhandler::class.'.args.order',
            d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)
        );

        return d3GetModCfgDIC()->get(d3ordermanager_pdfhandler::class);
    }

    /**
     * @return bool
     * @throws ExceptionAlias
     */
    public function canGenerateOxidPdf()
    {
        return $this->getPdfHandler()->canGenerateOxidPdf();
    }

    /**
     * @return bool
     * @throws ExceptionAlias
     */
    public function canGeneratePdfDocuments()
    {
        return $this->getPdfHandler()->canGeneratePdfDocuments();
    }

    /**
     * @return d3ordermanager_actiongrouplist
     * @throws ExceptionAlias
     */
    public function getActionGroupList()
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_actiongrouplist::class.'.args.ordermanager',
            $this->getProfile()
        );
        d3GetModCfgDIC()->set(
            d3ordermanager_actiongrouplist::class.'.args.order',
            d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)
        );

        return d3GetModCfgDIC()->get(d3ordermanager_actiongrouplist::class);
    }

    /**
     * @return d3ordermanager_actionlist
     * @throws ExceptionAlias
     */
    public function getActionListObject()
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_actionlist::class.'.args.ordermanager',
            $this->getProfile()
        );
        d3GetModCfgDIC()->set(
            d3ordermanager_actionlist::class.'.args.order',
            d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)
        );

        return d3GetModCfgDIC()->get(d3ordermanager_actionlist::class);
    }

    /**
     * @return array
     * @throws ExceptionAlias
     */
    public function getGroupedActionList()
    {
        /** @var d3ordermanager $oManager */
        $oManager = $this->getProfile();
        $oActionList = $this->getActionGroupList();
        $oActionList->setGroups($oManager->getConfiguration()->getGroupedActionIdList());

        return $oActionList->getGroupList();
    }

    /**
     * @return array
     * @throws ExceptionAlias
     */
    public function getActionList()
    {
        /** @var d3ordermanager $oManager */
        $oManager = $this->getProfile();
        $oActionList = $this->getActionListObject();
        $oActionList->setActions($oManager->getConfiguration()->getActionIdList());

        return $oActionList->getActionList();
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
     * @return ModuleList
     * @throws ExceptionAlias
     */
    public function getModuleList()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.ModuleList::class);
    }

    /**
     * @return d3ShopCompatibilityAdapterHandler
     * @throws ExceptionAlias
     */
    public function getShopCompatibilityAdapterHandler()
    {
        return d3GetModCfgDIC()->get(d3ShopCompatibilityAdapterHandler::class);
    }

    /**
     * @return array
     * @throws StandardException
     * @throws ExceptionAlias
     * @throws d3ShopCompatibilityAdapterException
     */
    public function getModulePathList()
    {
        /** @var Config $config */
        $config = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);

        $sModulesDir = $config->getModulesDir();
        $aModulePathList = array();

        /** @var Module $oModule */
        $oModule = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Module::class);
        /** @var ModuleList $oModuleList */
        $oModuleList = $this->getModuleList();

        foreach (array_keys($oModuleList->getModulesFromDir($sModulesDir)) as $sId) {
            /** @var d3ShopCompatibilityAdapterHandler $oD3CompatibilityAdapterHandler */
            $oD3CompatibilityAdapterHandler = $this->getShopCompatibilityAdapterHandler();
            $sModulePath = $oD3CompatibilityAdapterHandler->call(
                'oxmodule__getModuleFullPath',
                array($oModule, $sId)
            );

            $aModulePathList[$sId] = $sModulePath;
        };

        return $aModulePathList;
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws ExceptionAlias
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function markAsFinished()
    {
        /** @var d3ordermanager $oProfile */
        $oProfile = $this->getProfile();
        /** @var Language $oLang */
        $oLang = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);
        $iCount = $oProfile->markConcernedItemsAsFinished();
        $this->_aMessages[] = sprintf(
            $oLang->translateString('D3_ORDERMANAGER_ACTION_MARKASFINISHED_MESSAGE'),
            $iCount
        );
    }
}
