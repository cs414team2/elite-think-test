//*****************Functions********************
// open the test edit page for a specific test
function open_edit_page(test_id) {
	window.location = "./?action=teacher_edit_test&test_id=" + test_id;
}

// Load all test and class lists
function load_tests_and_classes() {
	$("#tbl_classes").load("ajax/get_classes_for_teacher.php?user_id=" + user_id);
	$("#tbl_active_tests").load("ajax/get_tests_for_teacher.php?user_id=" + user_id + "&show_active=" + true, function(){
		$('.gradeable_test').click(function(){
			window.location = "./?action=teacher_grade_test&test_id=" + $(this).attr('id');
		});
	});
	$("#tbl_inactive_tests").load("ajax/get_tests_for_teacher.php?user_id=" + user_id + "&show_active=" + false, function(){
		$('.editable_test').click(function(){
			open_edit_page($(this).attr('id'));
		});
	});
	$.get("ajax/get_classes_ddl_for_teacher.php?user_id=" + user_id, function(list){
		$("#ddl_classes").append(list);
	});
}

// Add a new test
function create_test() {
	if ($("#ddl_classes").val() != "null") {
		$.ajax ({
			url: "ajax/add_test.php?class_id=" + $("#ddl_classes").val(),
			success: function(test_id){
				open_edit_page(test_id);
			}
		});
	}
}

//******************Events**********************
$(document).ready(function() {
	load_tests_and_classes();
	
	$("#btn_create_test").click(function(){
		create_test();
	})
})