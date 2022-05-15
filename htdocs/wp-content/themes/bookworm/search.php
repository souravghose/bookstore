<?php
/**
 * The template for displaying search results pages.
 *
 * @package bookworm
 */

get_header(); 
    do_action( 'bookworm_search_before' );

 if ( have_posts() ) :

        do_action( 'bookworm_posts_loop_before' );

        get_template_part( 'templates/blog/loop', '' );

        do_action( 'bookworm_posts_loop_after' );

    else :

        get_template_part( 'templates/contents/content', 'none' );

    endif;
    do_action( 'bookworm_search_after' );

get_footer();
