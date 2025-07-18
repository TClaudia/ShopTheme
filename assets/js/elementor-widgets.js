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
        initOpeningHours();
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
            
            // Validate form
            if (!validateBookingForm($form)) {
                return;
            }
            
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
     * Validate booking form
     */
    function validateBookingForm($form) {
        let isValid = true;
        
        // Check required fields
        $form.find('[required]').each(function() {
            const $field = $(this);
            if (!$field.val().trim()) {
                showFieldError($field, 'This field is required');
                isValid = false;
            } else {
                clearFieldError($field);
            }
        });
        
        // Validate email
        const $email = $form.find('input[type="email"]');
        if ($email.length && $email.val()) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test($email.val())) {
                showFieldError($email, 'Please enter a valid email address');
                isValid = false;
            }
        }
        
        // Validate date (must be in future)
        const $date = $form.find('input[type="date"]');
        if ($date.length && $date.val()) {
            const selectedDate = new Date($date.val());
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                showFieldError($date, 'Please select a future date');
                isValid = false;
            }
        }
        
        return isValid;
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
        // Create lightbox if it doesn't exist
        if (!$('.gallery-lightbox').length) {
            const $lightbox = $('<div class="gallery-lightbox"><span class="gallery-close">&times;</span><img class="gallery-modal-content"><div class="gallery-nav"><button class="gallery-prev">&#10094;</button><button class="gallery-next">&#10095;</button></div></div>');
            $('body').append($lightbox);
        }
        
        const $lightbox = $('.gallery-lightbox');
        let currentImageIndex = 0;
        let galleryImages = [];

        // Open lightbox
        $(document).on('click', '.gallery-item', function() {
            const $gallery = $(this).closest('.gallery-widget');
            galleryImages = [];
            
            $gallery.find('.gallery-item img').each(function() {
                galleryImages.push({
                    src: $(this).attr('src'),
                    alt: $(this).attr('alt') || ''
                });
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
            if (galleryImages.length > 1) {
                currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
                showLightboxImage(galleryImages[currentImageIndex]);
            }
        });

        $(document).on('click', '.gallery-next', function() {
            if (galleryImages.length > 1) {
                currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
                showLightboxImage(galleryImages[currentImageIndex]);
            }
        });

        // Keyboard navigation
        $(document).on('keydown', function(e) {
            if ($lightbox.hasClass('active')) {
                switch(e.key) {
                    case 'Escape':
                        closeLightbox();
                        break;
                    case 'ArrowLeft':
                        $('.gallery-prev').click();
                        break;
                    case 'ArrowRight':
                        $('.gallery-next').click();
                        break;
                }
            }
        });

        // Close on background click
        $lightbox.on('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        function showLightboxImage(image) {
            $lightbox.find('.gallery-modal-content').attr('src', image.src).attr('alt', image.alt);
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
        // Menu item hover effects
        $('.menu-item').hover(
            function() {
                $(this).find('.menu-item-image img').css('transform', 'scale(1.05)');
            },
            function() {
                $(this).find('.menu-item-image img').css('transform', 'scale(1)');
            }
        );

        // Featured item pulse animation
        $('.menu-item.featured-item').each(function() {
            const $item = $(this);
            
            // Add pulse animation class periodically
            setInterval(function() {
                $item.addClass('pulse-animation');
                setTimeout(() => $item.removeClass('pulse-animation'), 1000);
            }, 5000);
        });

        // Menu category filtering (if filters exist)
        $('.menu-filter-btn').on('click', function() {
            const $btn = $(this);
            const filter = $btn.data('filter');
            const $menuItems = $('.menu-item');
            
            // Update active button
            $('.menu-filter-btn').removeClass('active');
            $btn.addClass('active');
            
            // Filter items
            if (filter === 'all') {
                $menuItems.show();
            } else {
                $menuItems.hide();
                $(`.menu-item[data-category="${filter}"]`).show();
            }
        });
    }

    /**
     * Initialize Testimonials Widget
     */
    function initTestimonialsWidget() {
        // Star rating animation on scroll
        $('.testimonial-rating').each(function() {
            const $rating = $(this);
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateStars($rating);
                        observer.unobserve(entry.target);
                    }
                });
            });
            observer.observe(this);
        });

        function animateStars($rating) {
            $rating.find('.star').each(function(index) {
                const $star = $(this);
                setTimeout(() => {
                    $star.addClass('animate-star');
                }, index * 100);
            });
        }

        // Auto-play testimonials slider (if single column)
        $('.testimonials-widget').each(function() {
            const $widget = $(this);
            const $items = $widget.find('.testimonial-card');
            
            if ($items.length > 1 && window.innerWidth <= 768) {
                let currentIndex = 0;
                
                // Hide all except first
                $items.hide().first().show();
                
                // Auto-rotate every 5 seconds
                const interval = setInterval(function() {
                    $items.eq(currentIndex).fadeOut(300, function() {
                        currentIndex = (currentIndex + 1) % $items.length;
                        $items.eq(currentIndex).fadeIn(300);
                    });
                }, 5000);
                
                // Stop auto-play on interaction
                $widget.on('click', function() {
                    clearInterval(interval);
                });
            }
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

        // Member card interaction on mobile
        if (window.innerWidth <= 768) {
            $('.barista-member').on('click', function() {
                const $member = $(this);
                const $bio = $member.find('.member-bio');
                
                if ($bio.length) {
                    $bio.slideToggle(300);
                }
            });
        }

        // Stagger animation for team members
        $('.barista-member').each(function(index) {
            const $member = $(this);
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            $member.addClass('animate-in');
                        }, index * 100);
                        observer.unobserve(entry.target);
                    }
                });
            });
            observer.observe(this);
        });
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
            
            // Create floating animation to cart
            const $cart = $('.cart-toggle, .header-cart');
            if ($cart.length) {
                createFloatingCartAnimation($button, $cart);
            }
            
            // Update cart count (if WooCommerce is active)
            updateCartCount();
        });

        function createFloatingCartAnimation($button, $cart) {
            const $floatingItem = $('<div class="floating-cart-item">+1</div>');
            $('body').append($floatingItem);
            
            const buttonOffset = $button.offset();
            const cartOffset = $cart.offset();
            
            $floatingItem.css({
                position: 'fixed',
                top: buttonOffset.top,
                left: buttonOffset.left,
                zIndex: 9999,
                background: '#28a745',
                color: 'white',
                padding: '5px 10px',
                borderRadius: '20px',
                fontSize: '12px',
                fontWeight: 'bold',
                pointerEvents: 'none'
            });
            
            // Animate to cart
            $floatingItem.animate({
                top: cartOffset.top,
                left: cartOffset.left,
                opacity: 0
            }, 1000, function() {
                $floatingItem.remove();
            });
        }

        function updateCartCount() {
            // This would integrate with WooCommerce cart fragments
            if (typeof wc_add_to_cart_params !== 'undefined') {
                $(document.body).trigger('wc_fragment_refresh');
            }
        }
    }

    /**
     * Initialize Opening Hours Widget
     */
    function initOpeningHours() {
        $('.opening-hours-widget').each(function() {
            const $widget = $(this);
            const today = new Date().getDay(); // 0 = Sunday, 1 = Monday, etc.
            
            // Highlight today's hours
            $widget.find('.opening-hours-item').each(function(index) {
                if (index === today) {
                    $(this).addClass('today');
                }
            });
            
            // Add current status (open/closed)
            updateOpenStatus($widget);
            
            // Update status every minute
            setInterval(() => updateOpenStatus($widget), 60000);
        });

        function updateOpenStatus($widget) {
            const now = new Date();
            const currentDay = now.getDay();
            const currentTime = now.getHours() * 60 + now.getMinutes();
            
            const $todayItem = $widget.find('.opening-hours-item').eq(currentDay);
            const timeText = $todayItem.find('.opening-hours-time').text();
            
            if (timeText.toLowerCase().includes('closed')) {
                addStatusIndicator($widget, 'closed', 'Closed');
            } else {
                // Parse opening hours (assuming format like "9:00 AM - 8:00 PM")
                const timeMatch = timeText.match(/(\d{1,2}):(\d{2})\s*(AM|PM)\s*-\s*(\d{1,2}):(\d{2})\s*(AM|PM)/i);
                
                if (timeMatch) {
                    const openTime = parseTime(timeMatch[1], timeMatch[2], timeMatch[3]);
                    const closeTime = parseTime(timeMatch[4], timeMatch[5], timeMatch[6]);
                    
                    if (currentTime >= openTime && currentTime < closeTime) {
                        addStatusIndicator($widget, 'open', 'Open Now');
                    } else {
                        addStatusIndicator($widget, 'closed', 'Closed');
                    }
                }
            }
        }

        function parseTime(hours, minutes, ampm) {
            let h = parseInt(hours);
            const m = parseInt(minutes);
            
            if (ampm.toUpperCase() === 'PM' && h !== 12) h += 12;
            if (ampm.toUpperCase() === 'AM' && h === 12) h = 0;
            
            return h * 60 + m;
        }

        function addStatusIndicator($widget, status, text) {
            let $indicator = $widget.find('.status-indicator');
            if (!$indicator.length) {
                $indicator = $('<div class="status-indicator"></div>');
                $widget.prepend($indicator);
            }
            
            $indicator
                .removeClass('open closed')
                .addClass(status)
                .text(text);
        }
    }

    /**
     * Show field error
     */
    function showFieldError($field, message) {
        clearFieldError($field);
        
        $field.addClass('error');
        const $error = $('<div class="field-error">' + message + '</div>');
        $field.parent().append($error);
    }

    /**
     * Clear field error
     */
    function clearFieldError($field) {
        $field.removeClass('error');
        $field.parent().find('.field-error').remove();
    }

    /**
     * Show notification
     */
    function showNotification(message, type = 'info') {
        const $notification = $('<div class="notification ' + type + '">' + message + '</div>');
        $('body').append($notification);
        
        // Show notification
        setTimeout(() => $notification.addClass('show'), 100);
        
        // Hide notification after 5 seconds
        setTimeout(() => {
            $notification.removeClass('show');
            setTimeout(() => $notification.remove(), 300);
        }, 5000);
        
        // Allow manual close
        $notification.on('click', function() {
            $(this).removeClass('show');
            setTimeout(() => $(this).remove(), 300);
        });
    }

    /**
     * Utility: Debounce function
     */
    function debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction() {
            const context = this;
            const args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    /**
     * Utility: Throttle function
     */
    function throttle(func, limit) {
        let lastFunc;
        let lastRan;
        return function() {
            const context = this;
            const args = arguments;
            if (!lastRan) {
                func.apply(context, args);
                lastRan = Date.now();
            } else {
                clearTimeout(lastFunc);
                lastFunc = setTimeout(function() {
                    if ((Date.now() - lastRan) >= limit) {
                        func.apply(context, args);
                        lastRan = Date.now();
                    }
                }, limit - (Date.now() - lastRan));
            }
        };
    }

})(jQuery);