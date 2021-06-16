<?php

/*
 
Plugin Name: Memorista
 
Plugin URI: https://memorista.io/
 
Description: Let your guests share their memories by creating your own guestbook with Memorista.
 
Version: 1.0
 
Author: Mikowhy Owl
 
Author URI: https://github.com/Mikowhy-owl
 
License: GPLv2 or later
 
Text Domain: Guestbooks reimagined
 
*/

function set_memorista_plugin_page(){

    if (!empty($_POST)) {
        update_option( 'wp-memorista-plugin-api-key', $_POST['apiKey'] );
    }

    $apiKey = get_option('wp-memorista-plugin-api-key');

    ?>
    <div class="memorista-settings-container" style="height:100vh;">
        <h1>Memorista</h1>
     
        <button id="collapsible" type="button" class="collapsible">
            Guide - <?php if($apiKey !== ''&& $apiKey != null){ ?> <span style="color:green"> your setup is ready </span> <?php } else { ?>  <span style="color:red"> you have to set API key!!! </span> <?php } ?>
        </button>
        <div class="content">
            <ol>
                <li>
                    Fill your key
                </li>
            
            <form method="post" action="" id="form1" style="margin-top:20px; margin-bottom:20px;">
                <label>Your key</label>
                <input type="text" name="apiKey" value="<?php echo $apiKey?>" style="min-width:300px;">
                <button name="submit" value="send">Save</button>
            </form>
                <li>
                    Use shortcode <b>[show_memorista]</b> on your page
                </li>
                <li>
                    Next step
                </li>
            </ol>
        </div>

        <script>
            var coll = document.getElementById("collapsible");
            var i;

            coll.addEventListener("click", () => {
                coll.classList.toggle("active");
                setHeight()
            });


            if('<?php echo $apiKey?>' === ''){
                coll.nextElementSibling.style.maxHeight = '100%'
            }


            function setHeight(){
                var content = coll.nextElementSibling;
                if (content.style.maxHeight){
                    content.style.maxHeight = null;
                } else {
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            }
            
        </script>

        <iframe src="https://memorista.io/admin" width="100%" height="972px">
    </div>

    <?php
}

function show_shortcode() {
    $string = '<div id="memorista-root"></div>
    <link rel="stylesheet" href="https://unpkg.com/@memorista/client-ui@1/dist/index.css" />
    <script crossorigin src="https://unpkg.com/@memorista/client-ui@1/dist/index.js"></script>
    <script>
        memorista.init({
            container: document.getElementById(\'memorista-root\'),
            apiKey: \'';

            $string .= get_option('wp-memorista-plugin-api-key');

            $string .= '\'
        });
    </script>';

    return $string;
}

function memorista_plugin_settings_options() {
    //Add a settings page for this plugin to the Settings menu.
    add_menu_page( 'Memorista', 'Memorista', 'manage_options', 'my-plugin-settings', 'set_memorista_plugin_page' );  
}

add_action( 'admin_menu', 'memorista_plugin_settings_options' );
add_shortcode( 'show_memorista' , 'show_shortcode');    
wp_enqueue_style('styles', plugin_dir_url( __FILE__ ) . 'memorista-styles.css');
