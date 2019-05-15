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

namespace D3\Ordermanager\Modules\Application\Model;

use Exception;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Application\Model\Article;

class d3_oxbasketitem_ordermanager extends d3_oxbasketitem_ordermanager_parent
{
    /**
     * @throws Exception
     */
    public function d3ChangeOrderArticle2RealArticle()
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
