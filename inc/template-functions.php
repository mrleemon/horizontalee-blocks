<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function theme_body_classes( $classes ) {
	global $post;

	// Add class of post type and post slug for single posts.
	if ( is_singular() && isset( $post ) ) {
		$classes[] = sanitize_html_class( $post->post_type . '-' . $post->post_name );
	}

	// Add class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add class if we're viewing the Customizer for easier styling of theme options.
	if ( is_customize_preview() ) {
		$classes[] = 'theme-customizer';
	}

	// Add class when hiding the site title.
	if ( ! get_theme_mod( 'display_site_title', true ) ) {
		$classes[] = 'hide-site-title';
	} else {
		$classes[] = 'show-site-title';
	}

	// Add class when hiding the site tagline.
	if ( ! get_theme_mod( 'display_site_tagline', true ) ) {
		$classes[] = 'hide-site-tagline';
	} else {
		$classes[] = 'show-site-tagline';
	}

	// Add a class if header is sticky.
	if ( get_theme_mod( 'header_stickiness' ) ) {
		$classes[] = 'is-header-sticky';
	}

	// Add header layout class.
	$classes[] = 'header-layout-' . sanitize_html_class( get_theme_mod( 'header_layout', 'left-right' ) );

	// Add a class if there is a custom header.
	if ( has_header_image() ) {
		$classes[] = 'has-header-image';
	}

	// Add a class if the post has a featured image.
	if ( has_post_thumbnail() ) {
		$classes[] = 'has-featured-image';
	}

	// Add sidebar layout class.
	if ( is_front_page() ) {
		$classes[] = apply_filters( 'front_sidebar_layout_class', 'sidebar-layout-' . sanitize_html_class( get_theme_mod( 'front_sidebar_layout', 'none' ) ) );
	} elseif ( is_home() || is_singular( 'post' ) || is_category() || is_tag() || is_date() || is_author() || is_search() ) {
		$classes[] = apply_filters( 'blog_sidebar_layout_class', 'sidebar-layout-' . sanitize_html_class( get_theme_mod( 'blog_sidebar_layout', 'right' ) ) );
	} else {
		$classes[] = apply_filters( 'default_sidebar_layout_class', 'sidebar-layout-' . sanitize_html_class( get_theme_mod( 'default_sidebar_layout', 'none' ) ) );
	}

	return $classes;
}
add_filter( 'body_class', 'theme_body_classes' );

/**
 * Adds custom data attributes to the body tag.
 */
function theme_body_data_attributes() {
	// Add data-page-scrolled-offset attribute.
	$attributes = 'data-page-scrolled-offset="' . esc_attr( apply_filters( 'theme_page_scrolled_offset', 100 ) ) . '"';
	echo $attributes;
}

/**
 * Gets the SVG code for a given icon.
 *
 * @param string $icon  The name of the icon.
 * @param int    $size  The icon size in pixels.
 */
function theme_get_icon_svg( $icon, $size = 24 ) {
	return Theme_SVG_Icons::get_svg( $icon, $size );
}

/**
 * Add a search box at the end of the primary menu location.
 *
 * Use: add_filter( 'wp_nav_menu_items', 'theme_add_search_box_item', 10, 2 );
 *
 * @param string $items  The HTML list content for the menu items.
 * @param object $args   An object containing wp_nav_menu() arguments.
 * @return string The HTML list content for the menu items.
 */
function theme_add_search_box_item( $items, $args ) {
	$location = apply_filters( 'theme_search_box_item_location', 'primary' );
	if ( $location === $args->theme_location ) {
		$items .= '<li class="menu-item menu-item-object-search_box">' . get_search_form( false ) . '</li>';
	}
	return $items;
}

/**
 * Add a search icon at the end of the primary menu location.
 *
 * Use: add_filter( 'wp_nav_menu_items', 'theme_add_search_icon_item', 10, 2 );
 *
 * @param string $items  The HTML list content for the menu items.
 * @param object $args   An object containing wp_nav_menu() arguments.
 * @return string The HTML list content for the menu items.
 */
function theme_add_search_icon_item( $items, $args ) {
	$location = apply_filters( 'theme_search_icon_item_location', 'primary' );
	if ( $location === $args->theme_location ) {
		$items .= '<li class="menu-item menu-item-object-search_icon"><a href="#" class="search-toggle">' . theme_get_icon_svg( 'search', 20 ) . '</a><div class="search-wrap">' . get_search_form( false ) . '</div></li>';
	}
	return $items;
}

/**
 * Customize the search form
 *
 * @param string $form  The search form markup.
 * @return string The search form markup.
 */
function theme_search_form( $form ) {
	$form = '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
	<label>
		<span class="screen-reader-text">' . esc_html_x( 'Search for:', 'label', 'theme' ) . '</span>
		<input type="search" class="search-field" placeholder="' . esc_attr_x( 'Search&hellip;', 'placeholder', 'theme' ) . '" value="' . get_search_query() . '" name="s" />
	</label>
	<button type="submit" class="search-submit">' . theme_get_icon_svg( 'search', 20 ) . '<span class="screen-reader-text">' . esc_html_x( 'Search', 'submit button', 'theme' ) . '</span></button>
	</form>';
	return $form;
}
add_filter( 'get_search_form', 'theme_search_form' );

/**
 * Display the scroll to top button.
 */
function theme_scroll_to_top() {
	if ( ! get_theme_mod( 'display_scroll_to_top', false ) ) {
		return;
	}
	echo apply_filters(
		'theme_scroll_to_top_output',
		sprintf(
			'<button type="button" class="scroll-to-top">
        		%1$s <span class="screen-reader-text">%2$s</span>
        	</button>',
			theme_get_icon_svg( 'chevron_up', 24 ),
			esc_html__( 'Scroll To Top', 'theme' )
		)
	);
}
add_action( 'theme_footer_bottom', 'theme_scroll_to_top' );
