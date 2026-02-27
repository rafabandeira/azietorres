<?php
/**
 * Open Graph Meta Info
 */
function add_opengraph_doctype($output)
{
    return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');

function insert_fb_in_head()
{
    global $post;
    if (!is_singular())
        return;

    echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '"/>';
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '"/>';

    if (!has_post_thumbnail($post->ID)) {
        $default_image = get_template_directory_uri() . "/assets/img/logo.png";
        echo '<meta property="og:image" content="' . esc_url($default_image) . '"/>';
    } else {
        $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
        echo '<meta property="og:image" content="' . esc_url($thumbnail_src[0]) . '"/>';
    }
}
add_action('wp_head', 'insert_fb_in_head', 5);
