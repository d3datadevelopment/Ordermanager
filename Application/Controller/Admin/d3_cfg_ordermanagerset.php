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

use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_list as setListController;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanagerset_main as setMainController;
use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_;

class d3_cfg_ordermanagerset extends d3_cfg_mod_
{
    public function render(): string
    {
        $this->addTplParam('sListClass', setListController::class);
        $this->addTplParam('sMainClass', setMainController::class);

        $this->_hasListItems = false;

        return parent::render();
    }
}
