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

use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_main;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Model\Log\d3log;
use D3\ModCfg\Application\Model\Maintenance\d3clrtmp;
use Doctrine\DBAL\DBALException;
use GuzzleHttp\Client;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException as StandardException;
use OxidEsales\Eshop\Core\Registry as Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\Eshop\Core\UtilsView;

/**
 * Class d3_cfg_watermark_imagetypes
 */
class d3_cfg_watermark_imagetypes extends d3_cfg_mod_main
{

    protected $_sThisTemplate = 'd3_cfg_watermark_imagetypes.tpl';

    protected $_sModId = 'd3_watermark';

    protected $_sMenuItemTitle = 'd3mxwatermark';

    protected $_sMenuSubItemTitle = 'd3mxwatermark_settings';

    protected $_sWatermarkName = 'd3_watermark';

    protected $_aConfigImageSlots;

    protected $_blNewSettings = false;

    protected $_sHelpLinkMLAdd = 'D3_WATERMARK_MAIN_HELPLINK';

    /**
     * Fallback if there is no registered configParam 'aDetailImageSizes' is found
     *
     * @var $aImgFormats array
     */
    public $aImgFormats = array(
        'productpix'     => array(
            'icon',
            'thumb',
            'pic1',
            'pic2',
            'pic3',
            'pic4',
            'pic5',
            'pic6',
            'pic7',
            'pic8',
            'pic9',
            'pic10',
            'pic11',
            'pic12',
            'master'
        ),
        'productZoomPix' => array(
            'zoom1',
            'zoom2',
            'zoom3',
            'zoom4',
            'zoom5',
            'zoom6',
            'zoom7',
            'zoom8',
            'zoom9',
            'zoom10',
            'zoom11',
            'zoom12'
        ),
        'otherPix'       => array(
            'category_icon',
            'category_promo_icon',
            'category_thumb',
            'manufacturer_icon',
            'vendor_icon'
        )
    );

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
        $this->addTplParam("hasNewSettings", $this->getHasNewSettings());
        $this->addTplParam("sNewSettingsMessage", 'D3_WATERMARK_NEW_WATERMARKSETTINGS');
        $this->setHasNewSettings();

        return parent::render();
    }

    public function save()
    {
        $generellSettings = Registry::get(Request::class)->getRequestEscapedParameter('value');
        d3_cfg_mod::get('d3_watermark')->d3getLog()->log(
            d3log::INFO,
            __CLASS__,
            __FUNCTION__,
            __LINE__,
            "save generell settings via parent call",
            "settings: " . var_export($generellSettings, true)
        );

        $this->setHasNewSettings(true);

        return parent::save();
    }

    /**
     * @param bool $blNew
     */
    public function setHasNewSettings($blNew = false)
    {
        $this->_blNewSettings = $blNew;
    }

    /**
     * @return bool
     */
    public function getHasNewSettings()
    {
        return $this->_blNewSettings;
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
    public function d3deleteAllGeneratedArticlePictures()
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
     * @param $sType
     *
     * @return string
     */
    public function getGroupname($sType)
    {
        $sGroupname = 'otherPix';

        if ($sType == 'pic') {
            $sGroupname = 'productpix';
        } elseif ($sType == 'zoom') {
            $sGroupname = 'productZoomPix';
        }

        return $sGroupname;
    }

    /**
     * @return array
     */
    public function getImageFormats()
    {
        $aRegImages = $this->_getRegisteredImageFormats();

        if (is_array($aRegImages)) {
            $this->aImgFormats = array(
                'productpix'     => array(
                    'icon',
                    'thumb'
                ),
                'productZoomPix' => array(),
                'otherPix'       => array(
                    'category_icon',
                    'category_promo_icon',
                    'category_thumb',
                    'manufacturer_icon',
                    'vendor_icon'
                )
            );

            array_walk($aRegImages, array($this, '_addImageSlot'), 'pic');
            array_walk($aRegImages, array($this, '_addImageSlot'), 'zoom');
        }

        return $this->aImgFormats;
    }

    /**
     * @return array
     */
    protected function _getRegisteredImageFormats()
    {
        if (!$this->_aConfigImageSlots) {
            $this->_aConfigImageSlots = array();

            foreach ( Registry::getConfig()->getConfigParam( 'aDetailImageSizes') as $sIdent => $sSize) {
                if ($sIdent && $sSize) {
                    $this->_aConfigImageSlots[$sIdent] = str_replace('oxpic', '', strtolower($sIdent));
                }
            }
        }

        return $this->_aConfigImageSlots;
    }

    /**
     * @param $sIdent
     * @param $sName
     * @param $sType
     */
    protected function _addImageSlot($sIdent, $sName, $sType)
    {
        $this->aImgFormats[$this->getGroupname($sType)][] = $sType . $sIdent;
        unset($sName);
    }
}
