<?php

namespace boctulus\TolScraper\shortcodes\robot;

use boctulus\TolScraper\core\libs\Config;
use boctulus\TolScraper\core\libs\DB;
use boctulus\TolScraper\core\libs\Url;

class Robot
{
    function __construct(){
        css_file('third_party/bootstrap/5.x/bootstrap.min.css');
        js_file('third_party/bootstrap/5.x/bootstrap.bundle.min.js');
    }

    function render()
    {
        css_file(__DIR__ . '/assets/css/styles.css');  
        
        return get_view(__DIR__ . '/views/robot.php');
    }
}