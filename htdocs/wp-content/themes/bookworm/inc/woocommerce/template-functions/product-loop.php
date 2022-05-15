<?php
/**
 * Template functions used in Product Loop
 *
 */

if ( ! function_exists( 'bookworm_product_loop_start' ) ) {

    /**
     * Output the start of a product loop. By default this is a UL.
     *
     * @param bool $echo Should echo?.
     * @return string
     */
    function bookworm_product_loop_start( $loop_start ) {
        $columns = apply_filters( 'bookworm_loop_shop_columns', wc_get_loop_prop( 'columns' ) );
        $loop_start = '<ul class="products list-unstyled row no-gutters row-cols-2 row-cols-lg-' . esc_attr( $columns ) . ' row-cols-wd-' . esc_attr( $columns ) . ' border-top border-left mb-6">';
        return $loop_start;
    }
}

if ( ! function_exists( 'bookworm_get_sidebar' ) ) {
    /**
     * Display bookworm sidebar
     *
     * @uses get_sidebar()
     * @since 1.0.0
     */
    function bookworm_get_sidebar() {
        if ( bookworm_is_product_archive() ) {
            get_sidebar( 'shop' );
        } elseif ( is_product() && bookworm_is_single_product_sidebar() ) {
            get_sidebar( 'single' );
        }
    }
}



if ( ! function_exists( 'bookworm_wc_template_loop_product_thumbnail' ) ) {

    /**
     * Get the product thumbnail for the loop.
     */
    function bookworm_wc_template_loop_product_thumbnail() {
        echo bookworm_wc_get_product_thumbnail( 'woocommerce_thumbnail', array( 'class' => 'img-fluid d-block mx-auto attachment-shop_catalog size-shop_catalog wp-post-image img-fluid' ) ); // WPCS: XSS ok.
    }
}

if ( ! function_exists( 'bookworm_wc_get_product_thumbnail' ) ) {

    /**
     * Get the product thumbnail, or the placeholder if not set.
     *
     * @param string $size (default: 'woocommerce_thumbnail').
     * @return string
     */
    function bookworm_wc_get_product_thumbnail( $size = 'woocommerce_thumbnail', $attr = array() ) {
        global $product;

        $image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );

        return $product ? $product->get_image( $image_size, $attr ) : '';
    }
}


