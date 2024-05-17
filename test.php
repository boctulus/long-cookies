<?php

use boctulus\TolScraper\core\libs\DB;
use boctulus\TolScraper\core\libs\Config;
use boctulus\TolScraper\core\libs\Logger;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (php_sapi_name() != "cli"){
	return; 
}

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', realpath(__DIR__ . '/../../..') . DIRECTORY_SEPARATOR);

	require_once ABSPATH . '/wp-config.php';
	require_once ABSPATH .'/wp-load.php';
}

require_once __DIR__ . '/app.php';

////////////////////////////////////////////////


dd(shortcode_asset('/img/no-image.jpg'));

exit;

DB::getConnection('robot');

dd(
	DB::getTablePrefix(), 'TB PREFIX'
);