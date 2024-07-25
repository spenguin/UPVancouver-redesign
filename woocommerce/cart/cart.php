<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<section class="shopping-cart max-wrapper__narrow">
    <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
        <?php do_action( 'woocommerce_before_cart_table' ); ?>

        <?php // Completely modified cart table, as per Susan's design ?>

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
                    foreach( WC()->cart->cart_contents as $key => $item ) { //die(pvd($item));
                        if( $item['quantity'] == 0 ) continue;
                        $product        = wc_get_product( $item['product_id'] ); 
                        $productName    = $product->get_name();
                ?>
                        <tr>
                            <td>
                                <div class="shopping-cart__delete"><a href="/cart?del=<?php echo $key; ?>" >X</a></div>
                                <div>
                                    <?php if( $productName != "Donation"): ?>
                                        <?php echo isset($item['showTitle']) ? $item['showTitle'] : ''; ?><br />
                                        <?php echo isset($item['date']) ? $item['date']  . ' '  . date("g:i a", strtotime($item['time'])) : ''; ?><br />
                                    <?php endif; ?>
                                    <?php echo $productName . ' &dollar;' . $item['misha_custom_price']; ?>
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

                <tr>
                    <td class="cart-total__label">Total:</td>
                    <td>&nbsp;</td>
                    <td class="cart-total">&dollar;<?php echo WC()->cart->cart_contents_total; ?></td>
                </tr>                        
            </tbody>
        </table> 



        <?php // End modified cart table ?>

	    <?php do_action( 'woocommerce_after_cart_table' ); ?>
    </form>

    <?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

    <div class="shopping-cart__buttons">
        <?php if( WC()->cart->cart_contents_total > 0 ): ?>
            <a href="/checkout" class="button button--action">Proceed to Checkout</a>
        <?php else: ?>
            <a href="/confirm-order" class="button button--action">Proceed to Order Confirmation</a>
        <?php endif; ?>
        <a href="/current-season" class="button button--information">Continue Shopping</a> 
    </div>   

    <!-- <div class="cart-collaterals">
	    <?php
            /**
             * Cart collaterals hook.
             *
             * @hooked woocommerce_cross_sell_display
             * @hooked woocommerce_cart_totals - 10
             */
            //do_action( 'woocommerce_cart_collaterals' );
        ?>
    </div> -->

    <?php do_action( 'woocommerce_after_cart' ); ?>
</section>
