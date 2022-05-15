<?php
/**
 * Bookworm WooCommerce Customizer Class
 *
 * @package  bookworm
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Bookworm_WooCommerce_Customizer' ) ) :

    /**
     * The Bookworm Customizer class
     */
    class Bookworm_WooCommerce_Customizer extends Bookworm_Customizer {

        /**
         * Setup class.
         *
         * @since 1.0.0
         * @return void
         */
        public function __construct() {
            add_action( 'customize_register', array( $this, 'customize_catalog_settings' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_shop_settings' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_product_page_register' ), 10 );
        }

        /**
         * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         * @since 1.0.0
         */
        public function customize_catalog_settings( $wp_customize ) {
            if ( has_filter( 'loop_shop_per_page' ) ) {
                $wp_customize->add_setting(
                    'woocommerce_catalog_rows',
                    array(
                        'default'              => 4,
                        'type'                 => 'option',
                        'capability'           => 'manage_woocommerce',
                        'sanitize_callback'    => 'absint',
                        'sanitize_js_callback' => 'absint',
                    )
                );
            }

            $wp_customize->add_control(
                'woocommerce_catalog_rows',
                array(
                    'label'       => esc_html__( 'Rows per page', 'bookworm' ),
                    'description' => esc_html__( 'How many rows of products should be shown per page?', 'bookworm' ),
                    'section'     => 'woocommerce_product_catalog',
                    'settings'    => 'woocommerce_catalog_rows',
                    'type'        => 'number',
                    'input_attrs' => array(
                        'min'  => wc_get_theme_support( 'product_grid::min_rows', 1 ),
                        'max'  => wc_get_theme_support( 'product_grid::max_rows', '' ),
                        'step' => 1,
                    ),
                )
            );
        }

        /**
         * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         * @since 1.0.0
         */
        public function customize_shop_settings( $wp_customize ) {

            /**
             * Shop page
             */

            global $bookworm;

            $wp_customize->add_section(
                'bookworm_shop', array(
                    'title'       => esc_html__( 'Shop Page', 'bookworm' ),
                    'description' => esc_html__( 'This section contains settings related to products listing and archives.', 'bookworm' ),
                    'priority'    => 30,
                    'panel'       => 'woocommerce',
                )
            );

            $wp_customize->add_setting(
                'product_archive_layout', array(
                    'default'           => 'left-sidebar',
                    'capability'        => 'edit_theme_options',
                    'sanitize_callback' => 'sanitize_key',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                'product_archive_layout', array(
                    'type'        => 'select',
                    'section'     => 'bookworm_shop',
                    /* translators: label field of control in Customizer */
                    'label'       => esc_html__( 'Shop Sidebar', 'bookworm' ),
                    'description' => esc_html__( 'Select from the three sidebar layouts for shop', 'bookworm' ),
                    'choices'     => [
                        'left-sidebar'  => esc_html__( 'Left Sidebar', 'bookworm' ),
                        'right-sidebar' => esc_html__( 'Right Sidebar', 'bookworm' ),
                        'full-width'    => esc_html__( 'Full Width', 'bookworm' ),
                    ],
                    'priority'    => 10,
                )
            );

            $wp_customize->selective_refresh->add_partial( 'product_archive_layout', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting(
                'bookworm_wc_jumbotron', array(
                    'default'           => 0,
                    'capability'        => 'edit_theme_options',
                    'sanitize_callback' => 'absint',
                )
            );
            
            $wp_customize->add_control(
                'bookworm_wc_jumbotron', array(
                    'section'     => 'bookworm_shop',
                    'label'       => esc_html__( 'Shop Top Jumbotron', 'bookworm' ),
                    'description' => esc_html__( 'Choose a static block that will be the jumbotron element for shop page', 'bookworm' ),
                    'type'        => 'select',
                    'choices'     => $this->mas_static_content_options(),
                    'active_callback' => function () {
                        return bookworm_is_mas_static_content_activated();
                    }
                )
            );

            $wp_customize->add_setting(
                'bookworm_catalog_layout', array(
                    'default'           => 'grid',
                    'sanitize_callback' => 'sanitize_key',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                'bookworm_catalog_layout', array(
                    'type'        => 'select',
                    'section'     => 'bookworm_shop',
                    'label'       => esc_html__( 'Shop Layout', 'bookworm' ),
                    'description' => esc_html__( 'Applicable for both shop page and category views.', 'bookworm' ),
                    'choices'     => [
                        'grid'            => esc_html__( 'Grid', 'bookworm' ),
                        'list'            => esc_html__( 'List', 'bookworm' ),
                    ],
                    'priority'    => 20,
                )
            );

            $wp_customize->selective_refresh->add_partial( 'bookworm_catalog_layout', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting(
                'bookworm_enable_page_header_background', array(
                    'default'           => 'no',
                    'sanitize_callback' => 'sanitize_key',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                'bookworm_enable_page_header_background', array(
                    'type'        => 'radio',
                    'section'     => 'bookworm_shop',
                    'label'       => esc_html__( 'Enable Page Header Background', 'bookworm' ),
                    'description' => esc_html__( 'This setting allows you to enable background for page header', 'bookworm' ),
                    'choices'     => [
                        'yes' => esc_html__( 'Yes', 'bookworm' ),
                        'no'  => esc_html__( 'No', 'bookworm' ),
                    ],
                )
            );

            $wp_customize->selective_refresh->add_partial( 'bookworm_enable_page_header_background', [
                'fallback_refresh'    => true
            ] );



            $wp_customize->add_setting(
                'page_header_backround', array(
                    'default'           => 0,
                    'sanitize_callback' => 'absint',
                )
            );


            $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 
                'page_header_backround', array(
                    'section'     => 'bookworm_shop',
                    'label'       => esc_html__( 'Upload page header background image', 'bookworm' ),
                    'description' => esc_html__(
                        'This setting allows you to upload an image for page header.',
                        'bookworm'
                    ),
                    'mime_type'   => 'image',
                    'active_callback' => function () {
                        return get_theme_mod( 'bookworm_enable_page_header_background', 'yes' ) === 'yes';
                    }
                )
            ));

            $wp_customize->selective_refresh->add_partial( 'page_header_backround', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting(
                'compare_page_id', array(
                    'capability' => 'edit_theme_options',
                    'sanitize_callback' => 'sanitize_key',
                )
            );

            $wp_customize->add_control(
                'compare_page_id', array(
                    'section'     => 'bookworm_shop',
                    'label'       => esc_html__( 'Shop Comparison Page', 'bookworm' ),
                    'description' => esc_html__( 'Choose a page that will be the product compare page for shop.', 'bookworm' ),
                    'type'        => 'dropdown-pages',
                )
            );

            $wp_customize->selective_refresh->add_partial( 'compare_page_id', [
                'fallback_refresh'    => true
            ] );

        }

        /**
         * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         * @since 1.0.0
         */
        public function customize_product_page_register( $wp_customize ) {

            /**
             * Product Page
             */
            $wp_customize->add_section(
                'bookworm_product_page', array(
                    'title'       => esc_html__( 'Product Page', 'bookworm' ),
                    'description' => esc_html__( 'This section contains settings related to single product page', 'bookworm' ),
                    'priority'    => 30,
                    'panel'       => 'woocommerce',
                )
            );

            $wp_customize->add_setting(
                'product_style', array(
                    'default'           => 'v1',
                    'sanitize_callback' => 'sanitize_key',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                'product_style', array(
                    'type'        => 'select',
                    'section'     => 'bookworm_product_page',
                    'label'       => esc_html__( 'Single Product Style', 'bookworm' ),
                    'description' => esc_html__( 'Select the style for single product page', 'bookworm' ),
                    'choices'     => [
                        'v1'            => esc_html__( 'Shop Single v1', 'bookworm' ),
                        'v2'            => esc_html__( 'Shop Single v2', 'bookworm' ),
                        'v3'            => esc_html__( 'Shop Single v3', 'bookworm' ),
                        'v4'            => esc_html__( 'Shop Single v4', 'bookworm' ),
                        'v5'            => esc_html__( 'Shop Single v5', 'bookworm' ),
                        'v6'            => esc_html__( 'Shop Single v6', 'bookworm' ),
                        'v7'            => esc_html__( 'Shop Single v7', 'bookworm' ),
                    ],
                    'priority'    => 10,
                )
            );

            $wp_customize->selective_refresh->add_partial( 'product_style', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting(
                'bookworm_wc_single_product_jumbotron', array(
                    'default'           => 0,
                    'capability'        => 'edit_theme_options',
                    'sanitize_callback' => 'absint',
                )
            );
            
            $wp_customize->add_control(
                'bookworm_wc_single_product_jumbotron', array(
                    'section'     => 'bookworm_product_page',
                    'label'       => esc_html__( 'Shop Single Jumbotron', 'bookworm' ),
                    'description' => esc_html__( 'Choose a static block that will be the jumbotron element for shop sinlgle page', 'bookworm' ),
                    'type'        => 'select',
                    'choices'     => $this->mas_static_content_options(),
                    'active_callback' => function () {
                        return in_array( get_theme_mod( 'product_style' ), [
                        'v2',
                        ] ) && bookworm_is_mas_static_content_activated();
                    }
                )
            );

            $wp_customize->selective_refresh->add_partial( 'bookworm_wc_single_product_jumbotron', [
                'fallback_refresh'    => true
            ] );
            $wp_customize->add_setting(
                'single_product_layout', array(
                    'default'           => 'right-sidebar',
                    'capability'        => 'edit_theme_options',
                    'sanitize_callback' => 'sanitize_key',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                'single_product_layout', array(
                    'type'        => 'select',
                    'section'     => 'bookworm_product_page',
                    /* translators: label field of control in Customizer */
                    'label'       => esc_html__( 'Single Product Sidebar', 'bookworm' ),
                    'description' => esc_html__( 'Select from the three sidebar layouts for single product page', 'bookworm' ),
                    'choices'     => [
                        'left-sidebar'  => esc_html__( 'Left Sidebar', 'bookworm' ),
                        'right-sidebar' => esc_html__( 'Right Sidebar', 'bookworm' ),
                        'full-width'    => esc_html__( 'Full Width', 'bookworm' ),
                    ],
                    'active_callback' => function () {
                        return in_array( get_theme_mod( 'product_style' ), ['v4'] );
                    }
            
                )
            );

            $wp_customize->selective_refresh->add_partial( 'single_product_layout', [
                'fallback_refresh'    => true
            ] );
            
        }

    }

endif;

return new Bookworm_WooCommerce_Customizer();