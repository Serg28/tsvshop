<?php
//if (!IN_TSVSHOP_MODE) {die();}
//if(IN_MANAGER_MODE!="true") die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODx Content Manager instead of accessing this file directly.");
$tables['sales']="system";
$tsvshop['dborders']=$modx->getFullTableName('shop_order');
$tsvshop['dborders_details']=$modx->getFullTableName('shop_order_detail');
$tsvshop['tplmailupdateorder'] = !empty($tplmailupdateorder) ? $tplmailupdateorder : "Shop_UpdateOrder";
//Ниже - список имен полей в таблице заказа shop_order . Служит как проверочный список допустимых полей при добавлении заказа в БД
//т.е. значение поля в форме заказа не будет добавлено в БД, если названия этого поля нету в данном списке.
//также этот список служит для формирования списка полей, доступных для шифрования в аддоне модуле TSVshop, аддон Конфигурация, вкладка Безопасность, поле Поля для шифрования
$tsvshop['sysfields'] = "dateorder,datepay,status,fio,total,topay,comments,adress,city,region,province,zip,tracking,phone,email,commentadmin,subtotal,nalog,code,userid,discount,discountnum,shipping,shiptype,payments";
//список меток аддона Заказы, которые используются в чанках Shop_Cart, Shop_Checkout, которые нельзя вырезать.
$tsvshop['syslabels']="noempty,empty,subtotal,total,buttons,repeat,full,table";

