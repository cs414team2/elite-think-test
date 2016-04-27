//****************************************************************
//*               Constants and Global Variables :(              *
//****************************************************************
const MAX_TEST_SIZE = 3;

//****************************************************************
//*                        Functions                             *
//****************************************************************
/* function load_questions() {
	$.ajax({
		url: "ajax/get_questions.php",
		data: { test_id : test_id },
		success: function (test) {
			$('#test_content').show();
			$('#test_content').html(test);
			$('#area_test_loader').hide();
			number_questions();
			
			$('img[src$="images/arrowup.png"]').hide();
			$('img[src$="images/arrowDown.png"]').hide();
			$('img[src$="images/edit.png"]').hide();
			$('img[src$="images/delete.png"]').hide();
		}
	});
} */

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
	//load_questions();
	
	$('.view_test_button').click(function(){
		var student_name = $(this).data('student-name');
		var student_id = $(this).data('student-id');
		
		$('#test_content').hide();
		$('#area_test_loader').show();
		$.ajax({
			url : 'ajax/get_test_teacher.php',
			data : {
				student_id : student_id,
				test_id : test_id
			},
			success : function(test) {
				var temp_div = document.createElement('div');
				temp_div.innerHTML = test;
				
				$('#test_content').html($(temp_div).find('#test').html());
				$('#area_test_loader').hide();
				$('#test_content').show();
				
				$('#stud_grade').html($(temp_div).find('#grade').html() + "%");
				$('#stud_letter_grade').html($(temp_div).find('#letter_grade').html());
				
				$('#test_curr_stud_name').html(student_name + "&apos;s");
				number_questions();

			}
		});
	});
});