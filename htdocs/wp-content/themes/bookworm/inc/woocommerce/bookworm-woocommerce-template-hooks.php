<?php
/**
 * Bookworm WooCommerce hooks
 *
 * @package bookworm
 */

/**
 * General
 */
add_filter( 'woocommerce_format_sale_price', 'bookworm_wc_format_sale_price', 10, 3 );
add_filter( 'woocommerce_form_field', 'bookworm_wc_form_field', 10, 4 );
add_filter( 'woocommerce_form_field_args', 'bookworm_wc_form_field_args', 10, 3 );

add_filter( 'bookworm_site_header_offcanvas_toggle_links', 'bookworm_site_header_offcanvas_wc_links' );
add_filter( 'bookworm_site_header_icons_links', 'bookworm_site_header_icons_wc_links' );
add_action( 'bookworm_after_header', 'bookworm_wc_offcanvas_register_loggin_form', 20 );
add_action( 'bookworm_after_header', 'bookworm_wc_offcanvas_mini_cart', 30 );

add_action( 'after_setup_theme', 'bookworm_product_category_taxonomy_fields', 10 );
add_action( 'after_setup_theme', 							'bookworm_setup_brands_taxonomy',				10 );
//add_filter( 'woocommerce_get_breadcrumb', 'bookworm_wc_get_breadcrumb', 99, 2 );
/**
 * Layout
 *
 * @see  bookworm_wc_before_content()
 * @see  bookworm_wc_after_content()
 * @see  woocommerce_breadcrumb()
 * @see  bookworm_shop_messages()
 */
remove_action( 'woocommerce_before_main_content',         'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_main_content',         'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',          'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar',                     'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_after_shop_loop',             'woocommerce_pagination', 10 );
remove_action( 'woocommerce_before_shop_loop',            'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop',            'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title',  'woocommerce_template_loop_rating', 5 );

add_filter( 'loop_shop_per_page',                         'bookworm_wc_set_loop_shop_per_page', 10 );
add_filter( 'woocommerce_product_loop_start',             'bookworm_product_loop_start', 10 );
add_filter( 'woocommerce_loop_add_to_cart_link',          'bookworm_wc_loop_add_to_cart_link', 10, 3 );
add_filter( 'woocommerce_product_loop_title_classes',     'bookworm_wc_product_loop_title_classes', 10 );

add_action( 'woocommerce_before_main_content',           'bookworm_wc_before_content', 20 );
add_action( 'woocommerce_after_main_content',            'bookworm_wc_after_content', 10 );
add_action( 'woocommerce_after_main_content',            'bookworm_wc_offcanvas_product_sidebar', 20);

add_action( 'bookworm_sidebar',                          'bookworm_get_sidebar', 10 );
//add_action( 'bookworm_single_sidebar',                   'bookworm_get_single_sidebar', 10 );

add_action( 'woocommerce_before_shop_loop',              'bookworm_shop_page_top_jumbotron', 10 );
add_action( 'woocommerce_before_shop_loop',              'bookworm_shop_control_bar', 20 );
add_action( 'bookworm_shop_control_bar_left',            'bookworm_wc_result_count', 10 );
add_action( 'bookworm_shop_control_bar_right',           'woocommerce_catalog_ordering', 10 );
add_action( 'bookworm_shop_control_bar_right',           'bookworm_wc_products_per_page', 20 );
add_action( 'bookworm_shop_control_bar_right',           'bookworm_wc_products_views', 30 );
add_action( 'bookworm_shop_control_bar_right',           'bookworm_wc_product_filter_sidebar', 40 );

add_action( 'woocommerce_before_shop_loop',              'bookworm_shop_view_content_wrapper_open', 30 );
add_action( 'woocommerce_after_shop_loop',               'bookworm_shop_view_content_wrapper_close', 30 );


add_action( 'woocommerce_before_shop_loop_item',          'bookworm_wc_loop_product_grid_view_wrap_open',         4 );
add_action( 'woocommerce_before_shop_loop_item',          'bookworm_wc_template_loop_product_inner_open', 5 );
add_action( 'woocommerce_before_shop_loop_item',          'bookworm_wc_template_loop_product_header_open', 5 );

add_action( 'woocommerce_before_shop_loop_item_title',    'bookworm_wc_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title',    'woocommerce_template_loop_product_link_close', 20 );
add_action( 'woocommerce_before_shop_loop_item_title',    'woocommerce_show_product_loop_sale_flash',  25 );
add_action( 'woocommerce_before_shop_loop_item_title',    'bookworm_wc_template_loop_product_header_close', 30 );
add_action( 'woocommerce_before_shop_loop_item_title',    'bookworm_wc_template_loop_product_body_open', 40 );

