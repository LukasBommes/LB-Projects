// Show and hide default value in input forms on mouseclick
$(document).ready(function() {
	var default_val = '';
	$('input[class^="input-text"]').css({'color': '#aaa', 'font-style': 'italic'});
	$('input[class^="input-text"]').focus(function() {
		if($(this).val() == $(this).data('default_val') || !$(this).data('default_val')) {
		$(this).css({'color': '#3a3a3a', 'font-style': 'normal'});
			$(this).data('default_val', $(this).val());
			$(this).val('');
		}
	});
	$('input[class^="input-text"]').blur(function() {
		if ($(this).val() == '') {
			$(this).val($(this).data('default_val'));
			$(this).css({'color': '#aaa', 'font-style': 'italic'});
		}
	});
});