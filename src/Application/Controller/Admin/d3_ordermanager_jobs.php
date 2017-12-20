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

use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\d3ordermanager_execute;
use D3\Ordermanager\Application\Model\d3ordermanager_toorderassignment;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\d3filesystem;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;

class d3_ordermanager_jobs extends AdminDetailsController
{
    /** @var d3ordermanagerlist */
    protected $_aJobList;
    protected $_sHelpLinkMLAdd;

    /**
     * @return string
     */
    public function render()
    {
        parent::render();

        $soxId = $this->getEditObjectId();
        $this->addTplParam("oxid", $soxId);

        if ($soxId != "-1" && isset($soxId)) {
            // load object
            $oItem = oxNew(Order::class);
            $oItem->load($soxId);
            $this->addTplParam("edit", $oItem);
        }

        $sJobFolder = Registry::getSession()->getVariable('d3OrderManagerFolderSelect');
        $this->addTplParam("jobfolder", $sJobFolder);
        $this->_aJobList = $this->_d3GetManuallyManagerJobs($sJobFolder);

        return "d3_ordermanager_jobs.tpl";
    }

    public function changeFolder()
    {
        Registry::getSession()->setVariable(
            'd3OrderManagerFolderSelect',
            Registry::get(Request::class)->getRequestEscapedParameter('jobfolder')
        );
    }

    /**
     * @return d3ordermanagerlist
     */
    public function d3GetManagerJobs()
    {
        /** @var d3ordermanagerlist $oManagerList */
        $oManagerList = oxNew(d3ordermanagerlist::class);
        $oManagerList->getList();

        return $oManagerList;
    }

    /**
     * @param $sFolderId
     * @return d3ordermanagerlist
     */
    protected function _d3GetManuallyManagerJobs($sFolderId)
    {
        /** @var $oManagerList d3ordermanagerlist */
        $oManagerList = oxNew(d3ordermanagerlist::class);
        return $oManagerList->d3GetManuallyManagerJobsByFolder($sFolderId);
    }

    /**
     * @return array
     */
    public function d3GetJobList()
    {
        return $this->_aJobList->getArray();
    }

    public function d3execordermanager()
    {
        /** @var d3ordermanager $oManager */
        $oManager = oxNew(d3ordermanager::class);
        $oManager->load(Registry::get(Request::class)->getRequestEscapedParameter('ordermanagerid'));
        /** @var d3ordermanager_execute $oManagerExec */
        $oManagerExec = oxNew(d3ordermanager_execute::class, $oManager);
        $oManagerExec->exec4order(Registry::get(Request::class)->getRequestEscapedParameter('oxid'));
        $oManagerExec->finishJobExecution();
    }

    public function d3ExecChangedOrderManager()
    {
        /** @var d3ordermanager $oManager */
        $oManager = oxNew(d3ordermanager::class);
        $oManager->load(Registry::get(Request::class)->getRequestEscapedParameter('ordermanagerid'));
        $oManager->setEditedValues(Registry::get(Request::class)->getRequestEscapedParameter('aContent'));
        /** @var d3ordermanager_execute $oManagerExec */
        $oManagerExec = oxNew(d3ordermanager_execute::class, $oManager);
        $oManagerExec->exec4order(Registry::get(Request::class)->getRequestEscapedParameter('oxid'));
        $oManagerExec->finishJobExecution();
    }

    public function d3resetOrderManagerAssignment()
    {
        /** @var d3ordermanager $oManager */
        $oManager = oxNew(d3ordermanager::class);
        /** @var d3ordermanager_toorderassignment $oAssignment */
        $oAssignment = oxNew(d3ordermanager_toorderassignment::class, $oManager);
        $oAssignment->resetAssignment(
            Registry::get(Request::class)->getRequestEscapedParameter('ordermanagerid'),
            Registry::get(Request::class)->getRequestEscapedParameter('oxid')
        );
    }

    /**
     * @return mixed
     */
    public function getFolderList()
    {
        /** @var d3ordermanager $oManager */
        $oManager = oxNew(d3ordermanager::class);
        return $oManager->d3getSelectableFolderList();
    }

    public function execChangedContents()
    {
        $sItemId = Registry::get(Request::class)->getRequestEscapedParameter('oxid');
        /** @var $oManager d3ordermanager */
        $oManager = oxNew(d3ordermanager::class);
        $oManager->load(Registry::get(Request::class)->getRequestEscapedParameter('ordermanagerid'));
        $this->addTplParam('aMailContent', $oManager->getEditableContent($sItemId));
        $this->addTplParam('sAction', __FUNCTION__);
        $this->addTplParam('oOrderManager', $oManager);
    }

    /**
     * @return array
     */
    public function getUserMessages()
    {
        return array();
    }

    /**
     * @return string
     */
    public function getHelpURL()
    {
        $sUrl = $this->d3GetSet()->getHelpURL();
        /** @var $oFS d3filesystem */
        $oFS = oxNew(d3filesystem::class);

        if ($this->_sHelpLinkMLAdd) {
            $sUrl .= $oFS->unprefixedslashit(Registry::getLang()->TranslateString($this->_sHelpLinkMLAdd));
        }

        $aFileName = $oFS->splitFilename($sUrl);

        // has no extension
        if (false == $aFileName['ext']) {
            $sUrl = $oFS->trailingslashit($sUrl);
        }

        return $sUrl;
    }

    /**
     * @return d3_cfg_mod
     */
    public function d3GetSet()
    {
        return d3_cfg_mod::get('d3_ordermanager');
    }

    public function getLink()
    {
        return '';
    }
}
