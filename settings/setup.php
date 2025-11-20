<?php

function webbeb_setup()
{
    $defaults = array();
    add_theme_support('custom-logo', $defaults);
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'webbeb_setup');

include('options-page.php');
