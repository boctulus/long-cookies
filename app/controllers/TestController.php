<?php

namespace boctulus\LongCookies\controllers;

use boctulus\LongCookies\core\libs\Posts;

class TestController
{
    function __construct()
    {   
        // Restringe acceso a admin
        // Users::restrictAccess();
    }   

    function index(){
        dd(Posts::getPostTypes(), 'Post Types');
    }

    #21069
    function get_post_type(){
        $pid = $_GET['pid'] ?? 21069;

        dd(
            Posts::getPostType($pid), "Post Type para pid=$pid"
        );
        
    }
   
}
