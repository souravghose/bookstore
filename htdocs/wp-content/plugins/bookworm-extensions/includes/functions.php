<?php

// Register widgets.
function bookworm_widgets_register() {

    if ( class_exists( 'Bookworm' ) && class_exists( 'WooCommerce' ) ) {
        include_once BOOKWORM_EXTENSIONS_DIR . '/includes/widgets/class-bookworm-features-block-widget.php';
        register_widget( 'Bookworm_Features_Block_Widget' );
    }

    if ( class_exists( 'Bookworm' ) ) {
        include_once BOOKWORM_EXTENSIONS_DIR . '/includes/widgets/class-bookworm-recent-posts-widget.php';
        register_widget( 'Bookworm_Recent_Posts_Widget' );
        
    }
}

add_action( 'widgets_init', 'bookworm_widgets_register' );

add_action( 'woocommerce_before_single_product_summary',    'bookworm_before_wc_product_sale_flash', 9 );
add_action( 'woocommerce_before_single_product_summary',    'bookworm_after_wc_product_sale_flash', 11 );

if ( ! function_exists( 'bookworm_before_wc_product_sale_flash' ) ) {
    function bookworm_before_wc_product_sale_flash() {
        add_filter( 'woocommerce_sale_flash',   'bookworm_single_product_sale_flash', 20, 3 );
    }
}

if ( ! function_exists( 'bookworm_after_wc_product_sale_flash' ) ) {
    function bookworm_after_wc_product_sale_flash() {
        remove_filter( 'woocommerce_sale_flash',   'bookworm_single_product_sale_flash', 20, 3 );
    }
}

// Static Content Jetpack Share Remove
if ( ! function_exists( 'bookworm_mas_static_content_jetpack_sharing_remove_filters' ) ) {
    function bookworm_mas_static_content_jetpack_sharing_remove_filters() {
        if( function_exists( 'sharing_display' ) ) {
            remove_filter( 'the_content', 'sharing_display', 19 );
        }
    }
}

add_action( 'mas_static_content_before_shortcode_content', 'bookworm_mas_static_content_jetpack_sharing_remove_filters' );

if ( ! function_exists( 'bookworm_mas_static_content_jetpack_sharing_add_filters' ) ) {
    function bookworm_mas_static_content_jetpack_sharing_add_filters() {
        if( function_exists( 'sharing_display' ) ) {
            add_filter( 'the_content', 'sharing_display', 19 );
        }
    }
}

add_action( 'mas_static_content_after_shortcode_content', 'bookworm_mas_static_content_jetpack_sharing_add_filters' );

// Jetpack
if ( ! function_exists( 'bookworm_jetpack_sharing_remove_filters' ) ) {
    function bookworm_jetpack_sharing_remove_filters() {
        if( function_exists( 'sharing_display' ) ) {
            remove_filter( 'the_content', 'sharing_display', 19 );
            remove_filter( 'the_excerpt', 'sharing_display', 19 );
        }
    }
}

add_action( 'bookworm_single_post_before', 'bookworm_jetpack_sharing_remove_filters', 5 );
add_action( 'bookworm_before_page', 'bookworm_jetpack_sharing_remove_filters', 5 );


if ( ! function_exists( 'bookworm_jetpack_sharing_remove_filters' ) ) {
    function bookworm_jetpack_sharing_remove_filters() {
        if( function_exists( 'sharing_display' ) ) {
            remove_filter( 'the_content', 'sharing_display', 19 );
        }
    }
}

add_action( 'woocommerce_single_product_summary', 'bookworm_jetpack_sharing_remove_filters', 5 );



