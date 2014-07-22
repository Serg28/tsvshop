$output = "";
$e = &$modx->Event;
if($e->name == 'OnManagerWelcomePrerender'){

$count = $modx->db->getValue(
$modx->db->select("COUNT(*)",$modx->getFullTableName('shop_order'),"status='Новый'")
);
$module_id = $modx->db->getValue(
$modx->db->select("id",$modx->getFullTableName('site_modules'),"name='TSVshop'")
);
if (!empty($count)){
$output = '<div class="sectionHeader" style="color:red">Новые заказы:</div>
<div class="sectionBody">Новых заказов: <a href="index.php?a=112&id='.$module_id.'">'.$count.'</a></div>';
}
$e->output($output);
}
