<?php

add_filter( 'pt-ocdi/import_files', 'bookworm_ocdi_import_files' );

add_action( 'pt-ocdi/after_import', 'bookworm_ocdi_after_import_setup' );

add_action( 'pt-ocdi/before_widgets_import', 'bookworm_ocdi_before_widgets_import' );

add_action( 'admin_init', 'bookworm_custom_sidebar_update' );

add_filter( 'wp_import_post_data_processed', 'bookworm_ocdi_wp_import_post_data_processed', 99, 2 );

add_filter( 'wxr_importer.pre_process.post_meta', 'bookworm_wp_import_post_meta_data_processed', 99, 2 );

add_action( 'admin_enqueue_scripts', 'bookworm_ocdi_admin_styles' );

