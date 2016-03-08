const STUDENT_NOT_ENROLLED = 0;
const STUDENT_IS_ENROLLED = 1;

//***************Functions********************
function update_enrollment() {
	var student = [];
	
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
		}
	});
}

function update_row_click_events() {
	$(".clickable_row").each(function(){
		$(this).click(function(){
			$(this).find("input").prop("checked", $(this).find("input").prop("checked") ? false : true);
		});
	});
}

// ******************Events*******************
$(document).ready(function(){
	
	update_row_click_events();
	
	$("#btn_update_enrollment").click(function(){
		update_enrollment();
	});
});