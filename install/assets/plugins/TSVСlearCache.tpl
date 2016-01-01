 /**
 * TSVсlearCache
 *
 * Сброс кеша магазина TSVshop
 *
 * @author	 	lecosson@gmail.com,  Telnij Sergey (Serg24) <privat_tel@mail.ru>, http://tsvshop.tsv.org.ua, http://tsvshop.xyz
 * @category 	plugin
 * @version 	0.02
 * @license 	http://www.opensource.org/licenses/gpl-2.0.php GNU Public License Version 2 (GPL2)
 * @internal	@events OnCacheUpdate,OnManagerPageInit,TSVshopOnViewItemCard
 * @internal	@modx_category TSVshop
 * @internal  @installset base
 */
if(!function_exists("TSVclearCache"))
{
    function TSVclearCache($dir) {
	if ($objs = glob($dir."/*")) {
		foreach($objs as $obj) {
			is_dir($obj) ? TSVclearCache($obj) : unlink($obj);
		}
	}
	rmdir($dir);
    }
}

global $modx;
$e=&$modx->Event;
$action=$e->params["action"];
if ($action==26 || $e->name == 'OnCacheUpdate') {
	$dir=MODX_BASE_PATH.'assets/cache/t/';
  if (file_exists($dir)) {
	    TSVclearCache($dir);
  }
}

if ($e->name == 'TSVshopOnViewItemCard') { 
  // плагин получает
  // $itemid  - ID товара
  // $type - тип товара: docs - документ MODx, catalog - из каталога TSVcatalog
}
