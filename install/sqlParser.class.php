<?php

// MySQL Dump Parser
// SNUFFKIN/ Alex 2004

class SqlParser {
	var $host, $dbname, $prefix, $user, $password, $mysqlErrors;
	var $conn, $installFailed, $sitename, $adminname, $adminemail, $adminpass, $managerlanguage;
	var $mode, $fileManagerPath, $imgPath, $imgUrl;
	var $dbVersion;
    var $connection_charset, $connection_method;
    
    var $TEMPLATE_ITEM, $TEMPLATE_MAIN, $TEMPLATE_INDX, $TEMPLATE_CART;
    var $TV_PRICE, $TV_REDIT, $TV_TMINI, $TV_ARTCL, $TV_IMAGE, $TV_INVEN;

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

	function connect() {
		$this->conn = mysql_connect($this->host, $this->user, $this->password);
		mysql_select_db($this->dbname, $this->conn);

		$this->dbVersion = 3.23; // assume version 3.23
		if(function_exists("mysql_get_server_info")) {
			$ver = mysql_get_server_info();
			$this->dbMODx 	 = version_compare($ver,"4.0.2");
			$this->dbVersion = (float) $ver; // Typecasting (float) instead of floatval() [PHP < 4.2]
		}

        mysql_query("{$this->connection_method} {$this->connection_charset}");
	}

	function process($filename) {
	    global $modx_version;

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
		
		//$r=mysql_fetch_assoc(mysql_query("SELECT * FROM {$this->prefix}site_templates WHERE `name` LIKE 'Карточка товара'"));
    $r=mysql_fetch_assoc(mysql_query("SELECT * FROM {$this->prefix}site_templates WHERE `templatename` LIKE 'Карточка товара'"));
		$this->TEMPLATE_ITEM=!empty($r['id'])?$r['id']:101;
		//$r=mysql_fetch_assoc(mysql_query("SELECT * FROM {$this->prefix}site_templates WHERE `name` LIKE 'Основной'"));
    $r=mysql_fetch_assoc(mysql_query("SELECT * FROM {$this->prefix}site_templates WHERE `templatename` LIKE 'Основной'"));
		$this->TEMPLATE_MAIN=!empty($r['id'])?$r['id']:102;
		//$r=mysql_fetch_assoc(mysql_query("SELECT * FROM {$this->prefix}site_templates WHERE `name` LIKE 'Главная'"));
    $r=mysql_fetch_assoc(mysql_query("SELECT * FROM {$this->prefix}site_templates WHERE `templatename` LIKE 'Главная'"));
		$this->TEMPLATE_INDX=!empty($r['id'])?$r['id']:103;
		//$r=mysql_fetch_assoc(mysql_query("SELECT * FROM {$this->prefix}site_templates WHERE `name` LIKE 'Корзина'"));
    $r=mysql_fetch_assoc(mysql_query("SELECT * FROM {$this->prefix}site_templates WHERE `templatename` LIKE 'Корзина'"));
		$this->TEMPLATE_CART=!empty($r['id'])?$r['id']:104;
		
		$r=mysql_fetch_assoc(mysql_query("SELECT * FROM {$this->prefix}site_tmplvars WHERE `name`='price'"));
		$this->TV_PRICE=!empty($r['id'])?$r['id']:201;
		$r=mysql_fetch_assoc(mysql_query("SELECT * FROM {$this->prefix}site_tmplvars WHERE `name`='text'"));
		$this->TV_REDIT=!empty($r['id'])?$r['id']:202;
		$r=mysql_fetch_assoc(mysql_query("SELECT * FROM {$this->prefix}site_tmplvars WHERE `name`='tsvshop_param'"));
		$this->TV_TMINI=!empty($r['id'])?$r['id']:203;
		$r=mysql_fetch_assoc(mysql_query("SELECT * FROM {$this->prefix}site_tmplvars WHERE `name`='articul'"));
		$this->TV_ARTCL=!empty($r['id'])?$r['id']:204;
		$r=mysql_fetch_assoc(mysql_query("SELECT * FROM {$this->prefix}site_tmplvars WHERE `name`='cart_icon'"));
		$this->TV_IMAGE=!empty($r['id'])?$r['id']:205;
    $r=mysql_fetch_assoc(mysql_query("SELECT * FROM {$this->prefix}site_tmplvars WHERE `name`='inventory'"));
		$this->TV_INVEN=!empty($r['id'])?$r['id']:206;      


		// replace {} tags
		$idata = str_replace('{PREFIX}', $this->prefix, $idata);
		$idata = str_replace('{DBHOST}', $this->host, $idata);
		$idata = str_replace('{DBUSER}', $this->user, $idata);
		$idata = str_replace('{DBPASS}', $this->password, $idata);
		$idata = str_replace('{DBNAME}', $this->dbname, $idata);
		$idata = str_replace('{ADMIN}', $this->adminname, $idata);
		$idata = str_replace('{ADMINEMAIL}', $this->adminemail, $idata);
		$idata = str_replace('{ADMINPASS}', $this->adminpass, $idata);
		$idata = str_replace('{IMAGEPATH}', $this->imagePath, $idata);
		$idata = str_replace('{IMAGEURL}', $this->imageUrl, $idata);
		$idata = str_replace('{FILEMANAGERPATH}', $this->fileManagerPath, $idata);
		$idata = str_replace('{MANAGERLANGUAGE}', $this->managerlanguage, $idata);
		$idata = str_replace('{AUTOTEMPLATELOGIC}', $this->autoTemplateLogic, $idata);
		
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
			if ($sql_do) mysql_query($sql_do, $this->conn);
			if(mysql_error()) {
				// Ignore duplicate and drop errors - Raymond
				if ($this->ignoreDuplicateErrors){
					if (mysql_errno() == 1060 || mysql_errno() == 1061 || mysql_errno() == 1091) continue;
				}
				// End Ignore duplicate
				$this->mysqlErrors[] = array("error" => mysql_error(), "sql" => $sql_do);
				$this->installFailed = true;
			}
		}
	}

	function close() {
		mysql_close($this->conn);
	}
}

?>

