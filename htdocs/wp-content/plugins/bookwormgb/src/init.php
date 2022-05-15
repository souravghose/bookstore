<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since 	0.1
 * @package BookwormGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bookwormgb_block_assets' ) ) {

	/**
	* Enqueue block assets for both frontend + backend.
	*
	* @since 0.1
	*/
	function bookwormgb_block_assets() {

		$enqueue_styles_in_frontend  = apply_filters( 'bookwormgb_enqueue_styles', ! is_admin() );
		$enqueue_scripts_in_frontend = apply_filters( 'bookwormgb_enqueue_scripts', ! is_admin() );

		// Frontend block styles.
		if ( is_admin() || $enqueue_styles_in_frontend ) {
			wp_enqueue_style(
				'bwgb-style-css',
				plugins_url( 'dist/frontend_blocks.css', BWGB_FILE ),
				array(),
				BWGB_VERSION
			);
		}

		// Frontend only scripts.
		if ( $enqueue_scripts_in_frontend ) {
			wp_enqueue_script(
				'bwgb-block-frontend-js',
				plugins_url( 'dist/frontend_blocks.js', BWGB_FILE ),
				array( 'wp-element', 'slick', 'hs-core', 'hs-slick-carousel', 'jquery-countdown', 'hs-countdown' ),
				BWGB_VERSION
			);

			wp_localize_script( 'bwgb-block-frontend-js', 'bookwormgb', bookwormgb_get_localize_script_data() );
		}
	}
	add_action( 'enqueue_block_assets', 'bookwormgb_block_assets' );
}

