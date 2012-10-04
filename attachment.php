<?php 
/*
*	single.php
*
*	LB-Projects Theme
*	Author: Lukas Bommes
*	Copyright (C) Lukas Bommes
*/ 
?>

<?php get_header(); ?>
	
	<?php LB_announce_widget(); ?>
	
	<div id="article-wrapper">
  
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<div class="article">
	
				<div class="title"><h2><?php the_title(); ?></h2></div>
					
				<div class="entry">
					
					<?php if( wp_attachment_is_image( $post->ID ) ) : ?>
					
						<?php $att_image = wp_get_attachment_image_src( $post->ID, "large"); ?>
					
						<div class="attachment-header">
							<a class="attachment-linkback" href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment">
							<span>&laquo; </span><?php _e('Return to image gallery', 'lbprojects'); ?></a>
							
							<div class="gallery-navigation">
								<span class="right"><?php next_image_link(false, __('Next Image', 'lbprojects') . '<i class="icon-chevron-right"></i>'); ?></span>
								<span class="left"><?php previous_image_link(false, '<i class="icon-chevron-left"></i>' . __('Previous Image', 'lbprojects')); ?></span>
							</div>
						</div>
							
						<div class="attachment-wrapper">
							<a href="<?php echo wp_get_attachment_url($post->ID); ?>" title="<?php the_title(); ?>" rel="attachment">
							<img src="<?php echo $att_image[0]; ?>" class="attachment-image" alt="<?php $post->post_excerpt; ?>" /></a>
						</div>
						
					<?php else : ?>
					
						<div class="attachment-header">
							<a class="attachment-linkback" href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment">
							<span>&laquo; </span><?php _e('Return to the article', 'lbprojects'); ?></a>							
						</div>
					
						<a href="<?php echo wp_get_attachment_url($post->ID) ?>" rel="attachment"><?php echo basename($post->guid) ?></a>
						
					<?php endif; ?>
					
					<div class="gallery-caption">
						<?php if ( !empty($post->post_excerpt) ) the_excerpt() ?>
					</div>
					
					<?php if( get_the_content() ) : ?>
					
						<div class="gallery-description">
							<?php the_content( __('read more', 'lbprojects') ); ?>
						</div>
						
					<?php endif; ?>
					
					<div class="clear"></div>
 
				</div><!-- entry -->
				
			</div><!-- article -->

		</div><!-- post -->

		<?php endwhile; endif; ?>

	</div><!-- article-wrapper -->

	<?php LB_pagination(); ?>
	
	<?php comments_template(); ?>

	</div><!-- content -->

	<?php get_sidebar(); ?>            
 
	</div><!-- main -->

	</div><!-- wrapper -->

<?php get_footer(); ?>