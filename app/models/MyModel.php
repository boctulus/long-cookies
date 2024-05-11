<?php

namespace boctulus\LongCookies\models;

use boctulus\LongCookies\core\libs\DB;
use boctulus\LongCookies\core\libs\Model;

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