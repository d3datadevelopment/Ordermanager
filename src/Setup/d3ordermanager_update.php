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

declare(strict_types = 1);

namespace D3\Ordermanager\Setup;

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\d3bitmask;
use D3\ModCfg\Application\Model\d3database;
use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ParameterNotFoundException;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Model\Install\d3install_updatebase;
use D3\ModCfg\Application\Model\Installwizzard\d3installdbrecord;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\FetchMode;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\ConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Application\Model\Shop;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Facts\Facts;
use Doctrine\DBAL\Driver\PDOException;
use ReflectionException;
use stdClass;

class d3ordermanager_update extends d3install_updatebase
{
    public $sModKey = 'd3_ordermanager';
    public $sModName = 'Auftragsmanager';
    public $sModVersion = '5.0.0.0';
    public $sModRevision = '5000';
    public $sBaseConf =
    '8v8v2==YS9qUE5Bckl3YnVOZTJTZ3kyb0RkMkdERGxIUlpMem5VT3NGVnJwNGRxVDJ4S3RMaE45OC96c
nRNb2d5aEtGem9iYTB4b0F5SVBhdVR0amZlU0pxTFBKYS9lYlNhL0RKYy9MVWlPR2w5RGhicmI0YzBCV
TFxdkU4NC9vWThUeGFGb1JXaUZVdy9xeHI2dkZjT2xWU2UzVVZ6dFhJMkMwZzBGNUJsT0JkUjZRd2s2d
TNYMlJWdng1eGJoclBRQ3dYZVI4aElMYWZDbEFTMFNMQWdyQ0w1cTltRE4vTzFYRnA5UjgyTE1KN0k5Z
Xg3S1VxeWRUMGlPdHJ2c1oyR0ZKb0lTZ1NYWjduZGZacmI0eEtXNjRFSmNOcGRzT0dJSi8wUWVkaTNxM
jJvYTdncnR4aW5idkgyS1RVbGh2VXJ6WTFXUDBjbm1QMnFabWhDdXBBZUo1K1JRPT0=';
    public $sRequirements = '';
    public $sBaseValue = 'TyUzQTglM0ElMjJzdGRDbGFzcyUyMiUzQTUlM0ElN0JzJTNBMjMlM0ElMjJkM19jZmdfbW9kX19hRm9sZGVyTGlzdCUyMiUzQmElM0E1JTNBJTdCaSUzQTAlM0JzJTNBMjUlM0ElMjJEM19PUkRFUk1BTkFHRVJfT1JERVJfTkVXJTIyJTNCaSUzQTElM0JzJTNBMzIlM0ElMjJEM19PUkRFUk1BTkFHRVJfT1JERVJfUEFZQURWQU5DRSUyMiUzQmklM0EyJTNCcyUzQTM2JTNBJTIyRDNfT1JERVJNQU5BR0VSX09SREVSX1BBWVNUQVRVU0NIRUNLJTIyJTNCaSUzQTMlM0JzJTNBMzYlM0ElMjJEM19PUkRFUk1BTkFHRVJfT1JERVJfREVMSVZFUllTVEFUVVMlMjIlM0JpJTNBNCUzQnMlM0EzNyUzQSUyMkQzX09SREVSTUFOQUdFUl9PUkRFUl9PUkRFUlBST0NFU1NJTkclMjIlM0IlN0RzJTNBMjQlM0ElMjJkM19jZmdfbW9kX19ibENyb25BY3RpdmUlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjQlM0ElMjJkM19jZmdfbW9kX19pTWF4T3JkZXJDbnQlMjIlM0JzJTNBMiUzQSUyMjUwJTIyJTNCcyUzQTI1JTNBJTIyZDNfY2ZnX21vZF9fc0Nyb25QYXNzd29yZCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTMwJTNBJTIyZDNfY2ZnX21vZF9fYmxDYWxjU3RhdE9uRGVtYW5kJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCJTdE';

    public $sMinModCfgVersion = '6.0.0.0';
    
    protected $_aUpdateMethods = [
        [
            'check' => 'doesOrder2OrderManagerTableNotExist',
            'do'    => 'addOrder2OrderManagerTable'
        ],
        [
            'check' => 'doesModCfgItemNotExist',
            'do'    => 'addModCfgItem'
        ],
        [
            'check' => 'checkFields',
            'do'    => 'fixFields'
        ],
        [
            'check' => 'checkIndizes',
            'do'    => 'fixIndizes'
        ],
        [
            'check' => 'checkOrderManagerTableExist',
            'do'    => 'convertOrderManagerItems'
        ],
        [
            'check' => 'checkCronPasswordSet',
            'do'    => 'createCronPassword'
        ],
        [
            'check' => 'needExampleJobList',
            'do'    => 'addExampleJobList'
        ],
        [
            'check' => 'isExampleContentMissingInDatabase',
            'do'    => 'addExampleContentList'
        ],
        [
            'check' => 'requireExample2ShopRelation',
            'do'    => 'addExample2ShopRelation'
        ],
        [
            'check' => 'hasNotOrderArticlesParentId',
            'do'    => 'addOrderArticlesParentId'
        ],
        [
            'check' => 'hasUnregisteredFiles',
            'do'    => 'showUnregisteredFiles'
        ],
        [
            'check' => 'checkModCfgSameRevision',
            'do'    => 'updateModCfgSameRevision'
        ],
    ];

    // Standardwerte für checkMultiLangTables() und fixRegisterMultiLangTables()
    public $aMultiLangTables = [];

    public $aFields = [
        'PROF_EXECMANUALLY'        => [
            'sTableName'  => 'd3modprofile',
            'sFieldName'  => 'D3_OM_EXECMANUALLY',
            'sType'       => 'TINYINT(1)',
            'blNull'      => false,
            'sDefault'    => '0',
            'sComment'    => 'order manager: job is manually executable',
            'sExtra'      => '',
            'blMultilang' => false,
        ],
        'PROF_ORDERSAVETRIGGERED'        => [
            'sTableName'  => 'd3modprofile',
            'sFieldName'  => 'D3_OM_ORDERSAVETRIGGERED',
            'sType'       => 'TINYINT(1)',
            'blNull'      => false,
            'sDefault'    => '0',
            'sComment'    => 'order manager: job will executed on order::save',
            'sExtra'      => '',
            'blMultilang' => false,
        ],
        'PROF_ORDERFINISHTRIGGERED'        => [
            'sTableName'  => 'd3modprofile',
            'sFieldName'  => 'D3_OM_ORDERFINISHTRIGGERED',
            'sType'       => 'TINYINT(1)',
            'blNull'      => false,
            'sDefault'    => '0',
            'sComment'    => 'order manager: job will executed after order::finalizeOrder',
            'sExtra'      => '',
            'blMultilang' => false,
        ],
        'PROF_MARKORDER'        => [
            'sTableName'  => 'd3modprofile',
            'sFieldName'  => 'D3_OM_MARKORDER',
            'sType'       => 'TINYINT(1)',
            'blNull'      => false,
            'sDefault'    => '0',
            'sComment'    => 'order manager: mark orders as finished',
            'sExtra'      => '',
            'blMultilang' => false,
        ],
        'PROF_CRONJOBID'        => [
            'sTableName'  => 'd3modprofile',
            'sFieldName'  => 'D3_CRONJOBID',
            'sType'       => 'VARCHAR(8)',
            'blNull'      => false,
            'sDefault'    => 0,
            'sComment'    => 'ID for identifying via cronjob',
            'sExtra'      => '',
            'blMultilang' => false,
        ],

        'O_OXID'    => [
            'sTableName'  => 'd3order2ordermanager',
            'sFieldName'  => 'OXID',
            'sType'       => 'CHAR(32)',
            'blNull'      => false,
            'sDefault'    => false,
            'sComment'    => '',
            'sExtra'      => '',
            'blMultilang' => false,
        ],
        'O_OXORDERID'    => [
            'sTableName'  => 'd3order2ordermanager',
            'sFieldName'  => 'OXORDERID',
            'sType'       => 'CHAR(32)',
            'blNull'      => false,
            'sDefault'    => false,
            'sComment'    => '',
            'sExtra'      => '',
            'blMultilang' => false,
        ],
        'O_OXORDERMANAGERID'    => [
            'sTableName'  => 'd3order2ordermanager',
            'sFieldName'  => 'OXORDERMANAGERID',
            'sType'       => 'CHAR(32)',
            'blNull'      => false,
            'sDefault'    => false,
            'sComment'    => '',
            'sExtra'      => '',
            'blMultilang' => false,
        ],
        'O_OXREMARKID'    => [
            'sTableName'  => 'd3order2ordermanager',
            'sFieldName'  => 'OXREMARKID',
            'sType'       => 'CHAR(32)',
            'blNull'      => false,
            'sDefault'    => false,
            'sComment'    => '',
            'sExtra'      => '',
            'blMultilang' => false,
        ],
        'O_OXEXECDATE'    => [
            'sTableName'  => 'd3order2ordermanager',
            'sFieldName'  => 'OXEXECDATE',
            'sType'       => 'TIMESTAMP',
            'blNull'      => false,
            'sDefault'    => 'CURRENT_TIMESTAMP',
            'sComment'    => '',
            'sExtra'      => '',
            'blMultilang' => false,
        ],
        'O_OXDONTUSEFORCHECK'    => [
            'sTableName'  => 'd3order2ordermanager',
            'sFieldName'  => 'OXDONTUSEFORCHECK',
            'sType'       => 'TINYINT(1)',
            'blNull'      => false,
            'sDefault'    => '0',
            'sComment'    => '',
            'sExtra'      => '',
            'blMultilang' => false,
        ],
        'OXREMARKTYPE'    => [
            'sTableName'  => 'oxremark',
            'sFieldName'  => 'OXTYPE',
            'sType'       => 'ENUM("d3om")',
            'blNull'      => false,
            'sDefault'    => 'r',
            'sComment'    => '',
            'sExtra'      => '',
            'blMultilang' => false,
        ],
        'OXPARENTID'    => [
            'sTableName'  => 'oxorderarticles',
            'sFieldName'  => 'OXPARENTID',
            'sType'       => 'CHAR(32)',
            'blNull'      => false,
            'sDefault'    => '',
            'sComment'    => '',
            'sExtra'      => '',
            'blMultilang' => false,
        ],
    ];

    public $aIndizes = [
        'MP_D3_OM_EXECMANUALLY' => [
            'sTableName' => 'd3modprofile',
            'sType'      => d3database::INDEX_TYPE_INDEX,
            'sName'      => 'D3_OM_EXECMANUALLY',
            'aFields'    => [
                'D3_OM_EXECMANUALLY' => 'D3_OM_EXECMANUALLY',
            ],
        ],
        'MP_D3_OM_ORDERSAVETRIGGERED' => [
            'sTableName' => 'd3modprofile',
            'sType'      => d3database::INDEX_TYPE_INDEX,
            'sName'      => 'D3_OM_ORDERSAVETRIGGERED',
            'aFields'    => [
                'D3_OM_ORDERSAVETRIGGERED' => 'D3_OM_ORDERSAVETRIGGERED',
            ],
        ],
        'MP_D3_OM_ORDERFINISHTRIGGERED' => [
            'sTableName' => 'd3modprofile',
            'sType'      => d3database::INDEX_TYPE_INDEX,
            'sName'      => 'D3_OM_ORDERFINISHTRIGGERED',
            'aFields'    => [
                'D3_OM_ORDERFINISHTRIGGERED' => 'D3_OM_ORDERFINISHTRIGGERED',
            ],
        ],
        'O_OXID' => [
            'sTableName' => 'd3order2ordermanager',
            'sType'      => d3database::INDEX_TYPE_PRIMARY,
            'sName'      => 'PRIMARY',
            'aFields'    => [
                'OXID' => 'OXID',
            ],
        ],
        'O2OM_OXORDERMANAGERID' => [
            'sTableName' => 'd3order2ordermanager',
            'sType'      => d3database::INDEX_TYPE_INDEX,
            'sName'      => 'OXORDERMANAGERID',
            'aFields'    => [
                'OXORDERMANAGERID' => 'OXORDERMANAGERID',
            ],
        ],
        'O2OM_OXORDERID' => [
            'sTableName' => 'd3order2ordermanager',
            'sType'      => d3database::INDEX_TYPE_INDEX,
            'sName'      => 'OXORDERID',
            'aFields'    => [
                'OXORDERID' => 'OXORDERID',
            ],
        ],
    ];

    protected $_aRefreshMetaModuleIds = [ 'd3ordermanager' ];

    /**
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function checkOrderManagerTableExist(): bool
    {
        return !$this->_checkTableNotExist('d3ordermanager');
    }

    /**
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws ConnectionException
     */
    public function convertOrderManagerItems(): bool
    {
        $blReturn = false;
        if ($this->checkOrderManagerTableExist()) {
            $this->_changeItemContent('d3ordermanager__', '');
// ToDo: move this to generic methods in install_updatebase
            $aWhere = [];

            $aFieldLists = $this->_prepareConvertAssignments(
                'd3ordermanager',
                $this->_getConvertAssignments(),
                'd3modprofile'
            );

            $aSql = $this->_getDatabaseHandler()->getDataConvertQuery(
                'd3ordermanager',
                'd3modprofile',
                $aFieldLists['from'],
                $aFieldLists['to'],
                $aWhere
            );

            $sSql = implode('', $aSql);

            if ($this->hasExecute()) {
                try {
                    $this->getDb()->execute($sSql);
                    $blReturn = true;
                } catch  (PDOException $exception) {
                    if ($exception->errorInfo[1]) {
                        $this->setErrorMessage($exception->errorInfo[2]);
                    }
                    $blReturn = false;
                }
            } else {
                $blReturn = true;
            }

            $this->setUpdateBreak(false);

            if ($sSql) {
                $this->setActionLog('SQL', $sSql, __METHOD__);
            }

            if ($blReturn) {
                // moved to modprofile table
                $this->_dropTable('d3ordermanager');
                $this->fixUnRegisterMultiLangTables('d3ordermanager');
            }
        }

        return $blReturn;
    }

    /**
     * @return array
     */
    protected function _getConvertAssignments(): array
    {
        return [
            'oxid'   =>  [
                'from'      => 'oxid',
                'to'        => 'oxid',
                'multilang' => 0
            ],
            'oxshopid'   =>  [
                'from'      => 'oxshopid',
                'to'        => 'oxshopid',
                'multilang' => 0
            ],
            4   => [
                'from'      =>  'oxactive',
                'to'        =>  'oxactive',
                'multilang' => 1,
                'from_content'    => 1,
                'from_use_quote'  => 0
            ],
            5   => [
                'from'      =>  'oxactivefrom',
                'to'        =>  'oxactivefrom',
                'multilang' => 1,
                'from_content'    => '0000-00-00 00:00:00',
                'from_use_quote'  => 1
            ],
            6   => [
                'from'      =>  'oxactiveto',
                'to'        =>  'oxactiveto',
                'multilang' => 1,
                'from_content'    => '0000-00-00 00:00:00',
                'from_use_quote'  => 1
            ],
            7   => [
                'from_content' =>  'd3_ordermanager',
                'from_use_quote'    => true,
                'to'        =>  'oxmodid',
                'multilang' => 0
            ],
            8   => [
                'from'      =>  'oxtitle',
                'to'        =>  'oxtitle',
                'multilang' => 1
            ],
            9   => [
                'from'      =>  'oxcreate',
                'to'        =>  'oxcreate',
                'multilang' => 0,
                'from_content'    => 'NOW()',
                'from_use_quote'  => 0
            ],
            10   => [
                'from'      =>  'oxupdate',
                'to'        =>  'oxupdate',
                'multilang' => 1,
                'from_content'    => 'NOW()',
                'from_use_quote'  => 0
            ],
            11   => [
                'from'      =>  'oxmodversion',
                'to'        =>  'oxmodversion',
                'multilang' => 0,
                'from_content'    => $this->sModVersion,
                'from_use_quote'  => 1
            ],
            12   => [
                'from'      =>  'oxlog',
                'to'        =>  'oxlog',
                'multilang' => 1,
                'from_content'    => 15,
                'from_use_quote'  => 0
            ],
            13   => [
                'from'      =>  'oxvalue',
                'to'        =>  'oxvalue',
                'multilang' => 1
            ],
            14   => [
                'from'      =>  'oxfolder',
                'to'        =>  'oxfolder',
                'multilang' => 0
            ],
            15   => [
                'from'      =>  'oxsort',
                'to'        =>  'oxsort',
                'multilang' => 0
            ],
            16   => [
                'from'      =>  'oxwriteprotection',
                'to'        =>  'oxwriteprotection',
                'multilang' => 0,
                'from_content'    => '0',
                'from_use_quote'  => 0
            ],
            17   => [
                'from'      =>  'oxexecmanually',
                'to'        =>  'd3_om_execmanually',
                'multilang' => 0,
                'from_content'    => '0',
                'from_use_quote'  => 0
            ],
            18   => [
                'from'      =>  'oxmarkorder',
                'to'        =>  'd3_om_markorder',
                'multilang' => 0,
                'from_content'    => '1',
                'from_use_quote'  => 0
            ],
        ];
    }

    /**
     * @param $sOldKey
     * @param $sNewKey
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    protected function _changeItemContent($sOldKey, $sNewKey)
    {
        $iMaxLanguages = $this->getMaxLanguages();
        /** @var d3database $db */
        $db = d3GetModCfgDIC()->get('d3.ordermanager.database');

