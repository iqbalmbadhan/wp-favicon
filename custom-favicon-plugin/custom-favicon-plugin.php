<?php
/*
Plugin Name: Custom Favicon Plugin
Plugin URI: https://iqbalmahmud.com
Description: A plugin to add a custom favicon via the WordPress admin dashboard.
Version: 1.0
Author: Iqbal Mahmud
Author URI: https://iqbalmahmud.com
License: GPL2
*/

// Add settings menu
function myplugin_add_menu() {
    add_options_page(
        'Custom Favicon Settings',
        'Custom Favicon',
        'manage_options',
        'custom-favicon',
        'myplugin_settings_page'
    );
}
add_action('admin_menu', 'myplugin_add_menu');

// Settings page HTML
function myplugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>Custom Favicon Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('myplugin_settings_group');
            do_settings_sections('custom-favicon');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings
function myplugin_register_settings() {
    register_setting('myplugin_settings_group', 'myplugin_favicon_id', 'intval');
    register_setting('myplugin_settings_group', 'myplugin_apple_touch_icon_id', 'intval');

    add_settings_section(
        'myplugin_settings_section',
        'Favicon Settings',
        null,
        'custom-favicon'
    );

    add_settings_field(
        'myplugin_favicon_id',
        'Favicon',
        'myplugin_favicon_html',
        'custom-favicon',
        'myplugin_settings_section'
    );

    add_settings_field(
        'myplugin_apple_touch_icon_id',
        'Apple Touch Icon',
        'myplugin_apple_touch_icon_html',
        'custom-favicon',
        'myplugin_settings_section'
    );
}
add_action('admin_init', 'myplugin_register_settings');

// HTML for the favicon input field
function myplugin_favicon_html() {
    $value = get_option('myplugin_favicon_id', '');
    $image = wp_get_attachment_image_src($value, 'thumbnail');
    $image_url = $image ? $image[0] : '';
    echo '<input type="hidden" id="myplugin_favicon_id" name="myplugin_favicon_id" value="' . esc_attr($value) . '">';
    echo '<button type="button" class="button" id="myplugin_favicon_button">Select Favicon</button>';
    echo '<img id="myplugin_favicon_preview" src="' . esc_attr($image_url) . '" style="max-width: 100px; display: ' . ($image_url ? 'block' : 'none') . ';">';
    echo '<p class="description">Select a favicon from the media library. Recommended file type: PNG. Recommended size: 16x16 or 32x32 pixels.</p>';
}

// HTML for the Apple Touch Icon input field
function myplugin_apple_touch_icon_html() {
    $value = get_option('myplugin_apple_touch_icon_id', '');
    $image = wp_get_attachment_image_src($value, 'thumbnail');
    $image_url = $image ? $image[0] : '';
    echo '<input type="hidden" id="myplugin_apple_touch_icon_id" name="myplugin_apple_touch_icon_id" value="' . esc_attr($value) . '">';
    echo '<button type="button" class="button" id="myplugin_apple_touch_icon_button">Select Apple Touch Icon</button>';
    echo '<img id="myplugin_apple_touch_icon_preview" src="' . esc_attr($image_url) . '" style="max-width: 100px; display: ' . ($image_url ? 'block' : 'none') . ';">';
    echo '<p class="description">Select an Apple Touch Icon from the media library. Recommended file type: PNG. Recommended size: 180x180 pixels.</p>';
}

// Enqueue media uploader script
function myplugin_enqueue_media_uploader($hook) {
    if ($hook !== 'settings_page_custom-favicon') {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script('myplugin-media-uploader', plugin_dir_url(__FILE__) . 'media-uploader.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'myplugin_enqueue_media_uploader');

// Add the favicon URLs to the head section
function myplugin_add_custom_favicon() {
    $favicon_id = get_option('myplugin_favicon_id');
    $apple_touch_icon_id = get_option('myplugin_apple_touch_icon_id');
    $favicon_url = $favicon_id ? wp_get_attachment_url($favicon_id) : '';
    $apple_touch_icon_url = $apple_touch_icon_id ? wp_get_attachment_url($apple_touch_icon_id) : '';
    if ($favicon_url) {
        echo '<link rel="icon" type="image/png" href="' . esc_url($favicon_url) . '">';
    }
    if ($apple_touch_icon_url) {
        echo '<link rel="apple-touch-icon" href="' . esc_url($apple_touch_icon_url) . '">';
    }
}
add_action('wp_head', 'myplugin_add_custom_favicon');
