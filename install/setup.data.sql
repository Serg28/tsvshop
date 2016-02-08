# MODx Database Script for New/Upgrade Installations
# MODx was created By Raymond Irving - Nov 2004
#
# Each sql command is separated by double lines \n\n


CREATE TABLE IF NOT EXISTS `{PREFIX}shop_order` (
  `numorder` int(255) NOT NULL AUTO_INCREMENT,
  `dateorder` int(25) NOT NULL,
  `datepay` int(25) NOT NULL,
  `status` text NOT NULL,
  `fio` blob NOT NULL,
  `total` text NOT NULL,
  `topay` text NOT NULL,
  `discountnum` text NOT NULL,
  `discount` text NOT NULL,
  `discountsize` text NOT NULL,
  `comments` longtext NOT NULL,
  `adress` blob NOT NULL,
  `city` blob NOT NULL,
  `region` text NOT NULL,
  `zip` text NOT NULL,
  `province` text NOT NULL,
  `tracking` text NOT NULL,
  `phone` blob NOT NULL,
  `email` blob NOT NULL,
  `dostavka` text NOT NULL,
  `commentadmin` longtext NOT NULL,
  `dostprice` text NOT NULL,
  `subtotal` text NOT NULL,
  `nalog` text NOT NULL,
  `code` text NOT NULL,
  `userid` int(5) NOT NULL,
  PRIMARY KEY (`numorder`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `{PREFIX}shop_order_detail` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `numorder` int(11) NOT NULL default '0',
  `quantity` text NOT NULL,
  `price` text NOT NULL,
  `articul` text NOT NULL,
  `name` text NOT NULL,
  `url` varchar(125) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `options` varchar(200) NOT NULL,
  `typeitem` varchar(10) NOT NULL DEFAULT 'physical',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `{PREFIX}shop_numorder` (
  `numorder` int(11) NOT NULL,
  `key` int(11) NOT NULL,
  PRIMARY KEY (`numorder`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `{PREFIX}shop_conf` (
  `module` varchar(32) NOT NULL DEFAULT '',
  `name` varchar(32) NOT NULL DEFAULT '',
  `value` blob NOT NULL,
  `exported` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`module`,`name`)
) ENGINE=MyISAM;


REPLACE INTO `{PREFIX}shop_conf` VALUES ('MySQL', 'Prefix', '{PREFIX}', 1);

#REPLACE INTO `{PREFIX}shop_conf` VALUES ('MySQL', 'Server', '{DBHOST}', 1);

#REPLACE INTO `{PREFIX}shop_conf` VALUES ('MySQL', 'User', '{DBUSER}', 1);

#REPLACE INTO `{PREFIX}shop_conf` VALUES ('MySQL', 'Pass', '{DBPASS}', 1);

#REPLACE INTO `{PREFIX}shop_conf` VALUES ('MySQL', 'DB', '{DBNAME}', 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('addons', 'sales_active', 0x796573, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('addons', 'config_active', 0x796573, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('addons', 'addons_active', 0x796573, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'SmtpReplyEmail', 0x6d79406d61696c2e636f6d, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'SmtpFromName', 0xd098d0bdd182d0b5d180d0bdd0b5d1822dd0bcd0b0d0b3d0b0d0b7d0b8d0bd, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'SmtpFromEmail', 0x6d79406d61696c2e636f6d, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'TypeCat', 0x646f6373, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'SmtpAuth', 0x74727565, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'SmtPass', '', 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'SmtpUser', '', 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'MinimumOrder', '', 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'DisplayShippingRow', 0x74727565, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'DisplayNotice', 0x74727565, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'fShipping', '', 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'PriceFormat', 0x302c3030, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'CatRoot', 0x37, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'DisplayPrice', 0x74727565, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'SmtpPort', '', 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'DisplayDiscount', 0x74727565, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'SmtpHost', '', 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'MonetarySymbol', 0x20d0b3d180d0bd2e, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'MailMode', 0x6d61696c, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'StatusOrder', 0xd09dd0bed0b2d18bd0b93d3d4541413541347c7cd09ed0b6d0b8d0b4d0b0d0bdd0b8d0b520d0bed0bfd0bbd0b0d182d18b3d3d4541453441347c7cd09ed0bfd0bbd0b0d187d0b5d0bdd0be3d3d4233454141347c7cd097d0b0d0b2d0b5d180d188d0b5d0bdd0be3d3d4233454141347c7cd09ed182d0bcd0b5d0bdd0b5d0bd, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'SubjectMailAdmin', 0xd09fd0bed181d182d183d0bfd0b8d0bb20d0bdd0bed0b2d18bd0b920d0b7d0b0d0bad0b0d0b7, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'SubjectMailUser', 0xd097d0b0d0bad0b0d0b720d183d181d0bfd0b5d188d0bdd0be20d0bfd180d0b8d0bdd18fd182, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'SubjectUpdateStatus', 0xd098d0b7d0bcd0b5d0bdd0b5d0bdd0b8d0b520d181d182d0b0d182d183d181d0b020d0b7d0b0d0bad0b0d0b7d0b0, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'shipping', '', 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'SecPassword', 0x4d7950617373, 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('', 'SecFields', 0x66696f2c6164726573732c636974792c70686f6e652c656d61696c, 1);



REPLACE INTO `{PREFIX}system_eventnames` VALUES ('1020','TSVshopOnBeforeUserFormInit', 6, 'TSVshop');

REPLACE INTO `{PREFIX}system_eventnames` VALUES ('1021','TSVshopOnUserFormComplete', 6, 'TSVshop');

REPLACE INTO `{PREFIX}system_eventnames` VALUES ('1022','TSVshopOnUserFormRender', 6, 'TSVshop');

REPLACE INTO `{PREFIX}system_eventnames` VALUES ('1023','TSVshopOnBeforeUserFormRenderComplete', 6, 'TSVshop');

REPLACE INTO `{PREFIX}system_eventnames` VALUES ('1024','TSVshopOnTplCartRender', 6, 'TSVshop');

REPLACE INTO `{PREFIX}system_eventnames` VALUES ('1025','TSVshopOnTplCartPrerender', 6, 'TSVshop');

REPLACE INTO `{PREFIX}system_eventnames` VALUES ('1026','TSVshopOnGetSubtotal', 6, 'TSVshop');

REPLACE INTO `{PREFIX}system_eventnames` VALUES ('1027','TSVshopOnAddItem', 6, 'TSVshop');

REPLACE INTO `{PREFIX}system_eventnames` VALUES ('1028','TSVshopOnOrderSuccess', 6, 'TSVshop');

REPLACE INTO `{PREFIX}system_eventnames` VALUES ('1029','TSVshopOnViewItemCard', 6, 'TSVshop');

REPLACE INTO `{PREFIX}system_eventnames` VALUES ('1030','TSVshopOnOrderStatusUpdate', 6, 'TSVshop');

REPLACE INTO `{PREFIX}system_eventnames` VALUES ('1031','TSVshopOnDeleteItem', 6, 'TSVshop');

REPLACE INTO `{PREFIX}system_eventnames` VALUES ('1034','TSVshopOnClearCart', 6, 'TSVshop');

REPLACE INTO `{PREFIX}system_eventnames` VALUES ('1035','TSVshopOnChangeItemQty', 6, 'TSVshop');


REPLACE INTO `{PREFIX}categories` (`id`, `category`) VALUES (13, 'TSVshop');


# MODx Database Script for New/Upgrade Installations
#
# Each sql command is separated by double lines


REPLACE INTO `{PREFIX}site_templates` VALUES
(11,'Карточка товара','<strong>5.3</strong> Тестовый шаблон для карточки товара','0','8','','0','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n <meta http-equiv=\"content-type\" content=\"text/html; charset=[(modx_charset)]\" />\r\n <title>[*longtitle*]</title>\r\n <meta name=\"keywords\" content=\"\" />\r\n <meta name=\"description\" content=\"\" />\r\n <link rel=\"stylesheet\" href=\"/assets/templates/demoshop/css/style.css\" type=\"text/css\" media=\"screen, projection\" />\r\n<base href=\"[(base_url)]\" />\r\n </head>\r\n\r\n<body>\r\n\r\n<div id=\"wrapper\">\r\n\r\n <div id=\"header\">\r\n <a href=\"http://tsvshop.tsv.org.ua\" class=\"logo\" ><img src=\"/assets/templates/demoshop/img/logo.gif\" alt=\"Модуль TSVshop для создания интернет-магазина для MODx\" /></a>\r\n \r\n<div id=\"topmenu\">\r\n[[Wayfinder? &startId=`0` &level=`1`]]\r\n</div>\r\n </div><!-- #header-->\r\n\r\n<div id=\"bread\">\r\n[[Breadcrumbs]]\r\n<div class=\"loginlink\"><a href=\"[~6~]\">Личный кабинет</a></div>\r\n</div>\r\n\r\n <div id=\"middle\">\r\n\r\n <div id=\"container\">\r\n\r\n <div id=\"content\"><h3 class=\"title\">[*pagetitle*]</h3>\r\n<div class=\"cbox\">\r\n<div style=\"float:left; width:200px\">\r\n<center><img src=\"[*cart_icon*]\" width=\"120\" /></center>\r\n[!TSVshop? &act=`itemcard`!]\r\n
<form action=\"index.php\" method=\"post\" name=\"Tovar[*id*]\" id=\"Tovar[*id*]\">\r\n
[+tsvoptions+]\r\n
<div class=\"clear\"></div>\r\n
<div class=\"dashed\">\r\n
<span class=\"left\"><span class=\"price\">[+tsvprice+]</span> руб.</span>\r\n
<a href=\"javascript: void(0);\" onclick=\"AddToCart(\'[*id*]\');return false\" class=\"button right\">В корзину</a>\r\n
</div>\r\n
<div class=\"clear\"></div>\r\n
[+tsvservices+]\r\n
</form>\r\n</div>\r\n<div style=\"margin-left:240px\">[*content*][*demotext*]</div>\r\n</div>\r\n<div class=\"clear\"></div> \r\n </div><!-- #content-->\r\n </div><!-- #container-->\r\n\r\n <div class=\"sidebar\" id=\"sideRight\">\r\n<div class=\"rbox\">\r\n<h3 class=\"cart\">Корзина</h3>\r\n<div class=\"rbcont\">\r\n[!TSVshop? &act=`info` &basketid=`2`!]\r\n</div>\r\n</div>\r\n </div><!-- .sidebar#sideRight -->\r\n\r\n </div><!-- #middle-->\r\n\r\n</div><!-- #wrapper -->\r\n\r\n<div id=\"footer\">\r\n</div><!-- #footer -->\r\n\r\n</body>\r\n</html>','0'),
(12, 'Основной', '', 0, 0, '', 0, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n <meta http-equiv="content-type" content="text/html; charset=[(modx_charset)]" />\r\n <title>[*longtitle*]</title>\r\n <meta name="keywords" content="" />\r\n <meta name="description" content="" />\r\n <link rel="stylesheet" href="/assets/templates/demoshop/css/style.css" type="text/css" media="screen, projection" />\r\n<base href=\"[(base_url)]\" />\r\n</head>\r\n\r\n<body>\r\n\r\n<div id="wrapper">\r\n\r\n <div id="header">\r\n <a href=\"http://tsvshop.xyz\" class=\"logo\" ><img src=\"/assets/templates/demoshop/img/logo.gif\" alt=\"Модуль TSVshop для создания интернет-магазина для MODx\" /></a>\r\n \r\n<div id="topmenu">\r\n[[Wayfinder? &startId=`0` &level=`1`]]\r\n</div>\r\n </div><!-- #header-->\r\n\r\n<div id="bread">\r\n[[Breadcrumbs]]\r\n<div class=\"loginlink\"><a href=\"[~6~]\">Личный кабинет</a></div>\r\n</div>\r\n\r\n <div id="middle">\r\n\r\n <div id="container">\r\n\r\n <div id="content"><h3 class="title">[*pagetitle*]</h3>\r\n <div class="cbox">[*demotext*]</div>\r\n [*content*]\r\n </div><!-- #content-->\r\n </div><!-- #container-->\r\n\r\n <div class="sidebar" id="sideRight">\r\n<div class="rbox">\r\n<h3 class="cart">Мои товары</h3>\r\n<div class="rbcont">\r\n[!TSVshop? &act=`info` &basketid=`2`!]\r\n</div>\r\n</div>\r\n\r\n<div class="rbox">\r\n<h3 class="compare">Сравнить</h3>\r\n<div class="rbcont">\r\n\r\n<div class="dashed"><a class="button right" href="">Сравнить</a></div>\r\n<div class="clear"></div>\r\n</div>\r\n</div>\r\n \r\n </div><!-- .sidebar#sideRight -->\r\n\r\n </div><!-- #middle-->\r\n\r\n</div><!-- #wrapper -->\r\n\r\n<div id="footer">\r\n</div><!-- #footer -->\r\n\r\n</body>\r\n</html>', 0),
(13, 'Главная', '', 0, 0, '', 0, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n <meta http-equiv="content-type" content="text/html; charset=[(modx_charset)]" />\r\n <title>[*longtitle*]</title>\r\n <meta name="keywords" content="" />\r\n <meta name="description" content="" />\r\n <link rel="stylesheet" href="/assets/templates/demoshop/css/style.css" type="text/css" media="screen, projection" />\r\n<base href=\"[(base_url)]\" />\r\n</head>\r\n\r\n<body>\r\n\r\n<div id="wrapper">\r\n\r\n <div id="header">\r\n <a href=\"http://tsvshop.xyz\" class=\"logo\" ><img src=\"/assets/templates/demoshop/img/logo.gif\" alt=\"Модуль TSVshop для создания интернет-магазина для MODx\" /></a>\r\n \r\n<div id="topmenu">\r\n[[Wayfinder? &startId=`0` &level=`1`]]\r\n</div>\r\n </div><!-- #header-->\r\n\r\n<div id="bread">\r\n[[Breadcrumbs]]\r\n<div class=\"loginlink\"><a href=\"[~6~]\">Личный кабинет</a></div>\r\n</div>\r\n\r\n <div id="middle">\r\n\r\n <div id="container">\r\n\r\n <div id="content"><h3 class="title">[*pagetitle*]</h3>\r\n <div class="cbox">[*demotext*]</div>\r\n [*content*]\r\n </div><!-- #content-->\r\n </div><!-- #container-->\r\n\r\n <div class="sidebar" id="sideRight">\r\n<div class="rbox">\r\n<h3 class="cart">Мои товары</h3>\r\n<div class="rbcont">\r\n[!TSVshop? &act=`info` &basketid=`2`!]\r\n</div>\r\n</div>\r\n\r\n<div class="rbox">\r\n<h3 class="compare">Сравнить</h3>\r\n<div class="rbcont">\r\n\r\n<div class="dashed"><a class="button right" href="">Сравнить</a></div>\r\n<div class="clear"></div>\r\n</div>\r\n</div>\r\n \r\n </div><!-- .sidebar#sideRight -->\r\n\r\n </div><!-- #middle-->\r\n\r\n</div><!-- #wrapper -->\r\n\r\n<div id="footer">\r\n</div><!-- #footer -->\r\n\r\n</body>\r\n</html>', 0),
(14, 'Корзина', '', 0, 0, '', 0, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml">\r\n<head>\r\n <meta http-equiv="content-type" content="text/html; charset=[(modx_charset)]" />\r\n <title>[*longtitle*]</title>\r\n <meta name="keywords" content="" />\r\n <meta name="description" content="" />\r\n <link rel="stylesheet" href="/assets/templates/demoshop/css/style.css" type="text/css" media="screen, projection" />\r\n<base href=\"[(base_url)]\" />\r\n</head>\r\n\r\n<body>\r\n\r\n<div id="wrapper">\r\n\r\n <div id="header">\r\n <a href=\"http://tsvshop.xyz\" class=\"logo\" ><img src=\"/assets/templates/demoshop/img/logo.gif\" alt=\"Модуль TSVshop для создания интернет-магазина для MODx\" /></a>\r\n \r\n<div id="topmenu">\r\n[[Wayfinder? &startId=`0` &level=`1`]]\r\n</div>\r\n </div><!-- #header-->\r\n\r\n<div id="bread">\r\n[[Breadcrumbs]]\r\n<div class=\"loginlink\"><a href=\"[~6~]\">Личный кабинет</a></div>\r\n</div>\r\n\r\n <div id="middle">\r\n\r\n <div id="container">\r\n\r\n <div id="content" class="full"><h3 class="title">[*pagetitle*]</h3>\r\n <div class="cbox">[*content*]</div>\r\n \r\n </div><!-- #content-->\r\n </div><!-- #container-->\r\n\r\n \r\n </div><!-- #middle-->\r\n\r\n</div><!-- #wrapper -->\r\n\r\n<div id="footer">\r\n</div><!-- #footer -->\r\n\r\n</body>\r\n</html>', 0);

REPLACE INTO `{PREFIX}site_content` (`id`,	`type`,	`contentType`,	`pagetitle`,	`longtitle`,	`description`,	`alias`,	`link_attributes`, `published`, `pub_date`, `unpub_date`, `parent`, `isfolder`, `introtext`, `content`, `richtext`, `template`, `menuindex`, `searchable`, `cacheable`, `createdby`, `createdon`, `editedby`, `editedon`, `deleted`, `deletedon`, `deletedby`, `publishedon`, `publishedby`, `menutitle`, `donthit`, `haskeywords`, `hasmetatags`, `privateweb`, `privatemgr`, `content_dispo`, `hidemenu`) VALUES
(1,	'document',	'text/html',	'Главная', 'Главная', '', 'index', '', 1, 0, 0, 0, 0, '', '<div style="margin-left:-20px">[[Ditto? &tpl=`product` &parents=`8` &extenders=`shop`]]</div>\r\n<!--<div style="margin-left:-20px">[!loopDbChunk? &amp;chunkName=`product2` &amp;tableName=`modx_test_products`!]</div>-->',
0, 13, 0, 1, 1, 1, 1130304721, 1, 1326980481, 0, 0, 0, 1130304721, 1, 'Главная', 0, 0, 0, 0, 0, 0, 0),
(6,	'document',	'text/html',	'Мой кабинет', 'Мой кабинет', 'Мой кабинет',	'myoffice', '', 1, 0, 0, 0, 1, 'Мой кабинет', '[!TSVoffice? &orderpage=`14` &groups=`Registered`!]', 1, 12, 5, 1, 1, 1, 1326372471, 1, 1326372471, 0, 0, 0, 1326372471, 1, 'Мой кабинет', 0, 0, 0, 0, 0, 0, 1),
(2,	'document',	'text/html',	'Корзина', 'Корзина', 'Корзина', 'cart', '', 1, 0, 0, 6, 0, 'Корзина', '<p>[!TSVshop? &amp;act=`basket` &amp;checkid=`3`!]</p>',
1, 14, 1, 1, 1, 1, 1322040255, 1, 1331054736, 0, 0, 0, 1322040265, 1, 'Корзина', 0, 0, 0, 0, 0, 0, 1),
(3,	'document',	'text/html',	'Оформление покупки', 'Оформление покупки', 'Оформление покупки', 'checkout', '', 1, 0, 0, 6, 0, 'Оформление покупки', '<p>[!TSVshop? &amp;act=`checkout` &amp;backid=`4` !]</p>',
1, 14, 2, 1, 1, 1, 1322040674, 1, 1331055965, 0, 0, 0, 1322040674, 1, 'Оформление покупки', 0, 0, 0, 0, 0, 0, 1),
(4,	'document',	'text/html',	'Спасибо за покупку', 'Спасибо за покупку', '', '', '', 1, 0, 0, 6, 0, 'Спасибо за покупку', '', 0, 12, 3, 1, 1, 1, 1326362192, 1, 1326899658, 0, 0, 0, 1326362192, 1, 'Спасибо за покупку', 0, 0, 0, 0, 0, 0, 1),
(5,	'document',	'text/html',	'О сайте', 'О сайте', 'О сайте', 'about', '', 1, 0, 0, 0, 0, 'О сайте', '', 1, 12, 1, 1, 1, 1, 1326370247, 1, 1326975100, 0, 0, 0, 1326370247, 1, 'О сайте', 0, 0, 0, 0, 0, 0, 0),
(7,	'document',	'text/html',	'Каталог товаров', 'Каталог товаров', 'Каталог товаров', 'catalog', '', 1, 0, 0, 0, 1, '', '<div style="margin-left: -20px;">[[Ditto? &amp;tpl=`product` &amp;parents=`8` &amp;extenders=`shop`]]</div>',
1, 12, 2, 1, 1, 1, 1326975054, 1, 1326979259, 0, 0, 0, 1326975059, 1, 'Каталог товаров', 0, 0, 0, 0, 0, 0, 1),
(8,	'document',	'text/html',	'Бытовая техника', 'Бытовая техника', 'Бытовая техника', '', '', 1, 0, 0, 7, 1, 'Бытовая техника', '', 1, 12, 0, 1, 1, 1, 1326975378, 1, 1328644753, 0, 0, 0, 1326975378, 1, 'Бытовая техника', 0, 0, 0, 0, 0, 0, 0),
(9,	'document',	'text/html',	'Канцелярия', 'Канцелярия', 'Канцелярия', '', '', 1, 0, 0, 7, 0, 'Канцелярия', '', 1, 12, 1, 1, 1, 1, 1326975399, 1, 1326975399, 0, 0, 0, 1326975399, 1, 'Канцелярия', 0, 0, 0, 0, 0, 0, 0),
(10,	'document',	'text/html',	'Телевизор LCD', 'Телевизор LCD', 'Телевизор LCD', '', '', 1, 0, 0, 8, 0, 'Телевизор LCD', '<table class="tinfo" border="0">\r\n<tbody>\r\n<tr>\r\n<td>Размер диагонали экрана <br /></td>\r\n<td>32(81см) <br /></td>\r\n</tr>\r\n<tr>\r\n<td>Формат экрана</td>\r\n<td>16:9</td>\r\n</tr>\r\n<tr>\r\n<td>Разрешение</td>\r\n<td>1920х1080</td>\r\n</tr>\r\n<tr>\r\n<td>Яркость</td>\r\n<td>480</td>\r\n</tr>\r\n<tr>\r\n<td>Контрастность</td>\r\n<td>3000:1</td>\r\n</tr>\r\n<tr>\r\n<td>Динамичекая контрастность</td>\r\n<td>30000:1</td>\r\n</tr>\r\n<tr>\r\n<td>Макс. Угол обзора по верт.</td>\r\n<td>178</td>\r\n</tr>\r\n<tr>\r\n<td>Макс. Угол обзора по гориз.</td>\r\n<td>178</td>\r\n</tr>\r\n<tr>\r\n<td>Время отклика матрицы, мс</td>\r\n<td>8</td>\r\n</tr>\r\n<tr>\r\n<td>Scart</td>\r\n<td>2</td>\r\n</tr>\r\n<tr>\r\n<td>HDMI</td>\r\n<td>3 <br /></td>\r\n</tr>\r\n<tr>\r\n<td>Компонентный(Y/Pb/Pr)</td>\r\n<td>+</td>\r\n</tr>\r\n<tr>\r\n<td>VGA</td>\r\n<td>+</td>\r\n</tr>\r\n<tr>\r\n<td>AV</td>\r\n<td>+</td>\r\n</tr>\r\n</tbody>\r\n</table>',
1, 11, 0, 1, 1, 1, 1326976137, 1, 1326982164, 0, 0, 0, 1326976137, 1, 'Телевизор LCD', 0, 0, 0, 0, 0, 0, 0),
(11,	'document',	'text/html',	'Микроволновка', 'Микроволновка', 'Микроволновка', '', '', 1, 0, 0, 8, 0, 'Микроволновка', '', 1, 11, 1, 1, 1, 1, 1326978714, 1, 1326978714, 0, 0, 0, 1326978714, 1, 'Микроволновка', 0, 0, 0, 0, 0, 0, 0), (13, 'document', 'text/html', 'Мои заказы', 'Мои заказы', 'Мои заказы', '', '', 1, 0, 0, 6, 0, 'Мои заказы', '[!TSVoffice? &act=`listorders` &orderpage=`14`!]', 1, 12, 1, 1, 1, 1, 1326978714, 1, 1326978714, 0, 0, 0, 1326978714, 1, 'Мои заказы', 0, 0, 0, 0, 0, 0, 0),(14, 'document', 'text/html', 'Просмотр заказа', 'Просмотр заказа', 'Просмотр заказа', '', '', 1, 0, 0, 6, 0, 'Просмотр заказа', '<p><a href=\"[~6~]\">Назад к списку заказов</a></p>[!TSVoffice? &act=`showorder`!]<p><a href=\"[~6~]\">Назад к списку заказов</a></p>', 1, 12, 1, 1, 1, 1, 1326978714, 1, 1326978714, 0, 0, 0, 1326978714, 1, 'Просмотр заказа', 0, 0, 0, 0, 0, 0, 0),(15, 'document', 'text/html', 'Редактирование профиля', 'Редактирование профиля', 'Редактирование профиля', '', '', 1, 0, 0, 6, 0, 'Редактирование профиля', '[!TSVoffice? &act=`editprofile`!]', 1, 12, 1, 1, 1, 1, 1326978714, 1, 1326978714, 0, 0, 0, 1326978714, 1, 'Редактирование профиля', 0, 0, 0, 0, 0, 0, 0);

REPLACE INTO `{PREFIX}site_tmplvars` (`id`,	`type`,	`name`, `caption`, `description`, `editor_type`, `category`, `locked`, `elements`, `rank`, `display`, `display_params`, `default_text`) VALUES
(25, 'image', 'cart_icon', 'Картинка товара', 'Выводится в каталоге, корзине и инфоблоке', 0, 13, 0, '', 0, '', '', ''),
(23, 'textareamini',	'tsvshop_param', 'Параметры товара',	'Дополнительные параметры товара, влияющие на цену', 0, 13, 0, '', 0, '', '', ''),
(24, 'text', 'articul', 'Артикул', 'Артикул товара', 0, 13, 0, '', 0, '', '', ''),
(21, 'text', 'price', 'Цена товара', 'Параметр <b>обязателен</b>', 0, 13, 0, '', 0, '', '', ''),
(26, 'text', 'inventory', 'Кол-во на складе', '', 0, 13, 0, '', 0, '', '', ''),
(22, 'richtext', 'demotext', 'Текст вверху', '', 0, 0, 0, '', 0, '', '', '');

REPLACE INTO `{PREFIX}site_tmplvar_contentvalues` (`id`, `tmplvarid`, `contentid`, `value`) VALUES
(1, 22, 1, '<p>Добро пожаловать на демонстрационный сайт модуля <b>TSVshop</b> для создания интернет-магазина в CMS MODx. Помните, что вся предоставленная информация на сайте имеет исключительно демонстрационный характер. Все заказы, сделанные вами, будут игнорироваться.</p>\r\n<p>Ниже представлен каталог тестовых товаров, сформированных с помощью сниппета <strong>Ditto</strong>. </p>\r\n<p>Обратите внимание на 2 момента!</p>\r\n<ul>\r\n<li>Выбор любой характеристики товара влияет на его конечную стоимость.</li>\r\n<li>В зависимости от выбранного количества товара меняется его стоимость.</li>\r\n</ul>'),
(2, 22, 2, '<p>Вы находитесь на странице со списком выбранных вами товаров. Проверьте, все ли верно. Для того, чтобы оформить покупку, нажмите на кнопку <strong>Оформить заказ</strong></p>'),
(3, 22, 4, '[!TSVshop? &amp;act=`finish`!]'),
(4, 22, 7, '<p>Ниже вашему вниманию представлен каталог тестовых товаров, сформированных с помощью сниппета <strong>Ditto</strong>. </p>'),
(5, 25, 10, 'assets/images/toshiba-37-regza-lcd-37xv500pg.127701.2.jpg'),
(6, 23, 10, 'radio==Диагональ:*14==2||16==3||18==4;'),
(7, 24, 10, 'Т120'),
(8, 21, 10, '1-2==21490||3-4==21000||20800'),
(9, 25, 11, '/assets/templates/demoshop/img/tovar.jpg'),
(10, 23, 11, 'select==Цвет:*Белый==0||Серый==2||Черный==3;'),
(11, 24, 11, 'М120'),
(12, 21, 11, '13000');

REPLACE INTO `{PREFIX}site_tmplvar_templates` (`tmplvarid`, `templateid`, `rank`) VALUES
(25, 11, 0),
(24, 11, 0),
(23, 11, 0),
(21, 11, 0),
(22, 12, 0),
(22, 13, 0),
(22, 14, 0);