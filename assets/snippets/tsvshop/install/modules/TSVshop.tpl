/**
 * TSVshop
 *
 * Модуль управления магазином TSVshop
 *
 * @category	module
 * @version 	5.3
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal	@properties
 * @internal	@guid
 * @internal	@dependencies requires files located at /assets/snippets/tsvshop/
 * @internal	@modx_category TSVshop
 * @internal  @installset base, sample
 * @author    Telnij Sergey (Serg24) <privat_tel@mail.ru>, http://tsvshop.tsv.org.ua, http://tsvshop.xyz 
 */


//define('IN_TSVSHOP_MODE','true');
//-- get theme
global $theme, $shop_lang, $tables, $addonspath, $basePath, $siteURL, $moduleid, $modulea, $tsvshop, $cache;
define("TSVSHOP_PATH", MODX_BASE_PATH."assets/snippets/tsvshop/");
define("TSVSHOP_URL", MODX_BASE_URL."assets/snippets/tsvshop/");
define("TSVSHOP_SURL", MODX_SITE_URL."assets/snippets/tsvshop/");
$tb_prefix = $modx->db->config['table_prefix'];
$theme = $modx->db->select('setting_value', '`' . $tb_prefix . 'system_settings`', 'setting_name=\'manager_theme\'', '');
$theme = $modx->db->getRow($theme);
$theme = ($theme['setting_value'] <> '') ? '/' . $theme['setting_value'] : '';
$basePath = $modx->config['base_path'];
$siteURL = $modx->config['site_url'];
$addonspath = $basePath."assets/snippets/tsvshop/addons/";
$path = $siteURL.MGR_DIR."/index.php"; 
$tables = array(); 
$tsvshop = array();


$moduleid = $_GET['id'];
$modulea = $_GET['a'];
$act = $_GET['act'];
include_once (TSVSHOP_PATH.'admin/lang/' . $modx->config['manager_language'] . '.inc.php');
require_once ($basePath.MGR_DIR.'/includes/protect.inc.php');
include_once (TSVSHOP_PATH.'include/config.inc.php');
include_once (TSVSHOP_PATH.'admin/includes/core.inc.php');
if (file_exists(TSVSHOP_PATH.'include/version.inc.php')) {
   include_once (TSVSHOP_PATH.'include/version.inc.php');
}

if (!$cache) {
    include_once $basePath . 'assets/snippets/tsvshop/include/cache.class.php';
    $cache = fileCache::GetInstance(3600,MODX_BASE_PATH.'assets/cache/');
}


if (!$folders = $cache->cache('folders','tsvshop')) {
  $folders = scandir($addonspath,1);
  $cache->cache('folders','tsvshop',$folders);
}

foreach ($folders as $folder) {
         if ($folder != "."  && $folder != ".." ) {
                 $lfile=$addonspath.$folder.'/lang/' . $modx->config['manager_language'] . '.inc.php';
                 if (file_exists($lfile)) {
                     include_once ($lfile);
                 }
                 $file = $addonspath.$folder.'/includes/functions.inc.php';
                     if (file_exists($file)) {
                         include_once($file);
                     }
         }
}

include_once ($basePath . 'assets/snippets/tsvshop/addons/sales/includes/options.inc.php');

include_once ($basePath . 'assets/snippets/tsvshop/admin/template/header.inc.php');
//top button
include_once ($basePath . 'assets/snippets/tsvshop/admin/template/topbutton.inc.php');
$output.= '
<div class="sectionBody">
    <div class="tab-pane" id="resourcesPane">
        <script type="text/javascript">
        tpResources = new WebFXTabPane( document.getElementById( "resourcesPane" ) );
        </script>';

// выводим аддоны
foreach ($folders as $folder) {
         if ($folder != "."  && $folder != ".." ) {
                 $file = $addonspath.$folder.'/main.inc.php';
                 if (getConf("addons", $folder."_active")=="yes" || $tables[$folder]=="system") {
                     include_once ($addonspath.$folder.'/lang/' . $modx->config['manager_language'] . '.inc.php');
                     if (file_exists($file)) {
                         require_once($file);
                     }
                 }
         }
}

$output.= '</div></div></body></html>';
return $output;


