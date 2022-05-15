<?php
/**
 * Display single product advanced reviews (comments)
 *
 */
global $product;

$product_id 		= $product->get_id();
$review_count 		= $product->get_review_count();
$avg_rating_number 	= number_format( $product->get_average_rating(), 1 );
$rating_counts 		= Bookworm_WC_Helper::get_ratings_counts( $product );

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}
$version = bookworm_get_single_product_version();

?>
<h4 class="font-size-3"><?php echo esc_html__('Customer Reviews', 'bookworm');?></h4>

<div class="row mb-8 advanced-review-rating">
	<div class="<?php if ( $version =='v7' || $version =='v4' ):?>col-md-12 mb-6<?php else:?>col-md-6 mb-6 mb-md-0<?php endif;?>">
		<div class="d-flex  align-items-center mb-4">
			<span class="font-size-15 font-weight-bold"><?php echo esc_html( $avg_rating_number ); ?></span>
			<div class="ml-3 h6 mb-0">
				<span class="font-weight-normal">
					<?php echo esc_html( sprintf( _n( '%s review', '%s reviews', $review_count, 'bookworm' ), $review_count ) ); ?>
				</span>
				<div class="text-yellow-darker">
					<div class="star-rating" title="<?php printf( esc_attr__( 'Rated %s out of 5', 'bookworm' ), $avg_rating_number ); ?>">
						<small class="<?php echo esc_attr( ( $avg_rating_number >= 1 ) ? 'fas fa-star' : 'far fa-star' ); ?>"></small>
					    <small class="<?php echo esc_attr( ( $avg_rating_number >= 2 ) ? 'fas fa-star' : 'far fa-star' ); ?>"></small>
					    <small class="<?php echo esc_attr( ( $avg_rating_number >= 3 ) ? 'fas fa-star' : 'far fa-star' ); ?>"></small>
					    <small class="<?php echo esc_attr( ( $avg_rating_number >= 4 ) ? 'fas fa-star' : 'far fa-star' ); ?>"></small>
					    <small class="<?php echo esc_attr( ( $avg_rating_number >= 5 ) ? 'fas fa-star' : 'far fa-star' ); ?>"></small>
					</div>
				</div>
			</div>
		</div>

		<?php if ( $review_count  > 0 ) { ?>
			<div class="d-md-flex">
				<a href="#reviews" class="btn btn-outline-dark rounded-0 px-5 mb-3 mb-md-0" data-scroll><?php echo esc_html__('See all reviews', 'bookworm'); ?></a>
			</div>
		<?php } ?>
	</div>

	<div class="<?php if ( $version =='v7' || $version =='v4' ):?>col-md-12<?php else:?>col-md-6<?php endif;?>">
		<ul class="list-unstyled <?php if ( $version =='v7' || $version =='v4' ):?>p-0<?php else:?>pl-xl-4<?php endif;?>">
			<?php for( $rating = 5; $rating > 0; $rating-- ) : ?>
			<li class="py-2">
				<a class="row align-items-center mx-gutters-2 font-size-2">
					<div class="col-auto">
						<span class="text-dark"><?php echo sprintf( esc_html__( '%s stars', 'bookworm' ), $rating ); ?></span>
					</div>
					<?php
						$rating_percentage = 0;
						if ( isset( $rating_counts[$rating] ) && $review_count > 0 ) {
							$rating_percentage = (round( $rating_counts[$rating] / $review_count, 2 ) * 100 );
						}
					?>

					<div class="col px-0">
                    	<div class="progress bg-white-100" style="height: 7px;">
						  	<div class="progress-bar bg-yellow-darker" role="progressbar" style="width: <?php echo esc_attr( $rating_percentage ); ?>%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
	                 </div>
					<?php if ( isset( $rating_counts[$rating] ) ) : ?>
					<div class="col-2 text-right"><span class="text-secondary"><?php echo esc_html( $rating_counts[$rating] ); ?></span></div>
					<?php else : ?>
					<div class="col-2 text-right zero"><span class="text-secondary">0</span></div>
					<?php endif; ?>
				</a>
			</li>
			<?php endfor; ?>
		</ul>
	</div>
</div>

<?php if ( $review_count  > 0 ) { ?>
	<h4 class="font-size-3 mb-8 d-none"><?php echo esc_html__('1-5 of', 'bookworm'); ?><?php printf( _n( ' %s review ', ' %s reviews ', $review_count, 'bookworm' ), esc_html( $review_count ) ); ?></h4>
<?php } ?>


