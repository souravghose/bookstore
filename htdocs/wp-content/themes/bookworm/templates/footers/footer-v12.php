<?php
/**
 * Footer v12 Template
 *
 * @package bookworm
 */
?>
<footer class="site-footer_v12">
	<div class="space-top-2 border-top">
	    <?php
	    /**
	     * Functions hooked in to bookworm_footer action
	     *
	     * @hooked bookworm_footer_widgets - 10
	     * @hooked bookworm_site_info      - 20
	     */
	     do_action( 'bookworm_footer_v12', 'v12' );
	     ?>
	 </div>
</footer>