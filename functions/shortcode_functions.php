<?php

/*
*	functions.php
*	Article shortcode functions
*/

// Enable shortcodes in sidebar widgets
add_filter('widget_text', 'do_shortcode');

// Two-columned text
function LB_one_half( $atts, $content = null ) { 
	return '<div class="one_half">' . do_shortcode($content) . '</div>'; 
} 
add_shortcode('one_half', 'LB_one_half'); 

function LB_one_half_last( $atts, $content = null ) { 
	return '<div class="one_half last">' . do_shortcode($content) . '</div>
	<div class="clear"></div>';
} 
add_shortcode('one_half_last', 'LB_one_half_last');


// Notices
function LB_notice($atts, $content = null) { 
    $return = '<div class="notice">'; 
    $return .= $content;
    $return .= '</div>'; 
    return $return; 
} 
add_shortcode('notice', 'LB_notice' );


// Font Awesome Icons
function LB_font_icons($atts, $content = null) {
	extract(shortcode_atts(array( 'type' => 'icon-beaker' ), $atts));
	return '<i class="' . $type . '"></i>';
}
add_shortcode('icon', 'LB_font_icons');


// Color boxes
function LB_colorbox($atts, $content = null) {
	extract(shortcode_atts(array( 'color' => '' ), $atts));
	
	switch($color) {
		case 'red': $return = '<p class="red-box">' . $content . '</p>'; break;
		case 'blue': $return = '<p class="blue-box">' . $content . '</p>'; break;		
		case 'yellow': $return = '<p class="yellow-box">' . $content . '</p>'; break;		
		case 'green': $return = '<p class="green-box">' . $content . '</p>'; break;		
		case 'grey': $return = '<p class="grey-box">' . $content . '</p>'; break;
		default: $return = '';	
	}
	
	return $return;
}
add_shortcode('colorbox', 'LB_colorbox' );


// Spoiler boxes
function LB_spoiler($atts, $content = null) {

	extract(shortcode_atts(array( 'title' => 'Spoiler' ), $atts));
	
	return '<div class="spoiler">
				<div class="spoiler-header inactive">' . $title . '<span></span></div>
				<div class="spoiler-content">' . $content . '</div>
			</div>';
}
add_shortcode('spoiler', 'LB_spoiler' );


// Accordion boxes
function LB_accordion($atts, $content = null) {

	extract(shortcode_atts(array( 'title' => 'accordion', 'state' => 'inactive' ), $atts));
	
	return '<div class="accordion-block">
				<div class="accordion-header ' . $state . '">' . $title . '<span></span></div>
				<div class="accordion-content">' . $content . '</div>
			</div>';
} 
add_shortcode('accordion', 'LB_accordion' );


// Output spambot protected email address
function LB_secure_email($atts, $content = null) {
	extract(shortcode_atts(array( 'address' => '', 'mailto' => 'true' ), $atts));
	$encoded_mail = antispambot( $address );
	if( $mailto == 'true' ) {
		return '<span><a href="mailto:' . $encoded_mail . '">' . $encoded_mail . '</a></span>';
	}
	else if( $mailto == 'false' ) {
		return '<span>' . $encoded_mail . '</span>';
	}
}
add_shortcode('email', 'LB_secure_email');


// Google Maps
function LB_googlemaps($atts, $content = null) {
	extract(shortcode_atts(array( 'width' => '658', 'height' => '350', 'zoom' => 15, 'address' => '' ), $atts));
	return '<script type="text/javascript">
				/* <![CDATA[ */
				$(document).ready(function(){
					$(".googlemaps").gmap3(
						{ action : \'getLatLng\',
							address: \'' . $address . '\',
							callback: function(result){
								if(result){
									$(this).gmap3({action: \'setCenter\', args:[ result[0].geometry.location ]},
									{action: \'setZoom\', args:[' . $zoom . ']});
								}
							}
						},
						{ action: \'addMarker\',
							address: \'' . $address . '\'
						}
					);
				});	
				/* ]]> */
			</script>
			<div class="googlemaps-container">
				<div class="googlemaps" style="width:' . $width . 'px; height:' . $height . 'px;"></div>
			</div>';
}
add_shortcode('googlemap', 'LB_googlemaps');


// Google Docs
function LB_googledocs($atts, $content = null) {
	extract(shortcode_atts(array( 'width' => '678', 'height' => '530', 'src' => '' ), $atts));
	return '<p><iframe class="iframe googledocs" src="https://docs.google.com/viewer?url=' . $src . '&embedded=true&embedded=true" width="' . $width . '" height="' . $height . '"></iframe></p>';
}
add_shortcode('googledoc', 'LB_googledocs');

?>