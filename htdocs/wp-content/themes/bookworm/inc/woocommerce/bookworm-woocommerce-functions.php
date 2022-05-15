<?php
/**
 * Bookworm WooCommerce functions.
 *
 * @package bookworm
 */

/**
 * Checks if the current page is a product archive
 *
 * @return boolean
 */
if ( ! function_exists( 'bookworm_is_product_archive' ) ) {
    function bookworm_is_product_archive() {
        if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {
            return true;
        } else {
            return false;
        }
    }
}


if ( ! function_exists( 'bookworm_get_product_archive_layout' ) ) {
    function bookworm_get_product_archive_layout() {
        $layout = '';
        $is_brand = false;

        if ( class_exists( 'Mas_WC_Brands' ) ) {
            global $mas_wc_brands;
            $brand_taxonomy = $mas_wc_brands->get_brand_taxonomy();
            if ( is_tax ( $brand_taxonomy ) && is_product_taxonomy() ) {
                $is_brand = true;
            }  
        }

         if ( bookworm_is_product_archive() && ! $is_brand ) {
            if ( !is_active_sidebar( 'sidebar-shop' )  ) {
                $layout = 'full-width';
            } else {
                $layout = apply_filters( 'bookworm_product_archive_layout', get_theme_mod( 'product_archive_layout', 'left-sidebar' ) );
            }    
        }
        return $layout;
    }
}


if ( ! function_exists( 'bookworm_get_single_product_layout' ) ) {
    function bookworm_get_single_product_layout() {
        $layout = '';
        
        if ( is_product() && bookworm_is_single_product_sidebar() ) {
            if ( ! is_active_sidebar( 'sidebar-single' ) ) {
                $layout = 'full-width';
            } else {
                $layout = apply_filters( 'bookworm_single_product_layout', get_theme_mod( 'single_product_layout', 'right-sidebar' ));
            }    
       }

        return $layout;
    }
}

if ( ! function_exists( 'bookworm_is_single_product_sidebar' ) ) {
    function bookworm_is_single_product_sidebar() {

        return apply_filters( 'bookworm_is_enable_single_product_sidebar', false );
    }
}

if ( ! function_exists( 'bookworm_single_product_has_sidebar' ) ) {
    function bookworm_single_product_has_sidebar() {
        $layout = bookworm_get_single_product_layout();
        return ( 'left-sidebar' === $layout || 'right-sidebar' === $layout );
    }
}

if ( ! function_exists( 'bookworm_get_book_author_taxonomy' ) ) {
    function bookworm_get_book_author_taxonomy() {
        return apply_filters( 'bookworm_book_author_taxonomy', 'pa_book-author' );
    }
}

if ( ! function_exists( 'bookworm_get_book_format_taxonomy' ) ) {
    function bookworm_get_book_format_taxonomy() {
        return apply_filters( 'bookworm_book_format_taxonomy', 'pa_format' );
    }
}

if ( ! function_exists( 'bookworm_the_page_title' ) ) {
    function bookworm_the_page_title() {
        if( bookworm_is_woocommerce_activated() ) {
            $breadcrumb = new WC_Breadcrumb();
            $breadcrumb->generate();
            $crumbs = $breadcrumb->get_breadcrumb();
            $the_title = end( $crumbs );
            echo esc_html( $the_title[0] );
        }
    }
}

if ( ! function_exists( 'bookworm_is_wc_single_product_variations_radio_style' ) ) {
    function bookworm_is_wc_single_product_variations_radio_style() {

        return apply_filters( 'bookworm_is_wc_single_product_variations_radio_style', false );
    }
}

if ( ! function_exists( 'bookworm_product_archive_has_sidebar' ) ) {
    function bookworm_product_archive_has_sidebar() {
        $layout = bookworm_get_product_archive_layout();
        return ( 'left-sidebar' === $layout || 'right-sidebar' === $layout );
    }
}

