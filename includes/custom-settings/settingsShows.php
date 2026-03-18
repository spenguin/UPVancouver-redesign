<?php
/**
 * Show Settings
 * Current settings:
 * - Times for Matinee and Evening performances
 * - Performance Days of the Week
 */
 
if( isset($_POST['submit-show-settings']) )
{
    $errors = ['',''];
    if( strtotime($_POST['performanceMatineeStartTime']) == FALSE || strtotime($_POST['performanceEveningStartTime']) == FALSE )
    {
        $errors[0]  = "Time provided must be valid";
    } else {
        update_option('performanceMatineeStartTime', $_POST['performanceMatineeStartTime'] );
        update_option('performanceEveningStartTime', $_POST['performanceEveningStartTime'] );
    }

    if (isset($_POST['performanceDay']) && is_array($_POST['performanceDay'])) {
        $post_array = $_POST['performanceDay'];

        if (!empty($post_array)) 
        {
            $unique_values = array_unique($post_array);

            if (count($unique_values) === 1 ) 
            {
                update_option( 'performanceDay', $post_array );
            } else {
                $error[1]   = "Selected Performance Days is faulty. Please try again.";
            }
        } else {
            $error[1]   = "No Performance Days have been selected";
        }
    } else {
        $error[1]   = "No Performance Days have been selected";
    }    
}

$performanceMatineeStartTime    = get_option( 'performanceMatineeStartTime', '' );
$performanceEveningStartTime    = get_option( 'performanceEveningStartTime', '' );
$performanceDay                 = get_option( 'performanceDay', [] );

?>
<h3>Settings for Shows</h3>
<form method="post" action="options-general.php?page=custom_settings">
    <fieldset>
        <legend>Show Times and Days of the Week</legend>
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">Evening and Matinee Times</th>
                    <td>    
                        <label for="performanceMatineeStartTime">Matinee Start Time:</label>
                        <input type="time" name="performanceMatineeStartTime" value="<?php echo $performanceMatineeStartTime; ?>">
                        <label for="performanceEveningStartTime">Evening Start Time:</label>
                        <input type="time" name="performanceEveningStartTime" value="<?php echo $performanceEveningStartTime; ?>">
                    </td>
                </tr>
                <?php if( !empty($errors[0] ) ): ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td><?php echo $error[0]; ?></td>
                    </tr>
                <?php endif; ?>
                <tr class="performance_field_performance">
                    <th scope="row">
                        <label for="performance_field_performance">Performances each weekday</label>
                    </th>
                    <td>    
                        <table>
                            <tbody>
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
                                    <td><input name="performanceDay[m][0]" value="1" type="checkbox" <?php echo (isset( $performanceDay['m'][0] ) && $performanceDay['m'][0] == '1') ? 'checked="checked"' : ''; ?>></td>
                                    <td><input name="performanceDay[m][1]" value="1" type="checkbox" <?php echo (isset( $performanceDay['m'][1] ) && $performanceDay['m'][1] == '1') ? 'checked="checked"' : ''; ?>></td>
                                    <td><input name="performanceDay[m][2]" value="1" type="checkbox" <?php echo (isset( $performanceDay['m'][2] ) && $performanceDay['m'][2] == '1') ? 'checked="checked"' : ''; ?>></td>
                                    <td><input name="performanceDay[m][3]" value="1" type="checkbox" <?php echo (isset( $performanceDay['m'][3] ) && $performanceDay['m'][3] == '1') ? 'checked="checked"' : ''; ?>></td>
                                    <td><input name="performanceDay[m][4]" value="1" type="checkbox" <?php echo (isset( $performanceDay['m'][4] ) && $performanceDay['m'][4] == '1') ? 'checked="checked"' : ''; ?>></td>
                                    <td><input name="performanceDay[m][5]" value="1" type="checkbox" <?php echo (isset( $performanceDay['m'][5] ) && $performanceDay['m'][5] == '1') ? 'checked="checked"' : ''; ?>></td>
                                    <td><input name="performanceDay[m][6]" value="1" type="checkbox" <?php echo (isset( $performanceDay['m'][6] ) && $performanceDay['m'][6] == '1') ? 'checked="checked"' : ''; ?>></td>
                                </tr>
                                <tr>
                                    <td>Evening</td>
                                    <td><input name="performanceDay[e][0]" value="1" type="checkbox" <?php echo (isset( $performanceDay['e'][0] ) && $performanceDay['e'][0] == '1') ? 'checked="checked"' : ''; ?>></td>
                                    <td><input name="performanceDay[e][1]" value="1" type="checkbox" <?php echo (isset( $performanceDay['e'][1] ) && $performanceDay['e'][1] == '1') ? 'checked="checked"' : ''; ?>></td>
                                    <td><input name="performanceDay[e][2]" value="1" type="checkbox" <?php echo (isset( $performanceDay['e'][2] ) && $performanceDay['e'][2] == '1') ? 'checked="checked"' : ''; ?>></td>
                                    <td><input name="performanceDay[e][3]" value="1" type="checkbox" <?php echo (isset( $performanceDay['e'][3] ) && $performanceDay['e'][3] == '1') ? 'checked="checked"' : ''; ?>></td>
                                    <td><input name="performanceDay[e][4]" value="1" type="checkbox" <?php echo (isset( $performanceDay['e'][4] ) && $performanceDay['e'][4] == '1') ? 'checked="checked"' : ''; ?>></td>
                                    <td><input name="performanceDay[e][5]" value="1" type="checkbox" <?php echo (isset( $performanceDay['e'][5] ) && $performanceDay['e'][5] == '1') ? 'checked="checked"' : ''; ?>></td>
                                    <td><input name="performanceDay[e][6]" value="1" type="checkbox" <?php echo (isset( $performanceDay['e'][6] ) && $performanceDay['e'][6] == '1') ? 'checked="checked"' : ''; ?>></td>
                                </tr>
                                <?php if( !empty($errors[1] ) ): ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><?php echo $error[1]; ?></td>
                                    </tr>
                                <?php endif; ?>                                
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </fieldset>
    <?php
        submit_button('Save Show Settings', 'primary', 'submit-show-settings' ); 
    ?>
</form>