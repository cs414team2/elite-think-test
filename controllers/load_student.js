// Allows for clickable student records
// Redirects to information page for that student
function load_student(){
	$('.student_record, .Y').click(function(){
		var student_id = $(this).attr('id');
		window.location = 'index.php?action=admin_class_manager&id=' + student_id;
	});
	
	$('.student_record, .N').click(function(){
		var student_id = $(this).attr('id');
		window.location = 'index.php?action=admin_class_manager&id=' + student_id;
	});
}