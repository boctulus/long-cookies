<?php

namespace boctulus\TolScraper\core\libs;

use boctulus\TolScraper\core\traits\ExceptionHandler;

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