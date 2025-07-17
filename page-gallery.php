<?php
/**
 * Template Name: Gallery
 * 
 * @package CoffeeShop
 */

get_header();
?>

<main id="main" class="site-main">
    <?php
    // Check if page is built with Elementor
    if (class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor()) {
        while (have_posts()) {
            the_post();
            the_content();
        }
    } else {
        ?>
        <div class="page-template">
            <div class="container">
                <header class="page-header">
                    <h1 class="page-title"><?php _e('Gallery', 'coffeeshop'); ?></h1>
                    <p class="page-subtitle"><?php _e('Take a look at our cozy atmosphere and delicious offerings', 'coffeeshop'); ?></p>
                </header>

                <div class="gallery-filters">
                    <button class="filter-btn active" data-filter="all"><?php _e('All', 'coffeeshop'); ?></button>
                    <button class="filter-btn" data-filter="interior"><?php _e('Interior', 'coffeeshop'); ?></button>
                    <button class="filter-btn" data-filter="coffee"><?php _e('Coffee', 'coffeeshop'); ?></button>
                    <button class="filter-btn" data-filter="food"><?php _e('Food', 'coffeeshop'); ?></button>
                    <button class="filter-btn" data-filter="events"><?php _e('Events', 'coffeeshop'); ?></button>
                </div>

                <div class="gallery-grid" id="gallery-grid">
                    <?php
                    $gallery_items = array(
                        array(
                            'image' => 'gallery-1.jpg',
                            'title' => __('Cozy Corner Seating', 'coffeeshop'),
                            'category' => 'interior',
                            'description' => __('Perfect spot for reading or working', 'coffeeshop')
                        ),
                        array(
                            'image' => 'gallery-2.jpg',
                            'title' => __('Fresh Espresso', 'coffeeshop'),
                            'category' => 'coffee',
                            'description' => __('Perfectly pulled espresso shot', 'coffeeshop')
                        ),
                        array(
                            'image' => 'gallery-3.jpg',
                            'title' => __('Artisanal Pastries', 'coffeeshop'),
                            'category' => 'food',
                            'description' => __('Freshly baked daily', 'coffeeshop')
                        ),
                        array(
                            'image' => 'gallery-4.jpg',
                            'title' => __('Latte Art', 'coffeeshop'),
                            'category' => 'coffee',
                            'description' => __('Beautiful latte art by our skilled baristas', 'coffeeshop')
                        ),
                        array(
                            'image' => 'gallery-5.jpg',
                            'title' => __('Main Dining Area', 'coffeeshop'),
                            'category' => 'interior',
                            'description' => __('Spacious and welcoming atmosphere', 'coffeeshop')
                        ),
                        array(
                            'image' => 'gallery-6.jpg',
                            'title' => __('Coffee Tasting Event', 'coffeeshop'),
                            'category' => 'events',
                            'description' => __('Monthly coffee tasting sessions', 'coffeeshop')
                        ),
                        array(
                            'image' => 'gallery-7.jpg',
                            'title' => __('Gourmet Sandwich', 'coffeeshop'),
                            'category' => 'food',
                            'description' => __('Made with locally sourced ingredients', 'coffeeshop')
                        ),
                        array(
                            'image' => 'gallery-8.jpg',
                            'title' => __('Coffee Bean Display', 'coffeeshop'),
                            'category' => 'interior',
                            'description' => __('Premium beans from around the world', 'coffeeshop')
                        ),
                        array(
                            'image' => 'gallery-9.jpg',
                            'title' => __('Pour Over Station', 'coffeeshop'),
                            'category' => 'coffee',
                            'description' => __('Manual brewing for the perfect cup', 'coffeeshop')
                        ),
                        array(
                            'image' => 'gallery-10.jpg',
                            'title' => __('Live Music Night', 'coffeeshop'),
                            'category' => 'events',
                            'description' => __('Every Friday evening', 'coffeeshop')
                        ),
                        array(
                            'image' => 'gallery-11.jpg',
                            'title' => __('Barista Counter', 'coffeeshop'),
                            'category' => 'interior',
                            'description' => __('Watch our baristas work their magic', 'coffeeshop')
                        ),
                        array(
                            'image' => 'gallery-12.jpg',
                            'title' => __('Specialty Cake', 'coffeeshop'),
                            'category' => 'food',
                            'description' => __('Homemade cakes and desserts', 'coffeeshop')
                        )
                    );

                    foreach ($gallery_items as $index => $item) :
                    ?>
                        <div class="gallery-item" data-category="<?php echo esc_attr($item['category']); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/gallery/<?php echo esc_attr($item['image']); ?>" 
                                 alt="<?php echo esc_attr($item['title']); ?>" 
                                 data-title="<?php echo esc_attr($item['title']); ?>"
                                 data-description="<?php echo esc_attr($item['description']); ?>">
                            <div class="gallery-overlay">
                                <div class="gallery-content">
                                    <h3 class="gallery-title"><?php echo esc_html($item['title']); ?></h3>
                                    <p class="gallery-description"><?php echo esc_html($item['description']); ?></p>
                                    <button class="gallery-zoom" aria-label="<?php _e('View larger image', 'coffeeshop'); ?>">
                                        <i class="fas fa-search-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="gallery-info">
                    <h2><?php _e('Visit Us', 'coffeeshop'); ?></h2>
                    <p><?php _e('Experience our welcoming atmosphere in person. We would love to serve you the perfect cup of coffee in our beautiful space.', 'coffeeshop'); ?></p>
                    
                    <div class="gallery-stats">
                        <div class="stat-item">
                            <span class="stat-number">500+</span>
                            <span class="stat-label"><?php _e('Happy Customers Daily', 'coffeeshop'); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">15</span>
                            <span class="stat-label"><?php _e('Coffee Varieties', 'coffeeshop'); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">3</span>
                            <span class="stat-label"><?php _e('Locations', 'coffeeshop'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom Gallery Lightbox -->
        <div id="gallery-lightbox" class="gallery-lightbox">
            <span class="gallery-close">&times;</span>
            <img class="gallery-modal-content" id="gallery-modal-img">
            <div class="gallery-modal-info">
                <h3 id="gallery-modal-title"></h3>
                <p id="gallery-modal-description"></p>
            </div>
            <div class="gallery-nav">
                <button class="gallery-prev">&#10094;</button>
                <button class="gallery-next">&#10095;</button>
            </div>
        </div>

        <style>
        .gallery-filters {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--primary-color);
            color: white;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .gallery-item {
            position: relative;
            aspect-ratio: 4/3;
            overflow: hidden;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.8) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-content {
            color: white;
            width: 100%;
        }

        .gallery-title {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            font-family: var(--font-primary);
        }

        .gallery-description {
            font-size: 0.9rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .gallery-zoom {
            background: var(--accent-color);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-zoom:hover {
            background: var(--primary-color);
            transform: scale(1.1);
        }

        .gallery-info {
            text-align: center;
            padding: 3rem 0;
            background: var(--light-gray);
            border-radius: var(--border-radius);
            margin-top: 3rem;
        }

        .gallery-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .gallery-lightbox {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(5px);
        }

        .gallery-lightbox.active {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .gallery-modal-content {
            max-width: 80%;
            max-height: 70%;
            object-fit: contain;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .gallery-modal-info {
            text-align: center;
            color: white;
            max-width: 600px;
        }

        .gallery-modal-info h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: white;
        }

        .gallery-modal-info p {
            opacity: 0.8;
        }

        .gallery-close {
            position: absolute;
            top: 20px;
            right: 35px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .gallery-close:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .gallery-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 0 20px;
            pointer-events: none;
        }

        .gallery-prev,
        .gallery-next {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
            pointer-events: auto;
        }

        .gallery-prev:hover,
        .gallery-next:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .gallery-item.hidden {
            display: none;
        }

        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
            
            .gallery-filters {
                gap: 0.5rem;
            }
            
            .filter-btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            
            .gallery-modal-content {
                max-width: 95%;
                max-height: 60%;
            }
            
            .gallery-close {
                top: 10px;
                right: 10px;
                font-size: 30px;
                width: 40px;
                height: 40px;
            }
        }

        @media (max-width: 480px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }
        }
        </style>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const galleryItems = document.querySelectorAll('.gallery-item');
            const lightbox = document.getElementById('gallery-lightbox');
            const modalImg = document.getElementById('gallery-modal-img');
            const modalTitle = document.getElementById('gallery-modal-title');
            const modalDescription = document.getElementById('gallery-modal-description');
            const closeBtn = document.querySelector('.gallery-close');
            const prevBtn = document.querySelector('.gallery-prev');
            const nextBtn = document.querySelector('.gallery-next');
            
            let currentImageIndex = 0;
            let visibleImages = [];
            
            // Filter functionality
            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const filter = btn.dataset.filter;
                    
                    // Update active button
                    filterBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    
                    // Filter images
                    visibleImages = [];
                    galleryItems.forEach((item, index) => {
                        if (filter === 'all' || item.dataset.category === filter) {
                            item.classList.remove('hidden');
                            visibleImages.push({element: item, index: index});
                        } else {
                            item.classList.add('hidden');
                        }
                    });
                });
            });
            
            // Initialize visible images
            galleryItems.forEach((item, index) => {
                visibleImages.push({element: item, index: index});
            });
            
            // Lightbox functionality
            galleryItems.forEach((item, index) => {
                item.addEventListener('click', () => {
                    if (!item.classList.contains('hidden')) {
                        openLightbox(index);
                    }
                });
            });
            
            function openLightbox(index) {
                const visibleIndex = visibleImages.findIndex(img => img.index === index);
                if (visibleIndex === -1) return;
                
                currentImageIndex = visibleIndex;
                updateLightboxContent();
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
            
            function updateLightboxContent() {
                const currentItem = visibleImages[currentImageIndex];
                const img = currentItem.element.querySelector('img');
                
                modalImg.src = img.src;
                modalTitle.textContent = img.dataset.title;
                modalDescription.textContent = img.dataset.description;
                
                // Update navigation buttons
                prevBtn.style.display = visibleImages.length > 1 ? 'flex' : 'none';
                nextBtn.style.display = visibleImages.length > 1 ? 'flex' : 'none';
            }
            
            function closeLightbox() {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            }
            
            // Event listeners
            closeBtn.addEventListener('click', closeLightbox);
            
            prevBtn.addEventListener('click', () => {
                currentImageIndex = (currentImageIndex - 1 + visibleImages.length) % visibleImages.length;
                updateLightboxContent();
            });
            
            nextBtn.addEventListener('click', () => {
                currentImageIndex = (currentImageIndex + 1) % visibleImages.length;
                updateLightboxContent();
            });
            
            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (lightbox.classList.contains('active')) {
                    switch(e.key) {
                        case 'Escape':
                            closeLightbox();
                            break;
                        case 'ArrowLeft':
                            prevBtn.click();
                            break;
                        case 'ArrowRight':
                            nextBtn.click();
                            break;
                    }
                }
            });
            
            // Close on background click
            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) {
                    closeLightbox();
                }
            });
            
            // Touch gestures for mobile
            let startX = 0;
            let startY = 0;
            
            lightbox.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
            });
            
            lightbox.addEventListener('touchend', (e) => {
                if (!startX || !startY) return;
                
                const endX = e.changedTouches[0].clientX;
                const endY = e.changedTouches[0].clientY;
                
                const diffX = startX - endX;
                const diffY = startY - endY;
                
                if (Math.abs(diffX) > Math.abs(diffY)) {
                    if (diffX > 50) {
                        nextBtn.click();
                    } else if (diffX < -50) {
                        prevBtn.click();
                    }
                }
                
                startX = startY = 0;
            });
        });
        </script>
        <?php
    }
    ?>
</main>

<?php
get_footer();