<?php

namespace boctulus\LongCookies\controllers;

use boctulus\LongCookies\core\libs\Coupons;
use boctulus\LongCookies\core\libs\Posts;
use boctulus\LongCookies\core\libs\Users;

class CouponsController
{
    function __construct()
    {   
        Users::restrictAccess();
    }

    function index(){
        dd('Hi Admin!'); 
    }

   /*
        Ultimos cupones creados?
    */
    function last()
    {   
        $last_coupons = Posts::getLastNPost('*', 'shop_coupon', null, 2, null, true);

        foreach ($last_coupons as $c){
            $code = $c['post_title'];
            $date = $c['post_date'];	
            $mail = unserialize($c['meta']['customer_email'][0])[0];

            dd([
                'code' => $code,
                'mail' => $mail
            ], "Creation time: $date");
        }
    }

}