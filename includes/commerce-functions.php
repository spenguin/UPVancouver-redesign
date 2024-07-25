<?php
/**
 * Commerce functions
 */


add_filter( 'woocommerce_checkout_redirect_empty_cart', '__return_false' );
add_filter( 'woocommerce_checkout_update_order_review_expired', '__return_false' );
add_action( 'woocommerce_before_cart', 'upv_add_donation_form', 5 );
add_action( 'woocommerce_before_calculate_totals', 'rudr_custom_price_refresh' );



function upv_add_donation_form()
{ 
    if( !isset($_SESSION['donation']) ) {
        get_template_part('template-parts/donation-form');
    }
}

function getDonationProduct()
{
    $args   = [
        'post_type'         => 'product',
        'title'             => 'Donation',
        'posts_per_page'    => 1
    ];

    $query = new WP_Query($args); 
    if( $query->have_posts()): $query->the_post();
        return get_the_ID();
    endif;
    return NULL;
}

/**
 * Override product price on the fly
 * Based on: https://rudrastyh.com/woocommerce/add-product-to-cart-programmatically.html
 */
function rudr_custom_price_refresh( $cart_object ) {

	foreach ( $cart_object->get_cart() as $item ) {

		if( array_key_exists( 'misha_custom_price', $item ) ) {
			$item[ 'data' ]->set_price( $item[ 'misha_custom_price' ] );
		}
	}
}
 
// add_action( 'woocommerce_before_checkout_form', '\Core\upv_write_order_to_WC' );
 
// function upv_write_order_to_WC()
// {
// 	echo '<p>Write Order</p>';
// }
 
// remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review');
// add_action( 'woocommerce_before_checkout_form', 'woocommerce_order_review', 10 );

// add_action('woocommerce_before_cart', 'upv_read_order', 5 );


/**
 * Generate the Shopping Cart image with product count
 */
function renderShoppingCartLogo()
{   
    $count = WC()->cart->get_cart_contents_count(); //pvd($count);
    ob_start(); ?>
        <a href="/cart" class="nav nav--icon nav__shopping"><i class="fas fa-shopping-cart">
            <?php if($count > 0 ): ?>
                <span>&check;</span>
            <?php endif; ?>
        </i></a>
    <?php return ob_get_clean();
}

// font-size: 0.85rem;
//   position: absolute;
//   left: 30%;
//   color: white;
//   top: 15%;
//   background: red;
//   padding: 0.25rem;
//   border-radius: 50%;


function upv_read_order()
{ die('test');
    // updateTicketOrder();
    // die(pvd($_SESSION));
    $ticketsOrdered = decodeTicketData($_POST['ticketData']); die(pvd($ticketsOrdered));
    foreach( $ticketsOrdered as $t ) 
    {
        if( $t->quantity == 0 ) continue;
        WC()->cart->add_to_cart( $t->ticketid, $t->quantity );
    }

}


/**
 * Check Post data to update Session data
 */
function updateTicketOrder()
{
    // if( isset( $_GET['del'] ) ) {
    //     unset($_SESSION['ticketsOrdered'][$_GET['del']]);
    // }

    if( !empty($_POST) ) { 
        $ticketsOrdered = decodeTicketData($_POST['ticketData']); //die(pvd($ticketsOrdered));
        $selectedPerformanceId  = $_POST['selectedPerformance']; 
        if( empty($selectedPerformanceId) ) {
            $showTitle      = '';
            $showDate       = '';
            $showTime       = '';
        } else {
            $selectedPerformance    = get_post($selectedPerformanceId); 
            // Get show that corresponds to the selected Date
            $performanceMeta    = get_post_meta($selectedPerformanceId); 
            $showTitle          = get_the_title($performanceMeta['show_id'][0]);
            $showDate           = $selectedPerformance->post_title;
            $showTime           = $performanceMeta['performance_time'][0];
        }


        // Let's just start with looping through the tickets ordered
        foreach( $ticketsOrdered as $t ) { 
            if( $t->quantity == 0 ) continue;
            // Does the performance/ticket type already exist?
            $found = FALSE;
            if( isset($_SESSION['ticketsOrdered'] ) ) {
                foreach( $_SESSION['ticketsOrdered'] as $key => $to )
                {
                    if( empty($selectedPerformanceId) ) {
                        if( $to['ticketId'] == $t->ticketid ) {
                            $_SESSION['ticketsOrdered'][$key]['quantity'] = $t->quantity;
                            $found = TRUE;
                        }
                    } else {
                        if( $to['date'] == $selectedPerformance->post_title && $to['ticketId'] == $t->ticketid ) {
                            $_SESSION['ticketsOrdered'][$key]['quantity'] = $t->quantity;
                            $found = TRUE;
                        }
                    }
                }
            }
            if( !$found ) {
                // if( $t->quantity > 0 ) {
                    $_SESSION['ticketsOrdered'][] = [
                        'date'      => $showDate,
                        'time'      => $showTime,
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

// function 