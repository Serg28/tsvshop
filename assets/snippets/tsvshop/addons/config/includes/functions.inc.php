<?php
if (!IN_TSVSHOP_MODE) {die();}
$tables['config']="system";  


function saveconfig() {
	global $shop_lang, $modx;
  $user=$modx->getLoginUserType();
  //$user=$modx->userLoggedIn();
	$act=$_GET['act'];
	//if ($user['usertype']=="manager") {
	if ($user=="manager") {
		if  (!empty($act) && $act=="saveconfig") {
			foreach ($_GET as $key=>$value) {
				if ($key!="a" && $key!="id" && $key!="act" && $key!="act2"  && $key!="act3")  {
        //echo  $value;
					setConf("",$key, $value, 1);
				}
			}
 			include_once $modx->config['base_path'].MGR_DIR."/processors/cache_sync.class.processor.php";
               			$sync = new synccache();
                		$sync->setCachepath($modx->config['base_path']."assets/cache/");
                		$sync->setReport(false);
                		$sync->emptyCache(); // first empty the cache
			regenConf();	
			return "<span class='ok'>".$shop_lang['saveok']."</span>";
		}
	}

}

switch ($_GET['act']) {
    case 'saveconfig':
            exit(saveconfig()); break;
}

?>
