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

namespace D3\Ordermanager\Application\Model;

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Configuration\d3modprofilelist;
use D3\ModCfg\Application\Model\d3utils;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;

class d3ordermanagerlist extends d3modprofilelist
{
    /**
     * List Object class name
     *
     * @var string
     */
    protected $_sObjectsInListName = d3ordermanager::class;

    /**
     * @param $sFolderId
     * @return d3ordermanagerlist
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     */
    public function d3GetManuallyManagerJobsByFolder($sFolderId)
    {
        /** @var d3ordermanager $oListObject */
        $oListObject = $this->getBaseObject();
        $sFieldList = $oListObject->getSelectFields();
        $sQ = "select $sFieldList from " . $oListObject->getViewName();

        $sQ .= " where ";
        $sQ = $this->d3AddActiveSnippet($oListObject, $sQ, true, false);
        $sQ = $this->d3AddFolderSelection($sFolderId, $oListObject, $sQ);
        $sQ .= " ORDER BY ".$oListObject->getViewName().".oxsort ASC, ".$oListObject->getViewName().".oxfolder ASC";

        $this->selectString($sQ);

        /** @var $oManager d3ordermanager */
        foreach ($this->getArray() as $sKey => $oManager) {
            if (false == $this->canExecutedManually($oManager)) {
                $this->offsetUnset($sKey);
            }
        }

        return $this;
    }

    /**
     * @return d3ordermanagerlist
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     */
    public function d3GetOrderSaveTriggeredManagerTasks()
    {
        if ($this->d3GetSet()->isDemo() ||
            in_array(
                true,
                array_map(array($this->d3GetSet(),'getLicenseConfigData'),array(d3ordermanager_conf::SERIAL_BIT_STANDARD_EDITION))
            )
        ) {
            /** @var d3ordermanager $oListObject */
            $oListObject = $this->getBaseObject();
            $sFieldList = $oListObject->getSelectFields();
            $sQ = "select $sFieldList from " . $oListObject->getViewName();

            $sQ .= " where ";
            $sQ = $this->d3AddActiveSnippet($oListObject, $sQ, false, false);
            $sQ .= ' AND ' . $oListObject->getViewName() . '.D3_OM_ORDERSAVETRIGGERED = 1';
            $sQ .= " ORDER BY " . $oListObject->getViewName() . ".oxsort ASC, " . $oListObject->getViewName() . ".oxfolder ASC";
            $this->selectString($sQ);

            /** @var $oManager d3ordermanager */
            foreach ($this->getArray() as $sKey => $oManager) {
                if (false == $oManager->getLicenseActive()) {
                    $this->offsetUnset($sKey);
                }
            }
        }

        return $this;
    }

    /**
     * @return $this
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     */
    public function d3GetOrderFinishTriggeredManagerTasks()
    {
        if ($this->d3GetSet()->isDemo() ||
            in_array(
                true,
                array_map(array($this->d3GetSet(),'getLicenseConfigData'),array(d3ordermanager_conf::SERIAL_BIT_STANDARD_EDITION))
            )
        ) {
            /** @var d3ordermanager $oListObject */
            $oListObject = $this->getBaseObject();
            $sFieldList = $oListObject->getSelectFields();
            $sQ = "select $sFieldList from " . $oListObject->getViewName();

            $sQ .= " where ";
            $sQ = $this->d3AddActiveSnippet($oListObject, $sQ, false, false);
            $sQ .= ' AND ' . $oListObject->getViewName() . '.D3_OM_ORDERFINISHTRIGGERED = 1';
            $sQ .= " ORDER BY " . $oListObject->getViewName() . ".oxsort ASC, " . $oListObject->getViewName() . ".oxfolder ASC";
            $this->selectString($sQ);

            /** @var $oManager d3ordermanager */
            foreach ($this->getArray() as $sKey => $oManager) {
                if (false == $oManager->getLicenseActive()) {
                    $this->offsetUnset($sKey);
                }
            }
        }

        return $this;
    }

    /**
     * @param d3ordermanager $oManager
     *
     * @return bool
     * @throws DatabaseConnectionException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseErrorException
     * @throws StandardException
     */
    public function canExecutedManually(d3ordermanager $oManager)
    {
        return $oManager->getFieldData('D3_OM_EXECMANUALLY') &&
               $oManager->getLicenseActive();
    }

    /**
     * @param d3ordermanager $oListObject
     * @param                $sQ
     * @param bool $blManually
     * @param bool $blUseCommonActiveCheck (oxactive field)
     *
     * @return string
     * @throws DatabaseConnectionException
     * @throws Exception
     */
    public function d3AddActiveSnippet(d3ordermanager $oListObject, $sQ, $blManually = false, $blUseCommonActiveCheck = true)
    {
        $sActiveSnippet = $oListObject->getSqlActiveSnippet();

        /** @var d3utils $d3Utils */
        $d3Utils = d3GetModCfgDIC()->get(d3utils::class);

        if ($blUseCommonActiveCheck && $sActiveSnippet) {
            $sQ .= " $sActiveSnippet ";
        } else {
            $sQ .= " 1 ";
        }

        if ($blManually) {
            $sFieldName = $d3Utils->getMultiLangFieldName(
                'D3_OM_EXECMANUALLY',
                '',
                $oListObject
            );
        } else {
            $sFieldName = $d3Utils->getMultiLangFieldName(
                'oxactive',
                '',
                $oListObject
            );
        }

        $sQ .= " AND " . $oListObject->getViewName() . "." . $sFieldName . " = 1 ";

        return $sQ;
    }

    /**
     * @param               $sFolderId
     * @param d3ordermanager $oListObject
     * @param               $sQ
     *
     * @return string
     * @throws Exception
     */
    public function d3AddFolderSelection($sFolderId, d3ordermanager $oListObject, $sQ)
    {
        /** @var DatabaseInterface $oDb */
        $oDb = d3GetModCfgDIC()->get('d3ox.ordermanager.'.DatabaseInterface::class.'.num');

        if ($sFolderId && $sFolderId != '-1') {
            $sQ .= " AND " . $oListObject->getViewName() . ".oxfolder = " . $oDb->quote($sFolderId);
        }

        return $sQ;
    }

    /**
     * @param bool|string $iCronJobId
     */
    public function setCronJobId($iCronJobId)
    {
        /** @var d3ordermanager $oBaseObject */
        $oBaseObject = $this->getBaseObject();
        $oBaseObject->setCronJobIdFilter($iCronJobId);
    }

    /**
     * @return d3_cfg_mod
     * @throws Exception
     */
    public function d3GetSet()
    {
        return d3GetModCfgDIC()->get('d3.ordermanager.modcfg');
    }
}
