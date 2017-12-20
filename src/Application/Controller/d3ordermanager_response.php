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

use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_cronUnavailableException;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\d3ordermanager_execute;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Log\d3log;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Base;
use OxidEsales\Eshop\Core\Exception\StandardException;

class d3ordermanager_response extends Base
{
    private $_sModId = 'd3_ordermanager';

    public function init()
    {
        startProfile(__METHOD__);

        $blExceptionThrown = $this->_startExecution();

        if ($this->isBrowserCall() && false == $blExceptionThrown) {
            echo "script successfully finished".PHP_EOL;
        }

        Registry::getSession()->freeze();

        stopProfile(__METHOD__);

        $this->_getSet()->d3getLog()->d3GetProfiling();
    }

    /**
     * @return bool
     */
    protected function _startExecution()
    {
        startProfile(__METHOD__);

        $blExc = false;

        try {
            $iStartTime = microtime(true);
            $this->_getSet()->d3getLog()->log(d3log::INFO, __CLASS__, __FUNCTION__, __LINE__, "start cron", "");

            $this->_checkUnavailableCronjob();
            $this->_getSet()->setValue($this->_getCronTimestampVarName(), date('Y-m-d H:i:s'));
            $this->_getSet()->saveNoLicenseRefresh();

            $this->_startJobs();

            $iExecTime = microtime(true) - $iStartTime;
            $this->_getSet()->d3getLog()->log(
                d3log::INFO,
                __CLASS__,
                __FUNCTION__,
                __LINE__,
                "end cron",
                'execution time: '.$iExecTime." sec"
            );

        } catch (d3ordermanager_cronUnavailableException $oEx) {
            /** @var d3ordermanager_cronunavailableexception $oEx */
            $oEx->d3showMessage();
            $blExc = true;
        } catch (StandardException $oEx) {
            /** @var StandardException $oEx */
            $oEx->debugOut();
            $blExc = true;
        }

        stopProfile(__METHOD__);

        return $blExc;
    }

    protected function _startJobs()
    {
        startProfile(__METHOD__);

        /** @var $oManagerList d3OrdermanagerList */
        $oManagerList = oxNew(d3ordermanagerlist::class);
        $oManagerList->setCronJobId($this->_getCronJobIdParameter());
        $oManagerList->setCustomSorting('oxsort ASC');
        $oManagerList->getList();

        /** @var d3OrderManager $oHandleManager */
        $oHandleManager = oxNew(d3ordermanager::class);
        /** @var d3ordermanager_execute $oHandleManagerExec */
        $oHandleManagerExec = oxNew(d3ordermanager_execute::class, $oHandleManager);

        // disable admin mode for using active check
        $blOldAdminMode = self::$_blIsAdmin;
        self::$_blIsAdmin = false;

        $oHandleManager->d3getLog()->log(
            d3log::INFO,
            __CLASS__,
            __FUNCTION__,
            __LINE__,
            'manager count',
            $oManagerList->count()
        );

        /** @var $oManager d3ordermanager */
        foreach ($oManagerList->getList() as $oManager) {
            $oHandleManager = oxNew(d3ordermanager::class);
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
     * @return bool
     */
    protected function _checkAccessKey()
    {
        $sSetCronPassword = $this->_getSet()->getValue('sCronPassword');

        /** @var d3ordermanager $oManager */
        $oManager = oxNew(d3ordermanager::class);
        $sGetAccessKey  = Registry::get(Request::class)->getRequestEscapedParameter("key");
        $sRegisteredAccessKey = $sSetCronPassword ? $sSetCronPassword : $oManager->getBaseCronPW();

        if ($this->hasValidAccessKey($sRegisteredAccessKey, $sGetAccessKey)) {
            return false;
        }

        return true;
    }

    /**
     * @return d3_cfg_mod
     */
    protected function _getSet()
    {
        return d3_cfg_mod::get($this->_sModId);
    }

    /**
     * @return bool
     */
    public function showDisabledMessage()
    {
        return false == $this->_getSet()->getValue('blCronActive') &&
        ($this->_getSet()->hasDebugMode() || $this->isBrowserCall());
    }

    /**
     * @return bool
     */
    public function isBrowserCall()
    {
        return $_SERVER['REMOTE_ADDR'] || $_SERVER['HTTP_USER_AGENT'];
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
            $_SERVER['REMOTE_ADDR'] ||
            $_SERVER['HTTP_USER_AGENT']
        ) && $sRegisteredAccessKey != $sGetAccessKey;
    }

    /**
     * @throws d3ordermanager_cronunavailableexception
     */
    protected function _checkUnavailableCronjob()
    {
        if (false == $this->_getSet()->isActive()) {
            /** @var d3ordermanager_cronunavailableexception $oEx */
            $oEx = oxNew(d3ordermanager_cronunavailableexception::class, 'order manager module is disabled');
            $oEx->d3enableScreenMessage();
            $oEx->debugOut();
            throw $oEx;
        } elseif (false == $this->_checkAccessKey()) {
            /** @var d3ordermanager_cronunavailableexception $oEx */
            $oEx = oxNew(d3ordermanager_cronunavailableexception::class, 'cron via browser: missing or wrong identification');
            $oEx->d3enableScreenMessage();
            $oEx->debugOut();
            throw $oEx;
        } else {
            $this->_checkDisabledCronjob();
        }
    }

    /**
     * @throws d3ordermanager_cronunavailableexception
     */
    public function _checkDisabledCronjob()
    {
        if ($this->showDisabledMessage()) {
            /** @var d3ordermanager_cronunavailableexception $oEx */
            $oEx = oxNew(d3ordermanager_cronunavailableexception::class, 'cronjob script is disabled');
            $oEx->d3enableScreenMessage();
            $oEx->debugOut();
            throw $oEx;
        } elseif (false == $this->_getSet()->getValue('blCronActive')) {
            /** @var d3ordermanager_cronunavailableexception $oEx */
            $oEx = oxNew(d3ordermanager_cronunavailableexception::class, 'cron via browser: missing or wrong identification');
            $oEx->d3disableScreenMessage();
            $oEx->debugOut();
            throw $oEx;
        }
    }

    /**
     * @return string
     */
    protected function _getCronJobIdParameter()
    {
        $iCjId = Registry::get(Request::class)->getRequestEscapedParameter('cjid');

        if (false === $iCjId || null === $iCjId) {
            $iCjId = 0;
        }

        return $iCjId;
    }

    /**
     * @return string
     */
    protected function _getCronTimestampVarName()
    {
        $sVarName = "sCronExecTimestamp";

        if ($this->_getCronJobIdParameter() !== false) {
            $sVarName .= $this->_getCronJobIdParameter();
        }

        return $sVarName;
    }
}
