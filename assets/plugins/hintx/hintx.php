<?php

function loadhint($type, $id, $lang) {
    global $modx;
    switch ($type) {
        case "chunk":
            $name = $modx->db->getValue($modx->db->select("name", $modx->getFullTableName("site_htmlsnippets"), "id=" . $id));
            $path = MODX_BASE_PATH . "assets/plugins/hintx/chunks/$lang/$name.$type";
            if (file_exists($path)) {
                return file_get_contents($path);
            }
            break;
        case "template":
            $name = $modx->db->getValue($modx->db->select("templatename", $modx->getFullTableName("site_templates"), "id=" . $id));
            $path = MODX_BASE_PATH . "assets/plugins/hintx/chunks/$lang/$name.$type";
            if (file_exists($path)) {
                return file_get_contents($path);
            }
            break;
        default:
            return;
        //break;
    }
    return "";
}

// событие
$e    = &$modx->Event;
$id   = $e->params["id"];
$lang = isset($e->params["lang"]) ? $e->params["lang"] : "ru";
switch ($e->name) {
    case "OnChunkFormRender":
        $selector = ".sectionBody";
        $text     = addslashes(loadhint("chunk", $id, $lang));
        break;
    case "OnTempFormRender":
        $selector = "#tabTemplate";
        $text     = addslashes(loadhint("template", $id, $lang));
        break;
    default:
        return;
        //break;
}
$text  = str_replace("\r", "\\r", $text);
$text  = str_replace("\n", "\\n", $text);
$jfunc = "jQuery('$selector').find('TABLE').after('$text');";


// выводим пояснительный текст в редактор
echo <<<CLIENT_PLUGIN_TEXT
	<script src="/assets/js/jquery-1.4.4.min.js" ></script>
	<script>
	jQuery.noConflict();
	jQuery(document).ready(function(){
		$jfunc
	})
	</script>
CLIENT_PLUGIN_TEXT;
?>