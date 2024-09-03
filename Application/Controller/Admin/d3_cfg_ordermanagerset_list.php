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

use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_list;

class d3_cfg_ordermanagerset_list extends d3_cfg_mod_list
{
    // enables language depended configuration
    protected $_blD3ShowLangSwitch = false;

    protected $_sMenuItemTitle = 'd3mxordermanager';

    protected $_sMenuSubItemTitle = 'd3mxordermanager_settings';

    /**
     * @return null
     */
    public function render()
    {
        $sRet = parent::render();

        // default page number 1
        $this->addTplParam('oxid', 1);
        $this->addTplParam("default_edit", "d3_cfg_ordermanagerset_main");
        $this->addTplParam("updatemain", $this->_blUpdateMain);

        return $sRet;
    }
}
