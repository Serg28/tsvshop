<?php
define('IN_TSVSHOP_MODE', true);
define('MODX_API_MODE', true);
//define('IN_MANAGER_MODE', true);

if (!defined('DIRECTORY_SEPARATOR')) {
        define('DIRECTORY_SEPARATOR', "/");
    }
    $array     = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));
    $size      = sizeof($array);
    $p1        = array_slice($array, 0, ($size - 4));
    $_api_path = implode(DIRECTORY_SEPARATOR, $p1).DIRECTORY_SEPARATOR;

session_set_cookie_params("", '/');
include_once($_api_path . "/index.php");

$modx->db->connect();
if (empty ($modx->config)) {
    $modx->getSettings();
}


$modx->invokeEvent("OnWebPageInit");

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')) {
    $modx->sendRedirect($modx->config['site_url']);
}
////// для режима менеджера
/*if (IN_MANAGER_MODE != "true" || empty($modx) || !($modx instanceof DocumentParser)) {
    die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODX Content Manager instead of accessing this file directly.");
}
if (!$modx->hasPermission('exec_module')) {
    header("location: " . $modx->getManagerPath() . "?a=106");
}*/
if (!is_array($modx->event->params)) {
    $modx->event->params = array();
}
/*
if (!isset($_SESSION['mgrValidated'])) {
    die();
}
 */

if (!$cache) {
    include_once MODX_BASE_PATH . '/assets/snippets/tsvshop/include/cache.class.php';
    $cache = fileCache::GetInstance(3600, MODX_BASE_PATH . 'assets/cache/');
}
