<?php

$act = (!empty($act)) ? $act : 'office';

if(!function_exists("shop_striptags"))
{
function shop_striptags($var, $striptags=true)
      {
         if( $striptags ) {
         $var = strip_tags($var);
         //$var=strtr($var,"<>%&^[{", "#######");
         }
         if( ini_get('magic_quotes_gpc') == 0 ){
              $var = addslashes($var);
         }
         return $var;
}
}

if(!function_exists("_filter"))
{
function _filter( $var , $sql = 0) {
    global $modx;
	$var = shop_striptags($var);
	$var=str_replace ("\n"," ", $var);
    $var=str_replace ("\r","", $var);
	//$var = htmlentities($var);
	if ( $sql == 1) {
		$var = $modx->db->escape($var);
	}
	return $var;
}
}

if(!function_exists("CryptMessage"))
{
function CryptMessage($message, $password)
  {
  global $modx;
  require_once $modx->config['base_path']."assets/snippets/tsvshop/include/crypt.inc.php";
  $password = (!empty($password)) ? $password : "VhgtYhT65%6ytr";
  return base64_encode(xxtea_encrypt($message, $password));
  }
}


if(!function_exists("DeCryptMessage"))
{
function DeCryptMessage($message, $password)
  {
  require_once $modx->config['base_path']."assets/snippets/tsvshop/include/crypt.inc.php";
  $password = (!empty($password)) ? $password : "VhgtYhT65%6ytr";
  $message = base64_decode($message);
  return xxtea_decrypt($message, $password);
  }
}




if(!function_exists("getStr"))
{
function getStr($string, $start, $end){
	$string = " ".$string;
	$ini = strpos($string,$start);
	if ($ini == 0) return "";
	$ini += strlen($start);
	$len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
}

if(!function_exists("get_file_contents"))
{
function get_file_contents($filename) {
		if (!function_exists('file_get_contents')) {
			$fhandle = fopen($filename, "r");
			$fcontents = fread($fhandle, filesize($filename));
			fclose($fhandle);
		} else	{
			$fcontents = file_get_contents($filename);
		}
		return $fcontents;
}
}

if(!function_exists("tsv_logout"))
{
  function tsv_logout($logouthomeid)
  {
    global $modx;
    $loHomeId= (empty($logouthomeid)) ? "1" : $logouthomeid;
    $isLogOut=$_GET['isLogOut'];
    if ($isLogOut==1){
        $internalKey = $_SESSION['webInternalKey'];
        $username = $_SESSION['webShortname'];

        // invoke OnBeforeWebLogout event
        $modx->invokeEvent("OnBeforeWebLogout",
                                array(
                                    "userid"   => $internalKey,
                                    "username" => $username
                                ));

        // if we were launched from the manager
        // do NOT destroy session
        if(isset($_SESSION['mgrValidated'])) {
            unset($_SESSION['webShortname']);
            unset($_SESSION['webFullname']);
            unset($_SESSION['webEmail']);
            unset($_SESSION['webValidated']);
            unset($_SESSION['webInternalKey']);
            unset($_SESSION['webValid']);
            unset($_SESSION['webUser']);
            unset($_SESSION['webFailedlogins']);
            unset($_SESSION['webLastlogin']);
            unset($_SESSION['webnrlogins']);
            unset($_SESSION['webUsrConfigSet']);
            unset($_SESSION['webUserGroupNames']);
            unset($_SESSION['webDocgroups']);
        }
        else {
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', 0, MODX_BASE_URL);
            }
            session_destroy();
        }


        // invoke OnWebLogout event
        $modx->invokeEvent("OnWebLogout",
                                array(
                                    "userid"        => $internalKey,
                                    "username"        => $username
                                ));

        // redirect to first authorized logout page
        //$url = preserveUrl($loHomeId);
        $url = $modx->makeUrl($loHomeId);
        //$modx->sendRedirect($url,0,'REDIRECT_REFRESH');
        header('Location: '.$url);
    }
    return;
  }
}


