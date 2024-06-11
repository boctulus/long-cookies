<?php

namespace boctulus\LongCookies\core\libs;

use boctulus\LongCookies\core\Constants;
use boctulus\LongCookies\core\libs\Strings;

class CookieJar
{
    protected $cookieFile;

    public function __construct(string $cookieFile = 'cookies.txt')
    {
        $this->cookieFile = Constants::ETC_PATH . $cookieFile;
    }

    public function getCookies()
    {
        return file_exists($this->cookieFile) ? file_get_contents($this->cookieFile) : '';
    }

    public function saveCookies($cookies)
    {
        file_put_contents($this->cookieFile, $cookies);
    }

    public function getCookieFile() {
        return $this->cookieFile;
    }
}
