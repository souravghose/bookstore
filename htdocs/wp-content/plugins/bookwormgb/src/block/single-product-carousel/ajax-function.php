<?php
/**
 * Ajax Fuctions Single Product Carousel Block
 *
 * @since   0.1
 * @package BookwormGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! function_exists( 'bookwormgb_single_product_carousel_block_output' ) ) {

	/**
	 * Single Product Carousel Block.
	 */
	function bookwormgb_single_product_carousel_block_output() {

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

			$carouselArgs = apply_filters( 'bookwormgb_single_product_carousel_atts', array(
				'data-speed'         => $slickSpeed,
				'data-force-unslick' => true,
			) );

			$carouselArgs[ 'data-pagi-classes' ]= "d-xl-none text-center u-slick__pagination mb-4 pb-4";					

			if ( wp_validate_boolean( $showSlickArrow ) ) {
				
				$carouselArgs[ 'data-arrows-classes' ] = 'd-none d-xl-block u-slick__arrow u-slick__arrow--v1 u-slick__arrow-centered--y rounded-circle box-shadow-1';
				$carouselArgs[ 'data-arrow-left-classes' ] = 'flaticon-back u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-n10';
				$carouselArgs[ 'data-arrow-right-classes' ] = 'flaticon-next u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-n10';	
			}

			if ( wp_validate_boolean( $slickAutoplay ) ) {
				$carouselArgs[ 'data-autoplay' ] = true;
				$carouselArgs[ 'data-autoplay-speed' ] = $slickAutoplaySpeed;
			}

			ob_start();

			add_filter( 'woocommerce_product_loop_start', 'bookwormgb_woocommerce_product_loop_reset' );

			$shortcode_products->product_loop_start();

			remove_filter( 'woocommerce_product_loop_start', 'bookwormgb_woocommerce_product_loop_reset' );

			if ( wc_get_loop_prop( 'total' ) ) {

				?><div class="js-slick-carousel u-slick" <?php printf( bookwormgb_get_attributes( $carouselArgs ) ); ?>><?php

					foreach ( $products->ids as $product_id ) {
						$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
						setup_postdata( $GLOBALS['post'] );
						global $product;

						$product_type = $product->get_type();
						$sale_price_dates_from = $sale_price_dates_to = '';
						if( $product_type == 'variable' ) {
							$var_sale_price_dates_from = array();
							$var_sale_price_dates_to = array();
							$available_variations = $product->get_available_variations();
							foreach ( $available_variations as $key => $available_variation ) {
								$variation_id = $available_variation['variation_id']; // Getting the variable id of just the 1st product. You can loop $available_variations to get info about each variation.
								if( $date_from = get_post_meta( $variation_id, '_sale_price_dates_from', true ) ) {
									$var_sale_price_dates_from[] = date_i18n( 'Y-m-d H:i:s', $date_from );
								}
								if( $date_to =get_post_meta( $variation_id, '_sale_price_dates_to', true ) ) {
									$var_sale_price_dates_to[] = date_i18n( 'Y-m-d H:i:s', $date_to );
								}
							}

							if( ! empty( $var_sale_price_dates_from ) )
								$sale_price_dates_from = min( $var_sale_price_dates_from );
							if( ! empty( $var_sale_price_dates_to ) )
								$sale_price_dates_to = max( $var_sale_price_dates_to );
						} else {
							if( $date_from = get_post_meta( $product_id, '_sale_price_dates_from', true ) ) {
								$sale_price_dates_from = date_i18n( 'Y-m-d H:i:s', $date_from );
							}
							if( $date_to = get_post_meta( $product_id, '_sale_price_dates_to', true ) ) {
								$sale_price_dates_to = date_i18n( 'Y-m-d H:i:s', $date_to );
							}
						}

						$deal_end_date = $sale_price_dates_to;
						$deal_end_time = strtotime( $deal_end_date );
						$current_date = current_time( 'Y-m-d H:i:s', true );
						$current_time = strtotime( $current_date );
						$time_diff = ( $deal_end_time - $current_time );

						$total_stock_quantity = get_post_meta( get_the_ID(), '_total_stock_quantity', true );
						if( ! empty( $total_stock_quantity ) ) {
							$stock_quantity     = round( $total_stock_quantity );
							$stock_available    = ( $stock = get_post_meta( get_the_ID(), '_stock', true ) ) ? round( $stock ) : 0;
							$stock_sold         = ( $stock_quantity > $stock_available ? $stock_quantity - $stock_available : 0 );
							$percentage         = ( $stock_sold > 0 ? round( $stock_sold/$stock_quantity * 100 ) : 0 );
						} else {
							$stock_available    = ( $stock = get_post_meta( get_the_ID(), '_stock', true ) ) ? round( $stock ) : 0;
							$stock_sold         = ( $total_sales = get_post_meta( get_the_ID(), 'total_sales', true ) ) ? round( $total_sales ) : 0;
							$stock_quantity     = $stock_sold + $stock_available;
							$percentage         = ( ( $stock_available > 0 && $stock_quantity > 0 ) ? round( $stock_sold/$stock_quantity * 100 ) : 0 );
						}

					?>

						<div class="product position-relative">
							<div class="d-md-flex justify-content-center space-top-lg-2 space-bottom-lg-4 z-index-2 position-relative">
								<div class="woocommerce-loop-product__thumbnail bwgb-single-product-carousel__product-image mb-6 mb-md-10 mb-lg-0">
									<div class="position-relative">
											<?php
											$link = apply_filters( 'bookwormgb_wc_product_carousel_link', get_the_permalink(), $product );
											$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-300x452-crop' );

											if ( $showImage == 'true' ) {
												echo apply_filters( 'bookwormgb_wc_product_carousel_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block bwgb-products-carousel__product-image">%s</a>', esc_url($link), $thumbnail ) ) );

											}
				

											if ( $product->is_on_sale() && $showDiscountBadge === 'true'  ) :
												$saving_amount = bookworm_get_savings_on_sale( $product, $savingsIn );
		                                    	echo sprintf( '<div class="onsale d-none badge badge-lg badge-primary-home-v3 position-absolute badge-pos--top-left text-gray-200 rounded-circle d-lg-flex flex-column align-items-center justify-content-center"><h6 class="font-weight-medium mb-n2">%1s</h6><span class="font-size-5 font-weight-medium5">%2s</span></div>', $savingsText, $saving_amount ); 
		                                	endif; 

										?>
									</div>
								</div>

								<div class="woocommerce-loop-product__body ml-md-5 ml-lg-10 max-width-410 pt-lg-10 mb-6 mb-md-0">
									<?php 
										if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
											bookworm_wc_template_loop_product_format();
										}
									?>
									<?php if ( $showProductTitle == 'true' ): ?>
										<h2 class="bwgb-single-product-carousel__product-title woocommerce-loop-product__title product__title font-weight-bold mb-2 h-dark font-size-10<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_carousel_title_classes', '' ) ); ?>">
											<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
										</h2>
									<?php endif ?>
									<?php 
										if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
											bookworm_wc_template_loop_product_author();
										}
									?>
									<?php if ( $showProductPrice == 'true' ): ?>
										<div class="bwgb-single-product-carousel__product-price price d-flex align-items-center font-weight-medium font-size-26 mb-4">
											<?php woocommerce_template_loop_price(); ?>
										</div>
									<?php endif ?>

									<?php if ( $product->get_review_count() > 0 && $showProductRating == 'true' ): ?>
										<div class="bwgb-single-product-carousel__product-rating product__rating  align-items-center font-size-2 mb-3">
											<?php woocommerce_template_loop_rating(); ?>
											<?php if ( $showProductRatingCount == 'true' ): ?>
												<span class="bwgb-single-product-carousel__product-rating-count">(<?php echo esc_html( $product->get_review_count() ); ?>)</span>
											<?php endif ?>
										</div>
									<?php endif ?>

									<?php if ( $showAddToCart == 'true' || $showCompare == 'true' || $showWishlist == 'true' ) : ?>
									<div class="product__hover d-flex align-items-center<?php echo esc_attr( wp_validate_boolean( $showAddToCartIconOnly ) ? ' bwgb-single-product-carousel__add-to-cart-icon-only' : '' ); ?>">
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

							<?php if ( $showSliderBackgroundText == 'true' ) : ?>
								<div class="text-stroke-1 font-size-xl-160 mb-0 position-absolute bottom-0 text-center right-0 left-0"><?php echo esc_attr__( $sliderBackgroundText );?></div>
							<?php endif; ?>
						</div>
						<?php
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

	add_action( 'wp_ajax_nopriv_bookwormgb_single_product_carousel_block_output', 'bookwormgb_single_product_carousel_block_output' );
	add_action( 'wp_ajax_bookwormgb_single_product_carousel_block_output', 'bookwormgb_single_product_carousel_block_output' );
} 