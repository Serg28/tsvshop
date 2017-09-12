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
    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_content WHERE `pagetitle` LIKE 'Главная демо-сайта'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_MAIN=!empty($rid)?$rid:331;    
    
    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_content WHERE `pagetitle` LIKE 'Мой кабинет (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_KABINET=!empty($rid)?$rid:336; 

    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_content WHERE `pagetitle` LIKE 'Корзина (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_CART=!empty($rid)?$rid:332; 

    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_content WHERE `pagetitle` LIKE 'Оформление покупки (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_CHECKOUT=!empty($rid)?$rid:333; 
    
    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_content WHERE `pagetitle` LIKE 'Спасибо за покупку (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_FINISH=!empty($rid)?$rid:334;     
    
    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_content WHERE `pagetitle` LIKE 'О сайте (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_ABOUT=!empty($rid)?$rid:335;  

    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_content WHERE `pagetitle` LIKE 'Каталог товаров (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_CATALOG=!empty($rid)?$rid:337;      
    
    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_content WHERE `pagetitle` LIKE 'Бытовая техника (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_TEHN=!empty($rid)?$rid:338;   
    
    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_content WHERE `pagetitle` LIKE 'Канцелярия (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_KANC=!empty($rid)?$rid:339;  
    
    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_content WHERE `pagetitle` LIKE 'Телевизор LCD (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_LCD=!empty($rid)?$rid:400;      

    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_content WHERE `pagetitle` LIKE 'Микроволновка (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_MV=!empty($rid)?$rid:401;       
    
    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_content WHERE `pagetitle` LIKE 'Мои заказы  (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_MZ=!empty($rid)?$rid:402;  
    
    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_content WHERE `pagetitle` LIKE 'Просмотр заказа  (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_VZ=!empty($rid)?$rid:403; 
    
    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_content WHERE `pagetitle` LIKE 'Редактирование профиля  (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_content order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->CONTENT_RP=!empty($rid)?$rid:404;     
    
          
		
		//templates
    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_templates WHERE `templatename` LIKE 'Карточка товара (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_templates order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TEMPLATE_ITEM=!empty($rid)?$rid:101;
    
    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_templates WHERE `templatename` LIKE 'Основной (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_templates order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TEMPLATE_MAIN=!empty($r['id'])?$r['id']:102;
    
    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_templates WHERE `templatename` LIKE 'Главная (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_templates order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TEMPLATE_INDX=!empty($r['id'])?$r['id']:103;
    
    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_templates WHERE `templatename` LIKE 'Корзина (демо-сайт)'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_templates order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TEMPLATE_CART=!empty($r['id'])?$r['id']:104;
		
    //TV
		$r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_tmplvars WHERE `name`='price'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_tmplvars order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TV_PRICE=!empty($r['id'])?$r['id']:201;
    
		$r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_tmplvars WHERE `name`='demotext'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_tmplvars order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TV_REDIT=!empty($r['id'])?$r['id']:202;
    
		$r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_tmplvars WHERE `name`='tsvshop_param'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_tmplvars order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TV_TMINI=!empty($r['id'])?$r['id']:203;
    
		$r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_tmplvars WHERE `name`='articul'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_tmplvars order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TV_ARTCL=!empty($r['id'])?$r['id']:204;

		$r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_tmplvars WHERE `name`='cart_icon'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_tmplvars order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TV_IMAGE=!empty($r['id'])?$r['id']:205;

    $r=$modx->db->getRow($modx->db->query("SELECT * FROM {$modx->db->config['table_prefix']}site_tmplvars WHERE `name`='inventory'"));
    if (!empty($r['id'])) {
      $rid = $r['id'];
    } else {
      $r=$modx->db->getRow($modx->db->query("SELECT id FROM {$modx->db->config['table_prefix']}site_tmplvars order by id desc limit 1"));
      $rid = $r['id'];
    }
		$this->TV_INVEN=!empty($r['id'])?$r['id']:206;



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
