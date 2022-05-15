<?php
/**
 * Template for displaying single post with sidebar
 *
 * This is a fallback template.
 *
 * @see single.php
 *
 * @package Bookworm
 */
$blog_layout = function_exists( 'bookworm_post_layout' ) ? bookworm_post_layout() : 'left-sidebar';
$has_sidebar = in_array( $blog_layout, [ 'left-sidebar', 'right-sidebar' ] ) ? true : false;

$post_class	= $has_sidebar ? 'col-lg-8' : 'col-lg-9';
if( $blog_layout == 'left-sidebar' ) {
	$post_class	.= ' order-lg-1';
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'article article__single'); ?>>

	<?php
	do_action( 'bookworm_single_post_top', $blog_layout );

	/**
	 * Functions hooked into bookworm_single_post add_action
	 *
	 * @hooked bookworm_post_header          - 10
	 * @hooked bookworm_post_meta            - 20
	 * @hooked bookworm_post_content         - 30
	 */
	do_action( 'bookworm_single_post', $blog_layout );

	/**
	 * Functions hooked in to bookworm_single_post_bottom action
	 *
	 * @hooked bookworm_post_nav         - 10
	 * @hooked bookworm_display_comments - 20
	 */
	do_action( 'bookworm_single_post_bottom', $blog_layout );
	?>

</article><!-- #post-## -->

