<?php
/**
 * Server-side rendering of the `bwgb/footer` block.
 *
 * @package BookwormGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the `bwgb/footer` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */

if ( ! function_exists( 'bookworm_render_footer_block' ) ) {
	function bookworm_render_footer_block( $attributes ) {

		$design                = isset( $attributes['design'] ) ? $attributes['design'] : 'v1';
		$additionalClass       = isset( $attributes['additionalClass'] ) ? $attributes['additionalClass'] : '';
		$shop_address_1        = isset( $attributes['shop_address_1'] ) ? $attributes['shop_address_1'] : '';
		$shop_address_2        = isset( $attributes['shop_address_2'] ) ? $attributes['shop_address_2'] : '';

		$footerContactMenuSlug = isset( $attributes['footerContactMenuSlug'] ) ? $attributes['footerContactMenuSlug'] : '';

		$footerWidgetColumn1 = isset( $attributes['footerWidgetColumn1'] ) ? $attributes['footerWidgetColumn1'] : 'footer-1';
		$footerWidgetColumn2 = isset( $attributes['footerWidgetColumn2'] ) ? $attributes['footerWidgetColumn2'] : 'footer-2';
		$footerWidgetColumn3 = isset( $attributes['footerWidgetColumn3'] ) ? $attributes['footerWidgetColumn3'] : 'footer-3';
		$footerWidgetColumn4 = isset( $attributes['footerWidgetColumn4'] ) ? $attributes['footerWidgetColumn4'] : 'footer-4';
		$footerWidgetColumn5 = isset( $attributes['footerWidgetColumn5'] ) ? $attributes['footerWidgetColumn5'] : 'footer-5';

		$copyrightText = isset( $attributes['copyrightText'] ) ? $attributes['copyrightText'] : '';
		$paymentImageURL = isset( $attributes['paymentImageURL'] ) ? $attributes['paymentImageURL'] : '';
		$logoImageID = isset( $attributes['logoImageID'] ) ? $attributes['logoImageID'] : '';

		$newsletterTitle = isset( $attributes['newsletterTitle'] ) ? $attributes['newsletterTitle'] : '';
		$newsletterDesc = isset( $attributes['newsletterDesc'] ) ? $attributes['newsletterDesc'] : '';
		$newsletterShortcode = isset( $attributes['newsletterShortcode'] ) ? do_shortcode( $attributes['newsletterShortcode']) : '';

		add_filter( 'bookworm_footer_version', function() use ($design) {
			return $design;
		} );

		if ( $attributes['enableFooterSocialMenu'] == false ) {
			add_filter( 'bookworm_enable_footer_social_icons', '__return_false' );
		}  else {
			add_filter( 'bookworm_enable_footer_social_icons', '__return_true' );
		} 

		if ( $attributes['enableFooterContactMenu'] == false ) {
			add_filter( 'bookworm_enable_contact_links', '__return_false' );
		}  else {
			add_filter( 'bookworm_enable_contact_links', '__return_true' );
		} 

		if ( $attributes['enableFooterWidgets'] == false ) {
			add_filter( 'bookworm_enable_footer_widgets', '__return_false' );
		} else {
			add_filter( 'bookworm_enable_footer_widgets', '__return_true' );
		}

		if ( $attributes['enableFooterPayment'] == false ) {
			add_filter( 'bookworm_enable_footer_payment_method', '__return_false' );
		} else {
			add_filter( 'bookworm_enable_footer_payment_method', '__return_true' );
		}  

		if ( $attributes['enableFooterCopyright'] == false ) {
			add_filter( 'bookworm_is_copyright', '__return_false' );
		} else {
			add_filter( 'bookworm_is_copyright', '__return_true' );
		}

		if ( $attributes['enableLanguageSwitcher'] == false ) {
			add_filter( 'bookworm_enable_language_dropdown', '__return_false' );
		} else {
			add_filter( 'bookworm_enable_language_dropdown', '__return_true' );
		}

		if ( $attributes['enableCurrencySwitcher'] == false ) {
			add_filter( 'bookworm_enable_currency_dropdown', '__return_false' );
		} else {
			add_filter( 'bookworm_enable_currency_dropdown', '__return_true' );
		}

		if ( $attributes['enableSVGLogo'] == true ) {
			add_filter( 'bookworm_site_logo_svg', '__return_true' );
		} else {
			add_filter( 'bookworm_site_logo_svg', '__return_false' );
		}

		if ( $attributes['enableNewsletter'] == false ) {
			add_filter( 'bookworm_footer_newsletter', '__return_false' );
		} else {
			add_filter( 'bookworm_footer_newsletter', '__return_true' );
		}
		
		add_filter( 'bookworm_site_address_1', function() use ($shop_address_1) {
			return $shop_address_1;
		} );

		add_filter( 'bookworm_site_address_2', function() use ($shop_address_2) {
			return $shop_address_2;
		} );
		
		add_filter( 'bookworm_contact_menu', function() use ($footerContactMenuSlug) {
			return $footerContactMenuSlug;
		} );

		add_filter( 'bookworm_copyright', function() use ($copyrightText) {
			return $copyrightText;
		} );

		add_filter( 'bookworm_payment_image_url', function() use ($paymentImageURL) {
			return $paymentImageURL;
		} );

		add_filter( 'bookworm_footer_custom_logo', function() use ($logoImageID) {
			return $logoImageID;
		} );


		add_filter( 'bookworm_footer_newsletter_title', function() use ($newsletterTitle) {
			return $newsletterTitle;
		} );

		add_filter( 'bookworm_footer_newsletter_desc', function() use ($newsletterDesc) {
			return $newsletterDesc;
		} );

		add_filter( 'bookworm_footer_newsletter_shortcode', function() use ($newsletterShortcode) {
			return $newsletterShortcode;
		} );

		if( in_array( $design, array( "v1", "v3", "v5", "v11" ) ) ) {
			add_filter( 'bookworm_footer_widget-1', function() use ($footerWidgetColumn1) {
				return $footerWidgetColumn1;
			} );

			add_filter( 'bookworm_footer_widget-2', function() use ($footerWidgetColumn2) {
				return $footerWidgetColumn2;
			} );

			add_filter( 'bookworm_footer_widget-3', function() use ($footerWidgetColumn3) {
				return $footerWidgetColumn3;
			} );

			add_filter( 'bookworm_footer_widget-4', function() use ($footerWidgetColumn4) {
				return $footerWidgetColumn4;
			} );
		} elseif( in_array( $design, array( "v2" ) ) ) {
			add_filter( 'bookworm_footer_widget_2-1', function() use ($footerWidgetColumn1) {
				return $footerWidgetColumn1;
			} );

			add_filter( 'bookworm_footer_widget_2-2', function() use ($footerWidgetColumn2) {
				return $footerWidgetColumn2;
			} );

			add_filter( 'bookworm_footer_widget_2-3', function() use ($footerWidgetColumn3) {
				return $footerWidgetColumn3;
			} );

			add_filter( 'bookworm_footer_widget_2-4', function() use ($footerWidgetColumn4) {
				return $footerWidgetColumn4;
			} );
			add_filter( 'bookworm_footer_widget_2-5', function() use ($footerWidgetColumn5) {
				return $footerWidgetColumn5;
			} );
		} elseif( in_array( $design, array( "v4" ) ) ) {
			add_filter( 'bookworm_footer_widget_4-1', function() use ($footerWidgetColumn1) {
				return $footerWidgetColumn1;
			} );

			add_filter( 'bookworm_footer_widget_4-2', function() use ($footerWidgetColumn2) {
				return $footerWidgetColumn2;
			} );

			add_filter( 'bookworm_footer_widget_4-3', function() use ($footerWidgetColumn3) {
				return $footerWidgetColumn3;
			} );

			add_filter( 'bookworm_footer_widget_4-4', function() use ($footerWidgetColumn4) {
				return $footerWidgetColumn4;
			} );
		} elseif( in_array( $design, array( "v6" ) ) ) {
			add_filter( 'bookworm_footer_widget_6-1', function() use ($footerWidgetColumn1) {
				return $footerWidgetColumn1;
			} );

			add_filter( 'bookworm_footer_widget_6-2', function() use ($footerWidgetColumn2) {
				return $footerWidgetColumn2;
			} );

			add_filter( 'bookworm_footer_widget_6-3', function() use ($footerWidgetColumn3) {
				return $footerWidgetColumn3;
			} );

			add_filter( 'bookworm_footer_widget_6-4', function() use ($footerWidgetColumn4) {
				return $footerWidgetColumn4;
			} );
		} elseif( in_array( $design, array( "v7" ) ) ) {
			add_filter( 'bookworm_footer_widget_7-1', function() use ($footerWidgetColumn1) {
				return $footerWidgetColumn1;
			} );

			add_filter( 'bookworm_footer_widget_7-2', function() use ($footerWidgetColumn2) {
				return $footerWidgetColumn2;
			} );

			add_filter( 'bookworm_footer_widget_7-3', function() use ($footerWidgetColumn3) {
				return $footerWidgetColumn3;
			} );

			add_filter( 'bookworm_footer_widget_7-4', function() use ($footerWidgetColumn4) {
				return $footerWidgetColumn4;
			} );

			add_filter( 'bookworm_footer_widget_7-5', function() use ($footerWidgetColumn5) {
				return $footerWidgetColumn5;
			} );
		} elseif( in_array( $design, array( "v8" ) ) ) {
			add_filter( 'bookworm_footer_widget_8-1', function() use ($footerWidgetColumn1) {
				return $footerWidgetColumn1;
			} );

			add_filter( 'bookworm_footer_widget_8-2', function() use ($footerWidgetColumn2) {
				return $footerWidgetColumn2;
			} );

			add_filter( 'bookworm_footer_widget_8-3', function() use ($footerWidgetColumn3) {
				return $footerWidgetColumn3;
			} );

			add_filter( 'bookworm_footer_widget_8-4', function() use ($footerWidgetColumn4) {
				return $footerWidgetColumn4;
			} );
		} elseif( in_array( $design, array( "v9" ) ) ) {
			add_filter( 'bookworm_footer_widget_9-1', function() use ($footerWidgetColumn1) {
				return $footerWidgetColumn1;
			} );

			add_filter( 'bookworm_footer_widget_9-2', function() use ($footerWidgetColumn2) {
				return $footerWidgetColumn2;
			} );

			add_filter( 'bookworm_footer_widget_9-3', function() use ($footerWidgetColumn3) {
				return $footerWidgetColumn3;
			} );

			add_filter( 'bookworm_footer_widget_9-4', function() use ($footerWidgetColumn4) {
				return $footerWidgetColumn4;
			} );
		} elseif( in_array( $design, array( "v10" ) ) ) {
			add_filter( 'bookworm_footer_widget_10-1', function() use ($footerWidgetColumn1) {
				return $footerWidgetColumn1;
			} );

			add_filter( 'bookworm_footer_widget_10-2', function() use ($footerWidgetColumn2) {
				return $footerWidgetColumn2;
			} );

			add_filter( 'bookworm_footer_widget_10-3', function() use ($footerWidgetColumn3) {
				return $footerWidgetColumn3;
			} );

			add_filter( 'bookworm_footer_widget_10-4', function() use ($footerWidgetColumn4) {
				return $footerWidgetColumn4;
			} );
		} elseif( in_array( $design, array( "v12" ) ) ) {
			add_filter( 'bookworm_footer_widget_12-1', function() use ($footerWidgetColumn1) {
				return $footerWidgetColumn1;
			} );

			add_filter( 'bookworm_footer_widget_12-2', function() use ($footerWidgetColumn2) {
				return $footerWidgetColumn2;
			} );

			add_filter( 'bookworm_footer_widget_12-3', function() use ($footerWidgetColumn3) {
				return $footerWidgetColumn3;
			} );

			add_filter( 'bookworm_footer_widget_12-4', function() use ($footerWidgetColumn4) {
				return $footerWidgetColumn4;
			} );

			add_filter( 'bookworm_footer_widget_12-5', function() use ($footerWidgetColumn5) {
				return $footerWidgetColumn5;
			} );
		} elseif( in_array( $design, array( "v13" ) ) ) {
			add_filter( 'bookworm_footer_widget_13-1', function() use ($footerWidgetColumn1) {
				return $footerWidgetColumn1;
			} );

			add_filter( 'bookworm_footer_widget_13-2', function() use ($footerWidgetColumn2) {
				return $footerWidgetColumn2;
			} );

			add_filter( 'bookworm_footer_widget_13-3', function() use ($footerWidgetColumn3) {
				return $footerWidgetColumn3;
			} );

			add_filter( 'bookworm_footer_widget_13-4', function() use ($footerWidgetColumn4) {
				return $footerWidgetColumn4;
			} );
		}

		$footer = function_exists( 'bookworm_footer_version' ) ? bookworm_footer_version() : $design;
	
		ob_start();

		echo get_template_part( 'templates/footers/footer', $footer );

		return ob_get_clean();
	}
}

