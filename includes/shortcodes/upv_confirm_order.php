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

            // User already exist
            $user = get_user_by( 'email', $email );
            if( !$user ) {
                // Create new user
                $user_data = [
                    'user_pass'     => wp_generate_password(),
                    'user_login'    => $email,
                    'user_email'    => $email,
                    'role'          => 'attendee'
                ];
                wp_insert_user($user_data);
                $user = get_user_by( 'email', $email );
            }

            foreach( $_SESSION['cart'] as $productId => $item )
            {
                $order          = new WC_Order( $email );
                $order->set_created_via( $email ); 
                $order->set_customer_id( $user->ID ); 
                
                $note           = htmlspecialchars( $_POST['notes'], ENT_QUOTES );
                $order->add_order_note( $note );

                $performance    = get_post_by_title( $item['date'], '', 'performance' );
                $tickets_sold   = get_post_meta($performance->ID,'tickets_sold', TRUE);
                if( empty($tickets_sold) )
                {
                    $tickets_sold	= [
                        'count'		=> 0
                    ];
                }                 
                $order->add_product( wc_get_product( $productId ), $item['quantity'] );
                $order->calculate_totals();
                $order->set_status( 'wc-completed' );
                $orderId = $order->save(); 
                $tickets_sold[$orderId][$productId] = $item['quantity'];
                $tickets_sold['count']  += $item['quantity'];
                update_post_meta( $performance->ID, 'tickets_sold', $tickets_sold );


                // Send order confirmation email
                $subject    = "Your United Players of Vancouver confirmation has been received!";
                $body[]     = "Hi " . $email . ",";
                $body[]     = "Just to let you know we've received your ticket confirmation for the " . $item['date'] . " performance of " . $item['showTitle'];

                mail( $email, $subject, join("\n", $body));                
            }

            unset($_SESSION['cart']);

        }
        else
        {
            ?>
            <form action="/confirm-order/" method="post" class="upv-form">
                <label>Name: <input type="text" name="userName" /></label>
                <label>Phone number: <input type="phone" name="phone" /></label>
                <label>Email: <input type="email" name="email" /></label>
                <label>Notes:</label>
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
            <?php echo get_post_by_title('Shopping Cart Intro'); ?>
                <p>Your Shopping Cart is empty.</p>
                <a href="/" class="button button--information">Continue Shopping</a> 
        </section>
        <?php
    }
}