<?php
/**
 * Ajax Fuctions Product Block
 *
 * @since   0.1
 * @package BookwormGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bookwormgb_products_block_output' ) ) {

	/**
	 * Producs Block.
	 */
	function bookwormgb_products_block_output() {

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

			if( isset( $shortcode_atts['limit'] ) ) {
				$shortcode_atts['per_page'] = $shortcode_atts['limit'];
				unset( $shortcode_atts['limit'] );
			}

			$type = 'products';

			if( isset( $onSale ) && wp_validate_boolean( $onSale ) ) {
				$type = 'sale_products';
			} elseif( isset( $bestSelling ) && wp_validate_boolean( $bestSelling ) ) {
				$type = 'best_selling_products';
			} elseif( isset( $topRated ) && wp_validate_boolean( $topRated ) ) {
				$type = 'top_rated_products';
			}

			$shortcode_products = new Bookworm_Shortcode_Products( $shortcode_atts, $type );
			$products = $shortcode_products->get_products();

			ob_start();
 
			add_filter( 'woocommerce_product_loop_start', 'bookwormgb_woocommerce_product_loop_reset' );

			$shortcode_products->product_loop_start();

			remove_filter( 'woocommerce_product_loop_start', 'bookwormgb_woocommerce_product_loop_reset' );

			if ( wc_get_loop_prop( 'total' ) ) {
				?><div class="row<?php echo esc_attr( ( $design == 'style-v1' || $design == 'style-v3' ) ? ' no-gutters' : '' ); ?> products row-cols-2 row-cols-md-<?php echo esc_attr( $mdColumns ) ?> row-cols-lg-<?php echo esc_attr( $lgColumns ) ?> row-cols-xl-<?php echo esc_attr( $xlColumns ) ?> row-cols-wd-<?php echo esc_attr( $columns ) ?>"><?php

					foreach ( $products->ids as $key => $product_id ) {
						$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
						setup_postdata( $GLOBALS['post'] );
						global $product;

						$responsiveClasses = '';

						if ( wp_validate_boolean( $enableResponsiveLimits ) ) {
							if ( $key + 1 > $responsiveLimit ) {
								$responsiveClasses = ' ' . $responsiveLimitClasses;
							}
						}

						$product_item_classes = 'col';
						$product_inner_classes = 'product__inner overflow-hidden p-3';
						$column_margin_classes = '';

						if ( $design == 'style-v1' ) {
							if ( wp_validate_boolean( $enableProductWhite ) ) {
								$product_inner_classes .= ' p-md-4d875 bg-white h-100';
							} else {
								$product_inner_classes .= ' p-md-4';
							}

							if ( wp_validate_boolean( $enableHoverProductWhite ) && ! wp_validate_boolean( $enableProductWhite ) ) {
								$product_item_classes .= ' bg-hover-white';
							}
						}

						if ( $design == 'style-v2' ) {
							$product_item_classes = 'border product__space bg-white h-100';
							$product_inner_classes .= ' p-md-4d875 h-100';
							$column_margin_classes = ' mb-5';
						}

						if ( $design == 'style-v3' ) {
							$product_item_classes = 'product__space mx-1 h-100';
							$product_inner_classes .= wp_validate_boolean( $enableRoundedBorder ) ? ' p-md-4d875' : ' p-md-4';
							$product_inner_classes .= ' bg-white h-100';
							$product_inner_classes .= wp_validate_boolean( $enableRoundedBorder ) ? ' rounded-md' : '';
							$column_margin_classes = ' mb-2' . ( $key + 1 > $marginBottomCount ? ' mb-lg-0' : '' );
						}

						if ( $design == 'style-v4' ) {
							$product_item_classes = 'product__space product__space' . ( wp_validate_boolean( $enablePrimaryBorderHover ) ? '-primary' : '' ) . ' rounded-md bg-white h-100 ' . ( wp_validate_boolean( $enableBorder ) ? 'border' : '' ) . '';
							$product_inner_classes .= ' p-3 p-md-4d875 h-100';
							$column_margin_classes = ' mb-5' . ( $key + 1 > $marginBottomCount ? ' mb-xl-0' : '' );
						}

						if ( $design == 'style-v1' ) {
							$product_item_classes .= $responsiveClasses;
						} else {
							$column_margin_classes .= $responsiveClasses;
						}

						?>
						<?php if ( $design == 'style-v2' || $design == 'style-v3' || $design == 'style-v4' ): ?>
							<div class="col<?php echo esc_attr( $column_margin_classes ); ?>">
						<?php endif ?>
							<div <?php wc_product_class( $product_item_classes, $product ); ?>>
								<div class="<?php echo esc_attr( $product_inner_classes ); ?>">
									<div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
										<?php
											$link = apply_filters( 'bookwormgb_wc_product_link', get_the_permalink(), $product );
											$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-120x183-crop' );

											if ( $showImage == 'true' ) {
												?><div class="woocommerce-loop-product__thumbnail bwgb-products__product-image"><?php
													echo apply_filters( 'bookwormgb_wc_product_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block">%s</a>', esc_url($link), $thumbnail ) ) );
												?></div><?php
											}

											if ( $showDiscountBadge === 'true' ) {
												woocommerce_show_product_loop_sale_flash();
											}
										?>
										<div class="woocommerce-loop-product__body product__body pt-3<?php echo esc_attr( ( $design == 'style-v2' || $design == 'style-v3' || $design == 'style-v4' || ( $design == 'style-v1' && ! wp_validate_boolean( $enableHoverProductWhite ) ) ) ? ' bg-white' : '' ); echo esc_attr( ( $design == 'style-v1' && wp_validate_boolean( $productCenterAlign ) ) ? ' text-center' : '' ); ?>">
											<?php 
												if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
													bookworm_wc_template_loop_product_format();
												}
											?>
											<?php if ( $showProductTitle == 'true' ): ?>
												<h2 class="bwgb-products__product-title woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_title_classes', '' ) ); ?>">
													<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
												</h2>
											<?php endif ?>
											<?php 
												if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
													bookworm_wc_template_loop_product_author();
												}
											?>
											<?php if ( $showProductPrice == 'true' ): ?>
												<div class="bwgb-products__product-price price d-flex align-items-center font-weight-medium font-size-3<?php echo esc_attr( ( $design == 'style-v1' && wp_validate_boolean( $productCenterAlign ) ) ? ' justify-content-md-center' : '' ); ?>">
													<?php woocommerce_template_loop_price(); ?>
												</div>
											<?php endif ?>
											<?php if ( $design == 'style-v1' && $product->get_review_count() > 0 && $showProductRating == 'true' ): ?>
												<div class="bwgb-products__product-rating product__rating d-md-flex align-items-center font-size-2 d-none<?php echo esc_attr( ( $design == 'style-v1' && wp_validate_boolean( $productCenterAlign ) ) ? ' justify-content-center text-left' : '' ); ?>">
													<?php woocommerce_template_loop_rating(); ?>
													<?php if ( $showProductRatingCount == 'true' ): ?>
														<span class="bwgb-products__product-rating-count">(<?php echo esc_html( $product->get_review_count() ); ?>)</span>
													<?php endif ?>
												</div>
											<?php endif ?>
										</div>
										<?php if ( $showAddToCart == 'true' || $showCompare == 'true' || $showWishlist == 'true' ) : ?>
											<div class="product__hover d-flex align-items-center<?php echo esc_attr( wp_validate_boolean( $showAddToCartIconOnly ) ? ' bwgb-products__add-to-cart-icon-only' : '' ); ?>">
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
						<?php if ( $design == 'style-v2' || $design == 'style-v3' || $design == 'style-v4' ): ?>
							</div>
						<?php endif;
					}

				?></div><?php
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

	add_action( 'wp_ajax_nopriv_bookwormgb_products_block_output', 'bookwormgb_products_block_output' );
	add_action( 'wp_ajax_bookwormgb_products_block_output', 'bookwormgb_products_block_output' );
}