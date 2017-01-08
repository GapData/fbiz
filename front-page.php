<?php
/**
 * Site Front Page
 *
 * This is a traditional static HTML site model with a fixed front page and
 * content placed in Pages, rarely if ever using posts, categories, or tags. 
 *
 * @subpackage fBiz
 * @author tishonator
 * @since fBiz 1.0.0
 * @link https://codex.wordpress.org/Creating_a_Static_Front_Page
 *
 */

 get_header(); ?>

<?php fbiz_display_slider(); ?>

<div class="clear">
</div><!-- .clear -->

<div id="main-content-wrapper">
	<?php get_sidebar( 'home' ); ?>
</div><!-- #main-content-wrapper -->

<?php get_footer(); ?>