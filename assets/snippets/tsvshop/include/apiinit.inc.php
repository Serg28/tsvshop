<?php

define('IN_TSVSHOP_MODE', true);
//if (!$_api_path = $_SERVER["DOCUMENT_ROOT"]) {
    if (!defined('DIRECTORY_SEPARATOR')) {
        define('DIRECTORY_SEPARATOR', "/");
    }
    $array     = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
    $size      = sizeof($array);
    $p1        = array_slice($array, 0, ($size - 4));
    $_api_path = implode(DIRECTORY_SEPARATOR, $p1);
//}
$_api_path = $_api_path . "/";

if (file_exists($_api_path . "assets/cache/siteManager.php")) {
    include_once($_api_path . "assets/cache/siteManager.php");
} else {
    define('MGR_DIR', 'manager');
}

global $modx;
require_once($_api_path . MGR_DIR . '/includes/protect.inc.php');
include_once($_api_path . MGR_DIR . '/includes/config.inc.php');
include_once($_api_path . MGR_DIR . '/includes/document.parser.class.inc.php');

function executeDocument($docid = 0) {
    global $modx;
    ob_start();
    $tmp            = $_REQUEST['id']; // save old id
    $_REQUEST['id'] = $docid;
    $modx->executeParser();
    $html           = ob_get_contents();
    ob_end_clean();
    $_REQUEST['id'] = $tmp; // restore old id
    return $html;
}

session_set_cookie_params("", '/');
session_name($site_sessionname);
session_start();
//$modx = new MODxAPI();
$modx                  = new DocumentParser;
$modx->db->connect();
$modx->getSettings();
$modx->minParserPasses = 2;
$modx->invokeEvent("OnWebPageInit");

if (!$cache) {
    include_once MODX_BASE_PATH . '/assets/snippets/tsvshop/include/cache.class.php';
    $cache = fileCache::GetInstance(3600, MODX_BASE_PATH . 'assets/cache/');
}
?>
