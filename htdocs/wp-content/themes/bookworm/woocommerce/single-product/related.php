<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="related products space-bottom-3">
		<div class="container">

			<?php
			$heading = apply_filters( 'woocommerce_product_related_products_heading', esc_html__( 'Related products', 'bookworm' ) );

			if ( $heading ) :
				?>
				<header class="mb-5 d-md-flex justify-content-between align-items-center">
					<h2 class="font-size-5 mb-3 mb-md-0"><?php echo esc_html( $heading ); ?></h2>
				</header>
			<?php endif; ?>
			
			<?php $defaults = apply_filters( 'bookworm_related_products_carousel_args', array(
	            
	            'carousel_args'     => array(
	                'slidesToShow'   => 5,
	                'slidesToScroll' => 1,
	                'infinite'       => false,
	                'autoplay'       => false,
	                'arrows'         => true,
	                'dots'           => false,
	                'responsive'        => array(
	                    array(
	                        'breakpoint'    => 554,
	                        'settings'      => array(
	                            'slidesToShow'      => 2,
	                            'slidesToScroll'    => 1
	                        )
	                    ),
	                    
	                    array(
	                        'breakpoint'    => 992,
	                        'settings'      => array(
	                            'slidesToShow'      => 2,
	                            'slidesToScroll'    => 1
	                        )
	                    ),
	                    array(
	                        'breakpoint'    => 1199,
	                        'settings'      => array(
	                            'slidesToShow'      => 3,
	                            'slidesToScroll'    => 2
	                        )
	                    ),
	                    array(
	                        'breakpoint'    => 1500,
	                        'settings'      => array(
	                            'slidesToShow'      => 4,
	                            'slidesToScroll'    => 2
	                        )
	                    )
	                ),
	            )
	        ) );

	        $args = wp_parse_args( $args, $defaults );

	        if( is_rtl() ) {
	            $args['carousel_args']['rtl'] = true;
	            if( isset( $args['carousel_args']['prevArrow'] ) && isset( $args['carousel_args']['nextArrow'] ) ) {
	                $carousel_args_temp_arrow = $args['carousel_args']['prevArrow'];
	                $args['carousel_args']['prevArrow'] = $args['carousel_args']['nextArrow'];
	                $args['carousel_args']['nextArrow'] = $carousel_args_temp_arrow;
	            }
	        }

            ?>
            <div class="products-carousel-wrap related-product-carousel" data-ride="bk-slick-carousel" data-wrap=".products" data-slick="<?php echo esc_attr( json_encode( $args['carousel_args'] ), ENT_QUOTES, 'UTF-8' ); ?>">
				<?php woocommerce_product_loop_start(); ?>
				
					<?php foreach ( $related_products as $related_product ) : ?>

							<?php
							$post_object = get_post( $related_product->get_id() );

							setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

							wc_get_template_part( 'content', 'product' );
							?>

					<?php endforeach; ?>
				
				<?php woocommerce_product_loop_end(); ?>
			</div>


		</div>
	</section>
	<?php
endif;

wp_reset_postdata();
