<?php
/**
 * Personal Server Update Checker
 */
delete_site_transient('update_themes');
function update_checker($transient)
{
    if (empty($transient->checked))
        return $transient;
    $remote_json = 'https://raw.githubusercontent.com/rafabandeira/azietorres/refs/heads/main/azietorres.json';
    $response = wp_remote_get($remote_json, array('timeout' => 10));
    if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response))
        return $transient;
    $remote_data = json_decode(wp_remote_retrieve_body($response));
    if (!$remote_data || !isset($remote_data->version))
        return $transient;

    $theme_slug = get_template();
    $current_version = wp_get_theme($theme_slug)->get('Version');
    if (version_compare($current_version, $remote_data->version, '<')) {
        $transient->response[$theme_slug] = array(
            'theme' => $theme_slug,
            'new_version' => $remote_data->version,
            'details_url' => esc_url($remote_data->details_url),
            'package' => esc_url($remote_data->download_url),
        );
    }
    return $transient;
}
add_filter('pre_set_site_transient_update_themes', 'update_checker');

function update_checker_multisite_network()
{
    if (is_multisite()) {
        foreach (get_sites() as $site) {
            switch_to_blog($site->blog_id);
            set_site_transient('update_themes', update_checker(get_site_transient('update_themes')));
            restore_current_blog();
        }
    }
}
add_action('admin_init', 'update_checker_multisite_network');
