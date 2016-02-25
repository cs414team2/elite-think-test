$(document).ready(function(){
	$('#btn_create_test').click(function(){
		var class_id = $('#ddl_class').val();
		window.location = 'index.php?action=teacher_create_test&c_id=' + class_id;
	});
});