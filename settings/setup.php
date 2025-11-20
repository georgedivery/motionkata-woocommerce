<?php

function webbeb_setup()
{
    $defaults = array();
    add_theme_support('custom-logo', $defaults);
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    
    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'webbeb_setup');

include('options-page.php');
