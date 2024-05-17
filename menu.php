<?php

// ....


// Enqueue de CSS
add_action('admin_enqueue_scripts', 'tol_scraper_enqueue_styles');
function tol_scraper_enqueue_styles() {
    // Obtener el slug de la página actual
    $current_page      = get_current_screen();
    $current_page_slug = $current_page->id;
    
    css_file('css/styles.css');

    // Bootstrap
    css_file('/third_party/bootstrap/5.x/bootstrap.min.css', false, null, null, 'css-bt5');
    js_file( '/third_party/bootstrap/5.x/bootstrap.bundle.min.js', false, ['jquery-core'], null, 'js-bt5'); 

}