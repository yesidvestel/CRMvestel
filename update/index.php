<?php
define('BASEPATH', '2.8');
include "../application/config/constants.php";
include "version.php";
$php_version_success = false;
$install_version = false;
$mysql_success = false;
$curl_success = false;
$gd_success = false;
$allow_url_fopen_success = false;
$timezone_success = false;

$php_version_required = "5.6.0";
$current_php_version = PHP_VERSION;
$insttled=substr(APPVER,3);
//check required php version
if (version_compare($current_php_version, $php_version_required) >= 0) {
    $php_version_success = true;
}
//echo $insttled;
if (version_compare($insttled, PREVIOUS) > 0) {
    $install_version = true;
}

//check mySql 
if (function_exists("mysqli_connect")) {
    $mysql_success = true;
}

//check curl 
if (function_exists("curl_version")) {
    $curl_success = true;
}

//check gd
if (extension_loaded('gd') && function_exists('gd_info')) {
    $gd_success = true;
}

//check allow_url_fopen
if (ini_get('allow_url_fopen')) {
    $allow_url_fopen_success = true;
}

//check allow_url_fopen
$timezone_settings = ini_get('date.timezone');
if ($timezone_settings) {
    $timezone_success = true;
}

//check if all requirement is success
if ($php_version_success && $mysql_success && $curl_success && $gd_success && $allow_url_fopen_success && $timezone_success) {
    $all_requirement_success = true;
} else {
    $all_requirement_success = false;
}


$writeable_directories = array(
    'routes' => '/index.php',
    'routes_crm' => '/crm/index.php',
    'config_cache' => '/application/cache',
    'config_1' => '/application/config/config.php',
    'db' => '/application/config/database.php',
    'db_1' => '/application/config/lic.php',
    'config_crm' => '/crm/application/cache',
    'config' => '/crm/application/config/config.php',
    'db_c' => '/crm/application/config/database.php',
    'config_data' => '/userfiles/'
);

foreach ($writeable_directories as $value) {
    if (!is_writeable(".." . $value)) {
        $all_requirement_success = false;
    }
}

$dashboard_url = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
$dashboard_url = preg_replace('/install.*/', '', $dashboard_url); //remove everything after index.php
if (!empty($_SERVER['HTTPS'])) {
    $dashboard_url = 'https://' . $dashboard_url;
} else {
    $dashboard_url = 'http://' . $dashboard_url;
}

include "view/index.php";
?>