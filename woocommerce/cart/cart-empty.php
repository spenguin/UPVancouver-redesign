<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>

    <section class="shopping-cart max-wrapper__narrow">
        <h2>Tickets & Reservationstest</h2>
        <?php echo get_post_by_title('Shopping Cart Intro'); ?>
        <!-- <?php //if( count(WC()->cart->cart_contents ) == 0): ?> -->
             <p>Your Shopping Cart is empty.</p>
             <a href="/" class="button button--information">Continue Shopping</a> 
    </section>
<?php endif; ?>
