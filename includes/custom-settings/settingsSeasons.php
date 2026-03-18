<?php
/**
 * Season Settings
 * Current settings:
 * - Times for Matinee and Evening performances
 * - Performance Days of the Week
 */

if( isset($_POST['submit-season-settings']) )
{
    $errors = '';
    if( isset($_POST['display_next_season'] ) )
    {   
        if( !in_array($_POST['display_next_season'], ["0", "1"] )  )
        {
            $error = "Error with selection. Please try again";
        } else {
            update_option( 'display_next_season', $_POST['display_next_season'] );
        }

    } else {
        $error = "Select one option or another.";
    }
}
$display_next_season = get_option( 'display_next_season', 0 );
?>
<h3>Settings for Seasons</h3>
<form method="post" action="options-general.php?page=custom_settings">
    <label>
        <input type="radio" name="display_next_season" value="0" <?php echo ("0" == $display_next_season) ? 'checked' : ''; ?>> Display New Season</input><br>
        <input type="radio" name="display_next_season" value="1" <?php echo ("1" == $display_next_season) ? 'checked' : ''; ?>> Suppress New Season</input>
    </label>
    <?php if( !empty($errors ) ): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    
    <?php
        submit_button('Save Season Settings', 'primary', 'submit-season-settings' ); 
    ?>
</form>