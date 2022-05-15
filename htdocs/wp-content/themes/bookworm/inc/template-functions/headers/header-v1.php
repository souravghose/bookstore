<?php
/**
 * Template Functions for Header v1 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_topbar_v1' ) ) {
    /**
     * Displays Topbar in Header v1
     *
     * @return void
     */
    function bookworm_topbar_v1() {
        $enable_topbar = bookworm_enable_topbar();
        if ( $enable_topbar && ( has_nav_menu( 'topbar_left' ) || has_nav_menu( 'topbar_right' ) ) ) :
        ?><div class="topbar border-bottom">
            <div class="container-fluid px-2 px-md-5 px-xl-8d75">
                <div class="topbar__nav d-md-flex justify-content-between align-items-center">
                    <?php
                    $headerTopbarLeftMenuSlug = apply_filters( 'bookworm_topbar_left_menu' , '' );
                    $headerTopbarRightMenuSlug = apply_filters( 'bookworm_topbar_right_menu' , '' );
                    if ( has_nav_menu( 'topbar_left' ) ) {
                        $topbar_left_menu_args = apply_filters( 'bookworm_topbar_left_args', [
                            'theme_location'  => 'topbar_left',
                            'container'       => false,
                            'menu_id_prefix'  => 'topbar-left',
                            'menu_class'      => 'topbar__nav--left nav ml-md-n3 d-none d-md-flex',
                            'item_class'      => 'nav-item',
                            'nav_link_class'  => 'nav-link link-black-100 h-100',
                            'icon_class'      => 'mr-2 glph-icon',
                            'depth'           => 2,
                            'walker'          => new WP_Bootstrap_Navwalker()
                        ] );

                        if( ! empty ( $headerTopbarLeftMenuID ) && $headerTopbarLeftMenuID > 0 ) {
                            $topbar_left_menu_args['menu'] = $headerTopbarLeftMenuID;
                        } elseif( ! empty( $headerTopbarLeftMenuSlug ) ) {
                            $topbar_left_menu_args['menu'] = $headerTopbarLeftMenuSlug;
                        }

                        wp_nav_menu( $topbar_left_menu_args );
                    }?>

                    <?php if ( apply_filters('bookworm_enable_header_v1_topbar_right' , true )){ ?>
                        <div class="topbar__nav--right nav mr-md-n3">
                            <?php 
                            if ( bookworm_is_woocommerce_activated() ):
                                add_filter( 'bookworm_site_header_icons_links', 'bookworm_site_header_store_locator_link', 15 );
                                add_filter( 'bookworm_site_header_icons_links', 'bookworm_site_header_compare_link', 15 );
                                add_filter( 'bookworm_site_header_icons_links', 'bookworm_site_header_wishlist_link', 20 );
                            endif;
                            bookworm_site_header_icons_links( 'link-black-100 font-size-3 px-3', 'text-white bg-dark right-0', 'justify-content-end', 'font-size-3', true );
                            ?>
                        </div>
                   <?php  } ?>
                </div>
            </div>
        </div><?php
        endif;
    }
}

if ( ! function_exists( 'bookworm_masthead_v1' ) ) {
    /**
     * Displays Masthead for Header v1
     *
     * @return void
     */
    function bookworm_masthead_v1() {
        ?><div class="masthead border-bottom position-relative<?php echo bookworm_header_is_sticky() ? ' navbar-sticky' : ''; ?>" style="margin-bottom: -1px;">
            <div class="container-fluid px-3 px-md-5 px-xl-8d75 py-2 py-md-0">
                <div class="d-flex align-items-center position-relative flex-wrap">
                    <?php
                    do_action( 'bookworm_masthead_v1' );
                    ?>
                </div>
            </div>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_offcanvas_toggler_v1' ) ) {
    /**
     * Displays Offcanvas Toggler
     *
     * @return void
     */
    function bookworm_offcanvas_toggler_v1() {
        bookworm_offcanvas_toggler( 'mr-4 mr-lg-8', true );
    }
}

if ( ! function_exists( 'bookworm_site_branding_v1' ) ) {
    /**
     * Displays Site Branding in Header v1
     *
     * @return void
     */
    function bookworm_site_branding_v1() {
        ?><div class="site-branding pr-md-4">
            <?php bookworm_site_title_or_logo( true, 'site-title text-uppercase font-weight-bold font-size-5 m-0' ); ?>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_site_navigation_v1' ) ) {
    /**
     * Displays Site Navigation in Header v1
     *
     * @return void
     */
    function bookworm_site_navigation_v1() {
        if ( has_nav_menu( 'primary' ) ):
        ?><div class="site-navigation mr-auto d-none d-xl-block">
            <?php
                $headerPrimaryMenuSlug = apply_filters( 'bookworm_primary_menu' , '' );
                $primary_menu_args     = apply_filters( 'bookworm_primary_menu_args', [
                    'theme_location'      => 'primary',
                    'walker'              => new WP_Bootstrap_Navwalker(),
                    'menu_class'          => 'nav',
                    'container'           => false,
                    'nav_link_class'      => 'nav-link link-black-100 mx-4 px-0 py-5 font-weight-medium',
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

if ( ! function_exists( 'bookworm_site_search_v1' ) ) {
    /**
     * Displays Site Search in Header v1
     *
     * @return void
     */
    function bookworm_site_search_v1() {
        if ( apply_filters('bookworm_enable_site_search' , true ) ):
        ?><div class="site-search ml-xl-0 ml-md-auto w-r-100">
            <?php if ( bookworm_is_woocommerce_activated() ) : ?>
                <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="form-inline my-2 my-xl-0">
                    <label for="s" class="sr-only"><?php echo esc_html__( 'Search', 'bookworm' ); ?></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <i class="glph-icon flaticon-loupe input-group-text py-2d75 bg-white-100 border-white-100"></i>
                        </div>
                        <input type="text" class="form-control bg-white-100 min-width-380 py-2d75 height-4 border-white-100" name="s" id="s" placeholder="<?php esc_attr_e( 'Search by Keywords', 'bookworm' ); ?>" />
                        <input type="hidden" id="search-param" name="post_type" value="product" />
                    </div>
                    <input type="submit" class="submit btn btn-outline-success my-2 my-sm-0 sr-only" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search by Keywords', 'bookworm' ); ?>" />
                </form>
            <?php else : ?>
                <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="form-inline my-2 my-xl-0">
                    <label for="s" class="sr-only"><?php echo esc_html__( 'Search', 'bookworm' ); ?></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <i class="glph-icon flaticon-loupe input-group-text py-2d75 bg-white-100 border-white-100"></i>
                        </div>
                        <input type="text" class="form-control bg-white-100 min-width-380 py-2d75 height-4 border-white-100" name="s" id="s" placeholder="<?php esc_attr_e( 'Search by Keywords', 'bookworm' ); ?>" />
                        <input type="hidden" id="search-param" name="post_type" value="post" />
                    </div>
                    <input type="submit" class="submit btn btn-outline-success my-2 my-sm-0 sr-only" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search by Keywords', 'bookworm' ); ?>" />
                </form>
            <?php endif; ?>
        </div><?php
    endif;
    }
}

if ( ! function_exists( 'bookworm_site_header_v1_icons_links' ) ) {
    /**
     * Displays Icon Links For Header v1
     *
     * @return void
     */
    function bookworm_site_header_v1_icons_links() {
        
        bookworm_site_header_icons_links( 'link-black-100 font-size-3 px-3', 'text-white bg-dark right-0', 'd-md-none nav mr-md-n3 ml-auto', 'font-size-3', true );
        
    }
}