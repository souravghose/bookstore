<?php
/**
 * Search Form used in get_search_form
 *
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="sr-only"><?php echo esc_html__( 'Search for:', 'bookworm' ); ?></label>
    <div class="input-group">
        <input type="search" class="search-field form-control rounded-0" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'bookworm' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
        <div class="input-group-append">
            <input type="submit" class="search-submit btn btn-dark rounded-0" value="<?php echo esc_attr_x( 'Search', 'submit button', 'bookworm' ); ?>" />  
        </div>
    </div>
</form>