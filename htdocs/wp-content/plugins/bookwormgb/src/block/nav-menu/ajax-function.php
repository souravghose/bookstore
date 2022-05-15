<?php
/**
 * Ajax Fuctions Nav Menu Block
 *
 * @since   0.1
 * @package BookwormGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bookwormgb_nav_menu_block_output' ) ) {
    /**
     * Nav Menu Block.
     */
    function bookwormgb_nav_menu_block_output() {

        if( isset( $_POST['attributes'] ) ) {
            $attributes = $_POST['attributes'];

            if( isset( $attributes['attributes'] ) ) {
                unset( $attributes['attributes'] );
            }

            extract( $attributes );

            ob_start();

            if( ! empty( $attributes['navMenu'] ) ) {
                wp_nav_menu( array(
                    'menu'              => $attributes['navMenu'],
                    'container'         => false,
                    'menu_class'        => 'menu list-unstyled m-0',
                    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                    'walker'            => new wp_bootstrap_navwalker(),
                ) );
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

    add_action( 'wp_ajax_nopriv_bookwormgb_nav_menu_block_output', 'bookwormgb_nav_menu_block_output' );
    add_action( 'wp_ajax_bookwormgb_nav_menu_block_output', 'bookwormgb_nav_menu_block_output' );
}