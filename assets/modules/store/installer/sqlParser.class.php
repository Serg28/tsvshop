<?php

// MySQL Dump Parser
// SNUFFKIN/ Alex 2004

class SqlParser {
	var $host, $dbname, $prefix, $user, $password, $mysqlErrors;
	var $conn, $installFailed, $sitename, $adminname, $adminemail, $adminpass, $managerlanguage;
	var $mode, $fileManagerPath, $imgPath, $imgUrl;
	var $dbMODx, $dbVersion;
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

/*
	function SqlParser($host, $user, $password, $db, $prefix='modx_', $adminname, $adminemail, $adminpass, $connection_charset= 'utf8', $managerlanguage='english', $connection_method = 'SET CHARACTER SET', $auto_template_logic = 'parent') {
		$this->host = $host;
		$this->dbname = $db;
		$this->prefix = $prefix;
		$this->user = $user;
		$this->password = $password;
		$this->adminpass = $adminpass;
		$this->adminname = $adminname;
		$this->adminemail = $adminemail;
		$this->connection_charset = $connection_charset;
		$this->connection_method = $connection_method;
		$this->ignoreDuplicateErrors = false;
		$this->managerlanguage = $managerlanguage;
        $this->autoTemplateLogic = $auto_template_logic;
	}
*/
	function connect() {
		$this->conn = mysqli_connect($this->host, $this->user, $this->password);
		mysqli_select_db($this->conn, $this->dbname);
		if (function_exists('mysqli_set_charset')) mysqli_set_charset($this->conn, $this->connection_charset);

		$this->dbVersion = 3.23; // assume version 3.23
		if(function_exists("mysqli_get_server_info")) {
			$ver = mysqli_get_server_info($this->conn);
			$this->dbMODx 	 = version_compare($ver,"4.0.2");
			$this->dbVersion = (float) $ver; // Typecasting (float) instead of floatval() [PHP < 4.2]
		}

        mysqli_query($this->conn,"{$this->connection_method} {$this->connection_charset}");
	}

