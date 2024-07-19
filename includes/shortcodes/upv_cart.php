<?php

/**
 * Render Cart for UPV
 */

function upv_cart()
{ 
    ob_start();
        if( isset($_POST['ticketData'] ) ) {
            $ticketsOrdered = decodeTicketData($_POST['ticketData']); //die(pvd($ticketsOrdered));
        $selectedPerformanceId  = $_POST['selectedPerformance'];
        $selectedPerformance    = get_post($selectedPerformanceId); 
        // Get show that corresponds to the selected Date
        $performanceMeta        = get_post_meta($selectedPerformanceId); 
        $showTitle              = get_the_title($performanceMeta['show_id'][0]);            
            foreach( $ticketsOrdered as $t ) 
            {
                if( $t->quantity == 0 ) continue;
                $varations  = [
                    'date'      => $selectedPerformance->post_title,
                    'time'      => $performanceMeta['performance_time'][0],
                    'showTitle' => $showTitle,  
                    'misha_custom_price' => $t->charge
                ];
                WC()->cart->add_to_cart( $t->ticketid, $t->quantity, 0, [], $varations );
            }
        }
        if( isset($_POST['donation']) ){
            // Do something with the donation
            $donationProductId  = getDonationProduct(); 
            WC()->cart->add_to_cart($donationProductId, 1, 0, [], ['misha_custom_price' => $_POST['donation']] );
        }
        // die(pvd(WC()->cart));
        // echo do_shortcode('[woocommerce_cart]');
        ?>
        <section class="shopping-cart max-wrapper__narrow">
            <h2>Tickets & Reservations</h2>
            <?php echo get_post_by_title('Shopping Cart Intro'); ?>
            <?php if( count(WC()->cart->cart_contents ) == 0): ?>
                <p>Your Shopping Cart is empty.</p>
                <a href="/current-season" class="button button--information">Continue Shopping</a> 
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
                            // $orderTotal = 0; 
                            // foreach($_SESSION['ticketsOrdered']  as $key => $t ) {
                            foreach( WC()->cart->cart_contents as $item ) { //die(pvd($item));
                                if( $item['quantity'] == 0 ) continue;
                                $product = wc_get_product( $item['product_id'] ); 

                                // $showCharge = $t['quantity'] * $t['price'];
                                // $orderTotal += $showCharge;
                                ?>
                                <tr>
                                    <td>
                                        <div class="shopping-cart__delete"><a href="/cart?del=<?php echo $key; ?>" >X</a></div>
                                        <div>
                                            <?php echo $item['showTitle']; ?><br />
                                            <?php echo $item['date']  . ' '  . date("g:i a", strtotime($item['time'])); ?><br />
                                            <?php echo $product->get_name() . ' &dollar;' . $item['misha_custom_price']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $item['quantity']; ?>
                                    </td>
                                    <td>
                                        &dollar;<?php echo $item['line_total']; ?>
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
                            <td class="cart-total">&dollar;<?php echo WC()->cart->cart_contents_total; ?></td>
                        </tr>                        
                    </tbody>
                </table> 
                <div class="shopping-cart__buttons">
                    <?php if( count(WC()->cart->cart_contents ) > 0 ): ?>
                        <a href="/checkout" class="button button--action">Proceed to Checkout</a>
                    <?php endif; ?>
                    <a href="/current-season" class="button button--information">Continue Shopping</a> 
            </div>               
            <?php endif; ?>

        </section>
        <?php
    return ob_get_clean();
}