/**
 * TSVshopNotifier
 *
 * Отображение новых заказов модуля TSVshop на главной странице админки MODx (TSVshopNotifier plugin for MODx Evolution)
 *
 * @author    Telnij Sergey (Serg24) <privat_tel@mail.ru>, http://tsvshop.tsv.org.ua, http://tsvshop.xyz
 * @category  plugin
 * @version 	1.0
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal	@events OnManagerWelcomePrerender
 * @internal	@modx_category TSVshop
 * @internal  @installset base
 */

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
<div class="sectionBody">Новых заказов: <a href="/'.MGR_DIR.'/index.php?a=112&id='.$module_id.'">'.$count.'</a></div>';
} else {
$output = '<div class="sectionHeader" style="color:red">Новые заказы:</div>
<div class="sectionBody">Новых заказов нет</div>';
}
$e->output($output);
}
