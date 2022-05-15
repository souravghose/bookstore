<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bookworm
 */

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
	return;
}

?>
<div id="SidebarAccordion">
	<?php dynamic_sidebar( 'blog-sidebar' ); ?>
</div>
