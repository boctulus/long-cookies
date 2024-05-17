<?php

namespace boctulus\TolScraper\models;

use boctulus\TolScraper\core\libs\DB;
use boctulus\TolScraper\core\libs\Model;

class MyModel extends Model {
    function wp(){
		global $wpdb;
		return $this->prefix($wpdb->prefix);
	}

    protected function boot(){
        if (empty($this->prefix) && DB::isDefaultOrNoConnection()){
			$this->wp();
		}       
    }

    protected function init(){		
		
	}
}