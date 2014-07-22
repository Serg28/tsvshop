<style>
	@media print {
		H1, 
		#actions,
		.sectionHeader,
		.tab-row,
		#ShopSales>P,
		#ShopSales>UL,
		.gridAltItem .actionButtons #Button0,
		.gridAltItem .actionButtons #Button1,
		.gridAltItem .actionButtons #Button2
			{display:none !important;}
	}
</style>

<table class="grid_table">
    <tr>
     <td style="height:28px;" >
	<div class="header_tables" style="margin-bottom:-4px;"><div class="header_cont"><b>[+sales_more+] &laquo;[+numorder+]&raquo;</b></div></div>
     </td>
   </tr>
   <tr>
        <td>
        
			<form action="javascript:getform('/manager/index.php',document.getElementById('myform'),save_order_ok);" name="myform" id="myform">
			<input type="hidden" id="a" name="a" value="[+modulea+]" />
			<input type="hidden" id="id" name="id" value="[+moduleid+]" />
			<input type="hidden" name="act" value="updateorder" id="act">
			<input type="hidden" name="idorder" value="[+numorder+]" id="idorder">        
    <table cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:20px">

    <tr>
    <td valign="top" width="50%">

		<table class="TF tsvorder" cellpadding="0" cellspacing="0" width="100%">
    		<tr>
		    	<th colspan="2" style="border-right:none">[+sales_cdetail+]</th>
		    </tr>
		    <tr>
		    	<td width="30%" class="gridAltItem">[+sales_numorder+]</td>
		    	<td width="70%" class="gridItem" style="border-right:none">[+numorder+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">[+sales_data+]</td>
		    	<td class="gridItem" style="border-right:none">[+dateorder+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">[+sales_fio+]</td>
		    	<td class="gridItem" style="border-right:none">[+fio+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">[+sales_phone+]</td>
		    	<td class="gridItem" style="border-right:none">[+phone+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">[+sales_email+]</td>
		    	<td class="gridItem" style="border-right:none">[+email+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">[+sales_province+]</td>
		    	<td class="gridItem" style="border-right:none">[+province+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">[+sales_region+]</td>
		    	<td class="gridItem" style="border-right:none">[+region+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">[+sales_city+]</td>
		    	<td class="gridItem" style="border-right:none">[+city+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">[+sales_zip+]</td>
		    	<td class="gridItem" style="border-right:none">[+zip+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem" style="border-bottom:1px solid #D0D0D0">[+sales_adress+]</td>
		    	<td class="gridItem" style="border-bottom:1px solid #D0D0D0; border-right:none">[+adress+]</td>
		    </tr>
		    </table>
		</td>

		<td valign="top" width="50%">

			<table class="TF tsvorder" cellpadding="0" cellspacing="0" width="100%">
        <tr>
		    	<th colspan="2">[+sales_orderdetail+]</th>
		    </tr>
      	<tr>
		    	<td class="gridAltItem">[+sales_comments+]</td>
		    	<td class="gridItem">[+comments+]</td>
		    </tr>
      	<tr>
		    	<td width="30%"  class="gridAltItem">[+sales_shiptype+]</td>
		    	<td width="70%" class="gridItem">[+shiptype+]</td>
		    </tr>
				<tr>
			    <td width="30%"  class="gridAltItem">[+sales_discountnum+]</td>
			    <td width="70%" class="gridItem">[+discountnum+]</td>
			  </tr>
				<tr>
			    <td width="30%"  class="gridAltItem">[+sales_payment+]</td>
			    <td width="70%" class="gridItem">[+payments+]</td>
			  </tr>
		    	<tr>
		    		<td class="gridAltItem">[+sales_status+]</td>
		    		<td class="gridItem" style="padding:2px 7px 3px 7px">[+buildstatus+]</td>
		    	</tr>
			    <tr>
		    		<td class="gridAltItem" valign="top" style="border-bottom:1px solid #D0D0D0">[+sales_notes+]</td>
		    		<td class="gridItem" style="border-bottom:1px solid #D0D0D0"><textarea name="commentadmin" width="100%" rows="9" style="height:74px; width:98%" id="commentadmin">[+commentadmin+]</textarea></td>
		    	</tr>
          <tr>
		    <td class="gridAltItem" valign="top" colspan="2" style="border-bottom:1px solid #D0D0D0">
	            <ul class="actionButtons" style="margin:3px">
					<li id="Button0"><a href="index.php?a=[+modulea+]&id=[+moduleid+]"><img src="media/style[+theme+]/images/icons/stop.png">[+sales_close+]</a></li>
					<li id="Button1"><a href="#" onclick="getform('/manager/index.php',document.getElementById('myform'),save_order_ok);return false"><img src="media/style[+theme+]/images/icons/save.png">[+save+]</a> <span name="myspan" id="myspan"></span></li>
					<li id="Button2"><a href="#" onclick="$('#resourcesPane').show();window.print();return false"><img src="media/style[+theme+]/images/tree/application_pdf.png">[+sales_print+]</a></li>
				</ul>
				<span name="myspan" id="myspan"></span>
            </td>
		    	</tr>
			</table>


		</td>
	</tr>
	</table>
</form>        
        
<table class="TF tsvorder" cellpadding="0" cellspacing="0" width="100%">
			<tr>
      	<th width="1%">№</th>
				<th width="3%">[+sales_id+]</th>
				<th width="20%">[+sales_name+]</th>
				<th width="3%">[+sales_quantity+]</th>
				<th width="3%">[+sales_price+]</th>
			</tr>
<!--repeat-->

      <tr>
      	<td align="center">[+num+]</td>
			  <td align="center">[+articul+] (ID:[+url+])</td>
			  <td>[+name+]</td>
			  <td align="center">[+quantity+]</td>
			  <td align="center">[+price+]</td>
	    </tr>

<!--/repeat-->

      <tr>
				<td colspan="4" align="right" class="gridAltItem">[+sales_subtotal+]</td>
				<td class="gridAltItem">[+subtotal+]</td>
			</tr>

			<tr>
				<td colspan="4" align="right" class="gridAltItem">[+sales_shipping+]</td>
				<td class="gridAltItem">[+shipping+]</td>
			</tr>
			<tr>
				<td colspan="4" align="right" class="gridAltItem">[+sales_tax+]</td>
				<td class="gridAltItem">[+nalog+]</td>
			</tr>
			<tr>
				<td colspan="4" align="right" class="gridAltItem">[+sales_discount+]</td>
				<td class="gridAltItem"> - [+discountsize+] ([+discount+])</td>
			</tr>
			<tr>
				<td colspan="4" align="right" class="gridAltItem" style="border-bottom:1px solid #D0D0D0">[+sales_total+]</td>
				<td class="gridAltItem" style="border-bottom:1px solid #D0D0D0" >[+total+]</td>
			</tr>
      </table>        
        
     
        
        
        

   

</td>
    </tr>
</table> 