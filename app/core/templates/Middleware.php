<?php

namespace boctulus\TolScraper\middlewares;

use boctulus\TolScraper\core\Middleware;
use boctulus\TolScraper\core\libs\DB;
use boctulus\TolScraper\core\libs\Strings;

class __NAME__ extends Middleware
{   
    function __construct()
    {
        parent::__construct();
    }

    function handle(?callable $next = null){
        $res = $this->res->get();

        // ...

        $this->res->set($res);
    }
}