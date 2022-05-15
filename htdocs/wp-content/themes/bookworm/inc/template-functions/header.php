<?php
/**
 * Template functions used in Header
 *
 * @package bookworm
*/

if ( ! function_exists( 'bookworm_header_version' ) ) {
    /**
     * Header Version
     */
    function bookworm_header_version() {
        $header_version = get_theme_mod( 'header_version', 'v1' );
        return apply_filters( 'bookworm_header_version', $header_version );
    }
}

if ( ! function_exists( 'bookworm_enable_topbar' ) ) {
    /**
     * Enable Topbar
     */
    function bookworm_enable_topbar() {
        $enable_topbar = get_theme_mod( 'enable_topbar', 'yes' );
        return apply_filters( 'bookworm_enable_topbar', filter_var( $enable_topbar, FILTER_VALIDATE_BOOLEAN ) );
    }
}

if ( ! function_exists( 'bookworm_enable_navbar' ) ) {
    /**
     * Enable Navbar
     */
    function bookworm_enable_navbar() {
        $enable_navbar = get_theme_mod( 'enable_navbar', 'yes' );
        return apply_filters( 'bookworm_enable_navbar', filter_var( $enable_navbar, FILTER_VALIDATE_BOOLEAN ) );
    }
}

if ( ! function_exists( 'bookworm_enable_offcanvas_nav' ) ) {
    /**
     * Enable Header Offcanvas Nav
     */
    function bookworm_enable_offcanvas_nav() {
        $enable_offcanvas = get_theme_mod( 'enable_offcanvas_nav', 'yes' );
        return apply_filters( 'bookworm_enable_offcanvas_nav', filter_var( $enable_offcanvas, FILTER_VALIDATE_BOOLEAN ) );
    }
}

if ( ! function_exists( 'bookworm_offcanvas_toggler_title' ) ) {
    /**
     * Enable Header Offcanvas Toggler Title
     */
    function bookworm_offcanvas_toggler_title() {
        $offcanvas_toggler_title = get_theme_mod( 'offcanvas_toggler_title', esc_html__( 'Browse categories', 'bookworm' ) );
        return apply_filters( 'bookworm_offcanvas_toggler_title', $offcanvas_toggler_title );
    }
}

if ( ! function_exists( 'bookworm_offcanvas_header_title' ) ) {
    /**
     * Enable Header Offcanvas Nav Header Title
     */
    function bookworm_offcanvas_header_title() {
        $offcanvas_header_title = get_theme_mod( 'offcanvas_header_title', esc_html__( 'MENU', 'bookworm' ) );
        return apply_filters( 'bookworm_offcanvas_header_title', $offcanvas_header_title );
    }
}

if ( ! function_exists( 'bookworm_enable_department_menu' ) ) {
    /**
     * Enable Header Department Menu
     */
    function bookworm_enable_department_menu() {
        $enable_offcanvas = get_theme_mod( 'enable_department_menu', 'yes' );
        return apply_filters( 'bookworm_enable_department_menu', filter_var( $enable_offcanvas, FILTER_VALIDATE_BOOLEAN ) );
    }
}

if ( ! function_exists( 'bookworm_department_menu_toggler_title' ) ) {
    /**
     * Enable Header Department Menu Toggler Title
     */
    function bookworm_department_menu_toggler_title() {
        $department_menu_toggler_title = get_theme_mod( 'department_menu_toggler_title', esc_html__( 'Browse categories', 'bookworm' ) );
        return apply_filters( 'bookworm_department_menu_toggler_title', $department_menu_toggler_title );
    }
}

if ( ! function_exists( 'bookworm_enable_mini_cart' ) ) {
    /**
     * Enable Header Mini Cart
     */
    function bookworm_enable_mini_cart() {
        $enable_cart = get_theme_mod( 'enable_cart', 'yes' );
        return apply_filters( 'bookworm_enable_mini_cart', filter_var( $enable_cart , FILTER_VALIDATE_BOOLEAN ) );
    }
}

if ( ! function_exists( 'bookworm_enable_account' ) ) {
    /**
     * Enable Header Account
     */
    function bookworm_enable_account() {
        $enable_account = get_theme_mod( 'enable_account', 'yes' );
        return apply_filters( 'bookworm_enable_account', filter_var( $enable_account , FILTER_VALIDATE_BOOLEAN ) );
    }
}

if ( ! function_exists( 'bookworm_enable_store_locator_link' ) ) {
    /**
     * Enable Store Locator Link
     */
    function bookworm_enable_store_locator_link() {
        $enable_store_locator = get_theme_mod( 'bookworm_store_location_page' );
        return apply_filters( 'bookworm_enable_store_locator_link', $enable_store_locator );
    }
}

if ( ! function_exists( 'bookworm_enable_wishlist' ) ) {
    /**
     * Enable Header Wishlist
     */
    function bookworm_enable_wishlist() {
        $enable_wishlist = get_theme_mod( 'enable_wishlist', 'yes' );
        return apply_filters( 'bookworm_enable_wishlist', filter_var( $enable_wishlist , FILTER_VALIDATE_BOOLEAN ) );
    }
}

