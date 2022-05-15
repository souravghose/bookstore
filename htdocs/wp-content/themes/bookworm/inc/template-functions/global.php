<?php
/**
 * Template functions used globally
 *
 */

if ( ! function_exists( 'bookworm_the_svg_plus' ) ) {
    function bookworm_the_svg_plus() {
        ?><svg class="plus" width="15px" height="15px"><path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M15.000,8.000 L9.000,8.000 L9.000,15.000 L7.000,15.000 L7.000,8.000 L0.000,8.000 L0.000,6.000 L7.000,6.000 L7.000,-0.000 L9.000,-0.000 L9.000,6.000 L15.000,6.000 L15.000,8.000 Z"></path></svg><?php
    }
}

if ( ! function_exists( 'bookworm_the_svg_minus' ) ) {
    function bookworm_the_svg_minus() {
        ?><svg class="mins" width="15px" height="2px"><path fill-rule="evenodd" fill="rgb(22, 22, 25)" d="M0.000,-0.000 L15.000,-0.000 L15.000,2.000 L0.000,2.000 L0.000,-0.000 Z"></path></svg><?php
    }
}

if ( ! function_exists( 'bookworm_collapse_toggler' ) ) {
    function bookworm_collapse_toggler() {
        bookworm_the_svg_minus();
        bookworm_the_svg_plus();
    }
}
