<?php
/**
 * Bookworm Customizer Class
 *
 * @package  bookworm
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Bookworm_Customizer' ) ) :

    /**
     * The Bookworm Customizer class
     */
    class Bookworm_Customizer {

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {
            add_action( 'customize_register', array( $this, 'customize_logos' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_general' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_header' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_blog' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_footer' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_404' ), 10 );
            add_action( 'customize_register', array( $this, 'customize_customcolor' ), 10 );
        }


        /**
         * Customize all available site logos
         *
         * All logos located in title_tagline (Site Identity) section.
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_logos( $wp_customize ) {
            $this->add_customize_logos( $wp_customize );
        }

        private function add_customize_logos( $wp_customize ) {
            $wp_customize->get_control( 'custom_logo' )->description = esc_html__(
                'Logo is optimized for retina displays, so the original image size should be twice
                as big as the final logo that appears on the website. For example, if you want logo to
                be 142x34 px you should upload image 284x68 px.',
                'bookworm'
            );

            // Update the "custom_logo" partial with a new render callback
            // TODO: wrap into anonymous function with return context
            $wp_customize->selective_refresh->get_partial( 'custom_logo' )->render_callback = 'bookworm_site_title_or_logo';
            //</editor-fold>


            //<editor-fold desc="footer_logo">
            $wp_customize->add_setting( 'footer_logo', [
                'transport'      => 'postMessage',
                'theme_supports' => 'custom-logo',
                'sanitize_callback' => 'absint',
            ] );
            $wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'footer_logo', [
                'section'       => 'title_tagline',
                /* translators: label field for setting in Customizer */
                'label'         => esc_html__( 'Footer Logo', 'bookworm' ),
                /* translators: description field for setting in Customizer */
                'description'   => esc_html__( 'Footer logo inherits the same behavior for retina displays as desktop logo.', 'bookworm' ),
                'priority'      => 9,
                'width'         => 234,
                'height'        => 56,
                'flex_width'    => true,
                'flex_height'   => true,
                'button_labels' => [
                    'select'       => esc_html__( 'Select logo', 'bookworm' ),
                    'change'       => esc_html__( 'Change logo', 'bookworm' ),
                    'remove'       => esc_html__( 'Remove', 'bookworm' ),
                    'default'      => esc_html__( 'Default', 'bookworm' ),
                    'placeholder'  => esc_html__( 'No logo selected', 'bookworm' ),
                    'frame_title'  => esc_html__( 'Select logo', 'bookworm' ),
                    'frame_button' => esc_html__( 'Choose logo', 'bookworm' ),
                ],
            ] ) );
            $wp_customize->selective_refresh->add_partial( 'footer_logo', [
                'selector'            => '.footer-logo-link',
                'container_inclusive' => true,
                'render_callback'     => 'bookworm_footer_logo',
            ] );

            $wp_customize->add_setting( 'enable_logo', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'enable_logo', [
                'type'        => 'radio',
                'section'     => 'title_tagline',
                'label'       => esc_html__( 'Enable SVG Logo?', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
            ] );
            $wp_customize->selective_refresh->add_partial( 'enable_logo', [
                'fallback_refresh'    => true
            ] );


        }

        /**
         * Customize site header
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_general( $wp_customize ) {
            $wp_customize->add_section( 'bookworm_general', [
                'title'       => esc_html__( 'General', 'bookworm' ),
                'description' => esc_html__( 'This section contains settings related to general.', 'bookworm' ),
                'priority'    => 20,
            ] );

            $this->add_general_section( $wp_customize );
        }

        private function add_general_section( $wp_customize ) {
            $wp_customize->add_setting( 'enable_ajax_content_placeholder', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'enable_ajax_content_placeholder', [
                'type'        => 'radio',
                'section'     => 'bookworm_general',
                'label'       => esc_html__( 'Disable AJAX content placeholder', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
                
            ] );
            $wp_customize->selective_refresh->add_partial( 'enable_ajax_content_placeholder', [
                'fallback_refresh'    => true
            ] );
        }


        /**
         * Customize site header
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_header( $wp_customize ) {
            $wp_customize->add_panel( 'bookworm_header', [
                'title'       => esc_html__( 'Header', 'bookworm' ),
                'description' => esc_html__( 'This section contains settings related to header.', 'bookworm' ),
                'priority'    => 30,
            ] );

            $this->add_header_general_section( $wp_customize );
            $this->add_header_support_section( $wp_customize );
        }

        private function add_header_general_section( $wp_customize ) {
            $wp_customize->add_section( 'bookworm_header_general', [
                'title'       => esc_html__( 'General', 'bookworm' ),
                'description' => esc_html__( 'Contains general settings for header customization.', 'bookworm' ),
                'panel'       => 'bookworm_header',
            ] );

            $wp_customize->add_setting( 'header_version', [
                'default'           => 'v1',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'header_version', [
                'type'        => 'select',
                'section'     => 'bookworm_header_general',
                'label'       => esc_html__( 'Header Version', 'bookworm' ),
                'description' => esc_html__( 'This setting allows you to choose the desired version of header.', 'bookworm' ),
                'choices'     => [
                    'v1'    => esc_html__( 'Header v1', 'bookworm' ),
                    'v2'    => esc_html__( 'Header v2', 'bookworm' ),
                    'v3'    => esc_html__( 'Header v3', 'bookworm' ),
                    'v4'    => esc_html__( 'Header v4', 'bookworm' ),
                    'v5'    => esc_html__( 'Header v5', 'bookworm' ),
                    'v6'    => esc_html__( 'Header v6', 'bookworm' ),
                    'v7'    => esc_html__( 'Header v7', 'bookworm' ),
                    'v8'    => esc_html__( 'Header v8', 'bookworm' ),
                    'v9'    => esc_html__( 'Header v9', 'bookworm' ),
                    'v10'   => esc_html__( 'Header v10', 'bookworm' ),
                    'v11'   => esc_html__( 'Header v11', 'bookworm' ),
                    'v12'   => esc_html__( 'Header v12', 'bookworm' ),
                    'v13'   => esc_html__( 'Header v13', 'bookworm' ),
                ],
            ] );
            $wp_customize->selective_refresh->add_partial( 'header_version', [
                'fallback_refresh'    => true
            ] );

            

            $wp_customize->add_setting( 'enable_topbar', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'enable_topbar', [
                'type'        => 'radio',
                'section'     => 'bookworm_header_general',
                'label'       => esc_html__( 'Enable Topbar?', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v1',
                        'v3',
                        'v6',
                        'v7',
                        'v10',
                        'v12',
                        'v13',
                    ] );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'enable_topbar', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'enable_navbar', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'enable_navbar', [
                'type'        => 'radio',
                'section'     => 'bookworm_header_general',
                'label'       => esc_html__( 'Enable Navbar?', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v2',
                        'v9',
                        'v12',
                    ] );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'enable_navbar', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'enable_offcanvas_nav', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'enable_offcanvas_nav', [
                'type'        => 'radio',
                'section'     => 'bookworm_header_general',
                'label'       => esc_html__( 'Enable Offcanvas Nav?', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
            ] );
            $wp_customize->selective_refresh->add_partial( 'enable_offcanvas_nav', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'offcanvas_toggler_title', [
                'default'           => esc_html__( 'Browse categories', 'bookworm' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );
            $wp_customize->add_control( 'offcanvas_toggler_title', [
                'type'            => 'text',
                'priority'        => 20,
                'section'         => 'bookworm_header_general',
                'label'           => esc_html__( 'Offcanvas Nav Title', 'bookworm' ),
                'description'     => esc_html__( 'This setting allows you to change "Browse categories" word to something else in offcanvas nav toggler.', 'bookworm' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v3',
                        'v7',
                    ] ) && filter_var( get_theme_mod( 'enable_offcanvas_nav' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'offcanvas_toggler_title', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'offcanvas_header_title', [
                'default'           => esc_html__( 'MENU', 'bookworm' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );
            $wp_customize->add_control( 'offcanvas_header_title', [
                'type'            => 'text',
                'priority'        => 30,
                'section'         => 'bookworm_header_general',
                'label'           => esc_html__( 'Offcanvas Nav Title', 'bookworm' ),
                'description'     => esc_html__( 'This setting allows you to change "Menu" word to something else.', 'bookworm' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v1',
                        'v3',
                        'v7',
                    ] ) && filter_var( get_theme_mod( 'enable_offcanvas_nav' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'offcanvas_header_title', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'header_is_sticky', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'header_is_sticky', [
                'type'        => 'radio',
                'section'     => 'bookworm_header_general',
                'label'       => esc_html__( 'Make header sticky?', 'bookworm' ),
                'description' => esc_html__(
                    'Sticky means that navbar is locked into place so that it does not disappear when the user scrolls down the page.',
                    'bookworm'
                ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
            ] );


            $wp_customize->add_setting( 'enable_cart', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_cart', [
                'type'        => 'radio',
                'section'     => 'bookworm_header_general',
                'label'       => esc_html__( 'Show cart?', 'bookworm' ),
                'description' => esc_html__( 'Enable / disable mini cart in Header.', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
                'active_callback' => function () {
                    bookworm_is_woocommerce_activated();
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_cart', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'enable_account', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_account', [
                'type'        => 'radio',
                'section'     => 'bookworm_header_general',
                'label'       => esc_html__( 'Show My Account?', 'bookworm' ),
                'description' => esc_html__( 'Enable / disable account in Header.', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
                'active_callback' => function () {
                    bookworm_is_woocommerce_activated();
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_account', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'enable_wishlist', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_wishlist', [
                'type'        => 'radio',
                'section'     => 'bookworm_header_general',
                'label'       => esc_html__( 'Show Wishlist', 'bookworm' ),
                'description' => esc_html__( 'Enable / disable wishlist in Header.', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v1',
                        'v3',
                        'v4',
                        'v5',
                        'v6',
                        'v7',
                        'v8',
                        'v10',
                        'v11',
                        'v13',
                    ] ) && bookworm_is_woocommerce_activated();
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_wishlist', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'enable_compare', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_compare', [
                'type'        => 'radio',
                'section'     => 'bookworm_header_general',
                'label'       => esc_html__( 'Show Compare', 'bookworm' ),
                'description' => esc_html__( 'Enable / disable compare in Header.', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v1',
                        'v3',
                        'v11',
                        'v13',
                    ] ) && bookworm_is_woocommerce_activated();
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_compare', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'enable_department_menu', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'enable_department_menu', [
                'type'        => 'radio',
                'priority'        => 40,
                'section'     => 'bookworm_header_general',
                'label'       => esc_html__( 'Enable Department Menu?', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v4',
                        'v5',
                    ] );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'enable_department_menu', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'department_menu_toggler_title', [
                'default'           => esc_html__( 'Browse categories', 'bookworm' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );
            $wp_customize->add_control( 'department_menu_toggler_title', [
                'type'            => 'text',
                'priority'        => 50,
                'section'         => 'bookworm_header_general',
                'label'           => esc_html__( 'Department Menu Toggler Title', 'bookworm' ),
                'description'     => esc_html__( 'This setting allows you to change "Browse categories" word to something else in department menu toggler.', 'bookworm' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v4',
                        'v5',
                    ] ) && filter_var( get_theme_mod( 'enable_department_menu' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'department_menu_toggler_title', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'enable_store_locator', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_store_locator', [
                'type'        => 'radio',
                'section'     => 'bookworm_header_general',
                'label'       => esc_html__( 'Show Store Locator', 'bookworm' ),
                'description' => esc_html__( 'Enable / disable store locator in Topbar.', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v1',
                    ] ) && bookworm_is_woocommerce_activated();
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_store_locator', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'bookworm_store_location_page', [
                'capability' => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'bookworm_store_location_page', [
                'type'     => 'dropdown-pages',
                'priority' => 20,
                'label'    => esc_html__( 'Select an "Store Location" page', 'bookworm' ),
                'section'  => 'bookworm_header_general',
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v1',
                    ] ) && bookworm_is_woocommerce_activated() && filter_var( get_theme_mod( 'enable_store_locator' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'bookworm_store_location_page', [
                'fallback_refresh'    => true
            ] );


        }

        private function add_header_support_section( $wp_customize ) {
            $wp_customize->add_section( 'bookworm_header_support', [
                'title'       => esc_html__( 'Support', 'bookworm' ),
                'description' => esc_html__( 'Contains support settings for header customization.', 'bookworm' ),
                'panel'       => 'bookworm_header',
            ] );

            $wp_customize->add_setting( 'display_mail_support', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'display_mail_support', [
                'type'        => 'radio',
                'priority'    => 10,
                'section'     => 'bookworm_header_support',
                'label'       => esc_html__( 'Enable Mail Support?', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v3',
                        'v4',
                        'v12',
                    ] );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'display_mail_support', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'mail_support_pre', [
                'default'           => 'info@bookworm.com',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );
            $wp_customize->add_control( 'mail_support_pre', [
                'type'            => 'text',
                'priority'        => 20,
                'section'         => 'bookworm_header_support',
                'label'           => esc_html__( 'Mail Support Pretext', 'bookworm' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v3',
                        'v4',
                        'v12',
                    ] ) && filter_var( get_theme_mod( 'display_mail_support' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'mail_support_pre', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'mail_support_text', [
                'default'           => esc_html__( 'Any questions', 'bookworm' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );
            $wp_customize->add_control( 'mail_support_text', [
                'type'            => 'text',
                'priority'        => 30,
                'section'         => 'bookworm_header_support',
                'label'           => esc_html__( 'Mail Support Title', 'bookworm' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v3',
                        'v4',
                        'v12',
                    ] ) && filter_var( get_theme_mod( 'display_mail_support' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'mail_support_text', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'mail_support_link', [
                'default'           => 'mailto:info@bookworm.com',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );
            $wp_customize->add_control( 'mail_support_link', [
                'type'            => 'text',
                'priority'        => 40,
                'section'         => 'bookworm_header_support',
                'label'           => esc_html__( 'Mail Support Url', 'bookworm' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v3',
                        'v4',
                        'v12',
                    ] ) && filter_var( get_theme_mod( 'display_mail_support' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'mail_support_link', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'mail_support_icon', [
                'default'           => 'flaticon-question',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );
            $wp_customize->add_control( 'mail_support_icon', [
                'type'            => 'text',
                'priority'        => 50,
                'section'         => 'bookworm_header_support',
                'label'           => esc_html__( 'Mail Support Icon Class', 'bookworm' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v3',
                        'v4',
                        'v12',
                    ] ) && filter_var( get_theme_mod( 'display_mail_support' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'mail_support_icon', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'display_tel_support', [
                'default'           => 'yes',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'display_tel_support', [
                'type'        => 'radio',
                'priority'    => 60,
                'section'     => 'bookworm_header_support',
                'label'       => esc_html__( 'Enable Telephone Support?', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v3',
                        'v4',
                        'v12',
                    ] );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'display_tel_support', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'tel_support_pre', [
                'default'           => '+1 246-345-0695',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );
            $wp_customize->add_control( 'tel_support_pre', [
                'type'            => 'text',
                'priority'        => 70,
                'section'         => 'bookworm_header_support',
                'label'           => esc_html__( 'Telephone Support Pretext', 'bookworm' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v3',
                        'v4',
                        'v12',
                    ] ) && filter_var( get_theme_mod( 'display_tel_support' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'tel_support_pre', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'tel_support_text', [
                'default'           => esc_html__( 'Call toll-free', 'bookworm' ),
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );
            $wp_customize->add_control( 'tel_support_text', [
                'type'            => 'text',
                'priority'        => 80,
                'section'         => 'bookworm_header_support',
                'label'           => esc_html__( 'Telephone Support Title', 'bookworm' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v3',
                        'v4',
                        'v12',
                    ] ) && filter_var( get_theme_mod( 'display_tel_support' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'tel_support_text', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'tel_support_link', [
                'default'           => 'tel:+1246-345-0695',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );
            $wp_customize->add_control( 'tel_support_link', [
                'type'            => 'text',
                'priority'        => 90,
                'section'         => 'bookworm_header_support',
                'label'           => esc_html__( 'Telephone Support Url', 'bookworm' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v3',
                        'v4',
                        'v12',
                    ] ) && filter_var( get_theme_mod( 'display_tel_support' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'tel_support_link', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'tel_support_icon', [
                'default'           => 'flaticon-phone',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );
            $wp_customize->add_control( 'tel_support_icon', [
                'type'            => 'text',
                'priority'        => 100,
                'section'         => 'bookworm_header_support',
                'label'           => esc_html__( 'Telephone Support Icon Class', 'bookworm' ),
                'active_callback' => function () {
                    return in_array( get_theme_mod( 'header_version' ), [
                        'v3',
                        'v4',
                        'v12',
                    ] ) && filter_var( get_theme_mod( 'display_tel_support' ), FILTER_VALIDATE_BOOLEAN );
                }
            ] );
            $wp_customize->selective_refresh->add_partial( 'tel_support_icon', [
                'fallback_refresh'    => true
            ] );
        }

        public function customize_404( $wp_customize ) {
            $wp_customize->add_section( 'bookworm_404', [
                'title'    => '404',
                'priority' => 32,
            ] );

            $this->add_404_section( $wp_customize );
        }

        private function add_404_section( $wp_customize ) {
            $wp_customize->add_setting( '404_title', [
                'default'           => esc_html_x( 'Woops, looks like this page does not exist', 'front-end', 'bookworm' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( '404_title', [
                'type'            => 'text',
                'section'         => 'bookworm_404',
                'label'           => esc_html__( 'Title', 'bookworm' ),
                'active_callback' => function () {
                    return (int) get_theme_mod( '404_title' ) <= 0;
                },
            ] );
            $wp_customize->selective_refresh->add_partial( '404_title', [
                'selector'        => '[data-bw-customizer="404_title"]',
                'render_callback' => function () {
                    return esc_html( get_theme_mod( '404_title' ) );
                },
            ] );
            $wp_customize->add_setting( '404_desc', [
                'default'           => esc_html_x( 'You could either go back or go to homepage', 'front-end', 'bookworm' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( '404_desc', [
                'type'            => 'text',
                'section'         => 'bookworm_404',
                'label'           => esc_html__( 'Subtitle', 'bookworm' ),
                'active_callback' => function () {
                    return (int) get_theme_mod( '404_desc' ) <= 0;
                },
            ] );
            $wp_customize->selective_refresh->add_partial( '404_desc', [
                'selector'        => '[data-bw-customizer="404_desc"]',
                'render_callback' => function () {
                    return esc_html( get_theme_mod( '404_desc' ) );
                },
            ] );
            $wp_customize->add_setting( '404_btn_text', [
                'default'           => esc_html_x( 'Go Back', 'front-end', 'bookworm' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );
            $wp_customize->add_control( '404_btn_text', [
                'type'            => 'text',
                'section'         => 'bookworm_404',
                'label'           => esc_html__( 'Button Text', 'bookworm' ),
                'active_callback' => function () {
                    return (int) get_theme_mod( '404_btn_text' ) <= 0;
                },
            ] );
            $wp_customize->selective_refresh->add_partial( '404_btn_text', [
                'selector'        => '[data-bw-customizer="404_btn_text"]',
                'render_callback' => function () {
                    return esc_html( get_theme_mod( '404_btn_text' ) );
                },
            ] );
            
            $wp_customize->add_setting( '404_button_color', [
                'default'           => 'dark',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( '404_button_color', [
                'type'    => 'select',
                'section' => 'bookworm_404',
                'label'   => esc_html__( '"Go Back" button color', 'bookworm' ),
                'choices' => [
                    'primary'   => esc_html_x( 'Primary', 'button', 'bookworm' ),
                    'accent'    => esc_html_x( 'Accent', 'button', 'bookworm' ),
                    'secondary' => esc_html_x( 'Secondary', 'button', 'bookworm' ),
                    'success'   => esc_html_x( 'Success', 'button', 'bookworm' ),
                    'danger'    => esc_html_x( 'Danger', 'button', 'bookworm' ),
                    'warning'   => esc_html_x( 'Warning', 'button', 'bookworm' ),
                    'info'      => esc_html_x( 'Info', 'button', 'bookworm' ),
                    'dark'      => esc_html_x( 'Dark', 'button', 'bookworm' ),
                ],
            ] );
        }

        /**
         * Customize site blog
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_blog( $wp_customize ) {
            $wp_customize->add_section( 'bookworm_blog', [
                /* translators: title of section in Customizer */
                'title'       => esc_html__( 'Blog', 'bookworm' ),
                'description' => esc_html__( 'This section contains settings related to posts listing archives and single post.', 'bookworm' ),
                'priority'    => 30,
            ] );

            $this->add_blog_section( $wp_customize );
        }

        private function add_blog_section( $wp_customize ) {

            $wp_customize->add_setting( 'blog_layout', [
                'default'           => 'list',
                'sanitize_callback' => 'sanitize_key',
            ] );
            $wp_customize->add_control( 'blog_layout', [
                'type'        => 'select',
                'section'     => 'bookworm_blog',
                /* translators: label field of control in Customizer */
                'label'       => esc_html__( 'Blog Layout', 'bookworm' ),
                'description' => esc_html__( 'This setting affects both the posts listing (your blog page) and archives.', 'bookworm' ),
                'choices'     => [
                    /* translators: single item in a list of Blog Layout choices (in Customizer) */
                    'grid'            => esc_html__( 'Grid', 'bookworm' ),
                    /* translators: single item in a list of Blog Layout choices (in Customizer) */
                    'list'            => esc_html__( 'List', 'bookworm' ),
                ],
            ] );

            $wp_customize->add_setting( 'blog_sidebar', [
                'default'           => 'left-sidebar',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_sidebar', [
                'type'        => 'select',
                'section'     => 'bookworm_blog',
                /* translators: label field of control in Customizer */
                'label'       => esc_html__( 'Blog Sidebar', 'bookworm' ),
                'description' => esc_html__( 'This setting affects both the posts listing (your blog page) and archives. This works when blog sidebar has widgets', 'bookworm' ),
                'choices'     => [
                    'left-sidebar'  => esc_html__( 'Left Sidebar', 'bookworm' ),
                    'right-sidebar' => esc_html__( 'Right Sidebar', 'bookworm' ),
                    'no-sidebar'    => esc_html__( 'No Sidebar', 'bookworm' ),
                ],
            ] );

            $wp_customize->add_setting( 'blog_author_info', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_author_info', [
                'type'        => 'radio',
                'section'     => 'bookworm_blog',
                'label'       => esc_html__( 'Enable Blog Author Info', 'bookworm' ),
                'description' => esc_html__( 'This setting allows you to enable author info', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
            ] );

            $wp_customize->add_setting( 'blog_related_posts', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'blog_related_posts', [
                'type'        => 'radio',
                'section'     => 'bookworm_blog',
                'label'       => esc_html__( 'Enable Blog Related Posts', 'bookworm' ),
                'description' => esc_html__( 'This setting allows you to enable related posts', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
            ] );
        }

        /**
         * Customize site footer
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_footer( $wp_customize ) {
            $wp_customize->add_panel( 'bookworm_footer', [
                'title'              => esc_html__( 'Footer', 'bookworm' ),
                'description'        => esc_html__(
                    'Footer is divided into two section: top section and bottom one. The top section contains the widgets
                    areas and divided into four columns. The bottom section contains copyright, payment method and langauge switcher.',
                    'bookworm'
                ),
                'priority'           => 30,
                'description_hidden' => false,
            ] );

            $this->add_footer_general_section( $wp_customize );
        }

        private function add_footer_general_section( $wp_customize ) {
            $wp_customize->add_section( 'bookworm_footer_general', [
                /* translators: title of section in Customizer */
                'title'       => esc_html__( 'General', 'bookworm' ),
                'description' => esc_html__( 'Contains general settings for footer customization.', 'bookworm' ),
                'panel'       => 'bookworm_footer',
            ] );

            $wp_customize->add_setting( 'footer_version', [
                'default'           => 'v1',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'footer_version', [
                'type'        => 'select',
                'section'     => 'bookworm_footer_general',
                'label'       => esc_html__( 'Version', 'bookworm' ),
                'description' => esc_html__( 'This setting allows you to choose the desired version of footer.', 'bookworm' ),
                'choices'     => [
                    'v1'  => esc_html__( 'Footer v1', 'bookworm' ),
                    'v2'  => esc_html__( 'Footer v2', 'bookworm' ),
                    'v3'  => esc_html__( 'Footer v3', 'bookworm' ),
                    'v4'  => esc_html__( 'Footer v4', 'bookworm' ),
                    'v5'  => esc_html__( 'Footer v5', 'bookworm' ),
                    'v6'  => esc_html__( 'Footer v6', 'bookworm' ),
                    'v7'  => esc_html__( 'Footer v7', 'bookworm' ),
                    'v8'  => esc_html__( 'Footer v8', 'bookworm' ),
                    'v9'  => esc_html__( 'Footer v9', 'bookworm' ),
                    'v10'  => esc_html__( 'Footer v10', 'bookworm' ),
                    'v11'  => esc_html__( 'Footer v11', 'bookworm' ),
                    'v12'  => esc_html__( 'Footer v12', 'bookworm' ),
                    'v13'  => esc_html__( 'Footer v13', 'bookworm' ),
                ],
            ] );

            $wp_customize->add_setting( 'enable_newsletter_form', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_newsletter_form', [
                'type'        => 'radio',
                'section'     => 'bookworm_footer_general',
                'label'       => esc_html__( 'Enable Newsletter Form', 'bookworm' ),
                'description' => esc_html__( 'This setting allows you to show or hide newsletter form in Footer.', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_newsletter_form', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'bookworm_newsletter_title', [
                /* translators: default value for "departments_title" setting in Customizer */
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'bookworm_newsletter_title', [
                'type'            => 'text',
                'section'         => 'bookworm_footer_general',
                'label'           => esc_html__( 'Newsletter Title', 'bookworm' ),
                'description'     => esc_html__( 'This setting allows you to change newsletter title', 'bookworm' ),
                'active_callback' => function () {
                    return get_theme_mod( 'enable_newsletter_form', 'no' ) === 'yes';
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'bookworm_newsletter_title', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'bookworm_newsletter_desc', [
                /* translators: default value for "departments_title" setting in Customizer */
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_textarea_field',
            ] );

            $wp_customize->add_control( 'bookworm_newsletter_desc', [
                'type'            => 'textarea',
                'section'         => 'bookworm_footer_general',
                'label'           => esc_html__( 'Newsletter Description', 'bookworm' ),
                'description'     => esc_html__( 'This setting allows you to change newsletter description', 'bookworm' ),
                'active_callback' => function () {
                    return get_theme_mod( 'enable_newsletter_form', 'no' ) === 'yes';
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'bookworm_newsletter_desc', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'bookworm_newsletter_form', [
                /* translators: default value for "departments_title" setting in Customizer */
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_textarea_field',
            ] );

            $wp_customize->add_control( 'bookworm_newsletter_form', [
                'type'            => 'textarea',
                'section'         => 'bookworm_footer_general',
                'label'           => esc_html__( 'Newsletter Form', 'bookworm' ),
                'description'     => esc_html__( 'Paste your newsletter signup form or shortcode', 'bookworm' ),
                'active_callback' => function () {
                    return get_theme_mod( 'enable_newsletter_form', 'no' ) === 'yes';
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'bookworm_newsletter_form', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'enable_shop_address', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_shop_address', [
                'type'        => 'radio',
                'section'     => 'bookworm_footer_general',
                'label'       => esc_html__( 'Enable Shop Address', 'bookworm' ),
                'description' => esc_html__( 'This setting allows you to show or hide show address in Footer.', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_shop_address', [
                'fallback_refresh'    => true
            ] );



            $wp_customize->add_setting( 'bookworm_address_1', [
                /* translators: default value for "departments_title" setting in Customizer */
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'bookworm_address_1', [
                'type'            => 'text',
                'section'         => 'bookworm_footer_general',
                'label'           => esc_html__( 'Shop Address 1', 'bookworm' ),
                'description'     => esc_html__( 'This setting allows you to change shop address to something else.', 'bookworm' ),
                'active_callback' => function () {
                    return get_theme_mod( 'enable_shop_address', 'no' ) === 'yes';
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'bookworm_address_1', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'bookworm_address_2', [
                /* translators: default value for "departments_title" setting in Customizer */
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ] );

            $wp_customize->add_control( 'bookworm_address_2', [
                'type'            => 'text',
                'section'         => 'bookworm_footer_general',
                'label'           => esc_html__( 'Shop Address 2', 'bookworm' ),
                'description'     => esc_html__( 'This setting allows you to change shop address to something else.', 'bookworm' ),
                'active_callback' => function () {
                    return get_theme_mod( 'enable_shop_address', 'no' ) === 'yes';
                }
            ] );

            $wp_customize->selective_refresh->add_partial( 'bookworm_address_2', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'enable_footer_payment', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_footer_payment', [
                'type'        => 'radio',
                'section'     => 'bookworm_footer_general',
                'label'       => esc_html__( 'Enable Payment Method', 'bookworm' ),
                'description' => esc_html__( 'This setting allows you to show or hide payment in Footer.', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_footer_payment', [
                'fallback_refresh'    => true
            ] );


            
            $wp_customize->add_setting( 'bookworm_credit_card_img_url', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'esc_url_raw',
            ] );

            $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'bookworm_credit_card_img_url', [
                'section'     => 'bookworm_footer_general',
                /* translators: label field for setting in Customizer */
                'label'       => esc_html__( 'Payment Methods', 'bookworm' ),
                /* translators: description field for "Payment Methods" setting in Customizer */
                'description' => esc_html__( 'Enter image URL','bookworm'),
                'type'   => 'url',
                

                'active_callback' => function () {
                    return get_theme_mod( 'enable_footer_payment', 'no' ) === 'yes';
                }
            ] ) );

            $wp_customize->selective_refresh->add_partial( 'bookworm_credit_card_img_url', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'bookworm_copyright_text', [
                'transport'         => 'postMessage',
                'sanitize_callback' => 'wp_kses_post',
            ] );
            $wp_customize->add_control( 'bookworm_copyright_text', [
                'type'        => 'textarea',
                'section'     => 'bookworm_footer_general',
                /* translators: label field for setting in Customizer */
                'label'       => esc_html__( 'Copyright', 'bookworm' ),
                /* translators: description field for "Copyright" setting in Customizer */
                'description' => esc_html__( 'HTML is allowed in this field.', 'bookworm' ),
            ] );
            $wp_customize->selective_refresh->add_partial( 'bookworm_copyright_text', [
                'fallback_refresh'    => true
            ] );

            $wp_customize->add_setting( 'enable_footer_language', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_footer_language', [
                'type'        => 'radio',
                'section'     => 'bookworm_footer_general',
                'label'       => esc_html__( 'Enable Language Switcher', 'bookworm' ),
                'description' => esc_html__( 'This setting allows you to show or hide language in Footer.', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_footer_language', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'enable_footer_currency', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'enable_footer_currency', [
                'type'        => 'radio',
                'section'     => 'bookworm_footer_general',
                'label'       => esc_html__( 'Enable Currency Switcher', 'bookworm' ),
                'description' => esc_html__( 'This setting allows you to show or hide currency in Footer.', 'bookworm' ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
            ] );

            $wp_customize->selective_refresh->add_partial( 'enable_footer_currency', [
                'fallback_refresh'    => true
            ] );


            $wp_customize->add_setting( 'footer_widget_section_note', [
                'sanitize_callback' => 'sanitize_textarea_field',
            ] );
            $wp_customize->add_control( 'footer_widget_section_note', [
                'type'            => 'hidden',
                'section'         => 'bookworm_footer_general',
                /* translators: label field for setting in Customizer */
                'label'           => esc_html__( 'Note', 'bookworm' ),
                'description'     => wp_kses(
                    sprintf(
                    /* translators: %s: link to Widgets panel in Customizer  */
                        __( 'Top section is built with widgets. On Widgets screen you can find three sidebars
                            with names like "Footer Column 1" each represents one column and may contains one or more widgets.
                            Top section will appear as soon as you add your first widget (in any column).
                            <strong>Make sure you published your changes.</strong>
                            <p>Ready? <a href="%s">Add widgets to the footer columns</a>.</p>
                            <hr>',
                            'bookworm'
                        ),
                        admin_url( '/widgets.php' )
                    ),
                    [
                        'strong' => true,
                        'br'     => true,
                        'hr'     => true,
                        'p'      => true,
                        'a'      => [ 'href' => true ],
                    ]
                ),
            ] );
        }


        /**
         * Mas Static Content Option Lists
         */
        public function mas_static_content_options() {
            if ( bookworm_is_mas_static_content_activated()) {
                $static_block = array();
                $args = array('post_type' => 'mas_static_content', 'post_status' => 'publish', 'limit' => '-1', 'posts_per_page' => '-1' );
                $static_blocks = get_posts( $args ); 
                $options = array( 0 => esc_html__( '— Select —', 'bookworm' ) );
                foreach($static_blocks as $static_block) {
                    $options[$static_block->ID] = $static_block->post_title;
                    
                }
                return $options;
            }
        }

        /**
         * Customize site Custom Theme Color
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function customize_customcolor( $wp_customize ) {
            $wp_customize->add_section( 'bookworm_customcolor', [
                'title'    => esc_html__( 'Custom Theme Color', 'bookworm' ),
                'priority' => 200,
            ] );

            $this->add_customcolor_section( $wp_customize );
        }

        private function add_customcolor_section( $wp_customize ) {
            /**
             * Custom Color Enable / Disble Toggle
             */
            $wp_customize->add_setting( 'bookworm_enable_custom_color', [
                'default'           => 'no',
                'sanitize_callback' => 'sanitize_key',
            ] );

            $wp_customize->add_control( 'bookworm_enable_custom_color', [
                'type'        => 'radio',
                'section'     => 'bookworm_customcolor',
                'label'       => esc_html__( 'Enable Custom Color?', 'bookworm' ),
                'description' => esc_html__(
                    'This settings allow you to apply your custom color option.',
                    'bookworm'
                ),
                'choices'     => [
                    'yes' => esc_html__( 'Yes', 'bookworm' ),
                    'no'  => esc_html__( 'No', 'bookworm' ),
                ],
            ] );

            /**
             * Primary Color
             */
            $wp_customize->add_setting(
                'bookworm_primary_color', array(
                    'default'           => apply_filters( 'bookworm_default_primary_color', '#f75454' ),
                    'sanitize_callback' => 'sanitize_hex_color',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize, 'bookworm_primary_color', array(
                        'label'    => esc_html__( 'Primary color', 'bookworm' ),
                        'section'  => 'bookworm_customcolor',
                        'settings' => 'bookworm_primary_color',
                        'active_callback' => function () {
                            return get_theme_mod( 'bookworm_enable_custom_color', 'no' ) === 'yes';
                        }
                    )
                )
            );

            /**
             * Secondary Color
             */
            $wp_customize->add_setting(
                'bookworm_secondary_color', array(
                    'default'           => apply_filters( 'bookworm_default_secondary_color', '#161619' ),
                    'sanitize_callback' => 'sanitize_hex_color',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize, 'bookworm_secondary_color', array(
                        'label'    => esc_html__( 'Secondary color', 'bookworm' ),
                        'section'  => 'bookworm_customcolor',
                        'settings' => 'bookworm_secondary_color',
                        'active_callback' => function () {
                            return get_theme_mod( 'bookworm_enable_custom_color', 'no' ) === 'yes';
                        }
                    )
                )
            );

            /**
            * Dark Color
            */
            $wp_customize->add_setting(
                'bookworm_gray_color', array(
                    'default'           => apply_filters( 'bookworm_default_gray_color', '#fff6f6' ),
                    'sanitize_callback' => 'sanitize_hex_color',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize, 'bookworm_gray_color', array(
                        'label'    => esc_html__( 'Gray 200 color', 'bookworm' ),
                        'section'  => 'bookworm_customcolor',
                        'settings' => 'bookworm_gray_color',
                        'active_callback' => function () {
                            return get_theme_mod( 'bookworm_enable_custom_color', 'no' ) === 'yes';
                        }
                    )
                )
            );
        }

            
    }

endif;

return new Bookworm_Customizer();
