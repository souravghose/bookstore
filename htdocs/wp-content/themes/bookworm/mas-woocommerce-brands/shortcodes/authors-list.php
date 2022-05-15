<?php
/**
 * Show a grid of thumbnails
 */

$current_link = get_permalink();

?>
<div id="brands_a_z">
	<div class="author-portfolio mb-5 mb-lg-7">
		<ul class="author-index-pagination d-flex justify-content-between list-inline text-left pl-lg-8 pt-4 pt-lg-8 mb-5 mb-lg-8 overflow-auto">
			<?php

			if( empty( $first_letter ) || ! in_array( $first_letter, $index ) ) {
				echo '<li class="list-inline-item bg-white px-2 px-md-0 font-size-2 border-0 cbp-filter-item m-0 active"><a class="text-secondary-gray-700" href="' . esc_url( remove_query_arg( array( 'first_letter', 'paged' ), $current_link ) ) . '">' . esc_html__( 'ALL', 'bookworm' ) . '</a></li>';
			} else {
				echo '<li class="list-inline-item bg-white px-2 px-md-0 font-size-2 border-0 cbp-filter-item m-0"><a class="text-secondary-gray-700" href="' . esc_url( remove_query_arg( array( 'first_letter', 'paged' ), $current_link ) ) . '">' . esc_html__( 'ALL', 'bookworm' ) . '</a></li>';
			}

			foreach ( $index as $i ) {
				$link = add_query_arg( array(
					'first_letter' => $i,
				), $current_link );
				if( $first_letter == $i ) {
					echo '<li class="list-inline-item bg-white px-2 px-md-0 font-size-2 border-0 cbp-filter-item m-0 active"><a class="text-secondary-gray-700" href="' . esc_url( $link ) . '">' . esc_html( $i ) . '</a></li>';
				} else {
					echo '<li class="list-inline-item bg-white px-2 px-md-0 font-size-2 border-0 cbp-filter-item m-0"><a class="text-secondary-gray-700" href="' . esc_url( $link ) . '">' . esc_html( $i ) . '</a></li>';
				}
			}
			?>
		</ul>

		<div class="author-content position-relative mx-md-n7 row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-<?php echo esc_attr( $columns ); ?>">
			<?php if ( ! $brands || ! is_array( $brands ) ) : ?>
				<span class="px-md-7 col mx-auto d-block text-center w-100"><?php echo esc_html__( 'No authors available.', 'bookworm' ); ?></span>
			<?php else : ?>
				<?php foreach ( $brands as $index => $brand ) : ?>
					<div class="cbp-item author-wrapper col px-md-7 mx-0">
						<a class="cbp-caption" href="<?php echo esc_url( get_term_link( $brand->slug, $taxonomy ) ); ?>" title="<?php echo esc_attr( $brand->name ); ?>">
							<?php echo mas_wcbr_get_brand_thumbnail_image( $brand ); ?>

							<div class="py-3 text-center">
								<h4 class="h6 text-dark"><?php echo esc_html( $brand->name ); ?></h4>
								<?php if ( $brand->count > 0 ) : ?>
									<span class="font-size-2 text-secondary-gray-700"><?php echo esc_html( $brand->count );?> <?php echo esc_html__( 'Published Books' , 'bookworm'); ?></span>
								<?php endif; ?>
							</div>
						</a>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<?php if( $pages > 1 ) : ?>
		<ul class="author-pagination pagination pagination__custom justify-content-md-center flex-nowrap flex-md-wrap overflow-auto overflow-md-visble">
			<?php
			for ( $pagecount=1; $pagecount <= $pages; $pagecount++ ) {
				$link = add_query_arg( array(
					'paged' => $pagecount,
					'first_letter' => $first_letter,
				), $current_link );
				if( $page == $pagecount ) {
					echo '<li class="flex-shrink-0 flex-md-shrink-1 page-item active"><a class="page-link" href="' . esc_url( $link ) . '">' . esc_html( $pagecount ) . '</a></li>';
				} else {
					echo '<li class="flex-shrink-0 flex-md-shrink-1 page-item"><a class="page-link" href="' . esc_url( $link ) . '">' . esc_html( $pagecount ) . '</a></li>';
				}
			}
			?>
		</ul>
		<?php endif; ?>

	</div>	   
</div>
