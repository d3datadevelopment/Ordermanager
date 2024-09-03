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

use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_licence;

class d3_cfg_ordermanagerset_licence extends d3_cfg_mod_licence
{
    protected $_sModId = 'd3_ordermanager';

    protected $_hasNewsletterForm = false;

    protected $_sMenuItemTitle = 'd3mxordermanager';

    protected $_sMenuSubItemTitle = 'd3mxordermanager_settings';
}
