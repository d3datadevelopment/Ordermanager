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
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Model\Exception\wrongModIdException;
use D3\ModCfg\Application\Model\Log\d3LogInterface;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_execute as ManagerExecuteModel;
use D3\Ordermanager\Application\Model\d3ordermanager_vars as VariablesTrait;
use D3\Ordermanager\Application\Model\d3ordermanagerlist as ManagerList;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_cronUnavailableException as cronUnavailableException;
use DateTime;
use Doctrine\DBAL\Exception as DBALException;
use OxidEsales\Eshop\Core\Base;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\DatabaseException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use RuntimeException;

class d3ordermanager_response extends Base
{
    use VariablesTrait;
    private string $_sModId = 'd3_ordermanager';

    /**
     * constructor.
     */
    public function __construct()
    {
        $this->isCLI() or throw new RuntimeException('controller must called via command line interface');

        d3GetOxidDIC()->getParameter($this->_DIC_Instance_Id . 'modcfgid') === $this->_sModId or
        throw oxNew(wrongModIdException::class, $this->_sModId);

        parent::__construct();
    }

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

        /** @var d3LogInterface $oLog */
        $oLog = d3GetOxidDIC()->get('d3.ordermanager.log');
        $oLog->info(self::class, __FUNCTION__, __LINE__, "start cron", "");

        $this->_checkUnavailableCronjob();
        $this->_getSet()->setValue($this->_getCronTimestampVarName(), (new DateTime())->format('Y-m-d H:i:s'));
        $this->_getSet()->saveNoLicenseRefresh();

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

    public function getManagerList(): ManagerList
    {
        /** @var ManagerList $managerList */
        $managerList = d3GetOxidDIC()->get(ManagerList::class);

        return $managerList;
    }

    public function getManagerExecute(Manager $oManager): ManagerExecuteModel
    {
        d3GetOxidDIC()->set(
            ManagerExecuteModel::class.'.args.ordermanager',
            $oManager
        );

        /** @var ManagerExecuteModel $manager_execute */
        $manager_execute = d3GetOxidDIC()->get(ManagerExecuteModel::class);

        return $manager_execute;
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
        $blOldAdminMode = self::$_blIsAdmin;
        self::$_blIsAdmin = false;

        /** @var d3LogInterface $oLog */
        $oLog = d3GetOxidDIC()->get('d3.ordermanager.log');
        $oLog->info(
            self::class,
            __FUNCTION__,
            __LINE__,
            'manager count',
            $oManagerList->count()
        );

        /** @var $oManager Manager */
        foreach ($oManagerList->getList() as $oManager) {
            $oHandleManager = $this->getManager();
            $oHandleManager->setLanguage(Registry::getLang()->getTplLanguage());
            $oHandleManager->load($oManager->getId());
            $oHandleManagerExec->setManager($oHandleManager);

            self::$_blIsAdmin = $blOldAdminMode;
            $oHandleManagerExec->startJobExecution();
            self::$_blIsAdmin = false;
        }

        self::$_blIsAdmin = $blOldAdminMode;
        $oHandleManagerExec->finishJobExecution();

        stopProfile(__METHOD__);
    }

    public function getManager(): Manager
    {
        /** @var Manager $manager */
        $manager = d3GetOxidDIC()->get(Manager::class);

        return $manager;
    }

    protected function _checkAccessKey(): bool
    {
        $sSetCronPassword = $this->_getSet()->getValue('sCronPassword');

        /** @var Request $request */
        $request = d3GetOxidDIC()->get('d3ox.ordermanager.'.Request::class);
        $sGetAccessKey  = $request->getRequestEscapedParameter("key");
        $sRegisteredAccessKey = $sSetCronPassword ?: $this->getManager()->getBaseCronPW();

        return $this->hasValidAccessKey($sRegisteredAccessKey, $sGetAccessKey);
    }

    /**
     * return type can't be defined, because of unmockable d3_cfg_mod class, use stdClass in test
     * @return d3_cfg_mod
     */
    protected function _getSet()
    {
        /** @var d3_cfg_mod $modcfg */
        $modcfg = d3GetOxidDIC()->get('d3.ordermanager.modcfg');

        return $modcfg;
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
        if (false == $this->isBrowserCall()) {
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
        $this->_getSet()->isActive() or throw $this->getCronUnavailableException(
                $this->getLang()->translateString('D3_ORDERMANAGER_EXC_CRON_MODULEDISABLED')
            );

        $this->_checkAccessKey() or throw $this->getCronUnavailableException(
                $this->getLang()->translateString('D3_ORDERMANAGER_EXC_CRON_WRONGPASSWORD')
            );

        $this->_getSet()->getValue('blCronActive') or throw $this->getCronUnavailableException(
                $this->getLang()->translateString('D3_ORDERMANAGER_EXC_CRON_UNAVAILABLE')
            );
    }

    /**
     * @param $sMessage
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
        /** @var Request $request */
        $request = d3GetOxidDIC()->get('d3ox.ordermanager.'.Request::class);
        $iCjId = $request->getRequestEscapedParameter('cjid');

        try {
            Assert::that( $iCjId )->notBlank();
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
        return (string) $this->_getSet()->getValue($this->_getCronTimestampVarName());
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     */
    public function getLastExecDateInfo(): array
    {
        $sCronJobId = $this->_getCronJobIdParameter();
        $taskCount = current(
            array_filter(
                $this->getManager()->getAvailableCronjobIds(),
                static fn ($entry): bool => $entry['id'] == $sCronJobId
            )
        )['count'];

        return [
            sprintf(
                $this->getLang()->translateString('D3_GENERAL_ORDERMANAGER_TASKCOUNT_CRONID'),
                $sCronJobId,
                $taskCount
            ),
            sprintf(
                $this->getLang()->translateString('D3_GENERAL_ORDERMANAGER_LASTEXEC_CRONID'),
                $sCronJobId,
                $this->getLastExecDate()
            ),
        ];
    }

    public function getLang(): Language
    {
        /** @var Language $lang */
        $lang = d3GetOxidDIC()->get('d3ox.ordermanager.'.Language::class);

        return $lang;
    }
}
