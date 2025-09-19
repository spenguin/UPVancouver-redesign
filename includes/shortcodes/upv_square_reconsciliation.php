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
            $headings = [];
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                if( empty($headings))
                {
                    $headings = $data; 
                    continue;
                }
                $record = array_combine($headings, $data ); 
                if( !empty($record['Order Reference ID']) )
                {
                    $order = new Order_note( $record['Order Reference ID'] );
                    $order_note = $order->_note; 
                    if( !empty($order_note))
                    {
                        $fees       = substr($record['Fees'], 2); 
                        $order_note['fees']  = $fees; //die(var_dump($order_note));
                        $order->set_order_note($record['Order Reference ID'], $order_note );
                    }
                }
                echo '<p>' . $record['Order Reference ID'] . ': ' . $record['Fees'] . '</p>';
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
