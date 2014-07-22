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
