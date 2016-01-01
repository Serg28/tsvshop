/**
 * product
 *
 * Шаблон для вывода товара с помощью Ditto в TSVshop
 *
 * @category	chunk
 * @version 	5.3
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal  @modx_category TSVshop
 * @internal  @installset base, sample
 * @author    Telnij Sergey (Serg24) <privat_tel@mail.ru>, http://tsvshop.tsv.org.ua, http://tsvshop.xyz 
 */


<div class="product">
<form action="index.php" method="post" name="Tovar[+id+]" id="Tovar[+id+]">
<center><a href="[~[+id+]~]"><img src="[+cart_icon+]" width="138" height="118" /></a></center>
<div class="dashed">
<h3><a href="[~[+id+]~]" class="title">[+pagetitle+] [+articul+]</a></h3>
[+tsvoptions+]
</div>
<div class="clear"></div>
<div class="dashed">
     <span class="left"><span class="price">[+tsvprice+]</span> руб.</span>
     <a href="javascript: void(0);" onclick="AddToCart('[+id+]');return false" class="button right cart">В корзину</a>
</div>
<div class="clear"></div>
[+tsvservices+]
</form>
</div>
