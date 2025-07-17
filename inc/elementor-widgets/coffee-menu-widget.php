<?php
/**
 * Coffee Menu Elementor Widget
 *
 * @package CoffeeShop
 */

if (!defined('ABSPATH')) {
    exit;
}

class CoffeeShop_Coffee_Menu_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'coffeeshop-coffee-menu';
    }

    public function get_title() {
        return __('Coffee Menu', 'coffeeshop');
    }

    public function get_icon() {
        return 'eicon-menu-card';
    }

    public function get_categories() {
        return ['coffeeshop'];
    }

    public function get_keywords() {
        return ['coffee', 'menu', 'price', 'food', 'drink'];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Menu Items', 'coffeeshop'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_name',
            [
                'label' => __('Item Name', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Espresso', 'coffeeshop'),
                'placeholder' => __('Enter item name', 'coffeeshop'),
            ]
        );

        $repeater->add_control(
            'item_description',
            [
                'label' => __('Description', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Rich and bold espresso shot', 'coffeeshop'),
                'placeholder' => __('Enter item description', 'coffeeshop'),
            ]
        );

        $repeater->add_control(
            'item_price',
            [
                'label' => __('Price', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '$3.50',
                'placeholder' => __('$0.00', 'coffeeshop'),
            ]
        );

        $repeater->add_control(
            'item_image',
            [
                'label' => __('Image', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'item_featured',
            [
                'label' => __('Featured Item', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'coffeeshop'),
                'label_off' => __('No', 'coffeeshop'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'menu_items',
            [
                'label' => __('Menu Items', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_name' => __('Espresso', 'coffeeshop'),
                        'item_description' => __('Rich and bold espresso shot', 'coffeeshop'),
                        'item_price' => '$3.50',
                    ],
                    [
                        'item_name' => __('Americano', 'coffeeshop'),
                        'item_description' => __('Espresso with hot water', 'coffeeshop'),
                        'item_price' => '$4.00',
                    ],
                    [
                        'item_name' => __('Cappuccino', 'coffeeshop'),
                        'item_description' => __('Espresso with steamed milk and foam', 'coffeeshop'),
                        'item_price' => '$4.50',
                    ],
                ],
                'title_field' => '{{{ item_name }}}',
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

        $this->add_control(
            'layout_style',
            [
                'label' => __('Layout Style', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => __('Grid', 'coffeeshop'),
                    'list' => __('List', 'coffeeshop'),
                    'masonry' => __('Masonry', 'coffeeshop'),
                ],
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
                'condition' => [
                    'layout_style' => ['grid', 'masonry'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .coffee-menu-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_control(
            'show_images',
            [
                'label' => __('Show Images', 'coffeeshop'),
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

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Menu Item Style', 'coffeeshop'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_background_color',
            [
                'label' => __('Background Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => __('Border', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .menu-item',
            ]
        );

        $this->add_control(
            'item_border_radius',
            [
                'label' => __('Border Radius', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .menu-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'label' => __('Box Shadow', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .menu-item',
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => __('Padding', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .menu-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_margin',
            [
                'label' => __('Margin', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .menu-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'name' => 'item_name_typography',
                'label' => __('Item Name Typography', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .menu-item-name',
            ]
        );

        $this->add_control(
            'item_name_color',
            [
                'label' => __('Item Name Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-item-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_description_typography',
                'label' => __('Description Typography', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .menu-item-description',
            ]
        );

        $this->add_control(
            'item_description_color',
            [
                'label' => __('Description Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-item-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_price_typography',
                'label' => __('Price Typography', 'coffeeshop'),
                'selector' => '{{WRAPPER}} .menu-item-price',
            ]
        );

        $this->add_control(
            'item_price_color',
            [
                'label' => __('Price Color', 'coffeeshop'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-item-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $layout_class = 'coffee-menu-' . $settings['layout_style'];
        
        if (!empty($settings['menu_items'])) {
            echo '<div class="coffee-menu-widget ' . $layout_class . '">';
            
            if ($settings['layout_style'] === 'grid' || $settings['layout_style'] === 'masonry') {
                echo '<div class="coffee-menu-grid">';
            } else {
                echo '<div class="coffee-menu-list">';
            }
            
            foreach ($settings['menu_items'] as $index => $item) {
                $item_key = $this->get_repeater_setting_key('item', 'menu_items', $index);
                $this->add_render_attribute($item_key, 'class', 'menu-item');
                
                if ($item['item_featured'] === 'yes') {
                    $this->add_render_attribute($item_key, 'class', 'featured-item');
                }
                
                echo '<div ' . $this->get_render_attribute_string($item_key) . '>';
                
                if ($settings['show_images'] === 'yes' && !empty($item['item_image']['url'])) {
                    echo '<div class="menu-item-image">';
                    echo '<img src="' . esc_url($item['item_image']['url']) . '" alt="' . esc_attr($item['item_name']) . '">';
                    echo '</div>';
                }
                
                echo '<div class="menu-item-content">';
                echo '<div class="menu-item-header">';
                echo '<h3 class="menu-item-name">' . esc_html($item['item_name']) . '</h3>';
                echo '<span class="menu-item-price">' . esc_html($item['item_price']) . '</span>';
                echo '</div>';
                
                if ($settings['show_description'] === 'yes' && !empty($item['item_description'])) {
                    echo '<p class="menu-item-description">' . esc_html($item['item_description']) . '</p>';
                }
                
                echo '</div>'; // menu-item-content
                echo '</div>'; // menu-item
            }
            
            echo '</div>'; // grid/list container
            echo '</div>'; // coffee-menu-widget
        }
    }

    protected function content_template() {
        ?>
        <# if (settings.menu_items.length) { #>
            <div class="coffee-menu-widget coffee-menu-{{{ settings.layout_style }}}">
                <# if (settings.layout_style === 'grid' || settings.layout_style === 'masonry') { #>
                    <div class="coffee-menu-grid">
                <# } else { #>
                    <div class="coffee-menu-list">
                <# } #>
                
                <# _.each(settings.menu_items, function(item, index) { #>
                    <div class="menu-item<# if (item.item_featured === 'yes') { #> featured-item<# } #>">
                        <# if (settings.show_images === 'yes' && item.item_image.url) { #>
                            <div class="menu-item-image">
                                <img src="{{{ item.item_image.url }}}" alt="{{{ item.item_name }}}">
                            </div>
                        <# } #>
                        
                        <div class="menu-item-content">
                            <div class="menu-item-header">
                                <h3 class="menu-item-name">{{{ item.item_name }}}</h3>
                                <span class="menu-item-price">{{{ item.item_price }}}</span>
                            </div>
                            
                            <# if (settings.show_description === 'yes' && item.item_description) { #>
                                <p class="menu-item-description">{{{ item.item_description }}}</p>
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
\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CoffeeShop_Coffee_Menu_Widget());