<form action="[+url+]" id="check_del" method="get" >
<input type="hidden" name="act" value="delchecked">
<input type="hidden" id="id" name="id" value="[+moduleid+]" />
<input type="hidden" id="a" name="a" value="[+modulea+]" />
<table class="grid_table">
    <tr>
     <td style="height:34px;" >
	<div class="header_tables" style="margin-bottom:0px"><div class="header_cont"><b>[+sales_ttitle+]</b></div></div>
     </td>
   </tr>
   <tr>
        <td>
    
<table id="saletable" class="TF" cellpadding="0" cellspacing="0" width="100%">
<thead>
<tr>
	<th width="50"><input type="checkbox" name="checked" onclick="checkedAll(this.checked,'check_del'); void(0);" /></th>
	<th width="5%"><b>№</b></th>
	<th  align="left"><b>[+sales_fio+]</b></th>
	<th align="left"><b>[+sales_notes+]</b></th>

	<th width="12%" align="center"><b>[+sales_data+]</b></th>
	<th width="10%" align="center"><b>[+sales_status+]</b></th>
        <th width="16%" align="right"><nobr><b>[+sales_total+]</b></nobr></th>
        <th align="left" width="10%"></th>

</tr>
</thead>
<tbody>


<!--repeat-->
<tr [+color+] id="str[+numorder+]">
<td><input type="checkbox" name="check[+numorder+]" value="[+numorder+]" /></td>
<td align="center">[+numorder+]</td>
<td>[+fio+]</td>
<td>[+commentadmin+]</td>

<td align="center"><nobr>[+dateorder+]</nobr></td>
<td align="center">[+statussel+]</td>
<td align="right">[+total+]</td>
<td align="right">
<nobr><a href="/[+mgrdir+]/index.php?a=112&id=[+moduleid+]&act=vieworder&idorder=[+numorder+]"><img src="/assets/snippets/tsvshop/addons/sales/img/basket_edit.png" alt="" border="0"  style="margin-top:1px;margin-bottom:-2px"></a>
<a href="javascript:void(0);" onclick="if (confirm('Удалить заказ [+numorder+]?','Подтвердите удаление:')) document.location='/[+mgrdir+]/index.php?a=112&id=[+moduleid+]&act=delorder&idorder=[+numorder+]'; return false;"><img src="/assets/snippets/tsvshop/addons/sales/img/basket_delete.png" alt="" border="0"  style="margin-top:1px;margin-left:4px;margin-bottom:-2px"></a>
<a href="/[+mgrdir+]/index.php?a=112&id=[+moduleid+]&act=printorder&i=[+numorder+]:[+code+]" title="[+shop_printorder+]" target="_blank"><img src="/assets/snippets/tsvshop/addons/sales/img/printer.png" alt="[+shop_printorder+]" alt="" border="0"  style="margin-top:0px;margin-left:4px;margin-bottom:-2px" /></a>
</nobr></td>
</tr>
<!--/repeat-->

</tbody>
</table>
</td>
    </tr>
    <tr>
    <td><div id="saletoolbar"></div>  </td>
    </tr>
</table>

</form>
<div id="vieworder"></div>