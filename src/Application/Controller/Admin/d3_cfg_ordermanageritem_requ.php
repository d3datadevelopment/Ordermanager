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

use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirement_abstract;
use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirementgrouplist;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirementlist;
use Exception;
use OxidEsales\Eshop\Application\Model\PaymentList;
use OxidEsales\Eshop\Application\Model\DeliveryList;
use OxidEsales\Eshop\Application\Model\CountryList;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Model\ListModel;

class d3_cfg_ordermanageritem_requ extends d3_cfg_ordermanageritem_settings
{
    protected $_sThisTemplate = "d3_cfg_ordermanageritem_requ.tpl";
    protected $_aTransStatus = array('OK', 'ERROR', 'NOT_OK');
    protected $_sMenuSubItemTitle = 'd3mxordermanager_items';

    public function save()
    {
        parent::save();

        $aMissingRequiredValues = array();
        /** @var d3ordermanager_requirement_abstract $oRequirement */
        foreach ($this->getRequirementList() as $sId => $oRequirement) {
            if ($this->getProfile()->getValue($oRequirement->sRequActiveSwitch) && false == $oRequirement->hasRequiredValues()) {
                $aMissingRequiredValues[] = $sId;
            }
        };

        if (count($aMissingRequiredValues)) {
            $this->addTplParam('missingRequValuesActions', $aMissingRequiredValues);
        }
    }

    /**
     * @return ListModel
     * @throws Exception
     */
    public function getPaymentList()
    {
        /** @var PaymentList $oPaymentList */
        $oPaymentList = d3GetModCfgDIC()->get('d3ox.ordermanager.'.PaymentList::class);
        return $this->_getObjectList($oPaymentList, null, 'oxdesc ASC');
    }

    /**
     * @return ListModel
     * @throws Exception
     */
    public function getDeliveryList()
    {
        /** @var DeliveryList $oDeliveryList */
        $oDeliveryList = d3GetModCfgDIC()->get('d3ox.ordermanager.'.DeliveryList::class);
        return $this->_getObjectList($oDeliveryList, null, 'oxtitle ASC');
    }

    /**
     * @return ListModel
     * @throws Exception
     */
    public function getCountryList()
    {
        /** @var CountryList $oCountryList */
        $oCountryList = d3GetModCfgDIC()->get('d3ox.ordermanager.'.CountryList::class);
        return $this->_getObjectList($oCountryList, null, 'oxtitle ASC');
    }

    /**
     * @return d3ordermanagerlist
     * @throws Exception
     */
    public function getJobList()
    {
        $sCurrentId = $this->getViewDataElement('edit')->getId();
        /** @var $oManagerList d3Ordermanagerlist */
        $oManagerList = d3GetModCfgDIC()->get(d3ordermanagerlist::class);
        $oManagerList->setCustomSorting('oxsort ASC');
        $oManagerList->getList();
        $oManagerList->offsetUnset($sCurrentId);
        return $oManagerList;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getLanguageList()
    {
        $oLang = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);
        $aLanguageList = $oLang->getLanguageArray();
        return $aLanguageList;
    }

    /**
     * @return array
     */
    public function getTransStatusList()
    {
        return $this->_aTransStatus;
    }

    /**
     * Sets default values for empty article (currently does nothing), returns
     * array with parameters.
     *
     * @param array $aParams Parameters, to set default values
     *
     * @return array
     */
    public function addDefaultValues($aParams)
    {
        return $aParams;
    }

    /**
     * @param d3ordermanager $oManager
     * @return d3ordermanager_requirementgrouplist
     * @throws Exception
     */
    public function getRequirementGroupList(d3ordermanager $oManager)
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_requirementgrouplist::class.'.args.ordermanager',
            $oManager
        );

        return d3GetModCfgDIC()->get(d3ordermanager_requirementgrouplist::class);
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
    public function getGroupedRequirementList()
    {
        /** @var d3ordermanager $oManager */
        $oManager = $this->getProfile();
        /** @var d3ordermanager_requirementgrouplist $oRequList */
        $oRequList = $this->getRequirementGroupList($oManager);
        $oRequList->setGroups($oManager->getConfiguration()->getGroupedRequirementIdList());

        return $oRequList->getGroupList();
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getRequirementList()
    {
        /** @var d3ordermanager $oManager */
        $oManager = $this->getProfile();
        /** @var d3ordermanager_requirementlist $oRequList */
        $oRequList = $this->getRequirementListObject($oManager);
        $oRequList->setRequirements($oManager->getConfiguration()->getRequirementIdList());

        return $oRequList->getRequirementList();
    }
}
