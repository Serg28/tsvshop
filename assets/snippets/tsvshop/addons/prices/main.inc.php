<?php
include_once ($addonspath.'prices/includes/price.inc.php');
$modx->regClientStartupScript('/assets/snippets/tsvshop/addons/prices/js/saveprice.js');
$output.= '<div class="tab-page" id="ShopPrice" width="100%" position="absolute">';
$output.= '<h2 class="tab">'.$shop_lang['prices_title'].'</h2>';
$output.= '<p><img src="'.$siteURL.'assets/snippets/tsvshop/addons/prices/img/price.png" alt="'.$shop_lang['prices_title'].'" class="icon" style="vertical-align: middle; text-align: left; " />'.$shop_lang['prices_intro'];
$output.= '
<br /><div width="100%">
<table border="0">
            <tr><td>';
$output.= "<form action='index.php'>";
$output.= '<ul class="actionButtons">
                <li id="Button1"><a href="index.php?a=112&id=' . $moduleid . '"><img src="media/style'.$theme.'/images/icons/refresh.png"> '.$shop_lang['refresh'].'</a></li>
                <li id="Button1"><a href="#" onclick="get2(this.form);"><img src="media/style'.$theme.'/images/icons/save.png"> '.$shop_lang['save'].'</a></li>
            </ul>';
if ($output_notice<>"") $output.= '<div class="notice">'.$output_notice.'</div>';
if ($output_error<>"") $output.= '<div class="error">'.$output_error.'</div>';
$output.= '<table width="800px" border="0" cellspacing="0">
<tbody align="left" valign="top" >
<tr><td width="35%"><div width="100%">';
$output.= '<div onclick="tree_toggle(arguments[0])">';
$output.= '<div><b>'.$shop_lang['prices_tree_title'].'</b></div>';
//$output.='<ul class="Container">';
$output.= PrintLi($tsvshop['CatRoot'], $col, $pt, $col_p, $col_pr, $col_id);
$output.= '</div>';
$output.= '</td><td width="65%">';
$output.= PrintTable(0, $pt, $col_p, $col_pr, $col_id);
$output.= '</td>   </tr> </tbody> </table>';
$output.= '</form>';
$output.= "<input id='price_col' type='hidden' size='10' value='" . PriceCol() . "'>";
$output.= '</td></tr>
              </table>
</div>';
$output.= '</div>';

?>
