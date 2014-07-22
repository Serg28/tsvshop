<?

/************************************************
*           MDS-Script                          *
*     08.09.2008                                *
*     powered by DIMON                          *
*     email: kafu82@list.ru                     *
*     url: http://mds-script.org.ua             *
*     Copyright (c) 2008 MDS-Script             *
*     All rights reserved.                      *
*                                               *
************************************************/ 
/************************************************
*                                               *
*     Скрипт автоматической оплаты WebMoney     *
*                                               *
************************************************/

include "config.inc";


/****************** обработка предварительного запроса merchant *********************************/	
if (isset($_POST['LMI_PREREQUEST']))
{
	$currency = $_POST['CURRENCY'];
	$purse = $_POST['PURSE'];
	$amount = $_POST['AMOUNT'];
	$lmi_pre_payee_purse = $_POST['LMI_PAYEE_PURSE'];
	$lmi_pre_payment_amount = $_POST['LMI_PAYMENT_AMOUNT'];
	$lmi_pre_payment_no = $_POST['LMI_PAYMENT_NO'];
	$lmi_mode = $_POST['LMI_MODE'];
	$lmi_pre_payer_purse = $_POST['LMI_PAYER_PURSE'];
	$lmi_pre_payer_wm = $_POST['LMI_PAYER_WM'];


	$cur_index['WMZ'] = 0;
	$cur_index['WME'] = 1;
	$cur_index['WMU'] = 2;
	$cur_index['WMR'] = 3;
	$i=$cur_index[$currency];


	if ($lmi_mode == 1)
	{
		$error = 1;
		$error_text = "LMI_MODE=1 This is a Test Mode!";
	}



	switch($i)
	{
		case 0:
			if ($lmi_pre_payee_purse !== $wmz_purse)
			{
				$error = 1;
				$error_text = "Wrong LMI_PAYEE_PURSE";
			}
			break;
		case 1:
			if ($lmi_pre_payee_purse !== $wme_purse)
			{
				$error = 1;
				$error_text = "Wrong LMI_PAYEE_PURSE";
			}
			break;
		case 2:
			if ($lmi_pre_payee_purse !== $wmu_purse)
			{
				$error = 1;
				$error_text = "Wrong LMI_PAYEE_PURSE";
			}
			break;
		case 3:
			if ($lmi_pre_payee_purse !== $wmr_purse)
			{
				$error = 1;
				$error_text = "Wrong LMI_PAYEE_PURSE";
			}
			break;
		default: 
			$error = 1;
			$error_text = "Unknown CURRENCY";
	}

	if ($error=="")
	{
		echo "YES";



/****************** отправка уведомления *****************************/
		// отправка админу сообщения
		$headers=null; // Настройки для отправки писем
		$headers.="Content-Type: text/html; charset=windows-1251\r\n";
		$headers.="From: Admin <".$email_admin.">\r\n";
		$headers.="X-Mailer: PHP/".phpversion()."\r\n";


		// собираем всю информацию в письме
		$message_admin = "CURRENCY: <b>$currency</b><br>LMI_PAYEE_PURSE: <b>$lmi_pre_payee_purse</b><br>LMI_PAYMENT_AMOUNT: <b>$lmi_pre_payment_amount</b><br>LMI_PAYMENT_NO: <b>$lmi_pre_payment_no</b><br>LMI_MODE: <b>$lmi_mode</b><br>LMI_PAYER_PURSE: <b>$lmi_pre_payer_purse</b><br>LMI_PAYER_WM: <b>$lmi_pre_payer_wm</b>"; 

			
		// отправляем сообщение	
		if ($mail_wmpreresult=="1")
		{
			mail($email_admin, "Предварительная обработка платежа прошла успешно $amount (№ $lmi_pre_payment_no)", $message_admin, $headers);
		}


	}
	else
	{
		echo $error_text;

/****************** отправка уведомления об ошибке *********************************/
		// отправка админу сообщения
		$headers=null; // Настройки для отправки писем
		$headers.="Content-Type: text/html; charset=windows-1251\r\n";
		$headers.="From: Admin <".$email_admin.">\r\n";
		$headers.="X-Mailer: PHP/".phpversion()."\r\n";


		// собираем всю информацию в письме
		$message_admin = "CURRENCY: <b>$currency</b><br>LMI_PAYEE_PURSE: <b>$lmi_pre_payee_purse</b><br>LMI_PAYMENT_AMOUNT: <b>$lmi_pre_payment_amount</b><br>LMI_PAYMENT_NO: <b>$lmi_pre_payment_no</b><br>LMI_MODE: <b>$lmi_mode</b><br>LMI_PAYER_PURSE: <b>$lmi_pre_payer_purse</b><br>LMI_PAYER_WM: <b>$lmi_pre_payer_wm</b><br>ERROR: <b>$error_text</b>"; 

			
		// отправляем сообщение	
		if ($mail_wmpreresult=="1")
		{
			mail($email_admin, "Ошибка при предварительной проверке платежа $error_text $amount (№ $lmi_pre_payment_no)", $message_admin, $headers);
		}

	}

}



