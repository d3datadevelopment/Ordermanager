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

namespace D3\Ordermanager\Application\Controller;

use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Model\Log\d3LogInterface;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_cronUnavailableException as cronUnavailableException;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\d3ordermanager_execute;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Log\d3log;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\DatabaseException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\Eshop\Core\Base;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Session;
use OxidEsales\EshopCommunity\Core\ShopControl;
use ReflectionClass;

class d3ordermanager_response extends Base
{
    private $_sModId = 'd3_ordermanager';

    /**
     * d3ordermanager_response constructor.
     */
    public function __construct()
    {
        d3GetModCfgDIC()->setParameter('d3.ordermanager.modcfgid', $this->_sModId);

        parent::__construct();
    }

    /**
     * @throws DBALException
     * @throws Exception
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
     * @return d3ordermanagerlist
     * @throws Exception
     */
    public function getManagerList()
    {
        return d3GetModCfgDIC()->get(d3ordermanagerlist::class);
    }

    /**
     * @param d3ordermanager $oManager
     * @return d3ordermanager_execute
     * @throws Exception
     */
    public function getManagerExecute(d3ordermanager $oManager)
    {
        d3GetModCfgDIC()->set(
            d3ordermanager_execute::class.'.args.ordermanager',
            $oManager
        );

        return d3GetModCfgDIC()->get(d3ordermanager_execute::class);
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws DatabaseException
     * @throws Exception
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

        /** @var $oManager d3ordermanager */
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
     * @return d3ordermanager
     * @throws Exception
     */
    public function getManager()
    {
        return d3GetModCfgDIC()->get(d3ordermanager::class);
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected function _checkAccessKey()
    {
        $sSetCronPassword = $this->_getSet()->getValue('sCronPassword');

        /** @var Request $request */
        $request = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Request::class);
        $sGetAccessKey  = $request->getRequestEscapedParameter("key");
        $sRegisteredAccessKey = $sSetCronPassword ? $sSetCronPassword : $this->getManager()->getBaseCronPW();

        return $this->hasValidAccessKey($sRegisteredAccessKey, $sGetAccessKey);
    }

    /**
     * @return d3_cfg_mod
     * @throws Exception
     */
    protected function _getSet()
    {
        return d3GetModCfgDIC()->get('d3.ordermanager.modcfg');
    }

    /**
     * @return bool
     */
    public function isBrowserCall()
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
    protected function hasValidAccessKey($sRegisteredAccessKey, $sGetAccessKey)
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
     * @throws Exception
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
     * @throws Exception
     */
    public function getCronUnavailableException($sMessage)
    {
        d3GetModCfgDIC()->setParameter(
            cronUnavailableException::class.'.args.message',
            $sMessage
        );

        return d3GetModCfgDIC()->get(cronUnavailableException::class);
    }

    /**
     * @return string
     * @throws Exception
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
     * @throws Exception
     */
    protected function _getCronTimestampVarName()
    {
        $sVarName = "sCronExecTimestamp";

        if ($this->_getCronJobIdParameter() !== false) {
            $sVarName .= $this->_getCronJobIdParameter();
        }

        return $sVarName;
    }

    /**
     * @throws Exception
     */
    public function getLastExecDate()
    {
        return $this->_getSet()->getValue($this->_getCronTimestampVarName());
    }

    /**
     * @throws Exception
     */
    public function getLastExecDateInfo()
    {
        $sCronJobId = $this->_getCronJobIdParameter();
        $taskCount = current(
            array_filter(
                $this->getManager()->getAvailableCronjobIds(),
                function($entry) use ($sCronJobId) {
                    return ($entry['id'] == $sCronJobId);
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
            )
        ];
    }

    /**
     * @return Language
     */
    public function getLang()
    {
        return Registry::getLang();
    }
}
