<?php 
/*
*	search.php
*
*	LB-Projects Theme
*	Author: Lukas Bommes
*	Copyright (C) Lukas Bommes
*/ 
?>

<?php get_header(); ?>

	<?php LB_announce_widget(); ?>

	<?php if (have_posts()) : ?>

	<div id="search-result">
		<?php $s = esc_html( $s );
		$i = $wp_query->found_posts; ?>
		<p><?php printf( __("Your search for &quot;%s&quot; got %d hits.", 'lbprojects'), $s, $i ); ?></p>
	</div>
	
	<div id="article-wrapper">
			 
		<?php while (have_posts()) : the_post(); ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
			<div class="article">
				
				<?php LB_article_title('cat'); ?>
					
				<div class="entry">
				
					<?php LB_thumbnail('cat'); ?>

					<?php the_content( __('read more', 'lbprojects') ); ?>
				
				</div>
				
				<?php if( has_post_format('quote') ) : ?>
					<div class="cite"><?php the_title(); ?></div>
				<?php endif; ?>

			</div><!-- article -->						
				
		</div><!-- post -->
			
		<?php endwhile; ?>
		
	</div><!-- article-wrapper -->
	
	<?php else : ?>
	
	<div id="article-wrapper">
				
		<div class="article">
				
			<div class="title">
				<h2><?php _e('No hits', 'lbprojects'); ?></h2>
			</div>
				
			<div class="entry">
				<?php $s = esc_html( $s ); ?>
				<p><?php printf( __("Your search for &quot;%s&quot; did not get any results. You may try another keyword or browse the site archive.", 'lbprojects'), $s); ?></p>
			
				<div id="nohits-search">
					<?php get_search_form(); ?>
				</div>
			
				<div id="rand-posts">
				
					<ul>
				
						<?php
						$rand_posts = get_posts( array( 'numberposts' => 6, 'orderby' => 'rand' ) );
						foreach( $rand_posts as $post ) : ?>
						
							<?php if( get_the_title() ) : ?>
							
								<li>
									<span><a href="<?php the_permalink(); ?>">&#9658;</a></span>
									<?php the_title(); ?> <span class="article-date">(<?php global $cur_post; the_time('d. F Y', $cur_post['ID']); ?>)</span>
								</li>
							
							<?php endif; ?>
						
						<?php endforeach; ?>
					
					</ul>
				
				</div><!-- rand-posts -->			
			
			</div>
				
			<div class="clear"></div>
			
		</div>
		
	</div><!-- article-wrapper -->

	<?php endif; ?>

	<?php LB_pagination(); ?> 
 
	</div><!-- content --> 

	<?php get_sidebar(); ?>            
   
	</div><!-- main -->

	</div><!-- wrapper -->

<?php get_footer(); ?>