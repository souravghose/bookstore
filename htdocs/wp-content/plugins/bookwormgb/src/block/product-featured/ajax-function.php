<?php
/**
 * Ajax Fuctions Product Featured Block
 *
 * @since   0.1
 * @package BookwormGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bookwormgb_product_featured_block_output' ) ) {

	/**
	 * Product Featured Block.
	 */
	function bookwormgb_product_featured_block_output() {

		if ( ! ( function_exists( 'bookworm_is_woocommerce_activated' ) && bookworm_is_woocommerce_activated() && class_exists( 'Bookworm_Shortcode_Products' ) ) ) {
			$data = array(
				'success' => true,
				'output' => esc_html__( 'WooCommerce not activated', 'bookwormgb' ),
			);

			wp_send_json( $data );
		}

		if( isset( $_POST['attributes'] ) ) {
			$attributes = $_POST['attributes'];

			if( isset( $attributes['attributes'] ) ) {
				unset( $attributes['attributes'] );
			}

			extract( $attributes );

			$shortcode_atts = bookwormgb_get_products_shortcode_atts( $attributes );

			$shortcode_atts['per_page'] = '1';
			$shortcode_atts['columns'] = '1';

			if( ! empty( $productId ) ) {
				$shortcode_atts['ids'] = $productId;
			}

			$type = 'products';

			$shortcode_products = new Bookworm_Shortcode_Products( $shortcode_atts, $type );
			$products = $shortcode_products->get_products();

			ob_start();

			add_filter( 'woocommerce_product_loop_start', 'bookwormgb_woocommerce_product_loop_reset' );

			$shortcode_products->product_loop_start();

			remove_filter( 'woocommerce_product_loop_start', 'bookwormgb_woocommerce_product_loop_reset' );

			if ( wc_get_loop_prop( 'total' ) ) {
				foreach ( $products->ids as $product_id ) {
					$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
					setup_postdata( $GLOBALS['post'] );
					global $product;

					$product_item_classes = $design == 'style-v1' ? 'border-bottom border-right d-flex h-100' : 'product product__space mx-1 mb-2 mb-lg-0 bg-white h-100';
					$product_inner_classes = $design == 'style-v1' ? ' p-3 p-md-4 my-auto' : ' d-flex py-5 py-md-6 py-lg-8 px-3 px-md-4 px-lg-6 px-xl-8 h-100';

					if ( wp_validate_boolean( $enableRoundedBorder ) && $design == 'style-v2' ) {
						$product_item_classes = 'product__no-border rounded-md bg-white py-6 py-lg-0 px-3 px-lg-8 d-flex h-100 align-items-center';
						$product_inner_classes = '';
					}
					?>
					<div <?php wc_product_class( $product_item_classes, $product ); ?>>
						<div class="product__inner overflow-hidden w-100<?php echo esc_attr( $product_inner_classes ); ?>">
							<div class="<?php echo esc_attr( $design == 'style-v2' ? 'mt-auto ' : '' ); ?>woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative w-100">
								<?php
									$link = apply_filters( 'bookwormgb_wc_product_featured_link', get_the_permalink(), $product );

									if ( $showImage == 'true' ) {
										?>
										<div class="woocommerce-loop-product__thumbnail mb-5 mb-<?php echo esc_attr( $design == 'style-v2' ? 'xl' : 'lg' ); ?>-8">
											<?php
												$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-254x400-crop' );

												echo apply_filters( 'bookwormgb_wc_product_featured_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block">%s</a>', esc_url($link), $thumbnail ) ) );
											?>
										</div>
										<?php
									}
								?>
								<div class="woocommerce-loop-product__body product__body<?php echo esc_attr( $design == 'style-v1' ? ' mb-3' : '' ); ?>">
									<?php
										if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
											bookworm_wc_template_loop_product_format();
										}
									?>
									<?php if ( $showProductTitle == 'true' ): ?>
										<h2 class="woocommerce-loop-product__title product__title mb-2 font-size-22 font-weight-regular crop-text-2<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_featured_title_classes', '' ) ); ?>">
											<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
										</h2>
									<?php endif ?>
									<?php
										if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
											bookworm_wc_template_loop_product_author();
										}
									?>
									<?php if ( $showProductPrice == 'true' ): ?>
										<div class="price d-flex align-items-center font-weight-medium mb-4">
											<?php woocommerce_template_loop_price(); ?>
										</div>
									<?php endif ?>
									<?php if ( $product->get_review_count() > 0 && $showProductRating == 'true' ): ?>
										<div class="bwgb-product-featured__product-rating product__rating d-flex align-items-center font-size-2 mb-4">
											<?php woocommerce_template_loop_rating(); ?>
											<?php if ( $showProductRatingCount == 'true' ): ?>
												<span class="bwgb-product-featured__product-rating-count">(<?php echo esc_html( $product->get_review_count() ); ?>)</span>
											<?php endif ?>
										</div>
									<?php endif ?>
								</div>
								<?php if ( $showAddToCart == 'true' || $showCompare == 'true' || $showWishlist == 'true' ) : ?>
									<div class="product__hover d-flex align-items-center">
										<?php
											if ( $showAddToCart == 'true' ) {
												woocommerce_template_loop_add_to_cart(); 
											}
											
											if ( $showCompare == 'true' && class_exists( 'YITH_Woocompare' ) && function_exists( 'bookworm_add_compare_link' ) ) {
												// bookworm_add_compare_link();
											}
											
											if ( $showWishlist == 'true' && class_exists( 'YITH_WCWL' ) && function_exists( 'bookworm_add_to_wishlist_button' ) ) {
												bookworm_add_to_wishlist_button();
											}
										?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php
				}
			}

			add_filter( 'woocommerce_product_loop_end', 'bookwormgb_woocommerce_product_loop_reset' );

			$shortcode_products->product_loop_end();

			remove_filter( 'woocommerce_product_loop_end', 'bookwormgb_woocommerce_product_loop_reset' );

			$output =  ob_get_clean();
		}

		if( ! empty( $output ) ) {
			$data = array(
				'success' => true,
				'output' => $output,
			);
		} else {
			$data = array(
				'error' => true,
			);
		}

		wp_send_json( $data );
	}

	add_action( 'wp_ajax_nopriv_bookwormgb_product_featured_block_output', 'bookwormgb_product_featured_block_output' );
	add_action( 'wp_ajax_bookwormgb_product_featured_block_output', 'bookwormgb_product_featured_block_output' );
}