        for ($i = 0; $i < $iMaxLanguages; $i++) {
            $sFieldName = $this->_addMultiLangAddOn('oxvalue', $i);
            if ($db->checkTableExist('d3ordermanager') && $db->checkFieldExist('d3ordermanager', $sFieldName)) {
                $qb = $db->getQueryBuilder();
                $qb->select(['oxid', $sFieldName.' AS value'])
                    ->from('d3ordermanager')
                    ->where('1');

                $aRecords = $qb->execute()->fetchAll(FetchMode::ASSOCIATIVE);
                if ($aRecords && is_array($aRecords) && count($aRecords)) {
                    foreach ($aRecords as $aRecord) {
                        $aRecord = array_change_key_case($aRecord, CASE_UPPER);
                        if (strlen($aRecord['VALUE'])) {
                            $aValues = unserialize(rawurldecode(base64_decode($aRecord['VALUE'])));
                            $aNewValues = new stdClass;

                            foreach ($aValues as $sKey => $mValue) {
                                $sNew = str_replace($sOldKey, $sNewKey, $sKey);
                                $aNewValues->{$sNew} = $mValue;
                            }

                            $aSaveValues = base64_encode(rawurlencode(serialize($aNewValues)));

                            $qb1 = $db->getQueryBuilder();
                            $qb1->update('d3ordermanager')
                                ->set($sFieldName, $qb->expr()->literal($aSaveValues))
                                ->where(
                                    $qb->expr()->eq('oxid', $aRecord['OXID'])
                                );

                            if ($this->hasExecute()) {
                                try {
                                    $qb1->execute();
                                } catch  (PDOException $exception) {
                                    if ($exception->errorInfo[1]) {
                                        $this->setErrorMessage($exception->errorInfo[2]);
                                    }
                                }
                            }

                            $this->setUpdateBreak(false);

                            $this->setActionLog('SQL', $db->getPreparedStatementQuery($qb1->getSQL(), $qb1->getParameters()), __METHOD__);
                        }
                    }
                }
            }
        }
    }

    /**
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function doesOrder2OrderManagerTableNotExist(): bool
    {
        return $this->_checkTableNotExist('d3order2ordermanager');
    }

    /**
     * @return bool
     * @throws ConnectionException
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function addOrder2OrderManagerTable(): bool
    {
        $blRet = false;
        if ($this->doesOrder2OrderManagerTableNotExist()) {
            $this->setInitialExecMethod(__METHOD__);
            $blRet  = $this->_addTable2(
                'd3order2ordermanager',
                $this->aFields,
                $this->aIndizes,
                'order to ordermanageritem assignment',
                'MyISAM'
            );
        }

        return $blRet;
    }

    /**
     * @return d3installdbrecord
     */
    public function d3GetInstallDbRecord(): d3installdbrecord
    {
        d3GetModCfgDIC()->set(
            d3installdbrecord::class.'.arg_updatebase',
            $this
        );

        /** @var d3installdbrecord $dbRecord */
        $dbRecord = d3GetModCfgDIC()->get(d3installdbrecord::class);
        return $dbRecord;
    }

    /**
     * required for unitTests
     * @return Config
     */
    public function d3GetConfig(): Config
    {
        /** @var Config $config */
        $config = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Config::class);
        return $config;
    }

    /**
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     */
    public function doesModCfgItemNotExist(): bool
    {
        $blRet = false;
        foreach ($this->d3GetConfig()->getShopIds() as $sShopId) {
            $aWhere = [
                'oxmodid'       => $this->sModKey,
                'oxnewrevision' => $this->sModRevision,
                'oxshopid'      => $sShopId,
            ];

            $blRet = $this->d3GetInstallDbRecord()->checkTableRecordNotExist('d3_cfg_mod', $aWhere);

            if ($blRet == true) {
                return true;
            }
        }

        return $blRet;
    }

    /**
     * @return bool
     * @throws ConnectionException
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function addModCfgItem(): bool
    {
        $blRet = false;

        if ($this->doesModCfgItemNotExist()) {
            foreach ($this->d3GetConfig()->getShopIds() as $sShopId) {
                $aWhere = [
                    'oxmodid'       => $this->sModKey,
                    'oxshopid'      => $sShopId,
                    'oxnewrevision' => $this->sModRevision,
                ];

                if ($this->d3GetInstallDbRecord()->checkTableRecordNotExist('d3_cfg_mod', $aWhere)) {
                    // update don't use this property
                    unset($aWhere['oxnewrevision']);

                    $aInsertFields = [
                        [
                            'fieldname'     => 'OXID',
                            'content'       => "md5('" . $this->sModKey . " " . $sShopId . " de')",
                            'force_update'  => true,
                            'use_quote'     => false,
                            'use_multilang' => false,
                        ],
                        [
                            'fieldname'     => 'OXSHOPID',
                            'content'       => $sShopId,
                            'force_update'  => true,
                            'use_quote'     => true,
                            'use_multilang' => false,
                        ],
                        [
                            'fieldname'     => 'OXMODID',
                            'content'       => $this->sModKey,
                            'force_update'  => true,
                            'use_quote'     => true,
                            'use_multilang' => false,
                        ],
                        [
                            'fieldname'     => 'OXNAME',
                            'content'       => $this->sModName,
                            'force_update'  => true,
                            'use_quote'     => true,
                            'use_multilang' => false,
                        ],
                        [
                            'fieldname'     => 'OXACTIVE',
                            'content'       => "0",
                            'force_update'  => false,
                            'use_quote'     => false,
                            'use_multilang' => false,
                        ],
                        [
                            'fieldname'     => 'OXBASECONFIG',
                            'content'       => $this->sBaseConf,
                            'force_update'  => true,
                            'use_quote'     => true,
                            'use_multilang' => false,
                        ],
                        [
                            'fieldname'     => 'OXSERIAL',
                            'content'       => "",
                            'force_update'  => false,
                            'use_quote'     => true,
                            'use_multilang' => false,
                        ],
                        [
                            'fieldname'     => 'OXINSTALLDATE',
                            'content'       => "NOW()",
                            'force_update'  => true,
                            'use_quote'     => false,
                            'use_multilang' => false,
                        ],
                        [
                            'fieldname'     => 'OXVERSION',
                            'content'       => $this->sModVersion,
                            'force_update'  => true,
                            'use_quote'     => true,
                            'use_multilang' => false,
                        ],
                        [
                            'fieldname'     => 'OXSHOPVERSION',
                            'content'       => d3GetModCfgDIC()->get('d3ox.ordermanager.'.Facts::class)->getEdition(),
                            'force_update'  => true,
                            'use_quote'     => true,
                            'use_multilang' => false,
                        ],
                        [
                            'fieldname'     => 'OXREQUIREMENTS',
                            'content'       => $this->sRequirements,
                            'force_update'  => true,
                            'use_quote'     => true,
                            'use_multilang' => false,
                        ],
                        [
                            'fieldname'     => 'OXVALUE',
                            'content'       => $this->sBaseValue,
                            'force_update'  => false,
                            'use_quote'     => true,
                            'use_multilang' => false,
                        ],
                        [
                            'fieldname'     => 'OXNEWREVISION',
                            'content'       => $this->sModRevision,
                            'force_update'  => true,
                            'use_quote'     => true,
                            'use_multilang' => false,
                        ]
                    ];

                    $this->setInitialExecMethod(__METHOD__);
                    $blRet  = $this->_updateTableItem2('d3_cfg_mod', $aInsertFields, $aWhere);

                    if ($this->getStepByStepMode()) {
                        break;
                    }
                }
            }
        }
        return $blRet;
    }

    /**
     * @return bool true, if new password must set
     */
    public function checkCronPasswordSet(): bool
    {
        /** @var d3_cfg_mod $set */
        $set = d3GetModCfgDIC()->get('d3.ordermanager.modcfg');
        $password = $set->getValue('sCronPassword');
        return false === $password || is_null($password) || (is_string($password) && strlen($password) <= 0);
    }

    /**
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function createCronPassword(): bool
    {
        $message = Registry::getLang()->translateString('D3_ORDERMANAGER_SETUP_CRONPASSWORD') . PHP_EOL.PHP_EOL;
        $this->setActionLog('msg', $message, __METHOD__);

        if ($this->hasExecute()) {
            /** @var d3str $oD3str */
            $oD3str = d3GetModCfgDIC()->get(d3str::class);
            $password = $oD3str->random_str(12);

            /** @var d3_cfg_mod $set */
            $set = d3GetModCfgDIC()->get('d3.ordermanager.modcfg');
            $set->setValue('sCronPassword', $password);
            $set->saveNoLicenseRefresh();
        }

        return true;
    }

    /**
     * @return bool true, if update is required
     * @throws DBALException
     */
    public function needExampleJobList(): bool
    {
        $blRet = false;

        /** @var d3database $db */
        $db = d3GetModCfgDIC()->get('d3.ordermanager.database');
        $qb = $db->getQueryBuilder();
        // change this to your inividual check criterias
        $qb->select('count(oxid) ')->from('d3modprofile')
           ->where('oxmodid = '.$qb->createNamedParameter('d3_ordermanager'))
           ->setMaxResults(1);

        if ($qb->execute()->fetchColumn() == 0) {
            $blRet = true;
        }

        return $blRet;
    }

    /**
     * @return bool
     * @throws ConnectionException
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function addExampleJobList(): bool
    {
        $blRet = true;

        foreach ($this->getExampleJobInsertList() as $aJobContentInfos) {
            $blRet = $this->_addExampleJobItem($aJobContentInfos['table'], $aJobContentInfos['content']);

            if (false == $blRet) {
                break;
            }
        }

        $this->setUpdateBreak(true);

        return $blRet;
    }

    /**
     * @return bool true, if update is required
     */
    public function isExampleContentMissingInDatabase(): bool
    {
        $blRet = false;

        $aIdentList = [];
        foreach ($this->getExampleContentInsertList() as $aJobContentInfos) {
            $aInsertFields = $this->{$aJobContentInfos['content']}($this->d3GetConfig()->getActiveShop());
            foreach ($aInsertFields as $aInsertField) {
                if (is_string($aInsertField['fieldname']) && strtoupper($aInsertField['fieldname']) == 'OXLOADID') {
                    $aIdentList[] = $aInsertField['content'];
                }
            }
        }

        if (count($aIdentList)) {
            // change this to your inividual check criterias
            /** @var d3database $db */
            $db = d3GetModCfgDIC()->get('d3.ordermanager.database');
            $qb = $db->getQueryBuilder();
            $qb->select('count(oxid) < '.count($aIdentList))
                ->from('oxcontents')
                ->where(
                        $qb->expr()->in('oxloadid', implode(', ', array_map(
                            function($value) use ($qb) {
                                return $qb->createNamedParameter($value);
                            },
                            $aIdentList
                        )))
                    )
                ->setMaxResults(1);

            return (bool) $qb->execute()->fetchColumn();
        }

        return $blRet;
    }

    /**
     * @return bool
     * @throws ConnectionException
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function addExampleContentList(): bool
    {
        $blRet = true;

        foreach ($this->getExampleContentInsertList() as $aJobContentInfos) {
            $blRet = $this->_addExampleJobItem($aJobContentInfos['table'], $aJobContentInfos['content']);

            if (!$blRet) {
                break;
            }
        }

        $this->setUpdateBreak(true);

        return $blRet;
    }

    /**
     * @return bool true, if update is required
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3ParameterNotFoundException
     * @throws ConnectionException
     */
    public function requireExample2ShopRelation(): bool
    {
        startProfile(__METHOD__);

        $this->setInitialExecMethod(__METHOD__);

        foreach ($this->getExampleJobInsertList() as $aJobContentInfos) {
            $sGetFieldContentMethodName = $aJobContentInfos['content'];
            /** @var $oShop Shop */
            foreach ($this->getShopListByActiveModule('d3ordermanager') as $oShop) {
                $aCheckFields = $this->{$sGetFieldContentMethodName}($oShop);

                if ($this->_require2ShopRelation($aJobContentInfos['table'], $aCheckFields)) {
                    stopProfile(__METHOD__);
                    return true;
                }
            }
        }

        stopProfile(__METHOD__);
        return false;
    }

    /**
     * @return bool
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3ParameterNotFoundException
     * @throws ConnectionException
     */
    public function addExample2ShopRelation(): bool
    {
        $blRet = true;

        foreach ($this->getExampleJobInsertList() as $aJobContentInfos) {
            $sGetFieldContentMethodName = $aJobContentInfos['content'];
            /** @var $oShop Shop */
            foreach ($this->getShopListByActiveModule('d3ordermanager') as $oShop) {
                $aInsertFields = $this->{$sGetFieldContentMethodName}($oShop);
                $blRet = $this->_add2ShopRelation($aJobContentInfos['table'], $aInsertFields);
            }

            if (!$blRet) {
                break;
            }
        }

        $this->setUpdateBreak(true);

        return $blRet;
    }

    /**
     * @return array
     */
    public function getExampleJobInsertList(): array
    {
        return [
            [
                'content'   => 'getExampleJobItem1InsertFields',
                'table'     => 'd3modprofile'
            ],
            [
                'content'   => 'getExampleJobItem2InsertFields',
                'table'     => 'd3modprofile'
            ],
            [
                'content'   => 'getExampleJobItem3InsertFields',
                'table'     => 'd3modprofile'
            ],
            [
                'content'   => 'getExampleJobItem4InsertFields',
                'table'     => 'd3modprofile'
            ],
            [
                'content'   => 'getExampleJobItem5InsertFields',
                'table'     => 'd3modprofile'
            ],
            [
                'content'   => 'getExampleJobItem6InsertFields',
                'table'     => 'd3modprofile'
            ],
            [
                'content'   => 'getExampleJobItem7InsertFields',
                'table'     => 'd3modprofile'
            ],
            [
                'content'   => 'getExampleJobItem8InsertFields',
                'table'     => 'd3modprofile'
            ],
            [
                'content'   => 'getExampleJobItem9InsertFields',
                'table'     => 'd3modprofile'
            ],
            [
                'content'   => 'getExampleJobItem10InsertFields',
                'table'     => 'd3modprofile'
            ],
        ];
    }

    /**
     * @return array
     */
    public function getExampleContentInsertList(): array
    {
        return [
            [
                'content'   => 'getExampleContent1InsertFields',
                'table'     => 'oxcontents'
            ],
            [
                'content'   => 'getExampleContent2InsertFields',
                'table'     => 'oxcontents'
            ],
        ];
    }

    /**
     * @return d3bitmask
     */
    public function getD3BitMask(): d3bitmask
    {
        /** @var d3bitmask $bitMask */
        $bitMask = d3GetModCfgDIC()->get(d3bitmask::class);
        return $bitMask;
    }

    /**
     * @param Shop $oShop
     *
     * @return array
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getExampleJobItem1InsertFields(Shop $oShop): array
    {
        $sShopId = $oShop->getId();
        $iShopBit = strlen($sShopId) == 1 ? $this->getD3BitMask()->getIntByBitPosition((int) $sShopId) : '1';

        return [
            [
                'fieldname'     => 'OXID',
                'content'       => "MD5('" . $this->sModKey . " job01 " . $sShopId . "')",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPID',
                'content'       => $sShopId,
                'force_update'  => true,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPINCL',
                'content'       => $iShopBit,
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPEXCL',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVE',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVEFROM',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVETO',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODID',
                'content'       => 'd3_ordermanager',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXTITLE',
                'content'       => 'Vorkasseinfo an Kunden senden',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'de'),
                'content'       => 'Vorkasseinfo an Kunden senden',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'en'),
                'content'       => 'send payadvance information',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHORTDESC',
                'content'       => 'Kunden, die per Vorkasse bezahlen möchten, werden kurz nach ihrem Kauf '.
                    'automatisch über den Ablauf der Vorkassezahlung und die Bankverbindung informiert.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXSHORTDESC', 'de'),
                'content'       => 'Kunden, die per Vorkasse bezahlen möchten, werden kurz nach ihrem Kauf '.
                    'automatisch über den Ablauf der Vorkassezahlung und die Bankverbindung informiert.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXCREATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXUPDATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXUPDATE', 'de'),
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODVERSION',
                'content'       => $this->sModVersion,
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXLOG',
                'content'       => '15',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXVALUE',
                'content'       => 'TyUzQTglM0ElMjJzdGRDbGFzcyUyMiUzQTg3JTNBJTdCcyUzQTEzJTNBJTIyYmxJdGVtRXhlY3V0ZSUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNCUzQSUyMmJsSXRlbU1haWxTZW5kJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja0Zyb21PcmRlck5yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNyUzQSUyMnNGcm9tT3JkZXJOclZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVG9PcmRlck5yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNUb09yZGVyTnJWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIzJTNBJTIyYmxDaGVja1RpbWVzcGFuMV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTUlM0ElMjJzVGltZXNwYW4xVmFsdWUlMjIlM0JzJTNBMiUzQSUyMjEwJTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMVVuaXQlMjIlM0JzJTNBNiUzQSUyMm1pbnV0ZSUyMiUzQnMlM0ExNCUzQSUyMnNUaW1lc3BhbjFUeXBlJTIyJTNCcyUzQTklM0ElMjJvcmRlcmRhdGUlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVGltZXNwYW4yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNUaW1lc3BhbjJWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMlVuaXQlMjIlM0JzJTNBNiUzQSUyMm1pbnV0ZSUyMiUzQnMlM0ExNCUzQSUyMnNUaW1lc3BhbjJUeXBlJTIyJTNCcyUzQTklM0ElMjJvcmRlcmRhdGUlMjIlM0JzJTNBMjQlM0ElMjJibENoZWNrTm90U2V0RGF0ZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTUlM0ElMjJzTm90U2V0RGF0ZVR5cGUlMjIlM0JzJTNBOCUzQSUyMnBhaWRkYXRlJTIyJTNCcyUzQTIyJTNBJTIyYmxDaGVja1dlZWtkYXlzX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMyUzQSUyMnNXZWVrZGF5c1R5cGUlMjIlM0JzJTNBOSUzQSUyMm9yZGVyZGF0ZSUyMiUzQnMlM0EyMSUzQSUyMmJsQ2hlY2tQYXltZW50X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExMCUzQSUyMnNQYXltZW50SWQlMjIlM0JhJTNBMSUzQSU3QmklM0EwJTNCcyUzQTE0JTNBJTIyb3hpZHBheWFkdmFuY2UlMjIlM0IlN0RzJTNBMjIlM0ElMjJibENoZWNrRGVsaXZlcnlfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIzJTNBJTIyYmxDaGVja1RyYWNrY29kZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjUlM0ElMjJibENoZWNrT3JkZXJzdG9ybm9fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI3JTNBJTIyYmxDaGVja09yZGVyTm9zdG9ybm9fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTI3JTNBJTIyYmxDaGVja0FydGljbGVzdG9ybm9fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIyJTNBJTIyYmxDaGVja09yZGVyU3VtX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMyUzQSUyMnNPcmRlclN1bVR5cGUlMjIlM0JzJTNBNSUzQSUyMnRvdGFsJTIyJTNCcyUzQTE3JTNBJTIyc09yZGVyU3VtUmVsYXRpb24lMjIlM0JzJTNBNiUzQSUyMmhpZ2hlciUyMiUzQnMlM0ExNCUzQSUyMnNPcmRlclN1bVZhbHVlJTIyJTNCcyUzQTQlM0ElMjIwLjAwJTIyJTNCcyUzQTI0JTNBJTIyYmxDaGVja0ludm9pY2VOdW1fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja1RyYW5zYWN0aW9uX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNyUzQSUyMnNPcmRlclRyYW5zU3RhdHVzJTIyJTNCcyUzQTIlM0ElMjJPSyUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tDdXJyZW5jeV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTclM0ElMjJzQ3VycmVuY3lJU09WYWx1ZSUyMiUzQnMlM0EzJTNBJTIyRVVSJTIyJTNCcyUzQTIyJTNBJTIyYmxDaGVja0xhbmd1YWdlX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExMyUzQSUyMnNJbkxhbmd1YWdlSWQlMjIlM0JhJTNBMSUzQSU3QmklM0EwJTNCcyUzQTElM0ElMjIwJTIyJTNCJTdEcyUzQTIyJTNBJTIyYmxDaGVja0luRm9sZGVyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNSUzQSUyMmJsQ2hlY2tOb3RJbkZvbGRlcl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjclM0ElMjJibENoZWNrT3JkZXJBcnRpY2xlMV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjAlM0ElMjJzQXJ0aWNsZUNvbnRlbnQxVHlwZSUyMiUzQnMlM0E4JTNBJTIyb3hhcnRudW0lMjIlM0JzJTNBMjIlM0ElMjJzQXJ0aWNsZUNvbnRlbnQxUmVnRXhwJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjclM0ElMjJibENoZWNrT3JkZXJBcnRpY2xlMl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjAlM0ElMjJzQXJ0aWNsZUNvbnRlbnQyVHlwZSUyMiUzQnMlM0E4JTNBJTIyb3hhcnRudW0lMjIlM0JzJTNBMjIlM0ElMjJzQXJ0aWNsZUNvbnRlbnQyUmVnRXhwJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMTglM0ElMjJibENoZWNrTWFpbF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTAlM0ElMjJzTWFpbFZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjElM0ElMjJibENoZWNrQ291bnRyeV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTQlM0ElMjJzQ3VzdENvdW50cnlJZCUyMiUzQmElM0ExJTNBJTdCaSUzQTAlM0JzJTNBMjYlM0ElMjJhN2M0MGY2MzFmYzkyMDY4Ny4yMDE3OTk4NCUyMiUzQiU3RHMlM0EyNyUzQSUyMmJsQWN0aW9uT3JkZXIyRm9sZGVyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMiUzQSUyMnNPcmRlckZvbGRlciUyMiUzQnMlM0ExNSUzQSUyMk9SREVSRk9MREVSX05FVyUyMiUzQnMlM0EyNiUzQSUyMmJsQWN0aW9uT3JkZXJTdG9ybm9fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI2JTNBJTIyYmxBY3Rpb25PcmRlckRlbGV0ZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMzIlM0ElMjJibEFjdGlvbk9yZGVyU2V0U2VuZGVkTm93X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EzMCUzQSUyMmJsQWN0aW9uT3JkZXJTZXRQYWlkTm93X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EzMyUzQSUyMmJsQWN0aW9uT3JkZXJBZGRGaWVsZFZhbHVlX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMSUzQSUyMnNBY3Rpb25BZGRGaWVsZF9maWVsZCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIxJTNBJTIyc0FjdGlvbkFkZEZpZWxkX3ZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMzglM0ElMjJibEFjdGlvbk9yZGVyQ2hhbmdlRGVsaXZlcnlDb3N0X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNSUzQSUyMnNBY3Rpb25DaGFuZ2VEZWxDb3N0VmFsdWUlMjIlM0JzJTNBNCUzQSUyMjAuMDAlMjIlM0JzJTNBMzQlM0ElMjJibEFjdGlvbk9yZGVyQ2hhbmdlRGlzY291bnRfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI2JTNBJTIyc0FjdGlvbkNoYW5nZURpc2NvdW50VmFsdWUlMjIlM0JzJTNBNCUzQSUyMjAuMDAlMjIlM0JzJTNBMjUlM0ElMjJibEFjdGlvbkN1c3QyR3JvdXBfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI4JTNBJTIyYmxBY3Rpb25DdXN0RnJvbUdyb3VwX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMyUzQSUyMmJsQWN0aW9uTWFpbHNlbmRfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTE5JTNBJTIyc1NlbmRNYWlsRnJvbVNvdXJjZSUyMiUzQnMlM0E4JTNBJTIydGVtcGxhdGUlMjIlM0JzJTNBMjAlM0ElMjJzU2VuZE1haWxGcm9tU3ViamVjdCUyMiUzQnMlM0EzNSUzQSUyMmVtYWlsJTJGaHRtbCUyRnZvcmthc3NlaW5mb19zdWJqZWN0LnRwbCUyMiUzQnMlM0EyNSUzQSUyMnNTZW5kTWFpbEZyb21UZW1wbGF0ZW5hbWUlMjIlM0JzJTNBMjclM0ElMjJlbWFpbCUyRmh0bWwlMkZ2b3JrYXNzZWluZm8udHBsJTIyJTNCcyUzQTMwJTNBJTIyc1NlbmRNYWlsRnJvbVRlbXBsYXRlbmFtZVBsYWluJTIyJTNCcyUzQTI4JTNBJTIyZW1haWwlMkZwbGFpbiUyRnZvcmthc3NlaW5mby50cGwlMjIlM0JzJTNBMjQlM0ElMjJzU2VuZE1haWxGcm9tQ29udGVudG5hbWUlMjIlM0JzJTNBMzIlM0ElMjI4NzA5ZTQ1ZjMxYTg2OTA5ZTlmOTk5MjIyZTgwYjFkMCUyMiUzQnMlM0EyOSUzQSUyMnNTZW5kTWFpbEZyb21Db250ZW50bmFtZVBsYWluJTIyJTNCcyUzQTMyJTNBJTIyODcwOWU0NWYzMWE4NjkwOWU5Zjk5OTIyMmU4MGIxZDAlMjIlM0JzJTNBMjAlM0ElMjJibFNlbmRNYWlsVG9DdXN0b21lciUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExNyUzQSUyMmJsU2VuZE1haWxUb093bmVyJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE4JTNBJTIyYmxTZW5kTWFpbFRvQ3VzdG9tJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI0JTNBJTIyc1NlbmRNYWlsVG9DdXN0b21BZGRyZXNzJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjQlM0ElMjJibENoZWNrT3JkZXJGaWVsZF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjElM0ElMjJzT3JkZXJGaWVsZF9GaWVsZE5hbWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMiUzQSUyMnNPcmRlckZpZWxkX0ZpZWxkVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNSUzQSUyMmlVbm1hcmtFeGVjRGVsYXlUaW1lVmFsdWUlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMjQlM0ElMjJzVW5tYXJrRXhlY0RlbGF5VGltZVVuaXQlMjIlM0JzJTNBNCUzQSUyMmRheXMlMjIlM0JzJTNBMzElM0ElMjJibEFjdGlvbk9yZGVyR2VuZXJhdGVQZGZfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTI3JTNBJTIyYmxBY3Rpb25PcmRlclBkZlR5cGVJbnZvaWNlJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTI3JTNBJTIyYmxBY3Rpb25PcmRlclBkZlR5cGVEZWxub3RlJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI2JTNBJTIyYmxBY3Rpb25PcmRlclBkZlNlbmRBdHRhY2glMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMjQlM0ElMjJibEFjdGlvbk9yZGVyUGRmU2VuZFNhdmUlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjIlM0ElMjJzQWN0aW9uT3JkZXJQZGZTYXZlRGlyJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMTglM0ElMjJzU2VuZE1haWxGcm9tVGhlbWUlMjIlM0JzJTNBOCUzQSUyMmZyb250ZW5kJTIyJTNCcyUzQTE5JTNBJTIyYmxHZXRTdG9ybm9BcnRpY2xlcyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQiU3RA==',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXFOLDER',
                'content'       => 'D3_ORDERMANAGER_ORDER_PAYADVANCE',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSORT',
                'content'       => '1000',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXWRITEPROTECTION',
                'content'       => "0",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_EXECMANUALLY',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'D3_OM_MARKORDER',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
        ];
    }

    /**
     * @param Shop $oShop
     *
     * @return array
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getExampleJobItem2InsertFields(Shop $oShop): array
    {
        $sShopId = $oShop->getId();
        $iShopBit = strlen($sShopId) == 1 ? $this->getD3BitMask()->getIntByBitPosition((int) $sShopId) : '1';

        return [
            [
                'fieldname'     => 'OXID',
                'content'       => "MD5('" . $this->sModKey . " job02 " . $sShopId . "')",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPID',
                'content'       => $sShopId,
                'force_update'  => true,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPINCL',
                'content'       => $iShopBit,
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPEXCL',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVE',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVEFROM',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVETO',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODID',
                'content'       => 'd3_ordermanager',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXTITLE',
                'content'       => 'Rechnungs-PDF erstellen',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'de'),
                'content'       => 'Rechnungs-PDF erstellen',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'en'),
                'content'       => 'create invoice pdf',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHORTDESC',
                'content'       => 'Versenden Sie die PDF-Rechnung automatisch an Ihre Kunden. Sie sparen sich damit viel Arbeit in der Nachbehandlung der Bestellungen.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXSHORTDESC', 'de'),
                'content'       => 'Versenden Sie die PDF-Rechnung automatisch an Ihre Kunden. Sie sparen sich damit viel Arbeit in der Nachbehandlung der Bestellungen.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXCREATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXUPDATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXUPDATE', 'de'),
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODVERSION',
                'content'       => $this->sModVersion,
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXLOG',
                'content'       => '15',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXVALUE',
                'content'       => 'TyUzQTglM0ElMjJzdGRDbGFzcyUyMiUzQTg1JTNBJTdCcyUzQTEzJTNBJTIyYmxJdGVtRXhlY3V0ZSUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNCUzQSUyMmJsSXRlbU1haWxTZW5kJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTI1JTNBJTIyaVVubWFya0V4ZWNEZWxheVRpbWVWYWx1ZSUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0EyNCUzQSUyMnNVbm1hcmtFeGVjRGVsYXlUaW1lVW5pdCUyMiUzQnMlM0E0JTNBJTIyZGF5cyUyMiUzQnMlM0EyNSUzQSUyMmJsQ2hlY2tGcm9tT3JkZXJOcl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTclM0ElMjJzRnJvbU9yZGVyTnJWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIzJTNBJTIyYmxDaGVja1RvT3JkZXJOcl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTUlM0ElMjJzVG9PcmRlck5yVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMyUzQSUyMmJsQ2hlY2tUaW1lc3BhbjFfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE1JTNBJTIyc1RpbWVzcGFuMVZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMTQlM0ElMjJzVGltZXNwYW4xVW5pdCUyMiUzQnMlM0E2JTNBJTIybWludXRlJTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMVR5cGUlMjIlM0JzJTNBOSUzQSUyMm9yZGVyZGF0ZSUyMiUzQnMlM0EyMyUzQSUyMmJsQ2hlY2tUaW1lc3BhbjJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE1JTNBJTIyc1RpbWVzcGFuMlZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMTQlM0ElMjJzVGltZXNwYW4yVW5pdCUyMiUzQnMlM0E2JTNBJTIybWludXRlJTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMlR5cGUlMjIlM0JzJTNBOSUzQSUyMm9yZGVyZGF0ZSUyMiUzQnMlM0EyNCUzQSUyMmJsQ2hlY2tOb3RTZXREYXRlX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNOb3RTZXREYXRlVHlwZSUyMiUzQnMlM0E3JTNBJTIyZGVsZGF0ZSUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tXZWVrZGF5c19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTMlM0ElMjJzV2Vla2RheXNUeXBlJTIyJTNCcyUzQTklM0ElMjJvcmRlcmRhdGUlMjIlM0JzJTNBMjElM0ElMjJibENoZWNrUGF5bWVudF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTAlM0ElMjJzUGF5bWVudElkJTIyJTNCYSUzQTElM0ElN0JpJTNBMCUzQnMlM0ExMSUzQSUyMm94aWRpbnZvaWNlJTIyJTNCJTdEcyUzQTIyJTNBJTIyYmxDaGVja0RlbGl2ZXJ5X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMyUzQSUyMmJsQ2hlY2tUcmFja2NvZGVfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja09yZGVyc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tPcmRlck5vc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tBcnRpY2xlc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tPcmRlclN1bV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTMlM0ElMjJzT3JkZXJTdW1UeXBlJTIyJTNCcyUzQTUlM0ElMjJ0b3RhbCUyMiUzQnMlM0ExNyUzQSUyMnNPcmRlclN1bVJlbGF0aW9uJTIyJTNCcyUzQTYlM0ElMjJoaWdoZXIlMjIlM0JzJTNBMTQlM0ElMjJzT3JkZXJTdW1WYWx1ZSUyMiUzQnMlM0E0JTNBJTIyMC4wMCUyMiUzQnMlM0EyNCUzQSUyMmJsQ2hlY2tJbnZvaWNlTnVtX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNSUzQSUyMmJsQ2hlY2tUcmFuc2FjdGlvbl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTclM0ElMjJzT3JkZXJUcmFuc1N0YXR1cyUyMiUzQnMlM0EyJTNBJTIyT0slMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrQ3VycmVuY3lfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE3JTNBJTIyc0N1cnJlbmN5SVNPVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tMYW5ndWFnZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrSW5Gb2xkZXJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja05vdEluRm9sZGVyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tPcmRlckFydGljbGUxX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMCUzQSUyMnNBcnRpY2xlQ29udGVudDFUeXBlJTIyJTNCcyUzQTglM0ElMjJveGFydG51bSUyMiUzQnMlM0EyMiUzQSUyMnNBcnRpY2xlQ29udGVudDFSZWdFeHAlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tPcmRlckFydGljbGUyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMCUzQSUyMnNBcnRpY2xlQ29udGVudDJUeXBlJTIyJTNCcyUzQTglM0ElMjJveGFydG51bSUyMiUzQnMlM0EyMiUzQSUyMnNBcnRpY2xlQ29udGVudDJSZWdFeHAlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNCUzQSUyMmJsQ2hlY2tPcmRlckZpZWxkX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMSUzQSUyMnNPcmRlckZpZWxkX0ZpZWxkTmFtZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIwJTNBJTIyc0NoZWNrT3JkZXJGaWVsZFR5cGUlMjIlM0JzJTNBNyUzQSUyMmNvbnRlbnQlMjIlM0JzJTNBMjIlM0ElMjJzT3JkZXJGaWVsZF9GaWVsZFZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMTglM0ElMjJibENoZWNrTWFpbF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTAlM0ElMjJzTWFpbFZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjElM0ElMjJibENoZWNrQ291bnRyeV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjclM0ElMjJibEFjdGlvbk9yZGVyMkZvbGRlcl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTIlM0ElMjJzT3JkZXJGb2xkZXIlMjIlM0JzJTNBMTUlM0ElMjJPUkRFUkZPTERFUl9ORVclMjIlM0JzJTNBMjYlM0ElMjJibEFjdGlvbk9yZGVyU3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNiUzQSUyMmJsQWN0aW9uT3JkZXJEZWxldGVfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTMyJTNBJTIyYmxBY3Rpb25PcmRlclNldFNlbmRlZE5vd19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMzAlM0ElMjJibEFjdGlvbk9yZGVyU2V0UGFpZE5vd19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMzMlM0ElMjJibEFjdGlvbk9yZGVyQWRkRmllbGRWYWx1ZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjElM0ElMjJzQWN0aW9uQWRkRmllbGRfZmllbGQlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMSUzQSUyMnNBY3Rpb25BZGRGaWVsZF92YWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTM4JTNBJTIyYmxBY3Rpb25PcmRlckNoYW5nZURlbGl2ZXJ5Q29zdF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjUlM0ElMjJzQWN0aW9uQ2hhbmdlRGVsQ29zdFZhbHVlJTIyJTNCcyUzQTQlM0ElMjIwLjAwJTIyJTNCcyUzQTM0JTNBJTIyYmxBY3Rpb25PcmRlckNoYW5nZURpc2NvdW50X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNiUzQSUyMnNBY3Rpb25DaGFuZ2VEaXNjb3VudFZhbHVlJTIyJTNCcyUzQTQlM0ElMjIwLjAwJTIyJTNCcyUzQTMxJTNBJTIyYmxBY3Rpb25PcmRlckdlbmVyYXRlUGRmX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0EyNyUzQSUyMmJsQWN0aW9uT3JkZXJQZGZUeXBlSW52b2ljZSUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0EyNyUzQSUyMmJsQWN0aW9uT3JkZXJQZGZUeXBlRGVsbm90ZSUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNiUzQSUyMmJsQWN0aW9uT3JkZXJQZGZTZW5kQXR0YWNoJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI0JTNBJTIyYmxBY3Rpb25PcmRlclBkZlNlbmRTYXZlJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTIyJTNBJTIyc0FjdGlvbk9yZGVyUGRmU2F2ZURpciUyMiUzQnMlM0ExMCUzQSUyMmV4cG9ydCUyRnBkZiUyMiUzQnMlM0EyNSUzQSUyMmJsQWN0aW9uQ3VzdDJHcm91cF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjglM0ElMjJibEFjdGlvbkN1c3RGcm9tR3JvdXBfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIzJTNBJTIyYmxBY3Rpb25NYWlsc2VuZF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjAlM0ElMjJzU2VuZE1haWxGcm9tU3ViamVjdCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTI1JTNBJTIyc1NlbmRNYWlsRnJvbVRlbXBsYXRlbmFtZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTMwJTNBJTIyc1NlbmRNYWlsRnJvbVRlbXBsYXRlbmFtZVBsYWluJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMTglM0ElMjJzU2VuZE1haWxGcm9tVGhlbWUlMjIlM0JzJTNBOCUzQSUyMmZyb250ZW5kJTIyJTNCcyUzQTI0JTNBJTIyc1NlbmRNYWlsRnJvbUNvbnRlbnRuYW1lJTIyJTNCcyUzQTMyJTNBJTIyODcwOWU0NWYzMWE4NjkwOWU5Zjk5OTIyMmU4MGIxZDAlMjIlM0JzJTNBMjklM0ElMjJzU2VuZE1haWxGcm9tQ29udGVudG5hbWVQbGFpbiUyMiUzQnMlM0EzMiUzQSUyMjg3MDllNDVmMzFhODY5MDllOWY5OTkyMjJlODBiMWQwJTIyJTNCcyUzQTIwJTNBJTIyYmxTZW5kTWFpbFRvQ3VzdG9tZXIlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTclM0ElMjJibFNlbmRNYWlsVG9Pd25lciUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExOCUzQSUyMmJsU2VuZE1haWxUb0N1c3RvbSUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNCUzQSUyMnNTZW5kTWFpbFRvQ3VzdG9tQWRkcmVzcyUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE5JTNBJTIyYmxHZXRTdG9ybm9BcnRpY2xlcyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQiU3RA==',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXFOLDER',
                'content'       => 'D3_ORDERMANAGER_ORDER_ORDERPROCESSING',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSORT',
                'content'       => '1100',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXWRITEPROTECTION',
                'content'       => "0",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_EXECMANUALLY',
                'content'       => "0",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_MARKORDER',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
        ];
    }

    /**
     * @param Shop $oShop
     *
     * @return array
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getExampleJobItem3InsertFields(Shop $oShop): array
    {
        $sShopId = $oShop->getId();
        $iShopBit = strlen($sShopId) == 1 ? $this->getD3BitMask()->getIntByBitPosition((int) $sShopId) : '1';

        return [
            [
                'fieldname'     => 'OXID',
                'content'       => "MD5('" . $this->sModKey . " job03 " . $sShopId . "')",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPID',
                'content'       => $sShopId,
                'force_update'  => true,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPINCL',
                'content'       => $iShopBit,
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPEXCL',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVE',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVEFROM',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVETO',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODID',
                'content'       => 'd3_ordermanager',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXTITLE',
                'content'       => 'mit Trackingcode als "versendet" markieren',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'de'),
                'content'       => 'mit Trackingcode als "versendet" markieren',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'en'),
                'content'       => 'trackcode orders mark as "sended"',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHORTDESC',
                'content'       => 'Alle Bestellungen, die einen Trackingcode erhalten, werden als "versendet" markiert. Der Kunde kann diesen Status abfragen oder wird per Mail informiert. Auf dem "versendet"-Status können andere Aufgaben aufbauen und weitere Aktionen auslösen.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXSHORTDESC', 'de'),
                'content'       => 'Alle Bestellungen, die einen Trackingcode erhalten, werden als "versendet" markiert. Der Kunde kann diesen Status abfragen oder wird per Mail informiert. Auf dem "versendet"-Status können andere Aufgaben aufbauen und weitere Aktionen auslösen.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXCREATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXUPDATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXUPDATE', 'de'),
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODVERSION',
                'content'       => $this->sModVersion,
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXLOG',
                'content'       => '15',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXVALUE',
                'content'       => 'TyUzQTglM0ElMjJzdGRDbGFzcyUyMiUzQTc1JTNBJTdCcyUzQTEzJTNBJTIyYmxJdGVtRXhlY3V0ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE0JTNBJTIyYmxJdGVtTWFpbFNlbmQlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMjUlM0ElMjJibENoZWNrRnJvbU9yZGVyTnJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE3JTNBJTIyc0Zyb21PcmRlck5yVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMyUzQSUyMmJsQ2hlY2tUb09yZGVyTnJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE1JTNBJTIyc1RvT3JkZXJOclZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVGltZXNwYW4xX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNUaW1lc3BhbjFWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMVVuaXQlMjIlM0JzJTNBNiUzQSUyMm1pbnV0ZSUyMiUzQnMlM0ExNCUzQSUyMnNUaW1lc3BhbjFUeXBlJTIyJTNCcyUzQTklM0ElMjJvcmRlcmRhdGUlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVGltZXNwYW4yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNUaW1lc3BhbjJWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMlVuaXQlMjIlM0JzJTNBNiUzQSUyMm1pbnV0ZSUyMiUzQnMlM0ExNCUzQSUyMnNUaW1lc3BhbjJUeXBlJTIyJTNCcyUzQTklM0ElMjJvcmRlcmRhdGUlMjIlM0JzJTNBMjQlM0ElMjJibENoZWNrTm90U2V0RGF0ZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTUlM0ElMjJzTm90U2V0RGF0ZVR5cGUlMjIlM0JzJTNBNyUzQSUyMmRlbGRhdGUlMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrV2Vla2RheXNfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTEzJTNBJTIyc1dlZWtkYXlzVHlwZSUyMiUzQnMlM0E5JTNBJTIyb3JkZXJkYXRlJTIyJTNCcyUzQTIxJTNBJTIyYmxDaGVja1BheW1lbnRfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIyJTNBJTIyYmxDaGVja0RlbGl2ZXJ5X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMyUzQSUyMmJsQ2hlY2tUcmFja2NvZGVfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja09yZGVyc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tPcmRlck5vc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tBcnRpY2xlc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tPcmRlclN1bV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTMlM0ElMjJzT3JkZXJTdW1UeXBlJTIyJTNCcyUzQTUlM0ElMjJ0b3RhbCUyMiUzQnMlM0ExNyUzQSUyMnNPcmRlclN1bVJlbGF0aW9uJTIyJTNCcyUzQTYlM0ElMjJoaWdoZXIlMjIlM0JzJTNBMTQlM0ElMjJzT3JkZXJTdW1WYWx1ZSUyMiUzQnMlM0E0JTNBJTIyMC4wMCUyMiUzQnMlM0EyNCUzQSUyMmJsQ2hlY2tJbnZvaWNlTnVtX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNSUzQSUyMmJsQ2hlY2tUcmFuc2FjdGlvbl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTclM0ElMjJzT3JkZXJUcmFuc1N0YXR1cyUyMiUzQnMlM0EyJTNBJTIyT0slMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrQ3VycmVuY3lfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE3JTNBJTIyc0N1cnJlbmN5SVNPVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tMYW5ndWFnZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrSW5Gb2xkZXJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja05vdEluRm9sZGVyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExNCUzQSUyMnNOb3RJbkZvbGRlcklkJTIyJTNCYSUzQTElM0ElN0JpJTNBMCUzQnMlM0EyMCUzQSUyMk9SREVSRk9MREVSX1BST0JMRU1TJTIyJTNCJTdEcyUzQTI3JTNBJTIyYmxDaGVja09yZGVyQXJ0aWNsZTFfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIwJTNBJTIyc0FydGljbGVDb250ZW50MVR5cGUlMjIlM0JzJTNBOCUzQSUyMm94YXJ0bnVtJTIyJTNCcyUzQTIyJTNBJTIyc0FydGljbGVDb250ZW50MVJlZ0V4cCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTI3JTNBJTIyYmxDaGVja09yZGVyQXJ0aWNsZTJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIwJTNBJTIyc0FydGljbGVDb250ZW50MlR5cGUlMjIlM0JzJTNBOCUzQSUyMm94YXJ0bnVtJTIyJTNCcyUzQTIyJTNBJTIyc0FydGljbGVDb250ZW50MlJlZ0V4cCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE4JTNBJTIyYmxDaGVja01haWxfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTEwJTNBJTIyc01haWxWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIxJTNBJTIyYmxDaGVja0NvdW50cnlfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI3JTNBJTIyYmxBY3Rpb25PcmRlcjJGb2xkZXJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTEyJTNBJTIyc09yZGVyRm9sZGVyJTIyJTNCcyUzQTIwJTNBJTIyT1JERVJGT0xERVJfRklOSVNIRUQlMjIlM0JzJTNBMjYlM0ElMjJibEFjdGlvbk9yZGVyU3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNiUzQSUyMmJsQWN0aW9uT3JkZXJEZWxldGVfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTMyJTNBJTIyYmxBY3Rpb25PcmRlclNldFNlbmRlZE5vd19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMzAlM0ElMjJibEFjdGlvbk9yZGVyU2V0UGFpZE5vd19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMzMlM0ElMjJibEFjdGlvbk9yZGVyQWRkRmllbGRWYWx1ZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjElM0ElMjJzQWN0aW9uQWRkRmllbGRfZmllbGQlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMSUzQSUyMnNBY3Rpb25BZGRGaWVsZF92YWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTM4JTNBJTIyYmxBY3Rpb25PcmRlckNoYW5nZURlbGl2ZXJ5Q29zdF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjUlM0ElMjJzQWN0aW9uQ2hhbmdlRGVsQ29zdFZhbHVlJTIyJTNCcyUzQTQlM0ElMjIwLjAwJTIyJTNCcyUzQTM0JTNBJTIyYmxBY3Rpb25PcmRlckNoYW5nZURpc2NvdW50X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNiUzQSUyMnNBY3Rpb25DaGFuZ2VEaXNjb3VudFZhbHVlJTIyJTNCcyUzQTQlM0ElMjIwLjAwJTIyJTNCcyUzQTI1JTNBJTIyYmxBY3Rpb25DdXN0Mkdyb3VwX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyOCUzQSUyMmJsQWN0aW9uQ3VzdEZyb21Hcm91cF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjMlM0ElMjJibEFjdGlvbk1haWxzZW5kX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMCUzQSUyMnNTZW5kTWFpbEZyb21TdWJqZWN0JTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjUlM0ElMjJzU2VuZE1haWxGcm9tVGVtcGxhdGVuYW1lJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMzAlM0ElMjJzU2VuZE1haWxGcm9tVGVtcGxhdGVuYW1lUGxhaW4lMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNCUzQSUyMnNTZW5kTWFpbEZyb21Db250ZW50bmFtZSUyMiUzQnMlM0EzMiUzQSUyMjg3MDllNDVmMzFhODY5MDllOWY5OTkyMjJlODBiMWQwJTIyJTNCcyUzQTI5JTNBJTIyc1NlbmRNYWlsRnJvbUNvbnRlbnRuYW1lUGxhaW4lMjIlM0JzJTNBMzIlM0ElMjI4NzA5ZTQ1ZjMxYTg2OTA5ZTlmOTk5MjIyZTgwYjFkMCUyMiUzQnMlM0EyMCUzQSUyMmJsU2VuZE1haWxUb0N1c3RvbWVyJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE3JTNBJTIyYmxTZW5kTWFpbFRvT3duZXIlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTglM0ElMjJibFNlbmRNYWlsVG9DdXN0b20lMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjQlM0ElMjJzU2VuZE1haWxUb0N1c3RvbUFkZHJlc3MlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNCUzQSUyMmJsQ2hlY2tPcmRlckZpZWxkX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMSUzQSUyMnNPcmRlckZpZWxkX0ZpZWxkTmFtZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIwJTNBJTIyc0NoZWNrT3JkZXJGaWVsZFR5cGUlMjIlM0JzJTNBNyUzQSUyMmNvbnRlbnQlMjIlM0JzJTNBMjIlM0ElMjJzT3JkZXJGaWVsZF9GaWVsZFZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0IlN0Q=',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXFOLDER',
                'content'       => 'D3_ORDERMANAGER_ORDER_ORDERPROCESSING',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSORT',
                'content'       => '2000',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXWRITEPROTECTION',
                'content'       => "0",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_EXECMANUALLY',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_MARKORDER',
                'content'       => '1',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
        ];
    }

    /**
     * @param Shop $oShop
     *
     * @return array
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getExampleJobItem4InsertFields(Shop $oShop): array
    {
        $sShopId = $oShop->getId();
        $iShopBit = strlen($sShopId) == 1 ? $this->getD3BitMask()->getIntByBitPosition((int) $sShopId) : '1';

        return [
            [
                'fieldname'     => 'OXID',
                'content'       => "MD5('" . $this->sModKey . " job04 " . $sShopId . "')",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPID',
                'content'       => $sShopId,
                'force_update'  => true,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPINCL',
                'content'       => $iShopBit,
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPEXCL',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVE',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVEFROM',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVETO',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODID',
                'content'       => 'd3_ordermanager',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXTITLE',
                'content'       => 'Lieferschwierigkeiten (Deutschland)',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'de'),
                'content'       => 'Lieferschwierigkeiten (Deutschland)',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'en'),
                'content'       => 'delivery delay (Germany)',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHORTDESC',
                'content'       => 'Ist z.B. ein bestimmter Artikel nicht lieferbar, informieren Sie alle Käufer dieses Artikels mit einer individuellen Mail. Für ausländische Kunden versendet die Aufgabe "Lieferschwierigkeiten (Ausland)" eine alternative Mail.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXSHORTDESC', 'de'),
                'content'       => 'Ist z.B. ein bestimmter Artikel nicht lieferbar, informieren Sie alle Käufer dieses Artikels mit einer individuellen Mail. Für ausländische Kunden versendet die Aufgabe "Lieferschwierigkeiten (Ausland)" eine alternative Mail.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXCREATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXUPDATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXUPDATE', 'de'),
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODVERSION',
                'content'       => $this->sModVersion,
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXLOG',
                'content'       => '15',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXVALUE',
                'content'       => 'TyUzQTglM0ElMjJzdGRDbGFzcyUyMiUzQTkzJTNBJTdCcyUzQTEzJTNBJTIyYmxJdGVtRXhlY3V0ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE0JTNBJTIyYmxJdGVtTWFpbFNlbmQlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMjUlM0ElMjJibENoZWNrRnJvbU9yZGVyTnJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE3JTNBJTIyc0Zyb21PcmRlck5yVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMyUzQSUyMmJsQ2hlY2tUb09yZGVyTnJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE1JTNBJTIyc1RvT3JkZXJOclZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVGltZXNwYW4xX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExNSUzQSUyMnNUaW1lc3BhbjFWYWx1ZSUyMiUzQnMlM0EyJTNBJTIyMTQlMjIlM0JzJTNBMTQlM0ElMjJzVGltZXNwYW4xVW5pdCUyMiUzQnMlM0EzJTNBJTIyZGF5JTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMVR5cGUlMjIlM0JzJTNBOSUzQSUyMm9yZGVyZGF0ZSUyMiUzQnMlM0EyMyUzQSUyMmJsQ2hlY2tUaW1lc3BhbjJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE1JTNBJTIyc1RpbWVzcGFuMlZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMTQlM0ElMjJzVGltZXNwYW4yVW5pdCUyMiUzQnMlM0E2JTNBJTIybWludXRlJTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMlR5cGUlMjIlM0JzJTNBOSUzQSUyMm9yZGVyZGF0ZSUyMiUzQnMlM0EyNCUzQSUyMmJsQ2hlY2tOb3RTZXREYXRlX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExNSUzQSUyMnNOb3RTZXREYXRlVHlwZSUyMiUzQnMlM0E3JTNBJTIyZGVsZGF0ZSUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tXZWVrZGF5c19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTMlM0ElMjJzV2Vla2RheXNUeXBlJTIyJTNCcyUzQTklM0ElMjJvcmRlcmRhdGUlMjIlM0JzJTNBMjElM0ElMjJibENoZWNrUGF5bWVudF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrRGVsaXZlcnlfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIzJTNBJTIyYmxDaGVja1RyYWNrY29kZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjUlM0ElMjJibENoZWNrT3JkZXJzdG9ybm9fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI3JTNBJTIyYmxDaGVja09yZGVyTm9zdG9ybm9fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTI3JTNBJTIyYmxDaGVja0FydGljbGVzdG9ybm9fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIyJTNBJTIyYmxDaGVja09yZGVyU3VtX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMyUzQSUyMnNPcmRlclN1bVR5cGUlMjIlM0JzJTNBNSUzQSUyMnRvdGFsJTIyJTNCcyUzQTE3JTNBJTIyc09yZGVyU3VtUmVsYXRpb24lMjIlM0JzJTNBNiUzQSUyMmhpZ2hlciUyMiUzQnMlM0ExNCUzQSUyMnNPcmRlclN1bVZhbHVlJTIyJTNCcyUzQTQlM0ElMjIwLjAwJTIyJTNCcyUzQTI0JTNBJTIyYmxDaGVja0ludm9pY2VOdW1fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja1RyYW5zYWN0aW9uX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExNyUzQSUyMnNPcmRlclRyYW5zU3RhdHVzJTIyJTNCcyUzQTIlM0ElMjJPSyUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tDdXJyZW5jeV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTclM0ElMjJzQ3VycmVuY3lJU09WYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIyJTNBJTIyYmxDaGVja0xhbmd1YWdlX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tJbkZvbGRlcl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjUlM0ElMjJibENoZWNrTm90SW5Gb2xkZXJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTE0JTNBJTIyc05vdEluRm9sZGVySWQlMjIlM0JhJTNBMSUzQSU3QmklM0EwJTNCcyUzQTIwJTNBJTIyT1JERVJGT0xERVJfUFJPQkxFTVMlMjIlM0IlN0RzJTNBMjclM0ElMjJibENoZWNrT3JkZXJBcnRpY2xlMV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMjAlM0ElMjJzQXJ0aWNsZUNvbnRlbnQxVHlwZSUyMiUzQnMlM0E3JTNBJTIyb3hjYXRpZCUyMiUzQnMlM0EyMiUzQSUyMnNBcnRpY2xlQ29udGVudDFSZWdFeHAlMjIlM0JzJTNBMzIlM0ElMjI2NjllYzE1ZjY5YWUyYzA5ZmVlZjM3ZDEwNzQ1NzkwMiUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tPcmRlckFydGljbGUyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMCUzQSUyMnNBcnRpY2xlQ29udGVudDJUeXBlJTIyJTNCcyUzQTglM0ElMjJveGFydG51bSUyMiUzQnMlM0EyMiUzQSUyMnNBcnRpY2xlQ29udGVudDJSZWdFeHAlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0ExOCUzQSUyMmJsQ2hlY2tNYWlsX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMCUzQSUyMnNNYWlsVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMSUzQSUyMmJsQ2hlY2tDb3VudHJ5X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExNCUzQSUyMnNDdXN0Q291bnRyeUlkJTIyJTNCYSUzQTElM0ElN0JpJTNBMCUzQnMlM0EyNiUzQSUyMmE3YzQwZjYzMWZjOTIwNjg3LjIwMTc5OTg0JTIyJTNCJTdEcyUzQTI3JTNBJTIyYmxBY3Rpb25PcmRlcjJGb2xkZXJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTEyJTNBJTIyc09yZGVyRm9sZGVyJTIyJTNCcyUzQTE1JTNBJTIyT1JERVJGT0xERVJfTkVXJTIyJTNCcyUzQTI2JTNBJTIyYmxBY3Rpb25PcmRlclN0b3Jub19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjYlM0ElMjJibEFjdGlvbk9yZGVyRGVsZXRlX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EzMiUzQSUyMmJsQWN0aW9uT3JkZXJTZXRTZW5kZWROb3dfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTMwJTNBJTIyYmxBY3Rpb25PcmRlclNldFBhaWROb3dfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTMzJTNBJTIyYmxBY3Rpb25PcmRlckFkZEZpZWxkVmFsdWVfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIxJTNBJTIyc0FjdGlvbkFkZEZpZWxkX2ZpZWxkJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjElM0ElMjJzQWN0aW9uQWRkRmllbGRfdmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EzOCUzQSUyMmJsQWN0aW9uT3JkZXJDaGFuZ2VEZWxpdmVyeUNvc3Rfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyc0FjdGlvbkNoYW5nZURlbENvc3RWYWx1ZSUyMiUzQnMlM0E0JTNBJTIyMC4wMCUyMiUzQnMlM0EzNCUzQSUyMmJsQWN0aW9uT3JkZXJDaGFuZ2VEaXNjb3VudF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjYlM0ElMjJzQWN0aW9uQ2hhbmdlRGlzY291bnRWYWx1ZSUyMiUzQnMlM0E0JTNBJTIyMC4wMCUyMiUzQnMlM0EyNSUzQSUyMmJsQWN0aW9uQ3VzdDJHcm91cF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjglM0ElMjJibEFjdGlvbkN1c3RGcm9tR3JvdXBfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIzJTNBJTIyYmxBY3Rpb25NYWlsc2VuZF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTklM0ElMjJzU2VuZE1haWxGcm9tU291cmNlJTIyJTNCcyUzQTglM0ElMjJ0ZW1wbGF0ZSUyMiUzQnMlM0EyMCUzQSUyMnNTZW5kTWFpbEZyb21TdWJqZWN0JTIyJTNCcyUzQTYyJTNBJTIydmlld3MlMkZ0cGwlMkZlbWFpbCUyRmh0bWwlMkZkM29yZGVybWFuYWdlcl9kZWxpdmVyeV9kZWxheV9zdWJqZWN0LnRwbCUyMiUzQnMlM0EyNSUzQSUyMnNTZW5kTWFpbEZyb21UZW1wbGF0ZW5hbWUlMjIlM0JzJTNBNTQlM0ElMjJ2aWV3cyUyRnRwbCUyRmVtYWlsJTJGaHRtbCUyRmQzb3JkZXJtYW5hZ2VyX2RlbGl2ZXJ5X2RlbGF5LnRwbCUyMiUzQnMlM0EzMCUzQSUyMnNTZW5kTWFpbEZyb21UZW1wbGF0ZW5hbWVQbGFpbiUyMiUzQnMlM0E1NSUzQSUyMnZpZXdzJTJGdHBsJTJGZW1haWwlMkZwbGFpbiUyRmQzb3JkZXJtYW5hZ2VyX2RlbGl2ZXJ5X2RlbGF5LnRwbCUyMiUzQnMlM0EyNCUzQSUyMnNTZW5kTWFpbEZyb21Db250ZW50bmFtZSUyMiUzQnMlM0EzMiUzQSUyMjg3MDllNDVmMzFhODY5MDllOWY5OTkyMjJlODBiMWQwJTIyJTNCcyUzQTI5JTNBJTIyc1NlbmRNYWlsRnJvbUNvbnRlbnRuYW1lUGxhaW4lMjIlM0JzJTNBMzIlM0ElMjI4NzA5ZTQ1ZjMxYTg2OTA5ZTlmOTk5MjIyZTgwYjFkMCUyMiUzQnMlM0EyMCUzQSUyMmJsU2VuZE1haWxUb0N1c3RvbWVyJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTE3JTNBJTIyYmxTZW5kTWFpbFRvT3duZXIlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTglM0ElMjJibFNlbmRNYWlsVG9DdXN0b20lMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMjQlM0ElMjJzU2VuZE1haWxUb0N1c3RvbUFkZHJlc3MlMjIlM0JzJTNBMjQlM0ElMjJidWNoaGFsdHVuZyU0MG94aWRlc2hvcC5kZSUyMiUzQnMlM0EyNCUzQSUyMmJsQ2hlY2tPcmRlckZpZWxkX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMSUzQSUyMnNPcmRlckZpZWxkX0ZpZWxkTmFtZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIyJTNBJTIyc09yZGVyRmllbGRfRmllbGRWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE4JTNBJTIyc1NlbmRNYWlsRnJvbVRoZW1lJTIyJTNCcyUzQTYlM0ElMjJtb2R1bGUlMjIlM0JzJTNBMTklM0ElMjJibEdldFN0b3Jub0FydGljbGVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTMxJTNBJTIyYmxBY3Rpb25PcmRlckdlbmVyYXRlUGRmX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNyUzQSUyMmJsQWN0aW9uT3JkZXJQZGZUeXBlSW52b2ljZSUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNyUzQSUyMmJsQWN0aW9uT3JkZXJQZGZUeXBlRGVsbm90ZSUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNiUzQSUyMmJsQWN0aW9uT3JkZXJQZGZTZW5kQXR0YWNoJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI0JTNBJTIyYmxBY3Rpb25PcmRlclBkZlNlbmRTYXZlJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTEzJTNBJTIyc0N1c3RBZGRHcm91cCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE2JTNBJTIyc0N1c3RSZW1vdmVHcm91cCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIzJTNBJTIyc1NlbmRNYWlsRnJvbU1vZHVsZVBhdGglMjIlM0JzJTNBMTQlM0ElMjJkM29yZGVybWFuYWdlciUyMiUzQnMlM0EyMSUzQSUyMnNTZW5kTWFpbFJlcGx5QWRkcmVzcyUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIxJTNBJTIyYmxBY3Rpb25FeHBvcnRfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE2JTNBJTIyYUV4cG9ydEZpZWxkTGlzdCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE5JTNBJTIyc0V4cG9ydFRlbXBsYXRlbmFtZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE2JTNBJTIyc0V4cG9ydEV4dGVuc2lvbiUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTMzJTNBJTIyYmxBY3Rpb25PcmRlckV4ZWN1dGVNZXRob2Rfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyc0FjdGlvbkV4ZWN1dGVNZXRob2RfbmFtZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCJTdE',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXFOLDER',
                'content'       => 'D3_ORDERMANAGER_ORDER_DELIVERYSTATUS',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSORT',
                'content'       => '2100',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXWRITEPROTECTION',
                'content'       => "0",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_EXECMANUALLY',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_MARKORDER',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
        ];
    }

    /**
     * @param Shop $oShop
     *
     * @return array
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getExampleJobItem5InsertFields(Shop $oShop): array
    {
        $sShopId = $oShop->getId();
        $iShopBit = strlen($sShopId) == 1 ? $this->getD3BitMask()->getIntByBitPosition((int) $sShopId) : '1';

        return [
            [
                'fieldname'     => 'OXID',
                'content'       => "MD5('" . $this->sModKey . " job05 " . $sShopId . "')",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPID',
                'content'       => $sShopId,
                'force_update'  => true,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPINCL',
                'content'       => $iShopBit,
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPEXCL',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVE',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVEFROM',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVETO',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODID',
                'content'       => 'd3_ordermanager',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXTITLE',
                'content'       => 'Lieferschwierigkeiten (Ausland)',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'de'),
                'content'       => 'Lieferschwierigkeiten (Ausland)',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'en'),
                'content'       => 'delivery delay (foreign countries)',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHORTDESC',
                'content'       => 'Ist der Versand eines Artikels außerhalb Deutschland unvorhergesehen nicht möglich, geben Sie Ihren Kunden Bescheid. Diese Aufgabe versendet personalisierte Mails an alle betroffenen Käufer.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXSHORTDESC', 'de'),
                'content'       => 'Ist der Versand eines Artikels außerhalb Deutschland unvorhergesehen nicht möglich, geben Sie Ihren Kunden Bescheid. Diese Aufgabe versendet personalisierte Mails an alle betroffenen Käufer.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXCREATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXUPDATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXUPDATE', 'de'),
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODVERSION',
                'content'       => $this->sModVersion,
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXLOG',
                'content'       => '15',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXVALUE',
                'content'       => 'TyUzQTglM0ElMjJzdGRDbGFzcyUyMiUzQTk1JTNBJTdCcyUzQTEzJTNBJTIyYmxJdGVtRXhlY3V0ZSUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNCUzQSUyMmJsSXRlbU1haWxTZW5kJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja0Zyb21PcmRlck5yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNyUzQSUyMnNGcm9tT3JkZXJOclZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVG9PcmRlck5yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNUb09yZGVyTnJWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIzJTNBJTIyYmxDaGVja1RpbWVzcGFuMV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTUlM0ElMjJzVGltZXNwYW4xVmFsdWUlMjIlM0JzJTNBMiUzQSUyMjIxJTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMVVuaXQlMjIlM0JzJTNBMyUzQSUyMmRheSUyMiUzQnMlM0ExNCUzQSUyMnNUaW1lc3BhbjFUeXBlJTIyJTNCcyUzQTklM0ElMjJvcmRlcmRhdGUlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVGltZXNwYW4yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNUaW1lc3BhbjJWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMlVuaXQlMjIlM0JzJTNBNiUzQSUyMm1pbnV0ZSUyMiUzQnMlM0ExNCUzQSUyMnNUaW1lc3BhbjJUeXBlJTIyJTNCcyUzQTklM0ElMjJvcmRlcmRhdGUlMjIlM0JzJTNBMjQlM0ElMjJibENoZWNrTm90U2V0RGF0ZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTUlM0ElMjJzTm90U2V0RGF0ZVR5cGUlMjIlM0JzJTNBNyUzQSUyMmRlbGRhdGUlMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrV2Vla2RheXNfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTEzJTNBJTIyc1dlZWtkYXlzVHlwZSUyMiUzQnMlM0E5JTNBJTIyb3JkZXJkYXRlJTIyJTNCcyUzQTIxJTNBJTIyYmxDaGVja1BheW1lbnRfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIyJTNBJTIyYmxDaGVja0RlbGl2ZXJ5X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMyUzQSUyMmJsQ2hlY2tUcmFja2NvZGVfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja09yZGVyc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tPcmRlck5vc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tBcnRpY2xlc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tPcmRlclN1bV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTMlM0ElMjJzT3JkZXJTdW1UeXBlJTIyJTNCcyUzQTUlM0ElMjJ0b3RhbCUyMiUzQnMlM0ExNyUzQSUyMnNPcmRlclN1bVJlbGF0aW9uJTIyJTNCcyUzQTYlM0ElMjJoaWdoZXIlMjIlM0JzJTNBMTQlM0ElMjJzT3JkZXJTdW1WYWx1ZSUyMiUzQnMlM0E0JTNBJTIyMC4wMCUyMiUzQnMlM0EyNCUzQSUyMmJsQ2hlY2tJbnZvaWNlTnVtX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNSUzQSUyMmJsQ2hlY2tUcmFuc2FjdGlvbl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTclM0ElMjJzT3JkZXJUcmFuc1N0YXR1cyUyMiUzQnMlM0EyJTNBJTIyT0slMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrQ3VycmVuY3lfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE3JTNBJTIyc0N1cnJlbmN5SVNPVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tMYW5ndWFnZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrSW5Gb2xkZXJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja05vdEluRm9sZGVyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tPcmRlckFydGljbGUxX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMCUzQSUyMnNBcnRpY2xlQ29udGVudDFUeXBlJTIyJTNCcyUzQTglM0ElMjJveGFydG51bSUyMiUzQnMlM0EyMiUzQSUyMnNBcnRpY2xlQ29udGVudDFSZWdFeHAlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tPcmRlckFydGljbGUyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMCUzQSUyMnNBcnRpY2xlQ29udGVudDJUeXBlJTIyJTNCcyUzQTglM0ElMjJveGFydG51bSUyMiUzQnMlM0EyMiUzQSUyMnNBcnRpY2xlQ29udGVudDJSZWdFeHAlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0ExOCUzQSUyMmJsQ2hlY2tNYWlsX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMCUzQSUyMnNNYWlsVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMSUzQSUyMmJsQ2hlY2tDb3VudHJ5X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExNCUzQSUyMnNDdXN0Q291bnRyeUlkJTIyJTNCYSUzQTI0NiUzQSU3QmklM0EwJTNCcyUzQTI2JTNBJTIyMmRiNDU1ODI0ZTRhMTljYzcuMTQ3MzEzMjglMjIlM0JpJTNBMSUzQnMlM0EyNiUzQSUyMmE3YzQwZjYzMjBhZWIyZWMyLjcyODg1MjU5JTIyJTNCaSUzQTIlM0JzJTNBMjYlM0ElMjJhN2M0MGY2MzIxYzZmNjEwOS40Mzg1OTI0OCUyMiUzQmklM0EzJTNCcyUzQTI2JTNBJTIyYTdjNDBmNjMyMmQ4NDJhZTMuODMzMzE5MjAlMjIlM0JpJTNBNCUzQnMlM0EyNiUzQSUyMmE3YzQwZjYzMjNjNGJmYjM2LjU5OTE5NDMzJTIyJTNCaSUzQTUlM0JzJTNBMjYlM0ElMjJhN2M0MGY2MzI2NDMwOWUwNS41ODU3NjY4MCUyMiUzQmklM0E2JTNCcyUzQTI2JTNBJTIyYTdjNDBmNjMyNzJhNTcyOTYuMzIxMTc1ODAlMjIlM0JpJTNBNyUzQnMlM0EyNiUzQSUyMmE3YzQwZjYzMjg0OGM1MjE3LjUzMzIyMzM5JTIyJTNCaSUzQTglM0JzJTNBMjYlM0ElMjJhN2M0MGY2MzI5M2MxOWQ2NS4zNzQ3MjgxNCUyMiUzQmklM0E5JTNCcyUzQTI2JTNBJTIyYTdjNDBmNjMyYTA4MDRhYjUuMTg4MDQwNzYlMjIlM0JpJTNBMTAlM0JzJTNBMjYlM0ElMjJhN2M0MGY2MzJiZTQyMzdjMi40ODUxNzkxMiUyMiUzQmklM0ExMSUzQnMlM0EyNiUzQSUyMmE3YzQwZjYzMmNkZDYzYzUyLjY0MjcyNjIzJTIyJTNCaSUzQTEyJTNCcyUzQTI2JTNBJTIyYTdjNDBmNjMyZTA0NjMzYzkuNDcxOTQwNDIlMjIlM0JpJTNBMTMlM0JzJTNBMjYlM0ElMjJhN2M0MGY2MzJmNjViZDhlMi44NDk2MzI3MiUyMiUzQmklM0ExNCUzQnMlM0EyNiUzQSUyMmE3YzQwZjYzMzAzOGNkNTc4LjIyOTc1NDQyJTIyJTNCaSUzQTE1JTNCcyUzQTI2JTNBJTIyYTdjNDBmNjMzMTE0ZThmYzYuMjUyNTc0NzclMjIlM0JpJTNBMTYlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTMwNjQ1MS4zNjk5ODIyNSUyMiUzQmklM0ExNyUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1MzI2NWE1LjI1Mjg2MTM0JTIyJTNCaSUzQTE4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTUzM2I5NDMuNTAyODc5MDAlMjIlM0JpJTNBMTklM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTM0ZjhjNy44MDM0OTkzMSUyMiUzQmklM0EyMCUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1MzYzNDY0Ljg5NjU3MjIyJTIyJTNCaSUzQTIxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTUzNzdkMzMuMjg2Nzg5MDElMjIlM0JpJTNBMjIlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTM5MmU0MS43NDM5NzQ5MSUyMiUzQmklM0EyMyUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1M2E4ZDEwLjI5NDc0ODQ4JTIyJTNCaSUzQTI0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTUzYmU4ZjIuNTYyNDgxMzQlMjIlM0JpJTNBMjUlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTNkMmZiMC41NDI2MDU0NyUyMiUzQmklM0EyNiUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1M2U3OTkzLjg4MTgwMzYwJTIyJTNCaSUzQTI3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTUzZmFjYzYuMzE2MjEwMzYlMjIlM0JpJTNBMjglM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTQxMGYzOC4zNzE2NTM2MSUyMiUzQmklM0EyOSUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1NDNjZjQ3LjE3ODc3MDE1JTIyJTNCaSUzQTMwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU0NTEzNzkuNzIwNzg4NzElMjIlM0JpJTNBMzElM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTQ2NjJlMy4yNzA1MTY1NCUyMiUzQmklM0EzMiUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1NDdhZTQ5LjYwMTU0NDMxJTIyJTNCaSUzQTMzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU0OTcwODMuMjExODE3MjUlMjIlM0JpJTNBMzQlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTRhYzViOS42MzEwNTIwMyUyMiUzQmklM0EzNSUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1NGQzNjIxLjQ1MzYyNTE1JTIyJTNCaSUzQTM2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU0ZWEwNjUuNDE0NTU4NDglMjIlM0JpJTNBMzclM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTRmZWUxMy41MDAxMTk0OCUyMiUzQmklM0EzOCUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1NTEzY2EwLjc1MzQ5NzMxJTIyJTNCaSUzQTM5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU1MmFlZTIuOTEwMDQ5NjUlMjIlM0JpJTNBNDAlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTUzZjkwMi4wNjk2MDQzOCUyMiUzQmklM0E0MSUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1NTU0ODM0LjU0MTk5NDgzJTIyJTNCaSUzQTQyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU1NmRkNTcuODQyOTIyODIlMjIlM0JpJTNBNDMlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTU5MjQwNy44OTk4NjE0MyUyMiUzQmklM0E0NCUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1NWE3NjQ0LjY4ODU5MTgwJTIyJTNCaSUzQTQ1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU1YmRlNjEuNjMyNTYwNDIlMjIlM0JpJTNBNDYlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTVkMzI2MC41NTQ4NzUzOSUyMiUzQmklM0E0NyUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1NWVhN2M4LjM2NzYyNjU0JTIyJTNCaSUzQTQ4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU2MDA0ZDUuMTE1MzQxODIlMjIlM0JpJTNBNDklM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTYxNzVmOS44MTY4MjAzNSUyMiUzQmklM0E1MCUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1NjMyODI4LjIwMjYzNTc0JTIyJTNCaSUzQTUxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU2NDlkMTguMDI2NzYwNTklMjIlM0JpJTNBNTIlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTY1ZTY3MS40ODg3NjM1NCUyMiUzQmklM0E1MyUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1NjczMjQ4LjUwNDA1ODUyJTIyJTNCaSUzQTU0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU2OGE1MDkuMDM1NjYwMzAlMjIlM0JpJTNBNTUlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTY5ZDRjMi40MjgwMDAzOSUyMiUzQmklM0E1NiUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1NmIzZWE3LjExMTY4MjcwJTIyJTNCaSUzQTU3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU2Yzg4NjAuMzc5ODE4NDUlMjIlM0JpJTNBNTglM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTZkZjZiMi41MjI4MzQyOCUyMiUzQmklM0E1OSUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1NmY1NGI0LjI2MzI3ODQ5JTIyJTNCaSUzQTYwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU3MGExZTMuNjk3NzI2MzglMjIlM0JpJTNBNjElM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTcxZjAxOC40NjI1MTUzNSUyMiUzQmklM0E2MiUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1NzMyMTg0LjcyNzcxOTg2JTIyJTNCaSUzQTYzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU3NDZhOTIuOTQ4Nzg0NDElMjIlM0JpJTNBNjQlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTc1ZDcwOC4yMDA4NDE1MCUyMiUzQmklM0E2NSUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1NzcxZjc2Ljg3OTA0MTIyJTIyJTNCaSUzQTY2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU3ODlhMDQuNjUxNTQyNDYlMjIlM0JpJTNBNjclM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTc5ZWY0OS45MTgwMzI0MiUyMiUzQmklM0E2OCUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1N2I2ODk2LjUyNzI1MTUwJTIyJTNCaSUzQTY5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU3Y2I0NTcuOTc4MjA5MTglMjIlM0JpJTNBNzAlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTdlNmVmOC41NjQ1ODQxOCUyMiUzQmklM0E3MSUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1N2ZkMzU2LjAyOTE4NjQ1JTIyJTNCaSUzQTcyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU4MTFlYTUuODQ3MTc4NDQlMjIlM0JpJTNBNzMlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTgyNWJmMi42MTA2MzM1NSUyMiUzQmklM0E3NCUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1ODM5MzIzLjg2NzU1MTY5JTIyJTNCaSUzQTc1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU4NGQ1MTIuMDY2NjM3ODklMjIlM0JpJTNBNzYlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTg2MWZiNy41NTI3ODI1NiUyMiUzQmklM0E3NyUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1ODczNmE5LjA2MDYxMjM3JTIyJTNCaSUzQTc4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU4OGQwNzcuNzQyODQ0OTAlMjIlM0JpJTNBNzklM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NThhMjIxNi4zODMyNDUzMSUyMiUzQmklM0E4MCUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1OGI2OWU0LjkzODg2MTcxJTIyJTNCaSUzQTgxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU4Y2FmNjcuMDg5ODIzMTMlMjIlM0JpJTNBODIlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NThlMmNjMy45MDc3MDI0OSUyMiUzQmklM0E4MyUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1OGY3YmE0Ljk2OTA4MDY1JTIyJTNCaSUzQTg0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU5MGQyMjYuMDc5Mzg3MjklMjIlM0JpJTNBODUlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTk0ZmNiMS43OTQ0MTc4MCUyMiUzQmklM0E4NiUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1OTYzNmY1LjcxNDc2MzU0JTIyJTNCaSUzQTg3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU5Nzg0YTMuMzQyNjQ4MjklMjIlM0JpJTNBODglM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTk5NGNiNi41OTM1MzM5MiUyMiUzQmklM0E4OSUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1OWFjZTc3LjE3Mzc5MzE5JTIyJTNCaSUzQTkwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU5YzIzNDEuMDE4MzAxOTklMjIlM0JpJTNBOTElM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NTllOTZiMy4wNTc1MjE1MiUyMiUzQmklM0E5MiUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1OWZkZGUwLjY4OTE5NDA1JTIyJTNCaSUzQTkzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVhMjlmNDcuMDQxMDIzNDMlMjIlM0JpJTNBOTQlM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NWEzZjE5NS44ODg4Njc4OSUyMiUzQmklM0E5NSUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1YTUyNTc4LjQ1NDEzNDkzJTIyJTNCaSUzQTk2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVhNzE3YjMuNjgxMjY2ODElMjIlM0JpJTNBOTclM0JzJTNBMjYlM0ElMjI4ZjI0MWYxMTA5NWE4NzBhNS40MjIzNTYzNSUyMiUzQmklM0E5OCUzQnMlM0EyNiUzQSUyMjhmMjQxZjExMDk1YTliZjgyLjE5OTg5NTU3JTIyJTNCaSUzQTk5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVhYjJiNTYuODMwNDkyODAlMjIlM0JpJTNBMTAwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVhYzlkMzAuNTY2NDA0MjklMjIlM0JpJTNBMTAxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVhZWJiMDYuMzQ0MDUxNzklMjIlM0JpJTNBMTAyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVhZmYyYzMuOTgwNTQ3NTUlMjIlM0JpJTNBMTAzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTViMTNmNTcuNTYwMjIzMDUlMjIlM0JpJTNBMTA0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTViMjkwMjEuNDk2NTcxMTglMjIlM0JpJTNBMTA1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTViM2UwMTYuOTgyMTMxNzMlMjIlM0JpJTNBMTA2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTViNTU4NDYuMjYxOTI2MDIlMjIlM0JpJTNBMTA3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTViNmJiODYuMDEzNjQ5MDQlMjIlM0JpJTNBMTA4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTViODA1MjYuNTk5Mjc2MzElMjIlM0JpJTNBMTA5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTViOTQ0NzYuMDUxOTU4MzIlMjIlM0JpJTNBMTEwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTViYWQ1YjIuNDI2NDU3MjQlMjIlM0JpJTNBMTExJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTViZDY1ZTEuNTk0NTk2ODMlMjIlM0JpJTNBMTEyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTViZmU4MzQuNjMzOTAxODUlMjIlM0JpJTNBMTEzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVjMTFkNDMuNzM0MTk3NDclMjIlM0JpJTNBMTE0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVjMmIzMDQuNzU5MDY5NjIlMjIlM0JpJTNBMTE1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVjM2UyZDEuMzY3MTQ0NjMlMjIlM0JpJTNBMTE2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVjNWI4ZTguNjYzMzM2NzklMjIlM0JpJTNBMTE3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVjNmUxODQuMjE0NTA2MTglMjIlM0JpJTNBMTE4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVjODcyODQuMzc5ODI1NDQlMjIlM0JpJTNBMTE5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVjOWRlNjQuMDEyNzU3MjYlMjIlM0JpJTNBMTIwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVjYjE1NDYuNDY2NTIxNzQlMjIlM0JpJTNBMTIxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVjYzdlZjUuMjgwNDM3NjclMjIlM0JpJTNBMTIyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVjZGNjZDUuOTYzODg4MDglMjIlM0JpJTNBMTIzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVjZjJlYTYuNzM5MjU1MTElMjIlM0JpJTNBMTI0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVkMDdkODcuNTg5ODYxMjklMjIlM0JpJTNBMTI1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVkMWM5YjIuMjE1NDgxMzIlMjIlM0JpJTNBMTI2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVkMmZkMjguOTE4NTg5MDglMjIlM0JpJTNBMTI3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVkNDYxODguNjQ2Nzk2MDUlMjIlM0JpJTNBMTI4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVkNmZmYTguODY1OTMyMzYlMjIlM0JpJTNBMTI5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVkOWMxYjIuMTM1NzcwMzMlMjIlM0JpJTNBMTMwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVkYjIyOTEuNTg5MTI4ODclMjIlM0JpJTNBMTMxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVkY2NmMTcuMDYyNjY4MDYlMjIlM0JpJTNBMTMyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVkZTIxMTkuNjA3OTU4MzMlMjIlM0JpJTNBMTMzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVkZjc4YTguNDQ1NTk1MDYlMjIlM0JpJTNBMTM0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVlMGM2YzkuNDM3NDY0NzclMjIlM0JpJTNBMTM1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVlMjQwMDYuMTcxNDE3MTUlMjIlM0JpJTNBMTM2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVlMzZlYjMuNjkwNTA1MDklMjIlM0JpJTNBMTM3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVlNGUzMzguMjY4MTcyNDQlMjIlM0JpJTNBMTM4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVlNjMxZTEuMjk0NzY0ODQlMjIlM0JpJTNBMTM5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVlN2JmZjkuMDk1MTgyNzElMjIlM0JpJTNBMTQwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVlOTBhODEuMDExNTYzOTMlMjIlM0JpJTNBMTQxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVlYTYyNDkuODE0NzQyNDYlMjIlM0JpJTNBMTQyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVlYmYzYTYuODYzODg1NzclMjIlM0JpJTNBMTQzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVlZDQ5MDIuNDkyNzYxOTclMjIlM0JpJTNBMTQ0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVlZTk5MjMuODUxNzU2NTMlMjIlM0JpJTNBMTQ1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVmMDBkNjUuMzAzMTgzMzAlMjIlM0JpJTNBMTQ2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVmMTYwYzkuNDEwNTk0NDElMjIlM0JpJTNBMTQ3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTVmMzE0ZjUuMDU4MzAzMjQlMjIlM0JpJTNBMTQ4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYwMDY4MjguNDkyODU1OTElMjIlM0JpJTNBMTQ5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYwMWI0MTkuNTUyNjk2OTElMjIlM0JpJTNBMTUwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYwMzBhZjUuNjU0NDkwNDMlMjIlM0JpJTNBMTUxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYwNDY1NzUuMzEzODIwNjAlMjIlM0JpJTNBMTUyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYwNWIxZjQuMjA1NzQ4OTUlMjIlM0JpJTNBMTUzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYwN2E5ZTcuMDM0ODY0NTAlMjIlM0JpJTNBMTU0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYwYWViNjQuMDk3NTcwMTAlMjIlM0JpJTNBMTU1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYwYzNlOTcuMjE5MDE0NzElMjIlM0JpJTNBMTU2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYwZDhlNTguOTY0NjYxMDMlMjIlM0JpJTNBMTU3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYwZWMzNDUuNzE4MDUwNTYlMjIlM0JpJTNBMTU4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYxMDFhNzkuNzA1MTMyMjclMjIlM0JpJTNBMTU5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYxMTY3NDQuOTIwMDgwOTIlMjIlM0JpJTNBMTYwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYxMmRjNjguNjM4MDY5OTIlMjIlM0JpJTNBMTYxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYxNDQyYzIuODI1NzM4OTglMjIlM0JpJTNBMTYyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYxNjI2NzguNzExNjQwODElMjIlM0JpJTNBMTYzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYxNzY3OTUuNjEyNTcwNjclMjIlM0JpJTNBMTY0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYxOGQ4MjUuODc2NjE5MjYlMjIlM0JpJTNBMTY1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYxYTI0MDEuNTkwMzk3NDAlMjIlM0JpJTNBMTY2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYxYjc3MjkuMTQyOTA0OTAlMjIlM0JpJTNBMTY3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYxY2MzODQuMTgxNjY1NjAlMjIlM0JpJTNBMTY4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYxZTM1MzguNzg0MzUzMDclMjIlM0JpJTNBMTY5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYxZjlkNjEuNTI3OTQyNzMlMjIlM0JpJTNBMTcwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYyMGIyNDUuMTYyNjE1MDYlMjIlM0JpJTNBMTcxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYyMWZhZjguNDAxMzU1NTYlMjIlM0JpJTNBMTcyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYyMzRkNjIuNDQxMjU5OTIlMjIlM0JpJTNBMTczJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYyNGQzZjguNTA5NTM2MDUlMjIlM0JpJTNBMTc0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYyNzlhMjIuNTA1ODI0NzklMjIlM0JpJTNBMTc1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYyOGY5MDMuNTE0NzgyOTElMjIlM0JpJTNBMTc2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYyYTNlYzUuNjU4NTcyNDAlMjIlM0JpJTNBMTc3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYyYzMwMDcuNjAzNjM1NzMlMjIlM0JpJTNBMTc4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYyZTQwZTYuNzUwNjIxNTMlMjIlM0JpJTNBMTc5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYyZjg2MTUuOTM2NjY1NjAlMjIlM0JpJTNBMTgwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYzMTc3YTcuNDkyODk5MDAlMjIlM0JpJTNBMTgxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYzMmZhYjQuNjg2NDY3NDAlMjIlM0JpJTNBMTgyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYzNDQzYzMuMjk1OTg4MDklMjIlM0JpJTNBMTgzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYzNTk5ODYuMDY0NzYyMjElMjIlM0JpJTNBMTg0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYzNzU3NTcuNDQxMjY5NDYlMjIlM0JpJTNBMTg1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYzOWI4YzQuNTc0ODQ5ODQlMjIlM0JpJTNBMTg2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYzYjliMjAuNDE1MDA3MDklMjIlM0JpJTNBMTg3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYzZDk5NjIuMzYzMDcxNDQlMjIlM0JpJTNBMTg4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTYzZjk4ZDguNjg0MjgzNzklMjIlM0JpJTNBMTg5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY0MTg0OTYuNzcyNTMwNzklMjIlM0JpJTNBMTkwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY0MzY5NjguNjk1NTEzNTElMjIlM0JpJTNBMTkxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY0NTZhNDguNzk2MDg4MDUlMjIlM0JpJTNBMTkyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY0N2EyNjUuMjk5MzgxNTQlMjIlM0JpJTNBMTkzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY0OTcxNDkuODUxMTYyNTQlMjIlM0JpJTNBMTk0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY0YjdiZjkuNDk1MDE4MzUlMjIlM0JpJTNBMTk1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY0ZDVmMjkuMTEzOTgzMDglMjIlM0JpJTNBMTk2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY0ZjI2MjMuNzQ5NzY4NzYlMjIlM0JpJTNBMTk3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY1MzEzMzAuMDMxOTgwODMlMjIlM0JpJTNBMTk4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY1NGRjYTQuOTk0NjY0MzQlMjIlM0JpJTNBMTk5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY1NmNkZTkuMTA4MTYwNzglMjIlM0JpJTNBMjAwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY1OGNiZTUuMDgyOTM5OTElMjIlM0JpJTNBMjAxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY1YzczNDcuNzUxMDg2ODElMjIlM0JpJTNBMjAyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY1ZWI3YjcuMjYxNDk3NDIlMjIlM0JpJTNBMjAzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY2MGMxMTMuNjI3ODA3MTglMjIlM0JpJTNBMjA0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY2NmI3ZjMuODE0MzU4OTglMjIlM0JpJTNBMjA1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY2ODdlYzcuNTg4MjQ3MzUlMjIlM0JpJTNBMjA2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY2YTU0ZDEuNDM3OTg5OTclMjIlM0JpJTNBMjA3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY2YzNhNzUuNjgyOTc5NjAlMjIlM0JpJTNBMjA4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY3MDdlMDguNjA1MTI3MDklMjIlM0JpJTNBMjA5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY3MjQxZTEuMzQ5MjUyMjAlMjIlM0JpJTNBMjEwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY3NDI1NjUuNzIxMzg4NzUlMjIlM0JpJTNBMjExJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY3NjJiMzEuMDMwNjkyNDQlMjIlM0JpJTNBMjEyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY3N2VkMjMuODQ4ODY2NzElMjIlM0JpJTNBMjEzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY3OWQ5ODguNDYwMDQzMjIlMjIlM0JpJTNBMjE0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY3YmJhNDAuODgyMzMyMDQlMjIlM0JpJTNBMjE1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY3ZDhmNjUuNTI2OTk3OTYlMjIlM0JpJTNBMjE2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY3ZjczZjguMTMxNDE0OTIlMjIlM0JpJTNBMjE3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY4MGVjMzAuOTc0MjY5NjMlMjIlM0JpJTNBMjE4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY4MjMwMTkuNDc4NDYzNjglMjIlM0JpJTNBMjE5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY4MzkxZDIuMzcxOTk4MTIlMjIlM0JpJTNBMjIwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY4NGJmMTUuNjMwNzEyNzklMjIlM0JpJTNBMjIxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY4NzdhYzAuOTg3NDg4MjYlMjIlM0JpJTNBMjIyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY4OTQ5NzcuNDEyMzk1NTMlMjIlM0JpJTNBMjIzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY4YTdjYzkuNTY3MTAxNDMlMjIlM0JpJTNBMjI0JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY4YmVjNDUuNDQxNjE4NTclMjIlM0JpJTNBMjI1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY4ZDNmMDMuMTM2MzAzMzQlMjIlM0JpJTNBMjI2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY4ZWJjMzAuNjM3OTI3NDYlMjIlM0JpJTNBMjI3JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY5MDJkOTIuMTQ3NDI0ODYlMjIlM0JpJTNBMjI4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY5MTlkMDAuOTI1MzQ5MjclMjIlM0JpJTNBMjI5JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY5MmZjMDQuMTUyMTYwMzQlMjIlM0JpJTNBMjMwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY5NDQ0NjguNjE5NTY1NzMlMjIlM0JpJTNBMjMxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY5NTk4YzguNzY5NjYxMTMlMjIlM0JpJTNBMjMyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY5NmU0ZTkuMzMwMDYyOTIlMjIlM0JpJTNBMjMzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY5ODIzNTQuNzM0NDg5NTglMjIlM0JpJTNBMjM0JTNCcyUzQTI2JTNBJTIyYTdjNDBmNjMyYTA4MDRhYjUuMTg4MDQwOTklMjIlM0JpJTNBMjM1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY5YzM0YTIuNDI1NjQ3MzAlMjIlM0JpJTNBMjM2JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY5ZGE2OTkuMDQxODU4ODglMjIlM0JpJTNBMjM3JTNCcyUzQTI2JTNBJTIyNTZkMzA4YTgyMmMxOGUxMDYuM2JhNTkwNDglMjIlM0JpJTNBMjM4JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTU3NWQ3MDguMjAwODQxOTklMjIlM0JpJTNBMjM5JTNCcyUzQTI2JTNBJTIyNTZkMzA4YTgyMmMxOGUxMDYuM2JhNTkwOTklMjIlM0JpJTNBMjQwJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY5ODIzNTQuNzM0NDg5OTklMjIlM0JpJTNBMjQxJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY5NDQ0NjguNjE5NTY1OTklMjIlM0JpJTNBMjQyJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY4ZWJjMzAuNjM3OTI3OTklMjIlM0JpJTNBMjQzJTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTY4YTdjYzkuNTY3MTAxOTklMjIlM0JpJTNBMjQ0JTNCcyUzQTI2JTNBJTIyYTdjNDBmNjMyZjY1YmQ4ZTIuODQ5NjMyOTklMjIlM0JpJTNBMjQ1JTNCcyUzQTI2JTNBJTIyOGYyNDFmMTEwOTUzM2I5NDMuNTAyODc5OTklMjIlM0IlN0RzJTNBMjclM0ElMjJibEFjdGlvbk9yZGVyMkZvbGRlcl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTIlM0ElMjJzT3JkZXJGb2xkZXIlMjIlM0JzJTNBMjAlM0ElMjJPUkRFUkZPTERFUl9QUk9CTEVNUyUyMiUzQnMlM0EyNiUzQSUyMmJsQWN0aW9uT3JkZXJTdG9ybm9fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI2JTNBJTIyYmxBY3Rpb25PcmRlckRlbGV0ZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMzIlM0ElMjJibEFjdGlvbk9yZGVyU2V0U2VuZGVkTm93X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EzMCUzQSUyMmJsQWN0aW9uT3JkZXJTZXRQYWlkTm93X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EzMyUzQSUyMmJsQWN0aW9uT3JkZXJBZGRGaWVsZFZhbHVlX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMSUzQSUyMnNBY3Rpb25BZGRGaWVsZF9maWVsZCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIxJTNBJTIyc0FjdGlvbkFkZEZpZWxkX3ZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMzglM0ElMjJibEFjdGlvbk9yZGVyQ2hhbmdlRGVsaXZlcnlDb3N0X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNSUzQSUyMnNBY3Rpb25DaGFuZ2VEZWxDb3N0VmFsdWUlMjIlM0JzJTNBNCUzQSUyMjAuMDAlMjIlM0JzJTNBMzQlM0ElMjJibEFjdGlvbk9yZGVyQ2hhbmdlRGlzY291bnRfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI2JTNBJTIyc0FjdGlvbkNoYW5nZURpc2NvdW50VmFsdWUlMjIlM0JzJTNBNCUzQSUyMjAuMDAlMjIlM0JzJTNBMjUlM0ElMjJibEFjdGlvbkN1c3QyR3JvdXBfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI4JTNBJTIyYmxBY3Rpb25DdXN0RnJvbUdyb3VwX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMyUzQSUyMmJsQWN0aW9uTWFpbHNlbmRfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTE5JTNBJTIyc1NlbmRNYWlsRnJvbVNvdXJjZSUyMiUzQnMlM0E4JTNBJTIydGVtcGxhdGUlMjIlM0JzJTNBMjAlM0ElMjJzU2VuZE1haWxGcm9tU3ViamVjdCUyMiUzQnMlM0E2MiUzQSUyMnZpZXdzJTJGdHBsJTJGZW1haWwlMkZodG1sJTJGZDNvcmRlcm1hbmFnZXJfZGVsaXZlcnlfZGVsYXlfc3ViamVjdC50cGwlMjIlM0JzJTNBMjUlM0ElMjJzU2VuZE1haWxGcm9tVGVtcGxhdGVuYW1lJTIyJTNCcyUzQTU0JTNBJTIydmlld3MlMkZ0cGwlMkZlbWFpbCUyRmh0bWwlMkZkM29yZGVybWFuYWdlcl9kZWxpdmVyeV9kZWxheS50cGwlMjIlM0JzJTNBMzAlM0ElMjJzU2VuZE1haWxGcm9tVGVtcGxhdGVuYW1lUGxhaW4lMjIlM0JzJTNBNTUlM0ElMjJ2aWV3cyUyRnRwbCUyRmVtYWlsJTJGcGxhaW4lMkZkM29yZGVybWFuYWdlcl9kZWxpdmVyeV9kZWxheS50cGwlMjIlM0JzJTNBMjQlM0ElMjJzU2VuZE1haWxGcm9tQ29udGVudG5hbWUlMjIlM0JzJTNBMzIlM0ElMjI4NzA5ZTQ1ZjMxYTg2OTA5ZTlmOTk5MjIyZTgwYjFkMCUyMiUzQnMlM0EyOSUzQSUyMnNTZW5kTWFpbEZyb21Db250ZW50bmFtZVBsYWluJTIyJTNCcyUzQTMyJTNBJTIyODcwOWU0NWYzMWE4NjkwOWU5Zjk5OTIyMmU4MGIxZDAlMjIlM0JzJTNBMjAlM0ElMjJibFNlbmRNYWlsVG9DdXN0b21lciUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExNyUzQSUyMmJsU2VuZE1haWxUb093bmVyJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE4JTNBJTIyYmxTZW5kTWFpbFRvQ3VzdG9tJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTI0JTNBJTIyc1NlbmRNYWlsVG9DdXN0b21BZGRyZXNzJTIyJTNCcyUzQTI0JTNBJTIyYnVjaGhhbHR1bmclNDBveGlkZXNob3AuZGUlMjIlM0JzJTNBMjUlM0ElMjJpVW5tYXJrRXhlY0RlbGF5VGltZVZhbHVlJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTI0JTNBJTIyc1VubWFya0V4ZWNEZWxheVRpbWVVbml0JTIyJTNCcyUzQTQlM0ElMjJkYXlzJTIyJTNCcyUzQTE0JTNBJTIyc05vdEluRm9sZGVySWQlMjIlM0JhJTNBMSUzQSU3QmklM0EwJTNCcyUzQTIwJTNBJTIyT1JERVJGT0xERVJfUFJPQkxFTVMlMjIlM0IlN0RzJTNBMjQlM0ElMjJibENoZWNrT3JkZXJGaWVsZF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjElM0ElMjJzT3JkZXJGaWVsZF9GaWVsZE5hbWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMiUzQSUyMnNPcmRlckZpZWxkX0ZpZWxkVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EzMSUzQSUyMmJsQWN0aW9uT3JkZXJHZW5lcmF0ZVBkZl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjclM0ElMjJibEFjdGlvbk9yZGVyUGRmVHlwZUludm9pY2UlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjclM0ElMjJibEFjdGlvbk9yZGVyUGRmVHlwZURlbG5vdGUlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjYlM0ElMjJibEFjdGlvbk9yZGVyUGRmU2VuZEF0dGFjaCUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNCUzQSUyMmJsQWN0aW9uT3JkZXJQZGZTZW5kU2F2ZSUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMyUzQSUyMnNDdXN0QWRkR3JvdXAlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0ExNiUzQSUyMnNDdXN0UmVtb3ZlR3JvdXAlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0ExOCUzQSUyMnNTZW5kTWFpbEZyb21UaGVtZSUyMiUzQnMlM0E2JTNBJTIybW9kdWxlJTIyJTNCcyUzQTIzJTNBJTIyc1NlbmRNYWlsRnJvbU1vZHVsZVBhdGglMjIlM0JzJTNBMTQlM0ElMjJkM29yZGVybWFuYWdlciUyMiUzQnMlM0ExOSUzQSUyMmJsR2V0U3Rvcm5vQXJ0aWNsZXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjElM0ElMjJzU2VuZE1haWxSZXBseUFkZHJlc3MlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMSUzQSUyMmJsQWN0aW9uRXhwb3J0X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNiUzQSUyMmFFeHBvcnRGaWVsZExpc3QlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0ExOSUzQSUyMnNFeHBvcnRUZW1wbGF0ZW5hbWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0ExNiUzQSUyMnNFeHBvcnRFeHRlbnNpb24lMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EzMyUzQSUyMmJsQWN0aW9uT3JkZXJFeGVjdXRlTWV0aG9kX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNSUzQSUyMnNBY3Rpb25FeGVjdXRlTWV0aG9kX25hbWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQiU3RA==',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXFOLDER',
                'content'       => 'D3_ORDERMANAGER_ORDER_DELIVERYSTATUS',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSORT',
                'content'       => '2200',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXWRITEPROTECTION',
                'content'       => "0",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_EXECMANUALLY',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_MARKORDER',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
        ];
    }

    /**
     * @param Shop $oShop
     *
     * @return array
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getExampleJobItem6InsertFields(Shop $oShop): array
    {
        $sShopId = $oShop->getId();
        $iShopBit = strlen($sShopId) == 1 ? $this->getD3BitMask()->getIntByBitPosition((int) $sShopId) : '1';

        return [
            [
                'fieldname'     => 'OXID',
                'content'       => "MD5('" . $this->sModKey . " job06 " . $sShopId . "')",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPID',
                'content'       => $sShopId,
                'force_update'  => true,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPINCL',
                'content'       => $iShopBit,
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPEXCL',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVE',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVEFROM',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVETO',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODID',
                'content'       => 'd3_ordermanager',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXTITLE',
                'content'       => 'Zahlungserinnerung',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'de'),
                'content'       => 'Zahlungserinnerung',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'en'),
                'content'       => 'pay reminder',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHORTDESC',
                'content'       => 'Automatisieren Sie Ihren Mahnlauf, indem säumige Zahler in verschiedenen Stufen an die Zahlung erinnert werden. Dies ist die Beispielaufgabe zur 1. Stufe "Zahlungserinnerung".',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXSHORTDESC', 'de'),
                'content'       => 'Automatisieren Sie Ihren Mahnlauf, indem säumige Zahler in verschiedenen Stufen an die Zahlung erinnert werden. Dies ist die Beispielaufgabe zur 1. Stufe "Zahlungserinnerung".',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXCREATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXUPDATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXUPDATE', 'de'),
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODVERSION',
                'content'       => $this->sModVersion,
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXLOG',
                'content'       => '15',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXVALUE',
                'content'       => 'TyUzQTglM0ElMjJzdGRDbGFzcyUyMiUzQTgzJTNBJTdCcyUzQTEzJTNBJTIyYmxJdGVtRXhlY3V0ZSUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNCUzQSUyMmJsSXRlbU1haWxTZW5kJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja0Zyb21PcmRlck5yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNyUzQSUyMnNGcm9tT3JkZXJOclZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVG9PcmRlck5yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNUb09yZGVyTnJWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIzJTNBJTIyYmxDaGVja1RpbWVzcGFuMV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTUlM0ElMjJzVGltZXNwYW4xVmFsdWUlMjIlM0JzJTNBMiUzQSUyMjE0JTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMVVuaXQlMjIlM0JzJTNBMyUzQSUyMmRheSUyMiUzQnMlM0ExNCUzQSUyMnNUaW1lc3BhbjFUeXBlJTIyJTNCcyUzQTklM0ElMjJvcmRlcmRhdGUlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVGltZXNwYW4yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNUaW1lc3BhbjJWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMlVuaXQlMjIlM0JzJTNBNiUzQSUyMm1pbnV0ZSUyMiUzQnMlM0ExNCUzQSUyMnNUaW1lc3BhbjJUeXBlJTIyJTNCcyUzQTklM0ElMjJvcmRlcmRhdGUlMjIlM0JzJTNBMjQlM0ElMjJibENoZWNrTm90U2V0RGF0ZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTUlM0ElMjJzTm90U2V0RGF0ZVR5cGUlMjIlM0JzJTNBOCUzQSUyMnBhaWRkYXRlJTIyJTNCcyUzQTIyJTNBJTIyYmxDaGVja1dlZWtkYXlzX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMyUzQSUyMnNXZWVrZGF5c1R5cGUlMjIlM0JzJTNBOSUzQSUyMm9yZGVyZGF0ZSUyMiUzQnMlM0EyMSUzQSUyMmJsQ2hlY2tQYXltZW50X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExMCUzQSUyMnNQYXltZW50SWQlMjIlM0JhJTNBMiUzQSU3QmklM0EwJTNCcyUzQTE0JTNBJTIyb3hpZHBheWFkdmFuY2UlMjIlM0JpJTNBMSUzQnMlM0ExMSUzQSUyMm94aWRpbnZvaWNlJTIyJTNCJTdEcyUzQTIyJTNBJTIyYmxDaGVja0RlbGl2ZXJ5X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMyUzQSUyMmJsQ2hlY2tUcmFja2NvZGVfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja09yZGVyc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tPcmRlck5vc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tBcnRpY2xlc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tPcmRlclN1bV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTMlM0ElMjJzT3JkZXJTdW1UeXBlJTIyJTNCcyUzQTUlM0ElMjJ0b3RhbCUyMiUzQnMlM0ExNyUzQSUyMnNPcmRlclN1bVJlbGF0aW9uJTIyJTNCcyUzQTYlM0ElMjJoaWdoZXIlMjIlM0JzJTNBMTQlM0ElMjJzT3JkZXJTdW1WYWx1ZSUyMiUzQnMlM0E0JTNBJTIyMC4wMCUyMiUzQnMlM0EyNCUzQSUyMmJsQ2hlY2tJbnZvaWNlTnVtX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNSUzQSUyMmJsQ2hlY2tUcmFuc2FjdGlvbl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTclM0ElMjJzT3JkZXJUcmFuc1N0YXR1cyUyMiUzQnMlM0EyJTNBJTIyT0slMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrQ3VycmVuY3lfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE3JTNBJTIyc0N1cnJlbmN5SVNPVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tMYW5ndWFnZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrSW5Gb2xkZXJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja05vdEluRm9sZGVyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExNCUzQSUyMnNOb3RJbkZvbGRlcklkJTIyJTNCYSUzQTElM0ElN0JpJTNBMCUzQnMlM0EyMCUzQSUyMk9SREVSRk9MREVSX1BST0JMRU1TJTIyJTNCJTdEcyUzQTI3JTNBJTIyYmxDaGVja09yZGVyQXJ0aWNsZTFfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIwJTNBJTIyc0FydGljbGVDb250ZW50MVR5cGUlMjIlM0JzJTNBOCUzQSUyMm94YXJ0bnVtJTIyJTNCcyUzQTIyJTNBJTIyc0FydGljbGVDb250ZW50MVJlZ0V4cCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTI3JTNBJTIyYmxDaGVja09yZGVyQXJ0aWNsZTJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIwJTNBJTIyc0FydGljbGVDb250ZW50MlR5cGUlMjIlM0JzJTNBOCUzQSUyMm94YXJ0bnVtJTIyJTNCcyUzQTIyJTNBJTIyc0FydGljbGVDb250ZW50MlJlZ0V4cCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE4JTNBJTIyYmxDaGVja01haWxfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTEwJTNBJTIyc01haWxWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIxJTNBJTIyYmxDaGVja0NvdW50cnlfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI3JTNBJTIyYmxBY3Rpb25PcmRlcjJGb2xkZXJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTEyJTNBJTIyc09yZGVyRm9sZGVyJTIyJTNCcyUzQTE1JTNBJTIyT1JERVJGT0xERVJfTkVXJTIyJTNCcyUzQTI2JTNBJTIyYmxBY3Rpb25PcmRlclN0b3Jub19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjYlM0ElMjJibEFjdGlvbk9yZGVyRGVsZXRlX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EzMiUzQSUyMmJsQWN0aW9uT3JkZXJTZXRTZW5kZWROb3dfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTMwJTNBJTIyYmxBY3Rpb25PcmRlclNldFBhaWROb3dfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTMzJTNBJTIyYmxBY3Rpb25PcmRlckFkZEZpZWxkVmFsdWVfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIxJTNBJTIyc0FjdGlvbkFkZEZpZWxkX2ZpZWxkJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjElM0ElMjJzQWN0aW9uQWRkRmllbGRfdmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EzOCUzQSUyMmJsQWN0aW9uT3JkZXJDaGFuZ2VEZWxpdmVyeUNvc3Rfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyc0FjdGlvbkNoYW5nZURlbENvc3RWYWx1ZSUyMiUzQnMlM0E0JTNBJTIyMC4wMCUyMiUzQnMlM0EzNCUzQSUyMmJsQWN0aW9uT3JkZXJDaGFuZ2VEaXNjb3VudF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjYlM0ElMjJzQWN0aW9uQ2hhbmdlRGlzY291bnRWYWx1ZSUyMiUzQnMlM0E0JTNBJTIyMC4wMCUyMiUzQnMlM0EyNSUzQSUyMmJsQWN0aW9uQ3VzdDJHcm91cF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjglM0ElMjJibEFjdGlvbkN1c3RGcm9tR3JvdXBfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIzJTNBJTIyYmxBY3Rpb25NYWlsc2VuZF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMjAlM0ElMjJzU2VuZE1haWxGcm9tU3ViamVjdCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTI1JTNBJTIyc1NlbmRNYWlsRnJvbVRlbXBsYXRlbmFtZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTMwJTNBJTIyc1NlbmRNYWlsRnJvbVRlbXBsYXRlbmFtZVBsYWluJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMTklM0ElMjJzU2VuZE1haWxGcm9tU291cmNlJTIyJTNCcyUzQTMlM0ElMjJjbXMlMjIlM0JzJTNBMjQlM0ElMjJzU2VuZE1haWxGcm9tQ29udGVudG5hbWUlMjIlM0JzJTNBMzIlM0ElMjI5NjAzYjE4MWRmYWU4ODU3NTU2MzBkNzY0NTlmMDJjMSUyMiUzQnMlM0EyOSUzQSUyMnNTZW5kTWFpbEZyb21Db250ZW50bmFtZVBsYWluJTIyJTNCcyUzQTMyJTNBJTIyNmRhNGY5MjkzMzY1NmU3NWEwN2IxZDQ5Yzc1ZGRkY2QlMjIlM0JzJTNBMjAlM0ElMjJibFNlbmRNYWlsVG9DdXN0b21lciUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExNyUzQSUyMmJsU2VuZE1haWxUb093bmVyJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE4JTNBJTIyYmxTZW5kTWFpbFRvQ3VzdG9tJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI0JTNBJTIyc1NlbmRNYWlsVG9DdXN0b21BZGRyZXNzJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjUlM0ElMjJpVW5tYXJrRXhlY0RlbGF5VGltZVZhbHVlJTIyJTNCcyUzQTElM0ElMjI3JTIyJTNCcyUzQTI0JTNBJTIyc1VubWFya0V4ZWNEZWxheVRpbWVVbml0JTIyJTNCcyUzQTQlM0ElMjJkYXlzJTIyJTNCcyUzQTE4JTNBJTIyc1NlbmRNYWlsRnJvbVRoZW1lJTIyJTNCcyUzQTglM0ElMjJmcm9udGVuZCUyMiUzQnMlM0ExOSUzQSUyMmJsR2V0U3Rvcm5vQXJ0aWNsZXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMzElM0ElMjJibEFjdGlvbk9yZGVyR2VuZXJhdGVQZGZfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI3JTNBJTIyYmxBY3Rpb25PcmRlclBkZlR5cGVJbnZvaWNlJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI3JTNBJTIyYmxBY3Rpb25PcmRlclBkZlR5cGVEZWxub3RlJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI2JTNBJTIyYmxBY3Rpb25PcmRlclBkZlNlbmRBdHRhY2glMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjQlM0ElMjJibEFjdGlvbk9yZGVyUGRmU2VuZFNhdmUlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjIlM0ElMjJzQWN0aW9uT3JkZXJQZGZTYXZlRGlyJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0IlN0Q=',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXFOLDER',
                'content'       => 'D3_ORDERMANAGER_ORDER_PAYSTATUSCHECK',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSORT',
                'content'       => '3000',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXWRITEPROTECTION',
                'content'       => "0",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_EXECMANUALLY',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_MARKORDER',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
        ];
    }

    /**
     * @param Shop $oShop
     *
     * @return array
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getExampleJobItem7InsertFields(Shop $oShop): array
    {
        $sShopId = $oShop->getId();
        $iShopBit = strlen($sShopId) == 1 ? $this->getD3BitMask()->getIntByBitPosition((int) $sShopId) : '1';

        return [
            [
                'fieldname'     => 'OXID',
                'content'       => "MD5('" . $this->sModKey . " job07 " . $sShopId . "')",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPID',
                'content'       => $sShopId,
                'force_update'  => true,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPINCL',
                'content'       => $iShopBit,
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPEXCL',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVE',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVEFROM',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVETO',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODID',
                'content'       => 'd3_ordermanager',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXTITLE',
                'content'       => '1. Mahnung',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'de'),
                'content'       => '1. Mahnung',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'en'),
                'content'       => '1st monition',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHORTDESC',
                'content'       => 'Automatisieren Sie Ihren Mahnlauf, indem säumige Zahler in verschiedenen Stufen an die Zahlung erinnert werden. Dies ist die Beispielaufgabe zur 2. Stufe "Mahnung". Legen Sie weitere Aufgaben an, um weiterhin säumige Kunden z.B. zu blockieren.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXSHORTDESC', 'de'),
                'content'       => 'Automatisieren Sie Ihren Mahnlauf, indem säumige Zahler in verschiedenen Stufen an die Zahlung erinnert werden. Dies ist die Beispielaufgabe zur 2. Stufe "Mahnung". Legen Sie weitere Aufgaben an, um weiterhin säumige Kunden z.B. zu blockieren.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXCREATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXUPDATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXUPDATE', 'de'),
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODVERSION',
                'content'       => $this->sModVersion,
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXLOG',
                'content'       => '15',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXVALUE',
                'content'       => 'TyUzQTglM0ElMjJzdGRDbGFzcyUyMiUzQTg0JTNBJTdCcyUzQTEzJTNBJTIyYmxJdGVtRXhlY3V0ZSUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNCUzQSUyMmJsSXRlbU1haWxTZW5kJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja0Zyb21PcmRlck5yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNyUzQSUyMnNGcm9tT3JkZXJOclZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVG9PcmRlck5yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNUb09yZGVyTnJWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIzJTNBJTIyYmxDaGVja1RpbWVzcGFuMV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTUlM0ElMjJzVGltZXNwYW4xVmFsdWUlMjIlM0JzJTNBMiUzQSUyMjI4JTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMVVuaXQlMjIlM0JzJTNBMyUzQSUyMmRheSUyMiUzQnMlM0ExNCUzQSUyMnNUaW1lc3BhbjFUeXBlJTIyJTNCcyUzQTklM0ElMjJvcmRlcmRhdGUlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVGltZXNwYW4yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNUaW1lc3BhbjJWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMlVuaXQlMjIlM0JzJTNBNiUzQSUyMm1pbnV0ZSUyMiUzQnMlM0ExNCUzQSUyMnNUaW1lc3BhbjJUeXBlJTIyJTNCcyUzQTklM0ElMjJvcmRlcmRhdGUlMjIlM0JzJTNBMjQlM0ElMjJibENoZWNrTm90U2V0RGF0ZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTUlM0ElMjJzTm90U2V0RGF0ZVR5cGUlMjIlM0JzJTNBOCUzQSUyMnBhaWRkYXRlJTIyJTNCcyUzQTIyJTNBJTIyYmxDaGVja1dlZWtkYXlzX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMyUzQSUyMnNXZWVrZGF5c1R5cGUlMjIlM0JzJTNBOSUzQSUyMm9yZGVyZGF0ZSUyMiUzQnMlM0EyMSUzQSUyMmJsQ2hlY2tQYXltZW50X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExMCUzQSUyMnNQYXltZW50SWQlMjIlM0JhJTNBMiUzQSU3QmklM0EwJTNCcyUzQTE0JTNBJTIyb3hpZHBheWFkdmFuY2UlMjIlM0JpJTNBMSUzQnMlM0ExMSUzQSUyMm94aWRpbnZvaWNlJTIyJTNCJTdEcyUzQTIyJTNBJTIyYmxDaGVja0RlbGl2ZXJ5X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMyUzQSUyMmJsQ2hlY2tUcmFja2NvZGVfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja09yZGVyc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tPcmRlck5vc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tBcnRpY2xlc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tPcmRlclN1bV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTMlM0ElMjJzT3JkZXJTdW1UeXBlJTIyJTNCcyUzQTUlM0ElMjJ0b3RhbCUyMiUzQnMlM0ExNyUzQSUyMnNPcmRlclN1bVJlbGF0aW9uJTIyJTNCcyUzQTYlM0ElMjJoaWdoZXIlMjIlM0JzJTNBMTQlM0ElMjJzT3JkZXJTdW1WYWx1ZSUyMiUzQnMlM0E0JTNBJTIyMC4wMCUyMiUzQnMlM0EyNCUzQSUyMmJsQ2hlY2tJbnZvaWNlTnVtX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNSUzQSUyMmJsQ2hlY2tUcmFuc2FjdGlvbl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTclM0ElMjJzT3JkZXJUcmFuc1N0YXR1cyUyMiUzQnMlM0EyJTNBJTIyT0slMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrQ3VycmVuY3lfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE3JTNBJTIyc0N1cnJlbmN5SVNPVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tMYW5ndWFnZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrSW5Gb2xkZXJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja05vdEluRm9sZGVyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tPcmRlckFydGljbGUxX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMCUzQSUyMnNBcnRpY2xlQ29udGVudDFUeXBlJTIyJTNCcyUzQTglM0ElMjJveGFydG51bSUyMiUzQnMlM0EyMiUzQSUyMnNBcnRpY2xlQ29udGVudDFSZWdFeHAlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tPcmRlckFydGljbGUyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMCUzQSUyMnNBcnRpY2xlQ29udGVudDJUeXBlJTIyJTNCcyUzQTglM0ElMjJveGFydG51bSUyMiUzQnMlM0EyMiUzQSUyMnNBcnRpY2xlQ29udGVudDJSZWdFeHAlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0ExOCUzQSUyMmJsQ2hlY2tNYWlsX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMCUzQSUyMnNNYWlsVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMSUzQSUyMmJsQ2hlY2tDb3VudHJ5X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNyUzQSUyMmJsQWN0aW9uT3JkZXIyRm9sZGVyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExMiUzQSUyMnNPcmRlckZvbGRlciUyMiUzQnMlM0EyMCUzQSUyMk9SREVSRk9MREVSX1BST0JMRU1TJTIyJTNCcyUzQTI2JTNBJTIyYmxBY3Rpb25PcmRlclN0b3Jub19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjYlM0ElMjJibEFjdGlvbk9yZGVyRGVsZXRlX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EzMiUzQSUyMmJsQWN0aW9uT3JkZXJTZXRTZW5kZWROb3dfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTMwJTNBJTIyYmxBY3Rpb25PcmRlclNldFBhaWROb3dfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTMzJTNBJTIyYmxBY3Rpb25PcmRlckFkZEZpZWxkVmFsdWVfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIxJTNBJTIyc0FjdGlvbkFkZEZpZWxkX2ZpZWxkJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjElM0ElMjJzQWN0aW9uQWRkRmllbGRfdmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EzOCUzQSUyMmJsQWN0aW9uT3JkZXJDaGFuZ2VEZWxpdmVyeUNvc3Rfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyc0FjdGlvbkNoYW5nZURlbENvc3RWYWx1ZSUyMiUzQnMlM0E0JTNBJTIyMC4wMCUyMiUzQnMlM0EzNCUzQSUyMmJsQWN0aW9uT3JkZXJDaGFuZ2VEaXNjb3VudF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjYlM0ElMjJzQWN0aW9uQ2hhbmdlRGlzY291bnRWYWx1ZSUyMiUzQnMlM0E0JTNBJTIyMC4wMCUyMiUzQnMlM0EyNSUzQSUyMmJsQWN0aW9uQ3VzdDJHcm91cF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTMlM0ElMjJzQ3VzdEFkZEdyb3VwJTIyJTNCYSUzQTElM0ElN0JpJTNBMCUzQnMlM0ExMyUzQSUyMm94aWRibGFja2xpc3QlMjIlM0IlN0RzJTNBMjglM0ElMjJibEFjdGlvbkN1c3RGcm9tR3JvdXBfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTE2JTNBJTIyc0N1c3RSZW1vdmVHcm91cCUyMiUzQmElM0EyJTNBJTdCaSUzQTAlM0JzJTNBMTIlM0ElMjJveGlkZ29vZGN1c3QlMjIlM0JpJTNBMSUzQnMlM0ExNiUzQSUyMm94aWRwb3dlcnNob3BwZXIlMjIlM0IlN0RzJTNBMjMlM0ElMjJibEFjdGlvbk1haWxzZW5kX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExOSUzQSUyMnNTZW5kTWFpbEZyb21Tb3VyY2UlMjIlM0JzJTNBOCUzQSUyMnRlbXBsYXRlJTIyJTNCcyUzQTIwJTNBJTIyc1NlbmRNYWlsRnJvbVN1YmplY3QlMjIlM0JzJTNBMzElM0ElMjJlbWFpbCUyRmh0bWwlMkZteUhUTUxUcGxTdWJqZWN0LnRwbCUyMiUzQnMlM0EyNSUzQSUyMnNTZW5kTWFpbEZyb21UZW1wbGF0ZW5hbWUlMjIlM0JzJTNBMjQlM0ElMjJlbWFpbCUyRmh0bWwlMkZteUhUTUxUcGwudHBsJTIyJTNCcyUzQTMwJTNBJTIyc1NlbmRNYWlsRnJvbVRlbXBsYXRlbmFtZVBsYWluJTIyJTNCcyUzQTI2JTNBJTIyZW1haWwlMkZwbGFpbiUyRm15UGxhaW5UcGwudHBsJTIyJTNCcyUzQTI0JTNBJTIyc1NlbmRNYWlsRnJvbUNvbnRlbnRuYW1lJTIyJTNCcyUzQTMyJTNBJTIyODcwOWU0NWYzMWE4NjkwOWU5Zjk5OTIyMmU4MGIxZDAlMjIlM0JzJTNBMjklM0ElMjJzU2VuZE1haWxGcm9tQ29udGVudG5hbWVQbGFpbiUyMiUzQnMlM0EzMiUzQSUyMjg3MDllNDVmMzFhODY5MDllOWY5OTkyMjJlODBiMWQwJTIyJTNCcyUzQTIwJTNBJTIyYmxTZW5kTWFpbFRvQ3VzdG9tZXIlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTclM0ElMjJibFNlbmRNYWlsVG9Pd25lciUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExOCUzQSUyMmJsU2VuZE1haWxUb0N1c3RvbSUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0EyNCUzQSUyMnNTZW5kTWFpbFRvQ3VzdG9tQWRkcmVzcyUyMiUzQnMlM0EyNCUzQSUyMmJ1Y2hoYWx0dW5nJTQwb3hpZGVzaG9wLmRlJTIyJTNCcyUzQTI1JTNBJTIyaVVubWFya0V4ZWNEZWxheVRpbWVWYWx1ZSUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0EyNCUzQSUyMnNVbm1hcmtFeGVjRGVsYXlUaW1lVW5pdCUyMiUzQnMlM0E0JTNBJTIyZGF5cyUyMiUzQnMlM0EzMSUzQSUyMmJsQWN0aW9uT3JkZXJHZW5lcmF0ZVBkZl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjclM0ElMjJibEFjdGlvbk9yZGVyUGRmVHlwZUludm9pY2UlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjclM0ElMjJibEFjdGlvbk9yZGVyUGRmVHlwZURlbG5vdGUlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjYlM0ElMjJibEFjdGlvbk9yZGVyUGRmU2VuZEF0dGFjaCUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNCUzQSUyMmJsQWN0aW9uT3JkZXJQZGZTZW5kU2F2ZSUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMiUzQSUyMnNBY3Rpb25PcmRlclBkZlNhdmVEaXIlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0ExOCUzQSUyMnNTZW5kTWFpbEZyb21UaGVtZSUyMiUzQnMlM0E4JTNBJTIyZnJvbnRlbmQlMjIlM0JzJTNBMTklM0ElMjJibEdldFN0b3Jub0FydGljbGVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCJTdE',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXFOLDER',
                'content'       => 'D3_ORDERMANAGER_ORDER_PAYSTATUSCHECK',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSORT',
                'content'       => '3100',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXWRITEPROTECTION',
                'content'       => "0",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_EXECMANUALLY',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_MARKORDER',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
        ];
    }

    /**
     * @param Shop $oShop
     *
     * @return array
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getExampleJobItem8InsertFields(Shop $oShop): array
    {
        $sShopId = $oShop->getId();
        $iShopBit = strlen($sShopId) == 1 ? $this->getD3BitMask()->getIntByBitPosition((int) $sShopId) : '1';

        return [
            [
                'fieldname'     => 'OXID',
                'content'       => "MD5('" . $this->sModKey . " job08 " . $sShopId . "')",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPID',
                'content'       => $sShopId,
                'force_update'  => true,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPINCL',
                'content'       => $iShopBit,
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPEXCL',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVE',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVEFROM',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVETO',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODID',
                'content'       => 'd3_ordermanager',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXTITLE',
                'content'       => 'bezahlte Rechnungen nach "erledigt" verschieben',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'de'),
                'content'       => 'bezahlte Rechnungen nach "erledigt" verschieben',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'en'),
                'content'       => 'move paid invoices to "finished"',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHORTDESC',
                'content'       => 'Mit dieser Aufgabe halten Sie die Bestellliste übersichtlich. Alle als "bezahlt" markierten Bestellungen werden in den Ordner "erledigt" einsortiert. Erweitern Sie die Aufgabe, um z.B. den Versand zu informieren.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXSHORTDESC', 'de'),
                'content'       => 'Mit dieser Aufgabe halten Sie die Bestellliste übersichtlich. Alle als "bezahlt" markierten Bestellungen werden in den Ordner "erledigt" einsortiert. Erweitern Sie die Aufgabe, um z.B. den Versand zu informieren.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXCREATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXUPDATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXUPDATE', 'de'),
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODVERSION',
                'content'       => $this->sModVersion,
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXLOG',
                'content'       => '15',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXVALUE',
                'content'       => 'TyUzQTglM0ElMjJzdGRDbGFzcyUyMiUzQTcyJTNBJTdCcyUzQTEzJTNBJTIyYmxJdGVtRXhlY3V0ZSUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNCUzQSUyMmJsSXRlbU1haWxTZW5kJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja0Zyb21PcmRlck5yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNyUzQSUyMnNGcm9tT3JkZXJOclZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVG9PcmRlck5yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNUb09yZGVyTnJWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIzJTNBJTIyYmxDaGVja1RpbWVzcGFuMV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTUlM0ElMjJzVGltZXNwYW4xVmFsdWUlMjIlM0JzJTNBMSUzQSUyMjIlMjIlM0JzJTNBMTQlM0ElMjJzVGltZXNwYW4xVW5pdCUyMiUzQnMlM0E0JTNBJTIyaG91ciUyMiUzQnMlM0ExNCUzQSUyMnNUaW1lc3BhbjFUeXBlJTIyJTNCcyUzQTglM0ElMjJwYWlkZGF0ZSUyMiUzQnMlM0EyMyUzQSUyMmJsQ2hlY2tUaW1lc3BhbjJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE1JTNBJTIyc1RpbWVzcGFuMlZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMTQlM0ElMjJzVGltZXNwYW4yVW5pdCUyMiUzQnMlM0E2JTNBJTIybWludXRlJTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMlR5cGUlMjIlM0JzJTNBOSUzQSUyMm9yZGVyZGF0ZSUyMiUzQnMlM0EyNCUzQSUyMmJsQ2hlY2tOb3RTZXREYXRlX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNOb3RTZXREYXRlVHlwZSUyMiUzQnMlM0E3JTNBJTIyZGVsZGF0ZSUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tXZWVrZGF5c19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTMlM0ElMjJzV2Vla2RheXNUeXBlJTIyJTNCcyUzQTklM0ElMjJvcmRlcmRhdGUlMjIlM0JzJTNBMjElM0ElMjJibENoZWNrUGF5bWVudF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrRGVsaXZlcnlfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIzJTNBJTIyYmxDaGVja1RyYWNrY29kZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjUlM0ElMjJibENoZWNrT3JkZXJzdG9ybm9fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI3JTNBJTIyYmxDaGVja09yZGVyTm9zdG9ybm9fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI3JTNBJTIyYmxDaGVja0FydGljbGVzdG9ybm9fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIyJTNBJTIyYmxDaGVja09yZGVyU3VtX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMyUzQSUyMnNPcmRlclN1bVR5cGUlMjIlM0JzJTNBNSUzQSUyMnRvdGFsJTIyJTNCcyUzQTE3JTNBJTIyc09yZGVyU3VtUmVsYXRpb24lMjIlM0JzJTNBNiUzQSUyMmhpZ2hlciUyMiUzQnMlM0ExNCUzQSUyMnNPcmRlclN1bVZhbHVlJTIyJTNCcyUzQTQlM0ElMjIwLjAwJTIyJTNCcyUzQTI0JTNBJTIyYmxDaGVja0ludm9pY2VOdW1fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja1RyYW5zYWN0aW9uX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNyUzQSUyMnNPcmRlclRyYW5zU3RhdHVzJTIyJTNCcyUzQTIlM0ElMjJPSyUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tDdXJyZW5jeV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTclM0ElMjJzQ3VycmVuY3lJU09WYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIyJTNBJTIyYmxDaGVja0xhbmd1YWdlX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tJbkZvbGRlcl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjUlM0ElMjJibENoZWNrTm90SW5Gb2xkZXJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI3JTNBJTIyYmxDaGVja09yZGVyQXJ0aWNsZTFfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIwJTNBJTIyc0FydGljbGVDb250ZW50MVR5cGUlMjIlM0JzJTNBOCUzQSUyMm94YXJ0bnVtJTIyJTNCcyUzQTIyJTNBJTIyc0FydGljbGVDb250ZW50MVJlZ0V4cCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTI3JTNBJTIyYmxDaGVja09yZGVyQXJ0aWNsZTJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIwJTNBJTIyc0FydGljbGVDb250ZW50MlR5cGUlMjIlM0JzJTNBOCUzQSUyMm94YXJ0bnVtJTIyJTNCcyUzQTIyJTNBJTIyc0FydGljbGVDb250ZW50MlJlZ0V4cCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE4JTNBJTIyYmxDaGVja01haWxfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTEwJTNBJTIyc01haWxWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIxJTNBJTIyYmxDaGVja0NvdW50cnlfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI3JTNBJTIyYmxBY3Rpb25PcmRlcjJGb2xkZXJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTEyJTNBJTIyc09yZGVyRm9sZGVyJTIyJTNCcyUzQTIwJTNBJTIyT1JERVJGT0xERVJfRklOSVNIRUQlMjIlM0JzJTNBMjYlM0ElMjJibEFjdGlvbk9yZGVyU3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNiUzQSUyMmJsQWN0aW9uT3JkZXJEZWxldGVfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTMyJTNBJTIyYmxBY3Rpb25PcmRlclNldFNlbmRlZE5vd19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMzAlM0ElMjJibEFjdGlvbk9yZGVyU2V0UGFpZE5vd19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMzMlM0ElMjJibEFjdGlvbk9yZGVyQWRkRmllbGRWYWx1ZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjElM0ElMjJzQWN0aW9uQWRkRmllbGRfZmllbGQlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMSUzQSUyMnNBY3Rpb25BZGRGaWVsZF92YWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTM4JTNBJTIyYmxBY3Rpb25PcmRlckNoYW5nZURlbGl2ZXJ5Q29zdF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjUlM0ElMjJzQWN0aW9uQ2hhbmdlRGVsQ29zdFZhbHVlJTIyJTNCcyUzQTQlM0ElMjIwLjAwJTIyJTNCcyUzQTM0JTNBJTIyYmxBY3Rpb25PcmRlckNoYW5nZURpc2NvdW50X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNiUzQSUyMnNBY3Rpb25DaGFuZ2VEaXNjb3VudFZhbHVlJTIyJTNCcyUzQTQlM0ElMjIwLjAwJTIyJTNCcyUzQTI1JTNBJTIyYmxBY3Rpb25DdXN0Mkdyb3VwX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyOCUzQSUyMmJsQWN0aW9uQ3VzdEZyb21Hcm91cF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjMlM0ElMjJibEFjdGlvbk1haWxzZW5kX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMCUzQSUyMnNTZW5kTWFpbEZyb21TdWJqZWN0JTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjUlM0ElMjJzU2VuZE1haWxGcm9tVGVtcGxhdGVuYW1lJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMzAlM0ElMjJzU2VuZE1haWxGcm9tVGVtcGxhdGVuYW1lUGxhaW4lMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNCUzQSUyMnNTZW5kTWFpbEZyb21Db250ZW50bmFtZSUyMiUzQnMlM0EzMiUzQSUyMjg3MDllNDVmMzFhODY5MDllOWY5OTkyMjJlODBiMWQwJTIyJTNCcyUzQTI5JTNBJTIyc1NlbmRNYWlsRnJvbUNvbnRlbnRuYW1lUGxhaW4lMjIlM0JzJTNBMzIlM0ElMjI4NzA5ZTQ1ZjMxYTg2OTA5ZTlmOTk5MjIyZTgwYjFkMCUyMiUzQnMlM0EyMCUzQSUyMmJsU2VuZE1haWxUb0N1c3RvbWVyJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE3JTNBJTIyYmxTZW5kTWFpbFRvT3duZXIlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTglM0ElMjJibFNlbmRNYWlsVG9DdXN0b20lMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjQlM0ElMjJzU2VuZE1haWxUb0N1c3RvbUFkZHJlc3MlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNSUzQSUyMmlVbm1hcmtFeGVjRGVsYXlUaW1lVmFsdWUlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMjQlM0ElMjJzVW5tYXJrRXhlY0RlbGF5VGltZVVuaXQlMjIlM0JzJTNBNCUzQSUyMmRheXMlMjIlM0IlN0Q=',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXFOLDER',
                'content'       => 'D3_ORDERMANAGER_ORDER_ORDERPROCESSING',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSORT',
                'content'       => '4000',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXWRITEPROTECTION',
                'content'       => "0",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_EXECMANUALLY',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_MARKORDER',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
        ];
    }

    /**
     * @param Shop $oShop
     *
     * @return array
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getExampleJobItem9InsertFields(Shop $oShop): array
    {
        $sShopId = $oShop->getId();
        $iShopBit = strlen($sShopId) == 1 ? $this->getD3BitMask()->getIntByBitPosition((int) $sShopId) : '1';

        return [
            [
                'fieldname'     => 'OXID',
                'content'       => "MD5('" . $this->sModKey . " job09 " . $sShopId . "')",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPID',
                'content'       => $sShopId,
                'force_update'  => true,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPINCL',
                'content'       => $iShopBit,
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPEXCL',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVE',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVEFROM',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVETO',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODID',
                'content'       => 'd3_ordermanager',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXTITLE',
                'content'       => 'Vorkasse-Kontroll-Export',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'de'),
                'content'       => 'Vorkasse-Kontroll-Export',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'en'),
                'content'       => 'export unpaid prepayment orders',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHORTDESC',
                'content'       => 'Unbezahlte Vorkassebestellungen werden in einer Exportliste für die Kontrolle durch die Buchhaltung zusammengefasst.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXSHORTDESC', 'de'),
                'content'       => 'Unbezahlte Vorkassebestellungen werden in einer Exportliste für die Kontrolle durch die Buchhaltung zusammengefasst.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXCREATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXUPDATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXUPDATE', 'de'),
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODVERSION',
                'content'       => $this->sModVersion,
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXLOG',
                'content'       => '15',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXVALUE',
                'content'       => 'TyUzQTglM0ElMjJzdGRDbGFzcyUyMiUzQTExOSUzQSU3QnMlM0ExMyUzQSUyMmJsSXRlbUV4ZWN1dGUlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTQlM0ElMjJibEl0ZW1NYWlsU2VuZCUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0EyNSUzQSUyMmlVbm1hcmtFeGVjRGVsYXlUaW1lVmFsdWUlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMjQlM0ElMjJzVW5tYXJrRXhlY0RlbGF5VGltZVVuaXQlMjIlM0JzJTNBNCUzQSUyMmRheXMlMjIlM0JzJTNBMjUlM0ElMjJibENoZWNrRnJvbU9yZGVyTnJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIxJTIyJTNCcyUzQTE3JTNBJTIyc0Zyb21PcmRlck5yVmFsdWUlMjIlM0JzJTNBMSUzQSUyMjIlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVG9PcmRlck5yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNUb09yZGVyTnJWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIzJTNBJTIyYmxDaGVja1RpbWVzcGFuMV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTUlM0ElMjJzVGltZXNwYW4xVmFsdWUlMjIlM0JzJTNBMSUzQSUyMjIlMjIlM0JzJTNBMTQlM0ElMjJzVGltZXNwYW4xVW5pdCUyMiUzQnMlM0EzJTNBJTIyZGF5JTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMVR5cGUlMjIlM0JzJTNBOSUzQSUyMm9yZGVyZGF0ZSUyMiUzQnMlM0EyMyUzQSUyMmJsQ2hlY2tUaW1lc3BhbjJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE1JTNBJTIyc1RpbWVzcGFuMlZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMTQlM0ElMjJzVGltZXNwYW4yVW5pdCUyMiUzQnMlM0E2JTNBJTIybWludXRlJTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMlR5cGUlMjIlM0JzJTNBOSUzQSUyMm9yZGVyZGF0ZSUyMiUzQnMlM0EyNCUzQSUyMmJsQ2hlY2tOb3RTZXREYXRlX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0ExNSUzQSUyMnNOb3RTZXREYXRlVHlwZSUyMiUzQnMlM0E4JTNBJTIycGFpZGRhdGUlMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrV2Vla2RheXNfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTEzJTNBJTIyc1dlZWtkYXlzVHlwZSUyMiUzQnMlM0E5JTNBJTIyb3JkZXJkYXRlJTIyJTNCcyUzQTEyJTNBJTIyc1dlZWtkYXlEYXlzJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjElM0ElMjJibENoZWNrUGF5bWVudF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTAlM0ElMjJzUGF5bWVudElkJTIyJTNCYSUzQTElM0ElN0JpJTNBMCUzQnMlM0ExNCUzQSUyMm94aWRwYXlhZHZhbmNlJTIyJTNCJTdEcyUzQTIyJTNBJTIyYmxDaGVja0RlbGl2ZXJ5X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMSUzQSUyMnNEZWxpdmVyeUlkJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVHJhY2tjb2RlX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNSUzQSUyMmJsQ2hlY2tPcmRlcnN0b3Jub19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjclM0ElMjJibENoZWNrT3JkZXJOb3N0b3Jub19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMjclM0ElMjJibENoZWNrQXJ0aWNsZXN0b3Jub19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrT3JkZXJTdW1fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTEzJTNBJTIyc09yZGVyU3VtVHlwZSUyMiUzQnMlM0E1JTNBJTIydG90YWwlMjIlM0JzJTNBMTclM0ElMjJzT3JkZXJTdW1SZWxhdGlvbiUyMiUzQnMlM0E2JTNBJTIyaGlnaGVyJTIyJTNCcyUzQTE0JTNBJTIyc09yZGVyU3VtVmFsdWUlMjIlM0JzJTNBNCUzQSUyMjAuMDAlMjIlM0JzJTNBMjQlM0ElMjJibENoZWNrSW52b2ljZU51bV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjUlM0ElMjJibENoZWNrVHJhbnNhY3Rpb25fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE3JTNBJTIyc09yZGVyVHJhbnNTdGF0dXMlMjIlM0JzJTNBMiUzQSUyMk9LJTIyJTNCcyUzQTIyJTNBJTIyYmxDaGVja0N1cnJlbmN5X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNyUzQSUyMnNDdXJyZW5jeUlTT1ZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrTGFuZ3VhZ2Vfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTEzJTNBJTIyc0luTGFuZ3VhZ2VJZCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIyJTNBJTIyYmxDaGVja0luRm9sZGVyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMSUzQSUyMnNJbkZvbGRlcklkJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjUlM0ElMjJibENoZWNrTm90SW5Gb2xkZXJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE0JTNBJTIyc05vdEluRm9sZGVySWQlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tPcmRlckFydGljbGUxX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMCUzQSUyMnNBcnRpY2xlQ29udGVudDFUeXBlJTIyJTNCcyUzQTglM0ElMjJveGFydG51bSUyMiUzQnMlM0EyMiUzQSUyMnNBcnRpY2xlQ29udGVudDFSZWdFeHAlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tPcmRlckFydGljbGUyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMCUzQSUyMnNBcnRpY2xlQ29udGVudDJUeXBlJTIyJTNCcyUzQTglM0ElMjJveGFydG51bSUyMiUzQnMlM0EyMiUzQSUyMnNBcnRpY2xlQ29udGVudDJSZWdFeHAlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyOSUzQSUyMmJsQ2hlY2tOb09yZGVyQXJ0aWNsZTFfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIyJTNBJTIyc05vQXJ0aWNsZUNvbnRlbnQxVHlwZSUyMiUzQnMlM0E4JTNBJTIyb3hhcnRudW0lMjIlM0JzJTNBMjQlM0ElMjJzTm9BcnRpY2xlQ29udGVudDFSZWdFeHAlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyOSUzQSUyMmJsQ2hlY2tOb09yZGVyQXJ0aWNsZTJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIyJTNBJTIyc05vQXJ0aWNsZUNvbnRlbnQyVHlwZSUyMiUzQnMlM0E4JTNBJTIyb3hhcnRudW0lMjIlM0JzJTNBMjQlM0ElMjJzTm9BcnRpY2xlQ29udGVudDJSZWdFeHAlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0ExOCUzQSUyMmJsQ2hlY2tNYWlsX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMCUzQSUyMnNNYWlsVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMSUzQSUyMmJsQ2hlY2tDb3VudHJ5X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNCUzQSUyMnNDdXN0Q291bnRyeUlkJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjElM0ElMjJibENoZWNrSW5Hcm91cF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTQlM0ElMjJzQ3VzdEluR3JvdXBJZCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTI0JTNBJTIyYmxDaGVja05vdEluR3JvdXBfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE3JTNBJTIyc0N1c3ROb3RJbkdyb3VwSWQlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tFeGVjdXRlTWV0aG9kX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EzMCUzQSUyMnNSZXF1aXJlbWVudEV4ZWN1dGVNZXRob2RfbmFtZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTI0JTNBJTIyYmxDaGVja09yZGVyRmllbGRfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIxJTNBJTIyc09yZGVyRmllbGRfRmllbGROYW1lJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjAlM0ElMjJzQ2hlY2tPcmRlckZpZWxkVHlwZSUyMiUzQnMlM0E3JTNBJTIyY29udGVudCUyMiUzQnMlM0EyMiUzQSUyMnNPcmRlckZpZWxkX0ZpZWxkVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNyUzQSUyMmJsQWN0aW9uT3JkZXIyRm9sZGVyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMiUzQSUyMnNPcmRlckZvbGRlciUyMiUzQnMlM0ExNSUzQSUyMk9SREVSRk9MREVSX05FVyUyMiUzQnMlM0EyNiUzQSUyMmJsQWN0aW9uT3JkZXJTdG9ybm9fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTMyJTNBJTIyYmxBY3Rpb25PcmRlclNldFNlbmRlZE5vd19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMzAlM0ElMjJibEFjdGlvbk9yZGVyU2V0UGFpZE5vd19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMzglM0ElMjJibEFjdGlvbk9yZGVyQ2hhbmdlRGVsaXZlcnlDb3N0X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNSUzQSUyMnNBY3Rpb25DaGFuZ2VEZWxDb3N0VmFsdWUlMjIlM0JzJTNBNCUzQSUyMjAuMDAlMjIlM0JzJTNBMzQlM0ElMjJibEFjdGlvbk9yZGVyQ2hhbmdlRGlzY291bnRfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI2JTNBJTIyc0FjdGlvbkNoYW5nZURpc2NvdW50VmFsdWUlMjIlM0JzJTNBNCUzQSUyMjAuMDAlMjIlM0JzJTNBMzElM0ElMjJibEFjdGlvbk9yZGVyR2VuZXJhdGVQZGZfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI3JTNBJTIyYmxBY3Rpb25PcmRlclBkZlR5cGVJbnZvaWNlJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI3JTNBJTIyYmxBY3Rpb25PcmRlclBkZlR5cGVEZWxub3RlJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI2JTNBJTIyYmxBY3Rpb25PcmRlclBkZlNlbmRBdHRhY2glMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjQlM0ElMjJibEFjdGlvbk9yZGVyUGRmU2VuZFNhdmUlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjUlM0ElMjJibEFjdGlvbkN1c3QyR3JvdXBfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTEzJTNBJTIyc0N1c3RBZGRHcm91cCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTI4JTNBJTIyYmxBY3Rpb25DdXN0RnJvbUdyb3VwX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNiUzQSUyMnNDdXN0UmVtb3ZlR3JvdXAlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMyUzQSUyMmJsQWN0aW9uTWFpbHNlbmRfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIwJTNBJTIyc1NlbmRNYWlsRnJvbVN1YmplY3QlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNSUzQSUyMnNTZW5kTWFpbEZyb21UZW1wbGF0ZW5hbWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EzMCUzQSUyMnNTZW5kTWFpbEZyb21UZW1wbGF0ZW5hbWVQbGFpbiUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE4JTNBJTIyc1NlbmRNYWlsRnJvbVRoZW1lJTIyJTNCcyUzQTglM0ElMjJmcm9udGVuZCUyMiUzQnMlM0EyNCUzQSUyMnNTZW5kTWFpbEZyb21Db250ZW50bmFtZSUyMiUzQnMlM0EzMiUzQSUyMjg3MDllNDVmMzFhODY5MDllOWY5OTkyMjJlODBiMWQwJTIyJTNCcyUzQTI5JTNBJTIyc1NlbmRNYWlsRnJvbUNvbnRlbnRuYW1lUGxhaW4lMjIlM0JzJTNBMzIlM0ElMjI4NzA5ZTQ1ZjMxYTg2OTA5ZTlmOTk5MjIyZTgwYjFkMCUyMiUzQnMlM0EyMCUzQSUyMmJsU2VuZE1haWxUb0N1c3RvbWVyJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE3JTNBJTIyYmxTZW5kTWFpbFRvT3duZXIlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTglM0ElMjJibFNlbmRNYWlsVG9DdXN0b20lMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjQlM0ElMjJzU2VuZE1haWxUb0N1c3RvbUFkZHJlc3MlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0ExOSUzQSUyMmJsR2V0U3Rvcm5vQXJ0aWNsZXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjElM0ElMjJibEFjdGlvbkV4cG9ydF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTYlM0ElMjJhRXhwb3J0RmllbGRMaXN0JTIyJTNCYSUzQTclM0ElN0JpJTNBMCUzQnMlM0ExMSUzQSUyMm94b3JkZXJkYXRlJTIyJTNCaSUzQTElM0JzJTNBOSUzQSUyMm94b3JkZXJuciUyMiUzQmklM0EyJTNCcyUzQTEzJTNBJTIyb3hiaWxsY29tcGFueSUyMiUzQmklM0EzJTNCcyUzQTExJTNBJTIyb3hiaWxsZm5hbWUlMjIlM0JpJTNBNCUzQnMlM0ExMSUzQSUyMm94YmlsbGxuYW1lJTIyJTNCaSUzQTUlM0JzJTNBMTUlM0ElMjJveHRvdGFsb3JkZXJzdW0lMjIlM0JpJTNBNiUzQnMlM0ExMSUzQSUyMm94aW52b2ljZW5yJTIyJTNCJTdEcyUzQTE5JTNBJTIyc0V4cG9ydFRlbXBsYXRlbmFtZSUyMiUzQnMlM0E2MCUzQSUyMkFwcGxpY2F0aW9uJTJGdmlld3MlMkZhZG1pbiUyRnRwbCUyRmV4cG9ydC10ZW1wbGF0ZXMlMkZDU1YtVm9ybGFnZS50cGwlMjIlM0JzJTNBMTYlM0ElMjJzRXhwb3J0RXh0ZW5zaW9uJTIyJTNCcyUzQTQlM0ElMjIuY3N2JTIyJTNCcyUzQTMzJTNBJTIyYmxBY3Rpb25PcmRlckV4ZWN1dGVNZXRob2Rfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyc0FjdGlvbkV4ZWN1dGVNZXRob2RfbmFtZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTMzJTNBJTIyYmxBY3Rpb25PcmRlckFkZEZpZWxkVmFsdWVfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIxJTNBJTIyc0FjdGlvbkFkZEZpZWxkX2ZpZWxkJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjElM0ElMjJzQWN0aW9uQWRkRmllbGRfdmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNiUzQSUyMmJsQWN0aW9uT3JkZXJEZWxldGVfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIyJTNBJTIyYmxDaGVja090aGVySm9iX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMiUzQSUyMnNPdGhlckpvYl9JRCUyMiUzQnMlM0EzMiUzQSUyMjJjZWE4MDU5YTFiZWMzNDY3OTQ3NTg1ZTNhYTcyNmZmJTIyJTNCcyUzQTE0JTNBJTIyc090aGVySm9iX1R5cGUlMjIlM0JzJTNBNCUzQSUyMmV4ZWMlMjIlM0JzJTNBMjIlM0ElMjJzQWN0aW9uT3JkZXJQZGZTYXZlRGlyJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjMlM0ElMjJzU2VuZE1haWxGcm9tTW9kdWxlUGF0aCUyMiUzQnMlM0ExMiUzQSUyMmQzbW9kY2ZnX2xpYiUyMiUzQnMlM0EyMSUzQSUyMnNTZW5kTWFpbFJlcGx5QWRkcmVzcyUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTEzJTNBJTIyaUxhc3RFeGVjRGF0ZSUyMiUzQmklM0ExNTEyOTk3OTM3JTNCcyUzQTIwJTNBJTIyc0V4cG9ydExpc3RGcm9tVGhlbWUlMjIlM0JzJTNBNiUzQSUyMm1vZHVsZSUyMiUzQnMlM0EyNSUzQSUyMnNFeHBvcnRMaXN0RnJvbU1vZHVsZVBhdGglMjIlM0JzJTNBMTQlM0ElMjJkM29yZGVybWFuYWdlciUyMiUzQiU3RA==',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXFOLDER',
                'content'       => 'D3_ORDERMANAGER_ORDER_PAYADVANCE',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSORT',
                'content'       => '4100',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXWRITEPROTECTION',
                'content'       => "0",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_EXECMANUALLY',
                'content'       => "0",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_MARKORDER',
                'content'       => '1',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
        ];
    }

    /**
     * @param Shop $oShop
     *
     * @return array
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getExampleJobItem10InsertFields(Shop $oShop): array
    {
        $sShopId = $oShop->getId();
        $iShopBit = strlen($sShopId) == 1 ? $this->getD3BitMask()->getIntByBitPosition((int) $sShopId) : '1';

        return [
            [
                'fieldname'     => 'OXID',
                'content'       => "MD5('" . $this->sModKey . " job10 " . $sShopId . "')",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPID',
                'content'       => $sShopId,
                'force_update'  => true,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPINCL',
                'content'       => $iShopBit,
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPEXCL',
                'content'       => '0',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVE',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVEFROM',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVETO',
                'content'       => '0000-00-00 00:00:00',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODID',
                'content'       => 'd3_ordermanager',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXTITLE',
                'content'       => 'Push-Benachrichtigung bei großen Bestellungen erhalten',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'de'),
                'content'       => 'Push-Benachrichtigung bei großen Bestellungen erhalten',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXTITLE', 'en'),
                'content'       => 'Receive push notification for large orders',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHORTDESC',
                'content'       => 'Diese Aufgabe kann eine Push-Benachrichtigung an einen Dienst (z.B. IFTTT) senden, der daraufhin weitere Aktionen durchführt. Die weiteren Bearbeitungsmöglichkeiten sind dienstabhängig. Weitere Infos zu dieser Funktion finden Sie im Handbuch des Moduls.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXSHORTDESC', 'de'),
                'content'       => 'Diese Aufgabe kann eine Push-Benachrichtigung an einen Dienst (z.B. IFTTT) senden, der daraufhin weitere Aktionen durchführt. Die weiteren Bearbeitungsmöglichkeiten sind dienstabhängig. Weitere Infos zu dieser Funktion finden Sie im Handbuch des Moduls.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXSHORTDESC', 'en'),
                'content'       => 'This task can send a push notification to a service (e.g. IFTTT), which then performs further actions. The other processing options are service-dependent. For more information on this function, refer to the modules manual.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXCREATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXUPDATE',
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('d3modprofile', 'OXUPDATE', 'de'),
                'content'       => 'NOW()',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXMODVERSION',
                'content'       => $this->sModVersion,
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXLOG',
                'content'       => '15',
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXVALUE',
                'content'       => 'TyUzQTglM0ElMjJzdGRDbGFzcyUyMiUzQTEyNiUzQSU3QnMlM0ExMyUzQSUyMmJsSXRlbUV4ZWN1dGUlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTQlM0ElMjJibEl0ZW1NYWlsU2VuZCUyMiUzQnMlM0ExJTNBJTIyMSUyMiUzQnMlM0EyNSUzQSUyMmlVbm1hcmtFeGVjRGVsYXlUaW1lVmFsdWUlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMjQlM0ElMjJzVW5tYXJrRXhlY0RlbGF5VGltZVVuaXQlMjIlM0JzJTNBNCUzQSUyMmRheXMlMjIlM0JzJTNBMjQlM0ElMjJzQ3JvbmpvYlByZUV4ZWN1dGVTY3JpcHQlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNSUzQSUyMnNDcm9uam9iUG9zdEV4ZWN1dGVTY3JpcHQlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNSUzQSUyMnNNYW51YWxseVByZUV4ZWN1dGVTY3JpcHQlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNiUzQSUyMnNNYW51YWxseVBvc3RFeGVjdXRlU2NyaXB0JTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjYlM0ElMjJzTWFudWFsbHlFeGVjTWVldENvbmRpdGlvbiUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EzNyUzQSUyMnNPcmRlckZpbmlzaFRyaWdnZXJlZFByZUV4ZWN1dGVTY3JpcHQlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EzOCUzQSUyMnNPcmRlckZpbmlzaFRyaWdnZXJlZFBvc3RFeGVjdXRlU2NyaXB0JTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMzUlM0ElMjJzT3JkZXJTYXZlVHJpZ2dlcmVkUHJlRXhlY3V0ZVNjcmlwdCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTM2JTNBJTIyc09yZGVyU2F2ZVRyaWdnZXJlZFBvc3RFeGVjdXRlU2NyaXB0JTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjUlM0ElMjJibENoZWNrRnJvbU9yZGVyTnJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE3JTNBJTIyc0Zyb21PcmRlck5yVmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMyUzQSUyMmJsQ2hlY2tUb09yZGVyTnJfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE1JTNBJTIyc1RvT3JkZXJOclZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVGltZXNwYW4xX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNUaW1lc3BhbjFWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMVVuaXQlMjIlM0JzJTNBNiUzQSUyMm1pbnV0ZSUyMiUzQnMlM0ExNCUzQSUyMnNUaW1lc3BhbjFUeXBlJTIyJTNCcyUzQTklM0ElMjJvcmRlcmRhdGUlMjIlM0JzJTNBMjMlM0ElMjJibENoZWNrVGltZXNwYW4yX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNSUzQSUyMnNUaW1lc3BhbjJWYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTE0JTNBJTIyc1RpbWVzcGFuMlVuaXQlMjIlM0JzJTNBNiUzQSUyMm1pbnV0ZSUyMiUzQnMlM0ExNCUzQSUyMnNUaW1lc3BhbjJUeXBlJTIyJTNCcyUzQTklM0ElMjJvcmRlcmRhdGUlMjIlM0JzJTNBMjQlM0ElMjJibENoZWNrTm90U2V0RGF0ZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTUlM0ElMjJzTm90U2V0RGF0ZVR5cGUlMjIlM0JzJTNBNyUzQSUyMmRlbGRhdGUlMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrV2Vla2RheXNfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTEzJTNBJTIyc1dlZWtkYXlzVHlwZSUyMiUzQnMlM0E5JTNBJTIyb3JkZXJkYXRlJTIyJTNCcyUzQTEyJTNBJTIyc1dlZWtkYXlEYXlzJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjElM0ElMjJibENoZWNrUGF5bWVudF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTAlM0ElMjJzUGF5bWVudElkJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrRGVsaXZlcnlfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTExJTNBJTIyc0RlbGl2ZXJ5SWQlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMyUzQSUyMmJsQ2hlY2tUcmFja2NvZGVfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja09yZGVyc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tPcmRlck5vc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNyUzQSUyMmJsQ2hlY2tBcnRpY2xlc3Rvcm5vX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tPcmRlclN1bV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMTMlM0ElMjJzT3JkZXJTdW1UeXBlJTIyJTNCcyUzQTUlM0ElMjJ0b3RhbCUyMiUzQnMlM0ExNyUzQSUyMnNPcmRlclN1bVJlbGF0aW9uJTIyJTNCcyUzQTYlM0ElMjJoaWdoZXIlMjIlM0JzJTNBMTQlM0ElMjJzT3JkZXJTdW1WYWx1ZSUyMiUzQnMlM0E2JTNBJTIyMjAwLjAwJTIyJTNCcyUzQTI0JTNBJTIyYmxDaGVja0ludm9pY2VOdW1fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja1RyYW5zYWN0aW9uX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNyUzQSUyMnNPcmRlclRyYW5zU3RhdHVzJTIyJTNCcyUzQTIlM0ElMjJPSyUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tDdXJyZW5jeV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTclM0ElMjJzQ3VycmVuY3lJU09WYWx1ZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIyJTNBJTIyYmxDaGVja0xhbmd1YWdlX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMyUzQSUyMnNJbkxhbmd1YWdlSWQlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMiUzQSUyMmJsQ2hlY2tJbkZvbGRlcl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTElM0ElMjJzSW5Gb2xkZXJJZCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTI1JTNBJTIyYmxDaGVja05vdEluRm9sZGVyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNCUzQSUyMnNOb3RJbkZvbGRlcklkJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjclM0ElMjJibENoZWNrT3JkZXJBcnRpY2xlMV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjAlM0ElMjJzQXJ0aWNsZUNvbnRlbnQxVHlwZSUyMiUzQnMlM0E4JTNBJTIyb3hhcnRudW0lMjIlM0JzJTNBMjIlM0ElMjJzQXJ0aWNsZUNvbnRlbnQxUmVnRXhwJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjclM0ElMjJibENoZWNrT3JkZXJBcnRpY2xlMl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjAlM0ElMjJzQXJ0aWNsZUNvbnRlbnQyVHlwZSUyMiUzQnMlM0E4JTNBJTIyb3hhcnRudW0lMjIlM0JzJTNBMjIlM0ElMjJzQXJ0aWNsZUNvbnRlbnQyUmVnRXhwJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjklM0ElMjJibENoZWNrTm9PcmRlckFydGljbGUxX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMiUzQSUyMnNOb0FydGljbGVDb250ZW50MVR5cGUlMjIlM0JzJTNBOCUzQSUyMm94YXJ0bnVtJTIyJTNCcyUzQTI0JTNBJTIyc05vQXJ0aWNsZUNvbnRlbnQxUmVnRXhwJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjklM0ElMjJibENoZWNrTm9PcmRlckFydGljbGUyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMiUzQSUyMnNOb0FydGljbGVDb250ZW50MlR5cGUlMjIlM0JzJTNBOCUzQSUyMm94YXJ0bnVtJTIyJTNCcyUzQTI0JTNBJTIyc05vQXJ0aWNsZUNvbnRlbnQyUmVnRXhwJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMTglM0ElMjJibENoZWNrTWFpbF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTAlM0ElMjJzTWFpbFZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjElM0ElMjJibENoZWNrQ291bnRyeV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTQlM0ElMjJzQ3VzdENvdW50cnlJZCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIxJTNBJTIyYmxDaGVja0luR3JvdXBfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE0JTNBJTIyc0N1c3RJbkdyb3VwSWQlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNCUzQSUyMmJsQ2hlY2tOb3RJbkdyb3VwX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNyUzQSUyMnNDdXN0Tm90SW5Hcm91cElkJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjclM0ElMjJibENoZWNrRXhlY3V0ZU1ldGhvZF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMzAlM0ElMjJzUmVxdWlyZW1lbnRFeGVjdXRlTWV0aG9kX25hbWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNCUzQSUyMmJsQ2hlY2tPcmRlckZpZWxkX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyMSUzQSUyMnNPcmRlckZpZWxkX0ZpZWxkTmFtZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIwJTNBJTIyc0NoZWNrT3JkZXJGaWVsZFR5cGUlMjIlM0JzJTNBNyUzQSUyMmNvbnRlbnQlMjIlM0JzJTNBMjIlM0ElMjJzT3JkZXJGaWVsZF9GaWVsZFZhbHVlJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjIlM0ElMjJibENoZWNrT3RoZXJKb2Jfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTEyJTNBJTIyc090aGVySm9iX0lEJTIyJTNCcyUzQTMyJTNBJTIyMmNlYTgwNTlhMWJlYzM0Njc5NDc1ODVlM2FhNzI2ZmYlMjIlM0JzJTNBMTQlM0ElMjJzT3RoZXJKb2JfVHlwZSUyMiUzQnMlM0E0JTNBJTIyZXhlYyUyMiUzQnMlM0EyNyUzQSUyMmJsQWN0aW9uT3JkZXIyRm9sZGVyX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExMiUzQSUyMnNPcmRlckZvbGRlciUyMiUzQnMlM0ExNSUzQSUyMk9SREVSRk9MREVSX05FVyUyMiUzQnMlM0EyNiUzQSUyMmJsQWN0aW9uT3JkZXJTdG9ybm9fc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTMyJTNBJTIyYmxBY3Rpb25PcmRlclNldFNlbmRlZE5vd19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMzAlM0ElMjJibEFjdGlvbk9yZGVyU2V0UGFpZE5vd19zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMzglM0ElMjJibEFjdGlvbk9yZGVyQ2hhbmdlRGVsaXZlcnlDb3N0X3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0EyNSUzQSUyMnNBY3Rpb25DaGFuZ2VEZWxDb3N0VmFsdWUlMjIlM0JzJTNBNCUzQSUyMjAuMDAlMjIlM0JzJTNBMzQlM0ElMjJibEFjdGlvbk9yZGVyQ2hhbmdlRGlzY291bnRfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI2JTNBJTIyc0FjdGlvbkNoYW5nZURpc2NvdW50VmFsdWUlMjIlM0JzJTNBNCUzQSUyMjAuMDAlMjIlM0JzJTNBMzElM0ElMjJibEFjdGlvbk9yZGVyR2VuZXJhdGVQZGZfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI3JTNBJTIyYmxBY3Rpb25PcmRlclBkZlR5cGVJbnZvaWNlJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI3JTNBJTIyYmxBY3Rpb25PcmRlclBkZlR5cGVEZWxub3RlJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI2JTNBJTIyYmxBY3Rpb25PcmRlclBkZlNlbmRBdHRhY2glMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjQlM0ElMjJibEFjdGlvbk9yZGVyUGRmU2VuZFNhdmUlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMjUlM0ElMjJibEFjdGlvbkN1c3QyR3JvdXBfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTEzJTNBJTIyc0N1c3RBZGRHcm91cCUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTI4JTNBJTIyYmxBY3Rpb25DdXN0RnJvbUdyb3VwX3N0YXR1cyUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNiUzQSUyMnNDdXN0UmVtb3ZlR3JvdXAlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyMyUzQSUyMmJsQWN0aW9uTWFpbHNlbmRfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIwJTNBJTIyc1NlbmRNYWlsRnJvbVN1YmplY3QlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EyNSUzQSUyMnNTZW5kTWFpbEZyb21UZW1wbGF0ZW5hbWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0EzMCUzQSUyMnNTZW5kTWFpbEZyb21UZW1wbGF0ZW5hbWVQbGFpbiUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTIzJTNBJTIyc1NlbmRNYWlsRnJvbU1vZHVsZVBhdGglMjIlM0JzJTNBMTIlM0ElMjJkM21vZGNmZ19saWIlMjIlM0JzJTNBMjQlM0ElMjJzU2VuZE1haWxGcm9tQ29udGVudG5hbWUlMjIlM0JzJTNBMjYlM0ElMjIxMDc0Mjc5ZTY3YTg1ZjViMS45NjkwNzQxMiUyMiUzQnMlM0EyOSUzQSUyMnNTZW5kTWFpbEZyb21Db250ZW50bmFtZVBsYWluJTIyJTNCcyUzQTI2JTNBJTIyMTA3NDI3OWU2N2E4NWY1YjEuOTY5MDc0MTIlMjIlM0JzJTNBMjAlM0ElMjJibFNlbmRNYWlsVG9DdXN0b21lciUyMiUzQnMlM0ExJTNBJTIyMCUyMiUzQnMlM0ExNyUzQSUyMmJsU2VuZE1haWxUb093bmVyJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTE4JTNBJTIyYmxTZW5kTWFpbFRvQ3VzdG9tJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI0JTNBJTIyc1NlbmRNYWlsVG9DdXN0b21BZGRyZXNzJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMTklM0ElMjJibEdldFN0b3Jub0FydGljbGVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIxJTNBJTIyc1NlbmRNYWlsUmVwbHlBZGRyZXNzJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjElM0ElMjJibEFjdGlvbkV4cG9ydF9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0JzJTNBMTYlM0ElMjJhRXhwb3J0RmllbGRMaXN0JTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMTklM0ElMjJzRXhwb3J0VGVtcGxhdGVuYW1lJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjUlM0ElMjJzRXhwb3J0TGlzdEZyb21Nb2R1bGVQYXRoJTIyJTNCcyUzQTEyJTNBJTIyZDNtb2RjZmdfbGliJTIyJTNCcyUzQTE2JTNBJTIyc0V4cG9ydEV4dGVuc2lvbiUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTMzJTNBJTIyYmxBY3Rpb25PcmRlckV4ZWN1dGVNZXRob2Rfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTI1JTNBJTIyc0FjdGlvbkV4ZWN1dGVNZXRob2RfbmFtZSUyMiUzQnMlM0EwJTNBJTIyJTIyJTNCcyUzQTMzJTNBJTIyYmxBY3Rpb25PcmRlckFkZEZpZWxkVmFsdWVfc3RhdHVzJTIyJTNCcyUzQTElM0ElMjIwJTIyJTNCcyUzQTIxJTNBJTIyc0FjdGlvbkFkZEZpZWxkX2ZpZWxkJTIyJTNCcyUzQTAlM0ElMjIlMjIlM0JzJTNBMjElM0ElMjJzQWN0aW9uQWRkRmllbGRfdmFsdWUlMjIlM0JzJTNBMCUzQSUyMiUyMiUzQnMlM0E0MCUzQSUyMmJsQWN0aW9uT3JkZXJTZW5kUHVzaE5vdGlmaWNhdGlvbl9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjElMjIlM0JzJTNBMzElM0ElMjJzQWN0aW9uU2VuZFB1c2hOb3RpZmljYXRpb25fdXJsJTIyJTNCcyUzQTYyJTNBJTIyaHR0cHMlM0ElMkYlMkZtYWtlci5pZnR0dC5jb20lMkZ0cmlnZ2VyJTJGbGFyZ2VPcmRlcnMlMkZ3aXRoJTJGa2V5JTJGY3VzdG9ta2V5JTIyJTNCcyUzQTI2JTNBJTIyYmxBY3Rpb25PcmRlckRlbGV0ZV9zdGF0dXMlMjIlM0JzJTNBMSUzQSUyMjAlMjIlM0IlN0Q=',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXFOLDER',
                'content'       => 'D3_ORDERMANAGER_ORDER_ORDERPROCESSING',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSORT',
                'content'       => '5000',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXWRITEPROTECTION',
                'content'       => "0",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_EXECMANUALLY',
                'content'       => "0",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'D3_OM_MARKORDER',
                'content'       => '1',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
        ];
    }

    /**
     * @param Shop $oShop
     *
     * @return array
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getExampleContent1InsertFields(Shop $oShop): array
    {
        $sShopId = $oShop->getId();

        return [
            [
                'fieldname'     => 'OXID',
                'content'       => "MD5('" . $this->sModKey . " content01 " . $sShopId . "')",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXLOADID',
                'content'       => "d3payreminder",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPID',
                'content'       => $sShopId,
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSNIPPET',
                'content'       => "1",
                'force_update'  => true,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXTYPE',
                'content'       => "0",
                'force_update'  => true,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVE',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXPOSITION',
                'content'       => "",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXTITLE',
                'content'       => "Zahlungserinnerung",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('oxcontent', 'OXTITLE', 'de'),
                'content'       => "Zahlungserinnerung",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('oxcontent', 'OXTITLE', 'en'),
                'content'       => "1. Reminder",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXCONTENT',
                'content'       => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"><html lang="de"><head><title>[{$oShop->oxshops__oxordersubject->value}]</title><meta http-equiv="Content-Type" content="text/html; charset=[{$charset}]"></head><body style="font-family: Verdana,Geneva,Arial,Helvetica,sans-serif; font-size: 10px;" alink="#355222" vlink="#355222" link="#355222" bgcolor="#FFFFFF"><img src="[{$oViewConf->getNoSslImageDir()}]/logo_white.gif" alt="[{$oShop->oxshops__oxname->value}]" border="0" hspace="0" vspace="0" align="texttop"><br><br>Hallo [{$oOrder->oxorder__oxbillsal->value|oxmultilangsal}][{$oOrder->oxorder__oxbilllname->getRawValue()}],<br>'.PHP_EOL.'<br>'.PHP_EOL.'zur Bestellung[{$oOrder->oxorder__oxordernr->getRawValue()}] liegt uns noch keine Bezahlung vor.<br>'.PHP_EOL.'<br>'.PHP_EOL.'Ihr [{$oShop->oxshops__oxname->getRawValue()}]-Team.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXCATID',
                'content'       => '30e44ab83fdee7564.23264141',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXFOLDER',
                'content'       => 'CMSFOLDER_EMAILS',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
        ];
    }

    /**
     * @param Shop $oShop
     *
     * @return array
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getExampleContent2InsertFields(Shop $oShop): array
    {
        $sShopId = $oShop->getId();

        return [
            [
                'fieldname'     => 'OXID',
                'content'       => "MD5('" . $this->sModKey . " content02 " . $sShopId . "')",
                'force_update'  => false,
                'use_quote'     => false,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXLOADID',
                'content'       => "d3payreminder_plain",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSHOPID',
                'content'       => $sShopId,
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXSNIPPET',
                'content'       => "1",
                'force_update'  => true,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXTYPE',
                'content'       => "0",
                'force_update'  => true,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXACTIVE',
                'content'       => "1",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXPOSITION',
                'content'       => "",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXTITLE',
                'content'       => "Zahlungserinnerung Plain",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('oxcontents', 'OXTITLE', 'de'),
                'content'       => "Zahlungserinnerung Plain",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => $this->_getLangAbbrFieldName('oxcontents', 'OXTITLE', 'en'),
                'content'       => "1. Reminder plain",
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXCONTENT',
                'content'       => 'Hallo [{$oOrder->oxorder__oxbillsal->value|oxmultilangsal}] [{$oOrder->oxorder__oxbilllname->getRawValue()}],'.PHP_EOL.PHP_EOL.'zur Bestellung [{$oOrder->oxorder__oxordernr->getRawValue()}] liegt uns noch keine Bezahlung vor.'.PHP_EOL.PHP_EOL.'Ihr [{$oShop->oxshops__oxname->getRawValue()}]-Team.',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => true,
            ],
            [
                'fieldname'     => 'OXCATID',
                'content'       => '30e44ab83fdee7564.23264141',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
            [
                'fieldname'     => 'OXFOLDER',
                'content'       => 'CMSFOLDER_EMAILS',
                'force_update'  => false,
                'use_quote'     => true,
                'use_multilang' => false,
            ],
        ];
    }

    /**
     * @param $sTableName
     *
     * @param $sGetFieldContentMethodName
     * @return bool
     * @throws ConnectionException
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    protected function _addExampleJobItem($sTableName, $sGetFieldContentMethodName): bool
    {
        $blRet = false;

        /** @var $oShop Shop */
        foreach ($this->getShopListByActiveModule('d3ordermanager') as $oShop) {
            $aWhere = [];
            $aInsertFields = $this->{$sGetFieldContentMethodName}($oShop);

            $this->setInitialExecMethod(__METHOD__);
            $blRet  = $this->_updateTableItem2($sTableName, $aInsertFields, $aWhere);

            if ($this->getStepByStepMode()) {
                break;
            }
        }

        return $blRet;
    }

    /**
     * @return bool
     * @throws DBALException
     */
    public function hasNotOrderArticlesParentId(): bool
    {
        if (false == $this->mustCheckOrderArticlesParentId()) {
            return false;
        }

        /** @var d3database $db */
        $db = d3GetModCfgDIC()->get('d3.ordermanager.database');
        $qb = $db->getQueryBuilder();

        $qb->select('ooa.oxparentid != oa.oxparentid')
            ->from('oxorderarticles', 'ooa')
            ->leftJoin('ooa', 'oxarticles', 'oa', 'ooa.oxartid = oa.oxid')
            ->where(
                $qb->expr()->isNotNull('oa.oxparentid')
            )
            ->setMaxResults(1);

        $ret = (bool) $qb->execute()->fetchColumn();

        if ($ret === false) {
            $this->setDontCheckOrderArticlesParentId();
        }

        return $ret;
    }

    /**
     * @return bool
     */
    public function mustCheckOrderArticlesParentId(): bool
    {
        return false === $this->d3GetConfig()->getShopConfVar('setupCheckOrderArticleParentId', null, 'd3ordermanager');
    }

    public function setDontCheckOrderArticlesParentId()
    {
        $this->d3GetConfig()->saveShopConfVar('bool', 'setupCheckOrderArticleParentId', true, null, 'd3ordermanager');
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function addOrderArticlesParentId(): bool
    {
        /** @var d3database $db */
        $db = d3GetModCfgDIC()->get('d3.ordermanager.database');
        $qbsub = $db->getQueryBuilder();

        $qbsub->select('oxarticles.oxparentid')
            ->from('oxarticles')
            ->where(
                $qbsub->expr()->eq(
                    'oxarticles.oxid',
                    'oxorderarticles.oxartid'
                )
            );

        $qb = $db->getQueryBuilder();
        $qb->update('oxorderarticles')
            ->set(
                'oxparentid',
                $qbsub->getSQL()
            )
            ->where(
                $qb->expr()->eq(
                    'oxorderarticles.oxparentid',
                    ""
                )
            );

        $ret = $this->_tableSqlExecute($qb->getSQL(), 'oxorderarticles', true);

        $this->setDontCheckOrderArticlesParentId();

        return $ret;
    }

    /**
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws ReflectionException
     * @throws d3ParameterNotFoundException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function hasUnregisteredFiles(): bool
    {
        return $this->_hasUnregisteredFiles('d3ordermanager', array('d3FileRegister'));
    }

    /**
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws ReflectionException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function showUnregisteredFiles(): bool
    {
        return $this->_showUnregisteredFiles('d3ordermanager', array('d3FileRegister'));
    }
}
