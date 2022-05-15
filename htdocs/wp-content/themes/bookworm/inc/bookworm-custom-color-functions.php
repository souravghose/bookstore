<?php
/**
 * Bookworm Theme Customizer
 *
 * @package Bookworm
 */

if ( ! function_exists( 'bookworm_sass_hex_to_rgba' ) ) {
	function bookworm_sass_hex_to_rgba( $hex, $alpa = '' ) {
		$hex = sanitize_hex_color( $hex );
		preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $matches);
		for($i = 1; $i <= 3; $i++) {
			$matches[$i] = hexdec($matches[$i]);
		}
		if( !empty( $alpa ) ) {
			$rgb = 'rgba(' . $matches[1] . ', ' . $matches[2] . ', ' . $matches[3] . ', ' . $alpa .')';
		} else {
			$rgb = 'rgba(' . $matches[1] . ', ' . $matches[2] . ', ' . $matches[3] . ')';
		}
		return $rgb;
	}
}

if ( ! function_exists( 'bookworm_sass_yiq' ) ) {
	function bookworm_sass_yiq( $hex ) {
		$hex = sanitize_hex_color( $hex );
		$length = strlen( $hex );
		if( $length < 5 ) {
			$hex = ltrim($hex,"#");
			$hex = '#' . $hex . $hex;
		}

		preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $matches);

		for($i = 1; $i <= 3; $i++) {
			$matches[$i] = hexdec($matches[$i]);
		}
		$yiq = (($matches[1]*299)+($matches[2]*587)+($matches[3]*114))/1000;
		return ($yiq >= 128) ? '#000' : '#fff';
	}
}

/**
 * Get all of the bookworm theme colors.
 *
 * @return array $bookworm_theme_colors The bookworm Theme Colors.
 */
if( ! function_exists( 'bookworm_get_theme_colors' ) ) {
	function bookworm_get_theme_colors() {
		$bookworm_theme_colors = array(
			'primary_color'     => get_theme_mod( 'bookworm_primary_color', apply_filters( 'bookworm_default_primary_color', '#f75454' ) ),
			
			'secondary_color'   => get_theme_mod( 'bookworm_secondary_color', apply_filters( 'bookworm_default_secondary_color', '#161619' ) ),

			'gray_color'        => get_theme_mod( 'bookworm_gray_color', apply_filters( 'bookworm_default_gray_color', '#fff6f6' ) ),

		);

		return apply_filters( 'bookworm_get_theme_colors', $bookworm_theme_colors );
	}
}

/**
 * Get Customizer Color css.
 *
 * @see bookworm_get_custom_color_css()
 * @return array $styles the css
 */
