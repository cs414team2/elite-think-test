//****************************************************************
//*                        Functions                             *
//****************************************************************
function finalize_grade() {
	var grade = [];

	$('[data-question-type="ESSAY"]').each(function(index){
		grade[index] = { student_answer_id : $(this).data('student-answer-id'),
							    points_recieved : 1 }//                                               Change this!!!!!!!!!!!!!!!
		
	});
}

//****************************************************************
//*                          Events                              *
//****************************************************************
$(document).ready(function(){
	
	
	$('.gradeTestButton').click(function(){
		$("#grade_content").show();
		$.ajax({
			url : "ajax/get_completed_test_teacher.php",
			data : {
				student_id : $(this).data('student-id'),
				test_id : test_id
			},
			success : function(test) {
				$("#grade_content").html(test);
				finalize_grade();
			}
		});
	});
	
	$('.btn_finalize_grade').click(function(){
		finalize_grade();
	});
});