(function() {
    'use strict';

    // Mobile menu functionality
    const menuToggle = document.querySelector('.menu-toggle');
    const primaryMenu = document.querySelector('.primary-menu');

    if (menuToggle && primaryMenu) {
        menuToggle.addEventListener('click', function() {
            const expanded = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', !expanded);
            primaryMenu.classList.toggle('active');
            document.body.classList.toggle('menu-open');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!menuToggle.contains(e.target) && !primaryMenu.contains(e.target)) {
                menuToggle.setAttribute('aria-expanded', 'false');
                primaryMenu.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        });
    }

    // Dropdown menu accessibility
    const menuItems = document.querySelectorAll('.primary-menu .menu-item-has-children > a');
    
    menuItems.forEach(function(menuItem) {
        menuItem.addEventListener('click', function(e) {
            const submenu = this.nextElementSibling;
            if (submenu && window.innerWidth < 768) {
                e.preventDefault();
                submenu.classList.toggle('open');
                this.setAttribute('aria-expanded', submenu.classList.contains('open'));
            }
        });
    });

})();