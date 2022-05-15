<?php
/**
 * Ajax Fuctions Product List Block
 *
 * @since   0.1
 * @package BookwormGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bookwormgb_products_list_block_output' ) ) {

	/**
	 * Producs List Block.
	 */
	function bookwormgb_products_list_block_output() {

		if ( ! ( function_exists( 'bookworm_is_woocommerce_activated' ) && bookworm_is_woocommerce_activated() && class_exists( 'Bookworm_Shortcode_Products' ) ) ) {
			$data = array(
				'success' => true,
				'output' => esc_html__( 'WooCommerce not activated', 'bookwormgb' ),
			);

			wp_send_json( $data );
		}

		if( isset( $_POST['attributes'] )  ) {
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
				switch ( $design ) {
					case 'style-v1':
						?><div class="border-top border-left<?php echo esc_attr( $enableBorderLeftLgClass == 'true' ? '' : ' border-lg-left-0' ) ?>"><?php
							foreach ( $products->ids as $product_id ) {
								$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
								setup_postdata( $GLOBALS['post'] );
								global $product;
								$product_item_classes = 'border-right border-bottom p-3';
								?>
								<div <?php wc_product_class( $product_item_classes, $product ); ?>>
									<div class="media m-1">
										<?php
											$link = apply_filters( 'bookwormgb_wc_product_list_link', get_the_permalink(), $product );
											$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-70x107-crop' );

											if ( $showImage == 'true' ) {
												echo apply_filters( 'bookwormgb_wc_product_list_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block bwgb-products-list__product-image">%s</a>', esc_url($link), $thumbnail ) ) );
											}
										?>
										<div class="media-body ml-3">
											<?php if ( $showProductTitle == 'true' ): ?>
												<h6 class="bwgb-products-list__product-title font-weight-normal ml-1 mb-2 pb-1 text-lh-md<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_list_title_classes', '' ) ); ?>">
													<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
												</h6>
											<?php endif ?>
											<?php if ( $showProductPrice == 'true' ): ?>
												<div class="bwgb-products-list__product-price font-weight-medium font-size-3">
													<?php woocommerce_template_loop_price(); ?>
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
						foreach ( $products->ids as $product_id ) {
							$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
							setup_postdata( $GLOBALS['post'] );
							global $product;
							$product_item_classes = 'py-3 pr-3';
							?>
							<div <?php wc_product_class( $product_item_classes, $product ); ?>>
								<div class="media my-1 mr-1">
									<?php
										$link = apply_filters( 'bookwormgb_wc_product_list_link', get_the_permalink(), $product );
										$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-90x138-crop' );

										if ( $showImage == 'true' ) {
											echo apply_filters( 'bookwormgb_wc_product_list_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block bwgb-products-list__product-image">%s</a>', esc_url($link), $thumbnail ) ) );
										}
									?>
									<div class="media-body ml-4">
										<?php 
											if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
												bookworm_wc_template_loop_product_format();
											}
										?>
										<?php if ( $showProductTitle == 'true' ): ?>
											<h6 class="bwgb-products-list__product-title font-weight-normal mb-1 text-lh-md crop-text-2<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_list_title_classes', '' ) ); ?>">
												<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
											</h6>
										<?php endif ?>
										<?php 
											if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
												bookworm_wc_template_loop_product_author();
											}
										?>
										<?php if ( $showProductPrice == 'true' ): ?>
											<div class="bwgb-products-list__product-price font-weight-medium font-size-3">
												<?php woocommerce_template_loop_price(); ?>
											</div>
										<?php endif ?>
									</div>
								</div>
							</div>
							<?php
						}
					break;

					case 'style-v3':
						?><div class="px-4 pt-4 border"><?php
							foreach ( $products->ids as $product_id ) {
								$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
								setup_postdata( $GLOBALS['post'] );
								global $product;
								$product_item_classes = 'media mb-5';
								?>
								<div <?php wc_product_class( $product_item_classes, $product ); ?>>
									<?php
										$link = apply_filters( 'bookwormgb_wc_product_list_link', get_the_permalink(), $product );
										$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-60x90-crop' );

										if ( $showImage == 'true' ) {
											echo apply_filters( 'bookwormgb_wc_product_list_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block bwgb-products-list__product-image">%s</a>', esc_url($link), $thumbnail ) ) );
										}
									?>
									<div class="media-body ml-3 pl-1">
										<?php if ( $showProductTitle == 'true' ): ?>
											<h6 class="bwgb-products-list__product-title crop-text-2 text-lh-md font-weight-normal<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_list_title_classes', '' ) ); ?>">
												<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
											</h6>
										<?php endif ?>
										<?php if ( $showProductPrice == 'true' ): ?>
											<div class="bwgb-products-list__product-price font-weight-medium">
												<?php woocommerce_template_loop_price(); ?>
											</div>
										<?php endif ?>
									</div>
								</div>
								<?php
							}
						?></div><?php
					break;

					case 'style-v4':
						$i = 0;
						foreach ( $products->ids as $product_id ) {
							$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
							setup_postdata( $GLOBALS['post'] );
							global $product;
							$i++;
							$product_item_classes = 'border-top border-right' . ( $products->total == $i ? ' border-bottom' : '' ) . ' border-left p-4d75';
							?>
							<div <?php wc_product_class( $product_item_classes, $product ); ?>>
								<div class="media m-1">
									<?php
										$link = apply_filters( 'bookwormgb_wc_product_list_link', get_the_permalink(), $product );
										$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-120x183-crop' );

										if ( $showImage == 'true' ) {
											echo apply_filters( 'bookwormgb_wc_product_list_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block bwgb-products-list__product-image">%s</a>', esc_url($link), $thumbnail ) ) );
										}
									?>
									<div class="media-body ml-5">
										<?php 
											if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
												bookworm_wc_template_loop_product_format();
											}
										?>
										<?php if ( $showProductTitle == 'true' ): ?>
											<h6 class="bwgb-products-list__product-title font-weight-normal mb-1 text-lh-md crop-text-2<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_list_title_classes', '' ) ); ?>">
												<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
											</h6>
										<?php endif ?>
										<?php 
											if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
												bookworm_wc_template_loop_product_author();
											}
										?>
										<?php if ( $showProductPrice == 'true' ): ?>
											<div class="bwgb-products-list__product-price font-weight-medium font-size-3">
												<?php woocommerce_template_loop_price(); ?>
											</div>
										<?php endif ?>
										<?php if ( $product->get_review_count() > 0 && $showProductRating == 'true' ): ?>
											<div class="bwgb-products-list__product-rating product__rating d-flex align-items-center font-size-2">
												<?php woocommerce_template_loop_rating(); ?>
												<?php if ( $showProductRatingCount == 'true' ): ?>
													<span class="bwgb-products-list__product-rating-count">(<?php echo esc_html( $product->get_review_count() ); ?>)</span>
												<?php endif ?>
											</div>
										<?php endif ?>
									</div>
								</div>
							</div>
							<?php
						}
					break;

					case 'style-v5':
						?><div class="row row-cols-md-<?php echo esc_attr( $mdColumns ); ?> row-cols-lg-<?php echo esc_attr( $lgColumns ); ?> row-cols-xl-<?php echo esc_attr( $columns ); ?> no-gutters"><?php
							foreach ( $products->ids as $product_id ) {
								$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
								setup_postdata( $GLOBALS['post'] );
								global $product;
								$product_item_classes = 'col border-right border-bottom p-4';
								?>
								<div <?php wc_product_class( $product_item_classes, $product ); ?>>
									<div class="media m-1">
										<?php
											$link = apply_filters( 'bookwormgb_wc_product_list_link', get_the_permalink(), $product );
											$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-120x183-crop' );

											if ( $showImage == 'true' ) {
												echo apply_filters( 'bookwormgb_wc_product_list_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block bwgb-products-list__product-image">%s</a>', esc_url($link), $thumbnail ) ) );
											}
										?>
										<div class="media-body ml-5">
											<?php 
												if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
													bookworm_wc_template_loop_product_format();
												}
											?>
											<?php if ( $showProductTitle == 'true' ): ?>
												<h6 class="bwgb-products-list__product-title font-weight-normal mb-1 text-lh-md crop-text-2<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_list_title_classes', '' ) ); ?>">
													<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
												</h6>
											<?php endif ?>
											<?php 
												if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
													bookworm_wc_template_loop_product_author();
												}
											?>
											<?php if ( $showProductPrice == 'true' ): ?>
												<div class="bwgb-products-list__product-price font-weight-medium font-size-3">
													<?php woocommerce_template_loop_price(); ?>
												</div>
											<?php endif ?>
										</div>
									</div>
								</div>
								<?php
							}
						?></div><?php
					break;

					case 'style-v6':
						$i = 0;
						foreach ( $products->ids as $product_id ) {
							$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
							setup_postdata( $GLOBALS['post'] );
							global $product;
							$i++;
							$product_item_classes = 'rounded-md border p-4d75' . ( $i != $limit ? ' mb-5' : '' );
							?>
							<div <?php wc_product_class( $product_item_classes, $product ); ?>>
								<div class="media m-1">
									<?php
										$link = apply_filters( 'bookwormgb_wc_product_list_link', get_the_permalink(), $product );
										$thumbnail = woocommerce_get_product_thumbnail( 'bookworm-120x183-crop' );

										if ( $showImage == 'true' ) {
											echo apply_filters( 'bookwormgb_wc_product_list_thumbnail', wp_kses_post( sprintf( '<a href="%s" class="d-block bwgb-products-list__product-image">%s</a>', esc_url($link), $thumbnail ) ) );
										}
									?>
									<div class="media-body ml-5">
										<?php 
											if ( $showProductFormat == 'true' && function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
												bookworm_wc_template_loop_product_format();
											}
										?>
										<?php if ( $showProductTitle == 'true' ): ?>
											<h6 class="bwgb-products-list__product-title font-weight-normal mb-1 text-lh-md crop-text-2<?php echo esc_attr( apply_filters( 'bookwormgb_wc_product_list_title_classes', '' ) ); ?>">
												<a href="<?php echo esc_url( $link ); ?>"><?php echo get_the_title(); ?></a>
											</h6>
										<?php endif ?>
										<?php 
											if ( $showProductAuthor == 'true' && function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
												bookworm_wc_template_loop_product_author();
											}
										?>
										<?php if ( $showProductPrice == 'true' ): ?>
											<div class="bwgb-products-list__product-price font-weight-medium font-size-3">
												<?php woocommerce_template_loop_price(); ?>
											</div>
										<?php endif ?>
									</div>
								</div>
							</div>
							<?php
						}
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

	add_action( 'wp_ajax_nopriv_bookwormgb_products_list_block_output', 'bookwormgb_products_list_block_output' );
	add_action( 'wp_ajax_bookwormgb_products_list_block_output', 'bookwormgb_products_list_block_output' );
}