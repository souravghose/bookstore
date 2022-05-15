<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package bookworm
 */
$additional_class = '';
if ( function_exists( 'is_cart' ) ) {
    if ( is_cart() ) {
        $additional_class .= ' article__cart';
    } elseif ( is_checkout() ) {
        $additional_class .= ' article__checkout';
    }
}

$additional_class .= ' article__page';
?>
<?php do_action( 'bookworm_before_page'); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class( $additional_class ); ?>>
    <?php
    /**
     * Functions hooked in to bookworm_page add_action
     *
     * @hooked bookworm_page_header          - 10
     * @hooked bookworm_page_content         - 20
     */
    do_action( 'bookworm_page' );
    ?>
</div><!-- #post-## -->
<?php do_action( 'bookworm_after_page'); ?>
