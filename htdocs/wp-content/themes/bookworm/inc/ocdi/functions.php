<?php

function bookworm_ocdi_import_files() {
    $dd_path = trailingslashit( get_template_directory() ) . 'assets/dummy-data/';
    return apply_filters( 'bookworm_ocdi_files_args', array(
        array(
            'import_file_name'             => 'Bookworm',
            'categories'                   => array( 'Bookworm' ),
            'local_import_file'            => $dd_path . 'dummy-data.xml',
            'local_import_widget_file'     => $dd_path . 'widgets.wie',
            'local_import_customizer_file' => $dd_path . 'customizer.dat',
            'import_notice'                => esc_html__( 'Import process may take 3-5 minutes. If you facing any issues please contact our support.', 'bookworm' ),
        ),
    ) );
}

function bookworm_ocdi_after_import_setup( $selected_import ) {

    // Assign menus to their locations.
    $topbar_left   = get_term_by( 'name', 'Topbar Left v1', 'nav_menu' );
    $topbar_right  = get_term_by( 'name', 'Topbar Right v1', 'nav_menu' );
    $primary       = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
    $secondary     = get_term_by( 'name', 'Secondary Menu', 'nav_menu' );
    $social_media  = get_term_by( 'name', 'Social Menu', 'nav_menu' );
    $contact_links = get_term_by( 'name', 'Contact Links', 'nav_menu' );
    $department    = get_term_by( 'name', 'Department Menu', 'nav_menu' );
    $offcanvas     = get_term_by( 'name', 'Offcanvas Menu', 'nav_menu' );

    $nav_menu_locations = array(
        'topbar_left'   => $topbar_left->term_id,
        'topbar_right'  => $topbar_right->term_id,
        'primary'       => $primary->term_id,
        'secondary'     => $secondary->term_id,
        'social_media'  => $social_media->term_id,
        'contact_links' => $contact_links->term_id,
        'department'    => $department->term_id,
        'offcanvas'     => $offcanvas->term_id,
    );

    set_theme_mod( 'nav_menu_locations', $nav_menu_locations );

    // Assign front page and posts page (blog page) and other pages
    $front_page_id                  = get_page_by_title( 'Home v1' );
    $blog_page_id                   = get_page_by_title( 'Blog' );
    $shop_page_id                   = get_page_by_title( 'Shop' );
    $cart_page_id                   = get_page_by_title( 'Cart' );
    $checkout_page_id               = get_page_by_title( 'Checkout' );
    $myaccount_page_id              = get_page_by_title( 'My account' );
    $wishlist_page_id               = get_page_by_title( 'Wishlist' );

    bookworm_ocdi_import_wpforms();

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
    update_option( 'woocommerce_shop_page_id', $shop_page_id->ID );
    update_option( 'woocommerce_cart_page_id', $cart_page_id->ID );
    update_option( 'woocommerce_checkout_page_id', $checkout_page_id->ID );
    update_option( 'woocommerce_myaccount_page_id', $myaccount_page_id->ID );
    update_option( 'yith_wcwl_wishlist_page_id', $wishlist_page_id->ID );

    // Enable Registration on "My Account" page
    update_option( 'woocommerce_enable_myaccount_registration', 'yes' );

    // Update Wishlist Position
    update_option( 'yith_wcwl_button_position', 'shortcode' );

    // Assign MAS Brand Attribute
    update_option( 'mas_wc_brands_brand_taxonomy', 'pa_book-author' );

    if ( function_exists( 'wc_delete_product_transients' ) ) {
        wc_delete_product_transients();
    }
    if ( function_exists( 'wc_delete_shop_order_transients' ) ) {
        wc_delete_shop_order_transients();
    }
    if ( function_exists( 'wc_delete_expired_transients' ) ) {
        wc_delete_expired_transients();
    }

    if ( function_exists( 'wc_update_product_lookup_tables_is_running' ) && function_exists( 'wc_update_product_lookup_tables' ) && ! wc_update_product_lookup_tables_is_running() ) {
        wc_update_product_lookup_tables();
    }

    if ( class_exists( 'WP_Store_locator' ) ) {
        update_option( 'template_id', 'custom' );
    }

    bookworm_ocdi_import_after_update_attribute_setup();

}

