<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package bookworm
 */

?>

<?php
    do_action( 'bookworm_before_footer' );
    	global $post;
        $static_content_id = apply_filters( 'bookworm_footer_static_content_id', '' );
        $is_custom_footer = false;

        if ( is_page() && isset( $post->ID ) ) {
            $clean_page_meta_values = get_post_meta( $post->ID, '_footer_static_content_id', true );
            $is_custom_footer = get_post_meta( $post->ID, '_is_custom_footer', true );
            if ( isset( $clean_page_meta_values ) && $clean_page_meta_values ) {
                $static_content_id = $clean_page_meta_values;
            }
        }

        if( bookworm_is_mas_static_content_activated() && ! empty( $static_content_id ) && $is_custom_footer ) {
            echo do_shortcode( '[mas_static_content id=' . $static_content_id . ' wrap=0]' );
        } else {
            $footer_version = function_exists( 'bookworm_footer_version' ) ? bookworm_footer_version() : 'v1';
		    get_template_part( 'templates/footers/footer', $footer_version );
		}
    do_action( 'bookworm_after_footer' );
?>



<?php wp_footer(); ?>

</body>
</html>
