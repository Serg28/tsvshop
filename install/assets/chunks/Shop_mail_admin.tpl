/**
 * Shop_mail_admin
 *
 * Шаблон письма о заказе администратору в TSVshop
 *
 * @category	chunk
 * @version 	5.3
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal  @modx_category TSVshop
 * @internal  @installset base, sample
 * @author    Telnij Sergey (Serg24) <privat_tel@mail.ru>, http://tsvshop.tsv.org.ua, http://tsvshop.xyz 
 */


Был получен новый заказ. Подробности этого заказа предоставлены ниже.<br /><br />

Дата заказа: [+shop.mail.dateorder+]<br />
Номер счета: <b>[+shop.mail.numorder+]</b><br />
<br />
-------- <br />
Данные заказчика: <br />
Полное наименование организации: [+shop.mail.fio+] <br />
Город: [+shop.mail.city+] <br />
Тип доставки: [+shop.mail.shiptype+] <br />
Дисконт: Карта [+shop.mail.discountcard+] ([+shop.mail.discount+]%) <br />
Адрес доставки: [+shop.mail.adress+] <br />
Телефон для связи: [+shop.mail.phone+] <br />
E-mail: [+shop.mail.email+] <br />

-------- <br />
 <br />
 <br />
-------- <br />
Комментарии к заказу: <br />
[+shop.mail.comments+]<br />
--------- <br />

<table border="1" width="100%"><tr><th>Артикул</th><th>Название товара</th><th>Кол-во</th><th>Цена</th></tr>
<!--table-->
<tr><td>[+shop.mail.articul+]</td><td>[+shop.mail.name+]</td><td>[+shop.mail.quantity+]</td><td>[+shop.mail.price+] [+shop.mail.monetary+]</td></tr>
<!--/table-->
<tr><td colspan="3">ПОДИТОГ:</td><td colspan="1">[+shop.mail.subtotal+] [+shop.mail.monetary+]</td></tr>
<tr><td colspan="3">ОТГРУЗКА:</td><td colspan="1">[+shop.mail.shipping+] [+shop.mail.monetary+]</td></tr>
<tr><td colspan="3">СКИДКА:</td><td colspan="1">[+shop.mail.discount+] [+shop.mail.monetary+]</td></tr>
<tr><td colspan="3">ВСЕГО:</td><td colspan="1">[+shop.mail.total+] [+shop.mail.monetary+]</td></tr>
</table>
<br />