remove_action( 'woocommerce_shop_loop_item_title',        'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title',           'bookworm_wc_template_loop_product_format', 5 );
remove_action( 'woocommerce_shop_loop_item_title',        'woocommerce_template_loop_product_link_open', 8 );
add_action( 'woocommerce_shop_loop_item_title',           'bookworm_wc_template_loop_product_title_link', 10 );
add_action( 'woocommerce_shop_loop_item_title',           'bookworm_wc_template_loop_product_author', 20 );
add_action( 'woocommerce_after_shop_loop_item_title',     'bookworm_wc_template_loop_product_rating', 15 );

remove_action( 'woocommerce_after_shop_loop_item',        'woocommerce_template_loop_product_link_close', 5 );
add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_template_loop_product_body_close', 7 );
add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_template_loop_product_hover_open', 7 );
//add_action( 'woocommerce_after_shop_loop_item',           'bookworm_add_compare_link', 12 );
add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_template_loop_product_hover_close', 20 );
add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_template_loop_product_inner_close', 20 );

add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_loop_product_grid_view_wrap_close',           30 );
add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_loop_product_list_view_wrap_open',            40 );

add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_template_loop_product_inner_open', 50 );

add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_template_loop_product_list_image_wrap', 60 );

add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_template_loop_product_list_body_wrap_open', 70 );
add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_template_loop_product_format', 80 );
add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_template_loop_product_title_link', 90 );
add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_template_loop_product_author', 100 );
add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_template_loop_product_excerpt', 110 );
add_action( 'woocommerce_after_shop_loop_item',           'woocommerce_template_loop_price', 120 );
add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_template_loop_product_list_body_wrap_close', 130 );

add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_template_loop_product_list_action_wrap_open', 140 );
add_action( 'woocommerce_after_shop_loop_item',           'woocommerce_template_loop_add_to_cart', 150 );

add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_template_loop_product_list_action_wrap_close', 180 );


add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_template_loop_product_inner_close', 190 );
add_action( 'woocommerce_after_shop_loop_item',           'bookworm_wc_loop_product_list_view_wrap_close',          200 );

add_action( 'woocommerce_after_shop_loop',                'woocommerce_pagination', 10 );

/**
 * Single Product
 */
add_action( 'woocommerce_before_single_product',                   'bookworm_single_product_hooks', 5 );

add_filter( 'bookworm_single_product_version',                		'bookworm_get_single_product_style', 10 );
add_filter( 'wc_product_enable_dimensions_display',                'bookworm_maybe_display_meta_in_add_info_tab', 10 );
add_filter( 'bookworm_enable_slider_vertical_pagination',          'bookworm_wc_template_slider_pagination');
add_filter( 'woocommerce_product_tabs',					           'bookworm_wc_product_tabs' );
add_filter( 'bookworm_is_wc_single_product_variations_radio_style',  'bookworm_wc_single_product_variations_radio_style_enable' );
add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'bookworm_wc_dropdown_variation_attribute_options_args', 10, 1 ); 
// Add the price  to the dropdown options items.
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'bookworm_show_price_in_attribute_dropdown', 10, 2);
add_filter( 'bookworm_is_enable_single_product_sidebar',	         'bookworm_enable_single_product_sidebar', 10 );

add_filter('woocommerce_output_related_products_args',               'bookworm_output_related_products_args');

add_filter( 'woocommerce_sale_flash',                                '__return_false',                       10, 3 );

//remove_action( 'woocommerce_before_single_product_summary',          'woocommerce_show_product_sale_flash', 10 );
//add_action( 'woocommerce_before_single_product_summary',             'bookworm_show_product_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary',          'woocommerce_show_product_images', 20 );
remove_action( 'woocommerce_single_product_summary',                 'woocommerce_template_single_rating', 10 );

add_action( 'woocommerce_before_single_product_summary',             'bookworm_wc_show_product_images', 20 );
add_action( 'woocommerce_before_single_product_summary',             'bookworm_single_product_row_start', 5 );
add_action( 'woocommerce_before_single_product_summary',             'bookworm_single_product_gallery_wrapper_start', 6 );
add_action( 'woocommerce_before_single_product_summary',             'bookworm_single_product_gallery_wrapper_end', 30 );
add_action( 'woocommerce_before_single_product_summary',             'bookworm_single_product_summary_wrapper_start', 40 );

add_action( 'woocommerce_single_product_summary',                    'bookworm_wc_product_rating_author_info', 9 );

