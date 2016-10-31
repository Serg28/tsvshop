<?php
$host = $_POST['host'];
$uid = $_POST['uid'];
$pwd = $_POST['pwd'];
$installMode = $_POST['installMode'];

require_once("lang.php");

$output = $_lang["status_checking_database"];
if (!$conn = @ mysql_connect($host, $uid, $pwd)) {
    $output .= '<span id="database_fail" style="color:#FF0000;">'.$_lang['status_failed'].'</span>';
}
else {
    if (version_compare(phpversion(), "5.3") < 0) {
        if(get_magic_quotes_gpc()) {
            $_POST['database_name'] = stripslashes($_POST['database_name']);
            $_POST['tableprefix'] = stripslashes($_POST['tableprefix']);
            $_POST['database_collation'] = stripslashes($_POST['database_collation']);
            $_POST['database_connection_method'] = stripslashes($_POST['database_connection_method']);
        }
    }
    $database_name = mysql_real_escape_string($_POST['database_name']);
    $database_name = str_replace("`", "", $database_name);
    $tableprefix = mysql_real_escape_string($_POST['tableprefix']);
    $database_collation = mysql_real_escape_string($_POST['database_collation']);
    $database_connection_method = mysql_real_escape_string($_POST['database_connection_method']);

    if (!@ mysql_select_db($database_name, $conn)) {
        // create database
        $database_charset = substr($database_collation, 0, strpos($database_collation, '_'));
        $query = "CREATE DATABASE `".$database_name."` CHARACTER SET ".$database_charset." COLLATE ".$database_collation.";";

        if (!@ mysql_query($query)){
            $output .= '<span id="database_fail" style="color:#FF0000;">'.$_lang['status_failed_could_not_create_database'].'</span>';
        }
        else {
            $output .= '<span id="database_pass" style="color:#80c000;">'.$_lang['status_passed_database_created'].'</span>';
        }
    }
    elseif (($installMode == 0) && (@ mysql_query("SELECT COUNT(*) FROM {$database_name}.`{$tableprefix}site_content`"))) {
        $output .= '<span id="database_fail" style="color:#FF0000;">'.$_lang['status_failed_table_prefix_already_in_use'].'</span>';
    }
    elseif (($database_connection_method != 'SET NAMES') && ($rs = @ mysql_query("show variables like 'collation_database'")) && ($row = @ mysql_fetch_row($rs)) && ($row[1] != $database_collation)) {
        $output .= '<span id="database_fail" style="color:#FF0000;">'.sprintf($_lang['status_failed_database_collation_does_not_match'], $row[1]).'</span>';
    }
    else {
        /// проверка для установки на мою сборку автоматическое выполнение запроса
        if ($installMode != 0) {
            $avtest = @ mysql_query("SELECT alias_visible FROM {$database_name}.`{$tableprefix}site_content`");
            if ($avtest)  { 
               $output .= ' ';
            }else {
                $avadd = @ mysql_query("ALTER TABLE  {$database_name}.`{$tableprefix}site_content` ADD  `alias_visible` INT( 2 ) NOT NULL DEFAULT  '1'");
                $avtest2 = @ mysql_query("SELECT alias_visible FROM {$database_name}.`{$tableprefix}site_content`");
                if ($avtest2)  { 
                    $output .= ' ';
                }else {
                    $output .= '<span id="database_pass" style="color:#FF0000;">ошибка при добавлении alias_visible</span><br/>';
                }
            }
        }   

        $output .= '<span id="database_pass" style="color:#80c000;">'.$_lang['status_passed'].'</span>';
    }
}

echo $output;
?>