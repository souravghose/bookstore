<?php
/**
 * Ajax Fuctions Authors Block
 *
 * @since   0.1
 * @package BookwormGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function bookwormgb_authors_pagination( $max_num_pages = null,  $current_page = 1 ) {

	if ( $max_num_pages <= 1 ) {
		return;
	}

	$alphas = range('A', 'Z');
	$pages = range( 1, $max_num_pages ); ?>
	<ul class="author-pagination d-flex justify-content-between list-inline cbp-l-filters-alignRight cbp-l-filters-alignRight__custom text-left pl-lg-8 pt-4 pt-lg-8 mb-5 mb-lg-8 overflow-auto">
		<?php
			foreach ( $pages as $key => $page ) {
				$page_number = $key + 1 > sizeof( $alphas ) ? $key + 1 : $alphas[$key];

				if ( $current_page == $page ) {
					echo '<li class="list-inline-item bg-white text-secondary-gray-700 px-2 px-md-0 font-size-2 border-0 cbp-filter-item m-0 u-cubeportfolio__item cbp-filter-item-active"><span class="current" data-page="' . esc_attr( $page ) . '">' . esc_html( $page_number ) . '</span></li>';
				} else {
					echo '<li class="list-inline-item bg-white text-secondary-gray-700 px-2 px-md-0 font-size-2 border-0 cbp-filter-item m-0 u-cubeportfolio__item"><a class="text-secondary-gray-700" href="#" data-page="' . esc_attr( $page ) . '">' . esc_html( $page_number ) . '</a></li>';
				}
			}
		?>
	</ul>
    <?php
}

if ( ! function_exists( 'bookwormgb_authors_block_output_author' ) ) {

	/**
	 * Authors Block.
	 */
	function bookwormgb_authors_block_output_author() {

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

			if( class_exists( 'Mas_WC_Brands' ) ) {
				global $mas_wc_brands;
				$author_tax = $mas_wc_brands->get_brand_taxonomy();

				if( ! empty( $author_tax ) ) {
					$default_args = apply_filters( 'bookwormgb_authors_block_default_args', array(
						'hide_empty'    => 0,
						'orderby'       => 'name',
						'order'         => '',
						'slug'          => '',
						'include'       => '',
						'exclude'       => '',
						'number'        => '',
						'image_size'    => '',
						'fluid_columns' => false
					) );

					$args = wp_parse_args( $attributes, $default_args );

					extract( $args );

					$exclude = array_map( 'intval', explode(',', $exclude) );
					
					if( empty( $order ) ) {
						$order = $orderby === 'name' ? 'asc' : 'desc';
					}

					$number_of_terms = wp_count_terms( $author_tax ); // This counts the total number terms in the taxonomy with a function)

					$paged_offset = ( $paged - 1 ) * $limit;

					$taxonomy_args = array(
						'taxonomy'      => $author_tax,
						'hide_empty'    => wp_validate_boolean( $hideEmpty ),
						'orderby'       => $orderby,
						'slug'          => $slug,
						'include'       => $include,
						'exclude'       => $exclude,
						'number'        => $limit,
						'order'         => $order,
					);

					if ( $design == 'basic' && ! wp_validate_boolean( $enableCarousel ) ) {
						$taxonomy_args[ 'offset' ] = $paged_offset;
					}

					$brands = get_terms( $taxonomy_args );

					if ( ! $brands || ! is_array( $brands ) ) {
						return;
					}

					$count = 0;
					$style_att = '';

					$brands = array_values( $brands );

					$index = range( 'a', 'z' );

					foreach ( $brands as $brand ) {

						$term_letter = substr( $brand->slug, 0, 1 );

						if ( ctype_alpha( $term_letter ) ) {

							foreach ( range( 'a', 'z' ) as $i )
								if ( $i == $term_letter ) {
									$product_brands[ $i ][] = $brand;
									break;
								}
						} 
					}

					$carouselArgs = apply_filters( 'bookwormgb_products_carousel_atts', array(
						'data-slides-show'   => $xlColumns,
						'data-slides-scroll' => $slideToScroll,
						'data-speed'         => $slickSpeed,
						'data-force-unslick' => true,
					) );

					if ( wp_validate_boolean( $showSlickDots ) ) {
						$carouselArgs[ 'data-pagi-classes' ]= "text-center u-slick__pagination mt-md-8 mt-4 position-absolute right-0 left-0";
					}

					if ( wp_validate_boolean( $showSlickArrow ) ) {
						$carouselArgs[ 'data-arrows-classes' ] = 'u-slick__arrow u-slick__arrow-centered--y';
						$carouselArgs[ 'data-arrow-left-classes' ] = 'fas fa-chevron-left u-slick__arrow-inner u-slick__arrow-inner--left ml-lg-n4';
						$carouselArgs[ 'data-arrow-right-classes' ] = 'fas fa-chevron-right u-slick__arrow-inner u-slick__arrow-inner--right mr-lg-n4';
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
					switch ( $design ) {
						case 'basic': ?>
							<?php if( ! wp_validate_boolean( $enableCarousel ) ) : ?>
								<div id="brands_a_z">
									<div class="author-portfolio u-cubeportfolio mb-5 mb-lg-7">
										<?php
											if ( wp_validate_boolean( $enableFilters ) ) {
												bookwormgb_authors_pagination( ceil( $number_of_terms / $limit ), $paged );
											}
										?>
										<div class="author-content position-relative mx-md-n7 row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-<?php echo esc_attr( $columns ); ?>">
											<?php foreach (  $brands as $brand ) : ?>
												<div class="cbp-item col px-md-7 mx-0">
													<a class="cbp-caption" href="<?php echo esc_url( get_term_link( $brand->slug, $author_tax ) ); ?>" title="<?php echo esc_attr( $brand->name ); ?>">
														<?php 
															if ( wp_validate_boolean( $showImage ) ) {
																echo mas_wcbr_get_brand_thumbnail_image( $brand );
															} 
														?>
														<div class="py-3 text-center">
															<?php if ( wp_validate_boolean( $showName ) ): ?>
																<h4 class="bwgb-author__name h6 text-dark"><?php echo esc_html( $brand->name ); ?></h4>
															<?php endif ?>
															<?php if ( $brand->count > 0 && wp_validate_boolean( $showBook ) ) : ?>
																<span class="bwgb-author__book font-size-2 text-secondary-gray-700 d-inline-block"><?php echo $brand->count;?> <?php echo wp_kses_post( $publishedBooksText ); ?></span>
															<?php endif; ?>

														</div>
													</a>
												</div>
											<?php endforeach; ?>
										</div>
										<?php if ( wp_validate_boolean( $showMoreButton ) && $limit < $number_of_terms ): ?>
											<div class="d-flex justify-content-center">
												<button type="submit" class="author-button btn btn-wide border-dark text-dark rounded-0 transition-3d-hover<?php echo esc_attr( $number_of_terms == $limit ? ' disabled' : '' ); ?>" <?php if ( $number_of_terms == $limit ): ?>disabled<?php endif; ?>><?php echo wp_kses_post( $showMoreButtonText ); ?></button>
											</div>
										<?php endif; ?>
									</div>
								</div>
							<?php else: ?>
							<ul class="authors authors-carousel list-unstyled js-slick-carousel u-slick" <?php printf( bookwormgb_get_attributes( $carouselArgs ) ); ?> data-responsive="<?php echo wp_kses_post( $carouselResponsiveArgs ); ?>"><?php
									foreach ( $brands as $index => $brand ) : ?>
										<li class="author">
											<a href="<?php echo esc_url( get_term_link( $brand->slug, $author_tax ) ); ?>" class="text-reset">
												<?php 
													if ( wp_validate_boolean( $showImage ) ) {
														echo mas_wcbr_get_brand_thumbnail_image( $brand );
													} 
												?>
												<div class="author__body text-center">
													<?php if ( wp_validate_boolean( $showName ) ): ?>
														<h2 class="bwgb-author__name author__name h6 mb-0"><?php echo esc_html( $brand->name ); ?></h2>
													<?php endif ?>
													<?php if ( $brand->count > 0 && wp_validate_boolean( $showBook ) ) : ?>
														<div class="bwgb-author__book text-gray-700 font-size-2 d-inline-block"><?php echo $brand->count;?> <?php echo wp_kses_post( $publishedBooksText ); ?></div>
													<?php endif; ?>
												</div>
											</a>
										</li>
								<?php endforeach;?>
							</ul>
						<?php endif;
						break;

						case 'horizontal': ?>
							<div class="px-4 pt-4 border mb-5">
								<?php foreach( $brands as $brand ) : ?>
								<div class="media mb-6 align-items-center">
									<?php if ( wp_validate_boolean( $showImage ) ): ?>
										<a class="d-block" href="<?php echo esc_url( get_term_link( $brand->slug, $author_tax ) ); ?>">
											<?php echo mas_wcbr_get_brand_thumbnail_image( $brand ); ?>
										</a>
									<?php endif ?>
									<div class="media-body ml-3 pl-1">
										<?php if ( wp_validate_boolean( $showName ) ): ?>
											<h6 class="crop-text-2 text-lh-md font-weight-normal mb-0 bwgb-author__name">
												<a href="<?php echo esc_url( get_term_link( $brand->slug, $author_tax ) ); ?>"><?php echo esc_html( $brand->name ); ?></a>
											</h6>
										<?php endif ?>
										<?php if ( $brand->count > 0 && wp_validate_boolean( $showBook ) ) : ?>
										<span class="bwgb-author__book text-secondary-gray-700 font-size-2 d-inline-block"><?php echo $brand->count;?> <?php echo wp_kses_post( $publishedBooksText ); ?></span>
										<?php endif; ?>
									</div>
								</div>
								 <?php endforeach; ?>
							</div><?php
						break;
					}
					$output = ob_get_clean();
				}
			}
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

	add_action( 'wp_ajax_nopriv_bookwormgb_authors_block_output_author', 'bookwormgb_authors_block_output_author' );
	add_action( 'wp_ajax_bookwormgb_authors_block_output_author', 'bookwormgb_authors_block_output_author' );
}