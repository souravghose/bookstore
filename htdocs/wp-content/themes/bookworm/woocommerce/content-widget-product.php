<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
    return;
}

?>
<li class="mb-5">
    <div class="media">
        <div class="media d-md-flex">

            <?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>

            <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="d-block">
                <?php echo wp_kses_post( $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'img-fluid', 'style' => 'max-width: 60px;' ) ) ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </a>


            <div class="media-body ml-3 pl-1">
                <h6 class="font-size-2 text-lh-md font-weight-normal crop-text-2"><a href="<?php echo esc_url( $product->get_permalink() ); ?>">
                    <?php echo wp_kses_post( $product->get_name() ); ?>
                </a></h6>
                <?php echo wp_kses_post( $product->get_price_html() ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>

            <?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>

        </div>
    </div>
</li>
