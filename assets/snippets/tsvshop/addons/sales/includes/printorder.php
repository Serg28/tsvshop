<?php

/**
 * TSVreceiptAdmin
 *
 * Сниппет для печати накладной
 *
 * @category    snippet
 * @version     1.1
 * @license     Перепродажа готового продукта и любых других его частей, а также копирование и распространение исходного кода запрещены.
 * @internal    @properties
 * @internal    @modx_category TSVshop
 * @internal    @installset base, sample
 *
 * @author      Serg24 <privat_tel@mail.ru>, http://tsvshop.xyz
 * -----------------------------------------------------------------------------
 */
if (!IN_TSVSHOP_MODE) {
    die();
}
defined('IN_TSVSHOP_MODE') or die();
global $modx, $tsvshop;
//require_once(TSVSHOP_PATH.'addons/payments/payments/receipt/functions.inc.php');
include (TSVSHOP_PATH . 'include/config.inc.php');
$tsvshop['tplprintorder'] = !empty($tplprintorder) ? $tplprintorder : "@FILE:assets/snippets/tsvshop/addons/sales/tpl/Shop_PrintOrder.tpl";


if (!function_exists("tsv_PriceFormat")) {

    function tsv_PriceFormat($price) {
        global $tsvshop;
        $price   = (empty($price)) ? 0 : $price;
        $decimal = ($tsvshop['PriceFormat'] == "0" || $tsvshop['PriceFormat'] == "") ? 0 : 2;
        return number_format($price, $decimal, '.', '');
    }

}


if (!function_exists("propis")) {

    function propis($price) {
        global $tsvshop;
        //цена прописью
        $price = (isset($price)) ? $price : '0';
        $price = number_format((double) $price, 2, ',', '');
        $point = strpos($price, ',');
        //отделяем рубли от копеек
        if (!empty($point)) {
            $rub = substr($price, 0, $point);
            $kop = substr($price, $point + 1);
        }
        //преобразуем рубли
        $str             = write_number_in_words($rub);
        //пишем рублей(ь,я)
        //$word = " рублей";
        $word            = $tsvshop['MonetarySymbol'];
        //последнее число
        $last_digit      = $rub[(strlen($rub) - 1)];
        //предпоследнее число
        $pred_last_digit = $rub[(strlen($rub) - 2)];
        if ($last_digit == '1' && $pred_last_digit != '1')
        //$word = " рубль";
            $word            = $tsvshop['MonetarySymbol'];
        elseif (($last_digit == '2' || $last_digit == '3' || $last_digit == '4') && $pred_last_digit != '1')
        //$word = " рубля";
            $word            = $tsvshop['MonetarySymbol'];
        $str             .= $word;
        //преобразуем копейки
        if (!empty($kop)) {

            $str             .= write_number_in_words($kop, 'femininum');
            //пишем копейка (и, ек)
            $word            = " копеек";
            //последнее число
            $last_digit      = $kop[(strlen($kop) - 1)];
            //предпоследнее число
            $pred_last_digit = $kop[(strlen($kop) - 2)];
            if ($last_digit == '1' && $pred_last_digit != '1')
                $word            = " копейка";
            elseif (($last_digit == '2' || $last_digit == '3' || $last_digit == '4') && $pred_last_digit != '1')
                $word            = " копейки";
            $str             .= $word;
        }
        return $str;
    }

}

