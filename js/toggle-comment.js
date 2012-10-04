// Toogle comments box and safe current state in browser cookie
$(document).ready(function(){

	$('#toggle-comment').click(function(){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
			$(this).addClass('inactive');
			$.cookies.set('toggle-state', 'closed');
			$('#commentlist').stop(true, true).slideUp();
			return false;
		}
		else{
			$(this).removeClass('inactive');
			$(this).addClass('active');
			$.cookies.set('toggle-state', 'opened');
			$('#commentlist').stop(true, true).slideDown();
			return false;
		}
		
	});
		
	if( $.cookies.get( 'toggle-state' ) == 'closed'){
		$('#toggle-comment').removeClass('active');
		$('#toggle-comment').addClass('inactive');
		$('#commentlist').hide();
	}
	else{
		$('#toggle-comment').removeClass('inactive');
		$('#toggle-comment').addClass('active');
		$('#commentlist').show();
	}

});