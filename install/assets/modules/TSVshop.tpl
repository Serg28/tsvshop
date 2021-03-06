/**
 * TSVshop
 *
 * Модуль управления магазином TSVshop
 *
 * @category	module
 * @version 	5.4.4
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal	@properties
 * @internal	@guid
 * @internal	@dependencies requires files located at /assets/snippets/tsvshop/
 * @internal	@modx_category TSVshop
 * @internal  @installset base, sample
 * @author    Telnij Sergey (Serg24) <tsv.art.com@gmail.com>, Сайт проекта, дополнения, доработка под нужды: http://tsvshop.xyz 
 */


define('IN_TSVSHOP_MODE','true');
//-- get theme
global $theme, $shop_lang, $tables, $addonspath, $basePath, $siteURL, $moduleid, $modulea, $tsvshop, $cache;
define("TSVSHOP_PATH", MODX_BASE_PATH."assets/snippets/tsvshop/");
define("TSVSHOP_URL", MODX_BASE_URL."assets/snippets/tsvshop/");
define("TSVSHOP_SURL", MODX_SITE_URL."assets/snippets/tsvshop/");
$tb_prefix = $modx->db->config['table_prefix'];
$theme = $modx->db->select('setting_value', '`' . $tb_prefix . 'system_settings`', 'setting_name=\'manager_theme\'', '');
$theme = $modx->db->getRow($theme);
$theme = ($theme['setting_value'] <> '') ? '/' . $theme['setting_value'] : '';
$moduletheme = ($modx->config['manager_theme'] != 'default') ? 'base' : $modx->config['manager_theme'];
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
if (file_exists($basePath.MGR_DIR.'/includes/protect.inc.php')) {
	require_once ($basePath.MGR_DIR.'/includes/protect.inc.php');
} else {
	require_once ($basePath.'core/includes/protect.inc.php');
}
if (!file_exists(TSVSHOP_PATH.'include/config.inc.php')) {
	rename(TSVSHOP_PATH.'include/config.inc.blank.php', TSVSHOP_PATH.'include/config.inc.php');
}
if (!file_exists(TSVSHOP_PATH.'js/config.js')) {
	rename(TSVSHOP_PATH.'js/config.blank.js', TSVSHOP_PATH.'js/config.js');
}
include_once (TSVSHOP_PATH.'include/config.inc.php');
include_once (TSVSHOP_PATH.'admin/includes/core.inc.php');
if (file_exists(TSVSHOP_PATH.'include/version.inc.php')) {
   include_once (TSVSHOP_PATH.'include/version.inc.php');
}

if (!$cache) {
    include_once $basePath . 'assets/snippets/tsvshop/include/cache.class.php';
    $cache = fileCache::GetInstance(3600,MODX_BASE_PATH.'assets/cache/');
}

//запуск печати накладной
if(!empty($_GET['i']) && !empty($_GET['act']) && $_GET['act']=='printorder') {
	$tsvshop = $cache->cache('tsvshop','tsvshop');
    //шаблон можно переопределить, задав его здесь в $tplprintorder
    //т.е. $tplprintorder='файл шаблона/имя чанка';
    require_once(TSVSHOP_PATH.'addons/sales/includes/printorder.php');
	exit;
}


if (!$folders = $cache->cache('folders','tsvshop')) {
  $folders = scandir($addonspath,1);
  //выставляем аддон Заказы первым в списке
  $sales = array_search('sales', $folders);
  if ($sales!=0) {
   $folders[$sales] = $folders[0];
   $folders[0] = 'sales';
  }
  $cache->cache('folders','tsvshop',$folders);
}

//$folders=array_reverse($folders,true);
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
if (!isset($tsvshop['addons_config_active'])) $output.=notice($shop_lang['config_noconfig'], 'error');
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


