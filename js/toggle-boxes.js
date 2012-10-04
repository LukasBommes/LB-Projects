//  Spoiler
$(function(){
	$('.spoiler-header').click(function(){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
			$(this).addClass('inactive');
		}
		else{
			$(this).removeClass('inactive');
			$(this).addClass('active');
		}
		$(this).next().stop(true, true).slideToggle();
		return false;
	});
});

// Accordion
$(function(){
	$('.accordion-header.inactive').next().hide();
	$('.accordion-header').click(function(){
		if(!$(this).hasClass('active')){
			$('.accordion-content').slideUp();
			$('.accordion-header').removeClass('active').addClass('inactive');	
		}
		$(this).removeClass('active').addClass('inactive');
		$(this).removeClass('inactive').addClass('active');
		$(this).next().slideDown();
		return false;
	});
});