if ( ! function_exists( 'bookworm_enable_compare' ) ) {
    /**
     * Enable Header Compare
     */
    function bookworm_enable_compare() {
        $enable_compare = get_theme_mod( 'enable_compare', 'yes' );
        return apply_filters( 'bookworm_enable_compare', filter_var( $enable_compare , FILTER_VALIDATE_BOOLEAN ) );
    }
}

if( ! function_exists( 'bookworm_header_is_sticky' ) ) {
    function bookworm_header_is_sticky() {
        $enable_sticky = get_theme_mod( 'header_is_sticky', 'no' );
        return (bool) apply_filters( 'bookworm_header_is_sticky', filter_var( $enable_sticky , FILTER_VALIDATE_BOOLEAN ) );
    }
}


if ( ! function_exists( 'bookworm_site_title_or_logo' ) ) {
    /**
     * Display the site title or logo
     *
     * @since 1.0.0
     * @param bool $echo Echo the string or return it.
     * @return string
     */
    function bookworm_site_title_or_logo( $echo = true, $tag_class = '' ) {
        $header_version = bookworm_header_version();
    
        if( $header_version === 'v10') {
            $additional_classes=' mb-3';
        } elseif( $header_version === 'v8') {
            $additional_classes=' mb-2';
        } elseif ( $header_version === 'v3') {
            $additional_classes =' pb-2d75';
        } elseif( $header_version === 'v2') {
            $additional_classes=' mb-2';
        } else {
            $additional_classes= ' mb-1';
        }

        $custom_logo_id = apply_filters( 'bookworm_custom_logo', '');

        if( apply_filters( 'bookworm_site_logo_svg', filter_var( get_theme_mod( 'enable_logo', 'no' ), FILTER_VALIDATE_BOOLEAN ) ))  {

            ob_start();
            bookworm_get_template( 'global/logo-svg.php' );
            $bookworm_logo_svg = ob_get_clean();

            $html = sprintf('<a href="%1$s" class="header-logo-link d-block' . esc_attr( $additional_classes ) . '">%2$s</a>',
                esc_url( home_url( '/' ) ),
                $bookworm_logo_svg
            );
            
        } elseif ( !empty ($custom_logo_id)) {
            $custom_logo_attr = [
                'class' => 'header-logo',
            ];

            // If the logo alt attribute is empty, get the site title
            $custom_logo_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
            if ( empty( $custom_logo_alt ) ) {
                $custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
            }

            $custom_logo_meta  = wp_get_attachment_metadata( $custom_logo_id );
            $custom_logo_width = isset( $custom_logo_meta['width'] ) ? (int) $custom_logo_meta['width'] : 340;

            $html = sprintf(
                '<a href="%1$s" class="header-custom-logo-link d-block' . esc_attr( $additional_classes ) . '" rel="home" style="width: %3$dpx;">%2$s</a>',
                esc_url( home_url( '/' ) ),
                wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr ),
                (float) $custom_logo_width / 2
            );

        } elseif ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
            $logo = get_custom_logo();
            $html = is_home() ? '<h1 class="logo">' . $logo . '</h1>' : $logo;
        }  else {
            $tag = is_home() ? 'h1' : 'h1';
            $tag_class = ! empty( $tag_class )? ' ' . $tag_class: '';
            $html = '<' . esc_attr( $tag ) . ' class="beta site-title' . esc_attr( $tag_class ) .' "><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></' . esc_attr( $tag ) . '>';
        }

        if ( ! $echo ) {
            return $html;
        }

        echo apply_filters( 'bookworm_logo', $html ); // WPCS: XSS ok.
    }
}

if ( ! function_exists( 'bookworm_get_svg_logo' ) ) {
    /**
     * Displays site logo in header
     */
    function bookworm_get_svg_logo() {
        bookworm_get_template( 'global/logo-svg.php' );
    }
}

