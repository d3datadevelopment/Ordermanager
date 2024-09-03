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

class d3_oxuser_ordermanager extends d3_oxuser_ordermanager_parent
{
    /**
     * @param string $sParamName
     *
     * @return mixed
     */
    public function __get($sParamName)
    {
        $mContent = parent::__get($sParamName);

        if ($mContent === null && isset($this->{$sParamName})) {
            // same extension  in the usermanager module can prevent execution
            // @codeCoverageIgnoreStart
            return $this->{$sParamName};
        // @codeCoverageIgnoreEnd
        } elseif ($mContent) {
            return $mContent;
        }

        return null;
    }
}
