<?php

namespace boctulus\TolScraper\core\interfaces;

interface IMigration {

    /**
     * Run migration
     *
     * @return void
     */
    function up();

}