// Show and hide search and login forms in the site header
$(function(){
	var searchbox = $('#header-boxes .searchform');
	var loginbox = $('#header-boxes #loginform');
	
	$('#header-boxes #login-open').click(function(){
		searchbox.hide();
		if(loginbox.css('display') == "none"){
			loginbox.stop(true, true).slideDown(150);
			return false;
		}
		else{
			loginbox.hide();
			return false;
		}
	});
	
	$('#header-boxes #search-open').click(function(){
		loginbox.hide();
		if(searchbox.css('display') == "none"){
			searchbox.stop(true, true).slideDown(100);
			searchbox.children('.s').focus();
			return false;
		}
		else{
			searchbox.hide();
			return false;
		}
	});
	
	$(document).mouseup(function(e){
		if ($('#header-boxes').has(e.target).length === 0){
			searchbox.hide();
			loginbox.hide();
		}
	});
});