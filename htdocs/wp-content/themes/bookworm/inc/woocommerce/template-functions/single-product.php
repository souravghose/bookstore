<?php
/**
 * Template functions used in Single Product
 *
 */
if ( ! function_exists( 'bookworm_single_product_hooks' ) ) {
    function bookworm_single_product_hooks() {
        $version            = bookworm_get_single_product_version();
        $available_versions = array( 'v1', 'v2', 'v3', 'v4', 'v5', 'v6', 'v7' );
        if ( in_array( $version, $available_versions ) ) {
            call_user_func( 'bookworm_single_product_' . $version . '_hooks'     );
        }
    }
}

if ( ! function_exists( 'bookworm_enable_single_product_sidebar' ) ) {
    function bookworm_enable_single_product_sidebar( $enable ) {
        $version            = bookworm_get_single_product_version();
        if ( $version === 'v4' ) {
            $enable = true;
        }
        return $enable;
    }
}


if ( ! function_exists( 'bookworm_wc_single_product_variations_radio_style_enable' ) ) {
    function bookworm_wc_single_product_variations_radio_style_enable() {
        $version            = bookworm_get_single_product_version();
        if ( $version === 'v1' || $version === 'v3' ||  $version === 'v6' ||  $version === 'v7' ) {
            return true;
        }
    }
}

if ( ! function_exists( 'bookworm_maybe_display_meta_in_add_info_tab' ) ) {
    function bookworm_maybe_display_meta_in_add_info_tab( $enable ) {
        if ( bookworm_enable_product_meta_display() ) {
            $enable = true;
        }

        return $enable;
    }
}

if ( ! function_exists( 'bookworm_comment_author' ) ) {
    function bookworm_comment_author( $comment ) { ?>
        <h6 class="mb-0 mr-3"><?php comment_author( $comment ); ?></h6><?php

    }
}

if ( ! function_exists( 'bookworm_review_display_comment_text' ) ) {
    function bookworm_review_display_comment_text() { ?>
       <div class="description mb-4 text-lh-md">
            <?php comment_text(); ?>
       </div><?php

    }
}

if ( ! function_exists( 'bookworm_review_comment_date' ) ) {
    function bookworm_review_comment_date( $comment ) {
        ?><div class="text-gray-600"><?php
            echo esc_html( get_comment_date( wc_date_format(), $comment ) );
        ?></div><?php
    }
}

if ( ! function_exists( 'bookworm_get_savings_on_sale' ) ) {
    function bookworm_get_savings_on_sale( $product, $in = 'amount' ) {

        if( ! $product->is_on_sale() ) {
            return 0;
        }

        if( $product->is_type( 'variable' ) ) {
            $var_regular_price = array();
            $var_sale_price = array();
            $var_diff_price = array();
            $available_variations = $product->get_available_variations();
            foreach ( $available_variations as $key => $available_variation ) {
                $variation_id = $available_variation['variation_id']; // Getting the variable id of just the 1st product. You can loop $available_variations to get info about each variation.
                $variable_product = new WC_Product_Variation( $variation_id );

                $variable_product_regular_price = $variable_product->get_regular_price();
                $variable_product_sale_price = $variable_product->get_sale_price();

                if( ! empty( $variable_product_regular_price ) ) {
                    $var_regular_price[] = $variable_product_regular_price;
                } else {
                    $var_regular_price[] = 0;
                }
                if( ! empty( $variable_product_sale_price ) ) {
                    $var_sale_price[] = $variable_product_sale_price;
                } else {
                    $var_sale_price[] = 0;
                }
            }

            foreach( $var_regular_price as $key => $reg_price ) {
                if( isset( $var_sale_price[$key] ) && $var_sale_price[$key] !== 0 ) {
                    $var_diff_price[] = $reg_price - $var_sale_price[$key];
                } else { 
                    $var_diff_price[] = 0;
                }
            }

            $best_key = array_search( max( $var_diff_price ), $var_diff_price );

            $regular_price = $var_regular_price[$best_key];
            $sale_price = $var_sale_price[$best_key];
        } else {
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
        }

        $regular_price = wc_get_price_to_display( $product, array( 'qty' => 1, 'price' => $regular_price ) );
        $sale_price = wc_get_price_to_display( $product, array( 'qty' => 1, 'price' => $sale_price ) );

        if ( ( $regular_price - $sale_price ) <= 0 ) {
            return;
        }

        if ( 'amount' === $in ) {

            $savings = wc_price( $regular_price - $sale_price );
        } elseif ( 'percentage' === $in ) {

            $savings = '<span class="percentage">' . round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ) . '%</span>';
        }

        return $savings;
    }
}

if ( ! function_exists( 'bookworm_get_sale_flash' ) ) {
    /**
     * Functions for getting sale flash with sale percentage.
     */
    function bookworm_get_sale_flash( $html, $post, $product ) {
        $bookworm_get_sale_flash = bookworm_get_savings_on_sale( $product, 'percentage' );
        
        if ( ! $bookworm_get_sale_flash ){
            return;
        }

        return '<span class="onsale badge badge-md badge-primary-green position-absolute badge-pos--top-right text-white rounded-circle d-flex flex-column align-items-center justify-content-center">' .  bookworm_get_savings_on_sale( $product, 'percentage' ) . '</span>'; 
    }
}

