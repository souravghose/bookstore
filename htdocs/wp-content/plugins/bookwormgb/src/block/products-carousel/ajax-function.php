<?php
/**
 * Ajax Fuctions Product Carousel Block
 *
 * @since   0.1
 * @package BookwormGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bookwormgb_products_carousel_block_output' ) ) {

	/**
	 * Producs Carousel Block.
	 */
	function bookwormgb_products_carousel_block_output() {

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

			$carouselArgs = apply_filters( 'bookwormgb_products_carousel_atts', array(
				'data-slides-show'   => $wdColumns,
				'data-slides-scroll' => $slideToScroll,
				'data-speed'         => $slickSpeed,
				'data-force-unslick' => true,
			) );

			if ( wp_validate_boolean( $showSlickDots ) ) {
				$carouselArgs[ 'data-pagi-classes' ]= 'text-center u-slick__pagination';

				if ( $disableSlickDotsPosition == 'false' ) {
					$carouselArgs[ 'data-pagi-classes' ] .= ' position-absolute right-0 left-0';
				}
		
				if ( ! empty( $dotsClass ) ) {
					$carouselArgs[ 'data-pagi-classes' ] .= ' ' . $dotsClass;
				}
			}

			if ( wp_validate_boolean( $showSlickArrow ) && ( $showAsideArrow == 'false' ) ) {
				switch ( $design ) {
					case 'style-v1':
					case 'style-v4':
					case 'style-v5':
					case 'style-v6':
					case 'style-v2':
						$carouselArgs[ 'data-arrows-classes' ] = 'u-slick__arrow u-slick__arrow-centered--y';
						$carouselArgs[ 'data-arrow-left-classes' ] = 'fas fa-chevron-left u-slick__arrow-inner u-slick__arrow-inner--left';
						$carouselArgs[ 'data-arrow-right-classes' ] = 'fas fa-chevron-right u-slick__arrow-inner u-slick__arrow-inner--right';
					break;
					case 'style-v3':
					 	if ( wp_validate_boolean( $showrondedArrow ) ) {
							$carouselArgs[ 'data-arrows-classes' ] = 'u-slick__arrow u-slick__arrow--v1 u-slick__arrow-centered--y';
							$carouselArgs[ 'data-arrow-left-classes' ] = 'fas flaticon-back u-slick__arrow-inner u-slick__arrow-inner--left';
							$carouselArgs[ 'data-arrow-right-classes' ] = 'fas flaticon-next u-slick__arrow-inner u-slick__arrow-inner--right';
						}
						else {
							$carouselArgs[ 'data-arrows-classes' ] = 'u-slick__arrow u-slick__arrow-centered--y';
							$carouselArgs[ 'data-arrow-left-classes' ] = 'flaticon-back u-slick__arrow-inner u-slick__arrow-inner--left';
							$carouselArgs[ 'data-arrow-right-classes' ] = 'flaticon-next u-slick__arrow-inner u-slick__arrow-inner--right';
						}
					break;
				}

				if ( ! empty( $arrowClass ) ) {
					$carouselArgs[ 'data-arrows-classes' ] .= ' ' . $arrowClass;
				}

				if ( ! empty( $arrowleftClass ) ) {
					$carouselArgs[ 'data-arrow-left-classes' ] .= ' ' . $arrowleftClass;
				}

				if ( ! empty( $arrowrightClass ) ) {
					$carouselArgs[ 'data-arrow-right-classes' ] .= ' ' . $arrowrightClass;
				}
			}

			if ( wp_validate_boolean( $showSlickArrow ) && $showAsideArrow == 'true'  ) {
				switch ( $design ) {
					case 'style-v1':
					case 'style-v2':
					case 'style-v3':
					case 'style-v4':
						$carouselArgs[ 'data-arrows-classes' ] = 'd-none d-lg-block position-absolute right-0 top-0 mt-n5 mt-lg-n9 arrow-cursor';
						$carouselArgs[ 'data-arrow-left-classes' ] = 'flaticon-back mr-5 ';
						$carouselArgs[ 'data-arrow-right-classes' ] = 'flaticon-next';
					break;
				}
			}
			
			if ( wp_validate_boolean( $slickAutoplay ) ) {
				$carouselArgs[ 'data-autoplay' ] = true;
				$carouselArgs[ 'data-autoplay-speed' ] = $slickAutoplaySpeed;
			}

			$carouselResponsiveOptions = array(
				array(
					'breakpoint'    => 1479.98,
					'settings'      => array(
						'slidesToShow' => intval( $xlColumns ),
					)
				),
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

				switch ( $design ) {

					case 'style-v1':
						if ( wp_validate_boolean( $enableBoxBorder ) ) {
							$product_classes = 'js-slick-carousel u-slick--equal-height u-slick products border';
						} elseif ( wp_validate_boolean( $enableGutter ) ) {
							$product_classes = 'js-slick-carousel u-slick--gutters-3 u-slick products';
						} else {
							$product_classes = 'js-slick-carousel u-slick--equal-height u-slick products';
						}
					
						?><div class="<?php echo esc_attr( $product_classes ); ?>"<?php printf( bookwormgb_get_attributes( $carouselArgs ) ); ?> data-responsive="<?php echo wp_kses_post( $carouselResponsiveArgs ); ?>"><?php

							foreach ( $products->ids as $product_id ) {
								$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
								setup_postdata( $GLOBALS['post'] );
								global $product;


								if ( wp_validate_boolean( $enableBoxBorder ) ) {
									$product_item_classes = 'js-slide product product__card' . ( $products->total != '1' ? ' border-right' : '' );

								} elseif ( wp_validate_boolean( $enableGutter ) ) {
									$product_item_classes = 'js-slide product product__card product__card-v2 border-0';
								}
								else {
									$product_item_classes = 'js-slide product product__card product__card-v2' . ( $products->total != '1' ? ' border-right' : '' );
								}

								$product_item_classes .=  wp_validate_boolean( $enableHoverProductWhite ) ? ' bg-hover-white' : '';

								?><div <?php wc_product_class( $product_item_classes, $product ); ?>>

								<?php if ( wp_validate_boolean( $enableGutter ) ) {
									$media_classes = 'media p-3 p-md-4d875 border';

								} else {
									$media_classes = 'media p-3 p-md-4d875 w-100';
								}

								$media_classes .= wp_validate_boolean( $enableHoverProductWhite ) ?  '' : ' bg-white';

								?><div class="<?php echo esc_attr( $media_classes ); ?>">
										<?php
											$link = apply_filters( 'bookwormgb_wc_product_carousel_link', get_the_permalink(), $product );
											$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-120x183-crop' );

											if ( $showImage == 'true' ) {
												echo apply_filters( 'bookwormgb_wc_product_carousel_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block bwgb-products-carousel__product-image">%s</a>', esc_url($link), $thumbnail ) ) );
											}
										?>
										<div class="media-body ml-4d875">
											<?php 
												if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
													bookworm_wc_template_loop_product_format();
												}
											?>
											<?php if ( $showProductTitle == 'true' ): ?>
												<h6 class="bwgb-products-carousel__product-title woocommerce-loop-product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_carousel_title_classes', '' ) ); ?>">
													<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
												</h6>
											<?php endif ?>
											<?php 
												if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
													bookworm_wc_template_loop_product_author();
												}
											?>
											<?php if ( $showProductPrice == 'true' ): ?>
												<div class="bwgb-products-carousel__product-price d-flex align-items-center font-weight-medium font-size-3">
													<?php woocommerce_template_loop_price(); ?>
												</div>
											<?php endif ?>
											<?php if ( $product->get_review_count() > 0 && $showProductRating == 'true' ): ?>
												<div class="bwgb-products-carousel__product-rating product__rating d-flex align-items-center font-size-2<?php echo esc_attr( wp_validate_boolean( $productCenterAlign ) ? ' justify-content-center text-left' : '' ); ?>">
													<?php woocommerce_template_loop_rating(); ?>
													<?php if ( $showProductRatingCount == 'true' ): ?>
														<span class="bwgb-products-carousel__product-rating-count">(<?php echo esc_html( $product->get_review_count() ); ?>)</span>
													<?php endif ?>
												</div>
											<?php endif ?>
										</div>
									</div>
								</div>
								<?php
							}
						?></div><?php
					break;
					case 'style-v2':

						$product_classes = "js-slick-carousel  u-slick u-slick--equal-height u-slick products no-gutters border-left border-top border-right";
					
						?><div class="<?php echo esc_attr( $product_classes ); ?>"<?php printf( bookwormgb_get_attributes( $carouselArgs ) ); ?> data-responsive="<?php echo wp_kses_post( $carouselResponsiveArgs ); ?>"><?php

							foreach ( $products->ids as $product_id ) {
								$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
								setup_postdata( $GLOBALS['post'] );
								global $product;

								$product_item_classes = 'js-slide product';

								if ( wp_validate_boolean( $enableHoverProductWhite ) ) {
									$product_item_classes .= ' bg-hover-white';
								}

								?>
								<div <?php wc_product_class( $product_item_classes, $product ); ?>>
									<div class="product__inner overflow-hidden p-3 p-md-4d875 w-100">
										<div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                			<div class="woocommerce-loop-product__thumbnail">
												<?php
													$link = apply_filters( 'bookwormgb_wc_product_carousel_link', get_the_permalink(), $product );
													$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-120x183-crop' );

													if ( $showImage == 'true' ) {
														echo apply_filters( 'bookwormgb_wc_product_carousel_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block bwgb-products-carousel__product-image mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid">%s</a>', esc_url($link), $thumbnail ) ) );
													}
												?>
											</div>
											<div class="woocommerce-loop-product__body product__body pt-3 <?php echo esc_attr( ! wp_validate_boolean( $enableHoverProductWhite ) ? ' bg-white' : '' ); echo esc_attr( wp_validate_boolean( $productCenterAlign ) ? ' text-center' : '' ); ?>">
												<?php 
													if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
														bookworm_wc_template_loop_product_format();
													}
												?>
												<?php if ( $showProductTitle == 'true' ): ?>
													<h2 class="bwgb-products-carousel__product-title woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_carousel_title_classes', '' ) ); ?>">
														<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
													</h2>
												<?php endif ?>
												<?php 
													if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
														bookworm_wc_template_loop_product_author();
													}
												?>
												<?php if ( $showProductPrice == 'true' ): ?>
													<div class="bwgb-products-carousel__product-price d-flex align-items-center font-weight-medium font-size-3<?php echo esc_attr( wp_validate_boolean( $productCenterAlign ) ? ' justify-content-md-center' : '' ); ?>">
														<?php woocommerce_template_loop_price(); ?>
													</div>
												<?php endif ?>
												<?php if ( $product->get_review_count() > 0 && $showProductRating == 'true' ): ?>
													<div class="bwgb-products-carousel__product-rating product__rating d-flex align-items-center font-size-2<?php echo esc_attr( wp_validate_boolean( $productCenterAlign ) ? ' justify-content-center text-left' : '' ); ?>">
														<?php woocommerce_template_loop_rating(); ?>
														<?php if ( $showProductRatingCount == 'true' ): ?>
															<span class="bwgb-products-carousel__product-rating-count">(<?php echo esc_html( $product->get_review_count() ); ?>)</span>
														<?php endif ?>
													</div>
												<?php endif ?>
											</div>
											<?php if ( $showAddToCart == 'true' || $showCompare == 'true' || $showWishlist == 'true' ) : ?>
												<div class="product__hover d-flex align-items-center<?php echo esc_attr( wp_validate_boolean( $showAddToCartIconOnly ) ? ' bwgb-products-carousel__add-to-cart-icon-only' : '' ); ?>">
													<?php
														if ( $showAddToCart == 'true' ) {
															woocommerce_template_loop_add_to_cart(); 
														}
														
														if ( $showCompare == 'true' && class_exists( 'YITH_Woocompare' ) && function_exists( 'bookworm_add_compare_link' ) ) {
																//bookworm_add_compare_link();
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

						?></div><?php
					break;
					case 'style-v3':

					if ( wp_validate_boolean( $noGutter ) ) {
						$product_classes = "js-slick-carousel u-slick--equal-height u-slick products  list-unstyled nogutters my-0";
					} else {
						$product_classes = "js-slick-carousel u-slick--equal-height u-slick products  list-unstyled u-slick--gutters-3 my-0";
					}

						?><ul class="<?php echo esc_attr( $product_classes ); ?>" <?php printf( bookwormgb_get_attributes( $carouselArgs ) ); ?> data-responsive="<?php echo wp_kses_post( $carouselResponsiveArgs ); ?>"><?php

							foreach ( $products->ids as $product_id ) {
								$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
								setup_postdata( $GLOBALS['post'] );
								global $product;

								if ( wp_validate_boolean( $roundedProduct ) ) {
									$product_item_classes = 'js-slide product border product__space bg-white rounded-md';
								} else {
									$product_item_classes = 'js-slide product border product__space bg-white';
								}
								
								?>
								<li <?php wc_product_class( $product_item_classes, $product ); ?>>
									<div class="product__inner overflow-hidden p-3 p-md-4d875 w-100">
										<div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                			<div class="woocommerce-loop-product__thumbnail">
												<?php
													$link = apply_filters( 'bookwormgb_wc_product_carousel_link', get_the_permalink(), $product );
													$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-120x183-crop' );

													if ( $showImage == 'true' ) {
														echo apply_filters( 'bookwormgb_wc_product_carousel_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block mx-auto bwgb-products-carousel__product-image attachment-shop_catalog size-shop_catalog wp-post-image img-fluid">%s</a>', esc_url($link), $thumbnail ) ) );
													}
												?>
											</div>
											<div class="woocommerce-loop-product__body product__body pt-3 bg-white">
												<?php 
													if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
														bookworm_wc_template_loop_product_format();
													}
												?>
												<?php if ( $showProductTitle == 'true' ): ?>
													<h2 class="bwgb-products-carousel__product-title woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_carousel_title_classes', '' ) ); ?>">
														<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
													</h2>
												<?php endif ?>
												<?php 
													if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
														bookworm_wc_template_loop_product_author();
													}
												?>
												<?php if ( $showProductPrice == 'true' ): ?>
													<div class="bwgb-products-carousel__product-price d-flex align-items-center font-weight-medium font-size-3">
														<?php woocommerce_template_loop_price(); ?>
													</div>
												<?php endif ?>
											</div>
											<?php if ( $showAddToCart == 'true' || $showCompare == 'true' || $showWishlist == 'true' ) : ?>
												<div class="product__hover d-flex align-items-center<?php echo esc_attr( wp_validate_boolean( $showAddToCartIconOnly ) ? ' bwgb-products-carousel__add-to-cart-icon-only' : '' ); ?>">
													<?php
														if ( $showAddToCart == 'true' ) {
															woocommerce_template_loop_add_to_cart(); 
														}
														
														if ( $showCompare == 'true' && class_exists( 'YITH_Woocompare' ) && function_exists( 'bookworm_add_compare_link' ) ) {
																//bookworm_add_compare_link();
														}
														
														if ( $showWishlist == 'true' && class_exists( 'YITH_WCWL' ) && function_exists( 'bookworm_add_to_wishlist_button' ) ) {
															bookworm_add_to_wishlist_button();
														}
													?>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</li>
								<?php
							}

						?></ul><?php
					break;
					case 'style-v4':

					if ( wp_validate_boolean( $noGutter ) ) {
						$product_classes = "js-slick-carousel u-slick--equal-height u-slick products  list-unstyled nogutters my-0";
					} else {
						$product_classes = "js-slick-carousel u-slick--equal-height u-slick products  list-unstyled u-slick--gutters-3 my-0";
					}

						?><div class="<?php echo esc_attr( $product_classes ); ?>" <?php printf( bookwormgb_get_attributes( $carouselArgs ) ); ?> data-responsive="<?php echo wp_kses_post( $carouselResponsiveArgs ); ?>"><?php

							foreach ( $products->ids as $product_id ) {
								$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
								setup_postdata( $GLOBALS['post'] );
								global $product;

								$product_item_classes = 'js-slide product product__no-border' . ( $products->total != '1' ? ' border-right' : '' ); ?>

								<div <?php wc_product_class( $product_item_classes, $product ); ?>>
									<div class="product__inner overflow-hidden p-3 p-md-4d875 w-100">
										<div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                			<div class="woocommerce-loop-product__thumbnail">
												<?php
													$link = apply_filters( 'bookwormgb_wc_product_carousel_link', get_the_permalink(), $product );
													$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-120x183-crop' );

													if ( $showImage == 'true' ) {
														echo apply_filters( 'bookwormgb_wc_product_carousel_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block bwgb-products-carousel__product-image attachment-shop_catalog size-shop_catalog wp-post-image img-fluid">%s</a>', esc_url($link), $thumbnail ) ) );
													}
												?>
											</div>
											<div class="woocommerce-loop-product__body product__body pt-3 bg-white">
												<?php 
													if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
														bookworm_wc_template_loop_product_format();
													}
												?>
												<?php if ( $showProductTitle == 'true' ): ?>
													<h2 class="bwgb-products-carousel__product-title woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_carousel_title_classes', '' ) ); ?>">
														<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
													</h2>
												<?php endif ?>
												<?php 
													if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
														bookworm_wc_template_loop_product_author();
													}
												?>
												<?php if ( $showProductPrice == 'true' ): ?>
													<div class="bwgb-products-carousel__product-price d-flex align-items-center font-weight-medium font-size-3">
														<?php woocommerce_template_loop_price(); ?>
													</div>
												<?php endif ?>
											</div>
											<?php if ( $showAddToCart == 'true' || $showCompare == 'true' || $showWishlist == 'true' ) : ?>
												<div class="product__hover d-flex align-items-center<?php echo esc_attr( wp_validate_boolean( $showAddToCartIconOnly ) ? ' bwgb-products-carousel__add-to-cart-icon-only' : '' ); ?>">
													<?php
														if ( $showAddToCart == 'true' ) {
															woocommerce_template_loop_add_to_cart(); 
														}
														
														if ( $showCompare == 'true' && class_exists( 'YITH_Woocompare' ) && function_exists( 'bookworm_add_compare_link' ) ) {
																//bookworm_add_compare_link();
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
						?></ul><?php
					break;
					case 'style-v5':

					if ( wp_validate_boolean( $noGutter ) ) {
						$product_classes = "js-slick-carousel u-slick--equal-height u-slick products  list-unstyled nogutters my-0";
					} else {
						$product_classes = "js-slick-carousel u-slick--equal-height u-slick products  list-unstyled u-slick--gutters-3 my-0";
					}

						?><div class="<?php echo esc_attr( $product_classes ); ?>" <?php printf( bookwormgb_get_attributes( $carouselArgs ) ); ?> data-responsive="<?php echo wp_kses_post( $carouselResponsiveArgs ); ?>"><?php

							foreach ( $products->ids as $product_id ) {
								$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
								setup_postdata( $GLOBALS['post'] );
								global $product;

								$product_item_classes = 'js-slide product product__space product__space-primary border rounded-md bg-white'; ?>

								<div <?php wc_product_class( $product_item_classes, $product ); ?>>
									<div class="product__inner overflow-hidden p-3 p-md-4d875 w-100">
										<div class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block position-relative">
                                			<div class="woocommerce-loop-product__thumbnail">
												<?php
													$link = apply_filters( 'bookwormgb_wc_product_carousel_link', get_the_permalink(), $product );
													$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-120x183-crop' );

													if ( $showImage == 'true' ) {
														echo apply_filters( 'bookwormgb_wc_product_carousel_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block attachment-shop_catalog bwgb-products-carousel__product-image size-shop_catalog wp-post-image img-fluid">%s</a>', esc_url($link), $thumbnail ) ) );
													}
												?>
											</div>
											<div class="woocommerce-loop-product__body product__body pt-3 bg-white">
												<?php 
													if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
														bookworm_wc_template_loop_product_format();
													}
												?>
												<?php if ( $showProductTitle == 'true' ): ?>
													<h2 class="bwgb-products-carousel__product-title woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_carousel_title_classes', '' ) ); ?>">
														<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
													</h2>
												<?php endif ?>
												<?php 
													if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
														bookworm_wc_template_loop_product_author();
													}
												?>
												<?php if ( $showProductPrice == 'true' ): ?>
													<div class="bwgb-products-carousel__product-price d-flex align-items-center font-weight-medium font-size-3">
														<?php woocommerce_template_loop_price(); ?>
													</div>
												<?php endif ?>
											
												<?php if ( $product->get_review_count() > 0 && $showProductRating == 'true' ): ?>
													<div class="bwgb-products-carousel__product-rating product__rating d-flex align-items-center font-size-2">
														<?php woocommerce_template_loop_rating(); ?>
														<?php if ( $showProductRatingCount == 'true' ): ?>
															<span class="bwgb-products-carousel__product-rating-count">(<?php echo esc_html( $product->get_review_count() ); ?>)</span>
														<?php endif ?>
													</div>
												<?php endif ?>
											</div>
											<?php if ( $showAddToCart == 'true' || $showCompare == 'true' || $showWishlist == 'true' ) : ?>
												<div class="product__hover d-flex align-items-center<?php echo esc_attr( wp_validate_boolean( $showAddToCartIconOnly ) ? ' bwgb-products-carousel__add-to-cart-icon-only' : '' ); ?>">
													<?php
														if ( $showAddToCart == 'true' ) {
															woocommerce_template_loop_add_to_cart(); 
														}
														
														if ( $showCompare == 'true' && class_exists( 'YITH_Woocompare' ) && function_exists( 'bookworm_add_compare_link' ) ) {
																//bookworm_add_compare_link();
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
						?></ul><?php
					break;
					case 'style-v6':

					$styles = '';

					if ( wp_validate_boolean( $noGutter ) ) {
						$product_classes = "js-slick-carousel u-slick nogutters mb-0 space-bottom-2 px-1 px-md-3";
					} else {
						$product_classes = "js-slick-carousel u-slick u-slick--gutters-3 mb-0 space-bottom-2 px-1 px-md-3";
					}

                        ?><ul class="<?php echo esc_attr( $product_classes ); ?>" <?php printf( bookwormgb_get_attributes( $carouselArgs ) ); ?> data-responsive="<?php echo wp_kses_post( $carouselResponsiveArgs ); ?>"><?php

                            foreach ( $products->ids as $key => $product_id ) {
                                $GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
                                setup_postdata( $GLOBALS['post'] );
                                global $product;

                                $defaultBg = ' bg-carolina-light';

								if ( ( $key + 1 ) % 7 == 1 ) {
									$defaultBg = ' bg-indigo-light';
								}

								if ( ( $key + 1 ) % 7 == 2 ) {
									$defaultBg = ' bg-tangerine-light';
								}

								if ( ( $key + 1 ) % 7 == 3 ) {
									$defaultBg = ' bg-chili-light';
								}

								if ( ( $key + 1 ) % 7 == 4 ) {
									$defaultBg = ' bg-carolina-light';
								}

								if ( ( $key + 1 ) % 7 == 5 ) {
									$defaultBg = ' bg-tangerine-light';
								}

								if ( ( $key + 1 ) % 7 == 6 ) {
									$defaultBg = ' bg-indigo-light ';
								}

                                $link = apply_filters( 'bookwormgb_wc_product_carousel_link', get_the_permalink(), $product ); 

                                $product_item_classes = 'js-slide p-4 p-md-5 rounded-md bwgb-products-carousel__bg-' . ( $key + 1 ) .  $defaultBg; 

                                ?><li <?php wc_product_class( $product_item_classes, $product ); ?> >
                                    <div class="d-md-flex align-items-center">
                                        <div class="mb-4 mb-md-0">
                                            <?php 
                                                if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
                                                    bookworm_wc_template_loop_product_format();
                                                }
                                            ?>
                                            <?php if ( $showProductTitle == 'true' ): ?>
                                                <h2 class="bwgb-products-carousel__product-title woocommerce-loop-product__title product__title h6 text-lh-md mb-1 text-height-2 crop-text-2 h-dark<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_carousel_title_classes', '' ) ); ?>">
                                                    <a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
                                                </h2>
                                            <?php endif ?>
                                            <?php 
                                                if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
                                                    bookworm_wc_template_loop_product_author();
                                                }
                                            ?>
                                            <?php if ( $showProductPrice == 'true' ): ?>
                                                <div class="bwgb-products-carousel__product-price d-flex align-items-center font-weight-medium font-size-3">
                                                    <?php woocommerce_template_loop_price(); ?>
                                                </div>
                                            <?php endif ?>
                                            <?php if ( $product->get_review_count() > 0 && $showProductRating == 'true' ): ?>
                                                <div class="bwgb-products-carousel__product-rating product__rating d-flex align-items-center font-size-2 mb-4">
                                                    <?php woocommerce_template_loop_rating(); ?>
                                                    <?php if ( $showProductRatingCount == 'true' ): ?>
                                                        <span class="bwgb-products-carousel__product-rating-count">(<?php echo esc_html( $product->get_review_count() ); ?>)</span>
                                                    <?php endif ?>
                                                </div>
                                            <?php endif ?>
                                            <?php if ( $showAddToCart == 'true' || $showCompare == 'true' || $showWishlist == 'true' ) : ?>
												<div class="product__hover d-flex align-items-center<?php echo esc_attr( wp_validate_boolean( $showAddToCartIconOnly ) ? ' bwgb-products-carousel__add-to-cart-icon-only' : '' ); ?>">
													<?php
														if ( $showAddToCart == 'true' ) {
															woocommerce_template_loop_add_to_cart(); 
														}
														
														if ( $showCompare == 'true' && class_exists( 'YITH_Woocompare' ) && function_exists( 'bookworm_add_compare_link' ) ) {
																//bookworm_add_compare_link();
														}
														
														if ( $showWishlist == 'true' && class_exists( 'YITH_WCWL' ) && function_exists( 'bookworm_add_to_wishlist_button' ) ) {
															bookworm_add_to_wishlist_button();
														}
													?>
												</div>
											<?php endif; ?>
                                        </div>
                                        <div class="ml-auto">
                                            <?php
                                                $thumbnail = woocommerce_get_product_thumbnail( 'bookworm-120x183-crop' );

                                                if ( $showImage == 'true' ) {
                                                    echo apply_filters( 'bookwormgb_wc_product_carousel_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block attachment-shop_catalog bwgb-products-carousel__product-image size-shop_catalog wp-post-image img-fluid">%s</a>', esc_url($link), $thumbnail ) ) );
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                        ?></ul><?php
                    break;
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

	add_action( 'wp_ajax_nopriv_bookwormgb_products_carousel_block_output', 'bookwormgb_products_carousel_block_output' );
	add_action( 'wp_ajax_bookwormgb_products_carousel_block_output', 'bookwormgb_products_carousel_block_output' );
} 