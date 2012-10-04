jQuery(function ($) {

	optionsframeworkMLU = {
	
		// Remove file when the "remove" button is clicked.  
		removeFile: function () {		 
			$('.mlu_remove').live('click', function(event) { 
				$(this).hide();
				$(this).parents().parents().children('.upload').attr('value', '');
				$(this).parents('.screenshot').slideUp();
				$(this).parents('.screenshot').siblings('.of-background-properties').hide(); //remove background properties
				return false;
			});

			$('a.delete-inline', "#option-1").hide();			  
		},		

		// Replace the default file upload field with a customised version.
		recreateFileField: function () {		
			$('input.file').each(function(){
				var uploadbutton = '<input class="upload_file_button" type="button" value="Upload" />';
				$(this).wrap('<div class="file_wrap" />');
				$(this).addClass('file').css('opacity', 0); //set to invisible
				$(this).parent().append($('<div class="fake_file" />').append($('<input type="text" class="upload" />').attr('id',$(this).attr('id')+'_file')).val( $(this).val() ).append(uploadbutton));
	 
				$(this).bind('change', function() {
					$('#'+$(this).attr('id')+'_file').val($(this).val());
				});
				$(this).bind('mouseout', function() {
					$('#'+$(this).attr('id')+'_file').val($(this).val());
				});
			});		  
		},

		// Use a custom function when working with the Media Uploads popup.
		mediaUpload: function () {
		
			jQuery.noConflict();
			
			$( 'input.upload_button' ).removeAttr('style');
			
			var formfield,
				formID,
				btnContent = true,
				tbframe_interval;
				
			$('input.upload_button').live("click", function () {
				formfield = $(this).prev('input').attr('id');
				formID = $(this).attr('rel');
				tbframe_interval = setInterval(function() {jQuery('#TB_iframeContent').contents().find('.savesend .button').val('Use This Image');}, 2000);
			
				var woo_title = '';
				
				if ( $(this).parents('.section').find('.heading') ) { 
					woo_title = $(this).parents('.section').find('.heading').text(); 
				}
				
				tb_show( woo_title, 'media-upload.php?post_id='+formID+'&TB_iframe=1' );
				return false;
			});
				
			window.original_send_to_editor = window.send_to_editor;
			window.send_to_editor = function(html) {
				
				if (formfield) {					
					
					clearInterval(tbframe_interval);
				  
					if ( $(html).html(html).find('img').length > 0 ) {				  
						itemurl = $(html).html(html).find('img').attr('src');					
					}					
					else {	
						var htmlBits = html.split("'");
						itemurl = htmlBits[1];					
						var itemtitle = htmlBits[2];					
						itemtitle = itemtitle.replace( '>', '' );
						itemtitle = itemtitle.replace( '</a>', '' );					  
					}
						   
					var image = /(^.*\.jpg|jpeg|png|gif|ico*)/gi;
					var document = /(^.*\.pdf|doc|docx|ppt|pptx|odt*)/gi;
					var audio = /(^.*\.mp3|m4a|ogg|wav*)/gi;
					var video = /(^.*\.mp4|m4v|mov|wmv|avi|mpg|ogv|3gp|3g2*)/gi;
				  
					if (itemurl.match(image)) {
						btnContent = '<img src="'+itemurl+'" alt="" /><a href="#" class="mlu_remove button">Remove Image</a>';
					}
					else {					
						html = '<a href="'+itemurl+'" target="_blank" rel="external">View File</a>';
						btnContent = '<div class="no_image"><span class="file_link">'+html+'</span><a href="#" class="mlu_remove button">Remove</a></div>';
					}
				  
					$('#' + formfield).val(itemurl);
					$('#' + formfield).siblings('.screenshot').slideDown().html(btnContent);
					$('#' + formfield).siblings('.of-background-properties').show();
					tb_remove();
				  
				}
				else {
				  window.original_send_to_editor(html);
				}
				
				formfield = '';
			}		  
		}   
	};

	// Execute the above methods in the optionsframeworkMLU object  
	$(document).ready(function () {

		optionsframeworkMLU.removeFile();
		optionsframeworkMLU.recreateFileField();
		optionsframeworkMLU.mediaUpload();
	
	});
  
});