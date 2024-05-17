<?php

namespace boctulus\TolScraper\core\interfaces;

interface IValidator {
    function validate(array $data, array $rules, $fillables = null);
    function getErrors() : array;
}