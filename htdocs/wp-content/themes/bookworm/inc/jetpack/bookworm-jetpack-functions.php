<?php
/**
 * Bookworm jetpack functions.
 *
 * @package Bookworm
 */


if ( ! function_exists( 'bookworm_jetpack_sharing_filters' ) ) {
    function bookworm_jetpack_sharing_filters() {
        
        if ( apply_filters( 'bookworm_enable_bookworm_jetpack_sharing', true ) ) {
            $options = get_option( 'sharing-options' );
        
            if ( isset( $options['global']['button_style'] ) && ( 'icon' == $options['global']['button_style'] || 'icon-text' == $options['global']['button_style'] || 'text' == $options['global']['button_style'] ) ) {
                add_filter( 'jetpack_sharing_display_classes', 'bookworm_jetpack_sharing_display_classes', 10, 4 );
                add_filter( 'jetpack_sharing_headline_html', 'bookworm_jetpack_sharing_headline_html', 10, 3 );
            }
        }
    }
}


add_action( 'bookworm_single_post_before', 'bookworm_jetpack_sharing_filters', 5 );
add_action( 'woocommerce_before_single_product', 'bookworm_jetpack_sharing_filters', 5 );

if ( ! function_exists( 'bookworm_jetpack_sharing_display_classes' ) ) {
    function bookworm_jetpack_sharing_display_classes( $klasses, $sharing_source, $id, $args ) {
        if ( 'icon' == $sharing_source->button_style ) {
            if ( ( $key = array_search( 'sd-button', $klasses ) ) !== false ) {
                unset( $klasses[$key] );
            }

            $klasses[] = 'btn py-2 width-175 mb-3 mb-xl-0 mr-md-1 pr-1 text-white font-size-2';
            $klasses[] = 'bg-' . $sharing_source->shortname;

            if ( is_a( $sharing_source, 'Share_Custom' ) ) {
                return $klasses;
            }

            
        } elseif ( 'icon-text' == $sharing_source->button_style ) {
            if ( ( $key = array_search( 'sd-button', $klasses ) ) !== false ) {
                unset( $klasses[$key] );
            }

            $klasses[] = 'btn rounded-0 py-2 width-175 mb-3 mb-xl-0 mr-md-1 px-1 text-white font-size-2';
            $klasses[] = 'bg-' . $sharing_source->shortname;

            if ( is_a( $sharing_source, 'Share_Custom' ) ) {
                return $klasses;
            }

        } elseif ( 'text' == $sharing_source->button_style ) {
            if ( ( $key = array_search( 'sd-button', $klasses ) ) !== false ) {
                unset( $klasses[$key] );
            }

            $klasses[] = 'btn rounded-0 py-2 mb-3 mb-xl-0 mr-md-1 px-3 text-white font-size-2';
            $klasses[] = 'bg-' . $sharing_source->shortname;

            if ( is_a( $sharing_source, 'Share_Custom' ) ) {
                return $klasses;
            }

        }

        return $klasses;
    }
}

if ( ! function_exists( 'bookworm_jetpack_sharing_headline_html' ) ) {
    function bookworm_jetpack_sharing_headline_html( $heading_html, $sharing_label, $action ) {
        return '<span class="sharing-title font-size-2 text-gray-600 font-weight-normal ml-1 mr-md-3 mr-xl-5">%s</span>';    
    }
}

