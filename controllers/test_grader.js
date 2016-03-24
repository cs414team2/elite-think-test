//****************************************************************
//*                        Functions                             *
//****************************************************************


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
			success : function(test){
				$("#grade_content").html(test);
			}
		});
	})
});