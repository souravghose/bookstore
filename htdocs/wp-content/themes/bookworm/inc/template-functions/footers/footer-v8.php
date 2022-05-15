<?php
/**
 * Template Functions for Footer v8 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_footer_widgets_v8' ) ) {
    function bookworm_footer_widgets_v8() {
        bookworm_footer_widgets( 'space-1 space-lg-3 bg-dark ', '', '' );
    }
}


if ( ! function_exists( 'bookworm_site_info_v8' ) ) {
    function bookworm_site_info_v8() {
        bookworm_site_info( 'py-4 bg-black', 'd-md-flex text-center text-md-left justify-content-between align-items-center', 'mb-3 mb-lg-0 font-size-2 text-gray-500', 'd-md-flex justify-content-md-end align-items-center' );
    }
}

