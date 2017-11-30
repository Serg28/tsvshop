<?php
if (!IN_TSVSHOP_MODE) {die();}
defined('IN_TSVSHOP_MODE') or die();

//include ($modx->config['base_path']."assets/snippets/tsvshop/include/config.inc.php");
$checkid = isset($checkid) ? $checkid : '';
$finid = isset($finid) ? $finid : $modx->documentIdentifier;
$basketid = isset($basketid) ? $basketid : '';
$backid = !empty($backid) ? $backid : $modx->documentIdentifier;
$actions = !empty($actions) ? $actions : '';
$type = !empty($type) ? $type : 'full';
$tsvshop['backid'] = $backid;

$tsvshop['maxpr'] = 100; // сколько наименований товаров можно положить в корзину
$tsvshop['charset'] = $modx->config['modx_charset']; //кодировка письма
$tsvshop['youremail'] = !empty($youremail) ? $youremail : $modx->config['emailsender'];

$tsvshop['SmtpFromEmail'] = (empty($tsvshop['SmtpFromEmail'])) ? $tsvshop['youremail'] : $tsvshop['SmtpFromEmail'];

$tsvshop['debug'] = !empty($debug) ? $debug : false;
$tsvshop['lang'] = !empty($lang) ? $lang : $modx->config['manager_language']; // язык системы
$tsvshop['act'] = !empty($act) ? $act : "basket"; // определяем действие, иначе "Корзина"
$tsvshop['actions'] = $actions;
$tsvshop['tb_prefix'] = $modx->db->config['table_prefix'];
$tsvshop['basePath'] = $modx->config['base_path'];
$tsvshop['siteURL'] = $modx->config['site_url'];
if (!empty($checkid)) {$tsvshop['checkurl'] = $modx->makeUrl($checkid);} //  урл оформления покупки
$tsvshop['finurl'] = $modx->makeUrl($finid);
if (!empty($basketid)) {$tsvshop['basketurl'] = $modx->makeUrl($basketid);}
$tsvshop['selfurl'] = $modx->makeUrl($modx->documentIdentifier);
$tsvshop['backurl'] = $modx->makeUrl($backid);
$tsvshop['hideon'] = !empty($hideon) ? explode(",",$hideon) : array();
// Templates
$tsvshop['tplcart'] = !empty($tplcart) ? $tplcart : "Shop_Cart";
$tsvshop['tplfullcheckout'] = !empty($tplfullcheckout) ? $tplfullcheckout : "Shop_FullCheckout";
$tsvshop['tplcartempty'] = !empty($tplcartempty) ? $tplcartempty : "Shop_Cart_Empty";
$tsvshop['tplcheckout'] = !empty($tplcheckout) ? $tplcheckout : "Shop_Checkout";
$tsvshop['tplprintorder'] = !empty($tplprintorder) ? $tplprintorder : "Shop_PrintOrder";
$tsvshop['tplinfoblock'] = !empty($tplinfoblock) ? $tplinfoblock : "Shop_Infoblock";
$tsvshop['tpluserform'] = !empty($tpluserform) ? $tpluserform : "Shop_UserForm";
$tsvshop['tplmailadmin'] = !empty($tplmailadmin) ? $tplmailadmin : "Shop_mail_admin";
$tsvshop['tplmailklient'] = !empty($tplmailklient) ? $tplmailklient : "Shop_mail_klient";
$tsvshop['tplsuccess'] = !empty($tplsuccess) ? $tplsuccess : "Shop_FinishText";
$tsvshop['tplmailupdateorder'] = !empty($tplmailupdateorder) ? $tplmailupdateorder : "Shop_UpdateOrder";
$tsvshop['namesource'] = !empty($namesource) ? $namesource : 'pagetitle';
$tsvshop['tvs'] = !empty($tvs) ? explode(",",$tvs) : '';  //список TV-параметров, которые нужно вывести для товара
//$tsvshop['tvToDB'] = ($tvToDB=='false' || empty($tvToDB)) ? false : true; // добавлять ли эти TV в базу данных при сохранении заказа
if (file_exists(TSVSHOP_PATH.'include/version.inc.php')) {
   include_once (TSVSHOP_PATH.'include/version.inc.php');
}

// для совместимости в версиями 5.0 и ранее
$table = $modx->getFullTableName( 'shop_order_detail');
  //if (!$modx->db->query("SELECT typeitem FROM  ".$table." WHERE 0")){
  if ($modx->db->getRecordCount($modx->db->query("show columns FROM ".$table." where `Field` = 'typeitem'"))==0) {
    $res1=$modx->db->query("ALTER TABLE  ".$table." ADD  `typeitem` varchar(10) NOT NULL DEFAULT 'physical'");
  }



// DB
$tsvshop['customfields'] = !empty($customfields) ? explode(",",$customfields) : array(); // кастомные поля для таблицы заказов

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
                         $jsfunc = 'addons/'.$folder.'/js/funct.js';
                         if (file_exists(TSVSHOP_PATH.$jsfunc)) {tsv_jsadd($jsfunc); /*$modx->regClientStartupScript($jsfunc);*/}
                         if (sizeof($tsvshop['cf_'.$folder])>0) {
                            $tsvshop['customfields'] = array_merge($tsvshop['customfields'],$tsvshop['cf_'.$folder]);
                         }
                     }
                 }
         }
}

