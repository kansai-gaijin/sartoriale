<?php

namespace Tonik\Theme\Page;

$account = wc_get_page_permalink( 'myaccount' );

if ( is_user_logged_in() ) {
    wp_redirect($account);
    exit;
}

/*
|------------------------------------------------------------------
| Page Controller
|------------------------------------------------------------------
|
| Think about theme template files as some sort of controllers
| from MVC design pattern. They should link application
| logic with your theme view templates files.
|
*/

use function Tonik\Theme\App\template;

/**
 * Renders single page.
 *
 * @see resources/templates/single.tpl.php
 */
template('page');