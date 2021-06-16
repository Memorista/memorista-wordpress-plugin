<?php
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
$option_name = 'wp-memorista-plugin-api-key';
 
delete_option($option_name);
?>