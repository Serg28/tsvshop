<?php

$table = $modx->getFullTableName( 'site_tmplvar_contentvalues' );
$s_value_col=$_GET['value_col'];

$x=1;

if ($s_value_col>1){
   while ($s_value_col > $x)
	{
	$valueN=$_GET['value'.$x];
	$sID=$_GET['value_'.$x];
	$output_notice ='';
	$output_error='';
	if ($modx->db->update( 'value = "' . $valueN . '"', $table, 'id = "' . $sID . '"' )){
		      $output_notice.= 'id = "' . $sID . '" -> '.'value = "' . $valueN . '" - <b>'.$shop_lang['prices_ok'].'</b><br />';
	}else{
    		      $output_error.= 'id = "' . $sID . '" -> '.'value = "' . $valueN . '" - <b>'.$shop_lang['prices_error'].'</b><br />';
	};


	$x++; // Увеличение счетчика
	}
   if ($output_notice<>'' ) {$output_notice.= $shop_lang['prices_update_ok'];}
   if ($output_error<>'') {$output_error.= $shop_lang['prices_update_error'];}
}

$table2 = $modx->getFullTableName( 'site_tmplvar_contentvalues' );
$table3 = $modx->getFullTableName( 'site_tmplvars' );
$query31="SELECT *
		FROM  ".$table3."
		WHERE  `name` =  'price'";
$res3=$modx->db->query($query31);
$row3 = $modx->db->getRow($res3);
$query21='SELECT *
		FROM  '.$table2.'
		WHERE  `tmplvarid` ='.$row3['id'];
$res2=$modx->db->query($query21);

while ($row2 = $modx->db->getRow($res2))  {
    $t_parent=$row2['contentid'];
    settype($t_parent,"integer");
    $col_pr[$t_parent]= $row2['value'];
    $col_id[$t_parent]= $row2['id'];
};

$table = $modx->getFullTableName( 'site_content' );
$query31="SELECT *
		FROM  ".$table."
		WHERE  `published` =  '1'";
$res3=$modx->db->query($query31);

while ($row3 = $modx->db->getRow($res3))  {
    $t_parent=$row3['parent'];
    $t_id=$row3['id'];
    $t_pagetitle=$row3['pagetitle'];
    $t_longtitle=$row3['longtitle'];
    settype($t_parent,"integer");
    if($col_pr[$t_id]==""){
      if ($col[$t_parent]['col']==""){
          $n=0;
      } else {
         $n= $col[$t_parent]['col'];
      };
      $n+=1;
      settype($n,integer);
      settype($t_id,integer);
      $col[$t_parent]['col']=$n;
      $col[$t_parent][$n]=$t_id;
   }else{
      if ($col_p[$t_parent]['col']==""){
          $n=0;
      } else {
         $n= $col_p[$t_parent]['col'];
      };
      $n+=1;
      settype($n,integer);
      settype($t_id,integer);
      $col_p[$t_parent]['col']=$n;
      $col_p[$t_parent][$n]=$t_id;
    }
    $pt[$t_id] =$t_pagetitle;
    $lt[$t_id] =$t_longtitle;
};

$Col_por=0;


function PrintTable($j,$pt,$col_p,$col_pr,$col_id) {

 static $txt = "";
 static $r=0;

if ($j==0){
 return $txt;
};
 settype($j,integer);
 $txt.='<table class="grid" id="teble'.$j.'" STYLE="display:none">
 <thead>
   <tr align="center"><th colspan="3" style="font-size: 100%; font-family: sans-serif">';
   $txt.=$pt[$j];
 $txt.='</th></tr>
          <tr>
             <th width="10%" class="gridHeader">#</td>
             <th width="75%" class="gridHeader">'.$shop_lang['prices_table_name_title'].'</th>
             <th width="15%" class="gridHeader">'.$shop_lang['prices_table_price_title'].'</th>
          </tr>
          </thead>
          ';

  $n= $col_p[$j]['col'];
  if ($n!=""){
     settype($n,integer);
     for ( $i=1;$i<= $n; $i++)
     {
          $r++;
          $z=$col_p[$j][$i];
          settype($z,integer);

          $txt.='<tbody><tr><td>';
          $txt.=$i;
          $txt.='</td><td>';
          $txt.='<a href="'.$siteURL.'index.php?a=27&id='.$z.'" >'.$pt[$z];
          $txt.="</a></td><td>";
          $txt.="<input id='price".$z."' type='text' size='10' value='".$col_pr[$z]."'>
                <input id='_price".$z."' type='hidden' size='10' value='".$col_pr[$z]."'>
                <input id='id_price".$z."' type='hidden' size='10' value='".$col_id[$z]."'>
                <input id='price_".$r."' type='hidden' size='10' value='".$z."'>";
          $txt2.=$col_pr[$z];
          $txt.='</td></tr>';
     }
  };
 $txt.='</tbody></table>';
 $GLOBALS["Col_por"]=$r;
 return $txt;
}

function PriceCol(){
return $GLOBALS["Col_por"];
}

function PrintLi($j,$col,$pt,$col_p,$col_pr,$col_id) {
 settype($j,integer);
  $n= $col[$j]['col'];
  if ($n!=""){
     settype($n,integer);
     for ( $i=1;$i<= $n; $i++)
     {
          $z=$col[$j][$i];
          settype($z,integer);
          $nu.='<ul class="Container">';
          $n2= $col[$z]['col'];
          if ($n2!=""){
              if ($i<$n){
                 $nu.='<li class="Node ExpandClosed">';
            }else{
                  $nu.='<li class="Node ExpandClosed IsLast">';
            }
         }else{
              if ($i<$n){
                  $nu.='<li class="Node ExpandLeaf">';
            }else{
                  $nu.='<li class="Node ExpandLeaf IsLast">';
            }
          };
          $nu.='<div class="Expand"></div>';
          $nu.='<div class="Content"><a 	  id="ler'.$z.'">'.$pt[$z];
          if ($col_p[$z]['col']!=""){
                $nu.='<b>  ['.$col_p[$z]['col'].']</b>';
                PrintTable($z,$pt,$col_p,$col_pr,$col_id);
           };
          $nu.='</a></div>';
          $n2= $col[$z]['col'];
            if ($n2!=""){
               $nu.=PrintLi($z,$col,$pt,$col_p,$col_pr,$col_id);
          };
          $nu.='</li>';
          $nu.='</ul>';
     }
  };
 return $nu;
};
?>