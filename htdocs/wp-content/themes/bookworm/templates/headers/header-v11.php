<?php
/**
 * Header v11 Template
 *
 * @package bookworm
 */
?>

<?php do_action( 'bookworm_before_header_v11' ); ?>

<header id="site-header" class="site-header__v11 bg-punch-light pt-2 pt-md-4<?php echo bookworm_header_is_sticky() ? ' navbar-sticky' : ''; ?>">
    <?php
    do_action( 'bookworm_header_v11' );
    ?>
</header>

<?php do_action( 'bookworm_after_header_v11' ); ?>
