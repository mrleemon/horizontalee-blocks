/**
 * Theme functions file.
 *
 */

(function () {

	// Ensure the page scrolls to the correct anchor element after the DOM is fully loaded.
	document.addEventListener('DOMContentLoaded', function () {
		const hash = window.location.hash;
		if (hash) {
			const target = document.querySelector(hash);
			if (target) {
				target.scrollIntoView();
			}
		}
	});

	// Add class 'is-page-scrolled' on vertical scroll
	var scrolled_page_offset = parseInt(document.body.dataset.pageScrolledOffset);
	var scrolled_page = function () {
		var scroll_top = window.scrollY;
		if (scroll_top > scrolled_page_offset) {
			document.body.classList.add('is-page-scrolled');
		} else {
			document.body.classList.remove('is-page-scrolled');
		}
	};

	window.addEventListener('scroll', function () {
		scrolled_page();
	});

	scrolled_page();

})();