if ( ! function_exists( 'bookwormgb_block_editor_assets' ) ) {

	/**
	 * Enqueue block assets for backend editor.
	 *
	 * @since 0.1
	 */
	function bookwormgb_block_editor_assets() {

		// Enqueue CodeMirror for Custom CSS.
		wp_enqueue_code_editor( array(
			'type' => 'text/css', // @see https://developer.wordpress.org/reference/functions/wp_get_code_editor_settings/
			'codemirror' => array(
				'indentUnit' => 2,
				'tabSize' => 2,
			),
		) );

		// Backend editor scripts: common vendor files.
		wp_enqueue_script(
			'bwgb-block-js-vendor',
			plugins_url( 'dist/editor_vendor.js', BWGB_FILE ),
			array(),
			BWGB_VERSION
		);

		// Backend editor scripts: blocks.
		wp_enqueue_script(
			'bwgb-block-js',
			plugins_url( 'dist/editor_blocks.js', BWGB_FILE ),
			// wp-util for wp.ajax.
			// wp-plugins & wp-edit-post for Gutenberg plugins.
			array( 'bwgb-block-js-vendor', 'code-editor', 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor', 'wp-util', 'wp-plugins', 'wp-edit-post', 'wp-i18n', 'wp-api' ),
			BWGB_VERSION
		);

		// Backend editor scripts: meta.
        wp_enqueue_script(
            'bwgb-meta-js',
            plugins_url( 'dist/editor_meta.js', BWGB_FILE ),
            array( 'wp-plugins', 'wp-edit-post', 'wp-i18n', 'wp-element' ),
            BWGB_VERSION
        );


		// Add translations.
		wp_set_script_translations( 'bwgb-block-js', BWGB_I18N );

		// Backend editor only styles.
		wp_enqueue_style(
			'bwgb-block-editor-css',
			plugins_url( 'dist/editor_blocks.css', BWGB_FILE ),
			array( 'wp-edit-blocks' ),
			BWGB_VERSION
		);

		wp_localize_script( 'bwgb-block-js-vendor', 'bookwormgb', bookwormgb_get_localize_script_data() );
	}

	// Enqueue in a higher number so that other scripts that add on BookwormGB can load first. E.g. Premium.
	add_action( 'enqueue_block_editor_assets', 'bookwormgb_block_editor_assets', 20 );
}

if ( ! function_exists( 'bookwormgb_get_localize_script_data' ) ) {

	/**
	 * Localize.
	 */
	function bookwormgb_get_localize_script_data() {
		global $content_width, $wp_registered_sidebars;

		$admin_ajax_url = admin_url( 'admin-ajax.php' );
		$current_lang   = apply_filters( 'wpml_current_language', NULL );

		if ( $current_lang ) {
			$admin_ajax_url = add_query_arg( 'lang', $current_lang, $admin_ajax_url );
		}

		return array(
			'ajaxUrl' => $admin_ajax_url,
			'srcUrl' => untrailingslashit( plugins_url( '/', BWGB_FILE ) ),
			'contentWidth' => isset( $content_width ) ? $content_width : 900,
			'i18n' => BWGB_I18N,
			'disabledBlocks' => bookwormgb_get_disabled_blocks(),
			'nonce' => wp_create_nonce( 'bookwormgb' ),
			'devMode' => defined( 'WP_ENV' ) ? WP_ENV === 'development' : false,
			'cdnUrl' => BWGB_CLOUDFRONT_URL,
			'wpRegisteredSidebars'  => json_encode( $wp_registered_sidebars ),

			// Fonts.
			'locale' => get_locale(),

			// Palette Color.
			'paletteColor' => get_theme_support( 'editor-color-palette' ),

			// Overridable default primary color for buttons and other blocks.
			'primaryColor' => get_theme_mod( 's_primary_color', '#f75454' ),
			'isYithCompareActive'   =>  class_exists( 'YITH_Woocompare' ),
			'isYithWcWlActive'   => function_exists( 'YITH_WCWL' ),
			'isWoocommerceActive'   => function_exists( 'bookworm_is_woocommerce_activated' ) && bookworm_is_woocommerce_activated(),
			'isRTL'                 => is_rtl(),
			// Overridable default primary color for buttons and other blocks.
			'primaryColor' => get_theme_mod( 's_primary_color', '#2091e1' ),
		);
	}
}


if ( ! function_exists( 'bookwormgb_load_plugin_textdomain' ) ) {

	/**
	 * Translations.
	 */
	function bookwormgb_load_plugin_textdomain() {
		load_plugin_textdomain( 'bookwormgb' );
	}
	add_action( 'plugins_loaded', 'bookwormgb_load_plugin_textdomain' );
}

if ( ! function_exists( 'bookwormgb_add_required_block_styles' ) ) {

	/**
	 * Adds the required global styles for BookwormGB blocks.
	 *
	 * @since 1.3
	 */
	function bookwormgb_add_required_block_styles() {
		global $content_width;
		$full_width_block_inner_width = isset( $content_width ) ? $content_width : 900;

		$custom_css = ':root {
			--content-width: ' . esc_attr( $full_width_block_inner_width ) . 'px;
		}';
		wp_add_inline_style( 'bwgb-style-css', $custom_css );
	}
	add_action( 'enqueue_block_assets', 'bookwormgb_add_required_block_styles', 20 );
}

if ( ! function_exists( 'bookwormgb_allow_safe_style_css' ) ) {

	/**
	 * Fix block saving for Non-Super-Admins (no unfiltered_html capability).
	 * For Non-Super-Admins, some styles & HTML tags/attributes are removed upon saving,
	 * this allows BookwormGB styles from being saved.
	 *
	 * For every BookwormGB block, add the styles used here.
	 * Inlined styles are the only ones filtered out. Styles inside
	 * <style> tags are okay.
	 *
	 * @see The list of style rules allowed: https://core.trac.wordpress.org/browser/tags/5.2/src/wp-includes/kses.php#L2069
	 * @see https://github.com/gambitph/BookwormGB/issues/184
	 *
	 * @param array $styles Allowed CSS style rules.
	 *
	 * @return array Modified CSS style rules.
	 */
	function bookwormgb_allow_safe_style_css( $styles ) {
		return array_merge( $styles, array(
			'border-radius',
			'opacity',
			'justify-content',
			'display',
		) );
	}
	add_filter( 'safe_style_css', 'bookwormgb_allow_safe_style_css' );
}

