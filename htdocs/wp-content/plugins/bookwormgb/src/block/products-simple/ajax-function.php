<?php
/**
 * Ajax Fuctions Products Block
 *
 * @since   0.1
 * @package BookwormGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bookwormgb_products_simple_block_output' ) ) {
	/**
	 * Products Simple Block.
	 */
	function bookwormgb_products_simple_block_output() {

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

			$shortcode_atts = bookwormgb_get_products_shortcode_atts( $attributes );

			if( ! isset( $GLOBALS['post'] ) ) {
				$GLOBALS['post'] = array();
			}

			if ( $design == 'grid' ) {
				add_filter( 'bookworm-catalog-layout', function() use ($design) {
					return $design;
				} );
			}

			if ( $design == 'list' ) {
				$shortcode_atts['columns'] = '1';
				
				add_filter( 'bookworm-catalog-layout', function() use ($design) {
					return $design;
				} );
			}

			$output = bookwormgb_do_shortcode( 'products', $shortcode_atts );

			if ( $design == 'grid' ) {
				remove_filter( 'bookworm-catalog-layout', function() use ($design) {
					return $design;
				} );
			}

			if ( $design == 'list' ) {
				remove_filter( 'bookworm-catalog-layout', function() use ($design) {
					return $design;
				} );
			}

			if( isset( $GLOBALS['post'] ) && empty( $GLOBALS['post'] ) ) {
				unset( $GLOBALS['post'] );
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

	add_action( 'wp_ajax_nopriv_bookwormgb_products_simple_block_output', 'bookwormgb_products_simple_block_output' );
	add_action( 'wp_ajax_bookwormgb_products_simple_block_output', 'bookwormgb_products_simple_block_output' );
}