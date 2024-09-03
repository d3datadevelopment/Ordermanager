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

use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_main;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ParameterNotFoundException;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actionlist as ActionListModel;
use D3\Ordermanager\Application\Model\Constants;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_configurationcheck;
use D3\Ordermanager\Application\Model\d3ordermanager_vars as VariablesTrait;
use D3\Ordermanager\Application\Model\Exceptions\d3ActionRequirementInterface;
use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirementlist as RequirementListModel;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_action as ItemActionController;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_requ as ItemRequirementController;
use Doctrine\DBAL\Exception as DBALException;
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

    protected $_sThisTemplate = '@'. Constants::OXID_MODULE_ID .'/admin/d3_cfg_ordermanageritem_overview';

    protected $_sMenuItemTitle = 'd3mxordermanager';

    protected $_sMenuSubItemTitle = 'd3mxordermanager_items';

    protected $_blUseOwnOxid = true;

    protected $_aNaviItems = [
        'new' => [
            'sScript' => 'top.oxid.admin.editThis( -1 );return false;',
            'sTranslationId' => 'D3_TOOLTIPS_NEWORDERMANAGER',
        ],
    ];

    protected $_sD3ObjectClass = Manager::class;

    protected $_sRequestData;

    /**
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
            d3GetOxidDIC()->set(
                d3ordermanager_configurationcheck::class.'.args.ordermanager',
                $this->getManager()
            );
            /** @var d3ordermanager_configurationcheck $confCheck */
            $confCheck = d3GetOxidDIC()->get(d3ordermanager_configurationcheck::class);
            $confCheck->checkThrowingExceptions(d3ordermanager_configurationcheck::REQUIREMENTS_AND_ACTIONS);
        } catch (d3ActionRequirementInterface $d3ActionRequirement) {
            /** @var UtilsView $utilsView */
            $utilsView = d3GetOxidDIC()->get('d3ox.ordermanager.'.UtilsView::class);
            $utilsView->addErrorToDisplay($d3ActionRequirement);
        }

        return parent::render();
    }

    public function getActionAdminController(): ItemActionController
    {
        /** @var ItemActionController $action */
        $action = d3GetOxidDIC()->get(ItemActionController::class);
        return $action;
    }

    public function getRequirementAdminController(): ItemRequirementController
    {
        /** @var ItemRequirementController $requ */
        $requ = d3GetOxidDIC()->get(ItemRequirementController::class);
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
        if (method_exists($oActionView, $method)) {
            return call_user_func_array([ $oActionView, $method], $arguments);
        }

        $oRequView = $this->getRequirementAdminController();
        if (method_exists($oRequView, $method)) {
            return call_user_func_array([ $oRequView, $method], $arguments);
        }

        return parent::__call($method, $arguments);
    }

    public function getRequirementListObject(Manager $oManager): RequirementListModel
    {
        d3GetOxidDIC()->set(
            RequirementListModel::class.'.args.ordermanager',
            $oManager
        );

        /** @var RequirementListModel $requList */
        $requList = d3GetOxidDIC()->get(RequirementListModel::class);
        return $requList;
    }

    public function getRequirementList(): array
    {
        /** @var Manager $oManager */
        $oManager = $this->getProfile();
        $oRequList = $this->getRequirementListObject($oManager);
        $oRequList->setRequirements($oManager->getConfiguration()->getRequirementIdList());

        return $oRequList->getRequirementList();
    }

    public function getActionListObject(Manager $oManager): ActionListModel
    {
        d3GetOxidDIC()->set(
            ActionListModel::class.'.args.ordermanager',
            $oManager
        );
        d3GetOxidDIC()->set(
            ActionListModel::class.'.args.order',
            d3GetOxidDIC()->get('d3ox.ordermanager.'.ItemModel::class)
        );

        /** @var ActionListModel $actionlist */
        $actionlist = d3GetOxidDIC()->get(ActionListModel::class);
        return $actionlist;
    }

    public function getActionList(): array
    {
        /** @var Manager $oManager */
        $oManager = $this->getProfile();
        $oActionList = $this->getActionListObject($oManager);
        $oActionList->setActions($oManager->getConfiguration()->getActionIdList());

        return $oActionList->getActionList();
    }

    public function isEditMode(): bool
    {
        return false;
    }

    public function setRequestData(): void
    {
        /** @var Request $request */
        $request = d3GetOxidDIC()->get('d3ox.ordermanager.'.Request::class);
        $this->_sRequestData = $request->getRequestEscapedParameter('sRequestData');
    }

    protected function _getRequestData(): string
    {
        return $this->_sRequestData;
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3ParameterNotFoundException
     */
    public function getToFinishedCount(): int
    {
        /** @var Request $request */
        $request = d3GetOxidDIC()->get('d3ox.ordermanager.'.Request::class);
        $requestCount = $request->getRequestEscapedParameter('toFinishedCount');
        if ($this->canRequestData(__FUNCTION__)) {
            /** @var Manager $oProfile */
            $oProfile = $this->getProfile();
            return $oProfile->getListGenerator()->getConcernedItemCount();
        }

        if ($this->canUseRequestData($requestCount)) {
            return (int) $requestCount;
        }

        return 0;
    }

    /**
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
        $request = d3GetOxidDIC()->get('d3ox.ordermanager.'.Request::class);
        $requestCount = $request->getRequestEscapedParameter('finishedCount');
        if ($this->canRequestData(__FUNCTION__)) {
            /** @var Manager $oProfile */
            $oProfile = $this->getProfile();
            return $oProfile->getListGenerator()->getFinishedItemCount();
        }

        if ($this->canUseRequestData($requestCount)) {
            return (int) $requestCount;
        }

        return 0;
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3ParameterNotFoundException
     */
    public function getFinishedMonthCount(): int
    {
        /** @var Request $request */
        $request = d3GetOxidDIC()->get('d3ox.ordermanager.'.Request::class);
        $requestCount = $request->getRequestEscapedParameter('finishedMonthCount');
        if ($this->canRequestData(__FUNCTION__)) {
            /** @var Manager $oProfile */
            $oProfile = $this->getProfile();
            return $oProfile->getListGenerator()->getFinishedMonthItemCount();
        }

        if ($this->canUseRequestData($requestCount)) {
            return (int) $requestCount;
        }

        return 0;
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3ParameterNotFoundException
     */
    public function getNotFinishedCount(): int
    {
        /** @var Request $request */
        $request = d3GetOxidDIC()->get('d3ox.ordermanager.'.Request::class);
        $requestCount = $request->getRequestEscapedParameter('notFinishedCount');
        if ($this->canRequestData(__FUNCTION__)) {
            /** @var Manager $oProfile */
            $oProfile = $this->getProfile();
            return $oProfile->getListGenerator()->getNotFinishedItemCount();
        }

        if ($this->canUseRequestData($requestCount)) {
            return (int) $requestCount;
        }

        return 0;
    }

    /**
     * @param $sFunctionName
     *
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function canRequestData($sFunctionName): bool
    {
        if (!$this->getDataOnDemand()) {
            return true;
        }

        return $this->_getRequestData() == $sFunctionName;
    }

    /**
     * @param $requestCount
     *
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function canUseRequestData($requestCount): bool
    {
        return $this->getDataOnDemand()
            && isset($requestCount) && false !== $requestCount;
    }

    /**
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
     */
    public function hasRequestedData($sRequestName, $sFunctionName): bool
    {
        /** @var Request $request */
        $request = d3GetOxidDIC()->get('d3ox.ordermanager.'.Request::class);
        $iRequestCount = (string) $request->getRequestEscapedParameter($sRequestName);
        return (bool) strlen($iRequestCount) || $this->_getRequestData() == $sFunctionName;
    }

    public function getManager(): Manager
    {
        /** @var Manager $manager */
        $manager = d3GetOxidDIC()->get(Manager::class);
        $manager->load($this->getEditObjectId());
        return $manager;
    }

    public function getLang(): Language
    {
        /** @var Language $lang */
        $lang = d3GetOxidDIC()->get('d3ox.ordermanager.'.Language::class);

        return $lang;
    }

    /**
     * @param $sManagerId
     */
    public function getManagerTitle(string $sManagerId): string
    {
        $oManager = $this->getManager();
        if ($oManager->load($sManagerId)) {
            return $oManager->getFieldData('oxtitle');
        }

        return $this->getLang()->translateString('D3_ORDERMANAGER_REQU_OTHERJOB_UNKNOWNJOBID').' "'.$sManagerId.'"';
    }
}
