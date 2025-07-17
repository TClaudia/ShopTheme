<?php
/**
 * Template Name: Our Baristas
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
                    <h1 class="page-title"><?php _e('Meet Our Baristas', 'coffeeshop'); ?></h1>
                    <p class="page-subtitle"><?php _e('The passionate experts behind every perfect cup', 'coffeeshop'); ?></p>
                </header>

                <div class="baristas-intro">
                    <div class="intro-content">
                        <h2><?php _e('Masters of Coffee Craft', 'coffeeshop'); ?></h2>
                        <p><?php _e('Our skilled baristas are more than just coffee makers - they are artisans who bring passion, expertise, and creativity to every cup. Each member of our team has undergone extensive training and brings their unique personality and skills to create the perfect coffee experience for you.', 'coffeeshop'); ?></p>
                    </div>
                </div>

                <div class="baristas-grid">
                    <?php
                    $baristas = array(
                        array(
                            'name' => __('Maria Rodriguez', 'coffeeshop'),
                            'position' => __('Head Barista & Coffee Director', 'coffeeshop'),
                            'image' => 'barista-maria.jpg',
                            'specialty' => __('Latte Art & Single Origin Espresso', 'coffeeshop'),
                            'experience' => 8,
                            'bio' => __('Maria brings over 8 years of coffee expertise to our team. She\'s a certified Q Grader and has won multiple latte art competitions. Her passion for single-origin espresso and innovative brewing techniques makes every cup exceptional.', 'coffeeshop'),
                            'certifications' => array(__('Q Grader Certified', 'coffeeshop'), __('SCA Brewing Professional', 'coffeeshop'), __('Latte Art Champion 2023', 'coffeeshop')),
                            'quote' => __('Coffee is not just a drink, it\'s a moment of connection between people.', 'coffeeshop'),
                            'social' => array(
                                'instagram' => 'https://instagram.com/maria_coffee_art',
                                'twitter' => 'https://twitter.com/maria_barista'
                            )
                        ),
                        array(
                            'name' => __('Carlos Martinez', 'coffeeshop'),
                            'position' => __('Coffee Roaster & Quality Manager', 'coffeeshop'),
                            'image' => 'barista-carlos.jpg',
                            'specialty' => __('Bean Roasting & Flavor Profiling', 'coffeeshop'),
                            'experience' => 12,
                            'bio' => __('Carlos is our master roaster with 12 years of experience in coffee roasting and quality control. He travels directly to coffee farms to source our beans and ensures every batch meets our high standards.', 'coffeeshop'),
                            'certifications' => array(__('Roasting Institute Graduate', 'coffeeshop'), __('Coffee Quality Institute', 'coffeeshop'), __('Fair Trade Certified', 'coffeeshop')),
                            'quote' => __('The perfect roast brings out the soul of the bean.', 'coffeeshop'),
                            'social' => array(
                                'instagram' => 'https://instagram.com/carlos_roasts',
                                'linkedin' => 'https://linkedin.com/in/carlos-coffee'
                            )
                        ),
                        array(
                            'name' => __('Sophie Chen', 'coffeeshop'),
                            'position' => __('Senior Barista', 'coffeeshop'),
                            'image' => 'barista-sophie.jpg',
                            'specialty' => __('Espresso & Customer Experience', 'coffeeshop'),
                            'experience' => 4,
                            'bio' => __('Sophie specializes in creating the perfect espresso-based drinks and ensuring every customer has an amazing experience. Her attention to detail and friendly personality make her a customer favorite.', 'coffeeshop'),
                            'certifications' => array(__('SCA Barista Skills', 'coffeeshop'), __('Customer Service Excellence', 'coffeeshop')),
                            'quote' => __('Every smile and perfect cup makes my day complete.', 'coffeeshop'),
                            'social' => array(
                                'instagram' => 'https://instagram.com/sophie_espresso',
                                'facebook' => 'https://facebook.com/sophie.barista'
                            )
                        ),
                        array(
                            'name' => __('Ahmed Hassan', 'coffeeshop'),
                            'position' => __('Brewing Specialist', 'coffeeshop'),
                            'image' => 'barista-ahmed.jpg',
                            'specialty' => __('Pour Over & Cold Brew', 'coffeeshop'),
                            'experience' => 6,
                            'bio' => __('Ahmed is our manual brewing expert, specializing in pour-over methods and cold brew techniques. His precision and knowledge of extraction science ensure every manual brew is perfectly balanced.', 'coffeeshop'),
                            'certifications' => array(__('SCA Brewing Intermediate', 'coffeeshop'), __('Cold Brew Specialist', 'coffeeshop')),
                            'quote' => __('Precision in brewing creates perfection in taste.', 'coffeeshop'),
                            'social' => array(
                                'instagram' => 'https://instagram.com/ahmed_pourover',
                                'twitter' => 'https://twitter.com/ahmed_brewing'
                            )
                        ),
                        array(
                            'name' => __('Emma Thompson', 'coffeeshop'),
                            'position' => __('Pastry & Coffee Pairing Expert', 'coffeeshop'),
                            'image' => 'barista-emma.jpg',
                            'specialty' => __('Coffee Pairing & Seasonal Drinks', 'coffeeshop'),
                            'experience' => 5,
                            'bio' => __('Emma combines her pastry background with coffee expertise to create perfect pairings and seasonal drink innovations. She\'s the creative mind behind our seasonal menu offerings.', 'coffeeshop'),
                            'certifications' => array(__('Pastry Arts Certificate', 'coffeeshop'), __('Coffee Cupping Certified', 'coffeeshop')),
                            'quote' => __('The right pairing can transform a good coffee into an unforgettable experience.', 'coffeeshop'),
                            'social' => array(
                                'instagram' => 'https://instagram.com/emma_coffee_pastry',
                                'pinterest' => 'https://pinterest.com/emma_pairings'
                            )
                        ),
                        array(
                            'name' => __('Jake Williams', 'coffeeshop'),
                            'position' => __('Junior Barista', 'coffeeshop'),
                            'image' => 'barista-jake.jpg',
                            'specialty' => __('Learning & Growing', 'coffeeshop'),
                            'experience' => 1,
                            'bio' => __('Jake is our newest team member, bringing fresh energy and enthusiasm to our coffee shop. He\'s currently training under our senior baristas and shows great promise in the craft.', 'coffeeshop'),
                            'certifications' => array(__('Barista Basics Certified', 'coffeeshop')),
                            'quote' => __('Every day is a new opportunity to learn and create something amazing.', 'coffeeshop'),
                            'social' => array(
                                'instagram' => 'https://instagram.com/jake_learning_coffee'
                            )
                        )
                    );

                    foreach ($baristas as $index => $barista) :
                    ?>
                        <div class="barista-card" data-index="<?php echo $index; ?>">
                            <div class="barista-image">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/baristas/<?php echo esc_attr($barista['image']); ?>" 
                                     alt="<?php echo esc_attr($barista['name']); ?>" 
                                     loading="lazy">
                                <div class="barista-overlay">
                                    <button class="view-details-btn" data-barista="<?php echo $index; ?>">
                                        <?php _e('View Details', 'coffeeshop'); ?>
                                    </button>
                                </div>
                            </div>
                            <div class="barista-info">
                                <h3 class="barista-name"><?php echo esc_html($barista['name']); ?></h3>
                                <p class="barista-position"><?php echo esc_html($barista['position']); ?></p>
                                <div class="barista-specialty">
                                    <strong><?php _e('Specialty:', 'coffeeshop'); ?></strong> 
                                    <?php echo esc_html($barista['specialty']); ?>
                                </div>
                                <div class="barista-experience">
                                    <strong><?php _e('Experience:', 'coffeeshop'); ?></strong> 
                                    <?php echo esc_html($barista['experience']); ?> <?php _e('years', 'coffeeshop'); ?>
                                </div>
                                <div class="barista-social">
                                    <?php foreach ($barista['social'] as $platform => $url) : ?>
                                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="nofollow" class="social-link">
                                            <i class="fab fa-<?php echo esc_attr($platform); ?>"></i>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="team-stats">
                    <h2><?php _e('Our Team Excellence', 'coffeeshop'); ?></h2>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-number">36</span>
                            <span class="stat-label"><?php _e('Years Combined Experience', 'coffeeshop'); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">15</span>
                            <span class="stat-label"><?php _e('Professional Certifications', 'coffeeshop'); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">3</span>
                            <span class="stat-label"><?php _e('Competition Winners', 'coffeeshop'); ?></span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">5000+</span>
                            <span class="stat-label"><?php _e('Cups Served Daily', 'coffeeshop'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="join-team">
                    <h2><?php _e('Join Our Team', 'coffeeshop'); ?></h2>
                    <p><?php _e('Are you passionate about coffee and looking to join a team of dedicated professionals? We\'re always looking for talented individuals who share our love for exceptional coffee.', 'coffeeshop'); ?></p>
                    <div class="join-actions">
                        <a href="<?php echo get_permalink(get_page_by_path('contact')); ?>" class="btn btn-primary">
                            <?php _e('Apply Now', 'coffeeshop'); ?>
                        </a>
                        <a href="mailto:careers@coffeeshop.com" class="btn btn-secondary">
                            <?php _e('Send Resume', 'coffeeshop'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barista Detail Modal -->
        <div id="barista-modal" class="barista-modal">
            <div class="modal-content">
                <span class="modal-close">&times;</span>
                <div class="modal-header">
                    <img id="modal-image" src="" alt="">
                    <div class="modal-header-info">
                        <h2 id="modal-name"></h2>
                        <p id="modal-position"></p>
                        <div class="modal-social" id="modal-social"></div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="modal-quote">
                        <blockquote id="modal-quote"></blockquote>
                    </div>
                    <div class="modal-details">
                        <div class="detail-section">
                            <h4><?php _e('Biography', 'coffeeshop'); ?></h4>
                            <p id="modal-bio"></p>
                        </div>
                        <div class="detail-section">
                            <h4><?php _e('Specialty', 'coffeeshop'); ?></h4>
                            <p id="modal-specialty"></p>
                        </div>
                        <div class="detail-section">
                            <h4><?php _e('Experience', 'coffeeshop'); ?></h4>
                            <p id="modal-experience"></p>
                        </div>
                        <div class="detail-section">
                            <h4><?php _e('Certifications', 'coffeeshop'); ?></h4>
                            <ul id="modal-certifications"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
        .baristas-intro {
            text-align: center;
            margin-bottom: 4rem;
            padding: 3rem;
            background: var(--light-gray);
            border-radius: var(--border-radius);
        }

        .baristas-intro h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
        }

        .baristas-intro p {
            max-width: 800px;
            margin: 0 auto;
            font-size: 1.1rem;
            line-height: 1.7;
            color: #666;
        }

        .baristas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .barista-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .barista-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .barista-image {
            position: relative;
            height: 300px;
            overflow: hidden;
        }

        .barista-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .barista-card:hover .barista-image img {
            transform: scale(1.05);
        }

        .barista-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(111, 78, 55, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .barista-card:hover .barista-overlay {
            opacity: 1;
        }

        .view-details-btn {
            background: white;
            color: var(--primary-color);
            border: none;
            padding: 1rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .view-details-btn:hover {
            background: var(--accent-color);
            color: white;
            transform: scale(1.05);
        }

        .barista-info {
            padding: 1.5rem;
        }

        .barista-name {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
            font-family: var(--font-primary);
        }

        .barista-position {
            color: var(--accent-color);
            font-weight: 600;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        .barista-specialty,
        .barista-experience {
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            color: #666;
        }

        .barista-social {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--accent-color);
            transform: translateY(-2px);
        }

        .team-stats {
            text-align: center;
            margin-bottom: 4rem;
        }

        .team-stats h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }

        .join-team {
            text-align: center;
            background: var(--primary-color);
            color: white;
            padding: 3rem;
            border-radius: var(--border-radius);
        }

        .join-team h2 {
            color: white;
            margin-bottom: 1rem;
        }

        .join-team p {
            max-width: 600px;
            margin: 0 auto 2rem auto;
            opacity: 0.9;
        }

        .join-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .join-actions .btn-primary {
            background: white;
            color: var(--primary-color);
        }

        .join-actions .btn-primary:hover {
            background: var(--accent-color);
            color: white;
        }

        .join-actions .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .join-actions .btn-secondary:hover {
            background: white;
            color: var(--primary-color);
        }

        /* Modal Styles */
        .barista-modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
        }

        .barista-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: var(--border-radius);
            max-width: 800px;
            width: 90%;
            max-height: 90%;
            overflow-y: auto;
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 2rem;
            cursor: pointer;
            color: #999;
            z-index: 1;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            color: var(--primary-color);
        }

        .modal-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            padding: 2rem;
            background: var(--light-gray);
        }

        .modal-header img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .modal-header-info h2 {
            margin-bottom: 0.5rem;
            color: var(--primary-color);
        }

        .modal-header-info p {
            color: var(--accent-color);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .modal-social {
            display: flex;
            gap: 0.75rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-quote {
            text-align: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: var(--light-gray);
            border-radius: var(--border-radius);
            border-left: 4px solid var(--accent-color);
        }

        .modal-quote blockquote {
            font-style: italic;
            font-size: 1.1rem;
            color: var(--primary-color);
            margin: 0;
        }

        .detail-section {
            margin-bottom: 1.5rem;
        }

        .detail-section h4 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .detail-section p {
            color: #666;
            line-height: 1.6;
        }

        .detail-section ul {
            list-style: none;
            padding: 0;
        }

        .detail-section li {
            background: var(--light-gray);
            padding: 0.5rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 20px;
            display: inline-block;
            margin-right: 0.5rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .baristas-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .modal-header {
                flex-direction: column;
                text-align: center;
            }
            
            .modal-header img {
                width: 120px;
                height: 120px;
            }
            
            .join-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .join-actions .btn {
                width: 200px;
            }
        }
        </style>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const baristas = <?php echo json_encode($baristas); ?>;
            const modal = document.getElementById('barista-modal');
            const modalClose = document.querySelector('.modal-close');
            const viewDetailsBtns = document.querySelectorAll('.view-details-btn');
            const baristaCards = document.querySelectorAll('.barista-card');
            
            // Open modal on button click or card click
            viewDetailsBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const baristaIndex = btn.dataset.barista;
                    openModal(baristaIndex);
                });
            });
            
            baristaCards.forEach(card => {
                card.addEventListener('click', () => {
                    const baristaIndex = card.dataset.index;
                    openModal(baristaIndex);
                });
            });
            
            function openModal(index) {
                const barista = baristas[index];
                
                // Populate modal content
                document.getElementById('modal-image').src = '<?php echo get_template_directory_uri(); ?>/images/baristas/' + barista.image;
                document.getElementById('modal-image').alt = barista.name;
                document.getElementById('modal-name').textContent = barista.name;
                document.getElementById('modal-position').textContent = barista.position;
                document.getElementById('modal-quote').textContent = barista.quote;
                document.getElementById('modal-bio').textContent = barista.bio;
                document.getElementById('modal-specialty').textContent = barista.specialty;
                document.getElementById('modal-experience').textContent = barista.experience + ' <?php _e('years', 'coffeeshop'); ?>';
                
                // Populate certifications
                const certificationsList = document.getElementById('modal-certifications');
                certificationsList.innerHTML = '';
                barista.certifications.forEach(cert => {
                    const li = document.createElement('li');
                    li.textContent = cert;
                    certificationsList.appendChild(li);
                });
                
                // Populate social links
                const socialContainer = document.getElementById('modal-social');
                socialContainer.innerHTML = '';
                Object.entries(barista.social).forEach(([platform, url]) => {
                    const link = document.createElement('a');
                    link.href = url;
                    link.target = '_blank';
                    link.rel = 'nofollow';
                    link.className = 'social-link';
                    link.innerHTML = `<i class="fab fa-${platform}"></i>`;
                    socialContainer.appendChild(link);
                });
                
                // Show modal
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
            
            function closeModal() {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
            
            // Close modal events
            modalClose.addEventListener('click', closeModal);
            
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });
            
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modal.classList.contains('active')) {
                    closeModal();
                }
            });
        });
        </script>
        <?php
    }
    ?>
</main>

<?php
get_footer();