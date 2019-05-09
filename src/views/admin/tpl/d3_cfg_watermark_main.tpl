[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

<script type="text/javascript">
<!--
function showFormatSettings(selectBox)
{
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    className = 'showpos';
    if(selectedValue === 'fit') {
        className = 'hidepos'
    }

    document.getElementById('settings_transparency').className = className;
}

function deleteGeneratedPictures(sMessage)
{
    var blCheck = confirm(sMessage);
    if(blCheck === true)
    {
        var oFormular = document.getElementById("myedit");
        if (oFormular.fnc.value === 'save') {
            setDeletePictureMethod();
        }
        oFormular.submit();
    }
}

function setDeletePictureMethod(type='All')
{
    var oFormular = document.getElementById("myedit");
    oFormular.fnc.value='d3deleteAllGenerated' + type + 'Pictures';
}

function closePopup() {
    document.getElementById("mask").className = "";
    document.getElementById("popup").className = "";
}
-->
</script>
<style type="text/css">
    <!--
    .hidepos { display: none; }
    /*.showpos { display: inherit; }*/
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

[{if $isNewWatermarkAdded}]
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

        [{include file="d3_cfg_mod_active.tpl"}]
    </div>

    [{if $oView->getValueStatus() == 'error'}]
        <hr>
        <strong>[{oxmultilang ident="D3_CFG_MOD_GENERAL_NOCONFIG_DESC"}]</strong>
        <br><br>
        <span class="d3modcfg_btn fixed icon status_attention">
            <input type="submit" value="[{oxmultilang ident="D3_CFG_MOD_GENERAL_NOCONFIG_BTN"}]" [{$readonly}]>
            <span></span>
        </span>
    [{else}]

        [{d3modcfgcheck modid="d3_watermark"}][{/d3modcfgcheck}]
        [{if false == $mod_d3_watermark}]
            <div class="extension_warning">
                [{oxmultilang ident="D3_WATERMARK_INACTIVE_NOTICE"}]
            </div>
        [{else}]

            [{if $isfailupload}]
                <div class="errorbox">[{oxmultilang ident="D3_WATERMARK_FAILUPLOAD_$isfailupload"}]</div>
            [{/if}]

            <fieldset style="border: 1px solid #646464;">
                <legend>
                    <strong>[{oxmultilang ident="D3_WATERMARK_MAIN_SETTINGS"}]</strong>
                </legend>
                <table border="0" width="98%">
                    <tr>
                        <td width="59%" valign="top">
                            [{oxinputhelp ident="D3_WATERMARK_MAIN_SUPPORTED_PICS_HELP"}]
                            <div class="d3modcfg_btn icon d3color-blue" style="position: relative; margin-right: 5px;">
                                <input id="uploadFile" class="edittext ext_edittext"
                                       name="imagefile" type="file" size="50" maxlength="100000" accept="text/*"
                                       style="position: relative; opacity: 0; filter: alpha(opacity=0); max-width: 280px;"
                                       onchange = "document.getElementById('uploadBtn').innerHTML = this.value;"
                                       [{$readonly}]>
                                <label id="uploadBtn" for="uploadFile" style="position: relative; top: -17px; color: #ffffff;">
                                    [{oxmultilang ident="D3_WATERMARK_MAIN_FILEUPLOAD"}]
                                </label>
                                <i class="fas fa-camera"
                                   style="padding: 4px; position: relative; top: -22px; float: left; font-size: 14px; color: white"></i>
                            </div>

                            <br>
                            <br>

                            <select size="1" onchange="setDeletePictureMethod(this.value)" style="float: left">
                                <option value="All">[{oxmultilang ident="D3_CFG_CLRTMP_GENALLIMGS"}]</option>
                                <option value="Product">[{oxmultilang ident="D3_CFG_CLRTMP_GENIMGS"}]</option>
                                <option value="Category">[{oxmultilang ident="D3_CFG_CLRTMP_GENCATIMGS"}]</option>
                                <option value="Manufacturer">[{oxmultilang ident="D3_CFG_CLRTMP_GENMNFIMGS"}]</option>
                                <option value="Vendor">[{oxmultilang ident="D3_CFG_CLRTMP_GENVNDIMGS"}]</option>
                                <option value="Wrapping">[{oxmultilang ident="D3_CFG_CLRTMP_GENWRPIMGS"}]</option>
                            </select>
                            <div class="d3modcfg_btn fixed icon d3color-orange" style="margin-right: 5px">
                                <button type="button"
                                        class="edittext"
                                        onClick="deleteGeneratedPictures('[{oxmultilang ident="D3_WATERMARK_DELETE_ALLGENPIX_MESSAGE"}]');"
                                        name="delete"
                                        style="text-align: left" [{$readonly}]>
                                    <i class="fas fa-trash" style="font-size: 16px; margin: 2px 0;"></i>
                                    [{oxmultilang ident="D3_WATERMARK_DELETE_ALLGENPIX"}]
                                </button>
                            </div>
                            [{oxinputhelp ident="D3_WATERMARK_DELETE_ALLGENPIX_HELP"}]
                        </td>
                        <td rowspan="2" valign="top">
                            <!-- rechte Seite -->
                            [{if $edit->getEditValue('sWaterMark_FileName')}]
                                [{if $edit->isDemo()}]
                                    <div class="extension_warning">
                                        [{oxmultilang ident="D3_WATERMARK_MAIN_DEMO"}]
                                    </div>
                                [{/if}]
                                <div class="extension_notice">
                                    [{oxmultilang ident="D3_WATERMARK_MAIN_FORMATNOTICE"}]
                                </div>
                            [{/if}]
                        </td>
                    </tr>
                    <tr>
                        <td>
                            [{if $edit->getEditValue('sWaterMark_FileName')}]
                                <br><br>
                                [{oxmultilang ident="D3_WATERMARK_MAIN_PREVIEW"}] [{$edit->getEditValue('sWaterMark_FileName')}]
                                <br>
                                <a href="[{$oView->getWatermarkUrl()}]" target="new">
                                    <img style="border: 1px solid black; margin: 5px" src="[{$oView->getWatermarkIconUrl()}]">
                                </a>
                                <br>
                                <select name="value[d3_cfg_mod__sWaterMark_transparency_type]" [{$readonly}] onChange="showFormatSettings(this)">
                                    <option value="fit" [{if $edit->getEditValue('sWaterMark_transparency_type') == 'fit'}]selected[{/if}]>[{oxmultilang ident="D3_WATERMARK_MAIN_FITTRANSPARENCY"}]</option>
                                    <option value="new" [{if $edit->getEditValue('sWaterMark_transparency_type') == 'new'}]selected[{/if}]>[{oxmultilang ident="D3_WATERMARK_MAIN_NEWTRANSPARENCY"}]</option>
                                </select>
                                <span id="settings_transparency" class="[{if $edit->getValue('sWaterMark_transparency_type') == 'new'}]showpos[{else}]hidepos[{/if}]">
                                    <input type="text" size="7"
                                           name="value[d3_cfg_mod__iWaterMark_transparency_value]"
                                           value="[{if $edit->getEditValue('iWaterMark_transparency_value')}][{$edit->getEditValue('iWaterMark_transparency_value')}][{else}]25[{/if}]"
                                           [{$readonly}]> [{oxinputhelp ident="D3_WATERMARK_MAIN_TRANSPARENCYDESC"}]
                                </span>
                            [{/if}]
                        </td>
                    </tr>
                </table>
            </fieldset>
        [{/if}]
    [{/if}]

    <table>
        <tr>
            <td class="edittext ext_edittext" align="left">
                <br>
                <span class="d3modcfg_btn icon d3color-green">
                    <button type="submit" class="edittext ext_edittext" name="save" [{$readonly}]>
                        [{oxmultilang ident="D3_CFG_MOD_GENERAL_SAVE"}]
                         <i class="fas fa-check-circle"></i>
                    </button>
                </span>
            </td>
        </tr>
    </table>
</form>

[{include file="d3_cfg_mod_inc.tpl"}]
