<?php

	/**
	 * Render the metabox
	 */
	function myplugin_render_metabox() {

		// Variables
		global $post;
		$saved = get_post_meta( $post->ID, 'myplugin_media_id', true );

		?>

			<fieldset>

				<div>
					<?php 
						/**
						 * The label for the media field
						 */ 
					?>
					<label for="myplugin_media"><?php _e( 'Field Label', 'events' )?></label><br>

					<?php 
						/**
						 * The actual field that will hold the URL for our file
						 */ 
					?>
					<input type="url" class="large-text" name="myplugin_media" id="myplugin_media" value="<?php echo esc_attr( $saved ); ?>"><br>

					<?php 
						/**
						 * The button that opens our media uploader
						 * The `data-media-uploader-target` value should match the ID/unique selector of your field.
						 * We'll use this value to dynamically inject the file URL of our uploaded media asset into your field once successful (in the myplugin-media.js file)
						 */ 
					?>
					<button type="button" class="button" id="events_video_upload_btn" data-media-uploader-target="#myplugin_media"><?php _e( 'Upload Media', 'myplugin' )?></button>
				</div>

			</fieldset>

		<?php

		// Security field
		wp_nonce_field( 'myplugin_form_metabox_nonce', 'myplugin_form_metabox_process' );

	}

	/**
	 * Load the media uploader and our custom myplugin-media.js file
	 * Change `myplugin_custom_post_type` to whatever the post type for your metabox is
	 * You may also need to change the `plugins_url()` path to match your plugin folder structure (currently assumes flat with no subfolders)
	 */
	function myplugin_load_admin_scripts( $hook ) {
		global $typenow;
		if( $typenow == 'myplugin_custom_post_type' ) {
			wp_enqueue_media();

			// Registers and enqueues the required javascript.
			wp_register_script( 'meta-box-image', plugins_url( 'myplugin-media.js' , __FILE__ ), array( 'jquery' ) );
			wp_localize_script( 'meta-box-image', 'meta_image',
				array(
					'title' => __( 'Choose or Upload Media', 'events' ),
					'button' => __( 'Use this media', 'events' ),
				)
			);
			wp_enqueue_script( 'meta-box-image' );
		}
	}
	add_action( 'admin_enqueue_scripts', 'gmt_events_load_admin_scripts', 10, 1 );