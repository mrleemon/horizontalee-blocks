<?php
/**
 * Custom Header functionality
 *
 * @package theme
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses theme_header_style()
 */
function theme_custom_header_setup() {
	$default_text_color = '#111111';

	/**
	 * Filter custom-header support arguments.
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string  $default_text_color     Default color of the header text.
	 *     @type int     $width                  Width in pixels of the custom header image. Default 954.
	 *     @type int     $height                 Height in pixels of the custom header image. Default 1300.
	 *     @type boolean $header-text            Display the header text along with the image
	 * }
	 */
	add_theme_support(
		'custom-header',
		apply_filters(
			'theme_custom_header_args',
			array(
				'default-text-color' => $default_text_color,
				'width'              => 1300,
				'height'             => 400,
				'header-text'        => false,
			)
		)
	);
}
add_action( 'after_setup_theme', 'theme_custom_header_setup' );
