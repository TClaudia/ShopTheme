</div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-content">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-section">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php else : ?>
                    <div class="footer-section">
                        <h3><?php _e('About CoffeeShop', 'coffeeshop'); ?></h3>
                        <p><?php _e('We are passionate about serving the finest coffee and creating memorable experiences for our customers. Visit us today!', 'coffeeshop'); ?></p>
                        <div class="social-links">
                            <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-2')) : ?>
                    <div class="footer-section">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                <?php else : ?>
                    <div class="footer-section">
                        <h3><?php _e('Quick Links', 'coffeeshop'); ?></h3>
                        <ul>
                            <li><a href="<?php echo home_url(); ?>"><?php _e('Home', 'coffeeshop'); ?></a></li>
                            <li><a href="<?php echo get_permalink(get_page_by_path('about')); ?>"><?php _e('About Us', 'coffeeshop'); ?></a></li>
                            <li><a href="<?php echo get_permalink(get_page_by_path('menu')); ?>"><?php _e('Menu', 'coffeeshop'); ?></a></li>
                            <li><a href="<?php echo get_permalink(get_page_by_path('barista')); ?>"><?php _e('Our Baristas', 'coffeeshop'); ?></a></li>
                            <li><a href="<?php echo get_permalink(get_page_by_path('contact')); ?>"><?php _e('Contact', 'coffeeshop'); ?></a></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-3')) : ?>
                    <div class="footer-section">
                        <?php dynamic_sidebar('footer-3'); ?>
                    </div>
                <?php else : ?>
                    <div class="footer-section">
                        <h3><?php _e('Services', 'coffeeshop'); ?></h3>
                        <ul>
                            <li><a href="<?php echo get_permalink(get_page_by_path('book')); ?>"><?php _e('Book a Table', 'coffeeshop'); ?></a></li>
                            <li><a href="<?php echo get_permalink(get_page_by_path('gallery')); ?>"><?php _e('Gallery', 'coffeeshop'); ?></a></li>
                            <li><a href="<?php echo get_permalink(get_page_by_path('faq')); ?>"><?php _e('FAQ', 'coffeeshop'); ?></a></li>
                            <?php if (class_exists('WooCommerce')) : ?>
                                <li><a href="<?php echo wc_get_page_permalink('shop'); ?>"><?php _e('Shop', 'coffeeshop'); ?></a></li>
                                <li><a href="<?php echo wc_get_page_permalink('cart'); ?>"><?php _e('Cart', 'coffeeshop'); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (is_active_sidebar('footer-4')) : ?>
                    <div class="footer-section">
                        <?php dynamic_sidebar('footer-4'); ?>
                    </div>
                <?php else : ?>
                    <div class="footer-section">
                        <h3><?php _e('Contact Info', 'coffeeshop'); ?></h3>
                        <div class="contact-info">
                            <p><i class="fas fa-map-marker-alt"></i> 123 Coffee Street, Downtown District, City, State 12345</p>
                            <p><i class="fas fa-phone"></i> <a href="tel:+1234567890">(123) 456-7890</a></p>
                            <p><i class="fas fa-envelope"></i> <a href="mailto:info@coffeeshop.com">info@coffeeshop.com</a></p>
                            <p><i class="fas fa-clock"></i> Mon-Fri: 6AM-8PM, Sat-Sun: 7AM-9PM</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'coffeeshop'); ?></p>
                    <div class="footer-bottom-links">
                        <a href="#"><?php _e('Privacy Policy', 'coffeeshop'); ?></a>
                        <a href="#"><?php _e('Terms of Service', 'coffeeshop'); ?></a>
                        <a href="#"><?php _e('Cookie Policy', 'coffeeshop'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button id="scroll-to-top" class="scroll-to-top" aria-label="<?php _e('Scroll to top', 'coffeeshop'); ?>">
        <i class="fas fa-arrow-up"></i>
    </button>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>