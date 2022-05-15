<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package bookworm
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
<link rel="profile" href="https://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php
    do_action( 'bookworm_before_header' );
        global $post;
        $static_content_id = apply_filters( 'bookworm_header_static_content_id', '' );
        $is_custom_header = false;

        if ( is_page() && isset( $post->ID ) ) {
            $clean_page_meta_values = get_post_meta( $post->ID, '_header_static_content_id', true );
            $is_custom_header = get_post_meta( $post->ID, '_is_custom_header', true );

            if ( isset( $clean_page_meta_values ) && $clean_page_meta_values ) {
                $static_content_id = $clean_page_meta_values;
            }
        }

        if( bookworm_is_mas_static_content_activated() && ! empty( $static_content_id ) && $is_custom_header ) {
            echo do_shortcode( '[mas_static_content id=' . $static_content_id . ' wrap=0]' );
        } else {
		    $header_version = function_exists( 'bookworm_header_version' ) ? bookworm_header_version() : 'v1';
		    get_template_part( 'templates/headers/header', $header_version );
		}
    do_action( 'bookworm_after_header' );
?>

<?php do_action( 'bookworm_before_site' ); ?>
