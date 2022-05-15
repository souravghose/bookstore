<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

    <?php do_action( 'woocommerce_before_cart_totals' ); ?>

    <table cellspacing="0" class="cart-totals__table shop_table shop_table_responsive d-block border border-gray-900 bg-white mb-5">

        <tbody class="p-4d875 border-bottom d-block cart-totals__body">

            <tr class="mb-4 d-block">
                <td colspan="2" class="d-block p-0">
                    <h2 class="cart-title mb-0 font-weight-medium font-size-3"><?php esc_html_e( 'Cart Totals', 'bookworm' ); ?></h2>
                </td>
            </tr>

            <tr class="cart-subtotal d-flex justify-content-between">
                <th><?php esc_html_e( 'Subtotal', 'bookworm' ); ?></th>
                <td data-title="<?php esc_attr_e( 'Subtotal', 'bookworm' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></td>
            </tr>

            <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                <tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?> d-flex justify-content-between">
                    <th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
                    <td data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>" class="position-relative"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
                </tr>
            <?php endforeach; ?>

            <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                <tr class="fee d-flex justify-content-between">
                    <th><?php echo esc_html( $fee->name ); ?></th>
                    <td data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></td>
                </tr>
            <?php endforeach; ?>

            <?php
            if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
                $taxable_address = WC()->customer->get_taxable_address();
                $estimated_text  = '';

                if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
                    /* translators: %s location. */
                    $estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'bookworm' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
                }

                if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
                    foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
                        ?>
                        <tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?> d-flex justify-content-between">
                            <th><?php echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
                            <td data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr class="tax-total d-flex justify-content-between">
                        <th><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
                        <td data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
                    </tr>
                    <?php
                }
            }
            ?>

            <?php if ( apply_filters( 'bookworm_show_shipping_in_cart_totals', true ) && WC()->cart->needs_shipping() && WC()->cart->show_shipping() && WC()->cart->get_shipping_total() > 0 ) : ?>

                <tr class="d-flex justify-content-between">
                    <th><?php esc_html_e( 'Shipping', 'bookworm' ); ?></th>
                    <td><?php echo wc_price( WC()->cart->get_shipping_total() ); ?></td>
                </tr>

            <?php endif; ?>

        </tbody>

        <?php if ( WC()->cart->needs_shipping() ) : ?>

        <tbody class="p-4d875 border-bottom d-block">

            <tr class="mb-4 d-block">
                <td colspan="2" class="d-block p-0">
                    <h2 class="cart-title mb-0 font-weight-medium font-size-3"><?php esc_html_e( 'Shipping', 'bookworm' ); ?></h2>
                </td>
            </tr>

            <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

                <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

                <?php wc_cart_totals_shipping_html(); ?>

                <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

            <?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

                <tr class="shipping d-flex justify-content-between">
                    <th class="sr-only"><?php esc_html_e( 'Shipping', 'bookworm' ); ?></th>
                    <td data-title="<?php esc_attr_e( 'Shipping', 'bookworm' ); ?>"><?php woocommerce_shipping_calculator(); ?></td>
                </tr>

            <?php endif; ?>

        </tbody>

        <?php endif; ?>

        <?php if ( apply_filters( 'bookworm_show_coupon_cart_totals', true ) && wc_coupons_enabled() ) { ?>
        <tbody class="p-4d875 border-bottom d-block">
            <tr class="d-block">
                <td id="coupon_heading" colspan="2" class="cart-head d-block p-0">
                    <a class="d-flex align-items-center justify-content-between text-dark" href="#" data-toggle="collapse" aria-expanded="false" data-target="#coupon_class" aria-controls="#coupon_class">
                        <h2 class="cart-title mb-0 font-weight-medium font-size-3"><?php esc_html_e( 'Coupon', 'bookworm' ); ?></h2>
                        <?php bookworm_collapse_toggler(); ?>
                    </a>
                </td>
            </tr>
            <tr class="coupon-collapse d-block">
                <td class="d-block p-0">
                    <div id="coupon_class" class="mt-4 cart-content collapse" aria-labelledby="coupon_heading">
                        <form method="POST">
                            <div class="coupon">
                                <label for="coupon_code"><?php esc_html_e( 'Coupon:', 'bookworm' ); ?></label>
                                <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'bookworm' ); ?>" />
                                <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'bookworm' ); ?>" />
                                <?php do_action( 'woocommerce_cart_coupon' ); ?>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
        </tbody>
        <?php } ?>

        <tfoot class="p-4d875 border-bottom d-block">
            <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

            <tr class="order-total d-flex justify-content-between">
                <th class="mb-0 font-weight-medium font-size-3"><?php esc_html_e( 'Total', 'bookworm' ); ?></th>
                <td data-title="<?php esc_attr_e( 'Total', 'bookworm' ); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
            </tr>

            <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
        </tfoot>

    </table>

    <div class="wc-proceed-to-checkout">
        <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
    </div>

    <?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
