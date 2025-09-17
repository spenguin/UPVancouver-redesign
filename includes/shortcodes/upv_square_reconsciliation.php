<?php
/**
 * Reconscile uploaded Square file with Orders
 */
function upv_square_reconsciliation( $atts = [], $content = null, $tag = '' )
{
    require_once( ABSPATH . 'wp-admin/includes/file.php' ); // Include file handling functions

    // pvd(get_temp_dir());
    
    if( empty($_FILES['fileToUpload'] ) )
    {
        // Upload the file 
        ?>
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Reconscile Transactions" name="submit">
        </form>
        <?php
    } else {
        if (($handle = fopen($_FILES['fileToUpload']['tmp_name'], 'r')) !== FALSE)
        {
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                // $data will be an array containing the fields of the current line
                // You can now process the data, for example, print it:
                echo "Line: " . implode(', ', $data) . "\n";
                
                // Or access specific fields:
                // echo "First field: " . $data[0] . "\n";
                // echo "Second field: " . $data[1] . "\n";
            }
            // Close the file handle
            fclose($handle);
        } else {
            echo "Error opening the CSV file.";
        }
    }
}



// $filename = 'data.csv'; // Replace with your CSV file name

// // Open the CSV file in read mode ('r')
// if (($handle = fopen($filename, 'r')) !== FALSE) {
//     // Loop through each line of the CSV file
//     while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
//         // $data will be an array containing the fields of the current line
//         // You can now process the data, for example, print it:
//         echo "Line: " . implode(', ', $data) . "\n";
        
//         // Or access specific fields:
//         // echo "First field: " . $data[0] . "\n";
//         // echo "Second field: " . $data[1] . "\n";
//     }
//     // Close the file handle
//     fclose($handle);
// } else {
//     echo "Error opening the CSV file.";
// }
