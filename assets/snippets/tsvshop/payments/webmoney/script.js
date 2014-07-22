function SelectPurse()
{

 if (document.pay.select_currency.value == "WMZ")
 {
  
  document.pay.LMI_PAYEE_PURSE.value = document.pay.wmz_purse.value;
  
 }

 if (document.pay.select_currency.value == "WME")
 {
  
  document.pay.LMI_PAYEE_PURSE.value = document.pay.wme_purse.value;
  
 }

 if (document.pay.select_currency.value == "WMU")
 {
  
  document.pay.LMI_PAYEE_PURSE.value = document.pay.wmu_purse.value;
  
 }

 if (document.pay.select_currency.value == "WMR")
 {
  
  document.pay.LMI_PAYEE_PURSE.value = document.pay.wmr_purse.value;
  
 }

document.pay.CURRENCY.value = document.pay.select_currency.value;
document.pay.PURSE.value = document.pay.LMI_PAYEE_PURSE.value;
document.pay.AMOUNT.value = document.pay.LMI_PAYMENT_AMOUNT.value;

}


function CheckSum()
{

	if (document.pay.LMI_PAYMENT_AMOUNT.value == "")
	{
		alert( "”кажите сумму платежа - она не должна быть пустой!" );
		return(false);
	}

	if (document.pay.LMI_PAYMENT_AMOUNT.value <= 0)
	{
		alert( "—умма должна быть больше 0!" );
		return(false);
	}
}


