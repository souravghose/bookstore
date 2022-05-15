<?php
if ( ! function_exists( 'bookwormgb_register_meta_fields' ) ) {
    function bookwormgb_register_meta_fields() {
        register_meta( 'post', '_body_classes', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'string',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );
        register_meta( 'post', '_disable_container', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'boolean',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );

        register_meta( 'post', '_hide_page_header', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'boolean',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );

        register_meta( 'post', '_hide_page_breadcrumb', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'boolean',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );

        register_meta( 'post', '_header_style', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'string',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );
        register_meta( 'post', '_is_custom_header', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'boolean',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );
        register_meta( 'post', '_header_static_content_id', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'number',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );

        register_meta( 'post', '_footer_style', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'string',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );
        register_meta( 'post', '_is_custom_footer', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'boolean',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );
        register_meta( 'post', '_footer_static_content_id', array(
            'object_subtype' => 'page',
            'show_in_rest' => true,
            'type' => 'number',
            'single' => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_pages' );
            }
        ) );
        
    }
    add_action('init', 'bookwormgb_register_meta_fields');
}
