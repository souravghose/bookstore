<?php
/**
 * Template Functions for Header v5 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_masthead_v5' ) ) {
    /**
     * Displays Masthead for Header v5
     *
     * @return void
     */
    function bookworm_masthead_v5() {
        ?><div class="masthead">
            <?php
            do_action( 'bookworm_masthead_v5_content_before' );
            ?>
            <div class="bg-white border-bottom<?php echo bookworm_header_is_sticky() ? ' navbar-sticky' : ''; ?>">
                <div class="container pt-3 pb-2 pt-lg-5 pb-lg-5">
                    <div class="d-flex align-items-center position-relative flex-wrap">
                        <?php
                        do_action( 'bookworm_masthead_v5' );
                        ?>
                    </div>
                </div>
            </div>
            <?php
            do_action( 'bookworm_masthead_v5_content_after' );
            ?>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_site_branding_v5' ) ) {
    /**
     * Displays Site Branding in Header v5
     *
     * @return void
     */
    function bookworm_site_branding_v5() {
        ?><div class="site-branding pr-md-7 mx-auto mx-md-0">
            <?php bookworm_site_title_or_logo( true, 'site-title text-uppercase font-weight-bold font-size-5 m-0' ); ?>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_site_search_v5' ) ) {
    /**
     * Displays Site Search in Header v5
     *
     * @return void
     */
    function bookworm_site_search_v5() {
        if ( apply_filters('bookworm_enable_site_search' , true )):
        ?>
        <div class="site-search ml-xl-0 ml-md-auto w-r-100 flex-grow-1 mr-md-5 py-2 py-md-0">
            <?php if ( bookworm_is_woocommerce_activated() ) : ?>
                <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="form-inline my-2 my-xl-0">
                    <div class="input-group w-100">
                        <div class="input-group-prepend border-right-0 d-none d-xl-block">
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
                                'class'             => 'd-none d-lg-block custom-select pr-7 pl-4 rounded-0 height-5 shadow-none text-dark position-relative z-index-2'
                            ) ) );
                            ?>
                        </div>
                        <input type="text" name="s" id="s" value="<?php echo get_search_query(); ?>" class="form-control height-5 rounded-0 border-right-0 px-3" placeholder="<?php esc_attr_e( 'Search for books by keyword', 'bookworm' ); ?>" aria-label="<?php esc_attr_e( 'Amount (to the nearest dollar)', 'bookworm' ); ?>">
                        <input type="hidden" id="search-param" name="post_type" value="product" />
                        <div class="input-group-append border-left">
                            <button class="btn btn-primary px-3 rounded-0" type="submit">
                                <i class="mx-1 glph-icon flaticon-loupe"></i>
                            </button>
                        </div>

                    </div>
                </form>
            <?php else : ?>
                <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="form-inline my-2 my-xl-0">
                    <div class="input-group w-100">
                        <div class="input-group-prepend border-right-0 d-none d-xl-block">
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
                                'class'             => 'd-none d-lg-block custom-select pr-7 pl-4 rounded-0 height-5 shadow-none text-dark position-relative z-index-2'
                            ) ) );
                            ?>
                        </div>
                        <input type="text" name="s" id="s" value="<?php echo get_search_query(); ?>" class="form-control height-5 rounded-0 border-right-0 px-3" placeholder="<?php esc_attr_e( 'Search for books by keyword', 'bookworm' ); ?>" aria-label="<?php esc_attr_e( 'Amount (to the nearest dollar)', 'bookworm' ); ?>">
                        <input type="hidden" id="search-param" name="post_type" value="post" />
                        <div class="input-group-append border-left">
                            <button class="btn btn-primary px-3 rounded-0" type="submit">
                                <i class="mx-1 glph-icon flaticon-loupe"></i>
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

if ( ! function_exists( 'bookworm_site_header_v5_icons_links' ) ) {
    /**
     * Displays Icon Links For Header v5
     *
     * @return void
     */
    function bookworm_site_header_v5_icons_links() {
        if ( bookworm_is_woocommerce_activated()):
            add_filter( 'bookworm_site_header_icons_links', 'bookworm_site_header_wishlist_link', 20 );
        endif;
        bookworm_site_header_icons_links( 'text-dark', 'text-white bg-dark left-0', 'align-self-center d-none d-md-flex' );
    }
}

