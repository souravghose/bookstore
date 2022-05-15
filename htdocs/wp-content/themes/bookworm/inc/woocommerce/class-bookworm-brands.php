<?php
/**
 * Class to setup Brands attribute
 *
 * @package Bookworm/WooCommerce
 */

class Bookworm_Brands {

	public function __construct() {

        $brand_taxonomy = Mas_WC_Brands()->get_brand_taxonomy();

		if( ! empty( $brand_taxonomy ) ) {
			
			// Add form
			add_action( "{$brand_taxonomy}_add_form_fields",	array( $this, 'add_brand_fields' ), 10 );
			add_action( "{$brand_taxonomy}_edit_form_fields",	array( $this, 'edit_brand_fields' ), 10, 2 );
			add_action( 'create_term',							array( $this, 'save_brand_fields' ), 	10, 3 );
			add_action( 'edit_term',							array( $this, 'save_brand_fields' ), 	10, 3 );

			
		}
	}

	/**
	 * Brand thumbnail fields.
	 *
	 * @return void
	 */
	public function add_brand_fields() {
		?>
		<div class="form-field">
			<?php 
				if( post_type_exists( 'mas_static_content' ) ) :
					$static_block = array();
					$args = array('post_type' => 'mas_static_content', 'post_status' => 'publish', 'limit' => '-1', 'posts_per_page' => '-1' );
					$static_blocks = get_posts( $args ); 
				endif;
			?>
			<div class="form-group">
				<label><?php echo esc_html__( 'Jumbotron', 'bookworm' ); ?></label>
				<select id="product_brand_static_block_id" class="form-control" name="product_brand_static_block_id">
					<option><?php echo esc_html__( 'Select a Static Block', 'bookworm' ); ?></option>
				<?php if( !empty( $static_blocks ) ) : ?>
				<?php foreach( $static_blocks as $static_block ) : ?>
					<option value="<?php echo esc_attr( $static_block->ID ); ?>"><?php echo get_the_title( $static_block->ID ); ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
				</select>
			</div>
			<div class="clear"></div>
		</div>
		
		<?php
	}

	/**
	 * Edit brand thumbnail field.
	 *
	 * @param mixed $term Term (brand) being edited
	 * @param mixed $taxonomy Taxonomy of the term being edited
	 */
	public function edit_brand_fields( $term, $taxonomy ) {

		$static_block_id 	= '';
		$static_block_id 	= absint( get_term_meta( $term->term_id, 'static_block_id', true ) );

		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php esc_html_e( 'Jumbotron', 'bookworm' ); ?></label></th>
			<td>
				<?php 
					if( post_type_exists( 'mas_static_content' ) ) :
						$static_block = array();
						$args = array('post_type' => 'mas_static_content', 'post_status' => 'publish', 'limit' => '-1', 'posts_per_page' => '-1' );
						$static_blocks = get_posts( $args ); 
					endif;
				?>
				<div class="form-group">
					<select id="product_brand_static_block_id" class="form-control" name="product_brand_static_block_id">
						<option><?php echo esc_html__( 'Select a Static Block', 'bookworm' ); ?></option>
					<?php if( !empty( $static_blocks ) ) : ?>
					<?php foreach( $static_blocks as $static_block ) : ?>
						<option value="<?php echo esc_attr( $static_block->ID ); ?>" <?php echo esc_attr( $static_block_id == $static_block->ID  ? 'selected' : '' ); ?>><?php echo get_the_title( $static_block->ID ); ?></option>
					<?php endforeach; ?>
					<?php endif; ?>
					</select>
				</div>
				<div class="clear"></div>
			</td>
		</tr>
		
		<?php
	}

	/**
	 * save_brand_fields function.
	 *
	 * @param mixed $term_id Term ID being saved
	 * @param mixed $tt_id
	 * @param mixed $taxonomy Taxonomy of the term being saved
	 * @return void
	 */
	public function save_brand_fields( $term_id, $tt_id, $taxonomy ) {

		if ( isset( $_POST['product_brand_thumbnail_id'] ) ) {
			//update_woocommerce_term_meta( $term_id, 'thumbnail_id', absint( $_POST['product_brand_thumbnail_id'] ) );
			update_woocommerce_term_meta( $term_id, 'static_block_id', absint( $_POST['product_brand_static_block_id'] ) );
		}

		delete_transient( 'wc_term_counts' );
	}

}

new Bookworm_Brands;