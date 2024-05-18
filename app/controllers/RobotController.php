<?php

namespace boctulus\TolScraper\controllers;

use boctulus\TolScraper\core\libs\DB;
use boctulus\TolScraper\core\libs\Env;
use boctulus\TolScraper\core\libs\HTTP;
use boctulus\TolScraper\core\libs\Config;
use boctulus\TolScraper\core\libs\Logger;
use boctulus\TolScraper\core\libs\System;
use boctulus\TolScraper\core\libs\Response;
use boctulus\TolScraper\shortcodes\robot\Robot;

class RobotController
{
    protected $robot_path;

    function __construct()
    {
        HTTP::cors();

        $this->robot_path = Env::get('ROBOT_PATH');
    }

   function index()
    {
        new Robot();                
    }


    protected function setupConnection(){
        DB::getConnection('robot');
    }

    /*
        Crea una orden a ejecutar

        TO-DO

        - La crea pero la debe poner en ejecucion invocando a Python con el script y el archivo de instrucciones
    */
    function order(){
        try {
            $raw   = file_get_contents("php://input");
            $order = json_decode($raw, true);

            $file  = 'order-' . ((string) time()) . '-' . ((string) rand(100,999)) . '.json';            
            $path  = $this->robot_path . "/instructions/$file";

            $bytes = file_put_contents($path, $raw);

            Logger::dd($bytes, $path);   // <-- revisar log

            $pid = System::runInBackground(Env::get('PYTHON_BINARY') . " index.py $file", Env::get('ROBOT_PATH'), true);

            $res = Response::getInstance();

            $res->sendJson([
                "message"  => "Orden puesta para ejecucion",                
                "order"    => $order,
                "filename" => $file,
                "PID"      => $pid
            ]);

        } catch (\Exception $e){
            $res->error($e->getMessage());
        }
    }   

    /*
        Retorna status del robot
    */
    function status(){
        try {
            $res = Response::getInstance();

            $this->setupConnection();

            $rows = table('robot_execution')
            ->orderBy(['id' => 'DESC'])
            ->getOne();
           
            $res->sendJson($rows);

        } catch (\Exception $e){
            $res->error($e->getMessage());
        }
    }    

    function screenshots($filename){
        try {
            $res = Response::getInstance();

            $path = $this->robot_path . "/screenshots/$filename";

            if (!file_exists($path)){
                http_response_code(404);
                $res->error('File not found', 404);
            }
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($path).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            readfile($path);
            exit;

        } catch (\Exception $e){
            $res->error($e->getMessage());
        }
    }

    
}