if (!function_exists("write_number_in_words")) {

    //допустимый диапазон чисел 0 .. 999999
    //число прописью
    function write_number_in_words($num, $genus = 'masculinum') {
        //разряд: единицы, десятки, сотни, тысячи
        $cur_order           = "единицы";
        $cur_thousands_order = "единицы";
        if ($num == 0)
            return " 00";
        $num                 = strval($num);
        $limit               = strlen($num) - 1;
        for ($i = $limit; $i >= 0; $i--) {
            //тысячный разряд
            if ($cur_order == "тысячи") {
                //сотни
                if ($cur_thousands_order == "сотни") {
                    $str = write_units_hundreds($num[$i]) . $str;
                }
                //десятки
                if ($cur_thousands_order == "десятки") {
                    $str                 = write_units_tens($num[$i], $next_digit) . $str;
                    $cur_thousands_order = "сотни";
                    $next_digit          = '';
                }
                //единицы
                if ($cur_thousands_order == "единицы") {
                    if ($num[$i - 1] == "1") {
                        $next_digit = $num[$i];
                        $str        = " тысяч" . $str;
                    } else
                        $str                 = write_units_thousands_units($num[$i]) . $str;
                    $cur_thousands_order = "десятки";
                }
            }
            //сотни
            if ($cur_order == "сотни") {
                $str       = write_units_hundreds($num[$i]) . $str;
                $cur_order = "тысячи";
            }
            //десятки
            if ($cur_order == "десятки") {
                $str        = write_units_tens($num[$i], $next_digit) . $str;
                $cur_order  = "сотни";
                $next_digit = '';
            }
            //единицы
            if ($cur_order == "единицы") {
                if ($num[$i - 1] == "1")
                    $next_digit = $num[$i];
                else
                    $str        = write_units($num[$i], $genus);
                $cur_order  = "десятки";
            }
        }
        return($str);
    }

}
if (!function_exists("write_units_tens")) {

    //принадлежит функции write_number_in_words
    //преобразует десятки
    function write_units_tens($tens, $next_digit) {
        $tens     .= $next_digit;
        if ($tens == 2)
            $str_tens = " двадцать";
        if ($tens == 3)
            $str_tens = " тридцать";
        if ($tens == 4)
            $str_tens = " сорок";
        if ($tens == 5)
            $str_tens = " пятьдесят";
        if ($tens == 6)
            $str_tens = " шестьдесят";
        if ($tens == 7)
            $str_tens = " семьдесят";
        if ($tens == 8)
            $str_tens = " восемьдесят";
        if ($tens == 9)
            $str_tens = " девяносто";
        if ($tens == 10)
            $str_tens = " десять";
        if ($tens == 11)
            $str_tens = " одиннадцать";
        if ($tens == 12)
            $str_tens = " двенадцать";
        if ($tens == 13)
            $str_tens = " тринадцать";
        if ($tens == 14)
            $str_tens = " четырнадцать";
        if ($tens == 15)
            $str_tens = " пятнадцать";
        if ($tens == 16)
            $str_tens = " шестнадцать";
        if ($tens == 17)
            $str_tens = " семнадцать";
        if ($tens == 18)
            $str_tens = " восемнадцать";
        if ($tens == 19)
            $str_tens = " девятнадцать";
        return($str_tens);
    }

}

if (!function_exists("write_units_hundreds")) {

    //принадлежит функции write_number_in_words
    //преобразует сотни
    function write_units_hundreds($hundreds) {
        if ($hundreds == 1)
            $str_hundreds = " сто";
        if ($hundreds == 2)
            $str_hundreds = " двести";
        if ($hundreds == 3)
            $str_hundreds = " триста";
        if ($hundreds == 4)
            $str_hundreds = " четыреста";
        if ($hundreds == 5)
            $str_hundreds = " пятьсот";
        if ($hundreds == 6)
            $str_hundreds = " шестьсот";
        if ($hundreds == 7)
            $str_hundreds = " семьсот";
        if ($hundreds == 8)
            $str_hundreds = " восемьсот";
        if ($hundreds == 9)
            $str_hundreds = " девятьсот";
        return($str_hundreds);
    }

}

