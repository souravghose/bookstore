<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs       = apply_filters( 'woocommerce_product_tabs', array() );
$version            = bookworm_get_single_product_version();

if ( ! empty( $product_tabs ) ) : 

    if ( $version === 'v2') {
        $nav_link_padding_classes = 'py-4';
        $nav_tabs_classes = 'border-bottom justify-content-md-center flex-nowrap flex-md-wrap overflow-auto overflow-md-visble
';
        $nav_tab_classes ='font-size-base';
    } elseif ( $version === 'v3') {
        $nav_link_padding_classes = 'py-2';
        $nav_tabs_classes = 'bg-punch-light pb-6 justify-content-md-center flex-nowrap flex-md-wrap overflow-auto overflow-md-visble
';
        $nav_tab_classes ='font-size-base';
    } elseif ( $version === 'v5') {
        $nav_link_padding_classes = 'py-4d75';
        $nav_tabs_classes = 'border-bottom justify-content-md-center flex-nowrap flex-md-wrap overflow-auto overflow-md-visble';
        $nav_tab_classes ='font-size-base';
    } elseif ( $version === 'v6') {
        $nav_link_padding_classes = 'py-6';
        $nav_tabs_classes = 'flex-nowrap ml-4 flex-md-wrap overflow-auto overflow-md-visble';
        $nav_tab_classes ='font-size-base';
    } elseif ( $version === 'v7') {
        $nav_link_padding_classes = 'py-4 mx-lg-2 mx-xl-3';
        $nav_tabs_classes = 'border-bottom justify-content-md-center flex-nowrap flex-md-wrap overflow-auto overflow-md-visble
';
        $nav_tab_classes ='font-size-base p-0';
    } else {
        $nav_link_padding_classes = 'py-4';
        $nav_tabs_classes = 'container justify-content-md-center flex-nowrap flex-md-wrap overflow-auto overflow-md-visble';
        $nav_tab_classes ='font-size-2';
    }
?>
    <?php do_action( 'bookworm_before_wc_tabs_wrapper' ); ?>
    
    <div class="woocommerce-tabs wc-tabs-wrapper mx-lg-auto">
        
        <?php do_action( 'bookworm_wc_product_before_tabs' ); ?>
        
        <ul class="tabs wc-tabs nav <?php echo esc_attr( apply_filters( 'bookworm-nav-tabs', $nav_tabs_classes ));?>" role="tablist">
            <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
                <li class="<?php echo esc_attr( $key ); ?>_tab flex-shrink-0 flex-md-shrink-1 nav-item" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
                    <a href="#tab-<?php echo esc_attr( $key ); ?>" class="nav-link font-weight-medium <?php echo esc_attr( apply_filters( 'bookworm-nav-links', $nav_link_padding_classes ));?>">
                        <?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php do_action( 'bookworm_before_wc_tabs_panel' ); ?>
        <div class="tab-content">
            <?php foreach ( $product_tabs as $key => $product_tab ) : ?>
            <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab container <?php echo esc_attr( apply_filters( 'bookworm-nav-tab', $nav_tab_classes ));?>" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
                
                <?php
                if ( isset( $product_tab['callback'] ) ) {
                    do_action( 'bookworm_before_wc_tabs_panel_content' );
                    call_user_func( $product_tab['callback'], $key, $product_tab );
                    do_action( 'bookworm_after_wc_tabs_panel_content' );
                }
                ?>
            </div>
            <?php endforeach; ?>
        </div>

        <?php do_action( 'woocommerce_product_after_tabs' ); ?>
    </div>

    <?php do_action( 'bookworm_after_wc_tabs_wrapper' ); ?>

<?php endif; ?>