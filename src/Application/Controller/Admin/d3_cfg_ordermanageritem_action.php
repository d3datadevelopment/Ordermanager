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

use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_action_interface as ActionModelInterface;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actiongrouplist as ActionGroupList;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actionlist as ActionList;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler as PdfHandler;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_vars as VariablesTrait;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_actionException;
use D3\OxidServiceBridges\Internal\Framework\Module\Path\ModulePathResolverBridgeInterface;
use Doctrine\DBAL\DBALException;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\Order as Item;
use OxidEsales\Eshop\Application\Model\ContentList;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ShopConfigurationDaoBridgeInterface;
use OxidEsales\Eshop\Core\UtilsView;

class d3_cfg_ordermanageritem_action extends d3_cfg_ordermanageritem_settings
{
    use VariablesTrait;

    protected $_sThisTemplate = "d3_cfg_ordermanageritem_action.tpl";
    protected $_sMenuSubItemTitle = 'd3mxordermanager_items';
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
     */
    public function save()
    {
        // @codeCoverageIgnoreStart
        if (!defined('OXID_PHP_UNIT')) {
            parent::save();
        }
        // @codeCoverageIgnoreEnd

        $aMissingRequiredValues = [];
        /** @var ActionModelInterface $oAction */
        foreach ($this->getActionList() as $sId => $oAction) {
            if ($this->getProfile()->getValue($oAction->getActiveSwitchParameter())) {
                try {
                    $oAction->throwUnvalidConfigurationException();
                } catch (d3ordermanager_actionException $e) {
                    unset($e);
                    $aMissingRequiredValues[] = $sId;
                }
            }
        }

        if (count($aMissingRequiredValues)) {
            $this->addTplParam('missingRequValuesActions', $aMissingRequiredValues);
        }
    }

    /**
     * @return ContentList|ListModel
     */
    public function getContentList()
    {
        /** @var $oContentList ContentList */
        $oContentList = d3GetModCfgDIC()->get('d3ox.ordermanager.'.ContentList::class);
        return $this->_getObjectList($oContentList);
    }

    /**
     * @return Config
     */
    public function d3GetConfig(): Config
    {
        /** @var Config $config */
        $config = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);

        return $config;
    }

    /**
     * @param $blAdmin
     *
     * @return string
     */
    public function getManagerTemplateDirs($blAdmin): string
    {
        return $this->d3GetConfig()->getTemplateDir($blAdmin);
    }

    /**
     * @return array
     */
    public function getItemFieldNames(): array
    {
        /** @var Item $item */
        $item = d3GetModCfgDIC()->get('d3ox.ordermanager.'. Item::class);
        return $item->getFieldNames();
    }

    /**
     * @return Manager
     */
    public function getProfile(): Manager
    {
        /** @var Manager $oProfile */
        $oProfile = d3GetModCfgDIC()->get(Manager::class);

        $soxId = $this->getEditObjectId();

        if (isset($soxId) && $soxId && $soxId != "-1") {
            // load object
            $oProfile->loadInLang($this->_iEditLang, $soxId);

            // load object in other languages
            $oOtherLang = $oProfile->getAvailableInLangs();
            if (!isset($oOtherLang[$this->_iEditLang])) {
                $oProfile->loadInLang(key($oOtherLang), $soxId);
            }
        }

        return $oProfile;
    }

    /**
     * @return string
     */
    public function getExportExamplePath(): string
    {
        $oProfile = $this->getProfile();
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $soxId    = $request->getRequestEscapedParameter("oxid");

        if (isset($soxId) && $soxId && $soxId != "-1") {
            // load object
            $oProfile->loadInLang($this->_iEditLang, $soxId);
            $oProfile = $this->_d3LoadInOtherLang($oProfile, $soxId);
        }

        $aSearch = [date('Y-m-d_H-i-s', $oProfile->getStartTime())];
        /** @var Language $oLang */
        $oLang = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);
        $aReplace = [$oLang->translateString('D3_ORDERMANAGER_ACTION_DATEPLACEHOLDER')];

        return str_replace($aSearch, $aReplace, $oProfile->getListExportFilePath());
    }

    /**
     * @param $sFieldName
     *
     * @return string
     */
    public function getFieldNameDescription($sFieldName): string
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
     */
    public function getLang(): Language
    {
        /** @var Language $language */
        $language = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);

        return $language;
    }

    /**
     * @param $sFieldName
     *
     * @return null|string
     */
    public function getFieldNameTitle($sFieldName): ?string
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
     */
    public function getPdfHandler(): PdfHandler
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
     */
    public function canGenerateOxidPdf(): bool
    {
        return $this->getPdfHandler()->canGenerateOxidPdf();
    }

    /**
     * @return bool
     */
    public function canGeneratePdfDocuments(): bool
    {
        return $this->getPdfHandler()->canGeneratePdfDocuments();
    }

    /**
     * @return ActionGroupList
     */
    public function getActionGroupList(): ActionGroupList
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
     */
    public function getActionListObject(): ActionList
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
     */
    public function getGroupedActionList(): array
    {
        $oManager = $this->getProfile();
        $oActionList = $this->getActionGroupList();
        $oActionList->setGroups($oManager->getConfiguration()->getGroupedActionIdList());

        return $oActionList->getGroupList();
    }

    /**
     * @return array
     */
    public function getActionList(): array
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
     * @return array
     */
    public function getModulePathList(): array
    {
        $aModulePathList = [];

        $container = ContainerFactory::getInstance()->getContainer();
        $shopConfiguration = $container->get(ShopConfigurationDaoBridgeInterface::class)->get();

        foreach ($shopConfiguration->getModuleConfigurations() as $moduleConfiguration) {
            /** @var ModulePathResolverBridgeInterface $pathResolverBridge */
            $pathResolverBridge = ContainerFactory::getInstance()->getContainer()->get(ModulePathResolverBridgeInterface::class);
            $sModulePath = $pathResolverBridge->getFullModulePathFromConfiguration(
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
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function markAsFinished()
    {
        $oProfile = $this->getProfile();
        $iAllCount = d3GetModCfgDIC()->get('d3ox.ordermanager.'.DatabaseInterface::class.'.assoc')
            ->getOne('SELECT COUNT(*) FROM '.d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)->getViewName());
        $iCount = $oProfile->markConcernedItemsAsFinished(true);

        $oEx = oxNew(
            StandardException::class,
            sprintf(
                Registry::getLang()->translateString('D3_ORDERMANAGER_ACTION_MARKASFINISHED_MESSAGE'),
                $iCount,
                $iAllCount
            )
        );
        Registry::get(UtilsView::class)->addErrorToDisplay($oEx);
    }
}
