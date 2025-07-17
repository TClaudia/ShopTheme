<?php
/**
 * Template Name: Book a Table
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
                    <h1 class="page-title"><?php _e('Book a Table', 'coffeeshop'); ?></h1>
                    <p class="page-subtitle"><?php _e('Reserve your spot for the perfect coffee experience', 'coffeeshop'); ?></p>
                </header>

                <form class="booking-form" id="booking-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first-name"><?php _e('First Name', 'coffeeshop'); ?> *</label>
                            <input type="text" id="first-name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last-name"><?php _e('Last Name', 'coffeeshop'); ?> *</label>
                            <input type="text" id="last-name" name="last_name" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email"><?php _e('Email', 'coffeeshop'); ?> *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone"><?php _e('Phone', 'coffeeshop'); ?> *</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="date"><?php _e('Date', 'coffeeshop'); ?> *</label>
                            <input type="date" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="time"><?php _e('Time', 'coffeeshop'); ?> *</label>
                            <input type="time" id="time" name="time" required min="07:00" max="20:00">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="guests"><?php _e('Number of Guests', 'coffeeshop'); ?> *</label>
                            <select id="guests" name="guests" required>
                                <option value=""><?php _e('Select...', 'coffeeshop'); ?></option>
                                <option value="1">1 <?php _e('person', 'coffeeshop'); ?></option>
                                <option value="2">2 <?php _e('people', 'coffeeshop'); ?></option>
                                <option value="3">3 <?php _e('people', 'coffeeshop'); ?></option>
                                <option value="4">4 <?php _e('people', 'coffeeshop'); ?></option>
                                <option value="5">5 <?php _e('people', 'coffeeshop'); ?></option>
                                <option value="6">6+ <?php _e('people', 'coffeeshop'); ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="occasion"><?php _e('Occasion', 'coffeeshop'); ?></label>
                            <select id="occasion" name="occasion">
                                <option value=""><?php _e('Select...', 'coffeeshop'); ?></option>
                                <option value="casual"><?php _e('Casual Visit', 'coffeeshop'); ?></option>
                                <option value="business"><?php _e('Business Meeting', 'coffeeshop'); ?></option>
                                <option value="date"><?php _e('Date', 'coffeeshop'); ?></option>
                                <option value="celebration"><?php _e('Celebration', 'coffeeshop'); ?></option>
                                <option value="other"><?php _e('Other', 'coffeeshop'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="special-requests"><?php _e('Special Requests', 'coffeeshop'); ?></label>
                        <textarea id="special-requests" name="special_requests" rows="4" placeholder="<?php _e('Any special requests or dietary requirements...', 'coffeeshop'); ?>"></textarea>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="newsletter" value="1">
                            <?php _e('I would like to receive updates about special offers and events', 'coffeeshop'); ?>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary"><?php _e('Book Table', 'coffeeshop'); ?></button>
                </form>
            </div>
        </div>
        <?php
    }
    ?>
</main>

<?php
get_footer();