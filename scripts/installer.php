<?php

use boctulus\LongCookies\core\libs\Config;

/*
    Seteo opciones la primera vez que se activa el plugin (al instalarse)

    La opciones provienen del config.php

        'options' => [
            'op1' => 'value 1',
            'op2' => 'value 2'
        ],    
*/

$options = Config::get('options');

if (!empty($options) && !get_transient(Config::get('namespace') . '__init')){     
    foreach($options as $opt_name => $value){
        update_option($opt_name, $value);        
    }

    set_transient(Config::get('namespace') . '__init', 1);
}



//require_once __DIR__ . '/db/01_link2product_metadata.php';
//require_once __DIR__ . '/db/05_posts_to_lik2prd.php';

// Creacion de otras tablas
// ...

