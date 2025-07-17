/**
 * Elementor Widgets JavaScript
 *
 * @package CoffeeShop
 */

(function($) {
    'use strict';

    // Initialize when Elementor frontend is ready
    $(window).on('elementor/frontend/init', function() {
        initCoffeeShopWidgets();
    });

    // Also initialize for regular page loads
    $(document).ready(function() {
        initCoffeeShopWidgets();
    });

    /**
     * Initialize all CoffeeShop widgets
     */
    function initCoffeeShopWidgets() {
        initBookingForm();
        initContactForm();
        initNewsletterForm();
        initGalleryWidget();
        initMenuWidget();
        initTestimonialsWidget();
        initTeamWidget();
        initProductsWidget();
    }

    /**
     * Initialize Booking Form Widget
     */
    function initBookingForm() {
        $(document).on('submit', '.booking-form', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('.booking-submit-btn');
            const originalText = $submitBtn.text();
            
            // Show loading state
            $submitBtn.text('Booking...').prop('disabled', true);
            
            // Prepare form data
            const formData = new FormData(this);
            formData.append('action', 'coffeeshop_elementor_booking');
            formData.append('nonce', coffeeshop_elementor_ajax.nonce);
            
            // Submit form
            $.ajax({
                url: coffeeshop_elementor_ajax.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showNotification(response.data.message, 'success');
                        $form[0].reset();
                    } else {
                        showNotification(response.data.message, 'error');
                    }
                },
                error: function() {
                    showNotification('An error occurred. Please try again.', 'error');
                },
                complete: function() {
                    $submitBtn.text(originalText).prop('disabled', false);
                }
            });
        });
    }

    /**
     * Initialize Contact Form Widget
     */
    function initContactForm() {
        $(document).on('submit', '.contact-form', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('.contact-submit-btn, [type="submit"]');
            const originalText = $submitBtn.text();
            
            // Show loading state
            $submitBtn.text('Sending...').prop('disabled', true);
            
            // Prepare form data
            const formData = new FormData(this);
            formData.append('action', 'coffeeshop_elementor_contact');
            formData.append('nonce', coffeeshop_elementor_ajax.nonce);
            
            // Submit form
            $.ajax({
                url: coffeeshop_elementor_ajax.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showNotification(response.data.message, 'success');
                        $form[0].reset();
                    } else {
                        showNotification(response.data.message, 'error');
                    }
                },
                error: function() {
                    showNotification('An error occurred. Please try again.', 'error');
                },
                complete: function() {
                    $submitBtn.text(originalText).prop('disabled', false);
                }
            });
        });
    }

    /**
     * Initialize Newsletter Form Widget
     */
    function initNewsletterForm() {
        $(document).on('submit', '.newsletter-form', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('.newsletter-submit-btn, [type="submit"]');
            const originalText = $submitBtn.text();
            
            // Show loading state
            $submitBtn.text('Subscribing...').prop('disabled', true);
            
            // Prepare form data
            const formData = new FormData(this);
            formData.append('action', 'coffeeshop_elementor_newsletter');
            formData.append('nonce', coffeeshop_elementor_ajax.nonce);
            
            // Submit form
            $.ajax({
                url: coffeeshop_elementor_ajax.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showNotification(response.data.message, 'success');
                        $form[0].reset();
                    } else {
                        showNotification(response.data.message, 'error');
                    }
                },
                error: function() {
                    showNotification('An error occurred. Please try again.', 'error');
                },
                complete: function() {
                    $submitBtn.text(originalText).prop('disabled', false);
                }
            });
        });
    }

    /**
     * Initialize Gallery Widget
     */
    function initGalleryWidget() {
        // Lightbox functionality
        const $lightbox = $('<div class="gallery-lightbox"><span class="gallery-close">&times;</span><img class="gallery-modal-content"><div class="gallery-nav"><button class="gallery-prev">&#10094;</button><button class="gallery-next">&#10095;</button></div></div>');
        $('body').append($lightbox);
        
        let currentImageIndex = 0;
        let galleryImages = [];

        // Open lightbox
        $(document).on('click', '.gallery-item', function() {
            const $gallery = $(this).closest('.gallery-widget');
            galleryImages = [];
            
            $gallery.find('.gallery-item img').each(function() {
                galleryImages.push($(this).attr('src'));
            });
            
            currentImageIndex = $(this).index();
            showLightboxImage(galleryImages[currentImageIndex]);
            $lightbox.addClass('active');
            $('body').addClass('lightbox-open');
        });

        // Close lightbox
        $(document).on('click', '.gallery-close', function() {
            closeLightbox();
        });

        // Navigation
        $(document).on('click', '.gallery-prev', function() {
            currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
            showLightboxImage(galleryImages[currentImageIndex]);
        });

        $(document).on('click', '.gallery-next', function() {
            currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
            showLightboxImage(galleryImages[currentImageIndex]);
        });

        // Keyboard navigation
        $(document).on('keydown', function(e) {
            if ($lightbox.hasClass('active')) {
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    $('.gallery-prev').click();
                } else if (e.key === 'ArrowRight') {
                    $('.gallery-next').click();
                }
            }
        });

        // Close on background click
        $lightbox.on('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        function showLightboxImage(src) {
            $lightbox.find('.gallery-modal-content').attr('src', src);
        }

        function closeLightbox() {
            $lightbox.removeClass('active');
            $('body').removeClass('lightbox-open');
        }
    }

    /**
     * Initialize Menu Widget
     */
    function initMenuWidget() {
        // Masonry layout for menu items
        $('.coffee-menu-masonry').each(function() {
            const $container = $(this);
            
            // Initialize masonry
            if (typeof $.fn.masonry !== 'undefined') {
                $container.masonry({
                    itemSelector: '.menu-item',
                    columnWidth: '.menu-item',
                    gutter: 20,
                    percentPosition: true
                });
            }
        });

        // Menu item hover effects
        $('.menu-item').hover(
            function() {
                $(this).find('.menu-item-image img').css('transform', 'scale(1.05)');
            },
            function() {
                $(this).find('.menu-item-image img').css('transform', 'scale(1)');
            }
        );

        // Featured item animation
        $('.menu-item.featured-item').each(function() {
            const $item = $(this);
            const $badge = $item.find('::before');
            
            // Pulse animation for featured badge
            setInterval(function() {
                $item.addClass('pulse-badge');
                setTimeout(() => $item.removeClass('pulse-badge'), 1000);
            }, 3000);
        });
    }

    /**
     * Initialize Testimonials Widget
     */
    function initTestimonialsWidget() {
        // Auto-rotate testimonials if only one column
        $('.testimonials-widget').each(function() {
            const $widget = $(this);
            const $grid = $widget.find('.testimonials-grid');
            const $items = $grid.find('.testimonial-card');
            
            if ($items.length > 1 && $grid.css('grid-template-columns').includes('1fr')) {
                let currentIndex = 0;
                
                // Hide all except first
                $items.hide().first().show();
                
                // Auto-rotate every 5 seconds
                setInterval(function() {
                    $items.eq(currentIndex).fadeOut(300);
                    currentIndex = (currentIndex + 1) % $items.length;
                    $items.eq(currentIndex).fadeIn(300);
                }, 5000);
            }
        });

        // Star rating animation
        $('.testimonial-rating .star').each(function(index) {
            const $star = $(this);
            setTimeout(() => {
                $star.addClass('animate-star');
            }, index * 100);
        });
    }

    /**
     * Initialize Team Widget
     */
    function initTeamWidget() {
        // Social links hover effect
        $('.member-social a').hover(
            function() {
                $(this).css('transform', 'translateY(-2px) scale(1.1)');
            },
            function() {
                $(this).css('transform', 'translateY(0) scale(1)');
            }
        );

        // Member card flip effect on mobile
        if (window.innerWidth <= 768) {
            $('.barista-member').on('click', function() {
                const $member = $(this);
                const $info = $member.find('.member-info');
                
                if ($info.hasClass('flipped')) {
                    $info.removeClass('flipped');
                } else {
                    $('.member-info').removeClass('flipped');
                    $info.addClass('flipped');
                }
            });
        }
    }

    /**
     * Initialize Products Widget
     */
    function initProductsWidget() {
        // Add to cart animation
        $(document).on('click', '.featured-product-button', function(e) {
            e.preventDefault();
            
            const $button = $(this);
            const originalText = $button.text();
            
            // Animate button
            $button.text('Added!').addClass('added');
            
            // Reset after 2 seconds
            setTimeout(() => {
                $button.text(originalText).removeClass('added');
            }, 2000);
            
            // Create floating animation
            const $cart = $('.cart-toggle, .header-cart');
            if ($cart.length) {
                const $floatingItem = $('<div class="floating-cart-item">+1</div>');
                $('body').append($floatingItem);
                
                const buttonOffset = $button.offset();
                const cartOffset = $cart.offset();
                
                $floatingItem.css({
                    position: 'absolute',