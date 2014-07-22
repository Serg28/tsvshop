[+validationmessage+]
<fieldset style="background:#E8E9EA">
<form method="post" action="[~[*id*]~]">
<input type="hidden" name="formid" value="TSVCheckoutForm" />
<p><b>Для завершения укажите некоторые данные:</b></p>
<table>
<tr>
<td width="150">Контактное лицо / Предприятие: </td>
<td width="1%">*</td>
<td><input type="text" name="fio" id="b_first" maxlength="75" size="37" class="text" value="[+shop.basket.fullname+]" eform="Контактное лицо / Предприятие:string:1" /></td>
</tr>
<tr>
<td>Город: </td>
<td width="1%"> </td>
<td><input type="text" name="city" id="b_city" maxlength="50" size="37" class="text" value="" /></td>
</tr>
<tr>
<td>Адрес доставки: </td>
<td width="1%">*</td>
<td><input type="text" name="adress" id="b_addr" maxlength="75" size="37" class="text" value="" eform="Адрес доставки:string:1" /></td>
</tr>
<tr>
<td>Телефон для связи: </td>
<td width="1%">*</td>
<td><input type="text" name="phone" id="b_phone" maxlength="50" size="37" class="text" value="[+shop.basket.phone+]" eform="Телефон для связи::1" /></td>
</tr>
<tr>
<td>E-mail</td>
<td width="1%">*</td>
<td><input type="text" name="email" id="b_email" maxlength="30" size="37" class="text" value="[+shop.basket.email+]" eform="E-mail:email:1"/></td>
</tr>
<tr>
<td valign="top">Метод оплаты: </td>
<td width="1%"> </td>
<td>[+shop.basket.fpayments+]</td>
</tr>
<tr>
<td valign="top">Дисконтная карта: </td>
<td width="1%"> </td>
<td>[+shop.basket.fdiscount+]</td>
</tr>
<tr>
<td valign="top">Метод доставки: </td>
<td width="1%"> </td>
<td>[+shop.basket.fshipping+]</td>
</tr>

<tr>
<td valign="top">Комментарии: </td>
<td width="1%"> </td>
<td><textarea id="comment" name="comments" rows="6" cols="36"></textarea></td>
</tr>

<tr>
<td></td>
<td width="1%"> </td>
<td><input type="submit" value="Подтвердить заказ" /></td>
</tr></table>
</form>
</fieldset>
