<?php
/**
 * Custom Settings for Show Custom Post Type
 */

add_action( 'admin_menu', 'show_settings_submenu' );

function show_settings_submenu(){
 
     add_submenu_page(
         'options-general.php', // parent page slug
         'Display Upcoming Season display_next_season Settings',
         'Show Settings',
         'manage_options',
         'show_settings',
         'show_settings_page_callback',
         10 // menu position
     );
 }
 
 function show_settings_page_callback(){
    ?>
    <div class="wrap">
        <h1><?php echo get_admin_page_title() ?></h1>
        <form method="post" action="options-general.php?page=show_settings">
            <?php
                // settings_fields( 'show_display_next_season_settings' ); // settings group name
                do_settings_sections( 'show_settings' ); // just a page slug
                submit_button(); // "Save Changes" button
            ?>
        </form>
    </div>

<!-- 
    <label for="display_next_season">New Season Shows Control<br>
        <input type="radio" name="display_next_season" value="0"> Display New Season</input><br>
        <input type="radio" name="display_next_season" value="1">Suppress New Season</input>
    </label> -->
    <?php

 }

add_action( 'admin_init',  'show_settings_fields' );
function show_settings_fields(){

	// I created variables to make the things clearer
	$page_slug = 'show_settings';
	$option_group = 'show_settings_options';

	// 1. create section
	add_settings_section(
		'show_settings_section_id', // section ID
		'', // title (optional)
		'', // callback function to display the section (optional)
		$page_slug
	);

	// 2. register fields
	register_setting( $option_group, 'show_toggle', 'show_settings_sanitize_radio' );

	// 3. add fields
	add_settings_field(
		'show_toggle',
		'New Season Shows Control',
		'show_settings_radio', // function to print the field
		$page_slug,
		'show_settings_section_id' // section ID
	);

}

// custom callback function to print radio field HTML
function show_settings_radio( $args ) { //pvd($_POST);
    if( isset($_POST['submit']))
    {
        $display_next_season = isset($_POST['display_next_season'] ) ? $_POST['display_next_season'] : 1; 
        update_option('display_next_season', $display_next_season);
    }
	$display_next_season = get_option( 'display_next_season' );
	?>

		<label>
            <input type="radio" name="display_next_season" value="0" <?php echo ("0" == $display_next_season) ? 'checked' : ''; ?>> Display New Season</input><br>
            <input type="radio" name="display_next_season" value="1" <?php echo ("1" == $display_next_season) ? 'checked' : ''; ?>> Suppress New Season</input>
		</label>
	<?php
}

// custom sanitization function for a checkbox field
function show_settings_sanitize_radio( $value ) {
	return 'on' == $value ? 'yes' : 'no';
}