if ( ! function_exists( 'bookworm_offcanvas_toggler' ) ) {
    /**
     * Displays Offcanvas Toggler
     *
     * @return void
     */
    function bookworm_offcanvas_toggler( $classes='', $icon_only=false, $bg_color='light', $header_version='' ) {
        $enable_offcanvas = bookworm_enable_offcanvas_nav();
        if( $enable_offcanvas && ( has_nav_menu( 'offcanvas' ) || has_nav_menu ( 'primary') ) ) {
            $offcanvas_toggler_title = bookworm_offcanvas_toggler_title();
            if( empty( $header_version ) ) {
                $header_version = bookworm_header_version();
            }

            ?><div class="offcanvas-toggler<?php if( ! empty( $classes ) ) echo esc_attr( ' ' . $classes ); ?>">
                <a id="offcanvasNavToggler" href="javascript:;" role="button" class="cat-menu <?php echo esc_attr( $bg_color !== 'dark' ? 'text-dark' : 'text-white' ) ?>"
                    aria-controls="offcanvasNav"
                    aria-haspopup="true"
                    aria-expanded="false"
                    data-unfold-event="click"
                    data-unfold-hide-on-scroll="false"
                    data-unfold-target="#offcanvasNav"
                    data-unfold-type="css-animation"
                    data-unfold-overlay='{
                        "className": "u-sidebar-bg-overlay",
                        "background": "rgba(0, 0, 0, .7)",
                        "animationSpeed": 100
                    }'
                    data-unfold-animation-in='<?php echo esc_attr ( is_rtl() ? "fadeInRight" : "fadeInLeft"); ?>'
                    data-unfold-animation-out='<?php echo esc_attr (is_rtl() ? "fadeOutRight" : "fadeOutLeft"); ?>'
                    data-unfold-duration="100"
                >
                    <?php if( $bg_color !== 'dark' ) : ?>
                        <svg width="20px" height="18px">
                            <path fill-rule="evenodd"  fill="rgb(25, 17, 11)" d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z"/>
                            <path fill-rule="evenodd"  fill="rgb(25, 17, 11)" d="M-0.000,8.000 L15.000,8.000 L15.000,10.000 L-0.000,10.000 L-0.000,8.000 Z"/>
                            <path fill-rule="evenodd"  fill="rgb(25, 17, 11)" d="M-0.000,16.000 L20.000,16.000 L20.000,18.000 L-0.000,18.000 L-0.000,16.000 Z"/>
                        </svg>
                    <?php else : ?>
                        <svg width="20px" height="18px">
                            <path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z"/>
                            <path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M-0.000,8.000 L15.000,8.000 L15.000,10.000 L-0.000,10.000 L-0.000,8.000 Z"/>
                            <path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M-0.000,16.000 L20.000,16.000 L20.000,18.000 L-0.000,18.000 L-0.000,16.000 Z"/>
                        </svg>
                    <?php endif; ?>
                    <?php if( ! $icon_only && ! empty( $offcanvas_toggler_title ) ) : ?>
                        <span class="ml-3"><?php echo esc_html( $offcanvas_toggler_title ); ?></span>
                    <?php endif; ?>
                </a>
                <?php do_action( "bookworm_offcanvas_toggler_after" ); ?>
                <?php do_action( "bookworm_offcanvas_toggler_after_{$header_version}" ); ?>
            </div><?php
        }
    }
}

if ( ! function_exists( 'bookworm_offcanvas_nav' ) ) {
    /**
     * Displays Offcanvas Nav
     *
     * @return void
     */
    function bookworm_offcanvas_nav() {
        $enable_offcanvas = bookworm_enable_offcanvas_nav();
        if( $enable_offcanvas && ( has_nav_menu( 'offcanvas' ) || has_nav_menu ( 'primary') ) ) {
            $offcanvas_header_title = bookworm_offcanvas_header_title();
            ?><aside id="offcanvasNav" class="u-sidebar u-sidebar__md u-sidebar--left" aria-labelledby="offcanvasNavToggler">
                <div class="u-sidebar__scroller js-scrollbar">
                    <div class="u-sidebar__container">
                        <div class="u-header-sidebar__footer-offset">
                            <div class="u-sidebar__body">
                                <div class="u-sidebar__content u-header-sidebar__content">
                                    <header class="border-bottom px-4 px-md-5 py-4 d-flex align-items-center justify-content-between">
                                        <h2 class="font-size-3 mb-0"><?php echo esc_html( $offcanvas_header_title ); ?></h2>
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="close ml-auto"
                                                aria-controls="offcanvasNav"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                                data-unfold-event="click"
                                                data-unfold-hide-on-scroll="false"
                                                data-unfold-target="#offcanvasNav"
                                                data-unfold-type="css-animation"
                                                data-unfold-animation-in='<?php echo esc_attr ( is_rtl() ? "fadeInRight" : "fadeInLeft"); ?>'
                                                data-unfold-animation-out='<?php echo esc_attr (is_rtl() ? "fadeOutRight" : "fadeOutLeft"); ?>'
                                                data-unfold-duration="500">
                                                <span aria-hidden="true"><i class="fas fa-times ml-2"></i></span>
                                            </button>
                                        </div>
                                    </header>
                                    <div class="border-bottom">
                                        <div class="zeynep pt-4"><?php
                                            $offcanvasMenuSlug = apply_filters( 'bookworm_offcanvas_menu' , '' );

                                            $offcanvas_menu_args = apply_filters( 'bookworm_offcanvas_args', [
                                                'theme_location'        => has_nav_menu( 'offcanvas' ) ? 'offcanvas' : 'primary',
                                                'walker'                => new WP_OffCanvas_Navwalker(),
                                                'id_prefix'             => 'offcanvas',
                                           ] );

                                            if( ! empty ( $offcanvasMenuID ) && $offcanvasMenuID > 0 ) {
                                                $offcanvas_menu_args['menu'] = $offcanvasMenuID;
                                                unset( $offcanvas_menu_args['theme_location'] );
                                            } elseif( ! empty( $offcanvasMenuSlug ) ) {
                                                $offcanvas_menu_args['menu'] = $offcanvasMenuSlug;
                                                unset( $offcanvas_menu_args['theme_location'] );
                                            }
                                            wp_nav_menu( $offcanvas_menu_args ); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside><?php
        }
    }
}

