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

function set_memorista_plugin_page()
{
    if (!empty($_POST)) {
        update_option("wp-memorista-plugin-api-key", $_POST["apiKey"]);
    }

    $apiKey = get_option("wp-memorista-plugin-api-key");
    include "memorista-admin-page.php";
}

function show_shortcode()
{
    $apiKey = get_option("wp-memorista-plugin-api-key");

    return <<<EOT
<div id="memorista-root"></div>
<link rel="stylesheet" href="https://unpkg.com/@memorista/client-ui@1/dist/index.css" />
<script crossorigin src="https://unpkg.com/@memorista/client-ui@1/dist/index.js"></script>
<script>
    memorista.init({
        container: document.getElementById('memorista-root'),
        apiKey: '$apiKey'
    });
</script>
EOT;
}

function memorista_plugin_settings_options()
{
    //Add a settings page for this plugin to the Settings menu.
    add_menu_page(
        "Memorista",
        "Memorista",
        "manage_options",
        "my-plugin-settings",
        "set_memorista_plugin_page"
    );
}

add_action("admin_menu", "memorista_plugin_settings_options");
add_shortcode("show_memorista", "show_shortcode");
wp_enqueue_style("styles", plugin_dir_url(__FILE__) . "memorista-styles.css");
