<?php
/**
 * Hide editor on specific pages.
 *   - Use $remove_editor_from_titles array to remove editor from pages with specific title
 *     Example: $remove_editor_from_titles = ['Homepage', 'Home'];
 *   - Use $templates array to add specific templates.
 */
function webbeb_hide_editor($arg)
{
    $target_template = 'theme-template.php';

    // Get the Post ID.
    $post_id = null;

    if (isset($_GET['post'])) {
        $post_id = absint($_GET['post']);
    } elseif (isset($_POST['post_ID'])) {
        $post_id = absint($_POST['post_ID']);
    }

    if (!$post_id) {
        return;
    }

    // Hide the editor when specific page template is selected.
    $template_file = get_post_meta($post_id, '_wp_page_template', true);
    if ($template_file === $target_template) {
        remove_post_type_support('page', 'editor');
    }
}

add_action('admin_init', 'webbeb_hide_editor');
