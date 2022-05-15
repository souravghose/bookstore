<?php
/**
 * Server-side rendering of the `bwgb/header` block.
 *
 * @package BookwormGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the `bwgb/header` block on server.
 *
 * @since 1.0
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the post content with latest posts added.
 */

if ( ! function_exists( 'bookworm_render_header_block' ) ) {
	function bookworm_render_header_block( $attributes ) {


		$design                            = isset( $attributes['design'] ) ? $attributes['design'] : 'v1';
		$topbarLeftMenuSlug                = isset( $attributes['topbarLeftMenuSlug'] ) ? $attributes['topbarLeftMenuSlug'] : '';
		$topbarRightMenuSlug               = isset( $attributes['topbarRightMenuSlug'] ) ? $attributes['topbarRightMenuSlug'] : '';
		$offcanvasMenuSlug                 = isset( $attributes['offcanvasMenuSlug'] ) ? $attributes['offcanvasMenuSlug'] : '';

		$headerPrimaryMenuSlug             = isset( $attributes['headerPrimaryMenuSlug'] ) ? $attributes['headerPrimaryMenuSlug'] : '';
		$headerSecondaryMenuSlug           = isset( $attributes['headerSecondaryMenuSlug'] ) ? $attributes['headerSecondaryMenuSlug'] : '';
		$offcanvasTogglerTitle             = isset( $attributes['offcanvasTogglerTitle'] ) ? $attributes['offcanvasTogglerTitle'] : '';

		$offcanvasHeaderTitle             = isset( $attributes['offcanvasHeaderTitle'] ) ? $attributes['offcanvasHeaderTitle'] : '';
		$logoImageID = isset( $attributes['logoImageID'] ) ? $attributes['logoImageID'] : '';

		$mailSupportPreText              = isset( $attributes['mailSupportPreText'] ) ? $attributes['mailSupportPreText'] : '';
		$mailSupportText                 = isset( $attributes['mailSupportText'] ) ? $attributes['mailSupportText'] : '';
		$mailSupportLink                 = isset( $attributes['mailSupportLink'] ) ? $attributes['mailSupportLink'] : '';
		$mailSupportIcon                 = isset( $attributes['mailSupportIcon'] ) ? $attributes['mailSupportIcon'] : '';
		$phoneSupportPreText             = isset( $attributes['phoneSupportPreText'] ) ? $attributes['phoneSupportPreText'] : '';
		$phoneSupportText                = isset( $attributes['phoneSupportText'] ) ? $attributes['phoneSupportText'] : '';
		$phoneSupportLink                = isset( $attributes['phoneSupportLink'] ) ? $attributes['phoneSupportLink'] : '';
		$phoneSupportIcon                = isset( $attributes['phoneSupportIcon'] ) ? $attributes['phoneSupportIcon'] : '';
		$departmentMenuTogglerTitle                = isset( $attributes['departmentMenuTogglerTitle'] ) ? $attributes['departmentMenuTogglerTitle'] : '';

		$headerDepartmentMenuSlug                = isset( $attributes['headerDepartmentMenuSlug'] ) ? $attributes['headerDepartmentMenuSlug'] : '';



		add_filter( 'bookworm_header_version', function() use ($design) {
			return $design;
		} );

		add_filter( 'bookworm_topbar_left_menu', function() use ($topbarLeftMenuSlug) {
			return $topbarLeftMenuSlug;
		} );

		add_filter( 'bookworm_topbar_right_menu', function() use ($topbarRightMenuSlug) {
			return $topbarRightMenuSlug;
		} );

		add_filter( 'bookworm_offcanvas_menu', function() use ($offcanvasMenuSlug) {
			return $offcanvasMenuSlug;
		} );

		add_filter( 'bookworm_primary_menu', function() use ($headerPrimaryMenuSlug) {
			return $headerPrimaryMenuSlug;
		} );

		add_filter( 'bookworm_secondary_menu', function() use ($headerSecondaryMenuSlug) {
			return $headerSecondaryMenuSlug;
		} );

		add_filter( 'bookworm_offcanvas_toggler_title', function() use ($offcanvasTogglerTitle) {
			return $offcanvasTogglerTitle;
		} );

		add_filter( 'bookworm_offcanvas_header_title', function() use ($offcanvasHeaderTitle) {
			return $offcanvasHeaderTitle;
		} );

		add_filter( 'bookworm_site_header_mail_support_pre', function() use ($mailSupportPreText) {
			return $mailSupportPreText;
		} );

		add_filter( 'bookworm_site_header_mail_support_text', function() use ($mailSupportText) {
			return $mailSupportText;
		} );

		add_filter( 'bookworm_site_header_mail_support_link', function() use ($mailSupportLink) {
			return $mailSupportLink;
		} );

		add_filter( 'bookworm_site_header_mail_support_icon', function() use ($mailSupportIcon) {
			return $mailSupportIcon;
		} );


		add_filter( 'bookworm_site_header_phone_support_pre', function() use ($phoneSupportPreText) {
			return $phoneSupportPreText;
		} );

		add_filter( 'bookworm_site_header_phone_support_text', function() use ($phoneSupportText) {
			return $phoneSupportText;
		} );

		add_filter( 'bookworm_site_header_phone_support_link', function() use ($phoneSupportLink) {
			return $phoneSupportLink;
		} );

		add_filter( 'bookworm_site_header_phone_support_icon', function() use ($phoneSupportIcon) {
			return $phoneSupportIcon;
		} );

		add_filter( 'bookworm_department_menu_toggler_title', function() use ($departmentMenuTogglerTitle) {
			return $departmentMenuTogglerTitle;
		} );

		add_filter( 'bookworm_departmenu_menu', function() use ($headerDepartmentMenuSlug) {
			return $headerDepartmentMenuSlug;
		} );

		add_filter( 'bookworm_custom_logo', function() use ($logoImageID) {
			return $logoImageID;
		} );



		if ( $attributes['enableTopbar'] == false ) {
			add_filter( 'bookworm_enable_topbar', '__return_false' );

		} else {
			add_filter( 'bookworm_enable_topbar', '__return_true' );
		}

		if ( $attributes['enableOffcanvas'] == false ) {
			add_filter( 'bookworm_enable_offcanvas_nav', '__return_false' );

		} else {
			add_filter( 'bookworm_enable_offcanvas_nav', '__return_true' );
		}

		if ( $attributes['enableNavbar'] == false ) {
			add_filter( 'bookworm_enable_navbar', '__return_false' );

		} else {
			add_filter( 'bookworm_enable_navbar', '__return_true' );
		}


		if ( $attributes['enableSiteSearch'] == false ) {
			add_filter( 'bookworm_enable_site_search', '__return_false' );

		} else {
			add_filter( 'bookworm_enable_site_search', '__return_true' );
		}

		if ( $attributes['enableSecondaryMenu'] == false ) {
			add_filter( 'bookworm_enable_secondary_menu', '__return_false' );

		} else {
			add_filter( 'bookworm_enable_secondary_menu', '__return_true' );
		}

		if ( $attributes['displayMailSupport'] == false ) {
			add_filter( 'bookworm_site_header_support_lists_display_mail_support', '__return_false' );

		} else {
			add_filter( 'bookworm_site_header_support_lists_display_mail_support', '__return_true' );
		}

		if ( $attributes['displayPhoneSupport'] == false ) {
			add_filter( 'bookworm_site_header_support_lists_display_tel_support', '__return_false' );

		} else {
			add_filter( 'bookworm_site_header_support_lists_display_tel_support', '__return_true' );
		}

		if ( $attributes['enableDepartmentMenu'] == false ) {
			add_filter( 'bookworm_enable_department_menu', '__return_false' );

		} else {
			add_filter( 'bookworm_enable_department_menu', '__return_true' );
		}

		if ( $attributes['enableSiteSearch1'] == false ) {
			add_filter( 'bookworm_enable_site_header_search_icon', '__return_false' );

		} else {
			add_filter( 'bookworm_enable_site_header_search_icon', '__return_true' );
		}

		if ( $attributes['enableCart'] == false ) {
			add_filter( 'bookworm_enable_mini_cart', '__return_false' );

		} else {
			add_filter( 'bookworm_enable_mini_cart', '__return_true' );
		}

		if ( $attributes['enableAccount'] == false ) {
			add_filter( 'bookworm_enable_account', '__return_false' );

		} else {
			add_filter( 'bookworm_enable_account', '__return_true' );
		}

		if ( $attributes['enableSVGLogo'] == true ) {
			add_filter( 'bookworm_site_logo_svg', '__return_true' );
		} else {
			add_filter( 'bookworm_site_logo_svg', '__return_false' );
		}

		if ( $attributes['enableWishlist'] == false ) {
			add_filter( 'bookworm_enable_wishlist', '__return_false' );

		} else {
			add_filter( 'bookworm_enable_wishlist', '__return_true' );
		}

		if ( $attributes['enableCompare'] == false ) {
			add_filter( 'bookworm_enable_compare', '__return_false' );

		} else {
			add_filter( 'bookworm_enable_compare', '__return_true' );
		}

		if ( $attributes['enableStoreLocator'] == false ) {
			add_filter( 'bookworm_enable_store_locator_link', '__return_false' );

		} else {
			add_filter( 'bookworm_enable_store_locator_link', '__return_true' );
		}




		$header = function_exists( 'bookworm_header_version' ) ? bookworm_header_version() : $design;

		ob_start();

		echo get_template_part( 'templates/headers/header', $header );

		return ob_get_clean();

	}
}

