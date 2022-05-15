<?php
/**
 * Ajax Fuctions Product Categories Block
 *
 * @since   0.1
 * @package BookwormGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bookwormgb_product_categories_block_output' ) ) {

	/**
	 * Product Categories Block.
	 */
	function bookwormgb_product_categories_block_output() {

		if ( function_exists( 'bookworm_is_woocommerce_activated' ) && ! bookworm_is_woocommerce_activated() ) {
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

			$carouselArgs = apply_filters( 'bookwormgb_products_category_atts', array(
				'data-slides-show'   => $xlColumns,
				'data-slides-scroll' => $slideToScroll,
				'data-speed'         => $slickSpeed,
				'data-force-unslick' => true,
			) );

			if ( wp_validate_boolean( $showSlickDots ) ) {
				$carouselArgs[ 'data-pagi-classes' ]= "d-xl-none text-center u-slick__pagination mb-n7 position-absolute right-0 left-0 bottom-0";
			}

			if ( wp_validate_boolean( $showSlickArrow ) ) {
				$carouselArgs[ 'data-arrows-classes' ] = 'd-none d-lg-block u-slick__arrow u-slick__arrow-centered--y bg-transparent border-0 text-dark';
				$carouselArgs[ 'data-arrow-left-classes' ] = 'fas flaticon-back u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-n4';
				$carouselArgs[ 'data-arrow-right-classes' ] = 'fas flaticon-next u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-n4';
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

			$category_args = array(
				'taxonomy'          => 'product_cat',
				'number'            => $limit,
				'hide_empty'        => filter_var( $hideEmpty, FILTER_VALIDATE_BOOLEAN ),
				'orderby'           => $orderby,
				'order'             => $order,
			);

			if( isset( $ids ) && ! empty( $ids ) ) {
                $category_args['slug'] = $ids;
            }

			$categories = get_terms( apply_filters( 'bookwormgb_product_categories_block_output_category_args', $category_args, $attributes ) );

			if( empty( $categories ) ) {
				return '';
			}

			ob_start();
			switch ( $style ) {
				case 'style-v1': ?>
					<ul class="list-unstyled my-0 row row-cols-1 row-cols-md-<?php echo esc_attr( $mdColumns ); ?> row-cols-lg-<?php echo esc_attr( $lgColumns ); ?> row-cols-xl-<?php echo esc_attr( $xlColumns ); ?> row-cols-wd-<?php echo esc_attr( $wdColumns ); ?>">
						<?php foreach( $categories as $key => $category ) : 
							$icon = get_term_meta( $category->term_id, 'icon', true ); 

							$defaultBg = ' bg-punch-light';
							$defaultIconColor = ' text-punch';

							if ( ( $key + 1 ) % 5 == 1 ) {
								$defaultBg = ' bg-indigo-light';
								$defaultIconColor = ' text-primary-indigo';
							}

							if ( ( $key + 1 ) % 5 == 2 ) {
								$defaultBg = ' bg-tangerine-light';
								$defaultIconColor = ' text-tangerine';
							}

							if ( ( $key + 1 ) % 5 == 3 ) {
								$defaultBg = ' bg-chili-light';
								$defaultIconColor = ' text-chili';
							}

							if ( ( $key + 1 ) % 5 == 4 ) {
								$defaultBg = ' bg-carolina-light';
								$defaultIconColor = ' text-carolina';
							}

							?>
							<li class="product-category col mb-5">
								<div class="bwgb-cat__item product-category__inner bwgb-products-category__bg-<?php echo esc_attr( $key + 1 ); echo esc_attr( $defaultBg ); ?> px-6 py-5">
									<div class="product-category__icon font-size-12 <?php echo esc_attr( $defaultIconColor ); ?>">
										<?php if ( $showCategoryIcon == 'true' && ! empty( $icon ) ): ?>
											<i class="<?php echo esc_attr( $icon ); ?> bwgb-products-category__icon-<?php echo esc_attr( $key + 1 ); ?>"></i>
										<?php endif ?>
									</div>
									<div class="product-category__body">
										<?php if ( $showProductCategoryTitle == 'true' ): ?>
											<h3 class="bwgb-products-category__category-title text-truncate font-size-3">
												<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="bwgb-products-category__category-title stretched-link text-dark"><?php echo esc_html( $category->name ); ?></a>
											</h3>
										<?php endif ?>
										<?php if ( wp_validate_boolean( $showShopNow ) ): ?>
											<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="stretched-link bwgb-products-category__shop-now-text text-dark"><?php echo wp_kses_post( $shopNowText ) ?></a>
										<?php endif ?>
									</div>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
					<?php
				break;
				
				case 'style-v2': ?>
					<div class="js-slick-carousel u-slick products" <?php printf( bookwormgb_get_attributes( $carouselArgs ) ); ?> data-responsive="<?php echo wp_kses_post( $carouselResponsiveArgs ); ?>">
						<?php foreach( $categories as $key => $category ) : 
							$icon = get_term_meta( $category->term_id, 'icon', true ); 

							$defaultIconColor = 'text-chili';

							if ( ( $key + 1 ) % 7 == 1 ) {
								$defaultIconColor = 'text-primary-indigo';
							}

							if ( ( $key + 1 ) % 7 == 2 ) {
								$defaultIconColor = 'text-tangerine';
							}

							if ( ( $key + 1 ) % 7 == 3 ) {
								$defaultIconColor = 'text-chili';
							}

							if ( ( $key + 1 ) % 7 == 4 ) {
								$defaultIconColor = 'text-carolina';
							}

							if ( ( $key + 1 ) % 7 == 5 ) {
								$defaultIconColor = 'text-punch';
							}

							if ( ( $key + 1 ) % 7 == 6 ) {
								$defaultIconColor = 'text-tangerine';
							}

							?>
							<li class="nav-item">
								<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="nav-link font-weight-medium px-0">
									<div class="text-center">
										<div class="product-category__icon font-size-12 <?php echo esc_attr( $defaultIconColor ); ?>">
											<?php if ( $showCategoryIcon == 'true' && ! empty( $icon ) ): ?>
												<i class="<?php echo esc_attr( $icon ); ?> bwgb-products-category__icon-<?php echo esc_attr( $key + 1 ); ?>"></i>
											<?php endif ?>
										</div>
										<?php if ( $showProductCategoryTitle == 'true' ): ?>
											<span class="bwgb-products-category__category-title tabtext font-size-3 font-weight-medium text-dark"><?php echo esc_html( $category->name ); ?></span>
										<?php endif ?>
									</div>
								</a>
							</li>
						<?php endforeach; ?>
					</div><?php
				break;

				case 'style-v3':
					$child_category_args = array(
						'taxonomy'              => 'product_cat',
						'echo'                  => false,
						'title_li'              => '',
						'show_option_none'      => '',
						'number'                => 6,
						'depth'                 => 1,
						'hide_empty'            => false
					); ?>
					<div class="row no-gutters row-cols-1 row-cols-md-<?php echo esc_attr( $mdColumns ); ?> row-cols-lg-<?php echo esc_attr( $lgColumns ); ?> row-cols-xl-<?php echo esc_attr( $xlColumns ); ?> row-cols-wd-<?php echo esc_attr( $wdColumns ); ?> border-top border-left">
						<?php foreach( $categories as $key => $category ) : 
							$icon = get_term_meta( $category->term_id, 'icon', true ); 

							$defaultIconColor = ' text-carolina__1';

							if ( ( $key + 1 ) % 3 == 1 ) {
								$defaultIconColor = ' text-tangerine__1';
							}

							if ( ( $key + 1 ) % 3 == 2 ) {
								$defaultIconColor = ' text-chili__1';
							}

							?>
							<div class="col">
								<div class="position-relative h-100">
									<div class="border-bottom border-right p-4 p-lg-7 h-100">
										<?php if ( $showProductCategoryTitle == 'true' ): ?>
											<h6 class="font-size-3 mb-3 pb-1 bwgb-products-category__category-title">
												<?php echo esc_html( $category->name ); ?>
											</h4>
										<?php endif ?>
										<?php if ( $showProductCategoryList == 'true' ): ?>
										<?php
											$child_category_args['parent'] = $category->term_id;
											echo '<ul class="list-unstyled m-0 p-0 bwgb-products-category__category-list">' . wp_list_categories( apply_filters( 'bookwormgb_product_categories_block_output_child_category_args', $child_category_args ) ) . '</ul>';
										?>
										<?php endif ?>
										<div class="d-flex d-md-block justify-content-end position-md-absolute bottom-0 right-md-30 product-category__icon">
											<?php if ( $showCategoryIcon == 'true' && ! empty( $icon ) ): ?>
												<i class="<?php echo esc_attr( $icon ); ?> bwgb-products-category__icon-<?php echo esc_attr( $key + 1 ); echo esc_attr( $defaultIconColor ); ?> font-size-17"></i>
											<?php endif ?>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<?php
				break;

				case 'style-v4': ?>
					<div class="row flex-nowrap flex-md-wrap overflow-auto row-cols-1 row-cols-md-<?php echo esc_attr( $mdColumns ); ?> row-cols-lg-<?php echo esc_attr( $lgColumns ); ?> row-cols-xl-<?php echo esc_attr( $xlColumns ); ?> row-cols-wd-<?php echo esc_attr( $wdColumns ); ?>">
						<?php foreach( $categories as $key => $category ) : 
							$icon = get_term_meta( $category->term_id, 'icon', true ); 

							$defaultIconColor = 'text-chili';
							$defaultBg = ' bg-punch-light';

							if ( ( $key + 1 ) % 6 == 1 ) {
								$defaultIconColor = 'text-primary-indigo';
								$defaultBg = ' bg-indigo-light';
							}

							if ( ( $key + 1 ) % 6 == 2 ) {
								$defaultIconColor = 'text-tangerine';
								$defaultBg = ' bg-tangerine-light';
							}

							if ( ( $key + 1 ) % 6 == 3 ) {
								$defaultIconColor = 'text-chili';
								$defaultBg = ' bg-chili-light';
							}

							if ( ( $key + 1 ) % 6 == 4 ) {
								$defaultIconColor = 'text-carolina';
								$defaultBg = ' bg-carolina-light';
							}

							if ( ( $key + 1 ) % 6 == 5 ) {
								$defaultIconColor = 'text-punch';
								$defaultBg = ' bg-punch-light';
							}

							?>
							<div class="col mb-5 mb-xl-0">
								<div class="text-center">
									<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="d-block">
										<?php if ( $showCategoryIcon == 'true' && ! empty( $icon ) ): ?>
											<div class="product-category__icon bwgb-cat__item d-flex align-items-center justify-content-center mb-0 width-100 height-100 <?php echo esc_attr( $defaultIconColor ); echo esc_attr( $defaultBg ); ?>  rounded-circle mx-auto mb-4 bwgb-products-category__bg-<?php echo esc_attr( $key + 1 ); ?>">
												<i class="<?php echo esc_attr( $icon ); ?> font-size-12 bwgb-products-category__icon-<?php echo esc_attr( $key + 1 ); ?>"></i>
											</div>
										<?php endif ?>
										<?php if ( $showProductCategoryTitle == 'true' ): ?>
											<span class="bwgb-products-category__category-title tabtext font-size-3 font-weight-medium text-dark"><?php echo esc_html( $category->name ); ?></span>
										<?php endif ?>
									</a>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<?php
				break;
			}

			$output = ob_get_clean();
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

	add_action( 'wp_ajax_nopriv_bookwormgb_product_categories_block_output', 'bookwormgb_product_categories_block_output' );
	add_action( 'wp_ajax_bookwormgb_product_categories_block_output', 'bookwormgb_product_categories_block_output' );
}