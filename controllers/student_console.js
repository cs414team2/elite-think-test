//*****************Functions********************

// Load all test and class lists
function load_tests_and_classes() {
	$("#tbl_classes").load("ajax/get_classes_for_student.php?user_id=" + user_id);
	$("#tbl_tests").load("ajax/get_tests_for_student.php?user_id=" + user_id);
}

//******************Events**********************
$(document).ready(function() {
	load_tests_and_classes();
})