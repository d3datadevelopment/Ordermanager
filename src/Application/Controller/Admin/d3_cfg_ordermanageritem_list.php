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

use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_list;
use OxidEsales\Eshop\Core\TableViewNameGenerator;

class d3_cfg_ordermanageritem_list extends d3_cfg_mod_list
{
    protected $_sListClass = d3ordermanager::class;
    protected $_sListType = d3ordermanagerlist::class;
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
