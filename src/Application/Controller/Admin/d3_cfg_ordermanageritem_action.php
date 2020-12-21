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

namespace D3\Ordermanager\Application\Controller\Admin;

use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_action_abstract as ActionAbstract;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actiongrouplist as ActionGroupList;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actionlist as ActionList;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler as PdfHandler;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_vars as VariablesTrait;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Order as Item;
use OxidEsales\Eshop\Application\Model\ContentList;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ShopConfigurationDaoBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Path\ModulePathResolverInterface;
use OxidEsales\Eshop\Core\UtilsView;

class d3_cfg_ordermanageritem_action extends d3_cfg_ordermanageritem_settings
{
    use VariablesTrait;

    protected $_sThisTemplate = "d3_cfg_usermanageritem_action.tpl";
    protected $_sMenuSubItemTitle = 'd3mxusermanager_items';
    protected $_sSavedId;
    protected $_sExportFieldDescMLIdent = 'D3_ORDERMANAGER_FIELDDESC';
    protected $_sExportFieldTitleBaseMLIdent = 'D3_ORDERMANAGER_FIELDTITLE_';
    protected $_sExportFieldLangMLIdent = 'D3_ORDERMANAGER_FIELDADD_LANG';

    /**
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws Exception
     */
    public function save()
    {
        // @codeCoverageIgnoreStart
        if (!defined('OXID_PHP_UNIT')) {
            parent::save();
        }
        // @codeCoverageIgnoreEnd

        $aMissingRequiredValues = array();
        /** @var ActionAbstract $oAction */
        foreach ($this->getActionList() as $sId => $oAction) {
            if ($this->getProfile()->getValue($oAction->getActiveSwitchParameter()) && false == $oAction->hasRequiredValues()) {
                $aMissingRequiredValues[] = $sId;
            }
        }

        if (count($aMissingRequiredValues)) {
            $this->addTplParam('missingRequValuesActions', $aMissingRequiredValues);
        }
    }

    /**
     * @return ContentList|ListModel
     * @throws Exception
     */
    public function getContentList()
    {
        /** @var $oContentList ContentList */
        $oContentList = d3GetModCfgDIC()->get('d3ox.ordermanager.'.ContentList::class);
        return $this->_getObjectList($oContentList);
    }

    /**
     * @return Config
     * @throws Exception
     */
    public function d3GetConfig()
    {
        /** @var Config $config */
        $config = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);

        return $config;
    }

    /**
     * @param $blAdmin
     *
     * @return string
     * @throws Exception
     */
    public function getManagerTemplateDirs($blAdmin)
    {
        return $this->d3GetConfig()->getTemplateDir($blAdmin);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getItemFieldNames()
    {
        /** @var Item $item */
        $item = d3GetModCfgDIC()->get('d3ox.ordermanager.'. Item::class);
        return $item->getFieldNames();
    }

    /**
     * @return Manager
     * @throws Exception
     */
    public function getProfile()
    {
        /** @var Manager $oProfile */
        $oProfile = d3GetModCfgDIC()->get(Manager::class);

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
     * @throws Exception
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
     * @throws Exception
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
     * @throws Exception
     */
    public function getLang()
    {
        /** @var Language $language */
        $language = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);

        return $language;
    }

    /**
     * @param $sFieldName
     *
     * @return null|string
     * @throws Exception
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
     * @return PdfHandler
     * @throws Exception
     */
    public function getPdfHandler()
    {
        d3GetModCfgDIC()->set(
            PdfHandler::class.'.args.ordermanager',
            $this->getProfile()
        );
        d3GetModCfgDIC()->set(
            PdfHandler::class.'.args.order',
            d3GetModCfgDIC()->get('d3ox.ordermanager.'. Item::class)
        );

        /** @var PdfHandler $pdfhandler */
        $pdfhandler = d3GetModCfgDIC()->get(PdfHandler::class);

        return $pdfhandler;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function canGenerateOxidPdf()
    {
        return $this->getPdfHandler()->canGenerateOxidPdf();
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function canGeneratePdfDocuments()
    {
        return $this->getPdfHandler()->canGeneratePdfDocuments();
    }

    /**
     * @return ActionGroupList
     * @throws Exception
     */
    public function getActionGroupList()
    {
        d3GetModCfgDIC()->set(
            ActionGroupList::class.'.args.ordermanager',
            $this->getProfile()
        );
        d3GetModCfgDIC()->set(
            ActionGroupList::class.'.args.order',
            d3GetModCfgDIC()->get('d3ox.ordermanager.'. Item::class)
        );

        /** @var ActionGroupList $actiongroup */
        $actiongroup = d3GetModCfgDIC()->get(ActionGroupList::class);

        return $actiongroup;
    }

    /**
     * @return ActionList
     * @throws Exception
     */
    public function getActionListObject()
    {
        d3GetModCfgDIC()->set(
            ActionList::class.'.args.ordermanager',
            $this->getProfile()
        );
        d3GetModCfgDIC()->set(
            ActionList::class.'.args.order',
            d3GetModCfgDIC()->get('d3ox.ordermanager.'. Item::class)
        );

        /** @var ActionList $actionlist */
        $actionlist = d3GetModCfgDIC()->get(ActionList::class);
        return $actionlist;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getGroupedActionList()
    {
        $oManager = $this->getProfile();
        $oActionList = $this->getActionGroupList();
        $oActionList->setGroups($oManager->getConfiguration()->getGroupedActionIdList());

        return $oActionList->getGroupList();
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getActionList()
    {
        $oManager = $this->getProfile();
        $oActionList = $this->getActionListObject();
        $oActionList->setActions($oManager->getConfiguration()->getActionIdList());

        return $oActionList->getActionList();
    }

    /**
     * @param Manager $oProfile
     * @param               $soxId
     *
     * @return Manager
     */
    protected function _d3LoadInOtherLang(Manager $oProfile, $soxId)
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
     * @throws StandardException
     * @throws Exception
     * @throws d3ShopCompatibilityAdapterException
     */
    public function getModulePathList()
    {
        $aModulePathList = array();

        $container = ContainerFactory::getInstance()->getContainer();
        $shopConfiguration = $container->get(ShopConfigurationDaoBridgeInterface::class)->get();

        foreach ($shopConfiguration->getModuleConfigurations() as $moduleConfiguration) {
            $pathResolver = ContainerFactory::getInstance()->getContainer()->get(ModulePathResolverInterface::class);
            $sModulePath = $pathResolver->getFullModulePathFromConfiguration(
                $moduleConfiguration->getId(),
                Registry::getConfig()->getShopId()
            );

            $aModulePathList[$moduleConfiguration->getId()] = $sModulePath;
        }

        return $aModulePathList;
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws Exception
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function markAsFinished()
    {
        $oProfile = $this->getProfile();
        $iCount = $oProfile->markConcernedItemsAsFinished();

        $oEx = oxNew(
            StandardException::class,
            sprintf(
                Registry::getLang()->translateString('D3_ORDERMANAGER_ACTION_MARKASFINISHED_MESSAGE'),
                $iCount
            )
        );
        Registry::get(UtilsView::class)->addErrorToDisplay($oEx);
    }
}
