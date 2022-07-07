<?php

namespace Tonik\Theme\App\Structure;

/*
|-----------------------------------------------------------
| Theme Templates Actions
|-----------------------------------------------------------
|
| This file purpose is to include your templates rendering
| actions hooks, which allows you to render specific
| partials at specific places of your theme.
|
*/

use function Tonik\Theme\App\template;

function render_empty_content()
{
  template(['partials/index/content', 'none']);
}
add_action('theme/index/content/none', 'Tonik\Theme\App\Structure\render_empty_content');

function render_page_content()
{
  template('partials/page/content');
}
add_action('theme/page/content', 'Tonik\Theme\App\Structure\render_page_content');

function render_header()
{
  template('partials/header');
}
add_action('theme/header', 'Tonik\Theme\App\Structure\render_header');

function render_footer()
{
  template('partials/footer');
}
add_action('theme/footer', 'Tonik\Theme\App\Structure\render_footer');