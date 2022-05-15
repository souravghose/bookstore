<?php
/**
 * Template functions used in WooCommerce Plugin Integrations
 *
 */

/**
 * Integrate plugin "YITH WooCommerce Compare" into the theme. 
 */

if ( ! function_exists( 'bookworm_add_compare_link' ) ) {
    function bookworm_add_compare_link( $product_id = false, $args = array() ) {
        extract( $args );
        global $yith_woocompare;

        if ( ! $product_id ) {
           global $product;
           $product_id = ! is_null( $product ) ? yit_get_prop( $product, 'id', true ) : 0;
        }

        // return if product doesn't exist
        if ( empty( $product_id ) || apply_filters( 'yith_woocompare_remove_compare_link_by_cat', false, $product_id ) )
           return;

        $is_button = ! isset( $button_or_link ) || ! $button_or_link ? get_option( 'yith_woocompare_is_button', 'button' ) : $button_or_link;

        if ( ! isset( $button_text ) || $button_text == 'default' ) {
           $button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Compare', 'bookworm' ) );
           do_action ( 'wpml_register_single_string', 'Plugins', 'plugin_yit_compare_button_text', $button_text );
           $button_text = apply_filters( 'wpml_translate_single_string', $button_text, 'Plugins', 'plugin_yit_compare_button_text' );
        }

        $button_text = '<i class="flaticon-switch"></i><span class="sr-only">' . $button_text . '</span>';

        printf( '<a href="%s" class="mr-1 h-p-bg btn btn-outline-primary border-0 %s" data-product_id="%d" rel="nofollow">%s</a>', $yith_woocompare->obj->add_product_url( $product_id ), 'add-to-compare-link' . ( $is_button == 'button' ? ' button' : '' ), $product_id, $button_text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}


function bookworm_add_compare_url_to_localize_data( $data ) {
        $data[ 'compare_page_url' ] = bookworm_get_compare_page_url();
        return $data;
    }


function bookworm_update_yith_compare_options( $options ) {
    
    foreach( $options['general'] as $key => $option ) {
      
      if( $option['id'] == 'yith_woocompare_auto_open' ) {
        $options['general'][$key]['std'] = 'no';
        $options['general'][$key]['default'] = 'no';
      }
    
    }
    
    return $options;
  }
  

if( ! function_exists( 'bookworm_get_compare_page_id' ) ) {
    /**
     * Gets page ID of product comparision page
     *
     * @return int
     */
     
    function bookworm_get_compare_page_id() {
        $compare_page_id = apply_filters( 'bookworm_product_comparison_page_id', get_theme_mod('compare_page_id', 0) );
        
        if( 0 !== $compare_page_id && function_exists( 'icl_object_id' ) ) {
            $compare_page_id = icl_object_id( $compare_page_id, 'page' );
        }

        return $compare_page_id;
    }
}

if( ! function_exists( 'bookworm_get_compare_page_url' ) ) {
    /**
     * Returns URL of Product Comparision Page
     *
     * @return string
     */
    function bookworm_get_compare_page_url() {
        $compare_page_id = bookworm_get_compare_page_id();
        $compare_page_url = '#';

        if( 0 !== $compare_page_id ) {
            $compare_page_url = get_permalink( $compare_page_id );
        }
        return $compare_page_url;
    }
}

/**
 * Integrate plugin "YITH WooCommerce Wishlist" into the theme. 
 */

if ( ! function_exists( 'bookworm_add_to_wishlist_button' ) ) {
  /**
   * Output the "Add to Wishlist" button.
   */
  function bookworm_add_to_wishlist_button() {
    echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
  }

}

