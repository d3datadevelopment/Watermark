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
 * @author    D3 Data Development <support@shopmodule.com>
 * @link      http://www.oxidmodule.com
 */

namespace D3\Watermark\Modules\Core;

use Exception as Exception;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Facts\Facts;

/**
 * Class d3_oxpicturehandler_watermark
 */
class d3_oxpicturehandler_watermark extends d3_oxpicturehandler_watermark_parent
{
    /**
     * @param string $sPath
     * @param string $sFile
     * @param string $sSize
     * @param null   $sIndex
     * @param bool   $sAltPath
     * @param null   $bSsl
     *
     * @return bool|mixed|string
     * @throws Exception
     */
    public function getPicUrl($sPath, $sFile, $sSize, $sIndex = null, $sAltPath = false, $bSsl = null)
    {
        $sUrl = parent::getPicUrl($sPath, $sFile, $sSize, $sIndex, $sAltPath, $bSsl);

        if (strtolower(oxNew(Facts::class)->getEdition()) == 'ee') {
            $aSize = $this->getImageSize($sSize, $sIndex);

            $sSearch = "{$aSize[0]}_{$aSize[1]}_" . Registry::getConfig()->getConfigParam('sDefaultImageQuality');
            $sReplace = $sSearch.'_'.Registry::getConfig()->getShopId();
            $sUrl = str_replace($sSearch, $sReplace, $sUrl);
        }

        return $sUrl;
    }
}
