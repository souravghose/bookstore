<?php
/**
 * Ajax Fuctions
 *
 * @since   0.1
 * @package BookwormGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bookwormgb_deal_product_block_output' ) ) {

	/**
	 * Producs Deals Block.
	 */
	function bookwormgb_deal_product_block_output() {

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

			$type = 'sale_products';

			if( isset( $products ) && ! empty ( $products ) ) {
				$type = 'products';
			}


			$shortcode_products = new Bookworm_Shortcode_Products( $shortcode_atts, $type );
			$products = $shortcode_products->get_products();

				ob_start();

				add_filter( 'woocommerce_product_loop_start', 'bookwormgb_woocommerce_product_loop_reset' );

				$shortcode_products->product_loop_start();

				remove_filter( 'woocommerce_product_loop_start', 'bookwormgb_woocommerce_product_loop_reset' );

				if ( wc_get_loop_prop( 'total' ) ) { ?>
					<div class="products deal-products"><?php

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
						<div class="product product__card product__card-v2">
							<div class="px-md-5 py-md-6 p-4 border border-primary border-width-2">
								<div class="woocommerce-loop-product__thumbnail py-8 position-relative deal-product-thumbnail">
									<?php if ( $product->is_on_sale() && $showDiscountBadge === 'true'  ) :
										$saving_amount = bookworm_get_savings_on_sale( $product, $savingsIn );
	                                    echo sprintf( '<div class="onsale width-100 height-100 bg-primary rounded-circle d-flex align-items-center flex-wrap justify-content-center text-white position-absolute right-0 top-0' . esc_attr( apply_filters( 'bookwormgb_deal_product_bg_classes', '' )) . '"><div class="text-center"><div>%1s</div><div class="font-size-5">%2s</div></div></div>', $savingsText, $saving_amount ); 
	                                endif; 

										$link = apply_filters( 'bookwormgb_wc_deal_product_link', get_the_permalink(), $product );
										$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-200x327-crop' );

										if ( $showImage == 'true' ) {
											echo apply_filters( 'bookwormgb_wc_deal_product_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block bwgb-deal-product__product-image">%s</a>', esc_url($link), $thumbnail ) ) );
										}
									?>
								</div>

								<div class="woocommerce-loop-product__body">
									<div class="mb-3">
										<?php 
											if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
												bookworm_wc_template_loop_product_format();
											}
										?>
										<?php if ( $showProductTitle == 'true' ): ?>
											<h2 class="bwgb-deal-product__product-title woocommerce-loop-product__title font-size-3 text-lh-md mb-2 text-height-2 crop-text-2 h-dark<?php echo esc_attr( apply_filters( 'bookwormgb_wc_deal_product_title_classes', '' ) ); ?>">
												<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
											</h2>
										<?php endif ?>
										<?php 
											if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
												bookworm_wc_template_loop_product_author();
											}
										?>
										<?php if ( $showProductPrice == 'true' ): ?>
											<div class="bwgb-deal-product__product-price price d-flex align-items-center font-weight-medium font-size-22">
												<?php woocommerce_template_loop_price(); ?>
											</div>
										<?php endif ?>
									</div>

									<?php if ( wp_validate_boolean( $showTimer ) && $time_diff > 0 ): ?>
										<div class="countdown-timer mb-5">
											<?php if ( wp_validate_boolean( $showTimerTitle ) ): ?>
												<h5 class="bwgb-deal-product__timer-title countdown-timer__title font-size-3 mb-3"><?php echo wp_kses_post( $timerTitle ); ?></h5>
											<?php endif; ?>
													
											<div 
												class="js-countdown d-flex align-items-stretch justify-content-between"
												data-end-date="<?php echo esc_attr( $deal_end_date ); ?>"
												data-days-format="%D"
												data-hours-format="%H"
												data-minutes-format="%M"
												data-seconds-format="%S"
											>
												<div class="py-2d75 d-md-flex align-items-center">
													<span class="font-weight-medium font-size-3 js-cd-days bwgb-deal-product__timer"></span>
													<span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline bwgb-deal-product__timer-label">Days</span>
												</div>
												<div class="border-left pr-3 pr-md-0">&nbsp;</div>

												<div class="py-2d75 d-md-flex align-items-center">
													<span class="font-weight-medium font-size-3 js-cd-hours bwgb-deal-product__timer"></span>
													<span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline bwgb-deal-product__timer-label">Hours</span>
												</div>
												<div class="border-left pr-3 pr-md-0">&nbsp;</div>
												<div class="py-2d75 d-md-flex align-items-center">
													<span class="font-weight-medium font-size-3 js-cd-minutes bwgb-deal-product__timer"></span>
													<span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline bwgb-deal-product__timer-label">Mins</span>
												</div>
												<div class="border-left pr-3 pr-md-0">&nbsp;</div>
												<div class="py-2d75 d-md-flex align-items-center">
													<span class="font-weight-medium font-size-3 js-cd-seconds bwgb-deal-product__timer"></span>
													<span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline bwgb-deal-product__timer-label">Secs</span>
												</div>
											</div>
										</div>
									<?php endif; ?>
									<?php if ( $stock_available > 0 && wp_validate_boolean( $showProgressBar ) ): ?>
										<div class="deal-progress bwgb-deal-product__stock-wrapper">
											<div class="d-flex justify-content-between font-size-2 mb-2d75 bwgb-deal-product__stock">
												<span><?php echo wp_kses_post( $stockSoldText . ' ' ); echo esc_html( $stock_sold ); ?></span>
												<span><?php echo wp_kses_post( $stockAvailabelText . ' ' ); echo esc_html( $stock_available ); ?></span>
											</div>
											<div class="progress">
												<div class="progress-bar" role="progressbar" style="width: <?php echo esc_attr( $percentage ); ?>%;"></div>
											</div>
										</div>
									<?php endif; ?>
									

									
								</div>
							</div>
						</div>
					<?php } ?>
					</div><?php
					
					
				} else { ?>
					<p class="text-danger text-center font-size-4"><?php echo esc_html__( 'No deal products available.', 'bookwormgb' );?></p><?php
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

	add_action( 'wp_ajax_nopriv_bookwormgb_deal_product_block_output', 'bookwormgb_deal_product_block_output' );
	add_action( 'wp_ajax_bookwormgb_deal_product_block_output', 'bookwormgb_deal_product_block_output' );
}