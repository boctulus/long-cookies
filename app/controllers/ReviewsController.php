<?php

namespace boctulus\TolScraper\controllers;

use boctulus\TolScraper\shortcodes\star_rating\StarRatingShortcode;

class ReviewsController
{
    function rating_slider(){        
        set_template('templates/tpl_basic.php');  

        $sc = new StarRatingShortcode();

        render($sc->rating_slider());
    }

    /*
        Test de shortcode
    */
    function rating_table()
    {
        set_template('templates/tpl_basic.php');  

        $sc = new StarRatingShortcode();

        render($sc->rating_table());
    }
}

