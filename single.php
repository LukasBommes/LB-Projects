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
					
				<?php LB_article_title(); ?>
				
				<?php LB_article_info(); ?>
					
				<div class="entry">
				
					<?php LB_thumbnail(); ?>

					<?php the_content( '<i class="icon-plus"></i> ' . __('read more', 'lbprojects') ); ?>

				</div>	
				
			</div><!-- article -->

		</div><!-- post -->
		
		<?php LB_related_posts(); ?>
			
		<?php endwhile; endif; ?>

	</div><!-- article-wrapper -->
	
	<?php LB_pagination(); ?>
	
	<?php LB_author_info(); ?>

	<?php comments_template(); ?>

	</div><!-- content -->

	<?php get_sidebar(); ?>            
  
	</div><!-- main -->

	</div><!-- wrapper -->

<?php get_footer(); ?>