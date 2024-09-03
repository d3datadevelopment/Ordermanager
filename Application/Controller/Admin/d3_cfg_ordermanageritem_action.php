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

use D3\DIContainerHandler\d3DicException;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ParameterNotFoundException;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_action_interface as ActionModelInterface;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actiongrouplist as ActionGroupList;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actionlist as ActionList;
use D3\Ordermanager\Application\Model\Constants;
use D3\Ordermanager\Application\Model\d3ordermanager_pdfhandler as PdfHandler;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_vars as VariablesTrait;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_actionException;
use DateTime;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Driver\Exception as DBALDriverException;
use Doctrine\DBAL\Query\QueryBuilder;
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
use OxidEsales\Eshop\Core\UtilsView;

class d3_cfg_ordermanageritem_action extends d3_cfg_ordermanageritem_settings
{
    use VariablesTrait;

    protected $_sThisTemplate = '@'. Constants::OXID_MODULE_ID .'/admin/d3_cfg_ordermanageritem_action';

    protected $_sMenuSubItemTitle = 'd3mxordermanager_items';

    protected $_sSavedId;

    protected string $_sExportFieldDescMLIdent = 'D3_ORDERMANAGER_FIELDDESC';

    protected string $_sExportFieldTitleBaseMLIdent = 'D3_ORDERMANAGER_FIELDTITLE_';

    protected string $_sExportFieldLangMLIdent = 'D3_ORDERMANAGER_FIELDADD_LANG';

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3DicException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function save(): void
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

