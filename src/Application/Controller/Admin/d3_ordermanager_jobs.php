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

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\d3filesystem;
use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ParameterNotFoundException;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_configurationcheck;
use D3\Ordermanager\Application\Model\d3ordermanager_execute as ManagerExecuteModel;
use D3\Ordermanager\Application\Model\d3ordermanager_toorderassignment as ToItemAssignmentModel;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\Exceptions\d3ActionRequirementAbstract;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_templaterendererExceptionInterface;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
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
    private $_sModId = 'd3_ordermanager';
    /** @var d3ordermanagerlist */
    protected $_aJobList;
    protected $_sHelpLinkMLAdd;

    /**
     * d3_ordermanager_jobs constructor.
     */
    public function __construct()
    {
        // prevent the use of the global currency setting instead of the order setting
        unset($_GET['cur']);

        d3GetModCfgDIC()->setParameter('d3.ordermanager.modcfgid', $this->_sModId);

        parent::__construct();
    }

    /**
     * @return Order
     * @throws Exception
     */
    public function getItemObject()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class);
    }

    /**
     * @return string
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     */
    public function render()
    {
        parent::render();

        $soxId = $this->getEditObjectId();
        $this->addTplParam("oxid", $soxId);

        if ($soxId != "-1" && isset($soxId)) {
            $oItem = $this->getItemObject();
            $oItem->load($soxId);
            $this->addTplParam("edit", $oItem);
        }

        /** @var Session $session */
        $session = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Session::class);

        $sJobFolder = $session->getVariable('d3OrderManagerFolderSelect');
        $this->addTplParam("jobfolder", $sJobFolder);
        $this->_aJobList = $this->_d3GetManuallyManagerJobs($sJobFolder);

        return "d3_ordermanager_jobs.tpl";
    }

    /**
     * @return Session
     * @throws Exception
     */
    public function d3GetSession()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.Session::class);
    }

    /**
     * @throws Exception
     */
    public function changeFolder()
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);

        $this->d3GetSession()->setVariable(
            'd3OrderManagerFolderSelect',
            $request->getRequestEscapedParameter('jobfolder')
        );
    }

    /**
     * @return d3ordermanagerlist
     * @throws Exception
     */
    public function getManagerList()
    {
        return d3GetModCfgDIC()->get(d3ordermanagerlist::class);
    }

    /**
     * @return d3ordermanagerlist
     * @throws Exception
     */
    public function d3GetManagerJobs()
    {
        $oManagerList = $this->getManagerList();
        $oManagerList->getList();

        return $oManagerList;
    }

    /**
     * @param $sFolderId
     *
     * @return d3ordermanagerlist
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     */
    protected function _d3GetManuallyManagerJobs($sFolderId)
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
        } catch (d3ActionRequirementAbstract $oEx) {
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
    public function d3GetJobList()
    {
        return $this->_aJobList->getArray();
    }

    /**
     * @return Manager
     * @throws Exception
     */
    public function getManager()
    {
        return d3GetModCfgDIC()->get(Manager::class);
    }

    /**
     * @param Manager $oManager
     * @return ManagerExecuteModel
     * @throws Exception
     */
    public function getManagerExecute(Manager $oManager)
    {
        d3GetModCfgDIC()->set(
            ManagerExecuteModel::class.'.args.ordermanager',
            $oManager
        );

        return d3GetModCfgDIC()->get(ManagerExecuteModel::class);
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
    public function d3execordermanager()
    {
        try {
            /** @var Request $request */
            $request = d3GetModCfgDIC()->get('d3ox.ordermanager.' . Request::class);

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
        } catch (d3ActionRequirementAbstract $oEx) {
            $oEx->debugOut();
            /** @var UtilsView $utilsView */
            $utilsView = d3GetModCfgDIC()->get('d3ox.ordermanager.'.UtilsView::class);
            $utilsView->addErrorToDisplay($oEx);
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
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws Exception
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function d3ExecChangedOrderManager()
    {
        try {
            /** @var Request $request */
            $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);

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
        } catch (d3ActionRequirementAbstract $e) {
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
     * @throws Exception
     */
    public function getOrderManagerAssignment(Manager $oManager)
    {
        d3GetModCfgDIC()->set(
            ToItemAssignmentModel::class.'.args.ordermanager',
            $oManager
        );

        return d3GetModCfgDIC()->get(ToItemAssignmentModel::class);
    }

    /**
     * @throws DatabaseErrorException
     * @throws d3ParameterNotFoundException
     * @throws Exception
     */
    public function d3resetOrderManagerAssignment()
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);

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
     * @throws Exception
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
     * @throws Exception
     */
    public function execChangedContents()
    {
        try {
            /** @var Request $request */
            $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
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
        } catch (d3ActionRequirementAbstract $oEx) {
            $oEx->debugOut();
            /** @var UtilsView $utilsView */
            $utilsView = d3GetModCfgDIC()->get('d3ox.ordermanager.'.UtilsView::class);
            $utilsView->addErrorToDisplay($oEx);
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
     * @return array
     */
    public function getUserMessages()
    {
        return array();
    }

    /**
     * @return Language
     * @throws Exception
     */
    public function getLang()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getHelpURL()
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
     * @return d3_cfg_mod
     * @throws Exception
     */
    public function d3GetSet()
    {
        return d3GetModCfgDIC()->get('d3.ordermanager.modcfg');
    }

    public function getLink()
    {
        return '';
    }

    /**
     * @param Manager $oManager
     * @throws d3ActionRequirementAbstract
     */
    protected function checkForConfigurationException(Manager $oManager)
    {
        d3GetModCfgDIC()->set(d3ordermanager_configurationcheck::class.'.args.ordermanager', $oManager);
        d3GetModCfgDIC()->setParameter(
            d3ordermanager_configurationcheck::class.'.args.checktypes',
            $oManager->getValue('sManuallyExecMeetCondition') ?
                d3ordermanager_configurationcheck::REQUIREMENTS_AND_ACTIONS :
                d3ordermanager_configurationcheck::ACTIONS_ONLY
        );
        /** @var d3ordermanager_configurationcheck $confCheck */
        $confCheck = d3GetModCfgDIC()->get(d3ordermanager_configurationcheck::class);
        $confCheck->checkThrowingExceptions();
    }
}
