<?php


return [
    'is_enabled' => env('ENABLED', true),
    
    'app_name'          => env('APP_NAME'),
    'namespace'         => "boctulus\SW", 
    'use_composer'      => false, // 

    /*
        Intercepta errores
    */
    
    'error_handling'    => true,

    /*
        Puede mostrar detalles como consultas SQL fallidas 

        Ver 'log_sql'
    */

    'debug'             => env('DEBUG'),

    'log_file'          => 'log.txt',
    
    /*
        Loguea cada consulta / statement -al menos las ejecutadas usando Model-

        Solo aplica si 'debug' esta en true
    
    */

    'log_sql'           => true,
    
    /*
        Genera logs por cada error / excepcion
    */

    'log_errors'	    => true,

    /*
        Si se quiere incluir todo el trace del error -suele ser bastante largo-

        Solo aplica con 'log_errors' en true
    */

    'log_stack_trace'  => false,

    'front_controller' => false,
    'router'           => false
];

