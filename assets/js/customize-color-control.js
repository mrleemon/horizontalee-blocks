/* global Color */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 * 
 */

(function (api) {

	var cssTemplate = wp.template('theme-color-scheme'),
		colorSettings = [
			'content_background_color',
			'content_text_color',
			'content_heading_color',
			'content_link_color',
			'content_link_hover_color',
			'button_background_color',
			'button_background_hover_color',
			'button_text_color',
			'button_text_hover_color',
			'header_background_color',
			'header_text_color',
			'header_link_color',
			'header_link_hover_color',
			'menu_background_color',
			'menu_color',
			'menu_background_hover_color',
			'menu_hover_color',
			'menu_background_active_color',
			'menu_active_color',
			'submenu_text_color',
			'submenu_background_color'
		];

	// Generate the CSS for the current Color Scheme.
	function updateCSS() {
		var css,
			colors = [];

		// Merge in color scheme overrides.
		_.each(colorSettings, function (setting) {
			colors[setting] = api(setting)();
		});

		// Add additional colors.
		colors.content_secondary_text_color = Color(colors.content_text_color).toCSS('rgba', 0.7);
		colors.border_color = Color(colors.content_text_color).toCSS('rgba', 0.2);
		colors.border_focus_color = Color(colors.content_text_color).toCSS('rgba', 0.5);
		colors.header_secondary_text_color = Color(colors.header_text_color).toCSS('rgba', 0.3);

		css = cssTemplate(colors);

		api.previewer.send('update-color-scheme-css', css);
	}

	// Update the CSS whenever a color setting is changed.
	_.each(colorSettings, function (setting) {
		api(setting, function (setting) {
			setting.bind(updateCSS);
		});
	});

})(wp.customize);