if (!function_exists("write_units_thousands_units")) {

    //принадлежит функции write_number_in_words
    //преобразует единицы тысячного разряда
    function write_units_thousands_units($hundreds) {
        if ($hundreds == 0)
            $str_hundreds = " тысяч";
        if ($hundreds == 1)
            $str_hundreds = " одна тысяча";
        if ($hundreds == 2)
            $str_hundreds = " две тысячи";
        if ($hundreds == 3)
            $str_hundreds = " три тысячи";
        if ($hundreds == 4)
            $str_hundreds = " четыре тысячи";
        if ($hundreds == 5)
            $str_hundreds = " пять тысяч";
        if ($hundreds == 6)
            $str_hundreds = " шесть тысяч";
        if ($hundreds == 7)
            $str_hundreds = " семь тысяч";
        if ($hundreds == 8)
            $str_hundreds = " восемь тысяч";
        if ($hundreds == 9)
            $str_hundreds = " девять тысяч";
        return($str_hundreds);
    }

}
//принадлежит функции write_number_in_words
//преобразует единицы
if (!function_exists("write_units")) {

    function write_units($units, $genus = 'masculinum') {
        if ($genus == 'masculinum') {
            if ($units == 1)
                $str_units = " один";
            if ($units == 2)
                $str_units = " два";
        }
        if ($genus == 'femininum') {
            if ($units == 1)
                $str_units = " одна";
            if ($units == 2)
                $str_units = " две";
        }
        if ($units == 3)
            $str_units = " три";
        if ($units == 4)
            $str_units = " четыре";
        if ($units == 5)
            $str_units = " пять";
        if ($units == 6)
            $str_units = " шесть";
        if ($units == 7)
            $str_units = " семь";
        if ($units == 8)
            $str_units = " восемь";
        if ($units == 9)
            $str_units = " девять";
        return($str_units);
    }

}

if (!function_exists("get_date")) {

//функции для конвертации даты
    function get_date($date) {
        $pubDay  = date('d', $date);
        $pubYear = date('Y', $date) . ' г.';
        switch (date('m', $date)) {
            case '01':
                $pubMonth = 'января';
                break;
            case '02':
                $pubMonth = 'февраля';
                break;
            case '03':
                $pubMonth = 'марта';
                break;
            case '04':
                $pubMonth = 'апреля';
                break;
            case '05':
                $pubMonth = 'мая';
                break;
            case '06':
                $pubMonth = 'июня';
                break;
            case '07':
                $pubMonth = 'июля';
                break;
            case '08':
                $pubMonth = 'августа';
                break;
            case '09':
                $pubMonth = 'сентября';
                break;
            case '10':
                $pubMonth = 'октября';
                break;
            case '11':
                $pubMonth = 'ноября';
                break;
            case '12':
                $pubMonth = 'декабря';
                break;
        }
        return $pubDay . " " . $pubMonth . " " . $pubYear;
    }

}

if (!function_exists("get_date_order")) {

    function get_date_order($date) {
        // Разбиение строки в 3 части - date, time and AM/PM
        $dt_elements   = explode(' ', $date);
        // Разбиение даты
        $date_elements = explode('-', $dt_elements[0]);
        // Разбиение времени
        $time_elements = explode(':', $dt_elements[1]);
        // Если у нас время в формате PM мы можем добавить 12 часов для получения  24 часового формата времени
        if ($dt_elements[2] == 'PM') {
            $time_elements[0] += 12;
        }
        // вывод результата
        return get_date(mktime($time_elements[0], $time_elements[1], $time_elements[2], $date_elements[1], $date_elements[2], $date_elements[0]));
    }

}

