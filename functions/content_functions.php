<?php

/*
*	functions.php
*	Article and content functions
*/

// Display related posts
function LB_related_posts() {

	global $post;
	global $cur_post;
	$orig_post = $post;
	$tags = wp_get_post_tags($post->ID);

	if( $tags && of_get_option('related_posts') ) {
	
		$tag_ids = array();
		foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
		
		$my_query = new wp_query( array( 'tag__in' => $tag_ids, 'post__not_in' => array($post->ID), 'posts_per_page' => 4 ) );
		
		if( $my_query->have_posts() ) {
		
			echo '<div id="related-posts">';
				
				echo '<h3 class="title">' . __('Related posts', 'lbprojects') . '</h3>';
					
				echo '<ul>';
				  
					while( $my_query->have_posts() ) {
					
						$my_query->the_post();
							
						echo '<li>';
							echo '<span><a href="' . get_permalink() . '">&#9658;</a></span>';
							echo get_the_title() . ' ' . '<span class="article-date">(' . get_the_time('d. F Y', $cur_post['ID']) . ')</span>';
						echo '</li>';

					}
					
					$post = $orig_post;
					wp_reset_query();
				
				echo '</ul>';
				
			echo '</div>';
		
		}		
	}
}


// Display article thumbnail
function LB_thumbnail( $type ) {

	if( has_post_thumbnail() && of_get_option('thumbnails') ) {
	
		if ( !( has_post_format('aside') || has_post_format('quote') || has_post_format('image') )  ) {
			
			if( $type == 'cat' ) {	
				the_post_thumbnail( array( 80, 80 ) );
			}
			
			if( $type == 'single' ) {
				the_post_thumbnail( array( 200, 200 ) );				
			}
			
		}		
	}
}


// Display announcement widget
function LB_announce_widget() { 

	if( of_get_option('announcements') ) {
	
		echo '<div class="announcement-widget">';
			
			echo '<p class="textwidget">';
				echo '<i class="icon-exclamation-sign icon-large"></i>';
				echo of_get_option('announcements');
			echo '</p>';
			
		echo '</div>';
		
	}
}


// Display author meta after each single post
function LB_author_info() {

	$user = get_the_author_meta( 'ID' );

	if( of_get_option('show_author') && get_the_author_meta('description', $user) ) {
		
		echo '<div id="author-meta">';
		
			echo '<div class="about-author-avatar"><a href="' . get_author_posts_url( $user ) . '">' . get_avatar( $user, 60 ) . '</a></div>';
			
			echo '<h2 class="about-author-title">' . __('About', 'lbprojects') . ' ' . get_the_author() . '</h2>';
			
			echo '<div class="about-author-entry">';
				echo get_the_author_meta('description', $user);
			echo '</div>';
			
			echo '<div class="clear"></div>';

		echo '</div>';
		
	}	
}


