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

function memorista_plugin_options()
{
    if (!empty($_POST)) {
        update_option("memorista_api_key", $_POST["apiKey"]);
    }

    $apiKey = get_option("memorista_api_key");
    include "memorista-admin-page.php";
}

function memorista_plugin_menu()
{
    add_menu_page(
        "Memorista",
        "Memorista",
        "manage_options",
        "memorista",
        "memorista_plugin_options",
        "dashicons-format-chat"
    );
}

function memorista_uninstall()
{
    delete_option("memorista_api_key");
}

add_action("admin_menu", "memorista_plugin_menu");
add_shortcode("memorista", "memorista_client_ui");
wp_enqueue_style("styles", plugin_dir_url(__FILE__) . "memorista-styles.css");

wp_enqueue_script(
    "memorista",
    plugin_dir_url(__FILE__) . "memorista-client-ui.js"
);
wp_enqueue_style(
    "memorista",
    plugin_dir_url(__FILE__) . "memorista-client-ui.css"
);

register_uninstall_hook(__FILE__, "memorista_uninstall");
