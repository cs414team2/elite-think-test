//*****************Functions********************
// open the test edit page for a specific test
function openEditPage(test_id) {
	//window.location = "./?action=teacher_edit_test&test_id=" + test_id;
	window.location = "./?action=teacher_create_test";
}

// Load all test and class lists
function loadTestsAndClasses() {
	$("#tbl_classes").load("ajax/get_classes_for_teacher.php?user_id=" + user_id);
	$("#tbl_active_tests").load("ajax/get_tests_for_teacher.php?user_id=" + user_id + "&show_active=" + true);
	$("#tbl_inactive_tests").load("ajax/get_tests_for_teacher.php?user_id=" + user_id + "&show_active=" + false, function(){
		$('.editable_test').click(function(){
			openEditPage($(this).attr('id'));
		});
	});
	$.get("ajax/get_classes_ddl_for_teacher.php?user_id=" + user_id, function(list){
		$("#ddl_classes").append(list);
	});
}

// Add a new test
function createTest() {
	if ($("#ddl_classes").val() != "null") {
		$.ajax ({
			url: "ajax/add_test.php?class_id=" + $("#ddl_classes").val(),
			success: function(test_id){
				openEditPage(test_id);
			}
		});
	}
}

//******************Events**********************
$(document).ready(function() {
	loadTestsAndClasses();
	
	$("#btn_create_test").click(function(){
		createTest();
	})
})