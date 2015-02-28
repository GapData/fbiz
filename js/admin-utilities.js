jQuery(document).ready(function($) {

	$( "input[id$='_uploadBtn']" ).click(function() {
		
		var fullId = $(this).attr('id');
		var index = fullId.indexOf('_uploadBtn');
		var id = fullId.substring(0, index);
		window.fbiz_imgUploadSouceId = '#' + id;
		
		tb_show( translation_array.upload_image, 'media-upload.php?referer=options.php&type=image&TB_iframe=true&post_id=0', false);  
		return false;
   });
   
   window.send_to_editor = function(html) { 
   
		var image_url = $( 'img',html).attr( 'src' );
		$(window.fbiz_imgUploadSouceId).val(image_url);  
		$(window.fbiz_imgUploadSouceId.concat( '_preview' )).attr("src", image_url);
		tb_remove();
	}
   
	$('.color-settings-table input.wp-color-picker').wpColorPicker();
	
});

