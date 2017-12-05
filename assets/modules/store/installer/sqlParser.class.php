<?php
// MySQL Dump Parser
// SNUFFKIN/ Alex 2004
error_reporting(E_ALL & ~E_NOTICE);
class SqlParser {
	var $host, $dbname, $prefix, $user, $password, $mysqlErrors;
	var $conn, $installFailed, $sitename, $adminname, $adminemail, $adminpass, $managerlanguage;
	var $mode, $fileManagerPath, $imgPath, $imgUrl;
    var $connection_charset, $connection_method;

    var $CONTENT_RP, $CONTENT_VZ, $CONTENT_MZ, $CONTENT_MAIN, $CONTENT_KABINET, $CONTENT_CART, $CONTENT_CHECKOUT, $CONTENT_FINISH, $CONTENT_ABOUT, $CONTENT_CATALOG, $CONTENT_TEHN, $CONTENT_KANC, $CONTENT_LCD, $CONTENT_MV;
    var $TEMPLATE_ITEM, $TEMPLATE_MAIN, $TEMPLATE_INDX, $TEMPLATE_CART;
    var $TV_PRICE, $TV_REDIT, $TV_TMINI, $TV_ARTCL, $TV_IMAGE, $TV_INVEN;

	public function __construct() {
		$adminname='';
		$adminemail=''; 
		$adminpass='';		
		$connection_charset= 'utf8'; 
		$managerlanguage='english'; 
		$connection_method = 'SET CHARACTER SET'; 
		$auto_template_logic = 'parent';
		$this->adminname = $adminname;
		$this->adminemail = $adminemail;
		$this->connection_charset = $connection_charset;
		$this->connection_method = $connection_method;
		$this->ignoreDuplicateErrors = false;
		$this->managerlanguage = $managerlanguage;
        $this->autoTemplateLogic = $auto_template_logic;
	}

