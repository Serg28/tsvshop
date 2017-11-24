<?php

global $TypeCat, $session, $cache;

if (!$cache) {
    include_once 'cache.class.php';
    $cache = fileCache::GetInstance(3600, MODX_BASE_PATH . 'assets/cache/');
}
if (!function_exists("session")) {

    function session($cache) {
        $session = (empty($_COOKIE['tsvshop'])) ? md5(uniqid(rand())) . 'hgT' : $_COOKIE['tsvshop'];
        SetCookie("tsvshop", $session, time() + 7200, "/"); //set the cookie to remain for 2 hours
        if ($cache) {
            $cache->cache("session", "tsvshop", $session);
        }
        return $session;
    }

}

$session = (!$session) ? session($cache) : $session;

if (!function_exists("tsv_PriceFormat")) {

    function tsv_PriceFormat($price) {
        global $tsvshop;
        $price = (empty($price)) ? 0 : $price;
        $decimal = ($tsvshop['PriceFormat'] == "0" || $tsvshop['PriceFormat'] == "") ? 0 : 2;
        return number_format($price, $decimal, '.', '');
    }

}

if (!function_exists("tsv_ConvertPrice")) {

    function tsv_ConvertPrice($txt) {
        if (strpos($txt, "||") === false) {
            echo str_replace('\r\n', '', $txt);
        } else {
            $pieces = explode("||", "||" . $txt);
            $i      = 0;
            $o      = "";
            $o2     = "";
            foreach ($pieces as $value) {
                $i++;
                if (strlen($value) > 0) {
                    $pos = strpos($value, "-");
                    if ($pos != false) {
                        $tmp  = substr($value, 0, $pos);
                        $o    .= "(( " . $tmp . "<=&#36n & ";
                        $pos2 = strpos($value, "==");
                        $tmp  = substr($value, $pos + 1, $pos2 - $pos - 1);
                        $o    .= $tmp . ">=&#36n)?( ";
                        $o2   .= "))";
                        $tmp  = substr($value, $pos2 + 2);
                        $o    .= $tmp . " ):( ";
                    } else {
                        $tmp = $value;
                        $o   .= $tmp;
                    }
                }
            }
            unset($tv);
            unset($value);
            unset($pieces);
            return "=" . $o . $o2;
        }
    }

}

if (!function_exists("tsv_TryCalc_old")) {

    function tsv_TryCalc_old($code, $col) {
        global $modx;
         $cod = str_replace(' ', '', $cod);
          $cod = str_replace(',', '.', $cod);
          $cod = str_replace('\r\n', '', $cod);
          if (strpos($cod, "||")) {
          $cod = tsv_ConvertPrice($cod);
          $a   = "";
          $cod = str_replace("&#36n", $col, $cod);
          $cod = str_replace("$n", $col, $cod);
          if (!$cod) {
          $cod = "\"\"";
          }
          if (substr($cod, -1) == '+')
          $cod .= '0';
          eval("\$a" . $cod . ";");
          return ($a * 1);
          } else {
          if (!$cod) {
          $cod = "\"\"";
          }
          if (substr($cod, -1) == '+')
          $cod .= '0';
          eval("\$a=" . $cod . ";");
          return ($a * 1);
          }
        /*
        $a    = "";
        $code = str_replace(array(' ', ',', '\r', '\n'), array('', '.', '', ''), $code);
        if (strpos($code, '||')) {
            $code = str_replace(
                    array('$n', '&#36n'), $col, tsv_ConvertPrice($code)
            );
        }
        $code = (!$code) ? "\"\"" : $code;
        if (substr($code, -1) == '+') {
            $code .= '0';
            eval('\$a' . $code . ';');
            return ($a * 1);
        }  */
    }

}

if (!function_exists("tsv_CalcPrice_old")) {

    function tsv_CalcPrice_old($price, $col, $opt) {
        //$opt = (!preg_match("/[^(\w)|(\+)|(\*)|(\-)|(\/)]/",$opt[0])) ? "+".$opt : $opt;
        /* $price = tsv_TryCalc($price, $col);
          $opt   = str_replace(" ", "+", $opt);
          $opt   = str_replace("#", "*", $opt);
          $price = tsv_TryCalc($price . $opt, $col);
          return $price; */

        $price = tsv_TryCalc($price, $col);
        $opt   = str_replace(array(' ', '#'), array('+', '*'), $opt);
        return tsv_TryCalc($price . $opt, $col);
    }

}


if(!function_exists("tsv_TryCalc"))
{
function tsv_TryCalc($cod,$col) {
	global $modx;
        $cod = str_replace(' ', '', $cod);
        $cod = str_replace(',', '.', $cod);
        $cod = str_replace('\r\n', '', $cod);
        if (strpos($cod, "||")){
            $cod=tsv_ConvertPrice($cod);
            $a="";
            $cod=str_replace("&#36n", $col, $cod);
            $cod=str_replace("$n", $col, $cod);
            if (!$cod) {$cod="\"\"";}
            if(substr($cod, -1)=='+')$cod.='0';
            eval("\$a".$cod.";");
            return ($a*1);
       } else {
            if (!$cod) {$cod="\"\"";}
            if(substr($cod, -1)=='+')$cod.='0';
            eval("\$a=".$cod.";");
            return ($a*1);
       }
}
}

if(!function_exists("tsv_CalcPrice"))
{
function tsv_CalcPrice($price, $col, $opt) {
  //$opt = (!preg_match("/[^(\w)|(\+)|(\*)|(\-)|(\/)]/",$opt[0])) ? "+".$opt : $opt;
	$price = tsv_TryCalc($price, $col);
	$opt = str_replace(" ","+", $opt);
	$opt = str_replace("#","*", $opt);
	$price = tsv_TryCalc($price.$opt, $col);
	return $price;
}
}



if (!function_exists("tsv_parseOptions")) {

    function tsv_parseOptions($opt) {
        $price  = 0;
        $fprice = 0;
        $i      = 0;
        $price  = '';
        if (is_array($txt    = explode(";", $opt))) {
            foreach ($txt as $sel1) {
                $option = explode(":", $sel1);
                $sel3   = explode("||", $option[1]);
                foreach ($sel3 as $sel4) {
                    $res = explode("==", $sel4);
                    if ($res[0]{0} == "*") {
                        if (!in_array($res[1]{0}, array('+', '-', '/', '*')))
                            $res[1] = '+' . $res[1];
                        $price  .= $res[1];
                    }
                    if ($i == 0) {
                        $fprice = $res[1];
                    }
                    $i++;
                }
            }
        }
        $price = ($i > 0) ? $price : $fprice;
        return $price;
    }

}


