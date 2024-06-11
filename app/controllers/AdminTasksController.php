<?php

namespace boctulus\LongCookies\controllers;

use boctulus\LongCookies\libs\Import;
use boctulus\LongCookies\core\libs\XML;
use boctulus\LongCookies\core\libs\Dokan;
use boctulus\LongCookies\core\libs\Users;
use boctulus\LongCookies\core\libs\Logger;
use boctulus\LongCookies\core\libs\System;
use boctulus\LongCookies\core\libs\Request;
use boctulus\LongCookies\core\libs\Products;
use boctulus\LongCookies\core\libs\DB;

class AdminTasksController
{
    function __construct()
    {   
        // Restringe acceso a admin
        Users::restrictAccess();
    }

    function index(){
        $php = System::getPHP();
        dd($php, 'PHP PATH');

        dd("Bienvenido!");
    }

    function migrate()
    {   
        dd("Migrating ...");

        $mgr = new MigrationsController();
        $mgr->migrate(); // "--dir=$folder", "--to=$tenant"
    }

    // Borra productos y sus categorias
    function wipe(){
        dd("Wiping products & categories ...");

        Products::deleteAllProducts();
        Products::deleteAllCategories(false, false);
    }

    /*
        --| max_execution_time
        300

        --| PHP version
        8.1.26
    */
    function show_system_vars(){
        dd(
            ini_get('max_execution_time'), 'max_execution_time'
        );

        dd(phpversion(), 'PHP version');
    }

    /*
        Devuelve algo como

        D:\www\woo6\wp-content\plugins\wp_runa\
    */
    function plugin_dir(){
        return realpath(__DIR__);
    }

    function get_smtp(){
        $smtp_host = ini_get('SMTP');
        $smtp_port = ini_get('smtp_port');
        $smtp_user = ini_get('smtp_user');
        $smtp_pass = ini_get('smtp_pass');

        // Muestra la información
        dd( "SMTP Host: $smtp_host");
        dd( "SMTP Port: $smtp_port");
        dd( "SMTP User: $smtp_user");
        dd( "SMTP Password: $smtp_pass");

        $to      = 'boctulus@gmail.com';    
        $subject = "Test";
        $message = "Probando 1,2,3";

        $sent = wp_mail($to, $subject, $message);        
        dd($sent, 'Sent?');
    }

    function log_me(){
        Logger::log(__FUNCTION__);
    }

    function log(){
        return file_exists(LOGS_PATH . 'log.txt') ? file_get_contents(LOGS_PATH . 'log.txt') : '--x--';
    }

    function error_log(){
       return file_exists(LOGS_PATH . 'errors.txt') ? file_get_contents(LOGS_PATH . 'errors.txt') : '--x--';
    }

    function debug_log(){
        return file_exists(__DIR__ . '/../wp-content/debug.log') ? file_get_contents(__DIR__ . '/../wp-content/debug.log') : '--x--';
    }

    function req(){
        return file_exists(LOGS_PATH . 'req.txt') ? file_get_contents(LOGS_PATH . 'req.txt') : '--x--';
    }

    function res(){
        return file_exists(LOGS_PATH . 'res.txt') ? file_get_contents(LOGS_PATH . 'res.txt') : '--x--';
    }

    function log_queries()
    {
        $logFilePath = LOGS_PATH . 'mysql.txt';

        try {
            $conn = DB::getConnection();
            
            // Habilitar el registro general de consultas
            $conn->exec("SET GLOBAL general_log = 1");
            
            // Establecer la ubicación del archivo de registro general de consultas
            $conn->exec("SET GLOBAL general_log_file = '$logFilePath'");
            
            dd("General query log enabled successfully.");
        } catch (\PDOException $e) {
            dd("Error: " . $e->getMessage());
        }
    }
    
    function adminer(){
        require_once __DIR__ . '/../scripts/adminer.php';
    }

    function update_db(){
        require __DIR__ . '/../scripts/installer.php';
        dd('done table creation');

        $this->insert();
        dd('done insert table');
    }

    function insert(){
        global $wpdb;
        
       // ...
    }
}
