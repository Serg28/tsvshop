<?php
/**
 * TSVshopPrepare
 *
 * Сниппет для подготовки чанка товара к выводу с помощью DocLister 
 *
 * @category    snippet
 * @version     1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal    @properties
 * @internal    @modx_category TSVshop
 * @internal    @installset base, sample
 *
 * @author      Serg24 <privat_tel@mail.ru>, http://tsvshop.xyz
 * -----------------------------------------------------------------------------
 */

/* 
 это сниппет выполняет те же функции, что и екстендер shop: обрабатывает и выводит товары для модуля TSVshop
 он позволяет выводить цену товара в зависимости от группы, к которой принаджлежит авторизованный пользователь
 для этого у товара добавляется несколько TV-параметров с ценами для разных веб-групп, напр., price_group1, price_group2 и т.д.
 в вызове DocLister параметр gtp , в котором задается такая формула:
 имя_веб_группы1=имя_tv_с_ценой1;имя_веб_группы2=имя_tv_с_ценой2.

 Пример: [[DocLister? &prepare=`TSVshopPrepare` &gtp=`gropname1=tvprice_group1;gropname2=tvprice_group2`]]

 если &gtp не указан, то берется цена из TV price
*/
 

if(!function_exists('tsv_MemberCheck')) {	
		function tsv_MemberCheck() {
			global $modx;
			$allGroups = array ();
			$tableName = $modx->getFullTableName('webgroup_names');
			$sql = "SELECT name FROM $tableName";
			if ($rs = $modx->db->query($sql)) {
				while ($row = $modx->db->getRow($rs)) {
					array_push($allGroups, stripslashes($row['name']));
				}
			}
			$_SESSION['allGroups'] = $allGroups;
		}
}

if(!function_exists('tsv_isValidGroup')) {	
		function tsv_isValidGroup($groupName) {
			global $modx, $allGroups;
			$isValid = !(array_search($groupName, $allGroups) === false);
			return $isValid;
		}	
}	

$tvList = $_DocLister->getCFGDef('tvList');
$tvList = (!empty($tvList)) ? implode(',',array_unique(explode(',',$tvList.','.'cart_icon,price,typeitem'))) : 'cart_icon,price,typeitem'; 

$gtp = $_DocLister->getCFGDef('gtp');	
$tvPrefix = $_DocLister->getCFGDef('tvPrefix');
$tvPrefix = (!empty($tvPrefix)) ? $tvPrefix."." : 'tv.';
$gtp = (isset($gtp)) ? $gtp : "";
$allGroups = (isset($_SESSION['allGroups'])) ? $_SESSION['allGroups'] : tsv_MemberCheck(); //все имеющиеся группы
$usergroups = $modx->isMemberOfWebGroup($allGroups); //авторизован ли пользователь и относится ли к какой-то группе?
$tvprice = (empty($gtp) || !$usergroups) ? $tvPrefix."price" : ""; // если нет группы либо нет параметра $gtp, tvprice = price

if (empty($tvprice)) {
  $gtptmp = explode(';',trim($gtp));
  foreach ($gtptmp as $val) {
    $gtpdata = explode('=',trim($val));
	if (tsv_isValidGroup($gtpdata[0]) && $modx->isMemberOfWebGroup(array($gtpdata[0]))) {
      $tvprice = $gtpdata[1];
    }
  }
  $tvprice = (empty($tvprice)) ? $tvPrefix."price" : $tvPrefix.$tvprice;
}



if(!function_exists('tsvservices')) {
        function tsvservices($data) {
				global $tvprice;
                return '<input type="hidden" name="typeitem" value="'.$data[$tvPrefix.'typeitem'].'" /><input type="hidden" name="formula" value="'.$data[$tvprice].'" /><input type="hidden" name="cart_icon" value="[(base_url)]'.$data[$tvPrefix.'cart_icon'].'" />';
        }
}

if(!function_exists('tsvprice')) {
        function tsvprice($data) {
				global $tvprice;
                require(MODX_BASE_PATH."assets/snippets/tsvshop/include/config.inc.php");
                $decimal = ($tsvshop['PriceFormat']=="0" || $tsvshop['PriceFormat']=="") ? 0 : 2;
                $price = number_format(floatval($data[$tvprice]), $decimal, '.', '');
                //return '<span id="price'.$data['id'].'" class="tsvprice">'.tsv_CalcPrice($data['price'], 1, tsv_parseOptions($data['tsvshop_param'])).'</span>';
                return '<span id="price'.$data['id'].'" class="tsvprice">'.number_format(tsv_CalcPrice($data[$tvprice], 1, tsv_parseOptions($data[$tvPrefix.'tsvshop_param'])), $decimal, '.', '').'</span>';
        }
}

if(!function_exists('tsvoptions')) {
        function tsvoptions($data) {
          global $modx;
          return $modx->runSnippet('TSVshop_options',array('docid'=>$data['id']));
        }
}

if(!function_exists('tsvbutton')) {
        function tsvbutton($data) {
                return 'onkeypress="return testKey(event)" onChange="Ucalc(\''.$data['id'].'\')"';
        }
}

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



$data['tsvservices'] = tsvservices($data);
$data['tsvprice'] = tsvprice($data);
$data['tsvoptions'] = tsvoptions($data);
$data['tsvbattr'] = tsvbutton($data);
$data['pagetitle'] = $data['pagetitle'];
return $data;
?>