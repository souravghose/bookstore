<?php
/**
 * Template Functions for Footer v3 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_footer_widgets_v3' ) ) {
    function bookworm_footer_widgets_v3() {
        bookworm_footer_widgets( 'pb-5 space-bottom-lg-3', 'col-lg-4 mb-6 mb-lg-0', 'pb-md-6' );
    }
}


if ( ! function_exists( 'bookworm_site_info_v3' ) ) {
    function bookworm_site_info_v3() {
        bookworm_site_info( 'space-1 border-top border-gray-210', 'd-lg-flex text-center text-lg-left justify-content-between align-items-center', 'mb-3 mb-lg-0 font-size-2', 'ml-auto d-lg-flex justify-content-xl-end align-items-center' );
    }
}