function bookworm_ocdi_before_widgets_import() {

    $sidebars_widgets = get_option('sidebars_widgets');
    $all_widgets = array();

    array_walk_recursive( $sidebars_widgets, function ($item, $key) use ( &$all_widgets ) {
        if( ! isset( $all_widgets[$key] ) ) {
            $all_widgets[$key] = $item;
        } else {
            $all_widgets[] = $item;
        }
    } );

    if( isset( $all_widgets['array_version'] ) ) {
        $array_version = $all_widgets['array_version'];
        unset( $all_widgets['array_version'] );
    }

    $new_sidebars_widgets = array_fill_keys( array_keys( $sidebars_widgets ), array() );

    $new_sidebars_widgets['wp_inactive_widgets'] = $all_widgets;
    if( isset( $array_version ) ) {
        $new_sidebars_widgets['array_version'] = $array_version;
    }

    update_option( 'sidebars_widgets', $new_sidebars_widgets );
}

if( ! function_exists( 'bookworm_custom_sidebar_update' ) ) {
    function bookworm_custom_sidebar_update() {
        $sidebars_json = '{
            "0": {
                "id": "cs-1",
                "name": "Footer Contact Widget",
                "description": "Widgets added here will appear in footer with contact details",
                "before_widget": "",
                "before_title": "",
                "after_widget": "",
                "after_title": ""
            },
            "1": {
                "id": "cs-2",
                "name": "Footer Contact Widget 12",
                "description": "",
                "before_widget": "",
                "before_title": "",
                "after_widget": "",
                "after_title": ""
            },
            "2": {
                "id": "cs-3",
                "name": "Footer v13 Column 1",
                "description": "",
                "before_widget": "",
                "before_title": "",
                "after_widget": "",
                "after_title": ""
            },
            "3": {
                "id": "cs-4",
                "name": "Footer v13 Column 2",
                "description": "",
                "before_widget": "",
                "before_title": "",
                "after_widget": "",
                "after_title": ""
            },
            "4": {
                "id": "cs-5",
                "name": "Footer v13 Column 3",
                "description": "",
                "before_widget": "",
                "before_title": "",
                "after_widget": "",
                "after_title": ""
            },
            "5": {
                "id": "cs-6",
                "name": "Footer v13 Column 4",
                "description": "",
                "before_widget": "",
                "before_title": "",
                "after_widget": "",
                "after_title": ""
            },
            "6": {
                "id": "cs-7",
                "name": "Footer v4 Column 4",
                "description": "",
                "before_widget": "",
                "before_title": "",
                "after_widget": "",
                "after_title": ""
            },
            "7": {
                "id": "cs-8",
                "name": "Footer v8 Column 1",
                "description": "",
                "before_widget": "",
                "before_title": "",
                "after_widget": "",
                "after_title": ""
            },
            "8": {
                "id": "cs-9",
                "name": "Footer v8 Column 2",
                "description": "",
                "before_widget": "",
                "before_title": "",
                "after_widget": "",
                "after_title": ""
            },
            "9": {
                "id": "cs-10",
                "name": "Footer v8 Column 3",
                "description": "",
                "before_widget": "",
                "before_title": "",
                "after_widget": "",
                "after_title": ""
            },
            "10": {
                "id": "cs-11",
                "name": "Footer v8 Column 4",
                "description": "",
                "before_widget": "",
                "before_title": "",
                "after_widget": "",
                "after_title": ""
            }
        }';
        $sidebars = json_decode( $sidebars_json, true );
        update_option( 'cs_sidebars', $sidebars );
    }
}

function bookworm_ocdi_wp_import_post_data_processed( $postdata, $data ) {
    $site_upload_dir_find_urls = array(
        'https://demo.madrasthemes.com/bookworm/wp-content/uploads/sites/88',
    );
    $site_upload_dir_url = $upload_dir = wp_get_upload_dir();
    $postdata = str_replace( $site_upload_dir_find_urls, $site_upload_dir_url['baseurl'], $postdata );

    $site_content_find_urls = array(
        'https://demo.madrasthemes.com/bookworm/wp-content/',
    );
    $site_content_url = content_url( '/' );
    $postdata = str_replace( $site_content_find_urls, $site_content_url, $postdata );

    $site_home_find_urls = array(
        'https://demo.madrasthemes.com/bookworm/',
    );
    $site_home_url = home_url( '/' );
    $postdata = str_replace( $site_home_find_urls, $site_home_url, $postdata );

    if( defined( 'PT_OCDI_VERSION' ) && version_compare( PT_OCDI_VERSION, '2.6.0' , '<' ) ) {
        return wp_slash( $postdata );
    }

    return $postdata;
}

