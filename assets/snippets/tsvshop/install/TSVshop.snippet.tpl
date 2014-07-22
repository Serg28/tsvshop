<?php
define("TSVSHOP_PATH", MODX_BASE_PATH."assets/snippets/tsvshop/");
define("TSVSHOP_URL", MODX_BASE_URL."assets/snippets/tsvshop/");
define("TSVSHOP_SURL", MODX_SITE_URL."assets/snippets/tsvshop/");
define("TSVSHOP_PUREPATH", "assets/snippets/tsvshop/");
define('IN_TSVSHOP_MODE','true');

global $cache, $session, $tsvshop, $shop_lang, $tables, $folders, $jsfiles;
$tsvshop = array();
$jsfiles = array();

if (!$cache) {
include_once TSVSHOP_PATH.'include/cache.class.php';
$cache = fileCache::GetInstance(3600,MODX_BASE_PATH.'assets/cache/');
}
include TSVSHOP_PATH."include/config.inc.php";
include_once (TSVSHOP_PATH. 'admin/includes/core.inc.php');
include_once (TSVSHOP_PATH. 'include/cart.inc.php');
include TSVSHOP_PATH."include/tsvshop.inc.php";
session_set_cookie_params("",'/');
session_name($session);
session_start();
tsv_minregjs();
?>
