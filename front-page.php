<?php 
/*
*	front-page.php
*
*	LB-Projects Theme
*	Author: Lukas Bommes
*	Copyright (C) Lukas Bommes
*/ 
?>

<?php get_header(); ?>

	<?php LB_announce_widget(); ?>
	
	<!-- Image Slideshow -->
		<?php if( of_get_option('show_slideshow') ) : ?>

		<div id="slider">

			<ul id="sliderContent">
			
				<?php for( $i = 1; $i <= 10; $i++ ) : ?>
						
						<?php ${'slider_'.$i} = of_get_option('slider_' . $i); ?>
						
						<?php if( ${'slider_'.$i}['image'] ) : ?>
						
							<li class="sliderImage">
									<a href="<?php echo ${'slider_'.$i}['link'] ?>">
									<img src="<?php echo ${'slider_'.$i}['image']; ?>" title="<?php echo ${'slider_'.$i}['title']; ?>" /></a>
									<div class="text">
										<h2 class="title"><a href="<?php echo ${'slider_'.$i}['link']; ?>"><?php echo ${'slider_'.$i}['title']; ?></a></h2>
										<p><?php echo ${'slider_'.$i}['text']; ?></p>
									</div>
							</li>
							
						<?php endif; ?>
				
				<?php endfor; ?>
				
				<li class="clear sliderImage"></li>

			</ul>

		</div><!-- slider -->

	<?php endif; ?>


	<!-- Featured Post Slider -->
	<?php if( of_get_option('featured_posts') ) : ?>

		<div id="featured-box">

			<div id="featured-wrap">
			
				<ul id="featured">
		
					<?php $featured_query = new WP_Query( array( 'meta_key' => 'LB-featured-post-check', 'meta_value' => 1, 'tax_query' => array( array( 'taxonomy' => 'post_format', 'field' => 'slug', 'terms' => 'post-format-image', 'operator' => 'NOT IN' ) ) ) ); ?>
					
					<?php if( $featured_query->have_posts() ) : while( $featured_query->have_posts() ) : $featured_query->the_post(); ?>

					<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<h2 class="title">
						
							<a href="<?php the_permalink(); ?>">
							
								<?php
								$custom_fields = get_post_custom($post->ID);								
								$LB_featured_post_title = $custom_fields['LB-featured-post-text'];
							
								foreach ( $LB_featured_post_title as $title ) {
									if( $title ) {
										echo $title;
									}
									else {
										the_title();
									}									
								} ?>
								
							</a>
							
						</h2>
							
						<div class="entry">
						
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( array( 150, 150 ) ); ?>
							</a>
							
							<?php the_excerpt(); ?> 

						</div>

					</li><!-- post -->
					
					<?php endwhile; endif; ?>

				</ul>
				
			</div>

			<div id="featured-controls">
				<div id="left_scroll"><a id="featured-prev" href="javascript:slide('left');"><?php _e('Previous Posts', 'lbprojects'); ?></a></div>
				<div id="right_scroll"><a id="featured-next" href="javascript:slide('right');"><?php _e('Next Posts', 'lbprojects'); ?></a></div>
			</div>
			
			<input type="hidden" id="hidden_auto_slide_seconds" value=0 />
		
		</div><!-- featured-box -->
		
	<?php endif; ?>
	
	
	<!-- Homepage Article -->
	<div id="article-wrapper">
				
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
			<div class="article">
			
				<?php if( !is_page() ) : ?>
					<?php LB_article_title('cat'); ?>
				<?php else : ?>
					<div class="title">
						<h2><?php the_title(); ?></h2>
					</div>
				<?php endif; ?>
						
				<div class="entry">
				
					<?php LB_thumbnail('cat'); ?>

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

	</div><!-- content --> 

	<?php get_sidebar(); ?>              
    
	</div><!-- main -->

	</div><!-- wrapper -->

<?php get_footer(); ?>