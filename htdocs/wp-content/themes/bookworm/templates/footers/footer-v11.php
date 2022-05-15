<?php
/**
 * Footer v11 Template
 *
 * @package bookworm
 */
?>
<footer class="site-footer_v9 bg-punch-light px-3 px-md-5 pb-6">
	<div class="bg-white rounded-bottom-pill">
		<div class="border-top space-top-2 space-top-md-3">
		    <?php
		    /**
		     * Functions hooked in to bookworm_footer action
		     *
		     * @hooked bookworm_footer_widgets - 10
		     * @hooked bookworm_site_info      - 20
		     */
		     do_action( 'bookworm_footer_v11', 'v11' );
		     ?>
		 </div>
	</div>
</footer>