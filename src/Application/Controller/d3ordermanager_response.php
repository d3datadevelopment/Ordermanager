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

namespace D3\Ordermanager\Application\Controller;

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Model\Exception\wrongModIdException;
use D3\ModCfg\Application\Model\Log\d3LogInterface;
use D3\ModCfg\Application\Model\Log\d3log;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_execute as ManagerExecuteModel;
use D3\Ordermanager\Application\Model\d3ordermanager_vars as VariablesTrait;
use D3\Ordermanager\Application\Model\d3ordermanagerlist as ManagerList;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_cronUnavailableException as cronUnavailableException;
use Doctrine\DBAL\DBALException;
use OxidEsales\Eshop\Core\Base;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\DatabaseException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\Eshop\Core\Session;
use OxidEsales\EshopCommunity\Core\ShopControl;
use ReflectionClass;

class d3ordermanager_response extends Base
{
    use VariablesTrait;
    private $_sModId = 'd3_ordermanager';

    /**
     * constructor.
     */
    public function __construct()
    {
        if (d3GetModCfgDIC()->getParameter($this->_DIC_Instance_Id . 'modcfgid') !== $this->_sModId) {
            throw oxNew(wrongModIdException::class, $this->_sModId);
        }

        parent::__construct();
    }

    /**
     * @throws DBALException
     */
    public function init()
    {
        startProfile(__METHOD__);

        try {
            /** @var Language $lang */
            $lang = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);
            if (false === $this->isBrowserCall()) {
                echo $lang->translateString('D3_ORDERMANAGER_CLI_DEPRECATED').PHP_EOL;
            }

            $this->_startExecution();

            if ($this->isBrowserCall()) {
                echo $lang->translateString('D3_ORDERMANAGER_CLI_FINISHED_SUCCESSFULLY').'<br><br>';
            }
        } catch (cronUnavailableException $oEx) {
            /** @var cronUnavailableException $oEx */
            $oEx->d3showMessage();
        } catch (StandardException $oEx) {
            /** @var StandardException $oEx */
            $logger = Registry::getLogger();
            $logger->error($oEx);
            $oEx->debugOut();
            echo $oEx->getMessage().PHP_EOL;
        } finally {
            /** @var Session $session */
            $session = d3GetModCfgDIC()->get('d3ox.ordermanager.' . Session::class);
            $session->freeze();

            stopProfile(__METHOD__);

            /** @var d3log $oLog */
            $oLog = d3GetModCfgDIC()->get('d3.ordermanager.log');
            $oLog->d3GetProfiling();
        }

        $shopControl = oxNew(ShopControl::class);
        d3GetModCfgDIC()->set(ReflectionClass::class.'.args.object', $shopControl);
        /** @var ReflectionClass $shopControlReflection */
        $shopControlReflection = d3GetModCfgDIC()->get(ReflectionClass::class);
        $method = $shopControlReflection->getMethod('_getFormattedErrors');
        $method->setAccessible(true);
        $errors = $method->invokeArgs($shopControl, [Registry::getConfig()->getActiveView()->getClassKey()]);

