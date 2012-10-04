// Scroll fixed header vertically
$(window).scroll(function(){
	$('#header').css('left', (-1) * $(this).scrollLeft());
});