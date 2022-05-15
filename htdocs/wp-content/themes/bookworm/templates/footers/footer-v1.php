<?php
/**
 * Footer v1 Template
 *
 * @package bookworm
 */
?>
<footer class="site-footer site-footer--v1">
    <div class="border-top">

        <?php
        /**
         * Functions hooked in to bookworm_footer action
         *
         * @hooked bookworm_footer_widgets - 10
         * @hooked bookworm_site_info      - 20
         */
         do_action( 'bookworm_footer_v1', 'v1' );
         ?>

    </div>
</footer>