        if (isset($errors['default'])) {
            echo $lang->translateString('D3_ORDERMANAGER_CLI_FINISHED_ERRORS')."<br><br>";
            foreach ($errors['default'] as $error) {
                echo $error . "<br>";
            }
        }
    }

    public function initCli()
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
        $oLog = d3GetModCfgDIC()->get('d3.ordermanager.log');
        $oLog->info(__CLASS__, __FUNCTION__, __LINE__, "start cron", "");

        $this->_checkUnavailableCronjob();
        $this->_getSet()->setValue($this->_getCronTimestampVarName(), date('Y-m-d H:i:s'));
        $this->_getSet()->saveNoLicenseRefresh();

        $this->_startJobs();

        $iExecTime = microtime(true) - $iStartTime;
        $oLog->info(
            __CLASS__,
            __FUNCTION__,
            __LINE__,
            "end cron",
            'execution time: '.$iExecTime." sec"
        );

        stopProfile(__METHOD__);
    }

    /**
     * @return ManagerList
     */
    public function getManagerList(): ManagerList
    {
        /** @var ManagerList $managerList */
        $managerList = d3GetModCfgDIC()->get(ManagerList::class);

        return $managerList;
    }

    /**
     * @param Manager $oManager
     * @return ManagerExecuteModel
     */
    public function getManagerExecute(Manager $oManager): ManagerExecuteModel
    {
        d3GetModCfgDIC()->set(
            ManagerExecuteModel::class.'.args.ordermanager',
            $oManager
        );

        /** @var ManagerExecuteModel $manager_execute */
        $manager_execute = d3GetModCfgDIC()->get(ManagerExecuteModel::class);

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
        $oLog = d3GetModCfgDIC()->get('d3.ordermanager.log');
        $oLog->info(
            __CLASS__,
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

    /**
     * @return Manager
     */
    public function getManager(): Manager
    {
        /** @var Manager $manager */
        $manager = d3GetModCfgDIC()->get(Manager::class);

        return $manager;
    }

    /**
     * @return bool
     */
    protected function _checkAccessKey(): bool
    {
        $sSetCronPassword = $this->_getSet()->getValue('sCronPassword');

        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $sGetAccessKey  = $request->getRequestEscapedParameter("key");
        $sRegisteredAccessKey = $sSetCronPassword ?: $this->getManager()->getBaseCronPW();

        return $this->hasValidAccessKey($sRegisteredAccessKey, $sGetAccessKey);
    }

    /**
     * return type can't defined, because of unmockable d3_cfg_mod class, use stdClass in test
     * @return d3_cfg_mod
     */
    protected function _getSet()
    {
        /** @var d3_cfg_mod $modcfg */
        $modcfg = d3GetModCfgDIC()->get('d3.ordermanager.modcfg');

        return $modcfg;
    }

    /**
     * @return bool
     */
    public function isBrowserCall(): bool
    {
        return (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']) ||
            (isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * @param $sRegisteredAccessKey
     * @param $sGetAccessKey
     *
     * @return bool
     */
    protected function hasValidAccessKey($sRegisteredAccessKey, $sGetAccessKey): bool
    {
        return (
            false == $this->isBrowserCall()
            || (
                $sRegisteredAccessKey == $sGetAccessKey
            )
        );
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
        if (false == $this->_getSet()->isActive()) {
            throw $this->getCronUnavailableException(
                $this->getLang()->translateString('D3_ORDERMANAGER_EXC_CRON_MODULEDISABLED')
            );
        } elseif (false == $this->_checkAccessKey()) {
            throw $this->getCronUnavailableException(
                $this->getLang()->translateString('D3_ORDERMANAGER_EXC_CRON_WRONGPASSWORD')
            );
        } elseif (false == $this->_getSet()->getValue('blCronActive')) {
            throw $this->getCronUnavailableException(
                $this->getLang()->translateString('D3_ORDERMANAGER_EXC_CRON_UNAVAILABLE')
            );
        }
    }

    /**
     * @param $sMessage
     * @return cronUnavailableException
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
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $iCjId = $request->getRequestEscapedParameter('cjid');

        if (false === $iCjId || null === $iCjId || $iCjId === '') {
            $iCjId = 0;
        }

        return $iCjId;
    }

    /**
     * @return string
     */
    protected function _getCronTimestampVarName(): string
    {
        return "sCronExecTimestamp".$this->_getCronJobIdParameter();
    }

    public function getLastExecDate(): string
    {
        return $this->_getSet()->getValue($this->_getCronTimestampVarName());
    }

    /**
     * @return array
     * @throws DBALException
     * @throws DatabaseConnectionException
     */
    public function getLastExecDateInfo(): array
    {
        $sCronJobId = $this->_getCronJobIdParameter();
        $taskCount = current(
            array_filter(
                $this->getManager()->getAvailableCronjobIds(),
                function ($entry) use ($sCronJobId) {
                    return $entry['id'] == $sCronJobId;
                }
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

    /**
     * @return Language
     */
    public function getLang(): Language
    {
        /** @var Language $lang */
        $lang = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);

        return $lang;
    }
}
