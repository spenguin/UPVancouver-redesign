<?php
/**
 * Performance Settings
 * Current settings:
 * - margin for Sold Out Performances
 * - overbooking margin for Opening Night Performance
 */
$errorMessages = ['',''];
if( isset($_POST['submit-performance-settings']) )
{
	$soldOutMargin 					= $_POST['soldOutMargin'];
	$overbookingOpeningNightMargin	= $_POST['overbookingOpeningNightMargin'];
	if (!preg_match("/^[0-9]*$/", $soldOutMargin)) {
    	$errorMessages[0] = "Only numeric values are allowed!!";
	}else{
      	update_option('soldOutMargin', $soldOutMargin );
	}
	if (!preg_match("/^[0-9]*$/", $overbookingOpeningNightMargin)) {
    	$errorMessages[1] = "Only numeric values are allowed!!";
	}else{
      	update_option('overbookingOpeningNightMargin', $overbookingOpeningNightMargin );
	}	
}

$soldOutMargin					= get_option( 'soldOutMargin', 0 );
$overbookingOpeningNightMargin	= get_option( 'overbookingOpeningNightMargin', 0 );
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
		<label for="overbookingOpeningNightMargin">Opening Night Performance Overbooking Margin: </label>
		<input type="number" name="overbookingOpeningNightMargin" value="<?php echo $overbookingOpeningNightMargin; ?>" />
		<?php if( 0 < strlen($errorMessages[1] ) ): ?>
			<div class="error"><?php echo $errorMessages[1]; ?></div>
		<?php endif; ?>

	</fieldset>

    <?php
        submit_button('Save Performance Settings', 'primary', 'submit-performance-settings' ); // "Save Changes" button
    ?>
</form>