function bookworm_wp_import_post_meta_data_processed( $meta_item, $post_id ) {

    if( isset( $meta_item['value'] ) ) {
        $site_home_find_urls = array(
            'https://demo.madrasthemes.com/bookworm/',
        );
        $site_home_url = home_url( '/' );
        $meta_item['value'] = str_replace( $site_home_find_urls, $site_home_url, $meta_item['value'] );
    }

    return $meta_item;
}

function bookworm_ocdi_admin_styles() {
    $tgmpa_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
    if( $tgmpa_instance->is_tgmpa_complete() != true ) {
        $script = "
            jQuery(document).ready( function($){
                $( '.ocdi__demo-import-notice' ).siblings( '.ocdi__button-container' ).children( '.js-ocdi-import-data' ).attr( 'disabled', 'disabled' );
                $( '.bookworm-ocdi-install-plugin-instructions' ).show();
                $( '.bookworm-ocdi-jetpack-module-instructions' ).hide();
            } );
        ";
        wp_add_inline_script( 'ocdi-main-js', $script );
    } else {
         $script = "
            jQuery(document).ready( function($){
                $( '.bookworm-ocdi-install-plugin-instructions' ).hide();
                $( '.bookworm-ocdi-jetpack-module-instructions' ).hide();
            } );
        ";
        wp_add_inline_script( 'ocdi-main-js', $script );
    }
}

function bookworm_ocdi_import_wpforms() {
    if ( ! function_exists( 'wpforms' ) ) {
        return;
    }

    $forms = [
        [
            'file' => 'wpforms-contact-form.json'
        ],
        [
            'file' => 'wpforms-subscribe-form.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-v2.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-v3.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-v5.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-4.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-6.json'
        ],
        [
            'file' => 'wpforms-subscribe-form-7.json'
        ],
    ];

    foreach ( $forms as $form ) {
        ob_start();
        bookworm_get_template( $form['file'], array(), 'assets/dummy-data/wpforms/' );
        $form_json = ob_get_clean();
        $form_data = json_decode( $form_json, true );

        if ( empty( $form_data[0] ) ) {
            continue;
        }
        $form_data = $form_data[0];
        $form_title = $form_data['settings']['form_title'];

        if( !empty( $form_data['id'] ) ) {
            $form_content = array(
                'field_id' => '0',
                'settings' => array(
                    'form_title' => sanitize_text_field( $form_title ),
                    'form_desc'  => '',
                ),
            );

            // Merge args and create the form.
            $form = array(
                'import_id'     => (int) $form_data['id'],
                'post_title'    => esc_html( $form_title ),
                'post_status'   => 'publish',
                'post_type'     => 'wpforms',
                'post_content'  => wpforms_encode( $form_content ),
            );

            $form_id = wp_insert_post( $form );
        } else {
            // Create initial form to get the form ID.
            $form_id   = wpforms()->form->add( $form_title );
        }

        if ( empty( $form_id ) ) {
            continue;
        }

        $form_data['id'] = $form_id;
        // Save the form data to the new form.
        wpforms()->form->update( $form_id, $form_data );
    }
}

function bookworm_ocdi_import_after_update_attribute_setup() {
    $products  = wc_get_products( array('orderby' => 'name') );

    // Loop through queried products
    foreach($products as $product) {
        // Loop through product attributes
        foreach( $product->get_attributes() as $attribute ) {
            if( $attribute->is_taxonomy() ) {
                $attribute_id   = $attribute->get_id(); // Get attribute Id
                $attribute_data = wc_get_attribute( $attribute_id ); // Get attribute data from the attribute Id
                
                // Update the product attribute with a new taxonomy label name
                wc_update_attribute( $attribute_id, array(
                    'name'         => $attribute_data->name, // <== == == Here set the taxonomy label name
                    'slug'         => $attribute_data->slug,
                    'type'         => $attribute_data->type,
                    'order_by'     => $attribute_data->order_by,
                    'has_archives' => 1,
                ) );
            }
        }
    }
}