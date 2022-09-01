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

namespace D3\Ordermanager\Modules\Application\Model;

use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Application\Model\Article;

class d3_oxbasketitem_ordermanager extends d3_oxbasketitem_ordermanager_parent
{
    public function d3OrderManagerChangeOrderArticle2RealArticle()
    {
        if ($this->_oArticle instanceof OrderArticle) {
            $sArticleId = $this->_oArticle->getProductId();
            $oArticle = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Article::class);

            if ($oArticle->exists($sArticleId) && $oArticle->load($sArticleId)) {
                $this->_oArticle = $oArticle;
            }
        }
    }
}
