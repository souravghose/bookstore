<?php

/**
 * Module Name          : Theme Shortcodes
 * Module Description   : Provides additional shortcodes for the Bookworm theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists( 'Bookworm_Shortcodes' ) ) {
    class Bookworm_Shortcodes {

        /**
         * Constructor function.
         * @access  public
         * @since   1.0.0
         * @return  void
         */
        public function __construct() {
            add_action( 'init', array( $this, 'setup_constants' ),  10 );
            add_action( 'init', array( $this, 'includes' ),         10 );
        }

        /**
         * Setup plugin constants
         *
         * @access public
         * @since  1.0.0
         * @return void
         */
        public function setup_constants() {

            // Plugin Folder Path
            if ( ! defined( 'BOOKWORM_EXTENSIONS_SHORTCODE_DIR' ) ) {
                define( 'BOOKWORM_EXTENSIONS_SHORTCODE_DIR', plugin_dir_path( __FILE__ ) );
            }

            // Plugin Folder URL
            if ( ! defined( 'BOOKWORM_EXTENSIONS_SHORTCODE_URL' ) ) {
                define( 'BOOKWORM_EXTENSIONS_SHORTCODE_URL', plugin_dir_url( __FILE__ ) );
            }

            // Plugin Root File
            if ( ! defined( 'BOOKWORM_EXTENSIONS_SHORTCODE_FILE' ) ) {
                define( 'BOOKWORM_EXTENSIONS_SHORTCODE_FILE', __FILE__ );
            }
        }

        /**
         * Include required files
         *
         * @access public
         * @since  1.0.0
         * @return void
         */
        public function includes() {

            #-----------------------------------------------------------------
            # Shortcodes
            #-----------------------------------------------------------------
            if( class_exists( 'Mas_WC_Brands' ) ) {
                require_once BOOKWORM_EXTENSIONS_SHORTCODE_DIR . '/elements/authors-list.php';
            }
            require_once BOOKWORM_EXTENSIONS_SHORTCODE_DIR . '/elements/compare-page.php';
      
        }
    }
}

// Finally initialize code
new Bookworm_Shortcodes();