if (!function_exists("tsv_GetTovar")) {

    function tsv_GetTovar($cache, $idnum = false) {
        global $modx, $tsvshop;
        $item = array();
        if (empty($idnum)) {
            $idnum = _filter($_REQUEST['idnum']);
        }
        $cachevar = $cache->cache("item" . $idnum, 'tsvshop');
        if (!empty($cachevar)) {
            return $cachevar;
        } else {
            if ($tsvshop['TypeCat'] == "catalog") {
                $itemclass = MODX_BASE_PATH . 'assets/modules/tsvcatalog/shop/lib/class/items.class.php';
                if (file_exists($itemclass)) {
                    require_once($itemclass);
                    $doc                   = new Item($idnum);
                    $item['name']          = $doc->Get('name');
                    $item['tsvshop_param'] = $doc->Get('ptvtsvshop_param');
                    $articul               = $doc->Get('ptvarticul');
                    $item['articul']       = (!empty($articul)) ? $articul : $idnum;
                    $item['price']         = $doc->Get('ptvprice');
                }
            } else {
                $item            = $modx->getTemplateVarOutput(array(
                    'tsvshop_param',
                    'price',
                    'articul'
                        ), $modx->db->escape($idnum));
                $doc             = $modx->getDocument($idnum);
                $item['name']    = $doc[$tsvshop['namesource']];
                $item['articul'] = (!empty($item['articul'])) ? $item['articul'] : $idnum;
            }
            $cache->cache("item" . $idnum, 'tsvshop', $item);
            return $item;
        }
    }

}

if (!function_exists("tsv_GetPrice")) {

    function tsv_GetPrice($cache, $idnum = false) {
        /*
          global $modx, $items, $tsvshop;
          if (empty($idnum)) {
          $idnum = _filter($_REQUEST['idnum']);
          }
          $cachevar = $cache->cache("price" . $idnum, 'tsvshop');
          if (!empty($cachevar)) {
          ob_start();
          print $cachevar;
          ob_end_flush();
          } else {
          if ($tsvshop['TypeCat'] == "catalog") {
          if (file_exists($itemclass)) {
          require_once($itemclass);
          $tv = new Item($idnum);
          }
          } else {
          $tv = $modx->getTemplateVar('price', '*', $modx->db->escape($idnum));
          }
          if (!$tv) {
          exit(0);
          } else {
          if ($tsvshop['TypeCat'] == "catalog") {
          $txt = $tv->Get('ptvprice');
          } else {
          $txt = $tv['value'];
          }
          ob_start();
          print $txt;
          $cache->cache("price" . $idnum, 'tsvshop', ob_get_contents());
          ob_end_flush();
          }
          }
          }
         */
        $item = tsv_GetTovar($cache, $idnum);
        return $item['price'];
    }

}


// Add item to cart
if (!function_exists("tsv_add_item")) {

    function tsv_add_item($cache, $id, $name, $opt, $icon, $qty = 1, $url, $typeitem) {
        global $modx, $session, $tsvshop, $shop_lang;
        $validQty = false;
        $item     = array();
        $incart   = false;

// получаем данные о товаре из БД
        $item       = tsv_GetTovar($cache, $id);
        $shop_param = $item['tsvshop_param'];
        $price      = $item['price'];
        $articul    = $item['articul'];
        $name       = $item['name'] . $name;


        // If decimal quantities are enabled, verify the quantity is a positive float
        //if (filter_var($qty, FILTER_VALIDATE_INT) || filter_var($qty, FILTER_VALIDATE_FLOAT) && $qty > 0) {
        if (is_numeric($qty) || is_float($qty)) {
            $validQty = true;
        }

        // Add the item
        if ($validQty !== false) {

            $count = sizeof($_SESSION[$session]['orders']);

            for ($i = $count; $i >= 0; $i--) {
                $order = $_SESSION[$session]['orders'][$i];
                if ($order['id'] == $id && $order['name'] == $name) {
                    $_SESSION[$session]['orders'][$i]['qty'] += $qty;
                    $incart                                  = true;
                    $curid                                   = $i;
                }
            }
            if (!$incart) {
                if (!$icon) {
                    $icon = "assets/snippets/tsvshop/images/noimage.png";
                }
                $items                          = array(
                    'id'       => $id,
                    'name'     => $name,
                    'articul'  => $articul,
                    'price'    => $price,
                    'icon'     => $icon,
                    'qty'      => $qty,
                    'url'      => $url,
                    'opt'      => $opt,
                    'typeitem' => $typeitem
                );
                $_SESSION[$session]['orders'][] = $items;
                $curid                          = $count;
            }
            $return = 'success';
            // плагин TSVshopOnAddItem. Обработка массива с добавляемым товаром.
            $evt    = $modx->invokeEvent("TSVshopOnAddItem", array(
                "item" => $curid
            ));
            // v5.0.1
            if (is_array($evt) && !empty($evt[0]))
                $msg    = $evt[0];
        } elseif ($validPrice !== true) {
            return 'error';
        } elseif ($validQty !== true) {
            return 'error';
        }
        $msg = (!empty($msg)) ? $msg : 'success';
        return $msg;
    }

}

if (!function_exists("tsv_delete_item")) {

    function tsv_delete_item($num) {
        global $modx, $session, $tsvshop, $shop_lang;
        //$session = session($cache);
        if (is_array($_SESSION[$session]['orders'])) {
            // Событие при удалении товара из корзины
            $modx->invokeEvent("TSVshopOnDeleteItem", array(
                "item" => $num
            ));
            $item = array_slice($_SESSION[$session]['orders'], $num, 1, true);
            array_splice($_SESSION[$session]['orders'], $num, 1);
        }

        $count = sizeof($_SESSION[$session]['orders']);
        $modx->sendRedirect($tsvshop['selfurl'], 0, 'REDIRECT_HEADER');
    }

}

if (!function_exists("tsv_modify_quantity")) {

    function tsv_modify_quantity($num, $quantity) {
        global $session, $tsvshop, $modx;
        //$session = session($cache);
        // Событие при изменении количества товара
        $modx->invokeEvent("TSVshopOnChangeItemQty", array(
            "item" => $num,
            "qty"  => $quantity
        ));
        $_SESSION[$session]['orders'][$num]['qty'] = $quantity;
        $modx->sendRedirect($tsvshop['selfurl'], 0, 'REDIRECT_HEADER');
    }

}

if (!function_exists("tsv_clear_cart")) {

    function tsv_clear_cart() {
        global $session, $tsvshop, $modx;
        //$session = session($cache);
        // Событие при очистке корзины
        $modx->invokeEvent("TSVshopOnClearCart");
        $_SESSION[$session] = array();
        $modx->sendRedirect($tsvshop['selfurl'], 0, 'REDIRECT_HEADER');
    }

}

if (!function_exists("tsv_cart_total")) {

    function tsv_cart_total() {
        // пока не используется
    }

}

