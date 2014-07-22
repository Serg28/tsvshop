<?php
// your registration data
$mrh_login = "floweryworld.ru";      // your login here
$mrh_pass1 = "domani12";   // merchant pass1 here

// order properties
$inv_id    = $numorder;   //номер счета
$inv_desc  = "Оплата товара в интенет-магазине цветов floweryworld.ru. Заказ ".$numorder;   // описание заказа
$out_summ  = $TOTAL; 

// build CRC value
$crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");

// build URL
$url = "http://test.robokassa.ru/Index.aspx?MrchLogin=$mrh_login&OutSum=$out_summ&InvId=$inv_id&Desc=$inv_desc&SignatureValue=$crc";//https://merchant.roboxchange.com/Index.aspx
header ("Location: $url");
?>