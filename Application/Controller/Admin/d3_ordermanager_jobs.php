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

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\d3filesystem;
use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ParameterNotFoundException;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Model\Exception\wrongModIdException;
use D3\ModCfg\Application\Model\Log\d3log;
use D3\Ordermanager\Application\Model\Constants;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_configurationcheck;
use D3\Ordermanager\Application\Model\d3ordermanager_execute as ManagerExecuteModel;
use D3\Ordermanager\Application\Model\d3ordermanager_toorderassignment as ToItemAssignmentModel;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\d3ordermanagerlist as ManagerListModel;
use D3\Ordermanager\Application\Model\d3ordermanager_vars as VariablesTrait;
use D3\Ordermanager\Application\Model\Exceptions\d3ActionRequirementInterface;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_templaterendererExceptionInterface;
use Doctrine\DBAL\Exception as DBALException;
use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use OxidEsales\Eshop\Application\Model\Order as ItemModel;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Model\BaseModel;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\Eshop\Core\Session;
use OxidEsales\Eshop\Core\UtilsView;
use OxidEsales\Twig\Resolver\TemplateChain\TemplateType\NonTemplateFilenameException;

class d3_ordermanager_jobs extends AdminDetailsController
{
    use VariablesTrait;

    private string $_sModId = 'd3_ordermanager';

    /** @var ManagerListModel */
    protected $_aJobList;

    protected $_sHelpLinkMLAdd;

    public $_sThisTemplate = '@' . Constants::OXID_MODULE_ID . '/admin/d3_ordermanager_jobs';

    /**
     * constructor.
     */
    public function __construct()
    {
        // prevent the use of the global currency setting instead of the order setting
        unset($_GET['cur']);

        d3GetOxidDIC()->getParameter($this->_DIC_Instance_Id . 'modcfgid') === $this->_sModId or
            throw oxNew(wrongModIdException::class, $this->_sModId);

        parent::__construct();
    }

    public function getItemObject(): ItemModel
    {
        /** @var ItemModel $item */
        $item = d3GetOxidDIC()->get('d3ox.ordermanager.'.ItemModel::class);

        return $item;
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function render(): string
    {
        $tpl = parent::render();

        $soxId = $this->getEditObjectId();
        $this->addTplParam("oxid", $soxId);

        if ($soxId != "-1") {
            $oItem = $this->getItemObject();
            $oItem->load($soxId);
            $this->addTplParam("edit", $oItem);
        }

        /** @var Session $session */
        $session = d3GetOxidDIC()->get($this->_DIC_OxInstance_Id.Session::class);

        $sJobFolder = $session->getVariable('d3FolderSelect');
        $this->addTplParam("jobfolder", $sJobFolder);
        $this->_aJobList = $this->_d3GetManuallyManagerJobs($sJobFolder);

        return $tpl;
    }

    public function d3GetSession(): Session
    {
        /** @var Session $session */
        $session = d3GetOxidDIC()->get('d3ox.ordermanager.'.Session::class);

        return $session;
    }

    public function changeFolder(): void
    {
        /** @var Request $request */
        $request = d3GetOxidDIC()->get($this->_DIC_OxInstance_Id.Request::class);

        $this->d3GetSession()->setVariable(
            'd3FolderSelect',
            $request->getRequestEscapedParameter('jobfolder')
        );
    }

    public function getManagerList(): ManagerListModel
    {
        /** @var ManagerListModel $managerList */
        $managerList = d3GetOxidDIC()->get(ManagerListModel::class);
        return $managerList;
    }

    public function d3GetManagerJobs(): ManagerListModel
    {
        $oManagerList = $this->getManagerList();
        $oManagerList->getList();

        return $oManagerList;
    }

    /**
     * @param $sFolderId
     *
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    protected function _d3GetManuallyManagerJobs($sFolderId): ManagerListModel
    {
        try {
            $oManagerList = $this->getManagerList();
            $oList = $oManagerList->d3GetManuallyManagerJobsByFolder($sFolderId);

            /** @var Manager $oManager */
            foreach ($oList as $sId => $oManager) {
                $oManagerExecute = $this->getManagerExecute($oManager);
                if (!$oManager->getValue('sManuallyExecMeetCondition')) {
                    continue;
                }

                if (false != $oManagerExecute->orderMeetsConditions($this->getEditObjectId())) {
                    continue;
                }

                $oList->offsetUnset($sId);
            }

            return $oList;
        } catch (d3ActionRequirementInterface $d3ActionRequirement) {
            /** @var UtilsView $utilsView */
            $utilsView = d3GetOxidDIC()->get('d3ox.ordermanager.'.UtilsView::class);
            $utilsView->addErrorToDisplay($d3ActionRequirement);
        }

