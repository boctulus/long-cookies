<?php

use boctulus\LongCookies\core\libs\Files;

/*
    Si es parametrizado, devuelve el contenido del archivo

    Ej:

    config('discounts.php')
*/

if (function_exists('config')){
    function config($file = null){
        $path = __DIR__ . '/../../../config/';

        if ($file != null){
            return include $path . $file;
        }

        $cfg = include $path . 'config.php';

        if (file_exists($path . 'databases.php')){    
            $db  = include $path . 'databases.php';
        }

        return array_merge($cfg, $db);
    }
}