if( ! function_exists( 'bookworm_get_custom_color_css' ) ) {
	function bookworm_get_custom_color_css() {
		$bookworm_theme_colors = bookworm_get_theme_colors();

		$primary_color = $bookworm_theme_colors['primary_color'];
		$primary_color_yiq = bookworm_sass_yiq( $primary_color );
		$primary_color_darken_10p = bookworm_adjust_color_brightness( $primary_color, -10 );
		$primary_color_darken_15p = bookworm_adjust_color_brightness( $primary_color, -15 );
		$primary_color_lighten_20p = bookworm_adjust_color_brightness( $primary_color, 20 );

		$secondary_color = $bookworm_theme_colors['secondary_color'];
		$secondary_color_yiq = bookworm_sass_yiq( $secondary_color );
		$secondary_color_darken_7p = bookworm_adjust_color_brightness( $secondary_color, -7 );
		$secondary_color_darken_10p = bookworm_adjust_color_brightness( $secondary_color, -10 );
		$secondary_color_darken_15p = bookworm_adjust_color_brightness( $secondary_color, -15 );

		$gray_color = $bookworm_theme_colors['gray_color'];
		$gray_color_yiq = bookworm_sass_yiq( $gray_color );



		$styles = 
'
/*
 * Primary Color
 */


.vertical-menu  .dropdown-toggle:hover,
.vertical-menu  .dropdown-toggle.active,
.select-hover:hover,
.text-primary,
.single-product .summary .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a, 
.single-product .summary .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
.has-primary-color   {
    color: ' . $primary_color . ' !important;
}

a,
footer .bootstrap-select .dropdown-menu .dropdown-item:hover,
.topbar .dropdown-menu .dropdown-item:hover,
.list-group .active > .list-group-item,
.list-group-flush .list-group-item.active,
.shop_table.cart tbody .product-name a:not(.d-block):hover,
.h-primary:hover,
.widget-content > ul a:hover, 
.widget-content > ul a:focus, 
footer .widget > ul a:hover, 
footer .widget > ul a:focus, 
.blog-sidebar .widget > ul a:hover, 
.blog-sidebar .widget > ul a:focus, 
.widget-area .widget > ul a:hover, 
.widget-area .widget > ul a:focus,
.btn-outline-primary, 
.single-product .related.products .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a, 
.single-product .related.products .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a, 
.single-product .upsells.products .yith-wcwl-add-to-wishlist a,
.widget_nav_menu .menu a:hover,
.sub-menu a:hover,
.widget_nav_menu .menu a:focus,
.sub-menu a:focus,
.widget-content > ul a:hover,
footer .widget > ul a:hover,
.blog-sidebar .widget > ul a:hover,
.widget-area .widget > ul a:hover,
.widget-content > ul a:focus,
footer .widget > ul a:focus,
.blog-sidebar .widget > ul a:focus,
.widget-area .widget > ul a:focus,
.site-footer_v5-alt .widget > ul a:hover, 
.site-footer_v5-alt .widget > ul a:focus, 
.site-footer_v5-alt .widget .menu a:hover, 
.site-footer_v5-alt .widget .menu a:focus, 
.site-footer_v5-alt .widget .sub-menu a:hover, 
.site-footer_v5-alt .widget .sub-menu a:focus,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:not(:hover),
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:not(:hover),
.products .product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:not(:hover),
.products .product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:not(:hover),
.product__hover  .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:not(:hover),
.product__hover  .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:not(:hover) {
	color: ' . $primary_color . ';
}

a:hover,
h1 > a:hover, h2 > a:hover, 
h3 > a:hover, h4 > a:hover, 
h5 > a:hover, h6 > a:hover, 
.h1 > a:hover, .h2 > a:hover, 
.h3 > a:hover, .h4 > a:hover, 
.h5 > a:hover, .h6 > a:hover {
	color: ' . $primary_color_darken_15p . ';
}

.add-to-compare-link:hover,
.add-to-compare-link:focus,
.sidebar .widget.widget_rating_filter .widget-content ul li.chosen a:before,
.btn-outline-primary:hover, 
.single-product .related.products .yith-wcwl-add-to-wishlist a:hover, 
.single-product .upsells.products .yith-wcwl-add-to-wishlist a:hover, 
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover, 
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover,
.progress-bar,
.btn-primary:disabled,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,
.product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:focus,
.product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:focus,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:not(:disabled):not(.disabled):active,
.product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:not(:disabled):not(.disabled):active,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:not(:disabled):not(.disabled):active,
.product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:not(:disabled):not(.disabled):active,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover,
.products .product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,
.products .product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover,
.products .product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover,
.product__hover  .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,
.product__hover  .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover,
.product__hover  .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover {
	background: ' . $primary_color . ';
	color: ' . $primary_color_yiq . ';
}

.btn-primary,
.single-product .related.products .yith-wcwl-add-to-wishlist a:not(:disabled):not(.disabled):active,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:not(:disabled):not(.disabled):active {
    background-color: ' . $primary_color . ';
}

.bg-primary ,
.has-primary-background-color{
	background-color: ' . $primary_color . ' !important;
}

.progress {
	background-color: ' . $primary_color_lighten_20p . ';
}

.add-to-compare-link:hover,
.add-to-compare-link:focus,
.sidebar .widget.widget_rating_filter .widget-content ul li.chosen a:before,
.btn-outline-primary, 
.single-product .related.products .yith-wcwl-add-to-wishlist a, 
.single-product .upsells.products .yith-wcwl-add-to-wishlist a, 
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a, 
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
.btn-outline-primary:hover, 
.single-product .related.products .yith-wcwl-add-to-wishlist a:hover, 
.single-product .upsells.products .yith-wcwl-add-to-wishlist a:hover, 
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover, 
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover,
.btn-primary,
.single-product .related.products .yith-wcwl-add-to-wishlist a:not(:disabled):not(.disabled):active,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:not(:disabled):not(.disabled):active,
.btn-primary:disabled,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,
.product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:focus,
.product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:focus,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:not(:disabled):not(.disabled):active,
.product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:not(:disabled):not(.disabled):active,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:not(:disabled):not(.disabled):active,
.product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:not(:disabled):not(.disabled):active,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
.products .product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a,
.products .product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
.products .product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
.product__hover  .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a,
.product__hover  .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
.product__hover  .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover,
.products .product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,
.products .product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover,
.products .product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover,
.product__hover  .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:hover,
.product__hover  .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover,
.product__hover  .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover {
	border-color: ' . $primary_color . ';
}

.products .product__space-primary:hover {
	border-color: ' . $primary_color . ' !important;
}

.zeynep ul > li > a:not(.btn):hover {
	background-color: ' . bookworm_sass_hex_to_rgba( $primary_color, '.04' ) . ';
}

.zeynep .submenu-header {
	background-color: ' . bookworm_sass_hex_to_rgba( $primary_color, '.1' ) . ';
}

.btn-outline-primary {
	color: ' . $primary_color . ';
	border-color:  ' . $primary_color . ';
}
.fill-primary {
    fill:  ' . $primary_color . ';
}

.btn-primary:hover,
.btn-primary:not(:disabled):not(.disabled):active, 
.btn-primary:not(:disabled):not(.disabled).active,
.show > .btn-primary.dropdown-toggles,
.btn-primary:focus {
	background-color: ' . $primary_color_darken_15p . ';
	border-color: ' . $primary_color_darken_15p . ';
}

.btn-outline-primary:not(:disabled):not(.disabled):active, 
.btn-outline-primary:not(:disabled):not(.disabled).active,
 .show > .btn-outline-primary.dropdown-toggle {
 	background-color: ' . $primary_color . ';
	border-color: ' . $primary_color . ';
 }

.btn-primary:not(:disabled):not(.disabled):active:focus, 
.btn-primary:not(:disabled):not(.disabled).active:focus, 
.show > .btn-primary.dropdown-toggle:focus,
.btn-primary:focus,
.btn-outline-primary:focus,
.btn-outline-primary:not(:disabled):not(.disabled):active:focus,
.btn-outline-primary:not(:disabled):not(.disabled).active:focus, 
.show > .btn-outline-primary.dropdown-toggle:focus,
.single-product .related.products .yith-wcwl-add-to-wishlist a:focus,
.single-product .related.products .yith-wcwl-add-to-wishlist a:not(:disabled):not(.disabled):active:focus,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:focus,
.product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:focus,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:not(:disabled):not(.disabled):active:focus,
.product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:not(:disabled):not(.disabled):active:focus,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:focus,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:focus,
ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:focus,
.products .product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:focus,
.products .product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:focus,
.products .product__hover .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:focus,
.product__hover  .yith-wcwl-add-to-wishlist .yith-wcwl-add-button a:focus,
.product__hover  .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:focus,
.product__hover  .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:focus {
	box-shadow: 0 0 0 0.2rem ' . bookworm_sass_hex_to_rgba( $primary_color, '0.5' ) . ';

}

/*
 * Secondary Color
 */

.btn-outline-dark {
    color: ' . $secondary_color . ';
}

.has-secondary-color { color: ' . $secondary_color . ' !important; }
.has-secondary-background-color { background-color: ' . $secondary_color . ' !important; }

.site-footer--v1 .footer-before-content div.wpforms-container-full .wpforms-form button[type="submit"], 
.site-footer_v3 .footer-before-content div.wpforms-container-full .wpforms-form button[type="submit"], .site-footer_v5.site-footer_v6-alt .footer-before-content div.wpforms-container-full .wpforms-form button[type="submit"], .site-footer_v8 .footer-before-content div.wpforms-container-full .wpforms-form button[type="submit"], 
.site-footer_v10 .footer-before-content div.wpforms-container-full .wpforms-form button[type="submit"], .site-footer_v9.bg-punch-light .footer-before-content div.wpforms-container-full .wpforms-form button[type="submit"],
.btn-dark, 
.woocommerce-MyAccount-content .button, 
.single_add_to_cart_button, 
.yith-wcwl-form.wishlist-fragment .hidden-title-form input[type="submit"], 
.wp-block-button .wp-block-button__link,
.badge-primary-home-v3,
.disabled.single_add_to_cart_button {
	background: ' . $secondary_color . ';
	color: ' . $secondary_color_yiq . ';
}

.pagination .page-item.active .page-link,
.btn-dark,
.btn-outline-dark:hover,
.u-slick__arrow:hover,
.pagination .page-item .page-link:hover,
.single_add_to_cart_button:not(:hover), 
.yith-wcwl-form.wishlist-fragment .hidden-title-form input:not(:hover)[type="submit"], 
.woocommerce-MyAccount-content .button:not(:hover), 
.wp-block-button .wp-block-button__link:not(:hover), 
#wpsl-wrap .wpsl-search input:not(:hover)[type="submit"] {
	background-color: ' . $secondary_color . ';
	color: ' . $secondary_color_yiq . ';
}

.bg-dark,
.widget_price_filter .price_slider_amount .button {
	background-color: ' . $secondary_color . ' !important;
	color: ' . $secondary_color_yiq . ';

}

.site-footer--v1 .footer-before-content div.wpforms-container-full .wpforms-form button[type="submit"], 
.site-footer_v3 .footer-before-content div.wpforms-container-full .wpforms-form button[type="submit"],
.site-footer_v5.site-footer_v6-alt .footer-before-content div.wpforms-container-full .wpforms-form button[type="submit"], .site-footer_v8 .footer-before-content div.wpforms-container-full .wpforms-form button[type="submit"], 
.site-footer_v10 .footer-before-content div.wpforms-container-full .wpforms-form button[type="submit"], .site-footer_v9.bg-punch-light .footer-before-content div.wpforms-container-full .wpforms-form button[type="submit"],
.pagination .page-item.active .page-link,
.btn-dark,
.products .product:not(.product__card):not(.product__no-border):not(.product__list):not(.product__space):hover,
.bk-tabs li.active a,
.btn-outline-dark:hover,
.u-slick__arrow:hover,
.woocommerce-MyAccount-content .button, 
.single_add_to_cart_button, 
.yith-wcwl-form.wishlist-fragment .hidden-title-form input[type="submit"], 
.wp-block-button .wp-block-button__link,
.woocommerce-MyAccount-content .button:hover,
.single_add_to_cart_button:hover, 
.yith-wcwl-form.wishlist-fragment .hidden-title-form input[type="submit"]:hover, 
.wp-block-button .wp-block-button__link:hover,
.pagination .page-item .page-link:hover,
footer .bootstrap-select .dropdown-menu,
.disabled.single_add_to_cart_button,
.single_add_to_cart_button:not(:hover), 
.yith-wcwl-form.wishlist-fragment .hidden-title-form input:not(:hover)[type="submit"], 
.woocommerce-MyAccount-content .button:not(:hover), 
.wp-block-button .wp-block-button__link:not(:hover), 
#wpsl-wrap .wpsl-search input:not(:hover)[type="submit"] {
	border-color: ' . $secondary_color . ';
}

