<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package CoffeeShop
 * @since 1.0.0
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		
		<?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4')) : ?>
			<div class="footer-widgets">
				<div class="container">
					<div class="footer-content">
						
						<?php if (is_active_sidebar('footer-1')) : ?>
							<div class="footer-section footer-1">
								<?php dynamic_sidebar('footer-1'); ?>
							</div>
						<?php endif; ?>
						
						<?php if (is_active_sidebar('footer-2')) : ?>
							<div class="footer-section footer-2">
								<?php dynamic_sidebar('footer-2'); ?>
							</div>
						<?php endif; ?>
						
						<?php if (is_active_sidebar('footer-3')) : ?>
							<div class="footer-section footer-3">
								<?php dynamic_sidebar('footer-3'); ?>
							</div>
						<?php endif; ?>
						
						<?php if (is_active_sidebar('footer-4')) : ?>
							<div class="footer-section footer-4">
								<?php dynamic_sidebar('footer-4'); ?>
							</div>
						<?php endif; ?>
						
					</div><!-- .footer-content -->
				</div><!-- .container -->
			</div><!-- .footer-widgets -->
		<?php endif; ?>

		<!-- Footer Bottom -->
		<div class="footer-bottom">
			<div class="container">
				<div class="footer-bottom-content">
					
					<div class="site-info">
						<?php
						$copyright_text = get_theme_mod('coffeeshop_copyright_text');
						if ($copyright_text) :
							echo wp_kses_post($copyright_text);
						else :
							printf(
								/* translators: 1: Copyright year, 2: Site name, 3: Theme name, 4: Theme author */
								esc_html__('© %1$s %2$s. Powered by %3$s theme by %4$s.', 'coffeeshop'),
								date('Y'),
								get_bloginfo('name'),
								'<a href="https://wordpress.org/" rel="nofollow">WordPress</a>',
								'<a href="' . esc_url('https://yourwebsite.com/') . '" rel="nofollow">YourCompany</a>'
							);
						endif;
						?>
					</div><!-- .site-info -->
					
					<!-- Footer Menu -->
					<?php if (has_nav_menu('footer')) : ?>
						<nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e('Footer Menu', 'coffeeshop'); ?>">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'footer',
									'menu_class'     => 'footer-menu',
									'container'      => false,
									'depth'          => 1,
									'fallback_cb'    => false,
								)
							);
							?>
						</nav>
					<?php endif; ?>
					
					<!-- Social Links -->
					<?php if (get_theme_mod('coffeeshop_enable_footer_social', true)) : ?>
						<div class="footer-social">
							<?php coffeeshop_social_links(); ?>
						</div>
					<?php endif; ?>
					
				</div><!-- .footer-bottom-content -->
			</div><!-- .container -->
		</div><!-- .footer-bottom -->
		
	</footer><!-- #colophon -->
	
	<!-- Back to Top Button -->
	<?php if (get_theme_mod('coffeeshop_enable_scroll_top', true)) : ?>
		<button class="back-to-top" aria-label="<?php esc_attr_e('Back to top', 'coffeeshop'); ?>" title="<?php esc_attr_e('Back to top', 'coffeeshop'); ?>">
			<i class="fas fa-chevron-up" aria-hidden="true"></i>
		</button>
	<?php endif; ?>
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>