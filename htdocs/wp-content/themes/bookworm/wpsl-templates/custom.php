<?php 
global $wpsl_settings, $wpsl;

$autoload_class = ( !$wpsl_settings['autoload'] ) ? 'class="wpsl-not-loaded"' : '';

$output = '<div id="wpsl-wrap" class="bookworm-wpsl-custom-template row no-gutters mb-0">' . "\r\n";
$output .= '<div class="col-lg-5 order-1 order-lg-0">';
$output .= "\t" . '<div class="bg-gray-200 p-4 px-md-9 pt-md-9 pb-md-10 mb-0 wpsl-search wpsl-clearfix ' . $this->get_css_classes() . '">' . "\r\n";
$output .= "\t\t" . '<div id="wpsl-search-wrap">' . "\r\n";
$output .= "\t\t\t" . '<form autocomplete="off" class="js-focus-state">' . "\r\n";
$output .= "\t\t\t\t" . '<label for="wpsl-search-input" class="font-weight-medium font-size-7 mb-5">' . esc_html( $wpsl->i18n->get_translation( 'search_label', __( 'Locate a Store', 'bookworm' ) ) ) . '</label>' . "\r\n";
$output .= '<div class="input-group border mb-5">';
$output .= "\t\t\t" . '<div class="wpsl-input form-control rounded-0 border-0 p-0 mr-0 mb-0">' . "\r\n";
$output .= "\t\t\t\t" . '<input class="form-control rounded-0 border-0 placeholder-color-3 pl-4 font-size-2 w-100 h-100" id="wpsl-search-input" type="text" value="' . apply_filters( 'wpsl_search_input', '' ) . '" name="wpsl-search-input" placeholder="Country/Region, state, city, street…" aria-required="true" />' . "\r\n";
$output .= "\t\t\t" . '</div>' . "\r\n";
$output .= "\t\t\t\t" . '<div class="wpsl-search-btn-wrap input-group-append mr-0 mt-0 d-none"><input class="mr-0 mb-0" id="wpsl-search-btn" type="submit" value="' . esc_attr( $wpsl->i18n->get_translation( 'search_btn_label', __( 'Search', 'bookworm' ) ) ) . '"></div>' . "\r\n";
$output .= '</div>';

if ( $wpsl_settings['radius_dropdown'] || $wpsl_settings['results_dropdown']  ) {
    $output .= "\t\t\t" . '<div class="wpsl-select-wrap row mb-5">' . "\r\n";

    if ( $wpsl_settings['radius_dropdown'] ) {
        $output .= "\t\t\t\t" . '<div id="wpsl-radius" class="col-12 col-xl-6 mb-4 mb-xl-0">' . "\r\n";
        $output .= "\t\t\t\t\t" . '<label for="wpsl-radius-dropdown" class="w-100 mr-0 mb-2 font-weight-medium">' . esc_html( $wpsl->i18n->get_translation( 'radius_label', __( 'Search radius', 'bookworm' ) ) ) . '</label>' . "\r\n";
        $output .= "\t\t\t\t\t" . '<select id="wpsl-radius-dropdown" class="wpsl-dropdown" name="wpsl-radius">' . "\r\n";
        $output .= "\t\t\t\t\t\t" . $this->get_dropdown_list( 'search_radius' ) . "\r\n";
        $output .= "\t\t\t\t\t" . '</select>' . "\r\n";
        $output .= "\t\t\t\t" . '</div>' . "\r\n";
    }

    if ( $wpsl_settings['results_dropdown'] ) {
        $output .= "\t\t\t\t" . '<div id="wpsl-results" class="col-12 col-xl-6">' . "\r\n";
        $output .= "\t\t\t\t\t" . '<label for="wpsl-results-dropdown" class="w-100 mr-0 mb-2 font-weight-medium">' . esc_html( $wpsl->i18n->get_translation( 'results_label', __( 'Results', 'bookworm' ) ) ) . '</label>' . "\r\n";
        $output .= "\t\t\t\t\t" . '<select id="wpsl-results-dropdown" class="wpsl-dropdown" name="wpsl-results">' . "\r\n";
        $output .= "\t\t\t\t\t\t" . $this->get_dropdown_list( 'max_results' ) . "\r\n";
        $output .= "\t\t\t\t\t" . '</select>' . "\r\n";
        $output .= "\t\t\t\t" . '</div>' . "\r\n";
    } 

    $output .= "\t\t\t" . '</div>' . "\r\n";
}

if ( $this->use_category_filter() ) {
    $output .= $this->create_category_filter();
}

$output .= "\t\t\t\t" . '<div class="wpsl-search-btn-wrap"><input id="wpsl-search-btn" type="submit" value="' . esc_attr( $wpsl->i18n->get_translation( 'search_btn_label', __( 'Near Me', 'bookworm' ) ) ) . '"></div>' . "\r\n";

$output .= "\t\t" . '</form>' . "\r\n";
$output .= "\t\t" . '</div>' . "\r\n";
$output .= "\t" . '</div>' . "\r\n";
    
$output .= "\t" . '<div id="wpsl-result-list" class="js-scrollbar height-100vh-main pt-8">' . "\r\n";
$output .= "\t\t" . '<div id="wpsl-stores" '. $autoload_class .'>' . "\r\n";
$output .= "\t\t\t" . '<ul class="list-unstyled"></ul>' . "\r\n";
$output .= "\t\t" . '</div>' . "\r\n";
$output .= "\t\t" . '<div id="wpsl-direction-details">' . "\r\n";
$output .= "\t\t\t" . '<ul></ul>' . "\r\n";
$output .= "\t\t" . '</div>' . "\r\n";
$output .= "\t" . '</div>' . "\r\n";
$output .= '</div>';

$output .= '<div class="col-lg-7 height-400-md-down">';
$output .= "\t" . '<div id="wpsl-gmap" class="wpsl-gmap-canvas"></div>' . "\r\n";
$output .= '</div>';

if ( $wpsl_settings['show_credits'] ) { 
    $output .= "\t" . '<div class="wpsl-provided-by">'. sprintf( __( "Search provided by %sWP Store Locator%s", "bookworm" ), "<a target='_blank' href='https://wpstorelocator.co'>", "</a>" ) .'</div>' . "\r\n";
}

$output .= '</div>' . "\r\n";

return $output;