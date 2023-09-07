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

namespace D3\Ordermanager\Application\Model;

use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanagerlist as ManagerList;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Configuration\d3modprofilelist;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Query\QueryBuilder;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use Psr\Container\ContainerInterface;

class d3ordermanagerlist extends d3modprofilelist
{
    /**
     * List Object class name
     *
     * @var string
     */
    protected $_sObjectsInListName = Manager::class;

    /**
     * @param $sFolderId
     * @return ManagerList
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     */
    public function d3GetManuallyManagerJobsByFolder($sFolderId): d3ordermanagerlist
    {
        /** @var Manager $oListObject */
        $oListObject = $this->getBaseObject();
        $fieldList = array_map('trim', explode(',', $oListObject->getSelectFields()));

        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->getDIContainer()->get(QueryBuilderFactoryInterface::class)->create();
        $queryBuilder->select($fieldList)
            ->from($oListObject->getViewName())
            ->orderBy($oListObject->getViewName().".oxsort", "ASC")
            ->addOrderBy($oListObject->getViewName().".oxfolder", "ASC");

        $queryBuilder = $this->d3AddActiveSnippet($oListObject, $queryBuilder, true, false);
        $queryBuilder = $this->d3AddFolderSelection($sFolderId, $oListObject, $queryBuilder);

        $this->selectString($queryBuilder->getSQL(), $queryBuilder->getParameters());

        /** @var $oManager Manager */
        foreach ($this->getArray() as $sKey => $oManager) {
            if (false == $this->canExecutedManually($oManager)) {
                $this->offsetUnset($sKey);
            }
        }

        return $this;
    }

    /**
     * @return ManagerList
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     */
    public function d3GetOrderSaveTriggeredManagerTasks(): d3ordermanagerlist
    {
        if ($this->d3GetSet()->isDemo() ||
            in_array(
                true,
                array_map([$this->d3GetSet(),'getLicenseConfigData'], [d3ordermanager_conf::SERIAL_BIT_STANDARD_EDITION])
            )
        ) {
            /** @var Manager $oListObject */
            $oListObject = $this->getBaseObject();
            $fieldList = array_map('trim', explode(',', $oListObject->getSelectFields()));

            /** @var QueryBuilder $queryBuilder */
            $queryBuilder = $this->getDIContainer()->get(QueryBuilderFactoryInterface::class)->create();
            $queryBuilder->select($fieldList)
                ->from($oListObject->getViewName())
                ->where(
                    $queryBuilder->expr()->eq(
                        $oListObject->getViewName() . '.D3_OM_ORDERSAVETRIGGERED',
                        $queryBuilder->createNamedParameter(1)
                    )
                )
                ->orderBy($oListObject->getViewName() . ".oxsort", 'ASC')
                ->addOrderBy($oListObject->getViewName() . ".oxfolder", "ASC");

            $queryBuilder = $this->d3AddActiveSnippet($oListObject, $queryBuilder, false, false);

            $this->selectString($queryBuilder->getSQL(), $queryBuilder->getParameters());

            /** @var $oManager Manager */
            foreach ($this->getArray() as $sKey => $oManager) {
                if (false == $oManager->getLicenseActive()) {
                    $this->offsetUnset($sKey);
                }
            }
        }

        return $this;
    }

    /**
     * @return ManagerList
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     */
    public function d3GetOrderFinishTriggeredManagerTasks(): d3ordermanagerlist
    {
        if ($this->d3GetSet()->isDemo() ||
            in_array(
                true,
                array_map([$this->d3GetSet(),'getLicenseConfigData'], [d3ordermanager_conf::SERIAL_BIT_STANDARD_EDITION])
            )
        ) {
            /** @var Manager $oListObject */
            $oListObject = $this->getBaseObject();
            $fieldList = array_map('trim', explode(',', $oListObject->getSelectFields()));

            /** @var QueryBuilder $queryBuilder */
            $queryBuilder = $this->getDIContainer()->get(QueryBuilderFactoryInterface::class)->create();
            $queryBuilder->select($fieldList)
                ->from($oListObject->getViewName())
                ->where(
                    $queryBuilder->expr()->eq(
                        $oListObject->getViewName() . '.D3_OM_ORDERFINISHTRIGGERED',
                        $queryBuilder->createNamedParameter(1)
                    )
                )
                ->orderBy($oListObject->getViewName() . ".oxsort", 'ASC')
                ->addOrderBy($oListObject->getViewName() . ".oxfolder", 'ASC');

            $queryBuilder = $this->d3AddActiveSnippet($oListObject, $queryBuilder, false, false);

            $this->selectString($queryBuilder->getSQL(), $queryBuilder->getParameters());

            /** @var $oManager Manager */
            foreach ($this->getArray() as $sKey => $oManager) {
                if (false == $oManager->getLicenseActive()) {
                    $this->offsetUnset($sKey);
                }
            }
        }

        return $this;
    }

