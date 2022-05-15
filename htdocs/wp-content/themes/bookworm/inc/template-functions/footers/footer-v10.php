<?php
/**
 * Template Functions for Footer v10 Template
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_footer_widgets_v10' ) ) {
    function bookworm_footer_widgets_v10() {
        bookworm_footer_widgets( 'border-bottom pb-5 space-bottom-lg-3', 'col-md-4', 'mb-5 mb-lg-0' );
    }
}


if ( ! function_exists( 'bookworm_site_info_v10' ) ) {
    function bookworm_site_info_v10() {
        bookworm_site_info( 'space-1', 'd-lg-flex text-center text-lg-left justify-content-between align-items-center', 'mb-3 mb-lg-0 font-size-2', 'd-md-flex align-items-md-baseline align-items-lg-center' );
    }
}

