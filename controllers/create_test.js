$(document).ready(function(){
	$('#btn_create_test').click(function(){
		var class_id = $('.ddl_clas').val();
		window.location = 'index.php?action=admin_class_manager&c_id=' + class_id;
	});
});