if ( ! function_exists( 'bookworm_site_header_v5_bottom_bar' ) ) {
    /**
     * Displays Bottom Bar For Header v5
     *
     * @return void
     */
    function bookworm_site_header_v5_bottom_bar() {
        ob_start();
        do_action( 'bookworm_site_header_v5_bottom_bar' );
        $content = ob_get_clean();
        if( !empty ( $content ) ) {
            ?><div class="border-bottom py-3 py-md-0">
                <div class="container">
                    <div class="d-md-flex position-relative">
                        <?php print_r( $content ); ?>
                    </div>
                </div>
            </div><?php
        }
    }
}

if ( ! function_exists( 'bookworm_site_header_v5_department_menu' ) ) {
    /**
     * Displays Department Menu in Site Header v5
     *
     * @return void
     */
    function bookworm_site_header_v5_department_menu() {
        bookworm_site_header_department_menu( 'bg-primary' );
    }
}

if ( ! function_exists( 'bookworm_offcanvas_toggler_v5' ) ) {
    /**
     * Displays Offcanvas Toggler v5
     *
     * @return void
     */
    function bookworm_offcanvas_toggler_v5() {
        add_action( 'bookworm_offcanvas_toggler_after', 'bookworm_site_header_mobile_icons_links', 10 );
        if ( bookworm_is_woocommerce_activated()):
            add_action( 'bookworm_after_header', 'bookworm_wc_offcanvas_mobile_mini_cart', 30 );
        endif;
        bookworm_offcanvas_toggler( 'align-self-center mr-md-5 d-xl-none d-flex d-md-block align-items-center' );
    }
}

if ( ! function_exists( 'bookworm_site_navigation_v5' ) ) {
    /**
     * Displays Site Navigation in Header v5
     *
     * @return void
     */
    function bookworm_site_navigation_v5() {
        if ( has_nav_menu( 'primary' ) ) {
            ?><div class="site-navigation mr-auto d-none d-xl-block"><?php
                $headerPrimaryMenuSlug = apply_filters( 'bookworm_primary_menu' , '' );
                $primary_menu_args     = apply_filters( 'bookworm_primary_menu_args', [
                    'theme_location'        => 'primary',
                    'walker'                => new WP_Bootstrap_Navwalker(),
                    'container'             => false,
                    'menu_class'            => 'nav',
                    'nav_link_class'        => 'nav-link link-black-100 mx-2 px-0 py-3 font-weight-medium',
                    'submenu_link_class'    => 'link-black-100',
                    'dropdown_menu_class'   => 'font-size-2',
                ] );

                if( ! empty( $headerPrimaryMenuSlug ) ) {
                    $primary_menu_args['menu'] = $headerPrimaryMenuSlug;
                }

                wp_nav_menu( $primary_menu_args );
            ?></div><?php
        }

        if ( has_nav_menu( 'secondary' ) && apply_filters( 'bookworm_enable_secondary_menu', true ) ) {
            ?><div class="secondary-navigation d-none d-md-block ml-md-auto"><?php
                $headerSecondaryMenuSlug = apply_filters( 'bookworm_secondary_menu' , '' );
                $secondary_menu_args     = apply_filters( 'bookworm_secondary_menu_args', [
                    'theme_location'        => 'secondary',
                    'walker'                => new WP_Bootstrap_Navwalker(),
                    'container'             => false,
                    'menu_class'            => 'nav',
                    'nav_link_class'        => 'nav-link link-black-100 mx-2 px-0 py-3 font-weight-medium',
                    'depth'                 => 1,
                ] );

                if( ! empty( $headerSecondaryMenuSlug ) ) {
                    $secondary_menu_args['menu'] = $headerSecondaryMenuSlug;
                }

                wp_nav_menu( $secondary_menu_args );
            ?></div><?php
        }
    }
}
