<?php
/**
 * Template Functions for Footer v4 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_footer_widgets_v4' ) ) {
    function bookworm_footer_widgets_v4() {
        bookworm_footer_widgets( 'pb-5 space-bottom-lg-3', '', '' );
    }
}


if ( ! function_exists( 'bookworm_site_info_v4' ) ) {
    function bookworm_site_info_v4() {
        bookworm_site_info( 'space-1 border-top border-gray-710', 'd-md-flex text-center text-md-left justify-content-between align-items-center', 'mb-3 mb-md-0 font-size-2 text-gray-450', 'd-md-flex justify-content-md-end align-items-center' );
    }
}

