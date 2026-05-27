<?php
/**
 * Child theme functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @package theme
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function child_setup() {

}
add_action( 'after_setup_theme', 'child_setup', 99 );

/**
 * Enqueue scripts and styles.
 */
function child_enqueue_scripts() {

}
add_action( 'wp_enqueue_scripts', 'child_enqueue_scripts' );

/**
 * Change login logo.
 */
function child_login_enqueue_scripts() {
	$css = '.login h1 a,
		.login .wp-login-logo a {
			background-image: url(' . get_stylesheet_directory_uri() . '/assets/images/login.png);
			background-size: 320px auto;
			width: 100%;
			height: 120px;
		}';
	wp_add_inline_style( 'login', $css );
}
add_action( 'login_enqueue_scripts', 'child_login_enqueue_scripts' );

/**
 * Change login link.
 */
function child_login_headerurl() {
	return get_home_url();
}
add_filter( 'login_headerurl', 'child_login_headerurl' );
