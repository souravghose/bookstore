<?php
/**
 * Welcome tutorial video required functions.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bookwormgb_welcome_video_closed_callback' ) ) {
	/**
	 * Callback function to note not to open the welcome video again for this user.
	 *
	 * @return Object WP_Error or success.
	 */
	function bookwormgb_welcome_video_closed_callback() {
		$return = update_user_meta( get_current_user_id(), 'bookwormgb_welcome_video_closed', 1 );
		return new WP_REST_Response( $return, 200 );
	}
}

if ( ! function_exists( 'bookwormgb_welcome_video_closed_endpoint' ) ) {
	/**
	 * Add rest endpoint for noting that the welcome video was closed.
	 */
	function bookwormgb_welcome_video_closed_endpoint() {
		register_rest_route( 'wp/v2', '/stk_welcome_video_closed', array(
			'methods' => 'POST',
			'callback' => 'bookwormgb_welcome_video_closed_callback',
			'permission_callback' => function () {
				return current_user_can( 'edit_posts' );
			  }
		) );
	}
	add_action( 'rest_api_init', 'bookwormgb_welcome_video_closed_endpoint' );
}

if ( ! function_exists( 'bookwormgb_display_welcome_video' ) ) {
	/**
	 * Check whether we need to display the welcome video for the user.
	 *
	 * @return Boolean True if the welcome video should be shown.
	 */
	function bookwormgb_display_welcome_video() {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return false;
		}
		return ! get_user_meta( get_current_user_id(), 'bookwormgb_welcome_video_closed', true );
	}
}
