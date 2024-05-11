<?php

namespace boctulus\LongCookies\controllers;

use boctulus\LongCookies\core\libs\DB;
use boctulus\LongCookies\core\libs\Users;
use boctulus\LongCookies\core\libs\Strings;
use boctulus\LongCookies\controllers\MyController;
use boctulus\LongCookies\libs\TutorLMSWooSubsAutomation;

class CronjobController
{
    function index()
    {
        $uids = Users::getUserIDList();

        foreach ($uids as $uid){
            dd("Automatizando por user_id=$uid");
            TutorLMSWooSubsAutomation::run($uid);
        }             
    }
}

