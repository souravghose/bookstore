<?php
/**
 * Template Functions for Footer v6 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_footer_widgets_v6' ) ) {
    function bookworm_footer_widgets_v6() {
        bookworm_footer_widgets( 'bg-dark space-bottom-3 space-top-2', 'col-md-4 col-lg-4', 'pb-6 pb-lg-0' );
    }
}


if ( ! function_exists( 'bookworm_site_info_v6' ) ) {
    function bookworm_site_info_v6() {
        bookworm_site_info( 'space-1 bg-black', 'text-center', 'mb-3 mb-lg-0 font-size-2 text-gray-500', '' );
    }
}

