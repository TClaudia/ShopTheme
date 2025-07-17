<?php
/**
 * Template Name: Menu
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
                    <h1 class="page-title"><?php _e('Our Menu', 'coffeeshop'); ?></h1>
                    <p class="page-subtitle"><?php _e('Discover our carefully crafted coffee and food selections', 'coffeeshop'); ?></p>
                </header>

                <!-- Coffee Menu -->
                <div class="menu-section">
                    <h2><?php _e('Coffee & Espresso', 'coffeeshop'); ?></h2>
                    <div class="menu-grid">
                        <?php
                        $coffee_items = array(
                            array(
                                'name' => __('Espresso', 'coffeeshop'),
                                'description' => __('Rich and bold single or double shot', 'coffeeshop'),
                                'price' => '$3.50',
                                'image' => 'espresso.jpg'
                            ),
                            array(
                                'name' => __('Americano', 'coffeeshop'),
                                'description' => __('Espresso with hot water', 'coffeeshop'),
                                'price' => '$4.00',
                                'image' => 'americano.jpg'
                            ),
                            array(
                                'name' => __('Cappuccino', 'coffeeshop'),
                                'description' => __('Espresso with steamed milk and foam', 'coffeeshop'),
                                'price' => '$4.50',
                                'image' => 'cappuccino.jpg'
                            ),
                            array(
                                'name' => __('Latte', 'coffeeshop'),
                                'description' => __('Espresso with steamed milk and light foam', 'coffeeshop'),
                                'price' => '$5.00',
                                'image' => 'latte.jpg'
                            ),
                        );
                        
                        foreach ($coffee_items as $item) :
                        ?>
                            <div class="menu-item">
                                <div class="menu-item-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/menu/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                                </div>
                                <div class="menu-item-content">
                                    <div class="menu-item-header">
                                        <h3 class="menu-item-name"><?php echo $item['name']; ?></h3>
                                        <span class="menu-item-price"><?php echo $item['price']; ?></span>
                                    </div>
                                    <p class="menu-item-description"><?php echo $item['description']; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Cold Drinks Menu -->
                <div class="menu-section">
                    <h2><?php _e('Cold Drinks', 'coffeeshop'); ?></h2>
                    <div class="menu-grid">
                        <?php
                        $cold_items = array(
                            array(
                                'name' => __('Iced Coffee', 'coffeeshop'),
                                'description' => __('Chilled coffee over ice', 'coffeeshop'),
                                'price' => '$3.75',
                                'image' => 'iced-coffee.jpg'
                            ),
                            array(
                                'name' => __('Cold Brew', 'coffeeshop'),
                                'description' => __('Smooth cold-brewed coffee', 'coffeeshop'),
                                'price' => '$4.25',
                                'image' => 'cold-brew.jpg'
                            ),
                        );
                        
                        foreach ($cold_items as $item) :
                        ?>
                            <div class="menu-item">
                                <div class="menu-item-image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/menu/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>">
                                </div>
                                <div class="menu-item-content">
                                    <div class="menu-item-header">
                                        <h3 class="menu-item-name"><?php echo $item['name']; ?></h3>
                                        <span class="menu-item-price"><?php echo $item['price']; ?></span>
                                    </div>
                                    <p class="menu-item-description"><?php echo $item['description']; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</main>

<?php
get_footer();