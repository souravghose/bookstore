<?php
/**
 * Template Functions for Header v6 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_topbar_v6' ) ) {
    /**
     * Displays Topbar in Header v6
     *
     * @return void
     */
    function bookworm_topbar_v6() {
        $enable_topbar = bookworm_enable_topbar();
        if ( $enable_topbar && ( has_nav_menu( 'topbar_left' ) || has_nav_menu( 'topbar_right' ) ) ) :
        ?><div class="topbar border-bottom d-none d-md-block bg-dark">
            <div class="container-fluid px-2 px-md-5 px-xl-8d75">
                <div class="topbar__nav d-lg-flex justify-content-between align-items-center font-size-2">
                    <?php
                    $headerTopbarLeftMenuSlug = apply_filters( 'bookworm_topbar_left_menu' , '' );
                    $headerTopbarRightMenuSlug = apply_filters( 'bookworm_topbar_right_menu' , '' );
                    
                    if ( has_nav_menu( 'topbar_left' ) ) {
                        $topbar_left_menu_args = apply_filters( 'bookworm_topbar_left_args', [
                            'theme_location'        => 'topbar_left',
                            'walker'                => new WP_Bootstrap_Navwalker(),
                            'container'             => false,
                            'menu_id_prefix'        => 'topbar-left',
                            'menu_class'            => 'topbar__nav--left nav ml-lg-n3',
                            'nav_link_class'        => 'nav-link py-2 px-3 text-white d-flex align-items-center h-100',
                            'submenu_link_class'    => 'link-black-100',
                            'icon_class'            => 'mr-2 font-size-3 glph-icon',
                            'depth'                 => 2,
                        ] );

                        if( ! empty ( $headerTopbarLeftMenuID ) && $headerTopbarLeftMenuID > 0 ) {
                            $topbar_left_menu_args['menu'] = $headerTopbarLeftMenuID;
                        } elseif( ! empty( $headerTopbarLeftMenuSlug ) ) {
                            $topbar_left_menu_args['menu'] = $headerTopbarLeftMenuSlug;
                        }

                        wp_nav_menu( $topbar_left_menu_args );
                    }

                    if ( has_nav_menu( 'topbar_right' ) ) {
                        $topbar_right_menu_args = apply_filters( 'bookworm_topbar_right_args', [
                            'theme_location'        => 'topbar_right',
                            'walker'                => new WP_Bootstrap_Navwalker(),
                            'container'             => false,
                            'menu_id_prefix'        => 'topbar-right',
                            'menu_class'            => 'topbar__nav--right nav',
                            'nav_link_class'        => 'nav-link py-2 px-3 text-white d-flex align-items-center h-100',
                            'submenu_link_class'    => 'link-black-100',
                            'dropdown_menu_class'   => 'right-0 left-auto',
                            'icon_class'            => 'mr-2 font-size-3 glph-icon',
                            'depth'                 => 2,
                        ] );

                        if( ! empty ( $headerTopbarRightMenuID ) && $headerTopbarRightMenuID > 0 ) {
                            $topbar_right_menu_args['menu'] = $headerTopbarRightMenuID;
                        } elseif( ! empty( $headerTopbarRightMenuSlug ) ) {
                            $topbar_right_menu_args['menu'] = $headerTopbarRightMenuSlug;
                        }

                        wp_nav_menu( $topbar_right_menu_args );
                    }
                    ?>
                </div>
            </div>
        </div><?php
        endif;
    }
}

if ( ! function_exists( 'bookworm_masthead_v6' ) ) {
    /**
     * Displays Masthead for Header v6
     *
     * @return void
     */
    function bookworm_masthead_v6() {
        ?><div class="masthead position-relative<?php echo bookworm_header_is_sticky() ? ' navbar-sticky' : ''; ?>" style="margin-bottom: -1px;">
            <?php
            do_action( 'bookworm_masthead_v6_content_before' );
            ?>
            <div class="container-fluid px-3 px-md-5 px-xl-8d75 py-3 py-xl-0">
                <div class="d-flex align-items-center position-relative flex-wrap">
                    <?php
                    do_action( 'bookworm_masthead_v6' );
                    ?>
                </div>
            </div>
            <?php
            do_action( 'bookworm_masthead_v6_content_after' );
            ?>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_offcanvas_toggler_v6' ) ) {
    /**
     * Displays Offcanvas Toggler v6
     *
     * @return void
     */
    function bookworm_offcanvas_toggler_v6() {
        bookworm_offcanvas_toggler( 'mr-5', true );
    }
}

if ( ! function_exists( 'bookworm_site_branding_v6' ) ) {
    /**
     * Displays Site Branding in Header v6
     *
     * @return void
     */
    function bookworm_site_branding_v6() {
        ?><div class="site-branding pr-4">
            <?php bookworm_site_title_or_logo( true, 'site-title text-uppercase font-weight-bold font-size-5 m-0' ); ?>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_site_navigation_v6' ) ) {
    /**
     * Displays Site Navigation in Header v6
     *
     * @return void
     */
    function bookworm_site_navigation_v6() {
        if ( has_nav_menu( 'primary' ) ) {
            ?><div class="site-navigation mx-auto d-none d-xl-block"><?php
                $headerPrimaryMenuSlug = apply_filters( 'bookworm_primary_menu' , '' );
                $primary_menu_args     = apply_filters( 'bookworm_primary_menu_args', [
                    'theme_location'        => 'primary',
                    'walker'                => new WP_Bootstrap_Navwalker(),
                    'container'             => false,
                    'menu_class'            => 'nav',
                    'nav_link_class'        => 'nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium',
                    'submenu_link_class'    => 'link-black-100',
                    'dropdown_menu_class'   => 'font-size-2',
                ] );

                if( ! empty( $headerPrimaryMenuSlug ) ) {
                    $primary_menu_args['menu'] = $headerPrimaryMenuSlug;
                }

                wp_nav_menu( $primary_menu_args );
            ?></div><?php
        }
    }
}

if ( ! function_exists( 'bookworm_site_header_v6_icons_links' ) ) {
    /**
     * Displays Icon Links For Header v6
     *
     * @return void
     */
    function bookworm_site_header_v6_icons_links() {
        if ( bookworm_is_woocommerce_activated()):
            add_filter( 'bookworm_site_header_icons_links', 'bookworm_site_header_wishlist_link', 20 );
        endif;
        bookworm_site_header_icons_links( 'text-dark', 'text-white bg-dark left-0', 'align-self-center ml-auto ml-xl-0' );
    }
}