	function process($filename) {
	    global $custom_placeholders;

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

		// check if in upgrade mode
		if ($this->mode=="upd") {
			// remove non-upgradeable parts
			$s = strpos($idata,"non-upgrade-able[[");
			$e = strpos($idata,"]]non-upgrade-able")+17;
			if($s && $e) $idata = str_replace(substr($idata,$s,$e-$s)," Removed non upgradeable items",$idata);
		}
    
    //content
    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_content WHERE `pagetitle` LIKE 'Главная демо-сайта'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_MAIN=!empty($rid)?$rid:331;    
    
    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_content WHERE `pagetitle` LIKE 'Мой кабинет (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_KABINET=!empty($rid)?$rid:336; 

    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_content WHERE `pagetitle` LIKE 'Корзина (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_CART=!empty($rid)?$rid:332; 

    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_content WHERE `pagetitle` LIKE 'Оформление покупки (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_CHECKOUT=!empty($rid)?$rid:333; 
    
    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_content WHERE `pagetitle` LIKE 'Спасибо за покупку (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_FINISH=!empty($rid)?$rid:334;     
    
    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_content WHERE `pagetitle` LIKE 'О сайте (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_ABOUT=!empty($rid)?$rid:335;  

    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_content WHERE `pagetitle` LIKE 'Каталог товаров (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_CATALOG=!empty($rid)?$rid:337;      
    
    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_content WHERE `pagetitle` LIKE 'Бытовая техника (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_TEHN=!empty($rid)?$rid:338;   
    
    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_content WHERE `pagetitle` LIKE 'Канцелярия (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_KANC=!empty($rid)?$rid:339;  
    
    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_content WHERE `pagetitle` LIKE 'Телевизор LCD (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_LCD=!empty($rid)?$rid:400;      

    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_content WHERE `pagetitle` LIKE 'Микроволновка (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_MV=!empty($rid)?$rid:401;       
    
    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_content WHERE `pagetitle` LIKE 'Мои заказы  (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_MZ=!empty($rid)?$rid:402;  
    
    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_content WHERE `pagetitle` LIKE 'Просмотр заказа  (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_VZ=!empty($rid)?$rid:403; 
    
    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_content WHERE `pagetitle` LIKE 'Редактирование профиля  (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_RP=!empty($rid)?$rid:404;     
    
          
		
		//templates
    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_templates WHERE `templatename` LIKE 'Карточка товара (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_templates order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TEMPLATE_ITEM=!empty($rid)?$rid:101;
    
    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_templates WHERE `templatename` LIKE 'Основной (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_templates order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TEMPLATE_MAIN=!empty($r['id'])?$r['id']:102;
    
    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_templates WHERE `templatename` LIKE 'Главная (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_templates order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TEMPLATE_INDX=!empty($r['id'])?$r['id']:103;
    
    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_templates WHERE `templatename` LIKE 'Корзина (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_templates order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TEMPLATE_CART=!empty($r['id'])?$r['id']:104;
		
    //TV
		$r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_tmplvars WHERE `name`='price'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_tmplvars order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TV_PRICE=!empty($r['id'])?$r['id']:201;
    
		$r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_tmplvars WHERE `name`='demotext'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_tmplvars order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TV_REDIT=!empty($r['id'])?$r['id']:202;
    
		$r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_tmplvars WHERE `name`='tsvshop_param'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_tmplvars order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TV_TMINI=!empty($r['id'])?$r['id']:203;
    
		$r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_tmplvars WHERE `name`='articul'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_tmplvars order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TV_ARTCL=!empty($r['id'])?$r['id']:204;

		$r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_tmplvars WHERE `name`='cart_icon'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_tmplvars order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TV_IMAGE=!empty($r['id'])?$r['id']:205;

    $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT * FROM {$this->prefix}site_tmplvars WHERE `name`='inventory'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=mysqli_fetch_assoc(mysqli_query($this->conn,"SELECT id FROM {$this->prefix}site_tmplvars order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TV_INVEN=!empty($r['id'])?$r['id']:206;
    
    
    

		// replace {} tags
		$idata = str_replace('{PREFIX}', $this->prefix, $idata);
		$idata = str_replace('{ADMIN}', $this->adminname, $idata);
		$idata = str_replace('{ADMINEMAIL}', $this->adminemail, $idata);
		$idata = str_replace('{ADMINPASS}', $this->adminpass, $idata);
		$idata = str_replace('{IMAGEPATH}', $this->imgPath, $idata);
		$idata = str_replace('{IMAGEURL}', $this->imgUrl, $idata);
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
		/*$idata = str_replace('{VERSION}', $modx_version, $idata);*/

		// Replace custom placeholders 
		foreach($custom_placeholders as $key=>$val) {
			if (strpos($idata, '{'.$key.'}') !== false) {
				$idata = str_replace('{'.$key.'}', $val, $idata);
			}
		}
		
		$sql_array = explode("\n\n", $idata);

		$num = 0;
		foreach($sql_array as $sql_entry) {
			$sql_do = trim($sql_entry, "\r\n; ");

			if (preg_match('/^\#/', $sql_do)) continue;

			// strip out comments and \n for mysql 3.x
			if ($this->dbVersion <4.0) {
				$sql_do = preg_replace("~COMMENT.*[^']?'.*[^']?'~","",$sql_do);
				$sql_do = str_replace('\r', "", $sql_do);
				$sql_do = str_replace('\n', "", $sql_do);
			}


			$num = $num + 1;
			if ($sql_do) mysqli_query($this->conn, $sql_do);
			if(mysqli_error($this->conn)) {
				// Ignore duplicate and drop errors - Raymond
				if ($this->ignoreDuplicateErrors){
					if (mysqli_errno($this->conn) == 1060 || mysqli_errno($this->conn) == 1061 || mysqli_errno($this->conn) == 1062 ||mysqli_errno($this->conn) == 1091) continue;
				}
				// End Ignore duplicate
				$this->mysqlErrors[] = array("error" => mysqli_error($this->conn), "sql" => $sql_do);
				$this->installFailed = true;
			}
		}
	}

	function close() {
		mysqli_close($this->conn);
	}
}

?>
