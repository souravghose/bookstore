<?php
/**
 * Template Functions for Footer v9 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_footer_widgets_v9' ) ) {
    function bookworm_footer_widgets_v9() {
        bookworm_footer_widgets( 'bg-dark space-2 space-lg-3 ', 'col-lg-4 mb-4 mb-md-0', 'pb-md-6' );
    }
}


if ( ! function_exists( 'bookworm_site_info_v9' ) ) {
    function bookworm_site_info_v9() {
        bookworm_site_info( 'space-1 bg-dark border-top border-gray-810', 'd-lg-flex text-center text-lg-left justify-content-between align-items-center', 'mb-3 mb-lg-0 font-size-2 text-gray-500', 'd-lg-flex justify-content-xl-end align-items-center' );
    }
}

