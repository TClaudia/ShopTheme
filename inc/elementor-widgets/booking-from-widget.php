<?php
/**
 * Booking Form Elementor Widget
 *
 * @package CoffeeShop
 */

if (!defined('ABSPATH')) {
    exit;
}

class CoffeeShop_Booking_Form_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'coffeeshop-booking-form';
    }

    public function get_title() {
        return __('Booking Form', 'coffeeshop');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_categories() {
        return ['coffeeshop'];
    }

    public function get_keywords() {
        return ['booking', 'form', 'reservation', 'table', 'coffee'];
    }

    public function get_script_depends() {
        return ['coffeeshop-elementor-widgets'];
    }

    public function get_style_depends() {
        return ['coffeeshop-elementor-widgets'];
    }

    protected function register_controls() {
        // Content Section
        $this->add_control(
            'show_newsletter_signup',
            [
                'label' => __('Show Newsletter Signup', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'coffeeshop'),
                'label_off' => __('Hide', 'coffeeshop'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Submit Button Section
        $this->start_controls_section(
            'submit_button_section',
            [
                'label' => __('Submit Button', 'coffeeshop'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'submit_button_text',
            [
                'label' => __('Button Text', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Book Table', 'coffeeshop'),
                'placeholder' => __('Enter button text', 'coffeeshop'),
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label' => __('Button Size', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'md',
                'options' => [
                    'xs' => __('Extra Small', 'coffeeshop'),
                    'sm' => __('Small', 'coffeeshop'),
                    'md' => __('Medium', 'coffeeshop'),
                    'lg' => __('Large', 'coffeeshop'),
                    'xl' => __('Extra Large', 'coffeeshop'),
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Form
        $this->start_controls_section(
            'form_style_section',
            [
                'label' => __('Form Style', 'coffeeshop'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'form_background_color',
            [
                'label' => __('Background Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .booking-form-widget' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'form_border',
                'label' => __('Border', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .booking-form-widget',
            ]
        );

        $this->add_control(
            'form_border_radius',
            [
                'label' => __('Border Radius', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .booking-form-widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'form_box_shadow',
                'label' => __('Box Shadow', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .booking-form-widget',
            ]
        );

        $this->add_responsive_control(
            'form_padding',
            [
                'label' => __('Padding', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .booking-form-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Typography
        $this->start_controls_section(
            'typography_style_section',
            [
                'label' => __('Typography', 'coffeeshop'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .booking-form-title',
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .booking-form-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => __('Description Typography', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .booking-form-description',
                'condition' => [
                    'show_description' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Description Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .booking-form-description' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_description' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => __('Label Typography', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .form-group label',
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => __('Label Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .form-group label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Fields
        $this->start_controls_section(
            'fields_style_section',
            [
                'label' => __('Form Fields', 'coffeeshop'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'field_typography',
                'label' => __('Field Typography', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .form-group input, {{WRAPPER}} .form-group select, {{WRAPPER}} .form-group textarea',
            ]
        );

        $this->add_control(
            'field_text_color',
            [
                'label' => __('Text Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .form-group input, {{WRAPPER}} .form-group select, {{WRAPPER}} .form-group textarea' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'field_background_color',
            [
                'label' => __('Background Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .form-group input, {{WRAPPER}} .form-group select, {{WRAPPER}} .form-group textarea' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'field_border',
                'label' => __('Border', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .form-group input, {{WRAPPER}} .form-group select, {{WRAPPER}} .form-group textarea',
            ]
        );

        $this->add_control(
            'field_border_radius',
            [
                'label' => __('Border Radius', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .form-group input, {{WRAPPER}} .form-group select, {{WRAPPER}} .form-group textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'field_padding',
            [
                'label' => __('Padding', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .form-group input, {{WRAPPER}} .form-group select, {{WRAPPER}} .form-group textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'field_focus_border_color',
            [
                'label' => __('Focus Border Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .form-group input:focus, {{WRAPPER}} .form-group select:focus, {{WRAPPER}} .form-group textarea:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Submit Button
        $this->start_controls_section(
            'button_style_section',
            [
                'label' => __('Submit Button', 'coffeeshop'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __('Typography', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .booking-submit-btn',
            ]
        );

        $this->start_controls_tabs('button_style_tabs');

        $this->start_controls_tab(
            'button_normal_tab',
            [
                'label' => __('Normal', 'coffeeshop'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Text Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .booking-submit-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => __('Background Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .booking-submit-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover_tab',
            [
                'label' => __('Hover', 'coffeeshop'),
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
                'label' => __('Text Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .booking-submit-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background_color',
            [
                'label' => __('Background Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .booking-submit-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => __('Border', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .booking-submit-btn',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .booking-submit-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'label' => __('Box Shadow', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .booking-submit-btn',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Padding', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .booking-submit-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        echo '<div class="booking-form-widget">';
        
        // Form Title
        if ($settings['show_title'] === 'yes' && !empty($settings['form_title'])) {
            echo '<h2 class="booking-form-title">' . esc_html($settings['form_title']) . '</h2>';
        }
        
        // Form Description
        if ($settings['show_description'] === 'yes' && !empty($settings['form_description'])) {
            echo '<p class="booking-form-description">' . esc_html($settings['form_description']) . '</p>';
        }
        
        echo '<form class="booking-form" id="elementor-booking-form-' . $this->get_id() . '">';
        
        // Name Fields
        if ($settings['name_field_type'] === 'separate') {
            echo '<div class="form-row">';
            echo '<div class="form-group">';
            echo '<label for="first-name-' . $this->get_id() . '">' . __('First Name', 'coffeeshop') . ' *</label>';
            echo '<input type="text" id="first-name-' . $this->get_id() . '" name="first_name" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="last-name-' . $this->get_id() . '">' . __('Last Name', 'coffeeshop') . ' *</label>';
            echo '<input type="text" id="last-name-' . $this->get_id() . '" name="last_name" required>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="form-group">';
            echo '<label for="full-name-' . $this->get_id() . '">' . __('Full Name', 'coffeeshop') . ' *</label>';
            echo '<input type="text" id="full-name-' . $this->get_id() . '" name="full_name" required>';
            echo '</div>';
        }
        
        // Email and Phone
        echo '<div class="form-row">';
        echo '<div class="form-group">';
        echo '<label for="email-' . $this->get_id() . '">' . __('Email', 'coffeeshop') . ' *</label>';
        echo '<input type="email" id="email-' . $this->get_id() . '" name="email" required>';
        echo '</div>';
        
        if ($settings['show_phone_field'] === 'yes') {
            echo '<div class="form-group">';
            echo '<label for="phone-' . $this->get_id() . '">' . __('Phone', 'coffeeshop') . ' *</label>';
            echo '<input type="tel" id="phone-' . $this->get_id() . '" name="phone" required>';
            echo '</div>';
        }
        echo '</div>';
        
        // Date and Time
        echo '<div class="form-row">';
        echo '<div class="form-group">';
        echo '<label for="date-' . $this->get_id() . '">' . __('Date', 'coffeeshop') . ' *</label>';
        echo '<input type="date" id="date-' . $this->get_id() . '" name="date" required min="' . date('Y-m-d') . '">';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="time-' . $this->get_id() . '">' . __('Time', 'coffeeshop') . ' *</label>';
        echo '<input type="time" id="time-' . $this->get_id() . '" name="time" required min="07:00" max="20:00">';
        echo '</div>';
        echo '</div>';
        
        // Guests and Occasion
        echo '<div class="form-row">';
        echo '<div class="form-group">';
        echo '<label for="guests-' . $this->get_id() . '">' . __('Number of Guests', 'coffeeshop') . ' *</label>';
        echo '<select id="guests-' . $this->get_id() . '" name="guests" required>';
        echo '<option value="">' . __('Select...', 'coffeeshop') . '</option>';
        for ($i = 1; $i <= 12; $i++) {
            $text = $i === 1 ? __('person', 'coffeeshop') : __('people', 'coffeeshop');
            if ($i > 10) {
                echo '<option value="' . $i . '">' . $i . '+ ' . $text . '</option>';
            } else {
                echo '<option value="' . $i . '">' . $i . ' ' . $text . '</option>';
            }
        }
        echo '</select>';
        echo '</div>';
        
        if ($settings['show_occasion_field'] === 'yes') {
            echo '<div class="form-group">';
            echo '<label for="occasion-' . $this->get_id() . '">' . __('Occasion', 'coffeeshop') . '</label>';
            echo '<select id="occasion-' . $this->get_id() . '" name="occasion">';
            echo '<option value="">' . __('Select...', 'coffeeshop') . '</option>';
            echo '<option value="casual">' . __('Casual Visit', 'coffeeshop') . '</option>';
            echo '<option value="business">' . __('Business Meeting', 'coffeeshop') . '</option>';
            echo '<option value="date">' . __('Date', 'coffeeshop') . '</option>';
            echo '<option value="celebration">' . __('Celebration', 'coffeeshop') . '</option>';
            echo '<option value="other">' . __('Other', 'coffeeshop') . '</option>';
            echo '</select>';
            echo '</div>';
        }
        echo '</div>';
        
        // Special Requests
        if ($settings['show_special_requests'] === 'yes') {
            echo '<div class="form-group">';
            echo '<label for="special-requests-' . $this->get_id() . '">' . __('Special Requests', 'coffeeshop') . '</label>';
            echo '<textarea id="special-requests-' . $this->get_id() . '" name="special_requests" rows="4" placeholder="' . esc_attr__('Any special requests or dietary requirements...', 'coffeeshop') . '"></textarea>';
            echo '</div>';
        }
        
        // Newsletter Signup
        if ($settings['show_newsletter_signup'] === 'yes') {
            echo '<div class="form-group">';
            echo '<label class="checkbox-label">';
            echo '<input type="checkbox" name="newsletter" value="1">';
            echo __('I would like to receive updates about special offers and events', 'coffeeshop');
            echo '</label>';
            echo '</div>';
        }
        
        // Submit Button
        $button_class = 'booking-submit-btn btn-' . $settings['button_size'];
        echo '<button type="submit" class="' . $button_class . '">' . esc_html($settings['submit_button_text']) . '</button>';
        
        echo '</form>';
        echo '</div>';
    }

    protected function content_template() {
        ?>
        <#
        var formId = 'elementor-booking-form-' + view.getID();
        #>
        <div class="booking-form-widget">
            <# if (settings.show_title === 'yes' && settings.form_title) { #>
                <h2 class="booking-form-title">{{{ settings.form_title }}}</h2>
            <# } #>
            
            <# if (settings.show_description === 'yes' && settings.form_description) { #>
                <p class="booking-form-description">{{{ settings.form_description }}}</p>
            <# } #>
            
            <form class="booking-form" id="{{{ formId }}}">
                <# if (settings.name_field_type === 'separate') { #>
                    <div class="form-row">
                        <div class="form-group">
                            <label><?php echo __('First Name', 'coffeeshop'); ?> *</label>
                            <input type="text" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label><?php echo __('Last Name', 'coffeeshop'); ?> *</label>
                            <input type="text" name="last_name" required>
                        </div>
                    </div>
                <# } else { #>
                    <div class="form-group">
                        <label><?php echo __('Full Name', 'coffeeshop'); ?> *</label>
                        <input type="text" name="full_name" required>
                    </div>
                <# } #>
                
                <div class="form-row">
                    <div class="form-group">
                        <label><?php echo __('Email', 'coffeeshop'); ?> *</label>
                        <input type="email" name="email" required>
                    </div>
                    <# if (settings.show_phone_field === 'yes') { #>
                        <div class="form-group">
                            <label><?php echo __('Phone', 'coffeeshop'); ?> *</label>
                            <input type="tel" name="phone" required>
                        </div>
                    <# } #>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label><?php echo __('Date', 'coffeeshop'); ?> *</label>
                        <input type="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label><?php echo __('Time', 'coffeeshop'); ?> *</label>
                        <input type="time" name="time" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label><?php echo __('Number of Guests', 'coffeeshop'); ?> *</label>
                        <select name="guests" required>
                            <option value=""><?php echo __('Select...', 'coffeeshop'); ?></option>
                            <option value="1">1 <?php echo __('person', 'coffeeshop'); ?></option>
                            <option value="2">2 <?php echo __('people', 'coffeeshop'); ?></option>
                            <option value="3">3 <?php echo __('people', 'coffeeshop'); ?></option>
                            <option value="4">4 <?php echo __('people', 'coffeeshop'); ?></option>
                        </select>
                    </div>
                    <# if (settings.show_occasion_field === 'yes') { #>
                        <div class="form-group">
                            <label><?php echo __('Occasion', 'coffeeshop'); ?></label>
                            <select name="occasion">
                                <option value=""><?php echo __('Select...', 'coffeeshop'); ?></option>
                                <option value="casual"><?php echo __('Casual Visit', 'coffeeshop'); ?></option>
                                <option value="business"><?php echo __('Business Meeting', 'coffeeshop'); ?></option>
                                <option value="date"><?php echo __('Date', 'coffeeshop'); ?></option>
                                <option value="celebration"><?php echo __('Celebration', 'coffeeshop'); ?></option>
                                <option value="other"><?php echo __('Other', 'coffeeshop'); ?></option>
                            </select>
                        </div>
                    <# } #>
                </div>
                
                <# if (settings.show_special_requests === 'yes') { #>
                    <div class="form-group">
                        <label><?php echo __('Special Requests', 'coffeeshop'); ?></label>
                        <textarea name="special_requests" rows="4" placeholder="<?php echo esc_attr__('Any special requests or dietary requirements...', 'coffeeshop'); ?>"></textarea>
                    </div>
                <# } #>
                
                <# if (settings.show_newsletter_signup === 'yes') { #>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="newsletter" value="1">
                            <?php echo __('I would like to receive updates about special offers and events', 'coffeeshop'); ?>
                        </label>
                    </div>
                <# } #>
                
                <button type="submit" class="booking-submit-btn btn-{{{ settings.button_size }}}">{{{ settings.submit_button_text }}}</button>
            </form>
        </div>
        <?php
    }
}

// Register the widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CoffeeShop_Booking_Form_Widget());->start_controls_section(
            'content_section',
            [
                'label' => __('Form Content', 'coffeeshop'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'form_title',
            [
                'label' => __('Form Title', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Book a Table', 'coffeeshop'),
                'placeholder' => __('Enter form title', 'coffeeshop'),
            ]
        );

        $this->add_control(
            'form_description',
            [
                'label' => __('Form Description', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Reserve your spot for the perfect coffee experience', 'coffeeshop'),
                'placeholder' => __('Enter form description', 'coffeeshop'),
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => __('Show Title', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'coffeeshop'),
                'label_off' => __('Hide', 'coffeeshop'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_description',
            [
                'label' => __('Show Description', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'coffeeshop'),
                'label_off' => __('Hide', 'coffeeshop'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Form Fields Section
        $this->start_controls_section(
            'form_fields_section',
            [
                'label' => __('Form Fields', 'coffeeshop'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'name_field_type',
            [
                'label' => __('Name Field Type', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'separate',
                'options' => [
                    'separate' => __('First & Last Name', 'coffeeshop'),
                    'single' => __('Full Name', 'coffeeshop'),
                ],
            ]
        );

        $this->add_control(
            'show_phone_field',
            [
                'label' => __('Show Phone Field', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'coffeeshop'),
                'label_off' => __('Hide', 'coffeeshop'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_occasion_field',
            [
                'label' => __('Show Occasion Field', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'coffeeshop'),
                'label_off' => __('Hide', 'coffeeshop'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_special_requests',
            [
                'label' => __('Show Special Requests', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'coffeeshop'),
                'label_off' => __('Hide', 'coffeeshop'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_newsletter_signup',
            [
                'label' => __('Show Newsletter Signup', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'coffeeshop'),
                'label_off' => __('Hide', 'coffeeshop'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );      

            