if (!function_exists("tsv_display_infoblock")) {

    function tsv_display_infoblock($cache) {
        global $modx, $session, $tsvshop, $shop_lang;
        $total  = 0;
        $items  = 0;
        $output = "";
        $tmp    = "";
        $table  = "";
        $sub    = 0;

        if (is_array($tsvshop['hideon'])) {
            if (in_array($modx->documentIdentifier, $tsvshop['hideon']))
                return;
        }

        if ($tsvshop['debug']) {
            $output .= print_r($_SESSION[$session]);
        }
        $tpl = $cache->cache("ib", "tsvshop");
        if (!$tpl) {
            $tpl = getTpl($tsvshop['tplinfoblock']);
            if (!$tpl) {
                exit("");
            } else {
                $cache->cache("ib", 'tsvshop', $tpl);
            }
        }

        $tpl   = str_replace("[+shop.info.carturl+]", $tsvshop['basketurl'], $tpl);
        $tpl   = str_replace("[+shop.info.selfurl+]", $tsvshop['selfurl'], $tpl);
        $tpl   = str_replace("[+shop.info.monetary+]", $tsvshop['MonetarySymbol'], $tpl);
        $empty = getStr($tpl, '<!--empty-->', '<!--/empty-->');
        $full  = getStr($tpl, '<!--full-->', '<!--/full-->');
        $table = getStr($tpl, '<!--table-->', '<!--/table-->');

        $count = sizeof($_SESSION[$session]['orders']);
        for ($i = ($count - 1); $i >= 0; $i--) {
            $total    = $total + (tsv_CalcPrice($_SESSION[$session]['orders'][$i]['price'], $_SESSION[$session]['orders'][$i]['qty'], $_SESSION[$session]['orders'][$i]['opt']) * $_SESSION[$session]['orders'][$i]['qty']);
            $items    = $items + $_SESSION[$session]['orders'][$i]['qty'];
            $price    = tsv_CalcPrice($_SESSION[$session]['orders'][$i]['price'], $_SESSION[$session]['orders'][$i]['qty'], $_SESSION[$session]['orders'][$i]['opt']);
            $summa    = (tsv_CalcPrice($_SESSION[$session]['orders'][$i]['price'], $_SESSION[$session]['orders'][$i]['qty'], $_SESSION[$session]['orders'][$i]['opt']) * $_SESSION[$session]['orders'][$i]['qty']);
            $tabletmp = $table;
            $tabletmp = str_replace('[+shop.info.iconpath+]', $_SESSION[$session]['orders'][$i]['icon'], $tabletmp);
            $tabletmp = str_replace('[+shop.info.articul+]', $_SESSION[$session]['orders'][$i]['articul'], $tabletmp);
            $tabletmp = str_replace('[+shop.info.quantity+]', $_SESSION[$session]['orders'][$i]['qty'], $tabletmp);
            $tabletmp = str_replace('[+shop.info.price+]', tsv_PriceFormat($price), $tabletmp);
            $tabletmp = str_replace('[+shop.info.summa+]', tsv_PriceFormat($summa), $tabletmp);
            //$tabletmp = str_replace('[+shop.info.name+]', $_SESSION[$session]['orders'][$i]['name'], $tabletmp);

            // добавлено разделение названия и опций
            $tplname = $_SESSION[$session]['orders'][$i]['name'];
            $details = getStr($tplname, 'ldquo', 'rdquo');

            $tplname = str_replace("ldquo".$details."rdquo", "", $tplname);
            $tabletmp = str_replace('[+shop.info.name+]', $tplname, $tabletmp);
            if (!empty($details)) {
              $tabletmp = str_replace('[+shop.info.details+]', " (".$details.")", $tabletmp);
            }
            // --

            if (!empty($_SESSION[$session]['orders'][$i]['url'])) {
                $url = ($tsvshop['TypeCat'] == 'docs' || empty($tsvshop['TypeCat'])) ? $modx->makeUrl($_SESSION[$session]['orders'][$i]['url']) : "&tovar=" . $_SESSION[$session]['orders'][$i]['url'];
            }
            $tabletmp = str_replace('[+shop.info.num+]', $i, $tabletmp);
            $tabletmp = str_replace('[+shop.info.link+]', str_replace("assets/snippets/tsvshop/include/", "", $url), $tabletmp);
            $tabletmp = str_replace('[+shop.info.delatributs+]', 'onClick="RemoveFromCart(\'' . $i . '\'); return false"', $tabletmp);

            //5.4 добавляем TV-параметры, заданные в &tvs. Выводятся вместо [+tv.имятв+]
            if (is_array($tsvshop['tvs'])) {
                $tvs = $modx->getTemplateVars($tsvshop['tvs'], '*', $_SESSION[$session]['orders'][$i]['url']);
                foreach ($tvs as $tv) {
                    $tabletmp = str_replace('[+tv.' . $tv['name'] . '+]', $tv['value'], $tabletmp);
                }
            }

            $tmp .= $tabletmp;
        }

        //$full = str_replace("[+shop.info.count+]", $items, $full);
        //$full = str_replace("[+shop.info.ssumma+]", $shop_lang['strSumma'], $full);
        //$full = str_replace("[+shop.info.total+]", tsv_PriceFormat($total), $full);
        $full = str_replace($table, $tmp, $full);
        $full = str_replace(
                array('[+shop.info.count+]','[+shop.info.ssumma+]','[+shop.info.total+]'),
                array($items,$shop_lang['strSumma'],tsv_PriceFormat($total)),
                $full
        );
        $full = str_replace($table, $tmp, $full);

        if (!$items)
            $output .= str_replace("[+shop.info.sempty+]", $shop_lang['strEmptyInfo'], $empty);
        if ($items == 1)
            $output .= str_replace("[+shop.info.stovar+]", $shop_lang['strTovar1'], $full);
        if ($items >= 2 && $items <= 4)
            $output .= str_replace("[+shop.info.stovar+]", $shop_lang['strTovar2'], $full);
        if ($items > 4)
            $output .= str_replace("[+shop.info.stovar+]", $shop_lang['strTovar5'], $full);


        $tpl = str_replace($empty, "", $tpl);

        $output = preg_replace('/(\[\+.*?\+\])/', '', $output);
        unset($tpl);
        return $output;
    }

}

if (!function_exists("tsv_ParseUserForm")) {

    function tsv_ParseUserForm(&$fields, &$templates) {
        global $modx, $shop_lang, $folders, $tsvshop, $session, $tables, $cache;
        $tables['payments'] = $modx->getFullTableName('shop_payments');

        // Плагин TSVshopOnUserFormRender
        $evt              = $modx->invokeEvent("TSVshopOnUserFormRender", array(
            "tpl" => $templates['tpl']
        ));
        if (is_array($evt) && !empty($evt[0]))
            $templates['tpl'] = $evt[0];

        foreach ($folders as $folder) {
            if ($folder != "." && $folder != "..") {
                $file = TSVSHOP_PATH . "addons/" . $folder . '/actions/userform.inc.php';
                if (file_exists($file) && $tsvshop['addons_' . $folder . '_active'] == "yes") {
                    require_once($file);
                }
            }
        }
        $username = $modx->getLoginUserName();
        $userid   = $modx->getLoginUserID();
        if (!empty($userid)) {
            $currentWebUser = $modx->getWebUserInfo($userid);
            foreach ($currentWebUser as $uk => $uv) {
                $templates['tpl'] = str_replace('[+shop.basket.' . $uk . '+]', stripslashes($uv), $templates['tpl']);
            }
        }
        //чистим
        $templates['tpl'] = call_user_func_array(tsv_ClearTplfromLabels, array(
            $templates['tpl']
        ));

        // Плагин TSVshopOnBeforeUserFormRenderComplete
        $evt              = $modx->invokeEvent("TSVshopOnBeforeUserFormRenderComplete", array(
            "tpl" => $templates['tpl']
        ));
        if (is_array($evt) && !empty($evt[0]))
            $templates['tpl'] = $evt[0];
        return true;
    }

}

