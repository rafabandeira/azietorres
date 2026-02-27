<?php
/**
 * Theme Setup
 */
if (!function_exists('azietorres_setup')):
    function azietorres_setup()
    {
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
    }
endif;
add_action('after_setup_theme', 'azietorres_setup');

/**
 * Remove Unnecessary Menus
 */
function remove_menus()
{
    remove_menu_page('edit-comments.php');
    remove_menu_page('edit.php?post_type=page');
    if (!current_user_can('administrator')) {
        remove_menu_page('tools.php');
    }
}
add_action('admin_menu', 'remove_menus');

/**
 * Remove Dashboard Widgets
 */
function remove_dashboard_widgets()
{
    remove_meta_box('dashboard_activity', 'dashboard', 'side');
    remove_meta_box('dashboard_right_now', 'dashboard', 'side');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'side');
    remove_meta_box('dashboard_plugins', 'dashboard', 'side');
    remove_meta_box('dashboard_site_health', 'dashboard', 'side');
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

/**
 * Custom Post URL structure
 */
function adicionar_base_artigos_para_posts($post_link, $post)
{
    if (is_object($post) && $post->post_type == 'post') {
        return home_url('/artigos/' . $post->post_name . '/');
    }
    return $post_link;
}
add_filter('post_link', 'adicionar_base_artigos_para_posts', 10, 2);

function adicionar_rewrite_rule_artigos()
{
    add_rewrite_rule('^artigos/([^/]+)/?$', 'index.php?post_type=post&name=$matches[1]', 'top');
}
add_action('init', 'adicionar_rewrite_rule_artigos');

/**
 * Change Post menu label
 */
function change_post_menu_label()
{
    global $menu, $submenu;
    $menu[5][0] = 'Artigos';
    $submenu['edit.php'][5][0] = 'Artigos';
    $menu[5][6] = 'dashicons-format-quote';
}
add_action('admin_menu', 'change_post_menu_label');
