<script type="text/javascript">
    <!--
    function deleteGeneratedPictures(sMessage)
    {
        var blCheck = confirm(sMessage);
        if(blCheck === true)
        {
            var oFormular = document.getElementById("myedit");
            if (oFormular.fnc.value === '') {
                setDeletePictureMethod();
            }
            oFormular.submit();
        }
    }

    function setDeletePictureMethod(type='All')
    {
        var oInput = document.getElementById("d3FormClrFnc");
        oInput.value='d3deleteAllGenerated' + type + 'Pictures';
    }
    -->
</script>

<div id="mask" class="on"></div>
<div id="popup" class="on" style="margin: 0; width: 410px; top: 20%; left: 25%; padding: 10px 20px 20px; height: auto; ">
    <i class="fa fa-times fa-pull-right"
       style="display: block;width: 10px;text-align: right;margin: 0 0 10px; cursor: pointer;"
       onclick="closePopup();"></i>

    <i class="fa fa-exclamation fa-4x fa-pull-left"></i>
    <form name="myedit" id="deleteGenPix" action="[{$oViewConf->getSelfLink()}]" method="post">
        <div>
            [{$oViewConf->getHiddenSid()}]
            <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
            <input type="hidden" id="d3FormClrFnc" name="fnc" value="">
            <input type="hidden" name="oxid" value="[{$oxid}]">
            <input type="hidden" name="editval[d3_cfg_mod__oxid]" value="[{$oxid}]">

        </div>
        [{oxmultilang ident=$sNewSettingsMessage}]
        <br><br>
        [{oxmultilang ident="D3_WATERMARK_CLEAR_GENERATED_PICTURES"}]
        <br><br>

        <select size="1" onchange="setDeletePictureMethod(this.value)" style="float: left">
            <option value="All">[{oxmultilang ident="D3_CFG_CLRTMP_GENALLIMGS"}]</option>
            <option value="Product">[{oxmultilang ident="D3_CFG_CLRTMP_GENIMGS"}]</option>
            <option value="Category">[{oxmultilang ident="D3_CFG_CLRTMP_GENCATIMGS"}]</option>
            <option value="Manufacturer">[{oxmultilang ident="D3_CFG_CLRTMP_GENMNFIMGS"}]</option>
            <option value="Vendor">[{oxmultilang ident="D3_CFG_CLRTMP_GENVNDIMGS"}]</option>
            <option value="Wrapping">[{oxmultilang ident="D3_CFG_CLRTMP_GENWRPIMGS"}]</option>
        </select>
        <div class="d3modcfg_btn fixed icon d3color-orange">
            <button type="submit" name="save" onClick="document.getElementById('d3FormClrFnc').value = 'd3deleteAllGeneratedAllPictures';" [{$readonly}]>
                <i class="fas fa-trash"></i>
                [{oxmultilang ident="D3_WATERMARK_DELETE_ALLGENPIX"}]
            </button>
        </div>
    </form>
    <div class="d3modcfg_btn fixed icon d3color-green" style="margin: 15px 0 0 0; float: right; height: 23px;">
        <button type="button" name="close"
                onclick="closePopup();">
             <i class="fas fa-times"></i>
            [{oxmultilang ident="D3_WATERMARK_BUTTON_NOT_YET"}]
        </button>
    </div>
</div>
