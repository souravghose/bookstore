<?php
/**
 * Footer v10 Template
 *
 * @package bookworm
 */
?>
<footer class="site-footer_v10">
	<div class="bg-gray-200 border-top space-top-1 space-top-lg-3">
	    <?php
	    /**
	     * Functions hooked in to bookworm_footer action
	     *
	     * @hooked bookworm_footer_widgets - 10
	     * @hooked bookworm_site_info      - 20
	     */
	     do_action( 'bookworm_footer_v10', 'v10' );
	     ?>
	 </div>
</footer>