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

namespace D3\Ordermanager\Modules\Application\Model;

use D3\DIContainerHandler\d3DicException;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Application\Model\Article;

class d3_oxbasketitem_ordermanager extends d3_oxbasketitem_ordermanager_parent
{
    /**
     * @throws d3DicException
     */
    public function d3OrderManagerChangeOrderArticle2RealArticle(): void
    {
        if ($this->_oArticle instanceof OrderArticle) {
            $sArticleId = $this->_oArticle->getProductId();
            /** @var Article $oArticle */
            $oArticle = d3GetOxidDIC()->get('d3ox.ordermanager.'.Article::class);

            if ($oArticle->exists($sArticleId) && $oArticle->load($sArticleId)) {
                $this->_oArticle = $oArticle;
            }
        }
    }
}
