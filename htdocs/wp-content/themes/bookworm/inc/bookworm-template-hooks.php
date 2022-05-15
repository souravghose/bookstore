<?php
/**
 * Bookworm hooks
 *
 * @package bookworm
 */
/**
 * Header
 */

add_filter( 'bookworm_site_header_support_lists', 'bookworm_site_header_support_lists_args', 10 );
add_filter( 'bookworm_header_version',     'bookworm_page_header_layout', 10 );


add_action( 'bookworm_after_header', 'bookworm_offcanvas_nav', 10 );

add_action( 'bookworm_header_v1', 'bookworm_topbar_v1', 10 );
add_action( 'bookworm_header_v1', 'bookworm_masthead_v1', 20 );

add_action( 'bookworm_masthead_v1', 'bookworm_offcanvas_toggler_v1', 10 );
add_action( 'bookworm_masthead_v1', 'bookworm_site_branding_v1', 20 );
add_action( 'bookworm_masthead_v1', 'bookworm_site_navigation_v1', 30 );
//add_action( 'bookworm_masthead_v1', 'bookworm_site_header_v1_icons_links', 35 );

add_action( 'bookworm_masthead_v1', 'bookworm_site_search_v1', 40 );

add_action( 'bookworm_header_v2', 'bookworm_masthead_v2', 10 );

add_action( 'bookworm_masthead_v2', 'bookworm_offcanvas_toggler_v2', 10 );
add_action( 'bookworm_masthead_v2', 'bookworm_site_branding_v2', 20 );
add_action( 'bookworm_masthead_v2', 'bookworm_site_search_v2', 30 );
add_action( 'bookworm_masthead_v2', 'bookworm_site_header_v2_offcanvas_toggle_links', 40 );

add_action( 'bookworm_masthead_v2_content_after', 'bookworm_site_header_v2_navbar', 10 );

add_action( 'bookworm_header_v3', 'bookworm_topbar_v3', 10 );
add_action( 'bookworm_header_v3', 'bookworm_masthead_v3', 20 );

add_action( 'bookworm_masthead_v3', 'bookworm_site_branding_v3', 10 );
add_action( 'bookworm_masthead_v3', 'bookworm_site_navigation_v3', 20 );
add_action( 'bookworm_masthead_v3', 'bookworm_site_header_v3_support_lists', 30 );

add_action( 'bookworm_masthead_v3_content_after', 'bookworm_site_header_v3_bottom_bar', 10 );

add_action( 'bookworm_site_header_v3_bottom_bar', 'bookworm_offcanvas_toggler_v3', 10 );
add_action( 'bookworm_site_header_v3_bottom_bar', 'bookworm_site_search_v3', 20 );
add_action( 'bookworm_site_header_v3_bottom_bar', 'bookworm_site_header_v3_icons_links', 30 );

add_action( 'bookworm_header_v4', 'bookworm_masthead_v4', 10 );

add_action( 'bookworm_masthead_v4', 'bookworm_site_branding_v4', 10 );
add_action( 'bookworm_masthead_v4', 'bookworm_site_navigation_v4', 20 );
add_action( 'bookworm_masthead_v4', 'bookworm_site_header_v3_support_lists', 30 );

add_action( 'bookworm_masthead_v4_content_after', 'bookworm_site_header_v4_bottom_bar', 10 );

add_action( 'bookworm_site_header_v4_bottom_bar', 'bookworm_site_header_v4_department_menu', 10 );
add_action( 'bookworm_site_header_v4_bottom_bar', 'bookworm_offcanvas_toggler_v4', 20 );
add_action( 'bookworm_site_header_v4_bottom_bar', 'bookworm_site_search_v4', 30 );
add_action( 'bookworm_site_header_v4_bottom_bar', 'bookworm_site_header_v4_icons_links', 40 );

add_action( 'bookworm_header_v5', 'bookworm_masthead_v5', 10 );

add_action( 'bookworm_masthead_v5', 'bookworm_site_branding_v5', 10 );
add_action( 'bookworm_masthead_v5', 'bookworm_site_search_v5', 20 );
add_action( 'bookworm_masthead_v5', 'bookworm_site_header_v5_icons_links', 30 );

add_action( 'bookworm_masthead_v5_content_after', 'bookworm_site_header_v5_bottom_bar', 10 );