if ( ! function_exists( 'bookworm_single_product_sale_flash' ) ) {
    function bookworm_single_product_sale_flash( $html, $post, $product ) {
        $bookworm_get_single_sale_flash = bookworm_get_savings_on_sale( $product );
        
        if ( ! $bookworm_get_single_sale_flash ){
            return;
        }
        
        return '<div class="onsale d-none badge badge-lg badge-primary-home-v3 position-absolute badge-pos--top-left text-gray-200 rounded-circle d-lg-flex flex-column align-items-center justify-content-center mt-9"><h6 class="font-weight-medium mb-n2">' . esc_html__('save', 'bookworm') . '</h6><span class="font-size-5 font-weight-medium">' . bookworm_get_savings_on_sale( $product ) . '</span></div>';
    }
}

if ( ! function_exists( 'bookworm_single_product_v1_hooks' ) ) {
    function bookworm_single_product_v1_hooks() {
        remove_action( 'woocommerce_single_product_summary',  'woocommerce_template_single_meta', 40 );
        remove_action( 'bookworm_wc_product_before_tabs',     'bookworm_wc_tabs_wrapper_start', 10 );
        remove_action( 'bookworm_before_wc_tabs_panel',       'bookworm_wc_tabs_wrapper_end', 10 );
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_summary_inner_start', 0 );
        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_summary_inner_end', 30 );
        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_summary_footer_start', 30 );
        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_summary_footer_end', 90 );
        
        add_action( 'woocommerce_after_single_product_summary', 'bookworm_output_product_data_tabs', 10 );

        bookworm_wc_product_meta_display_hook();
    }
}

