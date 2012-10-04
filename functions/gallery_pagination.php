<?php

/*
*	functions.php
*	Gallery pagination functions
*/

// Custom paginated gallery shortcode
function LB_paginated_gallery( $attr ) {
	global $post;	
	static $instance = 0;
	$instance++;	
	$imagesPerPage = of_get_option('paginated_gallery_count');
	
	// Define some default options
	$options = array(
		'id' => '',
		'order' => 'ASC', 
		'orderby' => 'menu_order ID',
		'itemtag' => 'dl',
		'icontag' => 'dt', 
		'captiontag' => 'dd', 
		'columns' => 3, 
		'size' => 'thumbnail', 
		'perpage' => $imagesPerPage, 
		'link' => 'attachment', 
		'show_edit_links' => 'Y', 
		'use_shortcode' => 'gallery', 
		'exclude' => ''
	);
	
	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}
	
	// Overwrite the defaults with any options passed in
	if( is_array($attr) ) $options = array_merge($options, $attr);
	
	// Start by getting the attachments
	$attachments = get_children(array(
		'post_parent' => $post->ID, 
		'post_status' => 'inherit', 
		'post_type' => 'attachment', 
		'post_mime_type' => 'image', 
		'order' => $options['order'], 
		'orderby' => $options['orderby'], 
		'exclude' => $options['exclude']
	));
	
	// If we don't have any attachments - output nothing
	if( empty($attachments) ) return '';
	
	// Output feed if requested
	if( is_feed() ) {
		$output = "\n";

		foreach( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link($id, $options['size'], true) . "\n";
		return $output;
	}
	
	// Work out how many pages we need and what page we are currently on
	$imageCount = count($attachments);
	$pageCount = ceil($imageCount / $imagesPerPage);
	
	$currentPage = intval($_GET['galleryPage']);
	if( empty($currentPage) || $currentPage <= 0 ) $currentPage = 1;
	
	$maxImage = $currentPage * $imagesPerPage;
	$minImage = ($currentPage-1) * $imagesPerPage;
	
	if( $pageCount > 1 ) {
		$page_link = get_permalink();
		$page_link_perma = true;
		if ( strpos($page_link, '?') !== false )
			$page_link_perma = false;

		$gplist = '<div class="gallery-pages-list"><span class="gallery-page">' . __('Page', 'lbprojects') . '</span>';
		for( $j = 1; $j <= $pageCount; $j++ ) {
			if( $j == $currentPage ) {
				$gplist .= '<span class="gallery-page-numbers current">' . $j . '</span>';
			}
			else {
				$gplist .= '<a class="gallery-page-numbers" href="' . $page_link . ($page_link_perma ? '?' : '&amp;') . 'galleryPage=' . $j . '">' . $j . '</a>';
			}
		}
		$gplist .= '</div>';
	}
	else {
		$gplist= '';
	}
	
	$itemtag = tag_escape($options['itemtag']);
	$captiontag = tag_escape($options['captiontag']);
	$columns = intval($options['columns']);
	$itemwidth = $options['columns'] > 0 ? floor(100/$options['columns']) : 100;
	$float = is_rtl() ? 'right' : 'left';
	$icontag = $options['icontag'];
	$id = $options['id'];
	$size = $options['size'];
	
	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
	if( apply_filters( 'use_default_gallery_style', true ) )
		$gallery_style = "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->";
	$size_class = sanitize_html_class( $size );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
	
	$i = 0;
	$k = 0;
	
	foreach( $attachments as $id => $attachment ) {
		if( $k >= $minImage && $k < $maxImage ) {
			$link = isset($options['link']) && 'file' == $options['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
			
			$output .= "<{$itemtag} class='gallery-item'>";
			$output .= "
				<{$icontag} class='gallery-icon'>
					$link
				</{$icontag}>";
			if( $captiontag && trim($attachment->post_excerpt) ) {
				$output .= "
					<{$captiontag} class='wp-caption-text gallery-caption'>
					" . wptexturize($attachment->post_excerpt) . "
					</{$captiontag}>";
			}
			$output .= "</{$itemtag}>";
			if( $columns > 0 && ++$i % $columns == 0 )
				$output .= '<br style="clear: both" />';
		}
		$k++;
	}
	$output .= "\n<div style='clear: both;'></div>$gplist\n</div>\n";

	return $output;
}

?>