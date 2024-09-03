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

use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_list as itemList;
use D3\Ordermanager\Application\Controller\Admin\d3_cfg_ordermanageritem_main as itemMain;

class d3_cfg_ordermanageritem extends d3_cfg_mod_
{
    public function render(): string
    {
        $this->addTplParam('sListClass', itemList::class);
        $this->addTplParam('sMainClass', itemMain::class);

        $this->_hasListItems = true;

        return parent::render();
    }
}
