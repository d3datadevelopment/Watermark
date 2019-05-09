[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

<script type="text/javascript">
    <!--
    [{if $updatelist == 1}]
    UpdateList('[{$oxid}]');
    [{/if}]

    function UpdateList( sID)
    {
        var oSearch = parent.list.document.getElementById("search");
        oSearch.oxid.value=sID;
        oSearch.fnc.value='';
        oSearch.submit();
    }

    function EditThis( sID)
    {
        var oTransfer = document.getElementById("transfer");
        oTransfer.oxid.value=sID;
        oTransfer.cl.value='';
        oTransfer.submit();

        var oSearch = parent.list.document.getElementById("search");
        oSearch.actedit.value = 0;
        oSearch.oxid.value=sID;
        oSearch.submit();
    }

    function _groupExp(el) {
        var _cur = el.parentNode;

        if (_cur.className === "exp") _cur.className = "";
        else _cur.className = "exp";
    }

    var sOldSettingElem = '';

    function showFormatSettings(sElemId, className, blUseOldElem)
    {
        if (blUseOldElem && sOldSettingElem) {
            document.getElementById(sOldSettingElem).style.display = 'none';
            sOldSettingElem = sElemId;
        } else if (blUseOldElem) {
            document.getElementById('settings_global').style.display = 'none';
            document.getElementById('settingstxt_global').style.display = 'none';
            sOldSettingElem = sElemId;
        }

        document.getElementById(sElemId).className = className;
    }

    function closePopup() {
        document.getElementById("mask").className = "";
        document.getElementById("popup").className = "";
    }
    -->
</script>

<style type="text/css">
    <!--
    .groupExp .exp .hidepos,
    .groupExp div div
    {
        display: none;
    }

    .groupExp .exp div {
        display: block;
    }

    .groupExp .exp div table th {
        background-color: #787878;
        color : #ffffff;
        font-weight: bold;
        padding: 5px 10px;
        text-align: center;
    }

    .groupExp .exp div table tr:nth-child(even) {
        background-color: #efefef;
    }
    .groupExp .exp div table tr:nth-child(odd) {
        background-color: #ffffff;
    }
    -->
</style>

[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
    <input type="hidden" name="actshop" value="[{$shop->id}]">
    <input type="hidden" name="editlanguage" value="[{$editlanguage}]">
</form>

[{if $hasNewSettings}]
    [{include file="d3_cfg_watermark_clearpictures_popup.tpl"}]
[{/if}]

<form name="myedit" id="myedit" enctype="multipart/form-data" action="[{$oViewConf->getSelfLink()}]" method="post">
    <div>
        <input type="hidden" name="MAX_FILE_SIZE" value="[{$iMaxUploadFileSize}]">
        [{$oViewConf->getHiddenSid()}]
        <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
        <input type="hidden" name="fnc" value="save">
        <input type="hidden" name="oxid" value="[{$oxid}]">
        <input type="hidden" name="editval[d3_cfg_mod__oxid]" value="[{$oxid}]">
    </div>
    <table border="0" width="98%">
        <tr>
            <td valign="top" class="edittext">

                [{if $oView->getValueStatus() == 'error'}]
                    <span style="font-weight: bold;">[{oxmultilang ident="D3_CFG_MOD_GENERAL_NOCONFIG_DESC"}]</span><br>
                    <input type="submit" value="[{oxmultilang ident="D3_CFG_MOD_GENERAL_NOCONFIG_BTN"}]">
                    </form>
                [{else}]
                    [{foreach from=$oView->getImageFormats() item="aImageFormat" key="sGroupname"}]
                        <div class="groupExp">
                            <div class="">
                                <a class="rc" onclick="_groupExp(this); return false;" href="#">
                                    <span style="font-weight: bold;">
                                        [{assign var="sTranslationIdent" value="D3_WATERMARK_FORMAT_"|cat:$sGroupname|upper}]
                                        [{oxmultilang ident=$sTranslationIdent}]
                                    </span>
                                </a>
                                <!-- Einstellungen gruppiert -->
                                <div>
                                    [{assign var="sLineStyle" value="padding: 0 5px;"}]
                                    <table width="100%" style="margin: 5px 0 15px; border: 1px solid #787878">
                                        <tr>
                                            <th style="width: 20%;">[{oxmultilang ident="D3_WATERMARK_MAIN_FORMATACTIVE"}]</th>
                                            <th style="width: 20%;">[{oxmultilang ident="D3_WATERMARK_MAIN_INSERTTYPE"}]</th>
                                            <th>[{oxmultilang ident="D3_WATERMARK_MAIN_INSERTTYPE_DIRECTPOS_SETS"}]</th>
                                        </tr>
                                        [{foreach from=$aImageFormat item="sImageFormat"}]
                                            <tr>
                                                <td valign="top" style="[{$sLineStyle}]">
                                                    [{assign var="sFieldName" value="blWaterMark_"|cat:$sImageFormat|cat:"_active"}]
                                                    <input type="hidden" name="value[[{$sFieldName}]]" value="0">
                                                    <input type="checkbox" name="value[[{$sFieldName}]]" value="1" [{if $edit->getEditValue($sFieldName) == 1}]checked[{/if}]>

                                                    [{assign var="sTranslationIdent" value="D3_WATERMARK_FORMAT_"|cat:$sImageFormat|upper}]
                                                    [{oxmultilang ident=$sTranslationIdent}]
                                                </td>
                                                <td valign="top" style="[{$sLineStyle}]">
                                                    [{assign var="sFieldName" value="sWaterMark_"|cat:$sImageFormat|cat:"_inserttype"}]
                                                    <select name="value[[{$sFieldName}]]">
                                                        <option value="fullsize" onclick="showFormatSettings('settings_[{$sImageFormat}]_positioning', 'hidepos', false);" [{if $edit->getEditValue($sFieldName) == 'fullsize'}]selected[{/if}]>[{oxmultilang ident="D3_WATERMARK_MAIN_INSERTTYPE_FULLSIZE"}]</option>
                                                        <option value="fitvertical" onclick="showFormatSettings('settings_[{$sImageFormat}]_positioning', 'hidepos', false);" [{if $edit->getEditValue($sFieldName) == 'fitvertical'}]selected[{/if}]>[{oxmultilang ident="D3_WATERMARK_MAIN_INSERTTYPE_FITVERTICAL"}]</option>
                                                        <option value="fithorizontal" onclick="showFormatSettings('settings_[{$sImageFormat}]_positioning', 'hidepos', false);" [{if $edit->getEditValue($sFieldName) == 'fithorizontal'}]selected[{/if}]>[{oxmultilang ident="D3_WATERMARK_MAIN_INSERTTYPE_FITHORIZONTAL"}]</option>
                                                        <option value="directpos" onclick="showFormatSettings('settings_[{$sImageFormat}]_positioning', 'showpos', false);" [{if $edit->getEditValue($sFieldName) == 'directpos'}]selected[{/if}]>[{oxmultilang ident="D3_WATERMARK_MAIN_INSERTTYPE_DIRECTPOS"}]</option>
                                                    </select>
                                                </td>
                                                <td style="[{$sLineStyle}]">
                                                    <div id="settings_[{$sImageFormat}]_positioning" class="[{if $edit->getEditValue($sFieldName) == 'directpos'}]showpos[{else}]hidepos[{/if}]">
                                                        [{assign var="sPosFieldName" value="sWaterMark_"|cat:$sImageFormat|cat:"_insertpos"}]
                                                        <select name="value[[{$sPosFieldName}]]">
                                                            <option value="center" [{if $edit->getEditValue($sPosFieldName) == 'center'}]selected[{/if}]>[{oxmultilang ident="D3_WATERMARK_MAIN_INSERTPOS_CENTER"}]</option>
                                                            <option value="top" [{if $edit->getEditValue($sPosFieldName) == 'top'}]selected[{/if}]>[{oxmultilang ident="D3_WATERMARK_MAIN_INSERTPOS_TOP"}]</option>
                                                            <option value="topright" [{if $edit->getEditValue($sPosFieldName) == 'topright'}]selected[{/if}]>[{oxmultilang ident="D3_WATERMARK_MAIN_INSERTPOS_TOPRIGHT"}]</option>
                                                            <option value="right" [{if $edit->getEditValue($sPosFieldName) == 'right'}]selected[{/if}]>[{oxmultilang ident="D3_WATERMARK_MAIN_INSERTPOS_RIGHT"}]</option>
                                                            <option value="bottomright" [{if $edit->getEditValue($sPosFieldName) == 'bottomright'}]selected[{/if}]>[{oxmultilang ident="D3_WATERMARK_MAIN_INSERTPOS_BOTTOMRIGHT"}]</option>
                                                            <option value="bottom" [{if $edit->getEditValue($sPosFieldName) == 'bottom'}]selected[{/if}]>[{oxmultilang ident="D3_WATERMARK_MAIN_INSERTPOS_BOTTOM"}]</option>
                                                            <option value="bottomleft" [{if $edit->getEditValue($sPosFieldName) == 'bottomleft'}]selected[{/if}]>[{oxmultilang ident="D3_WATERMARK_MAIN_INSERTPOS_BOTTOMLEFT"}]</option>
                                                            <option value="left" [{if $edit->getEditValue($sPosFieldName) == 'left'}]selected[{/if}]>[{oxmultilang ident="D3_WATERMARK_MAIN_INSERTPOS_LEFT"}]</option>
                                                            <option value="topleft" [{if $edit->getEditValue($sPosFieldName) == 'topleft'}]selected[{/if}]>[{oxmultilang ident="D3_WATERMARK_MAIN_INSERTPOS_TOPLEFT"}]</option>
                                                        </select>

                                                        [{assign var="sFieldName" value="sWaterMark_"|cat:$sImageFormat|cat:"_width"}]
                                                        [{oxmultilang ident="D3_WATERMARK_MAIN_INSERT_WIDTH"}] <input type="text" name="value[[{$sFieldName}]]" value="[{if $edit->getEditValue($sFieldName)}][{$edit->getEditValue($sFieldName)}][{else}]100[{/if}]" width="30"> px
                                                    </div>
                                                </td>
                                            </tr>
                                        [{/foreach}]
                                    </table>
                                </div>
                            </div>
                        </div>
                    [{/foreach}]
                [{/if}]

                <table style="width: 100%">
                    <tr>
                        <td class="edittext ext_edittext" style="text-align: left"><br>
                            <span class="d3modcfg_btn icon d3color-green">
                                <button type="submit" class="edittext ext_edittext" name="save" [{$readonly}]>
                                    [{oxmultilang ident="D3_CFG_MOD_GENERAL_SAVE"}]
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>

[{include file="d3_cfg_mod_inc.tpl"}]
