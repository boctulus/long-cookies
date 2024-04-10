<?php

/*
	Plugin Name: Loooong cookies
	Description: Makes cookies longer
	Version: 1.0.0
	Author: Pablo Bozzolo < boctulus@gmail.com >

	Continuar:

	https://chat.openai.com/c/cd04c878-9489-41e5-9b63-6d454eff6c22
*/


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

require_once __DIR__ . '/app.php';

// if (!in_array(config()['is_enabled'] ?? 'on', [true, '1', 'on'])){
// 	return;
// }

require_once __DIR__ . '/main.php';