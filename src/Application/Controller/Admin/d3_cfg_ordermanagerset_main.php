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

namespace D3\Ordermanager\Application\Controller\Admin;

use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_main;
use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Filegenerator\d3filegeneratorcronsh;
use D3\ModCfg\Application\Model\Shopcompatibility\d3ShopCompatibilityAdapterHandler;
use Doctrine\DBAL\DBALException;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Exception\FileException;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\Eshop\Application\Model\Shop;
use OxidEsales\Eshop\Core\Module\Module;
use OxidEsales\Eshop\Core\ViewConfig;
use OxidEsales\Eshop\Core\Registry;

class d3_cfg_ordermanagerset_main extends d3_cfg_mod_main
{
    protected $_sModId = 'd3_ordermanager';
    protected $_sThisTemplate = "d3_cfg_ordermanagerset_main.tpl";
    protected $_blHasDebugSwitch = true;
    protected $_sDebugHelpTextIdent = 'D3_ORDERMANAGER_SET_DEBUG_DESC';
    protected $_sMenuItemTitle = 'd3mxordermanager';
    protected $_sMenuSubItemTitle = 'd3mxordermanager_settings';

    /**
     * get basic cronjob access password; for cases only, if no password is set
     *
     * @return string
     */
    public function getBaseCronPW()
    {
        $oManager = oxNew(d3ordermanager::class);
        return $oManager->getBaseCronPW();
    }

    /**
     * @param bool $blUsePw
     * @param bool|int $iCronJobId
     *
     * @return string
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws FileException
     */
    public function getCronLink($blUsePw, $iCronJobId = false)
    {
        /** @var $oViewConf ViewConfig */
        $oViewConf = oxNew(ViewConfig::class);

        $sBaseUrl = $oViewConf->getModuleUrl('d3ordermanager').'public/d3_ordermanager_cron.php';

        $aParameters = array(
            'shp' => $oViewConf->getActiveShopId(),
        );

        if ($iCronJobId !== false) {
            $aParameters['cjid'] = $iCronJobId;
        }

        if ($blUsePw) {
            $aParameters['key'] = $this->d3GetSet()->getValue('sCronPassword') ?
                $this->d3GetSet()->getValue('sCronPassword') :
                $this->getBaseCronPW();
        }

        /** @var $oD3Str d3str */
        $oD3Str = oxNew(d3str::class);
        $sURL   = $oD3Str->generateParameterUrl($sBaseUrl, $aParameters);

        return $sURL;
    }

    /**
     * @return array
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getAvailableCronjobIds()
    {
        /** @var d3ordermanager $oManager */
        $oManager = oxNew(d3ordermanager::class);
        return $oManager->getAvailableCronjobIds();
    }

    /**
     * @param bool|array $aCJID
     *
     * @return string
     */
    public function getCJIDDesc($aCJID)
    {
        if ($aCJID['count'] == 1) {
            return sprintf(
                Registry::getLang()->translateString('D3_ORDERMANAGER_SET_CRON_JOBID', null, true),
                $aCJID['id'],
                $aCJID['count']
            );
        } else {
            return sprintf(
                Registry::getLang()->translateString('D3_ORDERMANAGER_SET_CRON_JOBSID', null, true),
                $aCJID['id'],
                $aCJID['count']
            );
        }
    }

    /**
     * @param bool|int $iCronJobId
     *
     * @return string
     */
    public function getCronTimestampVarName($iCronJobId = false)
    {
        $sVarName = "sCronExecTimestamp";

        if ($iCronJobId !== false) {
            $sVarName .= $iCronJobId;
        }

        return $sVarName;
    }

    /**
     * @return array
     */
    public function getCronProviderList()
    {
        /** @var d3filegeneratorcronsh $oD3ShGenerator */
        $oD3ShGenerator = oxNew(d3filegeneratorcronsh::class);

        return $oD3ShGenerator->getContentList();
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws StandardException
     */
    public function generateCronShFile()
    {
        /** @var Module $oModule */
        $oModule = oxNew(Module::class);

        /** @var d3ShopCompatibilityAdapterHandler $oD3CompatibilityAdapterHandler */
        $oD3CompatibilityAdapterHandler = oxNew(d3ShopCompatibilityAdapterHandler::class);
        $sModulePath = $oD3CompatibilityAdapterHandler->call(
            'oxmodule__getModuleFullPath',
            array($oModule, d3_cfg_mod::get($this->_sModId)->getMetaModuleId())
        );

        $sScriptPath = $sModulePath . "/public/d3_ordermanager_cron.php";

        $sCronId = Registry::get(Request::class)->getRequestEscapedParameter('cronid');

        /** @var Shop $oShop */
        $oShop = Registry::getConfig()->getActiveShop();
        $aParameters = array(
            0 => $oShop->getId(),
            1 => $sCronId,
        );

        /** @var d3filegeneratorcronsh $oD3ShGenerator */
        $oD3ShGenerator = oxNew(d3filegeneratorcronsh::class);

        $oD3ShGenerator->setContentType(Registry::get(Request::class)->getRequestEscapedParameter('crontype'));
        $oD3ShGenerator->setScriptPath($sScriptPath);
        $oD3ShGenerator->setSortedParameterList($aParameters);
        $oD3ShGenerator->startDownload('d3ordermanager_'.$oShop->getId()."_".$sCronId.".sh");
    }
}
