<?php

namespace boctulus\LongCookies\background\tasks;

use boctulus\LongCookies\core\libs\Task;

class __NAME__ extends Task
{ 
    static protected $priority = 10;
    static protected $exec_time_limit;
    static protected $memory_limit;
    static protected $dontOverlap = false;

	function run(string $name, int $age){
		// your logic here
	}
}
