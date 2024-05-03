<?php

/**
 * custom option and settings
 */
function performance_settings_init()
{
    // Register the settings for the 'performance' Custom Post Types
    register_setting('performance', 'performance_options');

    add_settings_section(
        'performance_section_developers',
        __('Set Performance Days and Times Defaults', 'performance'),
        '',
        'performance'
    );

    add_settings_field(
        'performance_field_times',
        __('Evening and Matinee Times', 'performance'),
        'performance_field_times_cb',
        'performance',
        'performance_section_developers',
        array(
            [
                'label_for' => 'performance_field_matinee_starttime',
                'class'     => 'performance_field_starttime',
                'performance_custom_data'   => 'custom'
            ],
            [
                'label_for' => 'performance_field_evening_starttime',
                'class'     => 'performance_field_starttime',
                'performance_custom_data'   => 'custom'
            ],
        )
    );

    add_settings_field(
        'performance_field_days',
        __('Performances each weekday', 'performance '),
        'performance_field_days_cb',
        'performance',
        'performance_section_developers',
        array(
            'label_for' => 'performance_field_performance',
            'class'     => 'performance_field_performance',
            'performance_custom_data'   => 'custom'
        )
    );

    add_settings_field(
        'season_ticket_settings',
        __('Season Ticket Advanced Offer settings', 'performance' ),
        'performance_season_ticket_settings_cb',
        'performance',
        'performance_section_developers',
        array(
            [
                'label_for' => 'performance_field_season_ticket_end_day',
                'class'     => 'performance_field_season_ticket_end_day',
                'performance_custom_data'   => 'custom'
            ],
            [
                'label_for' => 'performance_field_season_ticket_string',
                'class'     => 'performance_field_season_ticket_string',
                'performance_custom_data'   => 'custom'
            ]          
        )
    );
}


add_action('admin_init', 'performance_settings_init');

function performance_season_ticket_settings_cb($args)
{
    $options = get_option('performance_options'); 
    ?>
    <label for="<?php echo esc_attr($args[0]['label_for']); ?>">Season Ticket End Date:</label>
    <input type="date" name="performance_options[<?php echo esc_attr($args[0]['label_for']); ?>]" value="<?php echo isset( $options[$args[0]['label_for']] ) ? $options[$args[0]['label_for']] : NULL; ?>" />
    <label for="<?php echo esc_attr($args[1]['label_for']); ?>">Season Ticket Sales Phrase:</label>
    <input type="text" name="performance_options[<?php echo esc_attr($args[1]['label_for']); ?>]" value="<?php echo isset( $options[$args[1]['label_for']] ) ? $options[$args[1]['label_for']] : ''; ?>" />
    <?php
}

function performance_field_times_cb($args)
{
    $options = get_option('performance_options');
?>
    <label for="<?php echo esc_attr($args[0]['label_for']); ?>">Matinee Start Time:</label>
    <input type="time" name="performance_options[<?php echo esc_attr($args[0]['label_for']); ?>]" value="<?php echo $options[$args[0]['label_for']]; ?>" />
    <label for="<?php echo esc_attr($args[1]['label_for']); ?>">Evening Start Time:</label>
    <input type="time" name="performance_options[<?php echo esc_attr($args[1]['label_for']); ?>]" value="<?php echo $options[$args[1]['label_for']]; ?>" />

<?php
}

