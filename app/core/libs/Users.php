<?php

/*
    @author  Pablo Bozzolo boctulus@gmail.com
*/

namespace boctulus\LongCookies\core\libs;

/*
    Version truncada
*/

class Users
{
    static function isGuest(){
        return get_current_user_id() === 0;
    }

    static function isLogged(){
        return get_current_user_id() !== 0;
    }

    static function getUsernameByID($uid) {
        $user = get_user_by('id', $uid);

        // Verificar si se encontró un usuario
        if ($user) {
            return $user->user_login; // Devolver el nombre de usuario
        } else {
            return false; // Usuario no encontrado
        }
    }


    // login por username sin password
    static function loginNoPassword(string $username, $redirect = true){
        $user = get_user_by('login', $username );
        
        // Redirect URL //
        if ( !is_wp_error( $user ) )
        {
            wp_clear_auth_cookie();
            wp_set_current_user ( $user->ID );
            wp_set_auth_cookie  ( $user->ID );
        
            if ($redirect){
                $redirect_to = (is_string($redirect) ? $redirect : user_admin_url());
                wp_safe_redirect( $redirect_to );
                exit();
            }
        } else {
            $error_message = $user->get_error_message();
            // 
        }

        return !is_wp_error($user);
    }



   
}