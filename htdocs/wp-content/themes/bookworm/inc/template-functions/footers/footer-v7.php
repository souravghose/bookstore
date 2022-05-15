<?php
/**
 * Template Functions for Footer v7 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_footer_widgets_v7' ) ) {
    function bookworm_footer_widgets_v7() {
        bookworm_footer_widgets( 'space-1 space-lg-3 bg-gray-200 ', 'col-lg-4 mb-6 mb-lg-0', 'pb-6', '5' );
    }
}


if ( ! function_exists( 'bookworm_site_info_v7' ) ) {
    function bookworm_site_info_v7() {
        bookworm_site_info( 'space-1', 'd-lg-flex text-center text-lg-left justify-content-between align-items-center', 'mb-3 mb-lg-0 font-size-2', 'd-md-flex justify-content-xl-end align-items-center' );
    }
}

