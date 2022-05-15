<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

$notes = $order->get_customer_order_notes();
?>
<div class="border-bottom mb-5 pb-6">
	<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details list-unstyled d-flex justify-content-between">
	    <li class="woocommerce-order-overview__order order">
	        <div class="font-size-2 font-weight-normal py-0"><?php esc_html_e( 'Order number:', 'bookworm' ); ?></div>
	        <div class="font-weight-medium"><?php echo esc_html( $order->get_order_number()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
	    </li>
	    <li class="woocommerce-order-overview__date date">
            <div class="font-size-2 font-weight-normal py-0"><?php esc_html_e( 'Date:', 'bookworm' ); ?></div>
            <div class="font-weight-medium"><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
        </li>
        <li class="woocommerce-order-overview__status order-status">
            <div class="font-size-2 font-weight-normal py-0"><?php esc_html_e( 'Status:', 'bookworm' ); ?></div>
            <div class="font-weight-medium"><?php echo wc_get_order_status_name( $order->get_status() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
        </li>
    </ul>	
</div>

<?php if ( $notes ) : ?>
	<div class="border-bottom mb-5 pb-6">
		<h2 class="font-size-3 font-weight-medium mb-4 pb-1"><?php esc_html_e( 'Order updates', 'bookworm' ); ?></h2>
		<ol class="woocommerce-OrderUpdates commentlist notes list-unstyled font-size-2">
			<?php foreach ( $notes as $note ) : ?>
			<li class="woocommerce-OrderUpdate comment note">
				<div class="woocommerce-OrderUpdate-inner comment_container">
					<div class="woocommerce-OrderUpdate-text comment-text">
						<p class="woocommerce-OrderUpdate-meta meta m-0 text-gray-600"><?php echo date_i18n( esc_html__( 'l jS \o\f F Y, h:ia', 'bookworm' ), strtotime( $note->comment_date ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
						<div class="woocommerce-OrderUpdate-description description">
							<?php echo wpautop( wptexturize( $note->comment_content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			</li>
			<?php endforeach; ?>
		</ol>
	</div>
<?php endif; ?>

<?php do_action( 'woocommerce_view_order', $order_id ); ?>