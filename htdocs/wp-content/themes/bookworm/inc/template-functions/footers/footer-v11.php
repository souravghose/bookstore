<?php
/**
 * Template Functions for Footer v11 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_footer_widgets_v11' ) ) {
    function bookworm_footer_widgets_v11() {
        bookworm_footer_widgets( 'border-bottom pb-5 space-bottom-lg-3 ', 'col-lg-4 mb-6 mb-md-0', 'pb-md-6' );
    }
}


if ( ! function_exists( 'bookworm_site_info_v11' ) ) {
    function bookworm_site_info_v11() {
        bookworm_site_info( 'space-1', 'd-lg-flex text-center text-md-left justify-content-between align-items-center', 'mb-3 mb-lg-0 font-size-2', 'd-lg-flex justify-content-xl-end align-items-center' );
    }
}

