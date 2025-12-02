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
    wp_enqueue_style('stylewoo', get_stylesheet_directory_uri() . '/assets/css/style-woo.css');
    wp_enqueue_script('slickjs', get_stylesheet_directory_uri() . '/assets/js/vendor/slick/slick.js', ['jquery'], null, true);
    wp_enqueue_script('functions', get_stylesheet_directory_uri() . '/assets/js/functions.js', ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', 'webbeb_scripts');
 

// Create custom post type "Campaigns"
// Example
// $campaigns = new CustomPostType('Campaigns', 'Campaign', 'campaigns', ['category']);

 

add_filter( 'woocommerce_checkout_fields', function( $fields ) {

    // махаме ненужните полета
    unset( $fields['billing']['billing_address_2'] );
    unset( $fields['billing']['billing_postcode'] );

    // правим телефон и имейл задължителни (ако искаш)
    $fields['billing']['billing_phone']['required'] = true;
    $fields['billing']['billing_email']['required'] = true;

 

    // подреждане по priority:
    // 10  Име
    // 20  Фамилия
    // 30  Телефон
    // 40  Имейл
    // 50  Област
    // 60  Град
    // 70  Адрес
    $fields['billing']['billing_first_name']['priority'] = 10;
    $fields['billing']['billing_last_name']['priority']  = 20;
    $fields['billing']['billing_phone']['priority']      = 30;
    $fields['billing']['billing_email']['priority']      = 40;
    $fields['billing']['billing_state']['priority']      = 50;
    $fields['billing']['billing_city']['priority']       = 60;
    $fields['billing']['billing_address_1']['priority']  = 70;

    return $fields;
}, 9999 );

// Remove default WooCommerce coupon form from checkout
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

// Remove default terms and conditions from all default locations
remove_action( 'woocommerce_checkout_before_order_review', 'woocommerce_checkout_terms_and_conditions', 10 );
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_terms_and_conditions', 10 );
remove_action( 'woocommerce_checkout_after_order_review', 'woocommerce_checkout_terms_and_conditions', 10 );

add_action( 'wp_footer', function() {
    if ( ! is_checkout() ) {
        return;
    }
    ?>
    <script>
    jQuery(function($) {
        function changeBillingAddressLabel() {
          
            $('#billing_address_1').attr(
                'placeholder',
                "Генерира се автоматично от доставката"
            );
        }

        changeBillingAddressLabel();
        $(document.body).on('updated_checkout', changeBillingAddressLabel);
    });
    </script>
    <?php
} );
