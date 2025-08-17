<?php
//JavaScript Code for opening uploader and copying the link of the uploaded image to a textbox
function include_js_code_for_uploader(){
?>
<!-- ****** JS CODE ******  -->
<script>
    jQuery(function($){

      // Set all variables to be used in scope
      var frame,
          metaBox = $('#image_uploader_metabox.postbox'); // Your meta box id here
          addImgLink = metaBox.find('.upload-custom-img');
          imgContainer = metaBox.find( '.custom-img-container');
          imgIdInput = metaBox.find( '.custom-img-id' );
          customImgDiv = metaBox.find( '#custom-images' );

      // ADD IMAGE LINK
      addImgLink.on( 'click', function( event ){
        event.preventDefault();

        // If the media frame already exists, reopen it.
        if ( frame ) {
          frame.open();
          return;
        }

        // Create a new media frame
        frame = wp.media({
          title: 'Select or Upload Media Of Your Chosen Persuasion',
          button: {
            text: 'Use this media'
          },
          multiple: false  // Set to true to allow multiple files to be selected
        });
 

        // When an image is selected in the media frame...
        frame.on( 'select', function() {
          // Get media attachment details from the frame state
          var attachment = frame.state().get('selection').first().toJSON();

          // Send the attachment URL to our custom image input field.
          imgContainer.append( '<div class="image-wrapper"><input type="text" name="image_src[]" value="'+attachment.url+'"> <a class="delete-custom-img" href="#">Remove this image</a></div>' );

        });

        // Finally, open the modal on click
        frame.open();
      });

        customImgDiv.on ( 'click', '.delete-custom-img', function (event){		
            event.preventDefault();
            jQuery(event.target).parent().remove();		
        });

    });
</script>

<?php }