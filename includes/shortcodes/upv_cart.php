<?php

/**
 * Render Cart for UPV
 */

function upv_cart()
{ 
    if( isset($_POST['ticketData'] ) && ($_POST['ticketData'] != "null" ) ) 
    { //pvd($_POST);
        $ticketsOrdered = decodeTicketData($_POST['ticketData']); 
        $selectedPerformanceTitle  = $_POST['selectedPerformance']; 
        $isTicketSpecialAvailable   = FALSE;
        if( empty($selectedPerformanceTitle) )
        {
            $showTitle  = "Seasons Ticket";
            $showTime   = ""; 
            $performanceDate = "";
            $performanceTime = "";
            // Test for promo
            $isTicketSpecialAvailable   = ticketFns::isTicketSpecialAvailable(); 
            $seasonTicketsOrdered       = [];

        } else {
            $selectedPerformance    = siteFns::getPostByTitle($selectedPerformanceTitle);
            $performanceDate        = date( 'd M Y', (int) $selectedPerformanceTitle );
            $performanceTime        = date( 'h:i a', (int) $selectedPerformanceTitle );
            $showTitle              = performanceFns::getShowTitleByPerformanceDate($selectedPerformanceTitle);
        }

        $seasonTicketsOrdered   = [];
        foreach( $ticketsOrdered as $t ) 
        { 
            if( $t->quantity == 0 ) continue;
            $args  = [
                'product_id'=> $t->ticketid,
                'quantity'  => $t->quantity,
                'performance_title' => $selectedPerformanceTitle,
                'date'      => $performanceDate,
                'time'      => $performanceTime,
                'showTitle' => $showTitle,  
                'misha_custom_price' => $t->charge,
                'name'      => $t->name
            ];
            
            if( $isTicketSpecialAvailable )
            {
                $array                  = array_fill( 0, $t->quantity, $t->charge );
                $seasonTicketsOrdered   = array_merge( $seasonTicketsOrdered, $array );
            }
            $_SESSION['cart'][] = $args;
        }
        if( count( $seasonTicketsOrdered ) >= 3 )   // If there are fewer than three tickets ordered, the promo doesn't apply anyway
        {
            rsort($seasonTicketsOrdered);
            $discountTotal = 0;
            foreach( $seasonTicketsOrdered as $k => $s )
            {
                if( ($k+1)%3 == 0 )
                {
                    $discountTotal += $s/2;
                }
            }
            $_SESSION['cart']['promoDiscount'] = [
                'product_id'            => getPromoProduct(),
                'showTitle'             => 'Promotional Discount',
                'quantity'              => 1,
                'misha_custom_price'    => -1 * $discountTotal,
                'name'                  => 'Promotional Discount'
            ];
        } 
        
    }

    if( isset($_POST['donation']) ){
        // Do something with the donation
        $donationProductId  = getDonationProduct(); 
        $_SESSION['cart'][$donationProductId] = [
            'product_id'    => $donationProductId,
            'quantity'      => 1,
            'misha_custom_price'    => $_POST['donation'],
            'name'          => 'Donation'
        ];
    }

    if( isset($_GET['del']) ){
        // Remove item from cart
        unset($_SESSION['cart'][$_GET['del']]);
    }
    ?>
    <section class="shopping-cart max-wrapper__narrow">
        <h2>Tickets & Reservations</h2>
        <?php echo siteFns::getPostByTitle('Shopping Cart Intro'); ?>
        <?php if( empty($_SESSION['cart']) ): ?>
            <p>Your Shopping Cart is empty.</p>
        <?php else: ?>
            <table class="shopping-cart__table">
                <?php get_template_part('template-parts/donation-form'); ?>
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
                        foreach($_SESSION['cart']  as $key => $args ) { //pvd($args);
                            if( $args['quantity'] == 0 ) continue;
                            $showCharge = $args['quantity'] * $args['misha_custom_price'];
                            $orderTotal += $showCharge;
                            ?>
                            <tr>
                                <td>
                                    <?php //if( $args['name'] != 'Promotional Discount' ): ?>
                                        <div class="shopping-cart__delete"><a href="/cart?del=<?php echo $key; ?>" >X</a></div>
                                    <?php //endif; ?>
                                    <div>
                                        <?php if( $args['name'] != 'Donation' ): ?>
                                            <?php echo $args['showTitle']; ?><br />
                                            <?php 
                                                if( isset($args['showTitle']) && $args['showTitle'] != 'Seasons Ticket' && $args['showTitle'] != 'Promotional Discount')
                                                {
                                                    echo $args['date']  . ' '  . date("g:i a", strtotime($args['time'])) . '<br />';
                                                } ?>
                                        <?php endif; ?>
                                        <?php echo $args['name']; ?><?php echo ($args['misha_custom_price'] < 0 ) ? '(&dollar;' . abs($args['misha_custom_price']) . ')' : ' &dollar;' . $args['misha_custom_price']; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php echo $args['quantity']; ?>
                                </td>
                                <td>
                                    <?php echo $showCharge < 0 ? '(&dollar;' . abs($showCharge) . ')' : '&dollar;' . $showCharge; ?>
                                </td>
                            </tr>
                    <?php    } ?>
                    <tr>
                        <td class="cart-total__label">Total:</td>
                        <td>&nbsp;</td>
                        <td class="cart-total">&dollar;<?php echo $orderTotal; ?></td>
                    </tr>                        
                </tbody>
            </table>
        <?php endif; ?>
        <div class="shopping-cart__buttons">
            <?php if( !empty($_SESSION['cart']) ): 
                if( $orderTotal > 0 ): ?>
                    <a href="<?php echo site_url(); ?>/checkout" class="button button--action">Proceed to Checkout</a>
                <?php else: ?>
                    <a href="<?php echo site_url(); ?>/confirm-order" class="button button--action">Confirm Order</a>                
                <?php endif; ?>
            <?php endif; ?>
            <a href="<?php echo site_url(); ?>" class="button button--information">Continue Shopping</a> 
        </div>
    </section>
<?php
   
}