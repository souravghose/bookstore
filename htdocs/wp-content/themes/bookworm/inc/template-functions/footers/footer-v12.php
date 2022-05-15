<?php
/**
 * Template Functions for Footer v12 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_footer_widgets_v12' ) ) {
    function bookworm_footer_widgets_v12() {
        bookworm_footer_widgets( 'pb-5 space-bottom-lg-3', '', '6','5' );
    }
}


if ( ! function_exists( 'bookworm_site_info_v12' ) ) {
    function bookworm_site_info_v12() {
        bookworm_site_info( 'py-5 bg-gray-200', 'd-lg-flex text-center text-lg-left justify-content-between align-items-center', 'mb-3 mb-lg-0 font-size-2', 'd-lg-flex justify-content-xl-end align-items-center' );
    }
}

