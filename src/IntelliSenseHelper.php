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
    use OxidEsales\Eshop\Application\Model\Basket;
    use OxidEsales\Eshop\Application\Model\BasketItem;
    use OxidEsales\Eshop\Application\Model\Order;
    use OxidEsales\Eshop\Application\Model\User;
    use OxidEsales\Eshop\Core\Email;

    class d3_oxbasket_ordermanager_parent extends Basket {}

    class d3_oxbasketitem_ordermanager_parent extends BasketItem {}

    class d3_oxemail_ordermanager_parent extends Email {}

    class d3_oxorder_ordermanager_parent extends Order {}

    class d3_oxuser_ordermanager_parent extends User {}
}

namespace D3\Ordermanager\Modules\Application\Controller\Admin
{
    use OxidEsales\Eshop\Application\Controller\Admin\OrderRemark;

    class d3_order_remark_ordermanager_parent extends OrderRemark {}
}