<?php
/**
 * Footer v2 Template
 *
 * @package bookworm
 */
?>
<footer class="site-footer_v2 site-footer_v2-alt">
    <div class="space-top-3 bg-gray-850">
        <?php
        /**
         * Functions hooked in to bookworm_footer action
         *
         * @hooked bookworm_footer_widgets - 10
         * @hooked bookworm_site_info      - 20
         */
         do_action( 'bookworm_footer_v2', 'v2' );
         ?>
    </div>
</footer>
