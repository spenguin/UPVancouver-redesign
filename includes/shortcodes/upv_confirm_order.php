<?php
/**
 * Confirm Order where order is only season ticket subscription applied to a specific performance
 */

function upv_confirm_order()
{   
    if( isset($_SESSION['cart']) && count($_SESSION['cart']) > 0 ) 
    {
        
        if( isset($_POST['confirm-order'] ) ) 
        { 
            $email  = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); 
            $phone  = filter_var($_POST['phone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS ); 
            $userName   = filter_var($_POST['userName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS ); 

            $user   = userFns::getUserByEmail( $email, $userName );

            // Create Order

            $order          = new WC_Order( $email );
            $order->set_created_via( $email ); 
            $order->set_customer_id( $user->ID ); 
            $order->set_billing_phone( $phone );

            $name     = explode( ' ', $userName ); 
            $order->set_billing_first_name( $name[0] );
            array_shift($name); 
            if( !empty( $name ) ) $order->set_billing_last_name( join(' ', $name) );
            
            $note     = htmlspecialchars( $_POST['notes'], ENT_QUOTES );
            $order->add_order_note( $note );
            $orderId    = $order->save();


            foreach( $_SESSION['cart'] as $orderDetail )
            {
                if( !isset($orderDetail['performance_title'] ) )
                {
                    if( empty($orderDetail['date'] . $orderDetail['time']) )
                    {
                        $cart = serialize($_SESSION['cart']);
                        email_cart($cart);
                        // Redirect to Error Page
                        header('Location: /order-error');
                        exit();
                    }                        
                    $orderDetail['performance_title']  = strtotime( $orderDetail['date'] . ' ' . $orderDetail['time'] );
                }

                performanceFns::updateTicketsSold( $orderDetail['performance_title'], $orderId, $orderDetail['quantity'] );
                
                $order->add_product( wc_get_product( $orderDetail['product_id'] ), $orderDetail['quantity'] );
                $order->calculate_totals();
                $orderId = $order->save(); 
                
                // Add order_note to Order
                $order_note[] = [
                    'product_id'    => $orderDetail['product_id'],
                    'quantity'      => $orderDetail['quantity'],
                    'date'          => $orderDetail['date'],
                    'time'          => $orderDetail['time'],
                    'showTitle'     => $orderDetail['showTitle'],
                    'misha_custom_price'    => $orderDetail['misha_custom_price'],
                    'name'          => 'Season'
                ]; 
                set_order_note( $orderId, $order_note );

                $order->update_status( 'completed' );



                // // Send order confirmation email
                // $subject    = "Your United Players of Vancouver confirmation has been received!";
                // $body[]     = "Hi " . $email . ",";
                // $body[]     = "Just to let you know we've received your ticket confirmation for the " . $item['date'] . " performance of " . $item['showTitle'];

                // mail( $email, $subject, join("\n", $body));                
            }

            unset($_SESSION['cart']);

            ?>
            <p>Your order has been confirmed. You will be receive an email shortly.</p>
            <?php
        }
        else
        {
            ?>
            <form action="/confirm-order/" method="post" class="upv-form">
                <label>Name: <input type="text" name="userName" required/></label>
                <label>Phone number: <input type="phone" name="phone" required/></label>
                <label>Email: <input type="email" name="email" required/></label>
                <label>Seating requests:</label>
                <textarea name="notes" ></textarea>
                <input type="submit" class="button button--action" value="Confirm Order" name="confirm-order" />
            </form>
            <?php
        }
    }
    else 
    { 
        ?>
        <section class="shopping-cart max-wrapper__narrow">
            <h2>Tickets & Reservations</h2>
            <?php echo SiteFns::getPostByTitle('Shopping Cart Intro'); ?>
                <p>Your Shopping Cart is empty.</p>
                <a href="/" class="button button--information">Continue Shopping</a> 
        </section>
        <?php
    }
}

/**
 * https://www.reddit.com/r/PHP/comments/18j6k9/heres_a_function_to_reliably_validate_and_format/
 */
function valid_phone( $str, $international = false ) {
	$str = trim( $str );
	$str = preg_replace( '/\s+(#|x|ext(ension)?)\.?:?\s*(\d+)/', ' ext \3', $str );

	$us_number = preg_match( '/^(\+\s*)?((0{0,2}1{1,3}[^\d]+)?\(?\s*([2-9][0-9]{2})\s*[^\d]?\s*([2-9][0-9]{2})\s*[^\d]?\s*([\d]{4})){1}(\s*([[:alpha:]#][^\d]*\d.*))?$/', $str, $matches );

	if ( $us_number ) {
		return $matches[4] . '-' . $matches[5] . '-' . $matches[6] . ( !empty( $matches[8] ) ? ' ' . $matches[8] : '' );
	}

	if ( ! $international ) {
		/* SET ERROR: The field must be a valid U.S. phone number (e.g. 888-888-8888) */
		return false;
	}

	$valid_number = preg_match( '/^(\+\s*)?(?=([.,\s()-]*\d){8})([\d(][\d.,\s()-]*)([[:alpha:]#][^\d]*\d.*)?$/', $str, $matches ) && preg_match( '/\d{2}/', $str );

	if ( $valid_number ) {
		return trim( $matches[1] ) . trim( $matches[3] ) . ( !empty( $matches[4] ) ? ' ' . $matches[4] : '' );
	}

	/* SET ERROR: The field must be a valid phone number (e.g. 888-888-8888) */
	return false;
}