if ( ! function_exists( 'bookworm_wc_get_account_menu_item_icon' ) ) {
    function bookworm_wc_get_account_menu_item_icon( $endpoint, $default = '' ) {

        $icons = array(
            'orders'          => 'flaticon-order',
            'downloads'       => 'flaticon-cloud-computing',
            'edit-address'    => 'flaticon-place',
            'payment-methods' => 'flaticon-credit',
            'edit-account'    => 'flaticon-user-1',
            'customer-logout' => 'flaticon-exit',
        );

        $icon = isset( $icons[ $endpoint ] ) ? $icons[ $endpoint ]: $default;
        $icon = apply_filters( 'bookworm_wc_account_menu_item_icon', $icon, $endpoint );

        return $icon;
    }
}

if ( ! function_exists( 'bookworm_wc_form_field' ) ) {
    function bookworm_wc_form_field( $field, $key, $args, $value ) {
        $field = str_replace( 'form-row ', '', $field );
        return $field;
    }
}

if ( ! function_exists( 'bookworm_wc_form_field_args' ) ) {
    function bookworm_wc_form_field_args( $args, $key, $value ) {
        if ( 'billing_address_2' === $args['id'] ) {
            $args['label'] = '';
        }
        $args['input_class'] = array( 'form-control', 'rounded-0' );
        $args['label_class'] = array( 'form-label' );
        if ( isset( $args['class'] ) ) {
            foreach ( $args['class'] as $key => $class ) {
                if ( $class == 'form-row-first' || $class == 'form-row-last' ) {
                    $args['class'][$key] = 'col-md-6';
                } elseif ( $class == 'form-row-wide' ) {
                    $args['class'][$key] = 'col-12';
                }
            }
        } else {
            $args['class'] = 'col-12';
        }
        $args['class'][] = 'mb-4d75';
        if ( empty( $args['label'] ) ) {
            $args['class'][] = 'mt-n2d75';
        }
        return $args;
    }
}

if ( ! function_exists( 'bookworm_wp_kses_author_name' ) ) {
    function bookworm_wp_kses_author_name( $author_name ) {
        return wp_kses( $author_name, array( 'a' => array( 'href' => array(), 'class' => array() ) ) );
    }
}

if ( ! function_exists( 'bookworm_get_single_product_version' ) ) {
    function bookworm_get_single_product_version() {
        $product_style = get_theme_mod( 'product_style', 'v1' );
        return apply_filters( 'bookworm_single_product_version', $product_style );
    }
}

if ( ! function_exists( 'bookworm_get_single_product_style' ) ) {
    function bookworm_get_single_product_style( $layout ) {

        $product_meta_values = get_post_meta( get_the_ID(), '_product_layout', true );

            if ( isset($product_meta_values ) &&$product_meta_values ) {
                $layout =$product_meta_values;
            }
            
        return  $layout;
    }
}

if ( ! function_exists( 'bookworm_enable_product_meta_display' ) ) {
    function bookworm_enable_product_meta_display() {
        return apply_filters( 'bookworm_enable_product_meta_display', true );
    }
}

if ( ! function_exists( 'bookworm_site_header_offcanvas_wc_links' ) ) {
    function bookworm_site_header_offcanvas_wc_links( $links ) {
        $enable_cart    = bookworm_enable_mini_cart();
        $enable_account = bookworm_enable_account();


        if ( $enable_account ):
            if( is_user_logged_in() ) {
                $_bw_user = wp_get_current_user();
                $links['my_account'] = [
                    'title_text_1'      => esc_html__( 'Hello', 'bookworm' ),
                    'title_text_2'      => $_bw_user->display_name,
                    'icon_class'        => 'flaticon-user',
                    'text_class'        => 'd-none d-lg-block',
                    'priority'          => 10,
                    'atts'              => [
                        'href'          => get_permalink( wc_get_page_id( 'myaccount' ) ),
                    ],
                ];
            } else {
                $links['my_account'] = [
                    'title_text_1'      => esc_html__( 'Sign In', 'bookworm' ),
                    'title_text_2'      => esc_html__( 'My Account', 'bookworm' ),
                    'icon_class'        => 'flaticon-user',
                    'text_class'        => 'd-none d-lg-block',
                    'priority'          => 10,
                    'type'              => 'toggler',
                    'atts'              => [
                        'aria-controls'     => "registerLoginForm",
                        'data-unfold-target' => "#registerLoginForm",
                    ],
                ];
            }
        endif;

        if ( $enable_cart ):
            $links['my_cart'] = [
                'title_text_1'      => esc_html__( 'My Cart', 'bookworm' ),
                'title_text_2'      => is_a( WC()->cart, 'WC_Cart' ) ? WC()->cart->get_total() : 0,
                'badge_text'        => is_a( WC()->cart, 'WC_Cart' ) ? WC()->cart->get_cart_contents_count() : 0,
                'icon_class'        => 'flaticon-icon-126515',
                'priority'          => 20,
                'type'              => 'toggler',
                'atts'              => [
                    'class'             => 'd-none d-lg-block',
                    'aria-controls'     => "offcanvasCart",
                    'data-unfold-target' => "#offcanvasCart",
                ],
            ];
        endif;

        return $links;
    }
}

