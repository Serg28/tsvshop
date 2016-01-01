/**
 * TSVshop_options
 *
 * Сниппет вывода разных параметров товара, влияющих на цену в TSVshop 
 *
 * @category    snippet
 * @version     5.3
 * @license     http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal    @properties
 * @internal    @modx_category TSVshop
 * @internal    @installset base, sample
 *
 * @author      Serg24 <privat_tel@mail.ru>, http://tsvshop.tsv.org.ua, http://tsvshop.xyz
 * -----------------------------------------------------------------------------
 */

//select=123:синий==0||зеленый==0||красный==0;option=123:синий==0||зеленый==0||красный==0;
//select=Цвет:синий==0||зеленый==0||красный==0;option=Что_то:минимум==0||стандарт==0||расширенный==0;option=Что-то:минимум==-10||*стандарт ==0||расширенный==0;
include ($modx->config['base_path'] . 'assets/snippets/tsvshop/include/config.inc.php');

$docid = isset($docid) ? $docid : '';

$first_selected = isset($first_selected) ? $first_selected : true;
$wraptag = isset($wraptag) ? $wraptag : false;
$function = 'Ucalc('.$docid.')';

if ($tsvshop['TypeCat']=="catalog") {
$res=$modx->db->query("SELECT * FROM ".$modx->getFullTableName('test_products')." WHERE `id` = ".$docid." LIMIT 1");
if ($res) {
    $row=$modx->db->getRow($res);
    $tv_txt = $row['tsvshop_param'];
} else {
    $tv_txt ="";
}
} else {
$tv_txt = $modx->getTemplateVarOutput('tsvshop_param',$docid);
$tv_txt=$tv_txt['tsvshop_param'];
}
$n = strpos($tv_txt, ";");
$tv_cnt=0;

if (!$n && strlen($tv_txt)>3){
 $n=strlen($tv_txt);
}

while ($n!=false){
   $tv_cnt++;
   $n_s=0;
   $str_temp=substr($tv_txt, $n_s,$n-$n_s);
   $tv_txt=substr($tv_txt, $n+1);

   $sub_name="";
   $format="select";

   if (substr($str_temp,0,6)=="select") {
       $format = 'select';
       $n_s=6;
   }else   if (substr($str_temp,0,5)=="radio") {
         $format = 'radio';
         $n_s=5;
   } else   if (substr($str_temp,0,8)=="checkbox") {
         $format = 'checkbox';
         $n_s=8;
   } else{
    echo("=<");
    echo($str_temp);
    echo(">=");
   };

   $subnameAttr="";
   if(substr($str_temp,$n_s,2)=="=="){
       $n_s+=2;
       $n = strpos($str_temp, ":");
       $sub_name=(substr($str_temp,$n_s,$n-$n_s));
       $n_s=$n;
       echo("<span class='Shop_option_name'>".$sub_name."</span>");
	   $subnameAttr="data-subname=\"$sub_name\"";
   };
   $str_temp=substr($str_temp, $n+1);

$tvname="Shop_".$tv_cnt;
$tvout=$str_temp;

switch($format){
  case "select":
	  $options = "";
	  $count = 0;
	  $value = !empty($tvout) ? explode("||",$tvout) : array();
	  foreach($value as $val){
	    $count++;
	    list($item,$itemvalue) = explode("==",$val);

            $selected="";
             if(substr($item,0,1)=="*"){
               $selected = "selected";
               $item =substr($item,1);
             };

	     $options .= "\n  <option value=\"".$itemvalue."==".$item."\"$selected>$item</option>";
    }
	  $o = !empty($options) ? "\n<select $subnameAttr class=\"addparam\" name=\"".$tvname."\" onchange=\"".$function."\">$options\n</select>\n" : "";
  break;

  case "radio":
	  $output = "";
	  $otag = $wraptag ? "<$wraptag>" : "";
	  $ctag = $wraptag ? "</$wraptag>" : "";
	  $value = !empty($tvout) ? explode("||",$tvout) : array();
	  $count = 0;
	  foreach($value as $val){
	    $count++;
	    list($item,$itemvalue) = explode("==",$val);

            $selected="";
            if(substr($item,0,1)=="*"){
               $selected = ' checked="checked" ';
               $item =substr($item,1);
            };
	    $output .= "\n  $otag<label><input $subnameAttr class=\"addparam\" type=\"radio\" name=\"".
	    	$tvname."\" value=\"".$itemvalue."==".$item."\" id=\"radio".$docid."__".$count."\"$selected onclick=\"".
	    	$function."\" /> $item ";
	    	// если вместо разницы в цене вписать переопределение цены:
	    	// например price=100
	    	// param="10"
	    	// можно вписать param="*0+110"
	    	// в таком случае к тексту параметра припишется переопределенная цена в скобках.
	    	$getPrice=explode("*0+",$itemvalue);
	    	if (count($getPrice)>1)  $output .= "<span class=\"priceAddData\">(".($getPrice[1])." ".$tsvshop["MonetarySymbol"].")</span>";
	    $output .= "</label>$ctag";
    }
    $o = $output."\n";
  break;

  case "checkbox":
	  $output = "";
	  $otag = $wraptag ? "<$wraptag>" : "";
	  $ctag = $wraptag ? "</$wraptag>" : "";
	  $value = !empty($tvout) ? explode("||",$tvout) : array();
	  $count = 0;
	  foreach($value as $val){
	    $count++;
	    list($item,$itemvalue) = explode("==",$val);

        $selected="";
        if(substr($item,0,1)=="*"){
            $selected = ' checked="checked" ';
            $item =substr($item,1);
        };
	    $output .= "\n  $otag<input $subnameAttr class=\"addparam\" type=\"checkbox\" name=\"".$tvname."\" value=\"".$itemvalue."==".$item."\"

id=\"radio".$docid."__".$count."\"$selected onclick=\"".$function."\" /> <label for=\"radio".$docid."__$count\">$item</label>$ctag";
    }
    $o = $output."\n";
  break;
}

echo $o."<br>";

$n = strpos($tv_txt, ";");
}

echo '<input type="hidden" name="OptionText" value="'.$tv_cnt.'">';