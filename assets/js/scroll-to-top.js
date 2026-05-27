/**
 * Add a scroll to top button.
 * 
 */

(function () {

	var supportsNativeSmoothScroll = 'scrollBehavior' in document.documentElement.style;
	var goTopBtn = document.querySelector('.scroll-to-top');

	// Function to animate the scroll for browsers that support native smooth scrolling.
	var nativeSmoothScroll = function () {
		window.scrollTo({
			top: 0,
			left: 0,
			behavior: 'smooth'
		});
	};

	// Function to animate the scroll for browsers that don't support native smooth scrolling.
	var smoothScroll = function (duration) {
		// Calculate how far and how fast to scroll.
		var startLocation = window.scrollY;
		var endLocation = document.body.offsetTop;
		var distance = endLocation - startLocation;
		var easing = function (t) { return t < .5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1 }
		var start;

		if (!distance) {
			return;
		}

		function step(timestamp) {
			start = start || timestamp;
			// Elapsed milliseconds since start of scrolling.
			var time = timestamp - start;
			// Get percent of completion in range [0, 1].
			var percent = Math.min(time / duration, 1);
			// Apply easing function.
			percent = easing(percent);
			window.scrollTo(0, parseInt(startLocation + distance * percent));
			// Proceed with animation as long as we wanted it to.
			if (time < duration) {
				window.requestAnimationFrame(step);
			}
		}
		window.requestAnimationFrame(step);
	};

	if (goTopBtn) {
		// Show the button when scrolling down.
		window.addEventListener('scroll', function () {
			var scrolled = window.scrollY;
			var coords = goTopBtn.getAttribute('data-start-scroll') || 200;

			if (scrolled > coords) {
				goTopBtn.classList.add('is-scroll-button-visible');
			}

			if (scrolled < coords) {
				goTopBtn.classList.remove('is-scroll-button-visible');
			}
		});

		// Scroll back to top when clicked.
		goTopBtn.addEventListener('click', function (e) {
			e.preventDefault();
			if (supportsNativeSmoothScroll) {
				nativeSmoothScroll();
			} else {
				smoothScroll(goTopBtn.getAttribute('data-scroll-speed') || 400);
			}
		}, false);
	}

})();