$cache->cache('tsvshop','tsvshop',$tsvshop);

$a=_filter($_GET['a']);

$idnum	= _filter($_REQUEST['idnum']);
$name	= _filter($_REQUEST['name']);
$price	= _filter($_REQUEST['price']);
$icon	= _filter($_REQUEST['icon']);
$opt	= _filter($_REQUEST['opt']);
$qty	= ($q=_filter($_REQUEST['qty'])) ? $q : 1;
$typeitem  = ($t=_filter($_REQUEST['typeitem'])) ? $t : 'physical';
$url = $idnum;
include_once (TSVSHOP_PATH.'lang/'.$tsvshop['lang'].'.inc.php');

// Служебные скрипты
$src = "<script type='text/javascript'>var TSVSHOP_URL = '".TSVSHOP_URL."'</script>";
$modx->regClientStartupScript($src);
tsv_jsadd("lang/".$tsvshop['lang'].".js");
tsv_jsadd("js/config.js");
tsv_jsadd("js/tsvshop.js");
$modx->regClientCSS(TSVSHOP_SURL."shop.css");

if ($act == "itemcard") {
    $dparam     = $modx->getTemplateVar('tsvshop_param', '*', $modx->documentIdentifier);
    $dprice     = $modx->getTemplateVar('price', '*', $modx->documentIdentifier);
	  $price = $formula = $dprice['value'];

    $evt = $modx->invokeEvent("TSVshopOnGetPriceItemCard",array("itemid" => $modx->documentIdentifier,"type" => $tsvshop['TypeCat'], 'price'=>$price));

	  if (is_array($evt) && !empty($evt[0])) {
		  $price = tsv_PriceFormat($evt[0]);
		  $formula = $price;
	  }
    $price = tsv_PriceFormat(tsv_CalcPrice($price, 1, tsv_parseOptions($dparam['value'])));


    $vars = $modx->getTemplateVarOutput(array('typeitem','cart_icon'),$modx->documentIdentifier);

    $modx->setPlaceholder('tsvoptions',$modx->runSnippet('TSVshop_options',array('docid'=>$modx->documentIdentifier)));
    $modx->setPlaceholder('tsvservices','<input type="hidden" name="formula" value="'.$vars['price'].'" /><input type="hidden" name="cart_icon" value="'.$vars['cart_icon'].'" /><script type="text/javascript">Ucalc("'.$modx->documentIdentifier.'")</script>');
    $modx->setPlaceholder('tsvprice','<span id="price'.$modx->documentIdentifier.'" class="tsvprice">'.$vars['price'].'</span>');
    $modx->setPlaceholder('tsvbattr','onkeypress="return testKey(event)" onChange="UserCalc(\''.$modx->documentIdentifier.'\')"');
    $evt = $modx->invokeEvent("TSVshopOnViewItemCard",array("itemid" => $modx->documentIdentifier,"type" => $tsvshop['TypeCat']));

    $modx->setPlaceholder('tsvoptions',$modx->runSnippet('TSVshop_options',array('docid'=>$modx->documentIdentifier)));
    $modx->setPlaceholder('tsvservices','<input type="hidden" name="typeitem" value="'.$vars['typeitem'].'" /><input type="hidden" name="formula" value="'.$formula.'" /><input type="hidden" name="cart_icon" value="[(base_url)]'.$vars['cart_icon'].'" /><script type="text/javascript">Ucalc("'.$modx->documentIdentifier.'")</script>');
    $modx->setPlaceholder('tsvprice','<span id="price'.$modx->documentIdentifier.'">'.$price.'</span>');
    $modx->setPlaceholder('tsvbattr','onkeypress="return testKey(event)" onChange="Ucalc(\''.$modx->documentIdentifier.'\')"');
    $evt = $modx->invokeEvent("TSVshopOnViewItemCard",array("itemid" => $modx->documentIdentifier,"type" => $tsvshop['TypeCat']));
}

if ($act == "info") {
    print '<div id="infoblock_cont">'.tsv_display_infoblock($cache).'</div>';
}


if ($act == "basket") {
    print '<div id="basket_cont">'.tsv_display_cart($cache, "basket").'</div>';
}

if ($act == "checkout_cart") {
//if ($act == "checkout") {
    print '<div id="checkout_cont">'.tsv_display_cart($cache, "checkout").'</div>';
}

if ($act == "checkout_form") {
    print '<div id="checkoutform_cont">'.tsv_display_checkoutform($cache).'</div>';
}

if ($act == "checkout") {
    //print tsv_display_fullcheckout($cache);
    print tsv_display_cart($cache, "fullcheckout");
}

if ($act == "finish") {
    print tsv_display_success($cache);
}

if ($act == "printorder") {
    require_once(TSVSHOP_PATH.'addons/sales/includes/printorder.php');
}

if ($a == "clear" ) {
    tsv_clear_cart();
}

if ($a == "del" ) {
    tsv_delete_item(_filter(intval($_GET['num'])));
}

if ($a == "add" ) {
        tsv_add_item($cache, $idnum, $name, $opt, $icon, $qty, $url, $typeitem);
}

if ($a == "chq" ) {
        tsv_modify_quantity(_filter(intval($_GET['num'])), _filter(floatval($_GET['qnt'])));
}
?>
