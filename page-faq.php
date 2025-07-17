<?php
/**
 * Template Name: FAQ
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
                    <h1 class="page-title"><?php _e('Frequently Asked Questions', 'coffeeshop'); ?></h1>
                    <p class="page-subtitle"><?php _e('Find answers to common questions about our coffee shop', 'coffeeshop'); ?></p>
                </header>

                <div class="faq-search">
                    <input type="text" id="faq-search-input" placeholder="<?php _e('Search FAQs...', 'coffeeshop'); ?>">
                    <button type="button" id="faq-search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <div class="faq-categories">
                    <button class="category-btn active" data-category="all"><?php _e('All', 'coffeeshop'); ?></button>
                    <button class="category-btn" data-category="general"><?php _e('General', 'coffeeshop'); ?></button>
                    <button class="category-btn" data-category="coffee"><?php _e('Coffee', 'coffeeshop'); ?></button>
                    <button class="category-btn" data-category="orders"><?php _e('Orders', 'coffeeshop'); ?></button>
                    <button class="category-btn" data-category="catering"><?php _e('Catering', 'coffeeshop'); ?></button>
                </div>

                <div class="faq-container">
                    <?php
                    $faqs = array(
                        array(
                            'category' => 'general',
                            'question' => __('What are your opening hours?', 'coffeeshop'),
                            'answer' => __('We are open Monday through Friday from 6:00 AM to 8:00 PM, and Saturday through Sunday from 7:00 AM to 9:00 PM. We are closed on major holidays.', 'coffeeshop')
                        ),
                        array(
                            'category' => 'general',
                            'question' => __('Do you offer Wi-Fi?', 'coffeeshop'),
                            'answer' => __('Yes! We offer free Wi-Fi to all our customers. The network name is "CoffeeShop_Guest" and the password is available at the counter.', 'coffeeshop')
                        ),
                        array(
                            'category' => 'general',
                            'question' => __('Is parking available?', 'coffeeshop'),
                            'answer' => __('We have a dedicated parking lot with 20 spaces available for our customers. Street parking is also available on the surrounding streets.', 'coffeeshop')
                        ),
                        array(
                            'category' => 'coffee',
                            'question' => __('Where do you source your coffee beans?', 'coffeeshop'),
                            'answer' => __('We source our premium coffee beans directly from sustainable farms in Colombia, Ethiopia, Guatemala, and Costa Rica. All our suppliers follow fair trade practices.', 'coffeeshop')
                        ),
                        array(
                            'category' => 'coffee',
                            'question' => __('Do you offer decaffeinated options?', 'coffeeshop'),
                            'answer' => __('Absolutely! We offer decaffeinated versions of all our espresso-based drinks, as well as decaf drip coffee and cold brew options.', 'coffeeshop')
                        ),
                        array(
                            'category' => 'coffee',
                            'question' => __('Can I buy coffee beans to take home?', 'coffeeshop'),
                            'answer' => __('Yes! We sell whole bean and ground coffee for home brewing. Our beans are available in 12oz and 2lb bags, and we can grind them to your preferred coarseness.', 'coffeeshop')
                        ),
                        array(
                            'category' => 'coffee',
                            'question' => __('What milk alternatives do you offer?', 'coffeeshop'),
                            'answer' => __('We offer several plant-based milk alternatives including oat milk, almond milk, soy milk, and coconut milk. All are available for any of our espresso-based drinks.', 'coffeeshop')
                        ),
                        array(
                            'category' => 'orders',
                            'question' => __('Can I place orders online?', 'coffeeshop'),
                            'answer' => __('Yes! You can place orders online through our website or mobile app for pickup. We also offer delivery through third-party services within a 5-mile radius.', 'coffeeshop')
                        ),
                        array(
                            'category' => 'orders',
                            'question' => __('Do you offer loyalty rewards?', 'coffeeshop'),
                            'answer' => __('Yes! Join our CoffeeShop Rewards program to earn points with every purchase. Earn 1 point per dollar spent and get a free drink after 100 points.', 'coffeeshop')
                        ),
                        array(
                            'category' => 'orders',
                            'question' => __('What payment methods do you accept?', 'coffeeshop'),
                            'answer' => __('We accept cash, all major credit cards, debit cards, mobile payments (Apple Pay, Google Pay), and gift cards. We also accept our mobile app payments.', 'coffeeshop')
                        ),
                        array(
                            'category' => 'orders',
                            'question' => __('Can I customize my drinks?', 'coffeeshop'),
                            'answer' => __('Absolutely! We love customizing drinks to your preferences. You can adjust sweetness, milk type, add extra shots, flavored syrups, and more.', 'coffeeshop')
                        ),
                        array(
                            'category' => 'catering',
                            'question' => __('Do you offer catering services?', 'coffeeshop'),
                            'answer' => __('Yes! We provide catering for events, meetings, and parties. Our catering menu includes coffee service, pastries, sandwiches, and more. Please contact us 48 hours in advance.', 'coffeeshop')
                        ),
                        array(
                            'category' => 'catering',
                            'question' => __('What is the minimum order for catering?', 'coffeeshop'),
                            'answer' => __('Our minimum catering order is for 10 people. We offer various packages including coffee-only service, continental breakfast, lunch packages, and full-service options.', 'coffeeshop')
                        ),
                        array(
                            'category' => 'general',
                            'question' => __('Do you have seating for large groups?', 'coffeeshop'),
                            'answer' => __('We have several seating options including communal tables that can accommodate groups of 8-12 people. For larger groups, please call ahead so we can arrange appropriate seating.', 'coffeeshop')
                        ),
                        array(
                            'category' => 'general',
                            'question' => __('Are you pet-friendly?', 'coffeeshop'),
                            'answer' => __('We welcome well-behaved dogs on our outdoor patio. Pets are not allowed inside the cafe for health and safety reasons, but we have water bowls available outside.', 'coffeeshop')
                        ),
                        array(
                            'category' => 'coffee',
                            'question' => __('Do you offer coffee subscriptions?', 'coffeeshop'),
                            'answer' => __('Yes! Our coffee subscription service delivers freshly roasted beans to your door monthly. Choose from our signature blends or try different single-origin coffees each month.', 'coffeeshop')
                        )
                    );

                    foreach ($faqs as $index => $faq) :
                    ?>
                        <div class="faq-item" data-category="<?php echo esc_attr($faq['category']); ?>">
                            <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-<?php echo $index; ?>">
                                <span class="question-text"><?php echo esc_html($faq['question']); ?></span>
                                <span class="faq-icon">
                                    <i class="fas fa-plus"></i>
                                </span>
                            </button>
                            <div class="faq-answer" id="faq-answer-<?php echo $index; ?>">
                                <div class="answer-content">
                                    <p><?php echo esc_html($faq['answer']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="faq-contact">
                    <h2><?php _e('Still have questions?', 'coffeeshop'); ?></h2>
                    <p><?php _e('If you can\'t find the answer you\'re looking for, please don\'t hesitate to contact us directly.', 'coffeeshop'); ?></p>
                    <div class="contact-options">
                        <a href="<?php echo get_permalink(get_page_by_path('contact')); ?>" class="btn btn-primary">
                            <?php _e('Contact Us', 'coffeeshop'); ?>
                        </a>
                        <a href="tel:+1234567890" class="btn btn-secondary">
                            <i class="fas fa-phone"></i>
                            <?php _e('Call Us', 'coffeeshop'); ?>
                        </a>
                        <a href="mailto:info@coffeeshop.com" class="btn btn-secondary">
                            <i class="fas fa-envelope"></i>
                            <?php _e('Email Us', 'coffeeshop'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <style>
        .faq-search {
            display: flex;
            max-width: 500px;
            margin: 0 auto 3rem auto;
            position: relative;
        }

        .faq-search input {
            width: 100%;
            padding: 1rem 3rem 1rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .faq-search input:focus {
            outline: none;
            border-color: var(--accent-color);
        }

        .faq-search button {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.5rem;
        }

        .faq-categories {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .category-btn {
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

        .category-btn:hover,
        .category-btn.active {
            background: var(--primary-color);
            color: white;
        }

        .faq-container {
            max-width: 800px;
            margin: 0 auto 3rem auto;
        }

        .faq-item {
            background: white;
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .faq-item.hidden {
            display: none;
        }

        .faq-question {
            width: 100%;
            background: none;
            border: none;
            padding: 1.5rem;
            text-align: left;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .faq-question:hover {
            background: var(--light-gray);
        }

        .faq-question[aria-expanded="true"] {
            background: var(--primary-color);
            color: white;
        }

        .question-text {
            flex: 1;
            padding-right: 1rem;
        }

        .faq-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .faq-question[aria-expanded="true"] .faq-icon {
            transform: rotate(45deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .faq-answer.open {
            max-height: 300px;
        }

        .answer-content {
            padding: 0 1.5rem 1.5rem 1.5rem;
            color: #666;
            line-height: 1.6;
        }

        .faq-contact {
            text-align: center;
            background: var(--light-gray);
            padding: 3rem;
            border-radius: var(--border-radius);
            margin-top: 3rem;
        }

        .faq-contact h2 {
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .faq-contact p {
            margin-bottom: 2rem;
            color: #666;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .contact-options {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .contact-options .btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .no-results {
            text-align: center;
            padding: 3rem;
            color: #666;
        }

        .no-results h3 {
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .faq-categories {
                gap: 0.5rem;
            }
            
            .category-btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            
            .faq-question {
                padding: 1rem;
                font-size: 1rem;
            }
            
            .answer-content {
                padding: 0 1rem 1rem 1rem;
            }
            
            .contact-options {
                flex-direction: column;
                align-items: center;
            }
            
            .contact-options .btn {
                width: 200px;
                justify-content: center;
            }
        }
        </style>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('faq-search-input');
            const categoryBtns = document.querySelectorAll('.category-btn');
            const faqItems = document.querySelectorAll('.faq-item');
            const faqQuestions = document.querySelectorAll('.faq-question');
            const faqContainer = document.querySelector('.faq-container');
            
            let currentCategory = 'all';
            let searchTerm = '';
            
            // FAQ accordion functionality
            faqQuestions.forEach(question => {
                question.addEventListener('click', () => {
                    const isExpanded = question.getAttribute('aria-expanded') === 'true';
                    const answer = question.nextElementSibling;
                    
                    // Close all other FAQs
                    faqQuestions.forEach(q => {
                        if (q !== question) {
                            q.setAttribute('aria-expanded', 'false');
                            q.nextElementSibling.classList.remove('open');
                        }
                    });
                    
                    // Toggle current FAQ
                    question.setAttribute('aria-expanded', !isExpanded);
                    answer.classList.toggle('open', !isExpanded);
                });
            });
            
            // Search functionality
            searchInput.addEventListener('input', (e) => {
                searchTerm = e.target.value.toLowerCase();
                filterFAQs();
            });
            
            // Category filtering
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    currentCategory = btn.dataset.category;
                    
                    // Update active button
                    categoryBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    
                    filterFAQs();
                });
            });
            
            function filterFAQs() {
                let visibleCount = 0;
                
                faqItems.forEach(item => {
                    const category = item.dataset.category;
                    const questionText = item.querySelector('.question-text').textContent.toLowerCase();
                    const answerText = item.querySelector('.answer-content').textContent.toLowerCase();
                    
                    const matchesCategory = currentCategory === 'all' || category === currentCategory;
                    const matchesSearch = searchTerm === '' || 
                                        questionText.includes(searchTerm) || 
                                        answerText.includes(searchTerm);
                    
                    if (matchesCategory && matchesSearch) {
                        item.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                        // Close if expanded
                        const question = item.querySelector('.faq-question');
                        const answer = item.querySelector('.faq-answer');
                        question.setAttribute('aria-expanded', 'false');
                        answer.classList.remove('open');
                    }
                });
                
                // Show no results message
                let noResults = document.querySelector('.no-results');
                if (visibleCount === 0) {
                    if (!noResults) {
                        noResults = document.createElement('div');
                        noResults.className = 'no-results';
                        noResults.innerHTML = `
                            <h3><?php _e('No FAQs found', 'coffeeshop'); ?></h3>
                            <p><?php _e('Try adjusting your search terms or browse different categories.', 'coffeeshop'); ?></p>
                        `;
                        faqContainer.appendChild(noResults);
                    }
                } else {
                    if (noResults) {
                        noResults.remove();
                    }
                }
            }
            
            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    // Close all expanded FAQs
                    faqQuestions.forEach(question => {
                        question.setAttribute('aria-expanded', 'false');
                        question.nextElementSibling.classList.remove('open');
                    });
                }
            });
            
            // Smooth scroll to FAQ if linked from URL
            const urlHash = window.location.hash;
            if (urlHash) {
                const targetFaq = document.querySelector(urlHash);
                if (targetFaq) {
                    setTimeout(() => {
                        targetFaq.scrollIntoView({ behavior: 'smooth' });
                        targetFaq.querySelector('.faq-question').click();
                    }, 100);
                }
            }
        });
        </script>
        <?php
    }
    ?>
</main>

<?php
get_footer();