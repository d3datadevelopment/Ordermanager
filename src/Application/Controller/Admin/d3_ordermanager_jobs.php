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

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\d3filesystem;
use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ParameterNotFoundException;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Model\Exception\wrongModIdException;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_configurationcheck;
use D3\Ordermanager\Application\Model\d3ordermanager_execute as ManagerExecuteModel;
use D3\Ordermanager\Application\Model\d3ordermanager_toorderassignment as ToItemAssignmentModel;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\d3ordermanagerlist as ManagerListModel;
use D3\Ordermanager\Application\Model\d3ordermanager_vars as VariablesTrait;
use D3\Ordermanager\Application\Model\Exceptions\d3ActionRequirementInterface;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_templaterendererExceptionInterface;
use Doctrine\DBAL\DBALException;
use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use OxidEsales\Eshop\Application\Model\Order as ItemModel;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Model\BaseModel;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\Eshop\Core\Session;
use OxidEsales\Eshop\Core\UtilsView;

class d3_ordermanager_jobs extends AdminDetailsController
{
    use VariablesTrait;

    private $_sModId = 'd3_ordermanager';
    /** @var ManagerListModel */
    protected $_aJobList;
    protected $_sHelpLinkMLAdd;

    /**
     * constructor.
     */
    public function __construct()
    {
        // prevent the use of the global currency setting instead of the order setting
        unset($_GET['cur']);

        if (d3GetModCfgDIC()->getParameter($this->_DIC_Instance_Id . 'modcfgid') !== $this->_sModId) {
            throw oxNew(wrongModIdException::class, $this->_sModId);
        }

        parent::__construct();
    }

    /**
     * @return ItemModel
     */
    public function getItemObject(): ItemModel
    {
        /** @var ItemModel $item */
        $item = d3GetModCfgDIC()->get('d3ox.ordermanager.'.ItemModel::class);

        return $item;
    }

    /**
     * @return string
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function render(): string
    {
        parent::render();

        $soxId = $this->getEditObjectId();
        $this->addTplParam("oxid", $soxId);

        if (isset($soxId) && $soxId != "-1") {
            $oItem = $this->getItemObject();
            $oItem->load($soxId);
            $this->addTplParam("edit", $oItem);
        }

        /** @var Session $session */
        $session = d3GetModCfgDIC()->get($this->_DIC_OxInstance_Id.Session::class);

        $sJobFolder = $session->getVariable('d3FolderSelect');
        $this->addTplParam("jobfolder", $sJobFolder);
        $this->_aJobList = $this->_d3GetManuallyManagerJobs($sJobFolder);

