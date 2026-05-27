/**
 * Live-update changed settings in real time in the Customizer preview.
 * 
 */

(function () {

	var style = document.querySelector('#theme-color-scheme-css'),
		api = wp.customize;

	if (!style) {
		var el = document.createElement('style');
		el.setAttribute('type', 'text/css');
		el.setAttribute('id', 'theme-color-scheme-css');
		document.head.appendChild(el);
		style = document.querySelector('#theme-color-scheme-css');
	}

	// Site title.
	api('blogname', function (value) {
		value.bind(function (to) {
			document.querySelector('.site-title a').textContent = to;
		});
	});

	// Site tagline.
	api('blogdescription', function (value) {
		value.bind(function (to) {
			document.querySelector('.site-description').textContent = to;
		});
	});

	// Hide site title.
	api('display_site_title', function (value) {
		value.bind(function (to) {
			if (false === to) {
				document.body.classList.add('hide-site-title');
				document.body.classList.remove('show-site-title');
			} else {
				document.body.classList.remove('hide-site-title');
				document.body.classList.add('show-site-title');
			}
		});
	});

	// Hide site tagline.
	api('display_site_tagline', function (value) {
		value.bind(function (to) {
			if (false === to) {
				document.body.classList.add('hide-site-tagline');
				document.body.classList.remove('show-site-tagline');
			} else {
				document.body.classList.remove('hide-site-tagline');
				document.body.classList.add('show-site-tagline');
			}
		});
	});

	// Footer.
	api('footer_text', function (value) {
		value.bind(function (to) {
			document.querySelector('.footer-text').innerHTML = to;
		});
	});

	// Color Scheme CSS.
	api.bind('preview-ready', function () {
		api.preview.bind('update-color-scheme-css', function (css) {
			style.innerHTML = css;
		});
	});

})();