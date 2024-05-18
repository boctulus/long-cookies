<?php

/*
    Routes for Router

    Nota: la ruta mas general debe colocarse al final
*/

return [
    // rutas 

    'POST:/robot/order'      => 'boctulus\TolScraper\controllers\RobotController@order',
    'GET:/robot/screenshots' => 'boctulus\TolScraper\controllers\RobotController@screenshots',
    'GET:/robot/status'      => 'boctulus\TolScraper\controllers\RobotController@status',
];
