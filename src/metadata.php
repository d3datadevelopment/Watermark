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

use D3\ModCfg\Application\Model\d3utils;
use D3\Watermark\Setup\Events as Events;
use OxidEsales\Eshop\Application as OxidCore;

/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

/**
 * Module information
 */
$aModule = array(
    'id'          => 'd3_watermark',
    'title'       => (class_exists(
            d3utils::class) ? d3utils::getInstance()->getD3Logo() : 'D&sup3;')
        . ' Wasserzeichen',
    'description' => array(
        'de' => 'Versieht Ihre Artikelbilder automatisch mit einem individuellen Wasserzeichen. ' //
            . 'So sind Ihre Bilder individuell und lassen sich nicht einfach kopieren.',
        'en' => ''
    ),
    'thumbnail'   => 'picture.png',
    'version'     => '3.0.0.0',
    'author'      => 'D&sup3; Data Development (Inh.: Thomas Dartsch)',
    'email'       => 'support@shopmodule.com',
    'url'         => 'http://www.oxidmodule.com/',
    'extend'      => array(
        OxidCore\Model\Article::class               => D3\Watermark\Modules\Models\d3_oxarticle_watermark::class,
        OxidEsales\Eshop\Core\PictureHandler::class => D3\Watermark\Modules\Core\d3_oxpicturehandler_watermark::class,
    ),
    'controllers' => array(
        'd3_cfg_watermark'            => D3\Watermark\Controllers\Admin\d3_cfg_watermark::class,
        'd3_cfg_watermark_list'       => D3\Watermark\Controllers\Admin\d3_cfg_watermark_list::class,
        'd3_cfg_watermark_main'       => D3\Watermark\Controllers\Admin\d3_cfg_watermark_main::class,
        'd3_cfg_watermark_imagetypes' => D3\Watermark\Controllers\Admin\d3_cfg_watermark_imagetypes::class,
        'd3_cfg_watermark_licence'    => D3\Watermark\Controllers\Admin\d3_cfg_watermark_licence::class,
    ),
    'templates'   => array(
        'd3_cfg_watermark_main.tpl'                => 'd3/watermark/views/admin/tpl/d3_cfg_watermark_main.tpl',
        'd3_cfg_watermark_imagetypes.tpl'          => 'd3/watermark/views/admin/tpl/d3_cfg_watermark_imagetypes.tpl',
        'd3_cfg_watermark_clearpictures_popup.tpl' => 'd3/watermark/views/admin/tpl/d3_cfg_watermark_clearpictures_popup.tpl',
    ),
    'events'      => array(
        'onActivate' => Events::class . '::onActivate',
        'onDeactivate' => Events::class . '::onDeactivate',
    ),
    'd3SetupClasses' => array(
        D3\Watermark\Setup\d3watermark_update::class,
    ),
    'blocks'      => array(),
    'd3FileRegister' => array(
        'd3/watermark/metadata.php',
        'd3/watermark/IntelliSenseHelper.php',
        'd3/watermark/Core/utils/d3_getimg_wm.php',
        'd3/watermark/Core/utils/d3_oxpicgenerator_watermark.php',
        'd3/watermark/Core/d3_oxdynimggenerator_watermark.php',
        'd3/watermark/Models/d3watermark_activeCheck_forShop.php',
        'd3/watermark/public/d3watermark_src.php',
        'd3/watermark/views/admin/de/d3_watermark_lang.php',
        'd3/watermark/views/admin/en/d3_watermark_lang.php',
        'd3/watermark/Setup/Events.php',
        'd3/watermark/models/d3watermark.php'
    ),
);
