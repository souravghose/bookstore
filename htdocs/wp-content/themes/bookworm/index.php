<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package bookworm
 */

get_header(); 
	do_action( 'bookworm_index_before' );

if ( have_posts() ) :

        do_action( 'bookworm_posts_loop_before' );

        get_template_part( 'templates/blog/loop', '' );

        do_action( 'bookworm_posts_loop_after' );

    else :

        get_template_part( 'templates/contents/content', 'none' );

endif;
    do_action( 'bookworm_index_after' );

get_footer();
