<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "body-content-wrapper" div and all content after.
 *
 * @package WordPress
 * @subpackage fBiz
 * @author tishonator
 * @since fBiz 1.0.0
 *
 */
?>
			<a href="#" class="scrollup"></a>
			<footer id="footer-main">
			
				<div id="footer-content-wrapper">
				
					<div class="clear">
					</div><!-- .clear -->
					
					<div id="copyright">
					
						<p>
						 	<?php fbiz_show_copyright_text(); ?> <a href="<?php echo esc_url( 'http://tishonator.com/product/fbiz' ); ?>" title="<?php esc_attr_e( 'fbiz Theme', 'fbiz' ); ?>">
							<?php _e('fBiz Theme', 'fbiz'); ?></a> <?php esc_attr_e( 'powered by', 'fbiz' ); ?> <a href="<?php echo esc_url( 'http://wordpress.org/' ); ?>" title="<?php esc_attr_e( 'WordPress', 'fbiz' ); ?>">
							<?php _e('WordPress', 'fbiz'); ?></a>
						</p>
						
					</div><!-- #copyright -->
					
				</div><!-- #footer-content-wrapper -->
				
			</footer><!-- #footer-main -->

		</div><!-- #body-content-wrapper -->
		<?php wp_footer(); ?>
	</body>
</html>