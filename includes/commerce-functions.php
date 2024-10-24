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