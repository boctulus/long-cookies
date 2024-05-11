<?php

namespace boctulus\LongCookies\controllers;

use boctulus\LongCookies\core\libs\DB;
use boctulus\LongCookies\core\libs\Users;
use boctulus\LongCookies\core\libs\Logger;
use boctulus\LongCookies\core\libs\Strings;


/*
    Este controlador es para demostrar capacidades de una libreria

    Se limita su uso a usuarios con rol de Adminr por seguridad
*/
class UsersController
{
    /*
        Devuelve Users en JSON
    */
    function get_list($after_id = null)
    {
        // $this->checkpoint();

        $users = table('users')
        ->when($after_id !== null, function($q) use ($after_id){
            $q->where(['ID', $after_id, '>']);
        })
        ->get();

        response()->send($users);
    }

    /*
        Registra uno o mas usuarios y si es solo uno lo loguea

        Ej:

        woo8.lan/users/register?sec_code=boctulus1
    */
    function register($role = 'subscriber')
    {
        $this->checkpoint();
        
        $uname = $_GET['username'] ?? Strings::randomString(20, false); 
       
        $uid = Users::create($uname, null, null, $role); 
                 
        if (!empty($uid)){
            Users::loginNoPassword($uname);
        }
    }

    /*
        Ej:

        woo8.lan/users/register_many/5?sec_code=boctulus1
    */
    function register_many(int $n = 5, $role = 'subscriber')
    {
        $this->checkpoint();

        for ($i=0; $i<$n; $i++){
            $uname = Strings::randomString(20, false);
            $uid = Users::create($uname, null, null, $role); 

            dd("Creado usuario con rol = '$role' y username = $uname | user_id = $uid");
        }          
    }

    /*  
        /user/login
        
        Ej:

        http://woo8.lan/users/login?sec_code=boctulus1&email=boctulus@gmail.com
        http://woo8.lan/users/login?sec_code=boctulus1&email=boctulus@gmail.com&location=/wp-admin/plugins.php%3Fplugin_status=active

        Donde para por ejemplo location=/wp-admin/plugins.php?plugin_status=active
        
        %3F es ? 
        %26 es &
    */
    function login(){
        $this->checkpoint();

        $email = $_GET['email'] ?? null;
        $uname = $_GET['username'] ?? null;
        $redir = $_GET['redirect_to'] ?? $_GET['location'] ?? true;

        if (empty($email) && empty($uname)){
            wp_die("email or username are required");
        }

        if (empty($uname)){
            $uname = Users::getUsernameByEmail($email);
        }

        Users::loginNoPassword($uname, $redir);
    }

    function login_as_admin(){
        $this->checkpoint();

        $email = Users::getAdminEmail();

        if (empty($email)){
            wp_die("Email not found");
        }

        $uname = Users::getUsernameByEmail($email);

        Users::loginNoPassword($uname);
    }

    /*
        Ultimo usuario creado
    */
    function last(){
        $this->checkpoint();

        $last_user   = Users::getLast();

        if ($last_user){
            $user_id    = $last_user->data->ID;
            $user_email = $last_user->data->user_email;

            dd($user_email, "LAST USER with ID=$user_id");
        }
    }
    
    /*
        Cambia e-mail del Admin

        /users/set_admin_email/boctulus@gmail.com
    */
    function set_admin_email($email){
        $this->checkpoint();

        Users::setAdminEmail($email);
    }

    protected function checkpoint(){
        if (($_GET['sec_code'] ?? null) != 'boctulus1'){
            wp_die("Unauthorized");
        }
    }
}
