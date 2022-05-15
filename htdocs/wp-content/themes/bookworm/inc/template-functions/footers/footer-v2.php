<?php
/**
 * Template Functions for Footer v2 Template
 *
 * @package bookworm
 */
if ( ! function_exists( 'bookworm_footer_widgets_v2' ) ) {
    function bookworm_footer_widgets_v2() {
        bookworm_footer_widgets( 'pb-5 space-bottom-lg-3', '', '', '5' );
    }
}

if ( ! function_exists( 'bookworm_site_info_v2' ) ) {
    function bookworm_site_info_v2() {
        bookworm_site_info( 'space-1 border-top border-gray-750', 'd-lg-flex text-center text-lg-left justify-content-between align-items-center', 'mb-4 mb-lg-0 font-size-2 text-gray-450', 'ml-auto d-lg-flex justify-content-xl-end align-items-center' );
    }
}