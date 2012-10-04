<?php

/*
*	Widget for display of random images from the media library
*/

class LB_random_images_widget extends WP_Widget {

	function LB_random_images_widget() {
		$wp_options = array('description' => __('This Widget displays random images from your media library.', 'lbprojects'));
		parent::WP_Widget(false, $name = __('LB - Images', 'lbprojects'), $wp_options);
	}

	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$count = $instance['count'];
		
		echo $before_widget;
		
		echo '<div class="random-images">';
		
			if($title) echo $before_title . $title . $after_title;

			$attachments = get_posts( array( 'post_type' => 'attachment', 'orderby' => 'rand',  'numberposts' => $instance['count'], 'status' => 'publish', 'post_mime_type' => 'image' ) );

			if ($attachments) {
			
				foreach ($attachments as $attachment) {
				
					$parent_id = $attachment->post_parent;
				
					echo '<div class="random-thumbnail"><a href="' . get_permalink( $parent_id ) . '" title="' . get_the_title( $parent_id ) . '">';
					echo '<span class="image-layer"><i class="icon-circle-arrow-right"></i></span>';
					echo wp_get_attachment_image( $attachment->ID, array( 105, 105 ) );
					echo '</a></div>';
					
				}
				
			}

			echo '<div class="clear"></div>';

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
		$default_settings = array( 'title' => __('Images', 'lbprojects'), 'count' => '4' );
		$instance = wp_parse_args( (array) $instance, $default_settings );		

		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'title' ) . '">' . __('Title:', 'lbprojects') . '</label>';
			echo '<input class="widefat" type="text" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . $instance['title'] . '" />';
		echo '</p>';
		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'count' ) . '">' . __('Count:', 'lbprojects') . ' ' . '</label>';
			echo '<input type="text" id="' . $this->get_field_id( 'count' ) . '" name="' . $this->get_field_name( 'count' ) . '" value="' . $instance['count'] . '" size="3" />';
		echo '</p>';
	}
}

?>