<div id="reviews">
	<?php if ( have_comments() ) : ?>

		<ul class="commentlist list-unstyled mb-8">
			<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
		</ul>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
			echo '<nav class="woocommerce-pagination">';
			paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
				'prev_text' => '&larr;',
				'next_text' => '&rarr;',
				'type'      => 'list',
			) ) );
			echo '</nav>';
		endif; ?>

	<?php else : ?>

		<p class="woocommerce-noreviews text-center font-size-2 text-dark mb-8 alert alert-warning"><?php esc_html_e( 'There are no reviews yet.', 'bookworm' ); ?></p>

	<?php endif; ?>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product_id ) ) : ?>
		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
				$commenter    = wp_get_current_commenter();
				$comment_form = array(
					/* translators: %s is product title */
					'title_reply'         => have_comments() ? esc_html__( 'Write a Review', 'bookworm' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'bookworm' ), get_the_title() ),
					/* translators: %s is product title */
					'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'bookworm' ),
					'title_reply_before'  => '<h4 id="reply-title" class="comment-reply-title font-size-3 mb-4">',
					'title_reply_after'   => '</h4>',
					'comment_notes_after' => '',
					'label_submit'        => esc_html__( 'Submit Review', 'bookworm' ),
					'comment_field'       => '',

					'submit_button'       => '<button type="submit" name="%1$s" id="%2$s" class="%3$s">%4$s</button>',
						'submit_field'        => '<div class="d-flex">%1$s%2$s</div>',
						'class_submit'       => 'btn btn-dark btn-wide rounded-0 transition-3d-hover',
				);

				$name_email_required = (bool) get_option( 'require_name_email', 1 );
				$fields              = array(
					'author' => array(
						'label'    => esc_html__( 'Name', 'bookworm' ),
						'type'     => 'text',
						'value'    => $commenter['comment_author'],
						'required' => $name_email_required,
					),
					'email'  => array(
						'label'    => esc_html__( 'Email', 'bookworm' ),
						'type'     => 'email',
						'value'    => $commenter['comment_author_email'],
						'required' => $name_email_required,
					),
				);

				$comment_form['fields'] = array();

				foreach ( $fields as $key => $field ) {
					$field_html  = '<div class="form-group mb-5 comment-form-' . esc_attr( $key ) . '">';
					$field_html .= '<label class="form-label text-dark h6 mb-3" for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

					if ( $field['required'] ) {
						$field_html .= '&nbsp;<span class="required">*</span>';
					}

					$field_html .= '</label><input class="form-control rounded-0 px-4" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></div>';

					$comment_form['fields'][ $key ] = $field_html;
				}

				$account_page_url = wc_get_page_permalink( 'myaccount' );
				if ( $account_page_url ) {
					/* translators: %s opening and closing link tags respectively */
					$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'bookworm' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
				}

				if ( wc_review_ratings_enabled() ) {
					$comment_form['comment_field'] = '<div class="comment-form-rating d-flex align-items-center mb-6"><label for="rating" class="h6 mb-0 mr-3">' . esc_html__( 'Select a rating(required)', 'bookworm' ) . '</label><select name="rating" id="rating" required>
						<option value="">' . esc_html__( 'Rate&hellip;', 'bookworm' ) . '</option>
						<option value="5">' . esc_html__( 'Perfect', 'bookworm' ) . '</option>
						<option value="4">' . esc_html__( 'Good', 'bookworm' ) . '</option>
						<option value="3">' . esc_html__( 'Average', 'bookworm' ) . '</option>
						<option value="2">' . esc_html__( 'Not that bad', 'bookworm' ) . '</option>
						<option value="1">' . esc_html__( 'Very poor', 'bookworm' ) . '</option>
					</select></div>';
				}

				$comment_form['comment_field'] .= '<div class="comment-form-comment form-group mb-4"><label for="comment" class="form-label text-dark h6 mb-3">' . esc_html__( 'Details please! Your review helps other shoppers.', 'bookworm' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="7" class="form-control rounded-0 p-4" required></textarea></div>';

				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>
    <?php else : ?>
    	<div class="alert alert-info">
			<p class="woocommerce-verification-required font-size-sm mb-0"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'bookworm' ); ?></p>
				
		</div>

		<?php endif; ?>
</div>