if (!function_exists("tsv_display_checkoutform")) {

    function tsv_display_checkoutform($cache) {
        global $modx, $session, $tsvshop, $shop_lang, $folders, $tables;
        $tsvshop['MinimumOrder'] = empty($tsvshop['MinimumOrder']) ? 0 : $tsvshop['MinimumOrder'];
        if ($_SESSION[$session]['result']['total'] < $tsvshop['MinimumOrder']) {
            $tpl = notice(str_replace('%minsum%', $tsvshop['MinimumOrder'] . " " . $tsvshop['MonetarySymbol'], $shop_lang['strMinimumOrder']), 'error');
        } else {
            $tpl = $modx->runSnippet("eForm", array(
                'tpl'                    => $tsvshop['tpluserform'],
                'formid'                 => 'TSVCheckoutForm',
                'eformOnBeforeFormParse' => 'tsv_ParseUserForm',
                'eFormOnBeforeMailSent'  => 'tsv_Finish',
                'allowhtml'              => '1',
                'submitLimit'            => '0',
                'protectSubmit'          => '0',
                'noemail'                => '1',
                'gotoid'                 => $tsvshop['backid']
            ));
            // Плагин TSVshopOnUserFormComplete
            $evt = $modx->invokeEvent("TSVshopOnUserFormComplete", array(
                "tpl" => $tpl
            ));
            if (is_array($evt) && !empty($evt[0]))
                $tpl = $evt[0];
        }
        return $tpl;
    }

}

if (!function_exists("tsv_display_fullcheckout")) {

    function tsv_display_fullcheckout($cache) {
        global $modx, $session, $tsvshop, $shop_lang, $folders, $tables;
        $tvar  = "fch";
        $chunk = $tsvshop['tplfullcheckout'];
        $tpl   = $cache->cache($tvar, 'tsvshop');
        if (!$tpl) {
            if (!$tpl = getTpl($chunk)) {
                $tpl = "<div>[+shop.basket.checkouttable+]</div> <div>[+shop.basket.userform+]</div>";
            } else {
                $cache->cache($tvar, 'tsvshop', $tpl);
            }
        }
        $userform = '<div id="checkoutform_cont">' . tsv_display_checkoutform($cache) . '</div>';
        $table    = '<div id="checkout_cont">' . tsv_display_cart($cache, "checkout") . '</div>';
        $userform = (!sizeof($_SESSION[$session]['orders'])) ? '' : $userform;
        $tpl      = str_replace("[+shop.basket.userform+]", $userform, $tpl);
        $tpl      = str_replace("[+shop.basket.checkouttable+]", $table, $tpl);
        return $tpl;
    }

}

