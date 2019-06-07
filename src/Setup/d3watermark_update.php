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

namespace D3\Watermark\Setup;

use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ParameterNotFoundException;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Model\Install\d3install_updatebase;
use D3\ModCfg\Application\Model\d3filesystem;
use Doctrine\DBAL\DBALException;
use OxidEsales\Eshop\Application\Model\Shop;
use OxidEsales\Eshop\Core\Exception\ConnectionException as ConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException as StandardException;
use OxidEsales\Eshop\Core\Registry as Registry;
use OxidEsales\Facts\Facts;
use ReflectionException as ReflectionException;

/**
 * Class d3watermark_update
 */
class d3watermark_update extends d3install_updatebase
{

    public $sModKey = 'd3_watermark';

    public $sModName = 'Wasserzeichen';

    public $sModVersion = '3.1.0.0';

    public $sModRevision = '3100';

    public $sBaseConf = 'vslv2==M2svYjMveTZIc21vVCs4TkcyMm04YW9lbmgrbjNrRzhMVndwRElPNEp5SFpKcjhtUmhLY1p4T
jRHSkVrcWdNbmgyc1lXdi9OQVBNWm1OQVZETjZuTGV5aTFvM0NHSXlCVXJrUGlsT0JHWHFTeHBISEIzc
FdGbjlXaDBvWENGUTQrb25SOHlDc05NTW1IckpCNkN0ejBWaDhpaDdvb01YZ0VheGhJa2JodFNVdy9iU
1FOblM1SzJzTlNjV1pkcFRJbU9ZRVNsSWsreGg0TnZvSGh5ai9kQmtvZzdMWk0vVXVoYnBvekhDWTI0M
ktBdWxDZXpUbVk1NGVYK1NrV000TjE2UDZtaERVS2U5SHFPNEdrYzVWb0VHK3I0TXVGTGRkbzhTOUNKY
mhnYVVtUWhpbWVkeWFhZTNMQTdNQ2NETFVWSXBzTmNpSnFVMGZTUndZR2NTRHVBPT0=';

    public $sRequirements = '';

    public $sBaseValue = '';

    protected $_aUpdateMethods = array(
        array(
            'check' => 'checkModCfgItemExist',
            'do'    => 'updateModCfgItemExist'
        ),
        array(
            'check' => 'checkHtaccessRedirect',
            'do'    => 'updateHtaccessRedirect'
        ),
        array(
            'check' => 'hasToshowChangedHtaccessMessage',
            'do'    => 'showChangedHtaccessMessage'
        ),
        array(
            'check' => 'hasUnregisteredFiles',          // gültige Modul-Dateien prüfen - see metadata.php d3FileRegister
            'do'    => 'showUnregisteredFiles'
        ),
        array(
            'check' => 'checkModCfgSameRevision',
            'do'    => 'updateModCfgSameRevision'
        ),
    );

    /**
     * minimale Modul-Connector Versionsprüfung für die Installation
     */
    public $sMinModCfgVersion = '5.1.1.8';

    protected $_aRefreshMetaModuleIds = array('d3_watermark');

    /**
     * @return bool
     * @throws d3ParameterNotFoundException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws ReflectionException
     */
    public function hasUnregisteredFiles()
    {
        return $this->_hasUnregisteredFiles($this->sModKey, array('d3FileRegister'));
    }

    /**
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws ReflectionException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function showUnregisteredFiles()
    {
        return $this->_showUnregisteredFiles($this->sModKey, array('d3FileRegister'));
    }

    /**********************************************************************/
    /*** Modul Eintrag in der Datenbank ***********************************/
    /**********************************************************************/
    /**
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     */
    public function checkModCfgItemExist()
    {
        $blRet = false;
        foreach ($this->getShopList() as $oShop) {
            /** @var $oShop Shop */
            $aWhere = array(
                'oxmodid'       => $this->sModKey,
                'oxnewrevision' => $this->sModRevision,
                'oxshopid'      => $oShop->getId(),
            );

            $blRet = $this->_checkTableItemNotExist('d3_cfg_mod', $aWhere);

            if ($blRet) {
                return $blRet;
            }
        }

        return $blRet;
    }

    /**
     * @return bool
     * @throws ConnectionException
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function updateModCfgItemExist()
    {
        $blRet = false;

        if ($this->checkModCfgItemExist()) {
            foreach ($this->getShopList() as $oShop) {
                /** @var $oShop Shop */
                $aWhere = array(
                    'oxmodid'       => $this->sModKey,
                    'oxshopid'      => $oShop->getId(),
                    'oxnewrevision' => $this->sModRevision,
                );

