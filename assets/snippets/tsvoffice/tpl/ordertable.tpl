<table class="border tsvshop" cellpadding="0" cellspacing="0" width="100%">
<thead>
<tr>
	<th width="5%"><b>№</b></th>
	<th width="20%" align="center"><b>Заказчик</b></th>
	<th width="10%" align="center"><b>Дата заказа</b></th>
	<th width="10%" align="center"><b>Статус</b></th>
  <th width="10%" align="center"><b>К оплате</b></th>
  <th align="center" width="1%"></th>
</tr>
</thead>
<tbody>


<!--repeat-->
<tr [+color+] id="str[+numorder+]">
<td align="center">[+numorder+]</td>
<td>[+fio+]</td>
<td align="center"><nobr>[+dateorder+]</nobr></td>
<td align="center">[+status+]</td>
<td align="center">[+total+]</td>
<td align="center">
<nobr><a href="[+url+]">Подробности</a></nobr></td>
</tr>
<!--/repeat-->

</tbody>
</table>
