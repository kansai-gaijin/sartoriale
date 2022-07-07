<?php

namespace Tonik\Theme\App\Structure;

use function Tonik\Theme\App\template;

add_shortcode('home_hero', 'Tonik\Theme\App\Structure\render_home_hero');
add_shortcode('home_concept', 'Tonik\Theme\App\Structure\render_home_concept');
add_shortcode('home_links', 'Tonik\Theme\App\Structure\render_home_links');
add_shortcode('home_instagram', 'Tonik\Theme\App\Structure\render_home_instagram');
add_shortcode('home_news', 'Tonik\Theme\App\Structure\render_home_news');
add_shortcode('home_access', 'Tonik\Theme\App\Structure\render_home_access');

function render_home_hero()
{
    ob_start();
    template('sections/home/home_hero');
    return ob_get_clean();
}
function render_home_concept()
{
    ob_start();
    template('sections/home/home_concept');
    return ob_get_clean();
}
function render_home_links()
{
    ob_start();
    template('sections/home/home_links');
    return ob_get_clean();
}
function render_home_instagram()
{
    ob_start();
    template('sections/home/home_instagram');
    return ob_get_clean();
}
function render_home_news()
{
    ob_start();
    template('sections/home/home_news');
    return ob_get_clean();
}
function render_home_access()
{
    ob_start();
    template('sections/home/home_access');
    return ob_get_clean();
}