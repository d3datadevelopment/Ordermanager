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

use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanagerlist as ManagerList;
use D3\Ordermanager\Application\Model\d3ordermanager_vars as VariablesTrait;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_requirementException;
use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirement_interface as RequirementModelInterface;
use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirementgrouplist as RequirementGroupListModel;
use D3\Ordermanager\Application\Model\Requirements\d3ordermanager_requirementlist as RequirementListModel;
use OxidEsales\Eshop\Application\Model\DeliverySetList;
use OxidEsales\Eshop\Application\Model\PaymentList;
use OxidEsales\Eshop\Application\Model\CountryList;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Model\ListModel;

class d3_cfg_ordermanageritem_requ extends d3_cfg_ordermanageritem_settings
{
    use VariablesTrait;

    protected $_sThisTemplate = "d3_cfg_ordermanageritem_requ.tpl";
    protected $_aTransStatus = ['OK', 'ERROR', 'NOT_OK'];
    protected $_sMenuSubItemTitle = 'd3mxordermanager_items';

    public function save()
    {
        // @codeCoverageIgnoreStart
        if (!defined('OXID_PHP_UNIT')) {
            parent::save();
        }
        // @codeCoverageIgnoreEnd

        $aMissingRequiredValues = [];
        /** @var RequirementModelInterface $oRequirement */
        foreach ($this->getRequirementList() as $sId => $oRequirement) {
            if ($this->getProfile()->getValue($oRequirement->getActiveSwitchParameter())) {
                try {
                    $oRequirement->throwUnvalidConfigurationException();
                } catch (d3ordermanager_requirementException $e) {
                    unset($e);
                    $aMissingRequiredValues[] = $sId;
                }
            }
        }

        if (count($aMissingRequiredValues)) {
            $this->addTplParam('missingRequValuesActions', $aMissingRequiredValues);
        }
    }

    /**
     * @return ListModel
     */
    public function getPaymentList(): ListModel
    {
        /** @var PaymentList $oPaymentList */
        $oPaymentList = d3GetModCfgDIC()->get('d3ox.ordermanager.'.PaymentList::class);
        return $this->_getObjectList($oPaymentList, null, 'oxdesc ASC');
    }

    /**
     * @return DeliverySetList
     */
    public function getDeliverySetList(): DeliverySetList
    {
        /** @var DeliverySetList $oDeliverySetList */
        $oDeliverySetList = d3GetModCfgDIC()->get('d3ox.ordermanager.'.DeliverySetList::class);
        return $this->_getObjectList($oDeliverySetList, null, 'oxtitle ASC');
    }

    /**
     * @return ListModel
     */
    public function getCountryList(): ListModel
    {
        /** @var CountryList $oCountryList */
        $oCountryList = d3GetModCfgDIC()->get('d3ox.ordermanager.'.CountryList::class);
        return $this->_getObjectList($oCountryList, null, 'oxtitle ASC');
    }

    /**
     * @return ManagerList
     */
    public function getJobList(): ManagerList
    {
        $sCurrentId = $this->getViewDataElement('edit')->getId();
        /** @var $oManagerList ManagerList */
        $oManagerList = d3GetModCfgDIC()->get(ManagerList::class);
        $oManagerList->setCustomSorting('oxsort ASC');
        $oManagerList->getList();
        $oManagerList->offsetUnset($sCurrentId);
        return $oManagerList;
    }

    /**
     * @return array
     */
    public function getLanguageList(): array
    {
        $oLang = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);
        return $oLang->getLanguageArray();
    }

    /**
     * @return array
     */
    public function getTransStatusList(): array
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
    public function addDefaultValues($aParams): array
    {
        return $aParams;
    }

    /**
     * @param Manager $oManager
     * @return RequirementGroupListModel
     */
    public function getRequirementGroupList(Manager $oManager): RequirementGroupListModel
    {
        d3GetModCfgDIC()->set(
            RequirementGroupListModel::class.'.args.ordermanager',
            $oManager
        );

        /** @var RequirementGroupListModel $requGroupModel */
        $requGroupModel = d3GetModCfgDIC()->get(RequirementGroupListModel::class);
        return $requGroupModel;
    }

    /**
     * @param Manager $oManager
     * @return RequirementListModel
     */
    public function getRequirementListObject(Manager $oManager): RequirementListModel
    {
        d3GetModCfgDIC()->set(
            RequirementListModel::class.'.args.ordermanager',
            $oManager
        );

        /** @var RequirementListModel $requListModel */
        $requListModel = d3GetModCfgDIC()->get(RequirementListModel::class);
        return $requListModel;
    }

    /**
     * @return array
     */
    public function getGroupedRequirementList(): array
    {
        /** @var Manager $oManager */
        $oManager = $this->getProfile();
        $oRequList = $this->getRequirementGroupList($oManager);
        $oRequList->setGroups($oManager->getConfiguration()->getGroupedRequirementIdList());

        return $oRequList->getGroupList();
    }

    /**
     * @return array
     */
    public function getRequirementList(): array
    {
        /** @var Manager $oManager */
        $oManager = $this->getProfile();
        $oRequList = $this->getRequirementListObject($oManager);
        $oRequList->setRequirements($oManager->getConfiguration()->getRequirementIdList());

        return $oRequList->getRequirementList();
    }
}
