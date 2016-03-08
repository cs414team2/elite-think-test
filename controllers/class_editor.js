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
		success: function (data) {
			$("#main").html(data);
		}
	});
}

// ******************Events*******************
$(document).ready(function(){
	
	$("#btn_update_enrollment").click(function(){
		update_enrollment();
	});
});