// Display article information
function LB_article_info() {

	if( !( has_post_format('aside') || has_post_format('quote') || has_post_format('image') )  ) {

		echo '<div class="article-meta">';
		
			// Get the date
			$arc_year = get_the_time('Y');
			$arc_month = get_the_time('m');
			$arc_day = get_the_time('d');
			
			// Display edit link for users with appropiate permissions
			edit_post_link('<i class="icon-edit"></i>' . __('Edit This', 'lbprojects'));
		
			// Article data for single posts
			if( !is_page() ) {

				echo '<div class="article-date">';				
					echo '<i class="icon-time icon-large"></i>' . __('posted on', 'lbprojects')
					. ' ' . '<a href="' . get_day_link($arc_year, $arc_month, $arc_day) . '">' . get_the_date('d. F Y') . '</a>'
					. ' ' . __('at', 'lbprojects') . ' ' . '<span>' . get_the_date('G:i') . '</span>'
					. ' ' . __('in', 'lbprojects') . ' ' . get_the_category_list(', ');					
				echo '</div>';
				
				// Article Tags
				if( get_the_tags() ) {
					echo '<div class="article-tags">';
						echo '<i class="icon-tag icon-large"></i>';
						the_tags('');
					echo '</div>';
				}
				
				// Article Author
				echo '<div class="article-author">';
					echo '<i class="icon-user icon-large"></i>' . __('written by', 'lbprojects') . ' ' . '<a href="' . get_author_posts_url(get_the_author_meta( 'ID' )) . '">' . get_the_author_meta('display_name') . '</a>';
				echo '</div>';
				
				// Post Like Button
				if( of_get_option('like_button') ) {
					echo getPostLikeLink(get_the_ID());
				}
				
			}
			
			// Article data for pages
			else {
			
				echo '<div class="page-info">';				
					echo '<i class="icon-file icon-large"></i>' . __('posted on', 'lbprojects')
					. ' ' . '<a href="' . get_day_link($arc_year, $arc_month, $arc_day) . '">' . get_the_date('d. F Y') . '</a>'
					. ' ' . __('at', 'lbprojects') . ' ' . '<span>' . get_the_date('G:i') . '</span>'
					. ' ' . __('by', 'lbprojects') . ' ' . '<a href="' . get_author_posts_url(get_the_author_meta( 'ID' )) . '">' . get_the_author_meta('display_name') . '</a>';
				echo '</div>';
				
			}			

		echo '</div>';
		
	}
	
	if( has_post_format('quote') ) {		
		echo '<div class="cite">' . get_the_title() . '</div>';		
	}
}


//	Display article title
function LB_article_title( $type ) {

	if( !( has_post_format('aside') || has_post_format('quote') || has_post_format('image') )  ) {

		echo '<div class="title">';
		
			if( $type == 'cat' ) {
			
				echo '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';

				echo '<span class="article-comments">';
					echo '<a href="' . get_permalink() . '/#comment-wrapper">';
					if( comments_open() ) echo get_comments_number();
					else echo 'off';
				echo '<span class="coments-arrow"></span></a></span>';
				
			}

			if( $type == 'single' ) {
			
				echo '<h1>' . get_the_title() . '</h1>';
				
				echo '<span class="article-comments">';				
					echo '<a href="#comment-wrapper">';					
					if( comments_open() ) echo get_comments_number();
					else echo "off";
				echo '<span class="comments-arrow"></span></a></span>';
				
			}
			
		echo '</div>';
		
		echo '<div class="clear"></div>';

	}	
}


// Display pagination
function LB_pagination() {

	echo '<div class="pagination">';
	
		if( is_single() || is_page() || is_preview() ) {

			// Navigation for paged articles
			echo '<div class="paginate-single-post">';
					wp_link_pages('before=<div class="single-page-count">' . __('Pages', 'lbprojects') . ':</div><p class="single-page-numbers">&after=</p>');
			echo '</div>';
		
			if( !is_attachment() ) {
				// Previous and next post links
				echo '<div class="explore-posts-links">';
						previous_post_link( '%link', '<i class="icon-chevron-left"></i>' . ' ' . __('Previous Post', 'lbprojects'));
						next_post_link( '%link', __('Next Post', 'lbprojects') . ' ' . '<i class="icon-chevron-right"></i>');
				echo '</div>';
			}
			
			echo '<div class="clear"></div>';			
		}
		
		else {
		
			// Pagination for archive pages
			global $wp_query;
			if($wp_query->max_num_pages > 1) {
			
				echo '<div class="page-count">';			
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					echo __('Page', 'lbprojects') . ' ' . $paged . ' ' . __('of', 'lbprojects') . ' ' . $wp_query->max_num_pages;				
				echo '</div>';
				
			}
			
			$big = 999999999;
			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages, 
				'prev_text' => '<i class="icon-chevron-left"></i>',
				'next_text' => '<i class="icon-chevron-right"></i>',
				'end_size' => 2,
				'mid_size' => 1
			));		
		}
		
	echo '</div>';
	
}

?>