if (!function_exists("tsv_display_cart")) {

    function tsv_display_cart($cache, $act = "basket") {
        global $modx, $session, $tsvshop, $shop_lang, $folders, $tables;
        //$session = session($cache);
        $total     = 0;
        $items     = 0;
        $output    = "";
        $tabletmp  = "";
        $table     = "";
        $itemstmp  = "";
        $sub       = 0;
        $tot       = 0;
        $disc_size = 0;
        $disc      = 0;
        $piece     = array();
        $addons    = array();
        if (!act) {
            $act == "basket";
        }

        if ($tsvshop['debug']) {
            $output .= print_r($_SESSION[$session]);
        }
        $count = sizeof($_SESSION[$session]['orders']);
        if ($act == "basket") {
            $tvar  = "ct";
            $chunk = $tsvshop['tplcart'];
        } else {
            $tvar    = "ch";
            $chunk   = $tsvshop['tplcheckout'];
            //$divajax = '<div id="checkout_table">';
        }
        if (empty($count)) {
            $tvar  = "cte";
            $chunk = $tsvshop['tplcartempty'];
        }
        $tpl = $cache->cache($tvar, 'tsvshop');
        if (!$tpl) {
            if (!$tpl = getTpl($chunk)) {
                exit("");
            } else {
                $cache->cache($tvar, 'tsvshop', $tpl);
            }
        }
        // плагин TSVshopOnTplCartPrerender
        $evt = $modx->invokeEvent("TSVshopOnTplCartPrerender", array(
            "tpl" => $tpl
        ));
        if (is_array($evt) && !empty($evt[0]))
            $tpl = $evt[0];
        // ---
        $tpl = str_replace("[+shop.basket.monetary+]", $tsvshop['MonetarySymbol'], $tpl);
        $tpl = str_replace("[+shop.basket.checkurl+]", $tsvshop['checkurl'], $tpl);
        $tpl = str_replace("[+shop.basket.selfurl+]", $tsvshop['selfurl'], $tpl);

        // создаем метки для корзины
        // создаем метки аддона Sales (используются в чанках Shop_Cart и Shop_Checkout)
        $piece['head'] = getStr($tpl, '<thead>', '</thead>');
        $syslabels     = explode(",", $tsvshop['syslabels']);
        foreach ($syslabels as $folder) {
            $piece[$folder] = getStr($tpl, '<!--' . $folder . '-->', '<!--/' . $folder . '-->');
        }
        // создаем метки аддонов (используются аддонами)
        foreach ($folders as $folder) {
            if (tsv_AddonIsOn($folder)) {
                $piece[$folder] = getStr($tpl, '<!--' . $folder . '-->', '<!--/' . $folder . '-->');
            }
        }

        if (empty($count)) {
            //если корзина пуста
            if ($act == "checkout") {
                //$modx->sendRedirect($tsvshop['basketurl'],0,'REDIRECT_HEADER');
            }
        } else {
            for ($i = ($count - 1); $i >= 0; $i--) {
                //$tabletmp = $noempty; // было
                $tabletmp = $piece['noempty'];
                $price    = tsv_CalcPrice($_SESSION[$session]['orders'][$i]['price'], $_SESSION[$session]['orders'][$i]['qty'], $_SESSION[$session]['orders'][$i]['opt']);
                $summa    = (tsv_CalcPrice($_SESSION[$session]['orders'][$i]['price'], $_SESSION[$session]['orders'][$i]['qty'], $_SESSION[$session]['orders'][$i]['opt']) * $_SESSION[$session]['orders'][$i]['qty']);

                $sub   = $sub + $summa;
                $items = $items + $_SESSION[$session]['orders'][$i]['qty'];

                //---заполняем шаблон товарами
                // v 5.0.1 заменяем плейсхолдеры значениями
                foreach ($_SESSION[$session]['orders'][$i] as $key => $val) {
                    switch ($key) {
                        case 'qty':
                        case 'quantity':
                            $tabletmp = str_replace(array('[+shop.basket.quantity+]','[+shop.basket.qty+]'), $val, $tabletmp);
                            break;
                        case 'icon':
                            $tabletmp = str_replace('[+shop.basket.iconpath+]', $val, $tabletmp);
                            $tabletmp = str_replace('[+shop.basket.cart_icon+]', $val, $tabletmp);
                            $tabletmp = str_replace('[+shop.basket.icon+]', $val, $tabletmp);
                            break;
                        case 'price':
                            $tabletmp = str_replace('[+shop.basket.price+]', tsv_PriceFormat($price), $tabletmp);
                            break;
                        case 'url':
                            $url      = ($tsvshop['TypeCat'] == 'docs' || empty($tsvshop['TypeCat'])) ? $modx->makeUrl($val) : "&tovar=" . $val;
                            $tabletmp = str_replace('[+shop.basket.link+]', $url, $tabletmp);
                            //$tabletmp = str_replace('[+shop.basket.id+]', $val, $tabletmp);
                            break;


                            //-- добавлено разделение названия и опций
                        case 'name' :
                          $tplname = $val;
                          $details = getStr($tplname, 'ldquo', 'rdquo');
                          $tplname = str_replace("ldquo".$details."rdquo", "", $tplname);
                          $tabletmp = str_replace('[+shop.basket.name+]', $tplname, $tabletmp);
                          if (!empty($details)) {
                            $tabletmp = str_replace('[+shop.basket.details+]', " (".$details.")", $tabletmp);
                          }
                        break;
                          //--


                        default:
                            $tabletmp = str_replace('[+shop.basket.' . $key . '+]', $val, $tabletmp);
                            break;
                    }
                    //5.4 добавляем TV-параметры, заданные в &tvs. Выводятся вместо [+tv.имятв+]
                    if (is_array($tsvshop['tvs'])) {
                        $tvs = $modx->getTemplateVars($tsvshop['tvs'], '*', $_SESSION[$session]['orders'][$i]['url']);
                        foreach ($tvs as $tv) {
                            $tabletmp = str_replace('[+tv.' . $tv['name'] . '+]', $tv['value'], $tabletmp);
                        }
                    }
                }
                $tabletmp = str_replace('[+shop.basket.qinput+]', '<input type="number" name="q" size="3" class="nopinput" value="' . $_SESSION[$session]['orders'][$i]['qty'] . '" onkeypress="return testKey(event)" onChange="ChangeQuantity(\'' . $i . '\', this.value);">', $tabletmp);
                $tabletmp = str_replace('[+shop.basket.qatributs+]', 'name="q" value="' . $_SESSION[$session]['orders'][$i]['qty'] . '" onkeypress="return testKey(event)" onChange="ChangeQuantity(\'' . $i . '\', this.value);"', $tabletmp);
                $tabletmp = str_replace('[+shop.basket.summa+]', tsv_PriceFormat($summa), $tabletmp);
                $tabletmp = str_replace('[+shop.basket.num+]', $i, $tabletmp);
                $tabletmp = str_replace('[+shop.basket.delatributs+]', 'onClick="RemoveFromCart(\'' . $i . '\'); return false"', $tabletmp);
                // --------------------------------


                $table .= $tabletmp;
            }
            $tpl = str_replace($piece['noempty'], $table, $tpl);
            $tpl = str_replace($piece['empty'], "", $tpl);


            // ------ Проверяем переменные для итоговой суммы
            //$tsvshop['shipping'] = ($tsvshop['addons_shipping_active']=="no" || empty($tsvshop['addons_shipping_active'])) ? 0 : $tsvshop['shipping'];
            if ($tsvshop['addons_shipping_active'] == "no" || empty($tsvshop['addons_shipping_active'])) {
                $tsvshop['shipping'] = 0;
                $tsvshop['shipid']   = 0;
                $tsvshop['shiptype'] = '';
            }
            if ($tsvshop['addons_discount_active'] == "no" || empty($tsvshop['addons_discount_active'])) {
                $tsvshop['discountsize'] = $tsvshop['discount']     = 0;
                $tsvshop['discountnum']  = $tsvshop['discounttype'] = '';
            }
            if ($tsvshop['addons_tax_active'] == "no" || empty($tsvshop['addons_tax_active'])) {
                $tsvshop['Tax']     = $tsvshop['TaxRate'] = 0;
                $tsvshop['TaxType'] = $tsvshop['TaxName'] = '';
            }

            // ########################## Подсчет подитога корзины ########################## //
            // Подитог
            $evt                                      = $modx->invokeEvent("TSVshopOnGetSubtotal", array(
                "subtotal" => $sub
            ));
            if (is_array($evt) && !empty($evt[0])) {
                $sub = $evt[0];
            }
            $tpl                                      = str_replace("[+shop.basket.subtotal+]", tsv_PriceFormat($sub), $tpl);
            $_SESSION[$session]['result']['subtotal'] = $sub;

            //тут вставляем Actions для корзины
            foreach ($folders as $folder) {
                if ($folder != "." && $folder != "..") {
                    $file = TSVSHOP_PATH . "addons/" . $folder . '/actions/action.inc.php';
                    if (file_exists($file) && $tsvshop['addons_' . $folder . '_active'] == "yes") {
                        require_once($file);
                    }
                }
            }
            // ---- тут на будущее ------------
            // ------ Налог  --------------------------------------------------
            // Название налога, напр. ПДВ
            // Процентный или фиксированный
            // Размер скидки
            //$tsvshop['TaxRate'] = ($tsvshop['DisplayTaxRow']=="false" || empty($tsvshop['DisplayTaxRow'])) ? 0 : $tsvshop['TaxRate'];
            //$tpl = ($tsvshop['DisplayTaxRow']=="true" && !empty($piece['tax'])) ? str_replace("[+shop.basket.tax+]", $tsvshop['TaxRate'], $tpl) : str_replace($piece['tax'], "", $tpl);
            //$_SESSION[$session]['result']['nalog'] = $tsvshop['TaxRate'];
            // ------ Скидка правилами  ----------------------------------------
            // приплюсовываем скидки в одну
            // -----------------------------------------------------------------
            // -------------------------- Подсчитываем итог --------------------

            $tot = (($sub - $tsvshop['discountsize']) + (floatval($tsvshop['TaxRate']) + floatval($tsvshop['shipping'])));

            $tpl                                   = str_replace("[+shop.basket.total+]", tsv_PriceFormat($tot), $tpl);
            $_SESSION[$session]['result']['total'] = $tot;
            $_SESSION[$session]['result']['count'] = $count;

            //добавлено с v5.3 ----------------------------------------------------
            //определяем переменную topay - сумма к оплате
            //по умолчанию она равна сумме всего заказа
            //но ее можно переопределить.
            $_SESSION[$session]['result']['topay'] = $_SESSION[$session]['result']['total'];



            /*
            // Плагин TSVshopOnBeforeUserFormInit
            $evt = $modx->invokeEvent("TSVshopOnBeforeUserFormInit", array(
                "tpl" => $tpl
            ));
            if (is_array($evt) && !empty($evt[0]))
                $tpl = $evt[0];

            if (!empty($_SESSION[$session]['result']['count']) && _filter($_REQUEST['act']) != 'recalc') {
                if ($tot < $tsvshop['MinimumOrder']) {
                    $tpl = str_replace("[+shop.basket.userform+]", notice(str_replace('%minsum%', $tsvshop['MinimumOrder'] . " " . $tsvshop['MonetarySymbol'], $shop_lang['strMinimumOrder']), 'error'), $tpl);
                } else {
                    $userform = tsv_display_checkoutform($cache);
                    $tpl      = str_replace("[+shop.basket.userform+]", $userform, $tpl);
                }
            } else {
                $tpl = str_replace("[+shop.basket.userform+]", "", $tpl);
            }
            */
            //добавлено с v5.3 ----------------------------------------------------
            $tpl = str_replace("[+shop.basket.topay+]", tsv_PriceFormat($_SESSION[$session]['result']['topay']), $tpl);

            //запоминаем основные переменные
            $userid = $modx->getLoginUserID();
            if (!$userid) {
                $userid = "0";
            }
            $_SESSION[$session]['result']['userid'] = $userid; // Определяем ИД пользователя
            //Генерируем код доступа к заказу
            $tekens                                 = array(
                "a",
                "b",
                "c",
                "d",
                "e",
                "f",
                "g",
                "h",
                "i",
                "j",
                "k",
                "l",
                "m",
                "n",
                "o",
                "p",
                "q",
                "r",
                "s",
                "t",
                "u",
                "v",
                "w",
                "x",
                "y",
                "z",
                "0",
                "1",
                "2",
                "3",
                "4",
                "5",
                "6",
                "7",
                "8",
                "9",
                "A",
                "B",
                "C",
                "D",
                "E",
                "F",
                "G",
                "H",
                "I",
                "J",
                "K",
                "L",
                "M",
                "N",
                "O",
                "P",
                "Q",
                "R",
                "S",
                "T",
                "U",
                "V",
                "W",
                "X",
                "Y",
                "Z"
            );
            for ($c = 0; $c < 8; $c++) {
                //srand((double) microtime() * 100000000000000);
                $pass      = $tekens[rand(0, 62)];
                $accesskey = $accesskey . $pass;
            }
            $_SESSION[$session]['result']['code'] = $accesskey;
        }

        $evt = $modx->invokeEvent("TSVshopOnTplCartRender", array(
            "tpl" => $tpl
        ));
        if (is_array($evt) && !empty($evt[0]))
            $tpl = $evt[0];

//--------
        if ($act == 'fullcheckout') {
            $tvar  = "fch";
            $chunk = $tsvshop['tplfullcheckout'];
            $tplfc = $cache->cache($tvar, 'tsvshop');
            if (!$tplfc) {
                if (!$tplfc = getTpl($chunk)) {
                    $$tplfc = "<div>[+shop.basket.checkouttable+]</div> <div>[+shop.basket.userform+]</div>";
                } else {
                    $cache->cache($tvar, 'tsvshop', $tplfc);
                }
            }

            // Событие TSVshopOnBeforeUserFormInit
            $evt = $modx->invokeEvent("TSVshopOnBeforeUserFormInit", array(
                "tpl" => $tpl
            ));
            if (is_array($evt) && !empty($evt[0]))
                $tpl = $evt[0];
            if (!empty($_SESSION[$session]['result']['count']) && _filter($_REQUEST['act']) != 'recalc') {
                $userform = tsv_display_checkoutform($cache);
            } else {
                $userform = '';
            }

            $userform = '<div id="checkoutform_cont">' . $userform . '</div>';
            $table    = '<div id="checkout_table">'. $tpl . '</div>';

            $table = call_user_func_array(tsv_ClearTplfromLabels, array(
                $table
            ));

            $userform = (!sizeof($_SESSION[$session]['orders'])) ? '' : $userform;
            $tplfc      = str_replace("[+shop.basket.checkouttable+]", $table, $tplfc);
            $tpl      = str_replace("[+shop.basket.userform+]", $userform, $tplfc);
        }
        //------

        // Чистим чанк от всех меток
        $tpl = call_user_func_array(tsv_ClearTplfromLabels, array(
            $tpl
        ));
        $tpl = preg_replace('/(\[\+.*?\+\])/', "", $tpl);
        $tpl = preg_replace('/(<!--.*?-->)/', "", $tpl);
        if (empty($tpl)) {
            return true;
        } else {
            //return $divajax . $tpl;
            return $tpl;
        }
        unset($tpl);
        unset($piece);
    }

}

