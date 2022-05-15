<?php
/**
 * Template functions for Pages
 *
 * @package bookworm
 */

if ( ! function_exists( 'bookworm_breadcrumb' ) ) {
    /**
     * Displays Breadcrumb
     */
    function bookworm_breadcrumb() {

        global $post;
        $hide_page_breadcrumb = false;

        if ( isset( $post->ID ) ) {
            $page_breadcrumb_meta_values = get_post_meta( $post->ID, '_hide_page_breadcrumb', true );

            if ( isset( $page_breadcrumb_meta_values ) && $page_breadcrumb_meta_values ) {
                $hide_page_breadcrumb = $page_breadcrumb_meta_values;
            }
        }

        $hide_page_breadcrumb = apply_filters( 'bookworm_show_breadcrumb', $hide_page_breadcrumb );


        if( ! $hide_page_breadcrumb ) {
            
            if ( ! bookworm_is_woocommerce_activated() ) {
                return;
            }

            if ( isset( $page_breadcrumb_values ) && $page_breadcrumb_values ) { 
                return;
            }

            ob_start();
            woocommerce_breadcrumb();
            $breadcrumb_html = ob_get_clean();

            $background_enabled = filter_var( get_theme_mod( 'bookworm_enable_page_header_background', 'yes' ), FILTER_VALIDATE_BOOLEAN );


            if ( $background_enabled ) {
                $attachment_id = apply_filters( 'bookworm_page_header_background_id', get_theme_mod( 'page_header_backround' ));

                if ( (int) $attachment_id && $attachment_id > 0 ) {
                    $image = wp_get_attachment_image_src( $attachment_id, 'full' );
                } else {
                    $background_enabled = false;
                }
            }

            if ( $background_enabled && ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) ) {
                $breadcrumb_html = trim( str_replace( '<a', '<a class="text-white"', $breadcrumb_html ) );
            } else {
                $breadcrumb_html = trim( str_replace( '<a', '<a class="h-primary"', $breadcrumb_html ) );
            }
                     
            if ( $breadcrumb_html && $background_enabled && ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) ) :
                ?><div class="page-header mb-8">
                    <div class="bg-img-hero shop-page-header" style="background-image: url(<?php echo esc_attr( $image[0]);?> );">
                        <div class="container position-relative mb-2">
                            <div class="d-flex justify-content-center space-2 space-lg-4">
                                <h6 class="font-weight-medium text-white font-size-12 py-lg-5"><?php bookworm_the_page_title(); ?></h6>
                            </div>
                            <div class="d-flex justify-content-center text-white align-items-center pb-4">
                                <?php echo wp_kses( $breadcrumb_html, array( 'i' => array( 'class' => array() ), 'nav' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'class' => array() ), 'span' => array( 'class' => array() ) ) )?>
                            </div>
                        </div>
                    </div>
                </div><?php
            else :
                if ( ! empty ( $breadcrumb_html ) ): ?>
                    <div class="page-header border-bottom">
                        <div class="container">
                            <div class="d-md-flex justify-content-between align-items-center py-4">
                                <?php echo wp_kses( $breadcrumb_html, array( 'i' => array( 'class' => array() ), 'nav' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'class' => array() ), 'span' => array( 'class' => array() ) ) )?>
                            </div>
                        </div>
                    </div><?php
                endif;
            endif;
            
        }
    }
}


if ( ! function_exists( 'bookworm_page_header' ) ) {
    /**
     * Displays Page Header
     */
    function bookworm_page_header() {

        global $post;
        $hide_page_header = false;

        if ( isset( $post->ID ) ) {
            $page_header_meta_values = get_post_meta( $post->ID, '_hide_page_header', true );
            if ( isset( $page_header_meta_values ) && $page_header_meta_values ) {
                $hide_page_header = $page_header_meta_values;
            }
        }

        if( ! $hide_page_header ) {
            if ( is_page() && apply_filters( 'bookworm_show_site_content_page_header', true ) ) : ?>
            <?php if ( apply_filters( 'bookworm_enable_page_header', true ) ) : ?>
                <?php bookworm_the_page_header(); ?>
                <?php endif; ?>
            <?php endif;
        }
    }
}


if ( ! function_exists( 'bookworm_the_page_header' ) ) {
    function bookworm_the_page_header( $title = '', $header_classes = array() ) {
        $title = empty( $title ) ? get_the_title(): $title;
        ?><div class="page__header py-3 py-lg-7 <?php echo esc_attr( implode( ' ', $header_classes ) );?>">
            <h6 class="font-weight-medium font-size-7 text-center my-1"><?php echo esc_html( $title ); ?></h6>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_page_content' ) ) {
    /**
     * Displays Page Content
     */
    function bookworm_page_content() {
        global $post;

        $page_meta_values = get_post_meta( $post->ID, '_disable_container', true );

        $article_content_additional_class = '';

        if ( ! ( isset( $page_meta_values ) && $page_meta_values) ) {
            $article_content_additional_class .= ' container';
        }

        ?><div class="article__content article__content--page<?php echo esc_attr( $article_content_additional_class ); ?>">
            <div class="page__content">
                <?php the_content(); ?>
                
            </div><!-- .page__content -->
            <?php
                $link_pages = wp_link_pages(
                array(
                    'before' => '<div class="page-links"><span class="d-block text-secondary mb-3">' . esc_html__( 'Pages:', 'bookworm' ) . '</span><nav class="pagination mb-0">',
                    'after'  => '</nav></div>',
                    'link_before' => '<span class="page-link">',
                    'link_after'  => '</span>',
                    'echo'   => 0,
                )
            );

            $link_pages = str_replace( 'post-page-numbers', 'post-page-numbers page-item', $link_pages );
            $link_pages = str_replace( 'current', 'current active', $link_pages );
            echo wp_kses_post( $link_pages );

            ?>
            
        </div>
        <?php
    }
}
