/**
 * Карточка товара
 *
 * Тестовый шаблон для карточки товара в TSVshop
 *
 * @category	template
 * @version 	5.3
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal	@lock_template 0
 * @internal 	@modx_category TSVshop
 * @internal  @installset sample
 * @author    Telnij Sergey (Serg24) <privat_tel@mail.ru>, http://tsvshop.tsv.org.ua, http://tsvshop.xyz 
 */
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=[(modx_charset)]" />
	<title>[*longtitle*]</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link rel="stylesheet" href="/assets/templates/demoshop/css/style.css" type="text/css" media="screen, projection" />
  <base href="[(base_url)]" />
</head>

<body>

<div id="wrapper">

	<div id="header">
		<a href="http://tsvshop.tsv.org.ua" class="logo" ><img src="/assets/templates/demoshop/img/logo.gif" alt="Модуль TSVshop для создания интернет-магазина для MODx" /></a>
<div id="topmenu">
[[Wayfinder? &startId=`0` &level=`1`]]
</div>
	</div><!-- #header-->

<div id="bread">
[[Breadcrumbs]]
<div class="loginlink"><a href="[~6~]">Личный кабинет</a></div>
</div>

	<div id="middle">

		<div id="container">

			<div id="content"><h3 class="title">[*pagetitle*]</h3>
<div class="cbox">
<div  style="float:left; width:200px">
<center><img src="[*cart_icon*]" width="120" /></center>
[!TSVshop? &act=`itemcard`!]
<form action="index.php" method="post" name="Tovar[*id*]" id="Tovar[*id*]">
[+tsvoptions+]
<div class="clear"></div>
<div class="dashed">
     <span class="left"><span class="price">[+tsvprice+]</span> руб.</span>
     <a href="javascript: void(0);" onclick="AddToCart('[*id*]');return false" class="button right">В корзину</a>
</div>
<div class="clear"></div>
[+tsvservices+]
</form>
</div>
<div style="margin-left:240px">[*content*][*text*]</div>
</div>
<div class="clear"></div>			
			</div><!-- #content-->
		</div><!-- #container-->

		<div class="sidebar" id="sideRight">
<div class="rbox">
<h3 class="cart">Корзина</h3>
<div class="rbcont">
[!TSVshop? &act=`info` &basketid=`2`!]
</div>
</div>


</div><!-- .sidebar#sideRight -->

</div><!-- #middle-->

</div><!-- #wrapper -->

<div id="footer">
</div><!-- #footer -->

</body>
</html>