<?php 
/*
*	index.php
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
					
				<?php LB_article_title(); ?>
				
				<?php LB_article_info(); ?>

				<div class="entry">
				
					<?php LB_thumbnail(); ?>

					<?php the_content( '<i class="icon-plus"></i> ' . __('read more', 'lbprojects') ); ?>

				</div>

				<?php if( has_post_format('quote') ) : ?>
					<div class="cite"><?php the_title(); ?></div>
				<?php endif; ?>

			</div><!-- article -->

		</div><!-- post -->
 
		<?php endwhile; else: ?>
		
			<p><?php _e('This category is empty!', 'lbprojects'); ?></p>
			
		<?php endif; ?>

	</div><!-- article-wrapper -->
	
	<?php LB_pagination(); ?>

	<?php comments_template(); ?>

	</div><!-- content -->

	<?php get_sidebar(); ?> 

	</div><!-- main -->

</div><!-- wrapper -->

<?php get_footer(); ?>