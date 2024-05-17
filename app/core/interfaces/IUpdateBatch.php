<?php

namespace boctulus\TolScraper\core\interfaces;

interface IUpdateBatch {

    /**
     * Run migration
     *
     * @return void
     */
    function run() : ?bool;
}