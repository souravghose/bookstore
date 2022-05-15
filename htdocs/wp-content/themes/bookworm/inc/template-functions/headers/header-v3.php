<?php
/**
 * Template Functions for Header v3 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_topbar_v3' ) ) {
    /**
     * Displays Topbar in Header v3
     *
     * @return void
     */
    function bookworm_topbar_v3() {
        $enable_topbar = bookworm_enable_topbar();
        if ( $enable_topbar && ( has_nav_menu( 'topbar_left' ) || has_nav_menu( 'topbar_right' ) ) ) :
        ?><div class="topbar border-bottom d-none d-md-block">
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
                            'menu_class'            => 'topbar__nav--left nav align-items-center',
                            'nav_link_class'        => 'nav-link p-2 link-black-100 d-flex align-items-center h-100',
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
                            'menu_class'            => 'topbar__nav--right nav align-items-center',
                            'nav_link_class'        => 'nav-link p-2 link-black-100 d-flex align-items-center h-100',
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

if ( ! function_exists( 'bookworm_masthead_v3' ) ) {
    /**
     * Displays Masthead for Header v3
     *
     * @return void
     */
    function bookworm_masthead_v3() {
        ?><div class="masthead">
            <?php
            do_action( 'bookworm_masthead_v3_content_before' );
            ?>
            <div class="bg-white<?php echo bookworm_header_is_sticky() ? ' navbar-sticky' : ''; ?>">
                <div class="container py-3 py-md-4">
                    <div class="d-flex align-items-center position-relative flex-wrap">
                        <?php
                        do_action( 'bookworm_masthead_v3' );
                        ?>
                    </div>
                </div>
            </div>
            <?php
            do_action( 'bookworm_masthead_v3_content_after' );
            ?>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_site_branding_v3' ) ) {
    /**
     * Displays Site Branding in Header v3
     *
     * @return void
     */
    function bookworm_site_branding_v3() {
        ?><div class="site-branding pr-md-7 mx-auto mx-md-0">
            <?php bookworm_site_title_or_logo( true, 'site-title text-uppercase font-weight-bold font-size-5 m-0' ); ?>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_site_navigation_v3' ) ) {
    /**
     * Displays Site Navigation in Header v3
     *
     * @return void
     */
    function bookworm_site_navigation_v3() {
        if ( has_nav_menu( 'primary' ) ):
        ?><div class="site-navigation mr-auto d-none d-xl-block">
            <?php
                $headerPrimaryMenuSlug = apply_filters( 'bookworm_primary_menu' , '' );
                $primary_menu_args     = apply_filters( 'bookworm_primary_menu_args', [
                    'theme_location'      => 'primary',
                    'walker'              => new WP_Bootstrap_Navwalker(),
                    'menu_class'          => 'nav',
                    'container'           => false,
                    'nav_link_class'      => 'nav-link link-black-100 mx-3 px-0 py-3 font-weight-medium',
                    'submenu_link_class'  => 'link-black-100',
                    'dropdown_menu_class' => 'font-size-2',
                ] );

                if( ! empty( $headerPrimaryMenuSlug ) ) {
                    $primary_menu_args['menu'] = $headerPrimaryMenuSlug;
                }

                wp_nav_menu( $primary_menu_args );
            ?>
        </div><?php
        endif;
    }
}

if ( ! function_exists( 'bookworm_site_header_v3_support_lists' ) ) {
    /**
     * Displays Site Header Support Lists v3
     *
     * @return void
     */
    function bookworm_site_header_v3_support_lists() {
        bookworm_site_header_support_lists();
    }
}

if ( ! function_exists( 'bookworm_site_header_v3_bottom_bar' ) ) {
    /**
     * Displays Bottom Bar For Header v3
     *
     * @return void
     */
    function bookworm_site_header_v3_bottom_bar() {
        ob_start();
        do_action( 'bookworm_site_header_v3_bottom_bar' );
        $content = ob_get_clean();
        if( !empty ( $content ) ) {
            ?><div class="bg-primary-home-v3 py-2">
                <div class="container my-1">
                    <div class="d-md-flex align-items-center position-relative py-1">
                        <?php print_r( $content ); ?>
                    </div>
                </div>
            </div><?php
        }
    }
}

if ( ! function_exists( 'bookworm_offcanvas_toggler_v3' ) ) {
    /**
     * Displays Offcanvas Toggler v3
     *
     * @return void
     */
    function bookworm_offcanvas_toggler_v3() {
        bookworm_offcanvas_toggler( 'mr-md-8 d-flex d-md-block align-items-center', false, 'dark' );
    }
}

if ( ! function_exists( 'bookworm_site_search_v3' ) ) {
    /**
     * Displays Site Search in Header v3
     *
     * @return void
     */
    function bookworm_site_search_v3() {
        if ( apply_filters('bookworm_enable_site_search' , true )):
        ?>
        <div class="site-search ml-xl-0 ml-md-auto w-r-100 flex-grow-1 mr-md-5 mt-2 mt-md-0 py-2 py-md-0">
            <?php if ( bookworm_is_woocommerce_activated() ) : ?>
                <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="form-inline my-2 my-xl-0">
                    <div class="input-group input-group-borderless w-100">
                        <input type="text" name="s" id="s" value="<?php echo get_search_query(); ?>" class="form-control rounded-left-1 px-3 border-right height-5" placeholder="<?php esc_attr_e( 'Search for books by keyword', 'bookworm' ); ?>" aria-label="<?php esc_attr_e( 'Amount (to the nearest dollar)', 'bookworm' ); ?>">
                        <input type="hidden" id="search-param" name="post_type" value="product" />
                        <div class="input-group-append ml-0">
                            <?php $selected_cat = isset( $_GET['product_cat'] ) ? $_GET['product_cat'] : 0;
                            $navbar_search_dropdown_text = apply_filters( 'bookworm_navbar_search_category_dropdown_default_text', esc_html__( 'All Categories', 'bookworm' ) );
                            wp_dropdown_categories( apply_filters( 'bookworm_search_dropdown_categories_filter_args', array(
                                'show_option_all'   => $navbar_search_dropdown_text,
                                'taxonomy'          => 'product_cat',
                                'hide_if_empty'     => 1,
                                'name'              => 'product_cat',
                                'selected'          => $selected_cat,
                                'value_field'       => 'slug',
                                'id'                => 'inputGroupSelect01',
                                'class'             => 'd-none d-lg-block custom-select pr-7 pl-4 rounded-0 shadow-none border-0 text-dark'
                            ) ) );
                            ?>
                            <button class="btn btn-primary-yellow px-3 py-2" type="submit">
                                <i class="mx-1 glph-icon flaticon-loupe text-dark"></i>
                            </button>
                        </div>
                    </div>
                </form>
             <?php else : ?>
                <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="form-inline my-2 my-xl-0">
                    <div class="input-group input-group-borderless w-100">
                        <input type="text" name="s" id="s" value="<?php echo get_search_query(); ?>" class="form-control rounded-left-1 px-3 border-right height-5" placeholder="<?php esc_attr_e( 'Search for books by keyword', 'bookworm' ); ?>" aria-label="<?php esc_attr_e( 'Amount (to the nearest dollar)', 'bookworm' ); ?>">
                        <input type="hidden" id="search-param" name="post_type" value="post" />
                        <div class="input-group-append ml-0">
                            <?php $selected_cat = isset( $_GET['category'] ) ? $_GET['category'] : 0;
                            $navbar_search_dropdown_text = apply_filters( 'bookworm_navbar_search_category_dropdown_default_text', esc_html__( 'All Categories', 'bookworm' ) );
                            wp_dropdown_categories( apply_filters( 'bookworm_search_dropdown_categories_filter_args', array(
                                'show_option_all'   => $navbar_search_dropdown_text,
                                'taxonomy'          => 'category',
                                'hide_if_empty'     => 1,
                                'name'              => 'category',
                                'selected'          => $selected_cat,
                                'value_field'       => 'slug',
                                'id'                => 'inputGroupSelect01',
                                'class'             => 'd-none d-lg-block custom-select pr-7 pl-4 rounded-0 shadow-none border-0 text-dark'
                            ) ) );
                            ?>
                            <button class="btn btn-primary-yellow px-3 py-2" type="submit">
                                <i class="mx-1 glph-icon flaticon-loupe text-dark"></i>
                            </button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
        <?php
        endif;
    }
}

if ( ! function_exists( 'bookworm_site_header_v3_icons_links' ) ) {
    /**
     * Displays Icon Links For Header v3
     *
     * @return void
     */
    function bookworm_site_header_v3_icons_links() {
        if ( bookworm_is_woocommerce_activated()):
            add_filter( 'bookworm_site_header_icons_links', 'bookworm_site_header_wishlist_link', 20 );
        endif;
        bookworm_site_header_icons_links( 'text-white', 'text-dark bg-primary-yellow left-0', 'd-flex' );


    }
}
