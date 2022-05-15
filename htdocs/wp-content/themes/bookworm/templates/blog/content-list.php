<?php
/**
 * Template part for displaying a post tile in list layout
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bookworm
 */

$_bk_categories = bookworm_post_get_categories();
$css_class = 'text-secondary-gray-700';

?>
<article <?php post_class( ' mb-5 blog-list' ); ?>>
	<div class="row align-items-center">
		<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
			<div class="article__media">
				<a class="d-block mb-3 mb-md-0" href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'bookworm-391x298-crop', [
						'class' => 'img-fluid w-100 rounded',
						'alt'   => the_title_attribute( [ 'echo' => false ] ),
					] ); ?>
				</a>
			</div>
		<?php endif; ?>
		<div class="post-content">
			<?php if ( ! empty( $_bk_categories ) ) : ?>
				<div class="mb-1 text-primary">
					<?php
					echo implode( ', ', array_map( function ( $category ) {
						return sprintf( '<a href="%s" class="small">%s</a>',
							esc_url( get_category_link( $category ) ),
							esc_html( $category->name )
						);
					}, $_bk_categories ) ); ?>
				</div>
			<?php endif; unset( $_bk_categories ); 

			the_title( sprintf( '<h2 class="entry-title h5 crop-text-2 font-weight-medium text-lh-md mb-3"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			
			<p class="text-muted"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>

			<div class="text-secondary-gray-700 post-meta">
				<a href="<?php echo esc_url( get_permalink());?>" class="text-secondary-gray-700 post-date"><?php echo esc_html( get_the_date() ); ?></a>
				<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		            <span class="ml-3 post-comment-link"><?php comments_popup_link( esc_html__( '0 Comments', 'bookworm' ), esc_html__( '1 Comment', 'bookworm' ), esc_html__( '% Comments', 'bookworm' ), $css_class ); ?></span>
		        <?php endif; ?>
			</div>
		</div>
	</div>
</article>
