<?php

/**
 * Customizing the comment HTML
 *
 * @package Bookworm
 */
class Bookworm_Comment_Walker extends Walker_Comment {
	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @since 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		?>
		<div id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?>>
			<?php
			if ( 0 != $args['avatar_size'] ) :
				echo get_avatar( $comment, $args['avatar_size'], '', get_comment_author( $comment ), [
					'class' => 'rounded-circle d-none',
				] );
			endif; ?>
			<div class="d-md-flex align-items-center mb-3 comment-author">
				<?php if ( 0 != $args['avatar_size'] ) : ?>
                    <?php echo get_avatar( $comment, $args['avatar_size'], '', '', array( 'class' => 'img-fluid rounded-circle' ) ); ?>
                   
                <?php endif; ?>
                
                <div class="media-body d-flex justify-content-between flex-wrap">
					<h6 class="mb-2 mb-md-0 text-lh-md"><?php echo esc_html( get_comment_author( $comment ) ); ?></h6>

					<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>" class="font-size-2 text-gray-600 d-block comment-posted-on">
						<?php echo esc_html( get_comment_date( '', $comment ) ); ?>
					</a>
				</div>
			</div>
				<div class="comment-text mb-4 text-lh-1dot72">
					<?php
					if ( '0' == $comment->comment_approved ) :
						$commenter = wp_get_current_commenter();
						if ( $commenter['comment_author_email'] ) {
							echo esc_html_x( 'Your comment is awaiting moderation.', 'front-end', 'bookworm' );
						} else {
							echo esc_html_x(
								'Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.',
								'front-end',
								'bookworm'
							);
						}
					else:
						comment_text();
					endif; ?>
				</div>
				
				<ul class="nav comment-footer d-flex align-items-center ml-0">
				<?php comment_reply_link ( array_merge( $args, [
					'add_below' => 'comment-reply-target',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<li class="mr-5 mr-md-4"><i class="far fa-comments text-muted mr-1"></i>',
					'after'    => '</li>'
				] ), $comment ); ?>
				<?php if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) : ?>
					<li class="d-flex align-items-center mr-5 mr-md-4"><i class="far fa-edit text-muted mr-1"></i><a class="comment-edit-link font-size-ms text-gray-600 d-flex align-items-center" href="<?php echo esc_url( get_edit_comment_link( $comment ) ); ?>">
						<?php esc_html_e( 'Edit', 'bookworm' ); ?>
					</a></li>
				<?php endif; ?>
				</ul>
				
				<div id="comment-reply-target-<?php comment_ID(); ?>"></div>
		<?php
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 2.7.0
	 *
	 * @see Walker::end_el()
	 * @see wp_list_comments()
	 *
	 * @param string     $output  Used to append additional content. Passed by reference.
	 * @param WP_Comment $comment The current comment object. Default current comment.
	 * @param int        $depth   Optional. Depth of the current comment. Default 0.
	 * @param array      $args    Optional. An array of arguments. Default empty array.
	 */
	public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
		if ( ! empty( $args['end-callback'] ) ) {
			ob_start();
			call_user_func( $args['end-callback'], $comment, $args, $depth );
			$output .= ob_get_clean();
			return;
		}

		$output .= '</div>'; // close  div.media > div.media-body
	}
}