if(!function_exists("tsv_profile"))
{
  function tsv_profile($logout, $tpl)
  {
  global $modx;
# WebProfile 1.2
# Created By sottwell September 2006
# Version 1.3 - October 2006
# added redirect for non-loggin-in users
#::::::::::::::::::::::::::::::::::::::::
# Usage: 	
#	Allows a web user to edit the profile of his web account from the website
#	This snippet provides a basic set of form fields for the edit profile form
#	You can customize this snippet to create your own edit profile form
#
# Params:	
#
#	&tpl - (Optional) Chunk name or document id to use as a template
# &logout - (Optional) Document ID of page to redirect to if user is not logged in
#				  
#	Note: Template design:
#			section 1: profile template
#			section 2: notification template - with passwored change
#     section 3: notification template - no password change
#     by default use <hr> to separate sections 
#
# The page the snippet is called from must be uncached.
#
# Examples:
#
#	[[WebProfile? &tpl=`WebEditProfileForm` &logout=`23`]] 

# set page to redirect to if user is not logged in, site_start by default
if(!isset($_SESSION['webInternalKey']) || empty($_SESSION['webInternalKey'])) {
  $logout = isset($logout) ? $logout : $modx->config['site_start'];
  $modx->sendRedirect($modx->makeUrl($logout));
}

# Set Snippet Paths 
$snipPath = $modx->config['base_path'] . "assets/snippets/";

# check if inside manager
if ($m = $modx->insideManager()) {
	return ''; # don't go any further when inside manager
}


# Snippet customize settings
$tpl = isset($tpl)? $tpl:"";

# System settings
$isPostBack = count($_POST) && isset($_POST['cmdwebeditprofile']);

$output = '';

# Start processing
include_once $snipPath."weblogin/weblogin.common.inc.php";
include_once $snipPath."tsvoffice/inc/webeditprofile.inc.php";

# Return
return $output;

}

}


if(!function_exists("getTpl"))
{
    function getTpl($tpl){
	global $modx;
        $template = "";
        if(substr($tpl, 0, 6) == "@FILE:"){
          $tpl_file = $modx->config['base_path'].substr($tpl, 6);
                $template = get_file_contents($tpl_file);
        }else if(substr($tpl, 0, 6) == "@CODE:"){
                $template = substr($tpl, 6);
        }else if($modx->getChunk($tpl)!= ""){
                $template = $modx->getChunk($tpl);
        }else if($res=$modx->db->query("SELECT * FROM ".$modx->getFullTableName('site_htmlsnippets')." WHERE `name` ='".$modx->db->escape($tpl)."' LIMIT 1 ")){
                $row = $modx->db->getRow($res);
		            $template = $row['snippet'];
        }else{
                $template = false;
        }
        return $template;
    }
}

// просмотр списка заказов

function tsv_listorders($id) {
	global $modx, $tsvshop;
  $userid = $modx->getLoginUserID();
  //$userid = $userid['id'];
  if (!empty($userid)) {
  
    $dborders = $modx->getFullTableName('shop_order');
    $dborders_details = $modx->getFullTableName('shop_order_detail');
    $res = $modx->db->select("*", $dborders, 'userid = "' . $userid . '"','numorder');
        $out="";
        $tmp="";
        $temp="";
        $shop_lang = array();
        $lang = isset($lang) ? $lang : $modx->config['manager_language'];
        include_once ($modx->config['base_path'].'assets/snippets/tsvshop/addons/sales/lang/'.$lang.'.inc.php');
        $filename=$modx->config['base_path'].'assets/snippets/tsvoffice/tpl/ordertable.tpl';
        $tpl=get_file_contents($filename);
        
        $url="";
        $row1=array('url' => $modx->makeUrl($id)
        );
        
        $tpltr = getStr($tpl, '<!--repeat-->', '<!--/repeat-->');
        
        $row = array_merge($shop_lang,$row1);
        
        if (!empty($res) && !empty($tpl)) {
        	while($rows=$modx->db->getRow($res)) {
                    $row = array_merge($shop_lang,$rows);
                  
                    $temp = str_replace('[+moduleid+]', $_GET['id'], $tpltr);
                    foreach ($rows as $key => $value) {
                        if (in_array($key,explode(",",$tsvshop['SecFields'])))  {
                          $value=DeCryptMessage($value, $tsvshop['SecPassword']);
                        }
                    	  if ($key=="dateorder") {
                        	//$temp = str_replace('[+dateorder+]', date("d.m.Y H:i:s",$value), $temp);
                          $value = date("d.m.Y H:i:s",$value);
                        } 
    		    		        $temp = str_replace('[+'.$key.'+]', $value, $temp);

    		          }
                  $url = $modx->makeUrl($id);
                  $sep = (strpos($url,'?')) ? "&i=" : "?i=";
                  $param = $rows['numorder'].":".$rows['code'];
                  $temp = str_replace('[+url+]', $url.$sep.$param, $temp);
                  $out.=$temp;
            }
            $out = str_replace($tpltr,$out,$tpl);
            foreach ($row as $key => $value) {
                $out = str_replace('[+'.$key.'+]', $value, $out);
            }
            $out = preg_replace('/(\[\+.*?\+\])/' ,'', $out);
            return $out;
        } else {
        	return "";
        }
    } else {
      return $modx->runSnippet('TSVoffice', array('act'=>'office'));
    }
}