if ( ! function_exists( 'bookwormgb_register_header_block' ) ) {
	/**
	 * Registers the `bwgb/header` block on server.
	 */
	function bookwormgb_register_header_block() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		register_block_type(
			'bwgb/header',
			array(
				'attributes' => array(
					'className' => array(
						'type' => 'string',
					),

					'design' => array(
						'type' => 'string',
						'default' => 'v1'
					),

					'uniqueClass' => array(
						'type' => 'string',
					),
					
					'logoImageID' => array(
                        'type' => 'number',
                        'default' => 0
                    ),
                    'logoImageUrl' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    
					
				    'enableTopbar' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableSVGLogo' => array(
						'type' => 'boolean',
						'default' => false
					),

					'enableOffcanvas' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableNavbar' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableDepartmentMenu' => array(
						'type' => 'boolean',
						'default' => true
					),
					'displayMailSupport' => array(
						'type' => 'boolean',
						'default' => true
					),

					'displayPhoneSupport' => array(
						'type' => 'boolean',
						'default' => true
					),

					'offcanvasTogglerTitle'=> array (
				        'type' => 'string',
				        'default' => esc_html__('Browse categories', BWGB_I18N )
				    ),

				    'offcanvasHeaderTitle'=> array (
				        'type' => 'string',
				        'default' => esc_html__('SHOP BY CATEGORY', BWGB_I18N )
				    ),

				    'departmentMenuTogglerTitle'=> array (
				        'type' => 'string',
				        'default' => esc_html__('Browse categories', BWGB_I18N )
				    ),

				    'mailSupportText'=> array (
				        'type' => 'string',
				        'default' => esc_html__('Any questions', BWGB_I18N )
				    ),

				    'mailSupportPreText'=> array (
				        'type' => 'string',
				        'default' => esc_html__('info@bookworm.com', BWGB_I18N )
				    ),

				    'mailSupportLink'=> array (
				        'type' => 'string',
				        'default' => esc_html__('mailto:info@bookworm.com', BWGB_I18N )
				    ),

				    'mailSupportIcon'=> array (
				        'type' => 'string',
				        'default' => esc_html__('flaticon-question', BWGB_I18N )
				    ),

				    'phoneSupportPreText'=> array (
				        'type' => 'string',
				        'default' => esc_html__('+1 246-345-0695', BWGB_I18N )
				    ),

				    'phoneSupportText'=> array (
				        'type' => 'string',
				        'default' => esc_html__('Call toll-free', BWGB_I18N )
				    ),

				    'phoneSupportLink'=> array (
				        'type' => 'string',
				        'default' => esc_html__('tel:+1246-345-0695', BWGB_I18N )
				    ),

				    'phoneSupportIcon'=> array (
				        'type' => 'string',
				        'default' => esc_html__('flaticon-phone', BWGB_I18N )
				    ),

				    'topbarLeftMenuSlug'=> array (
				        'type' => 'string',
				    ),

				    'topbarRightMenuSlug'=> array (
				        'type' => 'string',
				    ),

				    'offcanvasMenuSlug'=> array (
				        'type' => 'string',
				    ),

				    'headerPrimaryMenuSlug'=> array (
				        'type' => 'string',
				    ),
				    'enableSiteSearch' => array(
						'type' => 'boolean',
						'default' => true
					),
					'headerSecondaryMenuSlug'=> array (
				        'type' => 'string',
				    ),

				    'enableSecondaryMenu' => array(
						'type' => 'boolean',
						'default' => true
					),
					'headerDepartmentMenuSlug'=> array (
				        'type' => 'string',
				    ),

				    'enableSiteSearch1' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableCart' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableAccount' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableWishlist' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableCompare' => array(
						'type' => 'boolean',
						'default' => true
					),

					'enableStoreLocator' => array(
						'type' => 'boolean',
						'default' => true
					),
                
				),
				'render_callback' => 'bookworm_render_header_block',
			)
		);
	}
	add_action( 'init', 'bookwormgb_register_header_block' );
}