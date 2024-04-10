<?php

/*
    @author Pablo Bozzolo < boctulus@gmail.com >

    Version: -- 
*/
    
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__   . '/app/core/helpers/debug.php';
require_once __DIR__   . '/app/core/helpers/autoloader.php';

require_once __DIR__   . '/config/constants.php';

/*
    CFG
*/

$cfg = require __DIR__ . '/config/config.php';



if (defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY){
	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
}

ini_set('display_errors', 0);


