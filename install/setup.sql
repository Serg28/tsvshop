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
  PRIMARY KEY  (`numorder`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `{PREFIX}shop_order_detail` (
  `id`  int(255) NOT NULL AUTO_INCREMENT,
  `numorder` int(11) NOT NULL default '0',
  `quantity` text NOT NULL,
  `price` text NOT NULL,
  `articul` text NOT NULL,
  `name` text NOT NULL,
  `url` varchar(125) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `options` varchar(200) NOT NULL,
  `typeitem` varchar(10) NOT NULL DEFAULT 'physical',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `{PREFIX}shop_numorder` (
  `numorder` int(11) NOT NULL,
  `key` int(11) NOT NULL,
  PRIMARY KEY  (`numorder`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `{PREFIX}shop_conf` (
  `module` varchar(32) NOT NULL DEFAULT '',
  `name` varchar(32) NOT NULL DEFAULT '',
  `value` blob NOT NULL,
  `exported` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`module`,`name`)
) ENGINE=MyISAM;


REPLACE INTO `{PREFIX}shop_conf` VALUES ('MySQL', 'Prefix', '{PREFIX}', 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('MySQL', 'Server', '{DBHOST}', 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('MySQL', 'User', '{DBUSER}', 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('MySQL', 'Pass', '{DBPASS}', 1);

REPLACE INTO `{PREFIX}shop_conf` VALUES ('MySQL', 'DB', '{DBNAME}', 1);

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

REPLACE INTO `{PREFIX}categories` (`id`, `category`) VALUES (8, 'TSVshop');

REPLACE INTO `{PREFIX}site_tmplvars` 	(`id`,			`type`,			`name`, 			`caption`, 			`description`, `editor_type`, `category`, `locked`, `elements`, `rank`, `display`, `display_params`, `default_text`) VALUES
										({TV_IMAGE}, 	'image', 		'cart_icon', 		'Картинка товара', 	'Выводится в каталоге, корзине и инфоблоке', 0, 8, 0, '', 0, '', '', ''),
										({TV_TMINI}, 	'textareamini',	'tsvshop_param', 	'Параметры товара',	'Дополнительные параметры товара, влияющие на цену', 0, 8, 0, '', 0, '', '', ''),
										({TV_ARTCL}, 	'text', 		'articul', 			'Артикул', 			'Артикул товара', 0, 8, 0, '', 0, '', '', ''),
										({TV_PRICE}, 	'text', 		'price', 			'Цена товара', 		'Параметр <b>обязателен</b>', 0, 8, 0, '', 0, '', '', ''),
		    ({TV_INVEN}, 'text', 'inventory', 'Кол-во на складе', '', 0, 8, 0, '', 0, '', '', ''),
										({TV_REDIT}, 	'richtext', 	'demotext', 			'Текст вверху', 	'', 0, 0, 0, '', 0, '', '', '');

