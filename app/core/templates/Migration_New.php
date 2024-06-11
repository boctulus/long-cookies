<?php

use boctulus\LongCookies\core\interfaces\IMigration;
use boctulus\LongCookies\core\libs\Factory;
use boctulus\LongCookies\core\libs\Schema;
use boctulus\LongCookies\core\Model;
use boctulus\LongCookies\core\libs\DB;

class __NAME__ implements IMigration
{
    protected $table = '__TB_NAME__';

    /**
	* Run migration.
    *
    * @return void
    */
    public function up()
    {
        $sc = new Schema($this->table);
		// ...
        $sc->create();
    }

    /**
	* Run undo migration.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}


