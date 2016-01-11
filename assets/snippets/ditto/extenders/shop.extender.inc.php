<?php
$hiddenFields='price,cart_icon';

$placeholders['tsvservices'] = array('id,price,cart_icon,typeitem','tsvservices');
$placeholders['tsvprice'] = array('id,price,tsvshop_param','tsvprice');
$placeholders['tsvoptions'] = array('id','tsvoptions');
$placeholders['tsvbattr'] = array('id','tsvbutton');

if(!function_exists('tsvservices')) {
        function tsvservices($resource) {
                return '<input type="hidden" name="typeitem" value="'.$resource['typeitem'].'" /><input type="hidden" name="formula" value="'.$resource['price'].'" /><input type="hidden" name="cart_icon" value="'.$resource['cart_icon'].'" />';
        }
}

if(!function_exists('tsvprice')) {
        function tsvprice($resource) {
                require(MODX_BASE_PATH."assets/snippets/tsvshop/include/config.inc.php");
                $decimal = ($tsvshop['PriceFormat']=="0" || $tsvshop['PriceFormat']=="") ? 0 : 2;
                $price = number_format($resource['price'], $decimal, '.', '');
                //return '<span id="price'.$resource['id'].'" class="tsvprice">'.tsv_CalcPrice($resource['price'], 1, tsv_parseOptions($resource['tsvshop_param'])).'</span>';
                return '<span id="price'.$resource['id'].'" class="tsvprice">'.number_format(tsv_CalcPrice($resource['price'], 1, tsv_parseOptions($resource['tsvshop_param'])), $decimal, '.', '').'</span>';
        }
}

if(!function_exists('tsvoptions')) {
        function tsvoptions($resource) {
          global $modx;
          return $modx->runSnippet('TSVshop_options',array('docid'=>$resource['id']));
        }
}

if(!function_exists('tsvbutton')) {
        function tsvbutton($resource) {
                return 'onkeypress="return testKey(event)" onChange="Ucalc(\''.$resource['id'].'\')"';
        }
}

$GLOBALS['sortDirPrice'] =  $sortDirPrice;
$GLOBALS['sortByPrice'] =  $sortByPrice;

if(!function_exists("tsv_ConvertPrice"))
{
function tsv_ConvertPrice($txt) {
            if (strpos($txt, "||") === false) {
                echo str_replace('\r\n','',$txt);
            } else {
                //$pieces = explode("||", $txt);  //было
                $pieces = explode("||", "||".$txt);
                $i = 0;
                $o = "";
                $o2 = "";
                foreach($pieces as $value) {
                    $i++;
                    if (strlen($value) > 0) {
                        $pos = strpos($value, "-");
                        if ($pos != false) {
                            $tmp = substr($value, 0, $pos);
                            $o.= "(( " . $tmp . "<=&#36n & ";
                            $pos2 = strpos($value, "==");
                            $tmp = substr($value, $pos + 1, $pos2 - $pos - 1);
                            $o.= $tmp . ">=&#36n)?( ";
                            $o2.= "))";
                            $tmp = substr($value, $pos2 + 2);
                            $o.= $tmp . " ):( ";
                        } else {
                            $tmp = $value;
                            $o.= $tmp;
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

if(!function_exists("tsv_TryCalc"))
{
function tsv_TryCalc($cod,$col) {
	global $modx;
        $cod = str_replace(' ', '', $cod);
        $cod = str_replace(',', '.', $cod);
        $cod = str_replace('\r\n', '', $cod);
        //if (strpos($cod, "||")){
	if (strpos($cod, "==") || strpos($cod, "||")){
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

if(!function_exists("tsv_parseOptions")) {
function tsv_parseOptions($opt) {
   $price = 0;
   $fprice = 0;
   $i=0;
   $price='';
   if (is_array($txt = explode(";", $opt))) {
     foreach ($txt as $sel1) {
        $option = explode(":", $sel1);
        $sel3 = explode("||",$option[1]);
        foreach($sel3 as $sel4) {
           $res = explode("==",$sel4);
           if ($res[0]{0} == "*") {
			 if (!in_array($res[1]{0},array('+', '-','/','*')))$res[1]='+'.$res[1];
             $price.= $res[1];
           }
           if ($i==0) { $fprice = $res[1]; }
           $i++;
        }
     }
   }
   $price = ($i>0) ? $price : $fprice;
   return $price; 
}
}



if (!function_exists('sortByPrice')) {
    function sortByPrice($a_doc, $b_doc) {
        $sortDirPrice = isset($sortDirPrice) ? $sortDirPrice : 'ASC';
        $a_stamp = tsv_CalcPrice($a_doc['price'],1,'');
        $b_stamp = tsv_CalcPrice($b_doc['price'],1,''); 

        if ($GLOBALS['sortDirPrice']=='ASC') {
          return ($a_stamp < $b_stamp ? -1 : ($a_stamp > $b_stamp ? 1 : 0));
        }
        if ($GLOBALS['sortDirPrice']=='DESC') {
          return ($a_stamp < $b_stamp ? 1 : ($a_stamp > $b_stamp ? -1 : 0));
        }
    }
}


if (!function_exists('sortByParam')) {
    function sortByParam($a_doc, $b_doc) {
        $sortDirPrice = isset($sortDirPrice) ? $sortDirPrice : 'ASC';
        $a_stamp = tsv_parseOptions($a_doc['tsvshop_param']);
        $b_stamp = tsv_parseOptions($b_doc['tsvshop_param']); 
        if ($GLOBALS['sortDirPrice']=='ASC') {
          return ($a_stamp < $b_stamp ? -1 : ($a_stamp > $b_stamp ? 1 : 0));
        }
        if ($GLOBALS['sortDirPrice']=='DESC') {
          return ($a_stamp < $b_stamp ? 1 : ($a_stamp > $b_stamp ? -1 : 0));
        }
    }
}

/*
// чтобы включить стандартную сортировку в Ditto, нужно добавить в его вызов &sortByPrice=`none`
if ($GLOBALS['sortByPrice'] != 'none')
{
	if ($GLOBALS['sortByPrice']=='price') {
	 $orderBy['custom'][] = array('price', 'sortByPrice');
	} else {
	 $orderBy['custom'][] = array('tsvshop_param', 'sortByParam');
	}
	$ditto->advSort = TRUE; 
}
*/

//v5.3
// По-умолчанию работает стандартная сортировка в Ditto
// Если же указан &sortByPrice=`price` или &sortByPrice=`param`, сортируется по цене или параметрам товара соответственно
if ($GLOBALS['sortByPrice']!='' && ($GLOBALS['sortByPrice']=='price' || $GLOBALS['sortByPrice']=='param')) {
  if ($GLOBALS['sortByPrice']=='price') {
    $orderBy['custom'][] = array('price', 'sortByPrice');
  } else {
    $orderBy['custom'][] = array('tsvshop_param', 'sortByParam');
  }
  $ditto->advSort = TRUE;
}

?>


