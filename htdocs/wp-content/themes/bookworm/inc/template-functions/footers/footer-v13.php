<?php
/**
 * Template Functions for Footer v13 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_footer_widgets_v13' ) ) {
    function bookworm_footer_widgets_v13() {
        bookworm_footer_widgets( 'space-lg-2 border-top footer-widgets', '', '' );
    }
}


if ( ! function_exists( 'bookworm_site_info_v13' ) ) {
    function bookworm_site_info_v13() {
        bookworm_site_info( 'border-top py-4', 'd-md-flex text-center text-lg-left justify-content-between align-items-center', 'mb-3 mb-lg-0 font-size-2 text-gray-500', 'd-md-flex justify-content-end align-items-center' );
    }
}

