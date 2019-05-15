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

use D3\ModCfg\Application\Model\Exception\d3ParameterNotFoundException;
use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirementlist;
use D3\Ordermanager\Application\Model\Actions\d3ordermanager_actionlist;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_main;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Request;
use oxSystemComponentException;

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
     * @return d3_cfg_ordermanageritem_action
     * @throws Exception
     */
    public function getActionAdminController()
    {
        return d3GetModCfgDIC()->get(d3_cfg_ordermanageritem_action::class);
    }

    /**
     * @return d3_cfg_ordermanageritem_requ
     * @throws Exception
     */
    public function getRequirementAdminController()
    {
        return d3GetModCfgDIC()->get(d3_cfg_ordermanageritem_requ::class);
    }

    /**
     * @param $sName
     * @param $aArguments
     *
     * @return mixed
     * @throws oxSystemComponentException
     * @throws Exception
     */
    public function __call($sName, $aArguments)
    {
        $oActionView = $this->getActionAdminController();
        if (method_exists($oActionView, $sName)) {
            return call_user_func_array(array($oActionView, $sName), $aArguments);
        }

        $oRequView = $this->getRequirementAdminController();
        if (method_exists($oRequView, $sName)) {
            return call_user_func_array(array($oRequView, $sName), $aArguments);
        }

        return parent::__call($sName, $aArguments);
    }

    /**
     * @param d3ordermanager $oManager
     * @return d3ordermanager_requirementlist
     * @throws Exception
     */
    public function getRequirementListObject(d3ordermanager $oManager)
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_requirementlist::class.'.args.ordermanager',
            $oManager
        );

        return d3GetModCfgDIC()->get(d3ordermanager_requirementlist::class);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getRequirementList()
    {
        /** @var d3ordermanager $oManager */
        $oManager = $this->getProfile();
        $oRequList = $this->getRequirementListObject($oManager);
        $oRequList->setRequirements($oManager->getConfiguration()->getRequirementIdList());

        return $oRequList->getRequirementList();
    }

    /**
     * @param d3ordermanager $oManager
     * @return d3ordermanager_actionlist
     * @throws Exception
     */
    public function getActionListObject(d3ordermanager $oManager)
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_actionlist::class.'.args.ordermanager',
            $oManager
        );
        d3GetModCfgDIC()->set(
            d3ordermanager_actionlist::class.'.args.order',
            d3GetModCfgDIC()->get('d3ox.ordermanager.'.Order::class)
        );

        return d3GetModCfgDIC()->get(d3ordermanager_actionlist::class);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getActionList()
    {
        /** @var d3ordermanager $oManager */
        $oManager = $this->getProfile();
        $oActionList = $this->getActionListObject($oManager);
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

    /**
     * @throws Exception
     */
    public function setRequestData()
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $this->_sRequestData = $request->getRequestEscapedParameter('sRequestData');
    }

    /**
     * @return string
     */
    protected function _getRequestData()
    {
        return $this->_sRequestData;
    }

    /**
     * @return int
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3ParameterNotFoundException
     * @throws Exception
     */
    public function getToFinishedCount()
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $iRequestCount = $request->getRequestEscapedParameter('toFinishedCount');

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
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3ParameterNotFoundException
     * @throws Exception
     */
    public function getFinishedCount()
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $iRequestCount = $request->getRequestEscapedParameter('finishedCount');

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
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3ParameterNotFoundException
     * @throws Exception
     */
    public function getFinishedMonthCount()
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $iRequestCount = $request->getRequestEscapedParameter('finishedMonthCount');

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
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3ParameterNotFoundException
     * @throws Exception
     */
    public function getNotFinishedCount()
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $iRequestCount = $request->getRequestEscapedParameter('notFinishedCount');

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
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function canRequestData($sFunctionName)
    {
        return !$this->getDataOnDemand()
            || $this->_getRequestData() == $sFunctionName;
    }

    /**
     * @param $iRequestCount
     *
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function canUseRequestData($iRequestCount)
    {
        return $this->getDataOnDemand()
            && strlen($iRequestCount);
    }

    /**
     * @return bool
     * @throws DatabaseConnectionException
     * @throws DBALException
     * @throws DatabaseErrorException
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
     * @throws Exception
     */
    public function hasRequestedData($sRequestName, $sFunctionName)
    {
        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $iRequestCount = $request->getRequestEscapedParameter($sRequestName);

        if (strlen($iRequestCount) || $this->_getRequestData() == $sFunctionName) {
            return true;
        }

        return false;
    }

    /**
     * @return d3ordermanager
     * @throws Exception
     */
    public function getManager()
    {
        return d3GetModCfgDIC()->get(d3ordermanager::class);
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
     * @param $sManagerId
     * @return string
     * @throws Exception
     */
    public function getManagerTitle($sManagerId)
    {
        $oManager = $this->getManager();
        if ($oManager->load($sManagerId)) {
            return $oManager->getFieldData('oxtitle');
        };

        return $this->getLang()->translateString('D3_ORDERMANAGER_REQU_OTHERJOB_UNKNOWNJOBID').' "'.$sManagerId.'"';
    }
}
