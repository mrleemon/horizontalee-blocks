<?php
/**
 * Customizer functionality
 *
 * @package theme
 */

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function theme_customize_register( $wp_customize ) {

	// Include the Alpha Color Picker control file.
	require_once __DIR__ . '/customizer/controls/alpha-color-picker/alpha-color-picker.php';

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Remove the core header textcolor control.
	$wp_customize->remove_control( 'header_textcolor' );

	// Remove the core background color control.
	$wp_customize->remove_control( 'background_color' );

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'            => '.site-title a',
				'container_inclusive' => false,
				'render_callback'     => 'theme_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'            => '.site-description',
				'container_inclusive' => false,
				'render_callback'     => 'theme_customize_partial_blogdescription',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'footer_text',
			array(
				'selector'            => '.footer-text',
				'container_inclusive' => false,
				'render_callback'     => 'theme_customize_partial_footer_text',
			)
		);
	}

	// Add display site title setting and control.
	$wp_customize->add_setting(
		'display_site_title',
		array(
			'default'           => true,
			'sanitize_callback' => 'theme_sanitize_checkbox_field',
		)
	);

	$wp_customize->add_control(
		'display_site_title',
		array(
			'label'    => __( 'Display Site Title', 'theme' ),
			'section'  => 'title_tagline',
			'settings' => 'display_site_title',
			'type'     => 'checkbox',
		)
	);

	// Add display site tagline setting and control.
	$wp_customize->add_setting(
		'display_site_tagline',
		array(
			'default'           => true,
			'sanitize_callback' => 'theme_sanitize_checkbox_field',
		)
	);

	$wp_customize->add_control(
		'display_site_tagline',
		array(
			'label'    => __( 'Display Site Tagline', 'theme' ),
			'section'  => 'title_tagline',
			'settings' => 'display_site_tagline',
			'type'     => 'checkbox',
		)
	);

	// Add layout panel.
	$wp_customize->add_panel(
		'layout',
		array(
			'title'    => __( 'Layout', 'theme' ),
			'priority' => 30,
		)
	);

	// Add header section.
	$wp_customize->add_section(
		'header',
		array(
			'title'       => __( 'Header', 'theme' ),
			'panel'       => 'layout',
			'description' => __( 'Customize the look & feel of your website header area.', 'theme' ),
		)
	);

	// Add header layout setting and control.
	$wp_customize->add_setting(
		'header_layout',
		array(
			'default'           => 'left-right',
			'sanitize_callback' => 'theme_sanitize_select_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'header_layout',
			array(
				'label'       => __( 'Header Layout', 'theme' ),
				'description' => __( 'Applied to the header on wide screens only.', 'theme' ),
				'section'     => 'header',
				'settings'    => 'header_layout',
				'type'        => 'select',
				'choices'     => array(
					'left-right'   => __( 'Logo on the left and menu on the right', 'theme' ),
					'left'         => __( 'Logo and menu on the left', 'theme' ),
					'left-align'   => __( 'Logo and menu aligned on the left', 'theme' ),
					'center'       => __( 'Logo and menu on the center', 'theme' ),
					'center-align' => __( 'Logo and menu aligned on the center', 'theme' ),
					'right'        => __( 'Logo and menu on the right', 'theme' ),
					'right-align'  => __( 'Logo and menu aligned on the right', 'theme' ),
					'right-left'   => __( 'Logo on the right and menu on the left', 'theme' ),
				),
			)
		)
	);

	// Add header stickiness setting and control.
	$wp_customize->add_setting(
		'header_stickiness',
		array(
			'default'           => false,
			'sanitize_callback' => 'theme_sanitize_checkbox_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'header_stickiness',
			array(
				'label'       => __( 'Enable sticky header', 'theme' ),
				'description' => __( 'Checking this will make the header stick to the top.', 'theme' ),
				'section'     => 'header',
				'settings'    => 'header_stickiness',
				'type'        => 'checkbox',
			)
		)
	);

	// Move core header image control to the header section.
	$wp_customize->get_control( 'header_image' )->section = 'header';

	// Add sidebar section.
	$wp_customize->add_section(
		'sidebar',
		array(
			'title'       => __( 'Sidebar', 'theme' ),
			'panel'       => 'layout',
			'description' => __( 'Customize the look & feel of your website sidebar area.', 'theme' ),
		)
	);

	// Add front page sidebar layout setting and control.
	$wp_customize->add_setting(
		'front_sidebar_layout',
		array(
			'default'           => 'none',
			'sanitize_callback' => 'theme_sanitize_select_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'front_sidebar_layout',
			array(
				'label'       => __( 'Front Page', 'theme' ),
				'description' => __( 'Applied on wide screens only.', 'theme' ),
				'section'     => 'sidebar',
				'settings'    => 'front_sidebar_layout',
				'type'        => 'select',
				'choices'     => array(
					'none'  => __( 'No sidebar', 'theme' ),
					'left'  => __( 'Sidebar on the left', 'theme' ),
					'right' => __( 'Sidebar on the right', 'theme' ),
				),
			)
		)
	);

	// Add blog page sidebar layout setting and control.
	$wp_customize->add_setting(
		'blog_sidebar_layout',
		array(
			'default'           => 'right',
			'sanitize_callback' => 'theme_sanitize_select_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'blog_sidebar_layout',
			array(
				'label'       => __( 'Blog Page', 'theme' ),
				'description' => __( 'Applied on wide screens only.', 'theme' ),
				'section'     => 'sidebar',
				'settings'    => 'blog_sidebar_layout',
				'type'        => 'select',
				'choices'     => array(
					'none'  => __( 'No sidebar', 'theme' ),
					'left'  => __( 'Sidebar on the left', 'theme' ),
					'right' => __( 'Sidebar on the right', 'theme' ),
				),
			)
		)
	);

	// Add default sidebar layout setting and control.
	$wp_customize->add_setting(
		'default_sidebar_layout',
		array(
			'default'           => 'none',
			'sanitize_callback' => 'theme_sanitize_select_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'default_sidebar_layout',
			array(
				'label'       => __( 'Default', 'theme' ),
				'description' => __( 'Applied on wide screens only.', 'theme' ),
				'section'     => 'sidebar',
				'settings'    => 'default_sidebar_layout',
				'type'        => 'select',
				'choices'     => array(
					'none'  => __( 'No sidebar', 'theme' ),
					'left'  => __( 'Sidebar on the left', 'theme' ),
					'right' => __( 'Sidebar on the right', 'theme' ),
				),
			)
		)
	);

	// Add blog section.
	$wp_customize->add_section(
		'blog',
		array(
			'title'       => __( 'Blog', 'theme' ),
			'panel'       => 'layout',
			'description' => __( 'Customize the look & feel of your website blog area.', 'theme' ),
		)
	);

	// Add blog layout setting and control.
	$wp_customize->add_setting(
		'blog_layout',
		array(
			'default'           => 'list',
			'sanitize_callback' => 'theme_sanitize_select_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'blog_layout',
			array(
				'label'       => __( 'Layout', 'theme' ),
				'description' => __( 'Layout for posts on your blog and archive pages.', 'theme' ),
				'section'     => 'blog',
				'settings'    => 'blog_layout',
				'type'        => 'select',
				'choices'     => array(
					'list' => __( 'List', 'theme' ),
					'grid' => __( 'Grid', 'theme' ),
				),
			)
		)
	);

	// Add grid post thumbnails per row setting and control.
	$wp_customize->add_setting(
		'grid_post_thumbnail_columns',
		array(
			'default'           => '4',
			'sanitize_callback' => 'theme_sanitize_select_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'grid_post_thumbnail_columns',
			array(
				'label'           => __( 'Thumbnails Per Row', 'theme' ),
				'description'     => __( 'Number of thumbnails per row on grid pages.', 'theme' ),
				'section'         => 'blog',
				'settings'        => 'grid_post_thumbnail_columns',
				'type'            => 'select',
				'choices'         => array(
					'0' => _x( 'Unlimited', 'Number of thumbnails', 'theme' ),
					'1' => _x( 'One', 'Number of thumbnails', 'theme' ),
					'2' => _x( 'Two', 'Number of thumbnails', 'theme' ),
					'3' => __( 'Three', 'theme' ),
					'4' => __( 'Four', 'theme' ),
					'5' => __( 'Five', 'theme' ),
					'6' => __( 'Six', 'theme' ),
				),
				'active_callback' => 'theme_is_grid_layout_active',
			)
		)
	);

	// Add grid post thumbnail size setting and control.
	$wp_customize->add_setting(
		'grid_post_thumbnail_size',
		array(
			'default'           => 'thumbnail',
			'sanitize_callback' => 'theme_sanitize_select_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'grid_post_thumbnail_size',
			array(
				'label'           => __( 'Thumbnail Size', 'theme' ),
				'description'     => __( 'Size of thumbnails on grid pages.', 'theme' ),
				'section'         => 'blog',
				'settings'        => 'grid_post_thumbnail_size',
				'type'            => 'select',
				'choices'         => theme_get_available_image_sizes(),
				'active_callback' => 'theme_is_grid_layout_active',
			)
		)
	);

	// Add default grid post thumbnail setting and control.
	$wp_customize->add_setting(
		'default_grid_post_thumbnail',
		array(
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'default_grid_post_thumbnail',
			array(
				'label'           => __( 'Default Thumbnail', 'theme' ),
				'description'     => __( 'Posts with no featured image will use this on grid pages.', 'theme' ),
				'section'         => 'blog',
				'settings'        => 'default_grid_post_thumbnail',
				'mime_type'       => 'image',
				'active_callback' => 'theme_is_grid_layout_active',
			)
		)
	);

	// Add footer section.
	$wp_customize->add_section(
		'footer',
		array(
			'title'       => __( 'Footer', 'theme' ),
			'panel'       => 'layout',
			'description' => __( 'Customize the look & feel of your website footer area.', 'theme' ),
		)
	);

	// Add footer text setting and control.
	$wp_customize->add_setting(
		'footer_text',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'theme_sanitize_html_text_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'footer_text',
			array(
				'label'       => __( 'Text', 'theme' ),
				'description' => __( 'Shortcodes and some HTML tags are permitted.', 'theme' ),
				'section'     => 'footer',
				'settings'    => 'footer_text',
				'type'        => 'textarea',
			)
		)
	);

	// Add display scroll to top setting and control.
	$wp_customize->add_setting(
		'display_scroll_to_top',
		array(
			'default'           => false,
			'sanitize_callback' => 'theme_sanitize_checkbox_field',
		)
	);

	$wp_customize->add_control(
		'display_scroll_to_top',
		array(
			'label'    => __( 'Display "Scroll To Top" Button', 'theme' ),
			'section'  => 'footer',
			'settings' => 'display_scroll_to_top',
			'type'     => 'checkbox',
		)
	);

	// Add colors panel.
	$wp_customize->add_panel(
		'colors',
		array(
			'title'    => __( 'Colors', 'theme' ),
			'priority' => 40,
		)
	);

	// Add content colors section.
	$wp_customize->add_section(
		'content_colors',
		array(
			'title'       => __( 'Content', 'theme' ),
			'panel'       => 'colors',
			'description' => __( 'Customize the colors of your website main content area.', 'theme' ),
		)
	);

	// Add content background color setting and control.
	$wp_customize->add_setting(
		'content_background_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'content_background_color',
			array(
				'label'   => __( 'Background Color', 'theme' ),
				'section' => 'content_colors',
			)
		)
	);

	// Add content text color setting and control.
	$wp_customize->add_setting(
		'content_text_color',
		array(
			'default'           => '#111111',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'content_text_color',
			array(
				'label'   => __( 'Text Color', 'theme' ),
				'section' => 'content_colors',
			)
		)
	);

	// Add content heading color setting and control.
	$wp_customize->add_setting(
		'content_heading_color',
		array(
			'default'           => '#111111',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'content_heading_color',
			array(
				'label'   => __( 'Heading Color', 'theme' ),
				'section' => 'content_colors',
			)
		)
	);

	// Add content link color setting and control.
	$wp_customize->add_setting(
		'content_link_color',
		array(
			'default'           => '#999999',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'content_link_color',
			array(
				'label'   => __( 'Link Color', 'theme' ),
				'section' => 'content_colors',
			)
		)
	);

	// Add content link hover color setting and control.
	$wp_customize->add_setting(
		'content_link_hover_color',
		array(
			'default'           => '#bbbbbb',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'content_link_hover_color',
			array(
				'label'   => __( 'Link Hover Color', 'theme' ),
				'section' => 'content_colors',
			)
		)
	);

	// Add button colors section.
	$wp_customize->add_section(
		'button_colors',
		array(
			'title'       => __( 'Buttons', 'theme' ),
			'panel'       => 'colors',
			'description' => __( 'Customize the colors of your website buttons.', 'theme' ),
		)
	);

	// Add button background color setting and control.
	$wp_customize->add_setting(
		'button_background_color',
		array(
			'default'           => '#999999',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'button_background_color',
			array(
				'label'   => __( 'Background Color', 'theme' ),
				'section' => 'button_colors',
			)
		)
	);

	// Add button background hover color setting and control.
	$wp_customize->add_setting(
		'button_background_hover_color',
		array(
			'default'           => '#bbbbbb',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'button_background_hover_color',
			array(
				'label'   => __( 'Background Hover Color', 'theme' ),
				'section' => 'button_colors',
			)
		)
	);

	// Add button text color setting and control.
	$wp_customize->add_setting(
		'button_text_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'button_text_color',
			array(
				'label'   => __( 'Text Color', 'theme' ),
				'section' => 'button_colors',
			)
		)
	);

	// Add button text hover color setting and control.
	$wp_customize->add_setting(
		'button_text_hover_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'button_text_hover_color',
			array(
				'label'   => __( 'Text Hover Color', 'theme' ),
				'section' => 'button_colors',
			)
		)
	);

	// Add header colors section.
	$wp_customize->add_section(
		'header_colors',
		array(
			'title'       => __( 'Header', 'theme' ),
			'panel'       => 'colors',
			'description' => __( 'Customize the colors of your website header area.', 'theme' ),
		)
	);

	// Add custom header background color setting and control.
	$wp_customize->add_setting(
		'header_background_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'theme_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new Customize_Alpha_Color_Control(
			$wp_customize,
			'header_background_color',
			array(
				'label'        => __( 'Background Color', 'theme' ),
				'section'      => 'header_colors',
				'show_opacity' => true,
			)
		)
	);

	// Add custom header text color setting and control.
	$wp_customize->add_setting(
		'header_text_color',
		array(
			'default'           => '#111111',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_text_color',
			array(
				'label'   => __( 'Text Color', 'theme' ),
				'section' => 'header_colors',
			)
		)
	);

	// Add custom header link color setting and control.
	$wp_customize->add_setting(
		'header_link_color',
		array(
			'default'           => '#111111',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_link_color',
			array(
				'label'   => __( 'Link Color', 'theme' ),
				'section' => 'header_colors',
			)
		)
	);

	// Add custom header link hover color setting and control.
	$wp_customize->add_setting(
		'header_link_hover_color',
		array(
			'default'           => '#999999',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_link_hover_color',
			array(
				'label'   => __( 'Link Hover Color', 'theme' ),
				'section' => 'header_colors',
			)
		)
	);

	// Add menu colors section.
	$wp_customize->add_section(
		'menu_colors',
		array(
			'title'       => __( 'Menu', 'theme' ),
			'panel'       => 'colors',
			'description' => __( 'Customize the colors of your website menu area.', 'theme' ),
		)
	);

	// Add menu background color setting and control.
	$wp_customize->add_setting(
		'menu_background_color',
		array(
			'default'           => 'rgba(255, 255, 255, 0)',
			'sanitize_callback' => 'theme_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new Customize_Alpha_Color_Control(
			$wp_customize,
			'menu_background_color',
			array(
				'label'   => __( 'Menu Item Background Color', 'theme' ),
				'section' => 'menu_colors',
			)
		)
	);

	// Add menu color setting and control.
	$wp_customize->add_setting(
		'menu_color',
		array(
			'default'           => '#111111',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_color',
			array(
				'label'   => __( 'Menu Item Color', 'theme' ),
				'section' => 'menu_colors',
			)
		)
	);

	// Add menu background hover color setting and control.
	$wp_customize->add_setting(
		'menu_background_hover_color',
		array(
			'default'           => 'rgba(255, 255, 255, 0)',
			'sanitize_callback' => 'theme_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new Customize_Alpha_Color_Control(
			$wp_customize,
			'menu_background_hover_color',
			array(
				'label'   => __( 'Menu Item Background Hover Color', 'theme' ),
				'section' => 'menu_colors',
			)
		)
	);

	// Add menu hover color setting and control.
	$wp_customize->add_setting(
		'menu_hover_color',
		array(
			'default'           => '#999999',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_hover_color',
			array(
				'label'   => __( 'Menu Item Hover Color', 'theme' ),
				'section' => 'menu_colors',
			)
		)
	);

	// Add menu background active color setting and control.
	$wp_customize->add_setting(
		'menu_background_active_color',
		array(
			'default'           => 'rgba(255, 255, 255, 0)',
			'sanitize_callback' => 'theme_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new Customize_Alpha_Color_Control(
			$wp_customize,
			'menu_background_active_color',
			array(
				'label'   => __( 'Menu Item Background Active Color', 'theme' ),
				'section' => 'menu_colors',
			)
		)
	);

	// Add menu active color setting and control.
	$wp_customize->add_setting(
		'menu_active_color',
		array(
			'default'           => '#999999',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_active_color',
			array(
				'label'   => __( 'Menu Item Active Color', 'theme' ),
				'section' => 'menu_colors',
			)
		)
	);

	// Add submenu background color setting and control.
	$wp_customize->add_setting(
		'submenu_background_color',
		array(
			'default'           => 'rgba(190, 190, 190, 0.7)',
			'sanitize_callback' => 'theme_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new Customize_Alpha_Color_Control(
			$wp_customize,
			'submenu_background_color',
			array(
				'label'        => __( 'Submenu Background Color', 'theme' ),
				'section'      => 'menu_colors',
				'show_opacity' => true,
			)
		)
	);

	// Add submenu color setting and control.
	$wp_customize->add_setting(
		'submenu_text_color',
		array(
			'default'           => '#111111',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'submenu_text_color',
			array(
				'label'   => __( 'Submenu Item Color', 'theme' ),
				'section' => 'menu_colors',
			)
		)
	);
}
add_action( 'customize_register', 'theme_customize_register', 11 );

