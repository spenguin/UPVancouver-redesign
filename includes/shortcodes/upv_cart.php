<?php

/**
 * Render Cart for UPV
 */

function upv_cart()
{ 
    updateTicketOrder(); //pvd($_SESSION['ticketsOrdered']);
    //pvd($_POST);
    
    ob_start();
    ?>
        <section class="shopping-cart max-wrapper__narrow">
            <h2>Tickets & Reservations</h2>
            <?php echo get_post_by_title('Shopping Cart Intro'); ?>
            <?php if( empty($_SESSION['ticketsOrdered']) ): ?>
                <p>Your Shopping Cart is empty.</p>
            <?php else: ?>
                <table class="shopping-cart__table">
                    <thead>
                        <tr>
                            <td class="shopping-cart__tickets">Tickets</td>
                            <td class="shopping-cart__qty">Qty</td>
                            <td class="shopping-cart__price">Price</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $orderTotal = 0;
                            foreach($_SESSION['ticketsOrdered']  as $key => $t ) {
                                if( $t['quantity'] == 0 ) continue;
                                $showCharge = $t['quantity'] * $t['charge'];
                                $orderTotal += $showCharge;
                                ?>
                                <tr>
                                    <td>
                                        <div class="shopping-cart__delete"><a href="/cart?del=<?php echo $key; ?>" >X</a></div>
                                        <div>
                                            <?php echo $t['showTitle']; ?><br />
                                            <?php echo $t['date']  . ' '  . date("g:i a", strtotime($t['time'])); ?><br />
                                            <?php echo $t['name'] . ' &dollar;' . $t['charge']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $t['quantity']; ?>
                                    </td>
                                    <td>
                                        &dollar;<?php echo $showCharge; ?>
                                    </td>
                                </tr>
                        <?php    } ?>
                        <!-- <tr>
                            <td class="cart-total__label">Subtotal:</td>
                            <td>&nbsp;</td>
                            <td class="cart-total">&dollar;<?php echo $orderTotal; ?></td>
                        </tr> -->
                        <!-- <tr>
                            <td class="cart-total__label">&nbsp;</td>
                            <td>Would you like to make a <a href="/donate">Donation</a>?</td>
                            <td class="cart-total">
                                <form>
                                    <input type="text" name="donation">
                                    
                                </form>

                            </td>
                        </tr> -->
                        <tr>
                            <td class="cart-total__label">Total:</td>
                            <td>&nbsp;</td>
                            <td class="cart-total">&dollar;<?php echo $orderTotal; ?></td>
                        </tr>                        
                    </tbody>
                </table>
            <?php endif; ?>
            <div class="shopping-cart__buttons">
                <?php if( !empty($_SESSION['ticketsOrdered']) ): ?>
                    <a href="/checkout" class="button button--action">Proceed to Checkout</a>
                <?php endif; ?>
                <a href="/current-season" class="button button--information">Continue Shopping</a> 
            </div>
        </section>
    <?php
    $o = ob_get_clean();    
    // endif; 
    // wp_reset_query();

    return $o;
}

/**
 * Check Post data to update Session data
 */
function updateTicketOrder()
{
    if( isset( $_GET['del'] ) ) {
        unset($_SESSION['ticketsOrdered'][$_GET['del']]);
    }
    
    if( !empty($_POST) ) { 
        $ticketsOrdered = decodeTicketData($_POST['ticketData']); //die(pvd($ticketsOrdered));
        $selectedPerformanceId  = $_POST['selectedPerformance'];
        $selectedPerformance    = get_post($selectedPerformanceId); 
        // Get show that corresponds to the selected Date


        $performanceMeta    = get_post_meta($selectedPerformanceId); 
        $showTitle          = get_the_title($performanceMeta['show_id'][0]);

        // Let's just start with looping through the tickets ordered
        foreach( $ticketsOrdered as $t ) { 
            if( $t->quantity == 0 ) continue;
            // Does the performance/ticket type already exist?
            $found = FALSE;
            if( isset($_SESSION['ticketsOrdered'] ) ) {
                foreach( $_SESSION['ticketsOrdered'] as $key => $to )
                {
                    if( $to['date'] == $selectedPerformance->post_title && $to['ticketId'] == $t->ticketid ) {
                        $_SESSION['ticketsOrdered'][$key]['quantity'] = $t->quantity;
                        $found = TRUE;
                    }
                }
            }
            if( !$found ) {
                // if( $t->quantity > 0 ) {
                    $_SESSION['ticketsOrdered'][] = [
                        'date'      => $selectedPerformance->post_title,
                        'time'      => $performanceMeta['performance_time'][0],
                        'ticketId'  => $t->ticketid,
                        'name'      => $t->name,
                        'showTitle' => $showTitle,
                        'charge'    => $t->charge,
                        'quantity'  => $t->quantity
                    ];
                // }
            }
        }
    }
}

function decodeTicketData($performance)
{
    return json_decode( str_replace('\\"', '"', $_POST['ticketData']) ); 
}