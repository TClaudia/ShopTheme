<?php
/**
 * Barista Team Elementor Widget
 *
 * @package CoffeeShop
 */

if (!defined('ABSPATH')) {
    exit;
}

class CoffeeShop_Barista_Team_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'coffeeshop-barista-team';
    }

    public function get_title() {
        return __('Barista Team', 'coffeeshop');
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return ['coffeeshop'];
    }

    public function get_keywords() {
        return ['barista', 'team', 'staff', 'people', 'coffee'];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Team Members', 'coffeeshop'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'member_image',
            [
                'label' => __('Photo', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'member_name',
            [
                'label' => __('Name', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Maria Rodriguez', 'coffeeshop'),
                'placeholder' => __('Enter member name', 'coffeeshop'),
            ]
        );

        $repeater->add_control(
            'member_position',
            [
                'label' => __('Position', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Head Barista', 'coffeeshop'),
                'placeholder' => __('Enter position', 'coffeeshop'),
            ]
        );

        $repeater->add_control(
            'member_bio',
            [
                'label' => __('Bio', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Passionate about creating the perfect coffee experience with 8 years of expertise.', 'coffeeshop'),
                'placeholder' => __('Enter member bio', 'coffeeshop'),
            ]
        );

        $repeater->add_control(
            'member_specialty',
            [
                'label' => __('Specialty', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Latte Art', 'coffeeshop'),
                'placeholder' => __('Coffee specialty', 'coffeeshop'),
            ]
        );

        $repeater->add_control(
            'member_experience',
            [
                'label' => __('Years of Experience', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5,
                'min' => 0,
                'max' => 50,
                'step' => 1,
            ]
        );

        $repeater->add_control(
            'social_heading',
            [
                'label' => __('Social Media', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'member_facebook',
            [
                'label' => __('Facebook', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://facebook.com/username', 'coffeeshop'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $repeater->add_control(
            'member_instagram',
            [
                'label' => __('Instagram', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://instagram.com/username', 'coffeeshop'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $repeater->add_control(
            'member_twitter',
            [
                'label' => __('Twitter', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://twitter.com/username', 'coffeeshop'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'team_members',
            [
                'label' => __('Team Members', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'member_name' => __('Maria Rodriguez', 'coffeeshop'),
                        'member_position' => __('Head Barista', 'coffeeshop'),
                        'member_bio' => __('Passionate about creating the perfect coffee experience with 8 years of expertise.', 'coffeeshop'),
                        'member_specialty' => __('Latte Art', 'coffeeshop'),
                        'member_experience' => 8,
                    ],
                    [
                        'member_name' => __('Carlos Martinez', 'coffeeshop'),
                        'member_position' => __('Coffee Roaster', 'coffeeshop'),
                        'member_bio' => __('Expert in coffee bean roasting and flavor profiling with international certifications.', 'coffeeshop'),
                        'member_specialty' => __('Bean Roasting', 'coffeeshop'),
                        'member_experience' => 12,
                    ],
                    [
                        'member_name' => __('Sophie Chen', 'coffeeshop'),
                        'member_position' => __('Barista', 'coffeeshop'),
                        'member_bio' => __('Specializes in espresso-based drinks and customer service excellence.', 'coffeeshop'),
                        'member_specialty' => __('Espresso', 'coffeeshop'),
                        'member_experience' => 4,
                    ],
                ],
                'title_field' => '{{{ member_name }}}',
            ]
        );

        $this->end_controls_section();

        // Layout Section
        $this->start_controls_section(
            'layout_section',
            [
                'label' => __('Layout', 'coffeeshop'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => __('Columns', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
                'selectors' => [
                    '{{WRAPPER}} .barista-team-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_control(
            'show_bio',
            [
                'label' => __('Show Bio', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'coffeeshop'),
                'label_off' => __('Hide', 'coffeeshop'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_specialty',
            [
                'label' => __('Show Specialty', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'coffeeshop'),
                'label_off' => __('Hide', 'coffeeshop'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_experience',
            [
                'label' => __('Show Experience', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'coffeeshop'),
                'label_off' => __('Hide', 'coffeeshop'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_social',
            [
                'label' => __('Show Social Links', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'coffeeshop'),
                'label_off' => __('Hide', 'coffeeshop'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Card Style Section
        $this->start_controls_section(
            'card_style_section',
            [
                'label' => __('Card Style', 'coffeeshop'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background_color',
            [
                'label' => __('Background Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .barista-member' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'label' => __('Border', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .barista-member',
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label' => __('Border Radius', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .barista-member' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow',
                'label' => __('Box Shadow', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .barista-member',
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => __('Padding', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .barista-member' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Image Style Section
        $this->start_controls_section(
            'image_style_section',
            [
                'label' => __('Image Style', 'coffeeshop'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label' => __('Width', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .member-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => __('Height', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .member-image' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => __('Border Radius', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .member-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Typography Section
        $this->start_controls_section(
            'typography_section',
            [
                'label' => __('Typography', 'coffeeshop'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'label' => __('Name Typography', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .member-name',
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => __('Name Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .member-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'position_typography',
                'label' => __('Position Typography', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .member-position',
            ]
        );

        $this->add_control(
            'position_color',
            [
                'label' => __('Position Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .member-position' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'bio_typography',
                'label' => __('Bio Typography', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .member-bio',
            ]
        );

        $this->add_control(
            'bio_color',
            [
                'label' => __('Bio Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .member-bio' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        if (!empty($settings['team_members'])) {
            echo '<div class="barista-team-widget">';
            echo '<div class="barista-team-grid">';
            
            foreach ($settings['team_members'] as $index => $member) {
                $member_key = $this->get_repeater_setting_key('member', 'team_members', $index);
                $this->add_render_attribute($member_key, 'class', 'barista-member');
                
                echo '<div ' . $this->get_render_attribute_string($member_key) . '>';
                
                // Member Image
                if (!empty($member['member_image']['url'])) {
                    echo '<div class="member-image">';
                    echo '<img src="' . esc_url($member['member_image']['url']) . '" alt="' . esc_attr($member['member_name']) . '">';
                    echo '</div>';
                }
                
                echo '<div class="member-info">';
                
                // Member Name
                echo '<h3 class="member-name">' . esc_html($member['member_name']) . '</h3>';
                
                // Member Position
                echo '<p class="member-position">' . esc_html($member['member_position']) . '</p>';
                
                // Member Specialty
                if ($settings['show_specialty'] === 'yes' && !empty($member['member_specialty'])) {
                    echo '<div class="member-specialty">';
                    echo '<strong>' . __('Specialty:', 'coffeeshop') . '</strong> ' . esc_html($member['member_specialty']);
                    echo '</div>';
                }
                
                // Member Experience
                if ($settings['show_experience'] === 'yes' && !empty($member['member_experience'])) {
                    echo '<div class="member-experience">';
                    echo '<strong>' . __('Experience:', 'coffeeshop') . '</strong> ' . esc_html($member['member_experience']) . ' ' . __('years', 'coffeeshop');
                    echo '</div>';
                }
                
                // Member Bio
                if ($settings['show_bio'] === 'yes' && !empty($member['member_bio'])) {
                    echo '<p class="member-bio">' . esc_html($member['member_bio']) . '</p>';
                }
                
                // Social Links
                if ($settings['show_social'] === 'yes') {
                    $social_links = '';
                    
                    if (!empty($member['member_facebook']['url'])) {
                        $social_links .= '<a href="' . esc_url($member['member_facebook']['url']) . '" target="_blank" rel="nofollow"><i class="fab fa-facebook"></i></a>';
                    }
                    
                    if (!empty($member['member_instagram']['url'])) {
                        $social_links .= '<a href="' . esc_url($member['member_instagram']['url']) . '" target="_blank" rel="nofollow"><i class="fab fa-instagram"></i></a>';
                    }
                    
                    if (!empty($member['member_twitter']['url'])) {
                        $social_links .= '<a href="' . esc_url($member['member_twitter']['url']) . '" target="_blank" rel="nofollow"><i class="fab fa-twitter"></i></a>';
                    }
                    
                    if (!empty($social_links)) {
                        echo '<div class="member-social">' . $social_links . '</div>';
                    }
                }
                
                echo '</div>'; // member-info
                echo '</div>'; // barista-member
            }
            
            echo '</div>'; // barista-team-grid
            echo '</div>'; // barista-team-widget
        }
    }

    protected function content_template() {
        ?>
        <# if (settings.team_members.length) { #>
            <div class="barista-team-widget">
                <div class="barista-team-grid">
                    <# _.each(settings.team_members, function(member, index) { #>
                        <div class="barista-member">
                            <# if (member.member_image.url) { #>
                                <div class="member-image">
                                    <img src="{{{ member.member_image.url }}}" alt="{{{ member.member_name }}}">
                                </div>
                            <# } #>
                            
                            <div class="member-info">
                                <h3 class="member-name">{{{ member.member_name }}}</h3>
                                <p class="member-position">{{{ member.member_position }}}</p>
                                
                                <# if (settings.show_specialty === 'yes' && member.member_specialty) { #>
                                    <div class="member-specialty">
                                        <strong><?php echo __('Specialty:', 'coffeeshop'); ?></strong> {{{ member.member_specialty }}}
                                    </div>
                                <# } #>
                                
                                <# if (settings.show_experience === 'yes' && member.member_experience) { #>
                                    <div class="member-experience">
                                        <strong><?php echo __('Experience:', 'coffeeshop'); ?></strong> {{{ member.member_experience }}} <?php echo __('years', 'coffeeshop'); ?>
                                    </div>
                                <# } #>
                                
                                <# if (settings.show_bio === 'yes' && member.member_bio) { #>
                                    <p class="member-bio">{{{ member.member_bio }}}</p>
                                <# } #>
                                
                                <# if (settings.show_social === 'yes') { #>
                                    <div class="member-social">
                                        <# if (member.member_facebook.url) { #>
                                            <a href="{{{ member.member_facebook.url }}}" target="_blank" rel="nofollow">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        <# } #>
                                        <# if (member.member_instagram.url) { #>
                                            <a href="{{{ member.member_instagram.url }}}" target="_blank" rel="nofollow">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        <# } #>
                                        <# if (member.member_twitter.url) { #>
                                            <a href="{{{ member.member_twitter.url }}}" target="_blank" rel="nofollow">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        <# } #>
                                    </div>
                                <# } #>
                            </div>
                        </div>
                    <# }); #>
                </div>
            </div>
        <# } #>
        <?php
    }
}

// Register the widget
\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CoffeeShop_Barista_Team_Widget());