if ( ! function_exists( 'bookworm_single_product_v2_hooks' ) ) {
    function bookworm_single_product_v2_hooks() {
        remove_action( 'woocommerce_single_product_summary',  'woocommerce_template_single_meta', 40 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing',  50 );// TODO:
        remove_action( 'bookworm_wc_product_before_tabs',    'bookworm_wc_tabs_wrapper_start', 10 );

        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_summary_inner_start', 0 );
        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_static_content', 30 );
        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_summary_inner_end', 50 );
        add_action( 'woocommerce_after_single_product_summary', 'bookworm_single_product_action', 6 );
        add_action( 'bookworm_wc_product_before_tabs',       'bookworm_v2_wc_tabs_wrapper_start', 10 );

        bookworm_wc_product_meta_display_hook();
    }
}

if ( ! function_exists( 'bookworm_single_product_v3_hooks' ) ) {
    function bookworm_single_product_v3_hooks() {
        remove_action( 'bookworm_wc_product_before_tabs',        'bookworm_wc_tabs_wrapper_start', 10 );
        remove_action( 'woocommerce_single_product_summary',  'woocommerce_template_single_meta', 40 );
        remove_action( 'bookworm_before_wc_tabs_panel', 'bookworm_wc_tabs_wrapper_end', 10 );

        add_action( 'woocommerce_before_single_product_summary', 'bookworm_single_product_background_wrapper_start', 4 );

        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_summary_inner_start', 0 );

        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_v3_cart_wrapper_start', 25 );
        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_v3_wishlist_share_wrapper_start', 30 );
        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_v3_closing_div', 50 );
        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_v3_closing_div', 55 );
        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_summary_inner_end', 70 );

        add_action( 'woocommerce_after_single_product_summary',  'bookworm_single_product_background_wrapper_end', 9 );

        bookworm_wc_product_meta_display_hook();
    }
}

if ( ! function_exists( 'bookworm_single_product_v4_hooks' ) ) {
    function bookworm_single_product_v4_hooks() {
        remove_action( 'bookworm_wc_product_before_tabs', 'bookworm_wc_tabs_wrapper_start', 10 );
        remove_action( 'bookworm_before_wc_tabs_panel', 'bookworm_wc_tabs_wrapper_end', 10 );
        remove_action( 'bookworm_before_wc_tabs_panel_content', 'bookworm_wc_tab_panel_wrapper_start', 10 );
        remove_action( 'bookworm_after_wc_tabs_panel_content', 'bookworm_wc_tab_panel_wrapper_close', 10 );
        remove_action( 'woocommerce_single_product_summary',  'woocommerce_template_single_meta', 40 );

        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_summary_inner_start', 0 );
        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_summary_inner_end', 30 );
        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_v4_summary_footer_start', 30 );
        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_v4_summary_footer_end', 90 );

        add_action( 'bookworm_wc_product_before_tabs', 'bookworm_v4_wc_tabs_wrapper_start', 10 );
        add_action( 'woocommerce_product_after_tabs',  'bookworm_v4_wc_tabs_wrapper_end', 10 );

        bookworm_wc_product_meta_display_hook();
        bookworm_wc_single_product_related_upsell_display_hook();
    }
}

if ( ! function_exists( 'bookworm_single_product_v5_hooks' ) ) {
    function bookworm_single_product_v5_hooks() {
        remove_action( 'bookworm_wc_product_before_tabs',        'bookworm_wc_tabs_wrapper_start', 10 );
        remove_action( 'bookworm_before_wc_tabs_panel', 'bookworm_wc_tabs_wrapper_end', 10 );
        remove_action( 'woocommerce_single_product_summary',  'woocommerce_template_single_meta', 40 );

        add_action( 'woocommerce_before_single_product_summary', 'bookworm_single_product_background_wrapper_start', 4 );
        add_action( 'woocommerce_after_single_product_summary',  'bookworm_single_product_background_wrapper_end', 9 );
        add_action( 'woocommerce_single_product_summary',        'bookworm_single_product_v5_summary_inner_start', 0 );
        add_action( 'woocommerce_single_product_summary',        'bookworm_single_product_wishlist_share_wrap_start', 30 );
        add_action( 'woocommerce_single_product_summary',        'bookworm_single_product_wishlist_share_wrap_end', 55 );
        add_action( 'woocommerce_after_single_product_summary',        'bookworm_single_product_v5_summary_inner_end', 4 );

        bookworm_wc_product_meta_display_hook();
    }
}

if ( ! function_exists( 'bookworm_single_product_v6_hooks' ) ) {
    function bookworm_single_product_v6_hooks() {
        remove_action( 'bookworm_wc_product_before_tabs', 'bookworm_wc_tabs_wrapper_start', 10 );
        remove_action( 'bookworm_before_wc_tabs_panel', 'bookworm_wc_tabs_wrapper_end', 10 );
        remove_action( 'bookworm_before_wc_tabs_panel_content', 'bookworm_wc_tab_panel_wrapper_start', 10 );
        remove_action( 'bookworm_after_wc_tabs_panel_content', 'bookworm_wc_tab_panel_wrapper_close', 10 );
        remove_action( 'woocommerce_single_product_summary', 'bookworm_wc_product_rating_author_info', 9 );
        remove_action( 'woocommerce_single_product_summary',  'woocommerce_template_single_meta', 40 );

        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

        add_action( 'woocommerce_before_single_product_summary', 'bookworm_single_product_background_wrapper_start', 4 );
        add_action( 'woocommerce_after_single_product_summary',  'bookworm_single_product_background_wrapper_end', 9 );
        add_action( 'bookworm_wc_product_before_tabs', 'bookworm_v6_wc_tabs_wrapper_start', 10 );
        add_action( 'bookworm_before_wc_tabs_panel', 'bookworm_v6_wc_tabs_wrapper_end', 10 );
        add_action( 'woocommerce_before_single_product_summary', 'bookworm_single_product_v6_before_gallery_wrapper', 5 );
        add_action( 'bookworm_before_wc_tabs_panel_content', 'bookworm_v6_wc_tab_panel_wrapper_start', 10 );
        add_action( 'bookworm_after_wc_tabs_panel_content', 'bookworm_v6_wc_tab_panel_wrapper_close', 10 );

        bookworm_wc_product_meta_display_hook();
    }
}

if ( ! function_exists( 'bookworm_single_product_v7_hooks' ) ) {
    function bookworm_single_product_v7_hooks() {
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
        remove_action( 'bookworm_wc_product_before_tabs', 'bookworm_wc_tabs_wrapper_start', 10 );
        remove_action( 'bookworm_before_wc_tabs_panel', 'bookworm_wc_tabs_wrapper_end', 10 );
        remove_action( 'bookworm_before_wc_tabs_panel_content', 'bookworm_wc_tab_panel_wrapper_start', 10 );
        remove_action( 'bookworm_after_wc_tabs_panel_content', 'bookworm_wc_tab_panel_wrapper_close', 10 );
        remove_action( 'woocommerce_single_product_summary',  'woocommerce_template_single_meta', 40 );

        remove_action( 'woocommerce_before_single_product_summary', 'bookworm_wc_show_product_images', 20 );
        add_filter( 'woocommerce_gallery_thumbnail_size', 'bookworm_gallery_image_size', 10);
        add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_summary_inner_start', 0 );
        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_summary_inner_end', 70 );
        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_v7_summary_footer_start', 70 );
        add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 80 );
        add_action( 'woocommerce_single_product_summary', 'bookworm_single_product_v7_summary_footer_end', 90 );
        
        add_action( 'bookworm_before_wc_tabs_panel_content', 'bookworm_v6_wc_tab_panel_wrapper_start', 10 );
        add_action( 'bookworm_after_wc_tabs_panel_content', 'bookworm_v6_wc_tab_panel_wrapper_close', 10 );

        add_action( 'woocommerce_single_product_summary',        'bookworm_single_product_wishlist_share_wrap_start', 30 );
        add_action( 'woocommerce_single_product_summary',        'bookworm_single_product_wishlist_share_wrap_end', 55 );

        bookworm_wc_product_meta_display_hook();
    }
}

