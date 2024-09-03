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

use D3\Ordermanager\Application\Model\Constants;
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

    protected $_sThisTemplate = '@'. Constants::OXID_MODULE_ID .'/admin/d3_cfg_ordermanageritem_requ';

    protected $_sMenuSubItemTitle = 'd3mxordermanager_items';

    public function save(): void
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

        if ($aMissingRequiredValues !== []) {
            $this->addTplParam('missingRequValuesActions', $aMissingRequiredValues);
        }
    }

    public function getPaymentList(): ListModel
    {
        /** @var PaymentList $oPaymentList */
        $oPaymentList = d3GetOxidDIC()->get('d3ox.ordermanager.'.PaymentList::class);
        return $this->_getObjectList($oPaymentList, null, 'oxdesc ASC');
    }

    public function getDeliverySetList(): DeliverySetList
    {
        /** @var DeliverySetList $oDeliverySetList */
        $oDeliverySetList = d3GetOxidDIC()->get('d3ox.ordermanager.'.DeliverySetList::class);

        /** @var DeliverySetList $list */
        $list = $this->_getObjectList($oDeliverySetList, null, 'oxtitle ASC');

        return $list;
    }

    public function getCountryList(): ListModel
    {
        /** @var CountryList $oCountryList */
        $oCountryList = d3GetOxidDIC()->get('d3ox.ordermanager.'.CountryList::class);
        return $this->_getObjectList($oCountryList, null, 'oxtitle ASC');
    }

    public function getJobList(): ManagerList
    {
        $sCurrentId = $this->getViewDataElement('edit')->getId();
        /** @var $oManagerList ManagerList */
        $oManagerList = d3GetOxidDIC()->get(ManagerList::class);
        $oManagerList->setCustomSorting('oxsort ASC');
        $oManagerList->getList();
        $oManagerList->offsetUnset($sCurrentId);
        return $oManagerList;
    }

    public function getLanguageList(): array
    {
        $oLang = d3GetOxidDIC()->get('d3ox.ordermanager.'.Language::class);
        return $oLang->getLanguageArray();
    }

    /**
     * Sets default values for empty article (currently does nothing), returns
     * array with parameters.
     *
     * @param array $aParams Parameters, to set default values
     */
    public function addDefaultValues($aParams): array
    {
        return $aParams;
    }

    public function getRequirementGroupList(Manager $oManager): RequirementGroupListModel
    {
        d3GetOxidDIC()->set(
            RequirementGroupListModel::class.'.args.ordermanager',
            $oManager
        );

        /** @var RequirementGroupListModel $requGroupModel */
        $requGroupModel = d3GetOxidDIC()->get(RequirementGroupListModel::class);
        return $requGroupModel;
    }

    public function getRequirementListObject(Manager $oManager): RequirementListModel
    {
        d3GetOxidDIC()->set(
            RequirementListModel::class.'.args.ordermanager',
            $oManager
        );

        /** @var RequirementListModel $requListModel */
        $requListModel = d3GetOxidDIC()->get(RequirementListModel::class);
        return $requListModel;
    }

    public function getGroupedRequirementList(): array
    {
        /** @var Manager $oManager */
        $oManager = $this->getProfile();
        $oRequList = $this->getRequirementGroupList($oManager);
        $oRequList->setGroups($oManager->getConfiguration()->getGroupedRequirementIdList());

        return $oRequList->getGroupList();
    }

    public function getRequirementList(): array
    {
        /** @var Manager $oManager */
        $oManager = $this->getProfile();
        $oRequList = $this->getRequirementListObject($oManager);
        $oRequList->setRequirements($oManager->getConfiguration()->getRequirementIdList());

        return $oRequList->getRequirementList();
    }
}