if ( ! function_exists( 'bookworm_site_header_offcanvas_toggle_links' ) ) {
    /**
     * Displays Site Header Offcanvas Toggle Links
     *
     * @return void
     */
    function bookworm_site_header_offcanvas_toggle_links( $text_classes='', $badge_classes='text-white bg-dark', $default_icon_classes='font-size-5', $secondary_text_classes="text-secondary-gray-1080 font-size-1", $wrapper_classes='' ) {
        $links = apply_filters( 'bookworm_site_header_offcanvas_toggle_links', [] );

        if( ! empty( $links ) && is_array( $links ) ) {
            uasort( $links, 'bookworm_sort_priority_callback' );
            reset( $links );
            $first_key = key( $links );
            ?><div class="d-flex align-items-center<?php if( ! empty( $wrapper_classes ) ) echo esc_attr( ' ' . $wrapper_classes ); ?>"><?php
                foreach ( $links as $key => $link ) {
                    $default_toogler_args = apply_filters( 'bookworm_site_header_offcanvas_default_toogler_args', [
                        'id'                    => "sidebarNavToggler-" . $key,
                        'href'                  => "javascript:;",
                        'role'                  => "button",
                        'aria-controls'         => "sidebarContent-" . $key,
                        'aria-haspopup'         => "true",
                        'aria-expanded'         => "false",
                        'data-unfold-event'     => "click",
                        'data-unfold-hide-on-scroll' => "false",
                        'data-unfold-target'    => "#sidebarContent-" . $key,
                        'data-unfold-type'      => "css-animation",
                        'data-unfold-overlay'   => '{
                            "className": "u-sidebar-bg-overlay",
                            "background": "rgba(0, 0, 0, .7)",
                            "animationSpeed": 500
                        }',
                        'data-unfold-animation-in'  => "fadeInRight",
                        'data-unfold-animation-out' => "fadeOutRight",
                        'data-unfold-duration'  => "500",
                    ] );

                    if ( ! isset( $link['atts'] ) ) {
                        $link['atts'] = [];
                    }

                    if( isset( $link['type'] ) && $link['type'] === 'toggler' ) {
                        $link['atts'] = wp_parse_args( $link['atts'], $default_toogler_args );
                    }

                    if( ! isset( $link['atts']['class'] ) ) {
                        $link['atts']['class'] = '';
                    }

                    if( $first_key !== $key ) {
                        $link['atts']['class'] .= ' ml-4';
                    }

                    $link['atts'] = array_filter( $link['atts'] );

                    $title_text_1 = isset( $link['title_text_1'] ) && ! empty( $link['title_text_1'] ) ? $link['title_text_1'] : '';
                    $title_text_2 = isset( $link['title_text_2'] ) && ! empty( $link['title_text_2'] ) ? $link['title_text_2'] : '';
                    $badge_text = isset( $link['badge_text'] ) && ! empty( $link['badge_text'] ) ? $link['badge_text'] : '';

                    if( $key === 'my_cart' ) {
                        $title_text_2 = bookworm_cart_link_total_text();
                    }

                    $icon_classes = $default_icon_classes;
                    if( isset( $link['icon_class'] ) && ! empty( $link['icon_class'] ) && ! empty( $icon_classes ) ) {
                        $icon_classes = $link['icon_class'] . ' ' . $icon_classes;
                    } elseif( isset( $link['icon_class'] ) && ! empty( $link['icon_class'] ) ) {
                        $icon_classes = $link['icon_class'];
                    }

                    if( isset( $link['text_class'] ) && ! empty( $link['text_class'] ) && ! empty( $text_classes ) ) {
                        $text_classes = $link['text_class'] . ' ' . $text_classes;
                    } elseif( isset( $link['text_class'] ) && ! empty( $link['text_class'] ) ) {
                        $text_classes = $link['text_class'];
                    }

                    $attributes = '';
                    foreach ( $link['atts'] as $attr => $value ) {
                        if ( ! empty( $value ) ) {
                            $value       = ( 'href' === $attr ) && ( $value !== 'javascript:;' ) ? esc_url( $value ) : esc_attr( $value );
                            $attributes .= ' ' . $attr . '="' . $value . '"';
                        }
                    }

                    if( !empty ( $title_text_1 ) || !empty ( $title_text_2 ) || !empty ( $icon_classes ) ) {
                        ?>
                        <a<?php echo print_r( $attributes, true ); ?>>
                            <div class="d-flex align-items-center text-white font-size-2 text-lh-sm position-relative">
                                <?php if( ! empty( $badge_text ) || $key === 'my_cart' ) : ?>
                                    <span class="position-absolute width-16 height-16 rounded-circle d-flex align-items-center justify-content-center font-size-n9 left-0 top-0 ml-n2 mt-n1 <?php echo esc_attr( $badge_classes ); ?>">
                                        <?php if ( $key === 'my_cart' ) {
                                            bookworm_cart_link_count(); 
                                        } else {
                                            echo esc_html( $badge_text );
                                        } ?>
                                    </span>
                                <?php endif; ?>
                                <?php if( ! empty( $icon_classes ) ) : ?>
                                    <i class="<?php echo esc_attr( $icon_classes ); ?>"></i>
                                <?php endif; ?>
                                <?php if( !empty ( $title_text_1 ) || !empty ( $title_text_2 ) ) : ?>
                                    <div class="ml-2 <?php echo esc_attr( $text_classes ); ?>">
                                        <?php if( ! empty( $title_text_1 ) ) : ?>
                                            <span class="<?php echo esc_attr( $secondary_text_classes ); ?>">
                                                <?php echo wp_kses_post( $title_text_1 ); ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if( ! empty( $title_text_2 ) ) : ?>
                                            <div><?php echo wp_kses_post( $title_text_2 ); ?></div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>
                        <?php
                    }
                }
            ?></div><?php
        }
    }
}

