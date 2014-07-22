<?php
global $modx, $session, $tsvshop, $shop_lang, $folders, $tables;

include_once ('cache.class.php');
include_once ('apiinit.inc.php');
$charset=$modx->config['modx_charset'];
$charset=(isset($charset))?$charset:"utf-8";
header('Content-type: text/html; charset='.$charset);
$cache 	= fileCache::GetInstance(3600, $_api_path . 'assets/cache/');
if (!$tsvshop = $cache->cache('tsvshop','tsvshop')) {$tsvshop['lang']="russian-UTF8";};

include_once ($_api_path.'assets/snippets/tsvshop/lang/'.$tsvshop['lang'].'.inc.php');
include_once ($_api_path.'assets/snippets/tsvshop/admin/includes/core.inc.php');
include_once ($_api_path.'assets/snippets/tsvshop/include/cart.inc.php');
include_once ($_api_path.'assets/snippets/tsvshop/include/config.inc.php');
$modx->config['base_path'] = $tsvshop['basePath'];
$modx->config['modx_charset'] = $tsvshop['charset'];
define("TSVSHOP_PATH", MODX_BASE_PATH."assets/snippets/tsvshop/");
define("TSVSHOP_URL", MODX_BASE_URL."assets/snippets/tsvshop/");
define("TSVSHOP_SURL", MODX_SITE_URL."assets/snippets/tsvshop/");

$mode 	= _filter($_REQUEST['mode']);
$idnum	= _filter(intval($_REQUEST['idnum']));
$name	= _filter($_REQUEST['name']);
$price	= _filter($_REQUEST['price']);
$icon	= _filter($_REQUEST['icon']);
$opt	= _filter($_REQUEST['opt']);
$qty	= ($q=_filter($_REQUEST['qty'])) ? $q : 1;
$typeitem  = ($t=_filter($_REQUEST['typeitem'])) ? $t : 'physical';
//$url	= ($u = _filter($_REQUEST['url'])) ? $u : "&tovar=".$idnum;
//$url	= ($tsvshop['TypeCat']=='docs' || empty($tsvshop['TypeCat'])) ? $modx->makeUrl($idnum) : "&tovar=".$idnum;
$url	= $idnum;
$addonspath = TSVSHOP_PATH."addons/";

if (!$folders = $cache->cache('folders','tsvshop')) {
  $folders = scandir($addonspath,1);
  $cache->cache('folders','tsvshop',$folders);
}

foreach ($folders as $folder) {
         if ($folder != "."  && $folder != ".." ) {
                 $file = $addonspath.$folder.'/includes/functions.inc.php';
                 $langfile = $addonspath.$folder.'/lang/'.$tsvshop['lang'].'.inc.php';
                 if ($tsvshop['addons_'.$folder.'_active']=="yes") {
                     if (file_exists($file) && file_exists($langfile)) {
                         require_once($file);
                         require_once($langfile);
                         if (sizeof($tsvshop['cf_'.$folder])>0) {
                            if (!is_array($tsvshop['customfields'])) {$tsvshop['customfields']=explode(',',$tsvshop['customfields']);}
                            $tsvshop['customfields'] = array_merge($tsvshop['customfields'],$tsvshop['cf_'.$folder]);
                         }
                     }
                 }
         }
}

switch ($mode) {
    case 'additem':
        $output = tsv_add_item($cache, $idnum, $name, $opt, $icon, $qty, $url, $typeitem); break;
    case 'getprice':
        tsv_get_price($cache, $idnum); break;
    case 'clear':
        tsv_clear_cart(); break;
    case 'info':
        //echo tsv_display_infoblock($cache); break;
        $output = $modx->parseDocumentSource(tsv_display_infoblock($cache)); break;
    case 'basket':
        $output = tsv_display_cart($cache, "basket"); break;
    case 'checkout':
        $output = tsv_display_cart($cache, "checkout"); break;
    case 'recalc':
        //echo tsv_display_cart($cache, "checkout"); break;
        $output = $modx->parseDocumentSource(tsv_display_cart($cache, "checkout")); break;
}


//added by Dmi3yy
$modx->minParserPasses=2;
$output = $modx->mergeSettingsContent($output);
$output = $modx->mergeChunkContent($output);
$output = $modx->evalSnippets($output);
$output = $modx->rewriteUrls($output);
//end added by Dmi3yy
echo $output;

//tsv_minregjs();

?>

