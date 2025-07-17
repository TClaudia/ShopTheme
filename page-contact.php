<?php
/**
 * Template Name: Contact Us
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
                    <h1 class="page-title"><?php _e('Contact Us', 'coffeeshop'); ?></h1>
                    <p class="page-subtitle"><?php _e('Get in touch with us - we\'d love to hear from you', 'coffeeshop'); ?></p>
                </header>

                <div class="contact-content">
                    <div class="contact-info">
                        <h3><?php _e('Get in Touch', 'coffeeshop'); ?></h3>
                        
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong><?php _e('Address', 'coffeeshop'); ?></strong>
                                <p>123 Coffee Street<br>Downtown District<br>City, State 12345</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <strong><?php _e('Phone', 'coffeeshop'); ?></strong>
                                <p><a href="tel:+1234567890">(123) 456-7890</a></p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong><?php _e('Email', 'coffeeshop'); ?></strong>
                                <p><a href="mailto:info@coffeeshop.com">info@coffeeshop.com</a></p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong><?php _e('Hours', 'coffeeshop'); ?></strong>
                                <p>
                                    <?php _e('Monday - Friday: 6:00 AM - 8:00 PM', 'coffeeshop'); ?><br>
                                    <?php _e('Saturday - Sunday: 7:00 AM - 9:00 PM', 'coffeeshop'); ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <form class="contact-form" id="contact-form">
                        <h3><?php _e('Send us a Message', 'coffeeshop'); ?></h3>
                        
                        <div class="form-group">
                            <label for="contact-name"><?php _e('Name', 'coffeeshop'); ?> *</label>
                            <input type="text" id="contact-name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="contact-email"><?php _e('Email', 'coffeeshop'); ?> *</label>
                            <input type="email" id="contact-email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="contact-phone"><?php _e('Phone', 'coffeeshop'); ?></label>
                            <input type="tel" id="contact-phone" name="phone">
                        </div>

                        <div class="form-group">
                            <label for="contact-subject"><?php _e('Subject', 'coffeeshop'); ?> *</label>
                            <select id="contact-subject" name="subject" required>
                                <option value=""><?php _e('Select a subject...', 'coffeeshop'); ?></option>
                                <option value="general"><?php _e('General Inquiry', 'coffeeshop'); ?></option>
                                <option value="reservation"><?php _e('Reservation', 'coffeeshop'); ?></option>
                                <option value="catering"><?php _e('Catering', 'coffeeshop'); ?></option>
                                <option value="feedback"><?php _e('Feedback', 'coffeeshop'); ?></option>
                                <option value="complaint"><?php _e('Complaint', 'coffeeshop'); ?></option>
                                <option value="other"><?php _e('Other', 'coffeeshop'); ?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="contact-message"><?php _e('Message', 'coffeeshop'); ?> *</label>
                            <textarea id="contact-message" name="message" rows="6" required placeholder="<?php _e('Please tell us how we can help you...', 'coffeeshop'); ?>"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary"><?php _e('Send Message', 'coffeeshop'); ?></button>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</main>

<?php
get_footer();