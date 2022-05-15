<?php

/**
 * Widget "(Bookworm) Recent Posts"
 *
 * Display the recent posts according to design.
 *
 * @uses WP_Widget
 */
class Bookworm_Recent_Posts_Widget extends WP_Widget {
	/**
	 * Widget id_base
	 *
	 * @var string
	 */
	private $widget_id = 'bookworm_recent_posts';

	/**
	 * Widget default values
	 *
	 * @var array
	 */
	private $defaults = [
		'title'    => '',
		'number'   => 3,
		'show_date' => true,
	];

	public function __construct() {
		$opts = array( 'description' => esc_html__( 'Your latest posts in a fancy manner.', 'bookworm-extensions' ) );
		parent::__construct( $this->widget_id, esc_html__( '(Bookworm) Recent Posts', 'bookworm-extensions' ), $opts );
	}

	/**
	 * Display the widget contents
	 *
	 * @param array $args     Widget args described in {@see register_sidebar()}
	 * @param array $instance Widget settings
	 */
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$title    = apply_filters( 'widget_title', esc_html( trim( $instance['title'] ) ), $instance, $this->id_base );
		$number   = false === (bool) $instance['number'] ? 3 : (int) $instance['number'];
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filter the argument for querying Recent Posts widget
		 *
		 * @since 1.0.0
		 *
		 * @param array $args An array of arguments for WP_Query
		 */
		$query = new WP_Query( apply_filters( 'bookworm_widget_recent_posts_query_args', [
			'post_status'         => 'publish',
			'no_found_rows'       => true,
			'suppress_filters'    => true,
			'posts_per_page'      => $number,
			'ignore_sticky_posts' => true,
		] ) );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'], $title, $args['after_title'];
		}

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				?>
				<div <?php post_class( 'd-flex mb-5 bookworm-recent-post' ); ?>>
					<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : ?>
						<a href="<?php the_permalink(); ?>" class="widget-post-thumb d-block mr-3">
							<?php the_post_thumbnail( 'post-thumbnail', [
								'class' => 'img-fluid rounded height-80 max-width-80 mb-0',
								'alt'   => the_title_attribute( [ 'echo' => false ] ),
							] ); ?>
						</a>
					<?php endif; ?>
					<div class="body-content">
						<?php
						the_title(
							sprintf( '<h6 class="blog-entry-title text-lh-md crop-text-2 mb-1"><a href="%s">', esc_url( get_permalink() ) ),
							'</a></h6>'
						); ?>
						<?php if ( $show_date ) : ?>
							<span class="post-date font-size-2 text-secondary-gray-700"><?php echo get_the_date(); ?></span>
						<?php endif; ?>
					</div>
				</div>
				<?php
			}
			wp_reset_postdata();
		} else {
			echo '<p class="font-size-sm text-muted">', esc_html__( 'Posts not found.', 'bookworm-extensions' ), '</p>';
		}

		echo $args['after_widget'];
	}

	/**
	 * Output the widget settings form
	 *
	 * @param array $instance Current settings
	 *
	 * @return bool
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php echo esc_html_x( 'Title', 'widget title', 'bookworm-extensions' ); ?>
			</label>
			<input type="text" class="widefat"
			       id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       value="<?php echo esc_html( trim( $instance['title'] ) ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>">
				<?php echo esc_html__( 'Number of posts', 'bookworm-extensions' ); ?>
			</label>
			<input type="number" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>"
			       value="<?php echo esc_attr( $instance['number'] ); ?>">
		</p>

		<p>
			<input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php echo esc_html__( 'Display post date?', 'bookworm-extensions' ); ?></label>
		</p>
		<?php

		return true;
	}

	/**
	 * Update widget
	 *
	 * @param array $new_instance New values
	 * @param array $old_instance Old values
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']    = sanitize_text_field( trim( $new_instance['title'] ) );
		$instance['number']   = absint( $new_instance['number'] );
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		
		return $instance;
	}
}