add_action( 'bookworm_site_header_v5_bottom_bar', 'bookworm_site_header_v5_department_menu', 10 );
add_action( 'bookworm_site_header_v5_bottom_bar', 'bookworm_offcanvas_toggler_v5', 20 );
add_action( 'bookworm_site_header_v5_bottom_bar', 'bookworm_site_navigation_v5', 30 );

add_action( 'bookworm_header_v6', 'bookworm_topbar_v6', 10 );
add_action( 'bookworm_header_v6', 'bookworm_masthead_v6', 20 );

add_action( 'bookworm_masthead_v6', 'bookworm_offcanvas_toggler_v6', 10 );
add_action( 'bookworm_masthead_v6', 'bookworm_site_branding_v6', 20 );
add_action( 'bookworm_masthead_v6', 'bookworm_site_navigation_v6', 30 );
add_action( 'bookworm_masthead_v6', 'bookworm_site_header_v6_icons_links', 40 );

add_action( 'bookworm_header_v7', 'bookworm_topbar_v7', 10 );
add_action( 'bookworm_header_v7', 'bookworm_masthead_v7', 20 );

add_action( 'bookworm_masthead_v7', 'bookworm_site_branding_v7', 10 );
add_action( 'bookworm_masthead_v7', 'bookworm_site_search_v7', 20 );
add_action( 'bookworm_masthead_v7', 'bookworm_site_header_v7_icons_links', 30 );

add_action( 'bookworm_masthead_v7_content_after', 'bookworm_site_header_v7_bottom_bar', 10 );

add_action( 'bookworm_site_header_v7_bottom_bar', 'bookworm_offcanvas_toggler_v7', 10 );
add_action( 'bookworm_site_header_v7_bottom_bar', 'bookworm_site_navigation_v7', 20 );

add_action( 'bookworm_header_v8', 'bookworm_masthead_v8', 10 );

add_action( 'bookworm_masthead_v8', 'bookworm_offcanvas_toggler_v8', 10 );
add_action( 'bookworm_masthead_v8', 'bookworm_site_branding_v8', 20 );
add_action( 'bookworm_masthead_v8', 'bookworm_site_navigation_v8', 30 );
add_action( 'bookworm_masthead_v8', 'bookworm_site_header_v8_icons_links', 40 );

add_action( 'bookworm_masthead_v8', 'bookworm_site_header_v8_search_icon_form_content', 50 );

add_action( 'bookworm_header_v9', 'bookworm_masthead_v9', 10 );

add_action( 'bookworm_masthead_v9', 'bookworm_offcanvas_toggler_v9', 10 );
add_action( 'bookworm_masthead_v9', 'bookworm_site_branding_v9', 20 );
add_action( 'bookworm_masthead_v9', 'bookworm_site_search_v9', 30 );
add_action( 'bookworm_masthead_v9', 'bookworm_site_header_v9_offcanvas_toggle_links', 40 );

add_action( 'bookworm_masthead_v9_content_after', 'bookworm_site_header_v9_navbar', 10 );

add_action( 'bookworm_header_v10', 'bookworm_topbar_v10', 10 );
add_action( 'bookworm_header_v10', 'bookworm_masthead_v10', 20 );
add_action( 'bookworm_header_v10', 'bookworm_site_header_v10_bg', 20 );

add_action( 'bookworm_masthead_v10', 'bookworm_offcanvas_toggler_site_navigation_v10', 10 );
add_action( 'bookworm_masthead_v10', 'bookworm_site_branding_v10', 20 );
add_action( 'bookworm_masthead_v10', 'bookworm_site_header_v10_icons_links', 30 );

add_action( 'bookworm_masthead_v10', 'bookworm_site_header_v10_search_icon_form_content', 40 );

add_action( 'bookworm_header_v11', 'bookworm_masthead_v11', 10 );

add_action( 'bookworm_masthead_v11', 'bookworm_offcanvas_toggler_site_navigation_v11', 10 );
add_action( 'bookworm_masthead_v11', 'bookworm_site_branding_v11', 20 );
add_action( 'bookworm_masthead_v11', 'bookworm_site_header_v11_icons_links', 30 );

add_action( 'bookworm_masthead_v11', 'bookworm_site_header_v11_search_icon_form_content', 40 );

add_action( 'bookworm_header_v12', 'bookworm_topbar_v12', 10 );
add_action( 'bookworm_header_v12', 'bookworm_masthead_v12', 20 );

