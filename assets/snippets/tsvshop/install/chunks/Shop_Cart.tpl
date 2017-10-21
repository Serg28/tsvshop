/**
 * Shop_Cart
 *
 * Шаблон корзины заказов в TSVshop
 *
 * @category	chunk
 * @version 	5.4.2
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal  @modx_category TSVshop
 * @internal  @installset base, sample
 * @author    Telnij Sergey (Serg24) <privat_tel@mail.ru>, http://tsvshop.tsv.org.ua, http://tsvshop.xyz 
 */


<table class="tsvshop">

<thead>
<tr>
<th>Фото</th>
<th>Наименование товара</th>
<th>Кол-во</th>
<th class="ralign">Цена</th>
<th class="ralign">Итого</th>
<th></th>
</tr>
</thead>
<tbody>

<!--noempty-->
<tr>
<td class="icon"><img src="[+shop.basket.iconpath+]" alt="[+shop.basket.name+]" width="50" /></td>
<td class="name"><a href="[+shop.basket.link+]">[+shop.basket.name+] <i>[+shop.basket.details+]</i></a></td>
<td class="qty">[+shop.basket.qinput+]</td>
<td class="price">[+shop.basket.price+] [+shop.basket.monetary+]</td>
<td class="price">[+shop.basket.summa+] [+shop.basket.monetary+]</td>
<td class="del"><a href="#" title="Удалить" [+shop.basket.delatributs+]><img src="/assets/templates/demoshop/img/del.png" /></a></td>
</tr>
<!--/noempty-->

<!--subtotal-->
<tr class="subtotal">
<td colspan="4"><b>Сумма:</b></td>
<td colspan="1">[+shop.basket.subtotal+] [+shop.basket.monetary+]</td>
<td></td>
</tr>
<!--/subtotal-->
<!--discount-->
<tr class="subtotal">
<td colspan="3"></td>
<td colspan="1">Скидка <b>[+shop.basket.discount+]</b> %</td>
<td colspan="1">- [+shop.basket.discountsize+] [+shop.basket.monetary+]</td>
<td></td>
</tr>
<!--/discount-->
<!--shipping-->
<tr class="subtotal">
<td colspan="4"><b>Доставка:</b></td>
<td colspan="1">[+shop.basket.shipping+] [+shop.basket.monetary+]</td>
<td></td>
</tr>
<!--/shipping-->
<!--tax-->
<tr class="subtotal">
<td colspan="4"><b>Налог:</b></td>
<td colspan="1">[+shop.basket.tax+] [+shop.basket.monetary+]</td>
<td></td>
</tr>
<!--/tax-->
<!--total-->
<tr class="total">
<td colspan="4"><b>Итого:</b></td>
<td colspan="1">[+shop.basket.topay+] [+shop.basket.monetary+]</td>
<td></td>
</tr>
<!--/total-->
</tbody>
</table>

<!--buttons-->
<p>
<a class="button right" href="[+shop.basket.checkurl+]">Оформить заказ</a>
<form class="left" method="GET" id="basketClearLink"><input name="a" value="clear" type="hidden"/><a href="javascript:void(0);" onClick="getId('basketClearLink').submit();" class="button right">Очистить корзину</a></form>&nbsp;&nbsp;
</p>
<!--/buttons-->



