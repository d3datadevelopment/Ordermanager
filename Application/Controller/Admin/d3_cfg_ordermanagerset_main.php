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

use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_main;
use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Model\Filegenerator\d3filegeneratorcronsh;
use D3\ModCfg\Application\Model\Shopcompatibility\d3ShopCompatibilityAdapterHandler;
use D3\Ordermanager\Application\Model\Constants;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use OxidEsales\Eshop\Application\Model\Shop;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\ViewConfig;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class d3_cfg_ordermanagerset_main extends d3_cfg_mod_main
{
    protected $_sModId = 'd3_ordermanager';

    protected $_sThisTemplate = '@'. Constants::OXID_MODULE_ID .'/admin/d3_cfg_ordermanagerset_main';

    protected $_blHasDebugSwitch = false;

    protected $_blHasTestModeSwitch = true;

    protected $_sTestModeHelpTextIdent = 'D3_ORDERMANAGER_SET_DEBUG_DESC';

    protected $_sMenuItemTitle = 'd3mxordermanager';

    protected $_sMenuSubItemTitle = 'd3mxordermanager_settings';

    /**
     * @codeCoverageIgnore
     */
    public function getManager(): Manager
    {
        return oxNew(Manager::class);
    }

    /**
     * get basic cronjob access password; for cases only, if no password is set
     */
    public function getBaseCronPW(): string
    {
        return $this->getManager()->getBaseCronPW();
    }

    /**
     * @codeCoverageIgnore
     */
    public function getViewConfig(): ViewConfig
    {
        if ($this->_oViewConf === null) {
            $this->_oViewConf = oxNew(ViewConfig::class);
        }

        return $this->_oViewConf;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getD3Str(): d3str
    {
        return oxNew(d3str::class);
    }

    public function getCronPath($iCronJobId = null): string
    {
        $sScriptPath = VENDOR_PATH.'bin/d3_ordermanager_cron';

        $aParameters = [
            'task'  => 'run',
            'shp'   => $this->getViewConfig()->getActiveShopId(),
        ];

        if ($iCronJobId !== null) {
            $aParameters['cjid'] = $iCronJobId;
        }

        return 'php ' . $sScriptPath." ".implode(' ', $aParameters);
    }

    /**
     * @throws DatabaseConnectionException
     */
    public function getAvailableCronjobIds(): array
    {
        return $this->getManager()->getAvailableCronjobIds();
    }

    public function getCJIDDesc(array $aCJID): string
    {
        $oLang = Registry::getLang();
        if ($aCJID['count'] == 1) {
            return sprintf(
                $oLang->translateString('D3_ORDERMANAGER_SET_CRON_JOBID', null, true),
                $aCJID['id'],
                $aCJID['count']
            );
        }

        return sprintf(
            $oLang->translateString('D3_ORDERMANAGER_SET_CRON_JOBSID', null, true),
            $aCJID['id'],
            $aCJID['count']
        );
    }

    /**
     * @param bool|int $iCronJobId
     */
    public function getCronTimestampVarName($iCronJobId = false): string
    {
        $sVarName = "sCronExecTimestamp";

        if ($iCronJobId !== false) {
            $sVarName .= $iCronJobId;
        }

        return $sVarName;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getFileGeneratorCronSh(): d3filegeneratorcronsh
    {
        return oxNew(d3filegeneratorcronsh::class);
    }

    public function getCronProviderList(): array
    {
        return $this->getFileGeneratorCronSh()->getContentList();
    }

    /**
     * @codeCoverageIgnore
     */
    public function getCompatibilityAdapterHandler(): d3ShopCompatibilityAdapterHandler
    {
        return oxNew(d3shopcompatibilityadapterhandler::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function d3GetActiveShop(): Shop
    {
        return Registry::getConfig()->getActiveShop();
    }

    /**
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function generateCronShFile(): void
    {
        $sScriptPath = VENDOR_PATH.'bin/d3_ordermanager_cron';

        $sCronId = Registry::getRequest()->getRequestEscapedParameter('cronid');

        $oShop = $this->d3GetActiveShop();
        $aParameters = [
            0 => 'run',
            1 => $oShop->getId(),
            2 => $sCronId,
        ];

        $oD3ShGenerator = $this->getFileGeneratorCronSh();
        $oD3ShGenerator->setContentType(Registry::getRequest()->getRequestEscapedParameter('crontype'));
        $oD3ShGenerator->setScriptPath($sScriptPath);
        $oD3ShGenerator->setSortedParameterList($aParameters);
        $oD3ShGenerator->startDownload('d3ordermanager_'.$oShop->getId()."_".$sCronId.".sh");
    }
}
