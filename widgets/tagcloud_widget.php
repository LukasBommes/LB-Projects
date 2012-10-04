<?php

/*
*	Tagcloud Widget
*/

class LB_tagcloud_widget extends WP_Widget {

	function LB_tagcloud_widget() {
		$wp_options = array('description' => __('This Widget displays the most common tags.', 'lbprojects'));
		parent::WP_Widget(false, $name = __('LB - Tagcloud', 'lbprojects'), $wp_options);
	}

	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);	
		
		echo $before_widget;
		
		echo '<div id="tagcloud">';
		
			if( $title ) echo $before_title . $title . $after_title;
			wp_tag_cloud( array( 'number' => $instance['count'], 'unit' => '%', 'smallest' => 95, 'largest' => 95 ) );
		
		echo '</div>';
		
		echo $after_widget;
		
	}

	function update($new_instance, $old_instance) {               

		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = strip_tags( $new_instance['count'] );

		return $instance;
	}

	function form($instance) {
		$default_settings = array( 'title' => __('Tags', 'lbprojects'), 'count' => '15' );
		$instance = wp_parse_args( (array) $instance, $default_settings ); 

		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'title' ) . '">' . __('Title:', 'lbprojects') . '</label>';
			echo '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . $instance['title'] . '" />';
		echo '</p>';
		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'count' ) . '">' . __('Count:', 'lbprojects') . '</label>';
			echo '<input class="widefat" id="' . $this->get_field_id( 'count' ) . '" name="' . $this->get_field_name( 'count' ) . '" value="' . $instance['count'] . '" />';
		echo '</p>';
	}
}

?>