add_action( 'woocommerce_after_single_product_summary',              'bookworm_single_product_summary_wrapper_end', 5 );
add_action( 'woocommerce_after_single_product_summary',              'bookworm_single_product_row_end', 9 );

add_action( 'bookworm_wc_product_before_tabs',                       'bookworm_wc_tabs_wrapper_start', 10 );
add_action( 'bookworm_before_wc_tabs_panel',                         'bookworm_wc_tabs_wrapper_end', 10 );
add_action( 'bookworm_before_wc_tabs_panel_content',                 'bookworm_wc_tab_panel_wrapper_start', 10 );
add_action( 'bookworm_after_wc_tabs_panel_content',                  'bookworm_wc_tab_panel_wrapper_close', 10 );


remove_action( 'woocommerce_after_single_product_summary',           'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary',           'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_after_single_product',                      'woocommerce_upsell_display', 10 );
add_action( 'woocommerce_after_single_product',                      'woocommerce_output_related_products', 20 );

add_filter( 'woocommerce_quantity_input_classes', 'bookworm_wc_quantity_input_classes', 10, 2 );
add_action( 'woocommerce_before_add_to_cart_quantity', 'bookworm_display_quantity_wrap_open', 10 );
add_action( 'woocommerce_before_add_to_cart_quantity', 'bookworm_display_quantity_plus', 20 );
add_action( 'woocommerce_after_add_to_cart_quantity', 'bookworm_display_quantity_minus', 10 );
add_action( 'woocommerce_after_add_to_cart_quantity', 'bookworm_display_quantity_wrap_close', 20 );



/**
 * Reviews
 */

add_action( 'woocommerce_review_before_comment_meta', 'bookworm_comment_author', 5 );
remove_action( 'woocommerce_review_meta', 'woocommerce_review_display_meta', 10 );
remove_action( 'woocommerce_review_comment_text', 'woocommerce_review_display_comment_text', 10 );
add_action( 'woocommerce_review_comment_text', 'bookworm_review_display_comment_text', 10 );
add_action( 'woocommerce_review_comment_text', 'bookworm_review_comment_date', 15 );

/**
 * My Account
 */
add_action( 'woocommerce_account_navigation', 'bookworm_wc_account_wrapper_start', 5 );
add_action( 'woocommerce_before_account_navigation', 'bookworm_wc_account_nav_wrapper_start', 5 );
add_action( 'woocommerce_before_account_navigation', 'bookworm_wc_account_nav_title', 8 );
add_action( 'woocommerce_after_account_navigation', 'bookworm_wc_account_nav_wrapper_close', 5 );
add_action( 'woocommerce_after_account_navigation', 'bookworm_wc_account_content_wrapper_start', 10 );
add_action( 'woocommerce_account_content', 'bookworm_wc_account_content_title', 1 );
add_action( 'woocommerce_account_content', 'bookworm_wc_account_content_wrapper_close', 15 );

add_action( 'woocommerce_account_dashboard', 'bookworm_wc_account_dashboard_icons', 10 );

/**
 * Cart
 */
remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
add_action( 'woocommerce_cart_is_empty', 'bookworm_wc_empty_cart_message', 10 );
add_action( 'woocommerce_after_cart_item_name', 'bookworm_cart_item_author', 10, 2 );
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

add_action( 'woocommerce_before_cart', 'bookworm_cart_page_header', 5 );
add_action( 'woocommerce_before_cart', 'bookworm_cart_wrapper_start', 20 );
add_action( 'woocommerce_before_cart_collaterals', 'bookworm_cart_wrapper_end', 10 );
add_action( 'woocommerce_before_cart_collaterals', 'bookworm_cart_collaterals_wrapper_start', 20 );
add_action( 'woocommerce_after_cart', 'bookworm_cart_collaterals_wrapper_end', 10 );
add_action( 'woocommerce_after_cart', 'bookworm_output_cross_sell_products' );

add_filter( 'woocommerce_add_to_cart_fragments', 'bookworm_cart_link_fragment', 10 );
add_filter( 'woocommerce_cart_totals_coupon_html', 'bookworm_wc_cart_totals_coupon_html', 10, 3 );


/**
 * Checkout
 */
add_action( 'woocommerce_checkout_order_review', 'bookworm_checkout_accordion_start', 5 );
add_action( 'woocommerce_checkout_order_review', 'bookworm_checkout_accordion_end', 15 );
add_filter( 'wc_payment_gateway_form_saved_payment_methods_html', 'bookworm_wc_saved_payment_methods_html', 10, 2 );

/*Toggle hook*/
add_action( 'woocommerce_before_shop_loop',                     'bookworm_toggle_shop_loop_hooks',         5 );

