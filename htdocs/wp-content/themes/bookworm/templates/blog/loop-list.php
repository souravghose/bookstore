<?php
/**
 * Template part for displaying the "List" blog layout (with sidebar)
 *
 * @package Bookworm
 */

$sidebar = function_exists( 'bookworm_posts_sidebar' ) ? bookworm_posts_sidebar() : 'left-sidebar';
$has_sidebar = in_array( $sidebar, [ 'left-sidebar', 'right-sidebar' ] ) ? true : false;

/**
 * Fires before the posts section
 */
do_action( 'bookworm_posts_before' );

?>

<div class="container mb-5 mb-lg-8 pb-xl-1 mt-5 mt-lg-8 pt-xl-1">
	<?php do_action( 'bookworm_posts_content_before' ); ?>
		<div class="row mb-lg-5 mb-xl-0">
			<div class="<?php echo esc_attr( $has_sidebar ? 'col-lg-8 col-xl-9' : 'col-lg-12' ); if( $sidebar == 'left-sidebar' ) echo esc_attr( ' order-lg-1' ); ?>">

				<?php
				/**
				 * Fires right before the blog loop starts
				 */
				do_action( 'bookworm_loop_before' );

				while ( have_posts() ) :
					the_post();
					get_template_part( 'templates/blog/content', 'list' );
				endwhile;

				/**
				 * Fires right after the blog loop
				 */
				do_action( 'bookworm_loop_after' ); ?>

			</div><!-- /.col-lg-8 col-xl-9 -->
			<?php if ( $has_sidebar ) : ?>
				<div class="col-lg-4 col-xl-3 sidebar widget-area blog-sidebar">
					<?php get_sidebar(); ?>
				</div><!-- /.col-lg-4 col-xl-3 -->
			<?php endif; ?>
			
		</div><!-- /.row -->

	<?php do_action( 'bookworm_posts_content_after' ); ?>
</div><!-- /.row -->

<?php

/**
 * Fires after the posts section
 */
do_action( 'bookworm_posts_after' );
