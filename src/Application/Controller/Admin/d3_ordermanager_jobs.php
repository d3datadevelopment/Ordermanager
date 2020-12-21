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

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\d3filesystem;
use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ParameterNotFoundException;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_execute as ManagerExecuteModel;
use D3\Ordermanager\Application\Model\d3ordermanager_toorderassignment as ToItemAssignmentModel;
use D3\Ordermanager\Application\Model\d3ordermanagerlist as ManagerListModel;
use D3\Ordermanager\Application\Model\d3ordermanager_vars as VariablesTrait;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use OxidEsales\Eshop\Application\Model\Order as ItemModel;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Model\BaseModel;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\Eshop\Core\Session;

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

        d3GetModCfgDIC()->setParameter($this->_DIC_Instance_Id.'modcfgid', $this->_sModId);

        parent::__construct();
    }

    /**
     * @return ItemModel
     * @throws Exception
     */
    public function getItemObject()
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
        $session = d3GetModCfgDIC()->get($this->_DIC_OxInstance_Id.Session::class);

        $sJobFolder = $session->getVariable('d3FolderSelect');
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
        /** @var Session $session */
        $session = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Session::class);

        return $session;
    }

    /**
     * @throws Exception
     */
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
     * @throws Exception
     */
    public function getManagerList()
    {
        /** @var ManagerListModel $managerList */
        $managerList = d3GetModCfgDIC()->get(ManagerListModel::class);
        return $managerList;
    }

    /**
     * @return ManagerListModel
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
     * @return ManagerListModel
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
        /** @var Manager $manager */
        $manager = d3GetModCfgDIC()->get(Manager::class);
        return $manager;
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

        /** @var ManagerExecuteModel $managerExecute */
        $managerExecute = d3GetModCfgDIC()->get(ManagerExecuteModel::class);
        return $managerExecute;
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
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get($this->_DIC_OxInstance_Id.Request::class);

        $oManager = $this->getManager();
        $oManager->load($request->getRequestEscapedParameter('ordermanagerid'));
        $oManagerExec = $this->getManagerExecute($oManager);

        if (false == $oManager->getValue('sManuallyExecMeetCondition') ||
            $oManagerExec->orderMeetsConditions($this->getEditObjectId())
        ) {
            $oManagerExec->exec4order($this->getEditObjectId());
            $oManagerExec->finishJobExecution();
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
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get($this->_DIC_OxInstance_Id.Request::class);

        $oManager = $this->getManager();
        $oManager->load($request->getRequestEscapedParameter('ordermanagerid'));
        $oManager->setEditedValues($request->getRequestEscapedParameter('aContent'));
        $oManagerExec = $this->getManagerExecute($oManager);

        if (false == $oManager->getValue('sManuallyExecMeetCondition') ||
            $oManagerExec->orderMeetsConditions($this->getEditObjectId())
        ) {
            $oManagerExec->exec4order($this->getEditObjectId());
            $oManagerExec->finishJobExecution();
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

        /** @var ToItemAssignmentModel $managerAssignment */
        $managerAssignment = d3GetModCfgDIC()->get(ToItemAssignmentModel::class);
        return $managerAssignment;
    }

    /**
     * @throws DatabaseErrorException
     * @throws d3ParameterNotFoundException
     * @throws Exception
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
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get($this->_DIC_OxInstance_Id.Request::class);
        $sItemId = $this->getEditObjectId();
        $oManager = $this->getManager();
        $oManager->load($request->getRequestEscapedParameter('ordermanagerid'));
        $this->addTplParam('aMailContent', $oManager->getEditableContent($sItemId));

        $contents = $oManager->getEditableContent($sItemId);
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
        /** @var Language $language */
        $language = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);

        return $language;
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
        /** @var d3_cfg_mod $modCfg */
        $modCfg = d3GetModCfgDIC()->get('d3.ordermanager.modcfg');

        return $modCfg;
    }

    public function getLink()
    {
        return '';
    }
}
