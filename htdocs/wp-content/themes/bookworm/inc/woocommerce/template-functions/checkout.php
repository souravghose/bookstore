<?php
/**
 * Template functions used in Checkout
 */

if ( ! function_exists( 'bookworm_checkout_accordion_start' ) ) {
    function bookworm_checkout_accordion_start() {
        ?><div id="checkoutAccordion" class="border border-gray-900 bg-white border-bottom-0"><?php
    }
}

if ( ! function_exists( 'bookworm_checkout_accordion_end' ) ) {
    function bookworm_checkout_accordion_end() {
        ?></div><?php
    }
}

if ( ! function_exists( 'bookworm_wc_saved_payment_methods_html' ) ) {
    function bookworm_wc_saved_payment_methods_html( $html, $wc_payment_gateway ) {
        return str_replace( 'wc-saved-payment-methods', 'wc-saved-payment-methods list-unstyled', $html );
    }
}