add_action( 'bookworm_masthead_v12', 'bookworm_site_header_v12_support_lists', 10 );
add_action( 'bookworm_masthead_v12', 'bookworm_offcanvas_toggler_v12', 20 );
add_action( 'bookworm_masthead_v12', 'bookworm_site_branding_v12', 30 );
add_action( 'bookworm_masthead_v12', 'bookworm_site_header_v12_offcanvas_toggle_links', 30 );

add_action( 'bookworm_masthead_v12_content_after', 'bookworm_site_header_v12_navbar', 10 );

add_action( 'bookworm_header_v13', 'bookworm_topbar_v13', 10 );
add_action( 'bookworm_header_v13', 'bookworm_masthead_v13', 20 );

add_action( 'bookworm_masthead_v13', 'bookworm_offcanvas_toggler_site_navigation_v13', 10 );
add_action( 'bookworm_masthead_v13', 'bookworm_site_branding_v13', 20 );
add_action( 'bookworm_masthead_v13', 'bookworm_site_header_v13_icons_links', 30 );

add_action( 'bookworm_masthead_v13', 'bookworm_site_header_v13_search_icon_form_content', 40 );

add_action( 'bookworm_before_site', 'bookworm_breadcrumb', 10 );

add_action( 'bookworm_page', 'bookworm_page_header', 10 );
add_action( 'bookworm_page', 'bookworm_page_content', 20 );

add_action( 'bookworm_posts_content_after', 'bookworm_post_pagination_spacing', 10 );
add_action( 'bookworm_posts_content_after', 'bookworm_pagination', 20 );

/**
 * Footer
 */
add_action( 'bookworm_footer_v1', 'bookworm_footer_widgets_v1', 10 );
add_action( 'bookworm_footer_v1', 'bookworm_site_info_v1', 20 );

add_action( 'bookworm_before_footer_widgets_v1', 'bookworm_footer_newsletter', 10 );

add_action( 'bookworm_contact_info', 'bookworm_footer_logo', 10 );
add_action( 'bookworm_contact_info', 'bookworm_shop_address', 20 );
add_action( 'bookworm_contact_info', 'bookworm_contact_links', 30 );
add_action( 'bookworm_contact_info', 'bookworm_social_media_links', 40 );

add_action( 'bookworm_site_info', 'bookworm_payment_info', 10 );
add_action( 'bookworm_site_info', 'bookworm_language_currency', 20 );


add_action( 'bookworm_footer_v2', 'bookworm_footer_widgets_v2', 10 );
add_action( 'bookworm_footer_v2', 'bookworm_site_info_v2', 20 );
add_action( 'bookworm_before_footer_widgets_v3', 'bookworm_footer_newsletter', 10 );
add_action( 'bookworm_footer_v3', 'bookworm_footer_widgets_v3', 10 );
add_action( 'bookworm_footer_v3', 'bookworm_site_info_v3', 20 );

add_action( 'bookworm_footer_v4', 'bookworm_footer_widgets_v4', 10 );
add_action( 'bookworm_footer_v4', 'bookworm_site_info_v4', 20 );

add_action( 'bookworm_footer_v5', 'bookworm_footer_widgets_v5', 10 );
add_action( 'bookworm_footer_v5', 'bookworm_site_info_v5', 20 );
add_action( 'bookworm_before_footer_content_v6', 'bookworm_footer_before_content_v6', 10 );
add_action( 'bookworm_footer_v6', 'bookworm_footer_widgets_v6', 10 );
add_action( 'bookworm_footer_v6', 'bookworm_site_info_v6', 20 );
add_action( 'bookworm_footer_v7', 'bookworm_footer_widgets_v7', 10 );
add_action( 'bookworm_footer_v7', 'bookworm_site_info_v7', 20 );
add_action( 'bookworm_footer_v8', 'bookworm_footer_widgets_v8', 10 );
add_action( 'bookworm_footer_v8', 'bookworm_site_info_v8', 20 );

