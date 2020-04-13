<?php
$output .= '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" '.($modx->config['manager_direction'] == 'rtl' ? 'dir="rtl"' : '').' lang="'.$modx->config['manager_lang_attribute'].'" xml:lang="'.$modx->config['manager_lang_attribute'].'">
		<head>
        <title>'.$shop_lang['modulename'].'</title>
        <link rel="stylesheet" type="text/css" href="media/style' . $theme . '/style.css" />
		
        <!-- jeasyui -->
        <link rel="stylesheet" type="text/css" href="'.MODX_BASE_URL.'assets/js/easy-ui/themes/modxevo/easyui.css">
	    <link rel="stylesheet" type="text/css" href="'.MODX_BASE_URL.'assets/js/easy-ui/themes/icon.css">     
	    <script type="text/javascript" src="'.MODX_BASE_URL.'assets/js/jquery.min.js" language="javascript" ></script> 	
	    <script type="text/javascript" src="'.MODX_BASE_URL.'assets/js/easy-ui/locale/easyui-lang-ru.js"></script>
	    <script type="text/javascript" src="'.MODX_BASE_URL.'assets/js/easy-ui/jquery.easyui.min.js"></script>
	    <script type="text/javascript" src="'.MODX_BASE_URL.'assets/js/easy-ui/plugins/jquery.edatagrid.js"></script>


        <script type="text/javascript" src="media/script/tabpane.js"></script>
		<link rel="stylesheet" type="text/css" href="'.MODX_BASE_URL.'assets/snippets/tsvshop/admin/libs/datetimepicker/css/datepicker.css"/>

        <script type="text/javascript" src="media/script/mootools/mootools.js"></script>

        <script type="text/javascript" src="media/script/mootools/moodx.js"></script>
        <script type="text/javascript" src="media/calendar/datepicker.js"></script>
        <script src="'.MODX_BASE_URL.'assets/snippets/tsvshop/admin/libs/datagrid/tablefilter_all_min.js" language="javascript" type="text/javascript"></script>
        <!-- Additional imported module needed for this demo  -->
        <script src="'.MODX_BASE_URL.'assets/snippets/tsvshop/admin/libs/datagrid/sortabletable.js" language="javascript" type="text/javascript"></script>
        <script src="'.MODX_BASE_URL.'assets/snippets/tsvshop/admin/libs/datagrid/tfAdapter.sortabletable.js" language="javascript" type="text/javascript"></script>
        <script src="'.MODX_BASE_URL.'assets/snippets/tsvshop/admin/libs/datagrid/TF_Modules/tf_paging.js" language="javascript" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="'.MODX_BASE_URL.'assets/snippets/tsvshop/admin/libs/datagrid/filtergrid.css">
        <link rel="stylesheet" type="text/css" href="'.MODX_BASE_URL.'assets/snippets/tsvshop/admin/template/themes/'.$moduletheme.'.css" />

        <!-- /grid -->
		<script type="text/javascript" src="'.MODX_BASE_URL.'assets/snippets/tsvshop/js/core.js"></script>

		</head>
        <body class=" dark" data-evocp="color">
';

?>
