// Modify properties of media upload box
jQuery(function($) {
	
	jQuery.noConflict();
	
	// Change the text of the "Insert into Post" buttons to read "Use this File"
	$( '.savesend input.button[value*="Insert into Post"], .media-item #go_button' ).attr( 'value', 'Use this File' );
	
	// Hide the "Insert Gallery" settings box on the "Gallery" tab
	$( 'div#gallery-settings' ).hide();
	
	// Preserve the "is_optionsframework" parameter on the "delete" confirmation button
	$( '.savesend a.del-link' ).click ( function () {
	
		var continueButton = $( this ).next( '.del-attachment' ).children( 'a.button[id*="del"]' );
		var continueHref = continueButton.attr( 'href' );
		continueHref = continueHref + '&is_optionsframework=yes';
		continueButton.attr( 'href', continueHref );
	
	} );
	
});