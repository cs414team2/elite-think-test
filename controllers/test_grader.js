const MAX_TEST_SIZE = 3;
const MAX_POINT_DIGITS = 4;

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

// Display the question numbers.
function number_questions() {
	$( ".question_number" ).each(function( index ) {
		var formatted_number = "";
		for (i = 0; i < (MAX_TEST_SIZE - (index + 1).toString().length); i++) {
			formatted_number = formatted_number + "&nbsp;";
		}
		formatted_number = formatted_number + (index + 1 + ")");
		$(this).html(formatted_number);
	});
}

//****************************************************************
//*                          Events                              *
//****************************************************************
$(document).ready(function(){
	$('#btn_finalize_grade').hide();
	
	$('.gradeTestButton').click(function(){
		var student_name = $(this).data('student-name');
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
				$('#grade_curr_stud_name').html(student_name + "'s");
				number_questions();
				
 				// Prevent negatives from being input in number boxes.
				$('input[type="number"]').keydown(function(event){
					if(event.keyCode == 109 || event.keyCode == 189)       // Negative keycode
						event.preventDefault();
					
				});
				
				$('input[type="number"]').on('input', function () {
					if ($(this).val().length > MAX_POINT_DIGITS) {
						$(this).val($(this).val().slice(0, MAX_POINT_DIGITS));
					}
					/*if (isNaN(parseInt($(this).val()))){  // Does not allow user to back space to remove the last digit. (Which prevents an empty box, but that might be annoying to the user.)
						$(this).val($(this).attr('name'));
					}*/
				}); 
			}
		});
	});
	
	$('#btn_finalize_grade').click(function(){
		finalize_grade();
	});
});