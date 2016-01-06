<?php
if(IN_MANAGER_MODE!="true") die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODx Content Manager instead of accessing this file directly.");


$output.= ' <div class="tab-page" id="ShopConf">';
$output.= '<h2 class="tab">' . $shop_lang['config_title'] . '</h2>';
$output.= '<p><img src="'.TSVSHOP_SURL.'addons/config/img/configure.png" alt="'.$shop_lang['config_title'].'" class="icon" style="vertical-align: middle; text-align: left; " />'.$shop_lang['config_intro'];
//Проверка файлов конфигурации на права для записи
if (getfilechmod(TSVSHOP_PATH.'js/config.js') != "0666" || getfilechmod(TSVSHOP_PATH.'include/config.inc.php') != "0666") {
    $output.= '<div class="notice">'.$shop_lang['config_chmod'].'</div><br />';
}
$output.= '
<table cellpadding="0" cellspacing="0" class="actionButtons">
        <tr>
<td>
<ul class="actionButtons">
                <li id="Button1"><a href="index.php?a=112&id=' . $moduleid . '"><img src="media/style'.$theme.'/images/icons/refresh.png"> '.$shop_lang['refresh'].'</a></li>
                <li id="Button1"><a href="#" onclick="getform(\'/'.MGR_DIR.'/index.php\',document.getElementById(\'sconf\'),save_config_ok);"><img src="media/style'.$theme.'/images/icons/save.png"> '.$shop_lang['save'].'</a></li>
            </ul>
</td>
            <td id="report"></td>
        </tr>
    </table>';
$output.= '
<div id="sconf">
<form action="javascript:getform(\'/'.MGR_DIR.'/index.php\',document.getElementById(\'sconf\'),save_config_ok);" name="sconf">
<input type="hidden" id="a" name="a" value="' . $modulea . '" />
<input type="hidden" id="id" name="id" value="' . $moduleid . '" />
<input type="hidden" id="act" name="act" value="saveconfig" />';

$output.= '
    <br /><div class="tab-pane" id="resourcesPane1">
        <script type="text/javascript">
        tp1Resources = new WebFXTabPane( document.getElementById( "resourcesPane1" ) );
        </script>';


//тут будет вывод формы конфигурации

foreach ($folders as $folder) {
         if ($folder != "."  && $folder != ".." ) {
                 $file = $addonspath.$folder.'/includes/config.form.inc.php';
                 if (is_install($folder) && file_exists($file)) {
                     require_once($file);
                 }
         }
}
//include_once ($addonspath.'config/includes/config.form.inc.php');


//--------------
$output.= '</div></form></div>';

$output.= '</div>';

?>
