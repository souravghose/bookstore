<?php
/**
 * Bookworm functions.
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_is_woocommerce_activated' ) ) {
    /**
     * Query WooCommerce activation
     */
    function bookworm_is_woocommerce_activated() {
        return class_exists( 'WooCommerce' ) ? true : false;
    }
}

if ( ! function_exists( 'bookworm_is_jetpack_activated' ) ) {
    /**
     * Query JetPack activation
     */
    function bookworm_is_jetpack_activated() {
        return class_exists( 'Jetpack' ) ? true : false;
    }
}


if ( ! function_exists( 'bookworm_is_mas_static_content_activated' ) ) {
    /**
     * Query MAS Static Content activation
     */
    function bookworm_is_mas_static_content_activated() {
        return class_exists( 'Mas_Static_Content' ) ? true : false;
    }
}

if( ! function_exists( 'bookworm_is_ocdi_activated' ) ) {
    /**
     * Check if One Click Demo Import is activated
     */
    function bookworm_is_ocdi_activated() {
        return class_exists( 'OCDI_Plugin' ) ? true : false;
    }
}

if ( ! function_exists( 'bookworm_is_wpsl_activated' ) ) {
    /**
     * Check if WP Store Locater is activated
     */
    function bookworm_is_wpsl_activated() {
        return class_exists( 'WP_Store_locator' ) ? true : false;
    }
}

/**
 * Query WooCommerce Extension Activation.
 * @var  $extension main extension class name
 * @return boolean
 */
function bookworm_is_woocommerce_extension_activated( $extension ) {

    if( bookworm_is_woocommerce_activated() ) {
        $is_activated = class_exists( $extension ) ? true : false;
    } else {
        $is_activated = false;
    }

    return $is_activated;
}

/**
 * Call a shortcode function by tag name.
 *
 * @since  1.0.0
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
function bookworm_do_shortcode( $tag, array $atts = array(), $content = null ) {
    global $shortcode_tags;

    if ( ! isset( $shortcode_tags[ $tag ] ) ) {
        return false;
    }

    return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}




/**
 * Adjust a hex color brightness
 * Allows us to create hover styles for custom link colors
 *
 * @param  strong  $hex   hex color e.g. #111111.
 * @param  integer $steps factor by which to brighten/darken ranging from -255 (darken) to 255 (brighten).
 * @return string        brightened/darkened hex color
 * @since  1.0.0
 */
function bookworm_adjust_color_brightness( $hex, $steps ) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter.
    $steps = max( -255, min( 255, $steps ) );

    // Format the hex color string.
    $hex = str_replace( '#', '', $hex );

    if ( 3 === strlen( $hex ) ) {
        $hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
    }

    // Get decimal values.
    $r = hexdec( substr( $hex, 0, 2 ) );
    $g = hexdec( substr( $hex, 2, 2 ) );
    $b = hexdec( substr( $hex, 4, 2 ) );

    // Adjust number of steps and keep it inside 0 to 255.
    $r = max( 0, min( 255, $r + $steps ) );
    $g = max( 0, min( 255, $g + $steps ) );
    $b = max( 0, min( 255, $b + $steps ) );

    $r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
    $g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
    $b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

    return '#' . $r_hex . $g_hex . $b_hex;
}



/**
 * Sanitizes choices (selects / radios)
 * Checks that the input matches one of the available choices
 *
 * @param array $input the available choices.
 * @param array $setting the setting object.
 * @since  1.0.0
 */
function bookworm_sanitize_choices( $input, $setting ) {
    // Ensure input is a slug.
    $input = sanitize_key( $input );

    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Checkbox sanitization callback.
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 * @since  1.0.0
 */
function bookworm_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Bookworm Sanitize Hex Color
 *
 * @param string $color The color as a hex.
 * @todo remove in 2.1.
 */
function bookworm_sanitize_hex_color( $color ) {
    _deprecated_function( 'bookworm_sanitize_hex_color', '2.0', 'sanitize_hex_color' );

    if ( '' === $color ) {
        return '';
    }

    // 3 or 6 hex digits, or the empty string.
    if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
        return $color;
    }

    return null;
}

/**
 * @param WP_Query|null $wp_query
 * @param bool $echo
 *
 * @return string
 * Accepts a WP_Query instance to build pagination (for custom wp_query()),
 * or nothing to use the current global $wp_query (eg: taxonomy term page)
 * - Tested on WP 4.9.5
 * - Tested with Bootstrap 4.1
 * - Tested on Sage 9
 *
 * USAGE:
 *     <?php echo landkit_bootstrap_pagination(); ?> //uses global $wp_query
 * or with custom WP_Query():
 *     <?php
 *      $query = new \WP_Query($args);
 *       ... while(have_posts()), $query->posts stuff ...
 *       echo landkit_bootstrap_pagination($query);
 *     ?>
 */
