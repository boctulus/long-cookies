<?php

namespace boctulus\TolScraper\controllers;

use boctulus\TolScraper\core\libs\Env;
use boctulus\TolScraper\core\libs\System;

class DumbController
{
    function test_bg(){
        $file_path  = System::isWindows() ? Env::get('PYTHON_BINARY') : 'python3';
        $dir        = Env::get('ROBOT_PATH') ;
        $args       = "index.py pablotol.py";

        dd("$file_path $args", 'CMD');

        // $pid = System::execInBackgroundWindows($file_path, $dir, $args); // ok
        $pid = System::runInBackground($file_path, $dir, $args); // ok
        dd($pid, 'PID');

        sleep(1);
        dd(System::isProcessAlive($pid), 'Alive?');
    }

}