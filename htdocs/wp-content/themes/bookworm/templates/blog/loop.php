<?php
/**
 * Template part for displaying the "List" blog layout (with sidebar)
 *
 * @package Bookworm
 */

$posts_layout = function_exists( 'bookworm_posts_layout' ) ? bookworm_posts_layout() : 'list';
get_template_part( 'templates/blog/loop', $posts_layout );