if (!function_exists("tsv_PriceFormat")) {

    function tsv_PriceFormat($price) {
        global $tsvshop;
		$price = (empty($price)) ? 0 : $price;
        $decimal = ($tsvshop['PriceFormat'] == "0" || $tsvshop['PriceFormat'] == "") ? 0 : 2;
        return number_format($price, $decimal, '.', '');
    }

}

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
                    'theme'    => $theme,
                    'mgrdir'  => MGR_DIR
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
                          $temp= str_replace('[+statussel+]','<select name="status" id="chst'.$row['numorder'].'" onchange="chst(\''.((int)$_GET['id']).'\',\''.((int)$_GET['a']).'\',\'/'.MGR_DIR.'/index.php\',document.getElementById(\'chst'.$row['numorder'].'\'),\''.$row['numorder'].'\',updst);return false">'.buildstatus($value, explode("||",$tsvshop['StatusOrder'])).'</select>',$temp);
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
    //$user=$modx->userLoggedIn();
    $user=$modx->getLoginUserType();
    $output = "";
    $output_sales_notice="";
    $output_sales_error="";
    $act=$_GET['act'];

    //if ($user['usertype']=="manager") {
    if ($user=="manager") {
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
    //$user=$modx->userLoggedIn();
    $user=$modx->getLoginUserType();
    $output = "";
    $output_sales_notice="";
	  $output_sales_error="";
    $act=$_GET['act'];

    //if ($user['usertype']=="manager") {
    if ($user=="manager") {
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
    //$user=$modx->userLoggedIn();
    $user=$modx->getLoginUserType();
    $output = "";
    $output_sales_notice="";
	  $output_sales_error="";
    $act=$_GET['act'];

    //if ($user['usertype']=="manager") {
    if ($user=="manager") {
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
    global $modx, $shop_lang, $tsvshop, $cache;
    //$user=$modx->userLoggedIn();
    $user=$modx->getLoginUserType();
    $output = "";
    $output_sales_notice="";
    $output_sales_error="";
    $act=$_GET['act'];
    $subtotal = 0;

    $folders = $cache->cache('folders','tsvshop');
    if (!is_array($tsvshop['sysfields'])) $tsvshop['sysfields'] = explode(',',$tsvshop['sysfields']);
    if (!is_array($tsvshop['customfields'])) $tsvshop['customfields'] = explode(',',$tsvshop['customfields']);
    $tsvshop['sysfields'] = array_merge($tsvshop['sysfields'],$tsvshop['customfields']);
    foreach ($folders as $folder) {
      if ($folder != "."  && $folder != ".." ) {
         if (!is_array($tsvshop['cf_'.$folder])) $tsvshop['cf_'.$folder] = explode(',',$tsvshop['cf_'.$folder]);
         $tsvshop['sysfields'] = array_merge($tsvshop['sysfields'],$tsvshop['cf_'.$folder]);
      }
    }

    if ($user=="manager") {
        if (!empty($act) && $act=="updateorder" && !empty($idorder) && is_numeric(intval($idorder)) && $idorder !="0") {
          // ищем данные о товарах в REQUEST  v5.4.1----
          if (!empty($_REQUEST['item'])) {
            foreach ($_REQUEST['item'] as $key=>$val) {
               $res = $modx->db->update( $val, $tsvshop['dborders_details'], 'id = ' . intval($key) );
                    $summa = $val['price']*$val['quantity'];
                    $subtotal = $subtotal + $summa;
            }
          }

          //---v5.4.1----
          $sysfielad = array_unique($tsvshop['sysfields']);
          $sfields = explode(",", $tsvshop['SecFields']);
          foreach ($_GET as $key => $value) {
            if (in_array($key,$sysfielad)) {
                 if (in_array($key, $sfields)) {
                    $value = CryptMessage($value, $tsvshop['SecPassword']);
                 }
              $fields[$key] = $modx->db->escape($value);
            }
          }
          //пересчет и добавление итоговых сумм  ---v5.4.1----
          $fields['subtotal'] = $subtotal;
          $fields['discountsize'] = tsv_PriceFormat(($fields['subtotal']*$fields['discount'])/100);
          $fields['total'] = tsv_PriceFormat(($fields['subtotal']+$fields['shipping']+$fields['nalog'])-$fields['discountsize']);

          //------
          //updateMail($modx->db->escape($_GET['status']),$idorder);
          if ($modx->db->update( $fields, $tsvshop['dborders'], 'numorder = "' . intval($idorder) . '"' )) {
              //Запускаем событие TSVshopOnOrderStatusUpdate
              $modx->invokeEvent("TSVshopOnOrderStatusUpdate",array("idorder"=>$idorder, "newstatus"=>$modx->db->escape($_GET['status'])));
              updateMail($modx->db->escape($_GET['status']),$idorder);
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
    $user=$modx->getLoginUserType();
    //$user=$modx->userLoggedIn();
    $output = "";
    $output_sales_notice="";
    $output_sales_error="";
    $act=$_GET['act'];

    //if ($user['usertype']=="manager") {
    if ($user=="manager") {
       	if (!empty($act) && $act=="updstorder" && !empty($idorder) && is_numeric(intval($idorder)) && $idorder !="0") {
            if ($_GET['status'] == "Оплачено") $fields['datepay'] = time();
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
    $tsvshop['SmtpFromEmail'] = (!empty($tsvshop['SmtpFromEmail'])) ? $tsvshop['SmtpFromEmail'] : $modx->config['emailsender'];
	  $tsvshop['SmtpFromName'] = (!empty($tsvshop['SmtpFromName'])) ? $tsvshop['SmtpFromName'] : $modx->config['site_name'];
    $modx->loadExtension('MODxMailer');
		$modx->mail->ClearAllRecipients();
    $modx->mail->ClearAttachments();
		$modx->mail->Body = $body;
		$modx->mail->isHTML($isHTML);
		$modx->mail->CharSet = $modx->config['modx_charset'];
		$modx->mail->From = $tsvshop['SmtpFromEmail'];
		$modx->mail->FromName = $tsvshop['SmtpFromName'];
		$modx->mail->Subject = $subject;


		$from = explode(',',$tsvshop['SmtpFromEmail']);
        	if (is_array($from)) {
			     $modx->mail->From = trim($from[0]);
			     $modx->mail->Sender   = trim($from[0]);
			     $modx->mail->AddReplyTo(trim($from[0]), $modx->config['site_name']);
		    } else {
			     $modx->mail->From = trim($tsvshop['SmtpFromEmail']);
			     $modx->mail->Sender   = trim($tsvshop['SmtpFromEmail']);
			     $modx->mail->AddReplyTo(trim($tsvshop['SmtpFromEmail']), $modx->config['site_name']);
		    }

		//5.4 Можно добавлять несколько адресов почты, через запятую
		if(!is_array($emails)) {
        		$emails = explode(",",$emails);
		}
		if(is_array($emails))
		{
			foreach($emails as $name => $email)
			{
				$name = (is_string($name)) ? $name : '';
				$modx->mail->AddAddress($email, $name);
			}
		}
		elseif(is_string($emails)) {
		  $modx->mail->AddAddress($emails);
    }
    //$mail->SetFrom($tsvshop['SmtpFromEmail'], $tsvshop['SmtpFromName']); //от кого (желательно указывать свой реальный e-mail на используемом SMTP сервере
  	$modx->mail->AddReplyTo($tsvshop['SmtpReplyEmail'], $tsvshop['SmtpFromName']);

		return ($modx->mail->Send() ? true : false);
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
    //$user=$modx->userLoggedIn();
    $user=$modx->getLoginUserType();
    $out = "";
    $output_sales_notice="";
	  $output_sales_error="";
    $temp = "";
    $subtotal = 0;
    $act=$_GET['act'];
    $id=_filter($_GET['idorder'],1);
    $filename = (empty($filename)) ? TSVSHOP_PATH.'addons/sales/tpl/orderview.tpl' : $filename;
    if ($user=="manager") {
      if (!empty($act) && $act=="vieworder" && $tables['sales']!="none" && $tsvshop['dborders']!="" && !empty($id) && is_numeric($id)) {
        if ($res = $modx->db->select('*', $tsvshop['dborders'], 'numorder = "' . $id . '"','numorder','1' )) {
           $row = $modx->db->getRow($res);
           $url="index.php";

           $tpl=get_file_contents($filename);
           $row1=array('moduleurl'      => $url,
                       'modulea'  => $modulea,
                       'moduleid' => $moduleid,
                       'theme'    => $theme,
                       'mgrdir'  => MGR_DIR
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
             if ($key=="shipping") {$shipping = $value;}
             if ($key=="nalog") {$nalog = $value;}
             if ($key=="discount") {$discount = $value;}
             if ($key!="subtotal" && $key!="total" && $key!="topay" && $key!="discountsize") {
                if (!empty($value)) $tpl = str_replace('[+'.$key.'+]', $value, $tpl);
             }
           }

           if ($res = $modx->db->select('*', $tsvshop['dborders_details'], 'numorder = "' . $id . '"','numorder' )) {

             while ($order = $modx->db->getRow($res))  {
               $row = array_merge($row,$order);
			         $r++;
               $temp = str_replace('[+moduleid+]', $_GET['id'], $tpltr);
               foreach ($order as $key => $value) {

                 if (!empty($value)) $temp = str_replace('[+'.$key.'+]', $value, $temp);
                 if ($key == 'price') {
                    $summa = $value*$order['quantity'];
                    $temp = str_replace('[+summa+]', tsv_PriceFormat($summa), $temp);
                    $subtotal = $subtotal + $summa;
                 }
               }
               $temp = str_replace('[+num+]', $r, $temp);
               $out.=$temp;
             }
             $out = str_replace($tpltr,$out,$tpl);

             //подсчет и заполнение итоговых сумм
             $discountsize = ($subtotal*$discount)/100;
             $total = ($subtotal+$shipping+$nalog)-$discountsize;
             //echo 'subtotal='.$subtotal.": shipping=".$shipping."; nalog=".$nalog."; discountsize=".$discountsize."; total=".$total;
             $out = str_replace('[+total+]', tsv_PriceFormat($total), $out);
             $out = str_replace('[+topay+]', tsv_PriceFormat($total), $out);
             $out = str_replace('[+subtotal+]', tsv_PriceFormat($subtotal), $out);
             $out = str_replace('[+discountsize+]', tsv_PriceFormat($discountsize), $out);

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
