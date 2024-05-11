<?php

use boctulus\LongCookies\core\Constants;
use boctulus\LongCookies\core\Router;
use boctulus\LongCookies\core\libs\DB;
use boctulus\LongCookies\core\libs\Files;
use boctulus\LongCookies\core\libs\Config;
use boctulus\LongCookies\core\FrontController;

/*
	Plugin Name: Long Cookies
	Description: Cookies extender
	Version: 1.5.0
	Author: Pablo Bozzolo
	Domain Path:  /languages
	Text Domain: long-cookies
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

require_once __DIR__ . '/app.php';

if (!in_array(Config::get('is_enabled'), [true, '1', 'on'])){
	return;
}

register_activation_hook( __FILE__, function(){
	$log_dir = __DIR__ . '/logs';
	
	if (is_dir($log_dir)){
		Files::globDelete($log_dir);
	} else {
		Files::mkdir($log_dir);
	}

	include_once __DIR__ . '/on_activation.php';
});

db_errors(false);


// Mostrar errores
if ((php_sapi_name() === 'cli') || (isset($_GET['show_errors']) && $_GET['show_errors'] == 1)){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
} else {
	if (Config::get('debug') == false){
		error_reporting(E_ALL & ~E_WARNING);
		error_reporting(0);
	}	
}

require_once __DIR__ . '/main.php';






