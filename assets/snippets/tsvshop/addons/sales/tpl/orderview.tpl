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
  #myform input:disabled {background: #f0f0f0; color:#999}
</style>

<table class="grid_table">
    <tr>
     <td style="height:34px;" >
	<div class="header_tables" style="margin-bottom:0px;"><div class="header_cont"><b>[+sales_more+] &laquo;[+numorder+]&raquo;</b></div></div>
     </td>
   </tr>
   <tr>
        <td>
        
			<form action="javascript:getform('/[+mgrdir+]/index.php',document.getElementById('myform'),save_order_ok);" name="myform" id="myform">
			<input type="hidden" id="a" name="a" value="[+modulea+]" />
			<input type="hidden" id="id" name="id" value="[+moduleid+]" />
			<input type="hidden" name="act" value="updateorder" id="act">
			<input type="hidden" name="idorder" value="[+numorder+]" id="idorder">        
    <table cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:20px">

    <tr>
    <td valign="top" width="50%" style="padding:0;vertical-align:top">

		<table class="TF tsvorder" cellpadding="0" cellspacing="0" width="100%">
    		<tr>
		    	<th colspan="2" style="border-right:none">[+sales_cdetail+]</th>
		    </tr>
		    <tr>
		    	<td width="30%" class="gridAltItem">[+sales_numorder+]</td>
		    	<td width="70%" class="gridItem" style="border-right:none; height:28px">[+numorder+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">[+sales_data+]</td>
		    	<td class="gridItem" style="border-right:none; height:28px">[+dateorder+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">[+sales_fio+]</td>
		    	<td class="gridItem" style="border-right:none; "><input type="text" name="fio" value="[+fio+]"></td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">[+sales_phone+]</td>
		    	<td class="gridItem" style="border-right:none; "><input type="text" name="phone" value="[+phone+]"></td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">[+sales_email+]</td>
		    	<td class="gridItem" style="border-right:none; "><input type="text" name="email" value="[+email+]"></td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">[+sales_province+]</td>
		    	<td class="gridItem" style="border-right:none; "><input type="text" name="province" value="[+province+]"></td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">[+sales_region+]</td>
		    	<td class="gridItem" style="border-right:none; "><input type="text" name="region" value="[+region+]"></td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">[+sales_city+]</td>
		    	<td class="gridItem" style="border-right:none; "><input type="text" name="city" value="[+city+]"></td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem" style="border-bottom:1px solid #D0D0D0">[+sales_zip+]</td>
		    	<td class="gridItem" style="border-bottom:1px solid #D0D0D0; border-right:none; "><input type="text" name="zip" value="[+zip+]"></td>
		    </tr>
		    
		    </table>
		</td>

		<td valign="top" width="50%" style="padding:0;vertical-align:top">
                    

			<table class="TF tsvorder" cellpadding="0" cellspacing="0" width="100%">
                            
        <tr>
		    	<th colspan="2">[+sales_orderdetail+]</th>
		    </tr>
                    <tr>
		    	<td class="gridAltItem" >[+sales_adress+]</td>
		    	<td class="gridItem" ><input type="text" name="adress" value="[+adress+]"></td>
		    </tr>
      	<tr>
		    	<td class="gridAltItem">[+sales_comments+]</td>
		    	<td class="gridItem"><input type="text" name="comments" value="[+comments+]"></td>
		    </tr>
      	<tr>
		    	<td width="30%"  class="gridAltItem">[+sales_shiptype+]</td>
		    	<td width="70%" class="gridItem"><input type="text" name="shiptype" value="[+shiptype+]"></td>
		    </tr>
				<tr>
			    <td width="30%"  class="gridAltItem">[+sales_discountnum+]</td>
			    <td width="70%" class="gridItem"><input type="text" name="discountnum" value="[+discountnum+]"></td>
			  </tr>
				<tr>
			    <td width="30%"  class="gridAltItem">[+sales_payment+]</td>
			    <td width="70%" class="gridItem"><input type="text" name="payments" value="[+payments+]"></td>
			  </tr>
		    	<tr>
		    		<td class="gridAltItem">[+sales_status+]</td>
		    		<td class="gridItem">[+buildstatus+]</td>
		    	</tr>
			    <tr>
		    		<td class="gridAltItem" valign="top" style="border-bottom:1px solid #D0D0D0">[+sales_notes+]</td>
		    		<td class="gridItem" style="border-bottom:1px solid #D0D0D0; "><textarea name="commentadmin" width="100%" rows="12" style="height:98px; width:98%" id="commentadmin">[+commentadmin+]</textarea></td>
		    	</tr>
         <!-- <tr>
		    <td class="gridAltItem" valign="top" colspan="2" style="border-bottom:1px solid #D0D0D0; padding-bottom:0">
	            <ul class="actionButtons" style="margin-bottom:-13px">
					<li id="Button0"><a href="/[+mgrdir+]/index.php?a=[+modulea+]&id=[+moduleid+]"><img src="media/style[+theme+]/images/icons/stop.png">[+sales_close+]</a></li>
					<li id="Button1"><a href="#" onclick="getform('/[+mgrdir+]/index.php',document.getElementById('myform'),save_order_ok);return false"><img src="media/style[+theme+]/images/icons/save.png">[+save+]</a> <span name="myspan" id="myspan"></span></li>
					<li id="Button2"><a href="#" onclick="$('#resourcesPane').show();window.print();return false"><img src="media/style[+theme+]/images/tree/application_pdf.png">[+sales_print+]</a></li>
          <li id="Button2"><a href="/[+mgrdir+]/index.php?a=[+modulea+]&id=[+moduleid+]&act=printorder&i=[+numorder+]:[+code+]" target="_blank"><img src="/assets/snippets/tsvshop/addons/sales/img/printer.png">[+sales_printorder+]</a></li>
				</ul>
				<span name="myspan" id="myspan"></span>
            </td>
		    	</tr>-->
			</table>


		</td>
	</tr>
        <tr>
            <td colspan="2" style="background:#f1f2f4;padding:5px;border: 1px solid #d0d0d0; border-top: 0">
               <ul class="actionButtons" style="margin-bottom:-13px">
					<li id="Button0"><a href="/[+mgrdir+]/index.php?a=[+modulea+]&id=[+moduleid+]"><img src="media/style[+theme+]/images/icons/stop.png">[+sales_close+]</a></li>
					<li id="Button1"><a href="#" onclick="getform('/[+mgrdir+]/index.php',document.getElementById('myform'),save_order_ok);return false"><img src="media/style[+theme+]/images/icons/save.png">[+save+]</a> <span name="myspan" id="myspan"></span></li>
					<li id="Button2"><a href="#" onclick="$('#resourcesPane').show();window.print();return false"><img src="media/style[+theme+]/images/tree/application_pdf.png">[+sales_print+]</a></li>
          <li id="Button2"><a href="/[+mgrdir+]/index.php?a=[+modulea+]&id=[+moduleid+]&act=printorder&i=[+numorder+]:[+code+]" target="_blank"><img src="/assets/snippets/tsvshop/addons/sales/img/printer.png">[+sales_printorder+]</a></li>
				</ul>
				<span name="myspan" id="myspan"></span> 
                
            </td>
        </tr>
	</table>
       
        
<table class="TF tsvorder" cellpadding="0" cellspacing="0" width="100%">
			<tr>
      	<th width="5%">№</th>
				<th width="10%">[+sales_id+]</th>
				<th width="55%">[+sales_name+]</th>
				<th width="10%">[+sales_quantity+]</th>
				<th width="10%">[+sales_price+]</th>
        <th width="10%">[+sales_summa+]</th>
			</tr>
<!--repeat-->

      <tr>
      	<td align="center">[+num+]</td>
			  <td align="center">[+articul+] (ID:[+url+])</td>
			  <td>[+name+]</td>
			  <td align="center"><input type="text" name="item[[+id+]][quantity]" value="[+quantity+]" style="width:80%;"></td>
			  <td align="center" style=" "><input type="text" name="item[[+id+]][price]" value="[+price+]" style="width:80%;" ></td>
        <td align="center"><input type="text" name="none" disabled value="[+summa+]" style="width:80%;"></td>
	    </tr>

<!--/repeat-->

      <tr>
				<td colspan="5" align="left" class="gridAltItem">[+sales_subtotal+]</td>
				<td class="gridAltItem" align="center"><input type="text" name="subtotal" disabled value="[+subtotal+]" style="width:80%;"></td>
			</tr>

			<tr>
				<td colspan="5" align="left" class="gridAltItem">[+sales_shipping+]</td>
				<td class="gridAltItem" align="center"><input type="text" name="shipping" value="[+shipping+]" style="width:80%;"></td>
			</tr>
			<tr>
				<td colspan="5" align="left" class="gridAltItem">[+sales_tax+]</td>
				<td class="gridAltItem" align="center"><input type="text" name="nalog" value="[+nalog+]" style="width:80%;"></td>
			</tr>
			<tr>
				<td colspan="5" align="left" class="gridAltItem"; ><div style="margin-top:8px; float:left">[+sales_discount+]</div> <span style="float:right"><input type="text" name="discount" value="[+discount+]" style="width:80%;">%</span></td>
				<td class="gridAltItem" align="center"> <input type="text" name="discountsize" disabled value="[+discountsize+]" style="width:80%;"></td>
			</tr>
			<tr>
				<td colspan="5" align="left" class="gridAltItem" style="border-bottom:1px solid #D0D0D0">[+sales_total+]</td>
				<td class="gridAltItem" style="border-bottom:1px solid #D0D0D0" align="center"><input type="text" name="total" disabled value="[+total+]" style="width:80%;"></td>
			</tr>
      </table>        
</form>         
     
        
        
        

   

</td>
    </tr>
</table> 