                if ($this->_checkTableItemNotExist('d3_cfg_mod', $aWhere)) {
                    // update don't use this property
                    unset($aWhere['oxnewrevision']);

                    $aInsertFields = array(
                        'OXID'           => array(
                            'content'      => "md5('" . $this->sModKey . " " . $oShop->getId() . "')",
                            'force_update' => false,
                            'use_quote'    => false,
                        ),
                        'OXSHOPID'       => array(
                            'content'      => $oShop->getId(),
                            'force_update' => false,
                            'use_quote'    => true,
                        ),
                        'OXMODID'        => array(
                            'content'      => $this->sModKey,
                            'force_update' => true,
                            'use_quote'    => true,
                        ),
                        'OXNAME'         => array(
                            'content'      => $this->sModName,
                            'force_update' => true,
                            'use_quote'    => true,
                        ),
                        'OXACTIVE'       => array(
                            'content'      => "0",
                            'force_update' => false,
                            'use_quote'    => false,
                        ),
                        'OXBASECONFIG'   => array(
                            'content'      => $this->sBaseConf,
                            'force_update' => true,
                            'use_quote'    => true,
                        ),
                        'OXINSTALLDATE'  => array(
                            'content'      => "NOW()",
                            'force_update' => true,
                            'use_quote'    => false,
                        ),
                        'OXVERSION'      => array(
                            'content'      => $this->sModVersion,
                            'force_update' => true,
                            'use_quote'    => true,
                        ),
                        'OXSHOPVERSION'  => array(
                            'content'      => oxNew(Facts::class)->getEdition(),
                            'force_update' => true,
                            'use_quote'    => true,
                        ),
                        'OXREQUIREMENTS' => array(
                            'content'      => $this->sRequirements,
                            'force_update' => true,
                            'use_quote'    => true,
                        ),
                        'OXVALUE'        => array(
                            'content'      => $this->sBaseValue,
                            'force_update' => false,
                            'use_quote'    => true,
                        ),
                        'OXNEWREVISION'  => array(
                            'content'      => $this->sModRevision,
                            'force_update' => true,
                            'use_quote'    => true,
                        ),
                    );
                    $aRet          = $this->_updateTableItem2('d3_cfg_mod', $aInsertFields, $aWhere);
                    $blRet         = $aRet['blRet'];
                    $this->setActionLog('SQL', $aRet['sql'], __METHOD__);
                    $this->setUpdateBreak(false);

                    if ($this->getStepByStepMode()) {
                        break;
                    }
                }
            }
        }

        return $blRet;
    }

    /**
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     */
    public function checkModCfgSameRevision()
    {
        return $this->_checkModCfgSameRevision($this->sModKey);
    }

    /**
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function updateModCfgSameRevision()
    {
        $blRet = false;

        if ($this->checkModCfgSameRevision()) {
            $aRet = $this->_updateModCfgSameRevision($this->sModKey);

            $this->setActionLog('SQL', $aRet['sql'], __METHOD__);
            $this->setUpdateBreak(false);
            $blRet = $aRet['blRet'];
        }

        return $blRet;
    }

    /**************************************************************************/
    /*** eigene Prüfmethoden **************************************************/
    /**************************************************************************/
    public $aHtaccessRedirectSearchContent = array(
        'checkHtaccessRedirect'     => array(
            'd3wm'  => "RewriteRule (\.jpe?g|\.gif|\.png)$ modules/d3/watermark/Core/utils/d3_getimg_wm.php",
            'oxid'  => "RewriteRule (\.jpe?g|\.gif|\.png)$ core/utils/getimg.php",
            'd3add' => "
            # D3 Watermark changed:
            RewriteRule (\.jpe?g|\.gif|\.png)$ modules/d3/watermark/Core/utils/d3_getimg_wm.php
            #",
        ),
        'checkHtaccessRedirect_475' => array(
            'd3wm'  => "RewriteRule (\.jpe?g|\.gif|\.png)$ modules/d3/watermark/Core/utils/d3_getimg_wm.php",
            'oxid'  => "RewriteRule (\.jpe?g|\.gif|\.png)$ getimg.php",
            'd3add' => "
            # D3 Watermark changed:
            RewriteRule (\.jpe?g|\.gif|\.png)$ modules/d3/watermark/Core/utils/d3_getimg_wm.php
            #",
        ),
        'checkHtaccessRedirect_483' => array(
            'd3wm'  => "RewriteRule (\.jpe?g|\.gif|\.png|\.svg)$ modules/d3/watermark/Core/utils/d3_getimg_wm.php",
            'oxid'  => "RewriteRule (\.jpe?g|\.gif|\.png|\.svg)$ getimg.php",
            'd3add' => "
            # D3 Watermark changed:
            RewriteRule (\.jpe?g|\.gif|\.png|\.svg)$ modules/d3/watermark/Core/utils/d3_getimg_wm.php
            #",
        ),
    );

    /**
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function checkHtaccessRedirect()
    {
        $sFilePath = '../.htaccess';

        foreach ($this->aHtaccessRedirectSearchContent as $aSearchContentPair) {
            if (false == $this->_checkFileHasContent($sFilePath, $aSearchContentPair['d3wm']) //
                && $this->_checkFileHasContent($sFilePath, $aSearchContentPair['oxid'])
            ) {
                return true;
            };
        }

        return false;
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
    public function updateHtaccessRedirect()
    {
        $blRet     = true;
        $sFilePath = '../.htaccess';

        /** @var $oFS d3filesystem */
        $oFS             = oxNew(d3filesystem::class);
        $blReturnContent = true;

        foreach ($this->aHtaccessRedirectSearchContent as $aSearchContentPair) {
            if (false == $this->_checkFileHasContent($sFilePath, $aSearchContentPair['d3wm']) //
                && $this->_checkFileHasContent($sFilePath, $aSearchContentPair['oxid'])
            ) {
                $sNewContent = $oFS->addContent($sFilePath, $aSearchContentPair['d3add'], 'before', $aSearchContentPair['oxid'], $blReturnContent);

                if ($this->hasExecute()) {
                    $blReturnContent = false; // save changes
                    $blRet           = $oFS->addContent($sFilePath, $aSearchContentPair['d3add'], 'before', $aSearchContentPair['oxid'], $blReturnContent);
                }

                $this->setActionLog(array('fileContent', $sFilePath), $sNewContent, __METHOD__);
            };
        }

        return $blRet;
    }

    /**
     * @return bool
     */
    public function hasToshowChangedHtaccessMessage()
    {
        return false == Registry::getConfig()->getConfigParam( 'd3watermark_htaccesschanged');
    }

    /**
     * @return bool
     */
    public function showChangedHtaccessMessage()
    {
        return $this->showConfigConfirmMessage('d3watermark_htaccesschanged', 'D3_WATERMARK_CHANGED_HTACCESS');
    }
}
