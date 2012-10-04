<?php

/*
*	functions.php
*	Internal Post Like System
*/

// Enqueue Ajax script
function enqueue_rating_scripts() {
	wp_enqueue_script('like_post', get_template_directory_uri().'/js/post-like-system.js');  
	wp_localize_script('like_post', 'ajax_var', array( 'url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('ajax-nonce') ));
}
add_action('wp_head', 'enqueue_rating_scripts');

// Hook Ajax
add_action('wp_ajax_nopriv_post-like', 'post_like');
add_action('wp_ajax_post-like', 'post_like');

$timebeforerevote = 1440; // 24 hours

// Like function
function post_like() {
	$nonce = $_POST['nonce'];
	
	if( !wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
		die();
	}
	
	if( isset($_POST['post_like']) ) {
	
		// Get the user's IP adress
		$ip = $_SERVER['REMOTE_ADDR'];
		$post_id = $_POST['post_id'];
		$meta_IP = get_post_meta($post_id, "voted_IP");
		$voted_IP = $meta_IP[0];
		
		if( !is_array($voted_IP) ) {
			$voted_IP = array();
		}
		
		// Get votes count for the current post
		$meta_count = get_post_meta($post_id, "votes_count", true);
		
		if( !hasAlreadyVoted($post_id) ) {
			$voted_IP[$ip] = time();  
			// Save IP and increase votes count
			update_post_meta($post_id, "voted_IP", $voted_IP);
			update_post_meta($post_id, "votes_count", ++$meta_count);
			// Display count  
			echo $meta_count;
		}		
		else {
			echo "already";
		}
	}
	exit;  
}

// Check if user has already voted
function hasAlreadyVoted($post_id) { 
	global $timebeforerevote;
	$meta_IP = get_post_meta($post_id, "voted_IP");
	$voted_IP = $meta_IP[0];
	
	if( !is_array($voted_IP) ) {
		$voted_IP = array();
	}
	
	// Get IP address
	$ip = $_SERVER['REMOTE_ADDR'];
	
	if( in_array($ip, array_keys($voted_IP)) ) {  
		$time = $voted_IP[$ip];
		$now = time();
		if( round(($now - $time) / 60) > $timebeforerevote )  
			return false;
		return true;
	}
	
	return false;
}

// Create markup for the like button
function getPostLikeLink($post_id) {
	$vote_count = get_post_meta($post_id, "votes_count", true);
	
	if( $vote_count > 0) {
		$vote_count_display = $vote_count;
	}
	else {
		$vote_count_display = '0';
	}
	
	$output = '<div class="post-like">';
	if( hasAlreadyVoted($post_id )) {
		$output .= '<i title="' . __('I like this article', 'lbprojects') . '" class="icon-heart like alreadyvoted"></i>';  
	}	
	else {
		$output .= '<a href="#" data-post_id="' . $post_id . '"><i title="' . __('I like this article', 'lbprojects') . '" class="icon-heart qtip like"></i></a>';
	}	
	$output .= '<span class="count">' . $vote_count_display . '</span></div>';
	
	return $output;
}

?>