add_action( 'bookworm_before_footer_content_v9', 'bookworm_footer_before_content_v9', 10 );
add_action( 'bookworm_footer_v9', 'bookworm_footer_widgets_v9', 10 );
add_action( 'bookworm_footer_v9', 'bookworm_site_info_v9', 20 );
add_action( 'bookworm_before_footer_widgets_v10', 'bookworm_footer_newsletter', 10 );
add_action( 'bookworm_footer_v10', 'bookworm_footer_widgets_v10', 10 );
add_action( 'bookworm_footer_v10', 'bookworm_site_info_v10', 20 );
add_action( 'bookworm_before_footer_widgets_v11', 'bookworm_footer_newsletter', 10 );
add_action( 'bookworm_footer_v11', 'bookworm_footer_widgets_v11', 10 );
add_action( 'bookworm_footer_v11', 'bookworm_site_info_v11', 20 );
add_action( 'bookworm_footer_v12', 'bookworm_footer_widgets_v12', 10 );
add_action( 'bookworm_footer_v12', 'bookworm_site_info_v12', 20 );
add_action( 'bookworm_footer_v13', 'bookworm_footer_widgets_v13', 10 );
add_action( 'bookworm_footer_v13', 'bookworm_site_info_v13', 20 );

add_action( 'bookworm_footer_widgets_v1', 'bookworm_footer_widgets_columns', 10, 3 );
add_action( 'bookworm_footer_widgets_v2', 'bookworm_footer_widgets_column_v2', 10, 3 );
add_action( 'bookworm_footer_widgets_v3', 'bookworm_footer_widgets_columns', 10, 3 );
add_action( 'bookworm_footer_widgets_v4', 'bookworm_footer_widgets_column_v4', 10, 3 );
add_action( 'bookworm_footer_widgets_v5', 'bookworm_footer_widgets_columns', 10, 3 );
add_action( 'bookworm_footer_widgets_v6', 'bookworm_footer_widgets_column_v6', 10, 3 );
add_action( 'bookworm_footer_widgets_v7', 'bookworm_footer_widgets_column_v7', 10, 3 );
add_action( 'bookworm_footer_widgets_v8', 'bookworm_footer_widgets_column_v8', 10, 3 );
add_action( 'bookworm_footer_widgets_v9', 'bookworm_footer_widgets_column_v9', 10, 3 );
add_action( 'bookworm_footer_widgets_v10', 'bookworm_footer_widgets_column_v10', 10, 3 );
add_action( 'bookworm_footer_widgets_v11', 'bookworm_footer_widgets_columns', 10, 3 );
add_action( 'bookworm_footer_widgets_v12', 'bookworm_footer_widgets_column_v12', 10, 3 );
add_action( 'bookworm_footer_widgets_v13', 'bookworm_footer_widgets_column_v13', 10, 3 );

add_filter( 'bookworm_footer_version',     'bookworm_page_footer_layout', 10 );

/**
 * Single post
 */
add_action( 'bookworm_single_post_before',   'bookworm_container_start', 10 );
add_action( 'bookworm_single_post_before',   'bookworm_single_post_wrap_start', 20 );

add_action( 'bookworm_single_post',          'bookworm_single_post_media', 10 );
add_action( 'bookworm_single_post',          'bookworm_single_post_content_wrap_start', 20 );

add_action( 'bookworm_single_post',          'bookworm_single_post_content_header', 30 );
add_action( 'bookworm_single_post',          'bookworm_single_post_content', 40 );
add_action( 'bookworm_single_post',          'bookworm_single_post_content_wrap_end', 50 );
add_action( 'bookworm_single_post',          'bookworm_single_post_content_footer', 60 );

add_action( 'bookworm_single_post_header',          'bookworm_single_post_category',       10 );
add_action( 'bookworm_single_post_header',          'bookworm_post_title',       20 );
add_action( 'bookworm_single_post_header',          'bookworm_post_meta',       30 );

add_action( 'bookworm_single_post_after',    'bookworm_single_post_wrap_end', 100 );
add_action( 'bookworm_single_post_after',    'bookworm_container_end', 110 );

/**
 * Comments
 */
add_filter( 'comment_form_default_fields', 'bookworm_comment_form_default_fields', 20 );

/**
 * Protected Post Custom Password Form
 */
add_filter( 'the_password_form', 'bookworm_post_protected_password_form' );

/**
 * Nav Menu Widget Handle Custom Fields
 */
add_filter( 'in_widget_form', 'bookworm_custom_widget_nav_menu_options', 10, 3 );
add_filter( 'widget_update_callback', 'bookworm_custom_widget_nav_menu_options_update', 10, 4 );
add_filter( 'widget_nav_menu_args', 'bookworm_custom_widget_nav_menu_args', 20, 4 );

add_filter( 'bookworm_dropdown_tools_toggle', 'bookworm_dropdown_tools_title', 10);
add_filter( 'bookworm_dropdown_tools', 'bookworm_dropdown_tools_language_currency', 10);
