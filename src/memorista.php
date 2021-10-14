<?php

/**
 * Plugin Name:       Memorista
 * Plugin URI:        https://github.com/Memorista/memorista-wordpress-plugin
 * Description:       Let your guests share their memories by creating your own guestbook with Memorista.
 * Version:           1.0.0
 * Requires at least: 2.7
 * Requires PHP:      5.6
 * Author:            Memorista
 * Author URI:        https://memorista.io
 * License:           MIT
 * License URI:       https://github.com/Memorista/memorista-wordpress-plugin/blob/main/LICENSE
 * Text Domain:       memorista
 * Domain Path:       /memorista
 */

function enqueue_memorista_client_ui_script()
{
    wp_enqueue_script("memorista-client-ui", plugin_dir_url(__FILE__) . "memorista-client-ui.js");
}
add_action("wp_enqueue_scripts", "enqueue_memorista_client_ui_script");

function memorista_client_ui()
{
    $apiKey = esc_html(get_option("memorista_api_key"));

    return "<x-memorista api-key=\"$apiKey\"></x-memorista>";
}
add_shortcode("memorista", "memorista_client_ui");

function memorista_options()
{
    $canActivatePlugin = current_user_can("activate_plugins");

    if (!empty($_POST) && $canActivatePlugin) {
        update_option("memorista_api_key", sanitize_text_field($_POST["apiKey"]));
    }

    wp_enqueue_style("styles", plugin_dir_url(__FILE__) . "memorista-options.css");

    $apiKey = get_option("memorista_api_key");
    include "memorista-options.php";
}
function memorista_menu()
{
    add_menu_page("Memorista", "Memorista", "manage_options", "memorista", "memorista_options", "dashicons-format-chat");
}
add_action("admin_menu", "memorista_menu");

function memorista_uninstall()
{
    delete_option("memorista_api_key");
}
register_uninstall_hook(__FILE__, "memorista_uninstall");
