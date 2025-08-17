<?php
/**
 * Add single purchases (or upload purchases as a spreadsheet)
 * Or Edit an existing order
 */

function upv_ticket_admin()
{
    if( isset($_GET['orderId']))
    {
        $order_id = filter_var($_GET['orderId'], FILTER_SANITIZE_NUMBER_INT);
        
        // Get the order details from the orderId
        $order = wc_get_order( $order_id ); 

        $order_note     = get_order_note( $order_id ); //pvd($order_note);
        $customer_note  = $order->get_customer_note();

        $customer       = get_order_customer( $order ); 

        $current_admin_user_note    = get_user_meta($customer->ID, 'user-notes-note', true);

        $admin_customer_note    = '';
        $admin_order_note       = get_admin_order_note($order_id); 

        // Has there been any amendments?
        if( isset($_POST['amend']) )
        {
            $admin_order_note = htmlspecialchars( $_POST['admin_order_note'], ENT_QUOTES ); 
            if( !empty($admin_order_note) && $admin_order_note != substr($admin_order_notes[0]->content, 4) )
            {
                $order->add_order_note( '[ta]' . $admin_order_note );
            }

            $admin_customer_note = htmlspecialchars( $_POST['admin_customer_note'], ENT_QUOTES ); 
            if( !empty($admin_customer_note) && $current_admin_user_note != $admin_customer_note )
            {
                update_user_meta($customer->ID, 'user-notes-note', $admin_customer_note);
            }

            // Any changes to performance dates
            if( isset($_POST['date']))
            {
                $changed    = FALSE;
                foreach($_POST['date'] as $key => $date )
                {
                    if( $order_note[$key]['date'] != ($new_date = date('j M Y',$date ) ) )
                    {
                        $changed    = TRUE;
                        amend_tickets_sold( $order_note[$key]['date'], -1 * $order_note[$key]['quantity'], $order_id );
                        amend_tickets_sold( $new_date, $order_note[$key]['quantity'], $order_id );
                        $performance= get_post_by_title( $new_date, NULL, 'performance' );
                        $time       = get_post_meta($performance->ID, 'performance_time', TRUE );
                        $order_note[$key]['date'] = $new_date;
                        $order_note[$key]['time'] = $time;
                    }
                }
                if( $changed )
                {
                    $order_note['amended']   = "changed";
                    set_order_note( $order_id, $order_note);
                    $order->update_status( 'processing' );
                    $order->update_status( 'completed' );

                    // $notes_encoded      = base64_encode(serialize($notes));
                    // update_post_meta($order_id, 'custom_field_name', $notes_encoded );
                } 

            }
        }
        ?>
        <div class="ticket-admin">
            <div class="ticket-admin__edit">
                <h2>Edit Ticket Purchase</h2>
                <?php if(!empty($message)): ?>
                    <div class="error"><?php echo $message; ?>
                <?php endif; ?>
                <?php 
                    if( empty($order_note) )
                    {
                        echo '<p>Order not found</p>';
                    } else {
                        
                        $total  = 0;
                        ?>
                        <form action="<?php echo get_bloginfo('url') . $_SERVER['REQUEST_URI']; ?>" method="post">
                            <table>
                                <thead>
                                    <tr>
                                        <td>Ticket</td>
                                        <td>Quantity</td>
                                        <td>Performance</td>
                                        <td>Charge</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach( $order_note as $key => $note )
                                    { 
                                        if( $key == "amended" ) continue;
                                        if( $key == "customer_contact" ) continue;
                                        if( $key == "boxoffice" ) continue;
                                        $terms  = get_the_terms($note['product_id'], 'product_cat'); 
                                        $term   = reset($terms); 
                                        ?>
                                        <tr>
                                            <td><?php echo $note['name'] ; ?>
                                                <?php 
                                                if( "Uncategorized" != $term->name)
                                                {
                                                    echo ' (' . $term->name . ')';
                                                } ?>
                                            </td>
                                            <td><?php echo $note['quantity']; ?></td>
                                            <td>
                                                <?php 
                                                    if( in_array($term->slug, ['season-ticket', 'donation'] ) )
                                                    {
                                                        echo "N/A";
                                                    } elseif( $term->slug == "uncategorized" && $note['name'] <> "Comp" ) {
                                                        echo "N/A";
                                                    } else { 
                                                        if( strtotime($note['date']) < time() )
                                                        {
                                                            echo $note['showTitle'] . ' ' . $note['date'] . ' ' . $note['time'];
                                                        }
                                                        else 
                                                        {
                                                            echo $note['showTitle'] . ', <select name="date[' . $key . ']">' . organise_performance_dates($note['showTitle'], $note['date']) . '</select>';
                                                        }

                                                    }
                                                ?>
                                            </td>
                                            <td>&dollar;<?php echo number_format($note['misha_custom_price'] * $note['quantity'], 2); ?></td>
                                        </tr>
                                        <?php $total += $note['misha_custom_price'] * $note['quantity'];
                                    } ?>
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                        <td>Total:</td>
                                        <td>&dollar;<?php echo number_format($total, 2); ?></td>
                                    </tr>
                                    <?php if( array_key_exists("boxoffice", $order_note) && $order_note['boxoffice'] ): ?>
                                        <tr><td>Note: Payment to be made at Box Office</td></tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td>Customer Note:<br/><?php echo $customer_note; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <label for="admin_order_note">Accessibility notes (if applicable):</label><br>
                                            <textarea name="admin_order_note" style="width:100%;"><?php echo $admin_order_note; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <label for="admin_customer_note">Customer Note (Admin):</label><br>
                                            <textarea name="admin_customer_note" style="width:100%;"><?php echo $admin_customer_note; ?></textarea>
                                        </td>
                                    </tr>  
                                    <tr><td><input type="submit" name="amend" value="Amend Order" class="button button--action"/></td>
                                    </tr>                              
                                </tbody>
                            </table>
                        </form>
                        <?php
                    }
                ?>
            </div>
        </div>

        <?php
        
    } else {

        $show_titles    = get_show_titles();
        $tickets        = getSingleShowTickets(); 

        $message        = "";

        if( isset($_POST['add_order'] ))
        {
            $error  = FALSE;
            if( empty( $_POST['seasons'] . $_POST['adult'] . $_POST['senior'] . $_POST['student'] . $_POST['comp'] ) )
            {
                $error      = TRUE;
                $message    = "At least one ticket must be added";
            }
            if( !isset($_POST['payment']) )
            {
                $error  = TRUE;
                $message    = "Payment status must be selected";
            }
            // Test if Comp ticket is selected; Note required
            if( isset($_POST['comp']) && $_POST['comp'] > 1 && !isset($_POST['admin_order_note']) )
            {
                $error      = TRUE;
                $message    = "Comp tickets require explanatory note.";
            }
            // Need to confirm that the date is an actual performance date
            $performance_date   = date('j M Y', strtotime($_POST['performance_date']) );
            $performance    = get_post_by_title( $performance_date, '', 'performance' );
            $time           = get_post_meta($performance->ID, 'performance_time', TRUE );
            if( is_null($performance) )
            {
                $error      = TRUE;
                $message    = "Performance date is invalid.";
            }

            if( !$error )
            {
                // Get user

                $email  = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
                $phone  = filter_var($_POST['userPhone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS );
                $userName   = filter_var($_POST['userName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS ); 

                // User already exist            
                $user = get_user_by( 'email', $email );
                if( !$user ) {
                    // Create new user
                    $user_data = [
                        'user_pass'     => wp_generate_password(),
                        'user_login'    => $email,
                        'user_email'    => $email,
                        'role'          => 'attendee',
                        'display_name'  => $userName
                    ];
                    wp_insert_user($user_data);
                    $user = get_user_by( 'email', $email );
                }            
                
                
                // Create new order
                $order          = new WC_Order( $email );
                $order->set_created_via( $email ); 
                $order->set_customer_id( $user->ID ); 
                $order->set_billing_phone( $phone );

                $name     = explode( ' ', $userName ); 
                $order->set_billing_first_name( $name[0] );
                array_shift($name); 
                if( !empty( $name ) ) $order->set_billing_last_name( join(' ', $name) );
                

                $admin_order_note   = htmlspecialchars( $_POST['admin_order_note'], ENT_QUOTES );//die(pvd($admin_order_note));
                $order->add_order_note( '[ta]' . $admin_order_note );

                $admin_customer_note = htmlspecialchars( $_POST['admin_customer_note'], ENT_QUOTES ); 
                if( !empty($admin_customer_note) )
                {
                    update_user_meta($user->ID, 'user-notes-note', $admin_customer_note);
                }
                // $order->add_order_note( $note );

                $tickets_ordered    = [];
                $ordered_count      = 0;
                $order_note         = [];

                foreach( $tickets as $ticketId => $ticketName )
                {
                    if( !empty($_POST[$ticketName] ) )
                    {
                        $product    = wc_get_product( $ticketId );
                        $order->add_product( $product, $_POST[$ticketName] );
                        $tickets_ordered[$ticketId] = $_POST[$ticketName];
                        $ordered_count              += $_POST[$ticketName];
                        

                        // $price = get_post_meta( $ticketId, 'misha_custom_price', TRUE );
                        // $performance                = get_post_by_title();
                        $order_note[]   = [
                            'product_id'    => $ticketId,
                            'quantity'      => $_POST[$ticketName],
                            'date'          => $performance_date, //date('j M Y', strtotime($_POST['performance_date'])),
                            'time'          => $time,
                            'showTitle'     => $_POST['show_title'],
                            'misha_custom_price' => $product->get_price(),
                            'name'          => ucfirst($ticketName)
                        ];
                    }
                }

                $order->calculate_totals(); 
                $orderId = $order->save(); 

                if( $_POST['payment'] != 1 )
                {
                    $order_note['boxoffice']    = TRUE;
                }

                // If the email being used is the Admin email, we need to save the Name and Phone Number in the $order_note
                if( $email == get_bloginfo('admin_email'))    // This will need to be amended.
                {
                    $order_note['customer_contact'] = [
                        'name'      => $userName,
                        'phone'     => $phone
                    ];
                } 
                set_order_note( $orderId, $order_note );

                $payment_status = $_POST['payment'] ? 'completed' : 'pending'; 
                // $order->update_status( $payment_status );
                $order->update_status( 'completed' );
                $order->add_order_note( '[ta]' . $admin_order_note );

                // Add order to Performance
                $tickets_sold = get_post_meta( $performance->ID, 'tickets_sold', TRUE );
                if( empty($tickets_sold) )
                {
                    $tickets_sold           = [];
                    $tickets_sold['count']  = 0;
                } 
                $tickets_sold['count']  += $ordered_count;
                $tickets_sold[$orderId] = $tickets_ordered;
                update_post_meta( $performance->ID, 'tickets_sold', $tickets_sold );
                $_POST = [];

                $message = "Order successfully added.";
            }
        }
        $userName   = isset($_POST['userName'] ) ? $_POST['userName'] : '';
        $userEmail  = isset($_POST['userEmail'] ) ? $_POST['userEmail'] : get_bloginfo('admin_email'); //'info@weirdspace.com';
        $userPhone  = isset($_POST['userPhone'] ) ? $_POST['userPhone'] : '';

        ?>
        <div class="ticket-admin max-wrapper__narrow">
            <div class="ticket-admin__add">
                <h2>Single Performance Ticket Purchases</h2>
                <?php if(!empty($message)): ?>
                    <div class="error"><?php echo $message; ?>
                <?php endif; ?>
                <form action="/ticket-admin" method="post" class="upv-form">
                    <label for="show">Which show:
                        <select name="show_title" required>
                            <option value="">Select Show</option>
                            <?php
                                foreach( $show_titles as $show_id => $show_name )
                                {   
                                    $selected = "";
                                    if( isset($_POST['show_title'] ) && $_POST['show_title'] == $show_name ) $selected = "selected";
                                    ?>
                                        <option value="<?php echo $show_name; ?>" <?php echo $selected; ?>><?php echo $show_name; ?></option>
                                    <?php
                                } ?>
                        </select>
                    </label>
                    <?php $date = isset($_POST['performance_date']) ? $_POST['performance_date'] : ''; ?>
                    <label for="performance_date">Which performance date:&nbsp;<input type="date" name="performance_date" placeholder="Performance date" required value="<?php echo $date; ?>" /></label>
                    <label for="userName">Name:<input type="text" name="userName" placeholder="Buyer name" value="<?php echo $userName; ?>" required/></label>
                    <label for="userEmail">Email:<input type="email" name="userEmail" placeholder="Buyer email" value="<?php echo $userEmail; ?>" required/></label>
                    <label for="userPhone">Telephone:<input type="text" name="userPhone" placeholder="Buyer telephone" value="<?php echo $userPhone; ?>" required/></label>                    
                    <label>Tickets ordered:
                        <div class="upv-form__short-text"><input type="text" name="seasons" value="<?php echo isset($_POST['seasons']) ? $_POST['seasons'] : ''; ?>"> Seasons tickets</div>
                        <div class="upv-form__short-text"><input type="text" name="adult" value="<?php echo isset($_POST['adult']) ? $_POST['adult'] : ''; ?>"> Adult tickets</div>
                        <div class="upv-form__short-text"><input type="text" name="senior" value="<?php echo isset($_POST['senior']) ? $_POST['senior'] : ''; ?>"> Senior tickets</div>
                        <div class="upv-form__short-text"><input type="text" name="student" value="<?php echo isset($_POST['student']) ? $_POST['student'] : ''; ?>"> Student tickets</div>
                        <div class="upv-form__short-text"><input type="text" name="comp" value="<?php echo isset($_POST['comp']) ? $_POST['comp'] : ''; ?>"> Comp tickets</div>
                    </label>
                    <?php $payment = isset($_POST['payment']) ? $_POST['payment'] : ''; ?>
                    <label>Payment method:
                        <div class="upv-form__short-text"><input type="radio" name="payment" value="1" <?php echo $payment == 1 ? "checked" : ''; ?>> Paid in full</div>
                        <div class="upv-form__short-text"><input type="radio" name="payment"  value="0" <?php echo $payment == 0 ? "checked" : ''; ?>> Pay at Box Office</div>
                        <!-- <div class="upv-form__short-text"><input type="radio" name="payment" class="short-text"> Comp</div> -->
                    </label>  
                    <label for="admin_order_note">Accessibility notes (if applicable): (Also required for Comp tickets)
                        <textarea name="admin_order_note" ><?php echo isset($_POST['admin_order_note']) ? $_POST['admin_order_note'] : ''; ?></textarea>
                    </label>
                    <label for="admin_customer_note">Customer Note (Admin):
                        <textarea name="admin_customer_note" ><?php echo isset($_POST['admin_customer_note']) ? $_POST['admin_customer_note'] : ''; ?></textarea>
                    </label>
                        
                    <input type="submit" class="button" name="add_order" value="Submit" />
                </form>
            </div>
            <!-- <div class="ticket-admin__edit">
                <h2>Ticket Purchase Edit</h2>
                <?php //if(!empty($message)): ?>
                    <div class="error"><?php //echo $message; ?>
                <?php //endif; ?>
                <form action="/ticket-admin" method="post" class="upv-form">
                    <label for="search">Search by email or name:
                        <input type="text" name="search" placeholder="Email or name" value="" required/>
                    </label>
                    <input type="submit" class="button" name="find_order" value="Search" />
                </form>
            </div> -->
        <!-- </section> -->
        <!-- Suspended for now. May not be needed -->
            <!-- <h2>Performance Ticket Purchases File Upload</h2>
            <form action="/ticket-admin" method="post" class="upv-form" enctype="multipart/form-data">
                <label for="ticket_orders">Upload Spreadsheet</label>
                <input type="file" name="ticket_orders" />
                <input type="submit" class="button" name="upload_file" value="Upload" />
            </form> -->

    <?php
    }
}

/**
 * Organise performance dates into a dropdown
 */
function organise_performance_dates( $showTitle, $date )
{
    $date = strtotime($date);  
    $show           = get_post_by_title($showTitle, NULL, 'show' ); 
    $performances   = getPerformanceDates( $show->ID ); 
    $o              = [];
    foreach( $performances as $performance)
    {   
        $selected   = ($performance['date'] == $date) ? 'selected="selected"' : '';
        $o[]        = "<option value='" . $performance['date'] . "' " . $selected  . ">" . date('j M Y', $performance['date'] ) . " " . $performance['performance_time'] . "</option>";
    }
    return join( '', $o );
}