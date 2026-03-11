<?php
/**
 * Performance Settings
 * Current settings:
 * - margin for Sold Out
 * - overbooking margin for Preview shows
 */
$errorMessages = ['',''];
if( isset($_POST['submit-performance-settings']) )
{
	$soldOutMargin 				= $_POST['soldOutMargin'];
	$overbookingPreviewMargin	= $_POST['overbookingPreviewMargin'];
	if (!preg_match("/^[0-9]*$/", $soldOutMargin)) {
    	$errorMessages[0] = "Only numeric values are allowed!!";
	}else{
      	update_option('soldOutMargin', $soldOutMargin );
	}
	if (!preg_match("/^[0-9]*$/", $overbookingPreviewMargin)) {
    	$errorMessages[1] = "Only numeric values are allowed!!";
	}else{
      	update_option('overbookingPreviewMargin', $overbookingPreviewMargin );
	}	
}

$soldOutMargin				= get_option( 'soldOutMargin', 0 );
$overbookingPreviewMargin	= get_option( 'overbookingPreviewMargin', 0 );
?>
<h3>Settings for Performances</h3>
<form method="post" action="options-general.php?page=custom_settings">
	<fieldset>
		<legend>Performance Margins</legend>
		<label for="soldOutMargin">Sold Out Margin: </label>
		<input type="number" name="soldOutMargin" value="<?php echo $soldOutMargin; ?>" /><br />
		<?php if( 0 < strlen($errorMessages[0] ) ): ?>
			<div class="error"><?php echo $errorMessages[0]; ?></div>
		<?php endif; ?>
		<label for="overbookingPreviewMargin">Preview Performance Overbooking Margin: </label>
		<input type="number" name="overbookingPreviewMargin" value="<?php echo $overbookingPreviewMargin; ?>" />
		<?php if( 0 < strlen($errorMessages[1] ) ): ?>
			<div class="error"><?php echo $errorMessages[1]; ?></div>
		<?php endif; ?>

	</fieldset>

    <?php
        submit_button('Save Performance Settings', 'primary', 'submit-performance-settings' ); // "Save Changes" button
    ?>
</form>