<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo esc_attr( $variations_attr ); // WPCS: XSS ok. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'bookworm' ) ) ); ?></p>
	<?php else : ?>
		<table class="variations">
			<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr>
						<td class="label"><label class="form-label font-size-2 font-weight-medium" for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label></td>
						<td class="value">
							<?php
								wc_dropdown_variation_attribute_options(
									array(
										'options'   => $options,
										'attribute' => $attribute_name,
										'product'   => $product,
									)
								);
								echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'bookworm' ) . '</a>' ) ) : '';
							?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<?php if( bookworm_is_wc_single_product_variations_radio_style() ) {
			$variations = $product->get_available_variations();
			if( ! empty( $variations ) ) {
				$id_attr = 'product-' . $product->get_id() . '-all-variations';
				$attribute_labels = array();
				foreach ( $attribute_keys as $attribute_label ) {
					$attribute_labels[] = wc_attribute_label( $attribute_label );
				}
				echo '<div class="row mx-gutters-2 mb-5 product-variations" id="' . esc_attr( $id_attr ) . '">';?>
				<div class="mb-2 font-size-2 col-12">
					<span class="font-weight-medium"><?php echo esc_html( implode( ', ', $attribute_labels ) ); ?>:</span>
					<span class="ml-2 text-gray-600"><?php echo esc_html__( 'Choose an option', 'bookworm' ); ?></span>
				</div><?php
				foreach ( $variations as $key => $variation ) {

					$variation_attributes_name = array();
					$variation_attributes = array();
					$is_selected = false;

					foreach ( $variation['attributes'] as $key => $value ) {
						$taxonomy = str_replace( 'attribute_', '', $key );
						$term = get_term_by( 'slug', $value, $taxonomy );
						$variation_attributes_name[] = isset( $term->name ) ? $term->name : $value;
						$variation_attributes[] = array(
							'attribute_name' => $key,
							'attribute_value' => $value
						);

						// Get selected value.
						$selected = isset( $_REQUEST[ $key ] ) ? wc_clean( wp_unslash( $_REQUEST[ $key ] ) ) : $product->get_variation_default_attribute( $taxonomy );
						$is_selected = $selected == $value ? true : false;

					}

					$variation_name = implode( ', ', $variation_attributes_name );
					?>
					<div class="variations-radio-style col-12 col-md-4 col-lg-4 mb-3 mb-md-0">
						<div class="custom-control custom-radio p-0" data-attributes="<?php echo htmlspecialchars( json_encode( $variation_attributes ), ENT_QUOTES, 'UTF-8' ); ?>">
							<input type="radio" id="<?php echo esc_attr( 'variation-' . $variation['variation_id'] ); ?>" name="<?php echo esc_attr( $id_attr ); ?>" class="custom-control-input checkbox-outline__input d-none"<?php if( $is_selected ) { echo ' checked="checked"'; } ?>>

							<label class="border-bottom d-block checkbox-outline__label py-3 px-1 mb-0" for="<?php echo esc_attr( 'variation-' . $variation['variation_id'] ); ?>">
							    <span class="d-block"><?php echo wp_kses_post($variation_name ); ?></span>
							    <span class="bookworm-variation-price"><?php echo wp_kses_post( $variation['price_html'] ); ?></span>

							</label>
						</div>

						
					</div>
					<?php
				}
				echo '</div>';
			}
		} ?>


		<div class="single_variation_wrap">
			<?php
				/**
				 * Hook: woocommerce_before_single_variation.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
