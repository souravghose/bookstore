<?php
/**
 * Plugin Name: Bookworm Gutenberg Blocks
 * Plugin URI: https://demo2.madrasthemes.com/bookworm/
 * Description: Gutenberg Blocks for Bookworm WordPress Theme
 * Author: MadrasThemes
 * Author URI: https://madrasthemes.com/
 * Text Domain: bookwormgb
 * Version: 1.1.0
 *
 * @package BookwormGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

defined( 'BWGB_SHOW_PRO_NOTICES' ) || define( 'BWGB_SHOW_PRO_NOTICES', true );
defined( 'BWGB_VERSION' ) || define( 'BWGB_VERSION', '1.1.0' );
defined( 'BWGB_FILE' ) || define( 'BWGB_FILE', __FILE__ );
defined( 'BWGB_I18N' ) || define( 'BWGB_I18N', 'bookwormgb' ); // Plugin slug.
defined( 'BWGB_CLOUDFRONT_URL' ) || define( 'BWGB_CLOUDFRONT_URL', 'https://d3gt1urn7320t9.cloudfront.net' ); // CloudFront CDN URL

/********************************************************************************************
 * Activation & PHP version checks.
 ********************************************************************************************/

if ( ! function_exists( 'bookwormgb_php_requirement_activation_check' ) ) {

	/**
	 * Upon activation, check if we have the proper PHP version.
	 * Show an error if needed and don't continue with the plugin.
	 *
	 * @since 1.9
	 */
	function bookwormgb_php_requirement_activation_check() {
		if ( version_compare( PHP_VERSION, '5.3.0', '<' ) ) {
			deactivate_plugins( basename( __FILE__ ) );
			wp_die(
				sprintf(
					__( '%s"BookwormGB" can not be activated. %s It requires PHP version 5.3.0 or higher, but PHP version %s is used on the site. Please upgrade your PHP version first ✌️ %s Back %s', BWGB_I18N ),
					'<strong>',
					'</strong><br><br>',
					PHP_VERSION,
					'<br /><br /><a href="' . esc_url( get_dashboard_url( get_current_user_id(), 'plugins.php' ) ) . '" class="button button-primary">',
					'</a>'
				)
			);
		}
	}
	register_activation_hook( __FILE__, 'bookwormgb_php_requirement_activation_check' );
}

/**
 * Always check the PHP version at the start.
 * If the PHP version isn't sufficient, don't continue to prevent any unwanted errors.
 *
 * @since 1.9
 */
if ( version_compare( PHP_VERSION, '5.3.0', '<' ) ) {
	if ( ! function_exists( 'bookwormgb_php_requirement_notice' ) ) {
		function bookwormgb_php_requirement_notice() {
	        printf(
	            '<div class="notice notice-error"><p>%s</p></div>',
	            sprintf( __( '"BookwormGB" requires PHP version 5.3.0 or higher, but PHP version %s is used on the site.', BWGB_I18N ), PHP_VERSION )
	        );
		}
	}
	add_action( 'admin_notices', 'bookwormgb_php_requirement_notice' );
	return;
}

/**
 * Always keep note of the BookwormGB version.
 *
 * @since 2.0
 */
if ( ! function_exists( 'bookwormgb_version_upgrade_check' ) ) {
	function bookwormgb_version_upgrade_check() {
		// This is triggered only when V1 was previously activated, and this is the first time V2 is activated.
		// Will not trigger after successive V2 activations.
		if ( get_option( 'bookwormgb_activation_date' ) && ! get_option( 'bookwormgb_current_version_installed' ) ) {
			update_option( 'bookwormgb_current_version_installed', '1' );
		}

		// Always check the current version installed. Trigger if it changes.
		if ( get_option( 'bookwormgb_current_version_installed' ) !== BWGB_VERSION ) {
			do_action( 'bookwormgb_version_upgraded', get_option( 'bookwormgb_current_version_installed' ), BWGB_VERSION );
			update_option( 'bookwormgb_current_version_installed', BWGB_VERSION );
		}
	}
	add_action( 'admin_menu', 'bookwormgb_version_upgrade_check', 1 );
}

if ( ! class_exists( 'Bookworm_Shortcode_Products' ) ) {
	function bookwormgb_extend_wc_product_shortcodes() {
		require_once( plugin_dir_path( __FILE__ ) . 'src/class-bookworm-shortcode-products.php' );
	}
	add_action( 'woocommerce_loaded', 'bookwormgb_extend_wc_product_shortcodes' );
}

/********************************************************************************************
 * END Activation & PHP version checks.
 ********************************************************************************************/

/**
 * Block Initializer.
 */
require_once( plugin_dir_path( __FILE__ ) . 'src/block/disabled-blocks.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/init.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/fonts.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/jetpack.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/metabox.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/footer/index.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/header/index.php' );
// Ajax Functions
require_once( plugin_dir_path( __FILE__ ) . 'src/block/blog-post/ajax-function.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/products/ajax-function.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/products-simple/ajax-function.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/products-carousel/ajax-function.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/product-featured/ajax-function.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/products-list/ajax-function.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/product-categories/ajax-function.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/products-deals-carousel/ajax-function.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/author/ajax-function.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/deal-product/ajax-function.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/single-product-carousel/ajax-function.php' );
require_once( plugin_dir_path( __FILE__ ) . 'src/block/nav-menu/ajax-function.php' );
