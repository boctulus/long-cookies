<?php

return [
    'include' => [
        // __DIR__ . '/../app/core/helpers', 
        __DIR__ . '/../app/helpers',
        // __DIR__ . '/../boot'

        __DIR__ . '/../app/core/helpers/system.php',
        __DIR__ . '/../app/core/helpers/env.php',
        __DIR__ . '/../app/core/helpers/credits.php',
        __DIR__ . '/../app/core/scripts/admin.php',
    ],

    'exclude' => [
        __DIR__ . '/../app/core/helpers/cli.php',
    ]
];