if ( ! function_exists( 'bookwormgb_register_footer_block' ) ) {
	/**
	 * Registers the `bwgb/footer` block on server.
	 */
	function bookwormgb_register_footer_block() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		register_block_type(
			'bwgb/footer',
			array(
				'attributes' => array(
					'className' => array(
						'type' => 'string',
					),

					'design' => array(
						'type' => 'string',
						'default' => 'v1'
					),

					'enableSVGLogo' => array(
						'type' => 'boolean',
						'default' => false
					),

					'enableFooterWidgets' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableFooterSocialMenu' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableFooterContactMenu' => array(
						'type' => 'boolean',
						'default' => true
					),

					'customLogoWidth' => array(
						'type' => 'number',
					),

					'enableFooterPayment' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableFooterCopyright' => array(
						'type' => 'boolean',
						'default' => true
					),

					'copyrightText' => array(
						'type' => 'string',
						'default' => esc_html__( '&copy;2020 Book Worm. All rights reserved', BWGB_I18N )
					),

					'footerWidgetColumn1'=> array(
						'type' =>'string',
						'default' => 'footer-1',
					),

					'footerWidgetColumn2'=> array(
						'type' =>'string',
						'default' => 'footer-2',
					),

					'footerWidgetColumn3'=> array(
						'type' =>'string',
						'default' => 'footer-3',
					),

					'footerWidgetColumn4'=> array(
						'type' =>'string',
						'default' => 'footer-4',
					),

					'footerWidgetColumn5'=> array(
						'type' =>'string',
						'default' => 'footer-5',
					),

					'uniqueClass' => array(
						'type' => 'string',
					),

					'logoImageID' => array(
						'type' => 'number',
					),

					'logoImageUrl' => array(
						'type' => 'string',
						'default' => ''
					),

					'additionalClass' => array(
						'type' => 'string',
					),

					'shop_address_1'=> array(
						'type' =>'string',
						'default' => esc_html__( '1418 River Drive, Suite 35 Cottonhall, CA 9622', BWGB_I18N )
					),

					'shop_address_2'=> array(
						'type' =>'string',
						'default' => esc_html__( 'United States', BWGB_I18N )
					),

					'enableLanguageSwitcher'=> array (
						'type' => 'boolean',
						'default' => true
					),

					'enableCurrencySwitcher'=> array (
						'type' => 'boolean',
						'default' => true
					),

					'paymentImageURL' => array(
						'type' => 'string',
						'default' => ''
					),

					'footerContactMenuSlug' => array(
						'type' => 'string',
					),

					'enableNewsletter'=> array (
						'type' => 'boolean',
						'default' => true
					),

					'newsletterTitle'=> array(
						'type' =>'string',
						'default' => esc_html__( 'Join Our Newsletter', BWGB_I18N )
					),

					'newsletterDesc'=> array(
						'type' =>'string',
						'default' => esc_html__( 'Signup to be the first to hear about exclusive deals, special offers and upcoming collections', BWGB_I18N )
					),

					'newsletterShortcode'=> array(
						'type' =>'string',
					),
				),
				'render_callback' => 'bookworm_render_footer_block',
			)
		);
	}
	add_action( 'init', 'bookwormgb_register_footer_block' );
}