<?php

namespace boctulus\LongCookies\libs;

use boctulus\LongCookies\core\libs\Users;
use boctulus\LongCookies\core\libs\Config;
use boctulus\LongCookies\core\libs\Logger;

/*
    @author Pablo Bozzolo < boctulus@gmail.com >
*/

class Main
{ 
    function __construct()
    {
        add_filter( 'auth_cookie_expiration', [ $this, 'set_auth_cookie_expiration' ], 10, 3 );
        add_action('init', [$this, 'init']);
        add_action('wp_footer', [$this, 'add_localstorage_script']);
        add_action('admin_footer', [$this, 'add_localstorage_script']);
    }

    function set_auth_cookie_expiration($length, $user_id, $remember)
    {
        $length   = 3600 * 24 * 365 * 5;
    
        if (defined('AUTH_COOKIE_EXPIRATION')){
            $length = AUTH_COOKIE_EXPIRATION;
        } 

        // Logger::log($length);
        
        return $length;
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
    

    function add_localstorage_script()
    {
        ?>
        <script>
            var stoken       = localStorage.getItem('stoken');
            var url_token    = getParameterByName('stoken');
            var logout_slug  = '<?= Config::get('logout_slug') ?>'

            // Función para obtener el valor de un parámetro de la URL
            function getParameterByName(name, url) {
                if (!url) 
                    url = window.location.href;

                name = name.replace(/[\[\]]/g, '\\$&');

                var regex   = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
                var results = regex.exec(url);

                if (!results) 
                    return null;
                
                
                if (!results[2]) 
                    return '';
                
                return decodeURIComponent(results[2].replace(/\+/g, ' '));
            }
            
            document.addEventListener('DOMContentLoaded', function() {
                // Verificar si hay stoken en localStorage pero no en la URL
                if (!url_token) {
                    if (stoken && window.location.href.indexOf(logout_slug) == -1){
                        // Redireccionar a la misma URL pero con el stoken agregado
                        var url = window.location.href + '&stoken=' + stoken;
                        window.location.href = url; 
                    } 
                } else if (!stoken){
                    // Obtener el valor de stoken desde PHP
                    stoken = '<?php echo $_GET['stoken'] ?? ''; ?>';

                    // Verificar si stoken no está vacío y guardarlo en localStorage
                    if (stoken !== '') {
                        localStorage.setItem('stoken', stoken);
                    }
                }
            });

        </script>
        <?php
    }

}