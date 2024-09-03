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

namespace D3\Ordermanager\Modules\Application\Model
{
    use OxidEsales\Eshop\Application\Model\Basket;
    use OxidEsales\Eshop\Application\Model\BasketItem;
    use OxidEsales\Eshop\Application\Model\Order;
    use OxidEsales\Eshop\Application\Model\User;
    use OxidEsales\Eshop\Core\Email;

    class d3_oxbasket_ordermanager_parent extends Basket
    {
    }

    class d3_oxbasketitem_ordermanager_parent extends BasketItem
    {
    }

    class d3_oxemail_ordermanager_parent extends Email
    {
    }

    class d3_oxorder_ordermanager_parent extends Order
    {
    }

    class d3_oxuser_ordermanager_parent extends User
    {
    }
}

namespace D3\Ordermanager\Modules\Core {
    use D3\DIContainerHandler\definitionFileContainer;

    class DefinitionFileContainer_ordermanager_parent extends definitionFileContainer
    {
    }
}
