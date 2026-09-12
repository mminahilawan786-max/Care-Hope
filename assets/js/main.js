'use strict';

const navigationToggle = document.querySelector('.nav-toggle');
const primaryNavigation = document.querySelector('.primary-nav');

if (navigationToggle && primaryNavigation) {
    navigationToggle.addEventListener('click', () => {
        const isOpen = navigationToggle.getAttribute('aria-expanded') === 'true';
        navigationToggle.setAttribute('aria-expanded', String(!isOpen));
        primaryNavigation.classList.toggle('is-open', !isOpen);
        document.body.classList.toggle('menu-open', !isOpen);
    });

    primaryNavigation.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            navigationToggle.setAttribute('aria-expanded', 'false');
            primaryNavigation.classList.remove('is-open');
            document.body.classList.remove('menu-open');
        });
    });
}
