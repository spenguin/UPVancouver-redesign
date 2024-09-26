<?php
/**
 * Commerce functions
 */


add_filter( 'woocommerce_checkout_redirect_empty_cart', '__return_false' );
add_filter( 'woocommerce_checkout_update_order_review_expired', '__return_false' );
add_action( 'woocommerce_before_cart', 'upv_add_donation_form', 5 );
add_action( 'woocommerce_before_calculate_totals', 'rudr_custom_price_refresh' );
add_action( 'woocommerce_before_checkout_form', 'upv_add_donation_form', 5 );
add_action( 'woocommerce_before_checkout_form', 'upv_session_cart_to_wc_cart', 5 ); 
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review');
add_action( 'woocommerce_before_checkout_form', 'woocommerce_order_review', 10 );
add_action( 'woocommerce_before_checkout_form', 'upv_redirect_button', 15 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form' );
add_action( 'woocommerce_after_order_notes', 'custom_checkout_field' );
add_action('woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta');
add_action( 'init', 'misha_register_pay_at_box_office_status' );
add_filter( 'wc_order_statuses', 'misha_add_status_to_list' );


function upv_add_donation_form()
{ 
    if( !isset($_SESSION['donation']) ) {
        get_template_part('template-parts/donation-form');
    }
}

function upv_session_cart_to_wc_cart()
{
    if( !empty($_SESSION['cart'] ) ) {
        WC()->cart->empty_cart();
        foreach($_SESSION['cart'] as $productId => $productData )
        {
            WC()->cart->add_to_cart($productId, $productData['quantity'], 0, [], ['misha_custom_price' => $productData['misha_custom_price']] );
        }
    }
}

function upv_redirect_button()
{
    ?>
    <div class="cta--wrapper"><a class="button button--special" href="/cart">Return to Shopping Cart</a></div>
    <?php
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
 


// add_action('woocommerce_before_cart', 'upv_read_order', 5 );


/**
 * Generate the Shopping Cart image with product count
 */
function renderShoppingCartLogo()
{   
    $count = count($_SESSION['cart']); //pvd($count);
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

/**
* Add a custom field to the checkout page
* From https://funnelkit.com/add-a-field-to-checkout-woocommerce/
*/
function custom_checkout_field($checkout)
{ 
    // echo '<div id="custom_checkout_field"><h3>' . __('Please Provide The Custom Data') . '</h3>';
    woocommerce_form_field('custom_field_name', array(

    'type' => 'hidden',
        'required' => 'true',

    // 'class' => array(

    // 'my-field-class form-row-wide'

    // ) ,

    // 'label' => __('Custom Field') ,

    // 'placeholder' => __('Enter Custom Data') ,

    // 'value' => serialize($_SESSION['cart'])

    ) 			   ,

    serialize($_SESSION['cart']));
    // $checkout->get_value('custom_field_name'));

    // echo '</div>';

}

/**
* Update the value given in custom field
* From https://funnelkit.com/add-a-field-to-checkout-woocommerce/
*/
function custom_checkout_field_update_order_meta($order_id)
{
    if (!empty($_POST['custom_field_name'])) {
        update_post_meta($order_id, 'custom_field_name',sanitize_text_field($_POST['custom_field_name']));
    }
}


/*
 * Register a custom order status
 *
 * @author Misha Rudrastyh
 * @url https://rudrastyh.com/woocommerce/order-statuses.html
 */


function misha_register_pay_at_box_office_status() {

	register_post_status(
		'wc-misha-pay-at-box-office',
		array(
			'label'		=> 'Pay at Box Office',
			'public'	=> true,
			'show_in_admin_status_list' => true,
			// 'label_count'	=> _n_noop( 'Awaiting shipping (%s)', 'Awaiting shipping (%s)' )
		)
	);

}

// Add registered status to list of WC Order statuses

function misha_add_status_to_list( $order_statuses ) {

	$order_statuses[ 'wc-misha-pay-at-box-office' ] = 'Pay at Box Office';
	return $order_statuses;

}