/**
 * TSVshopNotifier
 *
 * Оповещения от модуля TSVshop на главной странице админки MODx (TSVshopNotifier plugin for MODx Evolution)
 *
 * @author    Telnij Sergey (Serg24) <tsv.art.com@gmail.com>, http://tsvshop.xyz
 * @category  plugin
 * @version 	1.1
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal	@events OnManagerWelcomeHome
 * @internal	@modx_category TSVshop
 * @internal  @installset base
 */

$e = &$modx->event;
switch($e->name){
    case 'OnManagerWelcomeHome':
		$count = $modx->db->getValue(
			$modx->db->select("COUNT(*)",$modx->getFullTableName('shop_order'),"status='Новый'")
		);
		$module_id = $modx->db->getValue(
			$modx->db->select("id",$modx->getFullTableName('site_modules'),"name='TSVshop'")
		);
		if (!empty($count)){
			$body = 'Новых заказов: <a href="/'.MGR_DIR.'/index.php?a=112&id='.$module_id.'">'.$count.'</a>';
		} else {
			$body = 'Новых заказов нет';
		}
                                
        $widgets['neworders'] = array(
            'menuindex' =>'3',
            'id' => 'neworders',
            'cols' => 'col-sm-12',
            'icon' => 'fa-shopping-bag',
            'title' => 'Новые заказы',
            'body' => '<div class="card-body">'.$body.'</div>'
        );
	/*$widgets['shopstat'] = array(
            'menuindex' =>'4',
            'id' => 'shopstat',
            'cols' => 'col-sm-6',
            'icon' => 'fa-rss',
            'title' => 'Статистика',
            'body' => '<div class="card-body">Статистика заказов</div>'
        );*/
        $e->output(serialize($widgets));
    break;
}

