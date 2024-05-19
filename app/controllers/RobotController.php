<?php

namespace boctulus\TolScraper\controllers;

use boctulus\TolScraper\core\Constants;
use boctulus\TolScraper\core\libs\DB;
use boctulus\TolScraper\core\libs\Env;
use boctulus\TolScraper\core\libs\HTTP;
use boctulus\TolScraper\core\libs\Files;
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
            $res   = Response::getInstance();

            $raw   = file_get_contents("php://input");
            $order = json_decode($raw, true);

            $file  = 'order-' . ((string) time()) . '-' . ((string) rand(100,999)) . '.json';            
            $path  = $this->robot_path . "/instructions/$file";

            $bytes = file_put_contents($path, $raw);

            if (!$bytes){
                $len = strlen($raw);
                $res->error("Se ha producido un fallo al escribir el archivo. Se ha recibido $len bytes pero se escribieron 0 bytes. Path = '$path'", 500);
            }

            // Logger::dd($bytes, $path);   // <-- revisar log

            $file_path  = System::isWindows() ? Env::get('PYTHON_BINARY') : 'python3';
            $dir        = Env::get('ROBOT_PATH');
            $args       = "index.py load $file";

            // dd("$file_path $args", 'CMD');

            $pid = System::runInBackground($file_path, $dir, $args); // ok
            // dd($pid, 'PID');

            $data = [
                "message"  => "Orden puesta para ejecucion",                
                "order"    => $order,
                "filename" => $file,
                "PID"      => $pid,
            ];

            sleep(1);

            if (!System::isProcessAlive($pid)){
                $res->error("Orden ha fallado en ejecucion", 500, "La ejecucion se ha detenido antes del primer segundo");
            }

            $res->sendJson($data);

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

    function test_write(){
        dd("Intentando escribir log");
        Logger::log(__LINE__);
        dd(Logger::getContent(), "Log content");

        $dir = Constants::LOGS_PATH;
        dd(
            Files::isDirectoryWritable($dir), "Se puede escribir '$dir'?"
        );

        $dir = Env::get('ROBOT_PATH');
        dd(
            Files::isDirectoryWritable($dir), "Se puede escribir '$dir'?"
        );

        $dir = Files::normalize(Constants::WP_ROOT_PATH . '../');
        dd(
            Files::isDirectoryWritable($dir), "Se puede escribir '$dir'?"
        );
    }

    
}

