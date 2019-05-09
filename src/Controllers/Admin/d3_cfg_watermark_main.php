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

namespace D3\Watermark\Controllers\Admin;

use D3\ModCfg\Application\Model\d3filesystem;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_main;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Model\Log\d3log;
use D3\ModCfg\Application\Model\Maintenance\d3clrtmp;
use Doctrine\DBAL\DBALException;
use Intervention\Image\ImageManagerStatic;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException as StandardException;
use OxidEsales\Eshop\Core\Registry as Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\Eshop\Core\UtilsView;

class d3_cfg_watermark_Main extends d3_cfg_mod_main
{

    protected $_sThisTemplate = 'd3_cfg_watermark_main.tpl';

    protected $_sModId = 'd3_watermark';

    protected $_sMenuItemTitle = 'd3mxwatermark';

    protected $_sMenuSubItemTitle = 'd3mxwatermark_settings';

    protected $_sWatermarkName = 'd3_watermark';

    protected $_sHelpLinkMLAdd = 'D3_WATERMARK_MAIN_HELPLINK';

    protected $_blFailUpload = false;

    protected $_blNewWatermark = false;

    protected $_aAllowExtension = array("gif", "jpg", "png");

//    protected $_blHasDebugSwitch = false;
//    protected $_blHasTestModeSwitch = false;
//    protected $_sDebugHelpTextIdent = 'D3_CFG_MOD_GENERAL_DEBUGACTIVE_DESC';
//    protected $_sTestModeHelpTextIdent = 'D3_CFG_MOD_GENERAL_TESTMODEACTIVE_DESC';

    /**
     * @var d3clrtmp
     */
    public $oClrTmp;

    /**
     * @return string
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function render()
    {
        //Fehler beim Upload?
        $this->addTplParam("isfailupload", $this->_blFailUpload);
        $this->addTplParam("isNewWatermarkAdded", $this->getHasNewWatermarkPicture());
        $this->addTplParam("sNewSettingsMessage", 'D3_WATERMARK_NEW_WATERMARKPICTURE');
        $this->setHasNewWatermarkPicture();

        return parent::render();
    }

    /**
     * @param bool $blNew
     */
    public function setHasNewWatermarkPicture($blNew = false)
    {
        $this->_blNewWatermark = $blNew;
    }

    /**
     * @return bool
     */
    public function getHasNewWatermarkPicture()
    {
        return $this->_blNewWatermark;
    }

    public function save()
    {
        $this->_savePicture();

        $generellSettings = Registry::get(Request::class)->getRequestEscapedParameter('value');
        $this->d3GetSet()->d3getLog()->log(
            d3log::INFO,
            __CLASS__,
            __FUNCTION__,
            __LINE__,
            "save generell settings via parent call",
            "settings: " . var_export($generellSettings, true)
        );

        parent::save();

        return;
    }

    /**
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    protected function _savePicture()
    {
        $sFilename = $_FILES['imagefile']['name'];

        if (false == empty($sFilename)) {
            /** @var d3filesystem $oFS */
            $oFS               = oxNew(d3filesystem::class);
            $aFile             = $oFS->splitFilename($sFilename);
            $sCompareExtension = strtolower($aFile['ext']);

            if (false == in_array($sCompareExtension, $this->_aAllowExtension)) {
                $this->d3GetSet()->d3getLog()->log(
                    d3log::ERROR,
                    __CLASS__,
                    __FUNCTION__,
                    __LINE__,
                    "wrong file extension",
                    "upload failed for file " . $sFilename . "\n set fail upload and return"
                );

                $this->_blFailUpload = 11;

                return false;
            }

            $sFileName = $this->getWatermarkName($sFilename);
            $sDest     = $this->getConfig()->getImageDir($this->isAdmin()) . $sFileName; // ist aktuell immer out/admin/img/d3_watermark.png