if ( ! function_exists( 'bookwormgb_allow_wp_kses_allowed_html' ) ) {

	/**
	 * Fix block saving for Non-Super-Admins (no unfiltered_html capability).
	 * For Non-Super-Admins, some styles & HTML tags/attributes are removed upon saving,
	 * this allows BookwormGB HTML tags & attributes from being saved.
	 *
	 * For every BookwormGB block, add the HTML tags and attributes used here.
	 *
	 * @see The list of tags & attributes currently allowed: https://core.trac.wordpress.org/browser/tags/5.2/src/wp-includes/kses.php#L61
	 * @see https://github.com/gambitph/BookwormGB/issues/184
	 *
	 * @param array $tags Allowed HTML tags & attributes.
	 * @param string $context The context wherein the HTML is being filtered.
	 *
	 * @return array Modified HTML tags & attributes.
	 */
	function bookwormgb_allow_wp_kses_allowed_html( $tags, $context ) {
		$tags['style'] = array();

		// Used by Separators & Icons.
		$tags['svg'] = array(
			'viewbox' => true,
			'filter' => true,
			'enablebackground' => true,
			'xmlns' => true,
			'class' => true,
			'preserveaspectratio' => true,
			'aria-hidden' => true,
			'data-*' => true,
			'role' => true,
			'height' => true,
			'width' => true,
		);
		$tags['path'] = array(
			'class' => true,
			'fill' => true,
			'd' => true,
		);
		$tags['filter'] = array(
			'id' => true,
		);
		$tags['fegaussianblur'] = array(
			'in' => true,
			'stddeviation' => true,
		);
		$tags['fecomponenttransfer'] = array();
		$tags['fefunca'] = array(
			'type' => true,
			'slope' => true,
		);
		$tags['femerge'] = array();
		$tags['femergenode'] = array(
			'in' => true,
		);

		_bookwormgb_common_attributes( $tags, 'div' );
		_bookwormgb_common_attributes( $tags, 'h1' );
		_bookwormgb_common_attributes( $tags, 'h2' );
		_bookwormgb_common_attributes( $tags, 'h3' );
		_bookwormgb_common_attributes( $tags, 'h4' );
		_bookwormgb_common_attributes( $tags, 'h5' );
		_bookwormgb_common_attributes( $tags, 'h6' );
		_bookwormgb_common_attributes( $tags, 'svg' );

		return $tags;
	}

	function _bookwormgb_common_attributes( &$tags, $tag ) {
		$tags[ $tag ]['aria-hidden'] = true; // Used by Separators & Icons
		$tags[ $tag ]['aria-expanded'] = true; // Used by Expand block.
		$tags[ $tag ]['aria-level'] = true; // Used by Accordion block.
		$tags[ $tag ]['role'] = true; // Used by Accordion block.
		$tags[ $tag ]['tabindex'] = true; // Used by Accordion block.
	}
	add_filter( 'wp_kses_allowed_html', 'bookwormgb_allow_wp_kses_allowed_html', 10, 2 );
}

if ( ! function_exists( 'bookwormgb_rest_get_terms' ) ) {
	/**
	 * REST Callback. Gets all the terms registered for all post types (including category and tags).
	 *
	 * @see https://stackoverflow.com/questions/42462187/wordpress-rest-api-v2-how-to-list-taxonomy-terms
	 *
	 * @since 2.0
	 */
	function bookwormgb_rest_get_terms() {
		$args = array(
			'public' => true,
		);
		$taxonomies = get_taxonomies( $args, 'objects' );

		$return = array();

		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		foreach ( $post_types as $post_type => $data ) {
			// Don't include attachments.
			if ( $post_type === 'attachment' ) {
				continue;
			}
			$return[ $post_type ] = array(
				'label' => $data->label,
				'taxonomies' => array(),
			);
		}

		foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
			$post_type = $taxonomy->object_type[0];

			// Don't include post formats.
			if ( $post_type === 'post' && $taxonomy_slug === 'post_format' ) {
				continue;
			}

			$return[ $post_type ]['taxonomies'][ $taxonomy_slug ] = array(
				'label' => $taxonomy->label,
				'terms' => get_terms( $taxonomy->name ),
			);
		}

		return new WP_REST_Response( $return, 200 );
	}
}

