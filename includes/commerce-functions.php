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
// add_action( 'woocommerce_email_order_meta', 'add_invoice_notes', 15 );
add_filter( 'woocommerce_checkout_fields', 'md_custom_woocommerce_checkout_fields' );



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
        foreach($_SESSION['cart'] as $productData )
        {
            WC()->cart->add_to_cart($productData['product_id'], $productData['quantity'], 0, [], ['misha_custom_price' => $productData['misha_custom_price']] );
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
    wp_reset_postdata();
}

function getPromoProduct()
{
        $args   = [
        'post_type'         => 'product',
        'title'             => 'Promotional Discount',
        'posts_per_page'    => 1
    ];

    $query = new WP_Query($args); 
    if( $query->have_posts()): $query->the_post();
        return get_the_ID();
    endif;
    return NULL;
    wp_reset_postdata();
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
    woocommerce_form_field('custom_field_name', array(

    'type' => 'hidden',
        'required' => 'true',

    ) 			   ,

    base64_encode( serialize($_SESSION['cart'])) );
}

/**
* Update the value given in custom field
* From https://funnelkit.com/add-a-field-to-checkout-woocommerce/
*/
function custom_checkout_field_update_order_meta($order_id)
{
    if (!empty($_POST['custom_field_name'])) {
        update_post_meta($order_id, 'custom_field_name',sanitize_text_field($_POST['custom_field_name']));
        // update_post_meta($order_id, 'custom_field_name',$_POST['custom_field_name']);
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
		)
	);

}

// Add registered status to list of WC Order statuses

function misha_add_status_to_list( $order_statuses ) {

	$order_statuses[ 'wc-misha-pay-at-box-office' ] = 'Pay at Box Office';
	return $order_statuses;
}

/**
 * Add Notes to Customer Invoice
 */
function add_invoice_notes()
{
    $notes = get_post_by_title('Order notes');
    return $notes;
}

/**
 * Render both the notes at the top of the email,
 * and the details of the order
 */
function render_order_details($notes)
{
    $products_ordered   = [];
    $orderTotal         = 0;
    $amendedStr         = '';
    ob_start();
    foreach( $notes as $key => $args )
    { 
        if( $key == 'amended' )
        {
            $amendedStr = $key ? 'This is an amended order. You have not been charged again.<br />' : '';
            continue;
        }
        if( $key == 'boxoffice' ) continue;
        if( $key == "customer_contact" ) continue;
        if( $args['quantity'] == 0 ) continue;
        $showCharge = $args['quantity'] * $args['misha_custom_price'];
        $orderTotal += $showCharge;
        ?>
        <tr>
            <td>
                <?php if( $args['name'] != 'Donation' ): ?>
                    <?php echo $args['showTitle']; ?><br />
                    <?php 
                        if( $args['showTitle'] != 'Seasons Ticket' && $args['showTitle'] != 'Promotional Discount' )
                        {
                            $products_ordered[] = ( 0 == $args['misha_custom_price'] ) ? "Subscriber" : "Show";
                            echo $args['date']  . ' '  . date("g:i a", strtotime($args['time'])) . '<br />';
                        } else {
                            $products_ordered[] = "Season";
                        }
                        
                        ?>
                <?php else:
                    $products_ordered[] = "Donation";
                endif; ?>
                <?php echo $args['name'] . ($args['misha_custom_price'] < 0 ) ? '($' . abs($args['misha_custom_price']) . ')' : ' $' . $args['misha_custom_price']; ?>
            </td>
            <td>
                <?php echo $args['quantity']; ?>
            </td>
            <td>
                <?php echo $showCharge < 0 ? '($' . abs($showCharge) . ')' : '$' . $showCharge; ?>
            </td>
        </tr>   
        <?php     
    }
    $o['table'] = ob_get_clean();
    str_replace( "$", "$", $o['table'] ); 
    $products_ordered = array_unique($products_ordered); 

    if( in_array( "Show", $products_ordered ) )
    {
        $opening    = "Thank you for your purchase of ";
    } elseif( in_array( "Season", $products_ordered ) ) 
    {
        $opening    = "Thank you for your purchase of ";
    }
    else 
    {
        $opening    = "Thank you for ";
    }


    if( in_array('Season', $products_ordered ) )
    {
        $order_str[] = "season ticket package(s)";
        $second_str[]= "your season vouchers will be mailed out shortly";
    } 
    if( in_array('Subscriber', $products_ordered ) )
    {
        $order_str[] = "your season subscriber reservation(s)";
        $second_str[]= "your tickets will be held for you at the box office under your last name";
    } 
    if( in_array('Show', $products_ordered ) )
    {
        $order_str[] = "your ticket purchase(s)";
        $second_str[]= "your tickets will be held for you at the box office under your last name";
    } 
    if( in_array('Donation', $products_ordered ) )
    {
        $order_str[] = "your generous donation";
        $second_str[]= "a tax receipt will be mailed to you in the next few days.";
    } 
    

    $last           = array_pop($order_str)  . '.<br><br>';
    $second_str     = array_unique($second_str);
    $second_last    = array_pop( $second_str );
    $order_str      = $amendedStr . $opening . ( empty($order_str) ? "" : join( ', ', $order_str ) . " and " ) . $last;
    $order_str      .= "Your order is being processed: " .  ( empty($second_str) ? "" : join( ', ', $second_str ) . " and " ) . $second_last;

    if ( array_key_exists('boxoffice', $notes ) )
    {
        $order_str .= "<br>Your ticket order will be held at the Box Office for you to pay on the night";
    }

    // $order_str      .= $last;
    $o['order_str'] = $order_str;

    return $o;
}

function md_custom_woocommerce_checkout_fields( $fields ) 
{
    // $fields['order']['order_comments']['placeholder'] = 'Special notes';
    $fields['order']['order_comments']['label'] = 'Seating requests:';

    return $fields;
}