if ( ! function_exists( 'bookworm_site_header_icons_links' ) ) {
    /**
     * Displays Icon Links For Header
     *
     * @return void
     */
    function bookworm_site_header_icons_links( $anchor_classes='text-dark', $badge_classes='text-white bg-dark left-0', $nav_classes='d-none d-md-flex', $default_icon_classes='font-size-4', $icon_only=false, $id_base='sidebarNavToggler-' ) {
        $links = apply_filters( 'bookworm_site_header_icons_links', [] );

        if( ! empty( $links ) && is_array( $links ) ) {
            uasort( $links, 'bookworm_sort_priority_callback' );
            end( $links );
            $end_key = key( $links );
            reset( $links );
            ?><ul class="nav<?php if( ! empty( $nav_classes ) ) echo esc_attr( ' ' . $nav_classes ); ?>"><?php
                foreach ( $links as $key => $link ) {
                    $default_icons_links_args = apply_filters( 'bookworm_site_header_offcanvas_default_icons_links_args', [
                        'id'                    => $id_base. '' .$key,
                        'href'                  => "javascript:;",
                        'role'                  => "button",
                        'aria-controls'         => "sidebarContent-" . $key,
                        'aria-haspopup'         => "true",
                        'aria-expanded'         => "false",
                        'data-unfold-event'     => "click",
                        'data-unfold-hide-on-scroll' => "false",
                        'data-unfold-target'    => "#sidebarContent-" . $key,
                        'data-unfold-type'      => "css-animation",
                        'data-unfold-overlay'   => '{
                            "className": "u-sidebar-bg-overlay",
                            "background": "rgba(0, 0, 0, .7)",
                            "animationSpeed": 500
                        }',
                        'data-unfold-animation-in'  => is_rtl() ? 'fadeInLeft' : 'fadeInRight',
                        'data-unfold-animation-out' => is_rtl() ? 'fadeOutLeft' : 'fadeOutRight',
                        'data-unfold-duration'  => "500",
                    ] );

                    if ( ! isset( $link['atts'] ) ) {
                        $link['atts'] = [];
                    }

                    if( isset( $link['type'] ) && $link['type'] === 'toggler' ) {
                        $link['atts'] = wp_parse_args( $link['atts'], $default_icons_links_args );
                    }

                    if( ! isset( $link['atts']['class'] ) ) {
                        $link['atts']['class'] = 'nav-link ' . $anchor_classes;
                    }

                    if( isset( $link['atts'] ) && is_array( $link['atts'] ) ) {
                        if( $end_key === $key ) {
                            $link['atts']['class'] .= ' pr-0';
                        }

                        if( ( isset( $link['badge_text'] ) && ! empty( $link['badge_text'] ) ) || $key === 'my_cart' ) {
                            $link['atts']['class'] .= ' position-relative';
                        
                        }
                    }

                    $link['atts'] = array_filter( $link['atts'] );

                    $text = isset( $link['text'] ) && ! empty( $link['text'] ) ? $link['text'] : '';

                    if( $key === 'my_cart' ) {
                        $text = bookworm_cart_link_total_text();
                    }

                    $icon_classes = $default_icon_classes;
                    if( isset( $link['icon_class'] ) && ! empty( $link['icon_class'] ) && ! empty( $icon_classes ) ) {
                        $icon_classes = $link['icon_class'] . ' ' . $icon_classes;
                    } elseif( isset( $link['icon_class'] ) && ! empty( $link['icon_class'] ) ) {
                        $icon_classes = $link['icon_class'];
                    }

                    $attributes = '';
                    foreach ( $link['atts'] as $attr => $value ) {
                        if ( ! empty( $value ) ) {
                            $value       = ( 'href' === $attr ) && ( $value !== 'javascript:;' ) ? esc_url( $value ) : esc_attr( $value );
                            $attributes .= ' ' . $attr . '="' . $value . '"';
                        }
                    }

                    if( ( ! $icon_only && ! empty( $text ) ) || ! empty( $icon_classes ) ) {
                        ?>
                        <li class="nav-item<?php if( isset( $link['item_class'] ) && ! empty( $link['item_class'] ) ) echo esc_attr( ' ' . $link['item_class'] ); ?>">
                            <a<?php echo print_r( $attributes, true ); ?>>
                                <?php if( ( isset( $link['badge_text'] ) && ! empty( $link['badge_text'] ) ) || $key === 'my_cart' )  : ?>

                                    <span class="position-absolute width-16 height-16 rounded-circle d-flex align-items-center justify-content-center font-size-n9 <?php echo esc_attr( $badge_classes ); ?>">
                                        <?php if ( $key === 'my_cart' ) {
                                            bookworm_cart_link_count(); 
                                        } else {
                                            echo esc_html( $badge_text );
                                        } ?>
                                    </span>
                                <?php endif; ?>
                                <?php if( ! empty( $icon_classes ) ) : ?>
                                    <i class="<?php echo esc_attr( $icon_classes ); ?>"></i>
                                <?php endif; ?>
                                <?php if( ! $icon_only && ! empty( $text ) ) : ?>
                                    <span class="d-none d-xl-inline h6 mb-0 ml-1">
                                        <?php echo wp_kses_post( $text ); ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <?php
                    }
                }
            ?></ul><?php
        }
    }
}

