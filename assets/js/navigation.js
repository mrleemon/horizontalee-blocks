/* global screenReaderText */
/**
 * Handlers for navigation.
 *
 */

(function () {

	/**
	 * Get next sibling element.
	 */
	var nextSibling = function (el, selector) {
		if (selector) {
			var next = el.nextElementSibling;
			while (next && !next.matches(selector)) {
				next = next.nextElementSibling;
			}
			return next;
		} else {
			return el.nextElementSibling;
		}
	}

	/**
	 * Fade Out animation.
	 */
	var fadeOut = function (target, duration = 500) {
		target.style.transitionProperty = 'opacity';
		target.style.transitionDuration = duration + 'ms';
		target.style.opacity = 0;
		window.setTimeout(() => {
			target.style.display = 'none';
			target.style.removeProperty('opacity');
			target.style.removeProperty('transition-duration');
			target.style.removeProperty('transition-property');
		}, duration);
	}

	/**
	 * Fade In animation.
	 */
	var fadeIn = function (target, duration = 500) {
		target.style.opacity = 0;
		target.style.removeProperty('display');
		var display = window.getComputedStyle(target).display;

		if (display === 'none') {
			display = 'block';
		}

		target.style.display = display;
		target.style.transitionProperty = 'opacity';
		target.style.transitionDuration = duration + 'ms';
		window.setTimeout(() => {
			target.style.opacity = 1;
			window.setTimeout(() => {
				target.style.removeProperty('opacity');
				target.style.removeProperty('transition-duration');
				target.style.removeProperty('transition-property');
			}, duration);
		}, 1);
	}

	/**
	 * Toggle Fade In/Out animation.
	 */
	var fadeToggle = function (target, duration = 500) {
		if (window.getComputedStyle(target).display === 'none') {
			return fadeIn(target, duration);
		} else {
			return fadeOut(target, duration);
		}
	}

	/**
	 * Slide Up animation.
	 */
	var slideUp = function (target, duration = 500) {
		target.style.transitionProperty = 'height, margin, padding';
		target.style.transitionDuration = duration + 'ms';
		target.style.boxSizing = 'border-box';
		target.style.height = target.offsetHeight + 'px';
		target.offsetHeight;
		target.style.overflow = 'hidden';
		target.style.height = 0;
		target.style.paddingTop = 0;
		target.style.paddingBottom = 0;
		target.style.marginTop = 0;
		target.style.marginBottom = 0;
		window.setTimeout(() => {
			target.style.display = 'none';
			target.style.removeProperty('height');
			target.style.removeProperty('padding-top');
			target.style.removeProperty('padding-bottom');
			target.style.removeProperty('margin-top');
			target.style.removeProperty('margin-bottom');
			target.style.removeProperty('overflow');
			target.style.removeProperty('transition-duration');
			target.style.removeProperty('transition-property');
		}, duration);
	}

	/**
	 * Slide Down animation.
	 */
	var slideDown = function (target, duration = 500) {
		target.style.removeProperty('display');
		var display = window.getComputedStyle(target).display;

		if (display === 'none') {
			display = 'block';
		}

		target.style.display = display;
		var height = target.offsetHeight;
		target.style.overflow = 'hidden';
		target.style.height = 0;
		target.style.paddingTop = 0;
		target.style.paddingBottom = 0;
		target.style.marginTop = 0;
		target.style.marginBottom = 0;
		target.offsetHeight;
		target.style.boxSizing = 'border-box';
		target.style.transitionProperty = 'height, margin, padding';
		target.style.transitionDuration = duration + 'ms';
		target.style.height = height + 'px';
		target.style.removeProperty('padding-top');
		target.style.removeProperty('padding-bottom');
		target.style.removeProperty('margin-top');
		target.style.removeProperty('margin-bottom');
		window.setTimeout(() => {
			target.style.removeProperty('height');
			target.style.removeProperty('overflow');
			target.style.removeProperty('transition-duration');
			target.style.removeProperty('transition-property');
		}, duration);
	}

	/**
	 * Toggle Slide Up/Down animation.
	 */
	var slideToggle = function (target, duration = 500) {
		if (window.getComputedStyle(target).display === 'none') {
			return slideDown(target, duration);
		} else {
			return slideUp(target, duration);
		}
	}

	var wrap = document.querySelector('.header-navigation');
	if (!wrap) {
		// Return early if the navigation wrap doesn't exist.
		return;
	}

	var toggle = document.querySelector('.site-header .menu-toggle');
	if (!toggle) {
		// Return early if the menu toggle doesn't exist.
		return;
	}

	var mainNavigation = document.querySelector('.main-navigation');
	if (!mainNavigation) {
		// Return early if the main navigation doesn't exist.
		return;
	}

	/**
	 * Initialize menu toggle for small screens.
	 */
	function initMenuToggle() {
		// Hide toggle if the menus are missing or empty.
		var menu = wrap.querySelector('.main-navigation ul');
		if (!menu || !menu.children.length) {
			toggle.style.display = 'none';
			return;
		}

		toggle.addEventListener('click', function (e) {
			e.preventDefault();
			e.currentTarget.classList.toggle('toggled-on');
			e.currentTarget.setAttribute('aria-expanded', e.currentTarget.classList.contains('toggled-on'));
			wrap.classList.toggle('toggled-on');
			wrap.setAttribute('aria-expanded', wrap.classList.contains('toggled-on'));
		});
	}

	/**
	 * Initialize main navigation for small screens.
	 */
	function initMainNavigation(container) {
		// Toggle buttons with active children menu items.
		var button = container.querySelector('.current-menu-ancestor > button');
		if (button) {
			button.classList.add('toggle-on');
			button.setAttribute('aria-expanded', 'true');
		}

		// Toggle submenus with active children menu items.
		var submenu = container.querySelector('.current-menu-ancestor > .sub-menu');
		if (submenu) {
			submenu.classList.add('toggled-on');
			submenu.style.display = 'block';
		}

		container.querySelectorAll('.dropdown-toggle').forEach(function (item) {
			item.addEventListener('click', function (e) {
				var _this = e.currentTarget,
					topSubmenu = _this.closest('.main-navigation > .menu > .menu-item-has-children, .main-navigation > .menu .page_item_has_children'),
					screenReaderSpan = _this.querySelector('.screen-reader-text');

				e.preventDefault();

				// Remove toggle classes and attributes from all dropdown buttons but the ones in the current submenu.
				container.querySelectorAll('.dropdown-toggle.toggle-on').forEach(function (item) {
					var buttons = topSubmenu.querySelectorAll('.dropdown-toggle.toggle-on');
					// Convert to array
					buttons = Array.prototype.slice.call(buttons);
					if (!buttons.includes(item)) {
						item.classList.remove('toggle-on');
						item.setAttribute('aria-expanded', 'false');
					}
				});

				// Remove toggle classes and attributes from all submenu items but the ones in the current submenu.
				container.querySelectorAll('.children.toggled-on, .sub-menu.toggled-on').forEach(function (item) {
					var submenus = topSubmenu.querySelectorAll('.children.toggled-on, .sub-menu.toggled-on');
					// Convert to array
					submenus = Array.prototype.slice.call(submenus);
					if (!submenus.includes(item)) {
						item.classList.remove('toggled-on');
						slideUp(item, 100);
						if (item.style.display === 'none') {
							item.removeAttribute('style');
						}
					}
				});

				// Toggle clicked submenu item.
				_this.classList.toggle('toggle-on');
				var next = nextSibling(_this, '.children, .sub-menu');
				next.classList.toggle('toggled-on');
				slideToggle(next, 100);
				if (item.style.display === 'none') {
					item.removeAttribute('style');
				}

				_this.setAttribute('aria-expanded', _this.getAttribute('aria-expanded') === 'false' ? 'true' : 'false');
				screenReaderSpan.textContent = (screenReaderSpan.textContent === screenReaderText.expand ? screenReaderText.collapse : screenReaderText.expand);

			});
		});

	}

	/**
	 * Close main navigation for small screens.
	 */
	function closeMainNavigation(container) {
		toggle.classList.remove('toggled-on');
		wrap.classList.remove('toggled-on');
		toggle.setAttribute('aria-expanded', 'false');
		wrap.setAttribute('aria-expanded', 'false');
		// Remove toggle classes and attributes from all dropdown buttons.
		container.querySelectorAll('.dropdown-toggle.toggle-on').forEach(function (item) {
			item.classList.remove('toggle-on');
			item.setAttribute('aria-expanded', 'false');
		});
		// Remove toggle classes and attributes from all submenu items.
		container.querySelectorAll('.children.toggled-on, .sub-menu.toggled-on').forEach(function (item) {
			item.classList.remove('toggled-on');
			if (item.style.display === 'none') {
				item.removeAttribute('style');
			}
		});
	}

	/**
	 * Run the main navigation function as soon as the document is `ready`
	 */
	document.addEventListener('DOMContentLoaded', function () {
		initMenuToggle();
		initMainNavigation(mainNavigation);
	});

	/**
	 * Re-initialize the main navigation when it is updated, persisting any existing submenu expanded states.
	 */
	document.addEventListener('customize-preview-menu-refreshed', function (e, params) {
		if ('primary' === params.wpNavMenuArgs.theme_location) {
			initMainNavigation(params.newContainer);

			// Re-sync expanded states from oldContainer.
			params.oldContainer.querySelectorAll('.dropdown-toggle.toggle-on').forEach(function (item) {
				var containerId = item.parentNode.getAttribute('id');
				document.querySelector(params.newContainer + ' #' + containerId + ' > .dropdown-toggle').dispatchEvent(new MouseEvent('click'));
			});
		}
	});

	/**
	 * Close menu when resizing the browser.
	 */
	window.addEventListener('resize', function (e) {
		closeMainNavigation(mainNavigation);
	});
	
	/**
	 * Close menu after clicking an anchor link.
	 */
	mainNavigation.querySelectorAll('ul li a[href*="#"]:not(.dropdown-toggle):not(.search-toggle)').forEach(function (item) {
		item.addEventListener('click', function (e) {
			closeMainNavigation(mainNavigation);
		});
	});

	/**
	 * Enable menu toggle for the search icon.
	 */
	var searchToggle = document.querySelector('.menu-item-object-search_icon .search-toggle');
	if (searchToggle) {
		searchToggle.addEventListener('click', function (e) {
			e.preventDefault();
			var input = document.querySelector('.menu-item-object-search_icon .search-wrap');
			if (input.style.display === 'block') {
				fadeOut(input, 150);
			} else {
				fadeIn(input, 150);
				input.querySelector('input[type="search"]').focus();
			}
		});
	}

	/**
	 * Enable menu toggle for the product search icon.
	 */
	searchToggle = document.querySelector('.menu-item-object-product_search_icon .search-toggle');
	if (searchToggle) {
		searchToggle.addEventListener('click', function (e) {
			e.preventDefault();
			var input = document.querySelector('.menu-item-object-product_search_icon .search-wrap');
			if (input.style.display === 'block') {
				fadeOut(input, 150);
			} else {
				fadeIn(input, 150);
				input.querySelector('input[type="search"]').focus();
			}
		});
	}

})();