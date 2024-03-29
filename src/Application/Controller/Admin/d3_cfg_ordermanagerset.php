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

declare(strict_types=1);

namespace D3\Ordermanager\Application\Controller\Admin;

use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_list as setListController;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main as setMainController;
use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_;

class d3_cfg_ordermanagerset extends d3_cfg_mod_
{
    /**
     * @return string
     */
    public function render(): string
    {
        $this->addTplParam('sListClass', setListController::class);
        $this->addTplParam('sMainClass', setMainController::class);

        $this->_hasListItems = false;

        return parent::render();
    }
}
