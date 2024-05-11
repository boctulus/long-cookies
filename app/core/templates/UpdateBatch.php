<?php

use boctulus\LongCookies\core\libs\Files;
use boctulus\LongCookies\core\libs\Strings;
use boctulus\LongCookies\core\interfaces\IUpdateBatch;
use boctulus\LongCookies\controllers\MigrationsController;

/*
    Run batches
*/

class __NAME__ implements IUpdateBatch
{
    function run() : ?bool{
        // ...
        
        return true;
    }
}