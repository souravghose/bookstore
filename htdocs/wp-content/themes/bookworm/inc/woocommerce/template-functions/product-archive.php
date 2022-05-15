<?php
/**
 * Template functions used in Product Archive
 *
 */

if ( ! function_exists( 'bookworm_wc_before_content' ) ) {
    /**
     * Before Content
     * Wraps all WooCommerce content in wrappers which match the theme markup
     *
     * @since   1.0.0
     * @return  void
     */

    function bookworm_wc_before_content() {
        $content_area_additional_classes = '';

        if ( ( bookworm_get_product_archive_layout() === 'left-sidebar' ) || ( bookworm_get_single_product_layout() === 'left-sidebar' ) ) {
            $content_area_additional_classes = 'order-2';
        } else {
            $content_area_additional_classes = 'order-1';
        }
        
        if ( bookworm_is_product_archive()): ?>
            <div class="site-content space-bottom-3 mt-8">
                <div class="container">
        <?php endif; ?>

        <?php if ( bookworm_single_product_has_sidebar()): ?>
            <div class="container">
                <div class="row">
        <?php endif; ?>

        <?php if ( bookworm_product_archive_has_sidebar()) : ?>
            <div class="row">
        <?php endif; ?>
                <div id="primary" class="content-area <?php echo esc_attr( $content_area_additional_classes ); ?>">
                    <main id="main" class="site-main" role="main"><?php

    }
}

