<?php
/**
 * Template functions for Footer
 *
 * @package bookworm
 */
if ( ! function_exists( 'bookworm_footer_version' ) ) {
    /**
     * Footer Version
     */
    function bookworm_footer_version() {
        $footer_version = get_theme_mod( 'footer_version', 'v1' );
        return apply_filters( 'bookworm_footer_version', $footer_version );
    }
}

if ( ! function_exists( 'bookworm_footer_widgets' ) ) {
    /**
    * Display the footer widget regions.
    *
    * @since  1.0.0
    * @return void
    */
    function bookworm_footer_widgets( $wrapper_classes='', $contact_info_column_classes='', $contact_info_padding_classes='',$footer_region='4', $footer_version='' ) {
        $rows    = intval( apply_filters( 'bookworm_footer_widget_rows', 1 ) );
        $regions = intval( apply_filters( 'bookworm_footer_widget_columns',$footer_region ) );
        if( empty( $footer_version ) ) {
            $footer_version = apply_filters( 'bookworm_footer_version', get_theme_mod( 'footer_version', 'v1' ) );
        }

        for ( $row = 1; $row <= $rows; $row++ ) :

            // Defines the number of active columns in this footer row.
            for ( $region = $regions; 0 < $region; $region-- ) {
                if ( is_active_sidebar( 'footer-' . esc_attr( $region + $regions * ( $row - 1 ) ) ) ) {
                    $columns = $region;
                    break;
                }
            }

            if ( isset( $columns ) ) :
                do_action( "bookworm_before_footer_content_{$footer_version}" ); 
                ?><div class="<?php echo esc_attr( $wrapper_classes ); ?>">
                    
                    <div class="container">
                        <?php do_action( "bookworm_before_footer_widgets_{$footer_version}" ); ?>
                        <div class="row footer-top-row">
                            <?php if( $footer_version == 'v1' || $footer_version == 'v3' || $footer_version == 'v5' || $footer_version == 'v6' || $footer_version == 'v9' || $footer_version == 'v10' || $footer_version == 'v11' ) : ?>
                                <div class="<?php echo esc_attr( $contact_info_column_classes ); ?>">
                                    <div class="<?php echo esc_attr( $contact_info_padding_classes ); ?>">
                                        <?php bookworm_contact_info(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ( apply_filters( 'bookworm_enable_footer_widgets', true ) ): ?>
                                <?php do_action( "bookworm_footer_widgets_{$footer_version}",$row, $regions, $columns ); ?>
                            <?php endif; ?>
                            
                        </div>
                        <?php do_action( "bookworm_after_footer_widgets_{$footer_version}" ); ?>
                    </div>
                    
                </div>
                <?php do_action( "bookworm_after_footer_content_{$footer_version}" ); 
                unset( $columns );
            endif;
        endfor;
    }
}

if ( ! function_exists( 'bookworm_footer_widgets_columns' ) ) {
    function bookworm_footer_widgets_columns( $row, $regions, $columns ) {
        for ( $column = 1; $column <= $columns; $column++ ) :
            $footer_n = $column + $regions * ( $row - 1 );
            $widget_area = apply_filters( "bookworm_footer_widget-${footer_n}", 'footer-' . esc_attr( $footer_n ) );

            if ( is_active_sidebar( $widget_area ) ) : ?>
                <div class="col-lg-2 mb-6 mb-lg-0">
                    <?php dynamic_sidebar( $widget_area ); ?>
                </div>
                <?php
            endif;
        endfor;
    }
}

if ( ! function_exists( 'bookworm_footer_widgets_column_v2' ) ) {
    function bookworm_footer_widgets_column_v2( $row, $regions, $columns ) {
        for ( $column = 1; $column <= $columns; $column++ ) :
            $footer_n = $column + $regions * ( $row - 1 );
            $widget_area = apply_filters( "bookworm_footer_widget_2-${footer_n}", 'footer-' . esc_attr( $footer_n ) );

            if ( is_active_sidebar( $widget_area ) ) : ?>
                <div class="<?php if($column == 4 || $column == 5) : ?>col-lg-3 mb-6 mb-lg-0<?php else : ?>col-lg-2 mb-6 mb-lg-0<?php endif; ?>">
                    <?php dynamic_sidebar( $widget_area ); ?>
                </div>
                <?php
            endif;
        endfor;
    }
}

if ( ! function_exists( 'bookworm_footer_widgets_column_v4' ) ) {
    function bookworm_footer_widgets_column_v4( $row, $regions, $columns ) {
        for ( $column = 1; $column <= $columns; $column++ ) :
            $footer_n = $column + $regions * ( $row - 1 );
            $widget_area = apply_filters( "bookworm_footer_widget_4-${footer_n}", 'footer-' . esc_attr( $footer_n ) );

            if ( is_active_sidebar( $widget_area ) ) : ?>
                <div class="<?php if( $column == 1 || $column == 4 ) : ?>col-lg-4 mb-6 mb-lg-0<?php else : ?>col-lg-2 mb-6 mb-lg-0<?php endif; ?>">
                    <?php dynamic_sidebar( $widget_area ); ?>
                </div>
                <?php
            endif;
        endfor;
    }
}

if ( ! function_exists( 'bookworm_footer_widgets_column_v6' ) ) {
    function bookworm_footer_widgets_column_v6( $row, $regions, $columns ) {
        for ( $column = 1; $column <= $columns; $column++ ) :
            $footer_n = $column + $regions * ( $row - 1 );
            $widget_area = apply_filters( "bookworm_footer_widget_6-${footer_n}", 'footer-' . esc_attr( $footer_n ) );

            if ( is_active_sidebar( $widget_area ) ) : ?>
                <div class="col-md-4 col-lg-2 mb-5 mb-md-0">
                    <?php dynamic_sidebar( $widget_area ); ?>
                </div>
                <?php
            endif;
        endfor;
    }
}

if ( ! function_exists( 'bookworm_footer_widgets_column_v7' ) ) {
    function bookworm_footer_widgets_column_v7( $row, $regions, $columns ) {
        for ( $column = 1; $column <= $columns; $column++ ) :
            $footer_n = $column + $regions * ( $row - 1 );
            $widget_area = apply_filters( "bookworm_footer_widget_7-${footer_n}", 'footer-' . esc_attr( $footer_n ) );

            if ( is_active_sidebar( $widget_area ) ) : ?>
                <div class="<?php if( $column == 5 ) : ?>col-lg-4 mb-5 mb-lg-0<?php else : ?>col-md-3 col-lg-2 mb-5 mb-lg-0<?php endif; ?>">
                    <?php dynamic_sidebar( $widget_area ); ?>
                </div>
                <?php
            endif;
        endfor;
    }
}

if ( ! function_exists( 'bookworm_footer_widgets_column_v8' ) ) {
    function bookworm_footer_widgets_column_v8( $row, $regions, $columns ) {
        for ( $column = 1; $column <= $columns; $column++ ) :
            $footer_n = $column + $regions * ( $row - 1 );
            $widget_area = apply_filters( "bookworm_footer_widget_8-${footer_n}", 'footer-' . esc_attr( $footer_n ) );

            if ( is_active_sidebar( $widget_area ) ) : ?>
                <div class="<?php if( $column == 1 ) : ?>col-md-4 col-lg-4 mb-5 mb-lg-0<?php elseif( $column == 4) : ?>col-lg-4 mb-5 mb-lg-0<?php else: ?>col-md-4 col-lg-2 mb-5 mb-lg-0<?php endif; ?>">
                    <?php if ( $column == 4 ): ?>
                        <div class="pl-lg-7">
                    <?php endif; ?>
                    <?php dynamic_sidebar( $widget_area ); ?>
                    <?php if ( $column == 4 ): ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
            endif;
        endfor;
    }
}

if ( ! function_exists( 'bookworm_footer_widgets_column_v9' ) ) {
    function bookworm_footer_widgets_column_v9( $row, $regions, $columns ) {
        for ( $column = 1; $column <= $columns; $column++ ) :
            $footer_n = $column + $regions * ( $row - 1 );
            $widget_area = apply_filters( "bookworm_footer_widget_9-${footer_n}", 'footer-' . esc_attr( $footer_n ) );

            if ( is_active_sidebar( $widget_area ) ) : ?>
                <div class="col-lg-2 mb-5 mb-lg-0">
                    <?php dynamic_sidebar( $widget_area ); ?>
                </div>
                <?php
            endif;
        endfor;
    }
}

if ( ! function_exists( 'bookworm_footer_widgets_column_v10' ) ) {
    function bookworm_footer_widgets_column_v10( $row, $regions, $columns ) {
        for ( $column = 1; $column <= $columns; $column++ ) :
            $footer_n = $column + $regions * ( $row - 1 );
            $widget_area = apply_filters( "bookworm_footer_widget_10-${footer_n}", 'footer-' . esc_attr( $footer_n ) );

            if ( is_active_sidebar( $widget_area ) ) : ?>
                <div class="col-md-4 col-lg-2 mb-5 mb-md-0">
                    <?php dynamic_sidebar( $widget_area ); ?>
                </div>
                <?php
            endif;
        endfor;
    }
}

if ( ! function_exists( 'bookworm_footer_widgets_column_v12' ) ) {
    function bookworm_footer_widgets_column_v12( $row, $regions, $columns ) {
        for ( $column = 1; $column <= $columns; $column++ ) :
            $footer_n = $column + $regions * ( $row - 1 );
            $widget_area = apply_filters( "bookworm_footer_widget_12-${footer_n}", 'footer-' . esc_attr( $footer_n ) );

            if ( is_active_sidebar( $widget_area ) ) : ?>
                <div class="<?php if( $column == 5) : ?>col-lg-3 mb-5 mb-lg-0<?php elseif( $column == 4) : ?>col-md-4 col-lg-3 mb-5 mb-lg-0<?php else: ?>col-md-4 col-lg-2 mb-5 mb-lg-0<?php endif; ?>">
                    <?php dynamic_sidebar( $widget_area ); ?>
                </div>
                <?php
            endif;
        endfor;
    }
}

if ( ! function_exists( 'bookworm_footer_widgets_column_v13' ) ) {
    function bookworm_footer_widgets_column_v13( $row, $regions, $columns ) {
        for ( $column = 1; $column <= $columns; $column++ ) :
            $footer_n = $column + $regions * ( $row - 1 );
            $widget_area = apply_filters( "bookworm_footer_widget_13-${footer_n}", 'footer-' . esc_attr( $footer_n ) );

            if ( is_active_sidebar( $widget_area ) ) : ?>
                <div class="<?php if( $column == 1  || $column == 4 ) : ?>col-md-6 col-lg-4 mb-5 mb-lg-0<?php else: ?>col-md-6 col-lg-2 mb-5 mb-lg-0<?php endif; ?>">
                    <?php if ( $column == 4 ): ?>
                        <div class="pl-lg-7">
                    <?php endif; ?>
                    <?php dynamic_sidebar( $widget_area ); ?>
                    <?php if ( $column == 4 ): ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
            endif;
        endfor;
    }
}

if ( ! function_exists( 'bookworm_custom_widget_nav_menu_options' ) ) :
    function bookworm_custom_widget_nav_menu_options( $widget, $return, $instance ) {
        // Are we dealing with a nav menu widget?
        if ( 'nav_menu' == $widget->id_base ) {
            $is_social_icon_menu = isset( $instance['is_social_icon_menu'] ) ? $instance['is_social_icon_menu'] : '';
            ?>
                <p>
                    <input class="checkbox" type="checkbox" id="<?php echo esc_attr( $widget->get_field_id('is_social_icon_menu') ); ?>" name="<?php echo esc_attr( $widget->get_field_name('is_social_icon_menu') ); ?>" <?php checked( true , $is_social_icon_menu ); ?> />
                    <label for="<?php echo esc_attr( $widget->get_field_id('is_social_icon_menu') ); ?>">
                        <?php esc_html_e( 'Is Social Icon Menu', 'bookworm' ); ?>
                    </label>
                </p>
            <?php
        }
    }
endif;

if ( ! function_exists( 'bookworm_custom_widget_nav_menu_options_update' ) ) :
    function bookworm_custom_widget_nav_menu_options_update( $instance, $new_instance, $old_instance, $widget ) {
        if ( 'nav_menu' == $widget->id_base ) {
            if ( isset( $new_instance['is_social_icon_menu'] ) && ! empty( $new_instance['is_social_icon_menu'] ) ) {
                $instance['is_social_icon_menu'] = 1;
            }
        }

        return $instance;
    }
endif;

if ( ! function_exists( 'bookworm_custom_widget_nav_menu_args' ) ) :
    function bookworm_custom_widget_nav_menu_args( $nav_menu_args, $nav_menu, $args, $instance ) {
        if( empty( $footer_version ) ) {
            $footer_version = apply_filters( 'bookworm_footer_version', get_theme_mod( 'footer_version', 'v1' ) );
        }

        if ($footer_version == 'v1' || $footer_version == 'v3' || $footer_version == 'v5' || $footer_version == 'v10' || $footer_version == 'v11' ) {
            $nav_link_classes = 'link-black-100';
        } elseif ( $footer_version == 'v9' ) {
            $nav_link_classes = 'text-white';
        } elseif ( $footer_version == 'v6' ) {
            $nav_link_classes = 'text-gray-500';
        } elseif ( $footer_version == 'v13' ) {
            $nav_link_classes = 'link-black-100';
        } elseif ( $footer_version == 'v8' ) {
            $nav_link_classes = 'text-white';
        } else {
            $nav_link_classes = 'text-gray-450';
        }
        
        if( isset( $instance['is_social_icon_menu'] ) && ! empty( $instance['is_social_icon_menu'] ) ) {
            $social_nav_menu_args =   array(
                'theme_location'  => 'social_media',
                'walker'          => new WP_Bootstrap_Navwalker(),
                'item_class'      => 'btn',
                'menu_item_class' => false,
                'nav_link_class'  => $nav_link_classes,
                'icon_txt_class'  => 'sr-only',
                'depth'           => 1,
                'container'       => false,
                'menu_class'      => 'list-unstyled mb-0 d-flex social-menu',
                'schema'          => false,
            );

            $nav_menu_args = array_merge( $nav_menu_args, $social_nav_menu_args );
        }

        return $nav_menu_args;
    }
endif;


if ( ! function_exists( 'bookworm_footer_newsletter' ) ) {
    /**
    * Displays Footer Newsletter
    *
    */
    function bookworm_footer_newsletter(  $footer_version='' ) {
         if( apply_filters( 'bookworm_footer_newsletter', filter_var( get_theme_mod( 'enable_newsletter_form', 'no' ), FILTER_VALIDATE_BOOLEAN )  ) ) {
            $newsletter_title = apply_filters( 'bookworm_footer_newsletter_title', get_theme_mod( 'bookworm_newsletter_title', esc_html__( 'Join Our Newsletter', 'bookworm' ) ) );
            $newsletter_desc  = apply_filters( 'bookworm_footer_newsletter_desc', get_theme_mod( 'bookworm_newsletter_desc', esc_html__( 'Signup to be the first to hear about exclusive deals, special offers and upcoming collections', 'bookworm' ) ) );

            $newsletter_form = apply_filters( 'bookworm_footer_newsletter_shortcode', get_theme_mod('bookworm_newsletter_form') );

            if( empty( $footer_version ) ) {
                $footer_version = apply_filters( 'bookworm_footer_version', get_theme_mod( 'footer_version', 'v1' ) );
            }

            if ( $footer_version =='v3' ) {
                $footer_before_content_classes =' space-bottom-lg-3 mb-6 mb-lg-0';
            } elseif ( $footer_version =='v6' ) {
                $footer_before_content_classes =' space-1 space-lg-2';
            } elseif ( $footer_version =='v9' ) {
                $footer_before_content_classes =' space-2';
            } elseif ( $footer_version =='v10' )  {
                $footer_before_content_classes =' space-bottom-2 space-bottom-lg-3';
            } elseif ( $footer_version =='v11' )  {
                $footer_before_content_classes =' space-bottom-2 space-bottom-md-3';
            } else {
                $footer_before_content_classes =' space-bottom-2 space-bottom-md-3';
            }


            

            ?><div class="footer-before-content<?php echo esc_attr ( $footer_before_content_classes );?>">
                <?php if ( ! empty( $newsletter_title ) || ! empty( $newsletter_desc )  ): ?>
                    <div class="text-center mb-5">
                        <?php if ( ! empty( $newsletter_title ) ) : ?>
                            <h5 class="font-size-7 font-weight-medium"><?php echo esc_html( $newsletter_title ); ?></h5>
                        <?php endif; ?>
                        <?php if ( ! empty( $newsletter_desc ) ) : ?>
                            <p class="text-gray-700"><?php echo esc_html( $newsletter_desc ); ?></p>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

                 <?php if ( ! empty( $newsletter_form ) ) :
                    echo do_shortcode( $newsletter_form );
                    
                else :
                    footer_newsletter_form();
                endif; ?>

                
            </div><?php

        }
    }
}

if ( ! function_exists( 'footer_newsletter_form' ) ) {
    /**
     * Bookworm Footer Newsletter Form
     */
    function footer_newsletter_form() {
        ob_start();
        ?>

        <div class="form-row justify-content-center newsletter-form">
            <div class="col-md-5 mb-3 mb-md-2 left-column">
                <div class="js-form-message">
                    <div class="input-group">
                        <input type="text" class="form-control px-5 height-60 border-dark" name="name" id="signupSrName" placeholder="Enter email for weekly newsletter." aria-label="Your name" required="" data-msg="Name must contain only letters." data-error-class="u-has-error" data-success-class="u-has-success">
                    </div>
                </div>
            </div>
            <div class="col-sm-2 ml-md-2 right-column">
                <button type="submit" class="btn btn-dark rounded-0 btn-wide py-3 font-weight-medium"><?php echo esc_html( __( 'Subscribe', 'bookworm' ) ); ?>
                </button>
            </div>
        </div>
        <?php
        $footer_newsletter_form = ob_get_clean();

        echo apply_filters( 'bookworm_footer_newsletter_form', $footer_newsletter_form );

       
    }
}

if ( ! function_exists( 'bookworm_contact_info' ) ) {
    /**
     * Displays the site's contact Info
     *
     * @since  1.0.0
     * @return void
     */
    function bookworm_contact_info() {

        /**
         * Functions hooked in to bookworm_contact_info action
         *
         * @hooked bookworm_footer_logo        - 10
         * @hooked bookworm_shop_address       - 20
         * @hooked bookworm_contact_links      - 30
         * @hooked bookworm_social_media_links - 40
         */
        do_action( 'bookworm_contact_info' );
    }
}

if ( ! function_exists( 'bookworm_footer_logo' ) ) {
    /**
     * Displays Logo in Footer
     *
     * @since  1.0.0
     * @return void
     */
    function bookworm_footer_logo() {
        $footer_custom_logo_id =  (int) get_theme_mod( 'footer_logo' );

        $custom_logo_id = apply_filters( 'bookworm_footer_custom_logo', '');
        if( apply_filters( 'bookworm_site_logo_svg', filter_var( get_theme_mod( 'enable_logo', 'no' ), FILTER_VALIDATE_BOOLEAN ) ))  {
            ob_start();
            bookworm_get_template( 'global/logo-svg.php' );
            $bookworm_logo_svg = ob_get_clean();
            $html = sprintf('<a href="%1$s" class="footer-logo-link d-inline-block mb-5">%2$s</a>',
                    esc_url( home_url( '/' ) ),
                    $bookworm_logo_svg
            );
        } elseif ( !empty ($custom_logo_id)) {
            $custom_logo_attr = [
                'class' => 'footer-logo',
            ];

            // If the logo alt attribute is empty, get the site title
            $custom_logo_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
            if ( empty( $custom_logo_alt ) ) {
                $custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
            }

            $custom_logo_meta  = wp_get_attachment_metadata( $custom_logo_id );
            $custom_logo_width = isset( $custom_logo_meta['width'] ) ? (int) $custom_logo_meta['width'] : 340;

            $html = sprintf(
                '<a href="%1$s" class="footer-logo-link d-inline-block mb-5" rel="home" style="width: %3$dpx;">%2$s</a>',
                esc_url( home_url( '/' ) ),
                wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr ),
                (float) $custom_logo_width / 2
            );

        } elseif ( $footer_custom_logo_id ) {
            $attr = [
                'class' => 'footer-logo d-block',
            ];

            // If the logo alt attribute is empty, get the site title
            $alt = get_post_meta( $footer_custom_logo_id, '_wp_attachment_image_alt', true );

            if ( empty( $alt ) ) {
                $attr['alt'] = get_bloginfo( 'name', 'display' );
            }

            $meta  = wp_get_attachment_metadata( $footer_custom_logo_id );
            $width = isset( $meta['width'] ) ? (int) $meta['width'] : 284;

            $html = sprintf(
                '<a href="%1$s" class="footer-logo-link d-inline-block mb-5" rel="home" style="width: %3$dpx;">%2$s</a>',
                esc_url( home_url( '/' ) ),
                wp_get_attachment_image( $footer_custom_logo_id, 'full', false, $attr ),
                (float) $width / 2
            );
            

        } elseif ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
            $logo = get_custom_logo();
            $html = is_home() ? '<h1 class="logo">' . $logo . '</h1>' : $logo;
        }  else {
            $tag = is_home() ? 'h1' : 'h1';
            $tag_class = ! empty( $tag_class )? ' ' . $tag_class: '';
            $html = '<' . esc_attr( $tag ) . ' class="beta site-title site-title text-uppercase font-weight-bold font-size-5 mb-4 ' . esc_attr( $tag_class ) .' "><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></' . esc_attr( $tag ) . '>';
        }

        echo wp_kses_post( $html );
    }
}

