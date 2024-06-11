<?php

namespace boctulus\LongCookies\core\interfaces;

interface IMigration {

    /**
     * Run migration
     *
     * @return void
     */
    function up();

}