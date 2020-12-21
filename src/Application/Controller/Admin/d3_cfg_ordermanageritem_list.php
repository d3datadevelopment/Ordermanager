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

namespace D3\Ordermanager\Application\Controller\Admin;

use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_list;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanagerlist as ManagerList;
use OxidEsales\Eshop\Core\TableViewNameGenerator;

class d3_cfg_ordermanageritem_list extends d3_cfg_mod_list
{
    protected $_sListClass = Manager::class;
    protected $_sListType = ManagerList::class;
    protected $_blShowListItems = true;
    protected $_sThisTemplate = 'd3_cfg_ordermanageritem_list.tpl';
    protected $_sMenuItemTitle = 'd3mxordermanager';
    protected $_sMenuSubItemTitle = 'd3mxordermanager_items';

    public function buildWhere()
    {
        $aWhere = parent::buildWhere();

        $baseObject = $this->getItemListBaseObject();
        foreach ($aWhere as $key => $value) {
            unset($aWhere[$key]);
            $aWhere[str_replace(
                oxNew(TableViewNameGenerator::class)->getViewName($baseObject->getCoreTableName()),
                $baseObject->getViewName(),
                $key
            )] = $value;
        }

        return $aWhere;
    }
}
