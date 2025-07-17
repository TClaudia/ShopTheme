(function($) {
    'use strict';

    // DOM Ready
    $(document).ready(function() {
        initMobileMenu();
        initSearchToggle();
        initSmoothScroll();
        initLazyLoading();
        initCartUpdates();
        initProductFilters();
        initGallery();
        initBookingForm();
        initContactForm();
        initFAQ();
        initScrollEffects();
        initParallax();
        initPreloader();
    });

    // Mobile Menu Toggle
    function initMobileMenu() {
        $('.mobile-menu-toggle').on('click', function() {
            $('.nav-menu').toggleClass('active');
            $(this).toggleClass('active');
            $('body').toggleClass('menu-open');
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation, .mobile-menu-toggle').length) {
                $('.nav-menu').removeClass('active');
                $('.mobile-menu-toggle').removeClass('active');
                $('body').removeClass('menu-open');
            }
        });

        $(window).on('resize', function() {
            if ($(window).width() > 768) {
                $('.nav-menu').removeClass('active');
                $('.mobile-menu-toggle').removeClass('active');
                $('body').removeClass('menu-open');
            }
        });
    }

    // Search Toggle
    function initSearchToggle() {
        $('.search-toggle').on('click', function() {
            $('.search-form-container').slideToggle();
            $('.search-form-container input[type="search"]').focus();
        });

        // Close search when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-form-container, .search-toggle').length) {
                $('.search-form-container').slideUp();
            }
        });
    }

    // Smooth Scroll
    function initSmoothScroll() {
        $('a[href*="#"]:not([href="#"])').on('click', function() {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 1000);
                    return false;
                }
            }
        });
    }

    // Lazy Loading
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy-loading');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                img.classList.add('lazy-loading');
                imageObserver.observe(img);
            });
        }
    }

    // Cart Updates
    function initCartUpdates() {
        if (typeof wc_add_to_cart_params !== 'undefined') {
            $(document.body).on('added_to_cart', function(event, fragments, cart_hash) {
                if (fragments && fragments['span.cart-count']) {
                    $('span.cart-count').replaceWith(fragments['span.cart-count']);
                }
                showNotification('Product added to cart!', 'success');
            });
        }
    }

    // Product Filters
    function initProductFilters() {
        $('.price-filter input[type="range"]').on('input', function() {
            const minPrice = $('#min-price').val();
            const maxPrice = $('#max-price').val();
            $('.price-display').text('$' + minPrice + ' - $' + maxPrice);
        });

        $('.category-filter input[type="checkbox"]').on('change', function() {
            filterProducts();
        });

        $('.sort-filter select').on('change', function() {
            filterProducts();
        });
    }

    // Gallery Lightbox
    function initGallery() {
        const lightbox = $('<div id="gallery-lightbox" class="gallery-lightbox"><span class="gallery-close">&times;</span><img class="gallery-modal-content" id="gallery-modal-img"><div class="gallery-nav"><button class="gallery-prev">&#10094;</button><button class="gallery-next">&#10095;</button></div></div>');
        $('body').append(lightbox);
        
        const lightboxImg = $('#gallery-modal-img');
        let currentImageIndex = 0;
        let galleryImages = [];

        $('.gallery-item').each(function(index) {
            const imgSrc = $(this).find('img').attr('src');
            galleryImages.push(imgSrc);
            
            $(this).on('click', function() {
                currentImageIndex = index;
                lightboxImg.attr('src', galleryImages[currentImageIndex]);
                lightbox.addClass('active');
                $('body').addClass('lightbox-open');
            });
        });

        $('.gallery-close').on('click', function() {
            lightbox.removeClass('active');
            $('body').removeClass('lightbox-open');
        });

        $('.gallery-prev').on('click', function() {
            currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
            lightboxImg.attr('src', galleryImages[currentImageIndex]);
        });

        $('.gallery-next').on('click', function() {
            currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
            lightboxImg.attr('src', galleryImages[currentImageIndex]);
        });

        $(document).on('keydown', function(e) {
            if (lightbox.hasClass('active')) {
                if (e.key === 'Escape') {
                    lightbox.removeClass('active');
                    $('body').removeClass('lightbox-open');
                } else if (e.key === 'ArrowLeft') {
                    $('.gallery-prev').click();
                } else if (e.key === 'ArrowRight') {
                    $('.gallery-next').click();
                }
            }
        });

        // Close lightbox when clicking outside image
        lightbox.on('click', function(e) {
            if (e.target === this) {
                lightbox.removeClass('active');
                $('body').removeClass('lightbox-open');
            }
        });
    }

    // Booking Form
    function initBookingForm() {
        $('#booking-form').on('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = $(this).find('button[type="submit"]');
            const originalText = submitButton.text();
            
            // Validate form
            if (!validateBookingForm(this)) {
                return;
            }
            
            submitButton.text('Booking...').prop('disabled', true);