if ( ! function_exists( 'bookworm_wc_after_content' ) ) {
    /**
     * After Content
     * Closes the wrapping divs
     *
     * @since   1.0.0
     * @return  void
     */
    function bookworm_wc_after_content() {
        ?>

                        </main><!-- #main -->
                    </div><!-- #primary -->
                    <?php if ( bookworm_product_archive_has_sidebar() ) : ?>
                    <?php do_action( 'bookworm_sidebar' ); ?>
                </div><!-- #shop-row -->
                    <?php endif; ?>

                    <?php if ( bookworm_single_product_has_sidebar()): ?>
                        <?php do_action( 'bookworm_sidebar' ); ?>
                        </div><!-- .row -->
                        <?php do_action( 'bookworm_after_content_container' ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( bookworm_is_product_archive()): ?>
            </div>
            
        </div>
        <?php endif; 

    }
}


if ( ! function_exists( 'bookworm_shop_page_top_jumbotron' ) ) {
    function bookworm_shop_page_top_jumbotron() {
        $static_block_id = apply_filters( 'bookworm_shop_jumbotron_id', get_theme_mod( 'bookworm_wc_jumbotron', '' ) ); 

        if( bookworm_is_mas_static_content_activated() && ! empty( $static_block_id ) ) {
            $static_block = get_post( $static_block_id );
            $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
            echo '<div class="position-relative mb-6">' . apply_filters( 'the_content', $content ) . '</div>';
        }
    }
}

if ( ! function_exists( 'bookworm_shop_control_bar' ) ) {
    function bookworm_shop_control_bar() {
        ?><div class="container p-0"><div class="shop-control-bar d-lg-flex justify-content-between align-items-center mb-5 text-center text-md-left">
            <div class="shop-control-bar__left mb-4 m-lg-0"><?php do_action( 'bookworm_shop_control_bar_left' ); ?></div>
            <div class="shop-control-bar__right d-md-flex align-items-center"><?php do_action( 'bookworm_shop_control_bar_right' ); ?></div></div>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_wc_result_count' ) ) {
    function bookworm_wc_result_count() {
        if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
            return;
        }
        $total    = wc_get_loop_prop( 'total' );
        $per_page = wc_get_loop_prop( 'per_page' );
        $current  = wc_get_loop_prop( 'current_page' );

        ?><p class="woocommerce-result-count m-0">
        <?php
            if ( 1 === $total ) {
                esc_html_e( 'Showing the single result', 'bookworm' );
            } elseif ( $total <= $per_page || -1 === $per_page ) {
                /* translators: %d: total results */
                printf( _n( 'Showing all %d result', 'Showing all %d results', $total, 'bookworm' ), $total );
            } else {
                $first = ( $per_page * $current ) - $per_page + 1;
                $last  = min( $total, $per_page * $current );
                /* translators: 1: first result 2: last result 3: total results */
                printf( _nx( 'Showing %1$d&ndash;%2$d of %3$d result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'bookworm' ), $first, $last, $total );
            }
            ?>
        </p><?php
    }
}


/**
 * Returns the available views where key is a view name and value is a view icon
 *
 * Theme support grid and list view modes.
 *
 * @return array
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'bookworm_wc_views' ) ) {
    function bookworm_wc_views() {
        return (array) apply_filters( 'bookworm_wc_views', [
            'grid' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17px" height="17px">
<path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M-0.000,0.000 L3.000,0.000 L3.000,3.000 L-0.000,3.000 L-0.000,0.000 Z"></path>
<path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M7.000,0.000 L10.000,0.000 L10.000,3.000 L7.000,3.000 L7.000,0.000 Z"></path>
<path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M14.000,0.000 L17.000,0.000 L17.000,3.000 L14.000,3.000 L14.000,0.000 Z"></path>
<path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M-0.000,7.000 L3.000,7.000 L3.000,10.000 L-0.000,10.000 L-0.000,7.000 Z"></path>
<path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M7.000,7.000 L10.000,7.000 L10.000,10.000 L7.000,10.000 L7.000,7.000 Z"></path>
<path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M14.000,7.000 L17.000,7.000 L17.000,10.000 L14.000,10.000 L14.000,7.000 Z"></path>
<path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M-0.000,14.000 L3.000,14.000 L3.000,17.000 L-0.000,17.000 L-0.000,14.000 Z"></path>
<path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M7.000,14.000 L10.000,14.000 L10.000,17.000 L7.000,17.000 L7.000,14.000 Z"></path>
<path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M14.000,14.000 L17.000,14.000 L17.000,17.000 L14.000,17.000 L14.000,14.000 Z"></path>
</svg>',
            'list' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="23px" height="17px">
<path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M-0.000,0.000 L3.000,0.000 L3.000,3.000 L-0.000,3.000 L-0.000,0.000 Z"></path>
<path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M7.000,0.000 L23.000,0.000 L23.000,3.000 L7.000,3.000 L7.000,0.000 Z"></path>
<path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M-0.000,7.000 L3.000,7.000 L3.000,10.000 L-0.000,10.000 L-0.000,7.000 Z"></path>
<path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M7.000,7.000 L23.000,7.000 L23.000,10.000 L7.000,10.000 L7.000,7.000 Z"></path>
<path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M-0.000,14.000 L3.000,14.000 L3.000,17.000 L-0.000,17.000 L-0.000,14.000 Z"></path>
<path fill-rule="evenodd" fill="rgb(25, 17, 11)" d="M7.000,14.000 L23.000,14.000 L23.000,17.000 L7.000,17.000 L7.000,14.000 Z"></path>
</svg>',
        ] );
    }
}

/**
 * Returns the current view mode
 *
 * @return string
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'bookworm_wc_view_current' ) ) {
    function bookworm_wc_view_current() {
        if ( ! empty( $_GET['view'] ) ) {
            $current = $_GET['view'];
        } elseif ( ! empty( $_COOKIE[ BOOKWORM_WC_VIEW_COOKIE ] ) ) {
            $current = $_COOKIE[ BOOKWORM_WC_VIEW_COOKIE ];
        } else {
            $current = apply_filters('bookworm-catalog-layout', get_theme_mod( 'bookworm_catalog_layout', 'grid' ));
        }

        return (string) apply_filters( 'bookworm_wc_view_current', sanitize_key( $current ) );
    }
}


if ( ! function_exists( 'bookworm_wc_products_views' ) ) {
    function bookworm_wc_products_views() {
        if ( 'subcategories' !== woocommerce_get_loop_display_mode() ) {
            $current_view = bookworm_wc_view_current();
            $views        = bookworm_wc_views();

            ?><ul class="view-switcher nav nav-tab ml-lg-4 justify-content-center justify-content-md-start ml-md-auto" id="pills-tab" role="tablist"><?php
                foreach ( $views as $view => $content ) {

                    echo sprintf( '<li class="nav-item border"><a class="nav-link p-0 height-38 width-38 justify-content-center d-flex align-items-center %3$s" href="%1$s" role="button">%2$s</a></li>',
                        esc_url( add_query_arg( 'view', rawurlencode( $view ), false ) ),
                        $content,
                        $view === $current_view ? 'active' : ''
                    );
                }

            ?></ul><?php
        }
    }
}


if ( ! function_exists( 'bookworm_shop_view_content_wrapper_open' ) ) {
    function bookworm_shop_view_content_wrapper_open() {
        $current_view = bookworm_wc_view_current();
        if ( $current_view === 'grid') {
            $additional_class = 'grid-view';
        } else {
            $additional_class = 'list-view';
        }
        ?><div class="<?php echo esc_attr( $additional_class ); ?>"><?php
    }
}

if ( ! function_exists( 'bookworm_shop_view_content_wrapper_close' ) ) {
    function bookworm_shop_view_content_wrapper_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'bookworm_wc_product_filter_sidebar' ) ) {
    function bookworm_wc_product_filter_sidebar() { 
        if ( ! bookworm_product_archive_has_sidebar() && is_active_sidebar( 'sidebar-shop' ) ):
            ?><a id="offcanvasProductSidebarToggler" class="ml-3 h-primary d-inline-block mt-3 mt-md-0" href="javascript:;" role="button" 
                aria-controls="offcanvasProductSidebar" 
                aria-haspopup="true" 
                aria-expanded="false" 
                data-unfold-event="click" 
                data-unfold-hide-on-scroll="false" 
                data-unfold-target="#offcanvasProductSidebar" 
                data-unfold-type="css-animation" 
                data-unfold-overlay="{
                    &quot;className&quot;: &quot;u-sidebar-bg-overlay&quot;,
                    &quot;background&quot;: &quot;rgba(0, 0, 0, .7)&quot;,
                    &quot;animationSpeed&quot;: 500
                }" data-unfold-animation-in="<?php echo ( is_rtl() ? 'fadeInLeft' : 'fadeInRight' ); ?>" data-unfold-animation-out="<?php echo ( is_rtl() ? 'fadeOutLeft' : 'fadeOutRight' ); ?>" data-unfold-duration="500">
                 <i class="flaticon-filter mr-2"></i><?php echo esc_html__('Filter By', 'bookworm'); ?>
            </a><?php
        endif;
    }
}

if ( ! function_exists( 'bookworm_wc_offcanvas_product_sidebar' ) ) {
    /**
     * Offcanvas Product Sidebar
     */
    function bookworm_wc_offcanvas_product_sidebar() {
        $is_brand = false;

        if( class_exists( 'Mas_WC_Brands' ) ) {
            global $mas_wc_brands;
            $brand_taxonomy = $mas_wc_brands->get_brand_taxonomy();

            if ( is_tax ( $brand_taxonomy ) ){
                $is_brand = true;
            }   
        }

        if ( ! bookworm_product_archive_has_sidebar() && is_active_sidebar( 'sidebar-shop' ) && !is_product() && ! $is_brand ) :

        ?>
        <aside id="offcanvasProductSidebar" class="u-sidebar u-sidebar__md" aria-labelledby="offcanvasProductSidebarToggler">
            <div class="u-sidebar__scroller js-scrollbar">
                <div class="u-sidebar__container">
                    <div class="u-header-sidebar__footer-offset">
                        <div class="d-flex align-items-center justify-content-between py-4 px-4 border-bottom mb-5">
                            <div class="font-size-3">
                                <i class="flaticon-filter mr-2"></i><?php echo esc_html__( 'Filter By', 'bookworm');?>
                            </div>

                            <button type="button" class="close ml-auto"
                                aria-controls="offcanvasProductSidebar"
                                aria-haspopup="true"
                                aria-expanded="false"
                                data-unfold-event="click"
                                data-unfold-hide-on-scroll="false"
                                data-unfold-target="#offcanvasProductSidebar"
                                data-unfold-type="css-animation"
                                data-unfold-animation-in="<?php echo ( is_rtl() ? 'fadeInLeft' : 'fadeInRight'); ?>"
                                data-unfold-animation-out="<?php echo ( is_rtl() ? 'fadeOutLeft' : 'fadeOutRight'); ?>"
                                data-unfold-duration="500">
                                <span aria-hidden="true">
                                    <?php esc_html_e( 'Close', 'bookworm' ); ?> <i class="ml-2 flaticon-error"></i>
                                </span>
                            </button>
                        </div>

                        <!-- Content -->
                        <div class="u-sidebar__body px-4">
                            <div class="u-sidebar__content u-header-sidebar__content">
                                <div class="sidebar widget-area">
                                    <div id="offcanvasWidgetAccordion">
                                         <?php bookworm_get_sidebar(); ?>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <?php
        endif;
    
    }
}


if ( ! function_exists( 'bookworm_wc_products_per_page' ) ) {
    /**
     * Outputs a dropdown for user to select how many products to show per page
     */
    function bookworm_wc_products_per_page() {

        global $wp_query;
        global $wp;

        $action             = '';
        $cat                = '';
        $cat                = $wp_query->get_queried_object();
        $method             = apply_filters( 'bookworm_wc_ppp_method', 'post' );
        $return_to_first    = apply_filters( 'bookworm_wc_ppp_return_to_first', false );
        $total              = $wp_query->found_posts;
        $per_page           = $wp_query->get( 'posts_per_page' );
        $columns            = apply_filters( 'bookworm_catalog_columns', wc_get_default_products_per_row() );
        $rows               = apply_filters( 'bookworm_catalog_columns', wc_get_default_product_rows_per_page() );
        $_per_page          = $columns * $rows;

        // Generate per page options
        $products_per_page_options = array();
        
        while( $_per_page < $total ) {
            $products_per_page_options[] = $_per_page;
            $_per_page = $_per_page * 2;
        }

        if ( empty( $products_per_page_options ) ) {
            return;
        }

        $products_per_page_options[] = -1;

        // Set action url if option behaviour is true
        // Paste QUERY string after for filter and orderby support
        $query_string = null;

        if ( isset( $cat->term_id ) && isset( $cat->taxonomy ) && $return_to_first ) :
            $action = get_term_link( $cat->term_id, $cat->taxonomy ) . $query_string;
        elseif ( $return_to_first ) :
            $action = get_permalink( wc_get_page_id( 'shop' ) ) . $query_string;
        else :
            $action = home_url( $wp->request );
        endif;


        // Only show on product categories
        if ( ! woocommerce_products_will_display() ) :
            return;
        endif;
        
        do_action( 'bookworm_wc_ppp_before_dropdown_form' );

        ?><form method="POST" action="<?php echo esc_url( $action ); ?>" class="number-of-items ml-md-4 mb-4 m-md-0 d-none d-xl-block"><?php

             do_action( 'bookworm_wc_ppp_before_dropdown' );

            ?><select name="ppp" onchange="this.form.submit()" class="dropdown-select orderby"  data-style="border-bottom shadow-none outline-none py-2"><?php

                foreach( $products_per_page_options as $key => $value ) :

                    ?><option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $per_page ); ?>><?php
                        $ppp_text = apply_filters( 'bookworm_wc_ppp_text', esc_html__( 'Show %s', 'bookworm' ), $value );
                        esc_html( printf( $ppp_text, $value == -1 ? esc_html__( 'All', 'bookworm' ) : $value ) ); // Set to 'All' when value is -1
                    ?></option><?php

                endforeach;

            ?></select><?php

            // Keep query string vars intact
            foreach ( $_GET as $key => $val ) :

                if ( 'ppp' === $key || 'submit' === $key ) :
                    continue;
                endif;
                if ( is_array( $val ) ) :
                    foreach( $val as $inner_val ) :
                        ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>[]" value="<?php echo esc_attr( $inner_val ); ?>" /><?php
                    endforeach;
                else :
                    ?><input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $val ); ?>" /><?php
                endif;
            endforeach;

            do_action( 'bookworm_wc_ppp_after_dropdown' );

        ?></form><?php

        do_action( 'bookworm_wc_ppp_after_dropdown_form' );
    }
}

