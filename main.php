<?php

use boctulus\LongCookies\libs\Main;
use boctulus\LongCookies\core\libs\Url;
use boctulus\LongCookies\core\libs\Page;
use boctulus\LongCookies\core\libs\Posts;
use boctulus\LongCookies\core\libs\Logger;
use boctulus\LongCookies\libs\SubsReactor;
use boctulus\LongCookies\core\libs\Plugins;
use boctulus\LongCookies\libs\TutorLMSWooSubsAutomation;

/*
    @author Pablo Bozzolo < boctulus@gmail.com >

*/

// Mostrar errores
if ((php_sapi_name() === 'cli') || (isset($_GET['show_errors']) && $_GET['show_errors'] == 1)){
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);
}


// Cambiar tiempo de expiracion de cookie de inicio de session

add_filter ( 'auth_cookie_expiration', 'wp_login_session' );

function wp_login_session( $expire )
{
    $expire = 3600 * 24 * 365;
    
    if (defined('AUTH_COOKIE_EXPIRATION')){
        $expire = AUTH_COOKIE_EXPIRATION;
    } 
    
    return $expire;
}


// require_once __DIR__ . '/menu.php';

new Main();

