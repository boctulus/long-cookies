<?php

/*
    Routes for Router

    Nota: la ruta mas general debe colocarse al final
*/

return [
    // rutas 

    'GET:/tutor/courses' => 'boctulus\LongCookies\controllers\TutorController@courses',
    '/tutor/enrollment'  => 'boctulus\LongCookies\controllers\TutorController@enrollment',

    '/tutor/cronjob'     => 'boctulus\LongCookies\controllers\CronjobController'
];
