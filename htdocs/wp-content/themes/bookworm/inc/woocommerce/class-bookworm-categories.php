<?php
/**
 * Class to setup Brands attribute
 *
 * @package Bookworm/WooCommerce
 */

class Bookworm_Product_Categories {

	public function __construct() {

		// Add scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'load_wp_media_files' ), 0 );

		// Add form
		add_action( "product_cat_add_form_fields",				array( $this, 'add_category_fields' ), 10 );
		add_action( "product_cat_edit_form_fields",				array( $this, 'edit_category_fields' ), 10, 2 );
		add_action( 'create_term',								array( $this, 'save_category_fields' ), 10, 3 );
		add_action( 'edit_term',								array( $this, 'save_category_fields' ), 10, 3 );
	}

	/**
	 * Loads WP Media Files
	 *
	 * @return void
	 */
	public function load_wp_media_files() {
		wp_enqueue_media();
	}

	/**
	 * Product Category static block fields.
	 *
	 * @return void
	 */
	public function add_category_fields() {
		?>
		<div class="form-field">
			<div class="form-field">
                <label for="category_icon"><?php esc_html_e( 'Icon for category', 'bookworm' ); ?></label>
                <input type="text" name="category_icon" id="category_icon" value autocomplete="off">
                <p class="description"><?php esc_html_e( 'This is alternative for font based icons','bookworm' ); ?></p>
            </div>
			<div class="clear"></div>
		</div>
		<?php
	}

	/**
	 * Edit Category static block fields.
	 *
	 * @param mixed $term Term (product_cat) being edited
	 * @param mixed $taxonomy Taxonomy of the term being edited
	 */
	public function edit_category_fields( $term, $taxonomy ) {
		$icon = get_term_meta( $term->term_id, 'icon', true );
        ?>
        <tr class="form-field">
            <th scope="row" valign="top"><label for="category_icon"><?php esc_html_e( 'Category icon', 'bookworm' ); ?></label></th>
            <td>
                <input type="text" name="category_icon" id="category_icon" value="<?php echo esc_attr( $icon ); ?>">
                <p class="description"><?php esc_html_e( 'This is alternative for font based icons','bookworm' ); ?></p>
            </td>
        </tr>
        <?php
	}

	/**
	 * Save Category static block fields.
	 *
	 * @param mixed $term_id Term ID being saved
	 * @param mixed $tt_id
	 * @param mixed $taxonomy Taxonomy of the term being saved
	 * @return void
	 */
	public function save_category_fields( $term_id, $tt_id, $taxonomy ) {

		if ( isset( $_POST['category_icon'] ) ) {
            update_term_meta( $term_id, 'icon', $_POST['category_icon'] );
        }

		delete_transient( 'wc_term_counts' );
	}
}

new Bookworm_Product_Categories;