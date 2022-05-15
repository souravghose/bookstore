<?php
/**
 * Template functions for Blog
 *
 * @package bookworm
 */

if( ! function_exists( 'bookworm_posts_sidebar' ) ) {
    function bookworm_posts_sidebar() {
        $sidebar = get_theme_mod( 'blog_sidebar', 'left-sidebar' );

        if( ! is_active_sidebar( 'blog-sidebar' ) ) {
            $sidebar = 'no-sidebar';
        }

        return sanitize_key( apply_filters( 'bookworm_posts_sidebar', $sidebar ) );
    }
}

if( ! function_exists( 'bookworm_posts_layout' ) ) {
    function bookworm_posts_layout() {
        $layout = get_theme_mod( 'blog_layout', 'list' );

        return sanitize_key( apply_filters( 'bookworm_posts_layout', $layout ) );
    }
}

if( ! function_exists( 'bookworm_post_get_categories' ) ) {
    function bookworm_post_get_categories( $post_id = null ) {
        $post_id = $post_id ?: get_the_ID();

        $categories = get_the_terms( $post_id, 'category' );
        if ( empty( $categories ) || is_wp_error( $categories ) ) {
            return [];
        }

        return $categories;
    }
}

if( ! function_exists( 'bookworm_single_post_category' ) ) {
    function bookworm_single_post_category( ) {
       $_bk_categories = bookworm_post_get_categories();

       if ( ! empty( $_bk_categories ) ) : ?>
            <div class="mb-2 text-primary">
                <?php
                echo implode( ', ', array_map( function ( $category ) {
                    return sprintf( '<a href="%s" class="font-size-3 text-primary">%s</a>',
                        esc_url( get_category_link( $category ) ),
                        esc_html( $category->name )
                    );
                }, $_bk_categories ) ); ?>
            </div>
        <?php endif; unset( $_bk_categories ); 
    }
}


if ( ! function_exists( 'bookworm_post_title' ) ) {
    function bookworm_post_title() {
        the_title( '<h6 class="font-size-10 mb-3 crop-text-2 font-weight-medium text-lh-1dot4">', '</h6>' );
    }
}

if ( ! function_exists( 'bookworm_post_meta' ) ) {
    function bookworm_post_meta() { 
        $css_class = 'text-secondary-gray-700'; ?>
        <div class="single-post-meta text-secondary-gray-700">
            <a href="<?php echo esc_url( get_permalink());?>" class="post-date text-secondary-gray-700"><?php echo esc_html( get_the_date() ); ?></a>
            <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
                <span class="ml-3 post-comment-link"><?php comments_popup_link( esc_html__( '0 Comments', 'bookworm' ), esc_html__( '1 Comment', 'bookworm' ), esc_html__( '% Comments', 'bookworm' ), $css_class ); ?></span>
            <?php endif; ?>
        </div><?php
    }
}



if( ! function_exists( 'bookworm_pagination' ) ) {
    function bookworm_pagination() {
        $max_pages = isset( $GLOBALS['wp_query']->max_num_pages ) ? $GLOBALS['wp_query']->max_num_pages : 1;
        if ( $max_pages < 2 ) {
            return;
        }

        $paged = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;
        $links = paginate_links( apply_filters( 'bookworm_posts_pagination_args', [
            'type'      => 'array',
            'mid_size'  => 2,
            'prev_next' => false,
        ] ) );

        ?>
        <nav class="d-flex justify-content-center" aria-label="<?php
        /* translators: aria-label for posts navigation wrapper */
        echo esc_attr__( 'Page navigation example', 'bookworm' ); ?>">
            <ul class="pagination pagination__custom justify-content-md-center flex-nowrap flex-md-wrap overflow-auto overflow-md-visble mb-0">
               <?php if ( $paged && 1 < $paged ) : ?>
                    <li class="flex-shrink-0 flex-md-shrink-1 page-item prev">
                        <a class="page-link" href="<?php echo esc_url( get_previous_posts_page_link() ); ?>">
                            <?php
                            /* translators: label for previous posts link */
                            echo esc_html__( 'Prev', 'bookworm' ); ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

            <ul class="pagination pagination__custom justify-content-md-center flex-nowrap flex-md-wrap overflow-auto overflow-md-visble mb-0">
                <li class="page-item d-sm-none page-item-sm">
                    <span class="page-link page-link-static"><?php echo esc_html( "{$paged} / {$max_pages}" ); ?></span>
                </li>
                <?php foreach ( $links as $link ) : ?>
                    <?php if ( false !== strpos( $link, 'current' ) ) : ?>
                        <li class="flex-shrink-0 flex-md-shrink-1 page-item active d-none d-sm-block">
                            <?php echo str_replace( 'page-numbers', 'page-link', $link ); ?>
                        </li>
                    <?php else : ?>
                        <li class="flex-shrink-0 flex-md-shrink-1 page-item d-none d-sm-block">
                            <?php echo str_replace( 'page-numbers', 'page-link', $link ); ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>

            <ul class="pagination pagination__custom justify-content-md-center flex-nowrap flex-md-wrap overflow-auto overflow-md-visble mb-0">
                <?php if ( $paged && $paged < $max_pages ) : ?>
                    <li class="flex-shrink-0 flex-md-shrink-1 page-item next">
                        <a class="page-link" href="<?php echo esc_url( get_next_posts_page_link() ); ?>">
                            <?php
                            /* translators: label for next posts link */
                            echo esc_html__( 'Next', 'bookworm' ); ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php
    }
}


