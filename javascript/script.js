/**
 * Front-end JavaScript
 */

const menuToggle = document.querySelector('.menu-toggle');
const primaryNavigation = document.querySelector('.primary-navigation');
const primaryMenu = document.getElementById('primary-menu');

if (menuToggle && primaryNavigation && primaryMenu) {
	const menuLinks = primaryMenu.querySelectorAll('a');

	const closeMenu = () => {
		menuToggle.setAttribute('aria-expanded', 'false');
		menuToggle.setAttribute('aria-label', 'Open menu');
		primaryNavigation.classList.remove('is-open');
		document.body.classList.remove('mobile-menu-open');
	};

	const openMenu = () => {
		menuToggle.setAttribute('aria-expanded', 'true');
		menuToggle.setAttribute('aria-label', 'Close menu');
		primaryNavigation.classList.add('is-open');
		document.body.classList.add('mobile-menu-open');
	};

	menuToggle.addEventListener('click', () => {
		const isOpen = menuToggle.getAttribute('aria-expanded') === 'true';

		if (isOpen) {
			closeMenu();
		} else {
			openMenu();
		}
	});

	menuLinks.forEach((link) => {
		link.addEventListener('click', () => {
			if (window.matchMedia('(max-width: 1139px)').matches) {
				closeMenu();
			}
		});
	});

	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape' && menuToggle.getAttribute('aria-expanded') === 'true') {
			closeMenu();
			menuToggle.focus();
		}
	});

	window.addEventListener('resize', () => {
		if (window.matchMedia('(min-width: 1140px)').matches) {
			closeMenu();
		}
	});
}
