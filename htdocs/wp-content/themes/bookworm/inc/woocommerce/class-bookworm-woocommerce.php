<?php
/**
 * Bookworm WooCommerce Class
 *
 * @package  bookworm
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
define( 'BOOKWORM_WC_VIEW_COOKIE', 'bookworm_wc_view' );

if ( ! class_exists( 'Bookworm_WooCommerce' ) ) :

    /**
     * The Bookworm WooCommerce Integration class
     */
    class Bookworm_WooCommerce {

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {
            $this->includes();
            $this->init_hooks();
        }

        /**
         * Includes classes and other files required
         */
        public function includes() {
            require_once get_template_directory() . '/inc/woocommerce/classes/class-bookworm-wc-helper.php';
        }
        /**
         * Setup class.
         *
         * @since 1.0
         */
        private function init_hooks(){

            add_action( 'after_setup_theme', array( $this, 'setup' ) );
            add_action( 'widgets_init', array( $this, 'widgets_init' ), 10 );
            add_filter( 'dynamic_sidebar_params', array( $this, 'dynamic_wc_shop_sidebar_params' ) );
            add_filter( 'body_class', array( $this, 'woocommerce_body_class' ) );
            add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
            add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'change_breadcrumb_delimiter' ) );
            add_filter( 'woocommerce_show_page_title', '__return_false' );
            add_filter( 'bookworm_enable_page_header', array( $this, 'toggle_page_header' ) );
            add_filter( 'woocommerce_post_class', array( $this, 'product_class' ), 10 );
            add_filter( 'woocommerce_product_additional_information_tab_title', array( $this, 'rename_additional_information_tab_title' ), 20 );
            add_filter( 'woocommerce_product_description_heading', '__return_false' );
            add_filter( 'woocommerce_product_additional_information_heading', '__return_false' );
            // Integrations.
            add_action( 'bookworm_woocommerce_setup', array( $this, 'setup_integrations' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'woocommerce_integrations_scripts' ), 99 );
        }

        public function rename_additional_information_tab_title( $tab_title ) {
            return esc_html__( 'Product Details', 'bookworm' );
        }

        public function product_class( $classes ) {
            if ( bookworm_is_product_archive() ) {
                $classes[] = 'col';    
            }

            if ( is_product() && empty( wc_get_loop_prop( 'name' ) ) ) {
                $classes[] = 'single-product__content';
                $classes[] = 'single-product__' . bookworm_get_single_product_version();
            }

            return $classes;
        }

        /**
         * Sets up theme defaults and registers support for various WooCommerce features.
         *
         * Note that this function is hooked into the after_setup_theme hook, which
         * runs before the init hook. The init hook is too late for some features, such
         * as indicating support for post thumbnails.
         *
         * @since 1.0.0
         * @return void
         */
        public function setup() {
            add_theme_support(
                'woocommerce', apply_filters(
                    'bookworm_woocommerce_args', array(
                        'single_image_width'    => 300,
                        'thumbnail_image_width' => 150,
                        'product_grid'          => array(
                            'default_columns' => 4,
                            'default_rows'    => 5,
                            'min_columns'     => 1,
                            'max_columns'     => 6,
                            'min_rows'        => 1,
                        ),
                    )
                )
            );

            add_theme_support( 'wc-product-gallery-lightbox' );
            add_theme_support( 'wc-product-gallery-slider' );

            /**
             * Add 'bookworm_woocommerce_setup' action.
             *
             * @since  1.0.0
             */
            do_action( 'bookworm_woocommerce_setup' );
        }

        public function get_wc_shop_sidebar_args() {
            $sidebar_args['shop_sidebar'] = array(
                'name'        => esc_html__( 'Shop Sidebar', 'bookworm' ),
                'id'          => 'sidebar-shop',
                'description' => '',
            );

            return apply_filters( 'bookworm_wc_shop_sidebar_args', $sidebar_args );
        }

        /**
         * Register widget area used by WooCommerce.
         *
         * @link https://codex.wordpress.org/Function_Reference/register_sidebar
         */
        public function widgets_init() {

            $sidebar_args = $this->get_wc_shop_sidebar_args();

            foreach ( $sidebar_args as $sidebar => $args ) {
                $widget_tags = array(
                    'before_widget' => '<div id="%1$s" class="widget border p-4d875 %2$s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<div class="widget-head"><h3 class="widget-title font-weight-medium font-size-3 mb-4">',
                    'after_title'   => '</h3></div>',
                );

                /**
                 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
                 *
                 * 'bookworm_shop_sidebar_widget_tags'
                 */
                $filter_hook = sprintf( 'bookworm_%s_widget_tags', $sidebar );
                $widget_tags = apply_filters( $filter_hook, $widget_tags );

                if ( is_array( $widget_tags ) ) {
                    register_sidebar( $args + $widget_tags );
                }
            }

            register_sidebar( [
                'id'            => 'sidebar-single',
                'name'          => esc_html__( 'Single Sidebar', 'bookworm' ),
                'description'   => '',
                'before_widget' => '<div id="%1$s" class="widget p-4d875 border mb-5 %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widget-title font-weight-medium font-size-3">',
                'after_title'   => '</h3>',
            ] );

        }

        /**
         * Include Collapse Args on Shop Dynamic Sidebar
         *
         * @link https://developer.wordpress.org/reference/functions/dynamic_sidebar/
         */
        public function dynamic_wc_shop_sidebar_params( $params ) {
            $sidebar_args = $this->get_wc_shop_sidebar_args();

            if( isset( $params[0] ) && isset( $params[0]['id'] ) && in_array( $params[0]['id'], array_column( $sidebar_args, 'id' ) ) ) {
                global $wp_registered_widgets;

                $widget_id = $params[0]['widget_id'];
                $settings_getter = $wp_registered_widgets[ $widget_id ]['callback'][0];
                $get_settings = $settings_getter->get_settings();
                $settings = $get_settings[ $params[1]['number'] ];

                if ( isset( $settings['title'] ) && ! empty( $settings['title'] ) ) {
                    $minus = '<svg class="mins" width="15px" height="2px"><path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M0.000,-0.000 L15.000,-0.000 L15.000,2.000 L0.000,2.000 L0.000,-0.000 Z"></path></svg>';
                    $plus  = '<svg class="plus" width="15px" height="15px"><path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M15.000,8.000 L9.000,8.000 L9.000,15.000 L7.000,15.000 L7.000,8.000 L0.000,8.000 L0.000,6.000 L7.000,6.000 L7.000,-0.000 L9.000,-0.000 L9.000,6.000 L15.000,6.000 L15.000,8.000 Z"></path></svg>';

                    $params[0]['before_title'] = '<div class="widget-head" id="widgetHeading-' . esc_attr( $widget_id ) . '"><a class="d-flex align-items-center justify-content-between text-dark" href="#" data-toggle="collapse" data-target="#widget-collapse-' . esc_attr( $widget_id ) . '" aria-expanded="true" aria-controls="widget-collapse-' . esc_attr( $widget_id ) . '"><h3 class="widget-title font-weight-medium font-size-3 mb-0">';
                    $params[0]['after_title'] = '</h3>' . $minus . $plus . '</a></div><div id="widget-collapse-' . esc_attr(  $widget_id ) . '" class="mt-4 widget-content collapse show" aria-labelledby="widgetHeading-' . esc_attr( $widget_id ) . '" >';
                    $params[0]['after_widget'] = '</div></div>';
                }

            }

            return $params;
        }

        public function toggle_page_header( $enabled ) {
            if ( is_account_page() ) {
                $enabled = false;
            }

            if ( is_cart() ) {
                $enabled = false;
            }

            return $enabled;
        }

        /**
         * Query WooCommerce Extension Activation.
         *
         * @param string $extension Extension class name.
         * @return boolean
         */
        public function is_woocommerce_extension_activated( $extension = 'WC_Bookings' ) {
            return class_exists( $extension ) ? true : false;
        }

        /**
         * Remove the breadcrumb delimiter
         *
         * @param  array $defaults The breadcrumb defaults.
         * @return array           The breadcrumb defaults.
         * @since 2.2.0
         */
        public function change_breadcrumb_delimiter( $defaults ) {
            $defaults['delimiter']   = '<span class="breadcrumb-separator mx-2"><i class="fas fa-angle-right"></i></span>';
            $defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb font-size-2">';
            $defaults['wrap_after']  = '</nav>';
            return $defaults;
        }

        /**
         * Add WooCommerce specific classes to the body tag
         *
         * @param  array $classes css classes applied to the body tag.
         * @return array $classes modified to include 'woocommerce-active' class
         */
        public function woocommerce_body_class( $classes ) {
            $classes[] = 'woocommerce-active';

            // Remove `no-wc-breadcrumb` body class.
            $key = array_search( 'no-wc-breadcrumb', $classes, true );

            if ( false !== $key ) {
                unset( $classes[ $key ] );
            }

            if ( bookworm_product_archive_has_sidebar() ) {
                $classes[] = bookworm_get_product_archive_layout();
            }

            if ( bookworm_single_product_has_sidebar() ) {
                $classes[] = bookworm_get_single_product_layout();
            }

            if ( is_cart() ) {
                $classes[] = 'right-sidebar';
            }

            if( bookworm_is_wc_single_product_variations_radio_style() ) {
                $classes[] = 'bookworm-variations-radio-style-enabled';
            }


            return $classes;
        }

        /**
         * Integration Styles & Scripts
         *
         * @return void
         */
        public function woocommerce_integrations_scripts() {
            global $bookworm_version;

            /**
             * YITH WooCommerce Wishlist
             */
            if ( $this->is_woocommerce_extension_activated( 'YITH_WCWL_Frontend' ) ) {
                global $yith_wcwl;
                wp_dequeue_style( 'yith-wcwl-main' );
                wp_dequeue_style( 'yith-wcwl-font-awesome' );
                add_action( 'woocommerce_after_shop_loop_item',           'bookworm_add_to_wishlist_button', 170 );
            }

            if( bookworm_is_wc_single_product_variations_radio_style() ) {
                wp_enqueue_script( 'bookworm-variation-radio-scripts', get_template_directory_uri() . '/assets/js/variation-radio-scripts.js', [ 'jquery' ], $bookworm_version, true );
            }

            global $post;
            if( ( is_product() || ( ! empty( $post->post_content ) && strstr( $post->post_content, '[product_page' ) ) ) && bookworm_get_single_product_version() !== 'v7' ) {
                add_filter( 'woocommerce_single_product_flexslider_enabled', '__return_false' );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Integrations.
        |--------------------------------------------------------------------------
        */

        /**
         * Sets up integrations.
         *
         * @since  1.0.0
         *
         * @return void
         */
        public function setup_integrations() {
            /**
             * YITH WooCompare
             */
            if ( $this->is_woocommerce_extension_activated( 'YITH_Woocompare_Frontend' ) ) {
                global $yith_woocompare;
                remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
                remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj, 'add_compare_link' ), 35 );
                if ( get_option( 'yith_woocompare_compare_button_in_products_list', 'no' ) == 'yes' ) {
                    add_action( 'woocommerce_after_shop_loop_item', 'bookworm_add_compare_link', 10 );
                    add_action( 'woocommerce_after_shop_loop_item',           'bookworm_add_compare_link', 160 );
                }

                add_filter( 'bookworm_localize_script_data', 'bookworm_add_compare_url_to_localize_data' );
                add_filter( 'yith_woocompare_general_settings', 'bookworm_update_yith_compare_options' );

            }
        }
    }

endif;

return new Bookworm_WooCommerce();
