<?php

namespace boctulus\LongCookies\middlewares;

use boctulus\LongCookies\core\Middleware;
use boctulus\LongCookies\core\libs\DB;
use boctulus\LongCookies\core\libs\Strings;

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