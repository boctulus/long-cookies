<?php

namespace boctulus\TolScraper\controllers;

use boctulus\TolScraper\core\libs\DB;
use boctulus\TolScraper\core\libs\Users;
use boctulus\TolScraper\core\libs\Strings;
use boctulus\TolScraper\controllers\MyController;
use boctulus\TolScraper\libs\TutorLMSWooSubsAutomation;

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

