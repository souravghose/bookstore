<?php
/**
 * Bookworm engine room
 *
 * @package bookworm
 */

/**
 * Assign the MyTravel version to a var
 */
 $theme            = wp_get_theme( 'bookworm' );
 $bookworm_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}


$bookworm = (object) array(
	'version'    => $bookworm_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require get_template_directory()  . '/inc/class-bookworm.php',
	'customizer' => require get_template_directory()  . '/inc/customizer/class-bookworm-customizer.php',
);

require get_template_directory() . '/inc/bookworm-functions.php';
require get_template_directory() . '/inc/bookworm-template-hooks.php';
require get_template_directory() . '/inc/bookworm-template-functions.php';
require get_template_directory() . '/inc/wordpress-shims.php';

if ( bookworm_is_woocommerce_activated() ) {
	$bookworm->woocommerce            = require get_template_directory() . '/inc/woocommerce/class-bookworm-woocommerce.php';
	$bookworm->woocommerce_customizer = require get_template_directory() . '/inc/woocommerce/class-bookworm-woocommerce-customizer.php';

	require get_template_directory() . '/inc/woocommerce/bookworm-woocommerce-template-hooks.php';
	require get_template_directory() . '/inc/woocommerce/bookworm-woocommerce-template-functions.php';
	require get_template_directory() . '/inc/woocommerce/bookworm-woocommerce-functions.php';
}

if ( bookworm_is_wpsl_activated() ) {
    require get_template_directory() . '/inc/wpsl/bookworm-wpsl-functions.php';
}

if ( function_exists( 'bookworm_is_jetpack_activated' ) && bookworm_is_jetpack_activated() ) {
	require get_template_directory() . '/inc/jetpack/bookworm-jetpack-functions.php';
}

if ( bookworm_is_ocdi_activated() ) {
	require get_template_directory() . '/inc/ocdi/hooks.php';
	require get_template_directory() . '/inc/ocdi/functions.php';
}

/**
 * TGM Plugin Activation class.
 */
require get_template_directory() . '/inc/classes/class-tgm-plugin-activation.php';

/**
 * Bootstrap Nav Menu Walker
 */
require get_template_directory() . '/inc/classes/class-wp-bootstrap-navwalker.php';

/**
 * Offcanvas Nav Menu Walker
 */
require get_template_directory() . '/inc/classes/class-wp-offcanvas-navwalker.php';

/**
 * Custom Comment Walker template.
 */
require get_template_directory() . '/inc/classes/class-bookworm-walker-comment.php';

/**
 * Functions used for Bookworm Custom Theme Color
 */
require get_template_directory() . '/inc/bookworm-custom-color-functions.php';

define( 'CUSTOM_SIDEBAR_DISABLE_METABOXES', true );

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */
