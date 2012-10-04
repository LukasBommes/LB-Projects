// Show "more" tab in header navigation if menu is wider than specific value
$(document).ready(function(){
	var width = '720';
	if($('.nav-wrapper').width() > width){	
		$('.sf-menu').append('<li class="menu-item more-item"><a href="#">...</a><ul><li class="more-item destination"></li></ul></li>');
		$('.menu-item').each( function(){		
			if($('.nav-wrapper').width() > width){
				$('.more-item').prev().appendTo(".destination");
			}			
		});
	}
});