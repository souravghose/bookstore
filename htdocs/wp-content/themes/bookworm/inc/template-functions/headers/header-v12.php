<?php
/**
 * Template Functions for Header v12 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_topbar_v12' ) ) {
    /**
     * Displays Topbar in Header v12
     *
     * @return void
     */
    function bookworm_topbar_v12() {
        $enable_topbar = bookworm_enable_topbar();
        if ( $enable_topbar && ( has_nav_menu( 'topbar_left' ) || has_nav_menu( 'topbar_right' ) ) ) :
        ?><div class="topbar bg-gray-1060 d-none d-md-block">
            <div class="container">
                <div class="topbar__nav d-md-flex justify-content-between align-items-center font-size-2">
                    <?php
                    $headerTopbarLeftMenuSlug = apply_filters( 'bookworm_topbar_left_menu' , '' );
                    $headerTopbarRightMenuSlug = apply_filters( 'bookworm_topbar_right_menu' , '' );
                    if ( has_nav_menu( 'topbar_left' ) ) {
                        $topbar_left_menu_args = apply_filters( 'bookworm_topbar_left_args', [
                            'theme_location'        => 'topbar_left',
                            'walker'                => new WP_Bootstrap_Navwalker(),
                            'container'             => false,
                            'menu_id_prefix'        => 'topbar-left',
                            'menu_class'            => 'topbar__nav--left nav',
                            'nav_link_class'        => 'nav-link p-2 link-black-100 d-flex align-items-center h-100 mr-3',
                            'submenu_link_class'    => 'link-black-100',
                            'dropdown_menu_class'   => 'left-0 right-auto',
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
                            'nav_link_class'        => 'nav-link p-2 link-black-100 d-flex align-items-center h-100 ml-3',
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

if ( ! function_exists( 'bookworm_masthead_v12' ) ) {
    /**
     * Displays Masthead for Header v12
     *
     * @return void
     */
    function bookworm_masthead_v12() {
        ?><div class="masthead">
            <?php
            do_action( 'bookworm_masthead_v12_content_before' );
            ?>
            <div class="bg-punch-light<?php echo bookworm_header_is_sticky() ? ' navbar-sticky' : ''; ?>">
                <div class="container py-3 py-md-4">
                    <div class="d-flex align-items-center position-relative flex-wrap">
                        <?php
                        do_action( 'bookworm_masthead_v12' );
                        ?>
                    </div>
                </div>
            </div>
            <?php
            do_action( 'bookworm_masthead_v12_content_after' );
            ?>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_site_header_v12_support_lists' ) ) {
    /**
     * Displays Site Header Support Lists v12
     *
     * @return void
     */
    function bookworm_site_header_v12_support_lists() {
        bookworm_site_header_support_lists( 'd-none d-xl-flex align-items-center mt-3 mt-md-0 mr-md-auto' );
    }
}

if ( ! function_exists( 'bookworm_offcanvas_toggler_v12' ) ) {
    /**
     * Displays Offcanvas Toggler v12
     *
     * @return void
     */
    function bookworm_offcanvas_toggler_v12() {
        bookworm_offcanvas_toggler( 'd-xl-none mr-4', true );
    }
}

if ( ! function_exists( 'bookworm_site_branding_v12' ) ) {
    /**
     * Displays Site Branding in Header v12
     *
     * @return void
     */
    function bookworm_site_branding_v12() {
        ?><div class="site-branding pr-md-7 mx-auto mx-md-0">
            <?php bookworm_site_title_or_logo( true, 'site-title text-uppercase font-weight-bold font-size-5 m-0' ); ?>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_site_header_v12_offcanvas_toggle_links' ) ) {
    /**
     * Displays Offcanvas Toggler Links v12
     *
     * @return void
     */
    function bookworm_site_header_v12_offcanvas_toggle_links() {
        bookworm_site_header_offcanvas_toggle_links( 'text-dark', 'text-white bg-dark', 'font-size-5 text-dark', 'text-secondary-gray-1090 font-size-1', 'ml-auto' );
    }
}

if ( ! function_exists( 'bookworm_site_header_v12_navbar' ) ) {
    /**
     * Displays Site Navigation Bar in Header v12
     *
     * @return void
     */
    function bookworm_site_header_v12_navbar() {
        $enable_navbar = bookworm_enable_navbar();
        if ( $enable_navbar && ( has_nav_menu( 'primary' ) ) ) :
            ?><div class="border-bottom py-1 d-none d-xl-block">
                <div class="container">
                    <div class="d-md-flex align-items-center position-relative">
                        <div class="site-navigation mx-auto"><?php
                            $headerPrimaryMenuSlug = apply_filters( 'bookworm_primary_menu' , '' );
                            $primary_menu_args     = apply_filters( 'bookworm_primary_menu_args', [
                                'theme_location'        => 'primary',
                                'walker'                => new WP_Bootstrap_Navwalker(),
                                'container'             => false,
                                'menu_class'            => 'nav',
                                'nav_link_class'        => 'nav-link link-black-100 mx-3 px-0 py-3 font-weight-medium',
                                'submenu_link_class'    => 'link-black-100',
                                'dropdown_menu_class'   => 'font-size-2',
                            ] );

                            if( ! empty( $headerPrimaryMenuSlug ) ) {
                                $primary_menu_args['menu'] = $headerPrimaryMenuSlug;
                            }

                            wp_nav_menu( $primary_menu_args );
                        ?></div>
                    </div>
                </div>
            </div><?php
        endif;
    }
}
