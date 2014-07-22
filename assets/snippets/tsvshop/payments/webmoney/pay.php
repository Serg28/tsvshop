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

error_reporting (E_ALL);

include "config.inc";

/******************* если платеж прошел успешно *************************/
if (isset($_GET['success']))
{
	$purse = $_POST['PURSE'];
	$amount = $_POST['AMOUNT'];
	$lmi_sys_invs_no = $_POST['LMI_SYS_INVS_NO'];
	$lmi_sys_trans_no = $_POST['LMI_SYS_TRANS_NO'];
	$lmi_payment_no = $_POST['LMI_PAYMENT_NO'];
	$lmi_sys_trans_date = $_POST['LMI_SYS_TRANS_DATE'];


/****************** отправка уведомления *********************************/
	// отправка админу сообщения
	$headers=null; // Настройки для отправки писем
	$headers.="Content-Type: text/html; charset=windows-1251\r\n";
	$headers.="From: Admin <".$email_admin.">\r\n";
	$headers.="X-Mailer: PHP/".phpversion()."\r\n";


	// собираем всю информацию в письме
	$message_admin = "<br>PURSE: <b>$purse</b><br>AMOUNT: <b>$amount</b>br>LMI_PAYMENT_NO: <b>$lmi_payment_no</b><br>LMI_SYS_INVS_NO: <b>$lmi_sys_invs_no</b><br>LMI_SYS_TRANS_NO: <b>$lmi_sys_trans_no</b><br>LMI_SYS_TRANS_DATE: <b>$lmi_sys_trans_date</b>"; 

			
	// отправляем сообщение	
	if ($mail_wmsuccess=="1")
	{
		mail($email_admin, "Платеж успешно проведен $amount (№ $lmi_payment_no)", $message_admin, $headers);
	}

	print "<h2>Платеж успешно проведен</h2>";

	print "<h3>Данные платежа</h3>";

	print "<table width=\"60%\" cellspacing=\"2\" cellpadding=\"0\" class=\"tablehistory\">	<tr class=\"trdatauser1\"><td class=\"tddatahistory\" nowrap>";
	print "На кошелек:</td><td class=\"tddatahistory\" nowrap>";
	print $purse;
	print "</tr><tr class=\"trdatauser2\"><td class=\"tddatahistory\" nowrap>";
	print "Сумма:</td><td class=\"tddatahistory\" nowrap>";
	print $amount;
	print "</tr><tr class=\"trdatauser1\"><td class=\"tddatahistory\" nowrap>";
	print "Номер в системе:</td><td class=\"tddatahistory\" nowrap>";
	print $lmi_payment_no;
	print "</tr><tr class=\"trdatauser1\"><td class=\"tddatahistory\" nowrap>";
	print "SYS_INVS_NO:</td><td class=\"tddatahistory\" nowrap>";
	print $lmi_sys_invs_no;
	print "</tr><tr class=\"trdatauser2\"><td class=\"tddatahistory\" nowrap>";
	print "SYS_TRANS_NO</td><td class=\"tddatahistory\" nowrap>";
	print $lmi_sys_trans_no;
	print "</tr><tr class=\"trdatauser1\"><td class=\"tddatahistory\" nowrap>";
	print "Дата платежа:</td><td class=\"tddatahistory\" nowrap>";
	print $lmi_sys_trans_date;
	print "</tr></table>";

}


/******************* если возникла ошибка платежа *************************/
elseif (isset($_GET['fail']))
{
	$purse = $_POST['PURSE'];
	$amount = $_POST['AMOUNT'];
	$lmi_sys_invs_no = $_POST['LMI_SYS_INVS_NO'];
	$lmi_sys_trans_no = $_POST['LMI_SYS_TRANS_NO'];
	$lmi_payment_no = $_POST['LMI_PAYMENT_NO'];
	$lmi_sys_trans_date = $_POST['LMI_SYS_TRANS_DATE'];

/****************** отправка уведомления *********************************/
	// отправка админу сообщения
	$headers=null; // Настройки для отправки писем
	$headers.="Content-Type: text/html; charset=windows-1251\r\n";
	$headers.="From: Admin <".$email_admin.">\r\n";
	$headers.="X-Mailer: PHP/".phpversion()."\r\n";


	// собираем всю информацию в письме
	$message_admin = "<br>PURSE: <b>$purse</b><br>AMOUNT: <b>$amount</b><br>LMI_PAYMENT_NO: <b>$lmi_payment_no</b><br>LMI_SYS_INVS_NO: <b>$lmi_sys_invs_no</b><br>LMI_SYS_TRANS_NO: <b>$lmi_sys_trans_no</b><br>LMI_SYS_TRANS_DATE: <b>$lmi_sys_trans_date</b>"; 

			
	// отправляем сообщение	
	if ($mail_wmfail=="1")
	{
		mail($email_admin, "Ошибка платежа $amount (№ $lmi_payment_no)", $message_admin, $headers);
	}

	print "<h2>Ошибка платежа!</h2>";

	print "<h3>Данные платежа</h3>";

	print "<table width=\"60%\" cellspacing=\"2\" cellpadding=\"0\" class=\"tablehistory\"><tr class=\"trdatauser1\"><td class=\"tddatahistory\" nowrap>";
	print "На кошелек:</td><td class=\"tddatahistory\" nowrap>";
	print $purse;
	print "</tr><tr class=\"trdatauser2\"><td class=\"tddatahistory\" nowrap>";
	print "Сумма:</td><td class=\"tddatahistory\" nowrap>";
	print $amount;
	print "</tr><tr class=\"trdatauser1\"><td class=\"tddatahistory\" nowrap>";
	print "Номер в системе:</td><td class=\"tddatahistory\" nowrap>";
	print $lmi_payment_no;
	print "</tr><tr class=\"trdatauser1\"><td class=\"tddatahistory\" nowrap>";
	print "SYS_INVS_NO:</td><td class=\"tddatahistory\" nowrap>";
	print $lmi_sys_invs_no;
	print "</tr><tr class=\"trdatauser2\"><td class=\"tddatahistory\" nowrap>";
	print "SYS_TRANS_NO</td><td class=\"tddatahistory\" nowrap>";
	print $lmi_sys_trans_no;
	print "</tr><tr class=\"trdatauser1\"><td class=\"tddatahistory\" nowrap>";
	print "Дата платежа:</td><td class=\"tddatahistory\" nowrap>";
	print $lmi_sys_trans_date;
	print "</tr></table>";
}
else
{
	include "form.html";
}

?>