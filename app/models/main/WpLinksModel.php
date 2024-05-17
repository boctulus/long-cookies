<?php

namespace boctulus\TolScraper\models\main;

use boctulus\TolScraper\models\MyModel;
use boctulus\TolScraper\schemas\main\WpLinksSchema;

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

