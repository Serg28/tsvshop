<?php
//if (!IN_TSVSHOP_MODE) {die();}
//if(IN_MANAGER_MODE!="true") die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODx Content Manager instead of accessing this file directly.");
$tables['sales']="system";  
$tsvshop['dborders']=$modx->getFullTableName('shop_order');
$tsvshop['dborders_details']=$modx->getFullTableName('shop_order_detail');
$tsvshop['tplmailupdateorder'] = !empty($tplmailupdateorder) ? $tplmailupdateorder : "Shop_UpdateOrder";
$tsvshop['sysfields'] = "dateorder,status,fio,total,comments,adress,city,region,province,zip,tracking,phone,email,commentadmin,subtotal,nalog,code,userid";


function parsetable($res,$filename) {
	global $modx, $shop_lang, $tsvshop, $modulea, $moduleid;
        $out="";
        $tmp="";
        $temp="";
        $lang = isset($lang) ? $lang : $modx->config['manager_language'];
        //$filename=$modx->config['base_path'].'assets/snippets/tsvshop/admin/tpl/saletable.tpl';
        $tpl=get_file_contents($filename);
        
        $url="index.php";
        $row1=array('url'      => $url,
                    'modulea'  => $modulea,
                    'moduleid' => $moduleid,
                    'theme'    => $theme
        );
        
        $tpltr = getStr($tpl, '<!--repeat-->', '<!--/repeat-->');
        
        $row = array_merge($shop_lang,$row1);
        
        if (!empty($res) && !empty($tpl)) {
        	while($rows=$modx->db->getRow($res)) {
                  $row = array_merge($row,$rows);
                  
                    $temp = str_replace('[+moduleid+]', $_GET['id'], $tpltr);
                    $temp = str_replace('[+lang+]', $lang, $temp);
                    foreach ($rows as $key => $value) {
                        if (in_array($key,explode(",",$tsvshop['SecFields'])))  {
                          $value=DeCryptMessage($value, $tsvshop['SecPassword']);
                        }
                    	  if ($key=="dateorder") {
                        	$temp = str_replace('[+dateorder+]', date("d.m.Y H:i:s",$value), $temp);
                        } else {
    		    		          $temp = str_replace('[+'.$key.'+]', $value, $temp);
                        }
                        if ($key=="status") {
                          $temp= str_replace('[+statussel+]','<select name="status" id="chst'.$row['numorder'].'" onchange="chst(\''.((int)$_GET['id']).'\',\''.((int)$_GET['a']).'\',\'/manager/index.php\',document.getElementById(\'chst'.$row['numorder'].'\'),\''.$row['numorder'].'\',updst);return false">'.buildstatus($value, explode("||",$tsvshop['StatusOrder'])).'</select>',$temp);
                        }
                       
                        $status = explode("||",$tsvshop['StatusOrder']);
                        foreach ($status as $tmp) {
                          $tmpstatus = explode("==",$tmp); 
                          if ($key=="status" && $value==$tmpstatus[0]) {
                            $temp = str_replace('[+color+]', ' style="background:#'.$tmpstatus[1].'" ', $temp);
                          }
                        }
    		          }
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
}





//delete selected order
function delorder($idorder) {
    global $modx, $shop_lang, $tsvshop;
    $user=$modx->userLoggedIn();
    $output = "";
    $output_sales_notice="";
    $output_sales_error="";
    $act=$_GET['act'];

    if ($user['usertype']=="manager") {
    	if (!empty($act) && $act=="delorder" && !empty($idorder) && is_numeric(intval($idorder))) {
       		if ($modx->db->query( "
       		   DELETE FROM ".$tsvshop['dborders']." WHERE `numorder` = ".$idorder." LIMIT 1
       		")) {$output_sales_notice.=$shop_lang['sales_del_ok'];} else {$output_sales_error.=$shop_lang['sales_del_error'];};

       		if ($modx->db->query( "
       			DELETE FROM ".$tsvshop['dborders_details']." WHERE `numorder` = ".$idorder.";
       		")) {$output_sales_notice.=$shop_lang['sales_del_ok'];} else {$output_sales_error.=$shop_lang['sales_del_error'];};
       		if ($output_sales_notice<>"") {$output=notice($shop_lang['sales_del_ok'], 'success');}
       		if ($output_sales_error<>"") {$output=notice($shop_lang['sales_del_error'], 'error');}
    	}

    }
    return $output;
}

//truncate all orders
function clearorder() {
    global $modx, $shop_lang, $tsvshop;
    $user=$modx->userLoggedIn();
    $output = "";
    $output_sales_notice="";
	$output_sales_error="";
    $act=$_GET['act'];

    if ($user['usertype']=="manager") {
    	if (!empty($act) && $act=="clearorders") {
			if ($modx->db->query( "
				TRUNCATE TABLE ".$tsvshop['dborders']."
			")) {$output_sales_notice.=$shop_lang['sales_clear_ok'];} else {$output_sales_error.=$shop_lang['sales_clear_error'];}

			if ($modx->db->query( "
				TRUNCATE TABLE ".$tsvshop['dborders_details']."
			")) {$output_sales_notice.=$shop_lang['sales_clear_ok'];} else {$output_sales_error.=$shop_lang['sales_clear_error'];}
            if ($output_sales_notice<>"") {$output=notice($shop_lang['sales_clear_ok'], 'success');}
       		if ($output_sales_error<>"") {$output=notice($shop_lang['sales_clear_error'], 'error');}
        }
        return $output;
    }
}

//delete checked orders
function checkdelorder() {
    global $modx, $shop_lang, $tsvshop;
    $user=$modx->userLoggedIn();
    $output = "";
    $output_sales_notice="";
	$output_sales_error="";
    $act=$_GET['act'];

    if ($user['usertype']=="manager") {
    	if (!empty($act) && $act=="delchecked") {
        	foreach($_GET as $val) {
				if ($val<>"check_del" && is_numeric($val)) {
					if ($modx->db->query( "
						DELETE FROM ".$tsvshop['dborders']." WHERE `numorder` = ".$val.";
					")) {$output_sales_notice.=$shop_lang['sales_check_del_ok'];} else {$output_sales_error.=$shop_lang['sales_check_del_error'];};

					if ($modx->db->query( "
						DELETE FROM ".$tsvshop['dborders_details']." WHERE `numorder` = ".$val.";
					")) {$output_sales_notice.=$shop_lang['sales_check_del_ok'];} else {$output_sales_error.=$shop_lang['sales_check_del_error'];};
				}
			}
            if ($output_sales_notice<>"") {$output=notice($shop_lang['sales_check_del_ok'], 'success');}
       		if ($output_sales_error<>"") {$output=notice($shop_lang['sales_check_del_error'], 'error');}
        }
        return $output;
    }
}

//update selected order
function updateorder($idorder) {
    global $modx, $shop_lang, $tsvshop;
    $user=$modx->userLoggedIn();
    $output = "";
    $output_sales_notice="";
    $output_sales_error="";
    $act=$_GET['act'];

    if ($user['usertype']=="manager") {
        if (!empty($act) && $act=="updateorder" && !empty($idorder) && is_numeric(intval($idorder)) && $idorder !="0") {
          /*if (!empty($_GET['commentadmin'])) {
             $fields = array('status'       => $modx->db->escape($_GET['status']),
		              'commentadmin' => $modx->db->escape($_GET['commentadmin'])
             );
          } else {
             $fields = array('status'       => $modx->db->escape($_GET['status']));
          }*/
          //---v5.2rc2----
          $sysfielad = explode(',',$tsvshop['sysfields']);
          foreach ($_GET as $key => $value) {
            if (in_array($key,$sysfielad)) {
              $fields[$key] = $modx->db->escape($value);
            }
          }
          //------
          updateMail($modx->db->escape($_GET['status']),$idorder);
		      //$result = $modx->db->update( $fields, $tsvshop['dborders'], 'numorder = "' . intval($idorder) . '"' );
          if ($modx->db->update( $fields, $tsvshop['dborders'], 'numorder = "' . intval($idorder) . '"' )) {
              //Запускаем событие TSVshopOnOrderStatusUpdate
              $modx->invokeEvent("TSVshopOnOrderStatusUpdate",array("idorder"=>$idorder, "newstatus"=>$modx->db->escape($_GET['status'])));
              return "<span class='ok'>".$shop_lang['sales_update_ok']."</span>";
          } else {
              return "<span class='error'>".$shop_lang['sales_update_error']."</span>";
          }		
       }
    }
}

//update selected order
function updstorder($idorder) {
    global $modx, $shop_lang, $tsvshop;

    $user=$modx->userLoggedIn();
    $output = "";
    $output_sales_notice="";
    $output_sales_error="";
    $act=$_GET['act'];

    if ($user['usertype']=="manager") {
       	if (!empty($act) && $act=="updstorder" && !empty($idorder) && is_numeric(intval($idorder)) && $idorder !="0") {
            /*
            if (!empty($_GET['commentadmin'])) {
             $fields = array('status'       => $modx->db->escape($_GET['status']),
		              'commentadmin' => $modx->db->escape($_GET['commentadmin'])
             );
	          } else {
	           $fields = array('status'       => $modx->db->escape($_GET['status']));
	          }
            */
            //---v5.2rc2----
            $sysfielad = explode(',',$tsvshop['sysfields']);
            foreach ($_GET as $key => $value) {
              if (in_array($key,$sysfielad)) {
                $fields[$key] = $modx->db->escape($value);
              }
            }
            //------
            updateMail($modx->db->escape($_GET['status']),$idorder);
            $result = $modx->db->update( $fields, $tsvshop['dborders'], 'numorder = "' . intval($idorder) . '"' );
             if ($result) {
                  $status = explode("||",$tsvshop['StatusOrder']);
                  foreach ($status as $tmp) {
                    $tmpstatus = explode("==",$tmp); 
                      if ($_GET['status']==$tmpstatus[0]) {
                        $color = $tmpstatus[1];
                      }
                  }
                  //Запускаем событие TSVshopOnOrderStatusUpdate
                  $modx->invokeEvent("TSVshopOnOrderStatusUpdate",array("idorder"=>$idorder, "newstatus"=>$modx->db->escape($_GET['status'])));
                  return $idorder."||".$color."||success";
        
             } else {
				          return $idorder."||".$color."||error";
             }		
        }
    }
}

function getOrderInfo($idorder) {
    global $modx, $shop_lang, $tsvshop;
    $res = $modx->db->query("SELECT * FROM ".$tsvshop['dborders']." WHERE numorder=".$idorder." LIMIT 1");
    $row = $modx->db->getRow($res);
    return $row;
}

function sendMailUpdate($emails, $subject='', $body, $isHTML=false)
	{
    global $modx, $session, $tsvshop, $shop_lang, $mail;
    include $modx->config['base_path'] . "manager/includes/controls/class.phpmailer.php";
	  $mail = new PHPMailer;
		$mail->Body = $body;
		$mail->isHTML($isHTML);
		$mail->CharSet = $modx->config['modx_charset'];
		$mail->From = $tsvshop['SmtpFromEmail'];
		$mail->FromName = $tsvshop['SmtpFromName'];
		$mail->Subject = $subject;
    
    if ($tsvshop['MailMode']=="smtp") {
			$mail->IsSMTP();
      $mail->Host       = $tsvshop['SmtpHost'];
  		//$mail->SMTPDebug  = $__smtp['debug'];
  		$mail->SMTPAuth   = $tsvshop['SmtpAuth'];
  		$mail->Port       = $tsvshop['SmtpPort'];
  		$mail->Username   = $tsvshop['SmtpUser'];
  		$mail->Password   = $tsvshop['SmtpPass'];
		} else {
			$mail->IsMail();
		}
		
		if(is_array($emails))
		{
			foreach($emails as $name => $email)
			{
				$name = (is_string($name)) ? $name : '';
				$mail->AddAddress($email, $name);
			}
		}
		elseif(is_string($emails)) {
		  $mail->AddAddress($emails); 
    }
    //$mail->SetFrom($tsvshop['SmtpFromEmail'], $tsvshop['SmtpFromName']); //от кого (желательно указывать свой реальный e-mail на используемом SMTP сервере
  	$mail->AddReplyTo($tsvshop['SmtpReplyEmail'], $tsvshop['SmtpFromName']);
		
		return ($mail->Send() ? true : false);
	}

function updateMail($newstatus,$idorder) {
    global $modx, $tsvshop, $shop_lang;
    $body = getTpl($tsvshop['tplmailupdateorder']);
    $row = getOrderInfo($idorder);
    $i=0;
    $body = str_replace("[+shop.order.status+]",$newstatus,$body);
    if (!empty($row)) {
        foreach ($row as $key=>$val) {
            if (in_array($key,explode(",",$tsvshop['SecFields'])))  {
              $val=DeCryptMessage($val, $tsvshop['SecPassword']);
            }
            if ($key=="dateorder") {
              $body = str_replace("[+shop.order.".$key."+]",date("d.m.Y H:i:s",$val),$body);
            } else {
              $body = str_replace("[+shop.order.".$key."+]",$val,$body);
            }
            $body = str_replace("[+shop.order.num+]",$i,$body);
            $i++;
        }
    }  
    $body = str_replace("[+shop.order.sitename+]",$modx->config['site_name'],$body);
    if ($row['status']!=$newstatus) {
      if (sendMailUpdate(DeCryptMessage($row['email'], $tsvshop['SecPassword']), $tsvshop['SubjectUpdateStatus'], $body, 'true')) {return true;} else {return false;}
    }   
}


function vieworder($filename) {
    global $modx, $shop_lang, $theme, $tsvshop, $tables, $moduleid, $modulea;
    $user=$modx->userLoggedIn();
    $out = "";
    $output_sales_notice="";
	  $output_sales_error="";
    $temp = "";
    $act=$_GET['act'];
    $id=_filter($_GET['idorder'],1);
    $filename = (empty($filename)) ? TSVSHOP_PATH.'addons/sales/tpl/orderview.tpl' : $filename;
    if ($user['usertype']=="manager") { 
      if (!empty($act) && $act=="vieworder" && $tables['sales']!="none" && $tsvshop['dborders']!="" && !empty($id) && is_numeric($id)) { 
        if ($res = $modx->db->select('*', $tsvshop['dborders'], 'numorder = "' . $id . '"','numorder','1' )) { 
           $row = $modx->db->getRow($res);
           $url="index.php";
            
           $tpl=get_file_contents($filename);
           $row1=array('moduleurl'      => $url,
                       'modulea'  => $modulea,
                       'moduleid' => $moduleid,
                       'theme'    => $theme
           );
           
           $tpltr = getStr($tpl, '<!--repeat-->', '<!--/repeat-->');
           
           $row = array_merge($shop_lang,$row1,$row);
           
           foreach ($row as $key => $value) {
             if (in_array($key,explode(",",$tsvshop['SecFields'])))  {
               $value=DeCryptMessage($value, $tsvshop['SecPassword']);
             }
             if ($key=="dateorder") {
               $value=date("d.m.Y H:i:s",$value);
             }
             if ($key=="status") {
               $tpl = str_replace('[+buildstatus+]', '<select name="status" id="status">'.buildstatus($value, explode("||",$tsvshop['StatusOrder'])).'</select>', $tpl);
             }
             $tpl = str_replace('[+'.$key.'+]', $value, $tpl);
           }
           
           if ($res = $modx->db->select('*', $tsvshop['dborders_details'], 'numorder = "' . $id . '"','numorder' )) {
             while ($order = $modx->db->getRow($res))  {
               $row = array_merge($row,$order);
			         $r++;
               $temp = str_replace('[+moduleid+]', $_GET['id'], $tpltr);
               foreach ($order as $key => $value) { 
                 $temp = str_replace('[+'.$key.'+]', $value, $temp);
               }
               $temp = str_replace('[+num+]', $r, $temp);
               $out.=$temp;
             }
             $out = str_replace($tpltr,$out,$tpl);
             $out = preg_replace('/(\[\+.*?\+\])/' ,'', $out);
             return $out;
           }
        }
        //---
      }
    
    }
}

$snotice=""; 

switch ($_GET['act']) {
    case 'delorder':
        $snotice.=delorder($_GET['idorder']); break;
    case 'clearorders':
        $snotice.=clearorder(); break;
    case 'delchecked':
        $snotice.=checkdelorder(); break;
    case 'view':
        exit(vieworder($_GET['idorder'])); break;
    case 'updateorder':
        exit(updateorder($_GET['idorder'])); break;
    case 'updstorder':
        exit(updstorder($_GET['idorder'])); break;
}

?>