        return "d3_ordermanager_jobs.tpl";
    }

    /**
     * @return Session
     */
    public function d3GetSession(): Session
    {
        /** @var Session $session */
        $session = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Session::class);

        return $session;
    }

    public function changeFolder()
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get($this->_DIC_OxInstance_Id.Request::class);

        $this->d3GetSession()->setVariable(
            'd3FolderSelect',
            $request->getRequestEscapedParameter('jobfolder')
        );
    }

    /**
     * @return ManagerListModel
     */
    public function getManagerList(): ManagerListModel
    {
        /** @var ManagerListModel $managerList */
        $managerList = d3GetModCfgDIC()->get(ManagerListModel::class);
        return $managerList;
    }

    /**
     * @return ManagerListModel
     */
    public function d3GetManagerJobs(): ManagerListModel
    {
        $oManagerList = $this->getManagerList();
        $oManagerList->getList();

        return $oManagerList;
    }

    /**
     * @param $sFolderId
     *
     * @return ManagerListModel
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

                if ($oManager->getValue('sManuallyExecMeetCondition') &&
                    false == $oManagerExecute->orderMeetsConditions($this->getEditObjectId())
                ) {
                    $oList->offsetUnset($sId);
                }
            }

            return $oList;
        } catch (d3ActionRequirementInterface $oEx) {
            /** @var UtilsView $utilsView */
            $utilsView = d3GetModCfgDIC()->get('d3ox.ordermanager.'.UtilsView::class);
            $utilsView->addErrorToDisplay($oEx);
        }

        /** @var d3ordermanagerlist $managerList */
        $managerList = d3GetModCfgDIC()->get(d3ordermanagerlist::class);
        return $managerList;
    }

    /**
     * @return array
     */
    public function d3GetJobList(): array
    {
        return $this->_aJobList->getArray();
    }

    /**
     * @return Manager
     */
    public function getManager(): Manager
    {
        /** @var Manager $manager */
        $manager = d3GetModCfgDIC()->get(Manager::class);
        return $manager;
    }

    /**
     * @param Manager $oManager
     * @return ManagerExecuteModel
     */
    public function getManagerExecute(Manager $oManager): ManagerExecuteModel
    {
        d3GetModCfgDIC()->set(
            ManagerExecuteModel::class.'.args.ordermanager',
            $oManager
        );

        /** @var ManagerExecuteModel $managerExecute */
        $managerExecute = d3GetModCfgDIC()->get(ManagerExecuteModel::class);
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
    public function d3execordermanager()
    {
        try {
            /** @var Request $request */
            $request = d3GetModCfgDIC()->get($this->_DIC_OxInstance_Id . Request::class);

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
            $oEx->debugOut();
            /** @var UtilsView $utilsView */
            $utilsView = d3GetModCfgDIC()->get('d3ox.ordermanager.'.UtilsView::class);
            $utilsView->addErrorToDisplay($oEx);
        } finally {
            $oConfig = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);
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
    public function d3ExecChangedOrderManager()
    {
        try {
            /** @var Request $request */
            $request = d3GetModCfgDIC()->get($this->_DIC_OxInstance_Id.Request::class);

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
        } catch (d3ActionRequirementInterface $e) {
            $e->debugOut();
            /** @var UtilsView $utilsView */
            $utilsView = d3GetModCfgDIC()->get('d3ox.ordermanager.'.UtilsView::class);
            $utilsView->addErrorToDisplay($e);
        } catch (d3ordermanager_templaterendererExceptionInterface $oEx) {
            $oEx->debugOut();
            /** @var UtilsView $utilsView */
            $utilsView = d3GetModCfgDIC()->get('d3ox.ordermanager.'.UtilsView::class);
            $utilsView->addErrorToDisplay($oEx);
        } finally {
            $oConfig = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);
            $oConfig->setAdminMode(true);
        }
    }

    /**
     * @param Manager $oManager
     * @return ToItemAssignmentModel
     */
    public function getOrderManagerAssignment(Manager $oManager): ToItemAssignmentModel
    {
        d3GetModCfgDIC()->set(
            ToItemAssignmentModel::class.'.args.ordermanager',
            $oManager
        );

        /** @var ToItemAssignmentModel $managerAssignment */
        $managerAssignment = d3GetModCfgDIC()->get(ToItemAssignmentModel::class);
        return $managerAssignment;
    }

    /**
     * @throws d3ParameterNotFoundException
     */
    public function d3resetOrderManagerAssignment()
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get($this->_DIC_OxInstance_Id.Request::class);

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
    public function execChangedContents()
    {
        try {
            /** @var Request $request */
            $request = d3GetModCfgDIC()->get($this->_DIC_OxInstance_Id.Request::class);
            $sItemId = $this->getEditObjectId();
            $oManager = $this->getManager();
            $oManager->load($request->getRequestEscapedParameter('ordermanagerid'));

            // check configuration exceptions
            $this->checkForConfigurationException($oManager);

            $contents = $oManager->getEditableContent($sItemId);

            $this->addTplParam('aMailContent', $contents);

            $field = oxNew(Field::class);
            $field->setValue($contents['html']);
            $object = oxNew(BaseModel::class);
            $object->__set(
                'aContent[mail][html]',
                $field
            );
            $this->addTplParam("htmleditor", $this->generateTextEditor("95%", 180, $object, "aContent[mail][html]", "list.tpl.css"));

            $this->addTplParam('sAction', __FUNCTION__);
            $this->addTplParam('oManager', $oManager);
        } catch (d3ActionRequirementInterface | d3ordermanager_templaterendererExceptionInterface $oEx) {
            $oEx->debugOut();
            /** @var UtilsView $utilsView */
            $utilsView = d3GetModCfgDIC()->get('d3ox.ordermanager.'.UtilsView::class);
            $utilsView->addErrorToDisplay($oEx);
        } finally {
            $oConfig = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);
            $oConfig->setAdminMode(true);
        }
    }

    /**
     * @return array
     */
    public function getUserMessages(): array
    {
        return [];
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
     * @return string
     */
    public function getHelpURL(): string
    {
        $sUrl = $this->d3GetSet()->getHelpURL();
        /** @var d3str $oD3Str */
        $oD3Str = d3GetModCfgDIC()->get(d3str::class);

        if ($this->_sHelpLinkMLAdd) {
            $sUrl .= $oD3Str->unprefixedslashit($this->getLang()->translateString($this->_sHelpLinkMLAdd));
        }

        /** @var d3filesystem $oFS */
        $oFS = d3GetModCfgDIC()->get(d3filesystem::class);
        $aFileName = $oFS->splitFilename($sUrl);

        // has no extension
        if (false == $aFileName['ext']) {
            $sUrl = $oD3Str->trailingslashit($sUrl);
        }

        return $sUrl;
    }

    /**
     * return type can't defined, because of unmockable d3_cfg_mod class, use stdClass in test
     * @return d3_cfg_mod
     */
    public function d3GetSet()
    {
        /** @var d3_cfg_mod $modCfg */
        $modCfg = d3GetModCfgDIC()->get('d3.ordermanager.modcfg');

        return $modCfg;
    }

    public function getLink(): string
    {
        return '';
    }

    /**
     * @param Manager $oManager
     * @throws d3ActionRequirementInterface
     */
    protected function checkForConfigurationException(Manager $oManager): void
    {
        d3GetModCfgDIC()->set(d3ordermanager_configurationcheck::class.'.args.ordermanager', $oManager);
        /** @var d3ordermanager_configurationcheck $confCheck */
        $confCheck = d3GetModCfgDIC()->get(d3ordermanager_configurationcheck::class);
        $confCheck->checkThrowingExceptions($oManager->getValue('sManuallyExecMeetCondition') ?
            d3ordermanager_configurationcheck::REQUIREMENTS_AND_ACTIONS :
            d3ordermanager_configurationcheck::ACTIONS_ONLY);
    }
}
