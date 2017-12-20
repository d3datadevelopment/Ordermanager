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

namespace D3\Ordermanager\Modules\Application\Model
{
    class d3_oxbasket_ordermanager_parent extends \OxidEsales\Eshop\Application\Model\Basket {}

    class d3_oxbasketitem_ordermanager_parent extends \OxidEsales\Eshop\Application\Model\BasketItem {}

    class d3_oxemail_ordermanager_parent extends \OxidEsales\Eshop\Core\Email {}

    class d3_oxorder_ordermanager_parent extends \OxidEsales\Eshop\Application\Model\Order {}

    class d3_oxuser_ordermanager_parent extends \OxidEsales\Eshop\Application\Model\User {}
}

namespace D3\Ordermanager\Modules\Application\Controller\Admin
{
    class d3_order_remark_ordermanager_parent extends \OxidEsales\Eshop\Application\Controller\Admin\OrderRemark {}
}