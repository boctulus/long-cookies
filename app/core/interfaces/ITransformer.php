<?php

namespace boctulus\TolScraper\core\interfaces;

use boctulus\TolScraper\controllers\Controller;

interface ITransformer {
    function transform(object $user, Controller $controller = NULL);
}