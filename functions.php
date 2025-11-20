<?php

/**
 * Setup the theme and theme settings such as sync ACF fields.
 */
require_once('vendor/class-tgm-plugin-activation.php');
require_once('settings/register-required-plugins.php');
require_once('settings/setup.php');
require_once('settings/theme-panel.php');
require_once('settings/hide-editor.php');
require_once('helpers/CustomPostType.php');

function webbeb_scripts()
{
    wp_enqueue_style('slickstyle', get_stylesheet_directory_uri() . '/assets/js/vendor/slick/slick.css');
    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/assets/css/style.css');
    wp_enqueue_script('slickjs', get_stylesheet_directory_uri() . '/assets/js/vendor/slick/slick.js', ['jquery'], null, true);
    wp_enqueue_script('functions', get_stylesheet_directory_uri() . '/assets/js/functions.js', ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', 'webbeb_scripts');

// Create custom post type "Campaigns"
// Example
// $campaigns = new CustomPostType('Campaigns', 'Campaign', 'campaigns', ['category']);
