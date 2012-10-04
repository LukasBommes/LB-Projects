<?php 
/*
Template Name: Archives
*/
?>

<?php 
/*
*	archives.php
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
				
				<?php LB_article_title('single'); ?>
				
				<?php LB_article_info(); ?>
				
				<div class="entry">

					<?php the_content( __('read more', 'lbprojects') ); ?>
					
					<div id="archives-wrapper">
			
						<h3><?php _e('Pages', 'lbprojects'); ?></h3>
									
						<ul>							
							<?php wp_list_pages("title_li=" ); ?>								
						</ul>
									
						<h3><?php _e('Feeds', 'lbprojects'); ?></h3>
									
						<ul>							
							<li>
								<a href="feed:<?php bloginfo('rss2_url'); ?>"><?php _e('Site-Feed', 'lbprojects'); ?></a>
							</li>
									
							<li>
								<a href="feed:<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comment-Feed', 'lbprojects'); ?></a>
							</li>								
						</ul>
									
						<h3><?php _e('Categories', 'lbprojects'); ?></h3>
								
						<ul>
							<?php wp_list_categories( array( 'title_li' => '', 'hierarchical' => 0, 'feed' => 'RSS' ) ); ?>
						</ul>
					
						<h3><?php _e('Post Archives', 'lbprojects'); ?></h3>
					
						<ul>
							<?php wp_get_archives( array( 'show_post_count' => 1 ) ); ?>
						</ul>						

					</div><!-- sitemap-wrapper -->			
					
				</div>		
			
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