<?php
/**
 * Confirm Order where order is only season ticket subscription applied to a specific performance
 */

function upv_confirm_order()
{   pvd(WC()->cart->cart_contents);
    if( WC()->cart->get_cart_contents_count() > 0 ) 
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
            foreach( WC()->cart->cart_contents as $key => $item ) {
                $performance = get_post_by_title( $item['date'], '', 'performance' ); 
                $ticketsSold = get_metadata('performance', $performance->ID,'tickets_sold', TRUE); 
                $ticketsSold = unserialize($ticketsSold); 
                if( empty($ticketsSold ) ) 
                {
                    $ticketsSold = [];
                    $ticketsSold[$performance->ID]  = $item['quantity']; //pvd($ticketsSold);
                }
                else 
                {
                    $ticketPurchasers   = array_keys($ticketsSold); pvd($ticketPurchasers);
                    // Need to complete this
                    if( in_array( $performance->ID, $ticketPurchasers) )
                    {
                        $ticketsSold[$performance->ID] += $item['quantity'];
                    }
                    else
                    {
                        $ticketsSold[$performance->ID]  = $item['quantity'];
                    }
                }
                update_post_meta($performance->ID, 'tickets_sold', serialize($ticketsSold) );

                // Need to send email

            }
            WC()->cart->empty_cart(); pvd(WC()->cart);
        }
        else
        {
            ?>
            <form action="/confirm-order" method="post">
                <label>Name: <input type="text" name="name" /></label>
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
            <!-- <?php //if( count(WC()->cart->cart_contents ) == 0): ?> -->
                <p>Your Shopping Cart is empty.</p>
                <a href="/" class="button button--information">Continue Shopping</a> 
        </section>
        <?php
    }
}