if ( ! function_exists( 'bookworm_site_header_icons_wc_links' ) ) {
    function bookworm_site_header_icons_wc_links( $links ) {
        $enable_cart    = bookworm_enable_mini_cart();
        $enable_account = bookworm_enable_account();

        if ( $enable_account ) :
            if( is_user_logged_in() ) {
                $_bw_user = wp_get_current_user();
                $links['my_account'] = [
                    'icon_class'    => 'flaticon-user',
                    'priority'      => 30,
                    'atts'          => [
                        'href'      => get_permalink( wc_get_page_id( 'myaccount' ) ),
                    ],
                ];
            } else {
                $links['my_account'] = [
                    'icon_class'    => 'flaticon-user',
                    'priority'      => 30,
                    'type'          => 'toggler',
                    'atts'          => [
                        'aria-controls'     => "registerLoginForm",
                        'data-unfold-target' => "#registerLoginForm",
                    ],
                ];
            }
        endif;

        if ( $enable_cart ) :
            $links['my_cart'] = [
                'text'          => is_a( WC()->cart, 'WC_Cart' ) ? WC()->cart->get_total() : 0, /*WC()->cart->get_total(),*/
                'badge_text'    => is_a( WC()->cart, 'WC_Cart' ) ? WC()->cart->get_cart_contents_count() : 0,
                'icon_class'    => 'flaticon-icon-126515',
                'item_class'    => 'd-none d-md-block',
                'priority'      => 40,
                'type'          => 'toggler',
                'atts'          => [
                    'aria-controls'     => "offcanvasCart",
                    'data-unfold-target' => "#offcanvasCart",
                ],
            ];
        endif;

        return $links;
    }
}

if ( ! function_exists( 'bookworm_site_header_store_locator_link' ) ) {
    function bookworm_site_header_store_locator_link( $links ) {
        $enable_store_locator = bookworm_enable_store_locator_link();
        if ( $enable_store_locator ) :
            $links['store_locator'] = [
                'icon_class'    => 'flaticon-pin',
                'priority'      => 5,
                'item_class'    => 'd-none d-md-block',
                'atts'          => [
                    'href'      => get_permalink( get_theme_mod( 'bookworm_store_location_page' )),
                ],
            ];
        endif;
       
        return $links;
    }
}


if ( ! function_exists( 'bookworm_site_header_wishlist_link' ) ) {
    function bookworm_site_header_wishlist_link( $links ) {
        $enable_wishlist = bookworm_enable_wishlist();

        if ( $enable_wishlist && function_exists( 'YITH_WCWL' ) ):
            $links['wishlist'] = [
                'icon_class'    => 'flaticon-heart',
                'item_class'    => 'd-none d-md-block font-size-4',
                'priority'      => 20,
                'atts'          => [
                    'href'      => get_permalink( get_option( 'yith_wcwl_wishlist_page_id' )),
                ],
            ];
        endif;

        return $links;
    }
}

if ( ! function_exists( 'bookworm_site_header_compare_link' ) ) {
    function bookworm_site_header_compare_link( $links ) {
        $enable_compare = bookworm_enable_compare();

        if ( $enable_compare && class_exists( 'YITH_Woocompare' ) ):
            $links['compare'] = [
                'icon_class'    => 'flaticon-switch',
                'item_class'    => 'd-none d-md-block',
                'priority'      => 15,
                'atts'          => [
                    'href'      => get_permalink( get_theme_mod( 'compare_page_id' ) ),
                ],
            ];
        endif;

        return $links;
    }
}


