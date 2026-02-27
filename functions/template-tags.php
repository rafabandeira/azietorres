<?php
/**
 * Custom Template Tags and Helpers
 */

function custom_excerpt($charlength)
{
    $excerpt = get_the_excerpt();
    $charlength++;
    if (mb_strlen($excerpt) > $charlength) {
        $subex = mb_substr($excerpt, 0, $charlength - 5);
        $exwords = explode(' ', $subex);
        $excut = -(mb_strlen($exwords[count($exwords) - 1]));
        echo ($excut < 0) ? mb_substr($subex, 0, $excut) : $subex;
        echo '...';
    } else {
        echo $excerpt;
    }
}

function my_custom_pagination($query = null)
{
    if ($query === null) {
        global $wp_query;
        $query = $wp_query;
    }
    $big = 999999999;
    $pagination = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $query->max_num_pages,
        'prev_text' => '<i class="bi bi-arrow-left"></i>',
        'next_text' => '<i class="bi bi-arrow-right"></i>',
        'type' => 'list',
    ));
    if ($pagination) {
        echo '<div class="pagination-wrapper">' . $pagination . '</div>';
    }
}

function navegacao_post()
{
    echo '<div class="post-navigation">';
    the_post_navigation(array(
        'screen_reader_text' => ' ',
        'prev_text' => '<i class="bi bi-arrow-left"></i>',
        'next_text' => '<i class="bi bi-arrow-right"></i>',
    ));
    echo '</div>';
}

function tem_artigos_posts()
{
    static $artigos_posts = null;
    if ($artigos_posts === null) {
        $posts = get_posts(array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 1, 'fields' => 'ids'));
        $artigos_posts = !empty($posts);
    }
    return $artigos_posts;
}

function tem_area_atuacao_posts()
{
    static $has_posts = null;
    if ($has_posts === null) {
        $posts = get_posts(array('post_type' => 'area_atuacao', 'post_status' => 'publish', 'posts_per_page' => 1, 'fields' => 'ids'));
        $has_posts = !empty($posts);
    }
    return $has_posts;
}

function tem_advogado_posts()
{
    static $advogado_posts = null;
    if ($advogado_posts === null) {
        $posts = get_posts(array('post_type' => 'advogado', 'post_status' => 'publish', 'posts_per_page' => 1, 'fields' => 'ids'));
        $advogado_posts = !empty($posts);
    }
    return $advogado_posts;
}

function my_theme_display_social_media()
{
    $options = get_option('my_social_media_options');
    if (empty($options))
        return;
    echo '<div class="social-links mt-3">';
    foreach (array('x' => 'twitter', 'facebook' => 'facebook', 'instagram' => 'instagram', 'linkedin' => 'linkedin') as $slug => $icon) {
        if (!empty($options[$slug])) {
            echo '<a href="' . esc_url($options[$slug]) . '" target="_blank" rel="noopener noreferrer"><i class="bx bxl-' . $icon . '"></i></a>';
        }
    }
    echo '</div>';
}
