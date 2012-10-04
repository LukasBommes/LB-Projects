// Smooth scroll to top
$(document).ready(function(){
	
	// Fade in scroll button
	$(function(){
		$(window).scroll(function(){
			if ($(this).scrollTop() > 100){
				$('#back-top').fadeIn();
			} else{
				$('#back-top').fadeOut();
			}
		});

		// Scroll body to top on click
		$('#back-top a').click(function(){
			$('body,html').stop().animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});
	
});