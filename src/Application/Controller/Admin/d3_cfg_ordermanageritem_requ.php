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

use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirementgrouplist;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use OxidEsales\Eshop\Application\Model\PaymentList;
use OxidEsales\Eshop\Application\Model\DeliveryList;
use OxidEsales\Eshop\Application\Model\CountryList;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\Registry;

class d3_cfg_ordermanageritem_requ extends d3_cfg_ordermanageritem_settings
{
    protected $_sThisTemplate = "d3_cfg_ordermanageritem_requ.tpl";
    protected $_aTransStatus = array('OK', 'ERROR', 'NOT_OK');
    protected $_sMenuSubItemTitle = 'd3mxordermanager_items';

    /**
     * @return ListModel
     */
    public function getPaymentList()
    {
        /** @var PaymentList $oPaymentList */
        $oPaymentList = oxNew(PaymentList::class);
        return $this->_getObjectList($oPaymentList);
    }

    /**
     * @return ListModel
     */
    public function getDeliveryList()
    {
        /** @var DeliveryList $oDeliveryList */
        $oDeliveryList = oxNew(DeliveryList::class);
        return $this->_getObjectList($oDeliveryList);
    }

    /**
     * @return ListModel
     */
    public function getCountryList()
    {
        /** @var CountryList $oCountryList */
        $oCountryList = oxNew(CountryList::class);
        return $this->_getObjectList($oCountryList);
    }

    /**
     * @return d3ordermanagerlist
     */
    public function getJobList()
    {
        $sCurrentId = $this->getViewDataElement('edit')->getId();
        /** @var $oManagerList d3Ordermanagerlist */
        $oManagerList = oxNew(d3ordermanagerlist::class);
        $oManagerList->setCustomSorting('oxsort ASC');
        $oManagerList->getList();
        $oManagerList->offsetUnset($sCurrentId);
        return $oManagerList;
    }

    /**
     * @return array
     */
    public function getLanguageList()
    {
        $aLanguageList = Registry::getLang()->getLanguageArray();
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
     * @return array
     */
    public function getGroupedRequirementList()
    {
        /** @var d3ordermanager $oManager */
        $oManager = $this->getProfile();
        /** @var d3ordermanager_requirementgrouplist $oRequList */
        $oRequList = oxNew(d3ordermanager_requirementgrouplist::class, $oManager);
        $oRequList->setGroups($oManager->getConfiguration()->getGroupedRequirementIdList());

        return $oRequList->getGroupList();
    }
}
