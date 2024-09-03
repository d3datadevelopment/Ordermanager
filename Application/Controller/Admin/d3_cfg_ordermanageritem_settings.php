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

use D3\ModCfg\Application\Model\Exception\wrongModIdException;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_vars as VariablesTrait;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_main;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\Model\MultiLanguageModel;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use Psr\Container\ContainerInterface;

class d3_cfg_ordermanageritem_settings extends d3_cfg_mod_main
{
    use VariablesTrait;

    protected $_sModId = 'd3_ordermanager';

    protected $_sMenuItemTitle = 'd3mxordermanager';

    protected $_blUseOwnOxid = true;

    protected $_aNaviItems = [
        'new' => [
            'sScript' => 'top.oxid.admin.editThis( -1 );return false;',
            'sTranslationId' => 'D3_TOOLTIPS_NEWORDERMANAGER',
        ],
    ];

    protected $_sD3ObjectClass = Manager::class;

    /**
     * constructor.
     */
    public function __construct()
    {
        d3GetOxidDIC()->getParameter($this->_DIC_Instance_Id . 'modcfgid') === $this->_sModId or
            throw oxNew(wrongModIdException::class, $this->_sModId);

        parent::__construct();
    }

    public function getItemFolders(): array
    {
        /** @var Config $config */
        $config = d3GetOxidDIC()->get($this->_DIC_OxInstance_Id.Config::class);

        return $config->getConfigParam('aOrderfolder');
    }

    public function getGroupsList(): ListModel
    {
        /** @var $oGroupsList ListModel */
        $oGroupsList = d3GetOxidDIC()->get($this->_DIC_OxInstance_Id.ListModel::class);
        $oGroupsList->init('oxgroups');
        return $this->_getObjectList($oGroupsList, null, 'oxtitle ASC');
    }

    public function getDIContainer(): ContainerInterface
    {
        return ContainerFactory::getInstance()->getContainer();
    }

    /**
     * @param null|string $sWhere
     * @param null|string $sOrderBy
     *
     */
    protected function _getObjectList(ListModel $oObjectList, $sWhere = null, $sOrderBy = null): ListModel
    {
        startProfile(__METHOD__);

        /** @var Language $oLang */
        $oLang = d3GetOxidDIC()->get($this->_DIC_OxInstance_Id.Language::class);

        /** @var MultiLanguageModel $oObject */
        $oObject = $oObjectList->getBaseObject();
        if ($oObject->isMultilang()) {
            $oObject->setLanguage($oLang->getTplLanguage());
        }

        $sFieldList = $oObject->getSelectFields();

        /** @var queryBuilder $qb */
        $qb = $this->getDIContainer()->get(QueryBuilderFactoryInterface::class)->create();
        $qb->select($sFieldList)
            ->from($oObject->getViewName());

        if ($sWhere) {
            $qb->add('where', $sWhere);
        }

        if ($sOrderBy) {
            $qb->add('orderBy', $sOrderBy);
        }

        $oObjectList->selectString($qb->getSQL(), $qb->getParameters());

        stopProfile(__METHOD__);

        return $oObjectList;
    }

    public function isEditMode(): bool
    {
        return true;
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function getRestrictionMessage(): string
    {
        /** @var Language $oLang */
        $oLang = d3GetOxidDIC()->get($this->_DIC_OxInstance_Id.Language::class);

        /** @var d3_cfg_mod $oModCfg */
        $oModCfg =  d3GetOxidDIC()->get($this->_DIC_Instance_Id.'modcfg');

        return sprintf(
            $oLang->translateString('D3_ORDERMANAGER_ERROR_RESTRICTIONS'),
            $oModCfg->getLicenseConfigData('sEditionId', 'unknown')
        );
    }
}
