<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package storefront
 */
$notfound_heading       = get_theme_mod( '404_heading', esc_html__( '404', 'bookworm' ) );

$notfound_title       = get_theme_mod( '404_title', esc_html__( 'Woops, looks like this page does not exist', 'bookworm' ) );

$notfound_desc        = get_theme_mod( '404_desc', esc_html__( 'You could either go back or go to homepage', 'bookworm' ) );

$notfound_action_text = get_theme_mod( '404_btn_text', esc_html__( 'Go Back', 'bookworm' ) );
$notfound_btn_clr =    get_theme_mod( '404_button_color', 'dark' );

get_header(); ?>
    <main id="content" role="main">
        <div class="container">
            <div class="space-bottom-1 space-top-xl-2 space-bottom-xl-4">
                <div class="d-flex flex-column align-items-center pt-lg-7 pb-lg-4 pb-lg-6">
                    <div class="font-weight-medium font-size-200 font-size-xs-170 text-lh-sm mt-xl-1"><?php echo esc_html( $notfound_heading ); ?></div>
                    <h6 class="font-size-4 font-weight-medium mb-2"><?php echo esc_html( $notfound_title ); ?></h6>
                    <span class="font-size-2 mb-6"><?php echo esc_html( $notfound_desc ); ?></span>
                    <div class="d-flex align-items-center flex-column">
                        <a href="javascript:history.back()" class="btn btn-<?php echo esc_attr( $notfound_btn_clr ); ?> rounded-0 btn-wide height-60 width-250 font-weight-medium d-flex align-items-center justify-content-center">
                            <?php echo esc_html( $notfound_action_text ); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php
get_footer();