if( ! function_exists( 'bookworm_container_start' ) ) {
    function bookworm_container_start() { ?>
        <div class="bookworm-single-post mb-5 mb-lg-6 pb-xl-1"><div class="container"><?php
    }
}

if( ! function_exists( 'bookworm_container_end' ) ) {
    function bookworm_container_end() { ?>
        </div></div><?php
    }
}

if( ! function_exists( 'bookworm_single_post_wrap_start' ) ) {
    function bookworm_single_post_wrap_start() { ?>
        <div class="container__inner"><?php
    }
}

if( ! function_exists( 'bookworm_single_post_wrap_end' ) ) {
    function bookworm_single_post_wrap_end() { ?>
        </div><?php
    }
}

if( ! function_exists( 'bookworm_single_post_content_wrap_start' ) ) {
    function bookworm_single_post_content_wrap_start() { ?>
        <div class="article-post <?php echo esc_attr( has_post_thumbnail() ? 'max-width-940' : 'col-lg-9 px-0 px-md-5' ); ?> mx-auto bg-white position-relative"><div class="article-post__inner<?php echo esc_attr( has_post_thumbnail() ? ' mt-n10 mt-md-n13 pt-5 pt-lg-7 px-0 px-md-5 pl-xl-10 pr-xl-8' : '' ); ?> mb-8"><div class="ml-xl-4"><?php
    }
}

if( ! function_exists( 'bookworm_single_post_content_wrap_end' ) ) {
    function bookworm_single_post_content_wrap_end() { ?>
        </div></div></div><?php
    }
}

if( ! function_exists( 'bookworm_single_post_content_header' ) ) {
    function bookworm_single_post_content_header() { ?>
        <div class="mb-5 mb-lg-7">
            <?php do_action( 'bookworm_single_post_header' ); ?>
        </div><?php
            
    }
}


if( ! function_exists( 'bookworm_single_post_media' ) ) {
    function bookworm_single_post_media() {
        $post_format = get_post_format();

        if ( 'video' === $post_format && !empty( get_post_meta( get_the_ID(), '_video_field', true ) ) ) {
            bookworm_post_video();    
        } elseif ( 'audio' == $post_format && !empty( get_post_meta( get_the_ID(), '_audio_field', true ) ) ) {
            bookworm_post_audio();
        } elseif ( 'gallery' == $post_format && !empty( get_post_meta( get_the_ID(), '_gallery_images', true ) ) ) {
            bookworm_post_gallery();
        }  elseif ( bookworm_can_show_post_thumbnail() ) {
            bookworm_single_post_thumbnail();
        }
    }
}

