<?php declare(strict_types=1);

namespace boctulus\TolScraper\core\libs;

use boctulus\TolScraper\core\libs\Files;
use boctulus\TolScraper\core\libs\Strings;

/*
    WordPress metadata parser

    De momento sin uso y sin testear
*/
class MetadataParser
{   
    static function getMetadata(string $path){
        $path = Files::convertSlashes($path);
        
        if (Strings::contains( DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR,  $path)){
            return Plugins::getMeta($path);
        } else {
            return Templates::getMeta($path);
        }
    }
}

