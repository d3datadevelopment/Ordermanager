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

use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_main;
use D3\Ordermanager\Core\ModCfgTrait;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Query\QueryBuilder;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Model\ListModel;
use OxidEsales\Eshop\Core\Model\MultiLanguageModel;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class d3_cfg_ordermanageritem_settings extends d3_cfg_mod_main
{
    use ModCfgTrait;

    protected $_sMenuItemTitle = 'd3mxordermanager';

    protected $_blUseOwnOxid = true;

    protected $_aNaviItems = [
        'new' => [
            'sScript' => 'top.oxid.admin.editThis( -1 );return false;',
            'sTranslationId' => 'D3_TOOLTIPS_NEWORDERMANAGER',
        ],
    ];

    protected $_sD3ObjectClass = Manager::class;

    public function getItemFolders(): array
    {
        return Registry::getConfig()->getConfigParam('aOrderfolder');
    }

    public function getGroupsList(): ListModel
    {
        $oGroupsList = oxNew(ListModel::class);
        $oGroupsList->init('oxgroups');
        return $this->_getObjectList($oGroupsList, null, 'oxtitle ASC');
    }

    public function getDIContainer(): ContainerInterface
    {
        return ContainerFactory::getInstance()->getContainer();
    }

    /**
     * @param ListModel $oObjectList
     * @param null $sWhere
     * @param null $sOrderBy
     * @return ListModel
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function _getObjectList(ListModel $oObjectList, $sWhere = null, $sOrderBy = null): ListModel
    {
        startProfile(__METHOD__);

        /** @var MultiLanguageModel $oObject */
        $oObject = $oObjectList->getBaseObject();
        if ($oObject->isMultilang()) {
            $oObject->setLanguage(Registry::getLang()->getTplLanguage());
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
        $oModCfg =  $this->d3GetOrderManagerConfig();

        return sprintf(
            Registry::getLang()->translateString('D3_ORDERMANAGER_ERROR_RESTRICTIONS'),
            $oModCfg->getLicenseConfigData('sEditionId', 'unknown')
        );
    }
}
