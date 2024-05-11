<?php declare(strict_types=1);

namespace boctulus\LongCookies\core\libs;

use boctulus\LongCookies\core\libs\Validator;
use boctulus\LongCookies\core\libs\Request;


/*
	Usar el Container de dependencias en vez de seguir creando factories !
*/

class Factory {
	static function response($data = null, ?int $http_code = 200) : Response {
		$ret = Response::getInstance();

		if ($data != null){
			$ret->send($data, $http_code);
		}

		return $ret;
	}

	static function request() : Request {
		return Request::getInstance();
	}

	static function validador() : Validator {
		static $instance;

		if ($instance == null){
			$instance = new Validator();
		}

        return $instance;
	}
}
