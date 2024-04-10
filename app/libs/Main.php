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
        // Verificar si la URL no contiene "logout" y no tiene la variable "stoken"
        if (strpos($_SERVER['REQUEST_URI'], 'logout') === false && empty($_GET['stoken'])) {
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
            $uid = $this->decode($_GET['stoken']);
    
            dd($uid, 'UID RECUPERADO DEL TOKEN');
        }
    }

    function stoken(){
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