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
use D3\ModCfg\Application\Model\Exception\wrongModIdException;
use D3\ModCfg\Application\Model\Filegenerator\d3filegeneratorcronsh;
use D3\ModCfg\Application\Model\Shopcompatibility\d3ShopCompatibilityAdapterHandler;
use D3\Ordermanager\Application\Model\Constants;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_vars as VariablesTrait;
use Doctrine\DBAL\Exception as DBALException;
use OxidEsales\Eshop\Application\Model\Shop;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\Eshop\Core\ViewConfig;

class d3_cfg_ordermanagerset_main extends d3_cfg_mod_main
{
    use VariablesTrait;

    protected $_sModId = 'd3_ordermanager';

    protected $_sThisTemplate = '@'. Constants::OXID_MODULE_ID .'/admin/d3_cfg_ordermanagerset_main';

    protected $_blHasDebugSwitch = true;

    protected $_sDebugHelpTextIdent = 'D3_ORDERMANAGER_SET_DEBUG_DESC';

    protected $_sMenuItemTitle = 'd3mxordermanager';

    protected $_sMenuSubItemTitle = 'd3mxordermanager_settings';

    /**
     * constructor.
     */
    public function __construct()
    {
        d3GetOxidDIC()->getParameter($this->_DIC_Instance_Id . 'modcfgid') === $this->_sModId or
            throw oxNew(wrongModIdException::class, $this->_sModId);

        parent::__construct();
    }

    public function getManager(): Manager
    {
        /** @var Manager $manager */
        $manager = d3GetOxidDIC()->get(Manager::class);

        return $manager;
    }

    /**
     * get basic cronjob access password; for cases only, if no password is set
     */
    public function getBaseCronPW(): string
    {
        return $this->getManager()->getBaseCronPW();
    }

    public function getViewConfig(): ViewConfig
    {
        // don't use DIC because of circular reference
        if ($this->_oViewConf === null) {
            $this->_oViewConf = oxNew(ViewConfig::class);
        }

        return $this->_oViewConf;
    }

    public function getD3Str(): d3str
    {
        /** @var d3str $d3str */
        $d3str = d3GetOxidDIC()->get(d3str::class);
        return $d3str;
    }

    /**
     * @param bool|int $iCronJobId
     */
    public function getCronPath($iCronJobId = false): string
    {
        $sScriptPath = VENDOR_PATH.'bin/d3_ordermanager_cron';

        $aParameters = [
            'task'  => 'run',
            'shp'   => $this->getViewConfig()->getActiveShopId(),
        ];

        if ($iCronJobId !== false) {
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

    /**
     * @param bool|array $aCJID
     */
    public function getCJIDDesc(array $aCJID): string
    {
        /** @var Language $oLang */
        $oLang = d3GetOxidDIC()->get($this->_DIC_OxInstance_Id.Language::class);
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

    public function getFileGeneratorCronSh(): d3filegeneratorcronsh
    {
        /** @var d3filegeneratorcronsh $filegenerator */
        $filegenerator = d3GetOxidDIC()->get(d3filegeneratorcronsh::class);

        return $filegenerator;
    }

    public function getCronProviderList(): array
    {
        return $this->getFileGeneratorCronSh()->getContentList();
    }

    public function getCompatibilityAdapterHandler(): d3ShopCompatibilityAdapterHandler
    {
        /** @var d3ShopCompatibilityAdapterHandler $compatiblityHandler */
        $compatiblityHandler = d3GetOxidDIC()->get(d3ShopCompatibilityAdapterHandler::class);
        return $compatiblityHandler;
    }

    public function d3GetActiveShop(): Shop
    {
        /** @var Config $config */
        $config = d3GetOxidDIC()->get($this->_DIC_OxInstance_Id.Config::class);

        return $config->getActiveShop();
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function generateCronShFile(): void
    {
        $sScriptPath = VENDOR_PATH.'bin/d3_ordermanager_cron';

        /** @var Request $request */
        $request = d3GetOxidDIC()->get($this->_DIC_OxInstance_Id.Request::class);
        $sCronId = $request->getRequestEscapedParameter('cronid');

        $oShop = $this->d3GetActiveShop();
        $aParameters = [
            0 => 'run',
            1 => $oShop->getId(),
            2 => $sCronId,
        ];

        $oD3ShGenerator = $this->getFileGeneratorCronSh();
        $oD3ShGenerator->setContentType($request->getRequestEscapedParameter('crontype'));
        $oD3ShGenerator->setScriptPath($sScriptPath);
        $oD3ShGenerator->setSortedParameterList($aParameters);
        $oD3ShGenerator->startDownload('d3ordermanager_'.$oShop->getId()."_".$sCronId.".sh");
    }
}
