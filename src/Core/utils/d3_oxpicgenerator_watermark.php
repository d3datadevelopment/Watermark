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

use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception as d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException as d3ShopCompatibilityAdapterException;
use D3\Watermark\Models\d3watermark as d3watermark;
use Doctrine\DBAL\DBALException as DBALException;
use Intervention\Image\ImageManagerStatic;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException as DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException as DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException as StandardException;
use OxidEsales\Eshop\Core\Module\Module as Module;

if (false == function_exists("getShopBasePath")) {
    /**
     * Returns shop base path.
     *
     * @return string
     */
    function getShopBasePath()
    {
        return realpath(dirname(__FILE__) . '/../../../..') . '/';
    }
}

/** @var $oModule oxmodule */
$oModule = oxNew( Module::class);
if ($oModule->load('d3_watermark') && $oModule->isActive()) {

    /**
     * @param $sSrc
     * @param $sTarget
     * @param $iWidth
     * @param $iHeight
     * @param $iOriginalWidth
     * @param $iOriginalHeight
     * @param $iGdVer
     *
     * @return string
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    function resizeGif($sSrc, $sTarget, $iWidth, $iHeight, $iOriginalWidth, $iOriginalHeight, $iGdVer)
    {
        unset($iGdVer);
        unset($hDestinationImage);
        $aImageInfo = [
            0 => $iOriginalWidth,
            1 => $iOriginalHeight
        ];

        return d3ResizeImage($sSrc, $sTarget, $iWidth, $iHeight, $aImageInfo);
    }

    /**
     * @param $sSrc
     * @param $sTarget
     * @param $iWidth
     * @param $iHeight
     * @param $aImageInfo
     * @param $iGdVer
     * @param $hDestinationImage
     *
     * @return string
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    function resizePng($sSrc, $sTarget, $iWidth, $iHeight, $aImageInfo, $iGdVer, $hDestinationImage)
    {
        unset($iGdVer);
        unset($hDestinationImage);

        return d3ResizeImage($sSrc, $sTarget, $iWidth, $iHeight, $aImageInfo);
    }

    /**
     * @param $sSrc
     * @param $sTarget
     * @param $iWidth
     * @param $iHeight
     * @param $aImageInfo
     * @param $iGdVer
     * @param $hDestinationImage
     * @param $iDefQuality
     *
     * @return string
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    function resizeJpeg($sSrc, $sTarget, $iWidth, $iHeight, $aImageInfo, $iGdVer, $hDestinationImage, $iDefQuality)
    {
        unset($iGdVer);
        unset($hDestinationImage);

        return d3ResizeImage($sSrc, $sTarget, $iWidth, $iHeight, $aImageInfo, $iDefQuality);
    }

    /**
     * @param $sSourceImage
     * @param $sTarget
     * @param $iWidth
     * @param $iHeight
     * @param $aImageInfo
     * @param $iDefQuality
     *
     * @return string
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    function d3ResizeImage($sSourceImage, $sTarget, $iWidth, $iHeight, $aImageInfo, $iDefQuality = null)
    {
        $aResult = checkSizeAndCopy($sSourceImage, $sTarget, $iWidth, $iHeight, $aImageInfo[0], $aImageInfo[1]);

        /** @var d3watermark $oWatermarkHandler */
        $oWatermarkHandler = oxNew(d3watermark::class);

        $oImage = ImageManagerStatic::make( $sSourceImage );

        if (is_array($aResult)) {
            list( $iNewWidth, $iNewHeight ) = $aResult;
            $oImage->resize( $iNewWidth, $iNewHeight );
        } else {
            $iNewWidth = $iWidth;
            $iNewHeight = $iHeight;
        }

        $oImage = $oWatermarkHandler->d3AddWatermark( $sSourceImage, $sTarget, $oImage, $iNewWidth, $iNewHeight);
        $oImage->save( $sTarget, $iDefQuality );

        return makeReadable($sTarget);
    }
}

include_once '../../../../../../vendor/oxid-esales/oxideshop-ce/source/Core/utils/oxpicgenerator.php';

