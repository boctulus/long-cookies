<?php

use boctulus\TolScraper\libs\Main;
use boctulus\TolScraper\core\libs\Url;
use boctulus\TolScraper\core\libs\Page;
use boctulus\TolScraper\core\libs\Posts;
use boctulus\TolScraper\core\libs\Logger;
use boctulus\TolScraper\libs\SubsReactor;
use boctulus\TolScraper\core\libs\Plugins;
use boctulus\TolScraper\libs\TutorLMSWooSubsAutomation;
use boctulus\TolScraper\shortcodes\robot\Robot;

/*
    @author Pablo Bozzolo < boctulus@gmail.com >

*/

// Mostrar errores
if ((php_sapi_name() === 'cli') || (isset($_GET['show_errors']) && $_GET['show_errors'] == 1)){
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);
}


add_shortcode('robot', function(){
    $robot = new Robot();
    return $robot->render();
});

// require_once __DIR__ . '/menu.php';

new Main();

