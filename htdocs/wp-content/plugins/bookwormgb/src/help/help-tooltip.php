<?php
/**
 * Help Tooltip settings.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'bookwormgb_Help_Tooltip' ) ) {
	class bookwormgb_Help_Tooltip {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'register_settings' ) );
		}

		public function register_settings() {
			register_setting(
				'bookwormgb_help_tooltip_disabled',
				'bookwormgb_help_tooltip_disabled',
				array(
					'type' => 'string',
					'description' => __( 'Disable bookwormgb help video tooltips', 'block-options' ),
					'sanitize_callback' => 'sanitize_text_field',
					'show_in_rest' => true,
					'default' => '',
				)
			);
		}
	}

	new bookwormgb_Help_Tooltip();
}