if ( ! function_exists( 'bookworm_cart_link_count' ) ) {
    function bookworm_cart_link_count() {
        ?><span class="cart-contents-count">
            <?php echo absint( is_a( WC()->cart, 'WC_Cart' ) ? WC()->cart->get_cart_contents_count() : 0 ); ?>
        
        </span><?php
    }
}

if ( ! function_exists( 'bookworm_cart_link_total_text' ) ) {
    function bookworm_cart_link_total_text() {
        ob_start();
        ?><span class="cart-contents-total">
            <?php echo is_a( WC()->cart, 'WC_Cart' ) ? WC()->cart->get_total() : 0; ?>
        </span><?php
        return ob_get_clean();
    }
}

if ( ! function_exists( 'bookworm_site_header_mobile_icons_links' ) ) {
    /**
     * Displays Icon Links For Header Mobile
     *
     * @return void
     */
    function bookworm_site_header_mobile_icons_links() {
        bookworm_site_header_icons_links( 'text-dark px-2', 'text-white bg-dark right-0' ,'d-md-none ml-auto','', false, 'sidebarMobileNavToggler-'  );
    }
}

if ( ! function_exists( 'bookworm_site_header_support_lists' ) ) {
    /**
     * Displays Site Header Support Lists
     *
     * @return void
     */
    function bookworm_site_header_support_lists( $wrapper_classes="d-none d-md-flex align-items-center mt-3 mt-md-0 ml-md-auto" ) {
        $lists = apply_filters( 'bookworm_site_header_support_lists', [] );

        if( ! empty( $lists ) && is_array( $lists ) ) {
            uasort( $lists, 'bookworm_sort_priority_callback' );
            end( $lists );
            $end_key = key( $lists );
            reset( $lists );

            ?><div class="<?php echo esc_attr( $wrapper_classes ); ?>"><?php
                foreach ( $lists as $key => $list ) {
                    $link = isset( $list['link'] ) && ! empty( $list['link'] ) ? $list['link'] : '';
                    $text_1 = isset( $list['text_1'] ) && ! empty( $list['text_1'] ) ? $list['text_1'] : '';
                    $text_2 = isset( $list['text_2'] ) && ! empty( $list['text_2'] ) ? $list['text_2'] : '';
                    $icon_class = isset( $list['icon_class'] ) && ! empty( $list['icon_class'] ) ? $list['icon_class'] : '';

                    if( !empty ( $link ) && ( !empty ( $text_1 ) || !empty ( $text_2 ) || !empty ( $icon_class ) ) ) {
                        ?>
                        <a href="<?php echo esc_url( $link ); ?>" <?php if( $end_key !== $key ) echo 'class="' . esc_attr( 'mr-4 mb-4 mb-md-0' ) . '"'; ?>>
                            <div class="d-flex align-items-center text-dark font-size-2 text-lh-sm">
                                <?php if( ! empty( $icon_class ) ) : ?>
                                    <i class="<?php echo esc_attr( $icon_class ); ?> font-size-5 mt-2 mr-1"></i>
                                <?php endif; ?>
                                <?php if( !empty ( $text_1 ) || !empty ( $text_2 ) ) : ?>
                                    <div class="ml-2">
                                        <?php if( ! empty( $text_1 ) ) : ?>
                                            <span class="text-secondary-gray-1090 font-size-1">
                                                <?php echo wp_kses_post( $text_1 ); ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if( ! empty( $text_2 ) ) : ?>
                                            <div class="h6 mb-0">
                                                <?php echo wp_kses_post( $text_2 ); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>
                        <?php
                    }
                }
            ?></div><?php
        }
    }
}

