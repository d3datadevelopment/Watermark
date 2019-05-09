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

use D3\ModCfg\Application\Controller\Admin\d3_cfg_mod_licence;
use D3\ModCfg\Application\Model\Log\d3log;

/**
 * Class d3_cfg_watermark_licence
 */
class d3_cfg_watermark_licence extends d3_cfg_mod_licence
{

    protected $_sModId = 'd3_watermark';

    protected $_hasNewsletterForm = false;

    protected $_sLogType = d3log::CRITICAL;

    protected $_sMenuItemTitle = 'd3mxwatermark';

    protected $_sMenuSubItemTitle = 'd3mxwatermark_settings';

    protected $_sDefaultHelpLinkAdd = '';

    protected $_sHelpLinkMLAdd = 'D3_WATERMARK_MAIN_HELPLINK';

}