function tsv_getOrderData() {
    global $modx, $tsvshop;
    $dborders         = $modx->getFullTableName('shop_order');
    $dborders_details = $modx->getFullTableName('shop_order_detail');
    //$userid=$modx->getLoginUserID();
    $i                = explode(":", _filter($_GET['i'], 1));
    $n                = $i[0];
    $c                = $i[1];
    //if (!empty($n) && !empty($c) && !empty($userid)) {
    if (!empty($n) && !empty($c)) {
        //$res = $modx->db->select('*', $dborders, 'numorder = "'.$n.'" AND code="'.$c.'" AND userid="'.$userid.'"','numorder','1' );
        $res           = $modx->db->select('*', $dborders, 'numorder = "' . $n . '" AND code="' . $c . '"', 'numorder', '1');
        $orders        = $modx->db->select('*', $dborders_details, 'numorder = "' . $n . '"', 'numorder');
        $out           = $modx->db->makeArray($res);
        $out['orders'] = $modx->db->makeArray($orders);
        return $out;
    }
}

$orderdata = tsv_getOrderData();
$output    = '';
if (is_array($orderdata) && !empty($tsvshop['tplprintorder'])) {
    $tplcheck   = getTpl($tsvshop['tplprintorder']);
    $tablecheck = preg_replace("#.*?(<!--table-->(.*?)<!--/table-->|$)#is", "$2", $tplcheck);
    $r          = 0;
    $table      = "";
    $items      = 0;
    foreach ($orderdata['orders'] as $order) {
        $r++;
        $tablecheck1 = $tablecheck;
        foreach ($order as $key => $val) {
            if ($key == 'price') {
                $summa       = $val * $order['quantity'];
                $tablecheck1 = str_replace("[+shop.order.summa+]", tsv_PriceFormat($summa), $tablecheck1);
                $tablecheck1 = str_replace("[+shop.order.price+]", tsv_PriceFormat($val), $tablecheck1);
            } elseif ($key == 'id') {
                $tablecheck1 = str_replace("[+shop.order.id+]", $order['url'], $tablecheck1);
            } elseif ($key == 'quantity') {
                $tablecheck1 = str_replace("[+shop.order.qty+]", $order['quantity'], $tablecheck1);
                $items       = $items + $order['quantity'];
            } elseif ($key == 'name') {
                $name        = str_replace("rdquo", ")", $order['name']);
                $name        = str_replace("ldquo", "(", $name);
                $tablecheck1 = str_replace("[+shop.order.name+]", $name, $tablecheck1);
            } else {
                if (!empty($val))
                    $tablecheck1 = str_replace("[+shop.order." . $key . "+]", $val, $tablecheck1);
            }
            $tablecheck1 = str_replace("[+shop.order.num+]", $r, $tablecheck1);
        }
        $table .= $tablecheck1;
    }
    //v1.1 введено поле topay.
    //обратная совместимость с TSVshop версиями ниже 5.3
    //проверка, есть ли поле topay. Если да, берем его как сумма к оплате. Иначе - total
    $totalkey = (isset($orderdata[0]['topay'])) ? 'topay' : 'total';
    $tplcheck = str_replace($tablecheck, $table, $tplcheck);

    $orderdata[0][$totalkey]      = tsv_PriceFormat($orderdata[0][$totalkey]);
    $orderdata[0]['shipping']     = tsv_PriceFormat($orderdata[0]['shipping']);
    $orderdata[0]['discountsize'] = tsv_PriceFormat($orderdata[0]['discountsize']);
    $orderdata[0]['tax']          = tsv_PriceFormat($orderdata[0]['tax']);
    $orderdata[0]['subtotal']     = tsv_PriceFormat($orderdata[0]['subtotal']);

    $orderdata[0]['count']        = $r;
    $orderdata[0]['totalcount']   = $items;
    $orderdata[0]['datecreate']   = get_date($orderdata[0]['dateorder']);
    $orderdata[0]['total_propis'] = propis($orderdata[0][$totalkey]);
    foreach ($orderdata[0] as $key => $val) {
        if (in_array($key, explode(",", $tsvshop['SecFields']))) {
            $val = DeCryptMessage($val, $tsvshop['SecPassword']);
        }
        $tplcheck = str_replace("[+shop.order." . $key . "+]", $val, $tplcheck);
    }
    echo $tplcheck;
}
?>
