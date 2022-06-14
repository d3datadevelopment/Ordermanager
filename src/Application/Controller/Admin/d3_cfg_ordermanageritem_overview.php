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

declare(strict_types = 1);

namespace D3\Ordermanager\Application\Controller\Admin;

use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_main;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ParameterNotFoundException;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actionlist as ActionListModel;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_configurationcheck;
use D3\Ordermanager\Application\Model\d3ordermanager_vars as VariablesTrait;
use D3\Ordermanager\Application\Model\Exceptions\d3ActionRequirementInterface;
use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirementlist as RequirementListModel;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action as ItemActionController;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ as ItemRequirementController;
use Doctrine\DBAL\DBALException;
use OxidEsales\Eshop\Application\Model\Order as ItemModel;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\Eshop\Core\UtilsView;
use ReflectionException;

class d3_cfg_ordermanageritem_overview extends d3_cfg_mod_main
{
    use VariablesTrait;

    protected $_sSetModId = 'd3_ordermanager';
    protected $_sModId = 'd3_ordermanager';
    protected $_sThisTemplate = "d3_cfg_ordermanageritem_overview.tpl";
    protected $_sMenuItemTitle = 'd3mxordermanager';
    protected $_sMenuSubItemTitle = 'd3mxordermanager_items';
    protected $_blUseOwnOxid = true;
    protected $_aNaviItems = array(
        'new' => array(
            'sScript' => 'top.oxid.admin.editThis( -1 );return false;',
            'sTranslationId' => 'D3_TOOLTIPS_NEWORDERMANAGER',
        ),
    );
    protected $_sD3ObjectClass = Manager::class;
    protected $_sRequestData;

    /**
     * @return string
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws StandardException
     */
    public function render(): string
    {
        try {
            d3GetModCfgDIC()->set(
                d3ordermanager_configurationcheck::class.'.args.ordermanager',
                $this->getManager()
            );
            d3GetModCfgDIC()->setParameter(
                d3ordermanager_configurationcheck::class.'.args.checktypes',
                d3ordermanager_configurationcheck::REQUIREMENTS_AND_ACTIONS
            );
            /** @var d3ordermanager_configurationcheck $confCheck */
            $confCheck = d3GetModCfgDIC()->get(d3ordermanager_configurationcheck::class);
            $confCheck->checkThrowingExceptions();
        } catch (d3ActionRequirementInterface $e) {
            /** @var UtilsView $utilsView */
            $utilsView = d3GetModCfgDIC()->get('d3ox.ordermanager.'.UtilsView::class);
            $utilsView->addErrorToDisplay($e);
        }

        return parent::render();
    }

    /**
     * @return ItemActionController
     */
    public function getActionAdminController(): d3_cfg_ordermanageritem_action
    {
        /** @var ItemActionController $action */
        $action = d3GetModCfgDIC()->get(ItemActionController::class);
        return $action;
    }

    /**
     * @return ItemRequirementController
     */
    public function getRequirementAdminController(): d3_cfg_ordermanageritem_requ
    {
        /** @var ItemRequirementController $requ */
        $requ = d3GetModCfgDIC()->get(ItemRequirementController::class);
        return $requ;
    }

    /**
     * @param $method
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        $oActionView = $this->getActionAdminController();
        if (method_exists( $oActionView, $method)) {
            return call_user_func_array( array( $oActionView, $method), $arguments);
        }

        $oRequView = $this->getRequirementAdminController();
        if (method_exists( $oRequView, $method)) {
            return call_user_func_array( array( $oRequView, $method), $arguments);
        }

        return parent::__call( $method, $arguments);
    }

    /**
     * @param Manager $oManager
     * @return RequirementListModel
     */
    public function getRequirementListObject(Manager $oManager): RequirementListModel
    {
        d3GetModCfgDIC()->set(
            RequirementListModel::class.'.args.ordermanager',
            $oManager
        );

        /** @var RequirementListModel $requList */
        $requList = d3GetModCfgDIC()->get(RequirementListModel::class);
        return $requList;
    }

    /**
     * @return array
     */
    public function getRequirementList(): array
    {
        /** @var Manager $oManager */
        $oManager = $this->getProfile();
        $oRequList = $this->getRequirementListObject($oManager);
        $oRequList->setRequirements($oManager->getConfiguration()->getRequirementIdList());

        return $oRequList->getRequirementList();
    }

    /**
     * @param Manager $oManager
     * @return ActionListModel
     */
    public function getActionListObject(Manager $oManager): ActionListModel
    {
        d3GetModCfgDIC()->set(
            ActionListModel::class.'.args.ordermanager',
            $oManager
        );
        d3GetModCfgDIC()->set(
            ActionListModel::class.'.args.order',
            d3GetModCfgDIC()->get('d3ox.ordermanager.'.ItemModel::class)
        );

        /** @var ActionListModel $actionlist */
        $actionlist = d3GetModCfgDIC()->get(ActionListModel::class);
        return $actionlist;
    }

