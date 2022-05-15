<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="max-width-890 mx-auto">
    <div class="bg-white pt-6 border">
        <div class="woocommerce-order">
            <?php
            if ( $order ) :

                do_action( 'woocommerce_before_thankyou', $order->get_id() );
                ?>

                <?php if ( $order->has_status( 'failed' ) ) : ?>

                    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'bookworm' ); ?></p>

                    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                        <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'bookworm' ); ?></a>
                        <?php if ( is_user_logged_in() ) : ?>
                            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'bookworm' ); ?></a>
                        <?php endif; ?>
                    </p>

                <?php else : ?>

                    <h6 class="font-size-3 font-weight-medium text-center mb-4 pb-xl-1 woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
                        <?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'bookworm' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </h6>
                    <div class="border-bottom mb-5 pb-5 overflow-auto overflow-md-visible">
                        <div class="px-3 px-md-5">
                            <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details list-unstyled d-flex justify-content-between">

                                <li class="woocommerce-order-overview__order order">
                                    <div class="font-size-2 font-weight-normal py-0"><?php esc_html_e( 'Order number:', 'bookworm' ); ?></div>
                                    <div class="font-weight-medium"><?php echo wp_kses_post( $order->get_order_number() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                                </li>

                                <li class="woocommerce-order-overview__date date">
                                    <div class="font-size-2 font-weight-normal py-0"><?php esc_html_e( 'Date:', 'bookworm' ); ?></div>
                                    <div class="font-weight-medium"><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                                </li>

                                <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
                                    <li class="woocommerce-order-overview__email email">
                                        <div class="font-size-2 font-weight-normal py-0"><?php esc_html_e( 'Email:', 'bookworm' ); ?></div>
                                        <div class="font-weight-medium"><?php echo wp_kses_post( $order->get_billing_email() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                                    </li>
                                <?php endif; ?>



                                <li class="woocommerce-order-overview__total total">
                                    <div class="font-size-2 font-weight-normal py-0"><?php esc_html_e( 'Total:', 'bookworm' ); ?></div>
                                    <div class="font-weight-medium"><?php echo wp_kses_post( $order->get_formatted_order_total() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                                </li>

                                <?php if ( $order->get_payment_method_title() ) : ?>
                                    <li class="woocommerce-order-overview__payment-method method">
                                        <div class="font-size-2 font-weight-normal py-0"><?php esc_html_e( 'Payment method:', 'bookworm' ); ?></div>
                                        <div class="font-weight-medium"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></div>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </div>
                    </div>

                <?php endif; ?>

                    <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
                    <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

            <?php else : ?>

                <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'bookworm' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

            <?php endif; ?>

        </div>
    </div>
</div>