if ( ! function_exists( 'bookworm_single_product_action' ) ) {
    function bookworm_single_product_action() {
        add_action( 'bookworm_single_product_action', 'bookworm_single_product_v2_price_wrapper',       10 );
        add_action( 'bookworm_single_product_action', 'bookworm_single_product_action_inner_wrapper',     20 );

        ?>
        <div class="col-lg-4 product-actions-wrapper">
            <div class="border mt-md-8">
                <?php do_action( 'bookworm_single_product_action' );?>
            </div>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_v6_before_gallery_wrapper' ) ) {
    function bookworm_single_product_v6_before_gallery_wrapper() { ?>
        <div class="col-md-4 pt-8 pt-md-0">
           <?php woocommerce_template_single_title(); ?>
            <div class="font-size-2 mb-4">
                <?php bookworm_wc_product_rating_author_info(); 
                woocommerce_template_single_excerpt();?>
            </div>
        </div><?php
    }
}

if( ! function_exists( 'bookworm_gallery_image_size' ) ) {
    function bookworm_gallery_image_size( $image_size ) { 
        $image_size = 'woocommerce_single';
        return $image_size;
        
    }
}


if ( ! function_exists( 'bookworm_single_product_v2_price_wrapper' ) ) {
    function bookworm_single_product_v2_price_wrapper() { ?>
        <div class="bg-white-100 py-4 px-5">
            <?php woocommerce_template_single_price(); ?>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_action_inner_wrapper' ) ) {
    function bookworm_single_product_action_inner_wrapper() { ?>
        <div class="py-4 px-5">
            <?php woocommerce_template_single_add_to_cart(); ?>
            <ul class="list-unstyled nav d-block d-md-flex justify-content-center">
                <?php if ( apply_filters( 'bookworm_enable_wishlist', true ) && function_exists( 'YITH_WCWL' ) ) : ?>
                    <li class="mr-md-4 mb-4 mb-md-0"><?php bookworm_add_to_wishlist_button(); ?></li>
                <?php endif; ?>
                <li><?php woocommerce_template_single_sharing(); ?></li>
            </ul>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_background_wrapper_start' ) ) {
    function bookworm_single_product_background_wrapper_start() { ?>
        <div class="bg-punch-light single-product-bg"><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_background_wrapper_end' ) ) {
    function bookworm_single_product_background_wrapper_end() { ?>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_wc_product_meta_display_hook' ) ) {
    function bookworm_wc_product_meta_display_hook() {
        $version            = bookworm_get_single_product_version();

        if ( ! bookworm_enable_product_meta_display() ) {
            if (  $version === 'v1') {
                add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 50 );
            } elseif (  $version === 'v2'  || $version === 'v6') {
                add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
            } elseif (  $version === 'v3' || $version === 'v4' || $version === 'v5' || $version === 'v7' ) {
                add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 60 );
            }
        } else {
            add_action( 'woocommerce_product_additional_information', 'woocommerce_template_single_meta', 5 );
        }
    }
}

if ( ! function_exists( 'bookworm_wc_single_product_related_upsell_display_hook' ) ) {
    function bookworm_wc_single_product_related_upsell_display_hook() {
        if ( bookworm_single_product_has_sidebar() ) {
            remove_action( 'woocommerce_after_single_product', 'woocommerce_upsell_display', 10 );
            remove_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products', 20 );
            add_action( 'bookworm_after_content_container', 'woocommerce_upsell_display', 10 );
            add_action( 'bookworm_after_content_container', 'woocommerce_output_related_products', 20 );    
        }
    }
}

if ( ! function_exists( 'bookworm_wc_tabs_wrapper_start' ) ) {
    function bookworm_wc_tabs_wrapper_start() {
        ?><div class="border-top border-bottom"><?php
    }
}

if ( ! function_exists( 'bookworm_v3_wc_tabs_wrapper_start' ) ) {
    function bookworm_v3_wc_tabs_wrapper_start() {
        ?><div class="bg-punch-light pb-6"><?php
    }
}

if ( ! function_exists( 'bookworm_v4_wc_tabs_wrapper_start' ) ) {
    function bookworm_v4_wc_tabs_wrapper_start() {
        ?><div class="border-top classic-nav row"><?php
    }
}

if ( ! function_exists( 'bookworm_v4_wc_tabs_wrapper_end' ) ) {
    function bookworm_v4_wc_tabs_wrapper_end() {
        ?></div><?php
    }
}

if ( ! function_exists( 'bookworm_v2_wc_tabs_wrapper_start' ) ) {
    function bookworm_v2_wc_tabs_wrapper_start() {
        ?><div class="border-bottom"><?php
    }
}


if ( ! function_exists( 'bookworm_wc_tabs_wrapper_end' ) ) {
    function bookworm_wc_tabs_wrapper_end() {
        ?></div><?php
    }
}

if ( ! function_exists( 'bookworm_wc_tab_panel_wrapper_start' ) ) {
    function bookworm_wc_tab_panel_wrapper_start() {
        ?><div class="row pt-9 mb-10">
            <div class="col-xl-8 offset-xl-2"><?php
    }
}

if ( ! function_exists( 'bookworm_wc_tab_panel_wrapper_close' ) ) {
    function bookworm_wc_tab_panel_wrapper_close() {
            ?></div>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_row_start' ) ) {
    function bookworm_single_product_row_start() {
        $version = bookworm_get_single_product_version();
        ?><div class="single-product-container <?php echo esc_attr($version !== 'v6' && $version !== 'v7') ? 'container' : 'container-fluid';?>">
            <div class="row single-product-wrapper"><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_row_end' ) ) {
    function bookworm_single_product_row_end() {
            ?></div><!-- /.row -->
        </div><!-- /.container --><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_gallery_wrapper_start' ) ) {
    function bookworm_single_product_gallery_wrapper_start() {
        $version = bookworm_get_single_product_version();
        if ( $version === 'v2') {
            $gallery_wrapper_classes = 'col-md-4 col-lg-3';
        } elseif ( $version === 'v3') {
            $gallery_wrapper_classes = 'col-md-4 col-wd-5';
        } elseif ( $version === 'v4') {
            $gallery_wrapper_classes = 'col-lg-5';
        } elseif ( $version === 'v5') {
            $gallery_wrapper_classes = 'col-md-6 col-lg-5 offset-lg-1';
        } elseif ( $version === 'v6') {
            $gallery_wrapper_classes = 'col-md-4';
        } elseif ( $version === 'v7') {
            $gallery_wrapper_classes = 'bookworm-product-gallery-without-carousel col-lg-6 col-xl-7';
        } else {
            $gallery_wrapper_classes = 'col-md-5';
        }
        ?><div class="bookworm-product-gallery <?php echo esc_attr( apply_filters( 'bookworm_product_gallery_wrapper_classes',$gallery_wrapper_classes )); ?>"><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_gallery_wrapper_end' ) ) {
    function bookworm_single_product_gallery_wrapper_end() {
        ?></div><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_summary_wrapper_start' ) ) {
    function bookworm_single_product_summary_wrapper_start() {
        $version = bookworm_get_single_product_version();

        if ( $version === 'v2') {
            $summary_wrapper_classes = 'col-md-8 col-lg-5 pl-0';
        } elseif ( $version === 'v3') {
            $summary_wrapper_classes = 'col-md-8 col-wd-7 pl-0';
        } elseif ( $version === 'v4') {
            $summary_wrapper_classes = 'space-top-2 col-lg-7 pl-lg-0';
        } elseif ( $version === 'v5') {
            $summary_wrapper_classes = 'space-top-2  col-md-6 col-lg-5';
        } elseif ( $version === 'v6') {
            $summary_wrapper_classes = 'space-top-2  col-md-4';
        } elseif ( $version === 'v7') {
            $summary_wrapper_classes = 'col-lg-6 col-xl-5 pl-0';
        } else {
            $summary_wrapper_classes = 'space-top-2  col-md-7 pl-0 border-left';
        }

        ?><div class="summary entry-summary <?php echo esc_attr( apply_filters( 'bookworm_product_summary_classes', $summary_wrapper_classes ) ); ?>"><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_summary_wrapper_end' ) ) {
    function bookworm_single_product_summary_wrapper_end() {
        ?></div><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_summary_inner_start' ) ) {
    function bookworm_single_product_summary_inner_start() {
        $version = bookworm_get_single_product_version();

        if ( $version === 'v2') {
            $summary_wrapper_inner_classes = 'space-top-2 pl-4 pl-wd-6 px-wd-7 pb-5';
        } elseif ( $version === 'v3') {
            $summary_wrapper_inner_classes = 'space-top-2 px-4 px-xl-5 px-wd-7 pb-5';
        } elseif ( $version === 'v4') {
            $summary_wrapper_inner_classes = 'px-lg-4 px-xl-6';
        } elseif ( $version === 'v7') {
            $summary_wrapper_inner_classes = 'px-4 py-5 py-xl-6 px-xl-6';
        } else {
            $summary_wrapper_inner_classes = 'px-4 px-xl-7 pb-5';
        }


        ?><div class="summary__inner <?php echo esc_attr( apply_filters( 'bookworm_product_summary_inner_classes', $summary_wrapper_inner_classes ) ); ?>"><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_summary_inner_end' ) ) {
    function bookworm_single_product_summary_inner_end() {
        ?></div><?php
    }
}


if ( ! function_exists( 'bookworm_single_product_v4_summary_footer_start' ) ) {
    function bookworm_single_product_v4_summary_footer_start() {
        ?><div class="summary__footer px-lg-4 px-xl-7 py-5 d-flex align-items-center"><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_v4_summary_footer_end' ) ) {
    function bookworm_single_product_v4_summary_footer_end() {
        ?></div><?php
    }
}


if ( ! function_exists( 'bookworm_single_product_v5_summary_inner_start' ) ) {
    function bookworm_single_product_v5_summary_inner_start() {
        ?><div class="border bg-white"><div class="py-4 px-5"><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_v5_summary_inner_end' ) ) {
    function bookworm_single_product_v5_summary_inner_end() {
        ?></div></div><?php
    }
}



if ( ! function_exists( 'bookworm_single_product_summary_footer_start' ) ) {
    function bookworm_single_product_summary_footer_start() {
        if (  ( apply_filters( 'bookworm_enable_wishlist', true ) && function_exists( 'YITH_WCWL' ) ) || function_exists( 'sharing_display' ) )  : 
        ?><div class="summary__footer border-top px-4 px-xl-7 py-5 d-flex align-items-center flex-wrap"><?php
        endif;
    }
}

if ( ! function_exists( 'bookworm_single_product_summary_footer_end' ) ) {
    function bookworm_single_product_summary_footer_end() {
         if (  ( apply_filters( 'bookworm_enable_wishlist', true ) && function_exists( 'YITH_WCWL' ) ) || function_exists( 'sharing_display' ))  : 
        ?></div><?php
        endif;
    }
}

if ( ! function_exists( 'bookworm_single_product_v7_summary_footer_start' ) ) {
    function bookworm_single_product_v7_summary_footer_start() {
        ?><div class="summary__footer border-top px-4 py-5 py-xl-6 px-xl-6"><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_v7_summary_footer_end' ) ) {
    function bookworm_single_product_v7_summary_footer_end() {
        ?></div><?php
    }
}



if ( ! function_exists( 'bookworm_output_product_data_tabs' ) ) {
    function bookworm_output_product_data_tabs() {
        bookworm_get_template( 'shop/single-product/tabs/bookworm-tabs.php' );
    }
}

if ( ! function_exists( 'bookworm_v6_wc_tabs_wrapper_start' ) ) {
    function bookworm_v6_wc_tabs_wrapper_start() {
        ?><div class="container-fluid px-4 px-lg-8 bg-punch-light">
            <div class="bg-white box-shadow-1 d-xl-flex">
                <div class="d-md-flex align-items-center flex-wrap ml-xl-auto order-xl-1 ml-3 ml-xl-0 pt-6 pt-xl-0">

                    <ul class="list-unstyled nav ml-md-5">
                        <?php if ( apply_filters( 'bookworm_enable_wishlist', true ) && function_exists( 'YITH_WCWL' ) ) : ?>
                            <li class="mr-5 mr-lg-6 mb-4 mb-md-0"><?php bookworm_add_to_wishlist_button(); ?></li>
                        <?php endif; ?>
                        
                        <li class="mr-5 mr-lg-6"><?php woocommerce_template_single_sharing(); ?></li>
                    </ul>
                </div>
                <?php
    }
}

if ( ! function_exists( 'bookworm_v6_wc_tabs_wrapper_end' ) ) {
    function bookworm_v6_wc_tabs_wrapper_end() {
        ?></div></div><?php
    }
}

if ( ! function_exists( 'bookworm_v6_wc_tab_panel_wrapper_start' ) ) {
    function bookworm_v6_wc_tab_panel_wrapper_start() {
        ?><div class="pt-9 mb-10"><?php
    }
}

if ( ! function_exists( 'bookworm_v6_wc_tab_panel_wrapper_close' ) ) {
    function bookworm_v6_wc_tab_panel_wrapper_close() {
        ?></div><?php
    }
}



if ( ! function_exists( 'bookworm_wc_show_product_images' ) ) {
    function bookworm_wc_show_product_images() {
        global $product;

        $columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
        $post_thumbnail_id = $product->get_image_id();
        $attachment_ids    = $product->get_gallery_image_ids();
        $wrapper_id        = 'bookworm-single-product-gallery-' . uniqid();
        $wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
            'woocommerce-product-gallery',
            'woocommerce-product-gallery--' . ( has_post_thumbnail() ? 'with-images' : 'without-images' ),
            'woocommerce-product-gallery--columns-' . absint( $columns ),
            'woocommerce-thumb-count-' . count( $attachment_ids ),
            'images',
        ) );
        $image_ids         = $attachment_ids;
        array_unshift($image_ids, $post_thumbnail_id );

        $data_pagi_classes ='';
        if( apply_filters( 'bookworm_enable_slider_vertical_pagination', false ) ) {
            $data_pagi_classes ='position-absolute text-center left-0 u-slick__pagination flex-column u-slick__pagination-centered--y ml-md-n4 ml-lg-0 mr-lg-5 mb-0';
            $enable_data_vertical ='true';
        } else {
            $data_pagi_classes ='text-center u-slick__pagination my-4';
            $enable_data_vertical = 'false';
        }

        ?>
        <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">

            <!-- Main Slider -->
            <div id="heroSlider" class="js-slick-carousel u-slick" data-pagi-classes="<?php echo esc_attr( $data_pagi_classes ); ?>" data-vertical="<?php echo esc_attr( $enable_data_vertical );?>">
                <?php foreach( $image_ids as $image_id ) :

                    if ( $image_id ) {
                        ?>
                        <div class="js-slide">
                            <?php echo wc_get_gallery_image_html( $image_id, true ); ?>
                        </div>
                        <?php
                    } else {
                        echo '<div class="front-wc-product-gallery__image--placeholder">';
                        echo sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_attr__( 'Awaiting product image', 'bookworm' ) );
                        echo '</div>';
                    }

                endforeach; ?>

            </div>

            <!-- End Main Slider -->
            <?php if( count( $attachment_ids ) > 0 && apply_filters( 'bookworm_thumbnails_hide', false )) : ?>
            <!-- Slider Nav -->
            <div class="gallery-thumbnail">
                <div id="heroSliderNav" class="js-slick-carousel u-slick u-slick--gutters-1 u-slick--transform-off max-width-27 mx-auto" data-nav-for="#heroSlider" data-slides-show="3" data-is-thumbs="true" data-nav-for="#heroSlider">
                    <?php foreach( $image_ids as $image_id ) :
                        if ( $image_id ) {
                            echo bookworm_wc_get_gallery_image_html( $image_id );

                        } else {
                            echo '<div class="bookworm-wc-product-gallery__image--placeholder">';
                            echo sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src()), esc_attr__( 'Awaiting product image', 'bookworm' ) );
                            echo '</div>';
                        }

                    endforeach; ?>

                </div>
            </div>
             <!-- End Slider Nav -->
            <?php endif; ?>

            <?php
                $custom_script = "
                    jQuery(document).ready( function($) {
                        $( 'body' ).on( 'woocommerce_gallery_init_zoom', function( e ) {
                            $( '.woocommerce-product-gallery .js-slick-carousel' ).slick( 'slickGoTo', 0 );
                            $( '.woocommerce-product-gallery .js-slick-carousel' ).slick( 'refresh' );
                        } );
                    } );
                ";
                wp_add_inline_script( 'bookworm-js', $custom_script );
            ?>

        </div>
        <?php
    }
}

if ( ! function_exists( 'bookworm_wc_get_gallery_image_html' ) ) {
    function bookworm_wc_get_gallery_image_html( $attachment_id, $main_image = false ) {
        $gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
        $thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
        $image_size        = apply_filters( 'woocommerce_gallery_image_size', $main_image ? 'woocommerce_single': $thumbnail_size );
        $full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );
        $thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
        $full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
        $image             = wp_get_attachment_image( $attachment_id, $image_size, false, array(
            'title'                   => get_post_field( 'post_title', $attachment_id ),
            'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
            'data-src'                => $full_src[0],
            'data-large_image'        => $full_src[0],
            'data-large_image_width'  => $full_src[1],
            'data-large_image_height' => $full_src[2],
            'class'                   => $main_image ? 'wp-post-image' : '',
        ) );

        return '<div data-thumb="' . esc_url( $thumbnail_src[0] ) . '" class="js-slide p-1 bookworm-wc-product-gallery__image">' . '<a class="position-relative d-inline-block p-1" href="javascript:;">' . $image . '</a>' . '</div>';
    }
}


if ( ! function_exists( 'bookworm_wc_product_rating_author_info' ) ) {
    function bookworm_wc_product_rating_author_info() {
        global $product; ?>
        <div class="rating-author_info font-size-2 mb-4 d-flex flex-wrap align-items-center">
            <?php if ( post_type_supports( 'product', 'comments' ) && wc_review_ratings_enabled() ) :
                $rating_count = $product->get_rating_count();
                $review_count = $product->get_review_count();
                if ( $rating_count > 0 ) : ?>
                        <a class="js-go-to bookworm-wc-star-rating mr-3 d-flex align-items-center" href="#reviews" rel="nofollow"
                        data-target="#reviews"
                        data-compensation="#header"
                        data-type="static">
                        <?php echo wc_get_rating_html( $product->get_average_rating(), $rating_count ) ?>
                        <span class="ml-3 d-inline-block text-dark">
                            (<?php printf( _n( '%s', '%s', $review_count, 'bookworm' ), esc_html( $review_count ) );?>)
                        </span>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
            <?php bookworm_wc_single_product_author(); ?>
        </div><?php
    }
}


if ( ! function_exists( 'bookworm_wc_single_product_author' ) ) {
    function bookworm_wc_single_product_author() {
        $author_name = bookworm_wc_get_product_author();
        if ( ! empty ( $author_name ) ) :
        ?><div class="d-flex align-items-center"><span class="font-weight-medium"><?php echo esc_html__('By (author)', 'bookworm');?></span><span class="ml-2 text-gray-600"><?php echo wp_kses_post( str_replace( '</a><a ', '</a>, <a ', $author_name ) ); ?></span></div><?php
        endif;
    }
}

if ( ! function_exists( 'bookworm_wc_template_slider_pagination' ) ) {
    function bookworm_wc_template_slider_pagination() {
        $version            = bookworm_get_single_product_version();
        if ( $version === 'v5') {
            return true;
        }
    }
}

if ( ! function_exists( 'bookworm_wc_product_video_tab' ) ) {
    function bookworm_wc_product_video_tab() {
        global $product;
        $product_id = $product->get_id();
        $videos = get_post_meta( $product_id, '_videos', true );

        
        if ( ! empty( $videos ) ) {
            if( bookworm_is_mas_static_content_activated() && ! empty( $static_block_id ) ) {
                $static_block = get_post( $static_block_id );
                $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
                echo '<div class="single-product-video-tab">' . apply_filters( 'the_content', $content ) . '</div>';
            } else {
                echo apply_filters( 'the_content', wp_kses_post( $videos ) );
            }
        }
    }
}

if ( ! function_exists( 'bookworm_wc_product_tabs' ) ) {
    function bookworm_wc_product_tabs( $tabs = array() ) {
        global $product;
        $product_id = $product->get_id();
        $videos = get_post_meta( $product_id, '_videos', true );
        if ( ! empty( $videos ) && apply_filters( 'bookworm_wc_product_enable_video_tab', true ) ) {
            $tabs['videos'] = array(
                'title'    => esc_html__( 'Videos', 'bookworm' ),
                'priority' => 25,
                'callback' => 'bookworm_wc_product_video_tab',
            );
        }

        return $tabs;
    }
}

if ( ! function_exists( 'bookworm_wc_dropdown_variation_attribute_options_args' ) ) {
    function bookworm_wc_dropdown_variation_attribute_options_args( $args = array() ) { 
        $args['class']='font-size-2 text-dark';
        return $args; 
    }
}

// Utility function to get the price of a variation from it's attribute value
function get_the_variation_price_html( $product, $name, $term_slug ){
    foreach ( $product->get_available_variations() as $variation ){
        if($variation['attributes'][$name] == $term_slug ){
            return strip_tags( $variation['price_html'] );
        }
    }
}

if ( ! function_exists( 'bookworm_show_price_in_attribute_dropdown' ) ) {
    function bookworm_show_price_in_attribute_dropdown( $html, $args ) {
        // Only if there is a unique variation attribute (one dropdown)
        if( sizeof($args['product']->get_variation_attributes()) == 1 && apply_filters( 'bookworm_is_show_price_in_attribute_dropdown' , true ) ) :

        $options               = $args['options'];
        $product               = $args['product'];
        $attribute             = $args['attribute'];
        $name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
        $id                    = $args['id'] ? $args['id'] : sanitize_title( $attribute );
        $class                 = $args['class'];
        $show_option_none      = $args['show_option_none'] ? true : false;
        $show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : esc_html__( 'Choose an option', 'bookworm' );

        if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
            $attributes = $product->get_variation_attributes();
            $options    = $attributes[ $attribute ];
        }

        $html = '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
        $html .= '<option value="">' . esc_html( $show_option_none_text ) . '</option>';

        if ( ! empty( $options ) ) {
            if ( $product && taxonomy_exists( $attribute ) ) {
                $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

                foreach ( $terms as $term ) {
                    if ( in_array( $term->slug, $options ) ) {
                        // Get and inserting the price
                        $price_html = get_the_variation_price_html( $product, $name, $term->slug );
                        $html .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) . ' ' . $price_html ) . '</option>';
                    }
                }
            } else {
                foreach ( $options as $option ) {
                    $selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
                    // Get and inserting the price
                    $price_html = get_the_variation_price_html( $product, $name, $term->slug );
                    $html .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) . '' . $price_html ) . '</option>';
                }
            }
        }
        $html .= '</select>';

        endif;

        return $html;
    }

}


if ( ! function_exists( 'bookworm_single_product_static_content' ) ) {
    function bookworm_single_product_static_content() {
        if ( apply_filters( 'bookworm_enable_single_product_content' , true )) :

            $static_block_id = apply_filters( 'bookworm_single_product_jumbotron_id', get_theme_mod( 'bookworm_wc_single_product_jumbotron', '' ) ); 

            if( bookworm_is_mas_static_content_activated() && ! empty( $static_block_id ) ) {
                $static_block = get_post( $static_block_id );
                $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
                echo '<div class="single-product-jumbotron">' . apply_filters( 'the_content', $content ) . '</div>';
            }
        
        endif; 
    }
}

if ( ! function_exists( 'bookworm_single_product_v3_wishlist_share_wrapper_start' ) ) {
    function bookworm_single_product_v3_wishlist_share_wrapper_start() { ?>
        <div class="wishlist-share-wrap"><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_v3_closing_div' ) ) {
    function bookworm_single_product_v3_closing_div() { ?>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_wishlist_share_wrap_start' ) ) {
    function bookworm_single_product_wishlist_share_wrap_start() { ?>
        <div class="wishlist-share-wrap d-block d-md-flex justify-content-center"><?php
    }
}

if ( ! function_exists( 'bookworm_single_product_wishlist_share_wrap_end' ) ) {
    function bookworm_single_product_wishlist_share_wrap_end() { ?>
        </div><?php
    }
}



if ( ! function_exists( 'bookworm_single_product_v3_cart_wrapper_start' ) ) {
    function bookworm_single_product_v3_cart_wrapper_start() { ?>
        <div class="cart-form-wrap"><?php
    }
}


if ( ! function_exists( 'bookworm_output_related_products_args' ) ) {
    function bookworm_output_related_products_args( $args ) {

        $args = array(
            'posts_per_page' => 8,
            'columns'        => apply_filters( 'bookworm_related_products_columns', 5 )
        );
        return $args;
    }
}

if ( ! function_exists( 'bookworm_single_product_jumbotron' ) ) {
    function bookworm_single_product_jumbotron() {
        $static_block_id = apply_filters( 'bookworm_single_product_jumbotron_id', get_theme_mod( 'bookworm_wc_single_productjumbotron', '' ) ); 

        if( bookworm_is_mas_static_content_activated() && ! empty( $static_block_id ) ) {
            $static_block = get_post( $static_block_id );
            $content = isset( $static_block->post_content ) ? $static_block->post_content : '';
            echo '<div class="position-relative mb-6">' . apply_filters( 'the_content', $content ) . '</div>';
        }
    }
}

if ( ! function_exists( 'bookworm_wc_quantity_input_classes' ) ) {
    function bookworm_wc_quantity_input_classes( $classes, $product ) {
        $classes[] = 'js-result';
        return $classes;
    }
}


if ( ! function_exists( 'bookworm_display_quantity_plus' ) ) {
    function bookworm_display_quantity_plus() { 
        global $product;
        $min_value = apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product );
        $max_value = apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product );

        if ( $max_value && $min_value === $max_value ) {
            return;
        } ?>

        <a class="js-minus text-dark">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="10px" height="1px">
                <path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M-0.000,-0.000 L10.000,-0.000 L10.000,1.000 L-0.000,1.000 L-0.000,-0.000 Z"></path>
            </svg>
        </a><?php
    }
}

if ( ! function_exists( 'bookworm_display_quantity_minus' ) ) {
    function bookworm_display_quantity_minus() { 
        global $product;
        $min_value = apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product );
        $max_value = apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product );

        if ( $max_value && $min_value === $max_value ) {
            return;
        } ?>
    
        <a class="js-plus text-dark" href="javascript:;">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="10px" height="10px">
                <path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M10.000,5.000 L6.000,5.000 L6.000,10.000 L5.000,10.000 L5.000,5.000 L-0.000,5.000 L-0.000,4.000 L5.000,4.000 L5.000,-0.000 L6.000,-0.000 L6.000,4.000 L10.000,4.000 L10.000,5.000 Z"></path>
            </svg>
        </a><?php
    }
}

if ( ! function_exists( 'bookworm_display_quantity_wrap_open' ) ) {
    function bookworm_display_quantity_wrap_open() { 
        global $product;
        $min_value = apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product );
        $max_value = apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product );

        if ( $max_value && $min_value === $max_value ) {
            return;
        } ?>

        <div class="position-relative quantity-wrap js-quantity"><?php
    }
}

if ( ! function_exists( 'bookworm_display_quantity_wrap_close' ) ) {
    function bookworm_display_quantity_wrap_close() { 
        global $product;
        $min_value = apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product );
        $max_value = apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product );

        if ( $max_value && $min_value === $max_value ) {
            return;
        } ?>

        </div><?php
    }
}