        if ($aMissingRequiredValues !== []) {
            $this->addTplParam('missingRequValuesActions', $aMissingRequiredValues);
        }
    }

    /**
     * @throws d3DicException
     */
    public function getContentList(): ListModel
    {
        /** @var $oContentList ContentList */
        $oContentList = d3GetOxidDIC()->get('d3ox.ordermanager.'.ContentList::class);
        return $this->_getObjectList($oContentList);
    }

    /**
     * @throws d3DicException
     */
    public function d3GetConfig(): Config
    {
        /** @var Config $config */
        $config = d3GetOxidDIC()->get('d3ox.ordermanager.'.Config::class);

        return $config;
    }

    /**
     * @throws d3DicException
     */
    public function getItemFieldNames(): array
    {
        /** @var Item $item */
        $item = d3GetOxidDIC()->get('d3ox.ordermanager.'. Item::class);
        return $item->getFieldNames();
    }

    /**
     * @throws d3DicException
     */
    public function getProfile(): Manager
    {
        /** @var Manager $oProfile */
        $oProfile = d3GetOxidDIC()->get(Manager::class);

        $soxId = $this->getEditObjectId();

        if ($soxId != "-1") {
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
     * @throws d3DicException
     */
    public function getExportExamplePath(): string
    {
        $oProfile = $this->getProfile();
        /** @var Request $request */
        $request = d3GetOxidDIC()->get('d3ox.ordermanager.'.Request::class);
        $soxId    = $request->getRequestEscapedParameter("oxid");

        if (isset($soxId) && $soxId && $soxId != "-1") {
            // load object
            $oProfile->loadInLang($this->_iEditLang, $soxId);
            $oProfile = $this->_d3LoadInOtherLang($oProfile, $soxId);
        }

        $aSearch = [(new DateTime())->setTimestamp($oProfile->getStartTime())->format('Y-m-d_H-i-s')];
        /** @var Language $oLang */
        $oLang = d3GetOxidDIC()->get('d3ox.ordermanager.'.Language::class);
        $aReplace = [$oLang->translateString('D3_ORDERMANAGER_ACTION_DATEPLACEHOLDER')];

        return str_replace($aSearch, $aReplace, $oProfile->getListExportFilePath());
    }

    /**
     * @param $sFieldName
     * @throws d3DicException
     */
    public function getFieldNameDescription($sFieldName): string
    {
        if (($sFieldNameTitle = $this->getFieldNameTitle($sFieldName))) {
            return sprintf(
                $this->getLang()->translateString($this->_sExportFieldDescMLIdent),
                $sFieldNameTitle,
                $sFieldName
            );
        }

        return $sFieldName;
    }

    /**
     * @throws d3DicException
     */
    public function getLang(): Language
    {
        /** @var Language $language */
        $language = d3GetOxidDIC()->get('d3ox.ordermanager.'.Language::class);

        return $language;
    }

    /**
     * @param $sFieldName
     * @throws d3DicException
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
        }

        return null;
    }

    /**
     * @throws d3DicException
     */
    public function getPdfHandler(): PdfHandler
    {
        d3GetOxidDIC()->set(
            PdfHandler::class.'.args.ordermanager',
            $this->getProfile()
        );
        d3GetOxidDIC()->set(
            PdfHandler::class.'.args.order',
            d3GetOxidDIC()->get('d3ox.ordermanager.'. Item::class)
        );

        /** @var PdfHandler $pdfhandler */
        $pdfhandler = d3GetOxidDIC()->get(PdfHandler::class);

        return $pdfhandler;
    }

    /**
     * @throws d3DicException
     */
    public function canGenerateOxidPdf(): bool
    {
        return $this->getPdfHandler()->canGenerateOxidPdf();
    }

    /**
     * @throws d3DicException
     */
    public function canGeneratePdfDocuments(): bool
    {
        return $this->getPdfHandler()->canGeneratePdfDocuments();
    }

    /**
     * @throws d3DicException
     */
    public function getActionGroupList(): ActionGroupList
    {
        d3GetOxidDIC()->set(
            ActionGroupList::class.'.args.ordermanager',
            $this->getProfile()
        );
        d3GetOxidDIC()->set(
            ActionGroupList::class.'.args.order',
            d3GetOxidDIC()->get('d3ox.ordermanager.'. Item::class)
        );

        /** @var ActionGroupList $actiongroup */
        $actiongroup = d3GetOxidDIC()->get(ActionGroupList::class);

        return $actiongroup;
    }

    /**
     * @throws d3DicException
     */
    public function getActionListObject(): ActionList
    {
        d3GetOxidDIC()->set(
            ActionList::class.'.args.ordermanager',
            $this->getProfile()
        );
        d3GetOxidDIC()->set(
            ActionList::class.'.args.order',
            d3GetOxidDIC()->get('d3ox.ordermanager.'. Item::class)
        );

        /** @var ActionList $actionlist */
        $actionlist = d3GetOxidDIC()->get(ActionList::class);
        return $actionlist;
    }

    /**
     * @throws d3DicException
     */
    public function getGroupedActionList(): array
    {
        $oManager = $this->getProfile();
        $oActionList = $this->getActionGroupList();
        $oActionList->setGroups($oManager->getConfiguration()->getGroupedActionIdList());

        return $oActionList->getGroupList();
    }

    /**
     * @throws d3DicException
     */
    public function getActionList(): array
    {
        $oManager = $this->getProfile();
        $oActionList = $this->getActionListObject();
        $oActionList->setActions($oManager->getConfiguration()->getActionIdList());

        return $oActionList->getActionList();
    }

    protected function _d3LoadInOtherLang(Manager $oProfile, string $soxId): Manager
    {
        // load object in other languages
        $oOtherLang = $oProfile->getAvailableInLangs();
        if (!isset($oOtherLang[$this->_iEditLang])) {
            $oProfile->loadInLang(key($oOtherLang), $soxId);
        }

        return $oProfile;
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws DBALDriverException
     * @throws StandardException
     * @throws d3DicException
     * @throws d3ParameterNotFoundException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function markAsFinished(): void
    {
        $oProfile = $this->getProfile();
        /** @var QueryBuilder $qb */
        $qb = d3GetOxidDIC()->get('d3ox.modcfg.OxDbQueryBuilder');
        $qb->select('count(*)')
            ->from(d3GetOxidDIC()->get('d3ox.ordermanager.'.Item::class)->getViewName());
        $iAllCount = (int) $qb->execute()->fetchOne();
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