if ( ! function_exists( 'bookworm_shop_address' ) ) {
    /**
     * Displays Shop Address
     *
     * @since  1.0.0
     * @return void
     */
    function bookworm_shop_address( $text_color_classes='', $footer_version='' ) {
        if( apply_filters( 'bookworm_shop_address', filter_var( get_theme_mod( 'enable_shop_address', 'no' ), FILTER_VALIDATE_BOOLEAN )  ) ) {
            $address_1 = apply_filters('bookworm_site_address_1', get_theme_mod( 'bookworm_address_1', '1418 River Drive, Suite 35 Cottonhall, CA 9622' ));
            $address_2 = apply_filters('bookworm_site_address_2', get_theme_mod( 'bookworm_address_2', 'United States' ) );

            if( empty( $footer_version ) ) {
                $footer_version = apply_filters( 'bookworm_footer_version', get_theme_mod( 'footer_version', 'v1' ) );
            }

            if ($footer_version == 'v1' || $footer_version == 'v3' || $footer_version == 'v5' || $footer_version == 'v10' || $footer_version == 'v11' ) {
                $text_color_classes = 'text-dark';
            } elseif ( $footer_version == 'v9' ) {
                $text_color_classes = 'text-white';
            } else {
                $text_color_classes = 'text-gray-500';
            }

            if ( ! empty( $address_1 ) || ! empty( $address_2 ) ) :
            ?><address class="font-size-2 mb-5">
                <span class="mb-2 font-weight-normal <?php echo esc_attr( $text_color_classes ); ?>">
                <?php
                    echo esc_html( $address_1 );
                    if ( ! empty( $address_2 ) ) {
                        printf( '<br>' . esc_html( $address_2 ) );
                    }
                ?>
                </span>
            </address><?php
            endif;
        }
    }
}

