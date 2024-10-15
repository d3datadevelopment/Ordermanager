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

use D3\Ordermanager\Application\Model\Constants;
use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use OxidEsales\Eshop\Application\Controller\Admin\AdminMall;  // required for non fallback case

// @codeCoverageIgnoreStart
// fallback for non ee editions
if ( ! class_exists( '\\' . AdminMall::class ) ) {
    class d3AdminMall extends AdminDetailsController
    {
        protected $_sThisTemplate = '@'. Constants::OXID_MODULE_ID .'/admin/d3_cfg_ordermanageritem_mall';

        public function render(): string
        {
            parent::render();
            return $this->_sThisTemplate;
        }

        public function assignToSubshops(): void
        {
        }
    }
} else {
    class d3AdminMall extends AdminMall
    {
    }
}

// @codeCoverageIgnoreEnd