if ( ! function_exists( 'bookworm_site_header_support_lists_args' ) ) {
    /**
     * Displays Site Header Support Lists
     *
     * @return void
     */
    function bookworm_site_header_support_lists_args( $lists ) {
        $display_mail_support = apply_filters( 'bookworm_site_header_support_lists_display_mail_support', filter_var( get_theme_mod( 'display_mail_support', 'yes' ), FILTER_VALIDATE_BOOLEAN ) );
        $display_tel_support = apply_filters( 'bookworm_site_header_support_lists_display_tel_support', filter_var( get_theme_mod( 'display_tel_support', 'yes' ), FILTER_VALIDATE_BOOLEAN ) );

        if( $display_mail_support ) {
            $mail_support_pre  = apply_filters( 'bookworm_site_header_mail_support_pre', get_theme_mod( 'mail_support_pre', 'info@bookworm.com' ) );
            $mail_support_text = apply_filters( 'bookworm_site_header_mail_support_text', get_theme_mod( 'mail_support_text', esc_html__( 'Any questions', 'bookworm' ) ) ) ;
            $mail_support_link = apply_filters( 'bookworm_site_header_mail_support_link', get_theme_mod( 'mail_support_link', 'mailto:info@bookworm.com' ) );
            $mail_support_icon = apply_filters( 'bookworm_site_header_mail_support_icon', get_theme_mod( 'mail_support_icon', 'flaticon-question' ) );

            $lists['mail'] = [
                'text_1'        => $mail_support_pre,
                'text_2'        => $mail_support_text,
                'link'          => $mail_support_link,
                'icon_class'    => $mail_support_icon,
            ];
        }

        if( $display_tel_support ) {
            $tel_support_pre = apply_filters( 'bookworm_site_header_phone_support_pre', get_theme_mod( 'tel_support_pre', '+1 246-345-0695' ));
            $tel_support_text = apply_filters( 'bookworm_site_header_phone_support_text', get_theme_mod( 'tel_support_text', esc_html__( 'Call toll-free', 'bookworm' ) ) );
            $tel_support_link = apply_filters( 'bookworm_site_header_phone_support_link', get_theme_mod( 'tel_support_link', 'tel:+1246-345-0695' ));
            $tel_support_icon = apply_filters( 'bookworm_site_header_phone_support_icon', get_theme_mod( 'tel_support_icon', 'flaticon-phone' ));

            $lists['tel'] = [
                'text_1'        => $tel_support_pre,
                'text_2'        => $tel_support_text,
                'link'          => $tel_support_link,
                'icon_class'    => $tel_support_icon,
            ];
        }

        return $lists;
    }
}