function performance_field_days_cb($args)
{
    $options    = get_option('performance_options');
?>
    <table>
        <tr>
            <td>&nbsp;</td>
            <td>Monday</td>
            <td>Tuesday</td>
            <td>Wednesday</td>
            <td>Thursday</td>
            <td>Friday</td>
            <td>Saturday</td>
            <td>Sunday</td>
        </tr>
        <tr>
            <td>Matinee</td>
            <td><input name="performance_options['m'][0]" value="1" type="checkbox" <?php echo (isset( $options["'m'"][0] ) && $options["'m'"][0] == '1') ? 'checked="checked"' : ''; ?> /></td>
            <td><input name="performance_options['m'][1]" value="1" type="checkbox" <?php echo (isset( $options["'m'"][1] ) && $options["'m'"][1] == '1') ? 'checked="checked"' : ''; ?> /></td>
            <td><input name="performance_options['m'][2]" value="1" type="checkbox" <?php echo (isset( $options["'m'"][2] ) && $options["'m'"][2] == '1') ? 'checked="checked"' : ''; ?> /></td>
            <td><input name="performance_options['m'][3]" value="1" type="checkbox" <?php echo (isset( $options["'m'"][3] ) && $options["'m'"][3] == '1') ? 'checked="checked"' : ''; ?> /></td>
            <td><input name="performance_options['m'][4]" value="1" type="checkbox" <?php echo (isset( $options["'m'"][4] ) && $options["'m'"][4] == '1') ? 'checked="checked"' : ''; ?> /></td>
            <td><input name="performance_options['m'][5]" value="1" type="checkbox" <?php echo (isset( $options["'m'"][5] ) && $options["'m'"][5] == '1') ? 'checked="checked"' : ''; ?> /></td>
            <td><input name="performance_options['m'][6]" value="1" type="checkbox" <?php echo (isset( $options["'m'"][6] ) && $options["'m'"][6] == '1') ? 'checked="checked"' : ''; ?> /></td>
        </tr>
        <tr>
            <td>Evening</td>
            <td><input name="performance_options['e'][0]" value="1" type="checkbox" <?php echo ( isset( $options["'e'"][0] ) && $options["'e'"][0] == '1') ? 'checked="checked"' : ''; ?> /></td>
            <td><input name="performance_options['e'][1]" value="1" type="checkbox" <?php echo ( isset( $options["'e'"][1] ) && $options["'e'"][1] == '1') ? 'checked="checked"' : ''; ?> /></td>
            <td><input name="performance_options['e'][2]" value="1" type="checkbox" <?php echo ( isset( $options["'e'"][2] ) && $options["'e'"][2] == '1') ? 'checked="checked"' : ''; ?> /></td>
            <td><input name="performance_options['e'][3]" value="1" type="checkbox" <?php echo ( isset( $options["'e'"][3] ) && $options["'e'"][3] == '1') ? 'checked="checked"' : ''; ?> /></td>
            <td><input name="performance_options['e'][4]" value="1" type="checkbox" <?php echo ( isset( $options["'e'"][4] ) && $options["'e'"][4] == '1') ? 'checked="checked"' : ''; ?> /></td>
            <td><input name="performance_options['e'][5]" value="1" type="checkbox" <?php echo ( isset( $options["'e'"][5] ) && $options["'e'"][5] == '1') ? 'checked="checked"' : ''; ?> /></td>
            <td><input name="performance_options['e'][6]" value="1" type="checkbox" <?php echo ( isset( $options["'e'"][6] ) && $options["'e'"][6] == '1') ? 'checked="checked"' : ''; ?> /></td>
        </tr>
    </table>


<?php
    // checked=<?php $options[$args['m'][0]['label_for']] ? 'checked' : ''; 
}

// Add the top level menu page
function performance_options_page()
{
    add_menu_page(
        'Performance',
        'Performance Day & Time Defaults',
        'manage_options',
        'performance',
        'performance_options_page_html'
    );
}

/**
 * Register our performance_options_page to the admin_menu action hook.
 */
add_action('admin_menu', 'performance_options_page');

/**
 * Top level menu callback function
 */
function performance_options_page_html()
{
    // check user capabilties
    if (!current_user_can('manage_options')) {
        return;
    }

    // add error/update messages

    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if (isset($_GET['settings-updated'])) {
        // add settings saved message with the class of "updated"
        add_settings_error('performance_messages', 'performance_message', __('Settings Saved', 'performance'), 'updated');
    }

    // show error/update messages
    settings_errors('performance_messages');
?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "performance"
            settings_fields('performance');

            do_settings_sections('performance');

            submit_button('Save Settings');
            ?>
        </form>

    </div>
<?php


}
