<?php
if(IN_MANAGER_MODE!="true") die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODx Content Manager instead of accessing this file directly.");
$output.= '<div class="tab-page" id="ShopSales">';
$output.= '<h2 class="tab">'.$shop_lang['sales_title'].'</h2>';
$output.= '<p><img src="'.TSVSHOP_SURL.'addons/sales/img/cart.png" alt="'.$shop_lang['sales_title'].'" class="icon" style="vertical-align: middle; text-align: left; " />'.$shop_lang['sales_intro'];

$output.= '<ul class="actionButtons">';
if ($_GET['act']=='vieworder') { 
  $output.= '<li id="Button1"><a href="index.php?a='.$modulea.'&id='.$moduleid.'" ><img src="'.TSVSHOP_SURL.'addons/sales/img/back.png"> '.$shop_lang['sales_back'].'</a></li>';
}
$output.= '<li id="Button1"><a href="javascript:void(0)" onclick=\'window.location.reload(true);\'><img src="media/style'.$theme.'/images/icons/refresh.png"> '.$shop_lang['refresh'].'</a></li>';
$res = $modx->db->select("*", $tsvshop['dborders'], '','numorder desc');
if ($modx->db->getRecordCount($res) >= 1 && $_GET['act']!='vieworder') { 
  $output.='<li id="Button1"><a href="index.php?a='.$modulea.'&id='.$moduleid.'&act=clearorders"><img src="media/style'.$theme.'/images/icons/delete.png"> '.$shop_lang['sales_delete_all'].'</a></li><li id="Button1"><a href="#" onclick=\'document.getElementById("check_del").submit();return false;\'><img src="media/style'.$theme.'/images/icons/delete.png"> '.$shop_lang['sales_del_checked'].'</a></li>';
}
$output.='</ul>';


//-- тут вывод сообщений
$output.= $snotice;
$output.=vieworder(TSVSHOP_PATH.'addons/sales/tpl/orderview.tpl');
if ($_GET['act']!='vieworder') {
  $output.= parsetable($res,TSVSHOP_PATH.'addons/sales/tpl/saletable.tpl');
  $output.= '<script src="'.TSVSHOP_SURL.'addons/sales/js/script.js" language="javascript" type="text/javascript"></script>';
}
$output.= '</div>';
?>
