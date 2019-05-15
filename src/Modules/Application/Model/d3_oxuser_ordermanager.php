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

class d3_oxuser_ordermanager extends d3_oxuser_ordermanager_parent
{
    /**
     * @param string $sName
     *
     * @return mixed
     */
    public function __get($sName)
    {
        $mContent = parent::__get($sName);

        if (false == $mContent && $this->{$sName}) {
            return $this->{$sName};
        }

        return $mContent;
    }
}