if ( ! function_exists( 'bookworm_contact_links' ) ) {
    /**
     * Displays Contact Links
     *
     * @since  1.0.0
     * @return void
     */
    function bookworm_contact_links( $nav_link_classes='', $footer_version='' ) {
        if( empty( $footer_version ) ) {
            $footer_version = apply_filters( 'bookworm_footer_version', get_theme_mod( 'footer_version', 'v1' ) );
        }

        if ($footer_version == 'v1' || $footer_version == 'v3' || $footer_version == 'v5' || $footer_version == 'v10' || $footer_version == 'v11' ) {
            $nav_link_classes = ' link-black-100';
        } elseif ( $footer_version == 'v9' ) {
            $nav_link_classes = ' text-white';
        } elseif ( $footer_version == 'v6' ) {
            $nav_link_classes = ' text-gray-500';
        } else {
            $nav_link_classes = ' text-gray-450';
        }

        $footerContactMenuSlug = apply_filters( 'bookworm_contact_menu' , '' );

        if ( has_nav_menu( 'contact_links' ) && apply_filters( 'bookworm_enable_contact_links', true ) ) {
            $nav_menu_args = apply_filters( 'bookworm_contact_menu_args', [
                'theme_location'  => 'contact_links',
                'container'       => false,
                'walker'          => new WP_Bootstrap_Navwalker(),
                'menu_class'      => 'list-unstyled mb-4 ml-0',
                'schema'          => false,
                'depth'           => 1,
                'container'       => false,
                'menu_item_class' => false,
                'nav_link_class'  => 'font-size-2 d-block mb-1' . $nav_link_classes
            ] );

            if( ! empty ( $footerContactMenuID ) && $footerContactMenuID > 0 ) {
                $nav_menu_args['menu'] = $footerContactMenuID;
            } elseif( ! empty( $footerContactMenuSlug ) ) {
                $nav_menu_args['menu'] = $footerContactMenuSlug;
            }

            wp_nav_menu( $nav_menu_args );
        }
    }
}