// просмотр конкретного заказа

function tsv_showorder() {
  global $modx, $tsvshop;
  $dborders = $modx->getFullTableName('shop_order');
  $dborders_details = $modx->getFullTableName('shop_order_detail');
  $userid=$modx->getLoginUserID();

  $i=explode(":",_filter($_GET['i'],1));
  $n=$i[0];
  $c=$i[1];
  $out="";
  $r=0;
  $temp = "";
  $filename = $modx->config['base_path'].'assets/snippets/tsvoffice/tpl/orderview.tpl';
  if (!empty($n) && !empty($c) && !empty($userid)) {
    $res = $modx->db->select('*', $dborders, 'numorder = "'.$n.'" AND code="'.$c.'" AND userid="'.$userid.'"','numorder','1' );
    $row = $modx->db->getRow($res);
     if ($res && is_array($row)) { 
       //$row = $modx->db->getRow($res);
       $tpl=get_file_contents($filename);
       $tpltr = getStr($tpl, '<!--repeat-->', '<!--/repeat-->');
       foreach ($row as $key => $value) {
          if (in_array($key,explode(",",$tsvshop['SecFields'])))  {
            $value=DeCryptMessage($value, $tsvshop['SecPassword']);
            //echo "key=".$key.", value=".$value;
          }
          if ($key=="dateorder") {
            $value=date("d.m.Y H:i:s",$value);
          }
										// игнорируем дисконтную карту, проверим позже
										if($key=="discountnum"){
											$value='[+discountnum+]';
										}
										// 
          $tpl = str_replace('[+'.$key.'+]', $value, $tpl);
       }
							// Проверим валидна ли дисконтная карта и если её нет в базе выведем предупреждение
							if ($tsvshop['addons_discount_active']=='yes') {
							    $discountres=$modx->db->query("SELECT * FROM ".$modx->getFullTableName('shop_discount')." AS a WHERE a.discountnum = '".$row['discountnum']."' AND a.active = 1 AND (a.use < a.count OR a.count = 0) AND (a.summa >= '".$sub."' OR a.summa = 0) LIMIT 1");
       $discountrow=$modx->db->getRow($discountres);		
							}					
							if($discountrow['discountnum']){
							$tpl = str_replace('[+discountnum+]', $discountrow['discountnum'], $tpl);							
       } else {
							$tpl = str_replace('[+discountnum+]', '<span class="error_discount">Карта указана неверно или неактивна</span>', $tpl);		
							}
							// end
							
       if ($res = $modx->db->select('*', $dborders_details, 'numorder = "'.$n.'"','numorder' )) {
          while ($row = $modx->db->getRow($res))  {
			      $r++;
            $temp = $tpltr;
            foreach ($row as $key => $value) { 
              $temp = str_replace('[+'.$key.'+]', $value, $temp);
            }
            $temp = str_replace('[+num+]', $r, $temp);
            $out.=$temp;
          }
          $out = str_replace($tpltr,$out,$tpl);
          $out = preg_replace('/(\[\+.*?\+\])/' ,'', $out);
          return $out;
       }  
       
       
       
     }  else {
       return '<div class="error">Извините, но такого заказа не существует.</div>';
     }
     
  } else {
     return '<div class="error">Извините, но такого заказа не существует.</div>';
  }
  // если номер заказа, ид пользователя и код доступа подходят, выдаем подробности заказа
  // backid
  

}

