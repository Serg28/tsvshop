<?php
if (!IN_TSVSHOP_MODE) {die();}
//if(IN_PARSER_MODE!="true") die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODx Content Manager instead of accessing this file directly.");
$tables['addons']="system";

function parseaddons($addonspath, $filename, $shop_lang) {
	global $modx, $modulea, $moduleid, $tables, $tsvshop;
        $out="";
        $tmp="";
        $temp="";
        $num=1;
        $lang = isset($lang) ? $lang : $modx->config['manager_language'];
        //$filename=$modx->config['base_path'].'assets/snippets/tsvshop/admin/tpl/addonstable.tpl';
        $tpl=get_file_contents($filename);

        if (!empty($addonspath) && !empty($filename)) {
        	$folders = scandir($addonspath,1);
		foreach ($folders as $folder) {
        		if ($folder != "."  && $folder != ".." && file_exists($addonspath.$folder."/main.inc.php")) {
                		$temp = str_replace('[+moduleid+]', $_GET['id'], $tpl);
                		$temp = str_replace('[+lang+]', $lang, $temp);
                                $temp = str_replace('[+num+]', $num++, $temp);
                                $temp = str_replace('[+addon+]', $shop_lang[$folder.'_title'], $temp);

                                if (is_install($folder)) {
                                	  if ($tables[$folder]=="system") {
                                        $temp = str_replace('[+actions+]', '<img src="'.TSVSHOP_SURL.'addons/addons/img/system.png" alt="" />', $temp);
                                    } else {
                                    	  $temp = str_replace('[+actions+]', '<a href="/'.MGR_DIR.'/index.php?id='.$moduleid.'&a='.$modulea.'&act=addonuninstall&addon='.$folder.'" title="'.$shop_lang['addons_uninstall'].'" onclick="uninstall(\''.$shop_lang['addons_uninstall_question'].'\');return false"><img src="'.TSVSHOP_SURL.'addons/addons/img/uninstall.png" alt="'.$shop_lang['addons_uninstall'].'" /></a>', $temp);
									                  }
                                    if (getConf("addons", $folder."_active")=="yes") {
                                    	  if ($tables[$folder]=="system") {
                                            $temp = str_replace('[+status+]', '<img src="'.TSVSHOP_SURL.'addons/addons/img/addon_un.png" alt="" /> <img src="'.TSVSHOP_SURL.'addons/addons/img/addon_un.png" alt="" />', $temp);
                                        } else {
                                    		    $temp = str_replace('[+status+]', '<img src="'.TSVSHOP_SURL.'addons/addons/img/addon_on.png" alt="'.$shop_lang['addons_on'].'" title="'.$shop_lang['addons_on'].'" /> <a href="/'.MGR_DIR.'/index.php?id='.$moduleid.'&a='.$modulea.'&act=addonoff&addon='.$folder.'" title="'.$shop_lang['addons_off_act'].'"><img src="'.TSVSHOP_SURL.'addons/addons/img/addon_un.png" alt="'.$shop_lang['addons_off_act'].'" /></a>', $temp);
										                    }
                                    } else {
                                    	if ($tables[$folder]=="system") {
                                             $temp = str_replace('[+status+]', '<img src="'.TSVSHOP_SURL.'addons/addons/img/addon_un.png" alt="" /> <img src="'.TSVSHOP_SURL.'addons/addons/img/addon_un.png" alt="" />', $temp);
                                        } else {
                                    		$temp = str_replace('[+status+]', '<a href="/'.MGR_DIR.'/index.php?id='.$moduleid.'&a='.$modulea.'&act=addonon&addon='.$folder.'" title="'.$shop_lang['addons_on_act'].'"><img src="'.TSVSHOP_SURL.'addons/addons/img/addon_un.png" alt="'.$shop_lang['addons_on_act'].'" /></a> <img src="'.TSVSHOP_SURL.'addons/addons/img/addon_off.png" alt="'.$shop_lang['addons_off'].'" title="'.$shop_lang['addons_off'].'" />', $temp);
										                    }
                                    }
                                } else {
                                	if ($tables[$folder]=="system") {
                                      $temp = str_replace('[+actions+]', '<img src="'.TSVSHOP_SURL.'addons/addons/img/system.png" alt="" />', $temp);
                                    	$temp = str_replace('[+status+]', '<img src="'.TSVSHOP_SURL.'addons/addons/img/addon_un.png" alt="'.$shop_lang['addons_on'].'" title="'.$shop_lang['addons_on'].'" /> <img src="'.TSVSHOP_SURL.'addons/addons/img/addon_un.png" alt="'.$shop_lang['addons_on'].'" title="'.$shop_lang['addons_on'].'" />', $temp);
                                    } else {
                                		  $temp = str_replace('[+actions+]', '<a href="/'.MGR_DIR.'/index.php?id='.$moduleid.'&a='.$modulea.'&act=addoninstall&addon='.$folder.'" title="'.$shop_lang['addons_install'].'"><img src="'.TSVSHOP_SURL.'addons/addons/img/install.png" alt="'.$shop_lang['addons_install'].'" /></a>', $temp);
                                    	$temp = str_replace('[+status+]', '<img src="'.TSVSHOP_SURL.'addons/addons/img/addon_un.png" alt="'.$shop_lang['addons_on'].'" title="'.$shop_lang['addons_on'].'" /> <img src="'.TSVSHOP_SURL.'addons/addons/img/addon_un.png" alt="'.$shop_lang['addons_on'].'" title="'.$shop_lang['addons_on'].'" />', $temp);
									                  }
                                }
                                $temp = str_replace('[+description+]', $shop_lang[$folder.'_desc'], $temp);
                                $out.=$temp;
         		}

		}
                $out = preg_replace('/(\[\+.*?\+\])/' ,'', $out);
        	return $out;
        } else {
        	return "";
        }
}