            if (@copy($_FILES['imagefile']['tmp_name'], $sDest)) {
                if (move_uploaded_file($_FILES['imagefile']['tmp_name'], $sDest)) {
                    $sType = $this->_createWMIcon($sDest, $sFileName);

                    $this->d3GetSet()->setValue('sWaterMark_FileName', $sFileName);
                    $this->d3GetSet()->setValue('sWaterMark_FileType', $sType);
                    $this->setHasNewWatermarkPicture(true);

                    $this->d3GetSet()->d3getLog()->log(
                        d3log::INFO,
                        __CLASS__,
                        __FUNCTION__,
                        __LINE__,
                        "new file is saved",
                        "file is saved to " . $sDest
                    );

                    // clear cached icon, show new watermark pic in admin

                }
            }
        } else {
            $this->d3GetSet()->d3getLog()->log(
                d3log::DEBUG,
                __CLASS__,
                __FUNCTION__,
                __LINE__,
                "no new file found",
                var_export($sFilename, true)
            );
        }

        return true;
    }

    /**
     * @param $sSourceImage
     * @param $sFileName
     *
     * @return mixed
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    protected function _createWMIcon($sSourceImage, $sFileName)
    {
        list($width, $height, $type) = getimagesize($sSourceImage);

        $pDestImage   = null;
        $pSourceImage = null;
        $iNewWidth    = 100;
        $iFactor      = $width / $iNewWidth;
        $iNewHeight   = round($height / $iFactor);

        $sIcoFileName      = $this->getWatermarkName($sFileName, '_ico');
        $sDestinationImage = $this->getConfig()->getImageDir(1) . $sIcoFileName;

        ImageManagerStatic::make($sSourceImage)
            ->resize($iNewWidth, $iNewHeight)
            ->save($sDestinationImage);

        $this->d3GetSet()->setValue('sWaterMark_IcoFileName', $sIcoFileName);

        return $type;
    }

    /**
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     */
    public function d3deleteAllGeneratedAllPictures()
    {
        /** @var $oClrTmp d3clrtmp */
        $oClrTmp = $this->_getClrTmp();
        $oClrTmp->clearGeneratedAllImgs();

        Registry::get(UtilsView::class)->addErrorToDisplay( 'D3_WATERMARK_CLRTMP_GENIMGS_SUCC');
    }

    /**
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     */
    public function d3deleteAllGeneratedProductPictures()
    {
        /** @var $oClrTmp d3clrtmp */
        $oClrTmp = $this->_getClrTmp();
        $oClrTmp->clearGeneratedProductImgs();

        Registry::get(UtilsView::class)->addErrorToDisplay( 'D3_WATERMARK_CLRTMP_GENIMGS_SUCC');
    }

    /**
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     */
    public function d3deleteAllGeneratedCategoryPictures()
    {
        /** @var $oClrTmp d3clrtmp */
        $oClrTmp = $this->_getClrTmp();
        $oClrTmp->clearGeneratedCategoryImgs();

        Registry::get(UtilsView::class)->addErrorToDisplay( 'D3_WATERMARK_CLRTMP_GENIMGS_SUCC');
    }

    /**
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     */
    public function d3deleteAllGeneratedManufacturerPictures()
    {
        /** @var $oClrTmp d3clrtmp */
        $oClrTmp = $this->_getClrTmp();
        $oClrTmp->clearGeneratedManufacturerImgs();

        Registry::get(UtilsView::class)->addErrorToDisplay( 'D3_WATERMARK_CLRTMP_GENIMGS_SUCC');
    }

    /**
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     */
    public function d3deleteAllGeneratedVendorPictures()
    {
        /** @var $oClrTmp d3clrtmp */
        $oClrTmp = $this->_getClrTmp();
        $oClrTmp->clearGeneratedVendorImgs();

        Registry::get(UtilsView::class)->addErrorToDisplay( 'D3_WATERMARK_CLRTMP_GENIMGS_SUCC');
    }

    /**
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     */
    public function d3deleteAllGeneratedWrappingPictures()
    {
        /** @var $oClrTmp d3clrtmp */
        $oClrTmp = $this->_getClrTmp();
        $oClrTmp->clearGeneratedWrappingImgs();

        Registry::get(UtilsView::class)->addErrorToDisplay( 'D3_WATERMARK_CLRTMP_GENIMGS_SUCC');
    }

    /**
     * @return d3clrtmp
     */
    protected function _getClrTmp()
    {
        return oxNew(d3clrtmp::class);
    }

    /**
     * @return string
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getWatermarkIconUrl()
    {
        $oViewConfig = $this->getViewConfig();
        $pictureName = d3_cfg_mod::get('d3_watermark')->getEditValue('sWaterMark_IcoFileName');
        $picturePAth = $this->getConfig()->getImagePath($pictureName, true);

        return $oViewConfig->getImageUrl($pictureName). '?'.filemtime($picturePAth);
    }

    /**
     * @return string
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getWatermarkUrl()
    {
        $oViewConfig = $this->getViewConfig();
        $pictureName = d3_cfg_mod::get('d3_watermark')->getEditValue('sWaterMark_FileName');
        $picturePAth = $this->getConfig()->getImagePath($pictureName, true);

        return $oViewConfig->getImageUrl($pictureName). '?'.filemtime($picturePAth);
    }

    /**
     * @param string $sFilename
     * @param string $additionName
     *
     * @return string
     */
    protected function getWatermarkName($sFilename, $additionName = '')
    {
        $sFileName = $this->_sWatermarkName;
        $sFileName .= '_'. $this->getConfig()->getActiveShop()->getShopId();
        $sFileName .= $additionName;
        $sFileName .= substr($sFilename, strrpos($sFilename, '.'));

        return $sFileName;
    }
}