if (!function_exists("tsv_Finish")) {

    function tsv_Finish(&$fields) {
        global $modx, $session, $tsvshop, $shop_lang, $mail;
        include $modx->config['base_path'] . MGR_DIR . "/includes/controls/class.phpmailer.php";
        include(TSVSHOP_PATH . "include/config.inc.php");
        if (!$mail) {
            $mail = new PHPMailer;
        }
        $order               = $orderfields         = array();
        $today               = date("d.m.Y ");
        $strMessageBody      = "";
        $strMessageBody1     = "";
        //Подключаем чанк письма - переменная tplmail
        $tplmail             = getTpl($tsvshop['tplmailadmin']);
        $tplmail1            = getTpl($tsvshop['tplmailklient']);
        //Выделяем из него ту часть, которая отвечает за таблицу товаров
        $tablemail           = preg_replace("#.*?(<!--table-->(.*?)<!--/table-->|$)#is", "$2", $tplmail);
        $tablemail1          = preg_replace("#.*?(<!--table-->(.*?)<!--/table-->|$)#is", "$2", $tplmail1);
        $table               = "";
        $table1              = "";
        //Поля по умолчанию
        $fields['dateorder'] = time();
        $status              = explode("||", $tsvshop['StatusOrder']);
        //$fields['status'] = $status[0];   //тут выводим статус по умолчанию
        $tmpstatus           = explode("==", $status[0]); //тут выводим статус по умолчанию
        $fields['status']    = $tmpstatus[0];
        $payinfo             = explode("_", $fields['payments']);
        $fields['payments']  = $payinfo[1];

        $evt    = $modx->invokeEvent("TSVshopOnUserFormFieldsRender", array(
            "fields" => $fields
        ));
        if (is_array($evt) && !empty($evt[0]))
            $fields = $evt[0];

        if (sizeof($tsvshop['customfields']) > 0) {
            //v5.3
            //добавление в БД недостающих полей
            tsv_AddFieldstoDB($tsvshop['dborders'], $tsvshop['customfields']);
            foreach ($tsvshop['customfields'] as $cfield) {
                //проверяем кастомные поля на существование
                $cfield = _filter(trim($cfield));

                if (!empty($_SESSION[$session]['result'][$cfield])) {
                    $order[$cfield] = _filter($_SESSION[$session]['result'][$cfield]);
                }
                if (!empty($fields[$cfield])) {
                    if (empty($order[$cfield])) {
                        $order[$cfield] = _filter($fields[$cfield]);
                    }
                    if (empty($_SESSION[$session]['result'][$cfield])) {
                        $_SESSION[$session]['result'][$cfield] = _filter($fields[$cfield]);
                    }
                }
            }
        }

        //формируем поля для данных заказа
        $sf = explode(",", $tsvshop['sysfields']);
        //v5.3
        //добавление в БД недостающих полей
        tsv_AddFieldstoDB($tsvshop['dborders'], $tsvshop['sysfields']);
        foreach ($sf as $sfield) {
            $sfield = _filter(trim($sfield));
            if (!empty($_SESSION[$session]['result'][$sfield])) {
                if (in_array($sfield, explode(",", $tsvshop['SecFields']))) {
                    $_SESSION[$session]['result'][$sfield] = CryptMessage($_SESSION[$session]['result'][$sfield], $tsvshop['SecPassword']);
                }
                $order[$sfield] = $_SESSION[$session]['result'][$sfield];
            }
            if (!empty($fields[$sfield])) {
                if (in_array($sfield, explode(",", $tsvshop['SecFields']))) {
                    $fields[$sfield] = CryptMessage($fields[$sfield], $tsvshop['SecPassword']);
                }
                if (empty($order[$sfield])) {
                    $order[$sfield] = $fields[$sfield];
                }
                if (empty($_SESSION[$session]['result'][$sfield])) {
                    $_SESSION[$session]['result'][$sfield] = $fields[$sfield];
                }
            }
        }



        //запись данных о заказе в базу данных
        if (sizeof($order) > 0) {
            $modx->db->insert($order, $tsvshop['dborders']);
        }

        //берем последний ИД заказа функцией $numorder=$modx->db->getInsertId();
        $numorder                                 = $modx->db->getInsertId();
        $_SESSION[$session]['result']['numorder'] = $numorder;
        $_SESSION[$session]['result']['payment']  = $payinfo[1];
        $_SESSION[$session]['result']['paytype']  = $payinfo[0];

        $order['numorder'] = _filter($_SESSION[$session]['result']['numorder']);

        //формируем поля для подробностей заказа
        $count = sizeof($_SESSION[$session]['orders']);
        if (!empty($count)) {
            for ($i = ($count - 1); $i >= 0; $i--) {
                $tmp         = $tablemail; // для письма
                $tmp1        = $tablemail1; // для письма
                $price       = tsv_CalcPrice($_SESSION[$session]['orders'][$i]['price'], $_SESSION[$session]['orders'][$i]['qty'], $_SESSION[$session]['orders'][$i]['opt']);
                //---  Добавлено разделение названия и опций
                $name=str_replace("rdquo",")",$_SESSION[$session]['orders'][$i]['name']);
                $name=str_replace("ldquo","(",$name);
                //---
                $orderfields = array(
                    'numorder' => $numorder,
                    'name'     => $name,
                    'articul'  => $_SESSION[$session]['orders'][$i]['articul'],
                    'price'    => tsv_PriceFormat($price),
                    'icon'     => $_SESSION[$session]['orders'][$i]['icon'],
                    'quantity' => $_SESSION[$session]['orders'][$i]['qty'],
                    'url'      => $_SESSION[$session]['orders'][$i]['url'],
                    'options'  => $_SESSION[$session]['orders'][$i]['opt'],
                    'typeitem' => $_SESSION[$session]['orders'][$i]['typeitem']
                );

                //формируем таблицу товаров для письма  v 5.0.1
                foreach ($_SESSION[$session]['orders'][$i] as $key => $val) {
                    switch ($key) {
                        case 'price':
                            $tmp  = str_replace("[+shop.mail.price+]", tsv_PriceFormat($price), $tmp);
                            $tmp1 = str_replace("[+shop.mail.price+]", tsv_PriceFormat($price), $tmp1);
                            break;
                        case 'icon':
                            $tmp  = str_replace("[+shop.mail.icon+]", $val, $tmp);
                            $tmp1 = str_replace("[+shop.mail.icon+]", $val, $tmp1);
                            $tmp  = str_replace("[+shop.mail.cart_icon+]", $val, $tmp);
                            $tmp1 = str_replace("[+shop.mail.cart_icon+]", $val, $tmp1);
                            break;
                        case 'qty':
                            $tmp  = str_replace("[+shop.mail.quantity+]", $val, $tmp);
                            $tmp1 = str_replace("[+shop.mail.quantity+]", $val, $tmp1);
                            break;
                        case 'url':
                            $url  = ($tsvshop['TypeCat'] == 'docs' || empty($tsvshop['TypeCat'])) ? $modx->makeUrl($val) : "&tovar=" . $val;
                            $tmp  = str_replace('[+shop.mail.link+]', $url, $tmp);
                            $tmp1 = str_replace('[+shop.mail.link+]', $url, $tmp1);
                            $tmp  = str_replace('[+shop.mail.url+]', $val, $tmp);
                            $tmp1 = str_replace('[+shop.mail.url+]', $val, $tmp1);
                            break;
                        //-- добавлено разделение названия и опций
                        case 'name' :
                          $val = str_replace('ldquo','(',$val);
                          $val = str_replace('rdquo',')',$val);
                          $tmp = str_replace("[+shop.mail.name+]", $val, $tmp);
                          $tmp1 = str_replace("[+shop.mail.name+]", $val, $tmp1);
                        break;
                        //--
                        default:
                            $tmp  = str_replace("[+shop.mail." . $key . "+]", $val, $tmp);
                            $tmp1 = str_replace("[+shop.mail." . $key . "+]", $val, $tmp1);
                            $tmp  = str_replace("[+shop.mail.num+]", $i, $tmp);
                            $tmp1 = str_replace("[+shop.mail.num+]", $i, $tmp1);
                            break;
                    }
                    //5.4 добавляем TV-параметры, заданные в &tvs. Выводятся вместо [+tv.имятв+]
                    if (is_array($tsvshop['tvs'])) {
                        $tvs = $modx->getTemplateVars($tsvshop['tvs'], '*', $_SESSION[$session]['orders'][$i]['url']);
                        foreach ($tvs as $tv) {
                            $tmp  = str_replace('[+tv.' . $tv['name'] . '+]', $tv['value'], $tmp);
                            $tmp1 = str_replace('[+tv.' . $tv['name'] . '+]', $tv['value'], $tmp1);
                        }
                    }
                }
                $tmp  = str_replace("[+shop.mail.summa+]", (tsv_PriceFormat(tsv_CalcPrice($_SESSION[$session]['orders'][$i]['price'], $_SESSION[$session]['orders'][$i]['qty'], $_SESSION[$session]['orders'][$i]['opt']) * $_SESSION[$session]['orders'][$i]['qty'])), $tmp);
                $tmp1 = str_replace("[+shop.mail.summa+]", (tsv_PriceFormat(tsv_CalcPrice($_SESSION[$session]['orders'][$i]['price'], $_SESSION[$session]['orders'][$i]['qty'], $_SESSION[$session]['orders'][$i]['opt']) * $_SESSION[$session]['orders'][$i]['qty'])), $tmp1);

                $table  .= $tmp;
                $table1 .= $tmp1;

                //записываем заказы в таблицу
                if (sizeof($orderfields) > 0) {
                    $modx->db->insert($orderfields, $tsvshop['dborders_details']);
                }
            }
        }

        //вставляем в шаблон письма сформированную таблицу заказа
        $strMessageBody  = str_replace($tablemail, $table, $tplmail);
        $strMessageBody1 = str_replace($tablemail1, $table1, $tplmail1);

        $cf = (explode(",", $tsvshop['sysfields'])) + $tsvshop['customfields'];
        foreach ($fields as $key => $value) {
            if (is_array($cf) && !in_array($key, $cf)) {
                $strMessageBody  = str_replace("[+shop.mail." . $key . "+]", _filter($value), $strMessageBody);
                $strMessageBody1 = str_replace("[+shop.mail." . $key . "+]", _filter($value), $strMessageBody1);
            }
        }

        $strMessageBody  = str_replace("[+shop.mail.monetary+]", $tsvshop['MonetarySymbol'], $strMessageBody);
        $strMessageBody1 = str_replace("[+shop.mail.monetary+]", $tsvshop['MonetarySymbol'], $strMessageBody1);



        //оплата
    		if ($_SESSION[$session]['result']['paytype'] == "none" || empty($_SESSION[$session]['result']['paytype']) || empty($_SESSION[$session]['result']['topay'])) {
    			$_SESSION[$session]['result']['paylink'] = '';
    	  } else {
    			$tables['payments'] = (!empty($tables['payments'])) ? $tables['payments'] : $modx->getFullTableName('shop_payments');
    			$tsvshop['dborders'] = (!empty($tsvshop['dborders'])) ? $tsvshop['dborders'] : $modx->getFullTableName('shop_order');
                if (!empty($tables['payments'])) {
                    $res = $modx->db->query("SELECT * FROM " . $tables['payments'] . " WHERE `active` = 1");
                    while ($payment = $modx->db->getRow($res)) {
                        if ($_SESSION[$session]['result']['paytype'] == $payment['code']) {
                            include(TSVSHOP_PATH . "addons/payments/payments/" . $payment['code'] . "/proc.inc.php");
    						            $_SESSION['tsvshopfin']['result'] = $_SESSION[$session]['result'];
                            $paylink = paylink($_SESSION[$session]['result'], $tsvshop);
    						            unset($_SESSION['tsvshopfin']['result']);
    						            $_SESSION[$session]['result']['paylink'] = base64_encode($paylink);
    						            //paylink
    						            if (tsv_AddonIsOn('payments')) {
    							             $modx->db->query("UPDATE ".$tsvshop['dborders']." SET paylink='".base64_encode($paylink)."' where numorder = '".$order['numorder']."'");
    						            }
                        }
                    }
                } else {
    				        $_SESSION[$session]['result']['paylink'] = '';
                }
    		}
    		//




        //if (sizeof($order)>0) {
        if (sizeof($_SESSION[$session]['result']) > 0) {
            foreach ($_SESSION[$session]['result'] as $key => $val) {
                if ($key == "dateorder") {
                    $val = date("d.m.Y H:i:s", $val);
                }
                if ($key=="subtotal" || $key=="total" || $key=="topay" || $key=="shipping" || $key=="discountsize" || $key=="tax") {
					         $val = tsv_PriceFormat($val);
				        }
                if ($key == "paylink") {
                    $val = base64_decode($val);

                }
                if (in_array($key, explode(",", $tsvshop['SecFields']))) {
                    $val = DeCryptMessage($val, $tsvshop['SecPassword']);
                }
                $strMessageBody  = str_replace("[+shop.mail." . $key . "+]", $val, $strMessageBody);
                $strMessageBody1 = str_replace("[+shop.mail." . $key . "+]", $val, $strMessageBody1);
            }
        }

        //и результат помещаем в переменную $fields['orderData']
        $fields['orderData'] = $table;

        //отсылаем письма админу
        $strMessageBody  = preg_replace('/(\[\+.*?\+\])/', '', $strMessageBody);
        $strMessageBody1 = preg_replace('/(\[\+.*?\+\])/', '', $strMessageBody1);
        //обрабатываем текст писем на сниппеты и чанки
        $strMessageBody  = $modx->parseDocumentSource($strMessageBody);
        $strMessageBody1 = $modx->parseDocumentSource($strMessageBody1);
        tsv_sendMail($tsvshop['SmtpFromEmail'], $tsvshop['SubjectMailAdmin'], $strMessageBody, 'true');

        //и клиенту
        if (in_array('email', explode(",", $tsvshop['SecFields']))) {
            $fields['email'] = DeCryptMessage($fields['email'], $tsvshop['SecPassword']);
        }
        tsv_sendMail($fields['email'], $tsvshop['SubjectMailUser'], $strMessageBody1, 'true');
        $_SESSION['tsvshopfin']['orders'] = $_SESSION[$session]['orders'];
        $_SESSION['tsvshopfin']['result'] = $_SESSION[$session]['result'];
        $modx->invokeEvent("TSVshopOnOrderSuccess");
        $_SESSION[$session]               = array();
        return true;
    }

}

