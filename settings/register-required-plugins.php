<?php
/**
 * Register the required or recommended plugins for the theme.
 *
 * Uses the TGMPA library bundled in `vendor/class-tgm-plugin-activation.php`.
 *
 * @return void
 */
function webbeb_register_required_plugins()
{
    $theme_text_domain = 'webbeb';

    $acf_pro_source = get_template_directory() . '/lib/plugins/advanced-custom-fields-pro.5.8.1.zip';

    $plugins = array(
        array(
            'name'               => 'Advanced Custom Fields PRO',
            'slug'               => 'advanced-custom-fields-pro',
            'source'             => $acf_pro_source,
            'required'           => true,
            'version'            => '5.8.1',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'     => 'ACF to REST API',
            'slug'     => 'acf-to-rest-api',
            'required' => true,
        ),
        array(
            'name'     => 'ACF Content Analysis for Yoast SEO',
            'slug'     => 'acf-content-analysis-for-yoast-seo',
            'required' => false,
        ),
        array(
            'name'     => 'Laravel DD for WordPress',
            'slug'     => 'laravel-dd',
            'required' => false,
        ),
        array(
            'name'     => 'Yoast SEO',
            'slug'     => 'wordpress-seo',
            'required' => false,
        ),
        array(
            'name'     => 'Disable Gutenberg',
            'slug'     => 'disable-gutenberg',
            'required' => false,
        ),
    );

    $config = array(
        'id'           => 'webbeb_required_plugins',
        'default_path' => '',
        'menu'         => 'webbeb-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'is_automatic' => false,
        'message'      => '',
        'strings'      => array(
            'page_title' => __('Install Required Plugins', $theme_text_domain),
            'menu_title' => __('Install Plugins', $theme_text_domain),
        ),
    );

    tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'webbeb_register_required_plugins');

