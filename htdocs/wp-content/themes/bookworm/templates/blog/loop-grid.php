<?php
/**
 * Template part for displaying the "Grid" blog layout (with sidebar)
 *
 * @package Bookworm
 */

$sidebar = function_exists( 'bookworm_posts_sidebar' ) ? bookworm_posts_sidebar() : 'left-sidebar';
$has_sidebar = in_array( $sidebar, [ 'left-sidebar', 'right-sidebar' ] ) ? true : false;

/**
 * Fires before the posts section
 */
do_action( 'bookworm_posts_before' ); ?>

	<div class="container mb-5 mb-lg-8 pb-xl-1 mt-5 pt-xl-1<?php echo esc_attr( $has_sidebar ? ' mt-lg-8' : ' mt-lg-7' );?>">
		<?php do_action( 'bookworm_posts_content_before' ); ?>

		<?php if( !( $has_sidebar ) ) {
			$have_posts = false;
			$available_cats = array(
				'all_cats' => array(
					'title'	=> apply_filters( 'bookworm_grid_fullwidth_all_cats_title', esc_html__( 'All', 'bookworm' ) ),
					'posts'	=> '',
				),
			);

			while ( have_posts() ) :
				the_post();
				$have_posts = true;
				$current_post_cats = get_the_category( get_the_ID() );
				ob_start();
				get_template_part( 'templates/blog/content', 'grid' );
				$post_content = ob_get_clean();
				$available_cats['all_cats']['posts'] .= $post_content;
				if( ! empty( $current_post_cats ) && is_array( $current_post_cats ) ) {
					foreach ( $current_post_cats as $cat ) {
						if( isset( $available_cats[$cat->slug] ) ) {
							$available_cats[$cat->slug]['posts'] .= $post_content;
						} else {
							$available_cats[$cat->slug] = array(
								'title'	=> $cat->name,
								'posts'	=> $post_content,
							);
						}
					}
				}
			endwhile;

			if( $have_posts ) {
				?>
				<ul class="nav justify-content-md-center nav-gray-700 mb-5 flex-nowrap flex-md-wrap overflow-auto overflow-md-visible" id="featuredBooks" role="tablist">
					<?php foreach ( $available_cats as $key => $tab_title ) { ?>
						<li class="nav-item mx-5 mb-1 flex-shrink-0 flex-md-shrink-1">
							<a id="tab-<?php echo esc_attr($key);?>" class="nav-link px-0<?php if ( $key == 'all_cats') echo esc_attr( ' active' ); ?>" data-toggle="tab" href="#<?php echo esc_attr($key);?>" role="tab" aria-controls="<?php echo esc_attr($key);?>" aria-selected="<?php echo esc_attr( ( $key == 'all_cats' ) ? 'true' : 'false' ); ?>">
								<?php echo esc_html( $tab_title['title']); ?>
							</a>
						</li>
					<?php } ?>
				</ul>
				<div class="tab-content">
					<?php foreach ( $available_cats as $key => $tab_content ) { ?>
						<div class="tab-pane fade<?php if ( $key == 'all_cats' ) echo esc_attr( ' active show' ); ?>" id="<?php echo esc_attr($key); ?>" role="tabpanel" aria-labelledby="tab-<?php echo esc_attr($key);?>">
							<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
								<?php print_r( $tab_content['posts'] ); ?>
							</div>
						</div>
					<?php } ?>
				</div>
				<?php
			}

		} else { ?>

			<div class="row mb-lg-5 mb-xl-0">
				<div class="col-lg-8 col-xl-9<?php if( $sidebar == 'left-sidebar' ) echo esc_attr( ' order-lg-1' ); ?>">
					<?php 
					/**
					 * Fires right before the blog loop starts
					 */
					do_action( 'bookworm_loop_before' ); ?>

					<div class="row blog-grid-row <?php echo esc_attr( $has_sidebar ? 'row-cols-md-2' : 'row-cols-1 row-cols-md-2 row-cols-lg-3' );?>">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'templates/blog/content', 'grid' );
						endwhile; ?>
					</div>

					<?php
					/**
					 * Fires right after the blog loop
					 */
					do_action( 'bookworm_loop_after' ); ?>
				</div>

				<div class="col-lg-4 col-xl-3 sidebar widget-area blog-sidebar">
					<?php get_sidebar(); ?>
				</div>
			</div>
		<?php } ?>

	    	
	    <?php do_action( 'bookworm_posts_content_after' ); ?>
	</div>	
	
<?php

/**
 * Fires after the posts section
 */
do_action( 'bookworm_posts_after' );