        /** @var d3ordermanagerlist $managerList */
        $managerList = d3GetOxidDIC()->get(ManagerListModel::class);
        return $managerList;
    }

    public function d3GetJobList(): array
    {
        return $this->_aJobList->getArray();
    }

    public function getManager(): Manager
    {
        /** @var Manager $manager */
        $manager = d3GetOxidDIC()->get(Manager::class);
        return $manager;
    }

    public function getManagerExecute(Manager $oManager): ManagerExecuteModel
    {
        d3GetOxidDIC()->set(
            ManagerExecuteModel::class.'.args.ordermanager',
            $oManager
        );

        /** @var ManagerExecuteModel $managerExecute */
        $managerExecute = d3GetOxidDIC()->get(ManagerExecuteModel::class);
        return $managerExecute;
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function d3execordermanager(): void
    {
        try {
            /** @var Request $request */
            $request = d3GetOxidDIC()->get($this->_DIC_OxInstance_Id . Request::class);

            $oManager = $this->getManager();
            $oManager->load($request->getRequestEscapedParameter('ordermanagerid'));
            $oManagerExec = $this->getManagerExecute($oManager);

            $this->checkForConfigurationException($oManager);

            if (false == $oManager->getValue('sManuallyExecMeetCondition') ||
                $oManagerExec->orderMeetsConditions($this->getEditObjectId())
            ) {
                $oManagerExec->exec4order($this->getEditObjectId());
                $oManagerExec->finishJobExecution();
            }
        } catch (d3ActionRequirementInterface | d3ordermanager_templaterendererExceptionInterface $oEx) {
            // @codeCoverageIgnoreStart
            if (!defined('OXID_PHP_UNIT')) {
                $logger = Registry::getLogger();
                $logger->error($oEx);
            }

            // @codeCoverageIgnoreEnd

            d3GetOxidDIC()->get('d3.ordermanager.log')->alert(
                self::class,
                __FUNCTION__,
                __LINE__,
                "execution error",
                $oEx->getMessage()
            );

            /** @var UtilsView $utilsView */
            $utilsView = d3GetOxidDIC()->get('d3ox.ordermanager.'.UtilsView::class);
            $utilsView->addErrorToDisplay($oEx);
        } finally {
            $oConfig = d3GetOxidDIC()->get('d3ox.ordermanager.'.Config::class);
            $oConfig->setAdminMode(true);
        }
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function d3ExecChangedOrderManager(): void
    {
        try {
            /** @var Request $request */
            $request = d3GetOxidDIC()->get($this->_DIC_OxInstance_Id.Request::class);

            $oManager = $this->getManager();
            $oManager->load($request->getRequestEscapedParameter('ordermanagerid'));
            $oManager->setEditedValues($request->getRequestEscapedParameter('aContent'));
            $oManagerExec = $this->getManagerExecute($oManager);

            $this->checkForConfigurationException($oManager);

            if (false == $oManager->getValue('sManuallyExecMeetCondition') ||
                $oManagerExec->orderMeetsConditions($this->getEditObjectId())
            ) {
                $oManagerExec->exec4order($this->getEditObjectId());
                $oManagerExec->finishJobExecution();
            }
        } catch (d3ActionRequirementInterface|d3ordermanager_templaterendererExceptionInterface $e) {
            // @codeCoverageIgnoreStart
            if (!defined('OXID_PHP_UNIT')) {
                $logger = Registry::getLogger();
                $logger->error($e);
            }

            // @codeCoverageIgnoreEnd

            d3GetOxidDIC()->get('d3.ordermanager.log')->alert(
                self::class,
                __FUNCTION__,
                __LINE__,
                "execution error",
                $e->getMessage()
            );

            /** @var UtilsView $utilsView */
            $utilsView = d3GetOxidDIC()->get('d3ox.ordermanager.'.UtilsView::class);
            $utilsView->addErrorToDisplay($e);
        } finally {
            $oConfig = d3GetOxidDIC()->get('d3ox.ordermanager.'.Config::class);
            $oConfig->setAdminMode(true);
        }
    }

    public function getOrderManagerAssignment(Manager $oManager): ToItemAssignmentModel
    {
        d3GetOxidDIC()->set(
            ToItemAssignmentModel::class.'.args.ordermanager',
            $oManager
        );

        /** @var ToItemAssignmentModel $managerAssignment */
        $managerAssignment = d3GetOxidDIC()->get(ToItemAssignmentModel::class);
        return $managerAssignment;
    }

    /**
     * @throws d3ParameterNotFoundException
     */
    public function d3resetOrderManagerAssignment(): void
    {
        /** @var Request $request */
        $request = d3GetOxidDIC()->get($this->_DIC_OxInstance_Id.Request::class);

        $oManager = $this->getManager();
        $oAssignment = $this->getOrderManagerAssignment($oManager);
        $oAssignment->resetAssignment(
            $request->getRequestEscapedParameter('ordermanagerid'),
            $this->getEditObjectId()
        );
    }

    /**
     * @return mixed
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getFolderList()
    {
        $oManager = $this->getManager();
        return $oManager->d3getSelectableFolderList();
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function execChangedContents(): void
    {
        try {
            /** @var Request $request */
            $request = d3GetOxidDIC()->get($this->_DIC_OxInstance_Id.Request::class);
            $sItemId = $this->getEditObjectId();
            $oManager = $this->getManager();
            $oManager->load($request->getRequestEscapedParameter('ordermanagerid'));

            // check configuration exceptions
            $this->checkForConfigurationException($oManager);

            $contents = $oManager->getEditableContent($sItemId);
            $this->addTplParam('aMailContent', $contents);

            $field = oxNew(Field::class);
            $field->setValue($contents['html'] ?? '');
            $object = oxNew(BaseModel::class);
            $object->__set(
                'aContent[mail][html]',
                $field
            );
            $this->addTplParam("htmleditor", $this->generateTextEditor("95%", 180, $object, "aContent[mail][html]", "list.tpl.css"));

            $this->addTplParam('sAction', __FUNCTION__);
            $this->addTplParam('oManager', $oManager);
        } catch (d3ActionRequirementInterface | d3ordermanager_templaterendererExceptionInterface | NonTemplateFilenameException $oEx) {
            // @codeCoverageIgnoreStart
            if (! defined('OXID_PHP_UNIT')) {
                $logger = Registry::getLogger();
                $logger->error($oEx->getMessage());
            }

            // @codeCoverageIgnoreEnd

            $this->getManager()->d3getLog()->log(d3log::ALERT, self::class, __FUNCTION__, __LINE__, "stop execution because configuration error", $oEx->getMessage());

            /** @var UtilsView $utilsView */
            $utilsView = d3GetOxidDIC()->get('d3ox.ordermanager.' . UtilsView::class);
            $utilsView->addErrorToDisplay($oEx);
        } finally {
            $oConfig = d3GetOxidDIC()->get('d3ox.ordermanager.'.Config::class);
            $oConfig->setAdminMode(true);
        }
    }

    public function getUserMessages(): array
    {
        return [];
    }

    public function getLang(): Language
    {
        /** @var Language $language */
        $language = d3GetOxidDIC()->get('d3ox.ordermanager.'.Language::class);

        return $language;
    }

    public function getHelpURL(): string
    {
        $sUrl = $this->d3GetSet()->getHelpURL();
        /** @var d3str $oD3Str */
        $oD3Str = d3GetOxidDIC()->get(d3str::class);

        if ($this->_sHelpLinkMLAdd) {
            $sUrl .= $oD3Str->unprefixedslashit($this->getLang()->translateString($this->_sHelpLinkMLAdd));
        }

        /** @var d3filesystem $oFS */
        $oFS = d3GetOxidDIC()->get(d3filesystem::class);
        $aFileName = $oFS->splitFilename($sUrl);

        // has no extension
        if (false == $aFileName['ext']) {
            return $oD3Str->trailingslashit($sUrl);
        }

        return $sUrl;
    }

    /**
     * return type can't be defined, because of unmockable d3_cfg_mod class, use stdClass in test
     * @return d3_cfg_mod
     */
    public function d3GetSet()
    {
        /** @var d3_cfg_mod $modCfg */
        $modCfg = d3GetOxidDIC()->get('d3.ordermanager.modcfg');

        return $modCfg;
    }

    public function getLink(): string
    {
        return '';
    }

    /**
     * @throws d3ActionRequirementInterface
     */
    protected function checkForConfigurationException(Manager $oManager): void
    {
        d3GetOxidDIC()->set(d3ordermanager_configurationcheck::class.'.args.ordermanager', $oManager);
        /** @var d3ordermanager_configurationcheck $confCheck */
        $confCheck = d3GetOxidDIC()->get(d3ordermanager_configurationcheck::class);
        $confCheck->checkThrowingExceptions($oManager->getValue('sManuallyExecMeetCondition') ?
            d3ordermanager_configurationcheck::REQUIREMENTS_AND_ACTIONS :
            d3ordermanager_configurationcheck::ACTIONS_ONLY);
    }
}
