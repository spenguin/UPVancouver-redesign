<?php
/**
 * Test Options page
 */

add_action( 'admin_menu', 'rudr_network_settings_pages' );
function rudr_network_settings_pages() 
{

	add_menu_page( 'Schedule', 'Schedule', 'manage_options', 'schedule-page', 'schedule_cb', 'dashicons-airplane' );

	add_submenu_page( 'themes.php', 'More settings', 'More settings', 'manage_network_options', 'more-settings', 'more_settings_cb' );

}

function schedule_cb() {

}

function more_settings_cb() {

}