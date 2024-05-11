<?php

use boctulus\LongCookies\core\interfaces\IMigration;
use boctulus\LongCookies\core\libs\Factory;
use boctulus\LongCookies\core\libs\Schema;
use boctulus\LongCookies\core\Model;
use boctulus\LongCookies\core\libs\DB;

class StarRating implements IMigration
{
    /**
	* Run migration.
    *
    * @return void
    */
    public function up()
    {
        $sc = new Schema('star_rating');

        $sc
        ->integer('id')->auto()->pri()
        ->text('comment')->nullable()
        ->int('score')
        ->varchar('author')
        ->datetime('deleted_at')
        ->datetime('created_at');

		$sc->create();
    }

    /**
	* Run undo migration.
    *
    * @return void
    */
    public function down()
    {
        $sc = new Schema('star_rating');
        $sc->dropTableIfExists();
    }
}