if ( ! function_exists( 'bookworm_wc_set_loop_shop_per_page' ) ) {
    /**
     * Set Shop Loop Per Page
     */
    function bookworm_wc_set_loop_shop_per_page( $per_page ) {
        if ( isset( $_REQUEST['wppp_ppp'] ) ) :
            $per_page = intval( $_REQUEST['wppp_ppp'] );
            WC()->session->set( 'products_per_page', intval( $_REQUEST['wppp_ppp'] ) );
        elseif ( isset( $_REQUEST['ppp'] ) ) :
            $per_page = intval( $_REQUEST['ppp'] );
            WC()->session->set( 'products_per_page', intval( $_REQUEST['ppp'] ) );
        elseif ( WC()->session->__isset( 'products_per_page' ) ) :
            $per_page = intval( WC()->session->__get( 'products_per_page' ) );
        endif;

        return $per_page;
    }
}

if ( ! function_exists( 'bookworm_shop_attributes_top_jumbotron' ) ) {
    function bookworm_shop_attributes_top_jumbotron() {
        $static_block_id = apply_filters( 'bookworm_shop_attributes_top_jumbotron_id',  '' ); 

        $brand_taxonomy = Mas_WC_Brands()->get_brand_taxonomy();


        if( is_tax( $brand_taxonomy ) ) {
            $term               = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
            $term_id            = $term->term_id;
            $static_block_id    = get_term_meta( $term_id, 'static_block_id', true );
            
        }


        if( bookworm_is_mas_static_content_activated() && ! empty( $static_block_id ) ) {
            $static_block = get_post( $static_block_id );
            $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
            echo '<div class="space-bottom-2 space-bottom-lg-3 author-jumbotron">' . apply_filters( 'the_content', $content ) . '</div>';
        } 

    }
}

if ( ! function_exists( 'bookworm_toggle_shop_loop_hooks' ) ) {
    function bookworm_toggle_shop_loop_hooks() {

        if( class_exists( 'Mas_WC_Brands' ) ) {
            global $mas_wc_brands;
            $brand_taxonomy = $mas_wc_brands->get_brand_taxonomy();

            if( ! empty($brand_taxonomy ) && ! ( is_shop() || is_product_category() || is_product_tag() ) ) {

                remove_action( 'woocommerce_before_shop_loop',              'bookworm_shop_page_top_jumbotron', 10 );
                remove_action( 'woocommerce_before_shop_loop',              'bookworm_shop_control_bar', 20 );
                add_action( 'woocommerce_before_shop_loop',                 'bookworm_shop_attributes_top_jumbotron', 10 );
            }
        }
    }
}


function bookworm_wc_get_breadcrumb( $crumbs, $obj ) {
    if ( is_home() ) {
        if( isset( $crumbs[2] ) && get_query_var( 'paged' ) < 2 ) {
            unset( $crumbs[2] );
        }

        if( empty( $crumbs[1][0] ) ) {
            $crumbs[1][0] = esc_html__( 'Blog', 'bookworm' );
        }
    }
    return $crumbs;
}