.btn-dark:hover,
.btn-dark:focus,
.woocommerce-MyAccount-content .button:hover,
.single_add_to_cart_button:hover, 
.yith-wcwl-form.wishlist-fragment .hidden-title-form input[type="submit"]:hover, 
.wp-block-button .wp-block-button__link:hover,
.btn-dark:not(:disabled):not(.disabled):active,
.woocommerce-MyAccount-content .focus.button, 
.focus.single_add_to_cart_button, 
.yith-wcwl-form.wishlist-fragment .hidden-title-form input.focus[type="submit"], 
.wp-block-button .focus.wp-block-button__link,

.btn-dark:not(:disabled):not(.disabled):active, 
.woocommerce-MyAccount-content .button:not(:disabled):not(.disabled):active, .single_add_to_cart_button:not(:disabled):not(.disabled):active, 
.yith-wcwl-form.wishlist-fragment .hidden-title-form input:not(:disabled):not(.disabled):active[type="submit"], 
.wp-block-button .wp-block-button__link:not(:disabled):not(.disabled):active, 
.btn-dark:not(:disabled):not(.disabled).active,
 .woocommerce-MyAccount-content .button:not(:disabled):not(.disabled).active, .single_add_to_cart_button:not(:disabled):not(.disabled).active, 
 .yith-wcwl-form.wishlist-fragment .hidden-title-form input:not(:disabled):not(.disabled).active[type="submit"], 
 .wp-block-button .wp-block-button__link:not(:disabled):not(.disabled).active, 
 .show > .btn-dark.dropdown-toggle, 
 .woocommerce-MyAccount-content .show > .dropdown-toggle.button, 
 .show > .dropdown-toggle.single_add_to_cart_button, 
 .yith-wcwl-form.wishlist-fragment .hidden-title-form .show > input.dropdown-toggle[type="submit"], 
 .wp-block-button .show > .dropdown-toggle.wp-block-button__link {
	background-color: ' . $secondary_color_darken_7p . ';
	color: ' . $secondary_color_yiq . ';
}

