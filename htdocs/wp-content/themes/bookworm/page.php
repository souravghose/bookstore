<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package bookworm
 */

get_header(); ?>

    <main id="main" class="site-main<?php if ( bookworm_is_woocommerce_activated() && ( is_cart() || is_checkout() ) ):?> bg-punch-light space-bottom-3<?php endif; ?>" role="main">

        <?php
            while ( have_posts() ) :

                the_post();

                do_action( 'bookworm_page_before' );

                get_template_part( 'templates/contents/content', 'page' );
                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

                /**
                 * Functions hooked in to bookworm_page_after action
                 *
                 * @hooked bookworm_display_comments - 10
                 */
                do_action( 'bookworm_page_after' );

            endwhile; // End of the loop.
        ?>

    </main><!-- #main -->

<?php

get_footer();


