<?php

namespace boctulus\LongCookies\core\interfaces;

use boctulus\LongCookies\controllers\Controller;

interface ITransformer {
    function transform(object $user, Controller $controller = NULL);
}