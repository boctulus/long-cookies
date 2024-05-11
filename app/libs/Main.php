<?php

namespace boctulus\LongCookies\libs;

use boctulus\LongCookies\core\libs\Users;
use boctulus\LongCookies\core\libs\Config;

/*
    @author Pablo Bozzolo < boctulus@gmail.com >
*/

class Main
{ 
    function __construct()
    {
        
        /*
            Cambiar tiempo de expiracion de cookie de inicio de session
        */

        add_filter ('auth_cookie_expiration', [$this, 'wp_login_session']); 
        add_action('init', [$this, 'init']);
    }

    function wp_login_session( $expire )
    {
        $expire = 3600 * 24 * 365;
    
        if (defined('AUTH_COOKIE_EXPIRATION')){
            $expire = AUTH_COOKIE_EXPIRATION;
        } 
        
        return $expire;
    }

    function init()
    {   
        // Verificar si la URL no contiene "logout" y no tiene la variable "stoken"
        if (strpos($_SERVER['REQUEST_URI'], Config::get('logout_slug')) === false && empty($_GET['stoken'])) {
            // Obtener el stoken y agregarlo a la URL
            $stoken = $this->stoken();

            if ($stoken) {
                $url = add_query_arg('stoken', $stoken, $_SERVER['REQUEST_URI']);
                wp_redirect($url); // Redireccionar a la URL con el stoken agregado
                exit;
            }
        }

        // Verificar si el usuario está deslogueado
        $uid = get_current_user_id();

        if ($uid == 0 && isset($_GET['stoken'])) 
        {
            $uname = $this->decode($_GET['stoken']);

            Users::loginNoPassword($uname);
        }
    }

    function stoken(){
        $uid = get_current_user_id(); 
    
        if ($uid == 0) {
            return; 
        }

        $uname = Users::getUsernameByID($uid);
    
        return ($this->encode($uname));
    }

    function encode(string $uname){
        return base64_encode('pbz' . $uname);
    }
    
    function decode(string $uname){
        return substr(base64_decode($uname), 3);
    }
    

}