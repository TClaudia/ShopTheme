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
        initNewsletterForm();
        initScrollToTop();
        initHeaderScroll();
        initAnimations();
    });

    // Mobile Menu Toggle
    function initMobileMenu() {
        $('.mobile-menu-toggle').on('click', function(e) {
            e.preventDefault();
            
            $('.nav-menu').toggleClass('active');
            $(this).toggleClass('active');
            $('body').toggleClass('menu-open');
            
            // Animate hamburger icon
            $(this).find('i').toggleClass('fa-bars fa-times');
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation, .mobile-menu-toggle').length) {
                $('.nav-menu').removeClass('active');
                $('.mobile-menu-toggle').removeClass('active');
                $('body').removeClass('menu-open');
                $('.mobile-menu-toggle i').removeClass('fa-times').addClass('fa-bars');
            }
        });

        // Close menu when clicking on menu link
        $('.nav-menu a').on('click', function() {
            if ($(window).width() <= 768) {
                $('.nav-menu').removeClass('active');
                $('.mobile-menu-toggle').removeClass('active');
                $('body').removeClass('menu-open');
                $('.mobile-menu-toggle i').removeClass('fa-times').addClass('fa-bars');
            }
        });

        // Handle window resize
        $(window).on('resize', function() {
            if ($(window).width() > 768) {
                $('.nav-menu').removeClass('active');
                $('.mobile-menu-toggle').removeClass('active');
                $('body').removeClass('menu-open');
                $('.mobile-menu-toggle i').removeClass('fa-times').addClass('fa-bars');
            }
        });
    }

    // Search Toggle
    function initSearchToggle() {
        $('.search-toggle').on('click', function(e) {
            e.preventDefault();
            
            $('.search-form-container').slideToggle(300);
            $('.search-form-container input[type="search"]').focus();
            $(this).toggleClass('active');
        });

        // Close search when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-form-container, .search-toggle').length) {
                $('.search-form-container').slideUp(300);
                $('.search-toggle').removeClass('active');
            }
        });

        // Close search on escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                $('.search-form-container').slideUp(300);
                $('.search-toggle').removeClass('active');
            }
        });
    }

    // Smooth Scroll
    function initSmoothScroll() {
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    e.preventDefault();
                    
                    const offset = $('.site-header').outerHeight() || 80;
                    
                    $('html, body').animate({
                        scrollTop: target.offset().top - offset
                    }, 1000, 'easeInOutCubic');
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
                            img.classList.add('loaded');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px 50px 0px'
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
                
                // Animate cart icon
                $('.cart-toggle').addClass('cart-updated');
                setTimeout(() => {
                    $('.cart-toggle').removeClass('cart-updated');
                }, 1000);
                
                showNotification('Product added to cart!', 'success');
            });
        }
    }

    // Product Filters
    function initProductFilters() {
        // Price range filter
        $('.price-filter input[type="range"]').on('input', function() {
            const minPrice = $('#min-price').val();
            const maxPrice = $('#max-price').val();
            $('.price-display').text(' + minPrice + ' -  + maxPrice);
            
            // Trigger filter update
            filterProducts();
        });

        // Category filter
        $('.category-filter input[type="checkbox"]').on('change', function() {
            filterProducts();
        });

        // Sort filter
        $('.sort-filter select').on('change', function() {
            filterProducts();
        });

        function filterProducts() {
            const categories = [];
            $('.category-filter input[type="checkbox"]:checked').each(function() {
                categories.push($(this).val());
            });

            const minPrice = $('#min-price').val() || 0;
            const maxPrice = $('#max-price').val() || 999999;
            const sortBy = $('.sort-filter select').val() || 'date';

            // Show loading state
            $('.products-grid').addClass('loading');

            $.ajax({
                url: coffeeshop_ajax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'filter_products',
                    categories: categories,
                    min_price: minPrice,
                    max_price: maxPrice,
                    sort_by: sortBy,
                    nonce: coffeeshop_ajax.nonce
                },
                success: function(response) {
                    $('.products-grid').html(response).removeClass('loading');
                    
                    // Reinitialize animations for new content
                    initScrollAnimations();
                },
                error: function() {
                    showNotification('Error filtering products. Please try again.', 'error');
                    $('.products-grid').removeClass('loading');
                }
            });
        }
    }

    // Gallery Lightbox
    function initGallery() {
        // Create lightbox if it doesn't exist
        if (!$('#gallery-lightbox').length) {
            const lightbox = $('<div id="gallery-lightbox" class="gallery-lightbox"><span class="gallery-close">&times;</span><img class="gallery-modal-content" id="gallery-modal-img"><div class="gallery-nav"><button class="gallery-prev">&#10094;</button><button class="gallery-next">&#10095;</button></div></div>');
            $('body').append(lightbox);
        }
        
        const lightbox = $('#gallery-lightbox');
        const lightboxImg = $('#gallery-modal-img');
        let currentImageIndex = 0;
        let galleryImages = [];

        // Collect gallery images
        $('.gallery-item').each(function(index) {
            const imgSrc = $(this).find('img').attr('src');
            const imgAlt = $(this).find('img').attr('alt') || '';
            
            if (imgSrc) {
                galleryImages.push({
                    src: imgSrc,
                    alt: imgAlt
                });
                
                $(this).attr('data-index', index).on('click', function() {
                    currentImageIndex = index;
                    lightboxImg.attr('src', galleryImages[currentImageIndex].src)
                              .attr('alt', galleryImages[currentImageIndex].alt);
                    lightbox.addClass('active');
                    $('body').addClass('lightbox-open');
                });
            }
        });

        // Close lightbox
        $('.gallery-close').on('click', function() {
            closeLightbox();
        });

        // Navigation
        $('.gallery-prev').on('click', function(e) {
            e.stopPropagation();
            currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
            updateLightboxImage();
        });

        $('.gallery-next').on('click', function(e) {
            e.stopPropagation();
            currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
            updateLightboxImage();
        });

        // Keyboard navigation
        $(document).on('keydown', function(e) {
            if (lightbox.hasClass('active')) {
                if (e.key === 'Escape') {
                    closeLightbox();
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
                closeLightbox();
            }
        });

        function updateLightboxImage() {
            if (galleryImages[currentImageIndex]) {
                lightboxImg.attr('src', galleryImages[currentImageIndex].src)
                          .attr('alt', galleryImages[currentImageIndex].alt);
            }
        }

        function closeLightbox() {
            lightbox.removeClass('active');
            $('body').removeClass('lightbox-open');
        }
    }

    // Booking Form
    function initBookingForm() {
        $('#booking-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const $form = $(form);
            const submitButton = $form.find('button[type="submit"]');
            const originalText = submitButton.text();
            
            // Validate form
            if (!validateBookingForm($form)) {
                return;
            }
            
            submitButton.text('Booking...').prop('disabled', true).addClass('loading');
            
            const formData = new FormData(form);
            formData.append('action', 'process_booking');
            formData.append('nonce', coffeeshop_ajax.nonce);
            
            $.ajax({
                url: coffeeshop_ajax.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showNotification(response.data.message, 'success');
                        form.reset();
                        $form.addClass('form-success');
                        
                        setTimeout(() => {
                            $form.removeClass('form-success');
                        }, 3000);
                    } else {
                        showNotification(response.data.message, 'error');
                    }
                },
                error: function() {
                    showNotification('An error occurred. Please try again.', 'error');
                },
                complete: function() {
                    submitButton.text(originalText).prop('disabled', false).removeClass('loading');
                }
            });
        });
    }

    // Contact Form
    function initContactForm() {
        $('#contact-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const $form = $(form);
            const submitButton = $form.find('button[type="submit"]');
            const originalText = submitButton.text();
            
            // Validate form
            if (!validateContactForm($form)) {
                return;
            }
            
            submitButton.text('Sending...').prop('disabled', true).addClass('loading');
            
            const formData = new FormData(form);
            formData.append('action', 'process_contact');
            formData.append('nonce', coffeeshop_ajax.nonce);
            
            $.ajax({
                url: coffeeshop_ajax.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showNotification(response.data.message, 'success');
                        form.reset();
                    } else {
                        showNotification(response.data.message, 'error');
                    }
                },
                error: function() {
                    showNotification('An error occurred. Please try again.', 'error');
                },
                complete: function() {
                    submitButton.text(originalText).prop('disabled', false).removeClass('loading');
                }
            });
        });
    }

    // Newsletter Form
    function initNewsletterForm() {
        $('.newsletter-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const $form = $(form);
            const submitButton = $form.find('button[type="submit"]');
            const originalText = submitButton.text();
            const email = $form.find('input[type="email"]').val();
            
            if (!email || !isValidEmail(email)) {
                showNotification('Please enter a valid email address.', 'error');
                return;
            }
            
            submitButton.text('Subscribing...').prop('disabled', true).addClass('loading');
            
            $.ajax({
                url: coffeeshop_ajax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'newsletter_signup',
                    email: email,
                    nonce: coffeeshop_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showNotification(response.data.message, 'success');
                        form.reset();
                    } else {
                        showNotification(response.data.message, 'error');
                    }
                },
                error: function() {
                    showNotification('An error occurred. Please try again.', 'error');
                },
                complete: function() {
                    submitButton.text(originalText).prop('disabled', false).removeClass('loading');
                }
            });
        });
    }

    // FAQ
    function initFAQ() {
        $('.faq-question').on('click', function() {
            const $question = $(this);
            const $answer = $question.next('.faq-answer');
            const isExpanded = $question.attr('aria-expanded') === 'true';
            
            // Close all other FAQs
            $('.faq-question').not($question).attr('aria-expanded', 'false');
            $('.faq-answer').not($answer).removeClass('open').slideUp(300);
            
            // Toggle current FAQ
            $question.attr('aria-expanded', !isExpanded);
            if (isExpanded) {
                $answer.removeClass('open').slideUp(300);
            } else {
                $answer.addClass('open').slideDown(300);
            }
        });

        // FAQ search
        $('#faq-search-input').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            
            $('.faq-item').each(function() {
                const $item = $(this);
                const questionText = $item.find('.faq-question').text().toLowerCase();
                const answerText = $item.find('.faq-answer').text().toLowerCase();
                
                if (questionText.includes(searchTerm) || answerText.includes(searchTerm)) {
                    $item.show();
                } else {
                    $item.hide();
                }
            });
        });
    }

    // Scroll Effects
    function initScrollEffects() {
        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            
            // Parallax effect for hero section
            if ($('.hero-section').length) {
                $('.hero-section').css('transform', `translateY(${scrollTop * 0.5}px)`);
            }
            
            // Fade in elements on scroll
            $('.fade-in-scroll').each(function() {
                const $element = $(this);
                const elementTop = $element.offset().top;
                const windowBottom = scrollTop + $(window).height();
                
                if (elementTop < windowBottom - 100) {
                    $element.addClass('visible');
                }
            });
            
            // Header scroll effect
            if (scrollTop > 100) {
                $('.site-header').addClass('scrolled');
            } else {
                $('.site-header').removeClass('scrolled');
            }
        });
    }

    // Parallax
    function initParallax() {
        if ($(window).width() > 768) {
            $(window).on('scroll', function() {
                const scrolled = $(window).scrollTop();
                const parallaxElements = $('.parallax-bg');
                
                parallaxElements.each(function() {
                    const $element = $(this);
                    const speed = $element.data('speed') || 0.5;
                    const yPos = -(scrolled * speed);
                    $element.css('transform', `translateY(${yPos}px)`);
                });
            });
        }
    }

    // Preloader
    function initPreloader() {
        if ($('.preloader').length) {
            $(window).on('load', function() {
                $('.preloader').fadeOut(500, function() {
                    $(this).remove();
                });
            });
        }
    }

    // Scroll to Top
    function initScrollToTop() {
        const $scrollBtn = $('#scroll-to-top');
        
        if ($scrollBtn.length) {
            $(window).on('scroll', function() {
                if ($(this).scrollTop() > 300) {
                    $scrollBtn.addClass('show');
                } else {
                    $scrollBtn.removeClass('show');
                }
            });
            
            $scrollBtn.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, 800);
            });
        }
    }

    // Header Scroll
    function initHeaderScroll() {
        let lastScrollTop = 0;
        const $header = $('.site-header');
        
        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();
            
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                $header.addClass('header-hidden');
            } else {
                // Scrolling up
                $header.removeClass('header-hidden');
            }
            
            lastScrollTop = scrollTop;
        });
    }

    // Animations
    function initAnimations() {
        // Counter animation
        $('.stat-number').each(function() {
            const $counter = $(this);
            const target = parseInt($counter.text().replace(/[^\d]/g, ''));
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter($counter, target);
                        observer.unobserve(entry.target);
                    }
                });
            });
            
            observer.observe($counter[0]);
        });
        
        // Scroll animations
        initScrollAnimations();
    }

    // Initialize scroll animations
    function initScrollAnimations() {
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            // Observe elements with animation classes
            document.querySelectorAll('.animate-on-scroll, .menu-item, .product-card, .blog-card, .testimonial-card, .stat-item').forEach(el => {
                observer.observe(el);
            });
        }
    }

    // Helper Functions
    function validateBookingForm($form) {
        let isValid = true;
        const requiredFields = $form.find('[required]');
        
        requiredFields.each(function() {
            const $field = $(this);
            const value = $field.val().trim();
            
            $field.removeClass('error');
            
            if (!value) {
                $field.addClass('error');
                isValid = false;
            } else if ($field.attr('type') === 'email' && !isValidEmail(value)) {
                $field.addClass('error');
                isValid = false;
            } else if ($field.attr('type') === 'date') {
                const selectedDate = new Date(value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                if (selectedDate < today) {
                    $field.addClass('error');
                    isValid = false;
                }
            }
        });
        
        if (!isValid) {
            showNotification('Please fill in all required fields correctly.', 'error');
        }
        
        return isValid;
    }

    function validateContactForm($form) {
        let isValid = true;
        const requiredFields = $form.find('[required]');
        
        requiredFields.each(function() {
            const $field = $(this);
            const value = $field.val().trim();
            
            $field.removeClass('error');
            
            if (!value) {
                $field.addClass('error');
                isValid = false;
            } else if ($field.attr('type') === 'email' && !isValidEmail(value)) {
                $field.addClass('error');
                isValid = false;
            }
        });
        
        if (!isValid) {
            showNotification('Please fill in all required fields correctly.', 'error');
        }
        
        return isValid;
    }

    function isValidEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    function animateCounter($element, target) {
        const duration = 2000;
        const start = 0;
        const startTime = performance.now();
        
        function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            const current = Math.floor(progress * target);
            $element.text(current);
            
            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                $element.text(target);
            }
        }
        
        requestAnimationFrame(updateCounter);
    }

    function showNotification(message, type = 'info') {
        // Remove existing notifications
        $('.notification').fadeOut(300, function() {
            $(this).remove();
        });
        
        const $notification = $(`<div class="notification ${type}">${message}</div>`);
        $('body').append($notification);
        
        $notification.fadeIn(300);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            $notification.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
        
        // Click to close
        $notification.on('click', function() {
            $(this).fadeOut(300, function() {
                $(this).remove();
            });
        });
    }

    // Touch/swipe support for mobile
    function initTouchSupport() {
        let startX = 0;
        let startY = 0;
        
        $(document).on('touchstart', function(e) {
            startX = e.originalEvent.touches[0].clientX;
            startY = e.originalEvent.touches[0].clientY;
        });
        
        $(document).on('touchend', function(e) {
            if (!startX || !startY) return;
            
            const endX = e.originalEvent.changedTouches[0].clientX;
            const endY = e.originalEvent.changedTouches[0].clientY;
            
            const diffX = startX - endX;
            const diffY = startY - endY;
            
            // Only handle horizontal swipes that are longer than vertical
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
                if ($('.gallery-lightbox').hasClass('active')) {
                    if (diffX > 0) {
                        $('.gallery-next').click();
                    } else {
                        $('.gallery-prev').click();
                    }
                }
            }
            
            startX = startY = 0;
        });
    }

    // Initialize touch support
    initTouchSupport();

    // Performance optimization: debounce scroll events
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Apply debouncing to scroll events
    $(window).on('scroll', debounce(function() {
        // Debounced scroll events go here
    }, 16)); // ~60fps

})(jQuery);