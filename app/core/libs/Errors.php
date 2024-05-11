<?php

namespace boctulus\LongCookies\core\libs;

use boctulus\LongCookies\core\traits\ExceptionHandler;

class Errors
{	
	function __construct()
	{
		set_exception_handler(function(\Throwable $exception) {
			echo "ERROR: " , $exception->getMessage(), "\n";
			exit;
		});
	}
}