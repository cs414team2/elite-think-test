//****************************************************************
//*                      Global Variables :(                     *
//****************************************************************
var student_id = 0;

//****************************************************************
//*                        Functions                             *
//****************************************************************
function finalize_grade() {
	var grade = [];
	var validated

	$('[data-question-type="ESSAY"]').each(function(index){
		grade[index] = { student_answer_id : $(this).data('student-answer-id'),
							    points_recieved : $(this).find('input[type="number"]').val()
		}
	});
	
	$.ajax({
		url : 'ajax/submit_essay_grades.php',
		data : { test_id : test_id,
					student_id: student_id,
					grade : grade },
		success : function(data){
		}
	});
}

//****************************************************************
//*                          Events                              *
//****************************************************************
$(document).ready(function(){
	$('#btn_finalize_grade').hide();
	
	$('.gradeTestButton').click(function(){
		student_id = $(this).data('student-id');
		$('#grade_content').show();
		$.ajax({
			url : 'ajax/get_completed_test_teacher.php',
			data : {
				student_id : student_id,
				test_id : test_id
			},
			success : function(test) {
				$('#grade_content').html(test);
				$('#btn_finalize_grade').show();
			}
		});
	});
	
	$('#btn_finalize_grade').click(function(){
		finalize_grade();
	});
});