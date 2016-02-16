$(document).ready(function(){
	$('.student_record').click(function(){
		var student_id = $(this).attr('id');
		window.location = 'index.php?action=admin_class_manager&id=' + student_id;
	});
});