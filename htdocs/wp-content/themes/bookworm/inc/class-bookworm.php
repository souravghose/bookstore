<?php
/**
 * Bookworm Class
 *
 * @since    1.0.0
 * @package  bookworm
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Bookworm' ) ) :

    /**
     * The main Bookworm class
     */
    class Bookworm {

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {
            add_action( 'after_setup_theme', array( $this, 'setup' ) );
            add_action( 'widgets_init', array( $this, 'widgets_init' ), 20 );
            add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 10 );
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ), 20 );
            add_action( 'wp_enqueue_scripts', array( $this, 'child_scripts' ), 30 ); // After WooCommerce.
            add_action( 'enqueue_block_editor_assets', array( $this, 'block_editor_assets' ) );
            add_action( 'admin_menu', array( $this, 'admin_pages' ) );
            add_filter( 'dynamic_sidebar_params', array( $this, 'dynamic_blog_sidebar_params' ) );
            add_filter( 'body_class', array( $this, 'body_classes' ) );
            add_filter( 'admin_body_class', array( $this, 'admin_body_classes' ) );
            add_action( 'tgmpa_register', array( $this, 'register_required_plugins' ) );
            add_action( 'admin_head', array( $this, 'wp_5_6_editor_block_width_fix' ) );
        }

        /**
         * Sets up theme defaults and registers support for various WordPress features.
         *
         * Note that this function is hooked into the after_setup_theme hook, which
         * runs before the init hook. The init hook is too late for some features, such
         * as indicating support for post thumbnails.
         */
        public function setup() {
            /*
             * Load Localisation files.
             *
             * Note: the first-loaded translation file overrides any following ones if the same translation is present.
             */

            // Loads wp-content/languages/themes/bookworm-it_IT.mo.
            load_theme_textdomain( 'bookworm', trailingslashit( WP_LANG_DIR ) . 'themes' );

            // Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
            load_theme_textdomain( 'bookworm', get_stylesheet_directory() . '/languages' );

            // Loads wp-content/themes/bookworm/languages/it_IT.mo.
            load_theme_textdomain( 'bookworm', get_template_directory() . '/languages' );

            /**
             * Add default posts and comments RSS feed links to head.
             */
            add_theme_support( 'automatic-feed-links' );

            /*
             * Enable support for Post Thumbnails on posts and pages.
             *
             * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
             */
            add_theme_support( 'post-thumbnails' );

            /**
            * Register menu locations.
            */
            register_nav_menus( apply_filters( 'bookworm_register_nav_menus', array(
                'topbar_left'   => esc_html__( 'Topbar Left', 'bookworm' ),
                'topbar_right'  => esc_html__( 'Topbar Right', 'bookworm' ),
                'primary'       => esc_html__( 'Primary Menu', 'bookworm' ),
                'secondary'     => esc_html__( 'Secondary Menu', 'bookworm' ),
                'social_media'  => esc_html__( 'Social Media', 'bookworm' ),
                'contact_links' => esc_html__( 'Contact Links', 'bookworm' ),
                'department'    => esc_html__( 'Department Menu', 'bookworm' ),
                'offcanvas'     => esc_html__( 'Offcanvas Menu', 'bookworm' ),
            ) ) );

            /*
             * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
             * to output valid HTML5.
             */
            add_theme_support( 'html5', apply_filters( 'bookworm_html5_args', array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'widgets',
                'style',
                'script',
            ) ) );

            /**
             *  Add support for the Site Logo plugin and the site logo functionality in JetPack
             *  https://github.com/automattic/site-logo
             *  http://jetpack.me/
             */
            add_theme_support(
                'site-logo', apply_filters(
                    'bookworm_site_logo_args', array(
                        'size' => 'full',
                    )
                )
            );

            /**
             * Enable support for site logo.
             */
            add_theme_support(
                'custom-logo', apply_filters(
                    'bookworm_custom_logo_args', array(
                        'width'       => 170,
                        'height'      => 30,
                        'flex-width'  => true,
                        'flex-height' => true,
                    )
                )
            );

            /**
             * Add support for full and wide align images.
             */
            add_theme_support( 'align-wide' );
            
            /**
             * Add support for editor styles.
             */
            add_theme_support( 'editor-styles' );


            /**
             * Declare support for title theme feature.
             */
            add_theme_support( 'title-tag' );

            add_theme_support( 'editor-color-palette', [
                [
                    'name'  => esc_html__( 'Primary', 'bookworm' ),
                    'slug'  => 'primary',
                    'color' => apply_filters( 'bookworm_editor_primary_color', '#f75454')
                ],
                [
                    'name'  => esc_html__( 'Secondary', 'bookworm' ),
                    'slug'  => 'secondary',
                    'color' => apply_filters( 'bookworm_editor_secondary_color', '#161619')
                ],
                [
                    'name'  => esc_html__( 'Primary Green', 'bookworm' ),
                    'slug'  => 'primary-green',
                    'color' => '#88cf00'
                ],
                [
                    'name'  => esc_html__( 'Primary Yellow', 'bookworm' ),
                    'slug'  => 'primary-yellow',
                    'color' => '#fced70'
                ],
                [
                    'name'  => esc_html__( 'Info', 'bookworm' ),
                    'slug'  => 'info',
                    'color' => '#17a2b8'
                ],
                [
                    'name'  => esc_html__( 'Yellow Darker', 'bookworm' ),
                    'slug'  => 'yellow-darker',
                    'color' => '#ffbd00'
                ],
                [
                    'name'  => esc_html__( 'Bg Gray 200', 'bookworm' ),
                    'slug'  => 'bg-gray-200',
                    'color' => apply_filters( 'bookworm_editor_gray_color', '#fff6f6')
                ],
                [
                    'name'  => esc_html__( 'Primary Home v3', 'bookworm' ),
                    'slug'  => 'primary-home-v3',
                    'color' => '#041e42'
                ],
                [
                    'name'  => esc_html__( 'Primary Indigo', 'bookworm' ),
                    'slug'  => 'primary-indigo',
                    'color' => '#a200fc'
                ],
                [
                    'name'  => esc_html__( 'White', 'bookworm' ),
                    'slug'  => 'bg-white',
                    'color' => '#ffffff'
                ],
                [
                    'name'  => esc_html__( 'Tangerine', 'bookworm' ),
                    'slug'  => 'tangerine',
                    'color' => '#f79400'
                ],
                [
                    'name'  => esc_html__( 'Tangerine Light', 'bookworm' ),
                    'slug'  => 'tangerine-light',
                    'color' => '#faf4eb'
                ],
                [
                    'name'  => esc_html__( 'Chili', 'bookworm' ),
                    'slug'  => 'chili',
                    'color' => '#f01000'
                ],
                [
                    'name'  => esc_html__( 'Chili Light', 'bookworm' ),
                    'slug'  => 'chili-light',
                    'color' => '#f4e6e5'
                ],
                [
                    'name'  => esc_html__( 'Carolina', 'bookworm' ),
                    'slug'  => 'carolina',
                    'color' => '#00cdef'
                ],
                [
                    'name'  => esc_html__( 'Carolina Light', 'bookworm' ),
                    'slug'  => 'carolina-light',
                    'color' => '#e6f2f4'
                ],
                [
                    'name'  => esc_html__( 'Punch', 'bookworm' ),
                    'slug'  => 'punch',
                    'color' => '#ff8e8e'
                ],
                [
                    'name'  => esc_html__( 'Bg Dark 1', 'bookworm' ),
                    'slug'  => 'bg-dark-1',
                    'color' => '#2d3942'
                ],
                [
                    'name'  => esc_html__( 'Pale Pink', 'bookworm' ),
                    'slug'  => 'pale-pink',
                    'color' => '#f78da7'
                ],
            ] );

            /**
             * Enqueue editor styles.
             */

            $editor_styles = [
                is_rtl() ? 'assets/css/gutenberg-editor-rtl.css' : 'assets/css/gutenberg-editor.css',
                $this->google_fonts(),
            ];

            if( get_theme_mod( 'bookworm_enable_custom_color', 'no' ) === 'yes' ) {
                $editor_styles[] = content_url( '/custom_theme_color_css' );
                
            }


            add_editor_style( $editor_styles );

            // Register theme images sizes.
            if( apply_filters( 'bookworm_register_image_sizes', true ) ) {
                add_image_size( 'bookworm-70x107-crop', 70, 107, array( 'center', 'center' ) );
                add_image_size( 'bookworm-254x400-crop', 254, 400, array( 'center', 'center' ) );
                add_image_size( 'bookworm-90x138-crop', 90, 138, array( 'center', 'center' ) );
                add_image_size( 'bookworm-60x90-crop', 60, 90, array( 'center', 'center' ) );
                add_image_size( 'bookworm-120x183-crop', 120, 183, array( 'center', 'center' ) );
                add_image_size( 'bookworm-200x327-crop', 200, 327, array( 'center', 'center' ) );
                add_image_size( 'bookworm-300x452-crop', 300, 452, array( 'center', 'center' ) );
                add_image_size( 'bookworm-150x225-crop', 150, 225, array( 'center', 'center' ) );
                add_image_size( 'bookworm-190x222-crop', 190, 222, array( 'center', 'center' ) );
                add_image_size( 'bookworm-445x300-crop', 445, 300, array( 'center', 'center' ) );
                add_image_size( 'bookworm-506x341-crop', 506, 341, array( 'center', 'center' ) );
                add_image_size( 'bookworm-391x298-crop', 391, 298, array( 'center', 'center' ) );
                add_image_size( 'bookworm-360x250-crop', 360, 250, array( 'center', 'center' ) );
            }
        }

        public function get_blog_sidebar_args() {
            $blog_sidebar_args['blog_sidebar'] = array(
                'name'        => esc_html__( 'Blog Sidebar', 'bookworm' ),
                'id'          => 'blog-sidebar',
                'description' => '',
            );

            return apply_filters( 'bookworm_blog_sidebar_args', $blog_sidebar_args );
        }

        /**
         * Register widget area.
         *
         * @link https://codex.wordpress.org/Function_Reference/register_sidebar
         */
        public function widgets_init() {

            $blog_sidebar_args  = $this->get_blog_sidebar_args();

            foreach ( $blog_sidebar_args  as $sidebar => $args ) {
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

            $rows    = intval( apply_filters( 'bookworm_footer_widget_rows', 1 ) );
            $regions = intval( apply_filters( 'bookworm_footer_widget_columns', 5 ) );

            for ( $row = 1; $row <= $rows; $row++ ) {
                for ( $region = 1; $region <= $regions; $region++ ) {
                    $footer_n = $region + $regions * ( $row - 1 ); // Defines footer sidebar ID.
                    $footer   = sprintf( 'footer_%d', $footer_n );

                    if ( 1 === $rows ) {
                        /* translators: 1: column number */
                        $footer_region_name = sprintf( esc_html__( 'Footer Column %1$d', 'bookworm' ), $region );

                        /* translators: 1: column number */
                        $footer_region_description = sprintf( esc_html__( 'Widgets added here will appear in column %1$d of the footer.', 'bookworm' ), $region );

                        if ( 5 === $region ) {
                            $footer_region_description .= ' ' . esc_html__( 'This widget area is available in Footer v2 only', 'bookworm' );
                        }

                    } else {
                        /* translators: 1: row number, 2: column number */
                        $footer_region_name = sprintf( esc_html__( 'Footer Row %1$d - Column %2$d', 'bookworm' ), $row, $region );

                        /* translators: 1: column number, 2: row number */
                        $footer_region_description = sprintf( esc_html__( 'Widgets added here will appear in column %1$d of footer row %2$d.', 'bookworm' ), $region, $row );
                    }

                    $sidebar_args[ $footer ] = array(
                        'name'         => $footer_region_name,
                        'id'           => sprintf( 'footer-%d', $footer_n ),
                        'description'  => $footer_region_description,
                        'before_title' => '<h4 class="widget-title font-size-3 font-weight-medium mb-2 mb-xl-5 pb-xl-1">',
                    );
                }
            }

            $sidebar_args = apply_filters( 'bookworm_sidebar_args', $sidebar_args );

            foreach ( $sidebar_args as $sidebar => $args ) {
                $widget_tags = array(
                    'before_widget' => '<div id="%1$s" class="widget %2$s mb-6 mb-lg-8">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h4 class="widget-title">',
                    'after_title'   => '</h4>',
                );

                /**
                 * Dynamically generated filter hooks. Allow changing widget wrapper and title tags. See the list below.
                 *
                 * 'bookworm_header_widget_tags'
                 * 'bookworm_sidebar_widget_tags'
                 *
                 * 'bookworm_footer_1_widget_tags'
                 * 'bookworm_footer_2_widget_tags'
                 * 'bookworm_footer_3_widget_tags'
                 * 'bookworm_footer_4_widget_tags'
                 */
                $filter_hook = sprintf( 'bookworm_%s_widget_tags', $sidebar );
                $widget_tags = apply_filters( $filter_hook, $widget_tags );

                if ( is_array( $widget_tags ) ) {
                    register_sidebar( $args + $widget_tags );
                }
            }
        }

        /**
         * Include Collapse Args on Blog Dynamic Sidebar
         *
         * @link https://developer.wordpress.org/reference/functions/dynamic_sidebar/
         */
        public function dynamic_blog_sidebar_params( $params ) {
            $sidebar_args = $this->get_blog_sidebar_args();

            if( isset( $params[0] ) && isset( $params[0]['id'] ) && in_array( $params[0]['id'], array_column( $sidebar_args, 'id' ) ) ) {
                global $wp_registered_widgets;

                $widget_id = $params[0]['widget_id'];
                $settings_getter = $wp_registered_widgets[ $widget_id ]['callback'][0];
                $get_settings = $settings_getter->get_settings();
                $settings = $get_settings[ $params[1]['number'] ];

                if ( isset( $settings['title'] ) && ! empty( $settings['title'] ) ) {
                    $minus = '<svg class="mins" width="15px" height="2px"><path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M0.000,-0.000 L15.000,-0.000 L15.000,2.000 L0.000,2.000 L0.000,-0.000 Z"></path></svg>';
                    $plus  = '<svg class="plus" width="15px" height="15px"><path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M15.000,8.000 L9.000,8.000 L9.000,15.000 L7.000,15.000 L7.000,8.000 L0.000,8.000 L0.000,6.000 L7.000,6.000 L7.000,-0.000 L9.000,-0.000 L9.000,6.000 L15.000,6.000 L15.000,8.000 Z"></path></svg>';

                    $params[0]['before_title'] = '<div class="widget-head" id="widgetHeading-' . $widget_id . '"><a class="d-flex align-items-center justify-content-between text-dark" href="#" data-toggle="collapse" data-target="#widget-collapse-' . $widget_id . '" aria-expanded="true" aria-controls="widget-collapse-' . $widget_id . '"><h3 class="widget-title font-weight-medium font-size-3 mb-0">';
                    $params[0]['after_title'] = '</h3>' . $minus . $plus . '</a></div><div id="widget-collapse-' . $widget_id . '" class="mt-4 widget-content collapse show" aria-labelledby="widgetHeading-' . $widget_id . '" >';
                    $params[0]['after_widget'] = '</div></div>';
                }

            }

            return $params;
        }

        /**
         * Enqueue scripts and styles.
         *
         * @since  1.0.0
         */
        public function scripts() {
            global $bookworm_version;

            /**
             * Styles
             */
            $vendors = apply_filters( 'bookworm_vendor_styles', array(
                'fontawesome'        => 'font-awesome/css/fontawesome-all.min.css',
                'flaticon'           => 'flaticon/font/flaticon.css',
                'animate'            => 'animate.css/animate.css',
                'bootstrap-select'   => 'bootstrap-select/dist/css/bootstrap-select.min.css',
                'slick'              => 'slick-carousel/slick/slick.css"',
                'm-custom-scrollbar' => 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css',
                'fancybox'           =>'fancybox/jquery.fancybox.css',
                'cubeportfolio'      =>'cubeportfolio/css/cubeportfolio.min.css'
            ) );

            foreach( $vendors as $key => $vendor ) {
                wp_enqueue_style( $key, get_template_directory_uri() . '/assets/vendor/' . $vendor, '', $bookworm_version );

                if( in_array( $key, array( 'megamenu' ) ) ) {
                    wp_style_add_data( $key, 'rtl', 'replace' );
                }
            }

            wp_enqueue_style( 'bookworm-icons', get_template_directory_uri() . '/assets/css/bookworm-icons.css', '', $bookworm_version, 'screen' );

            wp_enqueue_style( 'bookworm-style', get_template_directory_uri() . '/style.css', '', $bookworm_version );
            wp_style_add_data( 'bookworm-style', 'rtl', 'replace' );

            if( apply_filters( 'bookworm_use_predefined_colors', true ) ) {
                $color_css_file = apply_filters( 'bookworm_primary_color', 'red' );
                wp_enqueue_style( 'bookworm-color', get_template_directory_uri() . '/assets/css/colors/' . $color_css_file . '.css', '', $bookworm_version );
            }

            

            /**
             * Fonts
             */
            wp_enqueue_style( 'bookworm-fonts', $this->google_fonts(), array(), null );

            /**
             * Scripts
             */
            self::register_scripts();

            // JS Global Compulsory
            wp_enqueue_script( 'popper' );
            wp_enqueue_script( 'bootstrap' );
            wp_enqueue_script( 'bootstrap-select' );
            wp_enqueue_script( 'slick' );
            wp_enqueue_script( 'jquery-zeyneyp' );
            wp_enqueue_script( 'mCustomScrollbar' );
            wp_enqueue_script( 'fancybox' );
            wp_enqueue_script( 'appear' );
            // HS Components
            wp_enqueue_script( 'hs-core' );
            wp_enqueue_script( 'hs-unfold' );
            wp_enqueue_script( 'hs-malihu-scrollbar' );
            wp_enqueue_script( 'hs-header' );
            wp_enqueue_script( 'hs-slick-carousel' );
            wp_enqueue_script( 'hs-selectpicker' );
            wp_enqueue_script( 'hs-onscroll-animation' );
            wp_enqueue_script( 'hs-show-animation' );
            wp_enqueue_script( 'hs-countdown' );
            wp_enqueue_script( 'hs-fancybox' );
            wp_enqueue_script( 'hs-scroll-nav' );
            wp_enqueue_script( 'hs-quantity-counter' );
            wp_enqueue_script( 'cubeportfolio' );
            wp_enqueue_script( 'hs-cubeportfolio' );
            wp_enqueue_script( 'hs-go-to' );
            

            wp_enqueue_script( 'bookworm-js', get_template_directory_uri() . '/assets/js/bookworm.js', array( 'bootstrap', 'jquery-zeyneyp', 'hs-unfold', 'hs-slick-carousel', 'hs-fancybox'  ), $bookworm_version, true );

            if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
            }

            $admin_ajax_url = admin_url( 'admin-ajax.php' );
          
            $current_lang   = apply_filters( 'wpml_current_language', NULL );
            if ( $current_lang ) {
                $admin_ajax_url = add_query_arg( 'lang', $current_lang, $admin_ajax_url );
            }

            $bookworm_options = apply_filters( 'bookworm_localize_script_data', array(
                'rtl'                       => is_rtl() ? '1' : '0',
                'ajax_url'                  => $admin_ajax_url,
                'ajax_loader_url'           => get_template_directory_uri() . '/assets/img/ajax-loader.gif',
                'scroll_sticky_nav_offset'  => 400,
                'scroll_to_top_offset'      => 600,
            ) );

            wp_localize_script( 'bookworm-js', 'bookworm_options', $bookworm_options );
        }

        /**
        * Get all Front scripts.
        */
        private static function get_theme_scripts() {
            $vendors_path = get_template_directory_uri() . '/assets/vendor/';
            $js_vendors = apply_filters( 'bookworm_js_vendors', array(
                'popper'           => array(
                    'src' => $vendors_path . 'popper.js/dist/umd/popper.min.js',
                    'dep' => array( 'jquery' )
                ),
                'bootstrap'        => array(
                    'src' => $vendors_path . 'bootstrap/bootstrap.min.js',
                    'dep' => array( 'jquery', 'popper' )
                ),
                'bootstrap-select' => array(
                    'src' => $vendors_path . 'bootstrap-select/dist/js/bootstrap-select.min.js',
                    'dep' => array( 'bootstrap' )
                ),
                'jquery-zeyneyp'   => array(
                    'src' => $vendors_path . 'multilevel-sliding-mobile-menu/dist/jquery.zeynep.js',
                    'dep' => array( 'jquery' )
                ),
                'jquery-countdown' => array(
                    'src' => $vendors_path .'jquery.countdown.min.js',
                    'dep' => array( 'jquery' )
                ),
                'mCustomScrollbar' => array(
                    'src' => $vendors_path . 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js',
                    'dep' => array( 'jquery' )
                ),
                'slick'            => array(
                    'src' => $vendors_path . 'slick-carousel/slick/slick.min.js',
                    'dep' => array( 'jquery' )
                ),
                'jquery-fancybox' => array(
                    'src' => $vendors_path . 'fancybox/jquery.fancybox.min.js',
                    'dep' => array( 'jquery' )
                ),
                'appear' => array(
                    'src' => $vendors_path . 'appear.js',
                    'dep' => array( 'jquery' )

                ),
                'cubeportfolio' => array(
                    'src' => $vendors_path . 'cubeportfolio/js/jquery.cubeportfolio.min.js',
                    'dep' => array( 'jquery' )
                ),
            ) );

            $hs_components_path = get_template_directory_uri() . '/assets/js/components/';
            $hs_components      = apply_filters( 'bookworm_hs_components', array(
                'hs-core'             => array(
                    'src' => get_template_directory_uri() . '/assets/js/hs.core.js',
                    'dep' => array( 'bootstrap' )
                ),
                'hs-unfold'           => array(
                    'src' => $hs_components_path . 'hs.unfold.js',
                    'dep' => array( 'hs-core' )
                ),
                'hs-malihu-scrollbar' => array(
                    'src' => $hs_components_path . 'hs.malihu-scrollbar.js',
                    'dep' => array( 'hs-core', 'mCustomScrollbar' )
                ),
                'hs-header'           => array(
                    'src' => $hs_components_path . 'hs.header.js',
                    'dep' => array( 'hs-core' )
                ),
                'hs-slick-carousel'   => array(
                    'src' => $hs_components_path . 'hs.slick-carousel.js',
                    'dep' => array( 'hs-core', 'slick' )
                ),
                'hs-selectpicker'           => array(
                    'src' => $hs_components_path . 'hs.selectpicker.js',
                    'dep' => array( 'hs-core' )
                ),
                'hs-onscroll-animation'   => array(
                    'src' => $hs_components_path . 'hs.onscroll-animation.js',
                    'dep' => array( 'hs-core' )
                ),
                'hs-show-animation'   => array(
                    'src' => $hs_components_path . 'hs.show-animation.js',
                    'dep' => array( 'hs-core' )
                ),
                'hs-scroll-nav'   => array(
                    'src' => $hs_components_path . 'hs.scroll-nav.js',
                    'dep' => array( 'hs-core' )
                ),
                'hs-fancybox'   => array(
                    'src' => $hs_components_path . 'hs.fancybox.js',
                    'dep' => array( 'hs-core', 'jquery-fancybox' )
                ),
                'hs-countdown' => array(
                    'src' => $hs_components_path . 'hs.countdown.js',
                    'dep' => array( 'hs-core', 'jquery-countdown' )
                ),
                'hs-quantity-counter' => array(
                    'src' => $hs_components_path . 'hs.quantity-counter.js',
                    'dep' => array( 'hs-core' )
                ),
                'hs-cubeportfolio' => array(
                    'src' => $hs_components_path . 'hs.cubeportfolio.js',
                    'dep' => array( 'hs-core', 'cubeportfolio' )
                ),
                'hs-go-to'            => array(
                    'src' => $hs_components_path . 'hs.go-to.js',
                    'dep' => array( 'hs-core' )
                ),
            ) );

            return array_merge( $js_vendors, $hs_components );
        }

        /**
         * Register all Bookworm scripts.
         */
        private static function register_scripts() {
            global $bookworm_version;

            $register_scripts = self::get_theme_scripts();
            foreach ( $register_scripts as $handle => $props ) {
                wp_register_script( $handle, $props['src'], $props['dep'], $bookworm_version, true );
            }
        }

        /**
         * Register Google fonts.
         *
         * @since 1.0.0
         * @return string Google fonts URL for the theme.
         */
        public function google_fonts() {
            $fonts_url = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap';
            return $fonts_url;
        }

        /**
         * Enqueue assets on admin side
         *
         * @since 1.0.0
         */
        public function admin_assets() {
            global $bookworm_version;
            wp_enqueue_style( 'bookworm', get_template_directory_uri() . '/assets/css/admin.css', array(), $bookworm_version, 'screen' );
        }
        
        /**
         * WordPress 5.6 editor width issue fix.
         *
         * @since 1.0.0
         */
        public function wp_5_6_editor_block_width_fix() {
            if( version_compare( get_bloginfo( 'version' ), '5.6', '>=' ) ) {
                echo '<style>.interface-interface-skeleton__editor { max-width: 100%; }</style>';
            }
        }

        /**
         * Add custom pages in "Appearance"
         *
         * @since 1.0.0
         */
        public function admin_pages() {
            add_theme_page(
                esc_html__( 'Bookworm Icons', 'bookworm' ),
                esc_html__( 'Bookworm Icons', 'bookworm' ),
                'edit_theme_options',
                'bookworm-icons',
                function() {
                    require get_theme_file_path( 'templates/admin/icons.php' );
                }
            );
        }

        /**
         * Enqueue block assets.
         *
         * @since 1.0.0
         */
        public function block_assets() {}

            /**
         * Enqueue supplemental block editor assets.
         *
         * @since 1.0.0
         */
        public function block_editor_assets() {
            global $bookworm_version;

            /**
             * Styles
             */
            $vendors = apply_filters( 'bookworm_editor_vendor_styles', array(
                'fontawesome'        => 'font-awesome/css/fontawesome-all.min.css',
                'flaticon'           => 'flaticon/font/flaticon.css',
                'animate'            => 'animate.css/animate.css',
                'bootstrap-select'   => 'bootstrap-select/dist/css/bootstrap-select.min.css',
                'slick'              => 'slick-carousel/slick/slick.css"',
                'm-custom-scrollbar' => 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css',
                'jquery-fancybox'    => 'fancybox/jquery.fancybox.css',
                'cubeportfolio'      =>'cubeportfolio/css/cubeportfolio.min.css',
            ) );

            foreach( $vendors as $key => $vendor ) {
                wp_enqueue_style( $key, get_template_directory_uri() . '/assets/vendor/' . $vendor, '', $bookworm_version );

                if( in_array( $key, array( 'megamenu' ) ) ) {
                    wp_style_add_data( $key, 'rtl', 'replace' );
                }
            }

            /**
             * Fonts
             */
            wp_enqueue_style( 'bookworm-fonts', $this->google_fonts(), array(), null );

            // Scripts
            $theme_scripts = self::get_theme_scripts();
            foreach ( $theme_scripts as $handle => $props ) {
                wp_enqueue_script(
                    $handle,
                    $props['src'],
                    $props['dep'],
                    isset( $props['ver'] ) ? $props['ver'] : $bookworm_version
                );
            }
        }

        /**
         * Enqueue child theme stylesheet.
         * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
         * primary css and the separate WooCommerce css.
         *
         * @since  1.0.0
         */
        public function child_scripts() {
            if ( is_child_theme() ) {
                $child_theme = wp_get_theme( get_stylesheet() );
                wp_enqueue_style( 'bookworm-child-style', get_stylesheet_uri(), array(), $child_theme->get( 'Version' ) );
            }
        }

        

        /**
         * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
         *
         * @param array $args Configuration arguments.
         * @return array
         */
        public function page_menu_args( $args ) {}

        /**
         * Adds custom classes to the array of body classes.
         *
         * @param array $classes Classes for the body element.
         * @return array
         */
        public function body_classes( $classes ) {
            global $post;

            if ( is_page() && isset( $post->ID ) ) {
                $body_class_meta_values = get_post_meta( $post->ID, '_body_classes', true );

                if ( isset( $body_class_meta_values ) && $body_class_meta_values ) {
                    $classes[] = $body_class_meta_values;
                }
            }

            if ( filter_var( get_theme_mod( 'enable_ajax_content_placeholder', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
                $classes[] = 'disable-placeholder';
            }


            return $classes;
        }

        public function admin_body_classes( $classes ) {

            $classes = explode(' ', $classes);
                 
            if ( filter_var( get_theme_mod( 'enable_ajax_content_placeholder', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) {
                $classes = array_merge($classes, [
                    'disable-placeholder',
                    
                ]);
            }

            return implode(' ', array_unique($classes));

        }

         /**
         * Register the required plugins for this theme.
         *
         * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
         */
        public function register_required_plugins() {
            /*
             * Array of plugin arrays. Required keys are name and slug.
             * If the source is NOT from the .org repo, then source is also required.
             */
            global $bookworm_version;

            $plugins = array(

                array(
                    'name'                  => esc_html__( 'Envato Market', 'bookworm' ),
                    'slug'                  => 'envato-market',
                    'source'                => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
                    'version'               => '2.0.6',
                    'required'              => false,
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'external_url'          => '',
                ),

                array(
                    'name'                  => esc_html__( 'Custom Sidebars', 'bookworm' ),
                    'slug'                  => 'custom-sidebars',
                    'version'               => '3.31',
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'required'              => false,
                ),

                array(
                    'name'                  => esc_html__( 'MAS Static Content', 'bookworm' ),
                    'slug'                  => 'mas-static-content',
                    'version'               => '1.0.4',
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'required'              => true,
                ),

                array(
                    'name'                  => esc_html__( 'One Click Demo Import', 'bookworm' ),
                    'slug'                  => 'one-click-demo-import',
                    'version'               => '3.0.2',
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'required'              => false,
                ),

                array(
                    'name'                  => esc_html__( 'Bookworm Extensions', 'bookworm' ),
                    'slug'                  => 'bookworm-extensions',
                    'source'                => 'https://transvelo.github.io/bookworm/assets/plugins/bookworm-extensions.zip',
                    'version'               => $bookworm_version,
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'required'              => true
                ),

                array(
                    'name'                  => esc_html__( 'Bookworm Gutenberg Blocks', 'bookworm' ),
                    'slug'                  => 'bookwormgb',
                    'source'                => 'https://transvelo.github.io/bookworm/assets/plugins/bookwormgb.zip',
                    'version'               => $bookworm_version,
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'required'              => true
                ),

                array(
                    'name'                  => esc_html__( 'WPForms Lite', 'bookworm' ),
                    'slug'                  => 'wpforms-lite',
                    'version'               => '1.6.6',
                    'required'              => false,
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'external_url'          => '',
                ),

                array(
                    'name'                  => esc_html__( 'WP Store Locator', 'bookworm' ),
                    'slug'                  => 'wp-store-locator',
                    'version'               => '2.2.234',
                    'required'              => false,
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'external_url'          => '',
                ),

                array(
                    'name'                  => esc_html__( 'WooCommerce', 'bookworm' ),
                    'slug'                  => 'woocommerce',
                    'version'               => '5.2.0',
                    'required'              => true,
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'external_url'          => '',
                ),

                array(
                    'name'                  => esc_html__( 'YITH WooCommerce Wishlist', 'bookworm' ),
                    'slug'                  => 'yith-woocommerce-wishlist',
                    'version'               => '3.0.20',
                    'required'              => false,
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'is_callable'           => array( 'YITH_WCWL', 'get_instance' ),
                    'external_url'          => '',
                ),

                array(
                    'name'                  => esc_html__( 'YITH WooCommerce Compare', 'bookworm' ),
                    'slug'                  => 'yith-woocommerce-compare',
                    'version'               => '2.4.7',
                    'required'              => false,
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'is_callable'           => array( 'YITH_Woocompare', 'is_frontend' ),
                    'external_url'          => '',
                ),

                array(
                    'name'                  => esc_html__( 'MAS WooCommerce Brands', 'bookworm' ),
                    'slug'                  => 'mas-woocommerce-brands',
                    'version'               => '1.0.4',
                    'force_activation'      => false,
                    'force_deactivation'    => false,
                    'required'              => false,
                ),
            );

            $config = array(
                'id'           => 'bookworm',                 // Unique ID for hashing notices for multiple instances of TGMPA.
                'default_path' => '',                      // Default absolute path to bundled plugins.
                'menu'         => 'tgmpa-install-plugins', // Menu slug.
                'has_notices'  => true,                    // Show admin notices or not.
                'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
                'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
                'is_automatic' => false,                   // Automatically activate plugins after installation or not.
                'message'      => '',                      // Message to output right before the plugins table.
            );

            tgmpa( $plugins, $config );
        }
    }
endif;

return new Bookworm();
