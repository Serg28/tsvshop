<?php 
$cssUrls = array(
	'switch' => array(
		'url' => $modx->config['site_url'].'assets/tvs/switch/switch.css',
		'name' => 'switch',
		'version' => '1.0'
	)
);
if (!function_exists("includeJsCss")) {
  echo includeJsCss($cssUrls['switch']['url'], $cssUrls['switch']['name'], $cssUrls['switch']['version']);
} else {
  echo '<link rel="stylesheet" type="text/css" href="'.$cssUrls['switch']['url'].'" />';
}

$checked = (empty($field_value)) ? "" : "checked='checked'";
?>

<label class="switch switch-small">
<input type="checkbox" id="tv[+field_id+]" name="tv[+field_id+][]" value="1" <?php echo $checked; ?> onchange="documentDirty=true;" /><span></span>
</label>