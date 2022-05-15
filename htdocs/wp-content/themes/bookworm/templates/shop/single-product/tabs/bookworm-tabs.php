<?php
/**
 * Bookworm Single Product tabs
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>
	<div class="js-scroll-nav1 mb-10">
	
		<?php $header = '<div class="border-top border-bottom"><ul class="bk-tabs container d-flex list-unstyled mb-0 justify-content-md-center flex-nowrap flex-md-wrap overflow-auto overflow-md-visble">';
		foreach ( $tabs as $key => $tab ) : 
			$header .= '<li class="flex-shrink-0 flex-md-shrink-1 ' . esc_attr( $key ) . '_tab">
				<a href="#tab-' . esc_attr( $key ) . '" class="d-block py-4 font-weight-medium">' . apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ) . '</a></li>';
		endforeach;

		
		$header .= '</ul></div>'; ?>

		<div class="bookworm-tabs woocommerce-tabs wc-tabs-wrapper  2 mx-lg-auto">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<div id="tab-<?php echo esc_attr( $key ); ?>" class="">
					<?php  $search 	= 'class="flex-shrink-0 flex-md-shrink-1 ' . esc_attr( $key ) . '_tab"';
					   	   $replace 	= 'class="flex-shrink-0 flex-md-shrink-1 ' . esc_attr( $key ) . '_tab active"';
					   	   $n_header 	= str_replace( $search, $replace, $header );
					       echo wp_kses_post( $n_header ); 
					?>
					
					<div class="tab-content font-size-2 container">
						<?php do_action( 'bookworm_before_wc_tabs_panel_content' ); ?>
							<div class="bookworm-Tabs-panel--<?php echo esc_attr( $key ); ?>">
								<?php call_user_func( $tab['callback'], $key, $tab ); ?>
							</div>
						<?php do_action( 'bookworm_after_wc_tabs_panel_content' ); ?>
					</div>
					
				</div>
			<?php endforeach; ?>
		</div>
	</div>

<?php endif; ?>