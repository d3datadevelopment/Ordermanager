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

namespace D3\Ordermanager\Modules\Application\Controller\Admin;

use Exception;
use OxidEsales\Eshop\Application\Model\Remark;
use OxidEsales\Eshop\Core\Language;

class d3_order_remark_ordermanager extends d3_order_remark_ordermanager_parent
{
    protected $_d3SearchPattern = '(<option\s+value=("|\')(%s)\2.*?>.*?)(\[.*?\])(.*?<\s*/option>)';

    public function render()
    {
        $sRet = parent::render();

        $this->addTplParam('sOriginalTplName', $sRet);
        $sRet = 'd3_ordermanager_order_remark.tpl';

        return $sRet;
    }

    /**
     * @param $sTplContent
     * @return string
     * @throws Exception
     */
    public function d3FixRemarkItems($sTplContent)
    {
        $aRemarkList = $this->getViewDataElement("allremark");
        /** @var Remark $oRemark */
        foreach ($aRemarkList as $oRemark) {
            if ($oRemark->getFieldData('oxtype') == 'd3om') {
                $sTplContent = $this->d3ReplaceType($sTplContent, $oRemark->getId());
            }
        }
        return $sTplContent;
    }

    /**
     * @return Language
     * @throws Exception
     */
    public function getLang()
    {
        return d3GetModCfgDIC()->get('d3ox.ordermanager.'.Language::class);
    }

    /**
     * @param $sHtml
     * @param $sId
     * @return string
     * @throws Exception
     */
    public function d3ReplaceType($sHtml, $sId)
    {
        $sPattern = '@'.sprintf($this->_d3SearchPattern, $sId).'@is';
        $sReplace = '\1'.$this->getLang()->translateString('D3_ORDERMANAGER_REMARK_NOTE', null, true).'\5';
        return preg_replace($sPattern, $sReplace, $sHtml);
    }
}