<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=[(modx_charset)]" />
	<title>[*longtitle*]</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link rel="stylesheet" href="/assets/templates/demoshop/css/style.css" type="text/css" media="screen, projection" />
</head>

<body>

<div id="wrapper">

	<div id="header">
		
<div id="topmenu">
[[Wayfinder? &startId=`0` &level=`1`]]
</div>
	</div><!-- #header-->

<div id="bread">
[[Breadcrumbs]]
</div>

	<div id="middle">

		<div id="container">

			<div id="content"><h3 class="title">[*pagetitle*]</h3>
<div class="cbox">
<div  style="float:left; width:200px">
<center><img src="[*cart_icon*]" width="120" /></center>
<form action="index.php" method="post" name="Tovar[*id*]" id="Tovar[*id*]">
[[Shop_option? &docid=`[*id*]`]]
<input type="hidden" name="formula" value="[*price*]">
<input type="hidden" name="cart_icon" value="[*cart_icon*]">

<div class="clear"></div>
<div class="dashed">
     <span class="left"><span id="price[*id*]" class="price"></span> руб.</span>
     <a href="javascript: void(0);" onclick="AddToCart('[*id*]');return false" class="button right">В корзину</a>
</div>
<div class="clear"></div>
<script type="text/javascript">Ucalc("[*id*]")</script>
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

<div class="rbox">
<h3 class="compare">Сравнить</h3>
<div class="rbcont">

<div class="dashed"><a class="button right" href="">Сравнить</a></div>
<div class="clear"></div>
</div>
</div>
			
		</div><!-- .sidebar#sideRight -->

	</div><!-- #middle-->

</div><!-- #wrapper -->

<div id="footer">
</div><!-- #footer -->

</body>
</html>