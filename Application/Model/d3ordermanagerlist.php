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

namespace D3\Ordermanager\Application\Model;

use Assert\Assert;
use Assert\InvalidArgumentException;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanagerlist as ManagerList;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Configuration\d3modprofilelist;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use DateTime;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Query\QueryBuilder;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

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
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws Exception
     */
    public function d3GetManuallyManagerJobsByFolder($sFolderId): ManagerList
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

        /** @var Manager $oManager */
        foreach ($this->getArray() as $sKey => $oManager) {
            if (false == $this->canExecutedManually($oManager)) {
                $this->offsetUnset($sKey);
            }
        }

        return $this;
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
    public function d3GetOrderSaveTriggeredManagerTasks(): ManagerList
    {
        if ($this->d3GetSet()->isDemo() ||
            in_array(
                true,
                array_map(fn (string|int $mConfigKey, $mDefaultValue = null): bool => $this->d3GetSet()->getLicenseConfigData($mConfigKey, $mDefaultValue), [d3ordermanager_conf::SERIAL_BIT_STANDARD_EDITION])
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

            /** @var Manager $oManager */
            foreach ($this->getArray() as $sKey => $oManager) {
                if (false == $oManager->getLicenseActive()) {
                    $this->offsetUnset($sKey);
                }
            }
        }

        return $this;
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
    public function d3GetOrderFinishTriggeredManagerTasks(): ManagerList
    {
        if ($this->d3GetSet()->isDemo() ||
            in_array(
                true,
                array_map(fn (string|int $mConfigKey, $mDefaultValue = null): bool => $this->d3GetSet()->getLicenseConfigData($mConfigKey, $mDefaultValue), [d3ordermanager_conf::SERIAL_BIT_STANDARD_EDITION])
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

            /** @var Manager $oManager */
            foreach ($this->getArray() as $sKey => $oManager) {
                if (false == $oManager->getLicenseActive()) {
                    $this->offsetUnset($sKey);
                }
            }
        }

        return $this;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws NotFoundExceptionInterface
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function d3GetCustomManagerTasks(string $eventName): self
    {
        if ($this->d3GetSet()->isDemo() ||
            in_array(
                true,
                array_map(
                    fn (string|int $mConfigKey, $mDefaultValue = null): bool => $this->d3GetSet()->getLicenseConfigData($mConfigKey, $mDefaultValue),
                    [d3ordermanager_conf::SERIAL_BIT_PREMIUM_EDITION]
                )
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
                     $queryBuilder->expr()->and(
                         $queryBuilder->expr()->eq(
                             $oListObject->getViewName() . '.D3_OM_EVENTTRIGGERED',
                             $queryBuilder->createNamedParameter(1)
                         ),
                         $queryBuilder->expr()->eq(
                             $oListObject->getViewName() . '.D3_EVENTID',
                             $queryBuilder->createNamedParameter($eventName)
                         )
                     )
                 )
                 ->orderBy($oListObject->getViewName() . ".oxsort", 'ASC')
                 ->addOrderBy($oListObject->getViewName() . ".oxfolder", 'ASC');

            $this->selectString($queryBuilder->getSQL(), $queryBuilder->getParameters());

            Assert::that($this->count())->greaterThan(0, 'No custom manager tasks found for event: ' . $eventName);

            /** @var Manager $oManager */
            foreach ($this->getArray() as $sKey => $oManager) {
                if (!$oManager->getLicenseActive()) {
                    $this->offsetUnset($sKey);
                }
            }
        }

        return $this;
    }

    /**
     *
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
     *
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
     *
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
     *
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
     *
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
     * @param bool           $blManually
     * @param bool           $blUseCommonActiveCheck (oxactive field)
     * @throws DatabaseConnectionException
     * @throws Exception
     */
    public function d3AddActiveSnippet(Manager $oListObject, QueryBuilder $queryBuilder, $blManually = false, $blUseCommonActiveCheck = true): QueryBuilder
    {
        $sActiveSnippet = $oListObject->getSqlActiveSnippet();

        if ($blUseCommonActiveCheck && $sActiveSnippet) {
            $queryBuilder->andWhere($sActiveSnippet);
        }

        $sFieldName = $blManually ? "D3_OM_EXECMANUALLY" : "oxactive";

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
     *
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
     * @param bool|int $iCronJobId
     */
    public function setCronJobId($iCronJobId): void
    {
        /** @var Manager $oBaseObject */
        $oBaseObject = $this->getBaseObject();
        $oBaseObject->setCronJobIdFilter($iCronJobId);
    }

    /**
     * @return array
     * @throws ContainerExceptionInterface
     * @throws DBALException
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws NotFoundExceptionInterface
     */
    public function getAffectedItemsCount(): array
    {
        /** @var QueryBuilder $currRangeQueryBuilder */
        $currRangeQueryBuilder = $this->getDIContainer()->get(QueryBuilderFactoryInterface::class)->create();
        $currRangeQueryBuilder->select(
            'd3modprofile.OXTITLE',
            'count(d3order2ordermanager.oxexecdate) as edited',
            'd3modprofile.oxid'
        )
            ->from($this->getBaseObject()->getViewName(), 'd3modprofile')
            ->leftJoin(
                'd3modprofile',
                'd3order2ordermanager',
                'd3order2ordermanager',
                $currRangeQueryBuilder->expr()->and(
                    $currRangeQueryBuilder->expr()->eq(
                        'd3modprofile.oxid',
                        'd3order2ordermanager.OXORDERMANAGERID'
                    ),
                    $currRangeQueryBuilder->expr()->eq(
                        'DATE_FORMAT(d3order2ordermanager.oxexecdate, "%Y%m")',
                        'DATE_FORMAT(LAST_DAY(NOW() - INTERVAL 1 MONTH), "%Y%m")'
                    )
                )
            )
            ->where(
                $currRangeQueryBuilder->expr()->and(
                    $currRangeQueryBuilder->expr()->eq(
                        'd3modprofile.OXMODID',
                        '"d3_ordermanager"'
                    ),
                    $currRangeQueryBuilder->expr()->eq(
                        'd3modprofile.OXACTIVE',
                        1
                    )
                )
            )
            ->groupBy('d3modprofile.oxid', 'DATE_FORMAT(d3order2ordermanager.OXEXECDATE, "%Y%m")');

        /** @var QueryBuilder $beforeRangeQueryBuilder */
        $beforeRangeQueryBuilder = $this->getDIContainer()->get(QueryBuilderFactoryInterface::class)->create();
        $beforeRangeQueryBuilder->select(
            'd3modprofile.OXTITLE',
            'count(d3order2ordermanager.oxexecdate) as edited',
            'd3modprofile.oxid'
        )
            ->from($this->getBaseObject()->getViewName(), 'd3modprofile')
            ->leftJoin(
                'd3modprofile',
                'd3order2ordermanager',
                'd3order2ordermanager',
                $beforeRangeQueryBuilder->expr()->and(
                    $beforeRangeQueryBuilder->expr()->eq(
                        'd3modprofile.oxid',
                        'd3order2ordermanager.OXORDERMANAGERID'
                    ),
                    $beforeRangeQueryBuilder->expr()->eq(
                        'DATE_FORMAT(d3order2ordermanager.oxexecdate, "%Y%m")',
                        'DATE_FORMAT(LAST_DAY(NOW() - INTERVAL 2 MONTH), "%Y%m")'
                    )
                )
            )
            ->where(
                $beforeRangeQueryBuilder->expr()->and(
                    $beforeRangeQueryBuilder->expr()->eq(
                        'd3modprofile.OXMODID',
                        '"d3_ordermanager"'
                    ),
                    $beforeRangeQueryBuilder->expr()->eq(
                        'd3modprofile.OXACTIVE',
                        1
                    )
                )
            )
            ->groupBy('d3modprofile.oxid', 'DATE_FORMAT(d3order2ordermanager.OXEXECDATE, "%Y%m")');

        /** @var QueryBuilder $statisticQueryBuilder */
        $statisticQueryBuilder = $this->getDIContainer()->get(QueryBuilderFactoryInterface::class)->create();
        $statisticQueryBuilder->select(
            'IF(LENGTH(current.oxtitle), current.oxtitle, current.oxid) as "'.Registry::getLang()->translateString('D3_ORDERMANAGER_CRON_STAT_TASK').'"',
            '"'.Registry::getLang()->translateString('D3_ORDERMANAGER_CRON_STAT_NOT_YET_EXECUTED').'" as "'.Registry::getLang()->translateString('D3_ORDERMANAGER_CRON_STAT_LASTEXECTIME').'"',
            'last.edited as "'.sprintf(
                Registry::getLang()->translateString('D3_ORDERMANAGER_CRON_STAT_ORDERSFROM'),
                date("Y-m", strtotime("- 2 month"))
            ).'"',
            'current.edited as "'.sprintf(
                Registry::getLang()->translateString('D3_ORDERMANAGER_CRON_STAT_ORDERSFROM'),
                date("Y-m", strtotime("- 1 month"))
            ).'"',
            'if (last.edited = 0, "'.Registry::getLang()->translateString('D3_ORDERMANAGER_CRON_STAT_CHANGES_NEW').'", concat(CONVERT((((current.edited - last.edited) / last.edited)*100), SIGNED), " %")) as "'.Registry::getLang()->translateString('D3_ORDERMANAGER_CRON_STAT_CHANGES').'"',
            'current.oxid as "'.Registry::getLang()->translateString('D3_ORDERMANAGER_CRON_STAT_ID').'"'
        )
            ->from(
                '('.$currRangeQueryBuilder->getSQL().')',
                'current'
            )
            ->leftJoin(
                'current',
                "(".$beforeRangeQueryBuilder->getSQL().")",
                'last',
                $statisticQueryBuilder->expr()->eq(
                    'current.oxid',
                    'last.oxid'
                )
            );

        $taskList = $statisticQueryBuilder->execute()->fetchAllAssociative();

        foreach ($taskList as $id => $task) {
            $manager = clone $this->getBaseObject();
            $manager->load($task[Registry::getLang()->translateString('D3_ORDERMANAGER_CRON_STAT_ID')]);
            try {
                Assert::that($manager->getValue('iLastExecDate'))
                    ->integerish();
                $lastExecDate = (new DateTime())->setTimestamp($manager->getValue('iLastExecDate'))
                        ->format(Registry::getLang()->translateString('fullDateFormat'));
                $taskList[$id][Registry::getLang()->translateString('D3_ORDERMANAGER_CRON_STAT_LASTEXECTIME')] = $lastExecDate;
            } catch (InvalidArgumentException) {
            }
        }

        return $taskList;
    }

    /**
     * return type can't be defined, because of unmockable d3_cfg_mod class, use stdClass in test
     * @return d3_cfg_mod
     */
    public function d3GetSet()
    {
        /** @var d3_cfg_mod $set */
        $set = d3GetOxidDIC()->get('d3.ordermanager.modcfg');
        return $set;
    }

    public function getDIContainer(): ContainerInterface
    {
        return ContainerFactory::getInstance()->getContainer();
    }
}