if( ! function_exists( 'bookworm_can_show_post_thumbnail' ) ) {
    function bookworm_can_show_post_thumbnail() {
        return apply_filters( 'bookworm_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() );
    }
}

if ( ! function_exists( 'bookworm_single_post_thumbnail' ) ) {
    function bookworm_single_post_thumbnail() {

        if ( ! bookworm_can_show_post_thumbnail() && ('image' !== $post_format || 'standard' !== $post_format || 'aside' !== $post_format || 'status' !== $post_format )) {
            return;
        }

         the_post_thumbnail('full', array( 'class' => 'img-fluid d-block mx-auto' )); 
    }
}

if ( ! function_exists( 'bookworm_post_gallery' ) ) {
    /**
     * Displays post gallery when applicable
     */
    function bookworm_post_gallery() {
        $clean_post_format_gallery_meta_values = get_post_meta( get_the_ID(), '_gallery_images', true );
        $attachments = json_decode( stripslashes( $clean_post_format_gallery_meta_values ), true );
        if ( ! empty( $attachments ) ) :

            $count = count( $attachments ); ?>

            <div class="js-slick-carousel u-slick u-slick--gutters-3 my-5 my-lg-8"
                 data-infinite="true"
                 data-slides-show="1"
                 data-slides-scroll="1"
                 data-pagi-classes="text-center u-slick__pagination mt-5 mb-0">
                         
                <?php foreach( $attachments as $attachment ) : 
                    $caption = !empty( $attachment['caption'] ) ? $attachment['caption'] : $attachment['alt']; ?>
                    <a class="gallery-item" href="<?php echo wp_get_attachment_image( $attachment['id'], 'full' ); ?>" <?php if( !empty($caption) ) echo 'data-sub-html="<h6 class=&quot;font-size-sm text-light&quot;>' . esc_html( $caption ) . '</h6>"' ?>>
                        <?php echo wp_get_attachment_image( $attachment['id'], 'post-thumbnail' ); ?>
                        <?php if( !empty($caption) ) : ?>
                            <span class="gallery-item-caption"><?php echo esc_html( $caption ); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
           
            <?php

        endif;
    }
}

if ( ! function_exists( 'bookworm_post_audio' ) ) {
    /**
     * Displays post audio when applicable
     */
    function bookworm_post_audio() {
        $embed_audio  = get_post_meta( get_the_ID(), '_audio_field', true );

        if ( isset($embed_audio) && $embed_audio != '' ) {
            // Embed Audio

            if( !empty($embed_audio) ) {
                ?><div class="post-media"><?php 
                // run oEmbed for known sources to generate embed code from audio links
                echo apply_filters( 'the_content', $embed_audio )

                ?></div><!-- .article__attachment--video --><?php
            }

        }
    }
}

if ( ! function_exists( 'bookworm_post_video' ) ) {
    /**
     * Displays post video when applicable
     */
    function bookworm_post_video() {
        $embed_video  = get_post_meta( get_the_ID(), '_video_field', true );

        if ( isset($embed_video) && $embed_video != '' ) {
            // Embed Audio

            if( !empty($embed_video) ) {
                ?><div class="video-container post-media"><?php 
                // run oEmbed for known sources to generate embed code from audio links
                echo apply_filters( 'the_content', $embed_video )

                ?></div><!-- .article__attachment--video --><?php
            }

        }
    }
}

if( ! function_exists( 'bookworm_single_post_content' ) ) {
    function bookworm_single_post_content() {
        the_content();
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

    }
}

if ( ! function_exists( 'bookworm_single_post_content_footer' ) ) :
/**
 * Displays Footer of Single Post
 */
function bookworm_single_post_content_footer() {
    ob_start();
    bookworm_single_post_tags();
    bookworm_single_post_share();
    bookworm_single_post_author();
    bookworm_comments();
    $output_content = ob_get_clean();

    if( ! empty( $output_content ) ) {
        echo sprintf( '<div class="col-lg-9 px-0 px-md-5 mx-auto"><div class="' . esc_attr( has_post_thumbnail() ? ' px-md-5 pl-xl-10 pr-xl-4' : 'post-content-footer' ) .'"><div class="ml-xl-4">%s</div></div></div>', $output_content );

    }
}
endif;

if ( ! function_exists( 'bookworm_single_post_tags' ) ) :
/**
 * Displays Single Post Tags in Post Footer
 */
function bookworm_single_post_tags() {

    if ( apply_filters( 'bookworm_single_post_tags_enabled', true ) ) :

        $tags_list = get_the_tag_list( '<div class="d-flex flex-wrap">', ' ', '</div>' );
        if ( $tags_list ) {
            printf(
                '<div class="pb-7 tag-links"><span class="sr-only">%1$s </span>%2$s</div>',
                esc_html__( 'Tags:', 'bookworm' ),
                $tags_list
            ); // WPCS: XSS OK.
        }
    endif;
}
endif;



if ( ! function_exists( 'bookworm_single_post_share' ) ) :
/**
 * Displays Sharing Block in Single post_tag
 */
 function bookworm_single_post_share() {
     if ( apply_filters( 'bookworm_single_post_share_enabled', true ) &&
            function_exists( 'sharing_display' ) ) { ?>
            <hr class="mb-7 mt-0">
            <div class="mb-7">
                <?php sharing_display( '', true ); ?>
            </div><?php
     }
 }
endif;

if ( ! function_exists( 'bookworm_single_post_author' ) ) :
/**
 * Display Author Information in Single Post
 */
function bookworm_single_post_author() {
    if ( apply_filters( 'bookworm_single_post_author_enabled', filter_var( get_theme_mod( 'blog_author_info', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) ) {  ?>
        <div class="mb-4 pb-1">
            <div class="bg-gray-200 py-3 py-md-5 px-3 px-md-6">
                <!-- Author -->
                <div class="d-md-flex align-items-center">
                    <a class="d-block text-center text-md-left mb-3 mb-md-0" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 120, '', '', array( 'class' => 'img-fluid rounded-circle max-width-120 height-120 mr-md-4' ) ); ?>
                    </a>
                    <div class="text-center text-md-left">
                        <h6 class="font-weight-medium font-size-3"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo esc_html( get_the_author() ); ?></a></h6>

                         <p class="font-size-2 mb-0"><?php the_author_meta( 'description' ); ?></p>

                          <?php if ( apply_filters( 'enable_author_social_links', TRUE ) ) :

                            $twitter            = esc_attr( get_post_meta( get_the_ID(), '_twitter', true ) );
                            $facebook           = esc_attr( get_post_meta( get_the_ID(), '_facebook', true ) );
                            $google_plus        = esc_attr( get_post_meta( get_the_ID(), '_google_plus', true ) );


                            $social_icons = apply_filters( 'reen_author_social_links_icons_args', array(
                                'facebook'  => array( 
                                    'class'         => 'facebook', 
                                    'icon'          => 'icon-s-facebook', 
                                    'title'         => esc_html__( 'Add me on Facebook', 'bookworm' ),
                                    'social_link'   => $facebook 
                                ),

                                'google_plus'          => array( 
                                    'class'         => 'google_plus', 
                                    'icon'          => 'icon-s-gplus', 
                                    'title'         => esc_html__( 'Add me on Google Plus', 'bookworm' ),
                                    'social_link'   => $google_plus 
                                ),
                                'twitter'       => array( 
                                    'class'         => 'twitter', 
                                    'icon'          => 'icon-s-twitter', 
                                    'title'         => esc_html__( 'Follow me on Twitter', 'bookworm' ),
                                    'social_link'   => $twitter 
                                ),
                                    
                                )
                            );
                            ?>
                            <ul class="list-unstyled mb-0 d-md-flex">
                                <?php foreach ($social_icons as $social_icon) : ?>
                                    <?php if( !empty( $social_icon['social_link'] ) ) :?>
                                    <?php $url = !empty( $social_icon['link_prefix'] ) ? $social_icon['link_prefix'] . ':' . $social_icon['social_link'] : esc_url( $social_icon['social_link'] ); ?>
                                    <li class="btn">
                                        <a href="<?php echo esc_url( $url ); ?>"><i class="<?php echo esc_attr( $social_icon['icon'] ); ?>"></i></a>
                                    </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif;?>

                    </div>
                </div>
            
            </div>
        </div><?php
    }
}
endif;

if ( ! function_exists( 'bookworm_single_post_nav' ) ) :
/**
 * Displays navigation for Single Posts
 */
function bookworm_single_post_nav() {
    if ( apply_filters( 'bookworm_single_post_nav_enabled', true ) && wp_count_posts()->publish > 1 ) :
    ?><div class="mb-5 mb-md-7">
       
        <nav class="navigation post-navigation" role="navigation">
            <h2 class="screen-reader-text"><?php echo esc_html__( 'Post navigation', 'bookworm' ); ?></h2>
            <div class="d-md-flex justify-content-between post-navigation__inner">
                <div class="nav-previous col-sm-6">
                    <?php
                        echo get_previous_post_link(
                            '%link',
                            '<div class="d-flex">' .
                            '<div><div class="bg-gray-200 p-2 rounded-circle d-inline-block"><i class="flaticon-left-arrow text-dark mx-1"></i></div></div>' .
                            '<div class="ml-3"><div class="font-size-2 text-secondary-gray-700 page-link-label">' . esc_html__( 'Previous Post', 'bookworm' ) . '</div><span class="link-black-100">%title</span></div>' .
                            '</div>'
                        );
                    ?>
                </div>
               
                <div class="nav-next col-sm-6">
                <?php
                    echo get_next_post_link(
                        '%link',
                        '<div class="d-flex justify-content-end">' .
                        '<div><div class="font-size-2 text-right text-secondary-gray-700 page-link-label">' . esc_html__( 'Next Post', 'bookworm' ) . '</div><span class="link-black-100">%title</span></div>' .
                        '<div class="ml-3"><div class="bg-gray-200 p-2 rounded-circle d-inline-block"><i class="flaticon-right-arrow text-dark mx-1"></i></div></div>' .
                        '</div>'
                    );
                ?>
                </div>
            </div>
        </nav>
        
    </div><?php
    endif;
}
endif;

if( ! function_exists( 'bookworm_related_posts' ) ) {
    function bookworm_related_posts() {
        $post_id = get_the_ID();
        $related_posts = get_post_meta( $post_id, '_relatedPosts', true );

        $related_posts = json_decode( stripslashes( $related_posts ), true );

        if ( empty( $related_posts ) ) {
            return;
        }

        ?>
        <div class="border-bottom mb-5 pb-5">
            <h6 class="font-weight-medium font-size-3 mb-4"><?php
                /* translators: related posts heading */
                echo esc_html__( 'You may also like','bookworm'); ?></h6>
            <div class="row row-cols-1 row-cols-lg-2">
                <?php
                while ( $query->have_posts() ):
                    $query->the_post();
                    get_template_part( 'templates/blog/loop', 'related' );
                endwhile;
                wp_reset_postdata(); ?>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'bookworm_single_related_posts' ) ) {
    function bookworm_single_related_posts() {
        if ( apply_filters( 'bookworm_enable_related_posts', filter_var( get_theme_mod( 'blog_related_posts', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) ) {
            if( empty( $post_id ) ) {
                $post_id = get_the_ID();
            }

            $tags = wp_get_post_terms( $post_id, 'post_tag', ['fields' => 'ids'] );

            if ( empty( $tags ) ) {
                return;
            }
            
            $related_post = new WP_Query(array( 
                'post_type'             => 'post',
                'post_status'           => 'publish',
                'ignore_sticky_posts'   => 1,
                'orderby'               => 'date',
                'order'                 => 'desc',
                'posts_per_page'        => 2,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'post_tag',
                        'terms'    => $tags
                    ),
                ),
            ));


            if ( $related_post->have_posts() ) : ?>         
                <div class="border-bottom mb-5 pb-5">
                    <h6 class="font-weight-medium font-size-3 mb-4"><?php
                        /* translators: related posts heading */
                        echo esc_html__( 'You May Also Like','bookworm'); ?></h6>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2">
                        <?php
                        while ( $related_post->have_posts() ):
                            $related_post->the_post();
                            get_template_part( 'templates/blog/loop', 'related' );
                        endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                </div><?php
            endif;
        }
    }
}

if( ! function_exists( 'bookworm_comments' ) ) {
    function bookworm_comments() {
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
    }
}

if( ! function_exists( 'bookworm_comment_form_default_fields' ) ) {
    function bookworm_comment_form_default_fields( $fields ) {
        $commenter = wp_get_current_commenter();
        $is_req    = (bool) get_option( 'require_name_email', 1 );

        // Remove url field
        unset( $fields['url'] );

        // Update other fields
        $fields['author'] = sprintf(
            '<div class="form-group comment-form-author mb-5">
                <label class="form-label text-dark mb-2" for="author">%1$s%4$s</label>
                <input type="text" name="author" id="author" class="form-control" value="%2$s" maxlength="245" %3$s>
            </div>',
            /* translators: comment author name */
            esc_html__( 'Your name','bookworm' ),
            esc_attr( $commenter['comment_author'] ),
            $is_req ? 'required' : '',
            $is_req ? '<span class="text-danger">*</span>' : ''
        );

        $fields['email'] = sprintf(
            '<div class="form-group comment-form-email mb-5">
                <label class="form-label text-dark mb-2" for="email">%1$s%4$s</label>
                <input type="email" name="email" id="email" class="form-control" value="%2$s" maxlength="100" aria-describedby="email-notes" %3$s>
            </div>',
            /* translators: comment author e-mail */
            esc_html__( 'Your email','bookworm' ),
            esc_attr( $commenter['comment_author_email'] ),
            $is_req ? 'required' : '',
            $is_req ? '<span class="text-danger">*</span>' : ''
        );

        if ( isset( $fields['cookies'] ) ) {
            $consent           = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
            $fields['cookies'] = sprintf(
                '<div class="custom-control custom-checkbox mb-5 comment-form-cookies-consent">
                    <input type="checkbox" id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="custom-control-input" value="yes"' . $consent . '>
                    <label class="custom-control-label text-dark font-weight-medium" for="wp-comment-cookies-consent">%s</label>
                </div>',
                esc_html__( 'Save my name and email in this browser for the next time I comment.','bookworm' )
            );
        }

        return $fields;
    }
}

if( ! function_exists( 'bookworm_comments_navigation' ) ) {
    function bookworm_comments_navigation() {
        if ( absint( get_comment_pages_count() ) === 1 ) {
            return;
        }

        /* translators: label for link to the previous comments page */
        $prev_text = esc_html__( 'Older comments', 'bookworm' );
        $prev_link = get_previous_comments_link( '<i class="czi-arrow-left mr-2"></i>' . $prev_text );

        /* translators: label for link to the next comments page */
        $next_text = esc_html__( 'Newer comments','bookworm' );
        $next_link = get_next_comments_link( $next_text . '<i class="czi-arrow-right ml-2"></i>' );

        ?>
        <nav class="navigation comment-navigation d-flex justify-content-between mt-4" role="navigation">
            <h3 class="screen-reader-text sr-only"><?php
                /* translators: navigation through comments */
                echo esc_html__( 'Comment navigation','bookworm' ); ?></h3>
            <?php if ( $prev_link ) : ?>
                <ul class="pagination">
                    <li class="page-item">
                        <?php echo str_replace( '<a ', '<a class="page-link" ', $prev_link ); ?>
                    </li>
                </ul>
            <?php endif; ?>
            <?php if ( $next_link ) : ?>
                <ul class="pagination">
                    <li class="page-item">
                        <?php echo str_replace( '<a ', '<a class="page-link" ', $next_link ); ?>
                    </li>
                </ul>
            <?php endif; ?>
        </nav>
        <?php
    }
}


if ( ! function_exists( 'bookworm_post_protected_password_form' ) ) :
    function bookworm_post_protected_password_form() {
        global $post;

        $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID ); ?>

        <form class="protected-post-form input-group bookworm-protected-post-form" action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" method="post">
            <p><?php echo esc_html__( 'This content is password protected. To view it please enter your password below:', 'bookworm' ); ?></p>
            <div class="d-flex align-items-center w-md-85">
                <label class="text-secondary mb-0 mr-3 d-none d-md-block" for="<?php echo esc_attr( $label ); ?>"><?php echo esc_html__( 'Password:', 'bookworm' ); ?></label>
                <div class="d-flex flex-wrap">
                    <input class="input-text form-control w-auto" name="post_password" id="<?php echo esc_attr( $label ); ?>" type="password" style="border-top-right-radius: 0; border-bottom-right-radius: 0;"/>
                    <input type="submit" name="Submit" class="btn btn-dark rounded-0 font-weight-medium" value="<?php echo esc_attr( "Submit" ); ?>" style="border-top-left-radius: 0; border-bottom-left-radius: 0; transform: none;"/>
                </div>
            </div>
        </form><?php
    }
endif;

if ( ! function_exists( 'bookworm_post_pagination_spacing' ) ) {
    function bookworm_post_pagination_spacing() {
        ?><div class="space-bottom-2"></div><?php
    }
}