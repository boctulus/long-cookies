<?php declare(strict_types=1);

namespace boctulus\LongCookies\core\traits;

use boctulus\LongCookies\core\libs\Config;
use boctulus\LongCookies\core\libs\DB;
use boctulus\LongCookies\core\libs\Logger;

trait ExceptionHandler
{
    /**
     * exception_handler
     *
     * @param  mixed $e
     *
     * @return void
     */
    function exception_handler($e) {
        $current_conn = DB::getCurrentConnectionId();
        DB::closeAllConnections();

        $error_msg = $e->getMessage();

        $config    = Config::get();
       
        if ($config['debug']){
            $e      = new \Exception();
            $traces = $e->getTrace();

            foreach ($traces as $tx => $trace){
                $args = $exception = $trace['args'] ?? null;

                if (empty($args)){
                    continue;
                }

                foreach ($args as $ax => $arg){
                    $exception = $traces[$tx]['args'][$ax];

                    $trace = $exception->getTraceAsString();
                    $trace = explode("\n", $trace);

                    $traces[$tx]['args'][$ax] = [
                        'message' => $exception->getMessage(),
                        'prev'    => $exception->getPrevious(),
                        'code'    => $exception->getCode(),
                        'file'    => $exception->getFile(),
                        'line'    => $exception->getLine(),
                        'trace'   => $trace,
                        'extra'   => [
                            'db_connection' => $current_conn
                        ]
                    ];
                }
            }

            $backtrace      = json_encode($traces, JSON_PRETTY_PRINT) . PHP_EOL . PHP_EOL;
            $error_location = 'Error on line number '.$e->getLine().' in file - '.$e->getFile();

            if ($config['log_stack_trace']){
                Logger::logError("Error: $error_msg. Trace: $backtrace");   
            } else{
                Logger::logError("Error: $error_msg");
            }

            error($error_msg, 500, $backtrace);
        } else {
            error($error_msg, 500);
        }
        
    }
    
}
    