.btn-dark:hover,
.btn-dark:focus,
.btn-outline-dark,
.btn-dark:not(:disabled):not(.disabled):active,
.woocommerce-MyAccount-content .button:focus, 
.single_add_to_cart_button:focus, 
.yith-wcwl-form.wishlist-fragment .hidden-title-form input:focus[type="submit"], 
.wp-block-button .wp-block-button__link:focus, 
.woocommerce-MyAccount-content .focus.button, 
.focus.single_add_to_cart_button, 
.yith-wcwl-form.wishlist-fragment .hidden-title-form input.focus[type="submit"], 
.wp-block-button .focus.wp-block-button__link,

.btn-dark:not(:disabled):not(.disabled):active, 
.woocommerce-MyAccount-content .button:not(:disabled):not(.disabled):active, .single_add_to_cart_button:not(:disabled):not(.disabled):active, 
.yith-wcwl-form.wishlist-fragment .hidden-title-form input:not(:disabled):not(.disabled):active[type="submit"], 
.wp-block-button .wp-block-button__link:not(:disabled):not(.disabled):active, 
.btn-dark:not(:disabled):not(.disabled).active,
 .woocommerce-MyAccount-content .button:not(:disabled):not(.disabled).active, .single_add_to_cart_button:not(:disabled):not(.disabled).active, 
 .yith-wcwl-form.wishlist-fragment .hidden-title-form input:not(:disabled):not(.disabled).active[type="submit"], 
 .wp-block-button .wp-block-button__link:not(:disabled):not(.disabled).active, 
 .show > .btn-dark.dropdown-toggle, 
 .woocommerce-MyAccount-content .show > .dropdown-toggle.button, 
 .show > .dropdown-toggle.single_add_to_cart_button, 
 .yith-wcwl-form.wishlist-fragment .hidden-title-form .show > input.dropdown-toggle[type="submit"], 
 .wp-block-button .show > .dropdown-toggle.wp-block-button__link {
	border-color: ' . $secondary_color_darken_7p . ';
}

