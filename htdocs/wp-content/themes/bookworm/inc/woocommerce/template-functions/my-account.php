<?php
/**
 * Template functions used in My Account
 *
 */

if ( ! function_exists( 'bookworm_wc_account_nav_title' ) ) {
    function bookworm_wc_account_nav_title() {
        ?><h6 class="font-weight-medium font-size-7 mb-5 mb-lg-7"><?php echo esc_html( get_the_title( wc_get_page_id( 'myaccount' ) ) ); ?></h6><?php
    }
}

if ( ! function_exists( 'bookworm_wc_account_content_title' ) ) {
    function bookworm_wc_account_content_title() {
        $endpoint   = WC()->query->get_current_endpoint();
        $menu_items = wc_get_account_menu_items();
        $label = '';
        if ( isset( $menu_items[ $endpoint ] ) ) {
            $label = $menu_items[ $endpoint ];
        } else {
            global $wp;
            if ( isset( $wp->query_vars['page'] ) || empty( $wp->query_vars ) ) {
                $endpoint = 'dashboard';
            } elseif ( isset( $wp->query_vars['view-order'] ) ) {
                $endpoint = 'orders';
            } elseif ( isset( $wp->query_vars['add-payment-method'] ) ) {
                $endpoint = 'payment-methods';
            }
            $label = isset( $menu_items[ $endpoint ] ) ? $menu_items[ $endpoint ]: '';
        }
        ?><h6 class="font-weight-medium font-size-7 mb-lg-8 pb-xl-1"><?php echo esc_html( apply_filters( 'bookworm_wc_account_content_title', $label ) ); ?></h6><?php
    }
}

if ( ! function_exists( 'bookworm_wc_account_dashboard_icons' ) ) {
    function bookworm_wc_account_dashboard_icons() {
        $menu_items = wc_get_account_menu_items();
        ?><div class="row no-gutters row-cols-1 row-cols-md-2 row-cols-lg-3 border-bottom border-right mt-4"><?php
        foreach ( $menu_items as $endpoint => $label ) {
            if ( 'dashboard' === $endpoint ) {
                continue;
            }
            $icon = bookworm_wc_get_account_menu_item_icon( $endpoint )
            ?><div class="col">
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" class="py-6 text-center d-block border-left border-top">
                    <span class="btn bg-gray-200 rounded-circle px-4 mb-2">
                        <span class="<?php echo esc_attr( $icon ); ?> font-size-10 btn-icon__inner text-primary"></span>
                    </span>
                    <div class="font-size-3 mb-xl-1"><?php echo esc_html( $label ); ?></div>
                </a>
            </div><?php
        }
        ?></div><?php
    }
}

if ( ! function_exists( 'bookworm_wc_account_wrapper_start' ) ) {
    function bookworm_wc_account_wrapper_start() {
        ?><div class="row"><?php
    }
}

if ( ! function_exists( 'bookworm_wc_account_nav_wrapper_start' ) ) {
    function bookworm_wc_account_nav_wrapper_start() {
        ?><div class="col-md-3 border-right py-5 py-lg-8 "><?php
    }
}

if ( ! function_exists( 'bookworm_wc_account_nav_wrapper_close' ) ) {
    function bookworm_wc_account_nav_wrapper_close() {
        ?></div><?php
    }
}

if ( ! function_exists( 'booworm_wc_account_content_wrapper_start' ) ) {
    function bookworm_wc_account_content_wrapper_start() {
        ?><div class="col-md-9"><div class="pt-5 pt-lg-8 pl-md-5 pl-lg-9 space-bottom-2 space-bottom-lg-3 mb-xl-1"><?php
    }
}

if ( ! function_exists( 'bookworm_wc_account_content_wrapper_close') ) {
    function bookworm_wc_account_content_wrapper_close() {
        ?></div><?php
    }
}
