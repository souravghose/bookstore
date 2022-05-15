<?php
/**
 * Ajax Fuctions Blog Post Block
 *
 * @since   0.1
 * @package BookwormGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bookwormgb_blog_post_block_output' ) ) {
	/**
	 * Blog Post Block.
	 */
	function bookwormgb_blog_post_block_output() {

		if( isset( $_POST['attributes'] ) ) {
			$attributes = $_POST['attributes'];

			if( isset( $attributes['attributes'] ) ) {
				unset( $attributes['attributes'] );
			}

			extract( $attributes );

			$default_args = array(
				'post_type'         => 'post',
				'orderby'           => $attributes['orderBy'],
				'order'             => $attributes['order'],
				'posts_per_page'    => ! empty( $attributes['postsToShow'] ) ? $attributes['postsToShow'] : 3,
				'post__in'          => ( ! empty( $attributes['posts'] ) && is_array($attributes['posts']) ) ? $attributes['posts'] : '',
				'tax_query'         => ( ! empty( $taxonomyType ) && ! empty( $taxonomy ) && $taxonomy != 'all' ) ? array(
					array(
						'taxonomy' => $taxonomyType,
						'field'    => 'term_id',
						'terms'    => $taxonomy,
						'operator' => 'IN',
					) 
				) :  array()
			);

			$posts = get_posts( apply_filters( 'bookwormgb_render_blog_post_args', $default_args ) );

			if( $posts ) {
				ob_start();
				global $post;
				
				?>
				<ul class="blog-posts list-unstyled my-0 row row-cols-md-<?php echo esc_attr( $mdColumns ); ?> row-cols-lg-<?php echo esc_attr( $lgColumns ); ?>">
					<?php foreach ( $posts as $post ) : setup_postdata( $post ); ?>
						<li class="blog-post col mb-4">
							<div class="blog-post__inner">
								<?php if ( $showPostFeaturedImage == 'true' ): ?>
									<a href="<?php echo esc_url( get_permalink() ); ?>">
										<?php echo wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), array('445', '300'), "", array( "class" => "img-fluid rounded-md mb-3 bwgb-bp__post-featured-image" ) );  ?>
									</a>
								<?php endif ?>
								<div class="blog-post__body">
									<?php if ( $showPostMeta == 'true' ): ?>
										<ul class="blog-post__meta list-unstyled d-flex font-size-2 ml-0 mb-2d75 bwgb-bp__post-meta">
											<?php if ( $showPostDate == 'true' ): ?>
												<li><a href="<?php echo esc_url( get_permalink() ); ?>" class="text-secondary-gray-700"><?php echo get_the_date('d M, Y');?></a></li>
											<?php endif; ?>
											<?php if ( $showPostComments == 'true' && ( $hideEmptyComments == 'true' ? $post->comment_count > 0 : true ) ): ?>
												<li <?php if ( $showPostDate == 'true' ): ?> class="ml-3" <?php endif ?>>
													<a href="<?php echo esc_url( get_permalink() ); ?>" class="text-secondary-gray-700">
														<?php echo $post->comment_count; echo apply_filters( 'bookwormgb_blog_post_comments_text', esc_html__( ' Comments', 'bookwormgb' ) ); ?>
													</a>
												</li>
											<?php endif ?>
										</ul>
									<?php endif ?>
									<?php if ( $showPostTitle == 'true' ): ?>
										<h2 class="blog-post__title text-truncate font-weight-regular h6 bwgb-bp__post-title">
											<a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo get_the_title( $post->ID ); ?></a>
										</h2>
									<?php endif ?>
								</div>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
				<?php
				wp_reset_postdata();
				$output = ob_get_clean();
			} else {
				$output = '<p class="text-danger text-center font-size-3 font-weight-semi-bold">' . esc_html__( 'No posts available.', 'bookwormgb' ) . '</p>';
			}
		}

		if( ! empty( $output ) ) {
			$data = array(
				'success' => true,
				'output' => $output,
			);
		} else {
			$data = array(
				'error' => true,
			);
		}

		wp_send_json( $data );
	}

	add_action( 'wp_ajax_nopriv_bookwormgb_blog_post_block_output', 'bookwormgb_blog_post_block_output' );
	add_action( 'wp_ajax_bookwormgb_blog_post_block_output', 'bookwormgb_blog_post_block_output' );
}