/****************** обработка оповещения о платеже merchant *********************************/
if (isset($_POST['LMI_HASH']))
{
	$currency = $_POST['CURRENCY'];
	$purse = $_POST['PURSE'];
	$amount = $_POST['AMOUNT'];

	$lmi_payee_purse = $_POST['LMI_PAYEE_PURSE'];
	$lmi_payment_amount = $_POST['LMI_PAYMENT_AMOUNT'];
	$lmi_payment_no = $_POST['LMI_PAYMENT_NO'];
	$lmi_mode = $_POST['LMI_MODE'];
	$lmi_sys_invs_no = $_POST['LMI_SYS_INVS_NO'];
	$lmi_sys_trans_no = $_POST['LMI_SYS_TRANS_NO'];
	$lmi_payer_purse = $_POST['LMI_PAYER_PURSE'];
	$lmi_payer_wm = $_POST['LMI_PAYER_WM'];
	$lmi_paymer_number = $_POST['LMI_PAYMER_NUMBER'];
	$lmi_paymer_email = $_POST['LMI_PAYMER_EMAIL'];
	$lmi_telepat_phonenumber = $_POST['LMI_TELEPAT_PHONENUMBER'];
	$lmi_telepat_orderid = $_POST['LMI_TELEPAT_ORDERID'];
	$lmi_payment_creditdays = $_POST['LMI_PAYMENT_CREDITDAYS'];
	$lmi_hash = $_POST['LMI_HASH'];
	$lmi_sys_trans_date = $_POST['LMI_SYS_TRANS_DATE'];
	$lmi_secret_key = $_POST['LMI_SECRET_KEY'];

	$hash = $lmi_payee_purse.$lmi_payment_amount.$lmi_payment_no.$lmi_mode.$lmi_sys_invs_no.$lmi_sys_trans_no.$lmi_sys_trans_date.$wm_secret_key.$lmi_payer_purse.$lmi_payer_wm;

	$hash = strtoupper(md5($hash));
	$lmi_hash = strtoupper($lmi_hash);

	if ($lmi_hash == $hash)
	{

		if ($lmi_mode == 1)
		{
			$error = 1;
			$error_text = "LMI_MODE=1 This is a Test Mode!";
		}

		$cur_index['WMZ'] = 0;
		$cur_index['WME'] = 1;
		$cur_index['WMU'] = 2;
		$cur_index['WMR'] = 3;
		$i=$cur_index[$currency];


		switch($i)
		{
			case 0:
				if ($lmi_payee_purse !== $wmz_purse)
				{
					$error = 1;
					$error_text = "Wrong LMI_PAYEE_PURSE";
				}
				break;
			case 1:
				if ($lmi_payee_purse !== $wme_purse)
				{
					$error = 1;
					$error_text = "Wrong LMI_PAYEE_PURSE";
				}
				break;
			case 2:
				if ($lmi_payee_purse !== $wmu_purse)
				{
					$error = 1;
					$error_text = "Wrong LMI_PAYEE_PURSE";
				}
				break;
			case 3:
				if ($lmi_payee_purse !== $wmr_purse)
				{
					$error = 1;
					$error_text = "Wrong LMI_PAYEE_PURSE";
				}
				break;
			default: 
				$error = 1;
				$error_text = "Unknown CURRENCY";
		}


		if ($error=="")
		{

/*************** отправка уведомления *********************/
			// отправка админу сообщения
			$headers=null; // Настройки для отправки писем
			$headers.="Content-Type: text/html; charset=windows-1251\r\n";
			$headers.="From: Admin <".$email_admin.">\r\n";
			$headers.="X-Mailer: PHP/".phpversion()."\r\n";


			// собираем всю информацию в письме
			$message_admin = "CURRENCY: <b>$currency</b><br>LMI_PAYEE_PURSE: <b>$lmi_payee_purse</b><br>LMI_PAYMENT_AMOUNT: <b>$lmi_payment_amount</b><br>LMI_PAYMENT_NO: <b>$lmi_payment_no</b><br>LMI_PAYER_PURSE: <b>$lmi_payer_purse</b><br>LMI_PAYER_WM: <b>$lmi_payer_wm</b><br>LMI_MODE: <b>$lmi_mode</b><br>LMI_SYS_INVS_NO: <b>$lmi_sys_invs_no</b><br>LMI_SYS_TRANS_NO: <b>$lmi_sys_trans_no</b><br>LMI_SYS_TRANS_DATE: <b>$lmi_sys_trans_date</b>"; 

			
			// отправляем сообщение	
			if ($mail_wmresult=="1")
			{
				mail($email_admin, "Оповещение о платеже $amount (№ $lmi_payment_no)", $message_admin, $headers);
			}
		}
		//END error==""

		else
		{
			
/****************** отправка уведомления об ошибке платежа *********************************/
			// отправка админу сообщения
			$headers=null; // Настройки для отправки писем
			$headers.="Content-Type: text/html; charset=windows-1251\r\n";
			$headers.="From: Admin <".$email_admin.">\r\n";
			$headers.="X-Mailer: PHP/".phpversion()."\r\n";


			// собираем всю информацию в письме
			$message_admin = "CURRENCY: <b>$currency</b><br>LMI_PAYEE_PURSE: <b>$lmi_payee_purse</b><br>LMI_PAYMENT_AMOUNT: <b>$lmi_payment_amount</b><br>LMI_PAYMENT_NO: <b>$lmi_payment_no</b><br>LMI_PAYER_PURSE: <b>$lmi_payer_purse</b><br>LMI_PAYER_WM: <b>$lmi_payer_wm</b><br>LMI_MODE: <b>$lmi_mode</b><br>LMI_SYS_INVS_NO: <b>$lmi_sys_invs_no</b><br>LMI_SYS_TRANS_NO: <b>$lmi_sys_trans_no</b><br>LMI_SYS_TRANS_DATE: <b>$lmi_sys_trans_date</b><br>ERROR TEXT: <b>$error_text</b>"; 

			
			// отправляем сообщение	
			if ($mail_wmresult=="1")
			{
				mail($email_admin, "Оповещение о платеже. Ошибка: $error_text $amount (№ $lmi_payment_no)", $message_admin, $headers);
			}
		}
	
	}
	//END lmi_hash == hash

	else
	{
		$error_text = "Wrong LMI_HASH";
			
/**************** отправка уведомления об ошибке платежа ************************/
		// отправка админу сообщения
		$headers=null; // Настройки для отправки писем
		$headers.="Content-Type: text/html; charset=windows-1251\r\n";
		$headers.="From: Admin <".$email_admin.">\r\n";
		$headers.="X-Mailer: PHP/".phpversion()."\r\n";


		// собираем всю информацию в письме
		$message_admin = "CURRENCY: <b>$currency</b><br>LMI_PAYEE_PURSE: <b>$lmi_payee_purse</b><br>LMI_PAYMENT_AMOUNT: <b>$lmi_payment_amount</b><br>LMI_PAYMENT_NO: <b>$lmi_payment_no</b><br>LMI_PAYER_PURSE: <b>$lmi_payer_purse</b><br>LMI_PAYER_WM: <b>$lmi_payer_wm</b><br>LMI_MODE: <b>$lmi_mode</b><br>LMI_SYS_INVS_NO: <b>$lmi_sys_invs_no</b><br>LMI_SYS_TRANS_NO: <b>$lmi_sys_trans_no</b><br>LMI_SYS_TRANS_DATE: <b>$lmi_sys_trans_date</b><br>ERROR TEXT: <b>$error_text</b><br>LMI_HASH: <b>$lmi_hash</b><br>HASH: <b>$hash</b>"; 

			
		// отправляем сообщение	
		if ($mail_wmresult=="1")
		{
			mail($email_admin, "Ошибка платежа: $error_text $amount (№ $lmi_payment_no)", $message_admin, $headers);
		}


	}


}

?>