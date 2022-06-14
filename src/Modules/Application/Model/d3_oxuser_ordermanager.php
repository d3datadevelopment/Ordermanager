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

declare(strict_types = 1);

namespace D3\Ordermanager\Modules\Application\Model;

class d3_oxuser_ordermanager extends d3_oxuser_ordermanager_parent
{
    /**
     * @param string $sParamName
     *
     * @return mixed
     */
    public function __get( $sParamName )
    {
        $mContent = parent::__get( $sParamName);

        if (false == $mContent && $this->{$sParamName}) {
            // same extension  in the usermanager module can prevent execution
            // @codeCoverageIgnoreStart
            return $this->{$sParamName};
            // @codeCoverageIgnoreEnd
        }

        return $mContent;
    }
}
