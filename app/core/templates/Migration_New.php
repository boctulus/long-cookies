<?php

use boctulus\TolScraper\core\interfaces\IMigration;
use boctulus\TolScraper\core\libs\Factory;
use boctulus\TolScraper\core\libs\Schema;
use boctulus\TolScraper\core\Model;
use boctulus\TolScraper\core\libs\DB;

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