if (!function_exists("tsv_display_success")) {

    function tsv_display_success($cache) {
        global $modx, $session, $tsvshop, $shop_lang, $tables;
        //$session = session($cache);
        $output = getTpl($tsvshop['tplsuccess']);
        if ($tsvshop['debug']) {
            $output .= print_r($_SESSION['tsvshopfin']);
        }
        $emails = array();
        $from   = explode(',', $tsvshop['SmtpFromEmail']);
        if (is_array($from)) {
            foreach ($from as $f) {
                $emails[] = '<a href="mailto:' . $f . '">' . $f . '</a>';
            }
        }

        $modx->setPlaceholder('shop.youremail', implode(', ', $emails)); //  адрес продавца
        // тут ставим функцию оплаты
        if ($_SESSION['tsvshopfin']['result']['paytype'] == "none" || empty($_SESSION['tsvshopfin']['result']['paytype']) || empty($_SESSION['tsvshopfin']['result']['topay'])) {
            $output = str_replace("[+shop.paylink+]", "", $output);
        } else {
			      $output = str_replace("[+shop.paylink+]", base64_decode($_SESSION['tsvshopfin']['result']['paylink']), $output);
		    }

        if (is_array($_SESSION['tsvshopfin']['result'])) {
            foreach ($_SESSION['tsvshopfin']['result'] as $key => $val) {
                $output = str_replace("[+shop." . $key . "+]", $val, $output);
            }
        }
        return $output;
    }

}

if (!function_exists("tsv_sendMail")) {

    function tsv_sendMail($emails, $subject = '', $body, $isHTML = false) {

        global $modx, $tsvshop;
        $tsvshop['SmtpReplyEmail'] = (!empty($tsvshop['SmtpReplyEmail'])) ? $tsvshop['SmtpReplyEmail'] : $modx->config['emailsender'];
        $tsvshop['SmtpFromName']  = (!empty($tsvshop['SmtpFromName'])) ? $tsvshop['SmtpFromName'] : $modx->config['site_name'];
        $params                   = array(
            'from'     => $tsvshop['SmtpReplyEmail'],
            'fromname' => $tsvshop['SmtpFromName'],
            'type'     => ($isHTML !== FALSE) ? '' : 'text',
            'subject'  => $subject,
            'to'       => $emails
        );
        return $modx->sendmail($params, $body);
    }

}
?>