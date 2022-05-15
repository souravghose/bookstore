<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
    return;
}

$pages = paginate_links(
    apply_filters(
        'woocommerce_pagination_args',
        array( // WPCS: XSS ok.
            'base'      => $base,
            'format'    => $format,
            'add_args'  => false,
            'current'   => max( 1, $current ),
            'total'     => $total,
            'prev_text' => esc_html__( 'Previous', 'bookworm' ),
            'next_text' => esc_html__( 'Next', 'bookworm' ),
            'type'      => 'array',
            'end_size'  => 3,
            'mid_size'  => 3,
            'prev_next' => true,
        )
    )
);
if ( is_array( $pages ) ):
?>
<nav class="woocommerce-pagination" aria-label="<?php echo esc_attr__( 'Shop Page navigation', 'bookworm' ); ?>">
    <ul class="pagination pagination__custom justify-content-md-center flex-nowrap flex-md-wrap overflow-auto overflow-md-visble">
        <?php
        foreach ( $pages as $page ) {
            ?><li class="flex-shrink-0 flex-md-shrink-1 page-item<?php echo esc_attr( strpos( $page, 'current' ) !== false ? ' active' : '' ); ?>">
                <?php echo str_replace( 'page-numbers', 'page-link', $page );?>
            </li><?php
        }
        ?>
    </ul>
</nav><?php
endif;
