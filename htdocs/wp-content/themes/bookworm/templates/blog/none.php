<?php
/**
 * Template part for displaying the "No content" blog layout (with sidebar)
 *
 * @package Bookworm
 */
$sidebar = function_exists( 'bookworm_posts_sidebar' ) ? bookworm_posts_sidebar() : 'left-sidebar';
$has_sidebar = in_array( $sidebar, [ 'left-sidebar', 'right-sidebar' ] ) ? true : false;
?>
<div class="article__page no-results not-found">
    <div class="container">
		<div class="row mb-lg-5 mb-xl-0">
			<div class="<?php echo esc_attr( $has_sidebar ? 'col-lg-8 col-xl-9' : 'col-lg-12' ); if( $sidebar == 'left-sidebar' ) echo esc_attr( ' order-lg-1' ); ?>">
				<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
					<p>
						<?php echo esc_html_x( 'Ready to publish your first post?', 'front-end', 'bookworm' ); ?>
						<a href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>"><?php
							/* translators: ready to publish your first post? */
							echo esc_html_x( 'Get started here', 'front-end', 'bookworm' ); ?></a>
					</p>
				<?php else :?>
					<p><?php echo esc_html_x( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'front-end', 'bookworm' ); ?></p>
				<?php endif; ?>
			</div>
			<?php if( $has_sidebar ) : ?>
				<div class="col-lg-4 col-xl-3">
					<?php get_sidebar(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

</div><!-- .no-results -->
