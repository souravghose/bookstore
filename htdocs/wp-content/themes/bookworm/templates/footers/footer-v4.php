<?php
/**
 * Footer v4 Template
 *
 * @package bookworm
 */
?>
<footer class="site-footer_v4 site-footer_v4-alt">
    <div class="space-top-3 bg-dark-1 border-top border-gray-710">
        <?php
        /**
         * Functions hooked in to bookworm_footer action
         *
         * @hooked bookworm_footer_widgets - 10
         * @hooked bookworm_site_info      - 20
         */
         do_action( 'bookworm_footer_v4', 'v4' );
         ?>
    </div>
</footer>