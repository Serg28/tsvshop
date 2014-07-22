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
$path = $siteURL."manager/index.php"; 
$tables = array(); 
$tsvshop = array();


$moduleid = $_GET['id'];
$modulea = $_GET['a'];
$act = $_GET['act'];
include_once ($basePath . 'assets/snippets/tsvshop/admin/lang/' . $modx->config['manager_language'] . '.inc.php');
require_once ($basePath . 'manager/includes/protect.inc.php');
include_once ($basePath . 'assets/snippets/tsvshop/include/config.inc.php');
include_once ($basePath . 'assets/snippets/tsvshop/admin/includes/core.inc.php');

if (!$cache) {
    include_once $basePath . 'assets/snippets/tsvshop/include/cache.class.php';
    $cache = fileCache::GetInstance(3600,MODX_BASE_PATH.'assets/cache/');
}

//$tsvshop = $cache->cache('tsvshop','tsvshop');
//$tsvshop['SecFields'] = (!is_array($tsvshop['SecFields'])) ? explode(",",$tsvshop['SecFields']) : $tsvshop['SecFields'] ;  // Поля таблицы заказов, которые нужно шифровать паролем

//$folders = scandir($addonspath,1);
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
                 //if (getConf("addons", $folder."_active")) {
                     if (file_exists($file)) {
                         include_once($file);
                     }
                 //}
         }
}

include_once ($basePath . 'assets/snippets/tsvshop/addons/sales/includes/options.inc.php');

include_once ($basePath . 'assets/snippets/tsvshop/admin/template/header.inc.php');
//top button
include_once ($basePath . 'assets/snippets/tsvshop/admin/template/topbutton.inc.php');
$output.= '
<div class="sectionHeader">'.$shop_lang['title'].'</div>
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


