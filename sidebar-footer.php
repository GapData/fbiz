<?php
/**
 * The sidebar containing the main footer columns widget areas
 *
 * @subpackage fTourism
 * @author tishonator
 * @since fTourism 1.0.0
 *
 */
?>

<div id="footer-cols">

	<div id="footer-cols-inner">

		<?php 
			/**
			 * Display widgets dragged in 'Footer Columns 1' widget areas
			 */
		?>
		<div class="col2a">

			<?php if ( !dynamic_sidebar( 'footer-column-1-widget-area' ) ) : ?>

						<h2 class="footer-title">
							<?php _e('Footer Col Widget 1', 'fbiz'); ?>
						</h2><!-- .footer-title -->
						
						<div class="footer-after-title">
						</div><!-- .footer-after-title -->
						
						<div class="textwidget">
							<?php _e('This is first footer widget area. To customize it, please navigate to Admin Panel -> Appearance -> Widgets and add widgets to Footer Column #1.', 'fbiz'); ?>
						</div><!-- .textwidget -->
			
			<?php endif; // end of ! dynamic_sidebar( 'footer-column-1-widget-area' )
				  ?>

		</div><!-- .col2a -->
		
		<?php 
			/**
			 * Display widgets dragged in 'Footer Columns 2' widget areas
			 */
		?>
		<div class="col2b">
			<?php if ( !dynamic_sidebar( 'footer-column-2-widget-area' ) ) : ?>
			
					<h2 class="footer-title">
						<?php _e('Footer Col Widget 2', 'fbiz'); ?>
					</h2><!-- .footer-title -->
					
					<div class="footer-after-title">
					</div><!-- .footer-after-title -->
					
					<div class="textwidget">
						<?php _e('This is second footer widget area. To customize it, please navigate to Admin Panel -> Appearance -> Widgets and add widgets to Footer Column #2.', 'fbiz'); ?>
					</div><!-- .textwidget -->
						
			<?php endif; // end of ! dynamic_sidebar( 'footer-column-2-widget-area' )
				  ?>
			
		</div><!-- .col2b -->
		
		<div class="clear">
		</div><!-- .clear -->

	</div><!-- #footer-cols-inner -->

</div><!-- #footer-cols -->