.products .product:not(.product__card):not(.product__no-border):not(.product__list):not(.product__space):hover::after, 
.products .product:not(.product__card):not(.product__no-border):not(.product__list):not(.product__space):hover::before,
.u-slick__pagination li.slick-active span,
.widget_price_filter .ui-slider .ui-slider-handle,
.widget_price_filter .ui-slider .ui-slider-range {
	background-color: ' . $secondary_color . ';
}


.btn-dark.focus,
.btn-dark:not(:disabled):not(.disabled):active,
.woocommerce-MyAccount-content .button:focus, 
.single_add_to_cart_button:focus,
.yith-wcwl-form.wishlist-fragment .hidden-title-form input:focus[type="submit"], 
.wp-block-button .wp-block-button__link:focus,  
.woocommerce-MyAccount-content .focus.button, 
.focus.single_add_to_cart_button, 
.yith-wcwl-form.wishlist-fragment .hidden-title-form input.focus[type="submit"], 
.wp-block-button .focus.wp-block-button__link {
	box-shadow: 0 0 0 0.2rem ' . bookworm_sass_hex_to_rgba( $secondary_color, '0.5' ) . ';
}

.border-gray-900{
	border-color: ' . $secondary_color . ' !important;
}

.u-slick__pagination li.slick-active {
	border: 2px solid ' . $secondary_color . ' !important;

}