if ($act=='editprofile') {
  $uid = $modx->getLoginUserID();
  $modx->setPlaceholder('manager_folder',MGR_DIR);
  if ($uid) {
    $edittpl = (!empty($edittpl)) ? $edittpl: '@FILE:/assets/snippets/tsvoffice/tpl/editprofile.tpl';
    echo tsv_profile($logouthomeid, $edittpl);
  } else {
    $act='office';
  }
}


if ($act=='showorder') { 
  $modx->setPlaceholder('manager_folder',MGR_DIR); 
  $uid = $modx->getLoginUserID();
  if ($uid) {
    echo tsv_showorder();
  } else {
    $act='office';
  }
}

// авторизован ли?
if ($act=='office' ) {
  $uid = $modx->getLoginUserID();
  $modx->setPlaceholder('manager_folder',MGR_DIR);
  $yesChunk =(!empty($yesChunk)) ? $yesChunk : '@FILE:assets/snippets/tsvoffice/tpl/tsvoffice.tpl';
  $noChunk = (!empty($noChunk)) ? $noChunk : '@FILE:assets/snippets/tsvoffice/tpl/login.tpl';
  tsv_logout($logouthomeid);
  if ($uid) {
    $act = 'listorders';
    $modx->setPlaceholder('listorders',$modx->runSnippet('TSVoffice', array('act'=>'listorders','orderpage'=>$orderpage)));
    $modx->setPlaceholder('logoutlink',$modx->documentIdentifier.'?isLogOut=1');
    echo getTpl($yesChunk);
  } else {    // если неавторизован
    $logintpl = (!empty($logintpl)) ? $logintpl : 'weblogin';
    $signuptpl = (!empty($signuptpl)) ? $signuptpl : 'formsignup';
    $modx->setPlaceholder('weblogin',$modx->runSnippet('WebLogin',array('loginhomeid'=>$loginhomeid,'logouthomeid'=>$logouthomeid,'pwdreqid'=>$pwdreqid,'pwdactid'=>$pwdactid,'logintext'=>$logintext,'logouttext'=>$logouttext,'tpl'=>$logintpl)));
    $modx->setPlaceholder('websignup',$modx->runSnippet('WebSignup',array('groups'=>$groups,'useCaptchad'=>$useCaptcha,'tpl'=>$signuptpl)));
    echo getTpl($noChunk);
  }
}

if ($act=='listorders') {
  $modx->setPlaceholder('manager_folder',MGR_DIR);
  $uid = $modx->getLoginUserID();
  if ($uid) {
    $orderpage = (!empty($orderpage)) ? $orderpage : $modx->documentIdentifier;
    echo tsv_listorders($orderpage);
  } else {
    $act='office';
  }
}
// показ формы авторизации

if ($act=='weblogin') {
   $modx->setPlaceholder('manager_folder',MGR_DIR);
   return $modx->runSnippet('WebLogin',array('loginhomeid'=>$loginhomeid,'logouthomeid'=>$logouthomeid,'pwdreqid'=>$pwdreqid,'pwdactid'=>$pwdactid,'logintext'=>$logintext,'logouttext'=>$logouttext,'tpl'=>$tpl));
}

if ($act=='websignup') {
   $modx->setPlaceholder('manager_folder',MGR_DIR);
   return $modx->runSnippet('WebSignup',array('groups'=>$groups,'useCaptchad'=>$useCaptcha,'tpl'=>$tpl));
}



?>
