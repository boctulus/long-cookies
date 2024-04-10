<?php

namespace boctulus\SW\libs;

/*
    @author  Pablo Bozzolo boctulus@gmail.com
*/

class Main
{ 
    function __construct(){
        
        add_action('init', [$this, 'init']);
    }

    function init(){
        // Verificar si la URL no contiene "logout" y no tiene la variable "token"
        if (strpos($_SERVER['REQUEST_URI'], 'logout') === false && empty($_GET['token'])) {
            // Obtener el token y agregarlo a la URL
            $token = $this->token();
            
            if ($token) {
                $url = add_query_arg('token', $token, $_SERVER['REQUEST_URI']);
                wp_redirect($url); // Redireccionar a la URL con el token agregado
                exit;
            }
        }
    }

    function token(){
        $uid = get_current_user_id(); 
    
        if ($uid == 0) {
            return; 
        }
    
        return ($this->encode($uid));
    }

    function encode($uid){
        return base64_encode(1000 + $uid);
    }
    
    function decode($uid){
        return base64_decode($uid) - 1000;
    }
    

}