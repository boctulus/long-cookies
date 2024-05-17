<?php

/*
    Routes for Router

    Nota: la ruta mas general debe colocarse al final
*/

return [
    // rutas 

    'GET:/tutor/courses' => 'boctulus\TolScraper\controllers\TutorController@courses',
    '/tutor/enrollment'  => 'boctulus\TolScraper\controllers\TutorController@enrollment',

    '/tutor/cronjob'     => 'boctulus\TolScraper\controllers\CronjobController'
];