function bookworm_bootstrap_pagination( \WP_Query $wp_query = null, $echo = true, $ul_class = '' ) {

    if ( null === $wp_query ) {
        global $wp_query;
    }

    $pages = paginate_links( [
            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'format'       => '?paged=%#%',
            'current'      => max( 1, get_query_var( 'paged' ) ),
            'total'        => $wp_query->max_num_pages,
            'type'         => 'array',
            'show_all'     => false,
            'end_size'     => 3,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => esc_html__( '&laquo; Prev', 'bookworm' ),
            'next_text'    => esc_html__( 'Next &raquo;', 'bookworm' ),
            'add_args'     => false,
            'add_fragment' => ''
        ]
    );

    if ( is_array( $pages ) ) {

        if ( ! empty( $ul_class ) ) {
            $ul_class = ' ' . $ul_class;
        }

        $pagination = '<nav aria-label="' . esc_attr__( 'Page navigation', 'bookworm' ) . '"><ul class="pagination' . esc_attr( $ul_class ) . '">';

        foreach ( $pages as $page ) {
            $pagination .= '<li class="page-item ' . ( strpos( $page, 'current' ) !== false ? 'active' : '' ) . '">' . str_replace( 'page-numbers', 'page-link', $page ) . '</li>';
        }

        $pagination .= '</ul></nav>';

        if ( $echo ) {
            echo wp_kses_post( $pagination );
        } else {
            return $pagination;
        }
    }

    return null;
}

/*
 * Bookworm Sort Array Content By Priority
 */
if ( ! function_exists( 'bookworm_sort_priority_callback' ) ) {
    function bookworm_sort_priority_callback( $a, $b ) {
        if ( ! isset( $a['priority'], $b['priority'] ) || $a['priority'] === $b['priority'] ) {
            return 0;
        }
        return ( $a['priority'] < $b['priority'] ) ? -1 : 1;
    }
}

/*
 * Bookworm Print Array
 */
if ( ! function_exists( 'bookworm_pr' ) ) {
    function bookworm_pr( $var ) {
        echo '<pre>' . print_r( $var, 1 ) . '</pre>';
    }
}

/**
 * Enables template debug mode
 *
 */
function bookworm_template_debug_mode() {
    if ( ! defined( 'BOOKWORM_TEMPLATE_DEBUG_MODE' ) ) {
        $status_options = get_option( 'woocommerce_status_options', array() );
        if ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) {
            define( 'BOOKWORM_TEMPLATE_DEBUG_MODE', true );
        } else {
            define( 'BOOKWORM_TEMPLATE_DEBUG_MODE', false );
        }
    }
}
add_action( 'after_setup_theme', 'bookworm_template_debug_mode', 10 );

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @access public
 * @param string $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */
function bookworm_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
    if ( $args && is_array( $args ) ) {
        extract( $args );
    }

    $located = bookworm_locate_template( $template_name, $template_path, $default_path );

    if ( ! file_exists( $located ) ) {
        _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );
        return;
    }

    // Allow 3rd party plugin filter template file from their plugin
    $located = apply_filters( 'bookworm_get_template', $located, $template_name, $args, $template_path, $default_path );

    do_action( 'bookworm_before_template_part', $template_name, $template_path, $located, $args );

    include( $located );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *      yourtheme       /   $template_path  /   $template_name
 *      yourtheme       /   $template_name
 *      $default_path   /   $template_name
 *
 * @access public
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function bookworm_locate_template( $template_name, $template_path = '', $default_path = '' ) {
    if ( ! $template_path ) {
        $template_path = 'templates/';
    }

    if ( ! $default_path ) {
        $default_path = 'templates/';
    }

    // Look within passed path within the theme - this is priority
    $template = locate_template(
        array(
            trailingslashit( $template_path ) . $template_name,
            $template_name
        )
    );

    // Get default template
    if ( ! $template || BOOKWORM_TEMPLATE_DEBUG_MODE ) {
        $template = $default_path . $template_name;
    }

    // Return what we found
    return apply_filters( 'bookworm_locate_template', $template, $template_name, $template_path );
}

/*
 * Remove action of anonymous class object
 */
if ( ! function_exists( 'bookworm_remove_class_action' ) ) {
    function bookworm_remove_class_action( $hook_name = '', $class_name = '', $method_name = '', $priority = 10 ) {
        global $wp_filter;
        // Take only filters on right hook name and priority
        if ( ! isset( $wp_filter[ $hook_name ][ $priority ] ) || ! is_array( $wp_filter[ $hook_name ][ $priority ] ) ) {
            return false;
        }
        // Loop on filters registered
        foreach ( (array) $wp_filter[ $hook_name ][ $priority ] as $unique_id => $filter_array ) {
            // Test if filter is an array ! (always for class/method)
            if ( isset( $filter_array['function'] ) && is_array( $filter_array['function'] ) ) {
                // Test if object is a class, class and method is equal to param !
                if ( is_object( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) == $class_name && $filter_array['function'][1] == $method_name ) {
                    // Test for WordPress >= 4.7 WP_Hook class (https://make.wordpress.org/core/2016/09/08/wp_hook-next-generation-actions-and-filters/)
                    if ( is_a( $wp_filter[ $hook_name ], 'WP_Hook' ) ) {
                        unset( $wp_filter[ $hook_name ]->callbacks[ $priority ][ $unique_id ] );
                    } else {
                        unset( $wp_filter[ $hook_name ][ $priority ][ $unique_id ] );
                    }
                }
            }
        }
        return false;
    }
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function bookworm_pingback_header() {
    if ( is_singular() && pings_open() ) {
        echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
}
add_action( 'wp_head', 'bookworm_pingback_header' );
