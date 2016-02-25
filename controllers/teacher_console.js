//*****************Functions********************
function loadTestsAndClasses() {
	$("#tbl_classes").load("ajax/get_classes_for_teacher.php?user_id=" + user_id);
	$("#tbl_active_tests").load("ajax/get_tests_for_teacher.php?user_id=" + user_id + "&show_active=" + true);
	$("#tbl_inactive_tests").load("ajax/get_tests_for_teacher.php?user_id=" + user_id + "&show_active=" + false);
	$.get("ajax/get_classes_ddl_for_teacher.php?user_id=" + user_id, function(list){
		$("#ddl_classes").append(list);
	});
}

//******************Events**********************
$(document).ready(function() {
	loadTestsAndClasses();
})