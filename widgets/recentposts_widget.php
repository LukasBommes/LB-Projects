<?php

/*
*	Widget for displaying recent posts
*/

class LB_recent_posts_widget extends WP_Widget {

	function LB_recent_posts_widget() {
		$wp_options = array('description' => __('This Widget displays your most recent posts.', 'lbprojects'));
		parent::WP_Widget(false, $name = __('LB - Recent Posts', 'lbprojects'), $wp_options);
	}

	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$count = $instance['count'];
		$date = $instance['date'];
		$offset = $instance['offset'];
		
		echo $before_widget;
		
		echo '<div id="recent-posts">';

		$last_posts = wp_get_recent_posts( array( 'numberposts' => $count, 'offset' => $offset, 'post_status' => 'publish' ) ); 
		
		if($title) echo $before_title . $title . $after_title;

			echo '<ul>';
				foreach($last_posts as $cur_post) {
					echo '<li>';					
						echo '<a href="' . home_url() . '/?p=' . $cur_post['ID'] . '" title="' . $cur_post['post_title'] . '">';
						if( $date == true) {
							echo '<span class="recent-post-date">(' . get_the_time('j. M', $cur_post['ID']) . ')</span>';
							echo '<div class="recentpost-content">' . $cur_post['post_title'] . '</div>';
						}
						else {
							echo '<div class="recentpost-content-nodate">' . $cur_post['post_title'] . '</div>';
						}						
						echo '</a>';
					echo '</li>';
				} 
			echo '</ul>';

		echo '</div>';
		
		echo $after_widget;
		
	}

	function update($new_instance, $old_instance) {               

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = strip_tags( $new_instance['count'] );
		$instance['date'] = strip_tags( $new_instance['date'] );
		$instance['offset'] = strip_tags( $new_instance['offset'] );

		return $instance;
	}

	function form($instance) {
		$default_settings = array( 'title' => __('Recent Posts', 'lbprojects'), 'count' => '12', 'offset' => '0', 'date' => true );
		$instance = wp_parse_args( (array) $instance, $default_settings );
		$date = esc_attr($instance['date']);		

		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'title' ) . '">' . __('Title:', 'lbprojects') . '</label>';
			echo '<input class="widefat" type="text" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . $instance['title'] . '" />';
		echo '</p>';
		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'count' ) . '">' . __('Count:', 'lbprojects') . ' ' . '</label>';
			echo '<input type="text" id="' . $this->get_field_id( 'count' ) . '" name="' . $this->get_field_name( 'count' ) . '" value="' . $instance['count'] . '" size="3" />';
		echo '</p>';
		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'offset' ) . '">' . __('Posts to skip:', 'lbprojects') . ' ' . '</label>';
			echo '<input type="text" id="' . $this->get_field_id( 'offset' ) . '" name="' . $this->get_field_name( 'offset' ) . '" value="' . $instance['offset'] . '" size="3" />';
		echo '</p>';
		echo '<p>';
			echo '<input class="checkbox" type="checkbox" id="' . $this->get_field_id( 'date' ) . '" name="' . $this->get_field_name( 'date' ) . '" value="1"'; checked( '1', $date ); echo '/>';
			echo '<label for="' . $this->get_field_id( 'date' ) . '">' . ' ' . __('Show date?', 'lbprojects') . '</label>';
		echo '</p>';
	}
}

?>