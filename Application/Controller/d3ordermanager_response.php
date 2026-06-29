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

namespace D3\Ordermanager\Application\Controller;

use Assert\Assert;
use Assert\InvalidArgumentException;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_execute as ManagerExecuteModel;
use D3\Ordermanager\Application\Model\d3ordermanagerlist as ManagerList;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_cronUnavailableException as cronUnavailableException;
use D3\Ordermanager\Core\ModCfgTrait;
use D3\Ordermanager\Core\Registry as ManagerRegistry;
use DateTime;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\Exception as DBALException;
use OxidEsales\Eshop\Core\Base;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\DatabaseException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;

class d3ordermanager_response extends Base
{
    use ModCfgTrait;

    public function isCLI(): bool
    {
        return str_starts_with(PHP_SAPI, 'cli');
    }

    public function initCli(): void
    {
        startProfile(__METHOD__);

        $this->_startExecution();

        stopProfile(__METHOD__);
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws DatabaseException
     * @throws StandardException
     * @throws cronUnavailableException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    protected function _startExecution()
    {
        startProfile(__METHOD__);

        $iStartTime = microtime(true);

        $oLog = $this->d3GetOrderManagerLog();
        $oLog->info(self::class, __FUNCTION__, __LINE__, "start cron", "");

        $this->_checkUnavailableCronjob();
        $this->d3GetOrderManagerConfig()->setValue($this->_getCronTimestampVarName(), (new DateTime())->format('Y-m-d H:i:s'));
        $this->d3GetOrderManagerConfig()->saveNoLicenseRefresh();

        $this->_startJobs();

        $iExecTime = microtime(true) - $iStartTime;
        $oLog->info(
            self::class,
            __FUNCTION__,
            __LINE__,
            "end cron",
            'execution time: '.$iExecTime." sec"
        );

        stopProfile(__METHOD__);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getManagerList(): ManagerList
    {
        return oxNew(ManagerList::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getManagerExecute(Manager $oManager): ManagerExecuteModel
    {
        return oxNew(ManagerExecuteModel::class, $oManager);
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws DatabaseException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    protected function _startJobs()
    {
        startProfile(__METHOD__);

        $oManagerList = $this->getManagerList();
        $oManagerList->setCronJobId($this->_getCronJobIdParameter());
        $oManagerList->setCustomSorting('oxsort ASC');
        $oManagerList->getList();

        $oHandleManager = $this->getManager();
        $oHandleManagerExec = $this->getManagerExecute($oHandleManager);

        // disable admin mode for using active check
        $blOldAdminMode = $this->setAdminContext(false);

        $oLog = $this->d3GetOrderManagerLog();
        $oLog->info(
            self::class,
            __FUNCTION__,
            __LINE__,
            'manager count',
            $oManagerList->count()
        );
        ManagerRegistry::getLogger()->debug('task list', [ 'count' => $oManagerList->count()]);

        /** @var $oManager Manager */
        foreach ($oManagerList->getList() as $oManager) {
            $this->resetLogHandlers();
            $oHandleManager = $this->getManager();
            $oHandleManager->setLanguage(Registry::getLang()->getTplLanguage());
            $oHandleManager->load($oManager->getId());
            $oHandleManagerExec->setManager($oHandleManager);

            $this->setAdminContext($blOldAdminMode);
            ManagerRegistry::getLogger()->info('execute task', [ 'status' => 'started', 'id' => $oManager->getId(), 'name' => $oManager->getFieldData('oxtitle')]);
            $oHandleManagerExec->startJobExecution();
            ManagerRegistry::getLogger()->info('execute task', [ 'status' => 'finished', 'id' => $oManager->getId(), 'name' => $oManager->getFieldData('oxtitle')]);
            $this->setAdminContext(false);
        }

        $this->resetLogHandlers();
        $this->setAdminContext($blOldAdminMode);
        $oHandleManagerExec->finishJobExecution();

        stopProfile(__METHOD__);
    }

    protected function setAdminContext(bool $blAdmin): bool
    {
        $config = Registry::getConfig();
        $isAdmin = $config->isAdmin();

        if ($isAdmin !== $blAdmin) {
            $config->setAdminMode($blAdmin);

            $refClass = new ReflectionClass(ContainerFactory::class);

            $instanceProp = $refClass->getProperty('instance');
            $instanceProp->setAccessible(true);
            $instanceProp->setValue(null, null);
        }

        return $isAdmin;
    }

    /**
     * if OnErrorOnly handler is used, prevent writing data from former iterations in error case
     * @return void
     * @throws \Exception
     */
    protected function resetLogHandlers(): void
    {
        foreach (ManagerRegistry::getLogger()->getHandlers() as $handler) {
            $handler->reset();
        }
    }

    public function getManager(): Manager
    {
        $manager = oxNew(Manager::class);
        $manager->setLanguage(Registry::getLang()->getTplLanguage());
        return $manager;
    }

    protected function _checkAccessKey(): bool
    {
        $sSetCronPassword = $this->d3GetOrderManagerConfig()->getValue('sCronPassword');

        $sGetAccessKey  = Registry::getRequest()->getRequestEscapedParameter("key");
        $sRegisteredAccessKey = $sSetCronPassword ?: $this->getManager()->getBaseCronPW();

        return $this->hasValidAccessKey($sRegisteredAccessKey, $sGetAccessKey);
    }

    public function isBrowserCall(): bool
    {
        return (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']) ||
            (isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * @param $sRegisteredAccessKey
     * @param $sGetAccessKey
     */
    protected function hasValidAccessKey($sRegisteredAccessKey, $sGetAccessKey): bool
    {
        if (!$this->isBrowserCall()) {
            return true;
        }

        return $sRegisteredAccessKey == $sGetAccessKey;
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws cronUnavailableException
     */
    protected function _checkUnavailableCronjob()
    {
        $this->d3GetOrderManagerConfig()->isActive() or throw $this->getCronUnavailableException(
            Registry::getLang()->translateString('D3_ORDERMANAGER_EXC_CRON_MODULEDISABLED')
        );

        $this->_checkAccessKey() or throw $this->getCronUnavailableException(
            Registry::getLang()->translateString('D3_ORDERMANAGER_EXC_CRON_WRONGPASSWORD')
        );

        $this->d3GetOrderManagerConfig()->getValue('blCronActive') or throw $this->getCronUnavailableException(
            Registry::getLang()->translateString('D3_ORDERMANAGER_EXC_CRON_UNAVAILABLE')
        );
    }

    /**
     * @codeCoverageIgnore
     */
    public function getCronUnavailableException($sMessage): cronUnavailableException
    {
        return oxNew(cronUnavailableException::class, $sMessage);
    }

    /**
     * @return string|int
     */
    protected function _getCronJobIdParameter()
    {
        $iCjId = Registry::getRequest()->getRequestEscapedParameter('cjid');

        try {
            Assert::that($iCjId)->notBlank();
        } catch (InvalidArgumentException) {
            return 0;
        }

        return $iCjId;
    }

    protected function _getCronTimestampVarName(): string
    {
        return "sCronExecTimestamp".$this->_getCronJobIdParameter();
    }

    public function getLastExecDate(): string
    {
        return
            ($ts = $this->d3GetOrderManagerConfig()->getValue($this->_getCronTimestampVarName())) ?
                DateTime::createFromFormat('Y-m-d H:i:s', $ts)
                        ->format(Registry::getLang()->translateString('fullDateFormat')) :
                '';
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     */
    public function getLastExecDateInfo(): array
    {
        $sCronJobId = $this->_getCronJobIdParameter();
        $task = current(
            array_filter(
                $this->getManager()->getAvailableCronjobIds(),
                static fn ($entry): bool => $entry['id'] == $sCronJobId
            )
        );
        $taskCount = $task ? $task['count'] : 0;

        return [
            sprintf(
                Registry::getLang()->translateString('D3_GENERAL_ORDERMANAGER_TASKCOUNT_CRONID'),
                $sCronJobId,
                $taskCount ?? 0
            ),
            sprintf(
                Registry::getLang()->translateString('D3_GENERAL_ORDERMANAGER_LASTEXEC_CRONID'),
                $sCronJobId,
                $this->getLastExecDate()
            ),
        ];
    }

    /**
     * @return array
     * @throws DBALException
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getStatistic(): array
    {
        return $this->getManagerList()->getAffectedItemsCount();
    }
}
