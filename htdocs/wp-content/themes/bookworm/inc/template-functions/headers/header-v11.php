<?php
/**
 * Template Functions for Header v11 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_masthead_v11' ) ) {
    /**
     * Displays Masthead for Header v11
     *
     * @return void
     */
    function bookworm_masthead_v11() {
        ?><div class="masthead position-relative mx-2 mx-md-4 bg-white rounded-top-pill">
            <?php
            do_action( 'bookworm_masthead_v11_content_before' );
            ?>
            <div class="container-fluid px-3 px-md-5 py-4">
                <div class="row align-items-center position-relative">
                    <?php
                    do_action( 'bookworm_masthead_v11' );
                    ?>
                </div>
            </div>
            <?php
            do_action( 'bookworm_masthead_v11_content_after' );
            ?>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_offcanvas_toggler_site_navigation_v11' ) ) {
    /**
     * Displays Offcanvas Toggler & Site Navigation v11
     *
     * @return void
     */
    function bookworm_offcanvas_toggler_site_navigation_v11() {
        ob_start();
        bookworm_offcanvas_toggler( 'mr-md-3', true );
        if ( has_nav_menu( 'primary' ) ) {
            ?><div class="site-navigation mr-auto d-none d-xl-block"><?php
                $headerPrimaryMenuSlug = apply_filters( 'bookworm_primary_menu' , '' );
                $primary_menu_args     = apply_filters( 'bookworm_primary_menu_args', [
                    'theme_location'        => 'primary',
                    'walker'                => new WP_Bootstrap_Navwalker(),
                    'container'             => false,
                    'menu_class'            => 'nav',
                    'nav_link_class'        => 'nav-link link-black-100 mx-2 mx-wd-4 px-0 py-3 font-weight-medium',
                    'submenu_link_class'    => 'link-black-100',
                    'dropdown_menu_class'   => 'font-size-2',
                ] );

                if( ! empty( $headerPrimaryMenuSlug ) ) {
                    $primary_menu_args['menu'] = $headerPrimaryMenuSlug;
                }

                wp_nav_menu( $primary_menu_args );
            ?></div><?php
        }
        $content = ob_get_clean();

        if( !empty ( $content ) ) {
            ?><div class="col-auto col-xl-5 position-static">
                <div class="d-flex align-items-center">
                    <?php print_r( $content ); ?>
                </div>
            </div><?php
        }
    }
}

