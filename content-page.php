<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage fBiz
 * @author tishonator
 * @since fBiz 1.0.0
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="page-content">
		<?php echo '<h1 class="entry-title">'.get_the_title().'</h1>'; ?>
		<?php fbiz_the_content_single(); ?>
	</div><!-- .page-content -->
	
	<div class="page-after-content">
	
		<!-- .author-icon -->
		
		<?php if ( ! post_password_required() ) : ?>

			<?php if ('open' == $post->comment_status) : ?>

					<span class="comments-icon">
						<?php comments_popup_link(__( 'No Comments', 'fbiz' ), __( '1 Comment', 'fbiz' ), __( '% Comments', 'fbiz' ), '', __( 'Comments are closed.', 'fbiz' )); ?>
					</span><!-- .comments-icon -->

			<?php endif; ?>
				
			<?php edit_post_link( __( 'Edit', 'fbiz' ), '<span class="edit-icon">', '</span>' ); ?>

		<?php endif; ?>

	</div><!-- .page-after-content -->
	
</article><!-- #post-## -->
