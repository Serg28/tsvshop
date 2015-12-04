# MODx Database Script for New/Upgrade Installations
#
# Each sql command is separated by double lines


REPLACE INTO `{PREFIX}site_templates` VALUES
({TEMPLATE_ITEM},'Карточка товара','<strong>4.3</strong> Тестовый шаблон для карточки товара','0','8','','0','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n	<meta http-equiv=\"content-type\" content=\"text/html; charset=[(modx_charset)]\" />\r\n	<title>[*longtitle*]</title>\r\n	<meta name=\"keywords\" content=\"\" />\r\n	<meta name=\"description\" content=\"\" />\r\n	<link rel=\"stylesheet\" href=\"/assets/templates/demoshop/css/style.css\" type=\"text/css\" media=\"screen, projection\" />\r\n<base href=\"[(base_url)]\" />\r\n </head>\r\n\r\n<body>\r\n\r\n<div id=\"wrapper\">\r\n\r\n	<div id=\"header\">\r\n	<a href=\"http://tsvshop.tsv.org.ua\" class=\"logo\" ><img src=\"/assets/templates/demoshop/img/logo.gif\" alt=\"Модуль TSVshop для создания интернет-магазина для MODx\" /></a>\r\n	\r\n<div id=\"topmenu\">\r\n[[Wayfinder? &startId=`0` &level=`1`]]\r\n</div>\r\n	</div><!-- #header-->\r\n\r\n<div id=\"bread\">\r\n[[Breadcrumbs]]\r\n<div class=\"loginlink\"><a href=\"[~6~]\">Личный кабинет</a></div>\r\n</div>\r\n\r\n	<div id=\"middle\">\r\n\r\n		<div id=\"container\">\r\n\r\n			<div id=\"content\"><h3 class=\"title\">[*pagetitle*]</h3>\r\n<div class=\"cbox\">\r\n<div  style=\"float:left; width:200px\">\r\n<center><img src=\"[*cart_icon*]\" width=\"120\" /></center>\r\n[!TSVshop? &act=`itemcard`!]\r\n
<form action=\"index.php\" method=\"post\" name=\"Tovar[*id*]\" id=\"Tovar[*id*]\">\r\n
[+tsvoptions+]\r\n
<div class=\"clear\"></div>\r\n
<div class=\"dashed\">\r\n
     <span class=\"left\"><span class=\"price\">[+tsvprice+]</span> руб.</span>\r\n
     <a href=\"javascript: void(0);\" onclick=\"AddToCart(\'[*id*]\');return false\" class=\"button right\">В корзину</a>\r\n
</div>\r\n
<div class=\"clear\"></div>\r\n
[+tsvservices+]\r\n
</form>\r\n</div>\r\n<div style=\"margin-left:240px\">[*content*][*text*]</div>\r\n</div>\r\n<div class=\"clear\"></div>			\r\n			</div><!-- #content-->\r\n		</div><!-- #container-->\r\n\r\n		<div class=\"sidebar\" id=\"sideRight\">\r\n<div class=\"rbox\">\r\n<h3 class=\"cart\">Корзина</h3>\r\n<div class=\"rbcont\">\r\n[!TSVshop? &act=`info` &basketid=`2`!]\r\n</div>\r\n</div>\r\n\r\n<div class=\"rbox\">\r\n<h3 class=\"compare\">Сравнить</h3>\r\n<div class=\"rbcont\">\r\n\r\n<div class=\"dashed\"><a class=\"button right\" href=\"\">Сравнить</a></div>\r\n<div class=\"clear\"></div>\r\n</div>\r\n</div>\r\n			\r\n		</div><!-- .sidebar#sideRight -->\r\n\r\n	</div><!-- #middle-->\r\n\r\n</div><!-- #wrapper -->\r\n\r\n<div id=\"footer\">\r\n</div><!-- #footer -->\r\n\r\n</body>\r\n</html>','0'),
({TEMPLATE_MAIN}, 'Основной', '', 0, 0, '', 0, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n	<meta http-equiv="content-type" content="text/html; charset=[(modx_charset)]" />\r\n	<title>[*longtitle*]</title>\r\n	<meta name="keywords" content="" />\r\n	<meta name="description" content="" />\r\n	<link rel="stylesheet" href="/assets/templates/demoshop/css/style.css" type="text/css" media="screen, projection" />\r\n<base href=\"[(base_url)]\" />\r\n</head>\r\n\r\n<body>\r\n\r\n<div id="wrapper">\r\n\r\n	<div id="header">\r\n	 <a href=\"http://tsvshop.tsv.org.ua\" class=\"logo\" ><img src=\"/assets/templates/demoshop/img/logo.gif\" alt=\"Модуль TSVshop для создания интернет-магазина для MODx\" /></a>\r\n  \r\n<div id="topmenu">\r\n[[Wayfinder? &startId=`0` &level=`1`]]\r\n</div>\r\n	</div><!-- #header-->\r\n\r\n<div id="bread">\r\n[[Breadcrumbs]]\r\n<div class=\"loginlink\"><a href=\"[~6~]\">Личный кабинет</a></div>\r\n</div>\r\n\r\n	<div id="middle">\r\n\r\n		<div id="container">\r\n\r\n			<div id="content"><h3 class="title">[*pagetitle*]</h3>\r\n                                 <div class="cbox">[*text*]</div>\r\n				[*content*]\r\n			</div><!-- #content-->\r\n		</div><!-- #container-->\r\n\r\n		<div class="sidebar" id="sideRight">\r\n<div class="rbox">\r\n<h3 class="cart">Мои товары</h3>\r\n<div class="rbcont">\r\n[!TSVshop? &act=`info` &basketid=`2`!]\r\n</div>\r\n</div>\r\n\r\n<div class="rbox">\r\n<h3 class="compare">Сравнить</h3>\r\n<div class="rbcont">\r\n\r\n<div class="dashed"><a class="button right" href="">Сравнить</a></div>\r\n<div class="clear"></div>\r\n</div>\r\n</div>\r\n			\r\n		</div><!-- .sidebar#sideRight -->\r\n\r\n	</div><!-- #middle-->\r\n\r\n</div><!-- #wrapper -->\r\n\r\n<div id="footer">\r\n</div><!-- #footer -->\r\n\r\n</body>\r\n</html>', 0),
({TEMPLATE_INDX}, 'Главная', '', 0, 0, '', 0, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n	<meta http-equiv="content-type" content="text/html; charset=[(modx_charset)]" />\r\n	<title>[*longtitle*]</title>\r\n	<meta name="keywords" content="" />\r\n	<meta name="description" content="" />\r\n	<link rel="stylesheet" href="/assets/templates/demoshop/css/style.css" type="text/css" media="screen, projection" />\r\n<base href=\"[(base_url)]\" />\r\n</head>\r\n\r\n<body>\r\n\r\n<div id="wrapper">\r\n\r\n	<div id="header">\r\n	<a href=\"http://tsvshop.tsv.org.ua\" class=\"logo\" ><img src=\"/assets/templates/demoshop/img/logo.gif\" alt=\"Модуль TSVshop для создания интернет-магазина для MODx\" /></a>\r\n	\r\n<div id="topmenu">\r\n[[Wayfinder? &startId=`0` &level=`1`]]\r\n</div>\r\n	</div><!-- #header-->\r\n\r\n<div id="bread">\r\n[[Breadcrumbs]]\r\n<div class=\"loginlink\"><a href=\"[~6~]\">Личный кабинет</a></div>\r\n</div>\r\n\r\n	<div id="middle">\r\n\r\n		<div id="container">\r\n\r\n			<div id="content"><h3 class="title">[*pagetitle*]</h3>\r\n		        <div class="cbox">[*text*]</div>\r\n                        [*content*]\r\n			</div><!-- #content-->\r\n		</div><!-- #container-->\r\n\r\n		<div class="sidebar" id="sideRight">\r\n<div class="rbox">\r\n<h3 class="cart">Мои товары</h3>\r\n<div class="rbcont">\r\n[!TSVshop? &act=`info` &basketid=`2`!]\r\n</div>\r\n</div>\r\n\r\n<div class="rbox">\r\n<h3 class="compare">Сравнить</h3>\r\n<div class="rbcont">\r\n\r\n<div class="dashed"><a class="button right" href="">Сравнить</a></div>\r\n<div class="clear"></div>\r\n</div>\r\n</div>\r\n			\r\n		</div><!-- .sidebar#sideRight -->\r\n\r\n	</div><!-- #middle-->\r\n\r\n</div><!-- #wrapper -->\r\n\r\n<div id="footer">\r\n</div><!-- #footer -->\r\n\r\n</body>\r\n</html>', 0),
({TEMPLATE_CART}, 'Корзина', '', 0, 0, '', 0, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n	<meta http-equiv="content-type" content="text/html; charset=[(modx_charset)]" />\r\n	<title>[*longtitle*]</title>\r\n	<meta name="keywords" content="" />\r\n	<meta name="description" content="" />\r\n	<link rel="stylesheet" href="/assets/templates/demoshop/css/style.css" type="text/css" media="screen, projection" />\r\n<base href=\"[(base_url)]\" />\r\n</head>\r\n\r\n<body>\r\n\r\n<div id="wrapper">\r\n\r\n	<div id="header">\r\n	<a href=\"http://tsvshop.tsv.org.ua\" class=\"logo\" ><img src=\"/assets/templates/demoshop/img/logo.gif\" alt=\"Модуль TSVshop для создания интернет-магазина для MODx\" /></a>\r\n	\r\n<div id="topmenu">\r\n[[Wayfinder? &startId=`0` &level=`1`]]\r\n</div>\r\n	</div><!-- #header-->\r\n\r\n<div id="bread">\r\n[[Breadcrumbs]]\r\n<div class=\"loginlink\"><a href=\"[~6~]\">Личный кабинет</a></div>\r\n</div>\r\n\r\n	<div id="middle">\r\n\r\n		<div id="container">\r\n\r\n			<div id="content" class="full"><h3 class="title">[*pagetitle*]</h3>\r\n                                 <div class="cbox">[*content*]</div>\r\n				\r\n			</div><!-- #content-->\r\n		</div><!-- #container-->\r\n\r\n		\r\n	</div><!-- #middle-->\r\n\r\n</div><!-- #wrapper -->\r\n\r\n<div id="footer">\r\n</div><!-- #footer -->\r\n\r\n</body>\r\n</html>', 0);

REPLACE INTO `{PREFIX}site_content` (`id`,	`type`,		`contentType`,	`pagetitle`,			`longtitle`,			`description`,			`alias`,	`link_attributes`, 	`published`, 	`pub_date`, 	`unpub_date`, 	`parent`, 	`isfolder`, 	`introtext`, 			`content`, 	`richtext`, 	`template`, 		`menuindex`, `searchable`, `cacheable`, `createdby`, `createdon`, `editedby`, `editedon`, `deleted`, `deletedon`, `deletedby`, `publishedon`, `publishedby`, `menutitle`, `donthit`, `haskeywords`, `hasmetatags`, `privateweb`, `privatemgr`, `content_dispo`, `hidemenu`) VALUES
									(1,		'document',	'text/html',	'Главная', 				'Главная', 				'', 					'index', 	'', 				1, 				0, 				0, 				0, 			0, 				'', 					'<div style="margin-left:-20px">[[Ditto? &tpl=`product` &parents=`8` &extenders=`shop`]]</div>\r\n<!--<div style="margin-left:-20px">[!loopDbChunk? &amp;chunkName=`product2` &amp;tableName=`modx_test_products`!]</div>-->',
																																																																								0, 				{TEMPLATE_INDX}, 	0, 1, 1, 1, 1130304721, 1, 1326980481, 0, 0, 0, 1130304721, 1, 'Главная', 0, 0, 0, 0, 0, 0, 0),
									(6,		'document',	'text/html',	'Мой кабинет', 			'Мой кабинет', 			'Мой кабинет',			'myoffice', '', 				1, 				0, 				0, 				0, 			1, 				'Мой кабинет', 			'[!TSVoffice? &orderpage=`14` &groups=`Registered`!]', 		1, 				{TEMPLATE_MAIN}, 	5, 1, 1, 1, 1326372471, 1, 1326372471, 0, 0, 0, 1326372471, 1, 'Мой кабинет', 0, 0, 0, 0, 0, 0, 1),
									(2,		'document',	'text/html',	'Корзина', 				'Корзина', 				'Корзина', 				'cart', 	'', 				1, 				0, 				0, 				6, 			0, 				'Корзина', 				'<p>[!TSVshop? &amp;act=`basket` &amp;checkid=`3`!]</p>',
																																																																								1, 				{TEMPLATE_CART}, 	1, 1, 1, 1, 1322040255, 1, 1331054736, 0, 0, 0, 1322040265, 1, 'Корзина', 0, 0, 0, 0, 0, 0, 1),
									(3,		'document',	'text/html',	'Оформление покупки', 	'Оформление покупки', 	'Оформление покупки', 	'checkout', '', 				1, 				0, 				0, 				6, 			0, 				'Оформление покупки', 	'<p>[!TSVshop? &amp;act=`checkout` &amp;backid=`4` !]</p>',
																																																																								1, 				{TEMPLATE_CART}, 	2, 1, 1, 1, 1322040674, 1, 1331055965, 0, 0, 0, 1322040674, 1, 'Оформление покупки', 0, 0, 0, 0, 0, 0, 1),
									(4,		'document',	'text/html',	'Спасибо за покупку', 	'Спасибо за покупку', 	'', 					'', 		'', 				1, 				0, 				0, 				6, 			0, 				'Спасибо за покупку', 	'', 		0, 				{TEMPLATE_MAIN}, 	3, 1, 1, 1, 1326362192, 1, 1326899658, 0, 0, 0, 1326362192, 1, 'Спасибо за покупку', 0, 0, 0, 0, 0, 0, 1),
									(5,		'document',	'text/html',	'О сайте', 				'О сайте', 				'О сайте', 				'about', 	'', 				1, 				0, 				0, 				0, 			0, 				'О сайте', 				'', 		1, 				{TEMPLATE_MAIN}, 	1, 1, 1, 1, 1326370247, 1, 1326975100, 0, 0, 0, 1326370247, 1, 'О сайте', 0, 0, 0, 0, 0, 0, 0),
									(7,		'document',	'text/html',	'Каталог товаров', 		'Каталог товаров', 		'Каталог товаров', 		'catalog', 	'', 				1, 				0, 				0, 				0, 			1, 				'', 					'<div style="margin-left: -20px;">[[Ditto? &amp;tpl=`product` &amp;parents=`8` &amp;extenders=`shop`]]</div>',
																																																																								1, 				{TEMPLATE_MAIN}, 	2, 1, 1, 1, 1326975054, 1, 1326979259, 0, 0, 0, 1326975059, 1, 'Каталог товаров', 0, 0, 0, 0, 0, 0, 1),
									(8,		'document',	'text/html',	'Бытовая техника', 		'Бытовая техника', 		'Бытовая техника', 		'', 		'', 				1, 				0, 				0, 				7, 			1, 				'Бытовая техника', 		'', 		1, 				{TEMPLATE_MAIN}, 	0, 1, 1, 1, 1326975378, 1, 1328644753, 0, 0, 0, 1326975378, 1, 'Бытовая техника', 0, 0, 0, 0, 0, 0, 0),
									(9,		'document',	'text/html',	'Канцелярия', 			'Канцелярия', 			'Канцелярия', 			'', 		'', 				1, 				0, 				0, 				7, 			0, 				'Канцелярия', 			'', 		1, 				{TEMPLATE_MAIN}, 	1, 1, 1, 1, 1326975399, 1, 1326975399, 0, 0, 0, 1326975399, 1, 'Канцелярия', 0, 0, 0, 0, 0, 0, 0),
									(10,	'document',	'text/html',	'Телевизор LCD', 		'Телевизор LCD', 		'Телевизор LCD', 		'', 		'', 				1, 				0, 				0, 				8, 			0, 				'Телевизор LCD', 		'<table class="tinfo" border="0">\r\n<tbody>\r\n<tr>\r\n<td>Размер диагонали экрана <br /></td>\r\n<td>32(81см) <br /></td>\r\n</tr>\r\n<tr>\r\n<td>Формат экрана</td>\r\n<td>16:9</td>\r\n</tr>\r\n<tr>\r\n<td>Разрешение</td>\r\n<td>1920х1080</td>\r\n</tr>\r\n<tr>\r\n<td>Яркость</td>\r\n<td>480</td>\r\n</tr>\r\n<tr>\r\n<td>Контрастность</td>\r\n<td>3000:1</td>\r\n</tr>\r\n<tr>\r\n<td>Динамичекая контрастность</td>\r\n<td>30000:1</td>\r\n</tr>\r\n<tr>\r\n<td>Макс. Угол обзора по верт.</td>\r\n<td>178</td>\r\n</tr>\r\n<tr>\r\n<td>Макс. Угол обзора по гориз.</td>\r\n<td>178</td>\r\n</tr>\r\n<tr>\r\n<td>Время отклика матрицы, мс</td>\r\n<td>8</td>\r\n</tr>\r\n<tr>\r\n<td>Scart</td>\r\n<td>2</td>\r\n</tr>\r\n<tr>\r\n<td>HDMI</td>\r\n<td>3 <br /></td>\r\n</tr>\r\n<tr>\r\n<td>Компонентный(Y/Pb/Pr)</td>\r\n<td>+</td>\r\n</tr>\r\n<tr>\r\n<td>VGA</td>\r\n<td>+</td>\r\n</tr>\r\n<tr>\r\n<td>AV</td>\r\n<td>+</td>\r\n</tr>\r\n</tbody>\r\n</table>',
																																																																								1, 				{TEMPLATE_ITEM}, 	0, 1, 1, 1, 1326976137, 1, 1326982164, 0, 0, 0, 1326976137, 1, 'Телевизор LCD', 0, 0, 0, 0, 0, 0, 0),
									(11,	'document',	'text/html',	'Микроволновка', 		'Микроволновка', 		'Микроволновка', 		'', 		'', 				1, 				0, 				0, 				8, 			0, 				'Микроволновка', 		'', 		1, 				{TEMPLATE_ITEM}, 	1, 1, 1, 1, 1326978714, 1, 1326978714, 0, 0, 0, 1326978714, 1, 'Микроволновка', 0, 0, 0, 0, 0, 0, 0), (13,    'document',     'text/html',    'Мои заказы',                'Мои заказы',                'Мои заказы',                '',             '',                             1,                              0,                              0,                              6,                      0,                              'Мои заказы',                '[!TSVoffice? &act=`listorders` &orderpage=`14`!]',             1,                              {TEMPLATE_MAIN},        1, 1, 1, 1, 1326978714, 1, 1326978714, 0, 0, 0, 1326978714, 1, 'Мои заказы', 0, 0, 0, 0, 0, 0, 0),(14,    'document',     'text/html',    'Просмотр заказа',                'Просмотр заказа',                'Просмотр заказа',                '',             '',                             1,                              0,                              0,                              6,                      0,                              'Просмотр заказа',                '<p><a href=\"[~6~]\">Назад к списку заказов</a></p>[!TSVoffice? &act=`showorder`!]<p><a href=\"[~6~]\">Назад к списку заказов</a></p>',             1,                              {TEMPLATE_MAIN},        1, 1, 1, 1, 1326978714, 1, 1326978714, 0, 0, 0, 1326978714, 1, 'Просмотр заказа', 0, 0, 0, 0, 0, 0, 0),(15,    'document',     'text/html',    'Редактирование профиля',                'Редактирование профиля',                'Редактирование профиля',                '',             '',                             1,                              0,                              0,                              6,                      0,                              'Редактирование профиля',                '[!TSVoffice? &act=`editprofile`!]',             1,                              {TEMPLATE_MAIN},        1, 1, 1, 1, 1326978714, 1, 1326978714, 0, 0, 0, 1326978714, 1, 'Редактирование профиля', 0, 0, 0, 0, 0, 0, 0);

REPLACE INTO `{PREFIX}site_tmplvars` 	(`id`,			`type`,			`name`, 			`caption`, 			`description`, `editor_type`, `category`, `locked`, `elements`, `rank`, `display`, `display_params`, `default_text`) VALUES
										({TV_IMAGE}, 	'image', 		'cart_icon', 		'Картинка товара', 	'Выводится в каталоге, корзине и инфоблоке', 0, 8, 0, '', 0, '', '', ''),
										({TV_TMINI}, 	'textareamini',	'tsvshop_param', 	'Параметры товара',	'Дополнительные параметры товара, влияющие на цену', 0, 8, 0, '', 0, '', '', ''),
										({TV_ARTCL}, 	'text', 		'articul', 			'Артикул', 			'Артикул товара', 0, 8, 0, '', 0, '', '', ''),
										({TV_PRICE}, 	'text', 		'price', 			'Цена товара', 		'Параметр <b>обязателен</b>', 0, 8, 0, '', 0, '', '', ''),
		    ({TV_INVEN}, 'text', 'inventory', 'Кол-во на складе', '', 0, 8, 0, '', 0, '', '', ''),
										({TV_REDIT}, 	'richtext', 	'text', 			'Текст вверху', 	'', 0, 0, 0, '', 0, '', '', '');

REPLACE INTO `{PREFIX}site_tmplvar_contentvalues` (`id`, `tmplvarid`, `contentid`, `value`) VALUES
(1, {TV_REDIT}, 1, '<p>Добро пожаловать на демонстрационный сайт модуля <b>TSVshop</b> для создания интернет-магазина в CMS MODx. Помните, что вся предоставленная информация на сайте имеет исключительно демонстрационный характер. Все заказы, сделанные вами, будут игнорироваться.</p>\r\n<p>Ниже представлен каталог тестовых товаров, сформированных с помощью сниппета <strong>Ditto</strong>. </p>\r\n<p>Обратите внимание на 2 момента!</p>\r\n<ul>\r\n<li>Выбор любой характеристики товара влияет на его конечную стоимость.</li>\r\n<li>В зависимости от выбранного количества товара меняется его стоимость.</li>\r\n</ul>'),
(2, {TV_REDIT}, 2, '<p>Вы находитесь на странице со списком выбранных вами товаров. Проверьте, все ли верно. Для того, чтобы оформить покупку, нажмите на кнопку <strong>Оформить заказ</strong></p>'),
(3, {TV_REDIT}, 4, '[!TSVshop? &amp;act=`finish`!]'),
(4, {TV_REDIT}, 7, '<p>Ниже вашему вниманию представлен каталог тестовых товаров, сформированных с помощью сниппета <strong>Ditto</strong>. </p>'),
(5, {TV_IMAGE}, 10, 'assets/images/toshiba-37-regza-lcd-37xv500pg.127701.2.jpg'),
(6, {TV_TMINI}, 10, 'radio==Диагональ:*14==2||16==3||18==4;'),
(7, {TV_ARTCL}, 10, 'Т120'),
(8, {TV_PRICE}, 10, '1-2==21490||3-4==21000||20800'),
(9, {TV_IMAGE}, 11, '/assets/templates/demoshop/img/tovar.jpg'),
(10, {TV_TMINI}, 11, 'select==Цвет:*Белый==0||Серый==2||Черный==3;'),
(11, {TV_ARTCL}, 11, 'М120'),
(12, {TV_PRICE}, 11, '13000');

REPLACE INTO `{PREFIX}site_tmplvar_templates` (`tmplvarid`, `templateid`, `rank`) VALUES
({TV_IMAGE}, {TEMPLATE_ITEM}, 0),
({TV_ARTCL}, {TEMPLATE_ITEM}, 0),
({TV_TMINI}, {TEMPLATE_ITEM}, 0),
({TV_PRICE}, {TEMPLATE_ITEM}, 0),
({TV_REDIT}, {TEMPLATE_MAIN}, 0),
({TV_REDIT}, {TEMPLATE_INDX}, 0),
({TV_REDIT}, {TEMPLATE_CART}, 0);

