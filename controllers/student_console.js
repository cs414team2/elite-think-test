//*****************Functions********************
function open_test_taking_page(test_id) {
	window.location = "./?action=student_test_page&test_id=" + test_id;
}

// Load all test and class lists
function load_tests_and_classes() {
	$("#tbl_classes").load("ajax/get_classes_for_student.php?user_id=" + user_id);
	$("#tbl_tests").load("ajax/get_tests_for_student.php?user_id=" + user_id, function () {
		$("#tbl_tests").children("tr").click(function(){
			open_test_taking_page($(this).attr('id'));
		});
	});
}

//******************Events**********************
$(document).ready(function() {
	load_tests_and_classes();
})