//uninstall addon
function uninstall_addon($addon) {
    global $modx, $shop_lang, $tables;
    //$user=$modx->userLoggedIn();
    $user=$modx->getLoginUserType();
    $output = "";
    $output_sales_notice="";
    $output_sales_error="";
    $act=$_GET['act'];

    //if ($user['usertype']=="manager") {
    if ($user=="manager") {
    	if (!empty($act) && $act=="addonuninstall" && !empty($addon) && $tables[$addon]!="system") {
		if ($tables[$addon]!="none") {
      if ($modx->db->query( "DROP TABLE ".$tables[$addon]) && $modx->db->query( "DELETE FROM ".$modx->getFullTableName('shop_conf')." WHERE `module` = 'addons' AND `name` = '".$addon."_active' LIMIT 1")) {
				$output_sales_notice.=$shop_lang['addons_uninstall_ok'];
			} else {
				$output_sales_error.=$shop_lang['addons_uninstall_error'];
			}
		} else {
			if ($modx->db->query( "DELETE FROM ".$modx->getFullTableName('shop_conf')." WHERE `module` = 'addons' AND `name` = '".$addon."_active' LIMIT 1")) {
				$output_sales_notice.=$shop_lang['addons_uninstall_ok'];
			} else {
				$output_sales_error.=$shop_lang['addons_uninstall_error'];
			}
		}
       		if ($output_sales_notice<>"") {$output=notice($shop_lang['addons_uninstall_ok'], 'success');}
       		if ($output_sales_error<>"") {$output=notice($shop_lang['addons_uninstall_error'], 'error');}
      //clearConf('addons', $addon.'_active');    
    	}
      
    }
    return $output;
}

//install addon
function install_addon($addon) {
    global $modx, $shop_lang, $addonspath, $tables;
    //$user=$modx->userLoggedIn();
    $user=$modx->getLoginUserType();
    $output = "";
    $output_sales_notice="";
    $output_sales_error="";
    $act=$_GET['act'];
    $fsql=$addonspath.$addon.'/sql/install.sql.inc.php';

    //if ($user['usertype']=="manager") {
    if ($user=="manager") {
    	if (!empty($act) && $act=="addoninstall" && !empty($addon)) {
	if (file_exists($fsql)) {
        		include_once ($addonspath.$addon.'/sql/install.sql.inc.php');
	}
                if (!empty($sql)) {
			if (!is_array($sql)) $sql=array($sql);
			foreach ($sql as $query) {
	       		if ($modx->db->query($query)) {
	                		setConf("addons", $addon."_active", "no", 1);
      	      			$output_sales_notice.=$shop_lang['addons_install_ok'];
            			} else {
            				$output_sales_error.=$shop_lang['addons_install_error'];
            			}
			}
           	} else {
			setConf("addons", $addon."_active", "no", 1);
           		$output_sales_notice.=$shop_lang['addons_install_ok'];
		}
       	if ($output_sales_notice<>"") {$output=notice($shop_lang['addons_install_ok'], 'success');}
       	if ($output_sales_error<>"") {$output=notice($shop_lang['addons_install_error'], 'error');}
        //clearConf('addons', $addon.'_active');
    	}
    }
    return $output;
}

//on addon
function on_addon($addon) {
    global $modx, $shop_lang;
    //$user=$modx->userLoggedIn();
    $user=$modx->getLoginUserType();
    $output = "";
    $output_sales_notice="";
    $output_sales_error="";
    $act=$_GET['act'];

    //if ($user['usertype']=="manager") {
    if ($user=="manager") {
    	if (!empty($act) && $act=="addonon" && !empty($addon) && $tables[$addon]!="system") {
        	setConf("addons", $addon."_active", "yes", 1);
            $output=notice($shop_lang['addons_on_ok'], 'success');
        }
    }
    return $output;
}

//off addon
function off_addon($addon) {
    global $modx, $shop_lang;
    //$user=$modx->userLoggedIn();
    $user=$modx->getLoginUserType();
    $output = "";
    $output_sales_notice="";
    $output_sales_error="";
    $act=$_GET['act'];

    //if ($user['usertype']=="manager") {
    if ($user=="manager") {
    	if (!empty($act) && $act=="addonoff" && !empty($addon) && $tables[$addon]!="system") {
            setConf("addons", $addon."_active", "no", 1);
            $output=notice($shop_lang['addons_off_ok'], 'success');
        }
    }
    return $output;
}


$anotice="";
$addon=_filter($_GET['addon'],1);

switch ($_GET['act']) {
    case 'addoninstall':
        $anotice.=install_addon($addon); break;
    case 'addonuninstall':
        $anotice.=uninstall_addon($addon); break;
    case 'addonon':
        $anotice.=on_addon($addon); break;
    case 'addonoff':
        $anotice.=off_addon($addon); break;
}


?>