if ( ! function_exists( 'bookwormgb_get_terms_endpoint' ) ) {
	/**
	 * Define our custom REST API endpoint for getting all the terms/taxonomies.
	 *
	 * @since 2.0
	 */
	function bookwormgb_get_terms_endpoint() {
		register_rest_route( 'wp/v2', '/bw_terms', array(
			'methods' => 'GET',
			'callback' => 'bookwormgb_rest_get_terms',
			'permission_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		) );
	}
	add_action( 'rest_api_init', 'bookwormgb_get_terms_endpoint' );
}

/**
 * Call a shortcode function by tag name.
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
function bookwormgb_do_shortcode( $tag, array $atts = array(), $content = null ) {
	global $shortcode_tags;
	if ( ! isset( $shortcode_tags[ $tag ] ) ) {
		return false;
	}

	return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}


/**
 * Products Shortcode Attributes.
 */

if ( ! function_exists( 'bookwormgb_get_products_shortcode_atts' ) ) {
	function bookwormgb_get_products_shortcode_atts( $attributes ) {

		extract( $attributes );

		$shortcode_atts = array(
			'limit' => 3,
			'columns' => 3
		);

		if( isset( $limit ) ) {
			$shortcode_atts['limit'] = $limit;
		}

		if( isset( $columns ) ) {
			$shortcode_atts['columns'] = $columns;
		}

		if( isset( $orderby ) ) {
			$shortcode_atts['orderby'] = $orderby;
		}

		if( isset( $order ) ) {
			$shortcode_atts['order'] = $order;
		}

		if( isset( $onSale ) && $onSale ) {
			$shortcode_atts['on_sale'] = $onSale;
		} elseif( isset( $bestSelling ) && $bestSelling ) {
			$shortcode_atts['best_selling'] = $bestSelling;
		} elseif( isset( $topRated ) && $topRated ) {
			$shortcode_atts['top_rated'] = $topRated;
		}

		if( ! empty( $products ) && is_array( $products ) ) {
			$shortcode_atts['ids'] = implode( ',', $products );
		}

		if( ! empty( $categories ) && is_array( $categories ) ) {
			$shortcode_atts['category'] = implode( ',', $categories );
			if( isset( $catOperator ) && $catOperator == 'all' ) {
				$shortcode_atts['cat_operator'] = 'AND';
			}
		}

        if( ! empty( $tags ) && is_array( $tags ) ) {
            $shortcode_atts['tag'] = implode( ',', $tags );
            if( isset( $tagOperator ) && $tagOperator == 'all' ) {
                $shortcode_atts['tag_operator'] = 'AND';
            }
        }

		if( ! empty( $attribute ) && is_array( $attribute ) ) {
			$terms = array();
			foreach ( $attribute as $term ) {
				$terms[] = $term['id'];
				$shortcode_atts['attribute'] = $term['attr_slug'];
			}

			$shortcode_atts['terms'] = implode( ',', $terms );
			if( isset( $attrOperator ) && $attrOperator == 'all' ) {
				$shortcode_atts['terms_operator'] = 'AND';
			}
		}

		if( isset( $visibility ) ) {
			$shortcode_atts['visibility'] = $visibility;
		}

		return $shortcode_atts;
	}
}

/**
 * Get attributes string from atts arary
 */
function bookwormgb_get_attributes( $atts ) {
	$attributes = '';
	foreach ( $atts as $attr => $value ) {
		if ( $value === "0" || ! empty( $value ) ) {
			$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
			$attributes .= ' ' . $attr . '="' . $value . '"';
		}
	}
	return $attributes;
}

if ( ! function_exists( 'bookwormgb_woocommerce_product_loop_reset' ) ) {
	function bookwormgb_woocommerce_product_loop_reset() {
		return '';
	}
}

function bookwormgb_nav_menu_taxonomy_args( $args, $taxonomy_name, $object_type ) {
    if ( 'nav_menu' === $taxonomy_name ) {
        $args['show_in_rest'] = true;
    }

    return $args;
}

add_filter( 'register_taxonomy_args', 'bookwormgb_nav_menu_taxonomy_args', 10, 3 );