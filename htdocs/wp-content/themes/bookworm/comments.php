<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bookworm
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

?>
<div id="comments" class="space-top-2">
	<h4 class="h4 pb-3 mb-0 font-weight-medium">
        <?php printf(
            esc_html( _nx( 'Comment (%1$s)', 'Comments (%1$s) ', get_comments_number(), 'comments title', 'bookworm' ) ),
            number_format_i18n( get_comments_number() ),
            get_the_title()
        ); ?>
	</h4>

	<hr class="mt-2 mb-5">

	<?php
	if ( have_comments() ) : ?>

		<div class="list-unstyled mb-5 mb-md-8 comment-list">
                <?php
                wp_list_comments( [
					/* translators: comment reply text */
					'reply_text'  => esc_html__( 'Reply', 'bookworm' ),
					'style'       => 'div',
					'format'      => 'html5',
					'avatar_size' => 50,
					'walker'      => new Bookworm_Comment_Walker(),
				] );
                ?>
            </div><!-- .comment-list -->

		

		<?php bookworm_comments_navigation();

		if ( ! comments_open() ) : ?>
			<div class="alert alert-danger alert-with-icon mt-4" role="alert">
				<span class="no-comments"><?php echo esc_html__( 'Comments are closed.', 'bookworm' ); ?></span>
			</div>
		<?php endif;

	endif;

	comment_form( apply_filters( 'bookworm_comment_form_args', [
		'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title mb-4">',
		'submit_field'         => '<div class="form-group form-submit">%1$s%2$s</div>',
		'submit_button'        => '<button type="submit" name="%1$s" id="%2$s" class="%3$s">%4$s</button>',
		'class_submit'         => 'btn btn-dark btn-wide rounded-0 transition-3d-hover',
		'comment_notes_after'  => '',
		'comment_notes_before' => sprintf( '<p class="font-size-sm text-muted">%s %s <span class="text-danger">*</span></p>',
			esc_html__( 'Your email address will not be published.', 'bookworm' ),
			/* translators: related to comment form; phrase follows by red mark*/
			esc_html__( 'Required fields are marked','bookworm' )
		),
		'comment_field'        => sprintf(
			'<div class="form-group comment-form-comment">
				<label class="form-label text-dark mb-2" for="comment">%s</label>
				<textarea id="comment" name="comment" class="form-control" rows="8" maxlength="65525" required></textarea>
			</div>',
			/* translators: label for textarea in comment form */
			esc_html__( 'Comment', 'bookworm' )
		),
	] ) );
	?>
</div>
<?php
