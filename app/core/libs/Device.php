<?php 

namespace boctulus\LongCookies\core\libs;

class Device
{
    /*
        Screen
    */

    static function isMobile(){
        return wp_is_mobile();
    }
}