<?php
/**
 * Template Functions for Footer v1 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_footer_widgets_v1' ) ) {
    function bookworm_footer_widgets_v1() {
        bookworm_footer_widgets( 'border-bottom pb-5 space-bottom-lg-3 space-top-3', 'col-lg-4 mb-6 mb-lg-0', 'pb-6' );
    }
}


if ( ! function_exists( 'bookworm_site_info_v1' ) ) {
    function bookworm_site_info_v1() {
        bookworm_site_info( 'space-1', 'd-lg-flex text-center text-lg-left justify-content-between align-items-center', 'mb-3 mb-lg-0 font-size-2', 'ml-auto d-lg-flex align-items-center' );
    }
}

