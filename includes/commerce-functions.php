<?php
/**
 * Commerce functions
 */


add_filter( 'woocommerce_checkout_redirect_empty_cart', '__return_false' );
add_filter( 'woocommerce_checkout_update_order_review_expired', '__return_false' );
 
// add_action( 'woocommerce_before_checkout_form', '\Core\upv_write_order_to_WC' );
 
// function upv_write_order_to_WC()
// {
// 	echo '<p>Write Order</p>';
// }
 
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review');
add_action( 'woocommerce_before_checkout_form', 'woocommerce_order_review', 10 );


/**
 * Generate the Shopping Cart image with product count
 */
function renderShoppingCartLogo()
{
    return '<a href="/cart" class="nav nav--icon nav__shopping"><i class="fas fa-shopping-cart"></i></a>';
}