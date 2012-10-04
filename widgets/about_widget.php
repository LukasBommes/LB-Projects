<?php

/*
*	Widget for author information or meta data
*/

class LB_about_widget extends WP_Widget {

	function LB_about_widget() {
		$wp_options = array('description' => __('This Widget displays your avatar and biographical information.', 'lbprojects'));
		parent::WP_Widget(false, $name = __('LB - About the Author', 'lbprojects'), $wp_options);
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$text = $instance['text'];
		$link = $instance['link'];
		$user = $instance['user'];
		$avatar = $instance['avatar'];
		$custom = $instance['custom'];
		$size = $instance['size'];
		
		echo $before_widget;
		
		echo '<div id="about-widget">';
		
			if($title) echo $before_title . $title . $after_title;
			
			if($avatar == true) {
				echo '<div class="about-avatar"><a href="' . $link . '">' . get_avatar( get_the_author_meta('email', $user), $size ) . '</a></div>';
			}
			
			echo '<div id="about-widget-entry">';
			
				if($custom == true) {
					echo $text;
				} 
				else {
					echo get_the_author_meta('description', $user);
				}
				
				if($link) {
					echo ' ' . '<a class="about-widget-link" href="' . $link . '">' . __('learn more about me', 'lbprojects') . '&rarr;' . '</a>';
				}
				
				echo '<div class="clear"></div>';
				
			echo '</div>';

		echo '</div>';
		
		echo $after_widget;
		
	}

	function update($new_instance, $old_instance) {               

		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['user'] = strip_tags( $new_instance['user'] );
		$instance['link'] = strip_tags( $new_instance['link'] );
		$instance['avatar'] = strip_tags($new_instance['avatar']);
		$instance['custom'] = strip_tags($new_instance['custom']);
		$instance['size'] = strip_tags($new_instance['size']);
		if( current_user_can('unfiltered_html') ) {
			$instance['text'] =  $new_instance['text'];
		} else {
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) );
		}
			
		return $instance;
	}

	function form($instance) {
		$default_settings = array( 'title' => __('About Me', 'lbprojects'), 'user' => '', 'text' => '', 'link' => '', 'avatar' => true, 'custom' => false, 'size' => 48 );
		$instance = wp_parse_args( (array) $instance, $default_settings );
		$avatar = esc_attr($instance['avatar']);
		$custom = esc_attr($instance['custom']);
		$size = esc_attr($instance['size']);
		$text = esc_textarea($instance['text']);
		
		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'title' ) . '">' . __('Title:', 'lbprojects') . '</label>';
			echo '<input class="widefat" type="text" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . $instance['title'] . '" />';
		echo '</p>';
		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'user' ) . '">' . __('Select Author:', 'lbprojects') . '</label>'; 
			wp_dropdown_users( array( 'class' => 'widefat', 'who' => 'authors', 'name' => $this->get_field_name( 'user' ), 'id' => $this->get_field_id( 'user' ), 'selected' => $instance['user'] ) );
		echo '</p>';
		echo '<p>';
			echo '<input class="checkbox" type="checkbox" id="' . $this->get_field_id( 'avatar' ) . '" name="' . $this->get_field_name( 'avatar' ) . '" value="1"'; checked( 1, $avatar ); echo '/>';
			echo '<label for="' . $this->get_field_id( 'avatar' ) . '">' . ' ' . __('Display avatar?', 'lbprojects') . '</label>';
		echo '</p>';
		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'size' ) . '">' . __('Size of the avatar:', 'lbprojects') . ' ' . '</label>';
			echo '<input type="text" id="' . $this->get_field_id( 'size' ) . '" name="' . $this->get_field_name( 'size' ) . '" value="' . $instance['size'] . '" size="3" />';
		echo '</p>';
		echo '<p>';
			echo '<input class="checkbox" type="checkbox" id="' . $this->get_field_id( 'custom' ) . '" name="' . $this->get_field_name( 'custom' ) . '" value="1"'; checked( 1, $custom ); echo '/>';
			echo '<label for="' . $this->get_field_id( 'custom' ) . '">' . ' ' . __('Display custom text instead of biographical data set in the profile page?', 'lbprojects') . '</label>';
		echo '</p>';
		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'text' ) . '">' . __('Description:', 'lbprojects') . '</label>';
			echo '<textarea class="widefat" rows="8" cols="20" id="' . $this->get_field_id( 'text' ) . '" name="' . $this->get_field_name( 'text' ) . '">' . $text . '</textarea>';
		echo '</p>';
		echo '<p>';
			echo '<label for="' . $this->get_field_id( 'link' ) . '">' . __('URL to your about page:', 'lbprojects') . ' ' . '</label>';
			echo '<input class="widefat" type="text" id="' . $this->get_field_id( 'link' ) . '" name="' . $this->get_field_name( 'link' ) . '" value="' . $instance['link'] . '" />';
		echo '</p>';
	}
}

?>