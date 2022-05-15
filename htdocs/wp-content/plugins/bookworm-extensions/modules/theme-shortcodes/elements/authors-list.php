<?php

if( ! function_exists( 'bookworm_mas_product_authors_list_output' ) ) {
	function bookworm_mas_product_authors_list_output( $atts ) {

		$brand_taxonomy = Mas_WC_Brands()->get_brand_taxonomy();

		extract( shortcode_atts( array(
			'columns'		=> 4,
			'hide_empty'	=> 0,
			'orderby'		=> 'name',
			'order'			=> '',
			'slug'			=> '',
			'include'		=> '',
			'exclude'		=> '',
			'number'		=> '',
			'image_size'	=> '',
			'fluid_columns'	=> false
		 ), $atts ) );

		$exclude = array_map( 'intval', explode(',', $exclude) );

		if( empty( $order ) ) {
			$order = $orderby == 'name' ? 'asc' : 'desc';
		}

		$first_letter = ( get_query_var('first_letter') ) ? get_query_var( 'first_letter' ) : '';
		$page = ( get_query_var('paged') ) ? get_query_var( 'paged' ) : 1;

		$offset = ( $page - 1 ) * $number;

		$taxonomy_args = array(
			'taxonomy'		=> $brand_taxonomy,
			'hide_empty'	=> $hide_empty,
			'orderby'		=> $orderby,
			'slug'			=> $slug,
			'include'		=> $include,
			'exclude'		=> $exclude,
			'number'		=> $number,
			'order'			=> $order,
			'offset'		=> $offset,
			'first_letter'	=> $first_letter
		);

		$total_terms_args = $taxonomy_args;
		unset( $total_terms_args['offset'] );
		$total_terms = wp_count_terms( $brand_taxonomy, $total_terms_args );
		$pages = ceil( $total_terms/$number );

		$brands = get_terms( $taxonomy_args );

		ob_start();

		wc_get_template( 'shortcodes/authors-list.php', array(
			'taxonomy'		=> $brand_taxonomy,
			'brands'		=> $brands,
			'index'			=> array_merge( range( 'A', 'Z' ), array( '0-9' ) ),
			'pages'			=> $pages,
			'page'			=> $page,
			'first_letter'	=> $first_letter,
			'columns'		=> $columns,
			'image_size'	=> $image_size,
			'fluid_columns' => $fluid_columns
		), 'mas-woocommerce-brands', untrailingslashit( MAS_WCBR_ABSPATH ) . '/templates/' );

		return ob_get_clean();
	}
}

add_shortcode( 'bookworm_mas_product_authors_list', 'bookworm_mas_product_authors_list_output' );

if( ! function_exists( 'bookworm_mas_product_authors_list_terms_clauses' ) ) {
	function bookworm_mas_product_authors_list_terms_clauses( $clauses, $taxonomies, $args ) {
		if( ! in_array( Mas_WC_Brands()->get_brand_taxonomy(), $taxonomies ) ) {
			return $clauses;
		}

		global $wpdb;

		if( ! isset( $args['first_letter'] ) ) {
			return $clauses;
		}

		$clauses['where'] .= ' AND ' . $wpdb->prepare( "t.name LIKE %s", $wpdb->esc_like( $args['first_letter'] ) . '%' );

		return $clauses;
	}
}

add_filter( 'terms_clauses', 'bookworm_mas_product_authors_list_terms_clauses', 10, 3 );

if( ! function_exists( 'bookworm_mas_product_authors_list_query_vars' ) ) {
	function bookworm_mas_product_authors_list_query_vars( $qvars ) {
		$qvars[] = 'first_letter';
		return $qvars;
	}
}

add_filter( 'query_vars', 'bookworm_mas_product_authors_list_query_vars' );
