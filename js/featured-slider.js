$(document).ready(function() {

	// Show or hide navigation on mouse hover
	$('#featured-box').mouseenter(function () {
		$('#featured-controls').stop(false, true).fadeIn();
	});
	$('#featured-box').mouseleave(function () {
		$('#featured-controls').stop(false, true).fadeOut();
	});
	
	// Autoslide duration
	var auto_slide_seconds = 5000;
	$('#featured li:first').before($('#featured li:last'));
	
	var timer = setInterval('slide("right")', auto_slide_seconds);
	$('#hidden_auto_slide_seconds').val(auto_slide_seconds);
 
	// Stop autoslide on mouse hover
	$('#featured').hover(function(){
		clearInterval(timer)
	},function(){
		timer = setInterval('slide("right")', auto_slide_seconds);
	});

	// Keyboard slide control
	$(document).bind('keydown', function(e) {
		if(e.keyCode==37){
			slide('left');
		}else if(e.keyCode==39){
			slide('right');  
		}
	});

	// Mouse slide control
	$("#featured-prev").click(function(){
		slide('left');
		return false;
	});
	$("#featured-next").click(function(){
		slide('right');
		return false;
	});
  
});
  
// Slider functions
function slide(where){
  
	var item_width = $('#featured li').outerWidth();
	
	if(where == 'left'){
		var left_indent = parseInt($('#featured').css('left')) + item_width;
	}else{
		var left_indent = parseInt($('#featured').css('left')) - item_width;
	}
	
	// Animate sliding
	$('#featured:not(:animated)').animate({'left' : left_indent},500,function(){
		if(where == 'left'){
			$('#featured li:first').before($('#featured li:last'));
		}else{
			$('#featured li:last').after($('#featured li:first'));
		}
		$('#featured').css({'left' : '-' + ( item_width + 1 ) + 'px'});
	});
  
}