if ( ! function_exists( 'bookworm_site_header_department_menu' ) ) {
    /**
     * Displays Department Menu in Site Header
     *
     * @return void
     */
    function bookworm_site_header_department_menu( $title_bg_color='bg-dark', $title_text_color='text-white' ) {
        $enable_department_menu = bookworm_enable_department_menu();
        if ( $enable_department_menu && has_nav_menu( 'department' ) ) :
            $department_menu_title = bookworm_department_menu_toggler_title();
            $show_dropdown = apply_filters( 'bookworm_department_menu_show_dropdown_default', true );
            ?><div id="departmentMenu" class="mr-5 d-none d-xl-block">
                <div class="position-relative">
                    <div class="<?php echo esc_attr( $title_bg_color ); ?> py-3 px-5 card-collapse" id="departmentMenuTitle">
                        <button type="button" class="btn btn-link btn-block p-0 d-flex align-items-center card-btn"
                            data-toggle="collapse"
                            data-target="#departmentMenuCollapse"
                            aria-expanded="true"
                            aria-controls="departmentMenuCollapse">
                            <svg width="20px" height="18px">
                                <path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M-0.000,-0.000 L20.000,-0.000 L20.000,2.000 L-0.000,2.000 L-0.000,-0.000 Z"/>
                                <path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M-0.000,8.000 L15.000,8.000 L15.000,10.000 L-0.000,10.000 L-0.000,8.000 Z"/>
                                <path fill-rule="evenodd"  fill="rgb(255, 255, 255)" d="M-0.000,16.000 L20.000,16.000 L20.000,18.000 L-0.000,18.000 L-0.000,16.000 Z"/>
                            </svg>
                            <span class="ml-3 <?php echo esc_attr( $title_text_color ); ?>"><?php echo esc_html( $department_menu_title ); ?></span>
                            <i class="fas fa-chevron-down ml-5 font-size-2 <?php echo esc_attr( $title_text_color ); ?>"></i>
                        </button>
                    </div>
                    <div id="departmentMenuCollapse" class="z-index-2 bg-white collapse position-absolute right-0 left-0 border<?php if( is_front_page() && $show_dropdown ) echo esc_attr( ' show' ); ?>"
                        aria-labelledby="departmentMenuTitle"
                        data-parent="#departmentMenu">
                        <div class="card-body p-0">
                            <?php
                                $headerDepartmentMenuSlug = apply_filters( 'bookworm_departmenu_menu' , '' );
                                $header_department_menu_args = apply_filters( 'bookworm_header_department_menu_args', [
                                    'theme_location'      => 'department',
                                    'walker'              => new WP_Bootstrap_Navwalker(),
                                    'menu_id_prefix'      => 'department',
                                    'menu_item_class'     => false,
                                    'menu_class'          => 'list-unstyled vertical-menu position-relative mb-0',
                                    'container'           => false,
                                    'nav_link_class'      => 'dropdown-nav-link dropdown-toggle d-flex align-items-center text-dark border-bottom',
                                    'submenu_link_class'  => 'bg-transparent link-black-100 px-0 py-1',
                                    'dropdown_menu_class' => 'dropdown-unfold overflow-hidden top-0 right-auto left-100 bottom-0 mt-0 px-5 py-3 rounded-0',
                                    'sub_menu_min_width'  => '700px',
                                    'icon_txt_class'      => 'mr-auto',
                                    'icon_class'          => 'font-size-5',
                                    'icon_html_before'    => '<div class="width-30 mr-2 text-lh-sm">',
                                    'icon_html_after'     => '</div>',
                                    'depth'               => 2,
                                ] );

                                if( ! empty ( $headerDepartmentMenuID ) && $headerDepartmentMenuID > 0 ) {
                                    $header_department_menu_args['menu'] = $headerDepartmentMenuID;
                                } elseif( ! empty( $headerDepartmentMenuSlug ) ) {
                                    $header_department_menu_args['menu'] = $headerDepartmentMenuSlug;
                                }

                                wp_nav_menu( $header_department_menu_args );
                            ?>
                        </div>
                    </div>
                </div>
            </div><?php
        endif;
    }
}

if ( ! function_exists( 'bookworm_site_header_search_icon_link' ) ) {
    function bookworm_site_header_search_icon_link( $links ) {
        if ( apply_filters ('bookworm_enable_site_header_search_icon' , true )):
            $links['search'] = [
                'icon_class'    => 'flaticon-loupe',
                'item_class'    => 'd-none d-md-block',
                'priority'      => 10,
                'type'          => 'toggler',
                'atts'          => [
                    'id'                        => "searchSlideDownInvoker",
                    'aria-controls'             => "searchSlideDown",
                    'data-unfold-target'        => "#searchSlideDown",
                    'data-unfold-animation-in'  => "active",
                    'data-unfold-animation-out' => "fadeOutUp",
                    'data-unfold-duration'      => "800",
                    'data-unfold-delay'         => "0",
                ],
            ];
        endif;

        return $links;
    }
}

if( ! function_exists( 'bookworm_is_account_registration_enable' ) ) {
    function bookworm_is_account_registration_enable() {
        return (bool) apply_filters( 'bookworm_is_account_registration_enable',
            // is WooCommerce activated?
            bookworm_is_woocommerce_activated()
            // is user can register somehow?
            && ( get_option( 'users_can_register' ) || 'yes' === get_option( 'woocommerce_enable_signup_and_login_from_checkout' ) || 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) )
        );
    }
}

if( ! function_exists( 'bookworm_page_header_layout' ) ) {
    function bookworm_page_header_layout( $layout ) {
        global $post;
        if ( is_page() && isset( $post->ID ) ) {
            $header_meta_values = get_post_meta( $post->ID, '_header_style', true );

            if ( isset( $header_meta_values ) && $header_meta_values ) {
                $layout = $header_meta_values;
            }
        }
        return $layout;
    }
}

require get_template_directory() . '/inc/template-functions/headers/header-v1.php';
require get_template_directory() . '/inc/template-functions/headers/header-v2.php';
require get_template_directory() . '/inc/template-functions/headers/header-v3.php';
require get_template_directory() . '/inc/template-functions/headers/header-v4.php';
require get_template_directory() . '/inc/template-functions/headers/header-v5.php';
require get_template_directory() . '/inc/template-functions/headers/header-v6.php';
require get_template_directory() . '/inc/template-functions/headers/header-v7.php';
require get_template_directory() . '/inc/template-functions/headers/header-v8.php';
require get_template_directory() . '/inc/template-functions/headers/header-v9.php';
require get_template_directory() . '/inc/template-functions/headers/header-v10.php';
require get_template_directory() . '/inc/template-functions/headers/header-v11.php';
require get_template_directory() . '/inc/template-functions/headers/header-v12.php';
require get_template_directory() . '/inc/template-functions/headers/header-v13.php';