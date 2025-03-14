<?php
/*
Plugin Name: KISS WP Batch Plugin Installer
Description: A plugin to batch install plugins from GitHub.
Version: 1.0
Author: Your Name
*/

// This plugin can use a config file stored in the same folder as the plugin.
// Example config data structure stored in wpbatchinstaller-config.json:
// {
//   "KISS Maintenance Mode": "https://github.com/kissplugins/KISS-maintenance-mode/archive/refs/heads/main.zip",
//   "KISS FAQs with Google Schema": "https://github.com/kissplugins/KISS-faqs/archive/refs/heads/main.zip",
//   "KISS Last Post Update Timestamp": "https://github.com/kissplugins/kiss-post-last-update-date/archive/refs/heads/main.zip"
// }

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function wp_batch_installer_menu_page() {
    add_menu_page(
        __('KISS WP Batch Plugin Installer', 'wp-batch-installer'),
        __('KISS WP Batch Plugin Installer', 'wp-batch-installer'),
        'manage_options',
        'wp-batch-installer',
        'wp_batch_installer_configuration_page'
    );
}
add_action('admin_menu', 'wp_batch_installer_menu_page');

function wp_batch_installer_configuration_page(){
    if(!current_user_can('manage_options')){
        return;
    }

    // Read the config file from this plugin directory.
    $config_file = plugin_dir_path(__FILE__) . 'wpbatchinstaller-config.json';

    if(!file_exists($config_file) || !is_readable($config_file)){
        echo '<div class="notice notice-error"><p>Config file not found or not readable at: '.esc_html($config_file).'</p></div>';
        return;
    }

    $json_data = file_get_contents($config_file);
    if(!$json_data){
        echo '<div class="notice notice-error"><p>Could not read config file.</p></div>';
        return;
    }

    $plugin_data = json_decode($json_data, true);
    if(!is_array($plugin_data)){
        echo '<div class="notice notice-error"><p>Config file does not contain valid JSON plugin data.</p></div>';
        return;
    }

    if(isset($_POST['wp_batch_installer_install_plugins']) && check_admin_referer('wp_batch_installer_nonce', 'wp_batch_installer_nonce_field')){
        $selected_plugins = isset($_POST['selected_plugins']) && is_array($_POST['selected_plugins']) ? $_POST['selected_plugins'] : [];

        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/misc.php';

        foreach($selected_plugins as $plugin_name){
            if(isset($plugin_data[$plugin_name])){
                $zip_url = $plugin_data[$plugin_name];

                $upgrader = new Plugin_Upgrader();
                $result = $upgrader->install($zip_url);

                if(is_wp_error($result)){
                    echo '<div class="notice notice-error"><p>Error installing '.esc_html($plugin_name).'</p></div>';
                } else {
                    echo '<div class="notice notice-success"><p>Successfully installed '.esc_html($plugin_name).'</p></div>';
                }
            }
        }
    }

    echo '<div class="wrap">';
    echo '<h1>'.esc_html__('KISS WP Batch Plugin Installer', 'wp-batch-installer').'</h1>';

    echo '<form method="post" action="">';
    wp_nonce_field('wp_batch_installer_nonce', 'wp_batch_installer_nonce_field');

    echo '<table class="form-table">';
    echo '<thead><tr><th>'.esc_html__('Select', 'wp-batch-installer').'</th><th>'.esc_html__('Plugin Name', 'wp-batch-installer').'</th><th>'.esc_html__('Download URL', 'wp-batch-installer').'</th></tr></thead>';
    echo '<tbody>';

    foreach($plugin_data as $plugin_name => $zip_url){
        $field_id = sanitize_title($plugin_name);
        echo '<tr>';
        echo '<td><input type="checkbox" name="selected_plugins[]" value="'.esc_attr($plugin_name).'" id="'.esc_attr($field_id).'" checked></td>';
        echo '<td><label for="'.esc_attr($field_id).'">'.esc_html($plugin_name).'</label></td>';
        echo '<td><a href="'.esc_url($zip_url).'" target="_blank" rel="noopener">'.esc_html($zip_url).'</a></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';

    echo '<p><input type="submit" name="wp_batch_installer_install_plugins" class="button button-primary" value="Install selected plugins"></p>';

    echo '</form>';
    echo '</div>';
}