/**
 * Sanitize RGBA color
 *
 * @param string $color The color in hex format.
 * @return string
 */
function theme_sanitize_rgba_color( $color ) {
	if ( empty( $color ) || is_array( $color ) ) {
		return 'rgba(0,0,0,0)';
	}

	// If string does not start with 'rgba', then treat as hex
	// sanitize the hex color and finally convert hex to rgba.
	if ( false === strpos( $color, 'rgba' ) ) {
		return sanitize_hex_color( $color );
	}

	// By now we know the string is formatted as an rgba color so we need to further sanitize it.
	$color = str_replace( ' ', '', $color );
	sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
	return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
}

/**
 * Sanitize select field
 *
 * @param string $input The input value.
 * @param string $setting The setting.
 * @return string
 */
function theme_sanitize_select_field( $input, $setting ) {
	// Lowercase alphanumeric characters, dashes and underscores allowed only.
	$input = sanitize_key( $input );

	// Get the list of possible select options.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// Return input if valid or return default option.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Sanitize checkbox field
 *
 * @param string $input The input value.
 * @return string
 */
function theme_sanitize_checkbox_field( $input ) {
	// Returns true if checkbox is checked.
	return ( ( isset( $input ) && true === $input ) ? true : false );
}

/**
 * Sanitize HTML text field
 *
 * @param string $input The input value.
 * @return string
 */
function theme_sanitize_html_text_field( $input ) {
	return wp_kses_post( $input );
}

/**
 * Check if grid layout is active
 *
 * @param string $control The control.
 * @return boolean
 */
function theme_is_grid_layout_active( $control ) {
	$setting = $control->manager->get_setting( 'blog_layout' );
	if ( 'grid' === $setting->value() ) {
		return true;
	}
	return false;
}

/**
 * Get available image sizes
 *
 * @return array
 */
function theme_get_available_image_sizes() {
	$available_sizes  = array();
	$additional_sizes = wp_get_additional_image_sizes();
	$image_sizes      = get_intermediate_image_sizes();
	foreach ( $image_sizes as $image_size ) {
		if ( has_image_size( $image_size ) ) {
			$width  = intval( $additional_sizes[ $image_size ]['width'] );
			$height = intval( $additional_sizes[ $image_size ]['height'] );
		} else {
			$width  = intval( get_option( $image_size . '_size_w' ) );
			$height = intval( get_option( $image_size . '_size_h' ) );
		}
		if ( 0 === $width && 0 === $height ) {
			continue;
		}
		$available_sizes[ $image_size ] = $image_size . ' – ' . $width . ' x ' . $height;
	}
	return $available_sizes;
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function theme_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function theme_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Render the footer text for the selective refresh partial.
 *
 * @return void
 */
function theme_customize_partial_footer_text() {
	echo wp_kses_post( get_theme_mod( 'footer_text' ) );
}

/**
 * Enqueues front-end CSS for color scheme.
 *
 * @see wp_add_inline_style()
 */
function theme_color_scheme_css() {
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

	if ( ! WP_DEBUG ) {
		$color_scheme_css = theme_minify_css( $color_scheme_css );
	}

	wp_add_inline_style( 'theme-style', $color_scheme_css );
}
add_action( 'wp_enqueue_scripts', 'theme_color_scheme_css' );

/**
 * Binds JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 */
function theme_customize_control_js() {
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script(
		'theme-customize-color-control',
		get_template_directory_uri() . '/assets/js/customize-color-control' . $suffix . '.js',
		array( 'customize-controls', 'iris', 'underscore', 'wp-util' ),
		filemtime( get_template_directory() . '/assets/js/customize-color-control' . $suffix . '.js' ),
		array(
			'in_footer' => false,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'customize_controls_enqueue_scripts', 'theme_customize_control_js' );

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 */
function theme_customize_preview_js() {
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script(
		'theme-customize-preview',
		get_template_directory_uri() . '/assets/js/customize-preview' . $suffix . '.js',
		array( 'customize-preview' ),
		filemtime( get_template_directory() . '/assets/js/customize-preview' . $suffix . '.js' ),
		array(
			'in_footer' => false,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'customize_preview_init', 'theme_customize_preview_js' );

/**
 * Returns minified CSS.
 *
 * @param string $css Original CSS code.
 * @return string Minified CSS code.
 */
function theme_minify_css( $css ) {
	// Remove comments.
	$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );
	// Remove spaces before and after symbols.
	$css = str_replace( ': ', ':', $css );
	$css = str_replace( ' {', '{', $css );
	$css = str_replace( ', ', ',', $css );
	// Remove remaining whitespace.
	$css = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css );
	return $css;
}

/**
 * Convert HEX to RGB.
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function theme_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
	} elseif ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array(
		'red'   => $r,
		'green' => $g,
		'blue'  => $b,
	);
}

/**
 * Returns CSS for the color schemes.
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function theme_get_color_scheme_css( $colors ) {
	$colors = wp_parse_args(
		$colors,
		array(
			'content_background_color'      => '',
			'content_text_color'            => '',
			'content_secondary_text_color'  => '',
			'content_heading_color'         => '',
			'content_link_color'            => '',
			'content_link_hover_color'      => '',
			'border_color'                  => '',
			'border_focus_color'            => '',
			'button_background_color'       => '',
			'button_background_hover_color' => '',
			'button_text_color'             => '',
			'button_text_hover_color'       => '',
			'header_background_color'       => '',
			'header_text_color'             => '',
			'header_secondary_text_color'   => '',
			'header_link_color'             => '',
			'header_link_hover_color'       => '',
			'menu_background_color'         => '',
			'menu_color'                    => '',
			'menu_background_hover_color'   => '',
			'menu_hover_color'              => '',
			'menu_background_active_color'  => '',
			'menu_active_color'             => '',
			'submenu_text_color'            => '',
			'submenu_background_color'      => '',
		)
	);

	$css = <<<CSS

    :root {
        --theme-background-color: {$colors['content_background_color']};
        --theme-text-color: {$colors['content_text_color']};
        --theme-secondary-text-color: {$colors['content_secondary_text_color']};
        --theme-heading-color: {$colors['content_heading_color']};
        --theme-link-color: {$colors['content_link_color']};
        --theme-link-hover-color: {$colors['content_link_hover_color']};
        --theme-border-color: {$colors['border_color']};
        --theme-border-focus-color: {$colors['border_focus_color']};
        --theme-button-background-color: {$colors['button_background_color']};
        --theme-button-background-hover-color: {$colors['button_background_hover_color']};
        --theme-button-text-color: {$colors['button_text_color']};
        --theme-button-text-hover-color: {$colors['button_text_hover_color']};
        --theme-header-background-color: {$colors['header_background_color']};
        --theme-header-text-color: {$colors['header_text_color']};
        --theme-header-secondary-text-color: {$colors['header_secondary_text_color']};
        --theme-header-link-color: {$colors['header_link_color']};
        --theme-header-link-hover-color: {$colors['header_link_hover_color']};
        --theme-menu-background-color: {$colors['menu_background_color']};
        --theme-menu-color: {$colors['menu_color']};
        --theme-menu-background-hover-color: {$colors['menu_background_hover_color']};
        --theme-menu-hover-color: {$colors['menu_hover_color']};
        --theme-menu-background-active-color: {$colors['menu_background_active_color']};
        --theme-menu-active-color: {$colors['menu_active_color']};
        --theme-submenu-text-color: {$colors['submenu_text_color']};
        --theme-submenu-background-color: {$colors['submenu_background_color']};
    }

CSS;

	return $css;
}

/**
 * Output an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the Customizer
 * preview.
 */
function theme_color_scheme_css_template() {
	$colors = array(
		'content_background_color'      => '{{ data.content_background_color }}',
		'content_text_color'            => '{{ data.content_text_color }}',
		'content_heading_color'         => '{{ data.content_heading_color }}',
		'content_secondary_text_color'  => '{{ data.content_secondary_text_color }}',
		'content_link_color'            => '{{ data.content_link_color }}',
		'content_link_hover_color'      => '{{ data.content_link_hover_color }}',
		'border_color'                  => '{{ data.border_color }}',
		'border_focus_color'            => '{{ data.border_focus_color }}',
		'button_background_color'       => '{{ data.button_background_color }}',
		'button_background_hover_color' => '{{ data.button_background_hover_color }}',
		'button_text_color'             => '{{ data.button_text_color }}',
		'button_text_hover_color'       => '{{ data.button_text_hover_color }}',
		'header_background_color'       => '{{ data.header_background_color }}',
		'header_text_color'             => '{{ data.header_text_color }}',
		'header_secondary_text_color'   => '{{ data.header_secondary_text_color }}',
		'header_link_color'             => '{{ data.header_link_color }}',
		'header_link_hover_color'       => '{{ data.header_link_hover_color }}',
		'menu_background_color'         => '{{ data.menu_background_color }}',
		'menu_color'                    => '{{ data.menu_color }}',
		'menu_background_hover_color'   => '{{ data.menu_background_hover_color }}',
		'menu_hover_color'              => '{{ data.menu_hover_color }}',
		'menu_background_active_color'  => '{{ data.menu_background_active_color }}',
		'menu_active_color'             => '{{ data.menu_active_color }}',
		'submenu_text_color'            => '{{ data.submenu_text_color }}',
		'submenu_background_color'      => '{{ data.submenu_background_color }}',
	);
	?>
	<script type="text/html" id="tmpl-theme-color-scheme">
		<?php echo theme_get_color_scheme_css( $colors ); ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'theme_color_scheme_css_template' );
