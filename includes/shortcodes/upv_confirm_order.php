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
            // User already exist
            $user = get_user_by( 'email', $_POST['email'] );
            if( !$user ) {
                // Create new user
                $user_data = [
                    'user_pass'     => wp_generate_password(),
                    'user_login'    => $_POST['email'],
                    'user_email'    => $_POST['email'],
                    'role'          => 'attendee'
                ];
                wp_insert_user($user_data);
                $user = get_user_by( 'email', $user_data['user_email'] );
            }
            // foreach( WC()->cart->cart_contents as $key => $item ) {
            $orderId    = 'u_' . $user->ID . time();
            $date       = '';
            foreach($_SESSION['cart'] as $productId => $item )
            {
                if( $date != $item['date'] )
                {
                    $performance    = get_post_by_title( $item['date'], '', 'performance' );
                    $date           = $item['date'];
                    $tickets_sold   = get_post_meta($performance->ID,'tickets_sold', TRUE);
                    $showTitle      = $item['showTitle'];
                }
                if( empty($tickets_sold) )
                {
                    $tickets_sold	= [
                        'count'		=> 0
                    ];
                }
                $tickets_sold[$orderId][$item['name']] = $item['quantity'];
                $tickets_sold['count'] += $item['quantity'];
                update_post_meta( $performance->ID, 'tickets_sold', $tickets_sold );
            }
            echo '<p>Order confirmed.</p>';

            // Send order confirmation email
            $subject    = "Your United Players of Vancouver confirmation has been received!";
            $body[]     = "Hi " . $_POST['userName'] . ",";
            $body[]     = "Just to let you know we've received your ticket confirmation for the " . $date . " performance of " . $showTitle;

            $to         = $_POST['email'];
            mail( $to, $subject, join("\n", $body));
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