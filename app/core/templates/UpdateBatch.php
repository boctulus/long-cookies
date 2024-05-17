<?php

use boctulus\TolScraper\core\libs\Files;
use boctulus\TolScraper\core\libs\Strings;
use boctulus\TolScraper\core\interfaces\IUpdateBatch;
use boctulus\TolScraper\controllers\MigrationsController;

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