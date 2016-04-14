const STUDENT_NOT_ENROLLED = 0;
const STUDENT_IS_ENROLLED = 1;

//***************Functions********************
// Enroll checked students in the class and unenroll the unchecked students.
function update_enrollment() {
	var student = [];
	
	$('#area_students').hide();
	$('#area_loader').show();
	
	$("tbody").children("tr").each(function (index) {
		student[index] = { id : $(this).attr("id"),
				     enrolled : $(this).find("input").prop("checked") ? STUDENT_IS_ENROLLED : STUDENT_NOT_ENROLLED};
	});
	
	$.ajax({
		url: "ajax/update_enrollment.php",
		type: "POST",
		data : {
			class_id : class_id,
			student : student
		},
		success : function (student_list) {
			$("#tbl_students").html(student_list);
			window.scroll(0,0);
			update_row_click_events();
			
			$('#area_students').animate({ scrollTop: 0 }, 1);
			$('#area_loader').hide();
			$('#area_students').show();
			
		}
	});
}

// Set the rows so that clicking the row checks the corresponding box.
function update_row_click_events() {
	$(".clickable_row").each(function(){
		$(this).click(function(){
			$(this).find("input").prop("checked", $(this).find("input").prop("checked") ? false : true);
		});
	});
}

function update_teacher() {
	var teacher_id = $('#ddl_teachers').val();

	$.ajax({
		url: "ajax/assign_teacher.php",
		data : {
			class_id : class_id,
			teacher_id : teacher_id
		}
	});
}

// ******************Events*******************
$(document).ready(function(){
	
	update_row_click_events();
	
	$("#btn_update_enrollment").click(function(){
		update_enrollment();
		update_teacher();
	});
});