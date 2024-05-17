<?php

use boctulus\TolScraper\core\libs\Env;


return [
    'is_enabled' => Env::get('ENABLED', true),

    ////////////////////////////////////////////////////////////////////////////////

    'options' => [
    //     'op1' => 'value 1',
    //     'op2' => 'value 2'
    ],
    
	// "field_separator" => ";",

	// "memory_limit" => "728M",
	// "max_execution_time" => 1800,
	// "upload_max_filesize" => "50M",
	// "post_max_size" => "50M",

    //
    // No editar desde aqui
    //

    'app_name'          => Env::get('APP_NAME'),
    'namespace'         => "boctulus\TolScraper", 
    'use_composer'      => false, // 

    /*
        Intercepta errores
    */
    
    'error_handling'    => true,

    /*
        Puede mostrar detalles como consultas SQL fallidas 

        Ver 'log_sql'
    */

    'debug'             => Env::get('DEBUG'),

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

    'front_controller' => true,
    'router'           => true,
];