	function process($filename) {
	    global $modx_version,$modx;
		
		// check to make sure file exists
		if (!file_exists($filename)) {
			$this->mysqlErrors[] = array("error" => "File '$filename' not found");
			$this->installFailed = true ;
			return false;
		}

		$fh = fopen($filename, 'r');
		$idata = '';

		while (!feof($fh)) {
			$idata .= fread($fh, 1024);
		}

		fclose($fh);
		$idata = str_replace("\r", '', $idata);

		if ($this->mode=="upd") {
			$s = strpos($idata,"non-upgrade-able[[");
			$e = strpos($idata,"]]non-upgrade-able")+17;
			if($s && $e) $idata = str_replace(substr($idata,$s,$e-$s)," Removed non upgradeable items",$idata);
		}



//content
        $ic=1;
        $r = $modx->db->getRow( $modx->db->query( "SELECT * FROM ".$modx->db->config['table_prefix']."site_content WHERE `pagetitle` LIKE 'Главная демо-сайта'"));
        if (!empty($r['id'])) {
            $this->CONTENT_MAIN = $r['id'];
        } else {
            $r                  = $modx->db->getRow( $modx->db->query( "SELECT id+".$ic." as id FROM ".$modx->db->config['table_prefix']."site_content order by id desc limit 1"));
            $this->CONTENT_MAIN = $r['id'];
            $ic++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_content WHERE `pagetitle` LIKE 'Мой кабинет (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->CONTENT_KABINET = $r['id'];
        } else {
            $r                     = $modx->db->getRow($modx->db->query("SELECT id+".$ic." as id FROM ".$modx->db->config['table_prefix']."site_content order by id desc limit 1"));
            $this->CONTENT_KABINET = $r['id'];
            $ic++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_content WHERE `pagetitle` LIKE 'Корзина (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->CONTENT_CART = $r['id'];
        } else {
            $r                  = $modx->db->getRow($modx->db->query("SELECT id+".$ic." as id FROM ".$modx->db->config['table_prefix']."site_content order by id desc limit 1"));
            $this->CONTENT_CART = $r['id'];
            $ic++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_content WHERE `pagetitle` LIKE 'Оформление покупки (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->CONTENT_CHECKOUT = $r['id'];
        } else {
            $r                      = $modx->db->getRow($modx->db->query("SELECT id+".$ic." as id FROM ".$modx->db->config['table_prefix']."site_content order by id desc limit 1"));
            $this->CONTENT_CHECKOUT = $r['id'];
            $ic++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_content WHERE `pagetitle` LIKE 'Спасибо за покупку (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->CONTENT_FINISH = $r['id'];
        } else {
            $r                    = $modx->db->getRow($modx->db->query("SELECT id+".$ic." as id FROM ".$modx->db->config['table_prefix']."site_content order by id desc limit 1"));
            $this->CONTENT_FINISH = $r['id'];
            $ic++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_content WHERE `pagetitle` LIKE 'О сайте (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->CONTENT_ABOUT = $r['id'];
        } else {
            $r                   = $modx->db->getRow($modx->db->query("SELECT id+".$ic." as id FROM ".$modx->db->config['table_prefix']."site_content order by id desc limit 1"));
            $this->CONTENT_ABOUT = $r['id'];
            $ic++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_content WHERE `pagetitle` LIKE 'Каталог товаров (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->CONTENT_CATALOG = $r['id'];
        } else {
            $r                     = $modx->db->getRow($modx->db->query("SELECT id+".$ic." as id FROM ".$modx->db->config['table_prefix']."site_content order by id desc limit 1"));
            $this->CONTENT_CATALOG = $r['id'];
            $ic++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_content WHERE `pagetitle` LIKE 'Бытовая техника (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->CONTENT_TEHN = $r['id'];
        } else {
            $r                  = $modx->db->getRow($modx->db->query("SELECT id+".$ic." as id FROM ".$modx->db->config['table_prefix']."site_content order by id desc limit 1"));
            $this->CONTENT_TEHN = $r['id'];
            $ic++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_content WHERE `pagetitle` LIKE 'Канцелярия (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->CONTENT_KANC = $r['id'];
        } else {
            $r                  = $modx->db->getRow($modx->db->query("SELECT id+".$ic." as id FROM ".$modx->db->config['table_prefix']."site_content order by id desc limit 1"));
            $this->CONTENT_KANC = $r['id'];
            $ic++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_content WHERE `pagetitle` LIKE 'Телевизор LCD (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->CONTENT_LCD = $r['id'];
        } else {
            $r                 = $modx->db->getRow($modx->db->query("SELECT id+".$ic." as id FROM ".$modx->db->config['table_prefix']."site_content order by id desc limit 1"));
            $this->CONTENT_LCD = $r['id'];
            $ic++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_content WHERE `pagetitle` LIKE 'Микроволновка (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->CONTENT_MV = $r['id'];
        } else {
            $r                = $modx->db->getRow($modx->db->query("SELECT id+".$ic." as id FROM ".$modx->db->config['table_prefix']."site_content order by id desc limit 1"));
            $this->CONTENT_MV = $r['id'];
            $ic++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_content WHERE `pagetitle` LIKE 'Мои заказы  (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->CONTENT_MZ = $r['id'];
        } else {
            $r                = $modx->db->getRow($modx->db->query("SELECT id+".$ic." as id FROM ".$modx->db->config['table_prefix']."site_content order by id desc limit 1"));
            $this->CONTENT_MZ = $r['id'];
            $ic++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_content WHERE `pagetitle` LIKE 'Просмотр заказа  (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->CONTENT_VZ = $r['id'];
        } else {
            $r                = $modx->db->getRow($modx->db->query("SELECT id+".$ic." as id FROM ".$modx->db->config['table_prefix']."site_content order by id desc limit 1"));
            $this->CONTENT_VZ = $r['id'];
            $ic++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_content WHERE `pagetitle` LIKE 'Редактирование профиля  (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->CONTENT_RP = $r['id'];
        } else {
            $r                = $modx->db->getRow($modx->db->query("SELECT id+".$ic." as id FROM ".$modx->db->config['table_prefix']."site_content order by id desc limit 1"));
            $this->CONTENT_RP = $r['id'];
        }

        //templates
        $it=1;
        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_templates WHERE `templatename` LIKE 'Карточка товара (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->TEMPLATE_ITEM = $r['id'];
        } else {
            $r                   = $modx->db->getRow($modx->db->query("SELECT id+".$it." as id FROM ".$modx->db->config['table_prefix']."site_templates order by id desc limit 1"));
            $this->TEMPLATE_ITEM = $r['id'];
            $it++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_templates WHERE `templatename` LIKE 'Основной (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->TEMPLATE_MAIN = $r['id'];
        } else {
            $r                   = $modx->db->getRow($modx->db->query("SELECT id+".$it." as id FROM ".$modx->db->config['table_prefix']."site_templates order by id desc limit 1"));
            $this->TEMPLATE_MAIN = $r['id'];
            $it++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_templates WHERE `templatename` LIKE 'Главная (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->TEMPLATE_INDX = $r['id'];
        } else {
            $r                   = $modx->db->getRow($modx->db->query("SELECT id+".$it." as id FROM ".$modx->db->config['table_prefix']."site_templates order by id desc limit 1"));
            $this->TEMPLATE_INDX = $r['id'];
            $it++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_templates WHERE `templatename` LIKE 'Корзина (демо-сайт)'"));
        if (!empty($r['id'])) {
            $this->TEMPLATE_CART = $r['id'];
        } else {
            $r                   = $modx->db->getRow($modx->db->query("SELECT id+".$it." as id FROM ".$modx->db->config['table_prefix']."site_templates order by id desc limit 1"));
            $this->TEMPLATE_CART = $r['id'];
        }

        //TV
        $itv=1;
        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_tmplvars WHERE `name`='price'"));
        if (!empty($r['id'])) {
            $this->TV_PRICE = $r['id'];
        } else {
            $r              = $modx->db->getRow($modx->db->query("SELECT id+".$itv." as id FROM ".$modx->db->config['table_prefix']."site_tmplvars order by id desc limit 1"));
            $this->TV_PRICE = $r['id'];
            $itv++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_tmplvars WHERE `name`='demotext'"));
        if (!empty($r['id'])) {
            $this->TV_REDIT = $r['id'];
        } else {
            $r              = $modx->db->getRow($modx->db->query("SELECT id+".$itv." as id FROM ".$modx->db->config['table_prefix']."site_tmplvars order by id desc limit 1"));
            $this->TV_REDIT = $r['id'];
            $itv++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_tmplvars WHERE `name`='tsvshop_param'"));
        if (!empty($r['id'])) {
            $this->TV_TMINI = $r['id'];
        } else {
            $r              = $modx->db->getRow($modx->db->query("SELECT id+".$itv." as id FROM ".$modx->db->config['table_prefix']."site_tmplvars order by id desc limit 1"));
            $this->TV_TMINI = $r['id'];
            $itv++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_tmplvars WHERE `name`='articul'"));
        if (!empty($r['id'])) {
            $this->TV_ARTCL = $r['id'];
        } else {
            $r              = $modx->db->getRow($modx->db->query("SELECT id+".$itv." as id FROM ".$modx->db->config['table_prefix']."site_tmplvars order by id desc limit 1"));
            $this->TV_ARTCL = $r['id'];
            $itv++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_tmplvars WHERE `name`='cart_icon'"));
        if (!empty($r['id'])) {
            $this->TV_IMAGE = $r['id'];
        } else {
            $r              = $modx->db->getRow($modx->db->query("SELECT id+".$itv." as id FROM ".$modx->db->config['table_prefix']."site_tmplvars order by id desc limit 1"));
            $this->TV_IMAGE = $r['id'];
            $itv++;
        }

        $r = $modx->db->getRow($modx->db->query("SELECT * FROM ".$modx->db->config['table_prefix']."site_tmplvars WHERE `name`='inventory'"));  
        if (!empty($r['id'])) {
            $this->TV_INVEN = $r['id'];
            
        } else {
            $r              = $modx->db->getRow($modx->db->query("SELECT id+".$itv." as id FROM ".$modx->db->config['table_prefix']."site_tmplvars order by id desc limit 1"));
            $this->TV_INVEN = $r['id']; 
        }



		// replace {} tags
		$idata = str_replace('{PREFIX}', $modx->db->config['table_prefix'], $idata);
		$idata = str_replace('{ADMIN}', $this->adminname, $idata);
		$idata = str_replace('{ADMINEMAIL}', $this->adminemail, $idata);
		$idata = str_replace('{ADMINPASS}', $this->adminpass, $idata);
		$idata = str_replace('{IMAGEPATH}', $this->imagePath, $idata);
		$idata = str_replace('{IMAGEURL}', $this->imageUrl, $idata);
		$idata = str_replace('{FILEMANAGERPATH}', $this->fileManagerPath, $idata);
		$idata = str_replace('{MANAGERLANGUAGE}', $this->managerlanguage, $idata);
		$idata = str_replace('{AUTOTEMPLATELOGIC}', $this->autoTemplateLogic, $idata);

$idata = str_replace('{CONTENT_MAIN}',	$this->CONTENT_MAIN, $idata);
		$idata = str_replace('{CONTENT_KABINET}',	$this->CONTENT_KABINET, $idata);
		$idata = str_replace('{CONTENT_CART}',	$this->CONTENT_CART, $idata);
		$idata = str_replace('{CONTENT_CHECKOUT}',	$this->CONTENT_CHECKOUT, $idata);
		$idata = str_replace('{CONTENT_FINISH}',	$this->CONTENT_FINISH, $idata);
		$idata = str_replace('{CONTENT_ABOUT}',	$this->CONTENT_ABOUT, $idata);
		$idata = str_replace('{CONTENT_CATALOG}',	$this->CONTENT_CATALOG, $idata);
		$idata = str_replace('{CONTENT_TEHN}',	$this->CONTENT_TEHN, $idata);
		$idata = str_replace('{CONTENT_KANC}',	$this->CONTENT_KANC, $idata);
		$idata = str_replace('{CONTENT_LCD}',	$this->CONTENT_LCD, $idata);
    $idata = str_replace('{CONTENT_MV}',	$this->CONTENT_MV, $idata);  
    $idata = str_replace('{CONTENT_VZ}',	$this->CONTENT_VZ, $idata);  
    $idata = str_replace('{CONTENT_MZ}',	$this->CONTENT_MZ, $idata);
    $idata = str_replace('{CONTENT_RP}',	$this->CONTENT_RP, $idata);                                                                                 
                                                                                   
		$idata = str_replace('{TEMPLATE_ITEM}',	$this->TEMPLATE_ITEM, $idata);
		$idata = str_replace('{TEMPLATE_MAIN}',	$this->TEMPLATE_MAIN, $idata);
		$idata = str_replace('{TEMPLATE_INDX}',	$this->TEMPLATE_INDX, $idata);
		$idata = str_replace('{TEMPLATE_CART}',	$this->TEMPLATE_CART, $idata);

		$idata = str_replace('{TV_PRICE}',	$this->TV_PRICE, $idata);
		$idata = str_replace('{TV_REDIT}',	$this->TV_REDIT, $idata);
		$idata = str_replace('{TV_TMINI}',	$this->TV_TMINI, $idata);
		$idata = str_replace('{TV_ARTCL}',	$this->TV_ARTCL, $idata);
		$idata = str_replace('{TV_IMAGE}',	$this->TV_IMAGE, $idata);
    $idata = str_replace('{TV_INVEN}',	$this->TV_INVEN, $idata);

		//$idata = str_replace('{VERSION}', $modx_version, $idata);

		$sql_array = explode("\n\n", $idata);

		$num = 0;
		foreach($sql_array as $sql_entry) {
			$sql_do = trim($sql_entry, "\r\n; ");

			if (preg_match('/^\#/', $sql_do)) continue;

			// strip out comments and \n for mysql 3.x
			if ( floatval( $modx->db->getVersion() ) < 4.0 ) {
				$sql_do = preg_replace("~COMMENT.*[^']?'.*[^']?'~","",$sql_do);
				$sql_do = str_replace('\r', "", $sql_do);
				$sql_do = str_replace('\n', "", $sql_do);
			}


			$num = $num + 1;
			if ($sql_do) $modx->db->query($sql_do, false);
		}
		
		
	}
}

?>
