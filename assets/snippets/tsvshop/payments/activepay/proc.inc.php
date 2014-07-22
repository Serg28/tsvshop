<?php
require "ActivePay.php";

$a = new ActivePay;
$a->secret_key = "seCre%6fG7";
$a->merchant_contract = "187";

$mass = array("amount" => $TOTAL,
        "currency" => "RUB",
        "merchant_data" => $numorder,
        "merchant_description" => "Оплата товара в интернет-магазине цветов floweryworld.ru",
        "redirect_url_ok" => $modx->config['site_url']."success.html",
        "redirect_url_failed" => $modx->config['site_url']."error.html",
        "test" => "true");
$URL = $a->build_merchant_pages_url($mass);
header ("Location: $URL");
?>