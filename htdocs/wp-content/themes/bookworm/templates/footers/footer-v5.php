<?php
/**
 * Footer v5 Template
 *
 * @package bookworm
 */
?>
<footer class="site-footer_v5 site-footer_v5-alt">
    <div class="space-top-3">
        <?php
        /**
         * Functions hooked in to bookworm_footer action
         *
         * @hooked bookworm_footer_widgets - 10
         * @hooked bookworm_site_info      - 20
         */
         do_action( 'bookworm_footer_v5', 'v5' );
         ?>
    </div>
</footer>