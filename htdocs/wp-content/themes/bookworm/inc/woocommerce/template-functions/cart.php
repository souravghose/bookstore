<?php
/**
 * Template functions used in Cart
 *
 */
use Automattic\Jetpack\Constants;

if ( ! function_exists( 'bookworm_wc_empty_cart_message' ) ) {
    function bookworm_wc_empty_cart_message() {
        ?>
        <div class="font-weight-medium font-size-200 font-size-xs-170 text-lh-sm mt-xl-1"><i class="flaticon-shopping-bag"></i></div>
        <p class="cart-empty font-size-4 font-weight-medium mb-6">
            <?php echo wp_kses_post( apply_filters( 'wc_empty_cart_message', __( 'Your cart is currently empty.', 'bookworm' ) ) ); ?>
        </p><?php
    }
}

if ( ! function_exists( 'bookworm_cart_page_header' ) ) {
    function bookworm_cart_page_header() {
        $items_in_cart   = sprintf( _n( '%s item', '%s items', WC()->cart->get_cart_contents_count(), 'bookworm' ), WC()->cart->get_cart_contents_count() );
        $cart_page_title = sprintf( esc_html__( 'Your Cart: %s', 'bookworm' ), $items_in_cart );
        bookworm_the_page_header( $cart_page_title, array( 'page__header--cart' ) );
    }
}

if ( ! function_exists( 'bookworm_cart_item_author' ) ) {
    function bookworm_cart_item_author( $cart_item, $cart_item_key ) {
        $product_id  = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
        $author_name = bookworm_wc_get_product_author( $product_id, array( 'text-gray-700', 'font-size-2', 'd-block' ) );
        if ( ! empty( $author_name ) ) { ?>
            <span class="d-flex align-items-center mb-2">
                <?php echo wp_kses_post( str_replace( '</a><a ', '</a>, <a ', $author_name ) ); ?>
           </span><?php
        }
    }
}

if ( ! function_exists( 'bookworm_cart_link_fragment' ) ) {
    /**
     * Cart Fragments
     * Ensure cart contents update when products are added to the cart via AJAX
     *
     * @param  array $fragments Fragments to refresh via AJAX.
     * @return array            Fragments to refresh via AJAX
     */
    function bookworm_cart_link_fragment( $fragments ) {
        global $woocommerce;

        ob_start();
        bookworm_cart_page_header();
        $fragments['.page__header--cart'] = ob_get_clean();

        ob_start();
        bookworm_cart_link_count();
        $fragments['span.cart-contents-count'] = ob_get_clean();

        ob_start();
        bookworm_wc_offcanvas_mini_cart_content();
        $fragments['aside#offcanvasCart div.u-sidebar__body'] = ob_get_clean();

        $fragments['span.cart-contents-total'] = bookworm_cart_link_total_text();

        return $fragments;
    }
}

if ( ! function_exists( 'bookworm_wc_cart_totals_coupon_html' ) ) {
    function bookworm_wc_cart_totals_coupon_html( $coupon_html, $coupon, $discount_amount_html ) {

        $coupon_html = $discount_amount_html . ' <a href="' . esc_url( add_query_arg( 'remove_coupon', rawurlencode( $coupon->get_code() ), Constants::is_defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ) . '" class="woocommerce-remove-coupon position-absolute" data-coupon="' . esc_attr( $coupon->get_code() ) . '">' . esc_html__( '&times;', 'bookworm' ) . '</a>';
        return $coupon_html;
    }
}


if ( ! function_exists( 'bookworm_cart_wrapper_start' ) ) {
    function bookworm_cart_wrapper_start() {
        ?><div class="row pb-8">
            <div id="primary" class="content-area"><?php
    }
}

if ( ! function_exists( 'bookworm_cart_wrapper_end' ) ) {
    function bookworm_cart_wrapper_end() {
        ?></div><!-- /#primary --><?php
    }
}

if ( ! function_exists( 'bookworm_cart_collaterals_wrapper_start' ) ) {
    function bookworm_cart_collaterals_wrapper_start() {
        ?><div id="secondary" class="sidebar order-1"><?php
    }
}

if ( ! function_exists( 'bookworm_cart_collaterals_wrapper_end' ) ) {
    function bookworm_cart_collaterals_wrapper_end() {
            ?></div>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_output_cross_sell_products' ) ) {
    function bookworm_output_cross_sell_products() {
        if ( apply_filters( 'bookworm_enable_cross_sell_products', true ) ) {
            woocommerce_cross_sell_display( 4, 4 );
        }
    }
}