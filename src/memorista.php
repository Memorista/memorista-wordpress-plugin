<?php

/*
Plugin Name: Memorista
Plugin URI: https://memorista.io
Description: Let your guests share their memories by creating your own guestbook with Memorista.
Text Domain: memorista
Version: 1.0.0
Author: Memorista
Author URI: https://memorista.io
License: TBD
*/

function memorista_client_ui()
{
    $apiKey = get_option("memorista_api_key");

    return <<<EOT
<div id="memorista-root"></div>
<script>
    memorista.init({
        container: document.getElementById('memorista-root'),
        apiKey: '$apiKey'
    });
</script>
EOT;
}
wp_enqueue_script("memorista", plugin_dir_url(__FILE__) . "memorista-client-ui.js");
wp_enqueue_style("memorista", plugin_dir_url(__FILE__) . "memorista-client-ui.css");
add_shortcode("memorista", "memorista_client_ui");

function memorista_options()
{
    if (!empty($_POST)) {
        update_option("memorista_api_key", $_POST["apiKey"]);
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