<?php

/*
*	Widget for Twitter-Feeds
*/

class LB_twitter_widget extends WP_Widget {

	function LB_twitter_widget() {
		$wp_options = array('description' => __('This Widget displays your latest tweets.', 'lbprojects'));
		parent::WP_Widget(false, $name = __('LB - Twitter', 'lbprojects'), $wp_options);
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);	
		
		echo $before_widget;
		
		echo '<div id="twitter-feed">';
		
			if($title) echo $before_title . $title . $after_title;
			echo '<div class="content_tweets"></div>
				<script type="text/javascript">
					jQuery(".content_tweets").miniTwitter({username: "' . $instance['username'] . '", limit: ' . $instance['count'] . '});
				</script>';
		
		echo '</div>';

		echo $after_widget;
		
	}

	function update($new_instance, $old_instance) {               

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['count'] = strip_tags( $new_instance['count'] );

		return $instance;
	}

	function form($instance) {
		$default_settings = array( 'title' => __('Twitter', 'lbprojects'), 'username' => '', 'count' => '3' );
		$instance = wp_parse_args( (array) $instance, $default_settings ); 

		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'title' ) . '">' . __('Title:', 'lbprojects') . '</label>';
			echo '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . $instance['title'] . '" />';
		echo '</p>';
		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'username' ) . '">' . __('Username:', 'lbprojects') . '</label>';
			echo '<input class="widefat" id="' . $this->get_field_id( 'username' ) . '" name="' . $this->get_field_name( 'username' ) . '" value="' . $instance['username'] . '" />';
		echo '</p>';
		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'count' ) . '">' . __('Count:', 'lbprojects') . '</label>';
			echo '<input class="widefat" id="' . $this->get_field_id( 'count' ) . '" name="' . $this->get_field_name( 'count' ) . '" value="' . $instance['count'] . '" />';
		echo '</p>';
	}
}

?>