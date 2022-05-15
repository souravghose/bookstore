<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( is_user_logged_in() ) {
    return;
}

?>
<form class="woocommerce-form woocommerce-form-login login p-4 p-md-6" method="post">

    <?php do_action( 'woocommerce_login_form_start' ); ?>

    <?php echo ! empty( $message ) ? wpautop( wptexturize( $message ) ) : '';  // @codingStandardsIgnoreLine ?>

    <div class="form-group mb-4">
        <div class="js-form-message js-focus-state">
            <label class="form-label" for="username"><?php esc_html_e( 'Username or email', 'bookworm' ); ?> *</label>
            <input type="text" class="form-control rounded-0 height-4 px-4" name="username" id="username" autocomplete="username" aria-label="" required>
        </div>
    </div>

    <div class="form-group mb-4">
        <div class="js-form-message js-focus-state">
            <label class="form-label" for="password"><?php esc_html_e( 'Password', 'bookworm' ); ?> *</label>
            <input type="password" class="form-control rounded-0 height-4 px-4" name="password" id="password" autocomplete="current-password" aria-label="" required>
        </div>
    </div>

    <?php do_action( 'woocommerce_login_form' ); ?>

    <div class="d-flex justify-content-between mb-5 align-items-center">
        <div class="js-form-message">
            <div class="woocommerce-form-login__rememberme custom-control custom-checkbox d-flex align-items-center text-muted">
                <input type="checkbox" class="custom-control-input" id="rememberme" name="rememberme" value="forever">
                <label class="custom-control-label" for="rememberme">
                    <span class="font-size-2 text-secondary-gray-700">
                        <?php esc_html_e( 'Remember me', 'bookworm' ); ?>
                    </span>
                </label>
            </div>
        </div>

        <a class="lost_password js-animation-link text-dark font-size-2 t-d-u link-muted font-weight-medium" href="javascript:;"
        data-target="#forgotPassword"
        data-link-group="idForm"
        data-animation-in="fadeIn">
            <?php esc_html_e( 'Forgot Password?', 'bookworm' ); ?>
        </a>
    </div>

    <div class="mb-4d75">
        <input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ); ?>" />
        <button type="submit" class="woocommerce-form-login__submit btn btn-block py-3 rounded-0 btn-dark" name="login" value="<?php esc_attr_e( 'Sign In', 'bookworm' ); ?>"><?php esc_html_e( 'Sign In', 'bookworm' ); ?></button>
    </div>

    <?php if( bookworm_is_account_registration_enable() ) : ?>
        <div class="mb-2">
            <a href="javascript:;" class="js-animation-link btn btn-block py-3 rounded-0 btn-outline-dark font-weight-medium"
            data-target="#signup"
            data-link-group="idForm"
            data-animation-in="fadeIn">
                <?php esc_html_e( 'Create Account', 'bookworm' ); ?>
            </a>
        </div>
    <?php endif; ?>

    <?php do_action( 'woocommerce_login_form_end' ); ?>

    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>

</form>
