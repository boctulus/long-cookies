<?php

namespace boctulus\TolScraper\libs;

use boctulus\TolScraper\core\Router;
use boctulus\TolScraper\core\libs\Users;
use boctulus\TolScraper\core\libs\Config;
use boctulus\TolScraper\core\libs\Logger;
use boctulus\TolScraper\core\FrontController;

/*
    @author Pablo Bozzolo < boctulus@gmail.com >
*/

class Main
{ 
    function __construct()
    {
        add_action('init', [$this, 'init']);
        add_action('wp_footer', [$this, 'wp_footer']);
        add_action('admin_footer', [$this, 'admin_footer']);
    }

    function init()
    {   
        Router::resolve();  
        FrontController::resolve();
    }

    function wp_footer(){

    }

    function admin_footer(){

    }

}