.bg-black {
	background-color: ' . $secondary_color_darken_10p . ';
	color:  ' . $secondary_color_yiq . ';
}

/*
 * Gray Color
 */
.bg-gray-200 {
	background-color: ' . $gray_color . ';
}

.bg-punch-light,
.bg-focus__1:focus {
	background-color: ' . $gray_color . ' !important;
}


';

		return apply_filters( 'bookworm_get_custom_color_css', $styles );
	}
}


/**
 * Add CSS in <head> for styles handled by the theme customizer
 *
 * @since 1.0.0
 * @return void
 */
if( ! function_exists( 'bookworm_enqueue_custom_color_css' ) ) {
	function bookworm_enqueue_custom_color_css() {
		if( get_theme_mod( 'bookworm_enable_custom_color', 'no' ) === 'yes' ) {
			$bookworm_theme_colors = bookworm_get_theme_colors();
			$color_root = ':root { --primary: ' . $bookworm_theme_colors['primary_color'] . '; --secondary: ' . $bookworm_theme_colors['secondary_color'] . '; --gray: ' . $bookworm_theme_colors['gray_color'] . '; }';
			$styles = $color_root . bookworm_get_custom_color_css();

			

			wp_add_inline_style( 'bookworm-color', $styles );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'bookworm_enqueue_custom_color_css', 130 );

if( ! function_exists( 'bookworm_enqueue_block_editor_panel_custom_color_css' ) ) {
	function bookworm_enqueue_block_editor_panel_custom_color_css() {
		if( get_theme_mod( 'bookworm_enable_custom_color', 'no' ) === 'yes' ) {
			$bookworm_theme_colors = bookworm_get_theme_colors();
			$color_root = ':root { --primary: ' . $bookworm_theme_colors['primary_color'] . '; --secondary: ' . $bookworm_theme_colors['secondary_color'] . '; --gray: ' . $bookworm_theme_colors['gray_color'] . ';}';
			$editor_styles =
'
.components-panel__body > .components-panel__body-title svg.components-panel__icon {
	color: ' . $bookworm_theme_colors['primary_color'] . ';
}

svg.bwgb-bookwormgb-icon-gradient {
	fill: ' . $bookworm_theme_colors['primary_color'] . ' !important;
}

.components-circular-option-picker .components-button[aria-label="Color: Primary"],
.components-circular-option-picker .components-button.is-pressed[aria-label="Color: Primary"] {
	color: ' . $bookworm_theme_colors['primary_color'] . ' !important;
}


.editor-color-palette-control .component-color-indicator[aria-label$="Primary)"] {
	background: ' . $bookworm_theme_colors['primary_color'] . ' !important;
}

.editor-styles-wrapper .bg-primary {
	background-color: ' . $bookworm_theme_colors['primary_color'] . ' !important;

}

.editor-styles-wrapper .btn-primary:disabled{
	background-color: ' . $bookworm_theme_colors['primary_color'] . ';
	border-color: ' . $bookworm_theme_colors['primary_color'] . ';
}

.edit-post-header .components-button[aria-label="Bookworm Options"].is-pressed,
.edit-post-header .components-button[aria-label="Bookworm Options"].is-pressed:focus,
.edit-post-header .components-button[aria-label="Bookworm Options"].is-pressed:hover {
	background: ' . $bookworm_theme_colors['primary_color'] . ' !important;
}
';
			$styles = $color_root . $editor_styles;
		
			wp_add_inline_style( 'bwgb-style-css', $styles );
		}
	}
}
add_action( 'enqueue_block_assets', 'bookworm_enqueue_block_editor_panel_custom_color_css', 30  );

if( ! function_exists( 'bookworm_enqueue_block_editor_primary_custom_color' ) ) {
	function bookworm_enqueue_block_editor_primary_custom_color( $color ) {
		if( get_theme_mod( 'bookworm_enable_custom_color', 'no' ) === 'yes' ) {
			$bookworm_theme_colors = bookworm_get_theme_colors();
			$color = $bookworm_theme_colors['primary_color'];
		}

		return $color;
	}
}


add_filter( 'bookworm_editor_primary_color', 'bookworm_enqueue_block_editor_primary_custom_color', 10  );

if( ! function_exists( 'bookworm_enqueue_block_editor_secondary_custom_color' ) ) {
	function bookworm_enqueue_block_editor_secondary_custom_color( $color ) {
		if( get_theme_mod( 'bookworm_enable_custom_color', 'no' ) === 'yes' ) {
			$bookworm_theme_colors = bookworm_get_theme_colors();
			$color = $bookworm_theme_colors['secondary_color'];
		}

		return $color;
	}
}


add_filter( 'bookworm_editor_secondary_color', 'bookworm_enqueue_block_editor_secondary_custom_color', 10  );

if( ! function_exists( 'bookworm_enqueue_block_editor_gray_custom_color' ) ) {
	function bookworm_enqueue_block_editor_gray_custom_color( $color ) {
		if( get_theme_mod( 'bookworm_enable_custom_color', 'no' ) === 'yes' ) {
			$bookworm_theme_colors = bookworm_get_theme_colors();
			$color = $bookworm_theme_colors['gray_color'];
		}

		return $color;
	}
}


add_filter( 'bookworm_editor_gray_color', 'bookworm_enqueue_block_editor_gray_custom_color', 10  );


if( ! function_exists( 'bookworm_enqueue_block_editor_custom_color_css' ) ) {
	function bookworm_enqueue_block_editor_custom_color_css( $response, $parsed_args, $url ) {
		if ( content_url( '/custom_theme_color_css' ) === $url ) {
			$response = array(
				'body'		=> bookworm_get_custom_color_css(), // E.g. 'body { background-color: #fbca04; }'
				'headers' 	=> new Requests_Utility_CaseInsensitiveDictionary(),
				'response'	=> array(
					'code'		=> 200,
					'message'	=> 'OK',
				),
				'cookies'	=> array(),
				'filename'	=> null,
			);
		}
		
		return $response;
	}
}
add_filter( 'pre_http_request', 'bookworm_enqueue_block_editor_custom_color_css', 10, 3 );
