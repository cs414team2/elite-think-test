const STUDENT_NOT_ENROLLED = 0;
const STUDENT_IS_ENROLLED = 1;

//***************Functions********************
function update_enrollment() {
	var student = [];
	
	$("tr").each(function (index) {
		student[index] = { student_id : $(this).attr("id"),
						  is_enrolled : $(this).find("input").prop("checked") ? STUDENT_IS_ENROLLED : STUDENT_NOT_ENROLLED};
	});
	
	/*$.ajax({
		url: "ajax/update_enrollment.php",
		data 
	});*/
}

// ******************Events*******************
$(document).ready(function(){
	
	$("#btn_update_enrollment").click(function(){
		
		update_enrollment();
	});
});