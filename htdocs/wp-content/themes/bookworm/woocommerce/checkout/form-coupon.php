<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
    return;
}

?>
<div class="woocommerce-form-coupon-toggle mb-4">
    <?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'bookworm' ) . ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', 'bookworm' ) . '</a>' ), 'info' ); ?>
</div>

<form class="checkout_coupon woocommerce-form-coupon p-4 bg-white border mb-4" method="post" style="display:none">

    <p><?php esc_html_e( 'If you have a coupon code, please apply it below.', 'bookworm' ); ?></p>

    <div class="row d-flex">
        <p class="col-md-4 mb-3 mb-md-0">
            <input type="text" name="coupon_code" class="input-text form-control" placeholder="<?php esc_attr_e( 'Coupon code', 'bookworm' ); ?>" id="coupon_code" value="" />
        </p>
        <p class="col-md-3">
            <button type="submit" class="button border-0 height-4 btn btn-dark rounded-0" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'bookworm' ); ?>"><?php esc_html_e( 'Apply coupon', 'bookworm' ); ?></button>
        </p>
    </div>
</form>
