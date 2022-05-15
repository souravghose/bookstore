<?php
/**
 * Bookworm Helper Class for WooCommerce
 */

class Bookworm_WC_Helper {

    public static function init() {
        add_filter( 'comments_template',    array( __CLASS__, 'comments_template_loader' ), 20 );

        // Add options on General Tab
        add_action( 'woocommerce_product_options_general_product_data', array( 'Bookworm_WC_Helper', 'product_options_general_product_data' ) );

        // Add options on Inventry Tab
        add_action( 'woocommerce_product_options_inventory_product_data',   array( 'Bookworm_WC_Helper', 'product_options_inventory_product_data' ) );

        // Add video Tab
        add_action( 'woocommerce_product_write_panel_tabs', array( 'Bookworm_WC_Helper', 'add_product_video_panel_tab' ) );
        add_action( 'woocommerce_product_data_panels',      array( 'Bookworm_WC_Helper', 'add_product_video_panel_data' ) );

        foreach ( wc_get_product_types() as $value => $label ) {
            // Save options on General Tab
            add_action( 'woocommerce_process_product_meta_' . $value, array( 'Bookworm_WC_Helper', 'save_product_style_to_product_options' ) );    

            // Save options on Inventory Tab
            add_action( 'woocommerce_process_product_meta_' . $value, array( 'Bookworm_WC_Helper', 'save_total_stock_quantity_to_product_options' ) );

            // Save video Tab
            add_action( 'woocommerce_process_product_meta_' . $value, array( 'Bookworm_WC_Helper', 'save_product_video_panel_data' ) );
        }
        
    }

    public static function comments_template_loader( $template ) {

        if ( get_post_type() !== 'product' || ! apply_filters( 'Bookworm_use_advanced_reviews', true ) ) {
            return $template;
        }

        $check_dirs = array(
            trailingslashit( get_stylesheet_directory() ) . 'templates/shop/',
            trailingslashit( get_template_directory() ) . 'templates/shop/',
            trailingslashit( get_stylesheet_directory() ) . WC()->template_path(),
            trailingslashit( get_template_directory() ) . WC()->template_path(),
            trailingslashit( get_stylesheet_directory() ),
            trailingslashit( get_template_directory() ),
            trailingslashit( WC()->plugin_path() ) . 'templates/'
        );

        if ( WC_TEMPLATE_DEBUG_MODE ) {
            $check_dirs = array( array_pop( $check_dirs ) );
        }

        foreach ( $check_dirs as $dir ) {
            if ( file_exists( trailingslashit( $dir ) . 'single-product-advanced-reviews.php' ) ) {
                return trailingslashit( $dir ) . 'single-product-advanced-reviews.php';
            }
        }

        return $template;
    }

    public static function get_ratings_counts( $product ) {
        global $wpdb;

        $product_id = $product->get_id();
        $counts     = array();
        $raw_counts = $wpdb->get_results( $wpdb->prepare("
                SELECT meta_value, COUNT( * ) as meta_value_count FROM $wpdb->commentmeta
                LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
                WHERE meta_key = 'rating'
                AND comment_post_ID = %d
                AND comment_approved = '1'
                AND meta_value > 0
                GROUP BY meta_value
            ", $product_id ) );

        foreach ( $raw_counts as $count ) {
            $counts[ $count->meta_value ] = $count->meta_value_count;
        }

        return $counts;
    }
     public static function product_options_general_product_data() {
        echo '<div class="options_group">';
            woocommerce_wp_select( array(
                'id' => '_product_layout',
                'label' => esc_html__( 'Product Layout', 'bookworm' ),
                'options' => array(
                    ''              => esc_html__( 'Default', 'bookworm' ),
                    'v1'            => esc_html__( 'Shop Single v1', 'bookworm' ),
                    'v2'            => esc_html__( 'Shop Single v2', 'bookworm' ),
                    'v3'            => esc_html__( 'Shop Single v3', 'bookworm' ),
                    'v4'            => esc_html__( 'Shop Single v4', 'bookworm' ),
                    'v5'            => esc_html__( 'Shop Single v5', 'bookworm' ),
                    'v6'            => esc_html__( 'Shop Single v6', 'bookworm' ),
                    'v7'            => esc_html__( 'Shop Single v7', 'bookworm' ),
                ),
                'desc_tip' => true,
                'description' => esc_html__( 'Select product layout to display on product page.', 'bookworm' )
            ) );
        echo '</div>';
    }

    public static function save_product_style_to_product_options( $post_id ) {
        $product_layout = isset( $_POST['_product_layout'] ) ? wc_clean( $_POST['_product_layout'] ) : '' ;
        update_post_meta( $post_id, '_product_layout', $product_layout );
    }

    public static function add_product_video_panel_tab() {
        ?>
        <li class="video_options video_tab">
            <a href="#video_product_data"><span><?php echo esc_html__( 'videos', 'bookworm' ); ?></span></a>
        </li>
        <?php
    }

    public static function add_product_video_panel_data() {
        global $post;
        ?>
        <div id="video_product_data" class="panel woocommerce_options_panel">
            <div class="options_group">
                <?php
                    $videos = get_post_meta( $post->ID, '_videos', true );
                    wp_editor( wp_specialchars_decode( $videos ), '_videos', array() );
                ?>
            </div>
        </div>
        <?php
    }

    public static function save_product_video_panel_data( $post_id ) {
        $videos = isset( $_POST['_videos'] ) ? $_POST['_videos'] : '';
        
        update_post_meta( $post_id, '_videos', $videos );
    }

    public static function product_options_inventory_product_data() {
        echo '<div class="options_group">';
            woocommerce_wp_text_input(  array( 
                'id' => '_total_stock_quantity',
                'label' => esc_html__( 'Total Stock Quantity', 'bookworm' ),
                'desc_tip' => 'true',
                'description' => esc_html__( 'Total Stock Quantity Available. This will be used to calculate prograss bar in onsale element.', 'bookworm' ),
                'type' => 'text'
            ) );
        echo '</div>';
    }

    public static function save_total_stock_quantity_to_product_options( $post_id ) {
        $current_stock = isset( $_POST['_stock'] ) ? wc_clean( $_POST['_stock'] ) : get_post_meta( $post_id, '_stock', true ) ;
        $stock_quantity = isset( $_POST['_total_stock_quantity'] ) ? wc_clean( $_POST['_total_stock_quantity'] ) : '' ;
        if( empty( $stock_quantity ) && ! empty( $current_stock ) && round( $current_stock ) > 0 ) {
            $stock_quantity = round( $current_stock );
        }
        update_post_meta( $post_id, '_total_stock_quantity', $stock_quantity );
    }
}

Bookworm_WC_Helper::init();
