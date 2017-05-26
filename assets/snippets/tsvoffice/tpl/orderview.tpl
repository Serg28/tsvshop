		<table class="border" cellpadding="0" cellspacing="0" width="100%">
    		<tr>
		    	<th colspan="2">Подробности заказа</th>
		    </tr>
		    <tr>
		    	<td width="30%" class="gridAltItem">Номер заказа</td>
		    	<td width="70%" class="gridItem" >[+numorder+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">Дата заказа</td>
		    	<td class="gridItem">[+dateorder+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">Заказчик</td>
		    	<td class="gridItem">[+fio+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">Телефон</td>
		    	<td class="gridItem">[+phone+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">E-mail</td>
		    	<td class="gridItem">[+email+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">Область</td>
		    	<td class="gridItem">[+province+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">Район</td>
		    	<td class="gridItem">[+region+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">Город</td>
		    	<td class="gridItem">[+city+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem">Индекс</td>
		    	<td class="gridItem">[+zip+]</td>
		    </tr>
		    <tr>
		    	<td class="gridAltItem" >Адрес доставки</td>
		    	<td class="gridItem" >[+adress+]</td>
		    </tr>
      	<tr>
		    	<td class="gridAltItem">Комментарии к заказу</td>
		    	<td class="gridItem">[+comments+]</td>
		    </tr>
      	<tr>
		    	<td width="30%"  class="gridAltItem">Тип доставки</td>
		    	<td width="70%" class="gridItem">[+shiptype+]</td>
		    </tr>
				<tr>
			    <td width="30%"  class="gridAltItem">Дисконтная карта</td>
			    <td width="70%" class="gridItem">[+discountnum+]</td>
			  </tr>
				<tr>
			    <td width="30%"  class="gridAltItem">Метод оплаты</td>
			    <td width="70%" class="gridItem">[+payments+]</td>
			  </tr>
		    	<tr>
		    		<td class="gridAltItem">Статус заказа</td>
		    		<td class="gridItem" style="padding:2px 7px 3px 7px">[+status+]</td>
		    	</tr>
			</table>
      
<br />        
<table class="border" cellpadding="0" cellspacing="0" width="100%">
			<tr>
      	<th width="1%">№</th>
				<th width="3%">Артикул</th>
				<th width="20%">Наименование</th>
				<th width="3%">Кол-во</th>
				<th width="3%">Стоимость</th>
			</tr>
<!--repeat-->

      <tr>
      	<td align="center">[+num+]</td>
			  <td align="center">[+url+]</td>
			  <td>[+name+]</td>
			  <td align="center">[+quantity+]</td>
			  <td align="center">[+price+]</td>
	    </tr>

<!--/repeat-->

      <tr>
				<td colspan="4" align="right" class="gridAltItem">Подитог</td>
				<td class="gridAltItem">[+subtotal+]</td>
			</tr>

			<tr>
				<td colspan="4" align="right" class="gridAltItem">Доставка</td>
				<td class="gridAltItem">[+shipping+]</td>
			</tr>
			<tr>
				<td colspan="4" align="right" class="gridAltItem">Налог</td>
				<td class="gridAltItem">[+nalog+]</td>
			</tr>
			<tr>
				<td colspan="4" align="right" class="gridAltItem">Скидка</td>
				<td class="gridAltItem"> - [+discountsize+] ([+discount+])</td>
			</tr>
			<tr>
				<td colspan="4" align="right" class="gridAltItem">К оплате</td>
				<td class="gridAltItem" >[+total+]</td>
			</tr>
      </table>        
