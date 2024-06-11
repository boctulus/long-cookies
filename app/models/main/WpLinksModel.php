<?php

namespace boctulus\LongCookies\models\main;

use boctulus\LongCookies\models\MyModel;
use boctulus\LongCookies\schemas\main\WpLinksSchema;

class WpLinksModel extends MyModel
{
	protected $hidden       = [];
	protected $not_fillable = [];

	protected $field_names  = [];
	protected $formatters    = [];

    function __construct(bool $connect = false){
        parent::__construct($connect, WpLinksSchema::class);
	}	
}