if ( ! function_exists( 'bookworm_wc_offcanvas_register_loggin_form' ) ) {
    function bookworm_wc_offcanvas_register_loggin_form( $id_base='', $aria_base='' ) {
        if ( is_user_logged_in() ) {
            return;
        }

        if( empty( $id_base ) ) {
            $id_base = 'registerLoginForm';
        }

         if( empty( $aria_base ) ) {
            $aria_base = 'sidebarNavToggler-my_account';
        }

        $has_registration_form = get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes';
        ?>
        <aside id="registerLoginForm" class="u-sidebar u-sidebar__lg" aria-labelledby="sidebarNavToggler-my_account">
            <div class="u-sidebar__scroller">
                <div class="u-sidebar__container">
                    <div class="u-header-sidebar__footer-offset">
                        <div class="d-flex align-items-center position-absolute top-0 right-0 z-index-2 mt-5 mr-md-6 mr-4">
                            <button type="button" class="close ml-auto"
                                aria-controls="registerLoginForm"
                                aria-haspopup="true"
                                aria-expanded="false"
                                data-unfold-event="click"
                                data-unfold-hide-on-scroll="false"
                                data-unfold-target="#registerLoginForm"
                                data-unfold-type="css-animation"
                                data-unfold-animation-in='<?php ( is_rtl() ? "fadeInLeft" : "fadeInRight"); ?>'
                                data-unfold-animation-out='<?php ( is_rtl() ? "fadeOutLeft" : "fadeOutRight"); ?>'
                                data-unfold-duration="500">
                                <span aria-hidden="true"><?php esc_html_e( 'Close', 'bookworm' ); ?> <i class="fas fa-times ml-2"></i></span>
                            </button>
                        </div>
                        <div class="js-scrollbar u-sidebar__body">
                            <div class="u-sidebar__content u-header-sidebar__content">
                                <div class="u-sidebar__content--inner u-header-sidebar__content--inner">
                                    <div id="login" data-target-group="idForm">
                                        <header class="border-bottom px-4 px-md-6 py-4">
                                            <h2 class="font-size-3 mb-0 d-flex align-items-center"><i class="flaticon-user mr-3 font-size-5"></i><?php esc_html_e( 'Account', 'bookworm' ); ?></h2>
                                        </header>
                                        <?php woocommerce_login_form( [
                                            'redirect' => get_permalink( wc_get_page_id( 'myaccount' ) ),
                                        ] ); ?>
                                    </div>
                                    <?php if( bookworm_is_account_registration_enable() ) : ?>
                                        <div id="signup" style="display: none; opacity: 0;" data-target-group="idForm">
                                            <header class="border-bottom px-4 px-md-6 py-4">
                                                <h2 class="font-size-3 mb-0 d-flex align-items-center"><i class="flaticon-resume mr-3 font-size-5"></i><?php esc_html_e( 'Create Account', 'bookworm' ); ?></h2>
                                            </header>
                                            <?php bookworm_wc_registration_form(); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div id="forgotPassword" style="display: none; opacity: 0;" data-target-group="idForm">
                                        <header class="border-bottom px-4 px-md-6 py-4">
                                            <h2 class="font-size-3 mb-0 d-flex align-items-center"><i class="flaticon-question mr-3 font-size-5"></i><?php esc_html_e( 'Forgot Password?', 'bookworm' ); ?></h2>
                                        </header>
                                        <?php bookworm_wc_lost_password_form(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <?php
    }
}


if ( ! function_exists( 'bookworm_wc_registration_form' ) ) {
    /**
     * Registration Form
     */
    function bookworm_wc_registration_form() {
        ?><form method="post" class="woocommerce-form woocommerce-form-register register p-4 p-md-6" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

            <?php do_action( 'woocommerce_register_form_start' ); ?>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                <div class="form-group mb-4">
                    <div class="js-form-message js-focus-state">
                        <label id="reg_usernameLabel" class="form-label" for="reg_username1"><?php esc_html_e( 'Username', 'bookworm' ); ?> *</label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control rounded-0 height-4 px-4" name="username" id="reg_username1" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" aria-label="" aria-describedby="reg_usernameLabel" required>
                    </div>
                </div>

            <?php endif; ?>

            <div class="form-group mb-4">
                <div class="js-form-message js-focus-state">
                    <label id="reg_emailLabel" class="form-label" for="reg_email1"><?php esc_html_e( 'Email', 'bookworm' ); ?> *</label>
                    <input type="email" class="woocommerce-Input woocommerce-Input--text input-text form-control rounded-0 height-4 px-4" name="email" id="reg_email1" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" aria-label="" aria-describedby="reg_emailLabel" required>
                </div>
            </div>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                <div class="form-group mb-4">
                    <div class="js-form-message js-focus-state">
                        <label id="reg_passwordLabel" class="form-label" for="reg_password1"><?php esc_html_e( 'Password', 'bookworm' ); ?> *</label>
                        <input type="password" class="form-control rounded-0 height-4 px-4" name="password" id="reg_password1" aria-label="" aria-describedby="reg_passwordLabel" autocomplete="new-password" required>
                    </div>
                </div>

            <?php else : ?>

                <p class="font-size-sm text-muted"><?php esc_html_e( 'A password will be sent to your email address.', 'bookworm' ); ?></p>

            <?php endif; ?>

            <?php do_action( 'woocommerce_register_form' ); ?>

            <div class="mb-3">
                <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark" name="register" value="<?php esc_attr_e( 'Register', 'bookworm' ); ?>"><?php esc_html_e( 'Create Account', 'bookworm' ); ?></button>
            </div>

            <div class="text-center mb-4">
                <span class="small text-muted"><?php esc_html_e( 'Already have an account?', 'bookworm' ); ?></span>
                <a class="js-animation-link small" href="javascript:;"
                    data-target="#login"
                    data-link-group="idForm"
                    data-animation-in="fadeIn">
                    <?php esc_html_e( 'Login', 'bookworm' ); ?>
                </a>
            </div>

            <?php do_action( 'woocommerce_register_form_end' ); ?>

            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
        </form><?php
    }
}

if ( ! function_exists( 'bookworm_wc_lost_password_form' ) ) {
    /**
     * Lost Password Form
     */
    function bookworm_wc_lost_password_form() {
        ?><form method="post" class="woocommerce-ResetPassword lost_reset_password p-4 p-md-6">

            <div class="form-group mb-4">
                <div class="js-form-message js-focus-state">
                    <label id="user_loginLabel" class="form-label" for="user_login"><?php esc_html_e( 'Username or email', 'bookworm' ); ?> *</label>
                    <input type="text" class="form-control rounded-0 height-4 px-4" name="user_login" id="user_login" autocomplete="username" aria-label="" aria-describedby="user_loginLabel" required>
                </div>
            </div>

            <?php do_action( 'woocommerce_lostpassword_form' ); ?>

            <div class="mb-3">
                <input type="hidden" name="wc_reset_password" value="true" />
                <button type="submit" class="btn btn-block py-3 rounded-0 btn-dark" value="<?php esc_attr_e( 'Recover password', 'bookworm' ); ?>"><?php esc_html_e( 'Recover Password', 'bookworm' ); ?></button>
            </div>

            <div class="text-center mb-4">
                <span class="small text-muted"><?php esc_html_e( 'Remember your password?', 'bookworm' ); ?></span>
                <a class="js-animation-link small" href="javascript:;"
                    data-target="#login"
                    data-link-group="idForm"
                    data-animation-in="fadeIn"><?php esc_html_e( 'Login', 'bookworm' ); ?>
                </a>
            </div>

            <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

        </form><?php
    }
}


if ( ! function_exists( 'bookworm_wc_offcanvas_mini_cart' ) ) {
    /**
     * Offcanvas Mini cart
     */
    function bookworm_wc_offcanvas_mini_cart( $id_base='', $aria_base='') {
        $enable_cart    = bookworm_enable_mini_cart();
        if ( $enable_cart ) :
            if( empty( $id_base ) ) {
                $id_base = 'offcanvasCart';
            }

            if( empty( $aria_base ) ) {
                $aria_base = 'sidebarNavToggler-my_cart';
            }
   
        ?>
        <aside id="<?php echo esc_attr( $id_base ); ?>" class="u-sidebar u-sidebar__xl" aria-labelledby="<?php echo esc_attr( $aria_base ); ?>">
            <div class="u-sidebar__scroller js-scrollbar">
                <div class="u-sidebar__container">
                    <div class="u-header-sidebar__footer-offset">
                        <div class="d-flex align-items-center position-absolute top-0 right-0 z-index-2 mt-5 mr-md-6 mr-4">
                            <button type="button" class="close ml-auto"
                                aria-controls="<?php echo esc_attr( $id_base ); ?>"
                                aria-haspopup="true"
                                aria-expanded="false"
                                data-unfold-event="click"
                                data-unfold-hide-on-scroll="false"
                                data-unfold-target="#<?php echo esc_attr( $id_base ); ?>"
                                data-unfold-type="css-animation"
                                data-unfold-animation-in='<?php ( is_rtl() ? "fadeInLeft" : "fadeInRight" ); ?>'
                                data-unfold-animation-out='<?php ( is_rtl() ? "fadeOutLeft" : "fadeOutRight" ); ?>'
                                data-unfold-duration="500">
                                <span aria-hidden="true">
                                    <?php esc_html_e( 'Close', 'bookworm' ); ?> <i class="fas fa-times ml-2"></i>
                                </span>
                            </button>
                        </div>

                        <?php bookworm_wc_offcanvas_mini_cart_content(); ?>
                        
                    </div>
                </div>
            </div>
        </aside>
        <?php
    endif;
        
    }
}

if ( ! function_exists( 'bookworm_wc_offcanvas_mini_cart_content' ) ) {
    
    function bookworm_wc_offcanvas_mini_cart_content() { ?>
        <div class="u-sidebar__body">
                <div class="u-sidebar__content u-header-sidebar__content">
                    <header class="border-bottom px-4 px-md-6 py-4">
                        <h2 class="font-size-3 mb-0 d-flex align-items-center">
                            <i class="flaticon-icon-126515 mr-3 font-size-5"></i>
                            <?php echo sprintf( esc_html__( "Your shopping bag (%u)", 'bookworm' ), WC()->cart->get_cart_contents_count() ); ?></h2>
                    </header>
                    <div class="widget woocommerce widget_shopping_cart">
                        <?php woocommerce_mini_cart(); ?>
                    </div>
                </div>
            </div><?php
        }
    }

if ( ! function_exists( 'bookworm_wc_offcanvas_mobile_mini_cart' ) ) {
    /**
     * Offcanvas Mobile Mini cart
     */
    function bookworm_wc_offcanvas_mobile_mini_cart() {
        bookworm_wc_offcanvas_mini_cart('offcanvasMobileCart', 'sidebarMobileNavToggler-my_cart');
        
    }
}

if ( ! function_exists( 'woocommerce_widget_shopping_cart_subtotal' ) ) {
    function woocommerce_widget_shopping_cart_subtotal() {
        ?><div class="woocommerce-mini-cart__subtotal py-3 d-flex justify-content-between align-items-center font-size-3">
            <h4 class="mb-0 font-size-3"><?php esc_html_e( 'Subtotal', 'bookworm' ); ?>:</h4>
            <div class="font-weight-medium">
                <?php echo WC()->cart->get_cart_subtotal(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        </div><?php
    }
}

if ( ! function_exists( 'bookworm_product_category_taxonomy_fields' ) ) {
    /**
     * Sets up Product categories metaboxes
     */
    function bookworm_product_category_taxonomy_fields() {
        require_once get_template_directory() . '/inc/woocommerce/class-bookworm-categories.php';
    }
}

if ( ! function_exists( 'bookworm_setup_brands_taxonomy' ) ) {
    /**
     * Sets up Brands Taxonomy from Product attributes
     */
    function bookworm_setup_brands_taxonomy() {
        if( class_exists( 'Mas_WC_Brands' ) ) {
            $brand_taxonomy = Mas_WC_Brands()->get_brand_taxonomy();

            if ( ! empty( $brand_taxonomy ) ) {
                require_once get_template_directory() . '/inc/woocommerce/class-bookworm-brands.php';
            }
        }
    }
}

