/**
 * Shop_mail_klient
 *
 * Шаблон письма-подтверждения заказа клиенту в TSVshop
 *
 * @category	chunk
 * @version 	5.3
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal  @modx_category TSVshop
 * @internal  @installset base, sample
 * @author    Telnij Sergey (Serg24) <privat_tel@mail.ru>, http://tsvshop.tsv.org.ua, http://tsvshop.xyz 
 */


Здравствуйте, [+shop.mail.fio+]<br />
Ваш заказ был успешно сформирован и отправлен. В самое ближайшее время менеджер свяжется с Вами.<br /><br />
Внимание! Если Вы будете звонить менеджеру по поводу этого заказа, указывайте, пожалуйста, номер этого заказа: - <b>[+shop.mail.numorder+]</b><br /><br />

-------- <br />
Ваш заказ:
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

