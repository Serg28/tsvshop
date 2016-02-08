<table class="border tsvshop">
	<thead>
		<tr>
			<th width="5%"><b>№</b></th>
			<th width="20%"><b>Заказчик</b></th>
			<th width="10%"><b>Дата заказа</b></th>
			<th width="10%"><b>Статус</b></th>
			<th width="10%"><b>К оплате</b></th>
			<th width="1%"></th>
			<th width="1%"></th>
		</tr>
	</thead>
	<tbody>

		<!--repeat-->
		<tr [+color+] id="str[+numorder+]">
			<td>[+numorder+]</td>
			<td>[+fio+]</td>
			<td><nobr>[+dateorder+]</nobr></td>
			<td>[+status+]</td>
			<td>[+total+]</td>
			<td><nobr><a href="[+url+]">Подробнее</a></nobr></td>
			<td>[+button.delete+]</td>
		</tr>
		<!--/repeat-->
		<!--repeat_links-->
		<tr  [+color+] id="substr[+numorder+]">
			<td></td>
			<td>[+filename+]</td>
			<td colspan="4">[+links+]</td>
			<td></td>
		</tr>
		<!--/repeat_links-->
	</tbody>
</table>