    /**
     * @return array
     */
    public function getActionList(): array
    {
        /** @var Manager $oManager */
        $oManager = $this->getProfile();
        $oActionList = $this->getActionListObject($oManager);
        $oActionList->setActions($oManager->getConfiguration()->getActionIdList());

        return $oActionList->getActionList();
    }

    /**
     * @return bool
     */
    public function isEditMode(): bool
    {
        return false;
    }

    public function setRequestData()
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $this->_sRequestData = $request->getRequestEscapedParameter('sRequestData');
    }

    /**
     * @return string
     */
    protected function _getRequestData(): string
    {
        return $this->_sRequestData;
    }

    /**
     * @return int
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3ParameterNotFoundException
     */
    public function getToFinishedCount(): int
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $requestCount = $request->getRequestEscapedParameter('toFinishedCount');

        if ($this->canRequestData(__FUNCTION__)) {
            /** @var Manager $oProfile */
            $oProfile = $this->getProfile();
            return (int) $oProfile->getListGenerator()->getConcernedItemCount();
        } elseif ($this->canUseRequestData($requestCount)) {
            return (int) $requestCount;
        }

        return 0;
    }

    /**
     * @return int
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws ReflectionException
     * @throws d3ParameterNotFoundException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function getFinishedCount(): int
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $requestCount = $request->getRequestEscapedParameter('finishedCount');

        if ($this->canRequestData(__FUNCTION__)) {
            /** @var Manager $oProfile */
            $oProfile = $this->getProfile();
            return $oProfile->getListGenerator()->getFinishedItemCount();
        } elseif ($this->canUseRequestData($requestCount)) {
            return (int) $requestCount;
        }

        return 0;
    }

    /**
     * @return int
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3ParameterNotFoundException
     */
    public function getFinishedMonthCount(): int
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $requestCount = $request->getRequestEscapedParameter('finishedMonthCount');

        if ($this->canRequestData(__FUNCTION__)) {
            /** @var Manager $oProfile */
            $oProfile = $this->getProfile();
            return (int) $oProfile->getListGenerator()->getFinishedMonthItemCount();
        } elseif ($this->canUseRequestData($requestCount)) {
            return (int) $requestCount;
        }

        return 0;
    }

    /**
     * @return int
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3ParameterNotFoundException
     */
    public function getNotFinishedCount(): int
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $requestCount = $request->getRequestEscapedParameter('notFinishedCount');

        if ($this->canRequestData(__FUNCTION__)) {
            /** @var Manager $oProfile */
            $oProfile = $this->getProfile();
            return (int) $oProfile->getListGenerator()->getNotFinishedItemCount();
        } elseif ($this->canUseRequestData($requestCount)) {
            return (int) $requestCount;
        }

        return 0;
    }

    /**
     * @param $sFunctionName
     *
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function canRequestData($sFunctionName): bool
    {
        return !$this->getDataOnDemand()
            || $this->_getRequestData() == $sFunctionName;
    }

    /**
     * @param $requestCount
     *
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function canUseRequestData($requestCount): bool
    {
        return $this->getDataOnDemand()
            && isset( $requestCount ) && false !== $requestCount;
    }

    /**
     * @return bool
     * @throws DatabaseConnectionException
     * @throws DBALException
     * @throws DatabaseErrorException
     */
    public function getDataOnDemand(): bool
    {
        return (bool) $this->d3GetSet()->getValue('blCalcStatOnDemand');
    }

    /**
     * @param $sRequestName
     * @param $sFunctionName
     *
     * @return bool
     */
    public function hasRequestedData($sRequestName, $sFunctionName): bool
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $iRequestCount = (string) $request->getRequestEscapedParameter($sRequestName);

        if ((bool) strlen($iRequestCount) || $this->_getRequestData() == $sFunctionName) {
            return true;
        }

        return false;
    }

    /**
     * @return Manager
     */
    public function getManager(): Manager
    {
        /** @var Manager $manager */
        $manager = d3GetModCfgDIC()->get(Manager::class);
        $manager->load($this->getEditObjectId());
        return $manager;
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
     * @param $sManagerId
     * @return string
     */
    public function getManagerTitle($sManagerId): string
    {
        $oManager = $this->getManager();
        if ($oManager->load($sManagerId)) {
            return $oManager->getFieldData('oxtitle');
        }

        return $this->getLang()->translateString('D3_ORDERMANAGER_REQU_OTHERJOB_UNKNOWNJOBID').' "'.$sManagerId.'"';
    }
}
