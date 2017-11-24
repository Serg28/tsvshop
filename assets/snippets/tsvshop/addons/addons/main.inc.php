<?php
if(IN_MANAGER_MODE!="true") die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODx Content Manager instead of accessing this file directly.");
$output.= '<div class="tab-page" id="ShopSales">';
$output.= '<h2 class="tab">'.$shop_lang['addons_title'].'</h2>';
$output.= '<p><img src="'.TSVSHOP_SURL.'addons/addons/img/addons.png" alt="'.$shop_lang['sales_title'].'" class="icon" style="vertical-align: middle; text-align: left; " />'.$shop_lang['addons_intro'];
$path = $siteURL.MGR_DIR."/index.php";

$output.= $anotice;
$addonstable=parseaddons($addonspath,TSVSHOP_PATH.'addons/addons/tpl/addonstable.tpl', $shop_lang);

$output.= '
<form action="index.php" id="check_addons" method="get" >
<input type="hidden" name="act" value="check_addons">
<input type="hidden" id="id" name="id" value="' . $moduleid . '" />
<input type="hidden" id="a" name="a" value="' . $modulea . '" />
<table class="grid_table">
    <tr>
     <td style="height:34px;" >
	<div class="header_tables" style="margin-bottom:0"><div class="header_cont"><b>'.$shop_lang['addons_ttitle'].'</b></div></div>
     </td>
   </tr>
   <tr>
        <td>
<table id="addonstable" class="TF" cellpadding="0" cellspacing="0" width="100%">
<thead>
<tr>
	<th width="5"><input type="checkbox" name="checked" onclick="checkedAll(this.checked,\'check_addons\'); void(0);" /></th>
	<th width="5%"><b>№</b></th>
	<th align="left"><b>'.$shop_lang['addons_name'].'</b></th>
        <th align="left"><b>'.$shop_lang['addons_desc_name'].'</b></th>
        <th align="left" width="5%"><b>'.$shop_lang['addons_status'].'</b></th>
        <th align="left" width="5%"></th>

</tr>
</thead>
<tbody>
'.$addonstable.'
</tbody>
</table>
</td>
    </tr>
    <tr>
    <td><div id="addonstoolbar"></div>  </td>
    </tr>
</table>

</form>
';

$output.= '
<script src="'.TSVSHOP_SURL.'addons/addons/js/script.js" language="javascript" type="text/javascript"></script>
';

//$output.= '</div></div>';
$output.= '</div>';
?>