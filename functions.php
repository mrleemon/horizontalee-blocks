<?php
/**
 * Theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package theme
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function theme_setup() {
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus(
		array(
			'primary'    => esc_html__( 'Primary Menu', 'theme' ),
			'additional' => esc_html__( 'Additional Menu', 'theme' ),
		)
	);

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style(
		array(
			get_parent_theme_file_uri( 'assets/css/style-editor.css' ),
		)
	);

	/**
	 * Enable support for Custom Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'navigation-widgets',
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add support for editor styles in the block editor.
	add_theme_support( 'editor-styles' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Add support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for block template parts.
	add_theme_support( 'block-template-parts' );

	// Remove support for the block template editor.
	remove_theme_support( 'block-templates' );

	// Remove support for core block patterns.
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function theme_content_width() {
	/**
	 * Filters content width of the theme.
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'theme_content_width', 660 );
}
add_action( 'after_setup_theme', 'theme_content_width', 0 );

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 */
function theme_javascript_detection() {
	wp_print_inline_script_tag( "(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);" );
}
add_action( 'wp_head', 'theme_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 */
function theme_scripts() {
	// Initialize dependencies array.
	$deps = array();

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	// Load WooCommerce stylesheet.
	if ( class_exists( 'WooCommerce' ) ) {
		$deps[] = 'theme-woocommerce-style';
	}

	// If using a child theme, auto-load the parent theme style.
	if ( is_child_theme() ) {
		wp_enqueue_style(
			'theme-parent-style',
			get_template_directory_uri() . '/style.css',
			array(),
			filemtime( get_template_directory() . '/style.css' )
		);
		$deps[] = 'theme-parent-style';
	}

	// Load our main stylesheet.
	wp_enqueue_style(
		'theme-style',
		get_stylesheet_uri(),
		$deps,
		filemtime( get_stylesheet_directory() . '/style.css' )
	);

	// Theme block stylesheet.
	wp_enqueue_style(
		'theme-block-style',
		get_template_directory_uri() . '/assets/css/blocks.css',
		array( 'theme-style' ),
		filemtime( get_template_directory() . '/assets/css/blocks.css' )
	);

	// Load scripts.
	wp_enqueue_script(
		'theme-script',
		get_template_directory_uri() . '/assets/js/functions' . $suffix . '.js',
		array(),
		filemtime( get_template_directory() . '/assets/js/functions' . $suffix . '.js' ),
		array(
			'in_footer' => false,
			'strategy'  => 'defer',
		)
	);

	wp_enqueue_script(
		'theme-navigation',
		get_template_directory_uri() . '/assets/js/navigation' . $suffix . '.js',
		array(),
		filemtime( get_template_directory() . '/assets/js/navigation' . $suffix . '.js' ),
		array(
			'in_footer' => false,
			'strategy'  => 'defer',
		)
	);

	wp_enqueue_script(
		'theme-scroll-to-top',
		get_template_directory_uri() . '/assets/js/scroll-to-top' . $suffix . '.js',
		array(),
		filemtime( get_template_directory() . '/assets/js/scroll-to-top' . $suffix . '.js' ),
		array(
			'in_footer' => false,
			'strategy'  => 'defer',
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_localize_script(
		'theme-navigation',
		'screenReaderText',
		array(
			'expand'   => __( 'Expand child menu', 'theme' ),
			'collapse' => __( 'Collapse child menu', 'theme' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );

/**
 * Enqueue color scheme styles for the block editor.
 */
function theme_block_editor_styles() {
	// Load customizer color scheme.
	wp_register_style( 'theme-color-scheme-style', false );
	wp_enqueue_style( 'theme-color-scheme-style' );

	$content_text_color_rgb = theme_hex2rgb( get_theme_mod( 'content_text_color', '#111111' ) );
	$header_text_color_rgb  = theme_hex2rgb( get_theme_mod( 'header_text_color', '#111111' ) );
	$colors                 = array(
		'content_background_color'      => maybe_hash_hex_color( get_theme_mod( 'content_background_color', '#ffffff' ) ),
		'content_text_color'            => get_theme_mod( 'content_text_color', '#111111' ),
		'content_secondary_text_color'  => vsprintf( 'rgba(%1$s, %2$s, %3$s, 0.7)', $content_text_color_rgb ),
		'content_heading_color'         => get_theme_mod( 'content_heading_color', '#111111' ),
		'content_link_color'            => get_theme_mod( 'content_link_color', '#999999' ),
		'content_link_hover_color'      => get_theme_mod( 'content_link_hover_color', '#bbbbbb' ),
		'border_color'                  => vsprintf( 'rgba(%1$s, %2$s, %3$s, 0.2)', $content_text_color_rgb ),
		'border_focus_color'            => vsprintf( 'rgba(%1$s, %2$s, %3$s, 0.5)', $content_text_color_rgb ),
		'button_background_color'       => get_theme_mod( 'button_background_color', '#999999' ),
		'button_background_hover_color' => get_theme_mod( 'button_background_hover_color', '#bbbbbb' ),
		'button_text_color'             => get_theme_mod( 'button_text_color', '#ffffff' ),
		'button_text_hover_color'       => get_theme_mod( 'button_text_hover_color', '#ffffff' ),
		'header_background_color'       => get_theme_mod( 'header_background_color', '#ffffff' ),
		'header_text_color'             => get_theme_mod( 'header_text_color', '#111111' ),
		'header_secondary_text_color'   => vsprintf( 'rgba(%1$s, %2$s, %3$s, 0.3)', $header_text_color_rgb ),
		'header_link_color'             => get_theme_mod( 'header_link_color', '#111111' ),
		'header_link_hover_color'       => get_theme_mod( 'header_link_hover_color', '#999999' ),
		'menu_background_color'         => get_theme_mod( 'menu_background_color', 'rgba(255, 255, 255, 0)' ),
		'menu_color'                    => get_theme_mod( 'menu_color', '#111111' ),
		'menu_background_hover_color'   => get_theme_mod( 'menu_background_hover_color', 'rgba(255, 255, 255, 0)' ),
		'menu_hover_color'              => get_theme_mod( 'menu_hover_color', '#999999' ),
		'menu_background_active_color'  => get_theme_mod( 'menu_background_active_color', 'rgba(255, 255, 255, 0)' ),
		'menu_active_color'             => get_theme_mod( 'menu_active_color', '#999999' ),
		'submenu_text_color'            => get_theme_mod( 'submenu_text_color', '#111111' ),
		'submenu_background_color'      => get_theme_mod( 'submenu_background_color', '#dddddd' ),
	);

	$color_scheme_css = theme_get_color_scheme_css( $colors );
	wp_add_inline_style( 'theme-color-scheme-style', $color_scheme_css );
}
add_action( 'enqueue_block_assets', 'theme_block_editor_styles' );

/**
 * Remove Jetpack just in time messages.
 */
add_filter( 'jetpack_just_in_time_msgs', '__return_false', 99 );

/**
 * Remove Jetpack promotions.
 */
add_filter( 'jetpack_show_promotions', '__return_false' );

/**
 * SVG Icons class.
 */
require get_template_directory() . '/classes/class-theme-svg-icons.php';

/**
 * Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
