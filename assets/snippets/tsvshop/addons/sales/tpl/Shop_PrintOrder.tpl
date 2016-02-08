<!--
/**
 * Shop_PrintOrder
 *
 * Шаблон печати товарного чека/накладной в TSVshop
 *
 * @category	chunk
 * @version 	5.3
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal  @modx_category TSVshop
 * @internal  @installset base, sample
* @author     Telnij Sergey (Serg24) <privat_tel@mail.ru>, http://tsvshop.tsv.org.ua, http://tsvshop.xyz 
 */
 -->
 
<table border="0" cellpadding="2" cellspacing="0" style="width: 100%;">
<tbody>
<tr>
<td align="left">
    <p><medium><b>Магазин такой-то</b><br /><b>Адрес:</b> такой-то &nbsp;<br /><b>Телефон:</b> 000-00-00&nbsp;<b>Сайт:</b> site.com</medium></p>
</td>
<td align="right">Logo</td>
</tr>
</tbody>
</table><br />
 
<table border="0" cellpadding="4" cellspacing="4">
<tbody>
<tr>
<td height="3" style="border: 1pt solid #000000;" align="left"><b>Заказчик:</b></td>
<td height="3" style="border: 1pt solid #000000;" align="left">[+shop.order.fio+]</td>
</tr>
<tr>
<td height="3" style="border: 1pt solid #000000;" align="left"><b>Дата заказа:</b></td>
<td height="3" style="border: 1pt solid #000000;" align="left">[+shop.order.datecreate+]</td>
</tr>
<tr>
<td height="3" style="border: 1pt solid #000000;" align="left"><b>Адрес:</b></td>
<td height="3" style="border: 1pt solid #000000;" align="left">[+shop.order.city+], [+shop.order.adress+]</td>
</tr>    
<tr>
<td height="3" style="border: 1pt solid #000000;" align="left"><b>Телефон:</b></td>
<td height="3" style="border: 1pt solid #000000;" align="left">[+shop.order.phone+]</td>
</tr>
<tr>
<td height="3" style="border: 1pt solid #000000;" align="left"><b>Метод оплаты:</b></td>
<td height="3" style="border: 1pt solid #000000;" align="left">[+shop.order.payments+]</td>
</tr>    
<tr>
<td height="3" style="border: 1pt solid #000000;" align="left"><b>Метод доставки:</b></td>
<td height="3" style="border: 1pt solid #000000;" align="left">[+shop.order.shiptype+]</td>
</tr>    
</tbody>
</table>    
 
<h2><center><b>Товарно-кассовый чек N:</b>&nbsp; [+shop.order.numorder+] от [+shop.order.datecreate+]</center></h2>
 
<table border="0" cellpadding="4" cellspacing="4" width="100%">
<tbody>
<tr bgcolor="#E2E2E2">
<td colspan="2" style="border: 1pt solid #000000; border-right:1;" align="center"><b>№</b></td>
<td colspan="4" style="border: 1pt solid #000000; border-right:1;" align="center"><b>Арт.</b></td>
<td colspan="17" style="border: 1pt solid #000000; border-right:1;" align="center"><b>Наименование товара</b></td>
<td colspan="3" style="border: 1pt solid #000000; border-right:1;" align="center"><b>Кол-во</b></td>
<td colspan="4" style="border: 1pt solid #000000; border-right:1;" align="center"><b>Цена</b></td>
<td colspan="5" style="border: 1pt solid #000000; border-right:1;" align="center"><b>Сумма</b></td>
 
</tr>
<!--table-->
<tr>
<td colspan="2" style="border: 1pt solid #000000; border-right:1;" align="center">[+shop.order.num+]</td>
<td colspan="4" style="border: 1pt solid #000000; border-right:1;" align="center">[+shop.order.id+]</td>
<td colspan="17" style="border: 1pt solid #000000; border-right:1;" align="left">[+shop.order.name+]</td>
<td colspan="3" style="border: 1pt solid #000000; border-right:1;" align="center">[+shop.order.qty+]</td>
<td colspan="4" style="border: 1pt solid #000000; border-right:1;" align="center">[+shop.order.price+] руб.</td>
<td colspan="5" style="border: 1pt solid #000000; border-right:1;" align="center">[+shop.order.summa+] руб.</td>
</tr>
<!--/table-->
<tr>
    <td colspan="30" style="border: 1pt solid #000000; border-right:1; border-top:1;" align="right" bgcolor="#ffffff"><b>Скидка по дисконтной карте или промокоду: </b>&nbsp; [+shop.order.discount+]% </td>
    <td colspan="5" style="border: 1pt solid #000000; border-right:1;" align="center">[+shop.order.discountsize+] руб.</td>
</tr>
<tr>
    <td colspan="30" style="border: 1pt solid #000000; border-right:1; border-top:1;" align="right" bgcolor="#ffffff"><b>Доставка: </b>&nbsp; [+shop.order.shiptype+]</td>
    <td colspan="5" style="border: 1pt solid #000000; border-right:1;" align="center">[+shop.order.shipping+] руб.</td>
</tr>    
<tr bgcolor="#E2E2E2">
    <td bgcolor="#E2E2E2" colspan="30" style="border: 1pt solid #000000; border-right:1; border-top:1;" align="right" bgcolor="#ffffff"><b>Итого к оплате:</b>&nbsp; [+shop.order.total_propis+]</td>
    <td bgcolor="#E2E2E2" colspan="5" style="border: 1pt solid #000000; border-right:1;" align="center"><b>[+shop.order.total+] руб.</b></td>
</tr>
</tbody>
</table>
<b>Количество товара:</b>&nbsp;[+shop.order.count+]&nbsp;шт.<br />
<span size="10" style="font-size: medium;">С внешним видом содержимого заказа ознакомлен(а). Количество проверено. Претензий не имею.</span><br />
<span size="5" style="font-size: medium;">Товар надлежащего качества возвращаем в течение 14 дней с момента покупки при условии сохранения товарного вида и потребительских свойств</span><br /><br />
Дата покупки ____________________&nbsp;
<br />
Подпись покупателя ____________________&nbsp;<br /><br /


