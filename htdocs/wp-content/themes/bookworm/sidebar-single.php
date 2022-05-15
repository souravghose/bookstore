<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package bookworm
 */

if ( ! is_active_sidebar( 'sidebar-single' ) ) {
    return;
}
?>

<div id="secondary" class="sidebar widget-area order-1" role="complementary">
    <div id="widgetAccordion">
        <?php dynamic_sidebar( 'sidebar-single' ); ?>
    </div>
</div><!-- #secondary -->
