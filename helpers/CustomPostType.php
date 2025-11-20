<?php
/**
 * Custom class to create new post types.
 */
class CustomPostType
{
    private $settings;

    /**
     * 
     */
    public function __construct($name, $singular_name, $slug, $taxonomies = [])
    {
        $this->settings = [
            'name' => $name,
            'singular_name' => $singular_name,
            'slug' => $slug,
            'taxonomies' => $taxonomies,
        ];

        add_action('init', [&$this, 'add_custom_post_type']);
    }

    public function add_custom_post_type()
    {
        $labels = [
            'name'                  => _x($this->settings['name'], 'Post Type General Name', 'webbeb'),
            'singular_name'         => _x($this->settings['singular_name'], 'Post Type Singular Name', 'webbeb'),
            'menu_name'             => __($this->settings['name'], 'webbeb'),
            'name_admin_bar'        => __('Post Type', 'webbeb'),
            'archives'              => __('Item Archives', 'webbeb'),
            'attributes'            => __('Item Attributes', 'webbeb'),
            'parent_item_colon'     => __('Parent Item:', 'webbeb'),
            'all_items'             => __('All ' . $this->settings['name'], 'webbeb'),
            'add_new_item'          => __('Add New Item', 'webbeb'),
            'add_new'               => __('Add New', 'webbeb'),
            'new_item'              => __('New Item', 'webbeb'),
            'edit_item'             => __('Edit Item', 'webbeb'),
            'update_item'           => __('Update Item', 'webbeb'),
            'view_item'             => __('View Item', 'webbeb'),
            'view_items'            => __('View Items', 'webbeb'),
            'search_items'          => __('Search Item', 'webbeb'),
            'not_found'             => __('Not found', 'webbeb'),
            'not_found_in_trash'    => __('Not found in Trash', 'webbeb'),
            'featured_image'        => __('Featured Image', 'webbeb'),
            'set_featured_image'    => __('Set featured image', 'webbeb'),
            'remove_featured_image' => __('Remove featured image', 'webbeb'),
            'use_featured_image'    => __('Use as featured image', 'webbeb'),
            'insert_into_item'      => __('Insert into item', 'webbeb'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'webbeb'),
            'items_list'            => __('Items list', 'webbeb'),
            'items_list_navigation' => __('Items list navigation', 'webbeb'),
            'filter_items_list'     => __('Filter items list', 'webbeb'),
        ];

        $args = array(
            'label'                 => __($this->settings['name'], 'webbeb'),
            'description'           => __($this->settings['name'], 'webbeb'),
            'labels'                => $labels,
            'supports'              => array( 'title',  'thumbnail' ),
            'hierarchical'          => false,
            'taxonomies' 	      	=> $this->settings['taxonomies'],
            'public'                => true,
            'show_ui'               => true,
            'show_in_rest'          => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
        );
        register_post_type($this->settings['slug'], $args);
    }
}
