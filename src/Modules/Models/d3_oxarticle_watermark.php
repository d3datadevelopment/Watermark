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

namespace D3\Watermark\Modules\Models;

/**
 * Class d3_oxarticle_watermark
 */
class d3_oxarticle_watermark extends d3_oxarticle_watermark_parent
{
    /**
     * @param int $iIndex
     *
     * @return string
     */
    public function getMasterZoomPictureUrl($iIndex)
    {
        return $this->getZoomPictureUrl($iIndex);
    }
}
