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

if ( ! function_exists( 'bookwormgb_products_deals_carousel_block_output' ) ) {

	/**
	 * Producs Deals Block.
	 */
	function bookwormgb_products_deals_carousel_block_output() {

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

			if( isset( $products ) && ! empty( $products ) ) {
				$type = 'products';
			}

			$shortcode_products = new Bookworm_Shortcode_Products( $shortcode_atts, $type );
			$products = $shortcode_products->get_products();

			$carouselArgs = apply_filters( 'bookwormgb_products_carousel_atts', array(
				'data-slides-show'   => $xlColumns,
				'data-slides-scroll' => $slideToScroll,
				'data-speed'         => $slickSpeed,
				'data-force-unslick' => true,
			) );

			if ( wp_validate_boolean( $showSlickDots ) ) {
				if ( $design == 'style-v5' ) {
					$carouselArgs[ 'data-pagi-classes' ] = 'd-md-none text-center u-slick__pagination mt-4  mb-0 position-absolute right-0 left-0';
				} elseif ( $design == 'style-v4' ) {
					$carouselArgs[ 'data-pagi-classes' ] = 'text-center u-slick__pagination mt-7 position-absolute right-0 left-0';
				} else {
					$carouselArgs[ 'data-pagi-classes' ] = 'text-center u-slick__pagination u-slick__pagination mt-6 mb-0 position-absolute right-0 left-0';
				}
			}

			if ( wp_validate_boolean( $showSlickArrow ) ) {
				if ( $design === 'style-v6' ) {
					$carouselArgs[ 'data-arrows-classes' ] = 'd-none d-lg-block u-slick__arrow u-slick__arrow--v3 border-0 u-slick__arrow-centered--y mt-lg-n12 text-dark';
					$carouselArgs[ 'data-arrow-left-classes' ] = 'flaticon-back u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-3';
					$carouselArgs[ 'data-arrow-right-classes' ] = 'flaticon-next u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-3';
				} elseif ( $design == 'style-v5' ) {
					$carouselArgs[ 'data-arrows-classes' ] = 'd-none d-md-block u-slick__arrow u-slick__arrow-centered--y';
					$carouselArgs[ 'data-arrow-left-classes' ] = 'fas fa-chevron-left u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-3';
					$carouselArgs[ 'data-arrow-right-classes' ] = 'fas fa-chevron-right u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-3';
				} elseif ( $design == 'style-v4' ) {
					$carouselArgs[ 'data-arrows-classes' ] = 'd-none d-xl-block u-slick__arrow u-slick__arrow-centered--y border-0 h-dark-white';
					$carouselArgs[ 'data-arrow-left-classes' ] = 'fas flaticon-back u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-n8';
					$carouselArgs[ 'data-arrow-right-classes' ] = 'fas flaticon-next u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-n8';
				} else {
					$carouselArgs[ 'data-arrows-classes' ] = 'u-slick__arrow u-slick__arrow-centered--y';
					$carouselArgs[ 'data-arrow-left-classes' ] = 'fas fa-chevron-left u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-n4 ml-xl-n10';
					$carouselArgs[ 'data-arrow-right-classes' ] = 'fas fa-chevron-right u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-n4 mr-xl-n10';
				}
			}

			if ( wp_validate_boolean( $slickAutoplay ) ) {
				$carouselArgs[ 'data-autoplay' ] = true;
				$carouselArgs[ 'data-autoplay-speed' ] = $slickAutoplaySpeed;
			}
			
			$carouselResponsiveOptions = array(
				array(
					'breakpoint'    => 1199.98,
					'settings'      => array(
						'slidesToShow' => intval( $lgColumns ),
					)
				),
				array(
					'breakpoint'    => 991.98,
					'settings'      => array(
						'slidesToShow' => intval( $mdColumns ),
					)
				),
				array(
					'breakpoint'    => 575.98,
					'settings'      => array(
						'slidesToShow' => intval( $smColumns ),
					)
				),
			);

			$carouselResponsiveArgs = htmlspecialchars( json_encode( $carouselResponsiveOptions ), ENT_QUOTES, 'UTF-8' );

			ob_start();

			add_filter( 'woocommerce_product_loop_start', 'bookwormgb_woocommerce_product_loop_reset' );

			$shortcode_products->product_loop_start();

			remove_filter( 'woocommerce_product_loop_start', 'bookwormgb_woocommerce_product_loop_reset' );

			if ( wc_get_loop_prop( 'total' ) ) {
							
				$wrapper_class = '';

				if ( $design == 'style-v1' ) {
					$wrapper_class = 'bg-white border';
				}

				if ( $design == 'style-v2' ) {
					$wrapper_class = 'bg-white';
				}

				if ( $design == 'style-v3' ) {
					$wrapper_class = 'bg-white border-left border-right';
				}

				if ( $design == 'style-v4' ) {
					$wrapper_class = 'u-slick--gutters-3';
				}

				if ( $design == 'style-v5' ) {
					$wrapper_class = 'border border-primary border-width-2';
				}

				if ( $design == 'style-v6' ) {
					$wrapper_class = 'mb-0 p-0 h-100';
					?><div class="border border-dark border-width-2 h-100"><?php
				}
					?><div class="js-slick-carousel u-slick u-slick--equal-height <?php echo esc_attr( $wrapper_class ); ?><?php echo esc_attr( ( $design != 'style-v3' && $design != 'style-v5' && $design != 'style-v6' ) ? ' products' : '' ); ?>" <?php printf( bookwormgb_get_attributes( $carouselArgs ) ); ?> data-responsive="<?php echo wp_kses_post( $carouselResponsiveArgs ); ?>"><?php

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

							switch ( $design ) {
								case 'style-v1':
								case 'style-v2':
								case 'style-v3':
									$product_item_classes = 'js-slide';

									if ( $design == 'style-v1' || $design == 'style-v2' ) {
										$product_item_classes .= ' product product__card border-right';
									}

									if ( $design == 'style-v2' ) {
										$product_item_classes .= ' product__card-v2';
									}

									if ( $design == 'style-v3' ) {
										$product_item_classes .= ' border-right border-bottom border-top';
									}

									$media_class = 'media d-block d-md-flex w-100';

									if ( $design == 'style-v1' ) {
										$media_class .= ' p-md-6 p-4';
									}

									if ( $design == 'style-v2' ) {
										$media_class .= ' px-4 px-md-6 px-xl-8d75';
									}

									if ( $design == 'style-v3' ) {
										$media_class = 'product__inner overflow-hidden p-3 p-md-4d875 w-100';
									}

									?>
									<div <?php wc_product_class( $product_item_classes, $product ); ?>>
										<div class="<?php echo esc_attr( $media_class ); ?>">
											<div class="woocommerce-loop-product__thumbnail<?php echo esc_attr( $design != 'style-v3' ? ' mb-4 mb-md-0' : '' ); ?>">
												<?php
													$link = apply_filters( 'bookwormgb_wc_product_deals_carousel_link', get_the_permalink(), $product );
													$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-200x327-crop' );

													if ( $showImage == 'true' ) {
														echo apply_filters( 'bookwormgb_wc_product_deals_carousel_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block bwgb-products-deals-carousel__product-image">%s</a>', esc_url($link), $thumbnail ) ) );
													}
												?>
											</div>
											<div class="woocommerce-loop-product__body <?php echo esc_attr( $design == 'style-v3' ? 'product__body pt-3 bg-white' : 'media-body ml-md-5d25' ); ?>">
												<?php if ( $design != 'style-v3' ): ?>
													<div class="mb-3">
												<?php endif ?>
													<?php 
														if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
															bookworm_wc_template_loop_product_format();
														}
													?>
													<?php if ( $showProductTitle == 'true' ): ?>
														<h2 class="bwgb-products-deals-carousel__product-title woocommerce-loop-product__title font-size-3 text-lh-md mb-2 text-height-2 crop-text-2 h-dark<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_deals_carousel_title_classes', '' ) ); ?>">
															<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
														</h2>
													<?php endif ?>
													<?php 
														if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
															bookworm_wc_template_loop_product_author();
														}
													?>
													<?php if ( $showProductPrice == 'true' ): ?>
														<div class="bwgb-products-deals-carousel__product-price price d-flex align-items-center font-weight-medium font-size-3<?php echo esc_attr( $design == 'style-v3' ? ' mb-2' : '' ); ?>">
															<?php woocommerce_template_loop_price(); ?>
														</div>
													<?php endif ?>
												<?php if ( $design != 'style-v3' ): ?>
													</div>
												<?php endif ?>
												<?php if ( wp_validate_boolean( $showTimer ) && $time_diff > 0 ): ?>
													<div class="countdown-timer<?php echo esc_attr( $design != 'style-v3' ? ' mb-5' : '' ); ?>">
														<?php if ( wp_validate_boolean( $showTimerTitle ) ): ?>
															<?php if ( $design != 'style-v3' ): ?>
																<h5 class="bwgb-products-deals-carousel__timer-title countdown-timer__title font-size-3 mb-3 font-weight-bold"><?php echo wp_kses_post( $timerTitle ); ?></h5>
																<?php else: ?>
																	<h6 class="bwgb-products-deals-carousel__timer-title countdown-timer__title text-primary-home-v3"><?php echo wp_kses_post( $timerTitle ); ?></h6>
															<?php endif; ?>
														<?php endif ?>
														<div 
															class="js-countdown d-flex align-items-stretch justify-content-between"
															data-end-date="<?php echo esc_attr( $deal_end_date ); ?>"
															data-days-format="%D"
															data-hours-format="%H"
															data-minutes-format="%M"
															data-seconds-format="%S"
														>
															<div class="py-2d75">
																<span class="font-weight-medium font-size-3 js-cd-days bwgb-products-deals-carousel__timer"></span>
																<span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline bwgb-products-deals-carousel__timer-label"><?php echo wp_kses_post( $timerDayslabel ); ?></span>
															</div>
															<?php if ( $design != 'style-v3' ): ?>
																<div class="border-left pr-3 pr-md-0">&nbsp;</div>
															<?php endif ?>
															<div class="py-2d75">
																<span class="font-weight-medium font-size-3 js-cd-hours bwgb-products-deals-carousel__timer"></span>
																<span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline bwgb-products-deals-carousel__timer-label"><?php echo wp_kses_post( $timerHourslabel ); ?></span>
															</div>
															<?php if ( $design != 'style-v3' ): ?>
																<div class="border-left pr-3 pr-md-0">&nbsp;</div>
															<?php endif ?>
															<div class="py-2d75">
																<span class="font-weight-medium font-size-3 js-cd-minutes bwgb-products-deals-carousel__timer"></span>
																<span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline bwgb-products-deals-carousel__timer-label"><?php echo wp_kses_post( $timerMinslabel ); ?></span>
															</div>
															<?php if ( $design != 'style-v3' ): ?>
																<div class="border-left pr-3 pr-md-0">&nbsp;</div>
															<?php endif ?>
															<div class="py-2d75">
																<span class="font-weight-medium font-size-3 js-cd-seconds bwgb-products-deals-carousel__timer"></span>
																<span class="font-size-2 ml-md-2 ml-xl-0 ml-wd-2 d-xl-block d-wd-inline bwgb-products-deals-carousel__timer-label"><?php echo wp_kses_post( $timerSecslabel ); ?></span>
															</div>
														</div>
													</div>
												<?php endif; ?>
												<?php if ( $stock_available > 0 && wp_validate_boolean( $showProgressBar ) ): ?>
													<div class="deal-progress bwgb-products-deals-carousel__stock-wrapper">
														<div class="d-flex justify-content-between font-size-2 mb-2d75 bwgb-products-deals-carousel__stock">
															<span><?php echo wp_kses_post( $stockSoldText . ' ' ); echo esc_html( $stock_sold ); ?></span>
															<span><?php echo wp_kses_post( $stockAvailabelText . ' ' ); echo esc_html( $stock_available ); ?></span>
														</div>
														<div class="progress">
															<div class="<?php echo esc_attr( $design == 'style-v3' ? 'bg-tangerine ' : '' ); echo esc_attr( $design == 'style-v2' ? 'bg-dark ' : '' ); ?>progress-bar" role="progressbar" style="width: <?php echo esc_attr( $percentage ); ?>%;"></div>
														</div>
													</div>
												<?php endif; ?>
											</div>
										</div>
									</div>
									<?php
								break;

								case 'style-v4':
									?>
									<div <?php wc_product_class( "js-slide product__card product__space product__space-primary border rounded-md bg-white", $product ); ?>>
										<div class="media d-block d-md-flex p-3 p-md-4d875 w-100">
											<?php
												$link = apply_filters( 'bookwormgb_wc_product_deals_carousel_link', get_the_permalink(), $product );
												$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-120x183-crop' );

												if ( $showImage == 'true' ) {
													echo apply_filters( 'bookwormgb_wc_product_deals_carousel_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block mb-4 mb-md-0 bwgb-products-deals-carousel__product-image">%s</a>', esc_url($link), $thumbnail ) ) );
												}
											?>
											<div class="media-body ml-md-4d875">
												<?php 
													if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
														bookworm_wc_template_loop_product_format();
													}
												?>
												<?php if ( $showProductTitle == 'true' ): ?>
													<h2 class="bwgb-products-deals-carousel__product-title woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_deals_carousel_title_classes', '' ) ); ?>">
														<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
													</h2>
												<?php endif ?>
												<?php 
													if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
														bookworm_wc_template_loop_product_author();
													}
												?>
												<?php if ( $showProductPrice == 'true' ): ?>
													<div class="bwgb-products-deals-carousel__product-price price d-flex align-items-center font-weight-medium font-size-3 mb-3">
														<?php woocommerce_template_loop_price(); ?>
													</div>
												<?php endif ?>
												<?php if ( $stock_available > 0 && wp_validate_boolean( $showProgressBar ) ): ?>
													<div class="deal-progress bwgb-products-deals-carousel__stock-wrapper">
														<div class="d-flex justify-content-between font-size-2 mb-2d75 bwgb-products-deals-carousel__stock">
															<span><?php echo wp_kses_post( $stockSoldText . ' ' ); echo esc_html( $stock_sold ); ?></span>
														</div>
														<div class="progress height-7">
															<div class="bg-dark progress-bar" role="progressbar" style="width: <?php echo esc_attr( $percentage ); ?>%;"></div>
														</div>
													</div>
												<?php endif; ?>
											</div>
										</div>
									</div>
									<?php
								break;

								case 'style-v5':
									?>
									<div <?php wc_product_class( "js-slide product__card", $product ); ?>>
										<div class="media p-md-6 p-lg-10 p-4 d-block d-md-flex w-100">
											<?php if ( $showImage == 'true' ): ?>
												<div class="woocommerce-loop-product__thumbnail mb-4 mb-md-0">
													<?php
														$link = apply_filters( 'bookwormgb_wc_product_deals_carousel_link', get_the_permalink(), $product );
														$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-200x327-crop' );

														if ( $showImage == 'true' ) {
															echo apply_filters( 'bookwormgb_wc_product_deals_carousel_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block bwgb-products-deals-carousel__product-image">%s</a>', esc_url($link), $thumbnail ) ) );
														}
													?>
												</div>
											<?php endif ?>
											<div class="woocommerce-loop-product__body media-body ml-md-5d25">
												<?php 
													if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
														bookworm_wc_template_loop_product_format();
													}
												?>
												<?php if ( $showProductTitle == 'true' ): ?>
													<h2 class="bwgb-products-deals-carousel__product-title woocommerce-loop-product__title font-size-3 text-lh-md mb-2 text-height-2 crop-text-2 font-weight-normal<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_deals_carousel_title_classes', '' ) ); ?>">
														<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
													</h2>
												<?php endif ?>
												<?php 
													if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
														bookworm_wc_template_loop_product_author();
													}
												?>
												<?php if ( $showProductPrice == 'true' ): ?>
													<div class="bwgb-products-deals-carousel__product-price price d-flex align-items-center font-weight-medium font-size-3">
														<?php woocommerce_template_loop_price(); ?>
													</div>
												<?php endif ?>
												<?php if ( $product->get_review_count() > 0 && $showProductRating == 'true' ): ?>
													<div class="bwgb-products-deals-carousel__product-rating product__rating d-flex align-items-center font-size-2 mb-4">
														<?php woocommerce_template_loop_rating(); ?>
														<?php if ( $showProductRatingCount == 'true' ): ?>
															<span class="bwgb-products-deals-carousel__product-rating-count">(<?php echo esc_html( $product->get_review_count() ); ?>)</span>
														<?php endif ?>
													</div>
												<?php endif ?>
												<?php if ( wp_validate_boolean( $showTimer ) && $time_diff > 0 ): ?>
													<div class="countdown-timer mb-5">
														<?php if ( wp_validate_boolean( $showTimerTitle ) ): ?>
															<h5 class="bwgb-products-deals-carousel__timer-title countdown-timer__title font-size-3 mb-3"><?php echo wp_kses_post( $timerTitle ); ?></h5>
														<?php endif ?>
														<div 
															class="js-countdown d-flex align-items-stretch justify-content-between"
															data-end-date="<?php echo esc_attr( $deal_end_date ); ?>"
															data-days-format="%D"
															data-hours-format="%H"
															data-minutes-format="%M"
															data-seconds-format="%S"
														>
															<div class="py-2d75 text-primary-home-v3">
																<span class="font-weight-medium font-size-3 js-cd-days bwgb-products-deals-carousel__timer"></span>
																<span class="font-size-2 bwgb-products-deals-carousel__timer-label"><?php echo wp_kses_post( $timerDayslabel ); ?></span>
															</div>
															<div class="border-left pr-3 pr-md-0">&nbsp;</div>
															<div class="py-2d75 text-primary-home-v3">
																<span class="font-weight-medium font-size-3 js-cd-hours bwgb-products-deals-carousel__timer"></span>
																<span class="font-size-2 bwgb-products-deals-carousel__timer-label"><?php echo wp_kses_post( $timerHourslabel ); ?></span>
															</div>
															<div class="border-left pr-3 pr-md-0">&nbsp;</div>
															<div class="py-2d75 text-primary-home-v3">
																<span class="font-weight-medium font-size-3 js-cd-minutes bwgb-products-deals-carousel__timer"></span>
																<span class="font-size-2 bwgb-products-deals-carousel__timer-label"><?php echo wp_kses_post( $timerMinslabel ); ?></span>
															</div>
															<div class="border-left pr-3 pr-md-0">&nbsp;</div>
															<div class="py-2d75 text-primary-home-v3">
																<span class="font-weight-medium font-size-3 js-cd-seconds bwgb-products-deals-carousel__timer"></span>
																<span class="font-size-2 bwgb-products-deals-carousel__timer-label"><?php echo wp_kses_post( $timerSecslabel ); ?></span>
															</div>
														</div>
													</div>
												<?php endif; ?>
												<?php if ( $stock_available > 0 && wp_validate_boolean( $showProgressBar ) ): ?>
													<div class="deal-progress bwgb-products-deals-carousel__stock-wrapper">
														<div class="d-flex justify-content-between font-size-2 mb-3 bwgb-products-deals-carousel__stock">
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
									<?php
								break;

								case 'style-v6':
									?>
									<div <?php wc_product_class( "js-slide media p-5 flex-column", $product ); ?>>
										<?php
											$link = apply_filters( 'bookwormgb_wc_product_deals_carousel_link', get_the_permalink(), $product );
											$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-190x222-crop' );

											if ( $showImage == 'true' ) {
												echo apply_filters( 'bookwormgb_wc_product_deals_carousel_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block img-fluid mx-auto mb-5 bwgb-products-deals-carousel__product-image">%s</a>', esc_url($link), $thumbnail ) ) );
											}
										?>
										<div class="media-body w-100">
											<?php 
												if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
													bookworm_wc_template_loop_product_format();
												}
											?>
											<?php if ( $showProductTitle == 'true' ): ?>
												<h2 class="bwgb-products-deals-carousel__product-title woocommerce-loop-product__title product__title font-size-3 font-weight-normal text-lh-md mb-1 crop-text-2<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_deals_carousel_title_classes', '' ) ); ?>">
													<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
												</h2>
											<?php endif ?>
											<?php 
												if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
													bookworm_wc_template_loop_product_author();
												}
											?>
											<?php if ( $showProductPrice == 'true' ): ?>
												<div class="bwgb-products-deals-carousel__product-price price d-flex align-items-center font-weight-medium font-size-3 mb-4 mb-4">
													<?php woocommerce_template_loop_price(); ?>
												</div>
											<?php endif ?>
											<?php if ( $stock_available > 0 && wp_validate_boolean( $showProgressBar ) ): ?>
												<div class="deal-progress bwgb-products-deals-carousel__stock-wrapper">
													<div class="d-flex justify-content-between font-size-2 mb-2d75 bwgb-products-deals-carousel__stock">
														<span><?php echo wp_kses_post( $stockSoldText . ' ' ); echo esc_html( $stock_sold ); ?></span>
														<span><?php echo wp_kses_post( $stockAvailabelText . ' ' ); echo esc_html( $stock_available ); ?></span>
													</div>
													<div class="progress">
														<div class="progress-bar" role="progressbar" style="width: <?php echo esc_attr( $percentage ); ?>%;" aria-valuenow="14" aria-valuemin="0" aria-valuemax="<?php echo esc_attr( $stock_sold + $stock_available ); ?>"></div>
													</div>
												</div>
											<?php endif; ?>
										</div>
									</div>
									<?php
								break;
							}
						}
					?></div><?php
				if ( $design == 'style-v6' ) {
					?></div><?php
				}
			} else { 
				?><p class="text-danger text-center font-size-4 py-4"><?php echo esc_html__( 'No deal products available.', 'bookwormgb' );?></p><?php
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

	add_action( 'wp_ajax_nopriv_bookwormgb_products_deals_carousel_block_output', 'bookwormgb_products_deals_carousel_block_output' );
	add_action( 'wp_ajax_bookwormgb_products_deals_carousel_block_output', 'bookwormgb_products_deals_carousel_block_output' );
}