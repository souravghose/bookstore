<?php
/**
 * Footer v3 Template
 *
 * @package bookworm
 */
?>
<footer class="site-footer_v3">
    <div class="bg-gray-200">
    	<div class="space-top-3">
	        <?php
	        /**
	         * Functions hooked in to bookworm_footer action
	         *
	         * @hooked bookworm_footer_widgets - 10
	         * @hooked bookworm_site_info      - 20
	         */
	         do_action( 'bookworm_footer_v3', 'v3' );
	         ?>
	     </div>
    </div>
</footer>