if ( ! function_exists( 'bookworm_social_media_links' ) ) {
    /**
     * Display Social Media Links
     *
     * @since  1.0.0
     * @return void
     */
    function bookworm_social_media_links( $nav_link_classes='', $footer_version='' ) {

        if( empty( $footer_version ) ) {
            $footer_version = apply_filters( 'bookworm_footer_version', get_theme_mod( 'footer_version', 'v1' ) );
        }

        if ($footer_version == 'v1' || $footer_version == 'v3' || $footer_version == 'v5' || $footer_version == 'v10' || $footer_version == 'v11' ) {
            $nav_link_classes = 'link-black-100';
        } elseif ( $footer_version == 'v9' ) {
            $nav_link_classes = 'text-white';
        } elseif ( $footer_version == 'v6' ) {
            $nav_link_classes = 'text-gray-500';
        } elseif ( $footer_version == 'v13' ) {
            $nav_link_classes = 'link-black-100';
        } elseif ( $footer_version == 'v8' ) {
            $nav_link_classes = 'text-white';
        } else {
            $nav_link_classes = 'text-gray-450';
        }

        if ( has_nav_menu( 'social_media' ) && apply_filters( 'bookworm_enable_footer_social_icons', true )) {
            wp_nav_menu( array(
                'theme_location'  => 'social_media',
                'walker'          => new WP_Bootstrap_Navwalker(),
                'item_class'      => 'btn',
                'menu_item_class' => false,
                'nav_link_class'  => $nav_link_classes,
                'icon_txt_class'  => 'sr-only',
                'depth'           => 1,
                'container'       => false,
                'menu_class'      => 'list-unstyled mb-0 d-flex social-icon-menu ml-0',
                'schema'          => false,
            ) );
        }
    }
}

