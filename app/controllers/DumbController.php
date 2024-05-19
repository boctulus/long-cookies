<?php

namespace boctulus\TolScraper\controllers;

use boctulus\TolScraper\core\libs\Env;
use boctulus\TolScraper\core\libs\System;

class DumbController
{
    function test_py(){
        dd("cd ". Env::get('ROBOT_PATH'));
        chdir(Env::get('ROBOT_PATH'));

        $cmd = "ls";
        dd(
            shell_exec($cmd), "$cmd"
        );

        $cmd = Env::get('PYTHON_BINARY') . " --version";     
        dd(
            shell_exec($cmd), "$cmd"
        );

        $cmd = Env::get('PYTHON_BINARY') . " test_py.py";     
        dd(
            shell_exec($cmd), "$cmd"
        );
    }

    function test_bg(){
        $file_path  = System::isWindows() ? Env::get('PYTHON_BINARY') : 'python3';
        $dir        = Env::get('ROBOT_PATH') ;
        $args       = "test_py.py";

        dd("$file_path $args", 'CMD');

        // $pid = System::execInBackgroundWindows($file_path, $dir, $args); // ok
        $pid = System::runInBackground($file_path, $dir, $args); // ok
        dd($pid, 'PID');

        sleep(1);
        dd(System::isProcessAlive($pid), 'Alive?');
    }

    function test_bg_2(){
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