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

use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirementlist;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actionlist;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_main;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;

class d3_cfg_ordermanageritem_overview extends d3_cfg_mod_main
{
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
    protected $_sD3ObjectClass = d3ordermanager::class;
    protected $_sRequestData;

    /**
     * @param $sName
     * @param $aArguments
     *
     * @return mixed
     */
    public function __call($sName, $aArguments)
    {
        /** @var d3_cfg_ordermanageritem_action $oActionView */
        $oActionView = oxNew(d3_cfg_ordermanageritem_action::class);
        if (method_exists($oActionView, $sName)) {
            return call_user_func_array(array($oActionView, $sName), $aArguments);
        }

        /** @var d3_cfg_ordermanageritem_requ $oRequView */
        $oRequView = oxNew(d3_cfg_ordermanageritem_requ::class);
        if (method_exists($oRequView, $sName)) {
            return call_user_func_array(array($oRequView, $sName), $aArguments);
        }

        return parent::__call($sName, $aArguments);
    }

    /**
     * @return array
     */
    public function getRequirementList()
    {
        /** @var d3ordermanager $oManager */
        $oManager = $this->getProfile();
        /** @var d3ordermanager_requirementlist $oRequList */
        $oRequList = oxNew(d3ordermanager_requirementlist::class, $oManager);
        $oRequList->setRequirements($oManager->getConfiguration()->getRequirementIdList());

        return $oRequList->getRequirementList();
    }

    /**
     * @return array
     */
    public function getActionList()
    {
        /** @var d3ordermanager $oManager */
        $oManager = $this->getProfile();
        $oItem = oxNew(Order::class);
        /** @var d3ordermanager_actionlist $oActionList */
        $oActionList = oxNew(d3ordermanager_actionlist::class, $oManager, $oItem);
        $oActionList->setActions($oManager->getConfiguration()->getActionIdList());

        return $oActionList->getActionList();
    }

    /**
     * @return bool
     */
    public function isEditMode()
    {
        return false;
    }

    public function setRequestData()
    {
        $this->_sRequestData = Registry::get(Request::class)->getRequestEscapedParameter('sRequestData');
    }

    /**
     * @return int
     */
    public function getToFinishedCount()
    {
        $iRequestCount = Registry::get(Request::class)->getRequestEscapedParameter('toFinishedCount');

        if ($this->canRequestData(__FUNCTION__)) {
            /** @var d3ordermanager $oProfile */
            $oProfile = $this->getProfile();
            return $oProfile->getListGenerator()->getConcernedItemCount();
        } elseif ($this->canUseRequestData($iRequestCount)) {
            return $iRequestCount;
        }

        return '';
    }

    /**
     * @return int
     */
    public function getFinishedCount()
    {
        $iRequestCount = Registry::get(Request::class)->getRequestEscapedParameter('finishedCount');

        if ($this->canRequestData(__FUNCTION__)) {
            /** @var d3ordermanager $oProfile */
            $oProfile = $this->getProfile();
            return $oProfile->getListGenerator()->getFinishedItemCount();
        } elseif ($this->canUseRequestData($iRequestCount)) {
            return $iRequestCount;
        }

        return '';
    }

    /**
     * @return int
     */
    public function getFinishedMonthCount()
    {
        $iRequestCount = Registry::get(Request::class)->getRequestEscapedParameter('finishedMonthCount');

        if ($this->canRequestData(__FUNCTION__)) {
            /** @var d3ordermanager $oProfile */
            $oProfile = $this->getProfile();
            return $oProfile->getListGenerator()->getFinishedMonthItemCount();
        } elseif ($this->canUseRequestData($iRequestCount)) {
            return $iRequestCount;
        }

        return '';
    }

    /**
     * @return int
     */
    public function getNotFinishedCount()
    {
        $iRequestCount = Registry::get(Request::class)->getRequestEscapedParameter('notFinishedCount');

        if ($this->canRequestData(__FUNCTION__)) {
            /** @var d3ordermanager $oProfile */
            $oProfile = $this->getProfile();
            return $oProfile->getListGenerator()->getNotFinishedItemCount();
        } elseif ($this->canUseRequestData($iRequestCount)) {
            return $iRequestCount;
        }

        return '';
    }

    /**
     * @param $sFunctionName
     *
     * @return bool
     */
    public function canRequestData($sFunctionName)
    {
        return !$this->getDataOnDemand()
            || $this->_sRequestData == $sFunctionName;
    }

    /**
     * @param $iRequestCount
     *
     * @return bool
     */
    public function canUseRequestData($iRequestCount)
    {
        return $this->getDataOnDemand()
            && strlen($iRequestCount);
    }

    /**
     * @return bool
     */
    public function getDataOnDemand()
    {
        return $this->d3GetSet()->getValue('blCalcStatOnDemand');
    }

    /**
     * @param $sRequestName
     * @param $sFunctionName
     *
     * @return bool
     */
    public function hasRequestedData($sRequestName, $sFunctionName)
    {
        $iRequestCount = Registry::get(Request::class)->getRequestEscapedParameter($sRequestName);

        if (strlen($iRequestCount) || $this->_sRequestData == $sFunctionName) {
            return true;
        }

        return false;
    }

    /**
     * @param $sManagerId
     * @return string
     */
    public function getManagerTitle($sManagerId)
    {
        /** @var d3ordermanager $oManager */
        $oManager = oxNew(d3ordermanager::class);
        if ($oManager->load($sManagerId)) {
            return $oManager->getFieldData('oxtitle');
        };

        return Registry::getLang()->translateString('D3_ORDERMANAGER_REQU_OTHERJOB_UNKNOWNJOBID').' "'.$sManagerId.'"';
    }
}