if ( ! function_exists( 'bookworm_site_info' ) ) {
    /**
	 * Display the site_info
	 *
	 * @since  1.0.0
	 * @return void
	 */
    function bookworm_site_info( $wrapper_classes='', $wrapper_inner_classes='', $copyright_text_classes='',$right_column_wrapper_classes='', $footer_version='' ) {
        if( empty( $footer_version ) ) {
            $footer_version = apply_filters( 'bookworm_footer_version', get_theme_mod( 'footer_version', 'v1' ) );
        }

        $copyright_text = apply_filters( 'bookworm_copyright', get_theme_mod( 'bookworm_copyright_text', sprintf( esc_html__( '%s %s. All Rights Reserved', 'bookworm' ), date( 'Y' ), get_bloginfo( 'name' ) ) ) );
        ?><div class="<?php echo esc_attr( $wrapper_classes ); ?>">
            <div class="container">
                <div class="<?php echo esc_attr( $wrapper_inner_classes ); ?>">
                    <?php if ( apply_filters( 'bookworm_is_copyright' , true)): ?>
                        <!-- Copyright -->
                        <p class="<?php echo esc_attr( $copyright_text_classes ); ?>"><?php echo esc_html( $copyright_text ); ?></p>
                        <!-- End Copyright -->
                    <?php endif; ?>
                    

                    <?php if ( $footer_version !== 'v6' ) : ?>
                        <div class="<?php echo esc_attr( $right_column_wrapper_classes ); ?>">
                        <?php
                            /**
                             * Functions hooked in to bookworm_site_info action
                             *
                             * @hooked bookworm_payment_info - 10
                             */
                            do_action( 'bookworm_site_info' );
                        ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_payment_info' ) ) {
    /**
     * Displays Site's Payment Info
     *
     * @since  1.0.0
     * @return void
     */
    function bookworm_payment_info( $footer_version='' ) {
        if( empty( $footer_version ) ) {
            $footer_version = apply_filters( 'bookworm_footer_version', get_theme_mod( 'footer_version', 'v1' ) );
        }

        $credit_cards_img_url = apply_filters( 'bookworm_payment_image_url', get_theme_mod( 'bookworm_credit_card_img_url', get_template_directory_uri() . '/assets/img/credit-cards.png' ) );

        if ( apply_filters( 'bookworm_enable_footer_payment_method' , filter_var( get_theme_mod( 'enable_footer_payment', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) && ( $footer_version =='v1' || $footer_version =='v3' || $footer_version =='v5' || $footer_version =='v6' || $footer_version =='v7' || $footer_version =='v10' || $footer_version =='v11' || $footer_version =='v12') && ! empty ( $credit_cards_img_url ) ) : 
        ?><div class="mb-4 mb-lg-0 ml-auto">
            <img class="img-fluid" src="<?php echo esc_url( $credit_cards_img_url ); ?>" alt="<?php echo esc_attr__( 'Payment Info', 'bookworm' ); ?>">
        </div><?php endif;
    }
}

if ( ! function_exists( 'bookworm_footer_before_content_v6' ) ) {
    function bookworm_footer_before_content_v6() { ?>
        <div class="border-top">
            <div class="container">
                <?php bookworm_footer_newsletter(); ?>
            </div>
        </div><?php
    }
}


if ( ! function_exists( 'bookworm_footer_before_content_v9' ) ) {
    function bookworm_footer_before_content_v9() { ?>
        <div class="bg-primary">
            <div class="container">
                <?php bookworm_footer_newsletter(); ?>
            </div>
        </div><?php
    }
}


if ( ! function_exists( 'bookworm_language_currency' ) ) {
    function bookworm_language_currency( $footer_vrsion='') {
        if( empty( $footer_version ) ) {
            $footer_version = apply_filters( 'bookworm_footer_version', get_theme_mod( 'footer_version', 'v1' ) );
        }

        if ( $footer_version == 'v2' ) {
            $dropdown_select_classes ='ml-lg-4 mb-3 mb-md-0';
            $data_style_classes ='text-white-60 bg-secondary-gray-800 px-4 py-2 rounded-lg height-5 outline-none shadow-none form-control font-size-2';
        } elseif ( $footer_version == 'v3' ) {
            $dropdown_select_classes ='ml-lg-4 mb-3 mb-md-0';
            $data_style_classes ='border px-4 py-2 rounded-md height-5 outline-none shadow-none form-control font-size-2';
        } elseif ( $footer_version == 'v4') {
            $dropdown_select_classes ='ml-md-3 mb-3 mb-md-0';
            $data_style_classes ='border border-gray-710 bg-transparent px-4 py-2 text-gray-450 rounded-0 height-5 outline-none shadow-none form-control font-size-2';
        } elseif ( $footer_version == 'v5') {
            $dropdown_select_classes ='mb-3 mb-lg-0 ml-md-5';
            $data_style_classes ='border px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2';
        } elseif ( $footer_version == 'v7') {
            $dropdown_select_classes ='mb-3 mb-md-0 ml-md-6';
            $data_style_classes ='border border-gray-300 px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2';
        } elseif ( $footer_version == 'v8') {
            $dropdown_select_classes ='';
            $data_style_classes ='bg-transparent border-0 text-gray-500 px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2';
        } elseif ( $footer_version == 'v9') {
            $dropdown_select_classes ='mb-3 mb-md-0';
            $data_style_classes ='text-gray-500 bg-gray-810 px-4 py-2 rounded-md height-5 outline-none shadow-none form-control font-size-2';
        } elseif ( $footer_version == 'v10') {
            $dropdown_select_classes ='mb-3 mb-md-0 ml-md-5';
            $data_style_classes ='border px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2';
        } elseif ( $footer_version == 'v11') {
            $dropdown_select_classes ='mb-3 mb-md-0 ml-md-3';
            $data_style_classes ='bg-transparent border px-4 py-2 rounded-md height-5 outline-none shadow-none form-control font-size-2';
        } elseif ( $footer_version == 'v12') {
            $dropdown_select_classes ='ml-md-3 mb-3 mb-md-0';
            $data_style_classes ='border px-4 py-2 rounded-0 bg-transparent height-5 outline-none shadow-none form-control font-size-2';
        } elseif ( $footer_version == 'v13') {
            $dropdown_select_classes ='mb-3 mb-md-0';
            $data_style_classes ='bg-transparent border-0 text-dark px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2';
        } else {
            $dropdown_select_classes ='mb-3 mb-lg-0 ml-md-5';
            $data_style_classes ='border px-4 py-2 rounded-0 height-5 outline-none shadow-none form-control font-size-2';
        } 

        if ( apply_filters( 'bookworm_enable_language_dropdown',  filter_var( get_theme_mod( 'enable_footer_language', 'no' ), FILTER_VALIDATE_BOOLEAN )  )) :?>
            <select class="js-select selectpicker dropdown-select <?php echo esc_attr( $dropdown_select_classes );?>" data-style="<?php echo esc_attr( $data_style_classes );?>" data-dropdown-align-right="true" data-width="fit">

                <option value="<?php echo strtoupper( get_bloginfo( 'language' )); ?>">
                    <?php echo strtoupper( get_bloginfo( 'language' ) ); ?>
                </option>
            </select>
            
            <?php
        endif;
       
        if( bookworm_is_woocommerce_activated() &&  apply_filters( 'bookworm_enable_currency_dropdown',  filter_var( get_theme_mod( 'enable_footer_currency', 'no' ), FILTER_VALIDATE_BOOLEAN ) ) ):
            ?>

            <select class="js-select selectpicker dropdown-select ml-md-3" data-style="<?php echo esc_attr( $data_style_classes );?>" data-dropdown-align-right="true" data-width="fit">

                <option value="<?php echo get_woocommerce_currency(); ?>">
                    <?php echo get_woocommerce_currency_symbol(); ?>
                    <?php echo get_woocommerce_currency(); ?>
                </option>
            </select>
            
            <?php
        endif;

    }
}

if( ! function_exists( 'bookworm_page_footer_layout' ) ) {
    function bookworm_page_footer_layout( $layout ) {
        global $post;
        if ( is_page() && isset( $post->ID ) ) {
            $footer_meta_values = get_post_meta( $post->ID, '_footer_style', true );

            if ( isset( $footer_meta_values ) && $footer_meta_values ) {
                $layout = $footer_meta_values;
            }
        }
        return $layout;
    }
}

require get_template_directory() . '/inc/template-functions/footers/footer-v1.php';
require get_template_directory() . '/inc/template-functions/footers/footer-v2.php';
require get_template_directory() . '/inc/template-functions/footers/footer-v3.php';
require get_template_directory() . '/inc/template-functions/footers/footer-v4.php';
require get_template_directory() . '/inc/template-functions/footers/footer-v5.php';
require get_template_directory() . '/inc/template-functions/footers/footer-v6.php';
require get_template_directory() . '/inc/template-functions/footers/footer-v7.php';
require get_template_directory() . '/inc/template-functions/footers/footer-v8.php';
require get_template_directory() . '/inc/template-functions/footers/footer-v9.php';
require get_template_directory() . '/inc/template-functions/footers/footer-v10.php';
require get_template_directory() . '/inc/template-functions/footers/footer-v11.php';
require get_template_directory() . '/inc/template-functions/footers/footer-v12.php';
require get_template_directory() . '/inc/template-functions/footers/footer-v13.php';