    /**
     * @param Manager $oManager
     *
     * @return bool
     * @throws DatabaseConnectionException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseErrorException
     * @throws StandardException
     */
    public function canExecutedByCron(Manager $oManager): bool
    {
        return $oManager->isActive() &&
               $oManager->getLicenseActive();
    }

    /**
     * @param Manager $oManager
     *
     * @return bool
     * @throws DatabaseConnectionException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseErrorException
     * @throws StandardException
     */
    public function canExecutedManually(Manager $oManager): bool
    {
        return $this->canExecutedByConfField($oManager, 'D3_OM_EXECMANUALLY');
    }

    /**
     * @param Manager $oManager
     *
     * @return bool
     * @throws DatabaseConnectionException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseErrorException
     * @throws StandardException
     */
    public function canExecutedOrderSaveTriggered(Manager $oManager): bool
    {
        return $this->canExecutedByConfField($oManager, 'D3_OM_ORDERSAVETRIGGERED');
    }

    /**
     * @param Manager $oManager
     *
     * @return bool
     * @throws DatabaseConnectionException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseErrorException
     * @throws StandardException
     */
    public function canExecutedOrderFinishTriggered(Manager $oManager): bool
    {
        return $this->canExecutedByConfField($oManager, 'D3_OM_ORDERFINISHTRIGGERED');
    }

    /**
     * @param Manager $oManager
     *
     * @return bool
     * @throws DatabaseConnectionException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseErrorException
     * @throws StandardException
     */
    protected function canExecutedByConfField(Manager $oManager, $fieldname): bool
    {
        return $oManager->getFieldData($fieldname) &&
               $oManager->getLicenseActive();
    }

    /**
     * @param Manager $oListObject
     * @param QueryBuilder   $queryBuilder
     * @param bool           $blManually
     * @param bool           $blUseCommonActiveCheck (oxactive field)
     *
     * @return QueryBuilder
     * @throws DatabaseConnectionException
     * @throws Exception
     */
    public function d3AddActiveSnippet(Manager $oListObject, QueryBuilder $queryBuilder, $blManually = false, $blUseCommonActiveCheck = true): QueryBuilder
    {
        $sActiveSnippet = $oListObject->getSqlActiveSnippet();

        if ($blUseCommonActiveCheck && $sActiveSnippet) {
            $queryBuilder->andWhere($sActiveSnippet);
        }

        if ($blManually) {
            $sFieldName = "D3_OM_EXECMANUALLY";
        } else {
            $sFieldName = "oxactive";
        }

        $queryBuilder->andWhere(
            $queryBuilder->expr()->eq(
                $oListObject->getViewName() . "." . $sFieldName,
                $queryBuilder->createNamedParameter(1, ParameterType::INTEGER)
            )
        );

        return $queryBuilder;
    }

    /**
     * @param                $sFolderId
     * @param Manager $oListObject
     * @param QueryBuilder   $queryBuilder
     *
     * @return QueryBuilder
     */
    public function d3AddFolderSelection($sFolderId, Manager $oListObject, QueryBuilder $queryBuilder): QueryBuilder
    {
        if ($sFolderId && $sFolderId != '-1') {
            $queryBuilder->andWhere(
                $queryBuilder->expr()->eq(
                    $oListObject->getViewName() . ".oxfolder",
                    $queryBuilder->createNamedParameter($sFolderId)
                )
            );
        }

        return $queryBuilder;
    }

    /**
     * @param bool|string $iCronJobId
     */
    public function setCronJobId($iCronJobId)
    {
        /** @var Manager $oBaseObject */
        $oBaseObject = $this->getBaseObject();
        $oBaseObject->setCronJobIdFilter($iCronJobId);
    }

    /**
     * return type can't defined, because of unmockable d3_cfg_mod class, use stdClass in test
     * @return d3_cfg_mod
     */
    public function d3GetSet()
    {
        /** @var d3_cfg_mod $set */
        $set = d3GetModCfgDIC()->get('d3.ordermanager.modcfg');
        return $set;
    }

    /**
     * @return ContainerInterface
     */
    public function getDIContainer(): ContainerInterface
    {
        return ContainerFactory::getInstance()->getContainer();
    }
}
