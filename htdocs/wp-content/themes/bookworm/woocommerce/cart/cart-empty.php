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
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="d-flex flex-column align-items-center pt-lg-7 pb-lg-4 pb-lg-6">
    <?php
    /*
     * @hooked wc_empty_cart_message - 10
     */
    do_action( 'woocommerce_cart_is_empty' );

    if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
        <p class="return-to-shop d-flex align-items-center flex-column m-0">
            <a class="button wc-backward btn btn-dark rounded-0 btn-wide height-60 width-250 font-weight-medium d-flex align-items-center justify-content-center" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
                <?php esc_html_e( 'Return to shop', 'bookworm' ); ?>
            </a>
        </p>
    <?php endif; ?>
</div>