if ( ! function_exists( 'bookworm_wc_template_loop_product_sale_flash' ) ) {
    function bookworm_wc_template_loop_product_sale_flash() {
        global $post, $product;

        if ( ! $product->is_on_sale() ) {
            return;
        }

        echo apply_filters( 'woocommerce_sale_flash', '<span class="badge badge-md badge-primary-green position-absolute badge-pos--top-right text-white rounded-circle d-flex flex-column align-items-center justify-content-center">' . esc_html__( 'Sale', 'bookworm' ) . '</span>', $post, $product );
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_categories' ) ) {
    function bookworm_wc_template_loop_product_categories() {
        global $product;
        $categories = wc_get_product_category_list( $product->get_id() );
        echo apply_filters( 'bookworm_wc_template_loop_categories_html', wp_kses( sprintf( '<div class="woocommerce-loop-product__categories text-uppercase font-size-1 mb-1 text-truncate">%s</div>', $categories ), array( 'a' => array( 'href' => array() ), 'div' => array( 'class' =>  array() ) ) ) );
    }
}

if ( ! function_exists( 'bookworm_wc_product_loop_title_classes' ) ) {
    function bookworm_wc_product_loop_title_classes( $classes ) {
        if ( bookworm_wc_view_current() === 'list' ) {
            $title_additional_classes = "";
        } else {
            $title_additional_classes = " text-height-2";
        }
        $classes = 'woocommerce-loop-product__title product__title h6 text-lh-md mb-1 crop-text-2 h-dark ' .  esc_attr( $title_additional_classes ) . '';

        return $classes;
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_format' ) ) {
    function bookworm_wc_template_loop_product_format() {
        global $product;
        $format_tax  = bookworm_get_book_format_taxonomy();
        $terms       = get_the_terms( $product->get_id(), $format_tax );
        $format_name = [];

        if ( $terms && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                $format_name[]= '<a href="'. esc_url( get_term_link( $term ) ) . '" class="text-gray-700">' . $term->name . '</a>';
                
            }
            $list = implode(', ', $format_name );
        }

        if ( ! empty ( $format_name ) ) :
        ?><div class="woocommerce-loop-product__format text-uppercase font-size-1 mb-1 text-truncate text-primary"><?php echo wp_kses( $list, array( 'a' => array( 'href' => array() ), 'div' => array( 'class' =>  array() ) ) ); ?></div><?php
        endif;
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_author' ) ) {
    function bookworm_wc_template_loop_product_author() {
        $author_name = bookworm_wc_get_product_author();

        if ( ! empty ( $author_name ) ) :
        ?><div class="woocommerce-loop-product__author font-size-2 text-truncate <?php echo bookworm_wc_view_current() === 'list' ? 'mb-2' : 'mb-1';?>"><?php echo wp_kses_post( str_replace( '</a><a ', '</a>, <a ', $author_name ) ); ?></div><?php
        endif;
    }
}

if ( ! function_exists( 'bookworm_wc_get_product_author' ) ) {
    function bookworm_wc_get_product_author( $product_id = '', $link_classes = array( 'text-gray-700' ) ) {
        global $product;

        $product_id  = empty( $product_id ) ? $product->get_id() : $product_id;
        $author_tax  = bookworm_get_book_author_taxonomy();
        $terms       = get_the_terms( $product_id, $author_tax );
        $author_name = '';

        if ( $terms && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                $author_name  .= '<a href="'. esc_url( get_term_link( $term ) ) . '" class="' . implode( ' ', (array)$link_classes ) .'">' . $term->name . '</a>';
            }
        }

        return $author_name;
    }
}

if ( ! function_exists( 'bookworm_wc_format_sale_price' ) ) {
    function bookworm_wc_format_sale_price( $price, $regular_price, $sale_price ) {
        $price = '<ins class="text-decoration-none mr-2">' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins><del class="font-size-1 font-weight-regular text-gray-700">' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';
        return $price;
    }
}

if ( ! function_exists( 'bookworm_wc_loop_add_to_cart_link' ) ) {
    function bookworm_wc_loop_add_to_cart_link( $cart_link, $product, $args ) {
        $add_to_cart = '<span class="product__add-to-cart">' . $product->add_to_cart_text() . '</span><span class="product__add-to-cart-icon font-size-4"><i class="flaticon-icon-126515"></i></span>';
        return sprintf(
            '<a href="%s" data-quantity="%s" class="%s text-uppercase text-dark h-dark font-weight-medium mr-auto" %s title="%s">%s</a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
            esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            esc_attr( $product->add_to_cart_text() ),
            wp_kses_post( $add_to_cart )
        );
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_title_link' ) ) {
    function bookworm_wc_template_loop_product_title_link() {
        global $product;
		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
        ?><h2 class="<?php echo esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ); ?>">
            <a href="<?php echo esc_url( $link ); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                <?php the_title(); ?>
            </a>
        </h2><?php
    }
}

if ( ! function_exists( 'bookworm_wc_loop_product_grid_view_wrap_open' ) ) {
    function bookworm_wc_loop_product_grid_view_wrap_open() {
        ?><div class="bookworm-product-grid"><?php
    }
}

if ( ! function_exists( 'bookworm_wc_loop_product_grid_view_wrap_close' ) ) {
    function bookworm_wc_loop_product_grid_view_wrap_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'bookworm_wc_loop_product_list_view_wrap_open' ) ) {
    function bookworm_wc_loop_product_list_view_wrap_open() {
        ?><div class="bookworm-product-list"><?php
    }
}


if ( ! function_exists( 'bookworm_wc_loop_product_list_view_wrap_close' ) ) {
    function bookworm_wc_loop_product_list_view_wrap_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_inner_open') ) {
    function bookworm_wc_template_loop_product_inner_open() {
        ?><div class="product__inner overflow-hidden p-3 p-md-4d875">
            <div class="position-relative <?php echo bookworm_wc_view_current() === 'list' ? 'row' : 'd-block';?>"><?php
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_inner_close') ) {
    function bookworm_wc_template_loop_product_inner_close() {
            ?></div>
        </div><!-- /.product__inner --><?php
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_header_open' ) ) {
    function bookworm_wc_template_loop_product_header_open() {
        ?><div class="woocommerce-loop-product__header"><?php
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_header_close' ) ) {
    function bookworm_wc_template_loop_product_header_close() {
        ?></div><!-- /.woocommerce-loop-product__header --><?php
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_body_open' ) ) {
    function bookworm_wc_template_loop_product_body_open() {
        ?><div class="woocommerce-loop-product__body product__body pt-3 bg-white"><?php
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_body_close' ) ) {
    function bookworm_wc_template_loop_product_body_close() {
        ?></div><!-- /.woocommerce-loop-product__body --><?php
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_hover_open' ) ) {
    function bookworm_wc_template_loop_product_hover_open() {
        ?><div class="woocommerce-loop-product__hover product__hover d-flex align-items-center"><?php
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_hover_close' ) ) {
    function bookworm_wc_template_loop_product_hover_close() {
        ?></div><!-- /.woocommerce-loop-product__header --><?php
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_list_image_wrap' ) ) {
    function bookworm_wc_template_loop_product_list_image_wrap() {
        global $product;
        $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
        ?><div class="col-md-auto woocommerce-loop-product__thumbnail mb-3 mb-md-0">
            <a href="<?php echo esc_url( $link ); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link d-block">
                <?php bookworm_wc_template_loop_product_thumbnail(); ?>
            </a>
        </div><?php
    }
}


if ( ! function_exists( 'bookworm_wc_template_loop_product_list_body_wrap_open' ) ) {
    function bookworm_wc_template_loop_product_list_body_wrap_open() {
        ?><div class="col-md woocommerce-loop-product__body product__body pt-3 bg-white mb-3 mb-md-0"><?php
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_list_body_wrap_close' ) ) {
    function bookworm_wc_template_loop_product_list_body_wrap_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_excerpt' ) ) {
    /**
     *
     */
    function bookworm_wc_template_loop_product_excerpt() {
        global $post;

        if ( ! is_object( $post ) || ! $post->post_excerpt ) {
            return;
        }

        ?>
        <div class="product-short-description font-size-2 mb-2 crop-text-2">
            <?php
                $product_excerpt = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

                if ( apply_filters( 'bookworm_esc_excerpt', false ) ) {
                    $product_excerpt = esc_html( $product_excerpt );
                }

                echo wp_kses_post( $product_excerpt );
            ?>
        </div>
        <?php
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_list_action_wrap_open' ) ) {
    function bookworm_wc_template_loop_product_list_action_wrap_open() {
        ?><div class="col-md-auto d-flex align-items-center"><?php
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_list_action_wrap_close' ) ) {
    function bookworm_wc_template_loop_product_list_action_wrap_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'bookworm_wc_template_loop_product_rating' ) ) {
    function bookworm_wc_template_loop_product_rating() {
        global $product;?>
        <div class="product__rating d-flex align-items-center font-size-2">
            <?php if ( post_type_supports( 'product', 'comments' ) && wc_review_ratings_enabled() ) :
                $rating_count = $product->get_rating_count();
                $review_count = $product->get_review_count();
                if ( $rating_count > 0 ) : ?>
                    <a class="bookworm-wc-star-rating d-flex align-items-center" href="#reviews" rel="nofollow" data-scroll>
                        <?php echo wc_get_rating_html( $product->get_average_rating(), $rating_count ) ?>
                        <span class="ml-2 d-inline-block text-dark">
                            (<?php printf( _n( '%s', '%s', $review_count, 'bookworm' ), esc_html( $review_count ) );?>)
                        </span>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div><?php
    }
}