if ( ! function_exists( 'bookworm_site_branding_v11' ) ) {
    /**
     * Displays Site Branding in Header v11
     *
     * @return void
     */
    function bookworm_site_branding_v11() {
        ?><div class="col-auto col-xl-2">
            <div class="site-branding text-center">
                <?php bookworm_site_title_or_logo( true, 'site-title text-uppercase font-weight-bold font-size-5 m-0' ); ?>
            </div>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_site_header_v11_icons_links' ) ) {
    /**
     * Displays Icon Links For Header v11
     *
     * @return void
     */
    function bookworm_site_header_v11_icons_links() {
        add_filter( 'bookworm_site_header_icons_links', 'bookworm_site_header_search_icon_link', 10 );
        if ( bookworm_is_woocommerce_activated()):
            add_filter( 'bookworm_site_header_icons_links', 'bookworm_site_header_compare_link', 15 );
            add_filter( 'bookworm_site_header_icons_links', 'bookworm_site_header_wishlist_link', 20 );
        endif;
        ob_start();
        bookworm_site_header_icons_links( 'link-black-100 font-size-3 px-3', 'text-white bg-dark right-0', 'justify-content-end', 'font-size-3', true );
        $content = ob_get_clean();
        if( !empty ( $content ) ) {
            ?><div class="col-2 col-md col-xl-5 position-static"><?php
                print_r( $content );
            ?></div><?php
        }
    }
}

if ( ! function_exists( 'bookworm_site_header_v11_search_icon_form_content' ) ) {
    function bookworm_site_header_v11_search_icon_form_content() {
        ?><div class="d-none d-md-block">
            <div id="searchSlideDown" class="dropdown-unfold u-search-slide-down" aria-labelledby="searchSlideDownInvoker">
                <?php if ( bookworm_is_woocommerce_activated() ) : ?>
                    <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <div class="input-group input-group-borderless u-search-slide-down__input rounded mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-size-3 nav-link">
                                    <span class="flaticon-loupe align-middle"></span>
                                </span>
                            </div>
                            <label for="s" class="sr-only"><?php echo esc_html__( 'Search', 'bookworm' ); ?></label>
                            <input type="search" class="form-control px-3" name="s" id="s" placeholder="<?php esc_attr_e( 'Search by Keywords', 'bookworm' ); ?>" />
                            <input type="hidden" id="search-param" name="post_type" value="product" />
                            <div class="input-group-append">
                                <a class="input-group-text px-4" href="javascript:;"
                                     aria-label="close"
                                     data-unfold-event="click"
                                     data-unfold-hide-on-scroll="false"
                                     data-unfold-target="#searchSlideDown"
                                     data-unfold-type="css-animation"
                                     data-unfold-animation-in="active"
                                     data-unfold-animation-out="fadeOutUp"
                                     data-unfold-delay="0"
                                     data-unfold-duration="800"
                                     data-unfold-overlay='{
                                         "className": "u-search-slide-down-bg-overlay",
                                         "background": "rgba(55, 125, 255, .1)",
                                         "animationSpeed": 400
                                     }'>
                                    <span class="fas fa-times" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div><?php
                        bookworm_site_header_v11_search_form_content_important_links();
                        
                    ?></form>
                <?php else : ?>
                    <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <div class="input-group input-group-borderless u-search-slide-down__input rounded mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-size-3 nav-link">
                                    <span class="flaticon-loupe align-middle"></span>
                                </span>
                            </div>
                            <label for="s" class="sr-only"><?php echo esc_html__( 'Search', 'bookworm' ); ?></label>
                            <input type="search" class="form-control px-3" name="s" id="s" placeholder="<?php esc_attr_e( 'Search by Keywords', 'bookworm' ); ?>" />
                            <input type="hidden" id="search-param" name="post_type" value="post" />
                            <div class="input-group-append">
                                <a class="input-group-text px-4" href="javascript:;"
                                     aria-label="close"
                                     data-unfold-event="click"
                                     data-unfold-hide-on-scroll="false"
                                     data-unfold-target="#searchSlideDown"
                                     data-unfold-type="css-animation"
                                     data-unfold-animation-in="active"
                                     data-unfold-animation-out="fadeOutUp"
                                     data-unfold-delay="0"
                                     data-unfold-duration="800"
                                     data-unfold-overlay='{
                                         "className": "u-search-slide-down-bg-overlay",
                                         "background": "rgba(55, 125, 255, .1)",
                                         "animationSpeed": 400
                                     }'>
                                    <span class="fas fa-times" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div><?php
                        bookworm_site_header_v11_search_form_content_important_links();
                        
                    ?></form>
                <?php endif; ?>
            </div>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_site_header_v11_search_form_content_important_links' ) ) {
    function bookworm_site_header_v11_search_form_content_important_links() {
        $links = apply_filters( 'bookworm_site_header_v11_search_icon_form_content_important_links', [] );

        if( ! empty( $links ) && is_array( $links ) ) {
            uasort( $links, 'bookworm_sort_priority_callback' );
            ?><div class="rounded bg-white u-search-slide-down__suggestions py-3 px-3">
                <ul class="list-group list-unstyled list-group-flush list-group-borderless mb-0">
                    <?php foreach ( $links as $key => $link ) :
                        if( isset( $link['link'], $link['text'] ) && ! empty( $link['link'] ) && ! empty( $link['text'] ) ) : ?>
                            <li>
                                <a class="list-group-item list-group-item-action text-dark font-size-2" href="<?php echo esc_url( $link['link'] ); ?>">
                                    <?php echo wp_kses_post( $link['text'] ); ?>
                                </a>
                            </li>
                        <?php endif;
                    endforeach; ?>
                </ul>
            </div><?php
        }
    }
}
