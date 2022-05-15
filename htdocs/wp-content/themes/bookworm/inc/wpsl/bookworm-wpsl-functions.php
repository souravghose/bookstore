<?php

add_filter( 'wpsl_templates', 'bookworm_wpsl_custom_templates' );

if ( ! function_exists( 'bookworm_wpsl_custom_templates' ) ) {
    
    function bookworm_wpsl_custom_templates( $templates ) {

        /**
         * The 'id' is for internal use and must be unique ( since 2.0 ).
         * The 'name' is used in the template dropdown on the settings page.
         * The 'path' points to the location of the custom template,
         * in this case the folder of your active theme.
         */
        $templates[] = array (
            'id'   => 'custom',
            'name' => 'Custom template',
            'path' => get_stylesheet_directory() . '/' . 'wpsl-templates/custom.php',
        );

        return $templates;
    }
}