$(document).ready(function(){
	$('.class_record, .Y').click(function(){
		var class_id = $(this).attr('id');
		window.location = 'index.php?action=admin_class_manager&id=' + class_id;
	});
	
	$('.class_record, .N').click(function(){
		var class_id = $(this).attr('id');
		window.location = 'index.php?action=admin_class_manager&id=' + class_id;
	});
});