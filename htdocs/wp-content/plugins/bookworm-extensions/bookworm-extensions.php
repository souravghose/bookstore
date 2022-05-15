<?php
/**
 * Plugin Name:     Bookworm Extensions
 * Plugin URI:      https://madrasthemes.com/bookworm
 * Description:     This selection of extensions compliment our theme Bookworm. Please note: they don’t work with any WordPress theme, just Bookworm.
 * Author:          MadrasThemes
 * Author URI:      https://madrasthemes.com/
 * Version:         1.1.0
 * Text Domain:     bookworm-extensions
 * Domain Path:     /languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define BOOKWORM_PLUGIN_FILE.
if ( ! defined( 'BOOKWORM_PLUGIN_FILE' ) ) {
	define( 'BOOKWORM_PLUGIN_FILE', __FILE__ );
}

if ( ! class_exists( 'Bookworm_Extensions' ) ) {
	/**
	 * Main Bookworm_Extensions Class
	 *
	 * @class Bookworm_Extensions
	 * @version 1.0.0
	 * @since 1.0.0
	 * @package Bookworm
	 */
	final class Bookworm_Extensions {

		/**
		 * Bookworm_Extensions The single instance of Bookworm_Extensions.
		 *
		 * @var     object
		 * @since   1.0.0
		 */
		private static $instance = null;

		/**
		 * The token.
		 *
		 * @var     string
		 * @since   1.0.0
		 */
		public $token;

		/**
		 * The version number.
		 *
		 * @var     string
		 * @since   1.0.0
		 */
		public $version;

		/**
		 * Constructor function.
		 *
		 * @since   1.0.0
		 * @return  void
		 */
		public function __construct() {

			$this->token   = 'bookworm-extensions';
			$this->version = '1.0.0';

			add_action( 'plugins_loaded', array( $this, 'setup_constants' ), 10 );
			add_action( 'plugins_loaded', array( $this, 'includes' ), 20 );
		}

		/**
		 * Main Bookworm_Extensions Instance
		 *
		 * Ensures only one instance of Bookworm_Extensions is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 * @static
		 * @see Bookworm_Extensions()
		 * @return Main Bookworm instance
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Setup plugin constants
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function setup_constants() {

			// Plugin Folder Path.
			if ( ! defined( 'BOOKWORM_EXTENSIONS_DIR' ) ) {
				define( 'BOOKWORM_EXTENSIONS_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL.
			if ( ! defined( 'BOOKWORM_EXTENSIONS_URL' ) ) {
				define( 'BOOKWORM_EXTENSIONS_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File.
			if ( ! defined( 'BOOKWORM_EXTENSIONS_FILE' ) ) {
				define( 'BOOKWORM_EXTENSIONS_FILE', __FILE__ );
			}

			// Modules File.
			if ( ! defined( 'BOOKWORM_MODULES_DIR' ) ) {
				define( 'BOOKWORM_MODULES_DIR', BOOKWORM_EXTENSIONS_DIR . '/modules' );
			}

			$this->define( 'BOOKWORM_ABSPATH', dirname( BOOKWORM_EXTENSIONS_FILE ) . '/' );
			$this->define( 'BOOKWORM_VERSION', $this->version );
		}

		/**
		 * Define constant if not already set.
		 *
		 * @param string      $name  Constant name.
		 * @param string|bool $value Constant value.
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * What type of request is this?
		 *
		 * @param  string $type admin, ajax, cron or bookwormend.
		 * @return bool
		 */
		private function is_request( $type ) {
			switch ( $type ) {
				case 'admin':
					return is_admin();
				case 'ajax':
					return defined( 'DOING_AJAX' );
				case 'cron':
					return defined( 'DOING_CRON' );
				case 'bookwormend':
					return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' ) && ! $this->is_rest_api_request();
			}
		}

		/**
		 * Include required files
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function includes() {

			/**
			 * Core classes.
			 */
			require BOOKWORM_EXTENSIONS_DIR . '/includes/functions.php';

			/**
			 * Theme Shortcodes
			 */
			require_once BOOKWORM_MODULES_DIR . '/theme-shortcodes/theme-shortcodes.php';

		}

		/**
		 * Get the plugin url.
		 *
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', BOOKWORM_PLUGIN_FILE ) );
		}

		/**
		 * Cloning is forbidden.
		 *
		 * @since 1.0.0
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'bookworm-extensions' ), '1.0.0' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 *
		 * @since 1.0.0
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'bookworm-extensions' ), '1.0.0' );
		}
	}
}

/**
 * Returns the main instance of Bookworm_Extensions to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Bookworm_Extensions
 */
function Bookworm_Extensions() { //phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return Bookworm_Extensions::instance();
}

/**
 * Initialise the plugin
 */
Bookworm_Extensions();
