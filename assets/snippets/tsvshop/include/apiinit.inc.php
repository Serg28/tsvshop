<?php
define('IN_TSVSHOP_MODE',true);
if (!$_api_path=$_SERVER["DOCUMENT_ROOT"]) {
    if( !defined( 'DIRECTORY_SEPARATOR' ) ) {
       define( 'DIRECTORY_SEPARATOR', "/" );
    }
    $array=explode(DIRECTORY_SEPARATOR,dirname(__FILE__));
    $size=sizeof($array);
    //$p1=array_slice($array,0,($size-6)); // на некоторых хостингах некорректно определяет путь
    $p1=array_slice($array,0,($size-4)); // работает? нужно проверить, но вроде корректно.
    $_api_path = implode(DIRECTORY_SEPARATOR,$p1);
}
$_api_path = $_api_path."/";

if (file_exists($_api_path."assets/cache/siteManager.php")) {
  include_once($_api_path."assets/cache/siteManager.php");
}else{
  define('MGR_DIR', 'manager');
}

global $modx; 
require_once($_api_path.MGR_DIR.'/includes/protect.inc.php');
include_once($_api_path.MGR_DIR.'/includes/config.inc.php');
include_once($_api_path.MGR_DIR.'/includes/document.parser.class.inc.php');
/*
class MODxAPI extends DocumentParser {

	function MODxAPI() {
		//$this->startSession();
    if (method_exists('DocumentParser', 'DocumentParser')) {
       parent::DocumentParser();
    }  else {
       parent::__construct();
    }

		// set some parser options
		$this->minParserPasses = 1;		// min number of parser recursive loops or passes
		$this->maxParserPasses = 10;	// max number of parser recursive loops or passes
		$this->dumpSQL = false;
		$this->dumpSnippets = false;
    $this->getSettings();
		// set start time
		$this->tstart = $this->getMicroTime();	// feed the parser the execution start time

	}

	// execute parser and return results - To be finalized
	function executeDocument($docid = 0) {
		ob_start();
			ob_start();
				$tmp = $_REQUEST['id']; // save old id
				$_REQUEST['id'] = $docid;
				$this->executeParser();
		$html = ob_get_contents();
		ob_end_clean();
		$_REQUEST['id'] = $tmp; // restore old id
		return $html;
	}

	// connect to MODx database - use $modx->db->query();
	function connect() {
		 $this->db->connect();
	}

	function startSession() {
		startCMSSession();
	}
}
*/
function executeDocument($docid = 0) {
global $modx;
		ob_start();
			ob_start();
				$tmp = $_REQUEST['id']; // save old id
				$_REQUEST['id'] = $docid;
				$modx->executeParser();
		$html = ob_get_contents();
		ob_end_clean();
		$_REQUEST['id'] = $tmp; // restore old id
		return $html;
	}


session_set_cookie_params("",'/');
session_name($site_sessionname);
session_start();
//$modx = new MODxAPI();    
$modx = new DocumentParser;   

?>
